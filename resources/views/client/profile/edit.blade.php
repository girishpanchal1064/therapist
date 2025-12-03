@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Profile')

@section('vendor-style')
<style>
:root {
    --theme-primary: #696cff;
    --theme-primary-dark: #5f61e6;
    --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.page-header {
    background: var(--theme-gradient);
    border-radius: 16px;
    padding: 2rem 2.5rem;
    position: relative;
    overflow: hidden;
    margin-bottom: 2rem;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.03)"/></svg>');
    background-size: 100px;
}

.page-header::after {
    content: '';
    position: absolute;
    bottom: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}

.btn-back {
    background: rgba(255,255,255,0.2);
    border: 2px solid rgba(255,255,255,0.3);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: rgba(255,255,255,0.3);
    border-color: rgba(255,255,255,0.5);
    color: white;
}

.form-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.08);
    overflow: hidden;
}

.form-section-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid rgba(102, 126, 234, 0.1);
    display: flex;
    align-items: center;
    color: #333;
}

.form-section-title i {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--theme-gradient);
    color: white;
    border-radius: 10px;
    margin-right: 0.75rem;
    font-size: 1rem;
}

.avatar-upload-wrapper {
    position: relative;
    display: inline-block;
}

.avatar-upload {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 6px solid #fff;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    object-fit: cover;
    background: var(--theme-gradient);
}

.avatar-upload-initials {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 6px solid #fff;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    font-weight: 700;
    color: #fff;
    background: var(--theme-gradient);
}

.avatar-upload-overlay {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--theme-gradient);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: white;
}

.avatar-upload-overlay:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
}

.avatar-upload-overlay i {
    font-size: 1.25rem;
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-control {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
}

.input-group .form-control {
    border-right: 0;
}

.input-group .input-group-text {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border: 2px solid #e9ecef;
    border-left: 0;
    border-radius: 0 10px 10px 0;
    color: #667eea;
}

.input-group .form-control:focus + .input-group-text {
    border-color: #667eea;
}

.input-icon {
    position: relative;
}

.input-icon .form-control {
    padding-left: 3rem;
}

.input-icon i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #667eea;
    font-size: 1.1rem;
}

.password-toggle-btn {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border: 2px solid #e9ecef;
    border-left: 0;
    color: #667eea;
    border-radius: 0 10px 10px 0;
}

.password-toggle-btn:hover {
    background: linear-gradient(135deg, #f0f2ff 0%, #e8e9ff 100%);
    color: #5a6fd6;
}

.password-strength-meter {
    height: 6px;
    border-radius: 3px;
    background: #e9ecef;
    overflow: hidden;
    margin-top: 0.5rem;
}

.password-strength-fill {
    height: 100%;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.preview-card {
    position: sticky;
    top: 1rem;
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.08);
    overflow: hidden;
}

.preview-card .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(102, 126, 234, 0.1);
    padding: 1rem 1.25rem;
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
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    background: var(--theme-gradient);
    border: 4px solid #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.role-badge {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    color: #667eea;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.8rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.8rem;
}

.status-badge-active {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(32, 201, 151, 0.15) 100%);
    color: #28a745;
}

.status-badge-verified {
    background: linear-gradient(135deg, rgba(23, 162, 184, 0.15) 0%, rgba(32, 201, 151, 0.15) 100%);
    color: #17a2b8;
}

.tips-card {
    border: none;
    border-radius: 16px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    border: 1px solid rgba(102, 126, 234, 0.15);
}

.tips-card h6 {
    color: #667eea;
}

.tips-card li {
    color: #5a5c69;
}

.btn-save {
    background: var(--theme-gradient);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-cancel {
    background: transparent;
    border: 2px solid #dee2e6;
    color: #6c757d;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #f8f9fa;
    border-color: #ced4da;
    color: #495057;
}

.btn-upload {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border: 2px solid rgba(102, 126, 234, 0.2);
    color: #667eea;
    font-weight: 600;
}

.btn-upload:hover {
    background: var(--theme-gradient);
    border-color: transparent;
    color: white;
}

.btn-remove {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%);
    border: 2px solid rgba(220, 53, 69, 0.2);
    color: #dc3545;
    font-weight: 600;
}

