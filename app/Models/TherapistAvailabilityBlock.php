<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistAvailabilityBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'therapist_id',
        'start_date',
        'end_date',
        'date',
        'blocked_slots',
        'reason',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'date' => 'date',
        'blocked_slots' => 'array',
        'is_active' => 'boolean',
    ];
}
