<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assessment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'icon',
        'color',
        'duration_minutes',
        'question_count',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_minutes' => 'integer',
        'question_count' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Get the questions for this assessment.
     */
    public function questions()
    {
        return $this->hasMany(AssessmentQuestion::class);
    }

    /**
     * Get the user assessments for this assessment.
     */
    public function userAssessments()
    {
        return $this->hasMany(UserAssessment::class);
    }

    /**
     * Scope for active assessments.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered assessments.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    /**
     * Get the completion count for this assessment.
     */
    public function getCompletionCountAttribute()
    {
        return $this->userAssessments()->where('status', 'completed')->count();
    }

    /**
     * Get the average score for this assessment.
     */
    public function getAverageScoreAttribute()
    {
        return $this->userAssessments()
            ->where('status', 'completed')
            ->whereNotNull('total_score')
            ->avg('total_score');
    }
}
