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
        // Redirect to main SessionController which has Twilio integration
        return redirect()->route('sessions.join', $appointmentId);
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
