<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'category' => $this->category,
            'icon' => $this->icon,
            'color' => $this->color,
            'duration_minutes' => $this->duration_minutes,
            'question_count' => $this->question_count,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            'questions' => $this->whenLoaded('questions', function () {
                return $this->questions->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'question_text' => $question->question_text,
                        'question_type' => $question->question_type,
                        'options' => $question->options,
                        'required' => $question->required,
                        'sort_order' => $question->sort_order,
                        'weight' => $question->weight,
                    ];
                });
            }),
        ];
    }
}

