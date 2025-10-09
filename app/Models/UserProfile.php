<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'profile_image',
        'bio',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'country',
        'pincode',
        'preferred_language',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full name.
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the profile image URL.
     */
    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image ? 
            asset('storage/' . $this->profile_image) : 
            'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the full address.
     */
    public function getFullAddressAttribute()
    {
        $address = [];
        
        if ($this->address_line1) {
            $address[] = $this->address_line1;
        }
        
        if ($this->address_line2) {
            $address[] = $this->address_line2;
        }
        
        if ($this->city) {
            $address[] = $this->city;
        }
        
        if ($this->state) {
            $address[] = $this->state;
        }
        
        if ($this->country) {
            $address[] = $this->country;
        }
        
        if ($this->pincode) {
            $address[] = $this->pincode;
        }
        
        return implode(', ', $address);
    }
}