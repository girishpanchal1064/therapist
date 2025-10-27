@extends('layouts/contentNavbarLayout')

@section('title', 'Create User')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Create New User</h5>
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

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email') }}" required>
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
                       id="phone" name="phone" value="{{ old('phone') }}">
                @error('phone')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="password" class="form-control @error('password') is-invalid @enderror"
                         id="password" name="password" required>
                  <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                    <i class="ri-eye-off-line" id="passwordIcon"></i>
                  </button>
                </div>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Minimum 8 characters</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                         id="password_confirmation" name="password_confirmation" required>
                  <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                    <i class="ri-eye-off-line" id="passwordConfirmIcon"></i>
                  </button>
                </div>
                @error('password_confirmation')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                  <option value="">Select Status</option>
                  <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                  <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                  <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
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
                <div class="form-text">Upload a profile picture (JPEG, PNG, JPG, GIF, SVG - Max 2MB)</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="role" class="form-label">User Role <span class="text-danger">*</span></label>
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                  <option value="">Select Role</option>
                  @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                      {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                    </option>
                  @endforeach
                </select>
                @error('role')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Choose one role for this user</div>
              </div>
            </div>
          </div>

          <!-- Additional Information -->
          <div class="card mt-4">
            <div class="card-header">
              <h6 class="card-title mb-0">Additional Information (Optional)</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                           id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                    @error('date_of_birth')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                      <option value="">Select Gender</option>
                      <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                      <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                      <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control @error('address') is-invalid @enderror"
                          id="address" name="address" rows="3" placeholder="Enter full address">{{ old('address') }}</textarea>
                @error('address')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">
              <i class="ri-save-line me-2"></i>Create User
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h6 class="card-title mb-0">User Preview</h6>
      </div>
      <div class="card-body text-center">
        <div class="avatar avatar-xl mb-3">
          <span class="avatar-initial rounded bg-primary" id="avatar-preview">U</span>
        </div>
        <h5 class="card-title" id="name-preview">New User</h5>
        <p class="text-muted" id="email-preview">user@example.com</p>

        <div class="mt-3">
          <span class="badge bg-secondary" id="status-preview">Inactive</span>
        </div>

        <div class="mt-3" id="roles-preview">
          <small class="text-muted">No roles selected</small>
        </div>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header">
        <h6 class="card-title mb-0">Quick Tips</h6>
      </div>
      <div class="card-body">
        <ul class="list-unstyled mb-0">
          <li class="mb-2">
            <i class="ri-check-line text-success me-2"></i>
            <small>All fields marked with * are required</small>
          </li>
          <li class="mb-2">
            <i class="ri-check-line text-success me-2"></i>
            <small>Password must be at least 8 characters</small>
          </li>
          <li class="mb-2">
            <i class="ri-check-line text-success me-2"></i>
            <small>Email must be unique</small>
          </li>
          <li class="mb-2">
            <i class="ri-check-line text-success me-2"></i>
            <small>Select appropriate roles for the user</small>
          </li>
          <li>
            <i class="ri-check-line text-success me-2"></i>
            <small>Profile picture is optional</small>
          </li>
        </ul>
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
        document.getElementById('name-preview').textContent = this.value || 'New User';
        document.getElementById('avatar-preview').textContent = this.value.substring(0, 2).toUpperCase() || 'U';
    });

    emailInput.addEventListener('input', function() {
        document.getElementById('email-preview').textContent = this.value || 'user@example.com';
    });

    statusSelect.addEventListener('change', function() {
        const statusPreview = document.getElementById('status-preview');
        const status = this.value;
        if (status) {
            statusPreview.textContent = status.charAt(0).toUpperCase() + status.slice(1);
            statusPreview.className = 'badge bg-' + (status === 'active' ? 'success' : (status === 'suspended' ? 'danger' : 'secondary'));
        } else {
            statusPreview.textContent = 'Inactive';
            statusPreview.className = 'badge bg-secondary';
        }
    });

    // Handle role selection (single role)
    const roleSelect = document.getElementById('role');
    if (roleSelect) {
        roleSelect.addEventListener('change', function() {
            const rolesPreview = document.getElementById('roles-preview');
            const selectedOption = this.options[this.selectedIndex];

            if (this.value) {
                rolesPreview.innerHTML = `<span class="badge bg-primary">${selectedOption.textContent}</span>`;
            } else {
                rolesPreview.innerHTML = '<small class="text-muted">No role selected</small>';
            }
        });
    }

    // Handle password visibility toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('passwordIcon');

    if (togglePassword && passwordInput && passwordIcon) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            passwordIcon.className = type === 'password' ? 'ri-eye-off-line' : 'ri-eye-line';
        });
    }

    // Handle confirm password visibility toggle
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const passwordConfirmIcon = document.getElementById('passwordConfirmIcon');

    if (togglePasswordConfirm && passwordConfirmInput && passwordConfirmIcon) {
        togglePasswordConfirm.addEventListener('click', function() {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);
            passwordConfirmIcon.className = type === 'password' ? 'ri-eye-off-line' : 'ri-eye-line';
        });
    }

    avatarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                preview.innerHTML = `<img src="${e.target.result}" alt="Avatar" class="rounded-circle" width="100%" height="100%">`;
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
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
  }

  .card:hover {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
  }

  .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 16px 16px 0 0;
    padding: 1.5rem;
    border-bottom: none;
  }

  .card-header h5 {
    margin: 0;
    font-weight: 600;
    font-size: 1.1rem;
  }

  .btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 10px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
  }

  .btn-secondary {
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .btn-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
  }

  .form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
  }

  .form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
  }

  .form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
  }

  .input-group .btn {
    border-radius: 0 10px 10px 0;
    border-left: none;
  }

  .input-group .form-control {
    border-radius: 10px 0 0 10px;
  }

  .form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
  }

  .invalid-feedback {
    font-size: 0.875rem;
    margin-top: 0.25rem;
  }

  .text-danger {
    color: #dc3545 !important;
  }

  /* Preview card styling */
  .preview-card {
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
    border: 2px dashed #667eea;
    border-radius: 12px;
    padding: 1.5rem;
    margin-top: 1rem;
  }

  .preview-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 1.2rem;
    margin-bottom: 1rem;
  }

  .preview-info h6 {
    color: #495057;
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  .preview-info p {
    color: #6c757d;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .card {
      margin: 0.5rem;
    }

    .btn-primary {
      width: 100%;
      margin-top: 1rem;
    }
  }

  /* Animation for form elements */
  .form-control, .form-select, .btn {
    transition: all 0.3s ease;
  }

  .form-control:focus, .form-select:focus {
    transform: translateY(-1px);
  }
</style>
@endsection
