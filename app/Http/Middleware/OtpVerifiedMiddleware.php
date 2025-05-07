<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpVerifiedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('api')->check() && Auth::guard('api')->user()->otp_verified_at) {
            return $next($request);
        }

        return Helper::jsonResponse(false, 'Validation failed', 422, 'Email is not verified.');
    }
}