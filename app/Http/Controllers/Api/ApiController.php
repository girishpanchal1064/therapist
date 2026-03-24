<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\AssessmentResource;
use App\Http\Resources\TherapistResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WalletTransactionResource;
use App\Models\Appointment;
use App\Models\Assessment;
use App\Models\SessionNote;
use App\Models\TherapistEarning;
use App\Models\UserAssessment;
use App\Models\UserAssessmentAnswer;
use App\Models\TherapistProfile;
use App\Models\TherapistSpecialization;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Wallet;
use App\Services\TherapistAvailabilityService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    protected function successResponse(
        mixed $data = null,
        ?string $message = null,
        int $status = 200
    ): JsonResponse {
        $payload = [
            'success' => true,
        ];

        if (! is_null($message)) {
            $payload['message'] = $message;
        }

        if (! is_null($data)) {
            $payload['data'] = $data;
        }

        return response()->json($payload, $status);
    }

    /**
     * Return a standardized error JSON response.
     */
    protected function errorResponse(
        string $message,
        int $status = 400,
        mixed $errors = null
    ): JsonResponse {
        $payload = [
            'success' => false,
            'message' => $message,
        ];

        if (! is_null($errors)) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }


    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
            'phone' => ['nullable', 'string', 'max:30'],
            'role_id' => ['nullable', 'integer', 'exists:roles,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'phone' => $validated['phone'] ?? null,
            'status' => 'active',
        ]);
        UserProfile::create([
            'user_id' => $user->id,
            'first_name' => explode(' ', $validated['name'])[0],
            'last_name' => explode(' ', $validated['name'], 2)[1] ?? '',
        ]);

        if (! empty($validated['role_id'])) {
            $role = Role::query()->find($validated['role_id']);

            if ($role) {
                $user->role_id = $role->id;
                $user->save();
                $user->assignRole($role->name);
            }
        } else {
            $defaultRole = Role::query()->where('name', 'Client')->first();
            if ($defaultRole) {
                $user->role_id = $defaultRole->id;
                $user->save();
                $user->assignRole($defaultRole->name);
            }
        }

        $tokenResult = $user->createToken('api-token');

        return $this->successResponse([
            'user' => new UserResource($user),
            'token_type' => 'Bearer',
            'access_token' => $tokenResult->accessToken ?? $tokenResult->token,
        ], 'Registered successfully.', 201);
    }


    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
        $user = User::query()->where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return $this->errorResponse('Invalid credentials.', 422);
        }

        if (! $user->isActive()) {
            return $this->errorResponse('Your account is not active.', 403);
        }

        $tokenResult = $user->createToken('api-token');
        $user->forceFill([
            'last_login_at' => now(),
        ])->save();

        return $this->successResponse([
            'user' => new UserResource($user),
            'token_type' => 'Bearer',
            'access_token' => $tokenResult->accessToken ?? $tokenResult->token,
        ], 'Logged in successfully.');
    }

    /**
     * Login specifically as a Client (customer).
     */
    public function loginCustomer(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()->where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return $this->errorResponse('Invalid credentials.', 422);
        }

        if (! $user->isClient()) {
            return $this->errorResponse('This account is not a Client.', 403);
        }

        if (! $user->isActive()) {
            return $this->errorResponse('Your account is not active.', 403);
        }

        $tokenResult = $user->createToken('api-token');
        $user->forceFill([
            'last_login_at' => now(),
        ])->save();

        // Load customer profile & wallet so app can show it immediately
        $user->loadMissing(['profile', 'wallet']);

        return $this->successResponse([
            'user' => new UserResource($user),
            'profile' => $user->profile,
            'wallet' => $user->wallet ? [
                'balance' => $user->wallet->balance,
                'formatted_balance' => $user->wallet->formatted_balance,
                'currency' => $user->wallet->currency,
            ] : null,
            'token_type' => 'Bearer',
            'access_token' => $tokenResult->accessToken ?? $tokenResult->token,
        ], 'Logged in successfully as Client.');
    }

    /**
     * Login specifically as a Therapist.
     */
    public function loginTherapist(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()->where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return $this->errorResponse('Invalid credentials.', 422);
        }

        if (! $user->isTherapist()) {
            return $this->errorResponse('This account is not a Therapist.', 403);
        }

        if (! $user->isActive()) {
            return $this->errorResponse('Your account is not active.', 403);
        }

        $tokenResult = $user->createToken('api-token');
        $user->forceFill([
            'last_login_at' => now(),
        ])->save();

        // Load therapist profile (and basic profile/wallet) for immediate use
        $user->loadMissing(['therapistProfile', 'profile', 'wallet']);

        return $this->successResponse([
            'user' => new UserResource($user),
            'profile' => $user->profile,
            'therapist_profile' => $user->therapistProfile,
            'wallet' => $user->wallet ? [
                'balance' => $user->wallet->balance,
                'formatted_balance' => $user->wallet->formatted_balance,
                'currency' => $user->wallet->currency,
            ] : null,
            'token_type' => 'Bearer',
            'access_token' => $tokenResult->accessToken ?? $tokenResult->token,
        ], 'Logged in successfully as Therapist.');
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return $this->successResponse(null, __($status));
        }

        return $this->errorResponse(__($status), 422);
    }

    /**
     * Reset the user's password using the token sent via email.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        // Allow the reset token and email to come from either the body or the query string
        $token = $request->input('token') ?? $request->query('token');
        $email = $request->input('email') ?? $request->query('email');

        if (! $token || ! is_string($token)) {
            return $this->errorResponse('The password reset token is required.', 422);
        }

        if (! $email || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->errorResponse('A valid email address is required.', 422);
        }

        $status = Password::reset(
            [
                'email' => $email,
                'password' => $request->input('password'),
                'password_confirmation' => $request->input('password_confirmation'),
                'token' => $token,
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return $this->successResponse(null, __($status));
        }

        return $this->errorResponse(__($status), 422);
    }

    /**
     * Log out the authenticated user by revoking the current token.
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user && $user->token()) {
            $user->token()->revoke();
        }

        return $this->successResponse(null, 'Logged out successfully.');
    }

    /**
     * Return the currently authenticated user.
     */
    public function me(Request $request): JsonResponse
    {
        return $this->successResponse([
            'user' => new UserResource($request->user()),
        ]);
    }

    /**
     * Get the authenticated user's full profile, including client/therapist details and basic stats.
     */
    public function profile(Request $request): JsonResponse
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

        return $this->successResponse([
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
        ]);
    }

    /**
     * Update the authenticated user's basic profile fields.
     */
    public function updateProfile(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:30'],
            'avatar' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.first_name' => ['sometimes', 'string', 'max:255'],
            'profile.last_name' => ['sometimes', 'string', 'max:255'],
            // Date of birth must be in Y-m-d format, e.g. 1990-05-21
            'profile.date_of_birth' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            // Restrict gender to known values for consistency
            'profile.gender' => ['sometimes', 'nullable', 'in:male,female,other,prefer_not_to_say'],
            'profile.bio' => ['sometimes', 'nullable', 'string', 'max:2000'],
            'profile.address_line1' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.address_line2' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.city' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.state' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.country' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.pincode' => ['sometimes', 'nullable', 'string', 'max:20'],
            'profile.preferred_language' => ['sometimes', 'nullable', 'string', 'max:100'],
        ]);

        $user->fill($request->only(['name', 'phone', 'avatar']));
        $user->save();

        $profileData = $request->input('profile', []);
        if (! empty($profileData)) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );
        }

        $user->loadMissing(['profile', 'therapistProfile', 'wallet']);

        return $this->successResponse([
            'user' => new UserResource($user),
            'profile' => $user->profile,
            'therapist_profile' => $user->therapistProfile,
            'wallet' => $user->wallet ? [
                'balance' => $user->wallet->balance,
                'formatted_balance' => $user->wallet->formatted_balance,
                'currency' => $user->wallet->currency,
            ] : null,
        ], 'Profile updated successfully.');
    }

    /**
     * Get therapist specific profile for authenticated therapist.
     */
    public function therapistSelfProfile(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can access therapist profile.', 403);
        }

        $user->loadMissing([
            'profile',
            'therapistProfile.specializations',
            'therapistProfile.experiences',
            'therapistProfile.qualifications',
            'therapistProfile.awards',
            'therapistProfile.professionalBodies',
            'therapistProfile.bankDetails',
        ]);

        $tp = $user->therapistProfile;
        $up = $user->profile;

        $specializations = $tp && $tp->relationLoaded('specializations')
            ? $tp->specializations->map(fn ($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'slug' => $s->slug,
            ])->values()->all()
            : [];

        return $this->successResponse([
            'basic' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'avatar' => $user->avatar,
            ],
            'profile' => $tp ? [
                'id' => $tp->id,
                // Basic Information (as per therapist profile UI)
                'prefix' => $tp->prefix,
                'first_name' => $tp->first_name ?? ($up->first_name ?? null),
                'middle_name' => $tp->middle_name,
                'last_name' => $tp->last_name ?? ($up->last_name ?? null),
                'category' => $tp->category,
                'user_name' => $tp->user_name,
                'full_name' => $tp->full_name,
                'email' => $user->email,
                'mobile' => $user->phone,
                'gender' => $up->gender ?? null,
                'date_of_birth' => optional($up?->date_of_birth)->toDateString(),
                'qualification_summary' => $tp->qualification,
                'experience_years' => $tp->experience_years,
                'timezone' => $tp->timezone,
                'consultation_fee' => $tp->consultation_fee,
                'couple_consultation_fee' => $tp->couple_consultation_fee,
                'bio' => $tp->bio,
                'languages' => $tp->languages,
                'brief_description' => $tp->brief_description,
                'present_address' => [
                    'address' => $tp->present_address,
                    'country' => $tp->present_country,
                    'state' => $tp->present_state,
                    'city' => $tp->present_city,
                    'district' => $tp->present_district,
                    'zip_code' => $tp->present_zip,
                ],
                'clinic_address' => [
                    'same_as_present_address' => (bool) $tp->same_as_present_address,
                    'address' => $tp->clinic_address,
                    'country' => $tp->clinic_country,
                    'state' => $tp->clinic_state,
                    'city' => $tp->clinic_city,
                    'district' => $tp->clinic_district,
                    'zip_code' => $tp->clinic_zip,
                ],
                'areas_of_expertise' => $tp->areas_of_expertise,
                'profile_image' => $tp->profile_image,
                'is_verified' => $tp->is_verified,
                'is_available' => $tp->is_available,
                'specializations' => $specializations,
            ] : null,
            'experiences' => $tp ? $tp->experiences : [],
            'qualifications' => $tp ? $tp->qualifications : [],
            'awards' => $tp ? $tp->awards : [],
            'professional_bodies' => $tp ? $tp->professionalBodies : [],
            'bank_details' => $tp ? $tp->bankDetails : [],
        ]);
    }

    /**
     * Update therapist profile for the authenticated therapist.
     */
    public function updateTherapistProfile(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can update therapist profile.', 403);
        }

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:30'],

            'bio' => ['sometimes', 'string'],
            'experience_years' => ['sometimes', 'integer', 'min:0'],
            'consultation_fee' => ['sometimes', 'numeric', 'min:0'],
            'couple_consultation_fee' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'qualification_summary' => ['sometimes', 'nullable', 'string', 'max:255'],
            'languages' => ['sometimes', 'array'],
            'languages.*' => ['string', 'max:50'],
            'areas_of_expertise' => ['sometimes', 'array'],
            'areas_of_expertise.*' => ['string', 'max:255'],
            'certifications' => ['sometimes', 'nullable', 'string'],
            'education' => ['sometimes', 'nullable', 'string'],
            'specializations' => ['sometimes', 'array'],
            'specializations.*' => ['integer', 'exists:therapist_specializations,id'],
        ]);

        // Update basic user fields
        $user->fill($request->only(['name', 'phone']));
        $user->save();

        // Ensure therapist profile exists
        $tp = $user->therapistProfile;
        if (! $tp) {
            $tp = new TherapistProfile(['user_id' => $user->id]);
        }

        $tp->fill([
            'bio' => $request->input('bio', $tp->bio),
            'experience_years' => $request->input('experience_years', $tp->experience_years),
            'consultation_fee' => $request->input('consultation_fee', $tp->consultation_fee),
            'couple_consultation_fee' => $request->input('couple_consultation_fee', $tp->couple_consultation_fee),
            'qualification' => $request->input('qualification_summary', $tp->qualification),
            'languages' => $request->has('languages') ? $request->input('languages') : $tp->languages,
            'areas_of_expertise' => $request->has('areas_of_expertise') ? $request->input('areas_of_expertise') : $tp->areas_of_expertise,
            'certifications' => $request->input('certifications', $tp->certifications),
            'education' => $request->input('education', $tp->education),
        ]);
        $tp->save();

        // Sync specializations if provided
        if ($request->has('specializations')) {
            $tp->specializations()->sync($request->input('specializations', []));
        }

        // Reload full therapist profile data for response (same shape as therapistSelfProfile)
        $user->loadMissing([
            'profile',
            'therapistProfile.specializations',
            'therapistProfile.experiences',
            'therapistProfile.qualifications',
            'therapistProfile.awards',
            'therapistProfile.professionalBodies',
            'therapistProfile.bankDetails',
        ]);

        $tp = $user->therapistProfile;
        $up = $user->profile;

        $specializations = $tp && $tp->relationLoaded('specializations')
            ? $tp->specializations->map(fn ($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'slug' => $s->slug,
            ])->values()->all()
            : [];

        return $this->successResponse([
            'basic' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'avatar' => $user->avatar,
            ],
            'profile' => $tp ? [
                'id' => $tp->id,
                // Basic Information (as per therapist profile UI)
                'prefix' => $tp->prefix,
                'first_name' => $tp->first_name ?? ($up->first_name ?? null),
                'middle_name' => $tp->middle_name,
                'last_name' => $tp->last_name ?? ($up->last_name ?? null),
                'category' => $tp->category,
                'user_name' => $tp->user_name,
                'full_name' => $tp->full_name,
                'email' => $user->email,
                'mobile' => $user->phone,
                'gender' => $up->gender ?? null,
                'date_of_birth' => optional($up?->date_of_birth)->toDateString(),
                'qualification_summary' => $tp->qualification,
                'experience_years' => $tp->experience_years,
                'timezone' => $tp->timezone,
                'consultation_fee' => $tp->consultation_fee,
                'couple_consultation_fee' => $tp->couple_consultation_fee,
                'bio' => $tp->bio,
                'languages' => $tp->languages,
                'brief_description' => $tp->brief_description,
                'present_address' => [
                    'address' => $tp->present_address,
                    'country' => $tp->present_country,
                    'state' => $tp->present_state,
                    'city' => $tp->present_city,
                    'district' => $tp->present_district,
                    'zip_code' => $tp->present_zip,
                ],
                'clinic_address' => [
                    'same_as_present_address' => (bool) $tp->same_as_present_address,
                    'address' => $tp->clinic_address,
                    'country' => $tp->clinic_country,
                    'state' => $tp->clinic_state,
                    'city' => $tp->clinic_city,
                    'district' => $tp->clinic_district,
                    'zip_code' => $tp->clinic_zip,
                ],
                'areas_of_expertise' => $tp->areas_of_expertise,
                'profile_image' => $tp->profile_image,
                'is_verified' => $tp->is_verified,
                'is_available' => $tp->is_available,
                'specializations' => $specializations,
            ] : null,
            'experiences' => $tp ? $tp->experiences : [],
            'qualifications' => $tp ? $tp->qualifications : [],
            'awards' => $tp ? $tp->awards : [],
            'professional_bodies' => $tp ? $tp->professionalBodies : [],
            'bank_details' => $tp ? $tp->bankDetails : [],
        ], 'Therapist profile updated successfully.');
    }

    /**
     * Get therapist availability (time slots) for a given date.
     *
     * Query params:
     * - date (Y-m-d, required)
     * - session_mode: online|offline (optional, passed as mode)
     * - duration_minutes: integer (optional, default 60)
     */
    public function therapistAvailability(int $therapistId, Request $request): JsonResponse
    {
        $request->validate([
            'date' => ['required', 'date'],
            'session_mode' => ['nullable', 'in:online,offline'],
            'duration_minutes' => ['nullable', 'integer', 'min:15', 'max:180'],
        ]);

        $therapist = User::findOrFail($therapistId);

        if (! $therapist->isTherapist()) {
            return $this->errorResponse('Therapist not found.', 404);
        }

        $date = $request->get('date');
        $mode = $request->get('session_mode');
        $duration = $request->get('duration_minutes', 60);

        $service = new TherapistAvailabilityService();
        $slots = $service->getAvailableSlots($therapistId, $date, $mode, $duration);

        return $this->successResponse([
            'therapist_id' => $therapistId,
            'date' => $date,
            'session_mode' => $mode,
            'duration_minutes' => (int) $duration,
            'slots' => $slots,
        ]);
    }

    /**
     * Get account summary for the authenticated therapist (earnings per appointment).
     */
    public function therapistAccountSummary(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can access account summary.', 403);
        }

        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $search = $request->get('search');
        $perPage = (int) $request->get('per_page', 10);

        $query = Appointment::with(['client', 'payment', 'therapistEarning'])
            ->where('therapist_id', $user->id)
            ->whereHas('payment', function ($q) {
                $q->where('status', 'completed');
            });

        if ($startDate && $endDate) {
            $query->whereBetween('appointment_date', [$startDate, $endDate]);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($clientQuery) use ($search) {
                        $clientQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $summaries = $query->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->paginate($perPage);

        $totalDue = $summaries->sum(function ($appointment) {
            return $appointment->therapistEarning ? $appointment->therapistEarning->due_amount : 0;
        });

        $totalAvailable = $summaries->sum(function ($appointment) {
            return $appointment->therapistEarning ? $appointment->therapistEarning->available_amount : 0;
        });

        $totalDisbursed = $summaries->sum(function ($appointment) {
            return $appointment->therapistEarning ? $appointment->therapistEarning->disbursed_amount : 0;
        });

        $items = $summaries->map(function (Appointment $appointment) {
            $earning = $appointment->therapistEarning;

            return [
                'appointment_id' => $appointment->id,
                'appointment_date' => optional($appointment->appointment_date)->toDateString(),
                'appointment_time' => optional($appointment->appointment_time)->format('H:i:s'),
                'status' => $appointment->status,
                'session_notes' => $appointment->session_notes,
                'client' => $appointment->client ? [
                    'id' => $appointment->client->id,
                    'name' => $appointment->client->name,
                    'email' => $appointment->client->email,
                ] : null,
                'payment' => $appointment->payment ? [
                    'id' => $appointment->payment->id,
                    'amount' => $appointment->payment->amount,
                    'status' => $appointment->payment->status,
                    'method' => $appointment->payment->payment_method ?? null,
                    'paid_at' => optional($appointment->payment->paid_at)->toDateTimeString(),
                ] : null,
                'earning' => $earning ? [
                    'id' => $earning->id,
                    'due_amount' => $earning->due_amount,
                    'available_amount' => $earning->available_amount,
                    'disbursed_amount' => $earning->disbursed_amount,
                    'status' => $earning->status,
                    'disbursed_at' => optional($earning->disbursed_at)->toDateTimeString(),
                    'description' => $earning->description,
                ] : null,
            ];
        });

        return $this->successResponse([
            'items' => $items,
            'totals' => [
                'due_amount' => $totalDue,
                'available_amount' => $totalAvailable,
                'disbursed_amount' => $totalDisbursed,
            ],
            'pagination' => [
                'current_page' => $summaries->currentPage(),
                'last_page' => $summaries->lastPage(),
                'per_page' => $summaries->perPage(),
                'total' => $summaries->total(),
            ],
        ]);
    }

    /**
     * List session notes for authenticated therapist.
     */
    public function therapistSessionNotes(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can access session notes.', 403);
        }

        $search = $request->get('search');
        $perPage = (int) $request->get('per_page', 10);

        $query = SessionNote::where('therapist_id', $user->id)
            ->with(['client', 'appointment']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('chief_complaints', 'like', "%{$search}%")
                    ->orWhere('observations', 'like', "%{$search}%")
                    ->orWhere('recommendations', 'like', "%{$search}%")
                    ->orWhere('reason', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($clientQuery) use ($search) {
                        $clientQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('appointment', function ($appointmentQuery) use ($search) {
                        $appointmentQuery->where('id', 'like', "%{$search}%");
                    });
            });
        }

        $sessionNotes = $query->orderByDesc('session_date')
            ->orderByDesc('start_time')
            ->paginate($perPage);

        $items = $sessionNotes->map(function (SessionNote $note) {
            return [
                'id' => $note->id,
                'session_date' => optional($note->session_date)->toDateString(),
                'start_time' => optional($note->start_time)->format('H:i:s'),
                'chief_complaints' => $note->chief_complaints,
                'observations' => $note->observations,
                'recommendations' => $note->recommendations,
                'reason' => $note->reason,
                'follow_up_date' => optional($note->follow_up_date)->toDateString(),
                'user_didnt_turn_up' => (bool) $note->user_didnt_turn_up,
                'no_follow_up_required' => (bool) $note->no_follow_up_required,
                'client' => $note->client ? [
                    'id' => $note->client->id,
                    'name' => $note->client->name,
                    'email' => $note->client->email,
                ] : null,
                'appointment' => $note->appointment ? [
                    'id' => $note->appointment->id,
                    'appointment_date' => optional($note->appointment->appointment_date)->toDateString(),
                    'appointment_time' => optional($note->appointment->appointment_time)->format('H:i:s'),
                ] : null,
            ];
        });

        return $this->successResponse([
            'items' => $items,
            'pagination' => [
                'current_page' => $sessionNotes->currentPage(),
                'last_page' => $sessionNotes->lastPage(),
                'per_page' => $sessionNotes->PerPage(),
                'total' => $sessionNotes->total(),
            ],
        ]);
    }

    /**
     * Store a new session note for authenticated therapist.
     */
    public function storeTherapistSessionNote(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can create session notes.', 403);
        }

        $validated = $request->validate([
            'appointment_id' => ['nullable', 'exists:appointments,id'],
            'client_id' => ['required', 'exists:users,id'],
            'session_date' => ['nullable', 'date'],
            'start_time' => ['nullable'],
            'chief_complaints' => ['required', 'string'],
            'observations' => ['required', 'string'],
            'recommendations' => ['required', 'string'],
            'reason' => ['nullable', 'string'],
            'follow_up_date' => ['nullable', 'date', 'after_or_equal:today'],
            'user_didnt_turn_up' => ['boolean'],
            'no_follow_up_required' => ['boolean'],
        ]);

        if ($request->appointment_id) {
            $appointment = Appointment::findOrFail($request->appointment_id);
            $validated['session_date'] = $appointment->appointment_date;
            $validated['start_time'] = $appointment->appointment_time
                ? $appointment->appointment_time->format('H:i:s')
                : null;
        }

        $validated['therapist_id'] = $user->id;
        $validated['user_didnt_turn_up'] = $request->has('user_didnt_turn_up');
        $validated['no_follow_up_required'] = $request->has('no_follow_up_required');

        if (! empty($validated['no_follow_up_required'])) {
            $validated['follow_up_date'] = null;
        }

        $note = SessionNote::create($validated);

        return $this->successResponse($note, 'Session note created successfully.', 201);
    }

    /**
     * Show a single session note for authenticated therapist.
     */
    public function showTherapistSessionNote(int $id, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can view session notes.', 403);
        }

        $note = SessionNote::where('therapist_id', $user->id)
            ->with(['client', 'appointment'])
            ->findOrFail($id);

        return $this->successResponse($note);
    }

    /**
     * Update a session note for authenticated therapist.
     */
    public function updateTherapistSessionNote(int $id, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can update session notes.', 403);
        }

        $note = SessionNote::where('therapist_id', $user->id)->findOrFail($id);

        $validated = $request->validate([
            'appointment_id' => ['nullable', 'exists:appointments,id'],
            'client_id' => ['sometimes', 'exists:users,id'],
            'session_date' => ['nullable', 'date'],
            'start_time' => ['nullable'],
            'chief_complaints' => ['sometimes', 'string'],
            'observations' => ['sometimes', 'string'],
            'recommendations' => ['sometimes', 'string'],
            'reason' => ['nullable', 'string'],
            'follow_up_date' => ['nullable', 'date', 'after_or_equal:today'],
            'user_didnt_turn_up' => ['boolean'],
            'no_follow_up_required' => ['boolean'],
        ]);

        if ($request->appointment_id) {
            $appointment = Appointment::findOrFail($request->appointment_id);
            $validated['session_date'] = $appointment->appointment_date;
            $validated['start_time'] = $appointment->appointment_time
                ? $appointment->appointment_time->format('H:i:s')
                : null;
        }

        if ($request->has('user_didnt_turn_up')) {
            $validated['user_didnt_turn_up'] = $request->boolean('user_didnt_turn_up');
        }

        if ($request->has('no_follow_up_required')) {
            $validated['no_follow_up_required'] = $request->boolean('no_follow_up_required');
            if ($validated['no_follow_up_required']) {
                $validated['follow_up_date'] = null;
            }
        }

        $note->update($validated);

        return $this->successResponse($note, 'Session note updated successfully.');
    }

    /**
     * List all therapists (astrologers) with optional filters.
     *
     * Query params (multi-select supported):
     * - search: string
     * - category[] or category: comma-separated or repeated specialization IDs (therapist must have at least one)
     * - language[] or language: comma-separated or repeated language names (therapist must speak at least one)
     * - min_fee, max_fee: number
     * - per_page: number (default 12)
     */
    public function therapists(Request $request): JsonResponse
    {
        $query = User::role('Therapist')
            ->whereHas('therapistProfile', function ($q) {
                $q->where('is_verified', true)
                    ->where('is_available', true);
            })
            ->with(['therapistProfile.specializations', 'therapistProfile.qualifications', 'profile']);

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('therapistProfile', function ($subQ) use ($search) {
                        $subQ->where('qualification', 'like', "%{$search}%")
                            ->orWhere('bio', 'like', "%{$search}%");
                    });
            });
        }

        // Multi-select: category (specialization IDs)
        $categoryIds = $request->collect('category')->filter()->values()->all();
        if ($request->filled('category') && empty($categoryIds)) {
            $categoryIds = array_filter(array_map('intval', explode(',', $request->string('category')->toString())));
        }
        if (! empty($categoryIds)) {
            $query->whereHas('therapistProfile.specializations', function ($q) use ($categoryIds) {
                $q->whereIn('therapist_specializations.id', $categoryIds);
            });
        }

        // Multi-select: language (therapist must speak at least one of the given languages)
        $languages = $request->collect('language')->filter()->values()->all();
        if ($request->filled('language') && empty($languages)) {
            $languages = array_filter(array_map('trim', explode(',', $request->string('language')->toString())));
        }
        if (! empty($languages)) {
            $query->whereHas('therapistProfile', function ($q) use ($languages) {
                $q->where(function ($q2) use ($languages) {
                    foreach ($languages as $lang) {
                        $q2->orWhereJsonContains('languages', $lang);
                    }
                });
            });
        }

        if ($request->filled('min_fee') || $request->filled('max_fee')) {
            $query->whereHas('therapistProfile', function ($q) use ($request) {
                if ($request->filled('min_fee')) {
                    $q->where('consultation_fee', '>=', $request->get('min_fee'));
                }
                if ($request->filled('max_fee')) {
                    $q->where('consultation_fee', '<=', $request->get('max_fee'));
                }
            });
        }

        $perPage = (int) $request->get('per_page', 12);
        $therapists = $query->paginate($perPage);

        // Build filter options for multi-select UIs (categories = specializations, languages = distinct from DB)
        $filterOptions = [
            'categories' => TherapistSpecialization::active()->ordered()->get(['id', 'name', 'slug']),
            'languages' => TherapistProfile::whereNotNull('languages')
                ->where('is_verified', true)
                ->get()
                ->pluck('languages')
                ->flatten()
                ->unique()
                ->filter()
                ->values()
                ->sort()
                ->values()
                ->all(),
        ];

        return $this->successResponse([
            'items' => TherapistResource::collection($therapists),
            'pagination' => [
                'current_page' => $therapists->currentPage(),
                'last_page' => $therapists->lastPage(),
                'per_page' => $therapists->perPage(),
                'total' => $therapists->total(),
            ],
            'filter_options' => $filterOptions,
        ]);
    }

    /**
     * Show a single therapist profile.
     */
    public function therapistProfile(int $id): JsonResponse
    {
        $therapist = User::role('Therapist')
            ->whereHas('therapistProfile', function ($q) {
                $q->where('is_verified', true);
            })
            ->with(['therapistProfile.specializations', 'therapistProfile.qualifications', 'profile'])
            ->findOrFail($id);

        return $this->successResponse(new TherapistResource($therapist));
    }

    /**
     * Get the authenticated user's wallet details and recent transactions.
     */
    public function wallet(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        // Only customers (clients) can access wallet summary
        if (! $user->isClient()) {
            return $this->errorResponse('Only customers can access wallet.', 403);
        }

        $wallet = $user->wallet;

        if (! $wallet) {
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'currency' => 'INR',
            ]);
        }

        $recentTransactions = $wallet->transactions()
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        return $this->successResponse([
            'wallet' => [
                'id' => $wallet->id,
                'balance' => $wallet->balance,
                'formatted_balance' => $wallet->formatted_balance,
                'currency' => $wallet->currency,
            ],
            'recent_transactions' => WalletTransactionResource::collection($recentTransactions),
        ]);
    }

    /**
     * List wallet transactions for the authenticated user with pagination and optional filters.
     */
    public function walletTransactions(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        // Only customers (clients) can view wallet transactions
        if (! $user->isClient()) {
            return $this->errorResponse('Only customers can view wallet transactions.', 403);
        }

        $wallet = $user->wallet;

        if (! $wallet) {
            return $this->successResponse([
                'wallet' => null,
                'items' => [],
                'pagination' => [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => (int) $request->get('per_page', 15),
                    'total' => 0,
                ],
            ]);
        }

        $query = $wallet->transactions()->orderByDesc('id');

        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->get('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->get('to'));
        }

        $perPage = (int) $request->get('per_page', 15);
        $transactions = $query->paginate($perPage);

        return $this->successResponse([
            'wallet' => [
                'id' => $wallet->id,
                'balance' => $wallet->balance,
                'formatted_balance' => $wallet->formatted_balance,
                'currency' => $wallet->currency,
            ],
            'items' => WalletTransactionResource::collection($transactions),
            'pagination' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'per_page' => $transactions->perPage(),
                'total' => $transactions->total(),
            ],
        ]);
    }

    /**
     * Confirm a simple top-up on the wallet (after successful payment).
     */
    public function walletTopupConfirm(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        // Only customers (clients) can top up wallet
        if (! $user->isClient()) {
            return $this->errorResponse('Only customers can top up wallet.', 403);
        }

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'payment_method' => ['required', 'string', 'max:50'],
            'transaction_id' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $wallet = $user->wallet;

        if (! $wallet) {
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'currency' => 'INR',
            ]);
        }

        $beforeBalance = $wallet->balance;
        $amount = (float) $validated['amount'];

        $wallet->addMoney(
            $amount,
            $validated['description'] ?? 'Wallet top-up',
            null,
            null
        );

        $transaction = $wallet->transactions()->latest('id')->first();
        if ($transaction) {
            $transaction->payment_method = $validated['payment_method'];
            $transaction->transaction_id = $validated['transaction_id'];
            $transaction->save();
        }

        return $this->successResponse([
            'wallet' => [
                'id' => $wallet->id,
                'balance_before' => $beforeBalance,
                'balance_after' => $wallet->balance,
                'formatted_balance' => $wallet->formatted_balance,
                'currency' => $wallet->currency,
            ],
            'transaction' => $transaction ? new WalletTransactionResource($transaction) : null,
        ], 'Wallet topped up successfully.');
    }

    /**
     * List appointments for the authenticated user.
     * - If therapist: appointments where therapist_id = user id
     * - If client: appointments where client_id = user id
     */
    public function appointments(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $query = Appointment::query()->with(['client', 'therapist']);

        if ($user->isTherapist()) {
            $query->where('therapist_id', $user->id);
        } elseif ($user->isClient()) {
            $query->where('client_id', $user->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $perPage = (int) $request->get('per_page', 10);
        $appointments = $query
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate($perPage);

        return $this->successResponse([
            'items' => AppointmentResource::collection($appointments),
            'pagination' => [
                'current_page' => $appointments->currentPage(),
                'last_page' => $appointments->lastPage(),
                'per_page' => $appointments->perPage(),
                'total' => $appointments->total(),
            ],
        ]);
    }

    /**
     * Create a new appointment (booking) for the authenticated client.
     */
    public function createAppointment(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isClient()) {
            return $this->errorResponse('Only clients can create appointments.', 403);
        }

        $validated = $request->validate([
            'therapist_id' => ['required', 'exists:users,id'],
            'appointment_type' => ['required', 'in:individual,couple,family'],
            'session_mode' => ['required', 'in:video,audio,chat'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required'],
            'duration_minutes' => ['required', 'integer', 'min:30', 'max:120'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $therapist = User::findOrFail($validated['therapist_id']);

        if (! $therapist->isTherapist()) {
            return $this->errorResponse('Therapist not found.', 404);
        }

        // Normalize date and time
        $appointmentDate = Carbon::parse($validated['appointment_date'])->toDateString();
        $appointmentTimeInput = $validated['appointment_time'];
        $timeFormatted = strlen($appointmentTimeInput) === 5
            ? $appointmentTimeInput . ':00'
            : $appointmentTimeInput;

        $durationMinutes = (int) $validated['duration_minutes'];

        $slotStart = Carbon::parse($appointmentDate . ' ' . $timeFormatted);
        $slotEnd = $slotStart->copy()->addMinutes($durationMinutes);

        // Check overlapping appointments for this therapist on that date
        $existingAppointments = Appointment::where('therapist_id', $validated['therapist_id'])
            ->where('appointment_date', $appointmentDate)
            ->whereIn('status', ['scheduled', 'confirmed', 'in_progress'])
            ->get();

        foreach ($existingAppointments as $existing) {
            $existingTime = is_string($existing->appointment_time)
                ? $existing->appointment_time
                : Carbon::parse($existing->appointment_time)->format('H:i:s');

            if (strlen($existingTime) === 5) {
                $existingTime .= ':00';
            }

            $existingStart = Carbon::parse($appointmentDate . ' ' . $existingTime);
            $existingEnd = $existingStart->copy()->addMinutes($existing->duration_minutes ?? 60);

            if ($slotStart->lt($existingEnd) && $slotEnd->gt($existingStart)) {
                return $this->errorResponse('This time slot is no longer available.', 422);
            }
        }

        // Create appointment
        $appointment = Appointment::create([
            'client_id' => $user->id,
            'therapist_id' => $validated['therapist_id'],
            'appointment_type' => $validated['appointment_type'],
            'session_mode' => $validated['session_mode'],
            'appointment_date' => $appointmentDate,
            'appointment_time' => $timeFormatted,
            'duration_minutes' => $durationMinutes,
            'status' => 'scheduled',
            'is_activated_by_admin' => true,
            'activated_at' => now(),
        ]);

        // Generate a simple meeting link using the existing helper on the model if available
        if (method_exists($appointment, 'generateMeetingLink')) {
            $appointment->generateMeetingLink();
        }

        $appointment->load(['client', 'therapist']);

        return $this->successResponse(
            new AppointmentResource($appointment),
            'Appointment created successfully.',
            201
        );
    }

    /**
     * List active assessments for the app.
     */
    public function assessments(Request $request): JsonResponse
    {
        $assessments = Assessment::query()
            ->active()
            ->ordered()
            ->get();

        return $this->successResponse(
            AssessmentResource::collection($assessments)
        );
    }

    /**
     * Show a single assessment with its ordered questions.
     */
    public function assessmentShow(int $id, Request $request): JsonResponse
    {
        $assessment = Assessment::query()
            ->active()
            ->with(['questions' => function ($query) {
                $query->ordered();
            }])
            ->findOrFail($id);

        return $this->successResponse(
            new AssessmentResource($assessment)
        );
    }

    /**
     * Submit answers for an assessment and compute a simple score.
     */
    public function assessmentSubmit(int $id, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        // Only customers (clients) can submit assessments
        if (! $user->isClient()) {
            return $this->errorResponse('Only customers can submit assessments.', 403);
        }

        $assessment = Assessment::query()
            ->active()
            ->with(['questions' => function ($query) {
                $query->ordered();
            }])
            ->findOrFail($id);

        $validated = $request->validate([
            'answers' => ['required', 'array'],
        ]);

        /**
         * Accept both formats:
         * 1) answers: { "<question_id>": <answer> }
         * 2) answers: [ { "question_id": 1, "answer": ... }, ... ]
         */
        $answersInput = $validated['answers'];
        $answersByQuestionId = [];

        // If it's a list of objects, normalize it
        if (array_is_list($answersInput)) {
            foreach ($answersInput as $row) {
                if (! is_array($row)) {
                    continue;
                }
                $qid = $row['question_id'] ?? $row['id'] ?? null;
                $ans = $row['answer'] ?? $row['value'] ?? $row['answer_text'] ?? null;
                if ($qid !== null) {
                    $answersByQuestionId[(int) $qid] = $ans;
                }
            }
        } else {
            // Treat as map keyed by question id
            foreach ($answersInput as $qid => $ans) {
                if (is_numeric($qid)) {
                    $answersByQuestionId[(int) $qid] = $ans;
                }
            }
        }

        if (empty($answersByQuestionId)) {
            return $this->errorResponse('Answers payload is empty or invalid.', 422);
        }

        DB::beginTransaction();

        try {
            $userAssessment = UserAssessment::create([
                'user_id' => $user->id,
                'assessment_id' => $assessment->id,
                'status' => 'completed',
                'started_at' => now(),
                'completed_at' => now(),
            ]);

            $totalScore = 0;
            $maxScore = 0;

            foreach ($assessment->questions as $question) {
                $answerData = $answersByQuestionId[$question->id] ?? null;

                if ($answerData === null && $question->required) {
                    DB::rollBack();

                    return $this->errorResponse(
                        'Missing answer for required question: ' . $question->id,
                        422
                    );
                }

                if ($answerData === null) {
                    continue;
                }

                $answerText = is_array($answerData) ? json_encode($answerData) : (string) $answerData;
                $answerValue = null;
                $score = 0;

                if (is_numeric($answerData)) {
                    $answerValue = (int) $answerData;
                    $score = $answerValue * ($question->weight ?? 1);
                }

                UserAssessmentAnswer::create([
                    'user_assessment_id' => $userAssessment->id,
                    'question_id' => $question->id,
                    'answer_text' => $answerText,
                    'answer_value' => $answerValue,
                    'score' => $score,
                ]);

                $totalScore += $score;
                $maxScore += (int) ($question->weight ?? 1) * 5;
            }

            $percentage = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : null;

            $userAssessment->update([
                'total_score' => $totalScore,
                'max_score' => $maxScore,
                'percentage' => $percentage,
                'result_summary' => [
                    'total_score' => $totalScore,
                    'max_score' => $maxScore,
                    'percentage' => $percentage,
                ],
            ]);

            DB::commit();

            $userAssessment->load(['assessment', 'answers.question']);

            return $this->successResponse(
                new \App\Http\Resources\UserAssessmentResource($userAssessment),
                'Assessment submitted successfully.',
                201
            );
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Assessment submit failed', [
                'assessment_id' => $id,
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage(),
            ]);

            return $this->errorResponse('Failed to submit assessment.', 500);
        }
    }

    /**
     * List assessment responses for the authenticated user.
     */
    public function assessmentResponses(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        // Only customers (clients) can view their assessment history
        if (! $user->isClient()) {
            return $this->errorResponse('Only customers can view assessment history.', 403);
        }

        $query = UserAssessment::query()
            ->where('user_id', $user->id)
            ->with('assessment')
            ->orderByDesc('created_at');

        $perPage = (int) $request->get('per_page', 10);
        $responses = $query->paginate($perPage);

        return $this->successResponse([
            'items' => \App\Http\Resources\UserAssessmentResource::collection($responses),
            'pagination' => [
                'current_page' => $responses->currentPage(),
                'last_page' => $responses->lastPage(),
                'per_page' => $responses->perPage(),
                'total' => $responses->total(),
            ],
        ]);
    }

    /**
     * Show a single assessment response for the authenticated user.
     *
     * By default the {id} parameter is treated as the assessment ID,
     * and we return the latest response of the current user for that assessment.
     *
     * Optionally you can pass ?response_id=... to fetch a specific UserAssessment row instead.
     */
    public function assessmentResponseShow(int $id, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        // Only customers (clients) can view their assessment details
        if (! $user->isClient()) {
            return $this->errorResponse('Only customers can view assessment details.', 403);
        }

        $responseId = $request->query('response_id');

        $query = UserAssessment::query()
            ->where('user_id', $user->id)
            ->with(['assessment', 'answers.question']);

        if ($responseId) {
            $response = $query->whereKey($responseId)->firstOrFail();
        } else {
            // Treat route {id} as assessment_id and return the latest response for that assessment
            $response = $query
                ->where('assessment_id', $id)
                ->orderByDesc('created_at')
                ->firstOrFail();
        }

        return $this->successResponse(
            new \App\Http\Resources\UserAssessmentResource($response)
        );
    }
}

