<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
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

            // Check if user has admin access
            if (!$user->hasAnyRole(['super_admin', 'admin', 'therapist'])) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'You do not have access to the admin panel.',
                ]);
            }

            // Update last login
            $user->update(['last_login_at' => now()]);

            // Redirect based on role (all backend roles go to dashboard)
            return redirect()->intended(route('admin.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        try {
            // Log the logout attempt for debugging
            \Log::info('Admin logout attempt', [
                'user_id' => Auth::id(),
                'user_email' => Auth::user() ? Auth::user()->email : 'No user',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'session_id' => $request->session()->getId(),
                'method' => $request->method(),
                'url' => $request->url()
            ]);

            if (Auth::check()) {
                $user = Auth::user();
                $userEmail = $user->email;

                // Logout the user
                Auth::logout();

                // Invalidate the session
                $request->session()->invalidate();

                // Regenerate the CSRF token
                $request->session()->regenerateToken();

                \Log::info('Admin logout successful', [
                    'user_email' => $userEmail,
                    'session_destroyed' => true
                ]);

                return redirect()->route('login')->with('success', 'You have been logged out successfully.');
            } else {
                \Log::warning('Admin logout called but no user authenticated');
                return redirect()->route('login')->with('error', 'No user was logged in.');
            }
        } catch (\Exception $e) {
            \Log::error('Admin logout error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('login')->with('error', 'Logout failed. Please try again.');
        }
    }
}
