<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verify current password if changing password
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
            }
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            try {
                // Delete old avatar if exists
                $oldAvatar = $user->getRawOriginal('avatar');
                if ($oldAvatar && Storage::disk('public')->exists($oldAvatar)) {
                    Storage::disk('public')->delete($oldAvatar);
                }

                // Store new avatar
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = $avatarPath;
                
                Log::info('Avatar uploaded successfully', ['path' => $avatarPath, 'user_id' => $user->id]);
            } catch (\Exception $e) {
                Log::error('Avatar upload failed', ['error' => $e->getMessage(), 'user_id' => $user->id]);
                return redirect()->back()->withErrors(['avatar' => 'Failed to upload avatar. Please try again.'])->withInput();
            }
        }

        $user->update($data);

        return redirect()->route('admin.profile.index')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile.index')->with('success', 'Password updated successfully.');
    }

    public function deleteAvatar()
    {
        $user = Auth::user();

        try {
            $oldAvatar = $user->getRawOriginal('avatar');
            if ($oldAvatar && Storage::disk('public')->exists($oldAvatar)) {
                Storage::disk('public')->delete($oldAvatar);
            }

            $user->update(['avatar' => null]);

            return redirect()->route('admin.profile.index')->with('success', 'Avatar removed successfully.');
        } catch (\Exception $e) {
            Log::error('Avatar deletion failed', ['error' => $e->getMessage(), 'user_id' => $user->id]);
            return redirect()->back()->with('error', 'Failed to remove avatar. Please try again.');
        }
    }
}
