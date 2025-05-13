<?php

namespace App\Http\Controllers\Api\Donate;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeDonateController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $amount = $request->input('amount'); // Assume it's in dollars

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Campaign Donation',
                    ],
                    'unit_amount' => $amount * 100, // in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => env('FRONTEND_URL') . '/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => env('FRONTEND_URL') . '/cancel',
            'metadata' => [
                'donor_name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'occupation' => $request->occupation,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postcode' => $request->postcode,
                'country' => $request->country,
                'phone' => $request->phone,
            ],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Checkout session created successfully.',
            'code' => 200,
            'url' =>[$session->url] 
        ]);
    }
}
