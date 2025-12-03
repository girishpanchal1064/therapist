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

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
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
        <div class="card profile-card">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="d-flex justify-content-end position-relative" style="z-index: 2;">
                    <a href="{{ route('client.profile.edit') }}" class="btn btn-theme-light">
                        <i class="ri-pencil-line me-1"></i> Edit Profile
                    </a>
                </div>
            </div>
            
            <!-- Profile Body -->
            <div class="card-body text-center pt-0">
                <div class="profile-avatar-wrapper d-flex justify-content-center">
                    @if($profile && $profile->profile_image)
                        <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="{{ $user->name }}" class="profile-avatar">
                    @elseif($user->getRawOriginal('avatar'))
                        <img src="{{ asset('storage/' . $user->getRawOriginal('avatar')) }}" alt="{{ $user->name }}" class="profile-avatar">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=667eea&color=fff&size=200&bold=true&format=svg" alt="{{ $user->name }}" class="profile-avatar">
                    @endif
                </div>
                
                <h4 class="mt-4 mb-1 fw-bold">{{ $user->name }}</h4>
                <p class="text-muted mb-4">{{ $user->email }}</p>
                
                <!-- Status -->
                <div class="d-flex justify-content-center align-items-center gap-2 mb-4 flex-wrap">
                    <span class="status-badge-active">
                        <i class="ri-checkbox-circle-line me-1"></i>
                        Active
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
                    <a href="{{ route('client.profile.edit') }}" class="btn btn-theme">
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
                <a href="{{ route('client.profile.edit') }}" class="btn btn-theme-outline btn-sm">
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
                    @if($profile)
                        @if($profile->first_name || $profile->last_name)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="ri-user-line me-1"></i>First Name
                                    </div>
                                    <div class="info-value">{{ $profile->first_name ?: 'Not provided' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="ri-user-line me-1"></i>Last Name
                                    </div>
                                    <div class="info-value">{{ $profile->last_name ?: 'Not provided' }}</div>
                                </div>
                            </div>
                        @endif
                        @if($profile->phone || $user->phone)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="ri-phone-line me-1"></i>Phone Number
                                    </div>
                                    <div class="info-value">{{ $user->phone ?: ($profile->phone ?? 'Not provided') }}</div>
                                </div>
                            </div>
                        @endif
                        @if($profile->date_of_birth)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="ri-calendar-line me-1"></i>Date of Birth
                                    </div>
                                    <div class="info-value">{{ $profile->date_of_birth->format('F d, Y') }}</div>
                                </div>
                            </div>
                        @endif
                        @if($profile->gender)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="ri-genderless-line me-1"></i>Gender
                                    </div>
                                    <div class="info-value">{{ ucfirst($profile->gender) }}</div>
                                </div>
                            </div>
                        @endif
                        @if($profile->bio)
                            <div class="col-12">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="ri-file-text-line me-1"></i>Bio
                                    </div>
                                    <div class="info-value">{{ $profile->bio }}</div>
                                </div>
                            </div>
                        @endif
                        @if($profile->address_line1 || $profile->city || $profile->state)
                            <div class="col-12">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="ri-map-pin-line me-1"></i>Address
                                    </div>
                                    <div class="info-value">
                                        @if($profile->address_line1)
                                            {{ $profile->address_line1 }}
                                        @endif
                                        @if($profile->address_line2)
                                            , {{ $profile->address_line2 }}
                                        @endif
                                        @if($profile->city)
                                            , {{ $profile->city }}
                                        @endif
                                        @if($profile->state)
                                            , {{ $profile->state }}
                                        @endif
                                        @if($profile->country)
                                            , {{ $profile->country }}
                                        @endif
                                        @if($profile->pincode)
                                             - {{ $profile->pincode }}
                                        @endif
                                        @if(!$profile->address_line1 && !$profile->city && !$profile->state)
                                            Not provided
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="col-md-6">
                        <div class="info-item mb-md-0">
                            <div class="info-label">
                                <i class="ri-calendar-check-line me-1"></i>Joined Date
                            </div>
                            <div class="info-value">{{ $user->created_at->format('F d, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
