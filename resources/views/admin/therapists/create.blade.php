@extends('layouts/contentNavbarLayout')

@section('title', 'Add New Therapist')

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
    color: #1e293b;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
  }

  .form-label .label-icon {
    color: #667eea;
    font-size: 1rem;
  }

  .form-label .required-star {
    color: #ef4444;
    margin-left: 0.125rem;
  }

  .form-control, .form-select {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.625rem 1rem;
    transition: all 0.2s ease;
    font-size: 0.9375rem;
    background: #ffffff;
    color: #1e293b;
  }

  .form-control::placeholder {
    color: #94a3b8;
    opacity: 0.7;
  }

  .form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
    outline: none;
    background: #ffffff;
  }

  .form-control.is-invalid, .form-select.is-invalid {
    border-color: #ef4444;
    background: #fef2f2;
  }

  .form-control.is-invalid:focus, .form-select.is-invalid:focus {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
  }

  .input-group .form-control {
    border-right: none;
  }

  .input-group .btn {
    border: 2px solid #e2e8f0;
    border-left: none;
    border-radius: 0 10px 10px 0;
    background: #f8fafc;
    color: #64748b;
  }

  .input-group .btn:hover {
    background: #e2e8f0;
    color: #334155;
  }

  .form-text {
    color: #64748b;
    font-size: 0.8125rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
  }

  .form-text::before {
    content: 'ℹ️';
    font-size: 0.875rem;
  }

  .invalid-feedback {
    display: block;
    color: #ef4444;
    font-size: 0.8125rem;
    margin-top: 0.375rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
  }

  .invalid-feedback::before {
    content: '⚠️';
    font-size: 0.875rem;
  }

  /* Avatar Preview */
  .avatar-upload-area {
    border: 2px dashed #e2e8f0;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: all 0.2s ease;
    cursor: pointer;
    background: #f8fafc;
  }

  .avatar-upload-area:hover {
    border-color: #667eea;
    background: #f5f3ff;
  }

  .avatar-upload-area .upload-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
  }

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

  /* Action Buttons */
  .action-buttons-wrapper {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding-top: 1.5rem;
    margin-top: 1.5rem;
    border-top: 2px solid #f0f2f5;
    flex-wrap: wrap;
  }

  .btn-cancel {
    background: white;
    border: 2px solid #e2e8f0;
    color: #64748b;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-cancel:hover {
    border-color: #cbd5e0;
    background: #f7fafc;
    color: #4a5568;
  }

  .btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
  }

  .btn-submit:active {
    transform: translateY(0);
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
    line-height: 1.6;
  }

  /* File Input */
  .form-control[type="file"] {
    padding: 0.5rem;
    cursor: pointer;
  }

  .form-control[type="file"]::file-selector-button {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    margin-right: 0.75rem;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .form-control[type="file"]::file-selector-button:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
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
        <i class="ri-user-add-line"></i>
      </div>
      <div>
        <h4 class="mb-1">Add New Therapist</h4>
        <p class="mb-0">Create a new therapist account with profile details</p>
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

<form action="{{ route('admin.therapists.store') }}" method="POST" enctype="multipart/form-data">
  @csrf

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
            <label for="name" class="form-label">
              <i class="ri-user-line label-icon"></i>
              Full Name
              <span class="required-star">*</span>
            </label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   id="name" name="name" value="{{ old('name') }}" placeholder="e.g., John Doe" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Enter the therapist's full name</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="email" class="form-label">
              <i class="ri-mail-line label-icon"></i>
              Email Address
              <span class="required-star">*</span>
            </label>
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                   id="email" name="email" value="{{ old('email') }}" placeholder="e.g., john.doe@example.com" required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Used for login and notifications</div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="password" class="form-label">
              <i class="ri-lock-password-line label-icon"></i>
              Password
              <span class="required-star">*</span>
            </label>
            <div class="input-group">
              <input type="password" class="form-control @error('password') is-invalid @enderror"
                     id="password" name="password" placeholder="Enter secure password" required>
              <button class="btn" type="button" id="togglePassword">
                <i class="ri-eye-off-line" id="passwordIcon"></i>
              </button>
            </div>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Minimum 8 characters with letters and numbers</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="password_confirmation" class="form-label">
              <i class="ri-lock-2-line label-icon"></i>
              Confirm Password
              <span class="required-star">*</span>
            </label>
            <div class="input-group">
              <input type="password" class="form-control"
                     id="password_confirmation" name="password_confirmation" placeholder="Re-enter password" required>
              <button class="btn" type="button" id="togglePasswordConfirm">
                <i class="ri-eye-off-line" id="passwordConfirmIcon"></i>
              </button>
            </div>
            <div class="form-text">Must match the password above</div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="phone" class="form-label">
              <i class="ri-phone-line label-icon"></i>
              Phone Number
              <span class="required-star">*</span>
            </label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                   id="phone" name="phone" value="{{ old('phone') }}" placeholder="e.g., +91 9876543210" required>
            @error('phone')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Include country code if applicable</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="profile_image" class="form-label">
              <i class="ri-image-line label-icon"></i>
              Profile Picture
            </label>
            <input type="file" class="form-control @error('profile_image') is-invalid @enderror"
                   id="profile_image" name="profile_image" accept="image/*">
            @error('profile_image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">JPEG, PNG, JPG, GIF, SVG - Max 2MB (Optional)</div>
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
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="first_name" class="form-label">
              <i class="ri-user-3-line label-icon"></i>
              First Name
              <span class="required-star">*</span>
            </label>
            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                   id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="e.g., John" required>
            @error('first_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="last_name" class="form-label">
              <i class="ri-user-3-line label-icon"></i>
              Last Name
              <span class="required-star">*</span>
            </label>
            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                   id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="e.g., Doe" required>
            @error('last_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="experience_years" class="form-label">
              <i class="ri-star-line label-icon"></i>
              Experience (Years)
              <span class="required-star">*</span>
            </label>
            <input type="number" class="form-control @error('experience_years') is-invalid @enderror"
                   id="experience_years" name="experience_years" value="{{ old('experience_years') }}" min="0" placeholder="e.g., 5" required>
            @error('experience_years')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Years of professional experience</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="consultation_fee" class="form-label">
              <i class="ri-money-rupee-circle-line label-icon"></i>
              Consultation Fee (₹)
              <span class="required-star">*</span>
            </label>
            <input type="number" class="form-control @error('consultation_fee') is-invalid @enderror"
                   id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee') }}" min="0" step="0.01" placeholder="e.g., 1500.00" required>
            @error('consultation_fee')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Per session consultation fee in INR</div>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="bio" class="form-label">
          <i class="ri-file-text-line label-icon"></i>
          Bio / About
          <span class="required-star">*</span>
        </label>
        <textarea class="form-control @error('bio') is-invalid @enderror"
                  id="bio" name="bio" rows="4" placeholder="Write a brief bio about the therapist's background, expertise, and approach..." required>{{ old('bio') }}</textarea>
        @error('bio')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">Brief professional biography (recommended: 100-200 words)</div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="certifications" class="form-label">
              <i class="ri-award-line label-icon"></i>
              Certifications
            </label>
            <textarea class="form-control @error('certifications') is-invalid @enderror"
                      id="certifications" name="certifications" rows="3" placeholder="e.g., Licensed Clinical Psychologist, CBT Certified...">{{ old('certifications') }}</textarea>
            @error('certifications')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">List professional certifications (Optional)</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="education" class="form-label">
              <i class="ri-graduation-cap-line label-icon"></i>
              Education
            </label>
            <textarea class="form-control @error('education') is-invalid @enderror"
                      id="education" name="education" rows="3" placeholder="e.g., M.A. in Psychology, Ph.D. in Clinical Psychology...">{{ old('education') }}</textarea>
            @error('education')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Educational qualifications and degrees (Optional)</div>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="specializations" class="form-label">
          <i class="ri-focus-3-line label-icon"></i>
          Specializations
          <span class="required-star">*</span>
        </label>
        <select class="form-select @error('specializations') is-invalid @enderror"
                id="specializations" name="specializations[]" multiple required>
          @foreach($specializations as $specialization)
            <option value="{{ $specialization->id }}" {{ in_array($specialization->id, old('specializations', [])) ? 'selected' : '' }}>
              {{ $specialization->name }}
            </option>
          @endforeach
        </select>
        @error('specializations')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">Hold Ctrl (Windows) or Cmd (Mac) to select multiple specializations</div>
      </div>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="action-buttons-wrapper">
    <a href="{{ route('admin.therapists.index') }}" class="btn-cancel">
      <i class="ri-close-line"></i> Cancel
    </a>
    <button type="submit" class="btn-submit">
      <i class="ri-save-line"></i> Create Therapist
    </button>
  </div>
</form>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle password visibility toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('passwordIcon');

    if (togglePassword && passwordInput && passwordIcon) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            passwordIcon.className = type === 'password' ? 'ri-eye-off-line' : 'ri-eye-line';
        });
    }

    // Handle confirm password visibility toggle
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const passwordConfirmIcon = document.getElementById('passwordConfirmIcon');

    if (togglePasswordConfirm && passwordConfirmInput && passwordConfirmIcon) {
        togglePasswordConfirm.addEventListener('click', function() {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);
            passwordConfirmIcon.className = type === 'password' ? 'ri-eye-off-line' : 'ri-eye-line';
        });
    }
});
</script>
@endsection
