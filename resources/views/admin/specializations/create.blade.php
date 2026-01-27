@extends('layouts/contentNavbarLayout')

@section('title', 'Create Specialization')

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

  .form-label-styled { font-weight: 600; color: #4a5568; margin-bottom: 8px; font-size: 0.9rem; display: block; }
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

  .icon-preview-container {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    margin-bottom: 20px;
  }
  .icon-preview {
    width: 100px;
    height: 100px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    background: white;
    margin: 0 auto 16px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    color: #667eea;
    transition: all 0.3s ease;
  }
  .icon-name { font-weight: 600; color: #2d3748; font-size: 1.1rem; }
  .icon-desc { color: #718096; font-size: 0.85rem; }

  .form-check-input:checked { background-color: #667eea; border-color: #667eea; }
  .form-check-input:focus { box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2); }

  .toggle-active {
    background: linear-gradient(135deg, rgba(40, 199, 111, 0.1) 0%, rgba(30, 157, 88, 0.1) 100%);
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 20px;
  }
  .toggle-active .toggle-info h6 { margin: 0 0 4px; font-weight: 600; color: #28c76f; }
  .toggle-active .toggle-info small { color: #718096; }

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
      <h4><i class="ri-focus-3-line me-2"></i>Create New Specialization</h4>
      <p>Add a new area of expertise for therapists</p>
    </div>
    <a href="{{ route('admin.specializations.index') }}" class="btn btn-header">
      <i class="ri-arrow-left-line me-1"></i> Back to Specializations
    </a>
  </div>
</div>

@if($errors->any())
  <div class="alert alert-danger mb-4"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<form action="{{ route('admin.specializations.store') }}" method="POST">
  @csrf
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="card form-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-information-line"></i></div>
            <div>
              <h5>Specialization Details</h5>
              <small>Enter the specialization information</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label-styled">Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="spec-name" name="name" value="{{ old('name') }}" placeholder="e.g., Anxiety & Depression" required>
            </div>
            <div class="col-md-4">
              <label class="form-label-styled">Sort Order</label>
              <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
              <div class="form-text">Lower numbers appear first</div>
            </div>
            <div class="col-12">
              <label class="form-label-styled">Description</label>
              <textarea class="form-control" name="description" rows="4" placeholder="Describe this area of expertise...">{{ old('description') }}</textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label-styled">Icon Class</label>
              <input type="text" class="form-control" id="spec-icon" name="icon" value="{{ old('icon', 'ri-heart-line') }}" placeholder="ri-heart-line">
              <div class="form-text">Use <a href="https://remixicon.com/" target="_blank" class="text-primary">Remix Icon</a> classes</div>
            </div>
          </div>

          <div class="toggle-active">
            <div class="toggle-info">
              <h6><i class="ri-checkbox-circle-line me-2"></i>Active Status</h6>
              <small>Only active specializations are visible to users</small>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width: 50px; height: 26px;">
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top">
            <a href="{{ route('admin.specializations.index') }}" class="btn btn-cancel"><i class="ri-close-line me-1"></i> Cancel</a>
            <button type="submit" class="btn btn-submit"><i class="ri-save-line me-1"></i> Create Specialization</button>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card form-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-eye-line"></i></div>
            <div>
              <h5>Preview</h5>
              <small>Live preview of your specialization</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="icon-preview-container">
            <div class="icon-preview" id="preview-icon">
              <i class="{{ old('icon', 'ri-heart-line') }}"></i>
            </div>
            <div class="icon-name" id="preview-name">{{ old('name', 'Specialization Name') }}</div>
            <div class="icon-desc">Area of Expertise</div>
          </div>
          <div class="text-center text-muted small">
            <i class="ri-information-line me-1"></i>
            This is how the specialization will appear on the platform
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
  const nameInput = document.getElementById('spec-name');
  const iconInput = document.getElementById('spec-icon');
  const previewName = document.getElementById('preview-name');
  const previewIcon = document.getElementById('preview-icon');

  nameInput?.addEventListener('input', () => previewName.textContent = nameInput.value || 'Specialization Name');
  iconInput?.addEventListener('input', () => previewIcon.innerHTML = `<i class="${iconInput.value || 'ri-heart-line'}"></i>`);
});
</script>
@endsection
