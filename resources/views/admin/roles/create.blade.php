@extends('layouts/contentNavbarLayout')

@section('title', 'Create Role')

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

  /* Permission Cards */
  .permission-group {
    border: 2px solid #e4e6eb;
    border-radius: 14px;
    overflow: hidden;
    transition: all 0.3s ease;
    margin-bottom: 16px;
  }
  .permission-group:hover { border-color: rgba(102, 126, 234, 0.3); }
  .permission-group-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    padding: 14px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
  }
  .permission-group-header h6 {
    margin: 0;
    font-weight: 700;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .permission-group-header h6 i {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 0.9rem;
  }
  .permission-group-body { padding: 16px 18px; }
  .permission-item {
    display: flex;
    align-items: center;
    padding: 10px 14px;
    border-radius: 8px;
    transition: all 0.2s ease;
    margin-bottom: 6px;
  }
  .permission-item:hover { background: rgba(102, 126, 234, 0.05); }
  .permission-item:last-child { margin-bottom: 0; }
  .permission-item label {
    margin-left: 12px;
    cursor: pointer;
    font-weight: 500;
    color: #4a5568;
  }

  .form-check-input { width: 20px; height: 20px; cursor: pointer; }
  .form-check-input:checked { background-color: #667eea; border-color: #667eea; }
  .form-check-input:focus { box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2); }

  .select-all-btn {
    background: rgba(102, 126, 234, 0.1);
    border: none;
    color: #667eea;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .select-all-btn:hover { background: rgba(102, 126, 234, 0.2); }

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
      <h4><i class="ri-shield-user-line me-2"></i>Create New Role</h4>
      <p>Define a new role with specific permissions</p>
    </div>
    <a href="{{ route('admin.roles.index') }}" class="btn btn-header">
      <i class="ri-arrow-left-line me-1"></i> Back to Roles
    </a>
  </div>
</div>

@if($errors->any())
  <div class="alert alert-danger mb-4"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<form action="{{ route('admin.roles.store') }}" method="POST">
  @csrf
  <div class="row g-4">
    <div class="col-lg-4">
      <div class="card form-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-information-line"></i></div>
            <div>
              <h5>Role Details</h5>
              <small>Basic role information</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <label class="form-label-styled">Role Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="e.g., content_manager" required>
          <div class="form-text">Use lowercase with underscores</div>

          <div class="alert alert-info mt-4 mb-0" style="border-radius: 10px; border: none;">
            <h6 class="alert-heading"><i class="ri-lightbulb-line me-2"></i>Naming Tips</h6>
            <ul class="mb-0 small">
              <li><code>admin</code> - Full system access</li>
              <li><code>editor</code> - Content management</li>
              <li><code>moderator</code> - Review & approve</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="card form-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-key-2-line"></i></div>
            <div>
              <h5>Permissions</h5>
              <small>Select permissions for this role</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            @foreach($permissions as $group => $groupPermissions)
              <div class="col-md-6 col-lg-4">
                <div class="permission-group">
                  <div class="permission-group-header">
                    <h6><i class="ri-folder-shield-line"></i>{{ ucfirst($group) }}</h6>
                    <button type="button" class="select-all-btn" onclick="toggleGroup(this, '{{ $group }}')">Select All</button>
                  </div>
                  <div class="permission-group-body">
                    @foreach($groupPermissions as $permission)
                      <div class="permission-item">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                               id="perm_{{ $permission->id }}" data-group="{{ $group }}"
                               {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                        <label for="perm_{{ $permission->id }}">{{ ucfirst(str_replace('_', ' ', $permission->name)) }}</label>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-cancel"><i class="ri-close-line me-1"></i> Cancel</a>
            <button type="submit" class="btn btn-submit"><i class="ri-save-line me-1"></i> Create Role</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('page-script')
<script>
function toggleGroup(btn, group) {
  const checkboxes = document.querySelectorAll(`input[data-group="${group}"]`);
  const allChecked = Array.from(checkboxes).every(cb => cb.checked);
  checkboxes.forEach(cb => cb.checked = !allChecked);
  btn.textContent = allChecked ? 'Select All' : 'Deselect All';
}
</script>
@endsection
