<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index(Request $request)
    {
        $therapistId = Auth::id();
        $status = $request->get('status', 'pending');
        $search = $request->get('search');

        $query = Appointment::where('therapist_id', $therapistId)
            ->with('client');

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
            case 'cancel_by_me':
                $query->where('status', 'cancelled')
                    ->where('cancelled_by', $therapistId);
                break;
            case 'cancelled_by_user':
                $query->where('status', 'cancelled')
                    ->where('cancelled_by', '!=', $therapistId)
                    ->whereNotNull('cancelled_by');
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
                  });
            });
        }

        $perPage = $request->get('per_page', 10);
        
        $sessions = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('therapist.sessions.index', compact('sessions', 'status', 'search'));
    }

    public function decline(Request $request, Appointment $appointment)
    {
        if ($appointment->therapist_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'cancellation_reason' => 'required|string|min:10|max:1000',
        ]);

        try {
            $appointment->declineByTherapist($validated['cancellation_reason'], (int) Auth::id());

            return redirect()
                ->route('therapist.sessions.index', ['status' => $request->get('status', 'pending')])
                ->with('success', 'Session declined. The client has been notified and will receive a refund if payment was completed.');
        } catch (\RuntimeException $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        } catch (\Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', 'Unable to decline this session. Please try again or contact support.');
        }
    }
}
