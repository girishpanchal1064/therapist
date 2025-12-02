<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($therapists as $therapist)
        <div class="therapist-card">
            <div class="therapist-card-inner">
                <!-- Left Column - Profile Info -->
                <div class="therapist-left">
                    <!-- Avatar with Pink Ring -->
                    <div class="therapist-avatar-wrapper">
                        <div class="therapist-avatar-ring">
                            @if($therapist->profile && $therapist->profile->profile_image)
                                <img src="{{ Storage::url($therapist->profile->profile_image) }}"
                                     alt="{{ $therapist->name }}"
                                     class="therapist-avatar">
                            @else
                                <div class="therapist-avatar-placeholder">
                                    {{ substr($therapist->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Name -->
                    <h3 class="therapist-name">{{ strtoupper($therapist->name) }}</h3>
                    
                    <!-- Specialization -->
                    @if($therapist->therapistProfile && $therapist->therapistProfile->specializations->count() > 0)
                        <p class="therapist-specialization">{{ $therapist->therapistProfile->specializations->first()->name }}</p>
                    @else
                        <p class="therapist-specialization">Counselling</p>
                    @endif
                    
                    <!-- Title -->
                    <p class="therapist-title">Psychologist</p>
                    
                    <!-- Experience -->
                    <p class="therapist-experience">{{ $therapist->therapistProfile->experience_years ?? 0 }} Yrs</p>
                    
                    <!-- Qualification -->
                    <p class="therapist-qualification">{{ $therapist->therapistProfile->qualification ?? 'MA' }}</p>

                    <!-- Rating -->
                    <div class="therapist-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                        <span class="rating-value">({{ number_format($therapist->therapistProfile->rating_average ?? 0, 1) }})</span>
                    </div>
                    <p class="therapist-reviews">({{ $therapist->therapistProfile->total_reviews ?? 0 }} Ratings)</p>
                </div>

                <!-- Right Column - Actions -->
                <div class="therapist-right">
                    <!-- See Availability -->
                    <a href="{{ route('therapists.show', $therapist->id) }}" class="see-availability">See Availability</a>

                    <!-- Recommend Badge -->
                    <div class="recommend-badge">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.834a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                        </svg>
                        Recommend
                    </div>

                    <!-- Online Status -->
                    <p class="online-status">Online</p>

                    <!-- Session Price -->
                    <div class="session-price">
                        <p class="session-price-label">Session beginning at</p>
                        <p class="session-price-amount">₹ {{ number_format($therapist->therapistProfile->consultation_fee ?? 0) }}</p>
                    </div>

                    <!-- Action Buttons -->
                    @auth
                        <a href="{{ route('booking.form', $therapist->id) }}" class="btn-book-session">
                            Book a session
                        </a>
                    @else
                        <a href="{{ route('login', ['redirect' => route('booking.form', $therapist->id)]) }}" class="btn-book-session">
                            Book a session
                        </a>
                    @endauth
                    <a href="{{ route('therapists.show', $therapist->id) }}" class="btn-view-profile">
                        View Profile
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Therapists Found</h3>
            <p class="text-gray-600 mb-6">Try adjusting your search criteria or filters.</p>
        </div>
    @endforelse
</div>
