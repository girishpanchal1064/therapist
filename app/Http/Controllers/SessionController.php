<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SessionController extends Controller
{
    protected $twilioService;

    public function __construct()
    {
        $this->twilioService = new TwilioService();
    }

    /**
     * Show join session page
     */
    public function join(Request $request, $appointmentId)
    {
        $appointment = Appointment::with(['client', 'therapist'])->findOrFail($appointmentId);
        
        // Check if user is authorized (either client or therapist)
        $user = Auth::user();
        if ($appointment->client_id !== $user->id && $appointment->therapist_id !== $user->id) {
            abort(403, 'You are not authorized to join this session.');
        }

        // Check if therapist already has an active session (only for therapists)
        if ($appointment->therapist_id === $user->id) {
            if (Appointment::therapistHasActiveSession($appointment->therapist_id, $appointment->id)) {
                $activeSession = Appointment::getActiveSessionForTherapist($appointment->therapist_id);
                return redirect()->back()
                    ->with('error', "You already have an active session (Appointment #{$activeSession->id}). Please complete that session before starting a new one.");
            }
        }

        // Check if session time has arrived
        // Handle appointment_time - it might be a datetime or time string
        $timeString = is_string($appointment->appointment_time) 
            ? $appointment->appointment_time 
            : (is_object($appointment->appointment_time) 
                ? $appointment->appointment_time->format('H:i:s') 
                : $appointment->appointment_time);
        
        // Extract just time if it's a full datetime string
        if (strlen($timeString) > 8) {
            $timeString = Carbon::parse($timeString)->format('H:i:s');
        }
        
        $appointmentDateTime = Carbon::parse($appointment->appointment_date->format('Y-m-d') . ' ' . $timeString);
        // Allow joining 5 minutes before appointment time or anytime after
        $canJoin = $appointmentDateTime->diffInMinutes(now(), false) >= -5;
        
        // Update status automatically if session time has arrived
        if ($canJoin) {
            if ($appointment->status === 'scheduled') {
                $appointment->update(['status' => 'confirmed']);
            }
            // Only update to in_progress if therapist doesn't have another active session
            if ($appointment->status === 'confirmed' && ($appointmentDateTime->isPast() || $appointmentDateTime->isCurrentMinute())) {
                // Double-check before setting to in_progress
                if (!Appointment::therapistHasActiveSession($appointment->therapist_id, $appointment->id)) {
                    $appointment->update(['status' => 'in_progress']);
                } else {
                    $activeSession = Appointment::getActiveSessionForTherapist($appointment->therapist_id);
                    return redirect()->back()
                        ->with('error', "You already have an active session (Appointment #{$activeSession->id}). Please complete that session before starting a new one.");
                }
            }
        }

        // Generate Twilio access token
        $roomName = $this->twilioService->generateRoomName($appointment->id);
        $identity = $user->id . '-' . $user->name;
        
        try {
            // Ensure room exists
            $room = $this->twilioService->getRoom($roomName);
            if (!$room) {
                $this->twilioService->createRoom($roomName);
            }

            // Generate token based on session mode
            if ($appointment->session_mode === 'audio') {
                $token = $this->twilioService->generateVoiceToken($identity, $roomName);
            } else {
                $token = $this->twilioService->generateVideoToken($identity, $roomName);
            }
        } catch (\Exception $e) {
            \Log::error('Error generating Twilio token: ' . $e->getMessage());
            $token = null;
        }

        $role = $appointment->client_id === $user->id ? 'client' : 'therapist';
        
        return view('sessions.join', compact('appointment', 'token', 'roomName', 'role', 'canJoin'));
    }

    /**
     * Get access token via AJAX
     */
    public function getToken(Request $request, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $user = Auth::user();

        // Check authorization
        if ($appointment->client_id !== $user->id && $appointment->therapist_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $roomName = $this->twilioService->generateRoomName($appointment->id);
        $identity = $user->id . '-' . $user->name;

        try {
            if ($appointment->session_mode === 'audio') {
                $token = $this->twilioService->generateVoiceToken($identity, $roomName);
            } else {
                $token = $this->twilioService->generateVideoToken($identity, $roomName);
            }

            return response()->json([
                'token' => $token,
                'roomName' => $roomName,
                'identity' => $identity,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error generating token: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate access token'], 500);
        }
    }

    /**
     * End session
     */
    public function end(Request $request, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $user = Auth::user();

        // Check authorization
        if ($appointment->client_id !== $user->id && $appointment->therapist_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Complete Twilio room
        $roomName = $this->twilioService->generateRoomName($appointment->id);
        $this->twilioService->completeRoom($roomName);

        // Update appointment status if needed
        if ($appointment->status === 'in_progress') {
            // Don't auto-complete, let therapist complete it manually
        }

        return response()->json(['success' => true, 'message' => 'Session ended']);
    }
}
