@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Assessment')

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
        <h5 class="card-title mb-0">Edit Assessment</h5>
        <a href="{{ route('admin.assessments.index') }}" class="btn btn-outline-secondary">
          <i class="ri-arrow-left-line me-1"></i> Back to Assessments
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

        <form action="{{ route('admin.assessments.update', $assessment) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="row">
            <div class="col-md-8">
              <div class="mb-3">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                       id="title" name="title" value="{{ old('title', $assessment->title) }}" 
                       placeholder="Assessment Title" required>
                @error('title')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                       id="slug" name="slug" value="{{ old('slug', $assessment->slug) }}" 
                       placeholder="assessment-slug" required>
                <small class="text-muted">URL-friendly identifier (auto-generated from title)</small>
                @error('slug')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                      id="description" name="description" rows="4" 
                      placeholder="Assessment description..." required>{{ old('description', $assessment->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('category') is-invalid @enderror" 
                       id="category" name="category" value="{{ old('category', $assessment->category) }}" 
                       placeholder="e.g., Mental Health, Wellness" required>
                @error('category')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="duration_minutes" class="form-label">Duration (Minutes) <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" 
                       id="duration_minutes" name="duration_minutes" 
                       value="{{ old('duration_minutes', $assessment->duration_minutes) }}" 
                       min="1" max="300" required>
                @error('duration_minutes')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="question_count" class="form-label">Question Count</label>
                <input type="number" class="form-control @error('question_count') is-invalid @enderror" 
                       id="question_count" name="question_count" 
                       value="{{ old('question_count', $assessment->question_count) }}" 
                       min="0" readonly>
                <small class="text-muted">Auto-calculated from questions</small>
                @error('question_count')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="icon" class="form-label">Icon</label>
                <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                       id="icon" name="icon" value="{{ old('icon', $assessment->icon) }}" 
                       placeholder="e.g., ri-mental-health-line">
                <small class="text-muted">RemixIcon class name</small>
                @error('icon')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if($assessment->icon)
                  <div class="mt-2">
                    <label class="form-label small">Preview:</label>
                    <div>
                      <i class="{{ $assessment->icon }}" style="font-size: 2rem; color: {{ $assessment->color ?? '#3B82F6' }};"></i>
                    </div>
                  </div>
                @endif
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="color" class="form-label">Color</label>
                <div class="input-group">
                  <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                         id="color" name="color" value="{{ old('color', $assessment->color ?? '#3B82F6') }}" 
                         title="Choose color">
                  <input type="text" class="form-control @error('color') is-invalid @enderror" 
                         value="{{ old('color', $assessment->color ?? '#3B82F6') }}" 
                         placeholder="#3B82F6" readonly>
                </div>
                <small class="text-muted">Hex color code for icon and badges</small>
                @error('color')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="sort_order" class="form-label">Sort Order</label>
                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                       id="sort_order" name="sort_order" 
                       value="{{ old('sort_order', $assessment->sort_order) }}" 
                       min="0">
                <small class="text-muted">Lower numbers appear first</small>
                @error('sort_order')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <div class="form-check form-switch mt-4">
                  <input class="form-check-input" type="checkbox" id="is_active" 
                         name="is_active" value="1" 
                         {{ old('is_active', $assessment->is_active) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_active">
                    Active
                  </label>
                </div>
                <small class="text-muted d-block">Make this assessment available to users</small>
              </div>
            </div>
          </div>

          <div class="mb-4">
            <h6 class="text-muted mb-3">
              <i class="ri-search-line me-2"></i>SEO Settings
            </h6>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="meta_title" class="form-label">Meta Title</label>
                  <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                         id="meta_title" name="meta_title" 
                         value="{{ old('meta_title', $assessment->meta_title) }}" 
                         placeholder="SEO meta title">
                  <small class="text-muted">For search engines (optional)</small>
                  @error('meta_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label for="meta_description" class="form-label">Meta Description</label>
                  <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                            id="meta_description" name="meta_description" rows="2" 
                            placeholder="SEO meta description">{{ old('meta_description', $assessment->meta_description) }}</textarea>
                  <small class="text-muted">For search engines (optional)</small>
                  @error('meta_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.assessments.index') }}" class="btn btn-outline-secondary">
              <i class="ri-close-line me-2"></i>Cancel
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="ri-save-line me-2"></i>Update Assessment
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

    // Sync color picker with text input
    const colorPicker = document.getElementById('color');
    const colorText = colorPicker?.nextElementSibling;
    
    if (colorPicker && colorText) {
      colorPicker.addEventListener('input', function() {
        colorText.value = this.value;
      });
    }
  });
</script>
@endsection
