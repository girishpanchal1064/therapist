@extends('layouts.app')

@section('title', 'Profile Settings - Apani Psychology')
@section('description', 'Manage your profile information, preferences, and account settings.')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Profile Settings</h1>
                    <p class="text-gray-600 mt-2">Manage your profile information and account settings.</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Last updated</p>
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="space-y-6">
                    <!-- Profile Overview -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="text-center">
                            <div class="relative inline-block">
                                @if($profile->profile_image)
                                    <img src="{{ $profile->profile_image_url }}" alt="Profile" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                                @else
                                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold border-4 border-white shadow-lg">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-4 border-white"></div>
                            </div>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ Auth::user()->name }}</h3>
                            <p class="text-sm text-gray-600 capitalize">{{ Auth::user()->role }}</p>
                            <div class="mt-3 flex items-center justify-center space-x-4 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Member since {{ Auth::user()->created_at->format('M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Settings</h3>
                        <nav class="space-y-2">
                            <a href="#profile-info" class="profile-nav-item active flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profile Information
                            </a>
                            <a href="#account-settings" class="profile-nav-item flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Account Settings
                            </a>
                            <a href="#security" class="profile-nav-item flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Security
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <div class="space-y-8">
                    <!-- Profile Information -->
                    <div id="profile-info" class="profile-section">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900">Profile Information</h2>
                                <p class="text-sm text-gray-600 mt-1">Update your personal information and preferences.</p>
                            </div>

                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6">
                                @csrf
                                @method('PUT')

                                <!-- Profile Image Section -->
                                <div class="mb-8">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Profile Picture</label>
                                    <div class="flex items-center space-x-6">
                                        <div class="relative">
                                            @if($profile->profile_image)
                                                <img src="{{ $profile->profile_image_url }}" alt="Profile" class="w-20 h-20 rounded-full object-cover border-4 border-gray-200">
                                            @else
                                                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xl font-bold border-4 border-gray-200">
                                                    {{ substr(Auth::user()->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <input type="file" id="profile_image" name="profile_image" accept="image/*"
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            @error('profile_image')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                            @if($profile->profile_image)
                                                <button type="button" onclick="deleteProfileImage()"
                                                        class="mt-2 text-sm text-red-600 hover:text-red-800 font-medium">
                                                    Remove current image
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Personal Information -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $profile->first_name) }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('first_name') border-red-500 @enderror" required>
                                        @error('first_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $profile->last_name) }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_name') border-red-500 @enderror" required>
                                        @error('last_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $profile->date_of_birth?->format('Y-m-d')) }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date_of_birth') border-red-500 @enderror">
                                        @error('date_of_birth')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                        <select id="gender" name="gender" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gender') border-red-500 @enderror">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender', $profile->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $profile->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender', $profile->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                            <option value="prefer_not_to_say" {{ old('gender', $profile->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                        </select>
                                        @error('gender')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Bio -->
                                <div class="mb-6">
                                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                    <textarea id="bio" name="bio" rows="4"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('bio') border-red-500 @enderror"
                                              placeholder="Tell us about yourself...">{{ old('bio', $profile->bio) }}</textarea>
                                    @error('bio')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Address Information -->
                                <div class="border-t border-gray-200 pt-6 mb-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Address Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="md:col-span-2">
                                            <label for="address_line1" class="block text-sm font-medium text-gray-700 mb-2">Address Line 1</label>
                                            <input type="text" id="address_line1" name="address_line1" value="{{ old('address_line1', $profile->address_line1) }}"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address_line1') border-red-500 @enderror">
                                            @error('address_line1')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="md:col-span-2">
                                            <label for="address_line2" class="block text-sm font-medium text-gray-700 mb-2">Address Line 2</label>
                                            <input type="text" id="address_line2" name="address_line2" value="{{ old('address_line2', $profile->address_line2) }}"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address_line2') border-red-500 @enderror">
                                            @error('address_line2')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                            <input type="text" id="city" name="city" value="{{ old('city', $profile->city) }}"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('city') border-red-500 @enderror">
                                            @error('city')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State</label>
                                            <input type="text" id="state" name="state" value="{{ old('state', $profile->state) }}"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('state') border-red-500 @enderror">
                                            @error('state')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                                            <input type="text" id="country" name="country" value="{{ old('country', $profile->country) }}"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('country') border-red-500 @enderror">
                                            @error('country')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="pincode" class="block text-sm font-medium text-gray-700 mb-2">Pincode</label>
                                            <input type="text" id="pincode" name="pincode" value="{{ old('pincode', $profile->pincode) }}"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pincode') border-red-500 @enderror">
                                            @error('pincode')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Emergency Contact -->
                                <div class="border-t border-gray-200 pt-6 mb-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Emergency Contact</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact Name</label>
                                            <input type="text" id="emergency_contact_name" name="emergency_contact_name"
                                                   value="{{ old('emergency_contact_name', $profile->emergency_contact_name) }}"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('emergency_contact_name') border-red-500 @enderror">
                                            @error('emergency_contact_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact Phone</label>
                                            <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone"
                                                   value="{{ old('emergency_contact_phone', $profile->emergency_contact_phone) }}"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('emergency_contact_phone') border-red-500 @enderror">
                                            @error('emergency_contact_phone')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Preferences -->
                                <div class="border-t border-gray-200 pt-6 mb-8">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Preferences</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="preferred_language" class="block text-sm font-medium text-gray-700 mb-2">Preferred Language</label>
                                            <select id="preferred_language" name="preferred_language" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('preferred_language') border-red-500 @enderror">
                                                <option value="">Select Language</option>
                                                <option value="en" {{ old('preferred_language', $profile->preferred_language) == 'en' ? 'selected' : '' }}>English</option>
                                                <option value="hi" {{ old('preferred_language', $profile->preferred_language) == 'hi' ? 'selected' : '' }}>Hindi</option>
                                                <option value="es" {{ old('preferred_language', $profile->preferred_language) == 'es' ? 'selected' : '' }}>Spanish</option>
                                                <option value="fr" {{ old('preferred_language', $profile->preferred_language) == 'fr' ? 'selected' : '' }}>French</option>
                                                <option value="de" {{ old('preferred_language', $profile->preferred_language) == 'de' ? 'selected' : '' }}>German</option>
                                            </select>
                                            @error('preferred_language')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                        Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Account Settings -->
                    <div id="account-settings" class="profile-section hidden">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900">Account Information</h2>
                                <p class="text-sm text-gray-600 mt-1">View your account details and settings.</p>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                                        <p class="text-gray-900 font-medium">{{ Auth::user()->email }}</p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Account Role</label>
                                        <p class="text-gray-900 font-medium capitalize">{{ Auth::user()->role }}</p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Member Since</label>
                                        <p class="text-gray-900 font-medium">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                                        <p class="text-gray-900 font-medium">{{ Auth::user()->updated_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security -->
                    <div id="security" class="profile-section hidden">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900">Change Password</h2>
                                <p class="text-sm text-gray-600 mt-1">Update your password to keep your account secure.</p>
                            </div>
                            <form method="POST" action="{{ route('profile.password.update') }}" class="p-6">
                                @csrf
                                @method('PUT')

                                <div class="space-y-6">
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                        <input type="password" id="current_password" name="current_password"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_password') border-red-500 @enderror" required>
                                        @error('current_password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                        <input type="password" id="password" name="password"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror" required>
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Profile Image Form -->
<form id="delete-profile-image-form" method="POST" action="{{ route('profile.image.delete') }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
.profile-nav-item {
    color: #6b7280;
}

.profile-nav-item:hover {
    background-color: #f3f4f6;
    color: #374151;
}

.profile-nav-item.active {
    background-color: #dbeafe;
    color: #1d4ed8;
}

.profile-section {
    display: block;
}

.profile-section.hidden {
    display: none;
}
</style>

<script>
function deleteProfileImage() {
    if (confirm('Are you sure you want to delete your profile image?')) {
        document.getElementById('delete-profile-image-form').submit();
    }
}

// Navigation functionality
document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.profile-nav-item');
    const sections = document.querySelectorAll('.profile-section');

    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            // Remove active class from all nav items
            navItems.forEach(nav => nav.classList.remove('active'));

            // Add active class to clicked item
            this.classList.add('active');

            // Hide all sections
            sections.forEach(section => section.classList.add('hidden'));

            // Show target section
            const targetId = this.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.classList.remove('hidden');
            }
        });
    });
});
</script>
@endsection
