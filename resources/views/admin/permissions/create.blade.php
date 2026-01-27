@extends('layouts/contentNavbarLayout')

@section('title', 'Create Permission')

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
  .form-control {
    border: 2px solid #e4e6eb;
    border-radius: 10px;
    padding: 12px 16px;
    transition: all 0.3s ease;
  }
  .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  }
  .form-text { color: #8e9baa; font-size: 0.8rem; margin-top: 6px; }

  .info-card {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    border: 1px solid rgba(102, 126, 234, 0.15);
    border-radius: 14px;
    padding: 20px;
  }
  .info-card h6 {
    color: #667eea;
    font-weight: 700;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .info-card h6 i { font-size: 1.2rem; }
  .info-card ul { margin: 0; padding-left: 20px; }
  .info-card li {
    margin-bottom: 8px;
    color: #4a5568;
  }
  .info-card li:last-child { margin-bottom: 0; }
  .info-card code {
    background: rgba(102, 126, 234, 0.15);
    color: #667eea;
    padding: 2px 8px;
    border-radius: 4px;
    font-weight: 600;
  }

  .preview-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px 20px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    font-size: 0.95rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  .preview-badge i { font-size: 1.2rem; }

  .btn-cancel {
    background: white; border: 2px solid #e4e6eb; color: #566a7f;
    padding: 12px 24px; border-radius: 10px; font-weight: 600; transition: all 0.3s ease;
  }
  .btn-cancel:hover { border-color: #ea5455; color: #ea5455; }
  .btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none; color: white; padding: 12px 28px; border-radius: 10px;
    font-weight: 600; transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4); color: white; }
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4><i class="ri-key-2-line me-2"></i>Create New Permission</h4>
      <p>Define a new permission for access control</p>
    </div>
    <a href="{{ route('admin.permissions.index') }}" class="btn btn-header">
      <i class="ri-arrow-left-line me-1"></i> Back to Permissions
    </a>
  </div>
</div>

@if($errors->any())
  <div class="alert alert-danger mb-4"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<form action="{{ route('admin.permissions.store') }}" method="POST">
  @csrf
  <div class="row g-4">
    <div class="col-lg-7">
      <div class="card form-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-add-circle-line"></i></div>
            <div>
              <h5>Permission Details</h5>
              <small>Define the new permission</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="mb-4">
            <label class="form-label-styled">Permission Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="perm-name" name="name" value="{{ old('name') }}" placeholder="e.g., manage_blog_posts" required>
            <div class="form-text">Use lowercase with underscores (e.g., view_users, create_posts)</div>
          </div>

          <div class="mb-4">
            <label class="form-label-styled">Description</label>
            <textarea class="form-control" name="description" rows="3" placeholder="Describe what this permission allows users to do...">{{ old('description') }}</textarea>
            <div class="form-text">Help administrators understand what this permission grants</div>
          </div>

          <div class="mb-4">
            <label class="form-label-styled">Preview</label>
            <div class="preview-badge" id="perm-preview">
              <i class="ri-key-2-line"></i>
              <span id="preview-name">permission_name</span>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top">
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-cancel"><i class="ri-close-line me-1"></i> Cancel</a>
            <button type="submit" class="btn btn-submit"><i class="ri-save-line me-1"></i> Create Permission</button>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card form-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-lightbulb-line"></i></div>
            <div>
              <h5>Naming Convention</h5>
              <small>Best practices for permission names</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="info-card">
            <h6><i class="ri-file-list-3-line"></i>Recommended Format</h6>
            <ul>
              <li><code>view_users</code> - View user information</li>
              <li><code>create_users</code> - Create new users</li>
              <li><code>edit_users</code> - Edit existing users</li>
              <li><code>delete_users</code> - Delete users</li>
              <li><code>manage_settings</code> - Manage system settings</li>
              <li><code>approve_reviews</code> - Approve user reviews</li>
            </ul>
          </div>

          <div class="info-card mt-3">
            <h6><i class="ri-checkbox-circle-line"></i>Tips</h6>
            <ul>
              <li>Use descriptive action verbs (view, create, edit, delete, manage)</li>
              <li>Always use lowercase letters</li>
              <li>Separate words with underscores</li>
              <li>Be specific about the resource</li>
            </ul>
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
  const nameInput = document.getElementById('perm-name');
  const previewName = document.getElementById('preview-name');
  nameInput?.addEventListener('input', () => previewName.textContent = nameInput.value || 'permission_name');
});
</script>
@endsection
