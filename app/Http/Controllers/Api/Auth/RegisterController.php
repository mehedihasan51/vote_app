<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\RegistrationNotificationEvent;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\OtpMail;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Notifications\RegistrationNotification;

class RegisterController extends Controller
{
    public $select;
    public function __construct()
    {
        $this->select = ['id', 'name', 'email', 'otp', 'avatar'];
    }

    public function register(Request $request)
    {
        $request->validate([
            'agree'         => 'required|in:true',
            'role'          => 'nullable|in:member',
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'nullable|string|max:100',
            'email'         => 'required|string|email|max:150|unique:users',
            'phone'         => 'required|numeric|unique:profiles',
            'dob'           => 'required|date',
            'gender'        => 'required|in:male,female,other',
            'password'      => 'required|string|min:6|confirmed'
        ]);
        try {

            $user = User::create([
                'name'           => $request->input('first_name') . ' ' . $request->input('last_name'),
                'email'          => strtolower($request->input('email')),
                'password'       => Hash::make($request->input('password')),
                'otp'            => rand(1000, 9999),
                'otp_expires_at' => Carbon::now()->addMinutes(60),
            ]);

            $user->profile()->create([
                'first_name' => $request->input('first_name'),
                'last_name'  => $request->input('last_name'),
                'phone'      => $request->input('phone'),
                'gender'     => $request->input('gender'),
                'dob'        => $request->input('dob')
            ]);

            $user->assignRole('member');

            //notify to admin start
            /* $notiData = [
                'user_id' => $user->id,
                'title' => 'User register in successfully.',
                'body' => 'User register in successfully.'
            ];

            $admins = User::role('admin', 'web')->get();
            foreach($admins as $admin){
                $admin->notify(new RegistrationNotification($notiData));
                if(config('settings.reverb')  === 'on'){
                    broadcast(new RegistrationNotificationEvent($notiData, $admin->id))->toOthers();
                }
            } */
            //notify to admin end

            Mail::to($user->email)->send(new OtpMail($user->otp, $user, 'Verify Your Email Address'));

            $data = User::select($this->select)->with(['roles', 'profile'])->find($user->id);

            return response()->json([
                'status'     => true,
                'message'    => 'User register in successfully.',
                'code'       => 200,
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'data' => $data
            ], 200);
            
        } catch (Exception $e) {
            return Helper::jsonErrorResponse('User registration failed', 500, [$e->getMessage()]);
        }
    }
    public function VerifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp'   => 'required|digits:4',
        ]);
        try {
            $user = User::where('email', $request->input('email'))->first();

            //! Check if email has already been verified
            if (!empty($user->otp_verified_at)) {
                return  Helper::jsonErrorResponse('Email already verified.', 409);
            }

            if ((string)$user->otp !== (string)$request->input('otp')) {
                return Helper::jsonErrorResponse('Invalid OTP code', 422);
            }

            //* Check if OTP has expired
            if (Carbon::parse($user->otp_expires_at)->isPast()) {
                return Helper::jsonErrorResponse('OTP has expired. Please request a new OTP.', 422);
            }

            //* Verify the email
            $user->otp_verified_at   = now();
            $user->otp               = null;
            $user->otp_expires_at    = null;
            $user->save();

            return Helper::jsonResponse(true, 'Email verification successful.', 200);
        } catch (Exception $e) {
            return Helper::jsonErrorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function ResendOtp(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        try {
            $user = User::where('email', $request->input('email'))->first();

            if (!$user) {
                return Helper::jsonErrorResponse('User not found.', 404);
            }

            if ($user->otp_verified_at) {
                return Helper::jsonErrorResponse('Email already verified.', 409);
            }

            $newOtp               = rand(1000, 9999);
            $otpExpiresAt         = Carbon::now()->addMinutes(60);
            $user->otp            = $newOtp;
            $user->otp_expires_at = $otpExpiresAt;
            $user->save();

            //* Send the new OTP to the user's email
            Mail::to($user->email)->send(new OtpMail($newOtp, $user, 'Verify Your Email Address'));

            return Helper::jsonResponse(true, 'A new OTP has been sent to your email.', 200);
        } catch (Exception $e) {
            return Helper::jsonErrorResponse($e->getMessage(), 200);
        }
    }
}
