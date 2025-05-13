<?php
namespace App\Http\Controllers\Api\Donate;

use Stripe\Stripe;
use Stripe\Webhook;
use App\Models\Donation;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class StripeWebhookController extends Controller
{
public function handle(Request $request)
{
    $payload = $request->getContent();
    $sigHeader = $request->header('Stripe-Signature');
    $secret = env('STRIPE_WEBHOOK_SECRET');

    try {
        $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);
    } catch (\UnexpectedValueException $e) {
        return response('Invalid payload', 400);
    } catch (\Stripe\Exception\SignatureVerificationException $e) {
        return response('Invalid signature', 400);
    }

    if ($event->type === 'checkout.session.completed') {
        $session = $event->data->object;

        $metadata = $session->metadata ?? [];

        Donation::create([
            'first_name' => $metadata->first_name ?? '',
            'last_name' => $metadata->last_name ?? '',
            'email' => $metadata->email ?? null,
            'phone' => $metadata->phone ?? null,
            'occupation' => $metadata->occupation ?? null,
            'amount' => $metadata->amount ?? '0',
            'address' => $metadata->address ?? null,
            'city' => $metadata->city ?? null,
            'state' => $metadata->state ?? null,
            'country' => $metadata->country ?? null,
            'zip_code' => $metadata->zip_code ?? null,
            'payment_status' => 'paid',
        ]);
    }

    return response('Webhook handled', 200);
}
}
