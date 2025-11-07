<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        $therapist = Auth::user();

        // Get today's appointments
        $todayAppointments = $therapist->appointmentsAsTherapist()
            ->with('client.profile')
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->get();

        // Get upcoming appointments (next 7 days)
        $upcomingAppointments = $therapist->appointmentsAsTherapist()
            ->with('client.profile')
            ->whereBetween('appointment_date', [today()->addDay(), today()->addDays(7)])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        // Get completed appointments this month
        $completedThisMonth = $therapist->appointmentsAsTherapist()
            ->where('appointments.status', 'completed')
            ->whereMonth('appointment_date', now()->month)
            ->count();

        // Get total earnings this month
        $monthlyEarnings = $therapist->appointmentsAsTherapist()
            ->where('appointments.status', 'completed')
            ->whereMonth('appointment_date', now()->month)
            ->join('payments', 'appointments.payment_id', '=', 'payments.id')
            ->where('payments.status', 'completed')
            ->sum('payments.total_amount');

        // Get pending reviews
        $pendingReviews = $therapist->reviewsAsTherapist()
            ->where('is_verified', false)
            ->count();

        // Get recent clients
        $recentClients = $therapist->appointmentsAsTherapist()
            ->with('client.profile')
            ->where('appointments.status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->limit(5)
            ->get()
            ->unique('client_id')
            ->take(5);

        // Get appointment statistics
        $appointmentStats = [
            'total' => $therapist->appointmentsAsTherapist()->count(),
            'completed' => $therapist->appointmentsAsTherapist()->where('appointments.status', 'completed')->count(),
            'scheduled' => $therapist->appointmentsAsTherapist()->where('appointments.status', 'scheduled')->count(),
            'cancelled' => $therapist->appointmentsAsTherapist()->where('appointments.status', 'cancelled')->count(),
        ];

        // Get weekly earnings data
        $weeklyEarnings = $therapist->appointmentsAsTherapist()
            ->where('appointments.status', 'completed')
            ->whereBetween('appointment_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->join('payments', 'appointments.payment_id', '=', 'payments.id')
            ->where('payments.status', 'completed')
            ->select(
                DB::raw('DAYNAME(appointment_date) as day'),
                DB::raw('SUM(payments.total_amount) as earnings')
            )
            ->groupBy('day')
            ->get();

        return view('therapist.dashboard', compact(
            'todayAppointments',
            'upcomingAppointments',
            'completedThisMonth',
            'monthlyEarnings',
            'pendingReviews',
            'recentClients',
            'appointmentStats',
            'weeklyEarnings'
        ));
    }
}
