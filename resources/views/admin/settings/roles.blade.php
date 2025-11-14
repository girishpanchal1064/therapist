@extends('layouts/contentNavbarLayout')

@section('title', 'Roles Settings')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Roles & Permissions Settings</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.settings.general') }}" class="btn btn-outline-primary">
            <i class="ri-global-line me-1"></i> General Settings
          </a>
          <a href="{{ route('admin.settings.system') }}" class="btn btn-outline-info">
            <i class="ri-settings-3-line me-1"></i> System Settings
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

        <form action="{{ route('admin.settings.roles.update') }}" method="POST">
          @csrf

          <div class="row">
            <div class="col-md-6">
              <div class="mb-4">
                <h6 class="text-muted mb-3">
                  <i class="ri-shield-user-line me-2"></i>Role Management
                </h6>

                <div class="mb-3">
                  <label for="default_role" class="form-label">Default User Role</label>
                  <select class="form-select @error('default_role') is-invalid @enderror" 
                          id="default_role" name="default_role">
                    <option value="Client" {{ old('default_role', 'Client') === 'Client' ? 'selected' : '' }}>Client</option>
                    <option value="Therapist" {{ old('default_role') === 'Therapist' ? 'selected' : '' }}>Therapist</option>
                  </select>
                  <small class="text-muted">Role assigned to new users upon registration</small>
                  @error('default_role')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="therapist_approval_required" class="form-label">Therapist Approval Required</label>
                  <select class="form-select @error('therapist_approval_required') is-invalid @enderror" 
                          id="therapist_approval_required" name="therapist_approval_required">
                    <option value="1" {{ old('therapist_approval_required', '1') == '1' ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('therapist_approval_required') == '0' ? 'selected' : '' }}>No</option>
                  </select>
                  <small class="text-muted">Require admin approval before therapist accounts are activated</small>
                  @error('therapist_approval_required')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="auto_assign_permissions" class="form-label">Auto-assign Permissions</label>
                  <select class="form-select @error('auto_assign_permissions') is-invalid @enderror" 
                          id="auto_assign_permissions" name="auto_assign_permissions">
                    <option value="1" {{ old('auto_assign_permissions', '1') == '1' ? 'selected' : '' }}>Enabled</option>
                    <option value="0" {{ old('auto_assign_permissions') == '0' ? 'selected' : '' }}>Disabled</option>
                  </select>
                  <small class="text-muted">Automatically assign default permissions to new roles</small>
                  @error('auto_assign_permissions')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-4">
                <h6 class="text-muted mb-3">
                  <i class="ri-lock-line me-2"></i>Permission Settings
                </h6>

                <div class="mb-3">
                  <label for="session_timeout" class="form-label">Session Timeout (minutes)</label>
                  <input type="number" class="form-control @error('session_timeout') is-invalid @enderror" 
                         id="session_timeout" name="session_timeout"
                         value="{{ old('session_timeout', '120') }}" 
                         min="5" max="1440" required>
                  <small class="text-muted">Time before user session expires due to inactivity</small>
                  @error('session_timeout')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="password_min_length" class="form-label">Minimum Password Length</label>
                  <input type="number" class="form-control @error('password_min_length') is-invalid @enderror" 
                         id="password_min_length" name="password_min_length"
                         value="{{ old('password_min_length', '8') }}" 
                         min="6" max="32" required>
                  <small class="text-muted">Minimum characters required for user passwords</small>
                  @error('password_min_length')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="password_require_special" class="form-label">Require Special Characters</label>
                  <select class="form-select @error('password_require_special') is-invalid @enderror" 
                          id="password_require_special" name="password_require_special">
                    <option value="1" {{ old('password_require_special', '1') == '1' ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('password_require_special') == '0' ? 'selected' : '' }}>No</option>
                  </select>
                  <small class="text-muted">Require special characters (!@#$%^&*) in passwords</small>
                  @error('password_require_special')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="mb-4">
                <h6 class="text-muted mb-3">
                  <i class="ri-user-settings-line me-2"></i>Access Control
                </h6>
                <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="allow_role_creation" 
                               name="allow_role_creation" value="1" 
                               {{ old('allow_role_creation', '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="allow_role_creation">
                          Allow Role Creation
                        </label>
                      </div>
                      <small class="text-muted d-block mt-1">Allow admins to create new roles</small>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="mb-3">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="allow_permission_creation" 
                               name="allow_permission_creation" value="1" 
                               {{ old('allow_permission_creation', '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="allow_permission_creation">
                          Allow Permission Creation
                        </label>
                      </div>
                      <small class="text-muted d-block mt-1">Allow admins to create new permissions</small>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="mb-3">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="restrict_superadmin_access" 
                               name="restrict_superadmin_access" value="1" 
                               {{ old('restrict_superadmin_access', '0') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="restrict_superadmin_access">
                          Restrict SuperAdmin Access
                        </label>
                      </div>
                      <small class="text-muted d-block mt-1">Add additional security for SuperAdmin role</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="mb-4">
                <h6 class="text-muted mb-3">
                  <i class="ri-information-line me-2"></i>Role Information
                </h6>
                <div class="alert alert-info">
                  <i class="ri-information-line me-2"></i>
                  <strong>Note:</strong> Role and permission changes may affect user access. Please review carefully before saving.
                </div>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
              <i class="ri-close-line me-2"></i>Cancel
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="ri-save-line me-2"></i>Save Settings
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
