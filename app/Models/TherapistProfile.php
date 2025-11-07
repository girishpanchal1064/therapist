<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_number',
        'specialization',
        'qualification',
        'experience_years',
        'consultation_fee',
        'couple_consultation_fee',
        'bio',
        'video_intro_url',
        'languages',
        'is_verified',
        'is_available',
        'verification_documents',
        'verified_at',
        'verified_by',
        'rating_average',
        'total_sessions',
        'total_reviews',
        'prefix',
        'first_name',
        'middle_name',
        'last_name',
        'category',
        'user_name',
        'brief_description',
        'present_address',
        'present_country',
        'present_state',
        'present_city',
        'present_district',
        'present_zip',
        'clinic_address',
        'same_as_present_address',
        'clinic_country',
        'clinic_state',
        'clinic_city',
        'clinic_district',
        'clinic_zip',
        'timezone',
        'areas_of_expertise',
    ];

    protected function casts(): array
    {
        return [
            'languages' => 'array',
            'verification_documents' => 'array',
            'areas_of_expertise' => 'array',
            'is_verified' => 'boolean',
            'is_available' => 'boolean',
            'same_as_present_address' => 'boolean',
            'verified_at' => 'datetime',
            'consultation_fee' => 'decimal:2',
            'couple_consultation_fee' => 'decimal:2',
            'rating_average' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the specializations.
     */
    public function specializations()
    {
        return $this->belongsToMany(TherapistSpecialization::class, 'therapist_specialization_pivot', 'therapist_profile_id', 'specialization_id');
    }

    /**
     * Get the availability.
     */
    public function availability()
    {
        return $this->hasMany(TherapistAvailability::class);
    }

    /**
     * Get the time offs.
     */
    public function timeOffs()
    {
        return $this->hasMany(TherapistTimeOff::class);
    }

    /**
     * Get the appointments.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'therapist_id');
    }

    /**
     * Get the reviews.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'therapist_id');
    }

    /**
     * Get the experiences.
     */
    public function experiences()
    {
        return $this->hasMany(TherapistExperience::class, 'therapist_profile_id');
    }

    /**
     * Get the qualifications.
     */
    public function qualifications()
    {
        return $this->hasMany(TherapistQualification::class, 'therapist_profile_id');
    }

    /**
     * Get the awards.
     */
    public function awards()
    {
        return $this->hasMany(TherapistAward::class, 'therapist_profile_id');
    }

    /**
     * Get the professional bodies.
     */
    public function professionalBodies()
    {
        return $this->hasMany(TherapistProfessionalBody::class, 'therapist_profile_id');
    }

    /**
     * Get the bank details.
     */
    public function bankDetails()
    {
        return $this->hasMany(TherapistBankDetail::class, 'therapist_profile_id');
    }

    /**
     * Get the verifier.
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Update rating based on reviews.
     */
    public function updateRating()
    {
        $reviews = $this->reviews()->where('is_approved', true);
        $this->rating_average = $reviews->avg('rating') ?? 0;
        $this->total_reviews = $reviews->count();
        $this->save();
    }

    /**
     * Check if therapist is available on given date and time.
     */
    public function isAvailableOn($date, $time)
    {
        $dayOfWeek = strtolower(date('l', strtotime($date)));

        // Check if therapist has time off on this date
        $hasTimeOff = $this->timeOffs()
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->exists();

        if ($hasTimeOff) {
            return false;
        }

        // Check if therapist has availability on this day and time
        $hasAvailability = $this->availability()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->where('start_time', '<=', $time)
            ->where('end_time', '>', $time)
            ->exists();

        return $hasAvailability;
    }

    /**
     * Get available time slots for a given date.
     */
    public function getAvailableSlots($date)
    {
        $dayOfWeek = strtolower(date('l', strtotime($date)));
        $slots = [];

        // Get therapist's availability for this day
        $availability = $this->availability()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->first();

        if (!$availability) {
            return $slots;
        }

        // Generate time slots
        $start = strtotime($availability->start_time);
        $end = strtotime($availability->end_time);
        $duration = 45 * 60; // 45 minutes in seconds

        for ($time = $start; $time < $end; $time += $duration) {
            $slotTime = date('H:i:s', $time);

            // Check if this slot is already booked
            $isBooked = $this->appointments()
                ->where('appointment_date', $date)
                ->where('appointment_time', $slotTime)
                ->whereIn('status', ['scheduled', 'confirmed', 'in_progress'])
                ->exists();

            if (!$isBooked) {
                $slots[] = [
                    'time' => $slotTime,
                    'formatted_time' => date('g:i A', $time),
                    'available' => true
                ];
            }
        }

        return $slots;
    }

    /**
     * Get the full name.
     */
    public function getFullNameAttribute()
    {
        return $this->user->full_name;
    }

    /**
     * Get the profile image URL.
     */
    public function getProfileImageUrlAttribute()
    {
        return $this->user->avatar;
    }
}
