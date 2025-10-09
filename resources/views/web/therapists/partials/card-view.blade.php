<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($therapists as $therapist)
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
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Therapists Found</h3>
            <p class="text-gray-600 mb-6">Try adjusting your search criteria or filters.</p>
        </div>
    @endforelse
</div>
