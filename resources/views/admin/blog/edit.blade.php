@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Blog Post')

@section('page-style')
<style>
  .card .card-body > .row {
    margin-top: 20px;
  }

  .card .card-body > .row:first-child {
    margin-top: 0;
  }
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Edit Blog Post</h5>
        <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
          <i class="ri-arrow-left-line me-1"></i> Back to Posts
        </a>
      </div>
      <div class="card-body">
        @if(session('error'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible" role="alert">
            <i class="ri-error-warning-line me-2"></i>
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form action="{{ route('admin.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- Basic Information -->
          <div class="mb-4">
            <h6 class="text-muted mb-3">
              <i class="ri-file-text-line me-2"></i>Basic Information
            </h6>
            
            <div class="row">
              <div class="col-md-8">
                <div class="mb-3">
                  <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('title') is-invalid @enderror" 
                         id="title" name="title" value="{{ old('title', $blog->title) }}" 
                         placeholder="Blog Post Title" required>
                  @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-4">
                <div class="mb-3">
                  <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                         id="slug" name="slug" value="{{ old('slug', $blog->slug) }}" 
                         placeholder="blog-post-slug" required>
                  <small class="text-muted">URL-friendly identifier (auto-generated from title)</small>
                  @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="excerpt" class="form-label">Excerpt <span class="text-danger">*</span></label>
              <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                        id="excerpt" name="excerpt" rows="3" 
                        placeholder="Brief description of the blog post..." required>{{ old('excerpt', $blog->excerpt) }}</textarea>
              <small class="text-muted">Recommended: 150-160 characters for SEO</small>
              <div class="mt-1">
                <small id="excerpt-count" class="text-muted">0 characters</small>
              </div>
              @error('excerpt')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
              <textarea class="form-control @error('content') is-invalid @enderror" 
                        id="content" name="content" rows="15" 
                        placeholder="Blog post content..." required>{{ old('content', $blog->content) }}</textarea>
              @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Media & Settings -->
          <div class="mb-4">
            <h6 class="text-muted mb-3">
              <i class="ri-image-line me-2"></i>Media & Settings
            </h6>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="featured_image" class="form-label">Featured Image</label>
                  <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                         id="featured_image" name="featured_image" accept="image/*">
                  @if($blog->featured_image)
                    <div class="mt-2">
                      <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                           alt="Current featured image" 
                           class="img-thumbnail" 
                           style="max-width: 200px;">
                      <div class="mt-1">
                        <small class="text-muted">Current image</small>
                      </div>
                    </div>
                  @endif
                  <small class="text-muted">Recommended: 1200x630px for optimal SEO</small>
                  @error('featured_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                      <select class="form-select @error('category_id') is-invalid @enderror" 
                              id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach(\App\Models\BlogCategory::orderBy('name')->get() as $category)
                          <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                          </option>
                        @endforeach
                      </select>
                      @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="author_id" class="form-label">Author <span class="text-danger">*</span></label>
                      <select class="form-select @error('author_id') is-invalid @enderror" 
                              id="author_id" name="author_id" required>
                        <option value="">Select Author</option>
                        @foreach(\App\Models\User::whereHas('roles', function($q) { $q->whereIn('name', ['Admin', 'SuperAdmin', 'Therapist']); })->orderBy('name')->get() as $user)
                          <option value="{{ $user->id }}" {{ old('author_id', $blog->author_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                          </option>
                        @endforeach
                      </select>
                      @error('author_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                      <select class="form-select @error('status') is-invalid @enderror" 
                              id="status" name="status" required>
                        <option value="draft" {{ old('status', $blog->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $blog->status) === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status', $blog->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                      </select>
                      @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="published_at" class="form-label">Published At</label>
                      <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                             id="published_at" name="published_at" 
                             value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}">
                      @error('published_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="is_featured" 
                           name="is_featured" value="1" 
                           {{ old('is_featured', $blog->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">
                      Featured Post
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- SEO Settings -->
          <div class="mb-4">
            <h6 class="text-muted mb-3">
              <i class="ri-search-line me-2"></i>SEO Settings
            </h6>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="focus_keyword" class="form-label">Focus Keyword</label>
                  <input type="text" class="form-control @error('focus_keyword') is-invalid @enderror" 
                         id="focus_keyword" name="focus_keyword" 
                         value="{{ old('focus_keyword', $blog->focus_keyword ?? '') }}" 
                         placeholder="Primary keyword for this post">
                  <small class="text-muted">The main keyword you want to rank for</small>
                  @error('focus_keyword')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label for="meta_title" class="form-label">Meta Title</label>
                  <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                         id="meta_title" name="meta_title" 
                         value="{{ old('meta_title', $blog->meta_title ?? '') }}" 
                         placeholder="SEO optimized title" maxlength="60">
                  <small class="text-muted">Recommended: 50-60 characters</small>
                  <div class="mt-1">
                    <small id="meta-title-count" class="text-muted">0 / 60 characters</small>
                  </div>
                  @error('meta_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="meta_description" class="form-label">Meta Description</label>
              <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                        id="meta_description" name="meta_description" rows="3" 
                        placeholder="SEO meta description" maxlength="160">{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
              <small class="text-muted">Recommended: 150-160 characters</small>
              <div class="mt-1">
                <small id="meta-desc-count" class="text-muted">0 / 160 characters</small>
              </div>
              @error('meta_description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="meta_keywords" class="form-label">Meta Keywords</label>
              <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                     id="meta_keywords" name="meta_keywords" 
                     value="{{ old('meta_keywords', $blog->meta_keywords ?? '') }}" 
                     placeholder="keyword1, keyword2, keyword3">
              <small class="text-muted">Comma-separated keywords (optional, less important for modern SEO)</small>
              @error('meta_keywords')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="canonical_url" class="form-label">Canonical URL</label>
              <input type="url" class="form-control @error('canonical_url') is-invalid @enderror" 
                     id="canonical_url" name="canonical_url" 
                     value="{{ old('canonical_url', $blog->canonical_url ?? '') }}" 
                     placeholder="https://your-domain.com/blog/post-slug">
              <small class="text-muted">Leave empty to use default URL. Use for duplicate content prevention.</small>
              @error('canonical_url')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Open Graph & Social Media -->
          <div class="mb-4">
            <h6 class="text-muted mb-3">
              <i class="ri-share-line me-2"></i>Open Graph & Social Media
            </h6>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="og_title" class="form-label">OG Title</label>
                  <input type="text" class="form-control @error('og_title') is-invalid @enderror" 
                         id="og_title" name="og_title" 
                         value="{{ old('og_title', $blog->og_title ?? '') }}" 
                         placeholder="Open Graph title">
                  <small class="text-muted">Leave empty to use meta title</small>
                  @error('og_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label for="og_image" class="form-label">OG Image</label>
                  <input type="file" class="form-control @error('og_image') is-invalid @enderror" 
                         id="og_image" name="og_image" accept="image/*">
                  @if($blog->og_image)
                    <div class="mt-2">
                      <img src="{{ asset('storage/' . $blog->og_image) }}" 
                           alt="Current OG image" 
                           class="img-thumbnail" 
                           style="max-width: 200px;">
                    </div>
                  @endif
                  <small class="text-muted">Recommended: 1200x630px. Leave empty to use featured image</small>
                  @error('og_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="og_description" class="form-label">OG Description</label>
              <textarea class="form-control @error('og_description') is-invalid @enderror" 
                        id="og_description" name="og_description" rows="2" 
                        placeholder="Open Graph description">{{ old('og_description', $blog->og_description ?? '') }}</textarea>
              <small class="text-muted">Leave empty to use meta description</small>
              @error('og_description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="twitter_card" class="form-label">Twitter Card Type</label>
              <select class="form-select @error('twitter_card') is-invalid @enderror" 
                      id="twitter_card" name="twitter_card">
                <option value="summary" {{ old('twitter_card', $blog->twitter_card ?? 'summary_large_image') === 'summary' ? 'selected' : '' }}>Summary</option>
                <option value="summary_large_image" {{ old('twitter_card', $blog->twitter_card ?? 'summary_large_image') === 'summary_large_image' ? 'selected' : '' }}>Summary with Large Image</option>
              </select>
              @error('twitter_card')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
              <i class="ri-close-line me-2"></i>Cancel
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="ri-save-line me-2"></i>Update Blog Post
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    if (titleInput && slugInput) {
      titleInput.addEventListener('input', function() {
        if (!slugInput.dataset.manualEdit) {
          const slug = this.value
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
          slugInput.value = slug;
        }
      });

      slugInput.addEventListener('input', function() {
        this.dataset.manualEdit = 'true';
      });
    }

    // Character counters
    const excerptInput = document.getElementById('excerpt');
    const excerptCount = document.getElementById('excerpt-count');
    if (excerptInput && excerptCount) {
      function updateExcerptCount() {
        const length = excerptInput.value.length;
        excerptCount.textContent = length + ' characters';
        if (length < 150) {
          excerptCount.className = 'text-warning';
        } else if (length > 160) {
          excerptCount.className = 'text-danger';
        } else {
          excerptCount.className = 'text-success';
        }
      }
      excerptInput.addEventListener('input', updateExcerptCount);
      updateExcerptCount();
    }

    const metaTitleInput = document.getElementById('meta_title');
    const metaTitleCount = document.getElementById('meta-title-count');
    if (metaTitleInput && metaTitleCount) {
      function updateMetaTitleCount() {
        const length = metaTitleInput.value.length;
        metaTitleCount.textContent = length + ' / 60 characters';
        if (length < 50) {
          metaTitleCount.className = 'text-warning';
        } else if (length > 60) {
          metaTitleCount.className = 'text-danger';
        } else {
          metaTitleCount.className = 'text-success';
        }
      }
      metaTitleInput.addEventListener('input', updateMetaTitleCount);
      updateMetaTitleCount();
    }

    const metaDescInput = document.getElementById('meta_description');
    const metaDescCount = document.getElementById('meta-desc-count');
    if (metaDescInput && metaDescCount) {
      function updateMetaDescCount() {
        const length = metaDescInput.value.length;
        metaDescCount.textContent = length + ' / 160 characters';
        if (length < 150) {
          metaDescCount.className = 'text-warning';
        } else if (length > 160) {
          metaDescCount.className = 'text-danger';
        } else {
          metaDescCount.className = 'text-success';
        }
      }
      metaDescInput.addEventListener('input', updateMetaDescCount);
      updateMetaDescCount();
    }
  });
</script>
@endsection
