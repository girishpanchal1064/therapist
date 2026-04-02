@extends('layouts/contentNavbarLayout')

@section('title', 'Roles Settings')

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

  .settings-card {
    border-radius: 16px;
    border: 1px solid rgba(186, 194, 210, 0.35);
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    overflow: hidden;
    margin-bottom: 24px;
  }
  .settings-card .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
    border-bottom: 1px solid rgba(186, 194, 210, 0.35);
    padding: 20px 24px;
  }
  .settings-card .card-body { padding: 24px; }

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
    background: linear-gradient(90deg, #041C54 0%, #2f4a76 55%, #647494 100%);
    color: white;
    box-shadow: 0 10px 18px rgba(4, 28, 84, 0.2);
  }
  .section-title h5 { margin: 0; font-weight: 700; color: #041C54; }
  .section-title small { color: #718096; font-size: 0.85rem; }

  .form-label-styled { font-weight: 600; color: #041C54; margin-bottom: 8px; font-size: 0.9rem; display: block; }
  .form-control, .form-select {
    border: 2px solid #e4e6eb;
    border-radius: 10px;
    padding: 12px 16px;
    transition: all 0.3s ease;
  }
  .form-control:focus, .form-select:focus {
    border-color: #647494;
    box-shadow: 0 0 0 4px rgba(100, 116, 148, 0.12);
  }
  .form-text { color: #8e9baa; font-size: 0.8rem; margin-top: 6px; display: block; }

  .toggle-card {
    background: #f8fafc;
    border-radius: 12px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 16px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    height: 100%;
  }
  .toggle-card:hover { border-color: rgba(100, 116, 148, 0.25); }
  .toggle-card .toggle-info h6 { margin: 0 0 4px; font-weight: 600; color: #041C54; font-size: 0.95rem; }
  .toggle-card .toggle-info small { color: #718096; }
  .toggle-card .form-check-input { width: 50px; height: 26px; flex-shrink: 0; }
  .toggle-card .form-check-input:checked { background-color: #041C54; border-color: #041C54; }

  .alert-modern {
    border-radius: 12px;
    border: none;
    padding: 16px 20px;
  }
  .alert-modern.alert-success {
    background: linear-gradient(135deg, rgba(40, 199, 111, 0.1) 0%, rgba(40, 199, 111, 0.05) 100%);
    border-left: 4px solid #28c76f;
  }
  .alert-modern.alert-danger {
    background: linear-gradient(135deg, rgba(234, 84, 85, 0.1) 0%, rgba(234, 84, 85, 0.05) 100%);
    border-left: 4px solid #ea5455;
  }
  .alert-modern.alert-info {
    background: linear-gradient(135deg, rgba(100, 116, 148, 0.12) 0%, rgba(100, 116, 148, 0.05) 100%);
    border-left: 4px solid #647494;
    color: #041C54;
  }

  .form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    padding-top: 8px;
  }
  .btn-cancel {
    background: white; border: 2px solid #e4e6eb; color: #566a7f;
    padding: 12px 24px; border-radius: 10px; font-weight: 600; transition: all 0.3s ease;
  }
  .btn-cancel:hover { border-color: #ea5455; color: #ea5455; }
  .btn-submit {
    background: linear-gradient(90deg, #041C54 0%, #2f4a76 55%, #647494 100%);
    border: none; color: white; padding: 12px 28px; border-radius: 10px;
    font-weight: 600; transition: all 0.3s ease;
    box-shadow: 0 10px 18px rgba(4, 28, 84, 0.22);
  }
  .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 22px rgba(4, 28, 84, 0.32); color: white; }
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4><i class="ri-shield-user-line me-2"></i>Roles &amp; permissions</h4>
      <p>Manage default roles, security rules, and access control</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ route('admin.settings.general') }}" class="btn btn-header">
        <i class="ri-global-line me-1"></i> General
      </a>
      <a href="{{ route('admin.settings.system') }}" class="btn btn-header">
        <i class="ri-server-line me-1"></i> System
      </a>
    </div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-modern alert-success alert-dismissible mb-4">
    <i class="ri-checkbox-circle-line me-2 text-success"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-modern alert-danger alert-dismissible mb-4">
    <i class="ri-error-warning-line me-2 text-danger"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if($errors->any())
  <div class="alert alert-modern alert-danger alert-dismissible mb-4">
    <i class="ri-error-warning-line me-2 text-danger"></i>
    <ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<form action="{{ route('admin.settings.roles.update') }}" method="POST">
  @csrf

  <div class="row g-4">
    <div class="col-lg-6">
      <div class="card settings-card mb-0">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-shield-user-line"></i></div>
            <div>
              <h5>Role management</h5>
              <small>Defaults for new users and therapist onboarding</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="mb-4">
            <label for="default_role" class="form-label-styled">Default user role</label>
            <select class="form-select @error('default_role') is-invalid @enderror"
                    id="default_role" name="default_role">
              <option value="Client" {{ old('default_role', 'Client') === 'Client' ? 'selected' : '' }}>Client</option>
              <option value="Therapist" {{ old('default_role') === 'Therapist' ? 'selected' : '' }}>Therapist</option>
            </select>
            <small class="form-text">Role assigned to new users upon registration</small>
            @error('default_role')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label for="therapist_approval_required" class="form-label-styled">Therapist approval required</label>
            <select class="form-select @error('therapist_approval_required') is-invalid @enderror"
                    id="therapist_approval_required" name="therapist_approval_required">
              <option value="1" {{ old('therapist_approval_required', '1') == '1' ? 'selected' : '' }}>Yes</option>
              <option value="0" {{ old('therapist_approval_required') == '0' ? 'selected' : '' }}>No</option>
            </select>
            <small class="form-text">Require admin approval before therapist accounts are activated</small>
            @error('therapist_approval_required')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-0">
            <label for="auto_assign_permissions" class="form-label-styled">Auto-assign permissions</label>
            <select class="form-select @error('auto_assign_permissions') is-invalid @enderror"
                    id="auto_assign_permissions" name="auto_assign_permissions">
              <option value="1" {{ old('auto_assign_permissions', '1') == '1' ? 'selected' : '' }}>Enabled</option>
              <option value="0" {{ old('auto_assign_permissions') == '0' ? 'selected' : '' }}>Disabled</option>
            </select>
            <small class="form-text">Automatically assign default permissions to new roles</small>
            @error('auto_assign_permissions')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card settings-card mb-0">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-lock-line"></i></div>
            <div>
              <h5>Permission settings</h5>
              <small>Sessions and password policy</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="mb-4">
            <label for="session_timeout" class="form-label-styled">Session timeout (minutes)</label>
            <input type="number" class="form-control @error('session_timeout') is-invalid @enderror"
                   id="session_timeout" name="session_timeout"
                   value="{{ old('session_timeout', '120') }}"
                   min="5" max="1440" required>
            <small class="form-text">Time before a session expires from inactivity</small>
            @error('session_timeout')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label for="password_min_length" class="form-label-styled">Minimum password length</label>
            <input type="number" class="form-control @error('password_min_length') is-invalid @enderror"
                   id="password_min_length" name="password_min_length"
                   value="{{ old('password_min_length', '8') }}"
                   min="6" max="32" required>
            <small class="form-text">Minimum characters required for user passwords</small>
            @error('password_min_length')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-0">
            <label for="password_require_special" class="form-label-styled">Require special characters</label>
            <select class="form-select @error('password_require_special') is-invalid @enderror"
                    id="password_require_special" name="password_require_special">
              <option value="1" {{ old('password_require_special', '1') == '1' ? 'selected' : '' }}>Yes</option>
              <option value="0" {{ old('password_require_special') == '0' ? 'selected' : '' }}>No</option>
            </select>
            <small class="form-text">Require characters such as !@#$%^&amp;* in passwords</small>
            @error('password_require_special')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card settings-card">
    <div class="card-header">
      <div class="section-title">
        <div class="icon"><i class="ri-user-settings-line"></i></div>
        <div>
          <h5>Access control</h5>
          <small>What administrators can change in the role system</small>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-4">
          <div class="toggle-card mb-0">
            <div class="toggle-info">
              <h6>Allow role creation</h6>
              <small>Admins can create new roles</small>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" id="allow_role_creation"
                     name="allow_role_creation" value="1"
                     {{ old('allow_role_creation', '1') == '1' ? 'checked' : '' }}>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="toggle-card mb-0">
            <div class="toggle-info">
              <h6>Allow permission creation</h6>
              <small>Admins can create new permissions</small>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" id="allow_permission_creation"
                     name="allow_permission_creation" value="1"
                     {{ old('allow_permission_creation', '1') == '1' ? 'checked' : '' }}>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="toggle-card mb-0">
            <div class="toggle-info">
              <h6>Restrict SuperAdmin access</h6>
              <small>Extra safeguards for the SuperAdmin role</small>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" id="restrict_superadmin_access"
                     name="restrict_superadmin_access" value="1"
                     {{ old('restrict_superadmin_access', '0') == '1' ? 'checked' : '' }}>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="alert alert-modern alert-info mb-4">
    <i class="ri-information-line me-2"></i>
    <strong>Note:</strong> Role and permission changes may affect user access. Review carefully before saving.
  </div>

  <div class="form-actions">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-cancel"><i class="ri-close-line me-1"></i> Cancel</a>
    <button type="submit" class="btn btn-submit"><i class="ri-save-line me-1"></i> Save settings</button>
  </div>
</form>
@endsection
