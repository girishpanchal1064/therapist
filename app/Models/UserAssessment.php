<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAssessment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'assessment_id',
        'status',
        'started_at',
        'completed_at',
        'total_score',
        'max_score',
        'percentage',
        'result_summary',
        'recommendations',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'total_score' => 'integer',
        'max_score' => 'integer',
        'percentage' => 'decimal:2',
        'result_summary' => 'array',
        'recommendations' => 'array',
    ];

    /**
     * Get the user who took the assessment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the assessment.
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * Get the answers for this assessment.
     */
    public function answers()
    {
        return $this->hasMany(UserAssessmentAnswer::class);
    }

    /**
     * Scope for completed assessments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for in progress assessments.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Get the duration of the assessment.
     */
    public function getDurationAttribute()
    {
        if ($this->started_at && $this->completed_at) {
            return $this->completed_at->diffInMinutes($this->started_at);
        }
        return null;
    }
}
