@extends('layouts.app')

@section('title', $therapist->name . ' - Therapist Profile - TalkToAngel Clone')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-primary-50 to-secondary-50 text-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <!-- Therapist Info -->
                <div class="flex items-center space-x-6 mb-8 lg:mb-0">
                    <div class="relative">
                        @if($therapist->therapistProfile && $therapist->therapistProfile->profile_image)
                            <img src="{{ asset('storage/' . $therapist->therapistProfile->profile_image) }}"
                                 alt="{{ $therapist->name }}"
                                 class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                        @elseif($therapist->avatar)
                            <img src="{{ asset('storage/' . $therapist->avatar) }}"
                                 alt="{{ $therapist->name }}"
                                 class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($therapist->name) }}&background=667eea&color=fff&size=192&bold=true&format=svg"
                                 alt="{{ $therapist->name }}"
                                 class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                        @endif
                        <!-- Online Status -->
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-4 border-white"></div>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold mb-2">{{ $therapist->name }}</h1>
                        <p class="text-xl text-gray-600 mb-3">{{ $therapist->therapistProfile->qualification ?? 'Licensed Therapist' }}</p>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= floor($therapist->therapistProfile->rating_average ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="ml-2 text-lg font-semibold">
                                    {{ number_format($therapist->therapistProfile->rating_average ?? 0, 1) }}
                                </span>
                                <span class="ml-1 text-gray-500">
                                    ({{ $therapist->therapistProfile->total_reviews ?? 0 }} reviews)
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Action -->
                <div class="text-center lg:text-right">
                    <div class="bg-white bg-opacity-80 backdrop-blur-sm rounded-xl p-6 mb-6 shadow-lg">
                        <div class="text-3xl font-bold mb-2 text-gray-900">
                            ₹{{ number_format($therapist->therapistProfile->consultation_fee ?? 0) }}
                        </div>
                        <div class="text-gray-600 mb-4">per session</div>
                        @auth
                            <a href="{{ route('booking.form', $therapist->id) }}"
                               class="inline-flex items-center px-8 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Book Session
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center px-8 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Login to Book
                            </a>
                        @endauth
                    </div>

                    @if($therapist->therapistProfile->couple_consultation_fee)
                        <div class="text-gray-600">
                            <div class="text-lg font-semibold">
                                ₹{{ number_format($therapist->therapistProfile->couple_consultation_fee) }}
                            </div>
                            <div class="text-sm">Couple Session</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- About Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            About {{ $therapist->name }}
                        </h2>
                    </div>
                    <div class="px-6 py-6">
                        <p class="text-gray-700 leading-relaxed text-lg">
                            {{ $therapist->therapistProfile->bio ?? 'No bio available.' }}
                        </p>
                    </div>
                </div>

                <!-- Specializations -->
                @if($therapist->therapistProfile->specializations && $therapist->therapistProfile->specializations->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Specializations
                            </h2>
                        </div>
                        <div class="px-6 py-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($therapist->therapistProfile->specializations as $specialization)
                                    <div class="flex items-center p-3 bg-green-50 rounded-lg border border-green-200">
                                        <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-green-800 font-medium">{{ $specialization->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Areas of Expertise -->
                @php
                    $areasOfExpertise = $therapist->therapistProfile->areas_of_expertise ?? [];
                    $areasCollection = \App\Models\AreaOfExpertise::whereIn('slug', is_array($areasOfExpertise) ? $areasOfExpertise : [])->active()->get();
                @endphp
                @if($areasCollection->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                Areas of Expertise
                            </h2>
                        </div>
                        <div class="px-6 py-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @php
                                    $areaColors = [
                                        ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-800', 'icon' => 'text-red-600'],
                                        ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-800', 'icon' => 'text-blue-600'],
                                        ['bg' => 'bg-purple-50', 'border' => 'border-purple-200', 'text' => 'text-purple-800', 'icon' => 'text-purple-600'],
                                        ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'text' => 'text-yellow-800', 'icon' => 'text-yellow-600'],
                                        ['bg' => 'bg-pink-50', 'border' => 'border-pink-200', 'text' => 'text-pink-800', 'icon' => 'text-pink-600'],
                                        ['bg' => 'bg-indigo-50', 'border' => 'border-indigo-200', 'text' => 'text-indigo-800', 'icon' => 'text-indigo-600'],
                                    ];
                                @endphp
                                @foreach($areasCollection as $index => $area)
                                    @php $color = $areaColors[$index % count($areaColors)]; @endphp
                                    <a href="{{ route('therapists.index', ['area' => $area->slug]) }}" 
                                       class="flex items-center p-3 {{ $color['bg'] }} rounded-lg border {{ $color['border'] }} hover:shadow-md transition-shadow">
                                        @if($area->icon)
                                            <i class="{{ $area->icon }} w-5 h-5 {{ $color['icon'] }} mr-3" style="font-size: 1.25rem;"></i>
                                        @else
                                            <svg class="w-5 h-5 {{ $color['icon'] }} mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                            </svg>
                                        @endif
                                        <span class="{{ $color['text'] }} font-medium">{{ $area->name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Experience & Qualifications -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            </svg>
                            Experience & Qualifications
                        </h2>
                    </div>
                    <div class="px-6 py-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <h3 class="font-semibold text-purple-900">Experience</h3>
                                </div>
                                <p class="text-purple-700">{{ $therapist->therapistProfile->experience_years ?? 0 }}+ years of experience</p>
                            </div>

                            <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <h3 class="font-semibold text-purple-900">Qualifications</h3>
                                </div>
                                <p class="text-purple-700">{{ $therapist->therapistProfile->qualification ?? 'Licensed Mental Health Professional' }}</p>
                            </div>

                            @if($therapist->therapistProfile->license_number)
                                <div class="bg-purple-50 rounded-lg p-4 border border-purple-200 md:col-span-2">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        <h3 class="font-semibold text-purple-900">License Number</h3>
                                    </div>
                                    <p class="text-purple-700">{{ $therapist->therapistProfile->license_number }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Languages -->
                @if($therapist->therapistProfile->languages && count($therapist->therapistProfile->languages) > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                </svg>
                                Languages
                            </h2>
                        </div>
                        <div class="px-6 py-6">
                            <div class="flex flex-wrap gap-3">
                                @foreach($therapist->therapistProfile->languages as $language)
                                    <div class="flex items-center px-4 py-2 bg-orange-50 rounded-lg border border-orange-200">
                                        <svg class="w-4 h-4 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                        </svg>
                                        <span class="text-orange-800 font-medium">{{ $language }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Reviews -->
                @if($reviews->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                Client Reviews
                            </h2>
                        </div>
                        <div class="px-6 py-6">
                            <div class="space-y-6">
                                @foreach($reviews as $review)
                                    <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex items-center">
                                                @if($review->client->profile && $review->client->profile->profile_image)
                                                    <img src="{{ Storage::url($review->client->profile->profile_image) }}"
                                                         alt="{{ $review->client->name }}"
                                                         class="h-10 w-10 rounded-full object-cover">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center text-white font-semibold">
                                                        {{ substr($review->client->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div class="ml-3">
                                                    <p class="font-semibold text-gray-900">{{ $review->client->name }}</p>
                                                    <div class="flex items-center mt-1">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                 fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Booking Sidebar -->
            <div class="lg:col-span-1">
                <div class="space-y-6">
                    <!-- Booking Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 sticky top-6">
                        <div class="px-6 py-4 bg-gradient-to-r from-primary-600 to-secondary-600 text-white rounded-t-xl">
                            <h3 class="text-lg font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Book a Session
                            </h3>
                        </div>
                        <div class="px-6 py-6">
                            @auth
                                <a href="{{ route('booking.form', $therapist->id) }}"
                                   class="w-full bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-primary-700 hover:to-secondary-700 transition-all duration-200 flex items-center justify-center mb-6">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Book Session
                                </a>
                            @else
                                <a href="{{ route('login', ['redirect' => route('booking.form', $therapist->id)]) }}"
                                   class="w-full bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-primary-700 hover:to-secondary-700 transition-all duration-200 flex items-center justify-center mb-6">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    Login to Book
                                </a>
                            @endauth

                            <!-- Quick Stats -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">Experience</span>
                                    </div>
                                    <span class="text-sm font-semibold text-blue-600">{{ $therapist->therapistProfile->experience_years ?? 0 }}+ years</span>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">Sessions</span>
                                    </div>
                                    <span class="text-sm font-semibold text-green-600">{{ $therapist->therapistProfile->total_sessions ?? 0 }}</span>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">Rating</span>
                                    </div>
                                    <span class="text-sm font-semibold text-yellow-600">{{ number_format($therapist->therapistProfile->rating_average ?? 0, 1) }}/5</span>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">Response</span>
                                    </div>
                                    <span class="text-sm font-semibold text-purple-600">Within 24h</span>
                                </div>
                            </div>

                            <!-- Available Time Slots Preview -->
                            @if($availableSlots && count($availableSlots) > 0)
                                <div class="mt-6">
                                    <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Available Time Slots
                                    </h4>
                                    <div class="space-y-3 max-h-96 overflow-y-auto">
                                        @foreach($availableSlots as $day)
                                            @if($day['is_available'] && count($day['slots']) > 0)
                                                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <div class="font-medium text-green-900">
                                                            @if($day['is_today'])
                                                                Today, {{ $day['formatted_date'] }}
                                                            @elseif($day['is_tomorrow'])
                                                                Tomorrow, {{ $day['formatted_date'] }}
                                                            @else
                                                                {{ $day['day_name'] }}, {{ $day['formatted_date'] }}
                                                            @endif
                                                        </div>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            {{ count($day['slots']) }} slots
                                                        </span>
                                                    </div>
                                                    <div class="flex flex-wrap gap-2 mt-3">
                                                        @foreach(array_slice($day['slots'], 0, 6) as $slot)
                                                            <span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-white text-green-700 border border-green-300 hover:bg-green-100 transition-colors">
                                                                <svg class="w-3 h-3 mr-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                                {{ $slot['formatted_time'] }}
                                                            </span>
                                                        @endforeach
                                                        @if(count($day['slots']) > 6)
                                                            <span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-green-100 text-green-800 border border-green-300">
                                                                +{{ count($day['slots']) - 6 }} more
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @elseif(!$day['is_past'])
                                                <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                                    <div class="font-medium text-gray-600">
                                                        @if($day['is_today'])
                                                            Today, {{ $day['formatted_date'] }}
                                                        @elseif($day['is_tomorrow'])
                                                            Tomorrow, {{ $day['formatted_date'] }}
                                                        @else
                                                            {{ $day['day_name'] }}, {{ $day['formatted_date'] }}
                                                        @endif
                                                    </div>
                                                    <div class="text-sm text-gray-500 mt-1">
                                                        No slots available
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="mt-3 text-center">
                                        <a href="{{ route('booking.form', $therapist->id) }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Book Appointment
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="mt-6">
                                    <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Available Time Slots
                                    </h4>
                                    <div class="text-center py-4 text-gray-500 bg-gray-50 rounded-lg border border-gray-200">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="text-sm">No availability set yet</p>
                                        <p class="text-xs text-gray-400 mt-1">Check back later for available slots</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Session Types -->
                            <div class="mt-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    Session Types
                                </h4>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between p-2 bg-blue-50 rounded-lg">
                                        <span class="text-sm text-gray-700">Video Call</span>
                                        <span class="text-sm font-semibold text-green-600">Available</span>
                                    </div>
                                    <div class="flex items-center justify-between p-2 bg-blue-50 rounded-lg">
                                        <span class="text-sm text-gray-700">Audio Call</span>
                                        <span class="text-sm font-semibold text-green-600">Available</span>
                                    </div>
                                    <div class="flex items-center justify-between p-2 bg-blue-50 rounded-lg">
                                        <span class="text-sm text-gray-700">Chat</span>
                                        <span class="text-sm font-semibold text-green-600">Available</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
