@extends('layouts/contentNavbarLayout')

@section('title', 'Schedule New Appointment')

@section('vendor-style')
<style>
  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
  }
  .page-header h4 {
    margin: 0;
    font-weight: 700;
    color: white;
    font-size: 1.5rem;
  }
  .page-header p {
    color: rgba(255, 255, 255, 0.85);
    margin: 4px 0 0 0;
  }
  .page-header .btn-header {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .page-header .btn-header:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    color: white;
  }

  /* Form Card */
  .form-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    transition: all 0.3s ease;
  }
  .form-card:hover {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
  }
  .form-card .card-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    border-bottom: 1px solid #e9ecef;
    padding: 20px 24px;
  }
  .form-card .card-body { 
    padding: 24px; 
  }

  .section-title {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 0;
  }
  .section-title .icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  .section-title h5 { 
    margin: 0; 
    font-weight: 700; 
    color: #2d3748;
  }
  .section-title small { 
    color: #718096; 
    font-size: 0.85rem;
  }

  /* User Selection */
  .user-select-wrapper {
    position: relative;
  }
  .user-search {
    position: relative;
    margin-bottom: 16px;
  }
  .user-search input {
    padding-left: 44px;
    border-radius: 12px;
    border: 2px solid #e4e6eb;
    transition: all 0.3s ease;
    height: 48px;
  }
  .user-search input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  }
  .user-search i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #8e9baa;
    font-size: 1.1rem;
  }

  .user-list {
    max-height: 300px;
    overflow-y: auto;
    border: 2px solid #e4e6eb;
    border-radius: 14px;
    padding: 10px;
    background: #fafbfc;
  }
  .user-list::-webkit-scrollbar { width: 6px; }
  .user-list::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 3px; }
  .user-list::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 3px; }
  .user-list::-webkit-scrollbar-thumb:hover { background: #a1a1a1; }

  .user-option {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 2px solid transparent;
    margin-bottom: 6px;
    background: white;
  }
  .user-option:last-child { margin-bottom: 0; }
  .user-option:hover {
    background: rgba(102, 126, 234, 0.04);
    border-color: rgba(102, 126, 234, 0.2);
    transform: translateX(4px);
  }
  .user-option.selected {
    background: rgba(102, 126, 234, 0.08);
    border-color: #667eea;
    box-shadow: 0 2px 10px rgba(102, 126, 234, 0.15);
  }
  .user-option input { display: none; }

  .user-avatar {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    object-fit: cover;
    flex-shrink: 0;
    border: 2px solid #f0f0f5;
  }
  .user-initials {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
  }
  .user-initials.client { 
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%); 
    color: #667eea; 
  }
  .user-initials.therapist { 
    background: linear-gradient(135deg, rgba(40, 199, 111, 0.15) 0%, rgba(30, 157, 88, 0.15) 100%); 
    color: #28c76f; 
  }

  .user-info { flex: 1; }
  .user-info h6 { margin: 0 0 3px; font-size: 0.95rem; font-weight: 600; color: #2d3748; }
  .user-info small { color: #718096; font-size: 0.8rem; }

  .user-check {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    border: 2px solid #e0e5ec;
    display: flex;
    align-items: center;
    justify-content: center;
    color: transparent;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }
  .user-option.selected .user-check {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: transparent;
    color: white;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
  }

  /* Option Cards */
  .option-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
  }
  .option-card {
    border: 2px solid #e4e6eb;
    border-radius: 14px;
    padding: 24px 16px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
    position: relative;
    overflow: hidden;
  }
  .option-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  .option-card:hover {
    border-color: #667eea;
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.15);
  }
  .option-card:hover::before {
    opacity: 1;
  }
  .option-card.selected {
    border-color: #667eea;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.2);
  }
  .option-card.selected::before {
    opacity: 1;
  }
  .option-card input { display: none; }
  .option-card .option-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    margin: 0 auto 14px;
    transition: all 0.3s ease;
  }
  .option-card:hover .option-icon,
  .option-card.selected .option-icon {
    transform: scale(1.1);
  }
  .option-card h6 { 
    margin: 0 0 6px; 
    font-weight: 700; 
    color: #2d3748;
    font-size: 1rem;
  }
  .option-card small { 
    color: #718096; 
    font-size: 0.8rem; 
  }

  .option-icon.bg-purple { 
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%); 
    color: #667eea; 
  }
  .option-icon.bg-green { 
    background: linear-gradient(135deg, rgba(40, 199, 111, 0.15) 0%, rgba(30, 157, 88, 0.15) 100%); 
    color: #28c76f; 
  }
  .option-icon.bg-orange { 
    background: linear-gradient(135deg, rgba(255, 159, 67, 0.15) 0%, rgba(255, 133, 16, 0.15) 100%); 
    color: #ff9f43; 
  }
  .option-icon.bg-blue { 
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%); 
    color: #3b82f6; 
  }
  .option-icon.bg-pink { 
    background: linear-gradient(135deg, rgba(236, 72, 153, 0.15) 0%, rgba(219, 39, 119, 0.15) 100%); 
    color: #ec4899; 
  }

  /* Duration Options */
  .duration-grid {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
  }
  .duration-option {
    flex: 1;
    min-width: 90px;
    border: 2px solid #e4e6eb;
    border-radius: 14px;
    padding: 20px 14px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
    position: relative;
  }
  .duration-option:hover {
    border-color: #667eea;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.12);
  }
  .duration-option.selected {
    border-color: #667eea;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
  }
  .duration-option.popular {
    position: relative;
  }
  .duration-option.popular::after {
    content: 'Popular';
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 0.65rem;
    padding: 3px 10px;
    border-radius: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
  }
  .duration-option input { display: none; }
  .duration-option .time { 
    font-size: 1.8rem; 
    font-weight: 800; 
    color: #566a7f;
    line-height: 1;
    margin-bottom: 4px;
  }
  .duration-option.selected .time { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
  .duration-option .unit { 
    font-size: 0.75rem; 
    color: #8e9baa; 
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  /* Schedule Inputs */
  .schedule-input {
    position: relative;
  }
  .schedule-input label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
    font-weight: 600;
    color: #4a5568;
    font-size: 0.9rem;
  }
  .schedule-input label i {
    color: #667eea;
    font-size: 1.1rem;
  }
  .schedule-input input,
  .schedule-input select {
    border: 2px solid #e4e6eb;
    border-radius: 12px;
    padding: 14px 18px;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    width: 100%;
  }
  .schedule-input input:focus,
  .schedule-input select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  }

  /* Meeting Details */
  .meeting-input label {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
    color: #4a5568;
    font-size: 0.9rem;
  }
  .meeting-input input,
  .meeting-input textarea {
    border: 2px solid #e4e6eb;
    border-radius: 12px;
    padding: 14px 18px;
    transition: all 0.3s ease;
    width: 100%;
    font-size: 0.95rem;
  }
  .meeting-input input:focus,
  .meeting-input textarea:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  }
  .meeting-input small {
    display: block;
    margin-top: 8px;
    color: #8e9baa;
    font-size: 0.8rem;
  }

  /* Preview Sidebar */
  .preview-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    position: sticky;
    top: 100px;
    overflow: hidden;
  }
  .preview-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 28px 24px;
    color: white;
    text-align: center;
  }
  .preview-header i { 
    font-size: 2.5rem; 
    margin-bottom: 12px; 
    display: block;
    opacity: 0.9;
  }
  .preview-header h5 { 
    margin: 0; 
    color: white; 
    font-weight: 700;
    font-size: 1.2rem;
  }
  .preview-header small { 
    opacity: 0.85; 
    font-size: 0.85rem;
  }

  .preview-body { 
    padding: 24px; 
    background: white;
  }
  .preview-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 0;
    border-bottom: 1px dashed #e9ecef;
  }
  .preview-item:last-child { border-bottom: none; }
  .preview-item .label {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #718096;
    font-size: 0.875rem;
    font-weight: 500;
  }
  .preview-item .label i {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    color: #667eea;
    font-size: 0.95rem;
  }
  .preview-item .value {
    font-weight: 600;
    color: #2d3748;
    text-align: right;
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .preview-footer {
    padding: 18px 24px;
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    border-top: 1px solid #e9ecef;
  }
  .preview-footer p {
    margin: 0;
    font-size: 0.8rem;
    color: #718096;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .preview-footer p i {
    color: #667eea;
    font-size: 1rem;
  }

  /* Action Buttons */
  .form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 28px;
    border-top: 1px solid #e9ecef;
    margin-top: 28px;
  }
  .btn-cancel {
    background: white;
    border: 2px solid #e4e6eb;
    color: #566a7f;
    padding: 14px 28px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
  }
  .btn-cancel:hover {
    border-color: #ea5455;
    color: #ea5455;
    background: rgba(234, 84, 85, 0.05);
  }
  .btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 14px 32px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  .btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
  }

  /* Alert Styling */
  .alert-error {
    background: linear-gradient(135deg, rgba(234, 84, 85, 0.1) 0%, rgba(234, 84, 85, 0.05) 100%);
    border: 1px solid rgba(234, 84, 85, 0.2);
    border-radius: 14px;
    padding: 20px 24px;
  }
  .alert-error i {
    color: #ea5455;
  }

  /* Form Labels */
  .form-label-styled {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 14px;
    font-weight: 600;
    color: #4a5568;
    font-size: 0.95rem;
  }
  .form-label-styled i {
    color: #667eea;
    font-size: 1.1rem;
  }

  @media (max-width: 991px) {
    .option-grid { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 575px) {
    .option-grid { grid-template-columns: 1fr; }
    .duration-option { min-width: 75px; }
    .form-actions {
      flex-direction: column;
      gap: 12px;
    }
    .form-actions .btn-cancel,
    .form-actions .btn-submit {
      width: 100%;
    }
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4><i class="ri-calendar-check-line me-2"></i>Schedule New Appointment</h4>
      <p>Create a therapy session between client and therapist</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ route('admin.appointments.index') }}" class="btn btn-header">
        <i class="ri-arrow-left-line me-1"></i> Back to Appointments
      </a>
    </div>
  </div>
