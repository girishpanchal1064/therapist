<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DebugSessions extends Command
{
    protected $signature = 'sessions:debug';
    protected $description = 'Debug why sessions are not activating';

    public function handle()
    {
        $now = Carbon::now();
        
        $this->info("Current Time: " . $now->format('Y-m-d H:i:s'));
        $this->info("==========================================\n");

        // Get all video/audio appointments
        $allAppointments = Appointment::whereIn('session_mode', ['video', 'audio'])->get();
        
        $this->info("Total Video/Audio Appointments: " . $allAppointments->count() . "\n");

        if ($allAppointments->count() === 0) {
            $this->warn("No video/audio appointments found in database!");
            $this->info("\nChecking all appointments...");
            $all = Appointment::all();
            $this->info("Total appointments: " . $all->count());
            foreach ($all as $app) {
                $this->line("  - ID: {$app->id}, Mode: {$app->session_mode}, Status: {$app->status}");
            }
            return 0;
        }

        foreach ($allAppointments as $appointment) {
            $this->info("Appointment #{$appointment->id}:");
            $this->line("  Status: {$appointment->status}");
            $this->line("  Mode: {$appointment->session_mode}");
            $this->line("  Date: {$appointment->appointment_date}");
            
            // Handle appointment_time
            $timeString = is_string($appointment->appointment_time) 
                ? $appointment->appointment_time 
                : (is_object($appointment->appointment_time) 
                    ? $appointment->appointment_time->format('H:i:s') 
                    : $appointment->appointment_time);
            
            if (strlen($timeString) > 8) {
                $timeString = Carbon::parse($timeString)->format('H:i:s');
            }
            
            $this->line("  Time: {$timeString}");
            
            $appointmentDateTime = Carbon::parse(
                $appointment->appointment_date->format('Y-m-d') . ' ' . $timeString
            );
            
            $this->line("  Appointment DateTime: " . $appointmentDateTime->format('Y-m-d H:i:s'));
            
            // Check conditions
            $isScheduledOrConfirmed = in_array($appointment->status, ['scheduled', 'confirmed']);
            $isVideoOrAudio = in_array($appointment->session_mode, ['video', 'audio']);
            $isDateValid = $appointment->appointment_date->lte($now->toDateString());
            $minutesDiff = $appointmentDateTime->diffInMinutes($now, false);
            $isTimeArrived = $appointmentDateTime->isPast() || $appointmentDateTime->isCurrentMinute();
            $isWithin5Min = $minutesDiff >= -5 && $minutesDiff <= 0;
            
            $this->line("\n  Conditions Check:");
            $this->line("  ✓ Status is scheduled/confirmed: " . ($isScheduledOrConfirmed ? 'YES' : 'NO'));
            $this->line("  ✓ Mode is video/audio: " . ($isVideoOrAudio ? 'YES' : 'NO'));
            $this->line("  ✓ Date is today or past: " . ($isDateValid ? 'YES' : 'NO'));
            $this->line("  ✓ Time difference: {$minutesDiff} minutes");
            $this->line("  ✓ Within 5 minutes: " . ($isWithin5Min ? 'YES' : 'NO'));
            $this->line("  ✓ Time has arrived: " . ($isTimeArrived ? 'YES' : 'NO'));
            
            if ($isScheduledOrConfirmed && $isVideoOrAudio && $isDateValid) {
                if ($isWithin5Min && $appointment->status === 'scheduled') {
                    $this->info("  → Should activate to 'confirmed'");
                } elseif ($isTimeArrived && in_array($appointment->status, ['confirmed', 'scheduled'])) {
                    $this->info("  → Should activate to 'in_progress'");
                } else {
                    $this->warn("  → Will NOT activate (conditions not met)");
                }
            } else {
                $this->warn("  → Will NOT activate (basic conditions not met)");
            }
            
            $this->line("\n");
        }

        return 0;
    }
}
