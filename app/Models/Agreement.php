<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agreement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'therapist_id',
        'client_id',
        'title',
        'content',
        'type',
        'status',
        'effective_date',
        'expiry_date',
        'signed_date',
        'signature_data',
    ];

    protected function casts(): array
    {
        return [
            'effective_date' => 'date',
            'expiry_date' => 'date',
            'signed_date' => 'date',
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
}
