<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'message_type',
        'content',
        'attachment_url',
        'attachment_type',
        'attachment_size',
        'is_read',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    /**
     * Get the conversation.
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get the sender.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Mark message as read.
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->is_read = true;
            $this->read_at = now();
            $this->save();
        }
    }

    /**
     * Check if message is text.
     */
    public function isText()
    {
        return $this->message_type === 'text';
    }

    /**
     * Check if message has attachment.
     */
    public function hasAttachment()
    {
        return in_array($this->message_type, ['file', 'image', 'voice', 'video']) && $this->attachment_url;
    }

    /**
     * Get formatted file size.
     */
    public function getFormattedFileSizeAttribute()
    {
        if (!$this->attachment_size) {
            return null;
        }

        $bytes = $this->attachment_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get attachment icon.
     */
    public function getAttachmentIconAttribute()
    {
        return match($this->message_type) {
            'file' => 'document',
            'image' => 'photo',
            'voice' => 'microphone',
            'video' => 'video-camera',
            default => 'document',
        };
    }

    /**
     * Get formatted time.
     */
    public function getFormattedTimeAttribute()
    {
        return $this->created_at->format('g:i A');
    }

    /**
     * Get relative time.
     */
    public function getRelativeTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}