<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform a Therapist (User with therapist profile) for API responses.
 */
class TherapistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $profile = $this->whenLoaded('therapistProfile');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role_id' => $this->role_id,
            'avatar' => $this->avatar,
            'profile' => $profile ? [
                'id' => $profile->id,
                'user_name' => $profile->user_name,
                'full_name' => $profile->full_name ?? trim(($profile->first_name ?? '') . ' ' . ($profile->last_name ?? '')),
                'qualification' => $profile->qualification,
                'specialization' => $profile->specialization,
                'experience_years' => $profile->experience_years,
                'consultation_fee' => $profile->consultation_fee,
                'couple_consultation_fee' => $profile->couple_consultation_fee,
                'bio' => $profile->bio,
                'languages' => $profile->languages,
                'areas_of_expertise' => $profile->areas_of_expertise,
                'rating_average' => $profile->rating_average,
                'total_reviews' => $profile->total_reviews,
                'is_verified' => $profile->is_verified,
                'is_available' => $profile->is_available,
                'profile_image' => $profile->profile_image,
            ] : null,
        ];
    }
}

