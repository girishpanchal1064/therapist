<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    /**
     * Check if user is SuperAdmin
     */
    private function checkSuperAdmin()
    {
        if (!Auth::user() || !Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access. Only SuperAdmin can access this page.');
        }
    }

    /**
     * Display a listing of all online sessions.
     */
    public function index(Request $request)
    {
        $this->checkSuperAdmin();
        
        $status = $request->get('status', 'pending');
        $search = $request->get('search');

        $query = Appointment::with(['client', 'therapist']);

        // Filter by status
        switch ($status) {
            case 'pending':
                $query->where('status', 'scheduled');
                break;
            case 'upcoming':
                $query->whereIn('status', ['scheduled', 'confirmed'])
                    ->where('appointment_date', '>=', now()->toDateString());
                break;
            case 'completed':
                $query->where('status', 'completed');
                break;
            case 'cancelled':
                $query->where('status', 'cancelled');
                break;
            case 'expired':
                $query->where('appointment_date', '<', now()->toDateString())
                    ->whereNotIn('status', ['completed', 'cancelled']);
                break;
        }

        // Search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('client', function($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('therapist', function($therapistQuery) use ($search) {
                      $therapistQuery->where('name', 'like', "%{$search}%")
                                     ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $perPage = $request->get('per_page', 10);
        
        $sessions = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.sessions.index', compact('sessions', 'status', 'search'));
    }

    /**
     * Show the form for creating a new session.
     */
    public function create()
    {
        $this->checkSuperAdmin();
        
        $therapists = User::whereHas('roles', function($query) {
            $query->where('name', 'Therapist');
        })->get();
        
        $clients = User::whereHas('roles', function($query) {
            $query->where('name', 'Client');
        })->get();
        
        return view('admin.sessions.create', compact('therapists', 'clients'));
    }

    /**
     * Store a newly created session in storage.
     */
    public function store(Request $request)
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'therapist_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:users,id',
            'appointment_type' => 'required|in:individual,couple,family',
            'session_mode' => 'required|in:video,audio,chat',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'duration_minutes' => 'required|integer|min:30|max:120',
            'status' => 'required|in:scheduled,confirmed',
            'session_notes' => 'nullable|string',
        ]);

        // Check if therapist is actually a therapist
        $therapist = User::findOrFail($validated['therapist_id']);
        if (!$therapist->hasRole('Therapist')) {
            return back()->withErrors(['therapist_id' => 'Selected user is not a therapist.'])->withInput();
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

        // Generate meeting link
        $meetingId = 'meeting_' . time() . '_' . $validated['therapist_id'] . '_' . $validated['client_id'];
        $validated['meeting_id'] = $meetingId;
        $validated['meeting_link'] = config('app.url') . '/session/' . $meetingId;
        $validated['meeting_password'] = str()->random(8);
        
        // Auto-activate session (no separate activation needed)
        $validated['is_activated_by_admin'] = true;
        $validated['activated_by'] = Auth::id();
        $validated['activated_at'] = now();

        Appointment::create($validated);

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Session created successfully.');
    }

    /**
     * Show the form for editing the specified session.
     */
    public function edit($id)
    {
        $this->checkSuperAdmin();
        
        $session = Appointment::with(['therapist', 'client'])->findOrFail($id);
        
        $therapists = User::whereHas('roles', function($query) {
            $query->where('name', 'Therapist');
        })->get();
        
        $clients = User::whereHas('roles', function($query) {
            $query->where('name', 'Client');
        })->get();
        
        return view('admin.sessions.edit', compact('session', 'therapists', 'clients'));
    }

    /**
     * Update the specified session in storage.
     */
    public function update(Request $request, $id)
    {
        $this->checkSuperAdmin();
        
        $session = Appointment::findOrFail($id);
        
        $validated = $request->validate([
            'therapist_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:users,id',
            'appointment_type' => 'required|in:individual,couple,family',
            'session_mode' => 'required|in:video,audio,chat',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'duration_minutes' => 'required|integer|min:30|max:120',
            'status' => 'required|in:scheduled,confirmed,in_progress,completed,cancelled,no_show',
            'session_notes' => 'nullable|string',
            'cancellation_reason' => 'nullable|string|required_if:status,cancelled',
        ]);

        // Check if therapist is actually a therapist
        $therapist = User::findOrFail($validated['therapist_id']);
        if (!$therapist->hasRole('Therapist')) {
            return back()->withErrors(['therapist_id' => 'Selected user is not a therapist.'])->withInput();
        }

        // Check if slot is available (excluding current session)
        $isBooked = Appointment::where('therapist_id', $validated['therapist_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->whereIn('status', ['scheduled', 'confirmed', 'in_progress'])
            ->where('id', '!=', $session->id)
            ->exists();

        if ($isBooked) {
            return back()->withErrors(['appointment_time' => 'This time slot is already booked.'])->withInput();
        }

        // Handle cancellation
        if ($validated['status'] === 'cancelled' && !$session->cancelled_at) {
            $validated['cancelled_at'] = now();
            $validated['cancelled_by'] = Auth::id();
        }

        $session->update($validated);

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Session updated successfully.');
    }

    /**
     * Remove the specified session from storage.
     */
    public function destroy($id)
    {
        $this->checkSuperAdmin();
        
        $session = Appointment::findOrFail($id);
        $session->delete();

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Session deleted successfully.');
    }

    /**
     * Activate a session (SuperAdmin only)
     */
    public function activate($id)
    {
        $this->checkSuperAdmin();
        
        $session = Appointment::findOrFail($id);
        
        if ($session->is_activated_by_admin) {
            return redirect()->back()
                ->with('info', 'Session is already activated.');
        }

        // Use direct assignment to bypass mass assignment protection
        $session->is_activated_by_admin = true;
        $session->activated_by = Auth::id();
        $session->activated_at = now();
        $session->save();

        return redirect()->back()
            ->with('success', 'Session activated successfully. Therapist can now see this session.');
    }

    /**
     * Deactivate a session (SuperAdmin only)
     */
    public function deactivate($id)
    {
        $this->checkSuperAdmin();
        
        $session = Appointment::findOrFail($id);
        
        if (!$session->is_activated_by_admin) {
            return redirect()->back()
                ->with('info', 'Session is not activated.');
        }

        // Only allow deactivation if session hasn't started
        if (in_array($session->status, ['in_progress', 'completed'])) {
            return redirect()->back()
                ->with('error', 'Cannot deactivate a session that is in progress or completed.');
        }

        // Use direct assignment to bypass mass assignment protection
        $session->is_activated_by_admin = false;
        $session->activated_by = null;
        $session->activated_at = null;
        $session->save();

        return redirect()->back()
            ->with('success', 'Session deactivated successfully.');
    }
}
