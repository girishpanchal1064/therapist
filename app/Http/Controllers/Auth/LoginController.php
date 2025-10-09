<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        // Store the intended URL for redirect after login
        if ($request->has('redirect')) {
            session(['url.intended' => $request->redirect]);

            // Check if it's a booking redirect
            if (str_contains($request->redirect, '/book/')) {
                session(['booking_redirect' => true]);
            }
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Update last login
            $user->update(['last_login_at' => now()]);

            // Redirect based on role
            if ($user->hasRole('super_admin') || $user->hasRole('admin')) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->isTherapist()) {
                return redirect()->intended(route('therapist.dashboard'));
            } else {
                return redirect()->intended(route('client.dashboard'));
            }
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
