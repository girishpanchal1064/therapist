<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\TwilioService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TwilioSessionTokenController extends Controller
{
    /**
     * Issue a Twilio Programmable Video JWT for the authenticated client or therapist.
     * Mirrors web {@see \App\Http\Controllers\SessionController::join} checks and status updates.
     */
    public function show(Appointment $appointment): JsonResponse
    {
        $user = Auth::user();

        if ($appointment->client_id !== $user->id && $appointment->therapist_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to join this session.',
            ], 403);
        }

        if ($appointment->therapist_id === $user->id) {
            if (Appointment::therapistHasActiveSession($appointment->therapist_id, $appointment->id)) {
                return $this->therapistActiveSessionConflictResponse($appointment->therapist_id);
            }
        }

        $timeString = is_string($appointment->appointment_time)
            ? $appointment->appointment_time
            : (is_object($appointment->appointment_time)
                ? $appointment->appointment_time->format('H:i:s')
                : $appointment->appointment_time);

        if (strlen((string) $timeString) > 8) {
            $timeString = Carbon::parse($timeString)->format('H:i:s');
        }

        $appointmentDateTime = Carbon::parse($appointment->appointment_date->format('Y-m-d') . ' ' . $timeString);
        $canJoin = $appointmentDateTime->diffInMinutes(now(), false) >= -5;

        if ($canJoin) {
            if ($appointment->status === 'scheduled') {
                $appointment->update(['status' => 'confirmed']);
            }
            if ($appointment->status === 'confirmed' && ($appointmentDateTime->isPast() || $appointmentDateTime->isCurrentMinute())) {
                if (! Appointment::therapistHasActiveSession($appointment->therapist_id, $appointment->id)) {
                    $appointment->update(['status' => 'in_progress']);
                } else {
                    return $this->therapistActiveSessionConflictResponse($appointment->therapist_id);
                }
            }
        }

        $sessionMode = $appointment->session_mode === 'audio' ? 'audio' : 'video';

        $twilio = new TwilioService();
        $roomName = $twilio->generateRoomName($appointment->id);
        $identity = $user->id . '-' . $user->name;

        $token = null;
        try {
            $room = $twilio->getRoom($roomName);
            if (! $room) {
                $twilio->createRoom($roomName);
            }

            $token = $sessionMode === 'audio'
                ? $twilio->generateVoiceToken($identity, $roomName)
                : $twilio->generateVideoToken($identity, $roomName);
        } catch (\Exception $e) {
            Log::error('Twilio API token error: ' . $e->getMessage());
        }

        $role = $appointment->client_id === $user->id ? 'client' : 'therapist';

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token,
                'room_name' => $roomName,
                'identity' => $identity,
                'session_mode' => $sessionMode,
                'role' => $role,
                'expires_in' => 3600,
                'can_join' => $canJoin,
                'appointment_status' => $appointment->fresh()->status,
            ],
        ]);
    }

    private function therapistActiveSessionConflictResponse(int $therapistId): JsonResponse
    {
        $active = Appointment::getActiveSessionForTherapist($therapistId);

        $payload = [
            'success' => false,
            'message' => $active
                ? "You already have an active session (Appointment #{$active->id}). Please complete that session before starting a new one."
                : 'You already have an active session.',
        ];
        if ($active) {
            $payload['data'] = ['active_appointment_id' => $active->id];
        }

        return response()->json($payload, 409);
    }
}
