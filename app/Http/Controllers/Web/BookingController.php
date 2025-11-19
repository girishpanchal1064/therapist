<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\TherapistProfile;
use App\Services\TherapistAvailabilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function showBookingForm($therapistId)
    {
        $therapist = User::with('therapistProfile')->findOrFail($therapistId);

        if (!$therapist->isTherapist() || !$therapist->therapistProfile) {
            abort(404, 'Therapist not found');
        }

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login', ['redirect' => route('booking.form', $therapistId)])
                ->with('message', 'Please login first to book a session with ' . $therapist->name . '. After logging in, you will be redirected to complete your booking.');
        }

        return view('web.booking.form', compact('therapist'));
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'therapist_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'session_mode' => 'nullable|in:online,offline',
            'duration_minutes' => 'nullable|integer|min:30|max:120'
        ]);

        $therapistId = $request->therapist_id;
        $date = $request->date;
        $sessionMode = $request->session_mode; // 'online' or 'offline'
        $durationMinutes = $request->duration_minutes ?? 60;

        $therapist = User::findOrFail($therapistId);

        if (!$therapist->isTherapist()) {
            return response()->json(['error' => 'Therapist not found'], 404);
        }

        $availabilityService = new TherapistAvailabilityService();
        $slots = $availabilityService->getAvailableSlots($therapistId, $date, $sessionMode, $durationMinutes);

        return response()->json([
            'slots' => $slots,
            'date' => $date,
            'formatted_date' => Carbon::parse($date)->format('M d, Y'),
            'day_name' => Carbon::parse($date)->format('l'),
            'slot_count' => count($slots)
        ]);
    }

    public function bookAppointment(Request $request)
    {
        $request->validate([
            'therapist_id' => 'required|exists:users,id',
            'appointment_type' => 'required|in:individual,couple,family',
            'session_mode' => 'required|in:video,audio,chat',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'duration_minutes' => 'required|integer|min:30|max:120',
            'notes' => 'nullable|string|max:1000',
        ]);

        $therapist = User::findOrFail($request->therapist_id);

        if (!$therapist->isTherapist()) {
            return back()->withErrors(['error' => 'Therapist not found']);
        }

        // Check if slot is still available
        $isBooked = Appointment::where('therapist_id', $request->therapist_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereIn('status', ['scheduled', 'confirmed'])
            ->exists();

        if ($isBooked) {
            return back()->withErrors(['error' => 'This time slot is no longer available']);
        }

        // Create appointment
        $appointment = Appointment::create([
            'client_id' => Auth::id(),
            'therapist_id' => $request->therapist_id,
            'appointment_type' => $request->appointment_type,
            'session_mode' => $request->session_mode,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'duration_minutes' => $request->duration_minutes,
            'status' => 'scheduled',
            'meeting_link' => $this->generateMeetingLink($request->session_mode),
        ]);

        // Redirect to payment page
        return redirect()->route('payment.create', ['appointment' => $appointment->id])
            ->with('success', 'Appointment created! Please complete payment to confirm your booking.');
    }

    private function generateMeetingLink($sessionMode)
    {
        // In a real application, integrate with video calling services
        switch ($sessionMode) {
            case 'video':
                return 'https://meet.google.com/' . uniqid();
            case 'audio':
                return 'https://zoom.us/j/' . uniqid();
            case 'chat':
                return route('chat.session', ['id' => uniqid()]);
            default:
                return 'https://meet.google.com/' . uniqid();
        }
    }
}
