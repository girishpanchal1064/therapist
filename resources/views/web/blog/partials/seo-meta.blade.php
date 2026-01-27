{{-- SEO Meta Tags Partial for Blog Posts --}}
@php
    $metaTitle = $post->seo_meta_title ?? $post->title;
    $metaDescription = $post->seo_meta_description ?? $post->excerpt;
    $ogTitle = $post->og_title_formatted ?? $post->seo_meta_title ?? $post->title;
    $ogDescription = $post->og_description_formatted ?? $post->seo_meta_description ?? $post->excerpt;
    $ogImage = $post->og_image_url ?? asset('assets/img/blog-default.jpg');
    $canonicalUrl = $post->canonical_url_formatted ?? route('blog.show', $post->slug);
@endphp

{{-- Basic Meta Tags --}}
@if(!isset($skipTitle))
<title>{{ $metaTitle }} | {{ config('app.name') }}</title>
@endif
@if(!isset($skipDescription))
<meta name="description" content="{{ Str::limit($metaDescription, 160) }}">
@endif
@if($post->meta_keywords)
<meta name="keywords" content="{{ $post->meta_keywords }}">
@endif
@if($post->focus_keyword)
<meta name="robots" content="index, follow">
@else
<meta name="robots" content="noindex, nofollow">
@endif
@if($post->author)
@if($post->author)
<meta name="author" content="{{ $post->author->name ?? 'Anonymous' }}">
@endif
@endif

{{-- Canonical URL --}}
<link rel="canonical" href="{{ $canonicalUrl }}">

{{-- Open Graph Tags --}}
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ Str::limit($ogDescription, 200) }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:site_name" content="{{ config('app.name') }}">
@if($post->published_at)
<meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}">
@endif
@if($post->updated_at)
<meta property="article:modified_time" content="{{ $post->updated_at->toIso8601String() }}">
@endif
@if($post->author)
<meta property="article:author" content="{{ $post->author->name ?? 'Anonymous' }}">
@endif
@if($post->category)
<meta property="article:section" content="{{ $post->category->name }}">
@endif

{{-- Twitter Card Tags --}}
<meta name="twitter:card" content="{{ $post->twitter_card ?? 'summary_large_image' }}">
<meta name="twitter:title" content="{{ $ogTitle }}">
<meta name="twitter:description" content="{{ Str::limit($ogDescription, 200) }}">
<meta name="twitter:image" content="{{ $ogImage }}">
@if($post->author && $post->author->twitter_handle ?? null)
<meta name="twitter:creator" content="@{{ $post->author->twitter_handle }}">
@endif

{{-- Structured Data (JSON-LD) --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "{{ $post->title }}",
  "description": "{{ Str::limit(strip_tags($post->excerpt), 200) }}",
  "image": "{{ $ogImage }}",
  "datePublished": "{{ $post->published_at ? $post->published_at->toIso8601String() : $post->created_at->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  @if($post->author)
  "author": {
    "@type": "Person",
    "name": "{{ $post->author->name ?? 'Anonymous' }}"
    @if($post->author->email)
    ,"email": "{{ $post->author->email }}"
    @endif
  },
  @else
  "author": {
    "@type": "Person",
    "name": "Anonymous"
  },
  @endif
  "publisher": {
    "@type": "Organization",
    "name": "{{ config('app.name') }}",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('logo.png') }}"
    }
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ $canonicalUrl }}"
  }
  @if($post->category)
  ,"articleSection": "{{ $post->category->name }}"
  @endif
  @if($post->reading_time)
  ,"timeRequired": "PT{{ $post->reading_time }}M"
  @endif
}
</script>
