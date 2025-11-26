@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Profile')

@section('vendor-style')
<style>
.profile-header-edit {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 0.75rem;
  padding: 2rem;
  position: relative;
  overflow: hidden;
}

.profile-header-edit::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.05)"/></svg>');
  background-size: 100px;
  opacity: 0.5;
}

.avatar-upload-wrapper {
  position: relative;
  display: inline-block;
}

.avatar-upload {
  width: 140px;
  height: 140px;
  border-radius: 50%;
  border: 5px solid #fff;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15);
  object-fit: cover;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.avatar-upload-initials {
  width: 140px;
  height: 140px;
  border-radius: 50%;
  border: 5px solid #fff;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3rem;
  font-weight: 700;
  color: #fff;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.avatar-upload-overlay {
  position: absolute;
  bottom: 0;
  right: 0;
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: #fff;
  box-shadow: 0 2px 10px rgba(0,0,0,0.15);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  border: 3px solid #f8f9fa;
}

.avatar-upload-overlay:hover {
  transform: scale(1.1);
  background: #667eea;
  color: #fff;
}

.avatar-upload-overlay i {
  font-size: 1.25rem;
}

.form-section {
  background: #fff;
  border-radius: 0.75rem;
  padding: 1.5rem;
  margin-bottom: 1.5rem;
  border: 1px solid #e9ecef;
}

.form-section-title {
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 1.25rem;
  padding-bottom: 0.75rem;
  border-bottom: 2px solid #f1f3f4;
  display: flex;
  align-items: center;
}

.form-section-title i {
  font-size: 1.25rem;
  margin-right: 0.5rem;
  color: #667eea;
}

.form-floating-custom .form-control {
  height: calc(3.5rem + 2px);
  border-radius: 0.5rem;
  border: 1px solid #dee2e6;
  transition: all 0.2s ease;
}

.form-floating-custom .form-control:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
}

.form-floating-custom label {
  padding: 1rem 0.75rem;
}

.preview-card {
  position: sticky;
  top: 1rem;
}

.preview-avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid #fff;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.preview-avatar-initials {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  font-weight: 700;
  color: #fff;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border: 4px solid #fff;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.password-toggle-btn {
  border-left: 0;
  background: #f8f9fa;
  border-color: #dee2e6;
}

.password-toggle-btn:hover {
  background: #e9ecef;
}

.password-strength-meter {
  height: 5px;
  border-radius: 2.5px;
  background: #e9ecef;
  overflow: hidden;
  margin-top: 0.5rem;
}

.password-strength-fill {
  height: 100%;
  border-radius: 2.5px;
  transition: all 0.3s ease;
}

.file-upload-zone {
  border: 2px dashed #dee2e6;
  border-radius: 0.75rem;
  padding: 2rem;
  text-align: center;
  transition: all 0.3s ease;
  cursor: pointer;
  background: #fafbfc;
}

.file-upload-zone:hover {
  border-color: #667eea;
  background: rgba(102, 126, 234, 0.05);
}

.file-upload-zone.dragover {
  border-color: #667eea;
  background: rgba(102, 126, 234, 0.1);
}

.btn-save {
  padding: 0.75rem 2rem;
  font-weight: 600;
  border-radius: 0.5rem;
  transition: all 0.3s ease;
}

.btn-save:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}
</style>
@endsection

@section('content')
<!-- Header -->
<div class="profile-header-edit mb-4">
  <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 1;">
    <div class="d-flex align-items-center">
      <a href="{{ route('admin.profile.index') }}" class="btn btn-light btn-sm me-3">
        <i class="ri-arrow-left-line me-1"></i>Back
      </a>
      <div class="text-white">
        <h4 class="mb-1 fw-bold">Edit Profile</h4>
        <p class="mb-0 opacity-75">Update your personal information</p>
      </div>
    </div>
  </div>
</div>

