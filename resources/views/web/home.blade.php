@extends('layouts.app')

@section('title', 'TalkToAngel Clone - Online Mental Health Counseling')
@section('description', 'Connect with verified therapists for online counseling, therapy sessions, and mental health support. Professional help when you need it most.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-50 to-secondary-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                Your Mental Health
                <span class="text-gradient">Matters</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Connect with verified therapists for online counseling, therapy sessions, and mental health support.
                Professional help when you need it most, from the comfort of your home.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('therapists.index') }}" class="btn-primary text-lg px-8 py-4">
                    Find a Therapist
                </a>
                <a href="{{ route('assessments.index') }}" class="btn-outline text-lg px-8 py-4">
                    Take Self Assessment
                </a>
            </div>
        </div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-primary-200 rounded-full opacity-20 animate-pulse-soft"></div>
    <div class="absolute bottom-10 right-10 w-32 h-32 bg-secondary-200 rounded-full opacity-20 animate-pulse-soft"></div>
    <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-accent-200 rounded-full opacity-20 animate-pulse-soft"></div>
</section>

<!-- Statistics Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">750+</div>
                <div class="text-gray-600">Verified Therapists</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">1.2M+</div>
                <div class="text-gray-600">Sessions Completed</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">50K+</div>
                <div class="text-gray-600">Happy Clients</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">24/7</div>
                <div class="text-gray-600">Available Support</div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Comprehensive Mental Health Services
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                We offer a wide range of mental health services to support you on your journey to better mental wellness.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Individual Counselling -->
            <div class="card-hover text-center service-hover-overlay" data-thoughts="Thoughts of therapy for personal growth and healing">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Individual Counselling</h3>
                <p class="text-gray-600">One-on-one sessions with licensed therapists for personalized mental health support and healing.</p>
            </div>

            <!-- Couple Counselling -->
            <div class="card-hover text-center service-hover-overlay" data-thoughts="Thoughts of therapy for relationship healing and growth">
                <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Couple Counselling</h3>
                <p class="text-gray-600">Strengthen your relationship with professional couple counseling and relationship therapy.</p>
            </div>

            <!-- Psychiatric Consultation -->
            <div class="card-hover text-center service-hover-overlay" data-thoughts="Thoughts of therapy for mental health evaluation and treatment">
                <div class="w-16 h-16 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Psychiatric Consultation</h3>
                <p class="text-gray-600">Professional psychiatric evaluation and medication management for mental health conditions.</p>
            </div>

            <!-- Employee Assistance Program -->
            <div class="card-hover text-center service-hover-overlay" data-thoughts="Thoughts of therapy for workplace wellness and support">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Employee Assistance Program</h3>
                <p class="text-gray-600">Comprehensive workplace mental health support and employee wellness programs.</p>
            </div>

            <!-- Teen Therapy -->
            <div class="card-hover text-center service-hover-overlay" data-thoughts="Thoughts of therapy for teenage challenges and growth">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Teen Therapy</h3>
                <p class="text-gray-600">Specialized counseling for teenagers dealing with anxiety, depression, and life transitions.</p>
            </div>

            <!-- Kids Therapy -->
            <div class="card-hover text-center service-hover-overlay" data-thoughts="Thoughts of therapy for children's emotional development">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-5-8V6a2 2 0 114 0v2m-4 0h4m-4 0v8a2 2 0 002 2h4a2 2 0 002-2v-8m-4 0V6"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Kids Therapy</h3>
                <p class="text-gray-600">Child-friendly therapy sessions using play therapy and age-appropriate techniques.</p>
            </div>

            <!-- Elder Care -->
            <div class="card-hover text-center service-hover-overlay" data-thoughts="Thoughts of therapy for aging with dignity and support">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Elder Care</h3>
                <p class="text-gray-600">Specialized mental health support for seniors dealing with aging-related challenges.</p>
            </div>

            <!-- Campus Wellness Program -->
            <div class="card-hover text-center service-hover-overlay" data-thoughts="Thoughts of therapy for student mental health and academic success">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Campus Wellness Program</h3>
                <p class="text-gray-600">Comprehensive mental health support for students and educational institutions.</p>
            </div>
        </div>
    </div>
</section>

