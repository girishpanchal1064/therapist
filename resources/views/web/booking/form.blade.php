@extends('layouts.app')

@section('title', 'Book Session with ' . $therapist->name . ' - Apani Psychology')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Enhanced Header -->
    <div class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center">
                <div class="relative">
                    <img src="{{ $therapist->avatar }}"
                         alt="{{ $therapist->name }}"
                         class="h-16 w-16 rounded-full object-cover border-4 border-white shadow-lg">
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-400 border-2 border-white rounded-full"></div>
                </div>
                <div class="ml-6">
                    <h1 class="text-3xl font-bold text-gray-900">Book Session with {{ $therapist->name }}</h1>
                    <p class="text-lg text-gray-600 mt-1">{{ $therapist->therapistProfile->qualification ?? 'Licensed Therapist' }}</p>
                    <div class="flex items-center mt-2">
                        <div class="flex text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="ml-2 text-sm text-gray-600">(4.8) • 127 reviews</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Enhanced Booking Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                    <!-- Session Details Header -->
                    <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-8 py-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Session Details</h2>
                                <p class="text-primary-100 mt-1">Configure your therapy session</p>
                            </div>
                        </div>
                    </div>

                    <div class="px-8 py-8">
                        <form method="POST" action="{{ route('booking.store') }}" id="bookingForm">
                            @csrf
                            <input type="hidden" name="therapist_id" value="{{ $therapist->id }}">

                            <!-- Session Type -->
                            <div class="mb-8">
                                <label class="block text-lg font-semibold text-gray-900 mb-4">Session Type</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="appointment_type" value="individual"
                                               class="sr-only peer" checked>
                                        <div class="p-6 border-2 border-gray-200 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 group-hover:border-primary-300 transition-all duration-200">
                                            <div class="text-center">
                                                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                                <div class="font-semibold text-gray-900">Individual</div>
                                                <div class="text-sm text-gray-600 mt-1">One-on-one session</div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="appointment_type" value="couple"
                                               class="sr-only peer">
                                        <div class="p-6 border-2 border-gray-200 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 group-hover:border-primary-300 transition-all duration-200">
                                            <div class="text-center">
                                                <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                    </svg>
                                                </div>
                                                <div class="font-semibold text-gray-900">Couple</div>
                                                <div class="text-sm text-gray-600 mt-1">Couple therapy</div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="appointment_type" value="family"
                                               class="sr-only peer">
                                        <div class="p-6 border-2 border-gray-200 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 group-hover:border-primary-300 transition-all duration-200">
                                            <div class="text-center">
                                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                    </svg>
                                                </div>
                                                <div class="font-semibold text-gray-900">Family</div>
                                                <div class="text-sm text-gray-600 mt-1">Family therapy</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Session Mode -->
                            <div class="mb-8">
                                <label class="block text-lg font-semibold text-gray-900 mb-4">Session Mode</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="session_mode" value="video"
                                               class="sr-only peer" checked>
                                        <div class="p-6 border-2 border-gray-200 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 group-hover:border-primary-300 transition-all duration-200">
                                            <div class="text-center">
                                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                                <div class="font-semibold text-gray-900">Video Call</div>
                                                <div class="text-sm text-gray-600 mt-1">Face-to-face session</div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="session_mode" value="audio"
                                               class="sr-only peer">
                                        <div class="p-6 border-2 border-gray-200 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 group-hover:border-primary-300 transition-all duration-200">
                                            <div class="text-center">
                                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                                                    </svg>
                                                </div>
                                                <div class="font-semibold text-gray-900">Audio Call</div>
                                                <div class="text-sm text-gray-600 mt-1">Voice-only session</div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="session_mode" value="chat"
                                               class="sr-only peer">
                                        <div class="p-6 border-2 border-gray-200 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 group-hover:border-primary-300 transition-all duration-200">
                                            <div class="text-center">
                                                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                    </svg>
                                                </div>
                                                <div class="font-semibold text-gray-900">Chat</div>
                                                <div class="text-sm text-gray-600 mt-1">Text-based session</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Date and Time Selection -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <!-- Date Selection -->
                                <div>
                                    <label for="appointment_date" class="block text-lg font-semibold text-gray-900 mb-3">
                                        Select Date
                                    </label>
                                    <div class="relative">
                                        <input type="date"
                                               name="appointment_date"
                                               id="appointment_date"
                                               min="{{ today()->toDateString() }}"
                                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                               required>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Duration -->
                                <div>
                                    <label for="duration_minutes" class="block text-lg font-semibold text-gray-900 mb-3">
                                        Session Duration
                                    </label>
                                    <select name="duration_minutes" id="duration_minutes" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" required>
                                        <option value="30">30 minutes</option>
                                        <option value="45" selected>45 minutes</option>
                                        <option value="60">60 minutes</option>
                                        <option value="90">90 minutes</option>
                                        <option value="120">120 minutes</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Time Selection -->
                            <div class="mb-8">
                                <label class="block text-lg font-semibold text-gray-900 mb-3">
                                    Select Time
                                </label>
                                <div id="timeSlots" class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    <div class="col-span-full text-center py-8 text-gray-500 bg-gray-50 rounded-xl">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Please select a date first
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="mb-8">
                                <label for="notes" class="block text-lg font-semibold text-gray-900 mb-3">
                                    Additional Notes (Optional)
                                </label>
                                <textarea name="notes"
                                          id="notes"
                                          rows="4"
                                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"
                                          placeholder="Any specific concerns or topics you'd like to discuss..."></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="px-8 py-4 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl hover:from-primary-700 hover:to-secondary-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Book Session
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Enhanced Booking Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 sticky top-6 overflow-hidden">
                    <!-- Summary Header -->
                    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-6">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Booking Summary</h3>
                                <p class="text-gray-300 text-sm">Review your session details</p>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-6">
                        <!-- Therapist Info -->
                        <div class="flex items-center mb-6 p-4 bg-gray-50 rounded-xl">
                            <img src="{{ $therapist->avatar }}"
                                 alt="{{ $therapist->name }}"
                                 class="h-14 w-14 rounded-full object-cover border-2 border-white shadow-sm">
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">{{ $therapist->name }}</div>
                                <div class="text-sm text-gray-600">{{ $therapist->therapistProfile->qualification ?? 'Licensed Therapist' }}</div>
                                <div class="flex items-center mt-1">
                                    <div class="flex text-yellow-400">
                                        @for($i = 0; $i < 5; $i++)
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="ml-1 text-xs text-gray-500">4.8 (127)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Session Details -->
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Session Type</span>
                                <span class="text-sm font-semibold text-gray-900" id="summaryType">Individual</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Mode</span>
                                <span class="text-sm font-semibold text-gray-900" id="summaryMode">Video Call</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Date</span>
                                <span class="text-sm font-semibold text-gray-900" id="summaryDate">-</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Time</span>
                                <span class="text-sm font-semibold text-gray-900" id="summaryTime">-</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-gray-600">Duration</span>
                                <span class="text-sm font-semibold text-gray-900" id="summaryDuration">45 minutes</span>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="bg-gradient-to-r from-primary-50 to-secondary-50 rounded-xl p-4 border border-primary-200">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-lg font-semibold text-gray-900">Total Amount</span>
                                <span class="text-2xl font-bold text-primary-600" id="summaryPrice">
                                    ₹{{ number_format($therapist->therapistProfile->consultation_fee) }}
                                </span>
                            </div>

                            <!-- Pricing Breakdown -->
                            <div id="pricingBreakdown" class="mb-3 p-3 bg-white bg-opacity-60 rounded-lg border border-primary-100">
                                <div class="text-xs text-gray-600 mb-1">Base Rate (45 min): ₹{{ number_format($therapist->therapistProfile->consultation_fee) }}</div>
                                <div class="text-xs text-gray-600 mb-1">Duration (45 minutes): 100%</div>
                            </div>

                            <div class="flex items-center text-xs text-gray-600">
                                <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Payment will be processed after booking confirmation
                            </div>
                        </div>

                        <!-- Security Badge -->
                        <div class="mt-4 flex items-center justify-center text-xs text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Secure & Encrypted Booking
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('appointment_date');
    const timeSlotsContainer = document.getElementById('timeSlots');
    const therapistId = {{ $therapist->id }};

    // Update summary when form changes
    function updateSummary() {
        const sessionType = document.querySelector('input[name="appointment_type"]:checked').value;
        const sessionMode = document.querySelector('input[name="session_mode"]:checked').value;
        const duration = document.getElementById('duration_minutes').value;
        const date = dateInput.value;
        const selectedTime = document.querySelector('input[name="appointment_time"]:checked');

        document.getElementById('summaryType').textContent = sessionType.charAt(0).toUpperCase() + sessionType.slice(1);
        document.getElementById('summaryMode').textContent = sessionMode.charAt(0).toUpperCase() + sessionMode.slice(1) + ' Call';
        
        // Format date consistently (DD/MM/YYYY) to match selected date format
        if (date) {
            const dateObj = new Date(date + 'T00:00:00');
            const day = String(dateObj.getDate()).padStart(2, '0');
            const month = String(dateObj.getMonth() + 1).padStart(2, '0');
            const year = dateObj.getFullYear();
            document.getElementById('summaryDate').textContent = `${day}/${month}/${year}`;
        } else {
            document.getElementById('summaryDate').textContent = '-';
        }
        
        document.getElementById('summaryTime').textContent = selectedTime ? selectedTime.nextElementSibling.querySelector('.font-semibold').textContent : '-';
        document.getElementById('summaryDuration').textContent = duration + ' minutes';

        // Update pricing based on duration
        updatePricing(duration, sessionType);
    }

    // Calculate pricing based on duration and session type
    function updatePricing(duration, sessionType) {
        const basePrice = {{ $therapist->therapistProfile->consultation_fee }};
        let multiplier = 1;

        // Calculate multiplier based on duration (45 minutes = base price)
        switch(parseInt(duration)) {
            case 30:
                multiplier = 0.7; // 30% discount for shorter sessions
                break;
            case 45:
                multiplier = 1.0; // Base price
                break;
            case 60:
                multiplier = 1.3; // 30% premium for longer sessions
                break;
            case 90:
                multiplier = 1.8; // 80% premium for extended sessions
                break;
            case 120:
                multiplier = 2.2; // 120% premium for very long sessions
                break;
        }

        // Apply session type multiplier
        if (sessionType === 'couple') {
            multiplier *= 1.5; // 50% premium for couple sessions
        } else if (sessionType === 'family') {
            multiplier *= 2.0; // 100% premium for family sessions
        }

        const totalPrice = Math.round(basePrice * multiplier);
        document.getElementById('summaryPrice').textContent = `₹${totalPrice.toLocaleString()}`;

        // Update pricing breakdown if element exists
        const pricingBreakdown = document.getElementById('pricingBreakdown');
        if (pricingBreakdown) {
            const durationText = duration + ' minutes';
            const sessionTypeText = sessionType.charAt(0).toUpperCase() + sessionType.slice(1);

            // Calculate duration multiplier separately
            let durationMultiplier = 1;
            switch(parseInt(duration)) {
                case 30: durationMultiplier = 0.7; break;
                case 45: durationMultiplier = 1.0; break;
                case 60: durationMultiplier = 1.3; break;
                case 90: durationMultiplier = 1.8; break;
                case 120: durationMultiplier = 2.2; break;
            }

            pricingBreakdown.innerHTML = `
                <div class="text-xs text-gray-600 mb-1">Base Rate (45 min): ₹${basePrice.toLocaleString()}</div>
                <div class="text-xs text-gray-600 mb-1">Duration (${durationText}): ${(durationMultiplier * 100).toFixed(0)}%</div>
                ${sessionType !== 'individual' ? `<div class="text-xs text-gray-600 mb-1">Session Type (${sessionTypeText}): ${sessionType === 'couple' ? '150%' : '200%'}</div>` : ''}
            `;
        }
    }

    // Load time slots when date is selected
    dateInput.addEventListener('change', function() {
        if (this.value) {
            loadTimeSlots(this.value);
            updateSummary();
        } else {
            timeSlotsContainer.innerHTML = `
                <div class="col-span-full text-center py-8 text-gray-500 bg-gray-50 rounded-xl">
                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Please select a date first
                </div>
            `;
            updateSummary();
        }
    });

    // Also load slots when session mode or duration changes
    document.querySelectorAll('input[name="session_mode"], #duration_minutes').forEach(input => {
        input.addEventListener('change', function() {
            if (dateInput.value) {
                loadTimeSlots(dateInput.value);
            }
        });
    });

    // Update summary when other fields change
    document.querySelectorAll('input[name="appointment_type"], input[name="session_mode"], #duration_minutes').forEach(input => {
        input.addEventListener('change', updateSummary);
    });

    function loadTimeSlots(date) {
        if (!date) {
            timeSlotsContainer.innerHTML = `
                <div class="col-span-full text-center py-8 text-gray-500 bg-gray-50 rounded-xl">
                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Please select a date first
                </div>
            `;
            return;
        }

        timeSlotsContainer.innerHTML = `
            <div class="col-span-full text-center py-8 text-gray-500 bg-gray-50 rounded-xl">
                <svg class="w-8 h-8 mx-auto mb-2 text-gray-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Loading available slots...
            </div>
        `;

        // Get session mode and duration
        const sessionMode = document.querySelector('input[name="session_mode"]:checked')?.value || 'video';
        const duration = document.getElementById('duration_minutes')?.value || 60;
        
        // Convert session_mode to match API expectations (video -> online, audio -> online, chat -> online)
        const apiMode = sessionMode === 'video' || sessionMode === 'audio' || sessionMode === 'chat' ? 'online' : 'offline';

        // Ensure date is in YYYY-MM-DD format
        const dateFormatted = date.includes('T') ? date.split('T')[0] : date;

        fetch(`{{ route('booking.slots') }}?therapist_id=${therapistId}&date=${dateFormatted}&session_mode=${apiMode}&duration_minutes=${duration}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
            .then(response => {
                // Check if response is ok
                if (!response.ok) {
                    // Try to parse error response
                    return response.json().then(err => {
                        throw new Error(err.error || err.message || 'Network response was not ok');
                    }).catch(() => {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                // Check if there's an error in the response
                if (data.error) {
                    throw new Error(data.error);
                }
                
                if (data.slots && data.slots.length > 0) {
                    timeSlotsContainer.innerHTML = '';
                    data.slots.forEach(slot => {
                        const slotElement = document.createElement('label');
                        slotElement.className = 'relative cursor-pointer group';
                        slotElement.innerHTML = `
                            <input type="radio" name="appointment_time" value="${slot.time}" class="sr-only peer">
                            <div class="p-4 text-center border-2 border-gray-200 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 group-hover:border-primary-300 transition-all duration-200">
                                <div class="font-semibold text-gray-900">${slot.formatted_time} - ${slot.formatted_end_time ?? ''}</div>
                                <div class="text-xs text-gray-500 mt-1">Available</div>
                            </div>
                        `;
                        slotElement.addEventListener('change', updateSummary);
                        timeSlotsContainer.appendChild(slotElement);
                    });
                } else {
                    timeSlotsContainer.innerHTML = `
                        <div class="col-span-full text-center py-8 text-gray-500 bg-gray-50 rounded-xl">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            No available slots for this date
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading time slots:', error);
                const errorMessage = error.message || 'An error occurred while loading time slots';
                timeSlotsContainer.innerHTML = `
                    <div class="col-span-full text-center py-8 text-red-500 bg-red-50 rounded-xl">
                        <svg class="w-8 h-8 mx-auto mb-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <div class="text-sm font-medium">${errorMessage}</div>
                        <div class="text-xs text-red-400 mt-1">Please try again or select a different date</div>
                    </div>
                `;
            });
    }

    // Load slots on page load if date is already selected
    if (dateInput.value) {
        loadTimeSlots(dateInput.value);
        updateSummary();
    }
});
</script>
@endsection
