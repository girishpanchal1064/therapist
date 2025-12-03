<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\TherapistEarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountSummaryController extends Controller
{
    public function index(Request $request)
    {
        $therapist = Auth::user();
        
        // Get date range filter
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $search = $request->get('search');
        $perPage = $request->get('per_page', 10);

        // Build query for appointments with payments and earnings
        $query = Appointment::with(['client', 'payment', 'therapistEarning'])
            ->where('therapist_id', $therapist->id)
            ->whereHas('payment', function($q) {
                $q->where('status', 'completed');
            });

        // Apply date range filter
        if ($startDate && $endDate) {
            $query->whereBetween('appointment_date', [$startDate, $endDate]);
        }

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('client', function($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Get account summaries
        $summaries = $query->orderBy('appointment_date', 'desc')
                          ->orderBy('appointment_time', 'desc')
                          ->paginate($perPage);

        // Calculate totals from earnings
        $totalDue = $summaries->sum(function($appointment) {
            return $appointment->therapistEarning ? $appointment->therapistEarning->due_amount : 0;
        });
        
        $totalAvailable = $summaries->sum(function($appointment) {
            return $appointment->therapistEarning ? $appointment->therapistEarning->available_amount : 0;
        });
        
        $totalDisbursed = $summaries->sum(function($appointment) {
            return $appointment->therapistEarning ? $appointment->therapistEarning->disbursed_amount : 0;
        });

        return view('therapist.account-summary.index', compact(
            'summaries',
            'startDate',
            'endDate',
            'search',
            'perPage',
            'totalDue',
            'totalAvailable',
            'totalDisbursed'
        ));
    }
}
