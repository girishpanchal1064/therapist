<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['client', 'therapist'])->paginate(15);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('admin.appointments.create');
    }

    public function store(Request $request)
    {
        // Implementation for storing appointments
    }

    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        return view('admin.appointments.edit', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        // Implementation for updating appointments
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('admin.appointments.index');
    }

    public function today()
    {
        $appointments = Appointment::whereDate('appointment_date', today())
            ->with(['client', 'therapist'])
            ->paginate(15);
        return view('admin.appointments.today', compact('appointments'));
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);
        return redirect()->back();
    }

    public function complete(Appointment $appointment)
    {
        $appointment->update(['status' => 'completed']);
        return redirect()->back();
    }
}
