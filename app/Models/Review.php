<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'client_id',
        'therapist_id',
        'appointment_id',
        'rating',
        'comment',
        'is_verified',
        'is_public',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_public' => 'boolean',
        'rating' => 'integer',
    ];

    /**
     * Get the client who wrote the review.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the therapist being reviewed.
     */
    public function therapist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }

    /**
     * Get the appointment associated with the review.
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
