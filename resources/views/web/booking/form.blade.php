@extends('layouts.app')

@section('title', 'Book Session with ' . $therapist->name . ' - TalkToAngel Clone')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center">
                <img src="{{ $therapist->avatar }}" 
                     alt="{{ $therapist->name }}" 
                     class="h-12 w-12 rounded-full object-cover">
                <div class="ml-4">
                    <h1 class="text-2xl font-bold text-gray-900">Book Session with {{ $therapist->name }}</h1>
                    <p class="text-gray-600">{{ $therapist->therapistProfile->qualification ?? 'Licensed Therapist' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Booking Form -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Session Details</h2>
                    </div>
                    <div class="px-6 py-6">
                        <form method="POST" action="{{ route('booking.store') }}" id="bookingForm">
                            @csrf
                            <input type="hidden" name="therapist_id" value="{{ $therapist->id }}">

                            <!-- Session Type -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Session Type</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="appointment_type" value="individual" 
                                               class="sr-only peer" checked>
                                        <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-primary-500 peer-checked:bg-primary-50">
                                            <div class="text-center">
                                                <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                <div class="font-medium text-gray-900">Individual</div>
                                                <div class="text-sm text-gray-500">One-on-one session</div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="appointment_type" value="couple" 
                                               class="sr-only peer">
                                        <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-primary-500 peer-checked:bg-primary-50">
                                            <div class="text-center">
                                                <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                </svg>
                                                <div class="font-medium text-gray-900">Couple</div>
                                                <div class="text-sm text-gray-500">Couple therapy</div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="appointment_type" value="family" 
                                               class="sr-only peer">
                                        <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-primary-500 peer-checked:bg-primary-50">
                                            <div class="text-center">
                                                <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                <div class="font-medium text-gray-900">Family</div>
                                                <div class="text-sm text-gray-500">Family therapy</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Session Mode -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Session Mode</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="session_mode" value="video" 
                                               class="sr-only peer" checked>
                                        <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-primary-500 peer-checked:bg-primary-50">
                                            <div class="text-center">
                                                <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                                <div class="font-medium text-gray-900">Video Call</div>
                                                <div class="text-sm text-gray-500">Face-to-face session</div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="session_mode" value="audio" 
                                               class="sr-only peer">
                                        <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-primary-500 peer-checked:bg-primary-50">
                                            <div class="text-center">
                                                <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                                                </svg>
                                                <div class="font-medium text-gray-900">Audio Call</div>
                                                <div class="text-sm text-gray-500">Voice-only session</div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="session_mode" value="chat" 
                                               class="sr-only peer">
                                        <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-primary-500 peer-checked:bg-primary-50">
                                            <div class="text-center">
                                                <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                </svg>
                                                <div class="font-medium text-gray-900">Chat</div>
                                                <div class="text-sm text-gray-500">Text-based session</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Date Selection -->
                            <div class="mb-6">
                                <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Select Date
                                </label>
                                <input type="date" 
                                       name="appointment_date" 
                                       id="appointment_date"
                                       min="{{ today()->toDateString() }}"
                                       class="form-input"
                                       required>
                            </div>

                            <!-- Time Selection -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Select Time
                                </label>
                                <div id="timeSlots" class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                    <div class="text-center py-4 text-gray-500">
                                        Please select a date first
                                    </div>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="mb-6">
                                <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Session Duration
                                </label>
                                <select name="duration_minutes" id="duration_minutes" class="form-select" required>
                                    <option value="30">30 minutes</option>
                                    <option value="45" selected>45 minutes</option>
                                    <option value="60">60 minutes</option>
                                    <option value="90">90 minutes</option>
                                    <option value="120">120 minutes</option>
                                </select>
                            </div>

                            <!-- Notes -->
                            <div class="mb-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Additional Notes (Optional)
                                </label>
                                <textarea name="notes" 
                                          id="notes" 
                                          rows="3" 
                                          class="form-textarea"
                                          placeholder="Any specific concerns or topics you'd like to discuss..."></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="btn-primary">
                                    Book Session
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg sticky top-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Booking Summary</h3>
                    </div>
                    <div class="px-6 py-4">
                        <!-- Therapist Info -->
                        <div class="flex items-center mb-4">
                            <img src="{{ $therapist->avatar }}" 
                                 alt="{{ $therapist->name }}" 
                                 class="h-12 w-12 rounded-full object-cover">
                            <div class="ml-3">
                                <div class="font-medium text-gray-900">{{ $therapist->name }}</div>
                                <div class="text-sm text-gray-500">{{ $therapist->therapistProfile->qualification ?? 'Licensed Therapist' }}</div>
                            </div>
                        </div>

                        <!-- Session Details -->
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Session Type</span>
                                <span class="text-sm font-medium" id="summaryType">Individual</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Mode</span>
                                <span class="text-sm font-medium" id="summaryMode">Video Call</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Date</span>
                                <span class="text-sm font-medium" id="summaryDate">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Time</span>
                                <span class="text-sm font-medium" id="summaryTime">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Duration</span>
                                <span class="text-sm font-medium" id="summaryDuration">45 minutes</span>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium text-gray-900">Total</span>
                                <span class="text-xl font-bold text-primary-600" id="summaryPrice">
                                    ₹{{ number_format($therapist->therapistProfile->consultation_fee) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Payment will be processed after booking</p>
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
        document.getElementById('summaryDate').textContent = date ? new Date(date).toLocaleDateString() : '-';
        document.getElementById('summaryTime').textContent = selectedTime ? selectedTime.nextElementSibling.textContent : '-';
        document.getElementById('summaryDuration').textContent = duration + ' minutes';
    }
    
    // Load time slots when date is selected
    dateInput.addEventListener('change', function() {
        if (this.value) {
            loadTimeSlots(this.value);
            updateSummary();
        }
    });
    
    // Update summary when other fields change
    document.querySelectorAll('input[name="appointment_type"], input[name="session_mode"], #duration_minutes').forEach(input => {
        input.addEventListener('change', updateSummary);
    });
    
    function loadTimeSlots(date) {
        timeSlotsContainer.innerHTML = '<div class="col-span-full text-center py-4 text-gray-500">Loading available slots...</div>';
        
        fetch(`{{ route('booking.slots') }}?therapist_id=${therapistId}&date=${date}`)
            .then(response => response.json())
            .then(data => {
                if (data.slots && data.slots.length > 0) {
                    timeSlotsContainer.innerHTML = '';
                    data.slots.forEach(slot => {
                        const slotElement = document.createElement('label');
                        slotElement.className = 'relative cursor-pointer';
                        slotElement.innerHTML = `
                            <input type="radio" name="appointment_time" value="${slot.time}" class="sr-only peer">
                            <div class="p-3 text-center border-2 border-gray-200 rounded-lg peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:border-gray-300">
                                <div class="font-medium text-gray-900">${slot.formatted_time}</div>
                            </div>
                        `;
                        slotElement.addEventListener('change', updateSummary);
                        timeSlotsContainer.appendChild(slotElement);
                    });
                } else {
                    timeSlotsContainer.innerHTML = '<div class="col-span-full text-center py-4 text-gray-500">No available slots for this date</div>';
                }
            })
            .catch(error => {
                timeSlotsContainer.innerHTML = '<div class="col-span-full text-center py-4 text-red-500">Error loading time slots</div>';
            });
    }
});
</script>
@endsection
