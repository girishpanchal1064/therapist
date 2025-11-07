<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TherapistWeeklyAvailability;
use App\Models\TherapistSingleAvailability;
use App\Models\TherapistAvailabilityBlock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TherapistAvailabilityController extends Controller
{
    /**
     * Check if user is SuperAdmin
     */
    private function checkSuperAdmin()
    {
        if (!Auth::user() || !Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access. Only SuperAdmin can access this page.');
        }
    }

    /**
     * Show therapist selection page
     */
    public function index()
    {
        $this->checkSuperAdmin();
        
        $therapists = User::whereHas('roles', function($query) {
            $query->where('name', 'Therapist');
        })->with('therapistProfile')->get();
        
        return view('admin.therapist-availability.index', compact('therapists'));
    }

    /**
     * Set Availability - Weekly
     */
    public function set(Request $request)
    {
        $this->checkSuperAdmin();
        
        $therapistId = $request->get('therapist_id');
        
        if (!$therapistId) {
            return redirect()->route('admin.therapist-availability.index')
                ->with('error', 'Please select a therapist.');
        }
        
        $therapist = User::findOrFail($therapistId);
        if (!$therapist->hasRole('Therapist')) {
            return redirect()->route('admin.therapist-availability.index')
                ->with('error', 'Selected user is not a therapist.');
        }
        
        $availabilities = TherapistWeeklyAvailability::where('therapist_id', $therapistId)->latest()->get();
        return view('admin.therapist-availability.set', compact('availabilities', 'therapist'));
    }

    public function storeSet(Request $request)
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'therapist_id' => 'required|exists:users,id',
            'groups' => 'required|array|min:1',
            'groups.*.days' => 'required|array|min:1',
            'groups.*.slots' => 'required|array|min:1|max:4',
            'groups.*.slots.*.start' => 'required|date_format:H:i',
            'groups.*.slots.*.end' => 'required|date_format:H:i',
            'groups.*.mode' => 'required|in:online,offline',
            'groups.*.type' => 'required|in:repeat,once',
            'groups.*.timezone' => 'nullable|string',
        ]);

        $therapist = User::findOrFail($validated['therapist_id']);
        if (!$therapist->hasRole('Therapist')) {
            return back()->withErrors(['therapist_id' => 'Selected user is not a therapist.'])->withInput();
        }

        foreach ($validated['groups'] as $group) {
            foreach ($group['slots'] as $slot) {
                if (strtotime($slot['end']) <= strtotime($slot['start'])) {
                    return back()->withErrors(['groups' => 'Each slot end time must be after start time'])->withInput();
                }
            }
            TherapistWeeklyAvailability::create([
                'therapist_id' => $validated['therapist_id'],
                'days' => $group['days'],
                'slots' => array_values($group['slots']),
                'mode' => $group['mode'],
                'type' => $group['type'],
                'timezone' => $group['timezone'] ?? null,
            ]);
        }

        return redirect()->route('admin.therapist-availability.set', ['therapist_id' => $validated['therapist_id']])
            ->with('success', 'Weekly availability saved.');
    }

    public function updateSet(Request $request, TherapistWeeklyAvailability $availability)
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'therapist_id' => 'required|exists:users,id',
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

        return redirect()->route('admin.therapist-availability.set', ['therapist_id' => $validated['therapist_id']])
            ->with('success', 'Weekly availability updated.');
    }

    public function destroySet(Request $request, TherapistWeeklyAvailability $availability)
    {
        $this->checkSuperAdmin();
        $therapistId = $availability->therapist_id;
        $availability->delete();
        return redirect()->route('admin.therapist-availability.set', ['therapist_id' => $therapistId])
            ->with('success', 'Weekly availability deleted.');
    }

    /**
     * Single Availability
     */
    public function single(Request $request)
    {
        $this->checkSuperAdmin();
        
        $therapistId = $request->get('therapist_id');
        
        if (!$therapistId) {
            return redirect()->route('admin.therapist-availability.index')
                ->with('error', 'Please select a therapist.');
        }
        
        $therapist = User::findOrFail($therapistId);
        if (!$therapist->hasRole('Therapist')) {
            return redirect()->route('admin.therapist-availability.index')
                ->with('error', 'Selected user is not a therapist.');
        }
        
        $availabilities = TherapistSingleAvailability::where('therapist_id', $therapistId)->latest()->get();
        return view('admin.therapist-availability.single', compact('availabilities', 'therapist'));
    }

    public function storeSingle(Request $request)
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'therapist_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'slots' => 'required|array|min:1|max:4',
            'slots.*.start' => 'required|date_format:H:i',
            'slots.*.end' => 'required|date_format:H:i',
            'mode' => 'required|in:online,offline',
            'timezone' => 'nullable|string',
        ]);

        $therapist = User::findOrFail($validated['therapist_id']);
        if (!$therapist->hasRole('Therapist')) {
            return back()->withErrors(['therapist_id' => 'Selected user is not a therapist.'])->withInput();
        }

        TherapistSingleAvailability::updateOrCreate(
            ['therapist_id' => $validated['therapist_id'], 'date' => $validated['date']],
            [
                'slots' => $validated['slots'],
                'mode' => $validated['mode'],
                'type' => 'once',
                'timezone' => $validated['timezone'] ?? null,
            ]
        );

        return redirect()->route('admin.therapist-availability.single', ['therapist_id' => $validated['therapist_id']])
            ->with('success', 'Single day availability saved.');
    }

    public function updateSingle(Request $request, TherapistSingleAvailability $availability)
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'therapist_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'slots' => 'required|array|min:1|max:4',
            'slots.*.start' => 'required|date_format:H:i',
            'slots.*.end' => 'required|date_format:H:i',
            'mode' => 'required|in:online,offline',
            'timezone' => 'nullable|string',
        ]);

        $availability->update([
            'date' => $validated['date'],
            'slots' => $validated['slots'],
            'mode' => $validated['mode'],
            'timezone' => $validated['timezone'] ?? null,
        ]);

        return redirect()->route('admin.therapist-availability.single', ['therapist_id' => $validated['therapist_id']])
            ->with('success', 'Single day availability updated.');
    }

    public function destroySingle(Request $request, TherapistSingleAvailability $availability)
    {
        $this->checkSuperAdmin();
        $therapistId = $availability->therapist_id;
        $availability->delete();
        return redirect()->route('admin.therapist-availability.single', ['therapist_id' => $therapistId])
            ->with('success', 'Single day availability deleted.');
    }

    /**
     * Block Availability
     */
    public function block(Request $request)
    {
        $this->checkSuperAdmin();
        
        $therapistId = $request->get('therapist_id');
        
        if (!$therapistId) {
            return redirect()->route('admin.therapist-availability.index')
                ->with('error', 'Please select a therapist.');
        }
        
        $therapist = User::findOrFail($therapistId);
        if (!$therapist->hasRole('Therapist')) {
            return redirect()->route('admin.therapist-availability.index')
                ->with('error', 'Selected user is not a therapist.');
        }
        
        $blocks = TherapistAvailabilityBlock::where('therapist_id', $therapistId)->latest()->get();
        return view('admin.therapist-availability.block', compact('blocks', 'therapist'));
    }

    public function storeBlockDate(Request $request)
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'therapist_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        $therapist = User::findOrFail($validated['therapist_id']);
        if (!$therapist->hasRole('Therapist')) {
            return back()->withErrors(['therapist_id' => 'Selected user is not a therapist.'])->withInput();
        }

        TherapistAvailabilityBlock::create([
            'therapist_id' => $validated['therapist_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'] ?? null,
        ]);

        return redirect()->route('admin.therapist-availability.block', ['therapist_id' => $validated['therapist_id']])
            ->with('success', 'Dates blocked successfully.');
    }

    public function storeBlockSlots(Request $request)
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'therapist_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'blocked_slots' => 'required|array|min:1|max:4',
            'blocked_slots.*.start' => 'required|date_format:H:i',
            'blocked_slots.*.end' => 'required|date_format:H:i',
            'reason' => 'nullable|string',
        ]);

        $therapist = User::findOrFail($validated['therapist_id']);
        if (!$therapist->hasRole('Therapist')) {
            return back()->withErrors(['therapist_id' => 'Selected user is not a therapist.'])->withInput();
        }

        TherapistAvailabilityBlock::create([
            'therapist_id' => $validated['therapist_id'],
            'date' => $validated['date'],
            'blocked_slots' => $validated['blocked_slots'],
            'reason' => $validated['reason'] ?? null,
        ]);

        return redirect()->route('admin.therapist-availability.block', ['therapist_id' => $validated['therapist_id']])
            ->with('success', 'Slots blocked successfully.');
    }

    public function updateBlockDate(Request $request, TherapistAvailabilityBlock $block)
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'therapist_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        $block->update([
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'] ?? null,
        ]);

        return redirect()->route('admin.therapist-availability.block', ['therapist_id' => $validated['therapist_id']])
            ->with('success', 'Date block updated successfully.');
    }

    public function updateBlockSlots(Request $request, TherapistAvailabilityBlock $block)
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'therapist_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'blocked_slots' => 'required|array|min:1|max:4',
            'blocked_slots.*.start' => 'required|date_format:H:i',
            'blocked_slots.*.end' => 'required|date_format:H:i',
            'reason' => 'nullable|string',
        ]);

        $block->update([
            'date' => $validated['date'],
            'blocked_slots' => $validated['blocked_slots'],
            'reason' => $validated['reason'] ?? null,
        ]);

        return redirect()->route('admin.therapist-availability.block', ['therapist_id' => $validated['therapist_id']])
            ->with('success', 'Slot block updated successfully.');
    }

    public function toggleBlock(Request $request, TherapistAvailabilityBlock $block)
    {
        $this->checkSuperAdmin();
        $block->is_active = !$block->is_active;
        $block->save();
        return redirect()->route('admin.therapist-availability.block', ['therapist_id' => $block->therapist_id])
            ->with('success', $block->is_active ? 'Block restored.' : 'Block disabled.');
    }

    public function destroyBlock(Request $request, TherapistAvailabilityBlock $block)
    {
        $this->checkSuperAdmin();
        $therapistId = $block->therapist_id;
        $block->delete();
        return redirect()->route('admin.therapist-availability.block', ['therapist_id' => $therapistId])
            ->with('success', 'Block deleted.');
    }
}
