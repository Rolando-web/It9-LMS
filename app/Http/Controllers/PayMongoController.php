<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\BookTransaction;
use App\Models\ActivityLog;

class PayMongoController extends Controller
{
    /**
     * Create a PayMongo source for GCash/PayMaya payment
     */
    public function createPayment(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'transaction_id' => 'required|integer|exists:book_transactions,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:gcash,paymaya',
        ]);

        $txId = $request->transaction_id;
        $amount = (float) $request->amount;
        $method = $request->payment_method;

        // Verify transaction belongs to user and has outstanding fee
        $tx = BookTransaction::where('id', $txId)
            ->where('user_id', $user->id)
            ->first();

        if (!$tx) {
            return response()->json(['message' => 'Transaction not found or unauthorized'], 404);
        }

        $currentFee = max(0, (float) ($tx->fee ?? 0));
        if ($amount > $currentFee) {
            return response()->json(['message' => 'Payment amount exceeds outstanding fee'], 422);
        }

        // Convert amount to cents (PayMongo uses smallest currency unit)
        $amountCents = (int) ($amount * 100);

        // Create PayMongo Source (for GCash/PayMaya)
        $response = Http::withBasicAuth(env('PAYMONGO_SECRET_KEY'), '')
            ->post('https://api.paymongo.com/v1/sources', [
                'data' => [
                    'attributes' => [
                        'amount' => $amountCents,
                        'currency' => 'PHP',
                        'type' => $method,
                        'redirect' => [
                            'success' => url('/payment/callback?transaction_id=' . $txId . '&amount=' . $amount),
                            'failed' => url('/payment/failed?transaction_id=' . $txId),
                        ],
                        'billing' => [
                            'name' => $user->firstName . ' ' . $user->lastName,
                            'email' => $user->email,
                        ],
                    ]
                ]
            ]);

        if (!$response->successful()) {
            Log::error('PayMongo Source Creation Failed', ['response' => $response->json()]);
            return response()->json([
                'message' => 'Failed to create payment source',
                'error' => $response->json()
            ], 500);
        }

        $source = $response->json()['data'];
        $checkoutUrl = $source['attributes']['redirect']['checkout_url'] ?? null;
        $sourceId = $source['id'];

        // Store source ID in session for verification
        session(['paymongo_source_' . $txId => $sourceId]);

        return response()->json([
            'message' => 'Payment source created',
            'source_id' => $sourceId,
            'checkout_url' => $checkoutUrl,
        ]);
    }

    /**
     * Handle payment success callback from PayMongo
     */
    public function paymentCallback(Request $request)
    {
        $txId = $request->query('transaction_id');
        $amountPaid = (float) $request->query('amount');

        if (!$txId || !$amountPaid) {
            return redirect('/user-transaction')->with('error', 'Invalid payment callback');
        }

        // Get stored source ID from session
        $sourceId = session('paymongo_source_' . $txId);

        if (!$sourceId) {
            return redirect('/user-transaction')->with('error', 'Payment session not found');
        }

        // Verify payment source status
        $response = Http::withBasicAuth(env('PAYMONGO_SECRET_KEY'), '')
            ->get("https://api.paymongo.com/v1/sources/{$sourceId}");

        if (!$response->successful()) {
            return redirect('/user-transaction')->with('error', 'Payment verification failed');
        }

        $source = $response->json()['data'];
        $status = $source['attributes']['status'];

        if ($status === 'chargeable' || $status === 'paid') {
            // Create payment (charge the source)
            $amountCents = (int) ($amountPaid * 100);

            $chargeResponse = Http::withBasicAuth(env('PAYMONGO_SECRET_KEY'), '')
                ->post('https://api.paymongo.com/v1/payments', [
                    'data' => [
                        'attributes' => [
                            'amount' => $amountCents,
                            'currency' => 'PHP',
                            'source' => [
                                'id' => $sourceId,
                                'type' => 'source',
                            ],
                            'description' => "Payment for Transaction #{$txId}",
                        ]
                    ]
                ]);

            if ($chargeResponse->successful()) {
                $tx = BookTransaction::find($txId);

                if ($tx) {
                    $currentFee = max(0, (float) ($tx->fee ?? 0));
                    $newFee = max(0, $currentFee - $amountPaid);
                    $tx->fee = $newFee;
                    $tx->save();

                    $user = Auth::user();
                    if ($user) {
                        ActivityLog::create([
                            'user_id' => $user->id,
                            'user_name' => $user->firstName . ' ' . $user->lastName,
                            'role' => $user->role,
                            'action' => 'Payment',
                            'details' => "Paid ₱{$amountPaid} for transaction #{$txId}. Remaining fee: ₱{$newFee}",
                            'status' => 'success',
                        ]);
                    }

                    // Clear session
                    session()->forget('paymongo_source_' . $txId);

                    return redirect('/user-transaction')->with('success', "Payment of ₱" . number_format($amountPaid, 2) . " successful! Remaining balance: ₱" . number_format($newFee, 2));
                }
            }
        }

        return redirect('/user-transaction')->with('error', 'Payment was not completed. Please try again.');
    }

    /**
     * Handle failed payment
     */
    public function paymentFailed(Request $request)
    {
        $txId = $request->query('transaction_id');
        if ($txId) {
            session()->forget('paymongo_source_' . $txId);
        }
        return redirect('/user-transaction')->with('error', 'Payment failed or was cancelled.');
    }

    /**
     * Webhook handler for PayMongo events (optional for production)
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();

        // Verify webhook signature (recommended for production)
        // $signature = $request->header('paymongo-signature');

        $eventType = $payload['data']['attributes']['type'] ?? null;

        if ($eventType === 'payment.paid') {
            $paymentIntent = $payload['data']['attributes']['data'];
            $metadata = $paymentIntent['attributes']['metadata'];
            $txId = $metadata['transaction_id'] ?? null;
            $amountCents = $paymentIntent['attributes']['amount'];
            $amountPaid = $amountCents / 100;

            if ($txId) {
                $tx = BookTransaction::find($txId);
                if ($tx) {
                    $currentFee = max(0, (float) ($tx->fee ?? 0));
                    $newFee = max(0, $currentFee - $amountPaid);
                    $tx->fee = $newFee;
                    $tx->save();
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
