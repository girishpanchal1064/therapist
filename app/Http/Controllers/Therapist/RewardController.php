<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\UserReward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    /**
     * Display a listing of available rewards
     */
    public function index()
    {
        $user = Auth::user();
        $now = now();

        // Get available rewards for therapists
        $rewards = Reward::where('is_active', true)
            ->where(function ($query) {
                $query->where('applicable_for', 'therapist')
                      ->orWhere('applicable_for', 'both');
            })
            ->where('valid_from', '<=', $now)
            ->where('valid_until', '>=', $now)
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get user's claimed rewards
        $claimedRewards = UserReward::where('user_id', $user->id)
            ->with('reward')
            ->orderBy('claimed_at', 'desc')
            ->get();

        return view('therapist.rewards.index', compact('rewards', 'claimedRewards'));
    }

    /**
     * Display the specified reward
     */
    public function show($id)
    {
        $user = Auth::user();
        $reward = Reward::findOrFail($id);

        // Check if reward is applicable for therapist
        if ($reward->applicable_for !== 'therapist' && $reward->applicable_for !== 'both') {
            abort(403, 'This reward is not available for therapists.');
        }

        // Check if user has already claimed this reward
        $userReward = UserReward::where('user_id', $user->id)
            ->where('reward_id', $reward->id)
            ->where('status', '!=', 'expired')
            ->first();

        return view('therapist.rewards.show', compact('reward', 'userReward'));
    }

    /**
     * Claim a reward
     */
    public function claim($id)
    {
        $user = Auth::user();
        $reward = Reward::findOrFail($id);

        // Check if reward can be claimed
        if (!$reward->canBeClaimedBy($user)) {
            return redirect()->route('therapist.rewards.index')
                ->with('error', 'This reward cannot be claimed at this time.');
        }

        // Check if user already claimed and can't use multiple times
        if (!$reward->can_use_multiple_times) {
            $existingClaim = UserReward::where('user_id', $user->id)
                ->where('reward_id', $reward->id)
                ->where('status', '!=', 'expired')
                ->first();

            if ($existingClaim) {
                return redirect()->route('therapist.rewards.show', $reward->id)
                    ->with('info', 'You have already claimed this reward.');
            }
        }

        // Create user reward
        UserReward::create([
            'user_id' => $user->id,
            'reward_id' => $reward->id,
            'coupon_code' => $reward->coupon_code,
            'status' => 'claimed',
            'claimed_at' => now(),
        ]);

        return redirect()->route('therapist.rewards.show', $reward->id)
            ->with('success', 'Reward claimed successfully! Your coupon code is: ' . $reward->coupon_code);
    }
}
