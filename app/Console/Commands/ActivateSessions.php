<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ActivateSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:activate {--force : Force activation even if time has not arrived} {--id= : Activate specific appointment ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate sessions when appointment time arrives';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $force = $this->option('force');
        $appointmentId = $this->option('id');
        
        // Find appointments that should be activated (only video/audio sessions)
        $query = Appointment::whereIn('status', ['scheduled', 'confirmed'])
            ->whereIn('session_mode', ['video', 'audio']); // Only activate video/audio sessions
        
        // If specific ID provided, get that appointment
        if ($appointmentId) {
            $query->where('id', $appointmentId);
        } else {
            $query->where('appointment_date', '<=', $now->toDateString());
        }
        
        $appointments = $query->get();
        
        if ($appointments->count() === 0) {
            $this->warn("No appointments found to activate.");
            if ($appointmentId) {
                $this->info("Appointment #{$appointmentId} not found or doesn't meet criteria.");
            } else {
                $this->info("Run 'php artisan sessions:debug' to see why sessions aren't activating.");
            }
            return 0;
        }

        $activated = 0;

        foreach ($appointments as $appointment) {
            // Handle appointment_time - it might be a datetime or time string
            $timeString = is_string($appointment->appointment_time) 
                ? $appointment->appointment_time 
                : (is_object($appointment->appointment_time) 
                    ? $appointment->appointment_time->format('H:i:s') 
                    : $appointment->appointment_time);
            
            // Extract just time if it's a full datetime string
            if (strlen($timeString) > 8) {
                $timeString = Carbon::parse($timeString)->format('H:i:s');
            }
            
            $appointmentDateTime = Carbon::parse(
                $appointment->appointment_date->format('Y-m-d') . ' ' . $timeString
            );

            // Activate if appointment time is within 5 minutes (before or after) OR if force flag is set
            $minutesDiff = $appointmentDateTime->diffInMinutes($now, false);
            
            if ($force || ($minutesDiff >= -5 && $minutesDiff <= 0)) {
                // Update status to confirmed if it's scheduled (5 min before to appointment time)
                if ($appointment->status === 'scheduled') {
                    $appointment->update(['status' => 'confirmed']);
                    $activated++;
                    $this->info("Activated appointment #{$appointment->id} - Status: confirmed" . ($force ? ' (forced)' : ''));
                }
            }

            // Auto-start session when time arrives or has passed (mode-wise) OR if force flag is set
            if ($force || $appointmentDateTime->isPast() || $appointmentDateTime->isCurrentMinute()) {
                // Only auto-start for video and audio sessions
                if (in_array($appointment->session_mode, ['video', 'audio'])) {
                    // Check if therapist already has an active session
                    if (Appointment::therapistHasActiveSession($appointment->therapist_id, $appointment->id)) {
                        $activeSession = Appointment::getActiveSessionForTherapist($appointment->therapist_id);
                        $this->warn("Skipping appointment #{$appointment->id} - Therapist #{$appointment->therapist_id} already has an active session (Appointment #{$activeSession->id})");
                        continue;
                    }
                    
                    if ($appointment->status === 'confirmed') {
                        $appointment->update(['status' => 'in_progress']);
                        $activated++;
                        $this->info("Auto-started appointment #{$appointment->id} ({$appointment->session_mode}) - Status: in_progress" . ($force ? ' (forced)' : ''));
                    } elseif ($appointment->status === 'scheduled') {
                        // If still scheduled but time has passed, update to in_progress directly
                        $appointment->update(['status' => 'in_progress']);
                        $activated++;
                        $this->info("Auto-started appointment #{$appointment->id} ({$appointment->session_mode}) - Status: in_progress" . ($force ? ' (forced)' : ''));
                    }
                }
            }
        }

        if ($activated > 0) {
            $this->info("Activated {$activated} session(s).");
        } else {
            $this->info("No sessions to activate.");
        }

        return 0;
    }
}
