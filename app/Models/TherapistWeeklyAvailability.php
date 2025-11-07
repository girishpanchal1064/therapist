<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistWeeklyAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'therapist_id',
        'days',
        'slots',
        'mode',
        'type',
        'timezone',
    ];

    protected $casts = [
        'days' => 'array',
        'slots' => 'array',
    ];
}
