<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReward extends Model
{
    protected $fillable = [
        'user_id',
        'reward_id',
        'coupon_code',
        'status',
        'claimed_at',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'claimed_at' => 'datetime',
            'used_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the reward
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reward
     */
    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
}