.btn-remove:hover {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border-color: transparent;
    color: white;
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

.optional-badge {
    background: linear-gradient(135deg, rgba(108, 117, 125, 0.1) 0%, rgba(108, 117, 125, 0.05) 100%);
    color: #6c757d;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-left: 0.5rem;
}
</style>
@endsection

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
        <div class="d-flex align-items-center">
            <a href="{{ route('client.profile.index') }}" class="btn btn-back me-3">
                <i class="ri-arrow-left-line me-1"></i>Back
            </a>
            <div class="text-white">
                <h4 class="mb-1 fw-bold">Edit Profile</h4>
                <p class="mb-0 opacity-75">Update your personal information and settings</p>
            </div>
        </div>
    </div>
</div>

<!-- Messages -->
@if(session('success'))
    <div class="alert alert-themed alert-success alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="ri-checkbox-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-themed alert-danger alert-dismissible fade show mb-4" role="alert">
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

<form action="{{ route('client.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
    @csrf
    @method('PUT')
    
    <div class="row">
        <!-- Main Form -->
        <div class="col-lg-8">
            <!-- Avatar Upload Section -->
            <div class="card form-card mb-4">
                <div class="card-body p-4">
                    <div class="form-section-title">
                        <i class="ri-image-line"></i>Profile Picture
                    </div>
                    
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar-upload-wrapper">
                                @if($profile && $profile->profile_image)
                                    <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="{{ $user->name }}" class="avatar-upload" id="avatarPreview">
                                @elseif($user->getRawOriginal('avatar'))
                                    <img src="{{ asset('storage/' . $user->getRawOriginal('avatar')) }}" alt="{{ $user->name }}" class="avatar-upload" id="avatarPreview">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=667eea&color=fff&size=200&bold=true&format=svg" alt="{{ $user->name }}" class="avatar-upload" id="avatarPreview">
                                @endif
                                <label for="avatarInput" class="avatar-upload-overlay">
                                    <i class="ri-camera-line"></i>
                                </label>
                                <input type="file" id="avatarInput" name="profile_image" accept="image/*" class="d-none">
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="mb-2 fw-bold">Upload New Avatar</h6>
                            <p class="text-muted small mb-3">JPG, PNG, or GIF. Max size 2MB. Recommended: 300x300px</p>
                            <div class="d-flex gap-2 flex-wrap">
                                <label for="avatarInput" class="btn btn-upload btn-sm">
                                    <i class="ri-upload-2-line me-1"></i>Choose File
                                </label>
                                @if(($profile && $profile->profile_image) || $user->getRawOriginal('avatar'))
                                    <button type="button" class="btn btn-remove btn-sm" id="removeAvatarBtn" data-title="Remove Avatar" data-text="Are you sure you want to remove your avatar? This action cannot be undone." data-confirm-text="Yes, remove it!" data-cancel-text="Cancel">
                                        <i class="ri-delete-bin-line me-1"></i>Remove
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="card form-card mb-4">
                <div class="card-body p-4">
                    <div class="form-section-title">
                        <i class="ri-user-3-line"></i>Personal Information
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label">
                                Full Name <span class="text-danger">*</span>
                            </label>
                            <div class="input-icon">
                                <i class="ri-user-line"></i>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
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
                            <label for="email" class="form-label">
                                Email Address <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-icon flex-grow-1">
                                    <i class="ri-mail-line"></i>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}" 
                                           placeholder="Enter your email"
                                           required
                                           style="border-radius: 10px 0 0 10px;">
                                </div>
                                @if($user->email_verified_at)
                                    <span class="input-group-text" style="background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(32, 201, 151, 0.1) 100%); border-color: #28a745;">
                                        <i class="ri-verified-badge-fill" style="color: #28a745;"></i>
                                    </span>
                                @endif
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <div class="input-icon">
                                <i class="ri-phone-line"></i>
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
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
                            <label class="form-label">Account Status</label>
                            <div class="form-control-plaintext pt-2">
                                <span class="status-badge status-badge-{{ $user->status === 'active' ? 'active' : 'danger' }}">
                                    <i class="ri-{{ $user->status === 'active' ? 'checkbox-circle' : 'close-circle' }}-line me-1"></i>
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Section -->
            <div class="card form-card mb-4">
                <div class="card-body p-4">
                    <div class="form-section-title">
                        <i class="ri-lock-password-line"></i>Change Password
                        <span class="optional-badge">Optional</span>
                    </div>
                    <p class="text-muted small mb-4">Leave blank if you don't want to change your password</p>
                    
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label for="current_password" class="form-label">Current Password</label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password"
                                       placeholder="••••••••"
                                       style="border-radius: 10px 0 0 10px;">
                                <button class="btn password-toggle-btn" type="button" data-target="current_password">
                                    <i class="ri-eye-line"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="password" class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password"
                                       placeholder="••••••••"
                                       style="border-radius: 10px 0 0 10px;">
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
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation"
                                       placeholder="••••••••"
                                       style="border-radius: 10px 0 0 10px;">
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
                <a href="{{ route('client.profile.index') }}" class="btn btn-cancel">
                    <i class="ri-close-line me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-save">
                    <i class="ri-save-line me-2"></i>Save Changes
                </button>
            </div>
        </div>

        <!-- Preview Sidebar -->
        <div class="col-lg-4">
            <div class="preview-card card">
                <div class="card-header">
                    <h6 class="card-title mb-0 fw-bold">
                        <i class="ri-eye-line me-2" style="color: #667eea;"></i>Live Preview
                    </h6>
                </div>
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        @if($profile && $profile->profile_image)
                            <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="{{ $user->name }}" class="preview-avatar" id="previewAvatar">
                        @elseif($user->getRawOriginal('avatar'))
                            <img src="{{ asset('storage/' . $user->getRawOriginal('avatar')) }}" alt="{{ $user->name }}" class="preview-avatar" id="previewAvatar">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=667eea&color=fff&size=200&bold=true&format=svg" alt="{{ $user->name }}" class="preview-avatar" id="previewAvatar">
                        @endif
                    </div>
                    <h5 class="mb-1 fw-bold" id="previewName">{{ $user->name }}</h5>
                    <p class="text-muted mb-4" id="previewEmail">{{ $user->email }}</p>
                    
                    <div class="mb-4">
                        @foreach($user->roles as $role)
                            <span class="role-badge me-1 mb-2">
                                <i class="ri-shield-user-line"></i>
                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                            </span>
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <span class="status-badge status-badge-{{ $user->status === 'active' ? 'active' : 'danger' }}">
                            <i class="ri-{{ $user->status === 'active' ? 'checkbox-circle' : 'close-circle' }}-line me-1"></i>
                            {{ ucfirst($user->status) }}
                        </span>
                        @if($user->email_verified_at)
                            <span class="status-badge status-badge-verified">
                                <i class="ri-verified-badge-line me-1"></i>Verified
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="card-footer bg-light border-0 p-3">
                    <div class="d-flex justify-content-between small">
                        <span class="text-muted">
                            <i class="ri-calendar-line me-1"></i>Joined
                        </span>
                        <span class="fw-bold">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="card tips-card mt-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="ri-lightbulb-line me-2"></i>Quick Tips
                    </h6>
                    <ul class="small mb-0 ps-3">
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

