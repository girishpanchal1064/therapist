<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Services\TwilioService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class EndSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:end {--force-all : Force end all active sessions regardless of duration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically end sessions when duration time expires';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $forceAll = $this->option('force-all');
        $twilioService = new TwilioService();
        
        // Find active sessions (only video/audio sessions)
        $query = Appointment::whereIn('status', ['in_progress', 'confirmed'])
            ->whereIn('session_mode', ['video', 'audio']); // Only end video/audio sessions
        
        if (!$forceAll) {
            $query->where('appointment_date', '<=', $now->toDateString());
        }
        
        $appointments = $query->get();

        $ended = 0;

        foreach ($appointments as $appointment) {
            $shouldEnd = false;
            
            if ($forceAll) {
                // Force end all active sessions
                $shouldEnd = true;
            } else {
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
                
                // Calculate session end time (start time + duration)
                $sessionEndTime = $appointmentDateTime->copy()->addMinutes($appointment->duration_minutes ?? 60);
                
                // Check if session duration has expired
                if ($now->gte($sessionEndTime) && $appointment->status === 'in_progress') {
                    $shouldEnd = true;
                }
            }
            
            if ($shouldEnd) {
                try {
                    // Complete Twilio room
                    $roomName = $twilioService->generateRoomName($appointment->id);
                    $twilioService->completeRoom($roomName);
                } catch (\Exception $e) {
                    $this->warn("Could not complete Twilio room for appointment #{$appointment->id}: " . $e->getMessage());
                }
                
                // Update appointment status
                // For force-all, bypass payment processing and just mark as completed
                // For normal expiration, try to process payment
                try {
                    if ($forceAll) {
                        // Force end: bypass observer and payment processing
                        \DB::table('appointments')
                            ->where('id', $appointment->id)
                            ->update(['status' => 'completed', 'updated_at' => now()]);
                    } else {
                        // Normal expiration: try to process payment
                        if ($appointment->payment && $appointment->payment->status === 'completed') {
                            // Payment already processed, just update status
                            $appointment->status = 'completed';
                            $appointment->save();
                        } else {
                            // Try to complete (will process payment if needed)
                            $appointment->complete();
                        }
                    }
                    $ended++;
                    $reason = $forceAll ? 'Force ended' : 'Duration expired';
                    $this->info("Ended session for appointment #{$appointment->id} - {$reason}");
                } catch (\Exception $e) {
                    // If payment processing fails and it's not force-all, skip it
                    if ($forceAll) {
                        // Even if there's an error, try to force update via DB
                        try {
                            \DB::table('appointments')
                                ->where('id', $appointment->id)
                                ->update(['status' => 'completed', 'updated_at' => now()]);
                            $ended++;
                            $this->warn("Force ended appointment #{$appointment->id} (payment processing skipped): " . $e->getMessage());
                        } catch (\Exception $dbError) {
                            $this->error("Failed to end session for appointment #{$appointment->id}: " . $dbError->getMessage());
                        }
                    } else {
                        $this->error("Failed to end session for appointment #{$appointment->id}: " . $e->getMessage());
                    }
                }
            }
        }

        if ($ended > 0) {
            $this->info("Ended {$ended} session(s).");
        } else {
            $this->info("No sessions to end.");
        }

        return 0;
    }
}
