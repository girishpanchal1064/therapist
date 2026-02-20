@extends('layouts.app')

@section('title', 'Mental Health Blog - Apani Psychology')
@section('description', 'Read our latest articles on mental health, wellness tips, therapy insights, and expert advice from licensed therapists.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-50 to-secondary-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                Mental Health
                <span class="text-gradient">Blog</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Expert insights, wellness tips, and mental health resources to support your journey
                towards better mental wellness.
            </p>
        </div>
    </div>
</section>

<!-- Featured Article -->
@if($featuredPost)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-primary-600 to-secondary-600 rounded-2xl p-8 text-white relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white bg-opacity-10 rounded-full -translate-y-32 translate-x-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white bg-opacity-10 rounded-full translate-y-24 -translate-x-24"></div>

            <div class="relative z-10 max-w-3xl">
                <span class="inline-block bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm font-medium mb-4">Featured Article</span>
                <h2 class="text-3xl font-bold mb-4">{{ $featuredPost->title }}</h2>
                <p class="text-xl text-primary-100 mb-6">
                    {{ $featuredPost->excerpt }}
                </p>
                <div class="flex items-center text-primary-100">
                    @if($featuredPost->author && $featuredPost->author->profile && $featuredPost->author->profile->profile_image)
                        <img src="{{ Storage::url($featuredPost->author->profile->profile_image) }}"
                             alt="{{ $featuredPost->author ? $featuredPost->author->name : 'Author' }}"
                             class="w-10 h-10 rounded-full object-cover mr-3">
                    @else
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <p class="font-medium">{{ $featuredPost->author ? $featuredPost->author->name : 'Anonymous' }}</p>
                        <p class="text-sm">
                            @if($featuredPost->author && $featuredPost->author->therapistProfile)
                                {{ $featuredPost->author->therapistProfile->qualification ?? 'Licensed Therapist' }}
                            @elseif($featuredPost->author && $featuredPost->author->profile && $featuredPost->author->profile->qualification)
                                {{ $featuredPost->author->profile->qualification }}
                            @else
                                Licensed Therapist
                            @endif
                        </p>
                    </div>
                    <span class="ml-auto text-sm">{{ $featuredPost->reading_time ?? 5 }} min read</span>
                </div>
                <div class="mt-6">
                    <a href="{{ route('blog.show', $featuredPost->slug) }}"
                       class="inline-flex items-center px-6 py-3 bg-white text-primary-600 font-semibold rounded-lg hover:bg-primary-50 transition-colors">
                        Read Article
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Blog Categories & Posts -->
<section class="py-16 bg-gray-50" x-data="blogFilter()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Category Tabs -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Browse Articles by Category</h2>

            <!-- Tab Navigation -->
            <div class="flex flex-wrap justify-center gap-2 mb-8">
                <button @click="filterPosts('all')"
                        :class="activeCategory === 'all' ? 'bg-primary-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                        class="px-6 py-3 rounded-lg font-medium transition-colors border border-gray-200">
                    All Articles
                </button>
                @foreach($categories as $category)
                    <button @click="filterPosts('{{ $category->id }}')"
                            :class="activeCategory === '{{ $category->id }}' ? 'text-white' : 'text-gray-700 hover:bg-gray-50'"
                            class="px-6 py-3 rounded-lg font-medium transition-colors border border-gray-200"
                            :style="activeCategory === '{{ $category->id }}' ? 'background-color: {{ $category->color }}' : 'background-color: white'">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Loading Spinner -->
        <div x-show="loading" class="text-center py-12">
            <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-primary-600 bg-white transition ease-in-out duration-150">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading articles...
            </div>
        </div>

        <!-- Posts Grid -->
        <div id="posts-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @include('web.blog.partials.posts-grid', ['posts' => $posts])
        </div>

        <!-- Load More Button -->
        <div x-show="hasMore && !loading" class="text-center mt-12">
            <button @click="loadMore()"
                    class="inline-flex items-center px-8 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                Load More Articles
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
        </div>

        <!-- No More Articles Message -->
        <div x-show="!hasMore && !loading && postsLoaded > 0" class="text-center mt-12">
            <div class="bg-gray-100 rounded-lg p-6 max-w-md mx-auto">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">You've reached the end!</h3>
                <p class="text-gray-600">No more articles to load. Check back later for new content.</p>
            </div>
        </div>

        <!-- No Articles Found -->
        <div x-show="!loading && postsLoaded === 0" class="text-center py-12">
            <div class="bg-gray-100 rounded-lg p-8 max-w-md mx-auto">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Articles Found</h3>
                <p class="text-gray-600 mb-4">We couldn't find any articles in this category.</p>
                <button @click="filterPosts('all')"
                        class="inline-flex items-center px-4 py-2 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors">
                    View All Articles
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Signup -->
<section class="py-16 bg-primary-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Stay Updated</h2>
        <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto">
            Get the latest mental health insights and wellness tips delivered to your inbox.
        </p>
        <div class="max-w-md mx-auto flex gap-4">
            <input type="email"
                   placeholder="Enter your email address"
                   class="flex-1 px-4 py-3 rounded-lg border-0 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-primary-600">
            <button class="px-6 py-3 bg-white text-primary-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                Subscribe
            </button>
        </div>
    </div>
</section>

<script>
function blogFilter() {
    return {
        activeCategory: '{{ $categoryId }}',
        loading: false,
        hasMore: {{ $posts->hasMorePages() ? 'true' : 'false' }},
        currentPage: {{ $posts->currentPage() }},
        postsLoaded: {{ $posts->count() }},

        init() {
            // Set initial active category
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

                // Scroll to posts section
                document.getElementById('posts-container').scrollIntoView({
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

                // Append new posts to existing ones
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
