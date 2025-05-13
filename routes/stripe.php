<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Donate\StripeDonateController;
use App\Http\Controllers\Api\Gateway\Stripe\StripeWebHookController;
use App\Http\Controllers\Api\Gateway\Stripe\StripeOnBoardingController;

//stripe webhook
Route::controller(StripeWebHookController::class)->prefix('payment/stripe')->name('payment.stripe.')->group(function () {
    Route::get('/intent/{booking_id}', 'intent')->name('intent');
    Route::post('/webhook', 'webhook')->name('webhook');
});

//stripe account
Route::controller(StripeOnBoardingController::class)->prefix('payment/stripe/account')->name('payment.stripe.account.')->group(function () {
    Route::middleware(['auth:api'])->get('/connect', 'accountConnect')->name('connect');
    Route::get('/connect/success/{account_id}', 'accountSuccess')->name('connect.success');
    Route::get('/connect/refresh/{account_id}', 'accountRefresh')->name('connect.refresh');
    Route::middleware(['auth:api'])->get('/url', 'AccountUrl')->name('url');
    Route::middleware(['auth:api'])->get('/info', 'accountInfo')->name('info');
    Route::middleware(['auth:api'])->post('/withdraw', 'withdrawRequest')->name('withdraw');
});


// Route::controller(StripeDonateController::class)->group(function(){
//     Route::get('stripe', 'stripe');
//     Route::post('stripe', 'stripePost')->name('stripe.post');
// });

// Route::post('/create-checkout-session', [StripeDonateController::class, 'createCheckoutSession']);