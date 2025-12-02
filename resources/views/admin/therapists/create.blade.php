@extends('layouts/contentNavbarLayout')

@section('title', 'Add New Therapist')

@section('page-style')
<style>
  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
  }

  .page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  .page-header h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
  }

  .page-header p {
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 0;
    position: relative;
    z-index: 1;
  }

  .header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: white;
    backdrop-filter: blur(10px);
  }

  /* Form Card */
  .form-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 1.5rem;
  }

  .form-card .card-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    border-bottom: 1px solid #e2e8f0;
    padding: 1.25rem 1.5rem;
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
    padding: 1.5rem;
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
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    border: 1px solid #fecaca;
    color: #991b1b;
    border-radius: 12px;
    padding: 1rem 1.25rem;
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

  .btn-cancel:hover {
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

  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
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
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div class="d-flex align-items-center gap-3">
      <div class="header-icon">
        <i class="ri-user-add-line"></i>
      </div>
      <div>
        <h4 class="mb-1">Add New Therapist</h4>
        <p class="mb-0">Create a new therapist account with profile details</p>
      </div>
    </div>
    <a href="{{ route('admin.therapists.index') }}" class="btn btn-light">
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
            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   id="name" name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                   id="email" name="email" value="{{ old('email') }}" placeholder="Enter email address" required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="password" class="form-control @error('password') is-invalid @enderror"
                     id="password" name="password" placeholder="Enter password" required>
              <button class="btn" type="button" id="togglePassword">
                <i class="ri-eye-off-line" id="passwordIcon"></i>
              </button>
            </div>
            @error('password')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            <div class="form-text">Minimum 8 characters</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="password" class="form-control"
                     id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
              <button class="btn" type="button" id="togglePasswordConfirm">
                <i class="ri-eye-off-line" id="passwordConfirmIcon"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                   id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number" required>
            @error('phone')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="profile_image" class="form-label">Profile Picture</label>
            <input type="file" class="form-control @error('profile_image') is-invalid @enderror"
                   id="profile_image" name="profile_image" accept="image/*">
            @error('profile_image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">JPEG, PNG, JPG, GIF, SVG - Max 2MB</div>
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
            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                   id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Enter first name" required>
            @error('first_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                   id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Enter last name" required>
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
                   id="experience_years" name="experience_years" value="{{ old('experience_years') }}" min="0" placeholder="0" required>
            @error('experience_years')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="consultation_fee" class="form-label">Consultation Fee (₹) <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('consultation_fee') is-invalid @enderror"
                   id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee') }}" min="0" step="0.01" placeholder="0.00" required>
            @error('consultation_fee')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="bio" class="form-label">Bio / About <span class="text-danger">*</span></label>
        <textarea class="form-control @error('bio') is-invalid @enderror"
                  id="bio" name="bio" rows="4" placeholder="Write a brief bio about the therapist..." required>{{ old('bio') }}</textarea>
        @error('bio')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="certifications" class="form-label">Certifications</label>
            <textarea class="form-control @error('certifications') is-invalid @enderror"
                      id="certifications" name="certifications" rows="3" placeholder="List certifications...">{{ old('certifications') }}</textarea>
            @error('certifications')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="education" class="form-label">Education</label>
            <textarea class="form-control @error('education') is-invalid @enderror"
                      id="education" name="education" rows="3" placeholder="Enter educational background...">{{ old('education') }}</textarea>
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
            <option value="{{ $specialization->id }}" {{ in_array($specialization->id, old('specializations', [])) ? 'selected' : '' }}>
              {{ $specialization->name }}
            </option>
          @endforeach
        </select>
        @error('specializations')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">Hold Ctrl/Cmd to select multiple specializations</div>
      </div>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="d-flex justify-content-end gap-3">
    <a href="{{ route('admin.therapists.index') }}" class="btn btn-cancel">
      <i class="ri-close-line me-2"></i>Cancel
    </a>
    <button type="submit" class="btn btn-submit">
      <i class="ri-save-line me-2"></i>Create Therapist
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
