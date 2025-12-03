<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SessionNote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'therapist_id',
        'appointment_id',
        'client_id',
        'session_date',
        'start_time',
        'chief_complaints',
        'observations',
        'recommendations',
        'reason',
        'follow_up_date',
        'user_didnt_turn_up',
        'no_follow_up_required',
    ];

    protected function casts(): array
    {
        return [
            'session_date' => 'date',
            'start_time' => 'datetime',
            'follow_up_date' => 'date',
            'user_didnt_turn_up' => 'boolean',
            'no_follow_up_required' => 'boolean',
        ];
    }

    /**
     * Get the therapist.
     */
    public function therapist()
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }

    /**
     * Get the client.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the appointment.
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
}
