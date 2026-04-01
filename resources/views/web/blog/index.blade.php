@extends('layouts.app')

@section('title', 'Mental Health Blog - Apani Psychology')
@section('description', 'Read our latest articles on mental health, wellness tips, therapy insights, and expert advice from licensed therapists.')

@section('content')
<div class="blog-page min-h-screen bg-gradient-to-b from-white to-[#BAC2D2]/5">
    {{-- Hero — consistent with Self Assessment / Figma blog 1:1564 --}}
    <section class="marketing-page-hero">
        <div class="pointer-events-none absolute inset-0 opacity-10" aria-hidden="true">
            <div class="absolute left-4 top-16 h-64 w-64 rounded-full bg-white blur-[64px] md:left-10 md:h-72 md:w-72"></div>
            <div class="absolute -right-8 top-6 h-80 w-80 rounded-full bg-[#647494] blur-[64px] md:right-0 md:h-96 md:w-96"></div>
        </div>
        <div class="relative z-10 mx-auto w-full max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <h1 class="font-display text-4xl font-medium leading-tight text-white md:text-5xl lg:text-[3.75rem] lg:leading-[1.1]">
                Mental Health <span class="text-[#BAC2D2]">Blog</span>
            </h1>
            <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-[#BAC2D2] md:text-lg">
                Expert insights, wellness tips, and mental health resources to support your journey towards better mental wellness.
            </p>
            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="#blog-articles"
                   class="inline-flex min-h-[3.5rem] w-full items-center justify-center rounded-[14px] border-2 border-white bg-[#041C54] px-8 text-base font-medium text-white shadow-[0_10px_15px_rgba(0,0,0,0.15)] transition hover:bg-[#031340] sm:w-auto sm:min-w-[12rem]">
                    Browse Articles
                </a>
                <a href="#blog-newsletter"
                   class="inline-flex min-h-[3.75rem] w-full items-center justify-center rounded-[14px] border-2 border-white px-8 text-base font-medium text-white transition hover:bg-white/10 sm:w-auto sm:min-w-[10rem]">
                    Subscribe
                </a>
            </div>
        </div>
    </section>

    {{-- Featured article — split card --}}
    @if($featuredPost)
        <section class="relative z-[1] -mt-6 px-4 pb-12 sm:px-6 lg:px-8 lg:pb-16">
            <div class="mx-auto max-w-5xl">
                <div class="overflow-hidden rounded-2xl border border-[#BAC2D2]/30 bg-white shadow-[0_20px_50px_-12px_rgba(4,28,84,0.2)] lg:flex lg:min-h-[320px]">
                    <div class="relative aspect-[16/10] w-full lg:aspect-auto lg:w-[46%] lg:min-h-[320px]">
                        @if($featuredPost->featured_image)
                            <img src="{{ $featuredPost->featured_image_url }}"
                                 alt="{{ $featuredPost->title }}"
                                 class="absolute inset-0 h-full w-full object-cover">
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-[#BAC2D2]/40 to-[#647494]/30"></div>
                            <div class="absolute inset-0 flex items-center justify-center text-[#647494]">
                                <svg class="h-20 w-20 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col justify-center bg-[#041C54] p-6 sm:p-8 lg:p-10">
                        <span class="inline-flex w-fit items-center rounded-full bg-[#BAC2D2]/20 px-3 py-1 text-xs font-medium text-[#BAC2D2]">
                            Featured Article
                        </span>
                        <h2 class="font-display mt-4 text-2xl font-medium leading-snug text-white md:text-3xl">
                            {{ $featuredPost->title }}
                        </h2>
                        <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-[#BAC2D2] sm:text-base">
                            {{ $featuredPost->excerpt }}
                        </p>
                        <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-[#BAC2D2]">
                            @if($featuredPost->author && $featuredPost->author->profile && $featuredPost->author->profile->profile_image)
                                <img src="{{ asset('storage/' . $featuredPost->author->profile->profile_image) }}"
                                     alt=""
                                     class="h-10 w-10 rounded-full object-cover ring-2 ring-white/20">
                            @else
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/15 ring-2 ring-white/20">
                                    <svg class="h-5 w-5 text-white/90" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-medium text-white">{{ $featuredPost->author ? $featuredPost->author->name : 'Anonymous' }}</p>
                                <p class="text-xs text-[#BAC2D2]/90">
                                    @if($featuredPost->author && $featuredPost->author->therapistProfile)
                                        {{ $featuredPost->author->therapistProfile->qualification ?? 'Licensed Therapist' }}
                                    @elseif($featuredPost->author && $featuredPost->author->profile && $featuredPost->author->profile->qualification)
                                        {{ $featuredPost->author->profile->qualification }}
                                    @else
                                        Licensed Therapist
                                    @endif
                                </p>
                            </div>
                            <span class="ml-auto inline-flex items-center gap-1 text-xs sm:text-sm">
                                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $featuredPost->reading_time ?? 5 }} min read
                            </span>
                        </div>
                        <div class="mt-8">
                            <a href="{{ route('blog.show', $featuredPost->slug) }}"
                               class="inline-flex items-center justify-center gap-2 rounded-[14px] bg-white px-6 py-3 text-base font-medium text-[#041C54] shadow-[0_10px_15px_rgba(0,0,0,0.12)] transition hover:bg-[#BAC2D2]/30">
                                Read Article
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Categories & grid --}}
    <section id="blog-articles" class="scroll-mt-20 px-4 py-12 sm:px-6 lg:px-8 lg:py-16" x-data="blogFilter()">
        <div class="mx-auto max-w-7xl">
            <div class="mb-10 text-center lg:mb-12">
                <h2 class="font-display text-3xl font-medium text-[#041C54] md:text-4xl">Browse Articles by Category</h2>
                <div class="mt-8 flex flex-wrap justify-center gap-2 sm:gap-3">
                    <button type="button"
                            @click="filterPosts('all')"
                            :class="activeCategory === 'all'
                                ? 'border-[#041C54] bg-[#041C54] text-white shadow-[0_8px_20px_rgba(4,28,84,0.25)]'
                                : 'border-[#BAC2D2]/40 bg-white text-[#041C54] hover:border-[#647494]/40'"
                            class="rounded-full border px-4 py-2.5 text-sm font-medium transition sm:px-6 sm:py-3 sm:text-base">
                        All Articles
                    </button>
                    @foreach($categories as $category)
                        <button type="button"
                                @click="filterPosts('{{ $category->id }}')"
                                :class="activeCategory === '{{ $category->id }}'
                                    ? 'border-[#041C54] bg-[#041C54] text-white shadow-[0_8px_20px_rgba(4,28,84,0.25)]'
                                    : 'border-[#BAC2D2]/40 bg-white text-[#041C54] hover:border-[#647494]/40'"
                                class="rounded-full border px-4 py-2.5 text-sm font-medium transition sm:px-6 sm:py-3 sm:text-base">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div x-show="loading" x-cloak class="py-12 text-center">
                <div class="inline-flex items-center gap-3 rounded-[14px] border border-[#BAC2D2]/30 bg-white px-5 py-3 text-sm font-medium text-[#7484A4] shadow-sm">
                    <svg class="h-5 w-5 animate-spin text-[#647494]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Loading articles…
                </div>
            </div>

            <div id="posts-container" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                @include('web.blog.partials.posts-grid', ['posts' => $posts])
            </div>

            <div x-show="hasMore && !loading" x-cloak class="mt-10 text-center sm:mt-12">
                <button type="button"
                        @click="loadMore()"
                        class="inline-flex items-center justify-center gap-2 rounded-[14px] bg-[#041C54] px-8 py-3.5 text-base font-medium text-white shadow-[0_8px_20px_rgba(4,28,84,0.35)] transition hover:bg-[#031340]">
                    Load More Articles
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </button>
            </div>

            <div x-show="!hasMore && !loading && postsLoaded > 0" x-cloak class="mt-10 text-center sm:mt-12">
                <div class="mx-auto max-w-md rounded-2xl border border-[#BAC2D2]/30 bg-[#BAC2D2]/10 p-6">
                    <svg class="mx-auto mb-4 h-12 w-12 text-[#647494]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="font-display text-lg font-medium text-[#041C54]">You've reached the end</h3>
                    <p class="mt-2 text-sm text-[#7484A4]">No more articles to load. Check back later for new content.</p>
                </div>
            </div>

            <div x-show="!loading && postsLoaded === 0" x-cloak class="py-12 text-center">
                <div class="mx-auto max-w-md rounded-2xl border border-[#BAC2D2]/30 bg-white p-8 shadow-sm">
                    <svg class="mx-auto mb-4 h-16 w-16 text-[#7484A4]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="font-display text-xl font-medium text-[#041C54]">No Articles Found</h3>
                    <p class="mt-2 text-[#7484A4]">We couldn't find any articles in this category.</p>
                    <button type="button"
                            @click="filterPosts('all')"
                            class="mt-6 inline-flex items-center justify-center rounded-[14px] bg-[#041C54] px-6 py-2.5 text-sm font-medium text-white transition hover:bg-[#031340]">
                        View All Articles
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- Newsletter — solid Gulf Blue --}}
    <section id="blog-newsletter" class="relative overflow-hidden bg-[#041C54] px-4 py-14 sm:px-6 md:py-16 lg:px-8 scroll-mt-20">
        <div class="pointer-events-none absolute inset-0 opacity-10" aria-hidden="true">
            <div class="absolute left-4 top-10 h-72 w-72 rounded-full bg-white blur-[64px]"></div>
            <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-[#BAC2D2] blur-[64px]"></div>
        </div>
        <div class="relative mx-auto max-w-2xl text-center">
            <h2 class="font-display text-3xl font-medium text-white md:text-4xl">Stay Updated</h2>
            <p class="mx-auto mt-4 max-w-xl text-base leading-relaxed text-[#BAC2D2] md:text-lg">
                Get the latest mental health insights and wellness tips delivered to your inbox.
            </p>
            <form class="mt-8 flex w-full flex-col gap-3 sm:flex-row sm:items-stretch sm:justify-center" action="#" onsubmit="return false;">
                <label class="relative min-w-0 flex-1 sm:max-w-md">
                    <span class="sr-only">Email address</span>
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-[#7484A4]" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <input type="email"
                           name="newsletter_email"
                           autocomplete="email"
                           placeholder="Enter your email address"
                           class="w-full rounded-[14px] border border-white/20 bg-[#031340] py-3.5 pl-11 pr-4 text-base text-white placeholder:text-[#7484A4] focus:border-white/40 focus:outline-none focus:ring-2 focus:ring-white/20">
                </label>
                <button type="button"
                        class="inline-flex shrink-0 items-center justify-center rounded-[14px] bg-white px-8 py-3.5 text-base font-medium text-[#041C54] shadow-[0_10px_15px_rgba(0,0,0,0.12)] transition hover:bg-[#BAC2D2]/30 sm:w-auto">
                    Subscribe
                </button>
            </form>
        </div>
    </section>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>

<script>
function blogFilter() {
    return {
        activeCategory: '{{ $categoryId }}',
        loading: false,
        hasMore: {{ $posts->hasMorePages() ? 'true' : 'false' }},
        currentPage: {{ $posts->currentPage() }},
        postsLoaded: {{ $posts->total() }},

        init() {
            this.activeCategory = '{{ $categoryId }}';
        },

        async filterPosts(categoryId) {
            this.activeCategory = categoryId;
            this.loading = true;
            this.currentPage = 1;
            this.postsLoaded = 0;

            try {
                const response = await fetch(`{{ route('blog.index') }}?category=${categoryId}&page=1`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                document.getElementById('posts-container').innerHTML = data.html;
                this.hasMore = data.hasMore;
                this.currentPage = data.nextPage;
                this.postsLoaded = data.total;
                this.loading = false;

                document.getElementById('blog-articles')?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

            } catch (error) {
                console.error('Error loading posts:', error);
                this.loading = false;
            }
        },

        async loadMore() {
            if (this.loading || !this.hasMore) return;

            this.loading = true;

            try {
                const response = await fetch(`{{ route('blog.index') }}?category=${this.activeCategory}&page=${this.currentPage}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                const container = document.getElementById('posts-container');
                container.insertAdjacentHTML('beforeend', data.html);

                this.hasMore = data.hasMore;
                this.currentPage = data.nextPage;
                this.postsLoaded += data.html.match(/class="blog-card"/g)?.length || 0;
                this.loading = false;

            } catch (error) {
                console.error('Error loading more posts:', error);
                this.loading = false;
            }
        }
    }
}
</script>
@endsection
