<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistProfessionalBody extends Model
{
    use HasFactory;

    protected $fillable = [
        'therapist_profile_id',
        'body_name',
        'membership_number',
        'membership_type',
        'year_joined',
        'document',
    ];

    public function therapistProfile()
    {
        return $this->belongsTo(TherapistProfile::class);
    }
}
