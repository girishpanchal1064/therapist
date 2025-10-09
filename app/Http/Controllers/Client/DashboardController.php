<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // Get upcoming appointments
        $upcomingAppointments = $user->appointmentsAsClient()
            ->with('therapist.profile')
            ->upcoming()
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->limit(5)
            ->get();

        // Get recent appointments
        $recentAppointments = $user->appointmentsAsClient()
            ->with('therapist.profile')
            ->completed()
            ->orderBy('appointment_date', 'desc')
            ->limit(5)
            ->get();

        // Get wallet balance
        $walletBalance = $user->wallet ? $user->wallet->balance : 0;

        // Get unread messages count
        $unreadMessagesCount = $user->conversations()
            ->whereHas('messages', function($query) use ($user) {
                $query->where('sender_id', '!=', $user->id)
                      ->where('is_read', false);
            })
            ->count();

        return view('client.dashboard', compact(
            'upcomingAppointments',
            'recentAppointments',
            'walletBalance',
            'unreadMessagesCount'
        ));
    }
}
