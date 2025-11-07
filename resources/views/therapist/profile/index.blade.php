@extends('layouts/contentNavbarLayout')

@section('title', 'Profile')

@section('content')
<div class="row">
  <div class="col-12 mb-4">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="card">
      <div class="card-body">
        <!-- Profile Tabs Navigation -->
        <div class="d-flex flex-wrap gap-2 mb-4 profile-filter-tabs">
          <a href="{{ route('therapist.profile.index', ['tab' => 'basic-info']) }}"
             class="btn {{ $tab === 'basic-info' ? 'btn-primary' : 'btn-outline-secondary' }} profile-tab-btn">
            <i class="ri-user-line me-1"></i> BASIC INFO
          </a>
          <a href="{{ route('therapist.profile.index', ['tab' => 'experience']) }}"
             class="btn {{ $tab === 'experience' ? 'btn-primary' : 'btn-outline-secondary' }} profile-tab-btn">
            <i class="ri-briefcase-line me-1"></i> EXPERIENCE
          </a>
          <a href="{{ route('therapist.profile.index', ['tab' => 'qualifications']) }}"
             class="btn {{ $tab === 'qualifications' ? 'btn-primary' : 'btn-outline-secondary' }} profile-tab-btn">
            <i class="ri-graduation-cap-line me-1"></i> QUALIFICATION
          </a>
          <a href="{{ route('therapist.profile.index', ['tab' => 'area-of-expertise']) }}"
             class="btn {{ $tab === 'area-of-expertise' ? 'btn-primary' : 'btn-outline-secondary' }} profile-tab-btn">
            <i class="ri-focus-line me-1"></i> AREA OF EXPERTISE
          </a>
          <a href="{{ route('therapist.profile.index', ['tab' => 'awards']) }}"
             class="btn {{ $tab === 'awards' ? 'btn-primary' : 'btn-outline-secondary' }} profile-tab-btn">
            <i class="ri-award-line me-1"></i> AWARD & RECOGNITION
          </a>
          <a href="{{ route('therapist.profile.index', ['tab' => 'professional-bodies']) }}"
             class="btn {{ $tab === 'professional-bodies' ? 'btn-primary' : 'btn-outline-secondary' }} profile-tab-btn">
            <i class="ri-group-line me-1"></i> MEMBER OF PROFESSIONAL BODIES
          </a>
          <a href="{{ route('therapist.profile.index', ['tab' => 'bank-details']) }}"
             class="btn {{ $tab === 'bank-details' ? 'btn-primary' : 'btn-outline-secondary' }} profile-tab-btn">
            <i class="ri-bank-line me-1"></i> BANK DETAILS
          </a>
          <a href="{{ route('therapist.profile.index', ['tab' => 'specializations']) }}"
             class="btn {{ $tab === 'specializations' ? 'btn-primary' : 'btn-outline-secondary' }} profile-tab-btn">
            <i class="ri-star-line me-1"></i> SPECIALIZATIONS
          </a>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
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
    </div>
  </div>
</div>
@endsection

@section('page-style')
<style>
  .profile-filter-tabs {
    border-bottom: 2px solid #e0e6ed;
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
  }

  .profile-tab-btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 0.875rem;
    white-space: nowrap;
  }

  .profile-tab-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .profile-tab-btn.btn-primary {
    background: linear-gradient(135deg, #696cff 0%, #5a5fef 100%);
    border: none;
    color: white;
  }

  .profile-tab-btn.btn-outline-secondary {
    background: white;
    border: 1px solid #d9dee3;
    color: #697a8d;
  }

  .profile-tab-btn.btn-outline-secondary:hover {
    background: #f8f9fa;
    border-color: #d9dee3;
    color: #697a8d;
  }
</style>
@endsection
