<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'date_of_birth',
        'gender',
        'address',
        'profile_completed',
        'status',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'date_of_birth' => 'date',
            'password' => 'hashed',
            'profile_completed' => 'boolean',
        ];
    }

    /**
     * Get the user's profile.
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the user's therapist profile.
     */
    public function therapistProfile()
    {
        return $this->hasOne(TherapistProfile::class);
    }

    /**
     * Get the user's wallet.
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Get appointments as client.
     */
    public function appointmentsAsClient()
    {
        return $this->hasMany(Appointment::class, 'client_id');
    }

    /**
     * Get appointments as therapist.
     */
    public function appointmentsAsTherapist()
    {
        return $this->hasMany(Appointment::class, 'therapist_id');
    }

    /**
     * Get reviews as client.
     */
    public function reviewsAsClient()
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    /**
     * Get reviews as therapist.
     */
    public function reviewsAsTherapist()
    {
        return $this->hasMany(Review::class, 'therapist_id');
    }

    /**
     * Get payments.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get organizations.
     */
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_users');
    }

    /**
     * Get conversations.
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants');
    }

    /**
     * Get sent messages.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get user assessments.
     */
    public function assessments()
    {
        return $this->hasMany(UserAssessment::class);
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is therapist.
     */
    public function isTherapist()
    {
        return $this->role === 'therapist';
    }

    /**
     * Check if user is client.
     */
    public function isClient()
    {
        return $this->role === 'client';
    }

    /**
     * Check if user is corporate admin.
     */
    public function isCorporateAdmin()
    {
        return $this->role === 'corporate_admin';
    }

    /**
     * Check if user is active.
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Get full name.
     */
    public function getFullNameAttribute()
    {
        return $this->profile ?
            $this->profile->first_name . ' ' . $this->profile->last_name :
            $this->name;
    }

    /**
     * Get avatar URL.
     */
    public function getAvatarAttribute()
    {
        if ($this->attributes['avatar'] ?? null) {
            return asset('storage/' . $this->attributes['avatar']);
        }

        return $this->profile?->profile_image ?
            asset('storage/' . $this->profile->profile_image) :
            'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
}
