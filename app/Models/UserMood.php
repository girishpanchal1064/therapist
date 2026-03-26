<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMood extends Model
{
    /** @var list<string> */
    public const MOODS = ['great', 'good', 'okay', 'low', 'bad'];

    protected $fillable = [
        'user_id',
        'mood',
        'note',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