<!-- Messages -->
@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <div class="d-flex align-items-center">
      <i class="ri-checkbox-circle-fill me-2 fs-5"></i>
      <div>{{ session('success') }}</div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if($errors->any())
  <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <div class="d-flex align-items-center">
      <i class="ri-error-warning-fill me-2 fs-5"></i>
      <div>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
  @csrf
  @method('PUT')
  
  <div class="row">
    <!-- Main Form -->
    <div class="col-lg-8">
      <!-- Avatar Upload Section -->
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
          <div class="form-section-title">
            <i class="ri-image-line"></i>Profile Picture
          </div>
          
          <div class="row align-items-center">
            <div class="col-auto">
              <div class="avatar-upload-wrapper">
                @if($user->getRawOriginal('avatar'))
                  <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="avatar-upload" id="avatarPreview">
                @else
                  <div class="avatar-upload-initials" id="avatarInitials">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                  </div>
                @endif
                <label for="avatarInput" class="avatar-upload-overlay">
                  <i class="ri-camera-line"></i>
                </label>
                <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none">
              </div>
            </div>
            <div class="col">
              <h6 class="mb-1 fw-semibold">Upload New Avatar</h6>
              <p class="text-muted small mb-2">JPG, PNG, or GIF. Max size 2MB</p>
              <div class="d-flex gap-2">
                <label for="avatarInput" class="btn btn-outline-primary btn-sm">
                  <i class="ri-upload-2-line me-1"></i>Choose File
                </label>
                @if($user->getRawOriginal('avatar'))
                  <form action="{{ route('admin.profile.avatar.delete') }}" method="POST" class="d-inline" id="removeAvatarForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to remove your avatar?')">
                      <i class="ri-delete-bin-line me-1"></i>Remove
                    </button>
                  </form>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Personal Information -->
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
          <div class="form-section-title">
            <i class="ri-user-3-line"></i>Personal Information
          </div>
          
          <div class="row g-3">
            <div class="col-md-6">
              <label for="name" class="form-label fw-semibold">
                Full Name <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                  <i class="ri-user-line text-muted"></i>
                </span>
                <input type="text" 
                       class="form-control border-start-0 @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $user->name) }}" 
                       placeholder="Enter your full name"
                       required>
              </div>
              @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="col-md-6">
              <label for="email" class="form-label fw-semibold">
                Email Address <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                  <i class="ri-mail-line text-muted"></i>
                </span>
                <input type="email" 
                       class="form-control border-start-0 @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $user->email) }}" 
                       placeholder="Enter your email"
                       required>
                @if($user->email_verified_at)
                  <span class="input-group-text bg-success-subtle border-start-0">
                    <i class="ri-verified-badge-fill text-success"></i>
                  </span>
                @endif
              </div>
              @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="col-md-6">
              <label for="phone" class="form-label fw-semibold">Phone Number</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                  <i class="ri-phone-line text-muted"></i>
                </span>
                <input type="tel" 
                       class="form-control border-start-0 @error('phone') is-invalid @enderror" 
                       id="phone" 
                       name="phone" 
                       value="{{ old('phone', $user->phone) }}" 
                       placeholder="Enter your phone number">
              </div>
              @error('phone')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Account Status</label>
              <div class="form-control-plaintext">
                <span class="badge bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'suspended' ? 'danger' : 'secondary') }}-subtle text-{{ $user->status === 'active' ? 'success' : ($user->status === 'suspended' ? 'danger' : 'secondary') }} px-3 py-2">
                  <i class="ri-{{ $user->status === 'active' ? 'checkbox-circle' : 'close-circle' }}-line me-1"></i>
                  {{ ucfirst($user->status) }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Password Section -->
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
          <div class="form-section-title">
            <i class="ri-lock-password-line"></i>Change Password
            <span class="badge bg-secondary-subtle text-secondary ms-2">Optional</span>
          </div>
          <p class="text-muted small mb-4">Leave blank if you don't want to change your password</p>
          
          <div class="row g-3">
            <div class="col-md-4">
              <label for="current_password" class="form-label fw-semibold">Current Password</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                  <i class="ri-lock-line text-muted"></i>
                </span>
                <input type="password" 
                       class="form-control border-start-0 border-end-0 @error('current_password') is-invalid @enderror" 
                       id="current_password" 
                       name="current_password"
                       placeholder="••••••••">
                <button class="btn password-toggle-btn" type="button" data-target="current_password">
                  <i class="ri-eye-line"></i>
                </button>
              </div>
              @error('current_password')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="col-md-4">
              <label for="password" class="form-label fw-semibold">New Password</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                  <i class="ri-key-2-line text-muted"></i>
                </span>
                <input type="password" 
                       class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password"
                       placeholder="••••••••">
                <button class="btn password-toggle-btn" type="button" data-target="password">
                  <i class="ri-eye-line"></i>
                </button>
              </div>
              <div class="password-strength-meter">
                <div class="password-strength-fill" id="passwordStrengthBar"></div>
              </div>
              <small class="text-muted" id="passwordStrengthText">Minimum 8 characters</small>
              @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="col-md-4">
              <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                  <i class="ri-lock-unlock-line text-muted"></i>
                </span>
                <input type="password" 
                       class="form-control border-start-0 border-end-0" 
                       id="password_confirmation" 
                       name="password_confirmation"
                       placeholder="••••••••">
                <button class="btn password-toggle-btn" type="button" data-target="password_confirmation">
                  <i class="ri-eye-line"></i>
                </button>
              </div>
              <small class="text-muted" id="passwordMatch"></small>
            </div>
          </div>
        </div>
      </div>

      <!-- Submit Buttons -->
      <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.profile.index') }}" class="btn btn-outline-secondary">
          <i class="ri-close-line me-2"></i>Cancel
        </a>
        <button type="submit" class="btn btn-primary btn-save">
          <i class="ri-save-line me-2"></i>Save Changes
        </button>
      </div>
    </div>

    <!-- Preview Sidebar -->
    <div class="col-lg-4">
      <div class="preview-card card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent">
          <h6 class="card-title mb-0 fw-semibold">
            <i class="ri-eye-line me-2 text-primary"></i>Live Preview
          </h6>
        </div>
        <div class="card-body text-center">
          <div class="mb-3">
            @if($user->getRawOriginal('avatar'))
              <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="preview-avatar" id="previewAvatar">
            @else
              <div class="preview-avatar-initials mx-auto" id="previewInitials">
                {{ strtoupper(substr($user->name, 0, 2)) }}
              </div>
            @endif
          </div>
          <h5 class="mb-1 fw-bold" id="previewName">{{ $user->name }}</h5>
          <p class="text-muted mb-3" id="previewEmail">{{ $user->email }}</p>
          
          <div class="mb-3">
            @foreach($user->roles as $role)
              <span class="badge bg-primary-subtle text-primary px-3 py-2 me-1">
                <i class="ri-shield-user-line me-1"></i>
                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
              </span>
            @endforeach
          </div>
          
          <div class="d-flex justify-content-center gap-2">
            <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }}-subtle text-{{ $user->status === 'active' ? 'success' : 'danger' }} px-3 py-2">
              <i class="ri-{{ $user->status === 'active' ? 'checkbox-circle' : 'close-circle' }}-line me-1"></i>
              {{ ucfirst($user->status) }}
            </span>
            @if($user->email_verified_at)
              <span class="badge bg-success-subtle text-success px-3 py-2">
                <i class="ri-verified-badge-line me-1"></i>Verified
              </span>
            @endif
          </div>
        </div>
        
        <div class="card-footer bg-light border-0">
          <div class="d-flex justify-content-between small">
            <span class="text-muted">
              <i class="ri-calendar-line me-1"></i>Joined
            </span>
            <span class="fw-semibold">{{ $user->created_at->format('M d, Y') }}</span>
          </div>
        </div>
      </div>

      <!-- Tips Card -->
      <div class="card shadow-sm border-0 mt-4 bg-primary-subtle">
        <div class="card-body">
          <h6 class="fw-semibold text-primary mb-3">
            <i class="ri-lightbulb-line me-2"></i>Quick Tips
          </h6>
          <ul class="small text-primary-emphasis mb-0">
            <li class="mb-2">Use a clear profile photo for better recognition</li>
            <li class="mb-2">Keep your email up to date for notifications</li>
            <li class="mb-2">Use a strong password with mix of characters</li>
            <li>Enable 2FA for extra security (coming soon)</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Avatar upload preview
  const avatarInput = document.getElementById('avatarInput');
  const avatarPreview = document.getElementById('avatarPreview');
  const avatarInitials = document.getElementById('avatarInitials');
  const previewAvatar = document.getElementById('previewAvatar');
  const previewInitials = document.getElementById('previewInitials');

  avatarInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        // Update main avatar
        if (avatarPreview) {
          avatarPreview.src = e.target.result;
        } else if (avatarInitials) {
          const wrapper = avatarInitials.parentElement;
          avatarInitials.remove();
          const img = document.createElement('img');
          img.src = e.target.result;
          img.className = 'avatar-upload';
          img.id = 'avatarPreview';
          img.alt = 'Preview';
          wrapper.insertBefore(img, wrapper.firstChild);
        }
        
        // Update preview sidebar
        if (previewAvatar) {
          previewAvatar.src = e.target.result;
        } else if (previewInitials) {
          previewInitials.innerHTML = '<img src="' + e.target.result + '" class="preview-avatar" id="previewAvatar" alt="Preview">';
        }
      };
      reader.readAsDataURL(file);
    }
  });

  // Live preview for name and email
  const nameInput = document.getElementById('name');
  const emailInput = document.getElementById('email');
  const previewName = document.getElementById('previewName');
  const previewEmail = document.getElementById('previewEmail');

  nameInput.addEventListener('input', function() {
    previewName.textContent = this.value || 'Your Name';
    if (avatarInitials) {
      avatarInitials.textContent = (this.value || 'NA').substring(0, 2).toUpperCase();
    }
    if (previewInitials && !document.getElementById('previewAvatar')) {
      previewInitials.textContent = (this.value || 'NA').substring(0, 2).toUpperCase();
    }
  });

  emailInput.addEventListener('input', function() {
    previewEmail.textContent = this.value || 'your@email.com';
  });

  // Password visibility toggle
  document.querySelectorAll('.password-toggle-btn').forEach(button => {
    button.addEventListener('click', function() {
      const targetId = this.getAttribute('data-target');
      const input = document.getElementById(targetId);
      const icon = this.querySelector('i');
      
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('ri-eye-line');
        icon.classList.add('ri-eye-off-line');
      } else {
        input.type = 'password';
        icon.classList.remove('ri-eye-off-line');
        icon.classList.add('ri-eye-line');
      }
    });
  });

  // Password strength meter
  const passwordInput = document.getElementById('password');
  const strengthBar = document.getElementById('passwordStrengthBar');
  const strengthText = document.getElementById('passwordStrengthText');

  passwordInput.addEventListener('input', function() {
    const password = this.value;
    let strength = 0;
    let text = '';
    let color = '';

    if (password.length >= 8) strength += 25;
    if (password.match(/[a-z]/)) strength += 25;
    if (password.match(/[A-Z]/)) strength += 25;
    if (password.match(/[0-9]/) || password.match(/[^a-zA-Z0-9]/)) strength += 25;

    if (strength <= 25) {
      color = '#dc3545';
      text = 'Weak password';
    } else if (strength <= 50) {
      color = '#ffc107';
      text = 'Fair password';
    } else if (strength <= 75) {
      color = '#198754';
      text = 'Good password';
    } else {
      color = '#0d6efd';
      text = 'Strong password';
    }

    strengthBar.style.width = strength + '%';
    strengthBar.style.backgroundColor = color;
    strengthText.textContent = password.length > 0 ? text : 'Minimum 8 characters';
    strengthText.style.color = password.length > 0 ? color : '';
  });

  // Password match check
  const confirmInput = document.getElementById('password_confirmation');
  const matchText = document.getElementById('passwordMatch');

  confirmInput.addEventListener('input', function() {
    if (this.value.length > 0) {
      if (this.value === passwordInput.value) {
        matchText.textContent = '✓ Passwords match';
        matchText.style.color = '#198754';
      } else {
        matchText.textContent = '✗ Passwords do not match';
        matchText.style.color = '#dc3545';
      }
    } else {
      matchText.textContent = '';
    }
  });

});

</script>
@endsection
