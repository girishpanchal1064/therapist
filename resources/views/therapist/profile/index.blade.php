@extends('layouts/contentNavbarLayout')

@section('title', 'My Profile')

@section('page-style')
<style>
  /* === Profile Page Custom Styles === */
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    color: white;
    position: relative;
    overflow: hidden;
  }

  .page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
  }

  .page-header h4 {
    font-weight: 700;
    margin-bottom: 0.25rem;
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
  }

  .page-header p {
    opacity: 0.9;
    margin: 0;
    font-size: 0.9375rem;
    position: relative;
    z-index: 1;
  }

  /* Profile Tabs */
  .profile-tabs-wrapper {
    background: white;
    border-radius: 16px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow-x: auto;
  }

  .profile-tabs {
    display: flex;
    gap: 0.5rem;
    min-width: max-content;
  }

  .profile-tab {
    padding: 0.625rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.8125rem;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border: 2px solid transparent;
    white-space: nowrap;
  }

  .profile-tab:not(.active) {
    background: #f3f4f6;
    color: #6b7280;
    border-color: #e5e7eb;
  }

  .profile-tab:not(.active):hover {
    background: #e5e7eb;
    color: #374151;
    transform: translateY(-2px);
  }

  .profile-tab.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }

  .profile-tab i {
    font-size: 1rem;
  }

  /* Profile Card */
  .profile-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow: hidden;
  }

  .profile-card .card-body {
    padding: 2rem;
  }

  /* Form Styles */
  .form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #f3f4f6;
  }

  .form-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
  }

  .section-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .section-title-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
  }

  .section-title-icon.purple {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    color: #7c3aed;
  }

  .section-title-icon.green {
    background: linear-gradient(135deg, rgba(5, 150, 105, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
    color: #059669;
  }

  .section-title-icon.blue {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.1) 100%);
    color: #2563eb;
  }

  .form-label {
    font-weight: 600;
    font-size: 0.8125rem;
    color: #374151;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }

  .form-control,
  .form-select {
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: all 0.2s ease;
    background: #f9fafb;
  }

  .form-control:focus,
  .form-select:focus {
    outline: none;
    border-color: #7c3aed;
    background: white;
    box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
  }

  .form-control::placeholder {
    color: #9ca3af;
  }

  textarea.form-control {
    min-height: 120px;
    resize: vertical;
  }

  /* Avatar Upload */
  .avatar-upload {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
  }

  .avatar-preview {
    width: 100px;
    height: 100px;
    border-radius: 16px;
    object-fit: cover;
    border: 3px solid #e5e7eb;
    transition: all 0.3s ease;
  }

  .avatar-preview:hover {
    border-color: #7c3aed;
  }

  .avatar-placeholder {
    width: 100px;
    height: 100px;
    border-radius: 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 2rem;
  }

  .avatar-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .btn-upload {
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-upload:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }

  .avatar-hint {
    font-size: 0.75rem;
    color: #9ca3af;
  }

  /* Submit Button */
  .btn-submit {
    padding: 0.875rem 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.35);
  }

  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.45);
    color: white;
  }

  /* Info Cards */
  .info-card {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 1px solid #86efac;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 0.875rem;
  }

  .info-card-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(5, 150, 105, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #059669;
    font-size: 1.125rem;
    flex-shrink: 0;
  }

  .info-card-content h6 {
    font-weight: 600;
    color: #166534;
    margin-bottom: 0.25rem;
    font-size: 0.9375rem;
  }

  .info-card-content p {
    color: #16a34a;
    margin: 0;
    font-size: 0.8125rem;
  }

  /* Scrollbar */
  .profile-tabs-wrapper::-webkit-scrollbar {
    height: 4px;
  }

  .profile-tabs-wrapper::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 4px;
  }

  .profile-tabs-wrapper::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 4px;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .profile-card .card-body {
      padding: 1.5rem;
    }

    .avatar-upload {
      flex-direction: column;
      text-align: center;
    }

    .avatar-actions {
      align-items: center;
    }
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <h4>
    <i class="ri-user-settings-line"></i>
    My Profile
  </h4>
  <p>Manage your professional profile and account information</p>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #059669;">
    <i class="ri-checkbox-circle-line me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Profile Tabs -->
<div class="profile-tabs-wrapper">
  <div class="profile-tabs">
    <a href="{{ route('therapist.profile.index', ['tab' => 'basic-info']) }}"
       class="profile-tab {{ $tab === 'basic-info' ? 'active' : '' }}">
      <i class="ri-user-line"></i>
      Basic Info
    </a>
    <a href="{{ route('therapist.profile.index', ['tab' => 'experience']) }}"
       class="profile-tab {{ $tab === 'experience' ? 'active' : '' }}">
      <i class="ri-briefcase-line"></i>
      Experience
    </a>
    <a href="{{ route('therapist.profile.index', ['tab' => 'qualifications']) }}"
       class="profile-tab {{ $tab === 'qualifications' ? 'active' : '' }}">
      <i class="ri-graduation-cap-line"></i>
      Qualifications
    </a>
    <a href="{{ route('therapist.profile.index', ['tab' => 'area-of-expertise']) }}"
       class="profile-tab {{ $tab === 'area-of-expertise' ? 'active' : '' }}">
      <i class="ri-focus-line"></i>
      Expertise
    </a>
    <a href="{{ route('therapist.profile.index', ['tab' => 'awards']) }}"
       class="profile-tab {{ $tab === 'awards' ? 'active' : '' }}">
      <i class="ri-award-line"></i>
      Awards
    </a>
    <a href="{{ route('therapist.profile.index', ['tab' => 'professional-bodies']) }}"
       class="profile-tab {{ $tab === 'professional-bodies' ? 'active' : '' }}">
      <i class="ri-group-line"></i>
      Prof. Bodies
    </a>
    <a href="{{ route('therapist.profile.index', ['tab' => 'bank-details']) }}"
       class="profile-tab {{ $tab === 'bank-details' ? 'active' : '' }}">
      <i class="ri-bank-line"></i>
      Bank Details
    </a>
    <a href="{{ route('therapist.profile.index', ['tab' => 'specializations']) }}"
       class="profile-tab {{ $tab === 'specializations' ? 'active' : '' }}">
      <i class="ri-star-line"></i>
      Specializations
    </a>
  </div>
</div>

<!-- Profile Content -->
<div class="profile-card">
  <div class="card-body">
    <!-- Tab Content -->
    @if($tab === 'basic-info')
      @include('therapist.profile.tabs.basic-info')
    @elseif($tab === 'experience')
      @include('therapist.profile.tabs.experience')
    @elseif($tab === 'qualifications')
      @include('therapist.profile.tabs.qualifications')
    @elseif($tab === 'area-of-expertise')
      @include('therapist.profile.tabs.area-of-expertise')
    @elseif($tab === 'awards')
      @include('therapist.profile.tabs.awards')
    @elseif($tab === 'professional-bodies')
      @include('therapist.profile.tabs.professional-bodies')
    @elseif($tab === 'bank-details')
      @include('therapist.profile.tabs.bank-details')
    @elseif($tab === 'specializations')
      @include('therapist.profile.tabs.specializations')
    @endif
  </div>
</div>
@endsection
