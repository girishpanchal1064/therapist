<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'therapist_profile_id',
        'designation',
        'hospital_organisation',
        'starting_date',
        'last_date',
        'document',
    ];

    protected $casts = [
        'starting_date' => 'date',
        'last_date' => 'date',
    ];

    public function therapistProfile()
    {
        return $this->belongsTo(TherapistProfile::class);
    }
}
