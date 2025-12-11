<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Assessment;
use App\Models\UserAssessment;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Dashboard Statistics
        $stats = [
            'total_appointments' => $user->appointmentsAsClient()->count(),
            'upcoming_appointments' => $user->appointmentsAsClient()
                ->whereIn('status', ['scheduled', 'confirmed'])
                ->where('appointment_date', '>=', today())
                ->count(),
            'completed_appointments' => $user->appointmentsAsClient()
                ->where('status', 'completed')
                ->count(),
            'total_spent' => Payment::where('user_id', $user->id)
                ->where('status', 'completed')
                ->sum('total_amount'),
            'wallet_balance' => $user->wallet ? $user->wallet->balance : 0,
            'assessments_completed' => UserAssessment::where('user_id', $user->id)
                ->where('status', 'completed')
                ->count(),
            'reviews_given' => Review::where('client_id', $user->id)
                ->count(),
        ];

        // Get upcoming appointments
        $upcomingAppointments = $user->appointmentsAsClient()
            ->with(['therapist.therapistProfile.specializations', 'payment'])
            ->whereIn('status', ['scheduled', 'confirmed'])
            ->where('appointment_date', '>=', today())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->limit(10)
            ->get();

        // Get today's appointments
        $todayAppointments = $user->appointmentsAsClient()
            ->with(['therapist.therapistProfile.specializations', 'payment'])
            ->whereDate('appointment_date', today())
            ->whereIn('status', ['scheduled', 'confirmed', 'in_progress'])
            ->orderBy('appointment_time')
            ->get();

        // Get recent completed appointments
        $recentAppointments = $user->appointmentsAsClient()
            ->with(['therapist.therapistProfile.specializations', 'payment'])
            ->where('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->limit(10)
            ->get();

        // Get available assessments
        $availableAssessments = Assessment::active()
            ->ordered()
            ->withCount(['userAssessments as user_completed' => function($query) use ($user) {
                $query->where('user_id', $user->id)->where('status', 'completed');
            }])
            ->get();

        // Get user's assessments
        $userAssessments = UserAssessment::where('user_id', $user->id)
            ->with('assessment')
            ->orderBy('completed_at', 'desc')
            ->limit(5)
            ->get();

        // Get wallet transactions
        $walletTransactions = $user->wallet 
            ? $user->wallet->transactions()
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
            : collect();

        // Get recent payments
        $recentPayments = Payment::where('user_id', $user->id)
            ->with('payable')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get unread messages count
        try {
            $unreadMessagesCount = $user->conversations()
                ->whereHas('messages', function($query) use ($user) {
                    $query->where('sender_id', '!=', $user->id)
                          ->where('is_read', false);
                })
                ->count();
        } catch (\Exception $e) {
            $unreadMessagesCount = 0;
        }

        // Monthly spending chart data
        $monthlySpending = Payment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as total')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month', 'year')
            ->orderBy('month')
            ->get();

        return view('client.dashboard', compact(
            'stats',
            'upcomingAppointments',
            'todayAppointments',
            'recentAppointments',
            'availableAssessments',
            'userAssessments',
            'walletTransactions',
            'recentPayments',
            'unreadMessagesCount',
            'monthlySpending'
        ));
    }
}
