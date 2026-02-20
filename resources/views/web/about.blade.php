@extends('layouts.app')

@section('title', 'About Us - Apani Psychology')
@section('description', 'Learn about our mission to make mental health support accessible, affordable, and effective for everyone.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-50 to-secondary-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                About
                <span class="text-gradient">Apani Psychology</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                We're on a mission to make mental health support accessible, affordable, and effective for everyone,
                everywhere.
            </p>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Mission</h2>
                <p class="text-lg text-gray-600 mb-6">
                    Mental health is a fundamental part of human well-being, yet millions of people around the world
                    lack access to quality mental health care. We believe that everyone deserves support for their
                    mental health journey, regardless of their location, schedule, or financial situation.
                </p>
                <p class="text-lg text-gray-600 mb-8">
                    Through technology and compassionate care, we're breaking down barriers and making professional
                    mental health support accessible to anyone who needs it, when they need it.
                </p>
                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary-600 mb-2">50K+</div>
                        <div class="text-gray-600">Lives Impacted</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary-600 mb-2">500+</div>
                        <div class="text-gray-600">Licensed Therapists</div>
                    </div>
                </div>
            </div>
            <div class="aspect-video bg-gray-200 rounded-2xl"></div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Values</h2>
            <p class="text-lg text-gray-600">The principles that guide everything we do</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Compassion</h3>
                <p class="text-gray-600">We approach every interaction with empathy, understanding, and genuine care for our users' well-being.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Quality</h3>
                <p class="text-gray-600">We maintain the highest standards in our services, ensuring every therapist is licensed and experienced.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Accessibility</h3>
                <p class="text-gray-600">We believe mental health support should be available to everyone, regardless of location or circumstances.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Privacy</h3>
                <p class="text-gray-600">We protect your privacy with industry-leading security measures and strict confidentiality protocols.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Community</h3>
                <p class="text-gray-600">We foster a supportive community where people can share experiences and find understanding.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Growth</h3>
                <p class="text-gray-600">We're committed to continuous improvement and innovation in mental health care delivery.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
            <p class="text-lg text-gray-600">The passionate people behind our mission</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-24 h-24 bg-gray-300 rounded-full mx-auto mb-4"></div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Dr. Sarah Johnson</h3>
                <p class="text-primary-600 font-medium mb-2">Chief Medical Officer</p>
                <p class="text-gray-600 text-sm">Licensed Clinical Psychologist with 15+ years of experience in mental health care.</p>
            </div>

            <div class="text-center">
                <div class="w-24 h-24 bg-gray-300 rounded-full mx-auto mb-4"></div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Michael Chen</h3>
                <p class="text-primary-600 font-medium mb-2">CEO & Co-Founder</p>
                <p class="text-gray-600 text-sm">Technology entrepreneur passionate about making mental health care accessible.</p>
            </div>

            <div class="text-center">
                <div class="w-24 h-24 bg-gray-300 rounded-full mx-auto mb-4"></div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Dr. Emily Rodriguez</h3>
                <p class="text-primary-600 font-medium mb-2">Head of Clinical Operations</p>
                <p class="text-gray-600 text-sm">Licensed Marriage and Family Therapist specializing in trauma-informed care.</p>
            </div>
        </div>
    </div>
</section>

<!-- Impact Section -->
<section class="py-16 bg-primary-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white mb-12">
            <h2 class="text-3xl font-bold mb-4">Our Impact</h2>
            <p class="text-xl text-primary-100">Making a difference in people's lives every day</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-white mb-2">50,000+</div>
                <div class="text-primary-100">People Helped</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-white mb-2">500+</div>
                <div class="text-primary-100">Licensed Therapists</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-white mb-2">100,000+</div>
                <div class="text-primary-100">Sessions Completed</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-white mb-2">95%</div>
                <div class="text-primary-100">User Satisfaction</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Join Our Mission</h2>
        <p class="text-lg text-gray-600 mb-8">
            Whether you're seeking support or looking to help others, there's a place for you in our community.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('therapists.index') }}" class="btn-primary text-lg px-8 py-4">
                Find a Therapist
            </a>
            <a href="{{ route('register') }}" class="btn-outline text-lg px-8 py-4">
                Get Started Today
            </a>
        </div>
    </div>
</section>
@endsection