<!-- Specializations Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Areas of Expertise
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Our therapists specialize in various areas of mental health to provide targeted support for your specific needs.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="spec-hover-overlay bg-red-50 text-red-600" data-thoughts="Thoughts of therapy for anxiety management and peace">
                <div class="spec-icon bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <div class="spec-text text-red-600">Anxiety</div>
            </div>

            <div class="spec-hover-overlay bg-blue-50 text-blue-600" data-thoughts="Thoughts of therapy for depression recovery and hope">
                <div class="spec-icon bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="spec-text text-blue-600">Depression</div>
            </div>

            <div class="spec-hover-overlay bg-green-50 text-green-600" data-thoughts="Thoughts of therapy for healthy relationships and connection">
                <div class="spec-icon bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div class="spec-text text-green-600">Relationships</div>
            </div>

            <div class="spec-hover-overlay bg-purple-50 text-purple-600" data-thoughts="Thoughts of therapy for stress relief and balance">
                <div class="spec-icon bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="spec-text text-purple-600">Stress</div>
            </div>

            <div class="spec-hover-overlay bg-yellow-50 text-yellow-600" data-thoughts="Thoughts of therapy for addiction recovery and freedom">
                <div class="spec-icon bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div class="spec-text text-yellow-600">Addiction</div>
            </div>

            <div class="spec-hover-overlay bg-pink-50 text-pink-600" data-thoughts="Thoughts of therapy for trauma healing and resilience">
                <div class="spec-icon bg-pink-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div class="spec-text text-pink-600">Trauma</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Therapists Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Featured Therapists
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Meet some of our highly qualified and experienced mental health professionals.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($featuredTherapists as $therapist)
                <div class="therapist-card bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Profile Section -->
                    <div class="profile-section bg-gray-50 p-4 text-center border-b">
                        <div class="relative inline-block">
                            @if($therapist->profile && $therapist->profile->profile_image)
                                <img src="{{ Storage::url($therapist->profile->profile_image) }}"
                                     alt="{{ $therapist->name }}"
                                     class="profile-image w-20 h-20 rounded-full object-cover border-2 border-white shadow-sm">
                            @else
                                <div class="profile-image w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xl font-bold border-2 border-white shadow-sm">
                                    {{ substr($therapist->name, 0, 1) }}
                                </div>
                            @endif
                            <!-- Online Status -->
                            <div class="online-badge absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="content-section p-4">
                        <!-- Therapist Info -->
                        <div class="text-center mb-1">
                            <h3 class="therapist-name text-lg font-semibold text-gray-900 mb-0.5">{{ $therapist->name }}</h3>
                            <p class="therapist-title text-sm text-gray-600">{{ $therapist->therapistProfile->qualification ?? 'Licensed Therapist' }}</p>
                        </div>

                        <!-- Experience & Education -->
                        <div class="space-y-0.5 mb-1 text-xs text-gray-600">
                            <div class="flex items-center justify-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $therapist->therapistProfile->experience_years ?? 0 }} Years Experience
                            </div>
                            <div class="flex items-center justify-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                </svg>
                                {{ $therapist->therapistProfile->qualification ?? 'BA, MA' }}
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="rating-container flex items-center justify-center gap-2 mb-1">
                            <div class="rating-stars flex gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="rating-star w-4 h-4 {{ $i <= floor($therapist->therapistProfile->rating_average ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="rating-text text-sm font-semibold text-gray-700">
                                {{ number_format($therapist->therapistProfile->rating_average ?? 0, 1) }}
                            </span>
                            <span class="rating-count text-xs text-gray-500">
                                ({{ $therapist->therapistProfile->total_reviews ?? 0 }} Ratings)
                            </span>
                        </div>

                        <!-- Specializations -->
                        @if($therapist->therapistProfile && $therapist->therapistProfile->specializations->count() > 0)
                            <div class="specializations flex flex-wrap gap-1 justify-center mb-1">
                                @foreach($therapist->therapistProfile->specializations->take(2) as $specialization)
                                    <span class="specialization-tag px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">
                                        {{ $specialization->name }}
                                    </span>
                                @endforeach
                                @if($therapist->therapistProfile->specializations->count() > 2)
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                        +{{ $therapist->therapistProfile->specializations->count() - 2 }}
                                    </span>
                                @endif
                            </div>
                        @endif

                        <!-- Session Info -->
                        <div class="text-center mb-1">
                            <div class="text-sm text-gray-600">
                                Session beginning at
                                <span class="text-lg font-bold text-teal-600">
                                    ₹{{ number_format($therapist->therapistProfile->consultation_fee ?? 0) }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons space-y-2">
                            <a href="{{ route('booking.form', $therapist->id) }}"
                               class="btn-primary w-full text-center block py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors">
                                Book a session
                            </a>
                            <a href="{{ route('therapists.show', $therapist->id) }}"
                               class="btn-outline w-full text-center block py-2 border border-teal-500 text-teal-600 rounded-lg hover:bg-teal-50 transition-colors">
                                View Profile
                            </a>
                        </div>

                        <!-- See Availability Link -->
                        <div class="text-center mt-2">
                            <a href="{{ route('therapists.show', $therapist->id) }}"
                               class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full hover:bg-green-200 transition-colors">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                See Availability
                            </a>
                        </div>
                    </div>

                    <!-- Recommend Badge -->
                    <div class="absolute top-3 right-3">
                        <div class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.834a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                            </svg>
                            Recommend
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Featured Therapists Available</h3>
                    <p class="text-gray-600 mb-6">We're working on adding more therapists to our platform.</p>
                    <a href="{{ route('therapists.index') }}" class="btn-primary">
                        View All Therapists
                    </a>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('therapists.index') }}" class="btn-outline text-lg px-8 py-4">
                View All Therapists
            </a>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Why Choose Online Therapy?
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Online therapy offers convenience, privacy, and accessibility while maintaining the same quality of care as in-person sessions.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Convenient Scheduling</h3>
                <p class="text-gray-600">Book sessions at times that work for you, including evenings and weekends.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Privacy & Security</h3>
                <p class="text-gray-600">Your sessions are completely confidential and secure with end-to-end encryption.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">24/7 Support</h3>
                <p class="text-gray-600">Access to mental health resources and support whenever you need it.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">From Anywhere</h3>
                <p class="text-gray-600">Attend sessions from the comfort of your home or any private location.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Affordable Rates</h3>
                <p class="text-gray-600">Competitive pricing with flexible payment options and insurance coverage.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Verified Professionals</h3>
                <p class="text-gray-600">All therapists are licensed, verified, and experienced in their specialties.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-primary-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Ready to Start Your Mental Health Journey?
        </h2>
        <p class="text-xl text-primary-100 mb-8 max-w-3xl mx-auto">
            Take the first step towards better mental health. Connect with a qualified therapist today.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="bg-white text-primary-600 hover:bg-gray-100 font-medium py-3 px-8 rounded-lg transition-colors duration-200">
                Get Started Free
            </a>
            <a href="{{ route('therapists.index') }}" class="border-2 border-white text-white hover:bg-white hover:text-primary-600 font-medium py-3 px-8 rounded-lg transition-colors duration-200">
                Browse Therapists
            </a>
        </div>
    </div>
</section>
@endsection
