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
     * Create a PayMongo Checkout Session for GCash/PayMaya payment
     */
    public function createPayment(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Ensure PayMongo secret key is configured
        $secret = env('PAYMONGO_SECRET_KEY') ?: env('PAYMONGO_SECRET');
        if (empty($secret) || !is_string($secret)) {
            return response()->json([
                'message' => 'PayMongo secret key is not configured. Please set PAYMONGO_SECRET_KEY in your .env file.'
            ], 500);
        }

        $request->validate([
            'transaction_id' => 'required|integer|exists:book_transactions,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $txId = $request->transaction_id;
        $amount = (float) $request->amount;

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

        // Create PayMongo Checkout Session (allows user to choose GCash or PayMaya)
        $response = Http::withBasicAuth($secret, '')
            ->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes' => [
                        'send_email_receipt' => true,
                        'show_description' => true,
                        'show_line_items' => true,
                        'description' => 'Payment for Transaction #' . $txId,
                        'line_items' => [
                            [
                                'currency' => 'PHP',
                                'amount' => $amountCents,
                                'description' => 'Book Transaction Fee Payment',
                                'name' => 'Transaction #' . $txId,
                                'quantity' => 1,
                            ]
                        ],
                        'payment_method_types' => ['gcash', 'paymaya'],
                        'success_url' => url('/payment/callback?transaction_id=' . $txId . '&amount=' . $amount),
                        'cancel_url' => url('/payment/failed?transaction_id=' . $txId),
                        'billing' => [
                            'name' => $user->firstName . ' ' . $user->lastName,
                            'email' => $user->email,
                        ],
                    ]
                ]
            ]);

        if (!$response->successful()) {
            Log::error('PayMongo Checkout Session Creation Failed', ['response' => $response->json()]);
            return response()->json([
                'message' => 'Failed to create payment session',
                'error' => $response->json()
            ], 500);
        }

        $session = $response->json()['data'];
        $checkoutUrl = $session['attributes']['checkout_url'] ?? null;
        $sessionId = $session['id'];

        // Store session ID for verification
        session(['paymongo_session_' . $txId => $sessionId]);

        return response()->json([
            'message' => 'Payment session created',
            'session_id' => $sessionId,
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

        // Get stored session ID
        $sessionId = session('paymongo_session_' . $txId);

        if (!$sessionId) {
            return redirect('/user-transaction')->with('error', 'Payment session not found');
        }

        // Verify checkout session status
        $secret = env('PAYMONGO_SECRET_KEY') ?: env('PAYMONGO_SECRET');
        if (empty($secret) || !is_string($secret)) {
            return redirect('/user-transaction')->with('error', 'PayMongo secret key is not configured.');
        }

        $response = Http::withBasicAuth($secret, '')
            ->get("https://api.paymongo.com/v1/checkout_sessions/{$sessionId}");

        if (!$response->successful()) {
            return redirect('/user-transaction')->with('error', 'Payment verification failed');
        }

        $session = $response->json()['data'];
        $status = $session['attributes']['payment_intent']['attributes']['status'] ?? null;

        if ($status === 'succeeded' || $status === 'awaiting_payment_method') {
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
                session()->forget('paymongo_session_' . $txId);

                return redirect('/user-transaction')->with('success', "Payment of ₱" . number_format($amountPaid, 2) . " successful! Remaining balance: ₱" . number_format($newFee, 2));
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
            session()->forget('paymongo_session_' . $txId);
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
