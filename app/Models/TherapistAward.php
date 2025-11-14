<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistAward extends Model
{
    use HasFactory;

    protected $fillable = [
        'therapist_profile_id',
        'award_name',
        'awarded_by',
        'year',
        'description',
        'document',
    ];

    public function therapistProfile()
    {
        return $this->belongsTo(TherapistProfile::class);
    }
}
