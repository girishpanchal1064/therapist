<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Merged into client appointments list (same data, single page).
     */
    public function index(Request $request)
    {
        return redirect()->route('client.appointments.index', $request->query());
    }

    public function join($appointmentId)
    {
        return redirect()->route('sessions.join', $appointmentId);
    }

    /**
     * Merged into client appointments detail page.
     */
    public function show($appointmentId)
    {
        return redirect()->route('client.appointments.show', $appointmentId);
    }
}
