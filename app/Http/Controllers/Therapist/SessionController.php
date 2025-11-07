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
}
