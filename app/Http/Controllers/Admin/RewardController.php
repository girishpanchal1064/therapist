<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Reward::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('coupon_code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)
                      ->where('valid_from', '<=', now())
                      ->where('valid_until', '>=', now());
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'expired') {
                $query->where('valid_until', '<', now());
            }
        }

        // Filter by applicable for
        if ($request->filled('applicable_for')) {
            $query->where('applicable_for', $request->applicable_for);
        }

        $rewards = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.rewards.index', compact('rewards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rewards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'affiliation_url' => 'nullable|url|max:500',
            'coupon_code' => 'required|string|max:50|unique:rewards,coupon_code',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_percentage' => 'required_if:discount_type,percentage|nullable|numeric|min:0|max:100',
            'discount_amount' => 'required_if:discount_type,fixed|nullable|numeric|min:0',
            'terms_conditions' => 'nullable|string',
            'applicable_for' => 'required|in:therapist,client,both',
            'can_use_multiple_times' => 'boolean',
            'max_uses_per_user' => 'nullable|integer|min:1',
            'total_max_uses' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Generate coupon code if not provided
        if (empty($validated['coupon_code'])) {
            $validated['coupon_code'] = strtoupper(Str::random(8));
        } else {
            $validated['coupon_code'] = strtoupper($validated['coupon_code']);
        }

        $validated['can_use_multiple_times'] = $request->has('can_use_multiple_times');
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        Reward::create($validated);

        return redirect()->route('admin.rewards.index')
            ->with('success', 'Reward created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reward $reward)
    {
        return view('admin.rewards.show', compact('reward'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reward $reward)
    {
        return view('admin.rewards.edit', compact('reward'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reward $reward)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'affiliation_url' => 'nullable|url|max:500',
            'coupon_code' => 'required|string|max:50|unique:rewards,coupon_code,' . $reward->id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_percentage' => 'required_if:discount_type,percentage|nullable|numeric|min:0|max:100',
            'discount_amount' => 'required_if:discount_type,fixed|nullable|numeric|min:0',
            'terms_conditions' => 'nullable|string',
            'applicable_for' => 'required|in:therapist,client,both',
            'can_use_multiple_times' => 'boolean',
            'max_uses_per_user' => 'nullable|integer|min:1',
            'total_max_uses' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['coupon_code'] = strtoupper($validated['coupon_code']);
        $validated['can_use_multiple_times'] = $request->has('can_use_multiple_times');
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $reward->update($validated);

        return redirect()->route('admin.rewards.index')
            ->with('success', 'Reward updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reward $reward)
    {
        $reward->delete();

        return redirect()->route('admin.rewards.index')
            ->with('success', 'Reward deleted successfully!');
    }
}
