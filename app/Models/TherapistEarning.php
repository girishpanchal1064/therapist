<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'therapist_id',
        'appointment_id',
        'payment_id',
        'due_amount',
        'available_amount',
        'disbursed_amount',
        'status',
        'disbursed_at',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'due_amount' => 'decimal:2',
            'available_amount' => 'decimal:2',
            'disbursed_amount' => 'decimal:2',
            'disbursed_at' => 'datetime',
        ];
    }

    public function therapist()
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
