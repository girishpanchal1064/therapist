<div class="space-y-4">
    @forelse($therapists as $therapist)
        @php
            $profile = $therapist->therapistProfile;
            $specs = $profile && $profile->specializations ? $profile->specializations->take(3) : collect();
            $rating = number_format($profile?->rating_average ?? 0, 1);
            $reviews = $profile?->total_reviews ?? 0;
            $years = $profile?->experience_years ?? 0;
            $fee = number_format($profile?->consultation_fee ?? 0);
        @endphp
        <article class="flex flex-col gap-4 overflow-hidden rounded-2xl border border-[#BAC2D2]/30 bg-white p-5 shadow-[0_4px_6px_-1px_rgba(4,28,84,0.06)] transition hover:shadow-[0_12px_24px_-8px_rgba(4,28,84,0.1)] md:flex-row md:items-stretch">
            <div class="flex shrink-0 gap-4 md:items-center">
                <div class="h-[4.5rem] w-[4.5rem] shrink-0 overflow-hidden rounded-xl bg-[#BAC2D2] md:h-24 md:w-24">
                    @if($profile && $profile->profile_image)
                        <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="{{ $therapist->name }}" class="h-full w-full object-cover">
                    @elseif($therapist->avatar)
                        <img src="{{ asset('storage/' . $therapist->avatar) }}" alt="{{ $therapist->name }}" class="h-full w-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($therapist->name) }}&background=BAC2D2&color=041C54&size=256&bold=true&format=svg"
                             alt="{{ $therapist->name }}"
                             class="h-full w-full object-cover">
                    @endif
                </div>
                <div class="min-w-0 flex-1 md:hidden">
                    <div class="flex items-start justify-between gap-2">
                        <h3 class="font-display text-base font-medium text-[#041C54]">Dr. {{ $therapist->name }}</h3>
                        <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-[#647494] px-2 py-0.5 text-[0.65rem] font-medium text-white">Recommended</span>
                    </div>
                </div>
            </div>

            <div class="min-w-0 flex-1 border-[#BAC2D2]/20 md:border-l md:pl-6">
                <div class="hidden items-start justify-between gap-3 md:flex">
                    <h3 class="font-display text-lg font-medium text-[#041C54]">Dr. {{ $therapist->name }}</h3>
                    <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-[#647494] px-2.5 py-0.5 text-xs font-medium text-white">
                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.834a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/></svg>
                        Recommended
                    </span>
                </div>
                <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-[#7484A4]">
                    <span class="inline-flex items-center gap-1 font-medium text-[#041C54]">
                        <svg class="h-4 w-4 text-[#F59E0B]" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        {{ $rating }} <span class="font-normal text-[#7484A4]">({{ $reviews }})</span>
                    </span>
                    <span>{{ $years }}+ yrs</span>
                    @if($profile && $profile->qualification)
                        <span>• {{ Str::limit($profile->qualification, 40) }}</span>
                    @endif
                </div>
                <p class="mb-1 mt-3 text-sm text-[#7484A4]">Specializes in:</p>
                <div class="flex flex-wrap gap-2">
                    @forelse($specs as $spec)
                        <span class="rounded-[10px] bg-[#BAC2D2]/20 px-2.5 py-0.5 text-xs text-[#041C54]">{{ $spec->name }}</span>
                    @empty
                        <span class="rounded-[10px] bg-[#BAC2D2]/20 px-2.5 py-0.5 text-xs text-[#041C54]">General counselling</span>
                    @endforelse
                </div>
            </div>

            <div class="flex flex-col justify-center gap-3 border-[#BAC2D2]/20 pt-2 md:w-52 md:shrink-0 md:border-l md:pl-6 md:pt-0">
                <div>
                    <p class="text-xs text-[#7484A4]">Session starting at</p>
                    <p class="font-display text-xl font-medium text-[#041C54]">₹{{ $fee }}</p>
                </div>
                @auth
                    <a href="{{ route('booking.form', $therapist->id) }}" class="inline-flex h-10 items-center justify-center rounded-[14px] bg-[#041C54] text-center text-sm font-medium text-white shadow-[0_8px_20px_rgba(4,28,84,0.35)] transition hover:bg-[#647494] hover:!text-white">Book Session</a>
                @else
                    <a href="{{ route('login', ['redirect' => route('booking.form', $therapist->id)]) }}" class="inline-flex h-10 items-center justify-center rounded-[14px] bg-[#041C54] text-center text-sm font-medium text-white shadow-[0_8px_20px_rgba(4,28,84,0.35)] transition hover:bg-[#647494] hover:!text-white">Book Session</a>
                @endauth
                <a href="{{ route('therapists.show', $therapist->id) }}" class="inline-flex h-10 items-center justify-center rounded-[14px] border-2 border-[#647494] text-center text-sm font-medium text-[#647494] transition hover:border-[#041C54] hover:text-[#041C54] hover:!no-underline">View Profile</a>
            </div>
        </article>
    @empty
        <div class="py-16 text-center">
            <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-[#BAC2D2]/20">
                <svg class="h-12 w-12 text-[#7484A4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h3 class="font-display text-xl font-medium text-[#041C54]">No Therapists Found</h3>
            <p class="mt-2 text-[#7484A4]">Try adjusting your search criteria or filters.</p>
        </div>
    @endforelse
</div>
