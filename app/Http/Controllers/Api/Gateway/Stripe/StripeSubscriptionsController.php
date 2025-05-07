<?php

namespace App\Http\Controllers\Api\Gateway\Stripe;

use App\Http\Controllers\Controller;
use Stripe\Customer;
use Stripe\Subscription;

class StripeSubscriptionsController extends Controller
{
    public function recurring($amount)
    {
        $user = auth('api')->user();

        if ($user->stripe_customer_id == null) {
            return redirect()->route('payment.stripe.account.connect');
        }

        $customer = Customer::retrieve($user->stripe_customer_id);

        if (!$customer || empty($customer->id)) {
            return redirect()->route('payment.stripe.account.connect');
        }

        $subscription = Subscription::create([
            'customer' => $customer->id,
            'items' => [
                ['price' => 'price_1L6Z8lKqZjZK2oTt6d2MqXvC'],
            ]
        ]);


    }
}
