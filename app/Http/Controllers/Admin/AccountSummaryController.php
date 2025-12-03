<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\TherapistEarning;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AccountSummaryController extends Controller
{
    private function checkSuperAdmin()
    {
        if (!Auth::user() || !Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access. Only SuperAdmin can access this page.');
        }
    }

    public function index(Request $request)
    {
        $this->checkSuperAdmin();

        // Get filters
        $therapistId = $request->get('therapist_id');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $search = $request->get('search');
        $perPage = $request->get('per_page', 10);

        // Build query for appointments with payments
        $query = Appointment::with(['client', 'therapist', 'payment'])
            ->whereHas('payment', function($q) {
                $q->where('status', 'completed');
            });

        // Filter by therapist
        if ($therapistId) {
            $query->where('therapist_id', $therapistId);
        }

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
                  })
                  ->orWhereHas('therapist', function($therapistQuery) use ($search) {
                      $therapistQuery->where('name', 'like', "%{$search}%")
                                     ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Get account summaries with earnings
        $summaries = $query->with('therapistEarning')
                          ->orderBy('appointment_date', 'desc')
                          ->orderBy('appointment_time', 'desc')
                          ->paginate($perPage);

        // Get all therapists for filter dropdown
        $therapists = User::whereHas('roles', function($q) {
            $q->where('name', 'Therapist');
        })->orderBy('name')->get();

        // Calculate totals
        $totalPaymentAmount = $summaries->sum(function($appointment) {
            return $appointment->payment ? $appointment->payment->total_amount : 0;
        });
        
        $totalTherapistEarning = $summaries->sum(function($appointment) {
            return $appointment->therapistEarning ? $appointment->therapistEarning->due_amount : 0;
        });
        
        $totalPlatformEarning = $totalPaymentAmount - $totalTherapistEarning;
        $totalDisbursed = $summaries->sum(function($appointment) {
            return $appointment->therapistEarning ? $appointment->therapistEarning->disbursed_amount : 0;
        });

        return view('admin.account-summary.index', compact(
            'summaries',
            'therapists',
            'therapistId',
            'startDate',
            'endDate',
            'search',
            'perPage',
            'totalPaymentAmount',
            'totalTherapistEarning',
            'totalPlatformEarning',
            'totalDisbursed'
        ));
    }
}
