<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\AssessmentResource;
use App\Http\Resources\TherapistResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WalletTransactionResource;
use App\Models\ApiMobileRefreshToken;
use App\Models\Appointment;
use App\Models\Assessment;
use App\Models\Review;
use App\Models\SessionNote;
use App\Models\TherapistAvailabilityBlock;
use App\Models\TherapistAward;
use App\Models\TherapistBankDetail;
use App\Models\TherapistExperience;
use App\Models\TherapistProfessionalBody;
use App\Models\TherapistProfile;
use App\Models\TherapistQualification;
use App\Models\TherapistSingleAvailability;
use App\Models\TherapistSpecialization;
use App\Models\TherapistWeeklyAvailability;
use App\Models\User;
use App\Models\UserAssessment;
use App\Models\UserAssessmentAnswer;
use App\Models\UserMood;
use App\Models\UserProfile;
use App\Models\Wallet;
use App\Services\TherapistAvailabilityService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

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

    /**
     * Create a Passport personal access token and a mobile refresh token (rotated on refresh).
     *
     * @return array{access_token: string, refresh_token: string, token_type: string}
     */
    protected function issueMobileTokenPair(User $user): array
    {
        $tokenResult = $user->createToken('api-token');
        $accessToken = $tokenResult->accessToken ?? (string) $tokenResult->token;
        $accessTokenId = $tokenResult->token->getKey();

        $plainRefresh = Str::random(64);
        ApiMobileRefreshToken::query()->create([
            'user_id' => $user->id,
            'access_token_id' => $accessTokenId,
            'token_hash' => hash('sha256', $plainRefresh),
            'expires_at' => now()->addDays(config('auth.mobile_refresh_token_expiration_days', 30)),
        ]);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $plainRefresh,
            'token_type' => 'Bearer',
        ];
    }

    /**
     * Exchange a valid refresh token for a new access + refresh token pair.
     */
    public function refreshToken(Request $request): JsonResponse
    {
        $request->validate([
            'refresh_token' => ['required', 'string'],
        ]);

        $hash = hash('sha256', $request->input('refresh_token'));
        $record = ApiMobileRefreshToken::query()
            ->where('token_hash', $hash)
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now())
            ->first();

        if (! $record) {
            return $this->errorResponse('Invalid or expired refresh token.', 401);
        }

        $user = User::query()->find($record->user_id);

        if (! $user || ! $user->isActive()) {
            return $this->errorResponse('Your account is not active.', 403);
        }

        DB::transaction(function () use ($record, $user) {
            $token = $user->tokens()->whereKey($record->access_token_id)->first();
            if ($token && (string) $token->user_id === (string) $user->id) {
                $token->revoke();
            }
            $record->forceFill(['revoked_at' => now()])->save();
        });

        $tokens = $this->issueMobileTokenPair($user);

        return $this->successResponse([
            'user' => new UserResource($user),
            'token_type' => $tokens['token_type'],
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
        ], 'Token refreshed successfully.');
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

        $tokens = $this->issueMobileTokenPair($user);

        return $this->successResponse([
            'user' => new UserResource($user),
            'token_type' => $tokens['token_type'],
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
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

        $tokens = $this->issueMobileTokenPair($user);
        $user->forceFill([
            'last_login_at' => now(),
        ])->save();

        return $this->successResponse([
            'user' => new UserResource($user),
            'token_type' => $tokens['token_type'],
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
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

        $tokens = $this->issueMobileTokenPair($user);
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
            'token_type' => $tokens['token_type'],
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
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

        $tokens = $this->issueMobileTokenPair($user);
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
            'token_type' => $tokens['token_type'],
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
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
     * Reset the authenticated user's password.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $user = $request->user();

        if (! $user) {
            return $this->errorResponse('Unauthenticated.', 401);
        }

        if (! Hash::check($request->input('current_password'), $user->password)) {
            return $this->errorResponse('Current password is incorrect.', 422);
        }

        $user->forceFill([
            'password' => $request->input('password'),
        ])->save();

        return $this->successResponse(null, 'Password reset successfully.');
    }

    /**
     * Log out the authenticated user by revoking the current token.
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user && $user->token()) {
            ApiMobileRefreshToken::query()
                ->where('access_token_id', $user->token()->id)
                ->update(['revoked_at' => now()]);
            $user->token()->revoke();
        }

        return $this->successResponse(null, 'Logged out successfully.');
    }

    /**
     * Return the currently authenticated user.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return $this->successResponse([
            'user' => new UserResource($user),
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
     * Upload avatar for authenticated user (and therapist profile image when applicable).
     */
    public function updateAvatar(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->avatar = $path;
        $user->save();

        if ($user->isTherapist()) {
            $tp = $user->therapistProfile;
            if (! $tp) {
                $tp = new TherapistProfile(['user_id' => $user->id]);
            }
            $tp->profile_image = $path;
            $tp->save();
        }

        $user->loadMissing(['profile', 'therapistProfile']);

        return $this->successResponse([
            'avatar' => $user->avatar,
            'avatar_path' => $path,
            'avatar_url' => asset('storage/'.$path),
            'therapist_profile_image' => $user->therapistProfile?->profile_image,
        ], 'Avatar updated successfully.');
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
                'gender' => $user->gender,
                'date_of_birth' => optional($user->date_of_birth)->toDateString(),
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

        $request->validate([
            // Backward-compatible flat fields
            'name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:30'],
            'gender' => ['sometimes', 'nullable', 'string', 'max:50'],
            'date_of_birth' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'bio' => ['sometimes', 'string'],
            'experience_years' => ['sometimes', 'integer', 'min:0'],
            'consultation_fee' => ['sometimes', 'numeric', 'min:0'],
            'couple_consultation_fee' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'qualification_summary' => ['sometimes', 'nullable', 'string', 'max:255'],
            'languages' => ['sometimes', 'array'],
            'languages.*' => ['string', 'max:50'],
            'areas_of_expertise' => ['sometimes', 'array'],
            'areas_of_expertise.*' => ['string', 'max:255'],
            'certifications' => ['sometimes', 'nullable'],
            'education' => ['sometimes', 'nullable'],
            'specializations' => ['sometimes', 'array'],
            'specializations.*' => ['integer', 'exists:therapist_specializations,id'],

            // therapistSelfProfile-compatible payload
            'basic' => ['sometimes', 'array'],
            'basic.name' => ['sometimes', 'string', 'max:255'],
            'basic.phone' => ['sometimes', 'nullable', 'string', 'max:30'],
            'profile' => ['sometimes', 'array'],
            'profile.prefix' => ['sometimes', 'nullable', 'string', 'max:20'],
            'profile.first_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.middle_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.last_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.category' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.user_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.gender' => ['sometimes', 'nullable', 'in:male,female,other,prefer_not_to_say'],
            'profile.date_of_birth' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'profile.qualification_summary' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.experience_years' => ['sometimes', 'integer', 'min:0'],
            'profile.timezone' => ['sometimes', 'nullable', 'string', 'max:100'],
            'profile.consultation_fee' => ['sometimes', 'numeric', 'min:0'],
            'profile.couple_consultation_fee' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'profile.bio' => ['sometimes', 'nullable', 'string'],
            'profile.languages' => ['sometimes', 'array'],
            'profile.languages.*' => ['string', 'max:50'],
            'profile.brief_description' => ['sometimes', 'nullable', 'string'],
            'profile.areas_of_expertise' => ['sometimes', 'array'],
            'profile.areas_of_expertise.*' => ['string', 'max:255'],
            'profile.profile_image' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.certifications' => ['sometimes', 'nullable'],
            'profile.education' => ['sometimes', 'nullable'],
            'profile.specializations' => ['sometimes', 'array'],
            'profile.specializations.*' => ['integer', 'exists:therapist_specializations,id'],
            'profile.present_address' => ['sometimes', 'array'],
            'profile.present_address.address' => ['sometimes', 'nullable', 'string', 'max:500'],
            'profile.present_address.country' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.present_address.state' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.present_address.city' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.present_address.district' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.present_address.zip_code' => ['sometimes', 'nullable', 'string', 'max:20'],
            'profile.clinic_address' => ['sometimes', 'array'],
            'profile.clinic_address.same_as_present_address' => ['sometimes', 'boolean'],
            'profile.clinic_address.address' => ['sometimes', 'nullable', 'string', 'max:500'],
            'profile.clinic_address.country' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.clinic_address.state' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.clinic_address.city' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.clinic_address.district' => ['sometimes', 'nullable', 'string', 'max:255'],
            'profile.clinic_address.zip_code' => ['sometimes', 'nullable', 'string', 'max:20'],

            // Full profile collections (same sections as therapistSelfProfile response)
            'experiences' => ['sometimes', 'array'],
            'experiences.*.id' => ['sometimes', 'integer'],
            'experiences.*.designation' => ['required_with:experiences', 'nullable', 'string', 'max:255'],
            'experiences.*.hospital_organisation' => ['required_with:experiences', 'nullable', 'string', 'max:255'],
            'experiences.*.starting_date' => ['required_with:experiences', 'nullable', 'date'],
            'experiences.*.last_date' => ['nullable', 'date'],
            'experiences.*.document' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],

            'qualifications' => ['sometimes', 'array'],
            'qualifications.*.id' => ['sometimes', 'integer'],
            'qualifications.*.name_of_degree' => ['required_with:qualifications', 'nullable', 'string', 'max:255'],
            'qualifications.*.degree_in' => ['required_with:qualifications', 'nullable', 'string', 'max:255'],
            'qualifications.*.institute_university' => ['required_with:qualifications', 'nullable', 'string', 'max:255'],
            'qualifications.*.year_of_passing' => ['nullable', 'string', 'max:10'],
            'qualifications.*.percentage_cgpa' => ['nullable', 'string', 'max:50'],
            'qualifications.*.certificate' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],

            'awards' => ['sometimes', 'array'],
            'awards.*.id' => ['sometimes', 'integer'],
            'awards.*.award_name' => ['required_with:awards', 'nullable', 'string', 'max:255'],
            'awards.*.awarded_by' => ['required_with:awards', 'nullable', 'string', 'max:255'],
            'awards.*.year' => ['nullable', 'string', 'max:10'],
            'awards.*.description' => ['nullable', 'string'],
            'awards.*.document' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],

            'professional_bodies' => ['sometimes', 'array'],
            'professional_bodies.*.id' => ['sometimes', 'integer'],
            'professional_bodies.*.body_name' => ['required_with:professional_bodies', 'nullable', 'string', 'max:255'],
            'professional_bodies.*.membership_number' => ['nullable', 'string', 'max:255'],
            'professional_bodies.*.membership_type' => ['nullable', 'string', 'max:255'],
            'professional_bodies.*.year_joined' => ['nullable', 'string', 'max:10'],
            'professional_bodies.*.document' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],

            'bank_details' => ['sometimes', 'array'],
            'bank_details.*.id' => ['sometimes', 'integer'],
            'bank_details.*.account_holder_name' => ['required_with:bank_details', 'nullable', 'string', 'max:255'],
            'bank_details.*.account_number' => ['required_with:bank_details', 'nullable', 'string', 'max:255'],
            'bank_details.*.bank_name' => ['required_with:bank_details', 'nullable', 'string', 'max:255'],
            'bank_details.*.ifsc_code' => ['nullable', 'string', 'max:255'],
            'bank_details.*.branch_name' => ['nullable', 'string', 'max:255'],
            'bank_details.*.account_type' => ['nullable', 'string', 'max:100'],
        ]);

        $basic = (array) $request->input('basic', []);
        $profileInput = (array) $request->input('profile', []);
        $normalizeTextOrArray = static function ($value): ?string {
            if (is_array($value)) {
                $parts = array_values(array_filter(array_map(static fn ($item) => is_scalar($item) ? trim((string) $item) : '', $value)));

                return empty($parts) ? null : implode(', ', $parts);
            }
            if (is_null($value)) {
                return null;
            }

            return trim((string) $value);
        };

        // Update basic user fields
        $user->fill([
            'name' => $basic['name'] ?? $request->input('name', $user->name),
            'phone' => array_key_exists('phone', $basic)
                ? $basic['phone']
                : $request->input('phone', $user->phone),
            'gender' => $request->exists('profile.gender')
                ? ($profileInput['gender'] ?? null)
                : ($request->exists('gender') ? $request->input('gender') : $user->gender),
            'date_of_birth' => $request->exists('profile.date_of_birth')
                ? ($profileInput['date_of_birth'] ?? null)
                : ($request->exists('date_of_birth') ? $request->input('date_of_birth') : $user->date_of_birth),
        ]);
        $user->save();

        // Ensure therapist profile exists
        $tp = $user->therapistProfile;
        if (! $tp) {
            $tp = new TherapistProfile(['user_id' => $user->id]);
        }

        $presentAddress = (array) ($profileInput['present_address'] ?? []);
        $clinicAddress = (array) ($profileInput['clinic_address'] ?? []);

        $tp->fill([
            'prefix' => $profileInput['prefix'] ?? $tp->prefix,
            'first_name' => $profileInput['first_name'] ?? $tp->first_name,
            'middle_name' => $profileInput['middle_name'] ?? $tp->middle_name,
            'last_name' => $profileInput['last_name'] ?? $tp->last_name,
            'category' => $profileInput['category'] ?? $tp->category,
            'user_name' => $profileInput['user_name'] ?? $tp->user_name,
            'timezone' => $profileInput['timezone'] ?? $tp->timezone,
            'brief_description' => $profileInput['brief_description'] ?? $tp->brief_description,
            'profile_image' => $profileInput['profile_image'] ?? $tp->profile_image,
            'bio' => $profileInput['bio'] ?? $request->input('bio', $tp->bio),
            'experience_years' => $profileInput['experience_years'] ?? $request->input('experience_years', $tp->experience_years),
            'consultation_fee' => $profileInput['consultation_fee'] ?? $request->input('consultation_fee', $tp->consultation_fee),
            'couple_consultation_fee' => $profileInput['couple_consultation_fee'] ?? $request->input('couple_consultation_fee', $tp->couple_consultation_fee),
            'qualification' => $profileInput['qualification_summary'] ?? $request->input('qualification_summary', $tp->qualification),
            'languages' => array_key_exists('languages', $profileInput)
                ? $profileInput['languages']
                : ($request->has('languages') ? $request->input('languages') : $tp->languages),
            'areas_of_expertise' => array_key_exists('areas_of_expertise', $profileInput)
                ? $profileInput['areas_of_expertise']
                : ($request->has('areas_of_expertise') ? $request->input('areas_of_expertise') : $tp->areas_of_expertise),
            'certifications' => $normalizeTextOrArray(
                array_key_exists('certifications', $profileInput)
                    ? $profileInput['certifications']
                    : $request->input('certifications', $tp->certifications)
            ),
            'education' => $normalizeTextOrArray(
                array_key_exists('education', $profileInput)
                    ? $profileInput['education']
                    : $request->input('education', $tp->education)
            ),
            'present_address' => $presentAddress['address'] ?? $tp->present_address,
            'present_country' => $presentAddress['country'] ?? $tp->present_country,
            'present_state' => $presentAddress['state'] ?? $tp->present_state,
            'present_city' => $presentAddress['city'] ?? $tp->present_city,
            'present_district' => $presentAddress['district'] ?? $tp->present_district,
            'present_zip' => $presentAddress['zip_code'] ?? $tp->present_zip,
            'same_as_present_address' => array_key_exists('same_as_present_address', $clinicAddress)
                ? (bool) $clinicAddress['same_as_present_address']
                : $tp->same_as_present_address,
            'clinic_address' => $clinicAddress['address'] ?? $tp->clinic_address,
            'clinic_country' => $clinicAddress['country'] ?? $tp->clinic_country,
            'clinic_state' => $clinicAddress['state'] ?? $tp->clinic_state,
            'clinic_city' => $clinicAddress['city'] ?? $tp->clinic_city,
            'clinic_district' => $clinicAddress['district'] ?? $tp->clinic_district,
            'clinic_zip' => $clinicAddress['zip_code'] ?? $tp->clinic_zip,
        ]);
        $tp->save();

        // Keep user profile name fields in sync with therapistSelfProfile response structure.
        $userProfileUpdates = [];

        if (array_key_exists('first_name', $profileInput)) {
            $userProfileUpdates['first_name'] = $profileInput['first_name'];
        }
        if (array_key_exists('last_name', $profileInput)) {
            $userProfileUpdates['last_name'] = $profileInput['last_name'];
        }

        if (! empty($userProfileUpdates)) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $userProfileUpdates
            );
        }

        // Sync specializations if provided
        if (array_key_exists('specializations', $profileInput)) {
            $tp->specializations()->sync($profileInput['specializations'] ?? []);
        } elseif ($request->has('specializations')) {
            $tp->specializations()->sync($request->input('specializations', []));
        }

        if ($request->has('experiences')) {
            $keepIds = [];
            foreach ((array) $request->input('experiences', []) as $index => $item) {
                $existingExperience = null;
                if (! empty($item['id'])) {
                    $existingExperience = TherapistExperience::query()
                        ->where('therapist_profile_id', $tp->id)
                        ->find($item['id']);
                }

                $experienceDocumentPath = $item['document'] ?? ($existingExperience?->document);
                if ($request->hasFile("experiences.$index.document")) {
                    if ($existingExperience?->document) {
                        Storage::disk('public')->delete($existingExperience->document);
                    }
                    $experienceDocumentPath = $request->file("experiences.$index.document")
                        ->store('therapist-experiences', 'public');
                }

                $experience = TherapistExperience::updateOrCreate(
                    [
                        'id' => $item['id'] ?? null,
                        'therapist_profile_id' => $tp->id,
                    ],
                    [
                        'designation' => $item['designation'] ?? null,
                        'hospital_organisation' => $item['hospital_organisation'] ?? null,
                        'starting_date' => $item['starting_date'] ?? null,
                        'last_date' => $item['last_date'] ?? null,
                        'document' => $experienceDocumentPath,
                    ]
                );
                $keepIds[] = $experience->id;
            }
            TherapistExperience::where('therapist_profile_id', $tp->id)
                ->whereNotIn('id', $keepIds)
                ->delete();
        }

        if ($request->has('qualifications')) {
            $keepIds = [];
            foreach ((array) $request->input('qualifications', []) as $index => $item) {
                $existingQualification = null;
                if (! empty($item['id'])) {
                    $existingQualification = TherapistQualification::query()
                        ->where('therapist_profile_id', $tp->id)
                        ->find($item['id']);
                }

                $qualificationCertificatePath = $item['certificate'] ?? ($existingQualification?->certificate);
                if ($request->hasFile("qualifications.$index.certificate")) {
                    if ($existingQualification?->certificate) {
                        Storage::disk('public')->delete($existingQualification->certificate);
                    }
                    $qualificationCertificatePath = $request->file("qualifications.$index.certificate")
                        ->store('therapist-qualifications', 'public');
                }

                $qualification = TherapistQualification::updateOrCreate(
                    [
                        'id' => $item['id'] ?? null,
                        'therapist_profile_id' => $tp->id,
                    ],
                    [
                        'name_of_degree' => $item['name_of_degree'] ?? null,
                        'degree_in' => $item['degree_in'] ?? null,
                        'institute_university' => $item['institute_university'] ?? null,
                        'year_of_passing' => $item['year_of_passing'] ?? null,
                        'percentage_cgpa' => $item['percentage_cgpa'] ?? null,
                        'certificate' => $qualificationCertificatePath,
                    ]
                );
                $keepIds[] = $qualification->id;
            }
            TherapistQualification::where('therapist_profile_id', $tp->id)
                ->whereNotIn('id', $keepIds)
                ->delete();
        }

        if ($request->has('awards')) {
            $keepIds = [];
            foreach ((array) $request->input('awards', []) as $index => $item) {
                $existingAward = null;
                if (! empty($item['id'])) {
                    $existingAward = TherapistAward::query()
                        ->where('therapist_profile_id', $tp->id)
                        ->find($item['id']);
                }

                $awardDocumentPath = $item['document'] ?? ($existingAward?->document);
                if ($request->hasFile("awards.$index.document")) {
                    if ($existingAward?->document) {
                        Storage::disk('public')->delete($existingAward->document);
                    }
                    $awardDocumentPath = $request->file("awards.$index.document")
                        ->store('therapist-awards', 'public');
                }

                $award = TherapistAward::updateOrCreate(
                    [
                        'id' => $item['id'] ?? null,
                        'therapist_profile_id' => $tp->id,
                    ],
                    [
                        'award_name' => $item['award_name'] ?? null,
                        'awarded_by' => $item['awarded_by'] ?? null,
                        'year' => $item['year'] ?? null,
                        'description' => $item['description'] ?? null,
                        'document' => $awardDocumentPath,
                    ]
                );
                $keepIds[] = $award->id;
            }
            TherapistAward::where('therapist_profile_id', $tp->id)
                ->whereNotIn('id', $keepIds)
                ->delete();
        }

        if ($request->has('professional_bodies')) {
            $keepIds = [];
            foreach ((array) $request->input('professional_bodies', []) as $index => $item) {
                $existingBody = null;
                if (! empty($item['id'])) {
                    $existingBody = TherapistProfessionalBody::query()
                        ->where('therapist_profile_id', $tp->id)
                        ->find($item['id']);
                }

                $bodyDocumentPath = $item['document'] ?? ($existingBody?->document);
                if ($request->hasFile("professional_bodies.$index.document")) {
                    if ($existingBody?->document) {
                        Storage::disk('public')->delete($existingBody->document);
                    }
                    $bodyDocumentPath = $request->file("professional_bodies.$index.document")
                        ->store('therapist-professional-bodies', 'public');
                }

                $body = TherapistProfessionalBody::updateOrCreate(
                    [
                        'id' => $item['id'] ?? null,
                        'therapist_profile_id' => $tp->id,
                    ],
                    [
                        'body_name' => $item['body_name'] ?? null,
                        'membership_number' => $item['membership_number'] ?? null,
                        'membership_type' => $item['membership_type'] ?? null,
                        'year_joined' => $item['year_joined'] ?? null,
                        'document' => $bodyDocumentPath,
                    ]
                );
                $keepIds[] = $body->id;
            }
            TherapistProfessionalBody::where('therapist_profile_id', $tp->id)
                ->whereNotIn('id', $keepIds)
                ->delete();
        }

        if ($request->has('bank_details')) {
            $keepIds = [];
            foreach ((array) $request->input('bank_details', []) as $item) {
                $bankDetail = TherapistBankDetail::updateOrCreate(
                    [
                        'id' => $item['id'] ?? null,
                        'therapist_profile_id' => $tp->id,
                    ],
                    [
                        'account_holder_name' => $item['account_holder_name'] ?? null,
                        'account_number' => $item['account_number'] ?? null,
                        'bank_name' => $item['bank_name'] ?? null,
                        'ifsc_code' => $item['ifsc_code'] ?? null,
                        'branch_name' => $item['branch_name'] ?? null,
                        'account_type' => $item['account_type'] ?? null,
                    ]
                );
                $keepIds[] = $bankDetail->id;
            }
            TherapistBankDetail::where('therapist_profile_id', $tp->id)
                ->whereNotIn('id', $keepIds)
                ->delete();
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
                'gender' => $user->gender,
                'date_of_birth' => optional($user->date_of_birth)->toDateString(),
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

        $service = new TherapistAvailabilityService;
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
     * Get authenticated therapist weekly/single/block availability.
     */
    public function therapistOwnAvailability(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can access availability.', 403);
        }

        $weekly = TherapistWeeklyAvailability::where('therapist_id', $user->id)
            ->latest()
            ->get(['id', 'days', 'slots', 'mode', 'type', 'timezone', 'created_at', 'updated_at']);

        $single = TherapistSingleAvailability::where('therapist_id', $user->id)
            ->orderByDesc('date')
            ->get(['id', 'date', 'slots', 'mode', 'type', 'timezone', 'created_at', 'updated_at']);

        $blocks = TherapistAvailabilityBlock::where('therapist_id', $user->id)
            ->where('is_active', true)
            ->latest()
            ->get(['id', 'start_date', 'end_date', 'date', 'blocked_slots', 'reason', 'is_active', 'created_at', 'updated_at']);

        return $this->successResponse([
            'weekly' => $weekly,
            'single_day' => $single,
            'blocked' => $blocks,
        ]);
    }

    private function validateWeeklyAvailabilityPayload(Request $request): array
    {
        $validated = $request->validate([
            'days' => ['required', 'array', 'min:1'],
            'slots' => ['required', 'array', 'min:1', 'max:4'],
            'slots.*.start' => ['required', 'date_format:H:i'],
            'slots.*.end' => ['required', 'date_format:H:i'],
            'mode' => ['required', 'in:online,offline'],
            'type' => ['required', 'in:repeat,once'],
            'timezone' => ['nullable', 'string'],
        ]);

        foreach ($validated['slots'] as $slot) {
            if (strtotime($slot['end']) <= strtotime($slot['start'])) {
                throw ValidationException::withMessages([
                    'slots' => ['Each slot end time must be after start time.'],
                ]);
            }
        }

        return $validated;
    }

    private function validateBlockAvailabilityPayload(Request $request): array
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date', 'required_without:date'],
            'end_date' => ['nullable', 'date', 'required_with:start_date', 'after_or_equal:start_date'],
            'date' => ['nullable', 'date', 'required_without:start_date'],
            'blocked_slots' => ['nullable', 'array', 'max:4'],
            'blocked_slots.*.start' => ['required_with:blocked_slots', 'date_format:H:i'],
            'blocked_slots.*.end' => ['required_with:blocked_slots', 'date_format:H:i'],
            'reason' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (! empty($validated['blocked_slots'])) {
            foreach ($validated['blocked_slots'] as $slot) {
                if (strtotime($slot['end']) <= strtotime($slot['start'])) {
                    throw ValidationException::withMessages([
                        'blocked_slots' => ['Each blocked slot end time must be after start time.'],
                    ]);
                }
            }
        }

        return $validated;
    }

    /**
     * Create authenticated therapist weekly availability.
     */
    public function createTherapistWeeklyAvailability(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can create weekly availability.', 403);
        }

        $validated = $this->validateWeeklyAvailabilityPayload($request);

        $availability = TherapistWeeklyAvailability::create([
            'therapist_id' => $user->id,
            'days' => $validated['days'],
            'slots' => array_values($validated['slots']),
            'mode' => $validated['mode'],
            'type' => $validated['type'],
            'timezone' => $validated['timezone'] ?? null,
        ]);

        return $this->successResponse($availability, 'Weekly availability created successfully.', 201);
    }

    /**
     * Update authenticated therapist weekly availability.
     */
    public function updateTherapistWeeklyAvailability(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can update weekly availability.', 403);
        }

        $validated = $this->validateWeeklyAvailabilityPayload($request);
        $request->validate(['id' => ['required', 'integer']]);

        $availability = TherapistWeeklyAvailability::where('therapist_id', $user->id)
            ->where('id', (int) $request->input('id'))
            ->first();

        if (! $availability) {
            return $this->errorResponse('Weekly availability not found.', 404);
        }

        $availability->update([
            'days' => $validated['days'],
            'slots' => array_values($validated['slots']),
            'mode' => $validated['mode'],
            'type' => $validated['type'],
            'timezone' => $validated['timezone'] ?? null,
        ]);

        return $this->successResponse($availability, 'Weekly availability updated successfully.');
    }

    /**
     * Create authenticated therapist single-day availability.
     */
    public function createTherapistSingleAvailability(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can create single-day availability.', 403);
        }

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'slots' => ['required', 'array', 'min:1', 'max:4'],
            'slots.*.start' => ['required', 'date_format:H:i'],
            'slots.*.end' => ['required', 'date_format:H:i'],
            'mode' => ['required', 'in:online,offline'],
            'timezone' => ['nullable', 'string'],
        ]);

        foreach ($validated['slots'] as $slot) {
            if (strtotime($slot['end']) <= strtotime($slot['start'])) {
                return $this->errorResponse('Each slot end time must be after start time.', 422);
            }
        }

        $availability = TherapistSingleAvailability::create([
            'therapist_id' => $user->id,
            'date' => $validated['date'],
            'slots' => array_values($validated['slots']),
            'mode' => $validated['mode'],
            'type' => 'once',
            'timezone' => $validated['timezone'] ?? null,
        ]);

        return $this->successResponse($availability, 'Single-day availability created successfully.', 201);
    }

    /**
     * Update authenticated therapist single-day availability.
     */
    public function updateTherapistSingleAvailability(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can update single-day availability.', 403);
        }

        $validated = $request->validate([
            'id' => ['required', 'integer'],
            'date' => ['required', 'date'],
            'slots' => ['required', 'array', 'min:1', 'max:4'],
            'slots.*.start' => ['required', 'date_format:H:i'],
            'slots.*.end' => ['required', 'date_format:H:i'],
            'mode' => ['required', 'in:online,offline'],
            'timezone' => ['nullable', 'string'],
        ]);

        foreach ($validated['slots'] as $slot) {
            if (strtotime($slot['end']) <= strtotime($slot['start'])) {
                return $this->errorResponse('Each slot end time must be after start time.', 422);
            }
        }

        $availability = TherapistSingleAvailability::where('therapist_id', $user->id)
            ->where('id', $validated['id'])
            ->first();

        if (! $availability) {
            return $this->errorResponse('Single-day availability not found.', 404);
        }

        $availability->update([
            'date' => $validated['date'],
            'slots' => array_values($validated['slots']),
            'mode' => $validated['mode'],
            'type' => 'once',
            'timezone' => $validated['timezone'] ?? null,
        ]);

        return $this->successResponse($availability, 'Single-day availability updated successfully.');
    }

    /**
     * Create authenticated therapist blocked availability by day/date-range.
     */
    public function createTherapistAvailabilityBlock(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can create blocked availability.', 403);
        }

        $validated = $this->validateBlockAvailabilityPayload($request);

        $block = TherapistAvailabilityBlock::create([
            'therapist_id' => $user->id,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'date' => $validated['date'] ?? null,
            'blocked_slots' => $validated['blocked_slots'] ?? null,
            'reason' => $validated['reason'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return $this->successResponse($block, 'Blocked availability created successfully.', 201);
    }

    /**
     * Update authenticated therapist blocked availability by id.
     */
    public function updateTherapistAvailabilityBlock(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can update blocked availability.', 403);
        }

        $request->validate(['id' => ['required', 'integer']]);
        $validated = $this->validateBlockAvailabilityPayload($request);

        $block = TherapistAvailabilityBlock::where('therapist_id', $user->id)
            ->where('id', (int) $request->input('id'))
            ->first();

        if (! $block) {
            return $this->errorResponse('Blocked availability not found.', 404);
        }

        $block->update([
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'date' => $validated['date'] ?? null,
            'blocked_slots' => $validated['blocked_slots'] ?? null,
            'reason' => $validated['reason'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return $this->successResponse($block, 'Blocked availability updated successfully.');
    }

    /**
     * Delete authenticated therapist weekly availability by id.
     */
    public function deleteTherapistWeeklyAvailability(int $id, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can delete weekly availability.', 403);
        }

        $availability = TherapistWeeklyAvailability::where('therapist_id', $user->id)
            ->where('id', $id)
            ->first();

        if (! $availability) {
            return $this->errorResponse('Weekly availability not found.', 404);
        }

        $availability->delete();

        return $this->successResponse(null, 'Weekly availability deleted successfully.');
    }

    /**
     * Delete authenticated therapist single-day availability by id.
     */
    public function deleteTherapistSingleAvailability(int $id, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can delete single-day availability.', 403);
        }

        $availability = TherapistSingleAvailability::where('therapist_id', $user->id)
            ->where('id', $id)
            ->first();

        if (! $availability) {
            return $this->errorResponse('Single-day availability not found.', 404);
        }

        $availability->delete();

        return $this->successResponse(null, 'Single-day availability deleted successfully.');
    }

    /**
     * Delete authenticated therapist blocked availability by id.
     */
    public function deleteTherapistAvailabilityBlock(int $id, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can delete blocked availability.', 403);
        }

        $block = TherapistAvailabilityBlock::where('therapist_id', $user->id)
            ->where('id', $id)
            ->first();

        if (! $block) {
            return $this->errorResponse('Blocked availability not found.', 404);
        }

        $block->delete();

        return $this->successResponse(null, 'Blocked availability deleted successfully.');
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
     * List therapist sessions with minimal payload for creating session notes.
     */
    public function therapistSessionsForNotes(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can access sessions.', 403);
        }

        $validated = $request->validate([
            'status' => ['nullable', 'in:scheduled,confirmed,in_progress,completed,cancelled,no_show'],
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date'],
            'search' => ['nullable', 'string', 'max:255'],
            'has_note' => ['nullable', 'boolean'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $query = Appointment::query()
            ->where('therapist_id', $user->id)
            ->with(['client:id,name'])
            ->withCount('sessionNote')
            ->select([
                'id',
                'client_id',
                'appointment_date',
                'appointment_time',
                'session_mode',
                'status',
            ]);

        if (! empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (! empty($validated['from_date'])) {
            $query->whereDate('appointment_date', '>=', $validated['from_date']);
        }

        if (! empty($validated['to_date'])) {
            $query->whereDate('appointment_date', '<=', $validated['to_date']);
        }

        if (! empty($validated['search'])) {
            $search = trim((string) $validated['search']);
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%');
            });
        }

        if (array_key_exists('has_note', $validated)) {
            if ((bool) $validated['has_note']) {
                $query->whereHas('sessionNote');
            } else {
                $query->whereDoesntHave('sessionNote');
            }
        }

        $perPage = (int) ($validated['per_page'] ?? 10);
        $sessions = $query
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->paginate($perPage);

        $items = $sessions->map(function (Appointment $appointment) {
            return [
                'appointment_id' => $appointment->id,
                'client_id' => $appointment->client_id,
                'client_name' => $appointment->client?->name,
                'session_date' => optional($appointment->appointment_date)->toDateString(),
                'session_time' => is_string($appointment->appointment_time)
                    ? $appointment->appointment_time
                    : optional($appointment->appointment_time)->format('H:i:s'),
                'session_mode' => $appointment->session_mode,
                'status' => $appointment->status,
                'has_note' => (bool) ($appointment->session_note_count ?? 0),
            ];
        });

        return $this->successResponse([
            'items' => $items,
            'pagination' => [
                'current_page' => $sessions->currentPage(),
                'last_page' => $sessions->lastPage(),
                'per_page' => $sessions->perPage(),
                'total' => $sessions->total(),
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
     * List session notes by appointment/session id for authenticated therapist.
     */
    public function showTherapistSessionNoteBySession(int $appointmentId, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can view session notes.', 403);
        }

        $notes = SessionNote::where('therapist_id', $user->id)
            ->where('appointment_id', $appointmentId)
            ->with(['client', 'appointment'])
            ->orderByDesc('id')
            ->get();

        if ($notes->isEmpty()) {
            return $this->errorResponse('Session note not found for this session.', 404);
        }

        return $this->successResponse([
            'items' => $notes,
            'count' => $notes->count(),
        ]);
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
     * List appointments for the authenticated user (legacy).
     * Prefer GET /client/appointments or GET /therapist/appointments for a clear contract.
     */
    public function appointments(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->isClient()) {
            return $this->clientAppointments($request);
        }

        if ($user->isTherapist()) {
            return $this->therapistAppointments($request);
        }

        return $this->errorResponse('Only clients or therapists can list appointments.', 403);
    }

    /**
     * List appointments for the authenticated client (bookings as client).
     */
    public function clientAppointments(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isClient()) {
            return $this->errorResponse('Only clients can access client appointments.', 403);
        }

        return $this->paginateAppointmentsForUser(
            $request,
            Appointment::query()
                ->where('client_id', $user->id)
                ->with(['therapist'])
        );
    }

    /**
     * List appointments for the authenticated therapist (sessions as therapist).
     */
    public function therapistAppointments(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can access therapist appointments.', 403);
        }

        return $this->paginateAppointmentsForUser(
            $request,
            Appointment::query()
                ->where('therapist_id', $user->id)
                ->with(['client'])
        );
    }

    /**
     * Single appointment for the authenticated client (must be the booking owner).
     */
    public function clientAppointmentShow(int $id, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isClient()) {
            return $this->errorResponse('Only clients can access client appointment details.', 403);
        }

        $appointment = Appointment::query()
            ->whereKey($id)
            ->where('client_id', $user->id)
            ->with(['therapist'])
            ->first();

        if (! $appointment) {
            return $this->errorResponse('Appointment not found.', 404);
        }

        return $this->successResponse(new AppointmentResource($appointment));
    }

    /**
     * Single appointment for the authenticated therapist (must be assigned therapist).
     */
    public function therapistAppointmentShow(int $id, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can access therapist appointment details.', 403);
        }

        $appointment = Appointment::query()
            ->whereKey($id)
            ->where('therapist_id', $user->id)
            ->with(['client'])
            ->first();

        if (! $appointment) {
            return $this->errorResponse('Appointment not found.', 404);
        }

        return $this->successResponse(new AppointmentResource($appointment));
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<Appointment>  $query
     */
    private function paginateAppointmentsForUser(Request $request, $query): JsonResponse
    {
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
     * Upcoming appointments for the authenticated client (today through the next N calendar days, N = 1–3).
     */
    public function clientUpcomingAppointments(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isClient()) {
            return $this->errorResponse('Only clients can access upcoming client appointments.', 403);
        }

        return $this->upcomingAppointmentsInWindow(
            $request,
            Appointment::query()->where('client_id', $user->id),
            ['therapist']
        );
    }

    /**
     * Upcoming appointments for the authenticated therapist (today through the next N calendar days, N = 1–3).
     */
    public function therapistUpcomingAppointments(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can access upcoming therapist appointments.', 403);
        }

        return $this->upcomingAppointmentsInWindow(
            $request,
            Appointment::query()->where('therapist_id', $user->id),
            ['client']
        );
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<Appointment>  $query
     * @param  array<int, string>  $with
     */
    private function upcomingAppointmentsInWindow(Request $request, $query, array $with): JsonResponse
    {
        $validated = $request->validate([
            'days' => ['sometimes', 'integer', 'min:1', 'max:3'],
        ]);

        $dayCount = (int) ($validated['days'] ?? 3);
        $from = Carbon::today()->startOfDay();
        $toDate = Carbon::today()->addDays($dayCount - 1)->toDateString();
        $fromDate = $from->toDateString();

        $query->with($with)
            ->whereDate('appointment_date', '>=', $fromDate)
            ->whereDate('appointment_date', '<=', $toDate)
            ->whereIn('status', ['scheduled', 'confirmed', 'in_progress'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc');

        $appointments = $query->get();

        return $this->successResponse([
            'items' => AppointmentResource::collection($appointments),
            'window' => [
                'days' => $dayCount,
                'from_date' => $fromDate,
                'to_date' => $toDate,
            ],
            'has_appointments' => $appointments->isNotEmpty(),
            'count' => $appointments->count(),
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
            ? $appointmentTimeInput.':00'
            : $appointmentTimeInput;

        $durationMinutes = (int) $validated['duration_minutes'];

        $slotStart = Carbon::parse($appointmentDate.' '.$timeFormatted);
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

            $existingStart = Carbon::parse($appointmentDate.' '.$existingTime);
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

        $appointment->load(['client']);

        return $this->successResponse(
            new AppointmentResource($appointment),
            'Appointment created successfully.',
            201
        );
    }

    /**
     * Client submits a review for the therapist tied to a completed appointment.
     */
    public function storeClientReview(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isClient()) {
            return $this->errorResponse('Only clients can submit reviews.', 403);
        }

        $validated = $request->validate([
            'appointment_id' => ['required', 'integer', 'exists:appointments,id'],
            'therapist_id' => ['sometimes', 'integer', 'exists:users,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:2000'],
            'is_public' => ['sometimes', 'boolean'],
        ]);

        $appointment = Appointment::with('therapist.therapistProfile')->findOrFail($validated['appointment_id']);

        if ((int) $appointment->client_id !== (int) $user->id) {
            return $this->errorResponse('You are not allowed to review this appointment.', 403);
        }

        if ($appointment->status !== 'completed') {
            return $this->errorResponse('You can only review completed sessions.', 422);
        }

        if (! empty($validated['therapist_id'])
            && (int) $validated['therapist_id'] !== (int) $appointment->therapist_id) {
            return $this->errorResponse('Therapist does not match this appointment.', 422);
        }

        if (Review::where('client_id', $user->id)->where('appointment_id', $appointment->id)->exists()) {
            return $this->errorResponse('You have already reviewed this session.', 422);
        }

        $review = Review::create([
            'client_id' => $user->id,
            'therapist_id' => $appointment->therapist_id,
            'appointment_id' => $appointment->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'is_verified' => false,
            'is_public' => $request->boolean('is_public'),
        ]);

        if ($appointment->therapist && $appointment->therapist->therapistProfile) {
            $appointment->therapist->therapistProfile->updateRating();
        }

        return $this->successResponse([
            'id' => $review->id,
            'appointment_id' => $review->appointment_id,
            'therapist_id' => $review->therapist_id,
            'rating' => $review->rating,
            'comment' => $review->comment,
            'is_verified' => $review->is_verified,
            'is_public' => $review->is_public,
            'created_at' => optional($review->created_at)->toDateTimeString(),
        ], 'Review submitted successfully. It may require verification before publication.', 201);
    }

    /**
     * Therapist lists reviews received from clients.
     */
    public function therapistReviews(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isTherapist()) {
            return $this->errorResponse('Only therapists can view therapist reviews.', 403);
        }

        $request->validate([
            'search' => ['sometimes', 'string', 'max:255'],
            'rating' => ['sometimes', 'integer', 'min:1', 'max:5'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:50'],
        ]);

        $search = $request->get('search');
        $rating = $request->get('rating');

        $query = Review::where('therapist_id', $user->id)
            ->with([
                'client:id,name,email,phone',
                'appointment:id,appointment_date,appointment_time,status,session_mode',
            ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('comment', 'like', '%'.$search.'%')
                    ->orWhereHas('client', function ($clientQuery) use ($search) {
                        $clientQuery->where('name', 'like', '%'.$search.'%')
                            ->orWhere('email', 'like', '%'.$search.'%');
                    });
            });
        }

        if ($rating !== null && $rating !== '') {
            $query->where('rating', (int) $rating);
        }

        $perPage = (int) $request->get('per_page', 10);
        $reviews = $query->orderByDesc('created_at')->paginate($perPage);

        $therapistId = $user->id;
        $totalReviews = Review::where('therapist_id', $therapistId)->count();
        $averageRating = round((float) (Review::where('therapist_id', $therapistId)->avg('rating') ?? 0), 2);
        $ratingDistribution = Review::where('therapist_id', $therapistId)
            ->selectRaw('rating, count(*) as c')
            ->groupBy('rating')
            ->pluck('c', 'rating')
            ->toArray();

        $items = $reviews->getCollection()->map(function (Review $review) {
            return [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'is_verified' => $review->is_verified,
                'is_public' => $review->is_public,
                'created_at' => optional($review->created_at)->toDateTimeString(),
                'client' => $review->client ? [
                    'id' => $review->client->id,
                    'name' => $review->client->name,
                    'email' => $review->client->email,
                    'phone' => $review->client->phone,
                ] : null,
                'appointment' => $review->appointment ? [
                    'id' => $review->appointment->id,
                    'appointment_date' => optional($review->appointment->appointment_date)->toDateString(),
                    'appointment_time' => (string) $review->appointment->appointment_time,
                    'status' => $review->appointment->status,
                    'session_mode' => $review->appointment->session_mode,
                ] : null,
            ];
        })->values();

        return $this->successResponse([
            'items' => $items,
            'pagination' => [
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
                'per_page' => $reviews->perPage(),
                'total' => $reviews->total(),
            ],
            'stats' => [
                'total_reviews' => $totalReviews,
                'average_rating' => $averageRating,
                'rating_distribution' => $ratingDistribution,
            ],
        ]);
    }

    /**
     * Client lists reviews they have submitted.
     */
    public function clientReviews(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isClient()) {
            return $this->errorResponse('Only clients can view their reviews.', 403);
        }

        $request->validate([
            'therapist_id' => ['nullable', 'integer', 'exists:users,id'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
            'is_verified' => ['nullable', 'boolean'],
            'is_public' => ['nullable', 'boolean'],
        ]);

        $therapistId = $request->get('therapist_id');
        $rating = $request->get('rating');
        $isVerified = $request->get('is_verified');
        $isPublic = $request->get('is_public');

        $query = Review::where('client_id', $user->id)
            ->with([
                'therapist:id,name,email,phone',
                'appointment:id,appointment_date,appointment_time,status,session_mode',
            ]);

        if (! empty($therapistId)) {
            $query->where('therapist_id', (int) $therapistId);
        }

        if (! empty($rating)) {
            $query->where('rating', (int) $rating);
        }

        if ($request->has('is_verified')) {
            $query->where('is_verified', (bool) $isVerified);
        }

        if ($request->has('is_public')) {
            $query->where('is_public', (bool) $isPublic);
        }

        $perPage = (int) $request->get('per_page', 10);
        $reviews = $query->orderByDesc('created_at')->paginate($perPage);

        $items = $reviews->getCollection()->map(function (Review $review) {
            return [
                'id' => $review->id,
                'therapist_id' => $review->therapist_id,
                'appointment_id' => $review->appointment_id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'is_verified' => $review->is_verified,
                'is_public' => $review->is_public,
                'created_at' => optional($review->created_at)->toDateTimeString(),
                'therapist' => $review->therapist ? [
                    'id' => $review->therapist->id,
                    'name' => $review->therapist->name,
                    'email' => $review->therapist->email,
                    'phone' => $review->therapist->phone,
                ] : null,
                'appointment' => $review->appointment ? [
                    'id' => $review->appointment->id,
                    'appointment_date' => optional($review->appointment->appointment_date)->toDateString(),
                    'appointment_time' => (string) $review->appointment->appointment_time,
                    'status' => $review->appointment->status,
                    'session_mode' => $review->appointment->session_mode,
                ] : null,
            ];
        })->values();

        return $this->successResponse([
            'items' => $items,
            'pagination' => [
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
                'per_page' => $reviews->perPage(),
                'total' => $reviews->total(),
            ],
        ]);
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
                        'Missing answer for required question: '.$question->id,
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

    /**
     * Record a mood check-in for the authenticated user.
     */
    public function storeMyMood(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $validated = $request->validate([
            'mood' => ['required', 'string', Rule::in(UserMood::MOODS)],
            'note' => ['nullable', 'string', 'max:5000'],
        ]);

        $todayMood = UserMood::query()
            ->where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->latest('id')
            ->first();

        $isUpdate = (bool) $todayMood;

        if ($todayMood) {
            $todayMood->update([
                'mood' => $validated['mood'],
                'note' => $validated['note'] ?? null,
            ]);
            $mood = $todayMood->fresh();
        } else {
            $mood = UserMood::create([
                'user_id' => $user->id,
                'mood' => $validated['mood'],
                'note' => $validated['note'] ?? null,
            ]);
        }

        return $this->successResponse([
            'id' => $mood->id,
            'mood' => $mood->mood,
            'note' => $mood->note,
            'created_at' => optional($mood->created_at)->toDateTimeString(),
            'updated_at' => optional($mood->updated_at)->toDateTimeString(),
        ], $isUpdate ? 'Today mood updated.' : 'Mood recorded.', $isUpdate ? 200 : 201);
    }

    /**
     * List mood entries for the authenticated user (optional date range, paginated).
     */
    public function myMoods(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        if ($request->filled('from') && $request->filled('to')) {
            if (Carbon::parse($request->get('from'))->startOfDay()->gt(Carbon::parse($request->get('to'))->startOfDay())) {
                return $this->errorResponse('`to` must be on or after `from`.', 422);
            }
        }

        $query = UserMood::query()
            ->where('user_id', $user->id)
            ->orderByDesc('created_at');

        if ($request->filled('from')) {
            $from = Carbon::parse($request->get('from'))->startOfDay();
            $query->where('created_at', '>=', $from);
        }

        if ($request->filled('to')) {
            $to = Carbon::parse($request->get('to'))->endOfDay();
            $query->where('created_at', '<=', $to);
        }

        $perPage = (int) $request->get('per_page', 15);
        $page = $query->paginate($perPage);

        $items = $page->getCollection()->map(function (UserMood $row) {
            return [
                'id' => $row->id,
                'mood' => $row->mood,
                'note' => $row->note,
                'created_at' => optional($row->created_at)->toDateTimeString(),
                'updated_at' => optional($row->updated_at)->toDateTimeString(),
            ];
        })->values();

        return $this->successResponse([
            'items' => $items,
            'pagination' => [
                'current_page' => $page->currentPage(),
                'last_page' => $page->lastPage(),
                'per_page' => $page->perPage(),
                'total' => $page->total(),
            ],
        ]);
    }
}
