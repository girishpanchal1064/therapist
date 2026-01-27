@extends('layouts.app')

@php
    $metaTitle = $post->seo_meta_title ?? $post->title;
    $metaDescription = $post->seo_meta_description ?? $post->excerpt;
@endphp

@section('title', $metaTitle)
@section('description', Str::limit($metaDescription, 160))

@section('head')
@include('web.blog.partials.seo-meta', ['post' => $post, 'skipTitle' => true, 'skipDescription' => true])
@endsection

@section('content')
<!-- Breadcrumb -->
<nav class="bg-gray-50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary-600">Home</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('blog.index') }}" class="text-gray-500 hover:text-primary-600">Blog</a>
            @if($post->category)
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('blog.category', $post->category->slug) }}" class="text-gray-500 hover:text-primary-600">{{ $post->category->name }}</a>
            @endif
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 font-medium">{{ Str::limit($post->title, 50) }}</span>
        </div>
    </div>
</nav>

<!-- Blog Post Content -->
<article class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <header class="mb-8">
            <!-- Category Badge -->
            @if($post->category)
            <div class="mb-4">
                <a href="{{ route('blog.category', $post->category->slug) }}" 
                   class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white hover:opacity-90 transition-opacity"
                   style="background-color: {{ $post->category->color ?? '#3B82F6' }}">
                    @if($post->category->icon)
                        <i class="{{ $post->category->icon }} mr-2"></i>
                    @endif
                    {{ $post->category->name }}
                </a>
            </div>
            @endif

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                {{ $post->title }}
            </h1>

            <!-- Meta Information -->
            <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600 mb-6">
                <!-- Author -->
                @if($post->author)
                <div class="flex items-center">
                    @if($post->author->profile && $post->author->profile->profile_image)
                        <img src="{{ asset('storage/' . $post->author->profile->profile_image) }}"
                             alt="{{ $post->author ? $post->author->name : 'Author' }}"
                             class="w-10 h-10 rounded-full object-cover mr-3">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-semibold mr-3">
                            {{ strtoupper(substr($post->author ? $post->author->name : 'A', 0, 2)) }}
                        </div>
                    @endif
                    <div>
                        <div class="font-semibold text-gray-900">{{ $post->author ? $post->author->name : 'Anonymous' }}</div>
                        @if($post->author->profile && $post->author->profile->designation)
                            <div class="text-xs text-gray-500">{{ $post->author->profile->designation }}</div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Published Date -->
                @if($post->published_at)
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $post->published_at->format('F d, Y') }}
                </div>
                @endif

                <!-- Reading Time -->
                @if($post->reading_time)
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $post->reading_time }} min read
                </div>
                @endif

                <!-- Views -->
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ number_format($post->views_count) }} views
                </div>
            </div>

            <!-- Featured Badge -->
            @if($post->is_featured)
            <div class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium mb-6">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Featured Article
            </div>
            @endif
        </header>

        <!-- Featured Image -->
        @if($post->featured_image)
        <div class="mb-8 rounded-2xl overflow-hidden">
            <img src="{{ asset('storage/' . $post->featured_image) }}" 
                 alt="{{ $post->title }}" 
                 class="w-full h-auto object-cover">
        </div>
        @endif

        <!-- Excerpt -->
        @if($post->excerpt)
        <div class="mb-8 p-6 bg-gradient-to-r from-primary-50 to-secondary-50 rounded-xl border-l-4 border-primary-600">
            <p class="text-lg text-gray-700 leading-relaxed italic">
                {{ $post->excerpt }}
            </p>
        </div>
        @endif

        <!-- Content -->
        <div class="prose prose-lg max-w-none mb-12 blog-content">
            {!! $post->content !!}
        </div>

        <!-- Tags/Keywords -->
        @if($post->meta_keywords)
        <div class="mb-8 pt-8 border-t border-gray-200">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Tags</h3>
            <div class="flex flex-wrap gap-2">
                @foreach(explode(',', $post->meta_keywords) as $keyword)
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                        {{ trim($keyword) }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Share Buttons -->
        <div class="mb-12 pt-8 border-t border-gray-200">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Share this article</h3>
            <div class="flex flex-wrap gap-3">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                   target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" 
                   target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    Twitter
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                   target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    LinkedIn
                </a>
                <button onclick="copyToClipboard('{{ url()->current() }}')" 
                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Copy Link
                </button>
            </div>
        </div>
    </div>
</article>

<!-- Related Posts -->
@if($relatedPosts->count() > 0)
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Related Articles</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @include('web.blog.partials.posts-grid', ['posts' => $relatedPosts])
        </div>
    </div>
</section>
@endif

<!-- Back to Blog -->
<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <a href="{{ route('blog.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Blog
        </a>
    </div>
</section>
@endsection

@section('page-style')
<style>
    .blog-content {
        line-height: 1.8;
        color: #374151;
    }
    .blog-content h1, .blog-content h2, .blog-content h3, .blog-content h4, .blog-content h5, .blog-content h6 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 700;
        color: #111827;
    }
    .blog-content h2 {
        font-size: 2rem;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 0.5rem;
    }
    .blog-content h3 {
        font-size: 1.5rem;
    }
    .blog-content p {
        margin-bottom: 1.5rem;
        font-size: 1.125rem;
    }
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 2rem 0;
    }
    .blog-content ul, .blog-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
    .blog-content li {
        margin-bottom: 0.5rem;
    }
    .blog-content blockquote {
        border-left: 4px solid #3B82F6;
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        color: #6B7280;
        background-color: #F9FAFB;
        padding: 1.5rem;
        border-radius: 8px;
    }
    .blog-content code {
        background-color: #F3F4F6;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.875rem;
        color: #EF4444;
    }
    .blog-content pre {
        background-color: #1F2937;
        color: #F9FAFB;
        padding: 1.5rem;
        border-radius: 8px;
        overflow-x: auto;
        margin: 2rem 0;
    }
    .blog-content pre code {
        background-color: transparent;
        color: inherit;
        padding: 0;
    }
    .blog-content a {
        color: #3B82F6;
        text-decoration: underline;
    }
    .blog-content a:hover {
        color: #2563EB;
    }
    .blog-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 2rem 0;
    }
    .blog-content table th,
    .blog-content table td {
        border: 1px solid #E5E7EB;
        padding: 0.75rem;
        text-align: left;
    }
    .blog-content table th {
        background-color: #F9FAFB;
        font-weight: 600;
    }
</style>
@endsection

@section('page-script')
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Link copied to clipboard!');
        }, function(err) {
            console.error('Failed to copy: ', err);
        });
    }
</script>
@endsection
