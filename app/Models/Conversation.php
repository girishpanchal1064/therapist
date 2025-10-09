<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'type',
        'last_message_at',
    ];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
        ];
    }

    /**
     * Get the appointment.
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the participants.
     */
    public function participants()
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    /**
     * Get the messages.
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get the latest message.
     */
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    /**
     * Add participant to conversation.
     */
    public function addParticipant($userId)
    {
        $this->participants()->firstOrCreate([
            'user_id' => $userId,
            'joined_at' => now(),
        ]);
    }

    /**
     * Remove participant from conversation.
     */
    public function removeParticipant($userId)
    {
        $this->participants()->where('user_id', $userId)->update([
            'left_at' => now(),
        ]);
    }

    /**
     * Check if user is participant.
     */
    public function hasParticipant($userId)
    {
        return $this->participants()
            ->where('user_id', $userId)
            ->whereNull('left_at')
            ->exists();
    }

    /**
     * Get unread message count for user.
     */
    public function getUnreadCountForUser($userId)
    {
        $lastReadAt = $this->participants()
            ->where('user_id', $userId)
            ->value('last_read_at');

        if (!$lastReadAt) {
            return $this->messages()->count();
        }

        return $this->messages()
            ->where('created_at', '>', $lastReadAt)
            ->where('sender_id', '!=', $userId)
            ->count();
    }

    /**
     * Mark messages as read for user.
     */
    public function markAsReadForUser($userId)
    {
        $this->participants()
            ->where('user_id', $userId)
            ->update([
                'last_read_at' => now(),
            ]);
    }

    /**
     * Update last message timestamp.
     */
    public function updateLastMessageAt()
    {
        $this->last_message_at = now();
        $this->save();
    }
}