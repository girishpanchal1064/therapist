<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Get upcoming and active sessions (confirmed or in_progress)
        $sessions = Appointment::with(['therapist.therapistProfile', 'payment'])
            ->where('client_id', $userId)
            ->whereIn('status', ['confirmed', 'in_progress', 'scheduled'])
            ->where('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->paginate(10);

        return view('client.sessions.index', compact('sessions'));
    }

    public function join($appointmentId)
    {
        $appointment = Appointment::with(['therapist.therapistProfile', 'client'])
            ->findOrFail($appointmentId);

        // Check if user owns this appointment
        if ($appointment->client_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if appointment is ready to join
        if (!in_array($appointment->status, ['confirmed', 'in_progress'])) {
            return redirect()->route('client.dashboard')
                ->with('error', 'This session is not available to join yet.');
        }

        // Check if appointment time is valid
        $appointmentDateTime = \Carbon\Carbon::parse($appointment->appointment_date->format('Y-m-d') . ' ' . $appointment->appointment_time->format('H:i:s'));
        $now = now();

        // Allow joining 10 minutes before scheduled time
        if ($now->lt($appointmentDateTime->subMinutes(10))) {
            return redirect()->route('client.dashboard')
                ->with('info', 'Session will be available 10 minutes before the scheduled time.');
        }

        // Update status to in_progress if it's confirmed
        // But first check if therapist already has an active session
        if ($appointment->status === 'confirmed') {
            if (Appointment::therapistHasActiveSession($appointment->therapist_id, $appointment->id)) {
                $activeSession = Appointment::getActiveSessionForTherapist($appointment->therapist_id);
                return redirect()->route('client.dashboard')
                    ->with('error', "The therapist is currently in another session (Appointment #{$activeSession->id}). Please wait for that session to complete.");
            }
            $appointment->update(['status' => 'in_progress']);
        }

        return view('client.sessions.join', compact('appointment'));
    }

    public function show($appointmentId)
    {
        $appointment = Appointment::with(['therapist.therapistProfile', 'client', 'payment'])
            ->findOrFail($appointmentId);

        // Check if user owns this appointment
        if ($appointment->client_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('client.sessions.show', compact('appointment'));
    }
}
