<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistBankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'therapist_profile_id',
        'account_holder_name',
        'account_number',
        'bank_name',
        'ifsc_code',
        'branch_name',
        'account_type',
    ];

    public function therapistProfile()
    {
        return $this->belongsTo(TherapistProfile::class);
    }
}
