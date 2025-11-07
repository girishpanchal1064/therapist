<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new UserProfile();

        if (request()->routeIs('therapist.*')) {
            return view('therapist.profile.edit', compact('profile'));
        }

        return view('profile.edit', compact('profile'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => ['nullable', Rule::in(['male', 'female', 'other', 'prefer_not_to_say'])],
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:20',
            'preferred_language' => 'nullable|string|max:50',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
        ]);

        // Get or create user profile
        $profile = $user->profile ?? new UserProfile();
        $profile->user_id = $user->id;

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($profile->profile_image && Storage::disk('public')->exists($profile->profile_image)) {
                Storage::disk('public')->delete($profile->profile_image);
            }

            // Store new image
            $path = $request->file('profile_image')->store('profile-images', 'public');
            $profile->profile_image = $path;
        }

        // Update profile data
        $profile->fill($request->only([
            'first_name',
            'last_name',
            'date_of_birth',
            'gender',
            'bio',
            'address_line1',
            'address_line2',
            'city',
            'state',
            'country',
            'pincode',
            'preferred_language',
            'emergency_contact_name',
            'emergency_contact_phone',
        ]));

        $profile->save();

        if ($request->routeIs('therapist.*')) {
            return redirect()->route('therapist.profile.edit')
                ->with('success', 'Profile updated successfully!');
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        if ($request->routeIs('therapist.*')) {
            return redirect()->route('therapist.profile.edit')
                ->with('success', 'Password updated successfully!');
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Password updated successfully!');
    }

    /**
     * Delete the user's profile image.
     */
    public function deleteProfileImage()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if ($profile && $profile->profile_image) {
            if (Storage::disk('public')->exists($profile->profile_image)) {
                Storage::disk('public')->delete($profile->profile_image);
            }

            $profile->profile_image = null;
            $profile->save();
        }

        if (request()->routeIs('therapist.*')) {
            return redirect()->route('therapist.profile.edit')
                ->with('success', 'Profile image deleted successfully!');
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Profile image deleted successfully!');
    }
}
