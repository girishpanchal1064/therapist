<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:client,therapist,corporate_admin'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone ?? null,
        ]);

        // Create user profile
        UserProfile::create([
            'user_id' => $user->id,
            'first_name' => explode(' ', $request->name)[0],
            'last_name' => explode(' ', $request->name, 2)[1] ?? '',
        ]);

        // Map form role values to database role names
        $roleMap = [
            'client' => 'Client',
            'therapist' => 'Therapist',
            'corporate_admin' => 'Admin', // Assuming corporate_admin maps to Admin role
        ];
        
        $roleName = $roleMap[$request->role] ?? 'Client';
        $user->assignRole($roleName);

        Auth::login($user);

        // Redirect based on role
        if ($request->role === 'therapist') {
            return redirect()->route('therapist.dashboard');
        } elseif ($request->role === 'corporate_admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('client.dashboard');
    }
}
