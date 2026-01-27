@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Therapist')

@section('page-style')
<style>
  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 14px;
    padding: 1.25rem 1.75rem;
    margin-bottom: 1.25rem;
    position: relative;
    overflow: hidden;
  }

  .page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  .page-header::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 150px;
    height: 150px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
  }

  .header-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    backdrop-filter: blur(10px);
  }

  .page-header h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 0.25rem;
    position: relative;
    z-index: 1;
    font-size: 1.35rem;
  }

  .page-header p {
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 0;
    position: relative;
    z-index: 1;
    font-size: 0.875rem;
  }

  /* Form Card */
  .form-card {
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 1.25rem;
    background: white;
  }

  .form-card .card-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    border-bottom: 2px solid #e2e8f0;
    padding: 1rem 1.25rem;
  }

  .form-card .card-header h6 {
    font-weight: 600;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
  }

  .form-card .card-header .header-icon-sm {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);
  }

  .form-card .card-body {
    padding: 1.25rem 1.5rem;
  }

  .form-card .card-body > .row {
    margin-top: 20px;
  }

  .form-card .card-body > .row:first-child {
    margin-top: 0;
  }

  /* Form Styling */
  .form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
  }

  .form-control, .form-select {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
    font-size: 0.9375rem;
  }

  .form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
  }

  .form-control.is-invalid, .form-select.is-invalid {
    border-color: #ef4444;
  }

  .form-text {
    color: #64748b;
    font-size: 0.8125rem;
    margin-top: 0.5rem;
  }

  /* Current Avatar */
  .current-avatar {
    width: 100px;
    height: 100px;
    border-radius: 16px;
    object-fit: cover;
    border: 3px solid #e2e8f0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .current-avatar-placeholder {
    width: 100px;
    height: 100px;
    border-radius: 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: 700;
    border: 3px solid #e2e8f0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  /* Status Select */
  .status-select {
    position: relative;
  }

  .status-select .form-select {
    padding-left: 2.5rem;
  }

  .status-indicator {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 10px;
    height: 10px;
    border-radius: 50%;
    z-index: 5;
  }

  .status-indicator.active { background: #22c55e; }
  .status-indicator.inactive { background: #94a3b8; }
  .status-indicator.suspended { background: #ef4444; }

  /* Alert Styling */
  .alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: none;
    border-left: 5px solid #ef4444;
    color: #991b1b;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.1);
  }

  .alert-warning {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: none;
    border-left: 5px solid #f59e0b;
    color: #92400e;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.1);
  }

  /* Action Buttons */
  .btn-cancel {
    background: #f1f5f9;
    border: 2px solid #e2e8f0;
    color: #475569;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.2s ease;
  }

  .btn-cancel:active {
    background: #e2e8f0;
    border-color: #cbd5e1;
    color: #334155;
  }

  .btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }

  .btn-submit:active {
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    color: white;
  }

  /* Select2 Style for Multi-select */
  .form-select[multiple] {
    min-height: 120px;
    padding: 0.5rem;
  }

  .form-select[multiple] option {
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    margin-bottom: 0.25rem;
  }

  .form-select[multiple] option:checked {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
  }

  /* Textarea */
  textarea.form-control {
    resize: vertical;
    min-height: 100px;
  }

  /* Required field indicator */
  .text-danger {
    color: #ef4444 !important;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 position-relative" style="z-index: 1;">
    <div class="d-flex align-items-center gap-3">
      <div class="header-icon">
        <i class="ri-user-settings-line"></i>
      </div>
      <div>
        <h4 class="mb-1">Edit Therapist</h4>
        <p class="mb-0">Update therapist account and profile information</p>
      </div>
    </div>
    <a href="{{ route('admin.therapists.index') }}" class="btn" style="background: rgba(255, 255, 255, 0.2); border: 2px solid rgba(255, 255, 255, 0.3); color: white; padding: 0.6rem 1.25rem; border-radius: 10px; font-weight: 600; font-size: 0.9rem; transition: all 0.3s ease; backdrop-filter: blur(10px);">
      <i class="ri-arrow-left-line me-2"></i>Back to List
    </a>
  </div>
</div>

@if($errors->any())
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-start gap-2">
      <i class="ri-error-warning-line fs-5 mt-1"></i>
      <div>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<form action="{{ route('admin.therapists.update', $therapist) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <!-- Account Information -->
  <div class="card form-card">
    <div class="card-header">
      <h6>
        <span class="header-icon-sm"><i class="ri-user-line"></i></span>
        Account Information
      </h6>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   id="name" name="name" value="{{ old('name', $therapist->name) }}" placeholder="Enter full name" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                   id="email" name="email" value="{{ old('email', $therapist->email) }}" placeholder="Enter email address" required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                   id="phone" name="phone" value="{{ old('phone', $therapist->phone) }}" placeholder="Enter phone number" required>
            @error('phone')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
              <option value="">Select Status</option>
              <option value="active" {{ old('status', $therapist->status) == 'active' ? 'selected' : '' }}>🟢 Active</option>
              <option value="inactive" {{ old('status', $therapist->status) == 'inactive' ? 'selected' : '' }}>⚪ Inactive</option>
              <option value="suspended" {{ old('status', $therapist->status) == 'suspended' ? 'selected' : '' }}>🔴 Suspended</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="row align-items-end">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="profile_image" class="form-label">Profile Picture</label>
            <input type="file" class="form-control @error('profile_image') is-invalid @enderror"
                   id="profile_image" name="profile_image" accept="image/*">
            @error('profile_image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Upload a new picture to replace the current one</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Current Avatar</label>
            <div>
              @if($therapist->therapistProfile && $therapist->therapistProfile->profile_image)
                <img src="{{ asset('storage/' . $therapist->therapistProfile->profile_image) }}" alt="Current Avatar" class="current-avatar">
              @elseif($therapist->avatar)
                <img src="{{ asset('storage/' . $therapist->avatar) }}" alt="Current Avatar" class="current-avatar">
              @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($therapist->name) }}&background=667eea&color=fff&size=200&bold=true&format=svg" alt="Default Avatar" class="current-avatar">
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Profile Information -->
  <div class="card form-card">
    <div class="card-header">
      <h6>
        <span class="header-icon-sm"><i class="ri-profile-line"></i></span>
        Profile Information
      </h6>
    </div>
    <div class="card-body">
      @if($therapist->therapistProfile)
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                     id="first_name" name="first_name" value="{{ old('first_name', $therapist->therapistProfile->first_name) }}" placeholder="Enter first name" required>
              @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                     id="last_name" name="last_name" value="{{ old('last_name', $therapist->therapistProfile->last_name) }}" placeholder="Enter last name" required>
              @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="experience_years" class="form-label">Experience (Years) <span class="text-danger">*</span></label>
              <input type="number" class="form-control @error('experience_years') is-invalid @enderror"
                     id="experience_years" name="experience_years" value="{{ old('experience_years', $therapist->therapistProfile->experience_years) }}" min="0" placeholder="0" required>
              @error('experience_years')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="consultation_fee" class="form-label">Consultation Fee (₹) <span class="text-danger">*</span></label>
              <input type="number" class="form-control @error('consultation_fee') is-invalid @enderror"
                     id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee', $therapist->therapistProfile->consultation_fee) }}" min="0" step="0.01" placeholder="0.00" required>
              @error('consultation_fee')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="bio" class="form-label">Bio / About <span class="text-danger">*</span></label>
          <textarea class="form-control @error('bio') is-invalid @enderror"
                    id="bio" name="bio" rows="4" placeholder="Write a brief bio about the therapist..." required>{{ old('bio', $therapist->therapistProfile->bio) }}</textarea>
          @error('bio')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="certifications" class="form-label">Certifications</label>
              <textarea class="form-control @error('certifications') is-invalid @enderror"
                        id="certifications" name="certifications" rows="3" placeholder="List certifications...">{{ old('certifications', $therapist->therapistProfile->certifications) }}</textarea>
              @error('certifications')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="education" class="form-label">Education</label>
              <textarea class="form-control @error('education') is-invalid @enderror"
                        id="education" name="education" rows="3" placeholder="Enter educational background...">{{ old('education', $therapist->therapistProfile->education) }}</textarea>
              @error('education')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="specializations" class="form-label">Specializations <span class="text-danger">*</span></label>
          <select class="form-select @error('specializations') is-invalid @enderror"
                  id="specializations" name="specializations[]" multiple required>
            @foreach($specializations as $specialization)
              <option value="{{ $specialization->id }}"
                      {{ in_array($specialization->id, old('specializations', $therapist->therapistProfile->specializations->pluck('id')->toArray())) ? 'selected' : '' }}>
                {{ $specialization->name }}
              </option>
            @endforeach
          </select>
          @error('specializations')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <div class="form-text">Hold Ctrl/Cmd to select multiple specializations</div>
        </div>
      @else
        <div class="alert alert-warning">
          <div class="d-flex align-items-center gap-2">
            <i class="ri-alert-line fs-5"></i>
            <div>
              <strong>No therapist profile found.</strong>
              <p class="mb-0 small">Please create a therapist profile first before editing.</p>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="d-flex justify-content-end gap-3">
    <a href="{{ route('admin.therapists.index') }}" class="btn btn-cancel">
      <i class="ri-close-line me-2"></i>Cancel
    </a>
    <button type="submit" class="btn btn-submit">
      <i class="ri-save-line me-2"></i>Update Therapist
    </button>
  </div>
</form>
@endsection
