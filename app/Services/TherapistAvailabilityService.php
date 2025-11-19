<?php

namespace App\Services;

use App\Models\User;
use App\Models\Appointment;
use App\Models\TherapistWeeklyAvailability;
use App\Models\TherapistSingleAvailability;
use App\Models\TherapistAvailabilityBlock;
use Carbon\Carbon;

class TherapistAvailabilityService
{
    /**
     * Get available slots for a therapist on a specific date
     */
    public function getAvailableSlots($therapistId, $date, $mode = null, $durationMinutes = 60)
    {
        $date = Carbon::parse($date);
        $dayOfWeek = strtolower($date->format('l')); // e.g., 'monday'
        
        $availableSlots = [];

        // Check if date is in the past
        if ($date->isPast() && !$date->isToday()) {
            return $availableSlots;
        }

        // Check for blocked dates
        if ($this->isDateBlocked($therapistId, $date)) {
            return $availableSlots;
        }

        // Get single day availability (overrides weekly)
        $singleAvailability = TherapistSingleAvailability::where('therapist_id', $therapistId)
            ->where('date', $date->toDateString())
            ->first();

        if ($singleAvailability) {
            // Use single day availability
            $slots = $singleAvailability->slots ?? [];
            $availabilityMode = $singleAvailability->mode;
            
            // Filter by mode if specified
            if ($mode && $availabilityMode !== $mode) {
                return $availableSlots;
            }

            foreach ($slots as $slot) {
                $slotSlots = $this->generateSlotsFromTimeRange(
                    $date,
                    $slot['start'],
                    $slot['end'],
                    $durationMinutes,
                    $therapistId,
                    $mode
                );
                $availableSlots = array_merge($availableSlots, $slotSlots);
            }
        } else {
            // Get weekly availability
            $weeklyAvailabilities = TherapistWeeklyAvailability::where('therapist_id', $therapistId)
                ->where('type', 'repeat')
                ->get();

            foreach ($weeklyAvailabilities as $weeklyAvailability) {
                $days = $weeklyAvailability->days ?? [];
                
                // Check if this day is in the availability
                $dayNames = array_map('strtolower', $days);
                if (!in_array($dayOfWeek, $dayNames)) {
                    continue;
                }

                $availabilityMode = $weeklyAvailability->mode;
                
                // Filter by mode if specified
                if ($mode && $availabilityMode !== $mode) {
                    continue;
                }

                $slots = $weeklyAvailability->slots ?? [];
                foreach ($slots as $slot) {
                    $slotSlots = $this->generateSlotsFromTimeRange(
                        $date,
                        $slot['start'],
                        $slot['end'],
                        $durationMinutes,
                        $therapistId,
                        $mode
                    );
                    $availableSlots = array_merge($availableSlots, $slotSlots);
                }
            }
        }

        // Remove duplicates and sort
        $availableSlots = $this->removeDuplicateSlots($availableSlots);
        usort($availableSlots, function($a, $b) {
            return strcmp($a['time'], $b['time']);
        });

        return $availableSlots;
    }

    /**
     * Generate time slots from a time range
     */
    private function generateSlotsFromTimeRange($date, $startTime, $endTime, $durationMinutes, $therapistId, $mode = null)
    {
        $slots = [];
        $start = Carbon::parse($date->toDateString() . ' ' . $startTime);
        $end = Carbon::parse($date->toDateString() . ' ' . $endTime);
        $current = $start->copy();

        while ($current->copy()->addMinutes($durationMinutes)->lte($end)) {
            $slotEnd = $current->copy()->addMinutes($durationMinutes);
            
            // Skip past slots for today
            if ($date->isToday() && $current->isPast()) {
                $current->addMinutes($durationMinutes);
                continue;
            }

            // Check if slot is blocked
            if ($this->isSlotBlocked($therapistId, $date, $current->format('H:i'))) {
                $current->addMinutes($durationMinutes);
                continue;
            }

            // Check if slot is already booked
            if ($this->isSlotBooked($therapistId, $date, $current->format('H:i'))) {
                $current->addMinutes($durationMinutes);
                continue;
            }

            $slots[] = [
                'time' => $current->format('H:i'),
                'formatted_time' => $current->format('g:i A'),
                'end_time' => $slotEnd->format('H:i'),
                'formatted_end_time' => $slotEnd->format('g:i A'),
                'available' => true,
                'mode' => $mode
            ];

            $current->addMinutes($durationMinutes);
        }

        return $slots;
    }

