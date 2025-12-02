@extends('layouts/contentNavbarLayout')

@section('title', 'My Profile')

@section('vendor-style')
<style>
:root {
    --theme-primary: #696cff;
    --theme-primary-dark: #5f61e6;
    --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.profile-header {
    background: var(--theme-gradient);
    border-radius: 16px 16px 0 0;
    padding: 2.5rem;
    position: relative;
    min-height: 220px;
    overflow: hidden;
}

.profile-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.03)"/></svg>');
    background-size: 100px;
}

.profile-header::after {
    content: '';
    position: absolute;
    bottom: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}

.profile-avatar-wrapper {
    position: relative;
    margin-top: -70px;
    z-index: 2;
}

.profile-avatar {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    border: 6px solid #fff;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    object-fit: cover;
    background: var(--theme-gradient);
}

.profile-avatar-initials {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    border: 6px solid #fff;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: 700;
    color: #fff;
    background: var(--theme-gradient);
}

.profile-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.08);
    overflow: hidden;
}

.stat-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 12px;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--theme-gradient);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
}

.stat-card:hover::before {
    opacity: 0.1;
}

.stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-icon-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.stat-icon-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.stat-icon-info {
    background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
    color: white;
}

.stat-icon-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
    color: white;
}

.info-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.08);
}

.info-card .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(102, 126, 234, 0.1);
    padding: 1.25rem 1.5rem;
}

.info-card .card-header h5 {
    color: #667eea;
}

.info-item {
    padding: 1.25rem;
    border-radius: 12px;
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    margin-bottom: 1rem;
    transition: all 0.2s ease;
    border: 1px solid rgba(102, 126, 234, 0.08);
}

.info-item:hover {
    background: linear-gradient(135deg, #f0f2ff 0%, #e8e9ff 100%);
    border-color: rgba(102, 126, 234, 0.15);
}

.info-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #667eea;
    margin-bottom: 0.35rem;
    font-weight: 600;
}

.info-value {
    font-size: 1rem;
    font-weight: 600;
    color: #212529;
}

.activity-item {
    padding: 1.25rem;
    border-left: 4px solid transparent;
    transition: all 0.2s ease;
    border-radius: 0 12px 12px 0;
    margin-bottom: 0.5rem;
}

.activity-item:hover {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border-left-color: #667eea;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.activity-icon-primary {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    color: #667eea;
}

.activity-icon-success {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(32, 201, 151, 0.15) 100%);
    color: #28a745;
}

.activity-icon-info {
    background: linear-gradient(135deg, rgba(23, 162, 184, 0.15) 0%, rgba(32, 201, 151, 0.15) 100%);
    color: #17a2b8;
}

.activity-icon-warning {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.15) 0%, rgba(255, 179, 0, 0.15) 100%);
    color: #ffc107;
}

.security-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.08);
}

.security-section {
    border: 1px solid rgba(102, 126, 234, 0.1);
    border-radius: 14px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.security-section:hover {
    border-color: rgba(102, 126, 234, 0.2);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.08);
}

.security-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.security-icon-warning {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.15) 0%, rgba(255, 179, 0, 0.15) 100%);
    color: #ffc107;
}

.security-icon-success {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(32, 201, 151, 0.15) 100%);
    color: #28a745;
}

.password-strength {
    height: 6px;
    border-radius: 3px;
    background: #e9ecef;
    overflow: hidden;
}

.password-strength-bar {
    height: 100%;
    border-radius: 3px;
    transition: width 0.3s ease;
}

