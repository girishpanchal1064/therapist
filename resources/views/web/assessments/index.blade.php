@extends('layouts.app')

@section('title', 'Mental Health Assessments - TalkToAngel Clone')
@section('description', 'Take our comprehensive mental health assessments to better understand your mental wellness and get personalized recommendations.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-50 to-secondary-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                Mental Health
                <span class="text-gradient">Assessments</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Take our comprehensive mental health assessments to better understand your mental wellness
                and get personalized recommendations for your mental health journey.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#assessments" class="btn-primary text-lg px-8 py-4">
                    Start Assessment
                </a>
                <a href="#how-it-works" class="btn-outline text-lg px-8 py-4">
                    Learn More
                </a>
            </div>
        </div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-primary-200 rounded-full opacity-20 animate-pulse-soft"></div>
    <div class="absolute bottom-10 right-10 w-32 h-32 bg-secondary-200 rounded-full opacity-20 animate-pulse-soft"></div>
    <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-accent-200 rounded-full opacity-20 animate-pulse-soft"></div>
</section>

<!-- Assessments Section -->
<section id="assessments" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Available Assessments</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Choose an assessment that best fits your needs. Each assessment is designed by mental health professionals
                to provide accurate insights into your mental wellness.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($assessments as $assessment)
                <div class="assessment-card group bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <!-- Card Header with Gradient -->
                    <div class="relative h-32" style="background: linear-gradient(135deg, {{ $assessment->color }}20, {{ $assessment->color }}40);">
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-4 right-4 w-16 h-16 rounded-full" style="background-color: {{ $assessment->color }};"></div>
                            <div class="absolute bottom-4 left-4 w-12 h-12 rounded-full" style="background-color: {{ $assessment->color }};"></div>
                        </div>

                        <!-- Icon -->
                        <div class="absolute top-6 left-6 w-16 h-16 rounded-xl flex items-center justify-center shadow-lg" style="background-color: {{ $assessment->color }};">
                            @if($assessment->icon === 'depression')
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            @elseif($assessment->icon === 'anxiety')
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            @elseif($assessment->icon === 'stress')
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @elseif($assessment->icon === 'sleep')
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                </svg>
                            @elseif($assessment->icon === 'relationships')
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            @elseif($assessment->icon === 'wellness')
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @else
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            @endif
                        </div>

                        <!-- Category Badge -->
                        <div class="absolute top-6 right-6">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold text-white shadow-sm" style="background-color: {{ $assessment->color }};">
                                {{ $assessment->category }}
                            </span>
                        </div>

                        <!-- Completion Count -->
                        <div class="absolute bottom-4 right-6">
                            <div class="flex items-center text-white text-sm">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $assessment->completion_count ?? 0 }} completed
                            </div>
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-6">
                        <!-- Title -->
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-gray-700 transition-colors">
                            {{ $assessment->title }}
                        </h3>

                        <!-- Description -->
                        <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                            {{ $assessment->description }}
                        </p>

                        <!-- Assessment Details -->
                        <div class="space-y-3 mb-6">
                            <!-- Duration -->
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">{{ $assessment->duration_minutes }} minutes</span>
                            </div>

                            <!-- Question Count -->
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">{{ $assessment->question_count }} questions</span>
                            </div>

                            <!-- Difficulty Indicator -->
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">
                                    @if($assessment->question_count <= 6)
                                        Easy
                                    @elseif($assessment->question_count <= 12)
                                        Moderate
                                    @else
                                        Comprehensive
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('assessments.start', $assessment->slug) }}"
                           class="block w-full text-center py-3 px-6 rounded-xl font-semibold text-white transition-all duration-200 hover:shadow-lg transform hover:-translate-y-0.5"
                           style="background-color: {{ $assessment->color }};"
                           onmouseover="this.style.backgroundColor='{{ $assessment->color }}dd'"
                           onmouseout="this.style.backgroundColor='{{ $assessment->color }}'">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                                Start Assessment
                            </span>
                        </a>
                    </div>

                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Assessments Available</h3>
                    <p class="text-gray-600">We're working on adding more assessments to our platform.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Simple steps to get your personalized mental health insights and recommendations
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="text-center group">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-primary-500 to-primary-600 text-white rounded-2xl flex items-center justify-center mx-auto text-2xl font-bold shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                        1
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-accent-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Choose Assessment</h3>
                <p class="text-gray-600 leading-relaxed">
                    Select the assessment that best fits your current needs and concerns. Each assessment is designed by mental health professionals.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="text-center group">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-secondary-500 to-secondary-600 text-white rounded-2xl flex items-center justify-center mx-auto text-2xl font-bold shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                        2
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-accent-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Answer Questions</h3>
                <p class="text-gray-600 leading-relaxed">
                    Complete the assessment by answering questions honestly and thoughtfully. Take your time to provide accurate responses.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="text-center group">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-accent-500 to-accent-600 text-white rounded-2xl flex items-center justify-center mx-auto text-2xl font-bold shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                        3
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-accent-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Get Results</h3>
                <p class="text-gray-600 leading-relaxed">
                    Receive personalized insights, recommendations, and next steps based on your responses. Your privacy is always protected.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Why Take Our Assessments?</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Our assessments are designed to provide valuable insights into your mental health and well-being
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Professional Design -->
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Professional Design</h3>
                <p class="text-gray-600">Created by licensed mental health professionals and validated by research.</p>
            </div>

            <!-- Privacy Protected -->
            <div class="text-center">
                <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Privacy Protected</h3>
                <p class="text-gray-600">Your responses are completely confidential and secure. We never share your data.</p>
            </div>

            <!-- Instant Results -->
            <div class="text-center">
                <div class="w-16 h-16 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Instant Results</h3>
                <p class="text-gray-600">Get immediate insights and personalized recommendations after completing your assessment.</p>
            </div>

            <!-- Actionable Insights -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Actionable Insights</h3>
                <p class="text-gray-600">Receive practical recommendations and next steps to improve your mental wellness.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-primary-600 to-secondary-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Ready to Understand Your Mental Health Better?
        </h2>
        <p class="text-xl text-primary-100 mb-8 max-w-3xl mx-auto">
            Take the first step towards better mental wellness. Our assessments are free, confidential, and designed to help you.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#assessments" class="bg-white text-primary-600 hover:bg-gray-100 font-medium py-3 px-8 rounded-lg transition-colors duration-200">
                Start Your Assessment
            </a>
            <a href="{{ route('therapists.index') }}" class="border-2 border-white text-white hover:bg-white hover:text-primary-600 font-medium py-3 px-8 rounded-lg transition-colors duration-200">
                Find a Therapist
            </a>
        </div>
    </div>
</section>
@endsection
