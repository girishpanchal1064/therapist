@extends('layouts/contentNavbarLayout')

@section('title', 'My Profile')

@section('page-style')
<style>
  .layout-page .content-wrapper { background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important; }

  .therapist-profile-apni .form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid rgba(186, 194, 210, 0.45);
  }
  .therapist-profile-apni .form-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
  }
  .therapist-profile-apni .section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #041c54;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
  }
  .therapist-profile-apni .section-title-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
  }
  .therapist-profile-apni .section-title-icon.purple,
  .therapist-profile-apni .section-title-icon.gulf {
    background: rgba(4, 28, 84, 0.08);
    color: #041c54;
  }
  .therapist-profile-apni .section-title-icon.green {
    background: rgba(16, 185, 129, 0.12);
    color: #059669;
  }
  .therapist-profile-apni .section-title-icon.blue {
    background: rgba(59, 130, 246, 0.12);
    color: #2563eb;
  }
  .therapist-profile-apni .form-label {
    font-weight: 600;
    font-size: 0.8125rem;
    color: #647494;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }
  .therapist-profile-apni .form-control,
  .therapist-profile-apni .form-select {
    padding: 0.75rem 1rem;
    border: 2px solid rgba(186, 194, 210, 0.7);
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    background: #f8fafc;
  }
  .therapist-profile-apni .form-control:focus,
  .therapist-profile-apni .form-select:focus {
    outline: none;
    border-color: #041c54;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(4, 28, 84, 0.12);
  }
  .therapist-profile-apni .form-control::placeholder {
    color: #9aa8bc;
  }
  .therapist-profile-apni textarea.form-control {
    min-height: 120px;
    resize: vertical;
  }
  .therapist-profile-apni .info-card {
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
    border: 1px solid rgba(16, 185, 129, 0.35);
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 0.875rem;
  }
  .therapist-profile-apni .info-card-icon {
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
  .therapist-profile-apni .info-card-content h6 {
    font-weight: 600;
    color: #166534;
    margin-bottom: 0.25rem;
    font-size: 0.9375rem;
  }
  .therapist-profile-apni .info-card-content p {
    color: #15803d;
    margin: 0;
    font-size: 0.8125rem;
  }
  .therapist-profile-apni .btn-primary {
    background-color: #041c54 !important;
    border-color: #041c54 !important;
    color: #fff !important;
    border-radius: 12px;
    font-weight: 600;
    padding: 0.5rem 1.25rem;
    box-shadow: 0 4px 14px rgba(4, 28, 84, 0.2);
  }
  .therapist-profile-apni .btn-primary:hover,
  .therapist-profile-apni .btn-primary:focus {
    background-color: #052a66 !important;
    border-color: #052a66 !important;
    color: #fff !important;
  }
  .therapist-profile-apni .btn-sm.btn-primary {
    padding: 0.35rem 0.75rem;
    border-radius: 10px;
    font-size: 0.8125rem;
    box-shadow: none;
  }
  .therapist-profile-apni .btn-secondary {
    border-radius: 10px;
    border-color: rgba(186, 194, 210, 0.9);
    color: #647494;
    background: #fff;
  }
  .therapist-profile-apni .btn-secondary:hover {
    background: rgba(186, 194, 210, 0.2);
    border-color: #647494;
    color: #041c54;
  }
  .therapist-profile-apni .btn-outline-primary {
    color: #041c54 !important;
    border-color: rgba(4, 28, 84, 0.45) !important;
    background: #fff !important;
    border-radius: 10px;
    font-weight: 600;
  }
  .therapist-profile-apni .btn-outline-primary:hover {
    background: rgba(4, 28, 84, 0.06) !important;
    border-color: #041c54 !important;
    color: #041c54 !important;
  }
  .therapist-profile-apni h5 {
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
    font-weight: 600;
    color: #041c54;
  }
  .therapist-profile-apni .table {
    --bs-table-hover-bg: rgba(186, 194, 210, 0.15);
  }
  .therapist-profile-apni .text-muted {
    color: #7484a4 !important;
  }
</style>
@endsection

@php
  $tabActive = 'inline-flex items-center gap-2 rounded-[10px] border-2 border-transparent px-3 py-2 text-xs font-semibold whitespace-nowrap transition sm:px-4 sm:text-sm bg-[#041C54] text-white shadow-[0_4px_14px_rgba(4,28,84,0.28)]';
  $tabIdle = 'inline-flex items-center gap-2 rounded-[10px] border-2 border-[#BAC2D2]/50 bg-white px-3 py-2 text-xs font-semibold whitespace-nowrap text-[#7484A4] transition hover:border-[#647494]/60 hover:text-[#041C54] sm:px-4 sm:text-sm';
@endphp

@section('content')
<div class="therapist-profile-apni pb-2">
  {{-- Hero — same Lynch gradient language as dashboard --}}
  <div class="relative mb-8 overflow-hidden rounded-3xl shadow-[0_20px_25px_-5px_rgba(100,116,148,0.2),0_8px_10px_-6px_rgba(100,116,148,0.2)]"
       style="background: linear-gradient(171deg, #647494 0%, #6d7f9d 25%, #7484A4 50%, #6d7f9d 75%, #647494 100%);">
    <div class="pointer-events-none absolute -right-20 top-0 h-64 w-64 rounded-full bg-white/10 blur-[64px]" aria-hidden="true"></div>
    <div class="relative z-10 flex flex-col gap-6 p-6 md:flex-row md:items-center md:justify-between md:p-8">
      <div class="min-w-0">
        <h1 class="font-display flex items-center gap-2 text-2xl font-medium leading-snug text-white md:text-3xl">
          <i class="ri-user-settings-line text-[1.75rem]"></i>
          My Profile
        </h1>
        <p class="mt-2 max-w-xl text-base text-white/90">
          Manage your professional profile, credentials, and account details.
        </p>
      </div>
      <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:items-center">
        <a href="{{ route('therapist.dashboard') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] bg-white px-5 py-2.5 text-sm font-medium text-[#041C54] shadow-md transition hover:bg-[#BAC2D2]/30">
          <i class="ri-dashboard-line text-lg"></i>
          Dashboard
        </a>
        <a href="{{ route('therapist.sessions.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] border-2 border-white px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/10">
          <i class="ri-video-line text-lg"></i>
          Sessions
        </a>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-2xl border border-[#10B981]/30 bg-[#ecfdf5] px-4 py-3 text-sm text-[#065f46] md:px-5" role="status">
      <i class="ri-checkbox-circle-fill mt-0.5 text-lg text-[#059669]"></i>
      <div class="min-w-0 flex-1">{{ session('success') }}</div>
    </div>
  @endif

  <div class="mb-6 overflow-x-auto rounded-2xl border border-[#BAC2D2]/30 bg-white p-3 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-4">
    <div class="flex min-w-max flex-wrap gap-2">
      <a href="{{ route('therapist.profile.index', ['tab' => 'basic-info']) }}" class="{{ $tab === 'basic-info' ? $tabActive : $tabIdle }}">
        <i class="ri-user-line"></i> Basic Info
      </a>
      <a href="{{ route('therapist.profile.index', ['tab' => 'experience']) }}" class="{{ $tab === 'experience' ? $tabActive : $tabIdle }}">
        <i class="ri-briefcase-line"></i> Experience
      </a>
      <a href="{{ route('therapist.profile.index', ['tab' => 'qualifications']) }}" class="{{ $tab === 'qualifications' ? $tabActive : $tabIdle }}">
        <i class="ri-graduation-cap-line"></i> Qualifications
      </a>
      <a href="{{ route('therapist.profile.index', ['tab' => 'area-of-expertise']) }}" class="{{ $tab === 'area-of-expertise' ? $tabActive : $tabIdle }}">
        <i class="ri-focus-line"></i> Expertise
      </a>
      <a href="{{ route('therapist.profile.index', ['tab' => 'awards']) }}" class="{{ $tab === 'awards' ? $tabActive : $tabIdle }}">
        <i class="ri-award-line"></i> Awards
      </a>
      <a href="{{ route('therapist.profile.index', ['tab' => 'professional-bodies']) }}" class="{{ $tab === 'professional-bodies' ? $tabActive : $tabIdle }}">
        <i class="ri-group-line"></i> Prof. Bodies
      </a>
      <a href="{{ route('therapist.profile.index', ['tab' => 'bank-details']) }}" class="{{ $tab === 'bank-details' ? $tabActive : $tabIdle }}">
        <i class="ri-bank-line"></i> Bank Details
      </a>
      <a href="{{ route('therapist.profile.index', ['tab' => 'specializations']) }}" class="{{ $tab === 'specializations' ? $tabActive : $tabIdle }}">
        <i class="ri-star-line"></i> Specializations
      </a>
    </div>
  </div>

  <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-8">
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
