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

        $specializations = $profile && $profile->relationLoaded('specializations')
            ? $profile->specializations->map(fn ($s) => ['id' => $s->id, 'name' => $s->name, 'slug' => $s->slug])->values()->all()
            : [];

        $qualification = $profile->qualification ?? '';
        $qualificationArray = is_array($qualification)
            ? array_values($qualification)
            : array_values(array_filter(array_map('trim', preg_split('/[\n,]+/', (string) $qualification))));

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
                'qualification' => $qualificationArray,
                'specialization' => $specializations,
                'specializations' => $specializations,
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

