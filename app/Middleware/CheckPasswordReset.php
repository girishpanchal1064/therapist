<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordReset
{

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->password_reset_required) {
            return redirect()->route('password.reset.form');
        }

        return $next($request);
    }
}
