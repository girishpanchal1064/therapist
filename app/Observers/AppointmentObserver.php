<?php

namespace App\Observers;

use App\Models\Appointment;

class AppointmentObserver
{
    /**
     * Handle the Appointment "updating" event.
     */
    public function updating(Appointment $appointment): void
    {
        // Check if status is being changed to 'completed'
        if ($appointment->isDirty('status') && $appointment->status === 'completed' && $appointment->getOriginal('status') !== 'completed') {
            // If status is being changed to completed and it wasn't completed before,
            // and payment hasn't been processed, use the complete() method
            if (!$appointment->payment || $appointment->payment->status !== 'completed') {
                // Prevent the direct status update and use complete() method instead
                // This will be handled by the complete() method
                // We'll let the complete() method handle it, so we don't need to do anything here
                // The complete() method will set the status itself
            }
        }
    }
}
