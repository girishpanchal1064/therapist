<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'started_at' => $this->started_at,
            'completed_at' => $this->completed_at,
            'total_score' => $this->total_score,
            'max_score' => $this->max_score,
            'percentage' => $this->percentage,
            'result_summary' => $this->result_summary,
            'assessment' => new AssessmentResource($this->whenLoaded('assessment')),
            'answers' => $this->whenLoaded('answers', function () {
                return $this->answers->map(function ($answer) {
                    return [
                        'id' => $answer->id,
                        'question_id' => $answer->question_id,
                        'question_text' => $answer->question ? $answer->question->question_text : null,
                        'answer_text' => $answer->answer_text,
                        'answer_value' => $answer->answer_value,
                        'score' => $answer->score,
                    ];
                });
            }),
        ];
    }
}

