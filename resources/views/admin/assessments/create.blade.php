@extends('layouts/contentNavbarLayout')

@section('title', 'Create Assessment')

@section('vendor-style')
<style>
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
  }
  .page-header h4 { margin: 0; font-weight: 700; color: white; font-size: 1.5rem; }
  .page-header p { color: rgba(255, 255, 255, 0.85); margin: 4px 0 0 0; }
  .page-header .btn-header {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .page-header .btn-header:hover { background: rgba(255, 255, 255, 0.3); color: white; }

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

  .section-title {
    display: flex;
    align-items: center;
    gap: 14px;
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

  .form-label-styled { font-weight: 600; color: #4a5568; margin-bottom: 8px; font-size: 0.9rem; }
  .form-control, .form-select {
    border: 2px solid #e4e6eb;
    border-radius: 10px;
    padding: 12px 16px;
    transition: all 0.3s ease;
  }
  .form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  }
  .form-text { color: #8e9baa; font-size: 0.8rem; margin-top: 6px; }

  .color-picker-wrapper {
    display: flex;
    gap: 10px;
    align-items: center;
  }
  .color-picker-wrapper input[type="color"] {
    width: 50px;
    height: 46px;
    border-radius: 10px;
    cursor: pointer;
  }

  .icon-preview {
    width: 80px;
    height: 80px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    transition: all 0.3s ease;
  }

  .form-check-input:checked { background-color: #667eea; border-color: #667eea; }

  .btn-cancel {
    background: white;
    border: 2px solid #e4e6eb;
    color: #566a7f;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .btn-cancel:hover { border-color: #ea5455; color: #ea5455; }
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
  .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4); color: white; }
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4><i class="ri-file-list-3-line me-2"></i>Create New Assessment</h4>
      <p>Design a new assessment for your platform</p>
    </div>
    <a href="{{ route('admin.assessments.index') }}" class="btn btn-header">
      <i class="ri-arrow-left-line me-1"></i> Back to Assessments
    </a>
  </div>
</div>

@if($errors->any())
  <div class="alert alert-danger alert-dismissible mb-4" role="alert">
    <i class="ri-error-warning-line me-2"></i>
    <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<form action="{{ route('admin.assessments.store') }}" method="POST">
  @csrf
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="card form-card mb-4">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-information-line"></i></div>
            <div>
              <h5>Basic Information</h5>
              <small>Enter assessment details</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label-styled">Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Assessment Title" required>
            </div>
            <div class="col-md-4">
              <label class="form-label-styled">Slug <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}" placeholder="auto-generated" required>
            </div>
            <div class="col-12">
              <label class="form-label-styled">Description <span class="text-danger">*</span></label>
              <textarea class="form-control" name="description" rows="4" placeholder="Describe what this assessment measures..." required>{{ old('description') }}</textarea>
            </div>
            <div class="col-md-4">
              <label class="form-label-styled">Category <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="category" value="{{ old('category') }}" placeholder="e.g., Mental Health" required>
            </div>
            <div class="col-md-4">
              <label class="form-label-styled">Duration (Minutes) <span class="text-danger">*</span></label>
              <input type="number" class="form-control" name="duration_minutes" value="{{ old('duration_minutes', 10) }}" min="1" max="300" required>
            </div>
            <div class="col-md-4">
              <label class="form-label-styled">Sort Order</label>
              <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
            </div>
          </div>
        </div>
      </div>

      <div class="card form-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-search-eye-line"></i></div>
            <div>
              <h5>SEO Settings</h5>
              <small>Optional SEO optimization</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label-styled">Meta Title</label>
              <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title') }}" maxlength="60">
            </div>
            <div class="col-12">
              <label class="form-label-styled">Meta Description</label>
              <textarea class="form-control" name="meta_description" rows="2" maxlength="160">{{ old('meta_description') }}</textarea>
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top">
            <a href="{{ route('admin.assessments.index') }}" class="btn btn-cancel"><i class="ri-close-line me-1"></i> Cancel</a>
            <button type="submit" class="btn btn-submit"><i class="ri-save-line me-1"></i> Create Assessment</button>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card form-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-palette-line"></i></div>
            <div>
              <h5>Appearance</h5>
              <small>Icon and color settings</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="text-center mb-4">
            <div class="icon-preview mx-auto" id="icon-preview">
              <i class="{{ old('icon', 'ri-heart-line') }}"></i>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label-styled">Icon Class</label>
            <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon') }}" placeholder="ri-heart-line">
            <div class="form-text">Use Remix Icon classes</div>
          </div>
          <div class="mb-4">
            <label class="form-label-styled">Color</label>
            <div class="color-picker-wrapper">
              <input type="color" id="color" name="color" value="{{ old('color', '#667eea') }}">
              <input type="text" class="form-control flex-grow-1" id="color-hex" value="{{ old('color', '#667eea') }}" maxlength="7">
            </div>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="is_active">Active Assessment</label>
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
  const title = document.getElementById('title');
  const slug = document.getElementById('slug');
  title?.addEventListener('input', function() {
    if (!slug.dataset.manual) slug.value = this.value.toLowerCase().trim().replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-');
  });
  slug?.addEventListener('input', () => slug.dataset.manual = 'true');

  const icon = document.getElementById('icon');
  const preview = document.getElementById('icon-preview');
  const color = document.getElementById('color');
  const colorHex = document.getElementById('color-hex');

  icon?.addEventListener('input', () => preview.innerHTML = `<i class="${icon.value || 'ri-heart-line'}"></i>`);
  color?.addEventListener('input', () => { colorHex.value = color.value; preview.style.color = color.value; });
  colorHex?.addEventListener('input', () => { if (/^#[0-9A-F]{6}$/i.test(colorHex.value)) { color.value = colorHex.value; preview.style.color = colorHex.value; }});
});
</script>
@endsection
