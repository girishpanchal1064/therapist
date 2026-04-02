@extends('layouts/contentNavbarLayout')

@section('title', 'View Blog Post')

@section('page-style')
<style>
  .layout-page .content-wrapper {
    background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important;
  }

  .page-header {
    background: linear-gradient(90deg, #041C54 0%, #2f4a76 55%, #647494 100%);
    border-radius: 24px;
    padding: 24px 28px;
    margin-bottom: 24px;
    box-shadow: 0 10px 18px rgba(4, 28, 84, 0.28);
  }
  .page-header h4 {
    margin: 0;
    font-weight: 700;
    color: #fff;
    font-size: 1.5rem;
  }
  .page-header p {
    margin: 4px 0 0;
    color: rgba(255, 255, 255, 0.85);
  }
  .page-header .btn-back-blog {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.35);
    color: #fff;
    font-weight: 600;
    border-radius: 10px;
    padding: 10px 18px;
    transition: all 0.3s ease;
  }
  .page-header .btn-back-blog:hover {
    background: rgba(255, 255, 255, 0.3);
    color: #fff;
  }

  .blog-show-main-card {
    border-radius: 16px;
    border: 1px solid rgba(186, 194, 210, 0.35);
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    overflow: hidden;
  }
  .blog-show-main-card > .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
    border-bottom: 1px solid rgba(186, 194, 210, 0.35);
    padding: 20px 24px;
  }
  .blog-show-main-card .card-title {
    font-weight: 700;
    color: #041C54;
  }

  .blog-show-subcard {
    border-radius: 12px;
    border: 1px solid rgba(186, 194, 210, 0.35);
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.04);
    overflow: hidden;
  }
  .blog-show-subcard > .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
    border-bottom: 1px solid rgba(186, 194, 210, 0.3);
  }
  .blog-show-subcard > .card-header h6 {
    font-weight: 700;
    color: #647494;
  }

  .blog-show-excerpt {
    background: rgba(100, 116, 148, 0.08);
    border: 1px solid rgba(186, 194, 210, 0.45);
    border-radius: 12px;
    color: #2d3748;
  }
  .blog-show-excerpt .alert-heading {
    color: #041C54;
    font-weight: 700;
  }

  .btn-blog-gradient {
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 10px;
    padding: 0.5rem 1.1rem;
    box-shadow: 0 8px 14px rgba(4, 28, 84, 0.2);
    transition: all 0.3s ease;
  }
  .btn-blog-gradient:hover {
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 10px 18px rgba(4, 28, 84, 0.28);
  }

  .blog-show-author-avatar {
    background: linear-gradient(90deg, #041C54 0%, #647494 100%) !important;
    color: #fff !important;
    font-weight: 700;
    font-size: 0.75rem;
  }

  .blog-content {
    line-height: 1.8;
  }
  .blog-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
  }
  .blog-content p {
    margin-bottom: 1rem;
  }
  .blog-content h1, .blog-content h2, .blog-content h3, .blog-content h4, .blog-content h5, .blog-content h6 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
  }
  .blog-content ul, .blog-content ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
  }
  .blog-content blockquote {
    border-left: 4px solid #647494;
    padding-left: 1rem;
    margin: 1rem 0;
    font-style: italic;
    color: #6B7280;
  }

  .blog-show-main-card h5.mb-3 {
    color: #041C54;
    font-weight: 700;
  }
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4><i class="ri-article-line me-2"></i>View Blog Post</h4>
      <p>Read-only details and SEO summary</p>
    </div>
    <a href="{{ route('admin.blog.index') }}" class="btn btn-sm btn-back-blog">
      <i class="ri-arrow-left-line me-1"></i> Back to Posts
    </a>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card blog-show-main-card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Blog Post Details</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.blog.edit', $blog) }}" class="btn btn-blog-gradient">
            <i class="ri-pencil-line me-1"></i> Edit
          </a>
        </div>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Featured Image -->
        @if($blog->featured_image)
          <div class="mb-4">
            <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                 alt="{{ $blog->title }}" 
                 class="img-fluid rounded" 
                 style="max-height: 400px; width: 100%; object-fit: cover;">
          </div>
        @endif

        <!-- Post Header -->
        <div class="mb-4">
          <h2 class="mb-2">{{ $blog->title }}</h2>
          
          <div class="d-flex flex-wrap gap-3 align-items-center mb-3">
            @if($blog->category)
              <span class="badge" style="background-color: {{ $blog->category->color ?? '#647494' }}; font-size: 0.875rem;">
                @if($blog->category->icon)
                  <i class="{{ $blog->category->icon }} me-1"></i>
                @endif
                {{ $blog->category->name }}
              </span>
            @endif

            @php
              $statusColors = [
                'draft' => 'secondary',
                'published' => 'success',
                'archived' => 'warning'
              ];
              $color = $statusColors[$blog->status] ?? 'secondary';
            @endphp
            <span class="badge bg-{{ $color }}">
              {{ ucfirst($blog->status) }}
            </span>

            @if($blog->is_featured)
              <span class="badge bg-warning">
                <i class="ri-star-fill me-1"></i> Featured
              </span>
            @endif
          </div>

          <div class="d-flex flex-wrap gap-4 text-muted small mb-3">
            <div class="d-flex align-items-center">
              @if($blog->author->avatar)
                <img src="{{ asset('storage/' . $blog->author->avatar) }}" 
                     alt="{{ $blog->author->name }}" 
                     class="rounded-circle me-2" 
                     width="32" 
                     height="32">
              @else
                <div class="avatar-initial rounded-circle blog-show-author-avatar me-2 d-flex align-items-center justify-content-center" 
                     style="width: 32px; height: 32px;">
                  {{ strtoupper(substr($blog->author->name, 0, 2)) }}
                </div>
              @endif
              <div>
                <div class="fw-bold text-dark">{{ $blog->author->name }}</div>
                <small>Author</small>
              </div>
            </div>

            @if($blog->published_at)
              <div>
                <i class="ri-calendar-line me-1"></i>
                <strong>Published:</strong> {{ $blog->published_at->format('d M Y, h:i A') }}
              </div>
            @endif

            <div>
              <i class="ri-eye-line me-1"></i>
              <strong>Views:</strong> {{ number_format($blog->views_count) }}
            </div>

            @if($blog->reading_time)
              <div>
                <i class="ri-time-line me-1"></i>
                <strong>Reading Time:</strong> {{ $blog->reading_time }} min
              </div>
            @endif

            <div>
              <i class="ri-calendar-check-line me-1"></i>
              <strong>Created:</strong> {{ $blog->created_at->format('d M Y, h:i A') }}
            </div>
          </div>
        </div>

        <!-- Excerpt -->
        @if($blog->excerpt)
          <div class="alert blog-show-excerpt mb-4">
            <h6 class="alert-heading mb-2">
              <i class="ri-file-text-line me-2"></i>Excerpt
            </h6>
            <p class="mb-0">{{ $blog->excerpt }}</p>
          </div>
        @endif

        <!-- Content -->
        <div class="mb-4">
          <h5 class="mb-3">Content</h5>
          <div class="blog-content">
            {!! $blog->content !!}
          </div>
        </div>

        <!-- SEO Information -->
        <div class="row mb-4">
          <div class="col-md-6">
            <div class="card blog-show-subcard">
              <div class="card-header">
                <h6 class="mb-0">
                  <i class="ri-search-line me-2"></i>SEO Information
                </h6>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label small text-muted">Meta Title</label>
                  <div class="fw-bold">{{ $blog->meta_title ?: 'Not set' }}</div>
                </div>
                <div>
                  <label class="form-label small text-muted">Meta Description</label>
                  <div>{{ $blog->meta_description ?: 'Not set' }}</div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card blog-show-subcard">
              <div class="card-header">
                <h6 class="mb-0">
                  <i class="ri-information-line me-2"></i>Post Information
                </h6>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label small text-muted">Slug</label>
                  <div>
                    <code>{{ $blog->slug }}</code>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label small text-muted">Last Updated</label>
                  <div>{{ $blog->updated_at->format('d M Y, h:i A') }}</div>
                </div>
                @if($blog->deleted_at)
                  <div class="alert alert-warning mb-0">
                    <small>
                      <i class="ri-delete-bin-line me-1"></i>
                      Deleted at: {{ $blog->deleted_at->format('d M Y, h:i A') }}
                    </small>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="d-flex gap-2">
          @if($blog->status !== 'published')
            <form action="{{ route('admin.blog.publish', $blog) }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-success">
                <i class="ri-checkbox-circle-line me-1"></i> Publish Now
              </button>
            </form>
          @endif

          <a href="{{ route('admin.blog.edit', $blog) }}" class="btn btn-blog-gradient">
            <i class="ri-pencil-line me-1"></i> Edit Post
          </a>

          <form action="{{ route('admin.blog.destroy', $blog) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">
              <i class="ri-delete-bin-line me-1"></i> Delete
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
