<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\TherapistResource;
use App\Http\Resources\UserResource;
use App\Models\Appointment;
use App\Models\TherapistProfile;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\TherapistAvailabilityService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Str;

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
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
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
     * List all therapists (astrologers) with optional filters.
     */
    public function therapists(Request $request): JsonResponse
    {
        $query = User::role('Therapist')
            ->whereHas('therapistProfile', function ($q) {
                $q->where('is_verified', true)
                    ->where('is_available', true);
            })
            ->with(['therapistProfile', 'profile']);

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

        if ($request->filled('language')) {
            $language = $request->string('language')->toString();
            $query->whereHas('therapistProfile', function ($q) use ($language) {
                $q->whereJsonContains('languages', $language);
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

        return $this->successResponse([
            'items' => TherapistResource::collection($therapists),
            'pagination' => [
                'current_page' => $therapists->currentPage(),
                'last_page' => $therapists->lastPage(),
                'per_page' => $therapists->perPage(),
                'total' => $therapists->total(),
            ],
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
            ->with(['therapistProfile', 'profile'])
            ->findOrFail($id);

        return $this->successResponse(new TherapistResource($therapist));
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
}

