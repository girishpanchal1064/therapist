@extends('layouts/contentNavbarLayout')

@section('title', 'My Profile')

@section('vendor-style')
<style>
.profile-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 0.5rem 0.5rem 0 0;
  padding: 2rem;
  position: relative;
  min-height: 200px;
}

.profile-header::before {
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

.profile-avatar-wrapper {
  position: relative;
  margin-top: -60px;
  z-index: 1;
}

.profile-avatar {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  border: 5px solid #fff;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15);
  object-fit: cover;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.profile-avatar-initials {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  border: 5px solid #fff;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.5rem;
  font-weight: 700;
  color: #fff;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stat-card {
  transition: all 0.3s ease;
  border: none;
  border-radius: 0.75rem;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
}

.info-item {
  padding: 1rem;
  border-radius: 0.5rem;
  background: #f8f9fa;
  margin-bottom: 0.75rem;
  transition: all 0.2s ease;
}

.info-item:hover {
  background: #f1f3f4;
}

.info-label {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #6c757d;
  margin-bottom: 0.25rem;
}

.info-value {
  font-size: 1rem;
  font-weight: 500;
  color: #212529;
}

.activity-item {
  padding: 1rem;
  border-left: 3px solid transparent;
  transition: all 0.2s ease;
}

.activity-item:hover {
  background: #f8f9fa;
  border-left-color: #667eea;
}

.password-strength {
  height: 4px;
  border-radius: 2px;
  background: #e9ecef;
  overflow: hidden;
}

.password-strength-bar {
  height: 100%;
  border-radius: 2px;
  transition: width 0.3s ease;
}

.nav-pills-profile .nav-link {
  padding: 0.75rem 1.5rem;
  border-radius: 0.5rem;
  font-weight: 500;
  color: #6c757d;
  transition: all 0.2s ease;
}

.nav-pills-profile .nav-link.active {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: #fff;
}

.nav-pills-profile .nav-link:not(.active):hover {
  background: #f1f3f4;
  color: #212529;
}
</style>
@endsection

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <div class="d-flex align-items-center">
      <i class="ri-checkbox-circle-fill me-2 fs-5"></i>
      <div>{{ session('success') }}</div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <div class="d-flex align-items-center">
      <i class="ri-error-warning-fill me-2 fs-5"></i>
      <div>{{ session('error') }}</div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="row">
  <!-- Profile Card -->
  <div class="col-lg-4 col-xl-4 mb-4">
    <div class="card shadow-sm border-0 overflow-hidden">
      <!-- Profile Header -->
      <div class="profile-header">
        <div class="d-flex justify-content-end position-relative" style="z-index: 1;">
          <a href="{{ route('admin.profile.edit') }}" class="btn btn-light btn-sm shadow-sm">
            <i class="ri-pencil-line me-1"></i> Edit
          </a>
        </div>
      </div>
      
      <!-- Profile Body -->
      <div class="card-body text-center pt-0">
        <div class="profile-avatar-wrapper d-flex justify-content-center">
          @if($user->getRawOriginal('avatar'))
            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="profile-avatar">
          @else
            <div class="profile-avatar-initials">
              {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
          @endif
        </div>
        
        <h4 class="mt-3 mb-1 fw-bold">{{ $user->name }}</h4>
        <p class="text-muted mb-3">{{ $user->email }}</p>
        
        <!-- Roles -->
        <div class="mb-3">
          @foreach($user->roles as $role)
            <span class="badge bg-primary-subtle text-primary px-3 py-2 me-1">
              <i class="ri-shield-user-line me-1"></i>
              {{ ucfirst(str_replace('_', ' ', $role->name)) }}
            </span>
          @endforeach
        </div>
        
        <!-- Status -->
        <div class="d-flex justify-content-center align-items-center gap-2 mb-4">
          <span class="badge bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'suspended' ? 'danger' : 'secondary') }}-subtle text-{{ $user->status === 'active' ? 'success' : ($user->status === 'suspended' ? 'danger' : 'secondary') }} px-3 py-2">
            <i class="ri-{{ $user->status === 'active' ? 'checkbox-circle' : 'close-circle' }}-line me-1"></i>
            {{ ucfirst($user->status) }}
          </span>
          @if($user->email_verified_at)
            <span class="badge bg-success-subtle text-success px-3 py-2">
              <i class="ri-verified-badge-line me-1"></i>
              Verified
            </span>
          @else
            <span class="badge bg-warning-subtle text-warning px-3 py-2">
              <i class="ri-mail-line me-1"></i>
              Unverified
            </span>
          @endif
        </div>

        <!-- Quick Actions -->
        <div class="d-grid gap-2">
          <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">
            <i class="ri-user-settings-line me-2"></i>Edit Profile
          </a>
        </div>
      </div>
    </div>

    <!-- Account Stats -->
    <div class="card shadow-sm border-0 mt-4">
      <div class="card-header border-0 bg-transparent">
        <h6 class="card-title mb-0 fw-semibold">
          <i class="ri-bar-chart-line me-2 text-primary"></i>Account Stats
        </h6>
      </div>
      <div class="card-body pt-0">
        <div class="row g-3">
          <div class="col-6">
            <div class="stat-card bg-primary-subtle p-3 rounded-3">
              <div class="stat-icon bg-primary text-white mb-2">
                <i class="ri-calendar-line"></i>
              </div>
              <div class="text-muted small">Member Since</div>
              <div class="fw-bold">{{ $user->created_at->format('M Y') }}</div>
            </div>
          </div>
          <div class="col-6">
            <div class="stat-card bg-success-subtle p-3 rounded-3">
              <div class="stat-icon bg-success text-white mb-2">
                <i class="ri-time-line"></i>
              </div>
              <div class="text-muted small">Account Age</div>
              <div class="fw-bold">{{ $user->created_at->diffForHumans(null, true) }}</div>
            </div>
          </div>
          <div class="col-6">
            <div class="stat-card bg-info-subtle p-3 rounded-3">
              <div class="stat-icon bg-info text-white mb-2">
                <i class="ri-login-box-line"></i>
              </div>
              <div class="text-muted small">Last Login</div>
              <div class="fw-bold">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</div>
            </div>
          </div>
          <div class="col-6">
            <div class="stat-card bg-warning-subtle p-3 rounded-3">
              <div class="stat-icon bg-warning text-white mb-2">
                <i class="ri-shield-check-line"></i>
              </div>
              <div class="text-muted small">Security</div>
              <div class="fw-bold">{{ $user->email_verified_at ? 'Verified' : 'Pending' }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="col-lg-8 col-xl-8">
    <!-- Profile Information -->
    <div class="card shadow-sm border-0 mb-4">
      <div class="card-header border-0 bg-transparent d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 fw-semibold">
          <i class="ri-user-line me-2 text-primary"></i>Profile Information
        </h5>
        <a href="{{ route('admin.profile.edit') }}" class="btn btn-outline-primary btn-sm">
          <i class="ri-pencil-line me-1"></i>Edit
        </a>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="info-item">
              <div class="info-label">
                <i class="ri-user-3-line me-1"></i>Full Name
              </div>
              <div class="info-value">{{ $user->name }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-item">
              <div class="info-label">
                <i class="ri-mail-line me-1"></i>Email Address
              </div>
              <div class="info-value d-flex align-items-center">
                {{ $user->email }}
                @if($user->email_verified_at)
                  <i class="ri-verified-badge-fill text-success ms-2" title="Verified"></i>
                @endif
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-item">
              <div class="info-label">
                <i class="ri-phone-line me-1"></i>Phone Number
              </div>
              <div class="info-value">{{ $user->phone ?: 'Not provided' }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-item">
              <div class="info-label">
                <i class="ri-shield-user-line me-1"></i>Role
              </div>
              <div class="info-value">
                @foreach($user->roles as $role)
                  {{ ucfirst(str_replace('_', ' ', $role->name)) }}@if(!$loop->last), @endif
                @endforeach
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-item">
              <div class="info-label">
                <i class="ri-calendar-check-line me-1"></i>Joined Date
              </div>
              <div class="info-value">{{ $user->created_at->format('F d, Y') }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-item">
              <div class="info-label">
                <i class="ri-time-line me-1"></i>Last Login
              </div>
              <div class="info-value">{{ $user->last_login_at ? $user->last_login_at->format('M d, Y h:i A') : 'Never' }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Security Settings -->
    <div class="card shadow-sm border-0 mb-4">
      <div class="card-header border-0 bg-transparent">
        <h5 class="card-title mb-0 fw-semibold">
          <i class="ri-lock-line me-2 text-primary"></i>Security Settings
        </h5>
      </div>
      <div class="card-body">
        <!-- Change Password -->
        <div class="border rounded-3 p-4 mb-4">
          <div class="d-flex align-items-start mb-3">
            <div class="flex-shrink-0">
              <div class="avatar avatar-md bg-warning-subtle text-warning rounded-circle">
                <i class="ri-key-2-line fs-4"></i>
              </div>
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="mb-1 fw-semibold">Change Password</h6>
              <p class="text-muted small mb-0">Update your password regularly to keep your account secure</p>
            </div>
          </div>
          
          <form action="{{ route('admin.profile.password') }}" method="POST" id="passwordForm">
            @csrf
            <div class="row g-3">
              <div class="col-md-4">
                <label for="current_password" class="form-label small fw-semibold">Current Password</label>
                <div class="input-group">
                  <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                         id="current_password" name="current_password" placeholder="••••••••">
                  <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                    <i class="ri-eye-line"></i>
                  </button>
                </div>
                @error('current_password')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-4">
                <label for="password" class="form-label small fw-semibold">New Password</label>
                <div class="input-group">
                  <input type="password" class="form-control @error('password') is-invalid @enderror"
                         id="password" name="password" placeholder="••••••••">
                  <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                    <i class="ri-eye-line"></i>
                  </button>
                </div>
                @error('password')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
                <div class="password-strength mt-2" id="passwordStrength">
                  <div class="password-strength-bar" id="passwordStrengthBar"></div>
                </div>
                <small class="text-muted" id="passwordStrengthText">Min 8 characters</small>
              </div>
              <div class="col-md-4">
                <label for="password_confirmation" class="form-label small fw-semibold">Confirm Password</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="••••••••">
                  <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                    <i class="ri-eye-line"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-warning">
                <i class="ri-lock-password-line me-2"></i>Update Password
              </button>
            </div>
          </form>
        </div>

        <!-- Two-Factor Authentication -->
        <div class="border rounded-3 p-4">
          <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-start">
              <div class="flex-shrink-0">
                <div class="avatar avatar-md bg-success-subtle text-success rounded-circle">
                  <i class="ri-shield-keyhole-line fs-4"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-1 fw-semibold">Two-Factor Authentication</h6>
                <p class="text-muted small mb-0">Add an extra layer of security to your account</p>
              </div>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="twoFactor" disabled>
              <span class="badge bg-secondary-subtle text-secondary">Coming Soon</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Activity Timeline -->
    <div class="card shadow-sm border-0">
      <div class="card-header border-0 bg-transparent">
        <h5 class="card-title mb-0 fw-semibold">
          <i class="ri-history-line me-2 text-primary"></i>Recent Activity
        </h5>
      </div>
      <div class="card-body pt-0">
        <div class="activity-timeline">
          <div class="activity-item">
            <div class="d-flex align-items-start">
              <div class="flex-shrink-0">
                <div class="avatar avatar-sm bg-primary-subtle text-primary rounded-circle">
                  <i class="ri-login-circle-line"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-1 fw-semibold small">Last Login</h6>
                <p class="text-muted small mb-0">
                  @if($user->last_login_at)
                    {{ $user->last_login_at->format('M d, Y h:i A') }}
                    <span class="text-muted">• {{ $user->last_login_at->diffForHumans() }}</span>
                  @else
                    Never logged in before
                  @endif
                </p>
              </div>
            </div>
          </div>
          <div class="activity-item">
            <div class="d-flex align-items-start">
              <div class="flex-shrink-0">
                <div class="avatar avatar-sm bg-success-subtle text-success rounded-circle">
                  <i class="ri-user-add-line"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-1 fw-semibold small">Account Created</h6>
                <p class="text-muted small mb-0">
                  {{ $user->created_at->format('M d, Y h:i A') }}
                  <span class="text-muted">• {{ $user->created_at->diffForHumans() }}</span>
                </p>
              </div>
            </div>
          </div>
          @if($user->email_verified_at)
          <div class="activity-item">
            <div class="d-flex align-items-start">
              <div class="flex-shrink-0">
                <div class="avatar avatar-sm bg-info-subtle text-info rounded-circle">
                  <i class="ri-mail-check-line"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-1 fw-semibold small">Email Verified</h6>
                <p class="text-muted small mb-0">
                  {{ $user->email_verified_at->format('M d, Y h:i A') }}
                  <span class="text-muted">• {{ $user->email_verified_at->diffForHumans() }}</span>
                </p>
              </div>
            </div>
          </div>
          @endif
          @if($user->updated_at->gt($user->created_at))
          <div class="activity-item">
            <div class="d-flex align-items-start">
              <div class="flex-shrink-0">
                <div class="avatar avatar-sm bg-warning-subtle text-warning rounded-circle">
                  <i class="ri-edit-line"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-1 fw-semibold small">Profile Updated</h6>
                <p class="text-muted small mb-0">
                  {{ $user->updated_at->format('M d, Y h:i A') }}
                  <span class="text-muted">• {{ $user->updated_at->diffForHumans() }}</span>
                </p>
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Toggle password visibility
  document.querySelectorAll('.toggle-password').forEach(button => {
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

  // Password strength indicator
  const passwordInput = document.getElementById('password');
  const strengthBar = document.getElementById('passwordStrengthBar');
  const strengthText = document.getElementById('passwordStrengthText');

  if (passwordInput) {
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
        text = 'Weak';
      } else if (strength <= 50) {
        color = '#ffc107';
        text = 'Fair';
      } else if (strength <= 75) {
        color = '#198754';
        text = 'Good';
      } else {
        color = '#0d6efd';
        text = 'Strong';
      }

      strengthBar.style.width = strength + '%';
      strengthBar.style.backgroundColor = color;
      strengthText.textContent = password.length > 0 ? text : 'Min 8 characters';
      strengthText.style.color = password.length > 0 ? color : '';
    });
  }
});
</script>
@endsection
