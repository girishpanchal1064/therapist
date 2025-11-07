<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistSingleAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'therapist_id',
        'date',
        'slots',
        'mode',
        'type',
        'timezone',
    ];

    protected $casts = [
        'date' => 'date',
        'slots' => 'array',
    ];
}
