<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAssessmentAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_assessment_id',
        'question_id',
        'answer_text',
        'answer_value',
        'score',
    ];

    protected $casts = [
        'answer_value' => 'integer',
        'score' => 'integer',
    ];

    /**
     * Get the user assessment this answer belongs to.
     */
    public function userAssessment()
    {
        return $this->belongsTo(UserAssessment::class);
    }

    /**
     * Get the question this answer is for.
     */
    public function question()
    {
        return $this->belongsTo(AssessmentQuestion::class, 'question_id');
    }
}
