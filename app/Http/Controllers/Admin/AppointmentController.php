<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'all');
        $type = $request->get('type', 'all');
        $mode = $request->get('mode', 'all');
        $perPage = $request->get('per_page', 15);

        $query = Appointment::with(['client', 'therapist', 'payment']);

        // Search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('client', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('therapist', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('meeting_id', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Type filter
        if ($type !== 'all') {
            $query->where('appointment_type', $type);
        }

        // Mode filter
        if ($mode !== 'all') {
            $query->where('session_mode', $mode);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
                              ->orderBy('appointment_time', 'desc')
                              ->paginate($perPage);

        return view('admin.appointments.index', compact('appointments', 'search', 'status', 'type', 'mode', 'perPage'));
    }

    public function create()
    {
        $therapists = \App\Models\User::whereHas('roles', function($query) {
            $query->where('name', 'Therapist');
        })->orderBy('name')->get();
        
        $clients = \App\Models\User::whereHas('roles', function($query) {
            $query->where('name', 'Client');
        })->orderBy('name')->get();
        
        return view('admin.appointments.create', compact('therapists', 'clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:users,id',
            'therapist_id' => 'required|exists:users,id',
            'appointment_type' => 'required|in:individual,couple,family',
            'session_mode' => 'required|in:video,audio,chat',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'duration_minutes' => 'required|integer|min:30|max:120',
            'status' => 'required|in:scheduled,confirmed,in_progress,completed,cancelled,no_show',
            'session_notes' => 'nullable|string',
            'meeting_link' => 'nullable|url',
            'meeting_id' => 'nullable|string',
            'meeting_password' => 'nullable|string',
        ]);

        // Check if therapist is actually a therapist
        $therapist = \App\Models\User::findOrFail($validated['therapist_id']);
        if (!$therapist->hasRole('Therapist')) {
            return back()->withErrors(['therapist_id' => 'Selected user is not a therapist.'])->withInput();
        }

        // Check if client is actually a client
        $client = \App\Models\User::findOrFail($validated['client_id']);
        if (!$client->hasRole('Client')) {
            return back()->withErrors(['client_id' => 'Selected user is not a client.'])->withInput();
        }

        // Check if slot is available
        $isBooked = Appointment::where('therapist_id', $validated['therapist_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->whereIn('status', ['scheduled', 'confirmed', 'in_progress'])
            ->exists();

        if ($isBooked) {
            return back()->withErrors(['appointment_time' => 'This time slot is already booked.'])->withInput();
        }

        // Generate meeting link if not provided
        if (empty($validated['meeting_link'])) {
            $meetingId = 'meeting_' . time() . '_' . $validated['therapist_id'] . '_' . $validated['client_id'];
            $validated['meeting_id'] = $meetingId;
            $validated['meeting_link'] = config('app.url') . '/session/' . $meetingId;
            $validated['meeting_password'] = $validated['meeting_password'] ?? str()->random(8);
        }

        Appointment::create($validated);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        return view('admin.appointments.edit', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        // Implementation for updating appointments
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('admin.appointments.index');
    }

    public function today()
    {
        $appointments = Appointment::whereDate('appointment_date', today())
            ->with(['client', 'therapist', 'payment'])
            ->orderBy('appointment_time', 'asc')
            ->paginate(15);
        return view('admin.appointments.today', compact('appointments'));
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);
        return redirect()->back();
    }

    public function complete(Appointment $appointment)
    {
        $appointment->update(['status' => 'completed']);
        return redirect()->back();
    }
}