.btn-theme {
    background: var(--theme-gradient);
    border: none;
    color: white;
    padding: 0.65rem 1.5rem;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-theme:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-theme-outline {
    background: transparent;
    border: 2px solid #667eea;
    color: #667eea;
    padding: 0.5rem 1.25rem;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-theme-outline:hover {
    background: var(--theme-gradient);
    border-color: transparent;
    color: white;
}

.btn-theme-light {
    background: rgba(255,255,255,0.9);
    border: none;
    color: #667eea;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-theme-light:hover {
    background: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.role-badge {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    color: #667eea;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.status-badge-active {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(32, 201, 151, 0.15) 100%);
    color: #28a745;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.85rem;
}

.status-badge-verified {
    background: linear-gradient(135deg, rgba(23, 162, 184, 0.15) 0%, rgba(32, 201, 151, 0.15) 100%);
    color: #17a2b8;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.85rem;
}

.alert-themed {
    border: none;
    border-radius: 12px;
    border-left: 5px solid;
}

.alert-themed.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border-left-color: #28a745;
    color: #155724;
}

.alert-themed.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    border-left-color: #dc3545;
    color: #721c24;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
}

.input-group-text {
    border-color: #dee2e6;
}

.btn-password-update {
    background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
    border: none;
    color: #212529;
    font-weight: 600;
}

.btn-password-update:hover {
    background: linear-gradient(135deg, #ffb300 0%, #ff9800 100%);
    color: #212529;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
}
</style>
@endsection

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-themed alert-success alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="ri-checkbox-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-themed alert-danger alert-dismissible fade show mb-4" role="alert">
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
        <div class="card profile-card">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="d-flex justify-content-end position-relative" style="z-index: 2;">
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-theme-light">
                        <i class="ri-pencil-line me-1"></i> Edit Profile
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
                
                <h4 class="mt-4 mb-1 fw-bold">{{ $user->name }}</h4>
                <p class="text-muted mb-4">{{ $user->email }}</p>
                
                <!-- Roles -->
                <div class="mb-4">
                    @foreach($user->roles as $role)
                        <span class="role-badge me-1 mb-2">
                            <i class="ri-shield-user-line"></i>
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        </span>
                    @endforeach
                </div>
                
                <!-- Status -->
                <div class="d-flex justify-content-center align-items-center gap-2 mb-4 flex-wrap">
                    <span class="status-badge-active">
                        <i class="ri-checkbox-circle-line me-1"></i>
                        {{ ucfirst($user->status) }}
                    </span>
                    @if($user->email_verified_at)
                        <span class="status-badge-verified">
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
                <div class="d-grid">
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-theme">
                        <i class="ri-user-settings-line me-2"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Account Stats -->
        <div class="card info-card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0 fw-bold">
                    <i class="ri-bar-chart-line me-2" style="color: #667eea;"></i>Account Statistics
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="stat-card bg-light p-3 rounded-3">
                            <div class="stat-icon stat-icon-primary mb-2">
                                <i class="ri-calendar-line"></i>
                            </div>
                            <div class="text-muted small mb-1">Member Since</div>
                            <div class="fw-bold">{{ $user->created_at->format('M Y') }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card bg-light p-3 rounded-3">
                            <div class="stat-icon stat-icon-success mb-2">
                                <i class="ri-time-line"></i>
                            </div>
                            <div class="text-muted small mb-1">Account Age</div>
                            <div class="fw-bold">{{ $user->created_at->diffForHumans(null, true) }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card bg-light p-3 rounded-3">
                            <div class="stat-icon stat-icon-info mb-2">
                                <i class="ri-login-box-line"></i>
                            </div>
                            <div class="text-muted small mb-1">Last Login</div>
                            <div class="fw-bold">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card bg-light p-3 rounded-3">
                            <div class="stat-icon stat-icon-warning mb-2">
                                <i class="ri-shield-check-line"></i>
                            </div>
                            <div class="text-muted small mb-1">Security</div>
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
        <div class="card info-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="ri-user-line me-2" style="color: #667eea;"></i>Profile Information
                </h5>
                <a href="{{ route('admin.profile.edit') }}" class="btn btn-theme-outline btn-sm">
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
                                    <i class="ri-verified-badge-fill ms-2" style="color: #28a745;" title="Verified"></i>
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
                        <div class="info-item mb-md-0">
                            <div class="info-label">
                                <i class="ri-calendar-check-line me-1"></i>Joined Date
                            </div>
                            <div class="info-value">{{ $user->created_at->format('F d, Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item mb-0">
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
        <div class="card security-card mb-4">
            <div class="card-header border-0 bg-transparent">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="ri-lock-line me-2" style="color: #667eea;"></i>Security Settings
                </h5>
            </div>
            <div class="card-body pt-0">
                <!-- Change Password -->
                <div class="security-section">
                    <div class="d-flex align-items-start mb-4">
                        <div class="security-icon security-icon-warning me-3">
                            <i class="ri-key-2-line"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Change Password</h6>
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
                        <div class="mt-4">
                            <button type="submit" class="btn btn-password-update">
                                <i class="ri-lock-password-line me-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Two-Factor Authentication -->
                <div class="security-section mb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-start">
                            <div class="security-icon security-icon-success me-3">
                                <i class="ri-shield-keyhole-line"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Two-Factor Authentication</h6>
                                <p class="text-muted small mb-0">Add an extra layer of security to your account</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-secondary-subtle text-secondary px-3 py-2">Coming Soon</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="card info-card">
            <div class="card-header">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="ri-history-line me-2" style="color: #667eea;"></i>Recent Activity
                </h5>
            </div>
            <div class="card-body pt-0">
                <div class="activity-timeline">
                    <div class="activity-item">
                        <div class="d-flex align-items-start">
                            <div class="activity-icon activity-icon-primary me-3">
                                <i class="ri-login-circle-line"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold small">Last Login</h6>
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
                            <div class="activity-icon activity-icon-success me-3">
                                <i class="ri-user-add-line"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold small">Account Created</h6>
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
                            <div class="activity-icon activity-icon-info me-3">
                                <i class="ri-mail-check-line"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold small">Email Verified</h6>
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
                            <div class="activity-icon activity-icon-warning me-3">
                                <i class="ri-edit-line"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold small">Profile Updated</h6>
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
                color = '#667eea';
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
