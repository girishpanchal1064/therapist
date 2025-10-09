<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'total_therapists' => User::whereHas('roles', function($query) {
                $query->where('name', 'therapist');
            })->count(),
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'scheduled')->count(),
            'total_payments' => Payment::sum('amount'),
            'monthly_revenue' => Payment::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
            'total_reviews' => Review::count(),
            'pending_reviews' => Review::where('is_verified', false)->count(),
        ];

        // Get recent activities
        $recent_appointments = Appointment::with(['client', 'therapist'])
            ->latest()
            ->limit(5)
            ->get();

        $recent_users = User::latest()
            ->limit(5)
            ->get();

        // Get monthly appointment data for chart
        $monthly_appointments = Appointment::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_appointments',
            'recent_users',
            'monthly_appointments'
        ));
    }
}
