<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'appointment_type' => $this->appointment_type,
            'session_mode' => $this->session_mode,
            'appointment_date' => optional($this->appointment_date)->toDateString(),
            'appointment_time' => (string) $this->appointment_time,
            'duration_minutes' => $this->duration_minutes,
            'status' => $this->status,
            'meeting_link' => $this->meeting_link,
            'meeting_id' => $this->meeting_id,
            'created_at' => optional($this->created_at)->toDateTimeString(),
            'updated_at' => optional($this->updated_at)->toDateTimeString(),
            'client' => new UserResource($this->whenLoaded('client')),
        ];
    }
}

