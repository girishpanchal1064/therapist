@extends('layouts/contentNavbarLayout')

@section('title', 'Create Blog Post')

@section('vendor-style')
<style>
  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
  }
  .page-header h4 {
    margin: 0;
    font-weight: 700;
    color: white;
    font-size: 1.5rem;
  }
  .page-header p {
    color: rgba(255, 255, 255, 0.85);
    margin: 4px 0 0 0;
  }
  .page-header .btn-header {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .page-header .btn-header:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    color: white;
  }

  /* Form Card */
  .form-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
    overflow: hidden;
  }
  .form-card .card-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    border-bottom: 1px solid #e9ecef;
    padding: 20px 24px;
  }
  .form-card .card-body { padding: 24px; }

  .form-card .card-body > .row {
    margin-top: 20px;
  }

  .form-card .card-body > .row:first-child {
    margin-top: 0;
  }

  .section-title {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 0;
  }
  .section-title .icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  .section-title h5 { margin: 0; font-weight: 700; color: #2d3748; }
  .section-title small { color: #718096; font-size: 0.85rem; }

  /* Form Styling */
  .form-label-styled {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 8px;
    font-size: 0.9rem;
  }
  .form-control, .form-select {
    border: 2px solid #e4e6eb;
    border-radius: 10px;
    padding: 12px 16px;
    transition: all 0.3s ease;
    font-size: 0.95rem;
  }
  .form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  }
  textarea.form-control {
    min-height: 120px;
  }
  .form-text {
    color: #8e9baa;
    font-size: 0.8rem;
    margin-top: 6px;
  }

  /* Character Counter */
  .char-counter {
    font-size: 0.8rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 6px;
    display: inline-block;
    margin-top: 6px;
  }
  .char-counter.warning { background: rgba(255, 159, 67, 0.15); color: #ff9f43; }
  .char-counter.success { background: rgba(40, 199, 111, 0.15); color: #28c76f; }
  .char-counter.danger { background: rgba(234, 84, 85, 0.15); color: #ea5455; }

  /* Form Check/Switch */
  .form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
  }
  .form-check-input:focus {
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
  }

  /* File Input */
  .file-input-wrapper {
    border: 2px dashed #e4e6eb;
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
  }
  .file-input-wrapper:hover {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.02);
  }
  .file-input-wrapper i {
    font-size: 2.5rem;
    color: #667eea;
    margin-bottom: 12px;
  }

  /* Action Buttons */
  .btn-cancel {
    background: white;
    border: 2px solid #e4e6eb;
    color: #566a7f;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .btn-cancel:hover {
    border-color: #ea5455;
    color: #ea5455;
  }
  .btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 12px 28px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
  }

  /* Alert */
  .alert-modern {
    border-radius: 12px;
    border: none;
    padding: 16px 20px;
  }
  .alert-modern.alert-danger {
    background: linear-gradient(135deg, rgba(234, 84, 85, 0.1) 0%, rgba(234, 84, 85, 0.05) 100%);
    border-left: 4px solid #ea5455;
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4><i class="ri-article-line me-2"></i>Create New Blog Post</h4>
      <p>Publish engaging content for your audience</p>
    </div>
    <a href="{{ route('admin.blog.index') }}" class="btn btn-header">
      <i class="ri-arrow-left-line me-1"></i> Back to Posts
    </a>
  </div>
</div>

@if($errors->any())
  <div class="alert alert-modern alert-danger mb-4">
    <div class="d-flex">
      <i class="ri-error-warning-line me-3 ri-xl text-danger"></i>
      <div>
        <strong class="text-danger">Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
@endif

<form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  
  <div class="row g-4">
    <div class="col-lg-8">
      <!-- Basic Information -->
      <div class="card form-card mb-4">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-file-text-line"></i></div>
            <div>
              <h5>Basic Information</h5>
              <small>Enter the main content details</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label-styled">Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('title') is-invalid @enderror" 
                     id="title" name="title" value="{{ old('title') }}" 
                     placeholder="Enter an engaging blog post title" required>
              @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
              <label class="form-label-styled">Slug <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                     id="slug" name="slug" value="{{ old('slug') }}" 
                     placeholder="auto-generated-slug" required>
              <div class="form-text">URL-friendly identifier</div>
              @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
              <label class="form-label-styled">Excerpt <span class="text-danger">*</span></label>
              <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                        id="excerpt" name="excerpt" rows="3" 
                        placeholder="Write a brief, compelling summary..." required>{{ old('excerpt') }}</textarea>
              <span class="char-counter warning" id="excerpt-count">0 characters</span>
              @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
              <label class="form-label-styled">Content <span class="text-danger">*</span></label>
              <textarea class="form-control @error('content') is-invalid @enderror" 
                        id="content" name="content" rows="12" 
                        placeholder="Write your blog post content here..." required>{{ old('content') }}</textarea>
              @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>
      </div>

      <!-- SEO Settings -->
      <div class="card form-card mb-4">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-search-eye-line"></i></div>
            <div>
              <h5>SEO Settings</h5>
              <small>Optimize for search engines</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label-styled">Focus Keyword</label>
              <input type="text" class="form-control" name="focus_keyword" 
                     value="{{ old('focus_keyword') }}" placeholder="Primary keyword">
            </div>
            <div class="col-md-6">
              <label class="form-label-styled">Meta Title</label>
              <input type="text" class="form-control" id="meta_title" name="meta_title" 
                     value="{{ old('meta_title') }}" placeholder="SEO title" maxlength="60">
              <span class="char-counter warning" id="meta-title-count">0 / 60</span>
            </div>
            <div class="col-12">
              <label class="form-label-styled">Meta Description</label>
              <textarea class="form-control" id="meta_description" name="meta_description" 
                        rows="2" placeholder="SEO description" maxlength="160">{{ old('meta_description') }}</textarea>
              <span class="char-counter warning" id="meta-desc-count">0 / 160</span>
            </div>
            <div class="col-12">
              <label class="form-label-styled">Meta Keywords</label>
              <input type="text" class="form-control" name="meta_keywords" 
                     value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3">
            </div>
          </div>
        </div>
      </div>

      <!-- Social Media -->
      <div class="card form-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-share-line"></i></div>
            <div>
              <h5>Social Media</h5>
              <small>Open Graph settings for sharing</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label-styled">OG Title</label>
              <input type="text" class="form-control" name="og_title" 
                     value="{{ old('og_title') }}" placeholder="Leave empty to use meta title">
            </div>
            <div class="col-md-6">
              <label class="form-label-styled">Twitter Card Type</label>
              <select class="form-select" name="twitter_card">
                <option value="summary_large_image" selected>Summary with Large Image</option>
                <option value="summary">Summary</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label-styled">OG Description</label>
              <textarea class="form-control" name="og_description" rows="2" 
                        placeholder="Leave empty to use meta description">{{ old('og_description') }}</textarea>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top">
            <a href="{{ route('admin.blog.index') }}" class="btn btn-cancel">
              <i class="ri-close-line me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-submit">
              <i class="ri-save-line me-1"></i> Create Blog Post
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
      <!-- Media & Settings -->
      <div class="card form-card mb-4">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-image-line"></i></div>
            <div>
              <h5>Media & Settings</h5>
              <small>Images and publish options</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="mb-4">
            <label class="form-label-styled">Featured Image</label>
            <div class="file-input-wrapper">
              <i class="ri-image-add-line d-block"></i>
              <p class="mb-2 text-muted">Click to upload or drag & drop</p>
              <small class="text-muted">Recommended: 1200x630px</small>
              <input type="file" class="form-control mt-3" name="featured_image" accept="image/*">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label-styled">Category <span class="text-danger">*</span></label>
            <select class="form-select" name="category_id" required>
              <option value="">Select Category</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label-styled">Author <span class="text-danger">*</span></label>
            <select class="form-select" name="author_id" required>
              <option value="">Select Author</option>
              @foreach($authors as $user)
                <option value="{{ $user->id }}" {{ old('author_id', auth()->id()) == $user->id ? 'selected' : '' }}>
                  {{ $user->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label-styled">Status <span class="text-danger">*</span></label>
            <select class="form-select" name="status" required>
              <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>📝 Draft</option>
              <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>✅ Published</option>
              <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>📦 Archived</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label-styled">Published At</label>
            <input type="datetime-local" class="form-control" name="published_at" value="{{ old('published_at') }}">
          </div>

          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="is_featured">⭐ Featured Post</label>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Auto-generate slug
  const title = document.getElementById('title');
  const slug = document.getElementById('slug');
  title?.addEventListener('input', function() {
    if (!slug.dataset.manual) {
      slug.value = this.value.toLowerCase().trim().replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-').replace(/^-+|-+$/g, '');
    }
  });
  slug?.addEventListener('input', () => slug.dataset.manual = 'true');

  // Character counters
  function setupCounter(inputId, counterId, max) {
    const input = document.getElementById(inputId);
    const counter = document.getElementById(counterId);
    if (input && counter) {
      function update() {
        const len = input.value.length;
        counter.textContent = max ? `${len} / ${max}` : `${len} characters`;
        counter.className = 'char-counter ' + (len < (max || 150) * 0.9 ? 'warning' : len > (max || 160) ? 'danger' : 'success');
      }
      input.addEventListener('input', update);
      update();
    }
  }
  setupCounter('excerpt', 'excerpt-count');
  setupCounter('meta_title', 'meta-title-count', 60);
  setupCounter('meta_description', 'meta-desc-count', 160);
});
</script>
@endsection
