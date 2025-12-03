<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\TherapistEarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function users(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $role = $request->get('role', 'all');
        $status = $request->get('status', 'all');
        $search = $request->get('search');

        $query = User::with('roles');

        // Date range filter
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Role filter
        if ($role !== 'all') {
            $query->whereHas('roles', function($q) use ($role) {
                $q->where('name', $role);
            });
        }

        // Status filter
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        // Statistics
        $stats = [
            'total_users' => User::count(),
            'total_clients' => User::whereHas('roles', function($q) {
                $q->where('name', 'Client');
            })->count(),
            'total_therapists' => User::whereHas('roles', function($q) {
                $q->where('name', 'Therapist');
            })->count(),
            'active_users' => User::where('status', 'active')->count(),
            'new_this_month' => User::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        // Monthly registration data
        $monthlyRegistrations = User::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.reports.users', compact('users', 'stats', 'monthlyRegistrations', 'dateFrom', 'dateTo', 'role', 'status', 'search'));
    }

    public function appointments(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $status = $request->get('status', 'all');
        $type = $request->get('type', 'all');
        $search = $request->get('search');

        $query = Appointment::with(['client', 'therapist', 'payment']);

        // Date range filter
        if ($dateFrom) {
            $query->whereDate('appointment_date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('appointment_date', '<=', $dateTo);
        }

        // Status filter
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Type filter
        if ($type !== 'all') {
            $query->where('appointment_type', $type);
        }

        // Search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('client', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('therapist', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        $appointments = $query->orderBy('appointment_date', 'desc')->paginate(20);

        // Statistics
        $stats = [
            'total' => Appointment::count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'scheduled' => Appointment::where('status', 'scheduled')->count(),
            'this_month' => Appointment::whereMonth('appointment_date', now()->month)
                ->whereYear('appointment_date', now()->year)
                ->count(),
            'this_week' => Appointment::whereBetween('appointment_date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
        ];

        // Monthly appointment data
        $monthlyAppointments = Appointment::select(
                DB::raw('MONTH(appointment_date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('appointment_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.reports.appointments', compact('appointments', 'stats', 'monthlyAppointments', 'dateFrom', 'dateTo', 'status', 'type', 'search'));
    }

    public function financial(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $status = $request->get('status', 'all');
        $search = $request->get('search');

        $query = Payment::with(['user', 'payable']);

        // Date range filter
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Status filter
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(20);

        // Statistics
        $totalRevenue = Payment::where('status', 'completed')->sum('total_amount');
        $monthlyRevenue = Payment::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
        
        $totalTherapistEarnings = TherapistEarning::sum('due_amount');
        $totalPlatformEarnings = $totalRevenue - $totalTherapistEarnings;

        $stats = [
            'total_revenue' => $totalRevenue,
            'monthly_revenue' => $monthlyRevenue,
            'total_payments' => Payment::count(),
            'completed_payments' => Payment::where('status', 'completed')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'therapist_earnings' => $totalTherapistEarnings,
            'platform_earnings' => $totalPlatformEarnings,
        ];

        // Monthly revenue data
        $monthlyRevenueData = Payment::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.reports.financial', compact('payments', 'stats', 'monthlyRevenueData', 'dateFrom', 'dateTo', 'status', 'search'));
    }
}
