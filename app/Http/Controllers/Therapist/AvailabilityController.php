<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Models\TherapistWeeklyAvailability;
use App\Models\TherapistSingleAvailability;
use App\Models\TherapistAvailabilityBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    public function set()
    {
        $therapistId = Auth::id();
        $availabilities = TherapistWeeklyAvailability::where('therapist_id', $therapistId)->latest()->get();
        return view('therapist.availability.set', compact('availabilities'));
    }

    public function storeSet(Request $request)
    {
        $validated = $request->validate([
            'groups' => 'required|array|min:1',
            'groups.*.days' => 'required|array|min:1',
            'groups.*.slots' => 'required|array|min:1|max:4',
            'groups.*.slots.*.start' => 'required|date_format:H:i',
            'groups.*.slots.*.end' => 'required|date_format:H:i',
            'groups.*.mode' => 'required|in:online,offline',
            'groups.*.type' => 'required|in:repeat,once',
            'groups.*.timezone' => 'nullable|string',
        ]);

        foreach ($validated['groups'] as $group) {
            // ensure start < end per slot
            foreach ($group['slots'] as $slot) {
                if (strtotime($slot['end']) <= strtotime($slot['start'])) {
                    return back()->withErrors(['groups' => 'Each slot end time must be after start time'])->withInput();
                }
            }
            TherapistWeeklyAvailability::create([
                'therapist_id' => Auth::id(),
                'days' => $group['days'],
                'slots' => array_values($group['slots']),
                'mode' => $group['mode'],
                'type' => $group['type'],
                'timezone' => $group['timezone'] ?? null,
            ]);
        }

        return back()->with('success', 'Weekly availability saved.');
    }

    public function updateSet(Request $request, TherapistWeeklyAvailability $availability)
    {
        $this->authorizeOwnership($availability->therapist_id);
        
        $validated = $request->validate([
            'groups' => 'required|array|min:1',
            'groups.*.days' => 'required|array|min:1',
            'groups.*.slots' => 'required|array|min:1|max:4',
            'groups.*.slots.*.start' => 'required|date_format:H:i',
            'groups.*.slots.*.end' => 'required|date_format:H:i',
            'groups.*.mode' => 'required|in:online,offline',
            'groups.*.type' => 'required|in:repeat,once',
            'groups.*.timezone' => 'nullable|string',
        ]);

        $group = $validated['groups'][0];
        
        // ensure start < end per slot
        foreach ($group['slots'] as $slot) {
            if (strtotime($slot['end']) <= strtotime($slot['start'])) {
                return back()->withErrors(['groups' => 'Each slot end time must be after start time'])->withInput();
            }
        }
        
        $availability->update([
            'days' => $group['days'],
            'slots' => array_values($group['slots']),
            'mode' => $group['mode'],
            'type' => $group['type'],
            'timezone' => $group['timezone'] ?? null,
        ]);

        return back()->with('success', 'Weekly availability updated.');
    }

    public function destroySet(TherapistWeeklyAvailability $availability)
    {
        $this->authorizeOwnership($availability->therapist_id);
        $availability->delete();
        return back()->with('success', 'Weekly availability deleted.');
    }

    public function single()
    {
        $therapistId = Auth::id();
        $availabilities = TherapistSingleAvailability::where('therapist_id', $therapistId)->latest()->get();
        return view('therapist.availability.single', compact('availabilities'));
    }

    public function storeSingle(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'slots' => 'required|array|min:1|max:4',
            'slots.*.start' => 'required|date_format:H:i',
            'slots.*.end' => 'required|date_format:H:i|after:slots.*.start',
            'mode' => 'required|in:online,offline',
            'timezone' => 'nullable|string',
        ]);

        TherapistSingleAvailability::updateOrCreate(
            ['therapist_id' => Auth::id(), 'date' => $validated['date']],
            [
                'slots' => $validated['slots'],
                'mode' => $validated['mode'],
                'type' => 'once',
                'timezone' => $validated['timezone'] ?? null,
            ]
        );

        return back()->with('success', 'Single day availability saved.');
    }

    public function updateSingle(Request $request, TherapistSingleAvailability $availability)
    {
        $this->authorizeOwnership($availability->therapist_id);
        
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'slots' => 'required|array|min:1|max:4',
            'slots.*.start' => 'required|date_format:H:i',
            'slots.*.end' => 'required|date_format:H:i|after:slots.*.start',
            'mode' => 'required|in:online,offline',
            'timezone' => 'nullable|string',
        ]);

        $availability->update([
            'date' => $validated['date'],
            'slots' => $validated['slots'],
            'mode' => $validated['mode'],
            'timezone' => $validated['timezone'] ?? null,
        ]);

        return back()->with('success', 'Single day availability updated.');
    }

    public function destroySingle(TherapistSingleAvailability $availability)
    {
        $this->authorizeOwnership($availability->therapist_id);
        $availability->delete();
        return back()->with('success', 'Single day availability deleted.');
    }

    public function block()
    {
        $therapistId = Auth::id();
        $blocks = TherapistAvailabilityBlock::where('therapist_id', $therapistId)->latest()->get();
        return view('therapist.availability.block', compact('blocks'));
    }

    public function storeBlockDate(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        TherapistAvailabilityBlock::create([
            'therapist_id' => Auth::id(),
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'] ?? null,
        ]);

        return back()->with('success', 'Dates blocked successfully.');
    }

    public function storeBlockSlots(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'blocked_slots' => 'required|array|min:1|max:4',
            'blocked_slots.*.start' => 'required|date_format:H:i',
            'blocked_slots.*.end' => 'required|date_format:H:i|after:blocked_slots.*.start',
            'reason' => 'nullable|string',
        ]);

        TherapistAvailabilityBlock::create([
            'therapist_id' => Auth::id(),
            'date' => $validated['date'],
            'blocked_slots' => $validated['blocked_slots'],
            'reason' => $validated['reason'] ?? null,
        ]);

        return back()->with('success', 'Slots blocked successfully.');
    }

    public function updateBlockDate(Request $request, TherapistAvailabilityBlock $block)
    {
        $this->authorizeOwnership($block->therapist_id);
        
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        $block->update([
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'] ?? null,
        ]);

        return back()->with('success', 'Date block updated successfully.');
    }

    public function updateBlockSlots(Request $request, TherapistAvailabilityBlock $block)
    {
        $this->authorizeOwnership($block->therapist_id);
        
        $validated = $request->validate([
            'date' => 'required|date',
            'blocked_slots' => 'required|array|min:1|max:4',
            'blocked_slots.*.start' => 'required|date_format:H:i',
            'blocked_slots.*.end' => 'required|date_format:H:i|after:blocked_slots.*.start',
            'reason' => 'nullable|string',
        ]);

        $block->update([
            'date' => $validated['date'],
            'blocked_slots' => $validated['blocked_slots'],
            'reason' => $validated['reason'] ?? null,
        ]);

        return back()->with('success', 'Slot block updated successfully.');
    }

    public function toggleBlock(TherapistAvailabilityBlock $block)
    {
        $this->authorizeOwnership($block->therapist_id);
        $block->is_active = !$block->is_active;
        $block->save();
        return back()->with('success', $block->is_active ? 'Block restored.' : 'Block disabled.');
    }

    public function destroyBlock(TherapistAvailabilityBlock $block)
    {
        $this->authorizeOwnership($block->therapist_id);
        $block->delete();
        return back()->with('success', 'Block deleted.');
    }

    private function authorizeOwnership(int $ownerId): void
    {
        abort_unless(Auth::id() === $ownerId, 403);
    }
}