<!-- Hidden form for avatar deletion (outside main form to avoid nesting) -->
@if(($profile && $profile->profile_image) || $user->getRawOriginal('avatar'))
<form action="{{ route('client.profile.image.delete') }}" method="POST" class="d-none" id="removeAvatarForm">
    @csrf
    @method('DELETE')
</form>
@endif

@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Avatar upload preview
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const previewAvatar = document.getElementById('previewAvatar');

    avatarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Update main avatar
                if (avatarPreview) {
                    avatarPreview.src = e.target.result;
                }
                
                // Update preview sidebar
                if (previewAvatar) {
                    previewAvatar.src = e.target.result;
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
        // Name preview is handled by textContent update above
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
            color = '#667eea';
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

    // Handle avatar removal button
    const removeAvatarBtn = document.getElementById('removeAvatarBtn');
    const removeAvatarForm = document.getElementById('removeAvatarForm');
    
    if (removeAvatarBtn && removeAvatarForm) {
        removeAvatarBtn.addEventListener('click', function() {
            const title = this.dataset.title || 'Remove Avatar';
            const text = this.dataset.text || 'Are you sure you want to remove your avatar? This action cannot be undone.';
            const confirmText = this.dataset.confirmText || 'Yes, remove it!';
            const cancelText = this.dataset.cancelText || 'Cancel';

            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary',
                    actions: 'swal2-actions'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    removeAvatarForm.submit();
                }
            });
        });
    }
});
</script>
@endsection
