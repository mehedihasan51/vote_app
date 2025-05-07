<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCheckMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check()) {
            if(Auth::guard('web')->user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }else{
                Auth::logout();
                return redirect()->route('login');
            }     
        }
        return $next($request);
    }
}

