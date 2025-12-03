<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Models\SessionNote;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $therapistId = Auth::id();
        $search = $request->get('search');

        $query = SessionNote::where('therapist_id', $therapistId)
            ->with(['client', 'appointment']);

        // Search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('chief_complaints', 'like', "%{$search}%")
                  ->orWhere('observations', 'like', "%{$search}%")
                  ->orWhere('recommendations', 'like', "%{$search}%")
                  ->orWhere('reason', 'like', "%{$search}%")
                  ->orWhereHas('client', function($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('appointment', function($appointmentQuery) use ($search) {
                      $appointmentQuery->where('id', 'like', "%{$search}%");
                  });
            });
        }

        $perPage = $request->get('per_page', 10);
        
        $sessionNotes = $query->orderBy('session_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('therapist.session-notes.index', compact('sessionNotes', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $therapistId = Auth::id();
        
        // Get appointments for this therapist
        $appointments = Appointment::where('therapist_id', $therapistId)
            ->whereIn('status', ['scheduled', 'confirmed', 'completed', 'in_progress'])
            ->with('client')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return view('therapist.session-notes.create', compact('appointments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'nullable|exists:appointments,id',
            'client_id' => 'required|exists:users,id',
            'session_date' => 'nullable|date',
            'start_time' => 'nullable',
            'chief_complaints' => 'required|string',
            'observations' => 'required|string',
            'recommendations' => 'required|string',
            'reason' => 'nullable|string',
            'follow_up_date' => 'nullable|date|after_or_equal:today',
            'user_didnt_turn_up' => 'boolean',
            'no_follow_up_required' => 'boolean',
        ]);

        // If appointment_id is provided, get session details from appointment
        if ($request->appointment_id) {
            $appointment = Appointment::findOrFail($request->appointment_id);
            $validated['session_date'] = $appointment->appointment_date;
            $validated['start_time'] = $appointment->appointment_time ? $appointment->appointment_time->format('H:i:s') : null;
        }

        $validated['therapist_id'] = Auth::id();
        $validated['user_didnt_turn_up'] = $request->has('user_didnt_turn_up');
        $validated['no_follow_up_required'] = $request->has('no_follow_up_required');

        // If no follow-up required, clear follow-up date
        if ($validated['no_follow_up_required']) {
            $validated['follow_up_date'] = null;
        }

        SessionNote::create($validated);

        return redirect()->route('therapist.session-notes.index')
            ->with('success', 'Session note created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sessionNote = SessionNote::where('therapist_id', Auth::id())
            ->with(['client', 'appointment'])
            ->findOrFail($id);

        return view('therapist.session-notes.show', compact('sessionNote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sessionNote = SessionNote::where('therapist_id', Auth::id())
            ->with(['client', 'appointment'])
            ->findOrFail($id);

        $therapistId = Auth::id();
        $appointments = Appointment::where('therapist_id', $therapistId)
            ->whereIn('status', ['scheduled', 'confirmed', 'completed', 'in_progress'])
            ->with('client')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return view('therapist.session-notes.edit', compact('sessionNote', 'appointments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sessionNote = SessionNote::where('therapist_id', Auth::id())
            ->findOrFail($id);

        $validated = $request->validate([
            'appointment_id' => 'nullable|exists:appointments,id',
            'client_id' => 'required|exists:users,id',
            'session_date' => 'nullable|date',
            'start_time' => 'nullable',
            'chief_complaints' => 'required|string',
            'observations' => 'required|string',
            'recommendations' => 'required|string',
            'reason' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
            'user_didnt_turn_up' => 'boolean',
            'no_follow_up_required' => 'boolean',
        ]);

        // If appointment_id is provided, get session details from appointment
        if ($request->appointment_id) {
            $appointment = Appointment::findOrFail($request->appointment_id);
            $validated['session_date'] = $appointment->appointment_date;
            $validated['start_time'] = $appointment->appointment_time ? $appointment->appointment_time->format('H:i:s') : null;
        }

        $validated['user_didnt_turn_up'] = $request->has('user_didnt_turn_up');
        $validated['no_follow_up_required'] = $request->has('no_follow_up_required');

        // If no follow-up required, clear follow-up date
        if ($validated['no_follow_up_required']) {
            $validated['follow_up_date'] = null;
        }

        $sessionNote->update($validated);

        return redirect()->route('therapist.session-notes.index')
            ->with('success', 'Session note updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sessionNote = SessionNote::where('therapist_id', Auth::id())
            ->findOrFail($id);

        $sessionNote->delete();

        return redirect()->route('therapist.session-notes.index')
            ->with('success', 'Session note deleted successfully.');
    }
}
