<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserProfile;
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
}

