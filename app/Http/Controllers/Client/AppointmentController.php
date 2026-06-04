<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->appointmentsAsClient()
            ->with(['therapist.therapistProfile', 'payment', 'cancelledBy']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total' => $user->appointmentsAsClient()->count(),
            'upcoming' => $user->appointmentsAsClient()
                ->whereIn('status', ['scheduled', 'confirmed'])
                ->where('appointment_date', '>=', now()->toDateString())
                ->count(),
            'completed' => $user->appointmentsAsClient()->where('status', 'completed')->count(),
        ];

        return view('client.appointments.index', compact('appointments', 'stats'));
    }

    public function show($appointmentId)
    {
        $appointment = Appointment::with(['therapist.therapistProfile', 'client', 'payment', 'cancelledBy'])
            ->findOrFail($appointmentId);

        // Check if user owns this appointment
        if ($appointment->client_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('client.appointments.show', compact('appointment'));
    }
}
