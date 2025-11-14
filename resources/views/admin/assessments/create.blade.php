@extends('layouts/contentNavbarLayout')

@section('title', 'Create Assessment')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Create New Assessment</h5>
        <a href="{{ route('admin.assessments.index') }}" class="btn btn-outline-secondary">
          <i class="ri-arrow-left-line me-1"></i> Back to Assessments
        </a>
      </div>
      <div class="card-body">
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

        <form action="{{ route('admin.assessments.store') }}" method="POST">
          @csrf

          <div class="row">
            <div class="col-md-8">
              <div class="mb-3">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                       id="title" name="title" value="{{ old('title') }}" 
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
                       id="slug" name="slug" value="{{ old('slug') }}" 
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
                      placeholder="Assessment description..." required>{{ old('description') }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('category') is-invalid @enderror" 
                       id="category" name="category" value="{{ old('category') }}" 
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
                       value="{{ old('duration_minutes', 10) }}" 
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
                       value="{{ old('question_count', 0) }}" 
                       min="0" readonly>
                <small class="text-muted">Auto-calculated from questions</small>
                @error('question_count')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="icon" class="form-label">Icon (Remix Icon Class)</label>
                <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                       id="icon" name="icon" value="{{ old('icon') }}" 
                       placeholder="ri-heart-line">
                <small class="text-muted">e.g., ri-heart-line, ri-user-line</small>
                <div class="mt-2" id="icon-preview" style="font-size: 2rem;"></div>
                @error('icon')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="color" class="form-label">Color</label>
                <div class="d-flex gap-2">
                  <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                         id="color" name="color" value="{{ old('color', '#3B82F6') }}">
                  <input type="text" class="form-control @error('color') is-invalid @enderror" 
                         id="color-hex" value="{{ old('color', '#3B82F6') }}" 
                         placeholder="#3B82F6" maxlength="7">
                </div>
                <small class="text-muted">Choose a color for the assessment</small>
                @error('color')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="sort_order" class="form-label">Sort Order</label>
                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                       id="sort_order" name="sort_order" 
                       value="{{ old('sort_order', 0) }}" 
                       min="0">
                <small class="text-muted">Lower numbers appear first</small>
                @error('sort_order')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="is_active" 
                     name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
              <label class="form-check-label" for="is_active">
                Active
              </label>
            </div>
            <small class="text-muted">Only active assessments are visible to users</small>
          </div>

          <!-- SEO Fields -->
          <div class="mb-4">
            <h6 class="text-muted mb-3">
              <i class="ri-search-line me-2"></i>SEO Settings (Optional)
            </h6>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="meta_title" class="form-label">Meta Title</label>
                  <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                         id="meta_title" name="meta_title" 
                         value="{{ old('meta_title') }}" 
                         placeholder="SEO meta title" maxlength="60">
                  <small class="text-muted">Recommended: 50-60 characters</small>
                  @error('meta_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="meta_description" class="form-label">Meta Description</label>
              <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                        id="meta_description" name="meta_description" rows="2" 
                        placeholder="SEO meta description" maxlength="160">{{ old('meta_description') }}</textarea>
              <small class="text-muted">Recommended: 150-160 characters</small>
              @error('meta_description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.assessments.index') }}" class="btn btn-outline-secondary">
              <i class="ri-close-line me-2"></i>Cancel
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="ri-save-line me-2"></i>Create Assessment
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

    // Icon preview
    const iconInput = document.getElementById('icon');
    const iconPreview = document.getElementById('icon-preview');
    
    if (iconInput && iconPreview) {
      function updateIconPreview() {
        const iconClass = iconInput.value.trim();
        if (iconClass) {
          iconPreview.innerHTML = `<i class="${iconClass}"></i>`;
          iconPreview.style.color = document.getElementById('color').value;
        } else {
          iconPreview.innerHTML = '';
        }
      }
      
      iconInput.addEventListener('input', updateIconPreview);
      updateIconPreview();
    }

    // Color picker sync
    const colorPicker = document.getElementById('color');
    const colorHex = document.getElementById('color-hex');
    
    if (colorPicker && colorHex) {
      colorPicker.addEventListener('input', function() {
        colorHex.value = this.value.toUpperCase();
        if (iconPreview) {
          iconPreview.style.color = this.value;
        }
      });
      
      colorHex.addEventListener('input', function() {
        const hex = this.value.replace('#', '');
        if (/^[0-9A-F]{6}$/i.test(hex)) {
          colorPicker.value = '#' + hex;
          if (iconPreview) {
            iconPreview.style.color = '#' + hex;
          }
        }
      });
    }
  });
</script>
@endsection
