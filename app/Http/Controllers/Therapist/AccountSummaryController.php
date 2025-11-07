<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Payment;
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

        // Build query for appointments with payments
        $query = Appointment::with(['client', 'payment'])
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

        // Calculate totals
        $totalDue = $summaries->sum(function($appointment) {
            return $appointment->payment ? $appointment->payment->amount : 0;
        });
        $totalAvailable = $totalDue; // For now, available = due (can be customized)
        $totalDisbursed = 0; // Track disbursed amounts separately

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
