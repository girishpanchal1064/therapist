<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistQualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'therapist_profile_id',
        'name_of_degree',
        'degree_in',
        'institute_university',
        'year_of_passing',
        'percentage_cgpa',
        'certificate',
    ];

    public function therapistProfile()
    {
        return $this->belongsTo(TherapistProfile::class);
    }
}
