<div class="space-y-4">
    @forelse($therapists as $therapist)
        <div class="therapist-list-item bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-start gap-4">
                <!-- Profile Image -->
                <div class="flex-shrink-0">
                    <div class="relative">
                        @if($therapist->profile && $therapist->profile->profile_image)
                            <img src="{{ Storage::url($therapist->profile->profile_image) }}"
                                 alt="{{ $therapist->name }}"
                                 class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-lg font-bold border-2 border-gray-200">
                                {{ substr($therapist->name, 0, 1) }}
                            </div>
                        @endif
                        <!-- Online Status -->
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                    </div>
                </div>

                <!-- Therapist Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $therapist->name }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $therapist->therapistProfile->qualification ?? 'Licensed Therapist' }}</p>

                            <!-- Experience & Education -->
                            <div class="flex items-center gap-4 mb-2 text-sm text-gray-600">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $therapist->therapistProfile->experience_years ?? 0 }} Years Experience
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    </svg>
                                    {{ $therapist->therapistProfile->qualification ?? 'BA, MA' }}
                                </div>
                            </div>

                            <!-- Rating -->
                            <div class="flex items-center gap-2 mb-2">
                                <div class="flex gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= floor($therapist->therapistProfile->rating_average ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-sm font-semibold text-gray-700">
                                    {{ number_format($therapist->therapistProfile->rating_average ?? 0, 1) }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    ({{ $therapist->therapistProfile->total_reviews ?? 0 }} Ratings)
                                </span>
                            </div>

                            <!-- Specializations -->
                            @if($therapist->therapistProfile && $therapist->therapistProfile->specializations->count() > 0)
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach($therapist->therapistProfile->specializations->take(3) as $specialization)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">
                                            {{ $specialization->name }}
                                        </span>
                                    @endforeach
                                    @if($therapist->therapistProfile->specializations->count() > 3)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                            +{{ $therapist->therapistProfile->specializations->count() - 3 }} more
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <!-- Languages -->
                            @if($therapist->therapistProfile && $therapist->therapistProfile->languages && count($therapist->therapistProfile->languages) > 0)
                                <div class="text-sm text-gray-600 mb-3">
                                    <span class="font-medium">Languages:</span>
                                    {{ implode(', ', array_slice($therapist->therapistProfile->languages, 0, 3)) }}
                                    @if(count($therapist->therapistProfile->languages) > 3)
                                        +{{ count($therapist->therapistProfile->languages) - 3 }} more
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Session Info & Actions -->
                        <div class="flex-shrink-0 text-right">
                            <div class="mb-3">
                                <div class="text-sm text-gray-600 mb-1">Online Session</div>
                                <div class="text-sm text-gray-600">
                                    Starting at
                                    <span class="text-lg font-bold text-teal-600">
                                        ₹{{ number_format($therapist->therapistProfile->consultation_fee ?? 0) }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <a href="{{ route('booking.form', $therapist->id) }}"
                                   class="block w-full px-4 py-2 bg-pink-500 text-white text-center rounded-lg hover:bg-pink-600 transition-colors">
                                    Book a session
                                </a>
                                <a href="{{ route('therapists.show', $therapist->id) }}"
                                   class="block w-full px-4 py-2 border border-teal-500 text-teal-600 text-center rounded-lg hover:bg-teal-50 transition-colors">
                                    View Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Therapists Found</h3>
            <p class="text-gray-600 mb-6">Try adjusting your search criteria or filters.</p>
        </div>
    @endforelse
</div>
