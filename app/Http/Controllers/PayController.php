<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PayController extends Controller
{
    //

    public function createPayment(Request $request)
    {
        $response = Http::withBasicAuth(env('PAYMONGO_SECRET_KEY'), '')
            ->post('https://api.paymongo.com/v1/payment_intents', [
                'data' => [
                    'attributes' => [
                        'amount' => 10000, // amount in cents
                        'currency' => 'PHP',
                        'payment_method_allowed' => ['card', 'gcash', 'paymaya'],
                    ]
                ]
            ]);

        return $response->json();
    }
}
