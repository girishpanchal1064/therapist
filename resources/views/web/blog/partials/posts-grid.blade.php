@foreach($posts as $post)
    <article class="blog-card group flex min-w-0 flex-col overflow-hidden rounded-2xl border border-[#BAC2D2]/30 bg-white shadow-[0_10px_15px_-3px_rgba(4,28,84,0.06),0_4px_6px_-4px_rgba(4,28,84,0.06)] transition-shadow duration-300 hover:shadow-[0_20px_40px_-12px_rgba(4,28,84,0.12)]">
        <div class="relative aspect-[16/10] w-full overflow-hidden bg-[#BAC2D2]/20">
            @if($post->featured_image)
                <img src="{{ $post->featured_image_url }}"
                     alt=""
                     class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.02]">
            @else
                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#BAC2D2]/30 to-[#647494]/20">
                    <svg class="h-14 w-14 text-[#647494]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif

            @if($post->category)
                <div class="absolute left-3 top-3 sm:left-4 sm:top-4">
                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium text-white shadow-sm sm:px-3 sm:py-1 sm:text-sm"
                          style="background-color: {{ $post->category->color ?? '#647494' }}">
                        {{ $post->category->name }}
                    </span>
                </div>
            @endif

            @if($post->is_featured)
                <div class="absolute right-3 top-3 sm:right-4 sm:top-4">
                    <span class="inline-flex rounded-full bg-[#F59E0B] px-2.5 py-0.5 text-xs font-medium text-white shadow-sm">
                        Featured
                    </span>
                </div>
            @endif
        </div>

        <div class="flex flex-1 flex-col p-5 sm:p-6">
            <h3 class="font-display line-clamp-2 min-w-0 text-lg font-medium leading-snug text-[#041C54] sm:text-xl">
                <a href="{{ route('blog.show', $post->slug) }}" class="transition hover:text-[#647494]">
                    {{ $post->title }}
                </a>
            </h3>

            <p class="mt-3 line-clamp-3 min-w-0 flex-1 text-sm leading-relaxed text-[#7484A4]">
                {{ $post->excerpt }}
            </p>

            <div class="mt-4 flex flex-wrap items-center justify-between gap-2 border-t border-[#BAC2D2]/20 pt-4 text-xs text-[#7484A4] sm:text-sm">
                <div class="flex min-w-0 items-center gap-2">
                    @if($post->author && $post->author->profile && $post->author->profile->profile_image)
                        <img src="{{ asset('storage/' . $post->author->profile->profile_image) }}"
                             alt=""
                             class="h-8 w-8 shrink-0 rounded-full object-cover ring-2 ring-[#BAC2D2]/30">
                    @else
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[linear-gradient(135deg,rgba(100,116,148,0.25)_0%,rgba(4,28,84,0.15)_100%)] text-xs font-semibold text-[#041C54] ring-2 ring-[#BAC2D2]/30">
                            {{ $post->author ? strtoupper(substr($post->author->name, 0, 1)) : 'A' }}
                        </div>
                    @endif
                    <span class="truncate font-medium text-[#041C54]">{{ $post->author?->name ?? 'Anonymous' }}</span>
                </div>
                <div class="flex shrink-0 items-center gap-3">
                    <span class="inline-flex items-center gap-1" title="Published">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $post->published_at->format('M j, Y') }}
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $post->reading_time }} min
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ $post->views_count }}
                    </span>
                </div>
            </div>
        </div>
    </article>
@endforeach
