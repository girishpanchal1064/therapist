<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'assessment_id',
        'question_text',
        'question_type',
        'options',
        'required',
        'sort_order',
        'weight',
    ];

    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
        'sort_order' => 'integer',
        'weight' => 'integer',
    ];

    /**
     * Get the assessment this question belongs to.
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * Get the answers for this question.
     */
    public function answers()
    {
        return $this->hasMany(UserAssessmentAnswer::class);
    }

    /**
     * Scope for ordered questions.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
