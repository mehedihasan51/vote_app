<?php

namespace App\Http\Controllers\Api\Gateway\Stripe;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Stripe\Account;
use Stripe\Stripe;
use Stripe\AccountLink;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class StripeOnBoardingController extends Controller
{
    
    public function accountConnect()
    {
        $user = auth('api')->user();

        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $account = Account::create([
                'type' => 'express',
                'email' => $user->email,
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
                'settings' => [
                    'payouts' => [
                        'schedule' => [
                            'interval' => 'daily', // daily, weekly, monthly
                        ],
                    ],
                ],
            ]);

            $link = AccountLink::create([
                'account' => $account->id,
                'refresh_url' => route('api.payment.stripe.account.connect.refresh', ['account_id' => $account->id]),
                'return_url' => route('api.payment.stripe.account.connect.success', ['account_id' => $account->id]),
                'type' => 'account_onboarding',
            ]);

            $data = [
                'url' => $link->url
            ];

            return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Redirecting to Stripe Express Dashboard..',], 200);
        } catch (ApiErrorException $e) {
            return response()->json(['status' => 'error', 'message' => 'Stripe API error: ' . $e->getMessage(),], 500);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error: ' . $e->getMessage(),], 500);
        }
    }

    public function accountSuccess($account_id)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $account = Account::retrieve($account_id);
            $user = User::where('email', $account->email)->first();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not found in the database for this Stripe account.'], 404);
            }

            $user->update([
                'stripe_account_id' => $account_id
            ]);
            $loginLink = Account::createLoginLink($user->stripe_account_id);
            return redirect()->away($loginLink->url);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error processing onboarding success: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function accountRefresh($account_id)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $link = AccountLink::create([
                'account' => $account_id,
                'refresh_url' => route('api.payment.stripe.account.connect.refresh', ['account_id' => $account_id]),
                'return_url' => route('api.payment.stripe.account.connect.success', ['account_id' => $account_id]),
                'type' => 'account_onboarding',
            ]);

            return redirect()->away($link->url);
        } catch (Exception $e) {
            return response()->json([ 'status' => 'error', 'message' => 'Error generating refresh link: ' . $e->getMessage() ], 500);
        }
    }

    public function accountUrl()
    {
        $user = auth('api')->user();

        if ($user->stripe_account_id) {
            try {
                Stripe::setApiKey(config('services.stripe.secret'));
                $loginLink = Account::createLoginLink($user->stripe_account_id);

                $data = [
                    'url' => $loginLink->url
                ];
                return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Redirecting to Stripe Express Dashboard..',], 200);
            } catch (Exception $e) {
                Log::info($e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'Error generating Stripe login link: ' . $e->getMessage(),], 500);
            }
        }
    }

    public function accountInfo()
    {
        $user = auth('api')->user();

        if ($user->stripe_account_id) {
            try {
                Stripe::setApiKey(config('services.stripe.secret'));
                $account = Account::retrieve($user->stripe_account_id);
                /* $balance = Balance::retrieve([], [
                    'stripe_account' => $user->stripe_account_id,
                ]); */

                $data = [
                    'account_id' => $account->id,
                    'email' => $account->email,
                    'payouts_enabled' => $account->payouts_enabled,
                    /* 'available_balance' => $balance->available,
                    'pending_balance' => $balance->pending, */
                ];

                return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Account info retrieved successfully.', 'code' => 200], 200);
            } catch (Exception $e) {
                Log::info($e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'Error retrieving account info: ' . $e->getMessage(), 'code' => 500], 500);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'User does not have a connected Stripe account.', 'code' => 404], 200);
        }
    }

}
