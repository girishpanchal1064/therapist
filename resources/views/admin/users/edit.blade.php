@extends('layouts/contentNavbarLayout')

@section('title', 'Edit User')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Edit User: {{ $user->name }}</h5>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
          <i class="ri-arrow-left-line me-2"></i>Back to Users
        </a>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible" role="alert">
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                @error('phone')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                  <option value="">Select Status</option>
                  <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                  <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                  <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
                @error('status')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="avatar" class="form-label">Profile Picture</label>
                <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                       id="avatar" name="avatar" accept="image/*">
                @error('avatar')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Upload a new profile picture (JPEG, PNG, JPG, GIF, SVG - Max 2MB)</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="roles" class="form-label">User Roles <span class="text-danger">*</span></label>
                <select class="form-select @error('roles') is-invalid @enderror" id="roles" name="roles[]" multiple required>
                  @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'selected' : '' }}>
                      {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                    </option>
                  @endforeach
                </select>
                @error('roles')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Hold Ctrl/Cmd to select multiple roles</div>
              </div>
            </div>
          </div>

          <!-- Current Avatar Preview -->
          @if($user->avatar)
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Current Profile Picture</label>
                  <div class="d-flex align-items-center">
                    <img src="{{ Storage::url($user->avatar) }}" alt="Current Avatar" class="rounded-circle me-3" width="60" height="60">
                    <div>
                      <p class="mb-0 text-muted">Current profile picture</p>
                      <small class="text-muted">Upload a new image to replace it</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endif

          <!-- Password Change Section -->
          <div class="card mt-4">
            <div class="card-header">
              <h6 class="card-title mb-0">Change Password (Optional)</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password">
                    @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Leave blank to keep current password</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">
              <i class="ri-save-line me-2"></i>Update User
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h6 class="card-title mb-0">User Information</h6>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Member Since:</span>
          <span>{{ $user->created_at->format('M d, Y') }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Last Login:</span>
          <span>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Email Verified:</span>
          <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
            {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
          </span>
        </div>
        @if($user->phone)
          <div class="d-flex justify-content-between">
            <span class="text-muted">Phone:</span>
            <span>{{ $user->phone }}</span>
          </div>
        @endif
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header">
        <h6 class="card-title mb-0">Current Roles</h6>
      </div>
      <div class="card-body">
        @if($user->roles->count() > 0)
          @foreach($user->roles as $role)
            <span class="badge bg-primary me-1 mb-1">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
          @endforeach
        @else
          <small class="text-muted">No roles assigned</small>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update preview when form fields change
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const statusSelect = document.getElementById('status');
    const rolesSelect = document.getElementById('roles');
    const avatarInput = document.getElementById('avatar');

    nameInput.addEventListener('input', function() {
        document.getElementById('name-preview').textContent = this.value;
    });

    emailInput.addEventListener('input', function() {
        document.getElementById('email-preview').textContent = this.value;
    });

    statusSelect.addEventListener('change', function() {
        const statusPreview = document.getElementById('status-preview');
        const status = this.value;
        if (status) {
            statusPreview.textContent = status.charAt(0).toUpperCase() + status.slice(1);
            statusPreview.className = 'badge bg-' + (status === 'active' ? 'success' : (status === 'suspended' ? 'danger' : 'secondary'));
        }
    });

    // Handle role selector
    const rolesSelect = document.getElementById('roles');
    if (rolesSelect) {
        rolesSelect.addEventListener('change', function() {
            const rolesPreview = document.getElementById('roles-preview');
            const selectedOptions = Array.from(this.selectedOptions);

            if (selectedOptions.length > 0) {
                rolesPreview.innerHTML = selectedOptions.map(option =>
                    `<span class="badge bg-primary me-1">${option.textContent}</span>`
                ).join('');
            } else {
                rolesPreview.innerHTML = '<small class="text-muted">No roles selected</small>';
            }
        });
    }

    avatarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    // Create new preview if it doesn't exist
                    const avatarDiv = document.querySelector('.avatar');
                    avatarDiv.innerHTML = '<img src="' + e.target.result + '" alt="Avatar" class="rounded-circle" id="avatar-preview">';
                }
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection

@section('page-style')
<style>
  /* Custom styles for better form appearance */
  .form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
  }

  .card {
    border: 1px solid #e9ecef;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px 12px 0 0;
  }

  .btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
  }
</style>
@endsection
