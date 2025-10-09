@extends('layouts.app')

@section('title', 'Complete Payment - TalkToAngel Clone')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Complete Payment</h1>
                <p class="text-gray-600">Secure payment processing for your therapy session</p>
            </div>
            
            <div class="px-6 py-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Payment Form -->
                <form id="paymentForm" method="POST" action="{{ route('payment.process') }}">
                    @csrf
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                    <!-- Payment Method Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Select Payment Method</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="razorpay" 
                                       class="sr-only peer" checked>
                                <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-primary-500 peer-checked:bg-primary-50">
                                    <div class="text-center">
                                        <div class="w-12 h-8 mx-auto mb-2 bg-blue-600 rounded flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">RZ</span>
                                        </div>
                                        <div class="font-medium text-gray-900">Razorpay</div>
                                        <div class="text-sm text-gray-500">Cards, UPI, Net Banking</div>
                                    </div>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="stripe" 
                                       class="sr-only peer">
                                <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-primary-500 peer-checked:bg-primary-50">
                                    <div class="text-center">
                                        <div class="w-12 h-8 mx-auto mb-2 bg-purple-600 rounded flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">S</span>
                                        </div>
                                        <div class="font-medium text-gray-900">Stripe</div>
                                        <div class="text-sm text-gray-500">Cards, Apple Pay, Google Pay</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="font-medium text-gray-900 mb-3">Payment Summary</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Therapist</span>
                                <span class="text-sm font-medium">{{ $appointment->therapist->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Session Type</span>
                                <span class="text-sm font-medium">{{ ucfirst($appointment->appointment_type) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Date & Time</span>
                                <span class="text-sm font-medium">
                                    {{ $appointment->appointment_date->format('M d, Y') }} at 
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Duration</span>
                                <span class="text-sm font-medium">{{ $appointment->duration_minutes }} minutes</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Session Fee</span>
                                <span class="text-sm font-medium">₹{{ number_format($appointment->therapist->therapistProfile->consultation_fee) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">GST (18%)</span>
                                <span class="text-sm font-medium">₹{{ number_format($appointment->therapist->therapistProfile->consultation_fee * 0.18) }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2">
                                <div class="flex justify-between">
                                    <span class="text-lg font-medium text-gray-900">Total Amount</span>
                                    <span class="text-lg font-bold text-primary-600">
                                        ₹{{ number_format($appointment->therapist->therapistProfile->consultation_fee * 1.18) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Secure Payment</h3>
                                <p class="mt-1 text-sm text-blue-700">
                                    Your payment information is encrypted and secure. We use industry-standard SSL encryption to protect your data.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('client.dashboard') }}" 
                           class="btn-outline">Cancel</a>
                        <button type="submit" 
                                class="btn-primary" 
                                id="payButton">
                            <span id="buttonText">Pay ₹{{ number_format($appointment->therapist->therapistProfile->consultation_fee * 1.18) }}</span>
                            <span id="loadingText" class="hidden">Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentForm');
    const payButton = document.getElementById('payButton');
    const buttonText = document.getElementById('buttonText');
    const loadingText = document.getElementById('loadingText');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        payButton.disabled = true;
        buttonText.classList.add('hidden');
        loadingText.classList.remove('hidden');

        // Simulate payment processing
        setTimeout(() => {
            // In a real application, this would integrate with payment gateways
            // For demo purposes, we'll simulate a successful payment
            window.location.href = '{{ route("payment.success") }}?payment_id=demo_' + Date.now();
        }, 2000);
    });
});
</script>
@endsection
