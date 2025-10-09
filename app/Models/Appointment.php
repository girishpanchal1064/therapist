<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'therapist_id',
        'appointment_type',
        'session_mode',
        'appointment_date',
        'appointment_time',
        'duration_minutes',
        'status',
        'meeting_link',
        'meeting_id',
        'meeting_password',
        'session_notes',
        'prescription',
        'cancellation_reason',
        'cancelled_by',
        'cancelled_at',
        'payment_id',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'appointment_time' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    /**
     * Get the client.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the therapist.
     */
    public function therapist()
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }

    /**
     * Get the payment.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Get the participants.
     */
    public function participants()
    {
        return $this->hasMany(AppointmentParticipant::class);
    }

    /**
     * Get the review.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Get the conversation.
     */
    public function conversation()
    {
        return $this->hasOne(Conversation::class);
    }

    /**
     * Get the cancelled by user.
     */
    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    /**
     * Scope for upcoming appointments.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
                    ->whereIn('status', ['scheduled', 'confirmed']);
    }

    /**
     * Scope for completed appointments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for therapist appointments.
     */
    public function scopeForTherapist($query, $therapistId)
    {
        return $query->where('therapist_id', $therapistId);
    }

    /**
     * Scope for client appointments.
     */
    public function scopeForClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    /**
     * Generate meeting link.
     */
    public function generateMeetingLink()
    {
        // This would integrate with video calling service (Agora, Twilio, etc.)
        $meetingId = 'meeting_' . $this->id . '_' . time();
        $this->meeting_id = $meetingId;
        $this->meeting_link = config('app.url') . '/session/' . $meetingId;
        $this->meeting_password = str_random(8);
        $this->save();
    }

    /**
     * Check if appointment can be cancelled.
     */
    public function canBeCancelled()
    {
        $appointmentDateTime = $this->appointment_date . ' ' . $this->appointment_time;
        $appointmentTime = strtotime($appointmentDateTime);
        $currentTime = time();
        $hoursUntilAppointment = ($appointmentTime - $currentTime) / 3600;
        
        return in_array($this->status, ['scheduled', 'confirmed']) && 
               $hoursUntilAppointment > 2; // Can cancel if more than 2 hours before
    }

    /**
     * Cancel the appointment.
     */
    public function cancel($reason, $userId)
    {
        $this->status = 'cancelled';
        $this->cancellation_reason = $reason;
        $this->cancelled_by = $userId;
        $this->cancelled_at = now();
        $this->save();
    }

    /**
     * Complete the appointment.
     */
    public function complete()
    {
        $this->status = 'completed';
        $this->save();
    }

    /**
     * Get the appointment date and time.
     */
    public function getAppointmentDateTimeAttribute()
    {
        return $this->appointment_date . ' ' . $this->appointment_time;
    }

    /**
     * Get the formatted appointment time.
     */
    public function getFormattedTimeAttribute()
    {
        return date('g:i A', strtotime($this->appointment_time));
    }

    /**
     * Get the formatted appointment date.
     */
    public function getFormattedDateAttribute()
    {
        return $this->appointment_date->format('M d, Y');
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'scheduled' => 'bg-blue-100 text-blue-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'in_progress' => 'bg-yellow-100 text-yellow-800',
            'completed' => 'bg-gray-100 text-gray-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'no_show' => 'bg-orange-100 text-orange-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}