</div>

<!-- Error Messages -->
@if($errors->any())
  <div class="alert alert-error d-flex align-items-start mb-4" role="alert">
    <i class="ri-error-warning-line me-3 mt-1 ri-xl"></i>
    <div>
      <strong class="text-danger">Please fix the following errors:</strong>
      <ul class="mb-0 mt-2 text-danger">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif

<form action="{{ route('admin.appointments.store') }}" method="POST" id="appointmentForm">
  @csrf
  <div class="row g-4">
    <!-- Main Form -->
    <div class="col-lg-8">
      <!-- Section 1: Participants -->
      <div class="card form-card mb-4">
        <div class="card-header">
          <div class="section-title">
            <div class="icon">
              <i class="ri-user-add-line"></i>
            </div>
            <div>
              <h5>Select Participants</h5>
              <small>Choose the client and therapist for this session</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-4">
            <!-- Client Selection -->
            <div class="col-md-6">
              <label class="form-label-styled">
                <i class="ri-user-heart-line"></i>Client <span class="text-danger">*</span>
              </label>
              <div class="user-select-wrapper">
                <div class="user-search">
                  <i class="ri-search-line"></i>
                  <input type="text" class="form-control" id="searchClient" placeholder="Search clients by name or email...">
                </div>
                <div class="user-list" id="clientsList">
                  @forelse($clients as $client)
                    <label class="user-option {{ old('client_id') == $client->id ? 'selected' : '' }}" data-search="{{ strtolower($client->name . ' ' . $client->email) }}">
                      <input type="radio" name="client_id" value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'checked' : '' }} required>
                      @if($client->profile && $client->profile->profile_image)
                        <img src="{{ asset('storage/' . $client->profile->profile_image) }}" alt="{{ $client->name }}" class="user-avatar">
                      @elseif($client->getRawOriginal('avatar'))
                        <img src="{{ asset('storage/' . $client->getRawOriginal('avatar')) }}" alt="{{ $client->name }}" class="user-avatar">
                      @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($client->name) }}&background=3b82f6&color=fff&size=80&bold=true&format=svg" alt="{{ $client->name }}" class="user-avatar">
                      @endif
                      <div class="user-info">
                        <h6>{{ $client->name }}</h6>
                        <small>{{ $client->email }}</small>
                      </div>
                      <div class="user-check">
                        <i class="ri-check-line"></i>
                      </div>
                    </label>
                  @empty
                    <div class="text-center py-4 text-muted">
                      <i class="ri-user-unfollow-line ri-2x mb-2 d-block"></i>
                      <p class="mb-0">No clients found</p>
                    </div>
                  @endforelse
                </div>
              </div>
              @error('client_id')
                <div class="text-danger small mt-2"><i class="ri-error-warning-line me-1"></i>{{ $message }}</div>
              @enderror
            </div>

            <!-- Therapist Selection -->
            <div class="col-md-6">
              <label class="form-label-styled">
                <i class="ri-user-star-line" style="color: #28c76f;"></i>Therapist <span class="text-danger">*</span>
              </label>
              <div class="user-select-wrapper">
                <div class="user-search">
                  <i class="ri-search-line"></i>
                  <input type="text" class="form-control" id="searchTherapist" placeholder="Search therapists by name...">
                </div>
                <div class="user-list" id="therapistsList">
                  @forelse($therapists as $therapist)
                    <label class="user-option {{ old('therapist_id') == $therapist->id ? 'selected' : '' }}" data-search="{{ strtolower($therapist->name . ' ' . $therapist->email) }}">
                      <input type="radio" name="therapist_id" value="{{ $therapist->id }}" {{ old('therapist_id') == $therapist->id ? 'checked' : '' }} required>
                      @if($therapist->getRawOriginal('avatar'))
                        <img src="{{ $therapist->avatar }}" alt="{{ $therapist->name }}" class="user-avatar">
                      @else
                        <div class="user-initials therapist">{{ strtoupper(substr($therapist->name, 0, 2)) }}</div>
                      @endif
                      <div class="user-info">
                        <h6>{{ $therapist->name }}</h6>
                        <small>{{ $therapist->therapistProfile->qualification ?? $therapist->email }}</small>
                      </div>
                      <div class="user-check">
                        <i class="ri-check-line"></i>
                      </div>
                    </label>
                  @empty
                    <div class="text-center py-4 text-muted">
                      <i class="ri-user-unfollow-line ri-2x mb-2 d-block"></i>
                      <p class="mb-0">No therapists found</p>
                    </div>
                  @endforelse
                </div>
              </div>
              @error('therapist_id')
                <div class="text-danger small mt-2"><i class="ri-error-warning-line me-1"></i>{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <!-- Section 2: Session Type & Mode -->
      <div class="card form-card mb-4">
        <div class="card-header">
          <div class="section-title">
            <div class="icon">
              <i class="ri-settings-4-line"></i>
            </div>
            <div>
              <h5>Session Configuration</h5>
              <small>Choose appointment type and communication mode</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <!-- Appointment Type -->
          <label class="form-label-styled mb-3">
            <i class="ri-group-line"></i>Appointment Type <span class="text-danger">*</span>
          </label>
          <div class="option-grid mb-4">
            <label class="option-card {{ old('appointment_type', 'individual') === 'individual' ? 'selected' : '' }}">
              <input type="radio" name="appointment_type" value="individual" {{ old('appointment_type', 'individual') === 'individual' ? 'checked' : '' }} required>
              <div class="option-icon bg-purple"><i class="ri-user-line"></i></div>
              <h6>Individual</h6>
              <small>One-on-one session</small>
            </label>
            <label class="option-card {{ old('appointment_type') === 'couple' ? 'selected' : '' }}">
              <input type="radio" name="appointment_type" value="couple" {{ old('appointment_type') === 'couple' ? 'checked' : '' }}>
              <div class="option-icon bg-pink"><i class="ri-hearts-line"></i></div>
              <h6>Couple</h6>
              <small>Couples counseling</small>
            </label>
            <label class="option-card {{ old('appointment_type') === 'family' ? 'selected' : '' }}">
              <input type="radio" name="appointment_type" value="family" {{ old('appointment_type') === 'family' ? 'checked' : '' }}>
              <div class="option-icon bg-orange"><i class="ri-parent-line"></i></div>
              <h6>Family</h6>
              <small>Family therapy</small>
            </label>
          </div>

          <!-- Session Mode -->
          <label class="form-label-styled mb-3">
            <i class="ri-webcam-line"></i>Session Mode <span class="text-danger">*</span>
          </label>
          <div class="option-grid">
            <label class="option-card {{ old('session_mode', 'video') === 'video' ? 'selected' : '' }}">
              <input type="radio" name="session_mode" value="video" {{ old('session_mode', 'video') === 'video' ? 'checked' : '' }} required>
              <div class="option-icon bg-purple"><i class="ri-video-chat-line"></i></div>
              <h6>Video Call</h6>
              <small>Face-to-face video</small>
            </label>
            <label class="option-card {{ old('session_mode') === 'audio' ? 'selected' : '' }}">
              <input type="radio" name="session_mode" value="audio" {{ old('session_mode') === 'audio' ? 'checked' : '' }}>
              <div class="option-icon bg-green"><i class="ri-phone-line"></i></div>
              <h6>Voice Call</h6>
              <small>Audio only session</small>
            </label>
            <label class="option-card {{ old('session_mode') === 'chat' ? 'selected' : '' }}">
              <input type="radio" name="session_mode" value="chat" {{ old('session_mode') === 'chat' ? 'checked' : '' }}>
              <div class="option-icon bg-blue"><i class="ri-chat-3-line"></i></div>
              <h6>Text Chat</h6>
              <small>Messaging session</small>
            </label>
          </div>
        </div>
      </div>

      <!-- Section 3: Schedule -->
      <div class="card form-card mb-4">
        <div class="card-header">
          <div class="section-title">
            <div class="icon">
              <i class="ri-calendar-schedule-line"></i>
            </div>
            <div>
              <h5>Schedule Details</h5>
              <small>Set the date, time and duration for the session</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-4 mb-4">
            <div class="col-md-4">
              <div class="schedule-input">
                <label><i class="ri-calendar-2-line"></i> Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="appointment_date" id="appointment_date" 
                       value="{{ old('appointment_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
              </div>
              @error('appointment_date')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-4">
              <div class="schedule-input">
                <label><i class="ri-time-line"></i> Time <span class="text-danger">*</span></label>
                <input type="time" class="form-control" name="appointment_time" id="appointment_time" 
                       value="{{ old('appointment_time', '10:00') }}" required>
              </div>
              @error('appointment_time')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-4">
              <div class="schedule-input">
                <label><i class="ri-checkbox-circle-line"></i> Status</label>
                <select class="form-select" name="status">
                  <option value="scheduled" {{ old('status', 'scheduled') === 'scheduled' ? 'selected' : '' }}>📅 Scheduled</option>
                  <option value="confirmed" {{ old('status') === 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                </select>
              </div>
            </div>
          </div>

          <label class="form-label-styled mb-3">
            <i class="ri-timer-line"></i>Session Duration <span class="text-danger">*</span>
          </label>
          <div class="duration-grid">
            <label class="duration-option {{ old('duration_minutes') == '30' ? 'selected' : '' }}">
              <input type="radio" name="duration_minutes" value="30" {{ old('duration_minutes') == '30' ? 'checked' : '' }}>
              <div class="time">30</div>
              <div class="unit">minutes</div>
            </label>
            <label class="duration-option popular {{ old('duration_minutes', '45') == '45' ? 'selected' : '' }}">
              <input type="radio" name="duration_minutes" value="45" {{ old('duration_minutes', '45') == '45' ? 'checked' : '' }}>
              <div class="time">45</div>
              <div class="unit">minutes</div>
            </label>
            <label class="duration-option {{ old('duration_minutes') == '60' ? 'selected' : '' }}">
              <input type="radio" name="duration_minutes" value="60" {{ old('duration_minutes') == '60' ? 'checked' : '' }}>
              <div class="time">60</div>
              <div class="unit">minutes</div>
            </label>
            <label class="duration-option {{ old('duration_minutes') == '90' ? 'selected' : '' }}">
              <input type="radio" name="duration_minutes" value="90" {{ old('duration_minutes') == '90' ? 'checked' : '' }}>
              <div class="time">90</div>
              <div class="unit">minutes</div>
            </label>
            <label class="duration-option {{ old('duration_minutes') == '120' ? 'selected' : '' }}">
              <input type="radio" name="duration_minutes" value="120" {{ old('duration_minutes') == '120' ? 'checked' : '' }}>
              <div class="time">120</div>
              <div class="unit">minutes</div>
            </label>
          </div>
        </div>
      </div>

      <!-- Section 4: Meeting Details -->
      <div class="card form-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon">
              <i class="ri-video-add-line"></i>
            </div>
            <div>
              <h5>Meeting Details</h5>
              <small>Optional - Leave empty to auto-generate credentials</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-4">
            <div class="col-md-6">
              <div class="meeting-input">
                <label>Meeting Link</label>
                <input type="url" name="meeting_link" id="meeting_link" 
                       value="{{ old('meeting_link') }}" placeholder="https://meet.example.com/room-id">
                <small><i class="ri-information-line me-1"></i>Auto-generated if left empty</small>
              </div>
            </div>
            <div class="col-md-3">
              <div class="meeting-input">
                <label>Meeting ID</label>
                <input type="text" name="meeting_id" id="meeting_id" 
                       value="{{ old('meeting_id') }}" placeholder="Auto-generated">
              </div>
            </div>
            <div class="col-md-3">
              <div class="meeting-input">
                <label>Password</label>
                <input type="text" name="meeting_password" id="meeting_password" 
                       value="{{ old('meeting_password') }}" placeholder="Auto-generated">
              </div>
            </div>
            <div class="col-12">
              <div class="meeting-input">
                <label>Session Notes</label>
                <textarea name="session_notes" rows="3" placeholder="Add any special notes or instructions for this appointment...">{{ old('session_notes') }}</textarea>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="form-actions">
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-cancel">
              <i class="ri-close-line me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-submit">
              <i class="ri-calendar-check-line me-1"></i> Create Appointment
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Preview Sidebar -->
    <div class="col-lg-4">
      <div class="card preview-card">
        <div class="preview-header">
          <i class="ri-calendar-check-line"></i>
          <h5>Appointment Preview</h5>
          <small>Review before creating</small>
        </div>
        <div class="preview-body">
          <div class="preview-item">
            <span class="label"><i class="ri-user-heart-line"></i> Client</span>
            <span class="value" id="previewClient">Not selected</span>
          </div>
          <div class="preview-item">
            <span class="label"><i class="ri-user-star-line"></i> Therapist</span>
            <span class="value" id="previewTherapist">Not selected</span>
          </div>
          <div class="preview-item">
            <span class="label"><i class="ri-team-line"></i> Type</span>
            <span class="value" id="previewType">Individual</span>
          </div>
          <div class="preview-item">
            <span class="label"><i class="ri-webcam-line"></i> Mode</span>
            <span class="value" id="previewMode">Video</span>
          </div>
          <div class="preview-item">
            <span class="label"><i class="ri-calendar-line"></i> Date</span>
            <span class="value" id="previewDate">{{ date('M d, Y') }}</span>
          </div>
          <div class="preview-item">
            <span class="label"><i class="ri-time-line"></i> Time</span>
            <span class="value" id="previewTime">10:00 AM</span>
          </div>
          <div class="preview-item">
            <span class="label"><i class="ri-timer-line"></i> Duration</span>
            <span class="value" id="previewDuration">45 min</span>
          </div>
          <div class="preview-item">
            <span class="label"><i class="ri-checkbox-circle-line"></i> Status</span>
            <span class="value"><span class="badge bg-primary" id="previewStatus">Scheduled</span></span>
          </div>
        </div>
        <div class="preview-footer">
          <p><i class="ri-lightbulb-line"></i> Meeting credentials will be auto-generated</p>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // User Selection
  document.querySelectorAll('.user-option').forEach(option => {
    option.addEventListener('click', function() {
      const list = this.closest('.user-list');
      list.querySelectorAll('.user-option').forEach(o => o.classList.remove('selected'));
      this.classList.add('selected');
      this.querySelector('input').checked = true;
      updatePreview();
    });
  });

  // Option Cards
  document.querySelectorAll('.option-card').forEach(card => {
    card.addEventListener('click', function() {
      const name = this.querySelector('input').name;
      document.querySelectorAll(`input[name="${name}"]`).forEach(i => {
        i.closest('.option-card').classList.remove('selected');
      });
      this.classList.add('selected');
      this.querySelector('input').checked = true;
      updatePreview();
    });
  });

  // Duration Options
  document.querySelectorAll('.duration-option').forEach(opt => {
    opt.addEventListener('click', function() {
      document.querySelectorAll('.duration-option').forEach(o => o.classList.remove('selected'));
      this.classList.add('selected');
      this.querySelector('input').checked = true;
      updatePreview();
    });
  });

  // Search Users
  document.getElementById('searchClient')?.addEventListener('input', function() {
    filterUsers('clientsList', this.value);
  });
  document.getElementById('searchTherapist')?.addEventListener('input', function() {
    filterUsers('therapistsList', this.value);
  });

  function filterUsers(listId, term) {
    const list = document.getElementById(listId);
    const options = list.querySelectorAll('.user-option');
    const searchTerm = term.toLowerCase();
    options.forEach(opt => {
      opt.style.display = opt.dataset.search.includes(searchTerm) ? 'flex' : 'none';
    });
  }

  // Preview Updates
  document.getElementById('appointment_date')?.addEventListener('change', updatePreview);
  document.getElementById('appointment_time')?.addEventListener('change', updatePreview);
  document.querySelector('select[name="status"]')?.addEventListener('change', updatePreview);

  function updatePreview() {
    // Client
    const client = document.querySelector('input[name="client_id"]:checked');
    document.getElementById('previewClient').textContent = client 
      ? client.closest('.user-option').querySelector('h6').textContent 
      : 'Not selected';

    // Therapist
    const therapist = document.querySelector('input[name="therapist_id"]:checked');
    document.getElementById('previewTherapist').textContent = therapist 
      ? therapist.closest('.user-option').querySelector('h6').textContent 
      : 'Not selected';

    // Type
    const type = document.querySelector('input[name="appointment_type"]:checked');
    if (type) {
      document.getElementById('previewType').textContent = type.value.charAt(0).toUpperCase() + type.value.slice(1);
    }

    // Mode
    const mode = document.querySelector('input[name="session_mode"]:checked');
    if (mode) {
      document.getElementById('previewMode').textContent = mode.value.charAt(0).toUpperCase() + mode.value.slice(1);
    }

    // Date
    const dateInput = document.getElementById('appointment_date');
    if (dateInput?.value) {
      const d = new Date(dateInput.value);
      document.getElementById('previewDate').textContent = d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    // Time
    const timeInput = document.getElementById('appointment_time');
    if (timeInput?.value) {
      const [h, m] = timeInput.value.split(':');
      const hour = parseInt(h);
      const ampm = hour >= 12 ? 'PM' : 'AM';
      document.getElementById('previewTime').textContent = `${hour % 12 || 12}:${m} ${ampm}`;
    }

    // Duration
    const duration = document.querySelector('input[name="duration_minutes"]:checked');
    if (duration) {
      document.getElementById('previewDuration').textContent = duration.value + ' min';
    }

    // Status
    const status = document.querySelector('select[name="status"]');
    if (status) {
      document.getElementById('previewStatus').textContent = status.options[status.selectedIndex].text.replace(/[📅✅]/g, '').trim();
    }
  }

  // Initial preview
  updatePreview();
});
</script>
@endsection