    /**
     * Check if a date is blocked
     */
    private function isDateBlocked($therapistId, $date)
    {
        return TherapistAvailabilityBlock::where('therapist_id', $therapistId)
            ->where('is_active', true)
            ->where(function($query) use ($date) {
                $query->where(function($q) use ($date) {
                    // Date range block
                    $q->whereNotNull('start_date')
                      ->whereNotNull('end_date')
                      ->where('start_date', '<=', $date)
                      ->where('end_date', '>=', $date);
                })->orWhere(function($q) use ($date) {
                    // Single date block
                    $q->whereNotNull('date')
                      ->where('date', $date->toDateString());
                });
            })
            ->exists();
    }

    /**
     * Check if a specific slot is blocked
     */
    private function isSlotBlocked($therapistId, $date, $time)
    {
        $blocks = TherapistAvailabilityBlock::where('therapist_id', $therapistId)
            ->where('is_active', true)
            ->where(function($query) use ($date) {
                $query->where(function($q) use ($date) {
                    $q->whereNotNull('start_date')
                      ->whereNotNull('end_date')
                      ->where('start_date', '<=', $date)
                      ->where('end_date', '>=', $date);
                })->orWhere(function($q) use ($date) {
                    $q->whereNotNull('date')
                      ->where('date', $date->toDateString());
                });
            })
            ->get();

        foreach ($blocks as $block) {
            $blockedSlots = $block->blocked_slots ?? [];
            foreach ($blockedSlots as $blockedSlot) {
                if (isset($blockedSlot['start']) && isset($blockedSlot['end'])) {
                    $slotStart = Carbon::parse($blockedSlot['start'])->format('H:i');
                    $slotEnd = Carbon::parse($blockedSlot['end'])->format('H:i');
                    if ($time >= $slotStart && $time < $slotEnd) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Check if a slot is already booked
     */
    private function isSlotBooked($therapistId, $date, $time)
    {
        return Appointment::where('therapist_id', $therapistId)
            ->where('appointment_date', $date->toDateString())
            ->where('appointment_time', $time . ':00')
            ->whereIn('status', ['scheduled', 'confirmed', 'in_progress'])
            ->exists();
    }

    /**
     * Remove duplicate slots
     */
    private function removeDuplicateSlots($slots)
    {
        $unique = [];
        $seen = [];

        foreach ($slots as $slot) {
            $key = $slot['time'];
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $unique[] = $slot;
            }
        }

        return $unique;
    }

    /**
     * Get availability for multiple dates (calendar view)
     */
    public function getAvailabilityCalendar($therapistId, $startDate = null, $days = 30, $mode = null)
    {
        $startDate = $startDate ? Carbon::parse($startDate) : Carbon::today();
        $calendar = [];

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $slots = $this->getAvailableSlots($therapistId, $date, $mode);

            if (!empty($slots) || $i < 7) { // Always show next 7 days
                $calendar[] = [
                    'date' => $date->toDateString(),
                    'formatted_date' => $date->format('M d, Y'),
                    'day_name' => $date->format('l'),
                    'day_short' => $date->format('D'),
                    'is_today' => $date->isToday(),
                    'is_tomorrow' => $date->isTomorrow(),
                    'is_past' => $date->isPast() && !$date->isToday(),
                    'slots' => $slots,
                    'slot_count' => count($slots),
                    'is_available' => !empty($slots)
                ];
            }
        }

        return $calendar;
    }

    /**
     * Check if therapist has any availability set
     */
    public function hasAvailability($therapistId)
    {
        $hasWeekly = TherapistWeeklyAvailability::where('therapist_id', $therapistId)
            ->where('type', 'repeat')
            ->exists();

        $hasSingle = TherapistSingleAvailability::where('therapist_id', $therapistId)
            ->where('date', '>=', Carbon::today())
            ->exists();

        return $hasWeekly || $hasSingle;
    }
}
