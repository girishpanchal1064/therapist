<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reward extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'affiliation_url',
        'coupon_code',
        'discount_percentage',
        'discount_amount',
        'discount_type',
        'terms_conditions',
        'applicable_for',
        'applicable_on',
        'can_use_multiple_times',
        'max_uses_per_user',
        'total_max_uses',
        'valid_from',
        'valid_until',
        'is_active',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'discount_percentage' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'can_use_multiple_times' => 'boolean',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'valid_from' => 'date',
            'valid_until' => 'date',
        ];
    }

    /**
     * Get all user rewards for this reward
     */
    public function userRewards()
    {
        return $this->hasMany(UserReward::class);
    }

    /**
     * Check if reward is currently valid
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        return $now->between($this->valid_from, $this->valid_until);
    }

    /**
     * Check if user can claim this reward
     */
    public function canBeClaimedBy($user): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        // Check if applicable for user role
        if ($this->applicable_for === 'therapist' && !$user->hasRole('Therapist')) {
            return false;
        }
        if ($this->applicable_for === 'client' && !$user->hasRole('Client')) {
            return false;
        }

        // Check max uses per user
        if ($this->max_uses_per_user !== null) {
            $userClaimCount = UserReward::where('user_id', $user->id)
                ->where('reward_id', $this->id)
                ->where('status', '!=', 'expired')
                ->count();
            
            if ($userClaimCount >= $this->max_uses_per_user) {
                return false;
            }
        }

        // Check total max uses
        if ($this->total_max_uses !== null) {
            $totalClaimCount = UserReward::where('reward_id', $this->id)
                ->where('status', '!=', 'expired')
                ->count();
            
            if ($totalClaimCount >= $this->total_max_uses) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get discount display text
     */
    public function getDiscountTextAttribute(): string
    {
        if ($this->discount_type === 'percentage') {
            return $this->discount_percentage . '% off';
        }
        return '₹' . number_format($this->discount_amount, 2) . ' off';
    }
}
