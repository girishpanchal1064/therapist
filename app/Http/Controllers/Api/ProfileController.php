<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Get the authenticated user's full profile, including client/therapist details and basic stats.
     */
    public function show(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user()->loadMissing([
            'profile',
            'therapistProfile',
            'wallet',
        ]);

        $appointmentsQuery = $user->isTherapist()
            ? $user->appointmentsAsTherapist()
            : $user->appointmentsAsClient();

        $appointmentsCount = $appointmentsQuery->count();
        $upcomingAppointmentsCount = (clone $appointmentsQuery)
            ->upcoming()
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => new UserResource($user),
                'profile' => $user->profile,
                'therapist_profile' => $user->therapistProfile,
                'wallet' => $user->wallet ? [
                    'balance' => $user->wallet->balance,
                    'formatted_balance' => $user->wallet->formatted_balance,
                    'currency' => $user->wallet->currency,
                ] : null,
                'stats' => [
                    'appointments_count' => $appointmentsCount,
                    'upcoming_appointments_count' => $upcomingAppointmentsCount,
                ],
            ],
        ]);
    }

    /**
     * Update the authenticated user's basic profile fields.
     */
    public function update(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:30'],
            'avatar' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.first_name' => ['sometimes', 'string', 'max:255'],
            'profile.last_name' => ['sometimes', 'string', 'max:255'],
            'profile.date_of_birth' => ['sometimes', 'date'],
            'profile.gender' => ['sometimes', 'nullable', 'string', 'max:50'],
            'profile.bio' => ['sometimes', 'nullable', 'string', 'max:2000'],
            'profile.address_line1' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.address_line2' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.city' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.state' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.country' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.pincode' => ['sometimes', 'nullable', 'string', 'max:20'],
            'profile.preferred_language' => ['sometimes', 'nullable', 'string', 'max:100'],
        ]);

        // Update user basic fields
        $user->fill($request->only(['name', 'phone', 'avatar']));
        $user->save();

        // Update or create user profile
        $profileData = $request->input('profile', []);
        if (! empty($profileData)) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );
        }

        $user->loadMissing(['profile', 'therapistProfile', 'wallet']);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'data' => [
                'user' => new UserResource($user),
                'profile' => $user->profile,
                'therapist_profile' => $user->therapistProfile,
                'wallet' => $user->wallet ? [
                    'balance' => $user->wallet->balance,
                    'formatted_balance' => $user->wallet->formatted_balance,
                    'currency' => $user->wallet->currency,
                ] : null,
            ],
        ]);
    }

    /**
     * Get therapist specific profile for authenticated therapist.
     */
    public function therapistProfile(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user()->loadMissing(['therapistProfile']);

        if (! $user->isTherapist()) {
            return response()->json([
                'success' => false,
                'message' => 'Only therapists can access therapist profile.',
            ], 403);
        }

        $therapistProfile = $user->therapistProfile;

        return response()->json([
            'success' => true,
            'data' => [
                'therapist_profile' => $therapistProfile,
            ],
        ]);
    }
}

