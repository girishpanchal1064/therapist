@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Profile')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Edit Profile</h5>
        <a href="{{ route('admin.profile.index') }}" class="btn btn-outline-secondary">
          <i class="ri-arrow-left-line me-2"></i>Back to Profile
        </a>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible" role="alert">
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                @error('phone')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="avatar" class="form-label">Profile Picture</label>
                <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                       id="avatar" name="avatar" accept="image/*">
                @error('avatar')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Upload a profile picture (JPEG, PNG, JPG, GIF, SVG - Max 2MB)</div>
              </div>
            </div>
          </div>

          <!-- Current Avatar Preview -->
          @if($user->avatar)
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Current Profile Picture</label>
                  <div class="d-flex align-items-center">
                    <img src="{{ Storage::url($user->avatar) }}" alt="Current Avatar" class="rounded-circle me-3" width="60" height="60">
                    <div>
                      <p class="mb-0 text-muted">Current profile picture</p>
                      <small class="text-muted">Upload a new image to replace it</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endif

          <!-- Password Change Section -->
          <div class="card mt-4">
            <div class="card-header">
              <h6 class="card-title mb-0">Change Password (Optional)</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                           id="current_password" name="current_password">
                    @error('current_password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Required only if changing password</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password">
                    @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('admin.profile.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">
              <i class="ri-save-line me-2"></i>Update Profile
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h6 class="card-title mb-0">Profile Preview</h6>
      </div>
      <div class="card-body text-center">
        <div class="avatar avatar-xl mb-3">
          @if($user->avatar)
            <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="rounded-circle" id="avatar-preview">
          @else
            <span class="avatar-initial rounded bg-primary" id="avatar-initial">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
          @endif
        </div>
        <h5 class="card-title" id="name-preview">{{ $user->name }}</h5>
        <p class="text-muted" id="email-preview">{{ $user->email }}</p>

        @foreach($user->roles as $role)
          <span class="badge bg-primary me-1">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
        @endforeach

        <div class="mt-3">
          <span class="badge bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'suspended' ? 'danger' : 'secondary') }}">
            {{ ucfirst($user->status) }}
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update preview when form fields change
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const avatarInput = document.getElementById('avatar');

    nameInput.addEventListener('input', function() {
        document.getElementById('name-preview').textContent = this.value;
        document.getElementById('avatar-initial').textContent = this.value.substring(0, 2).toUpperCase();
    });

    emailInput.addEventListener('input', function() {
        document.getElementById('email-preview').textContent = this.value;
    });

    avatarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    // Create new preview if it doesn't exist
                    const avatarDiv = document.querySelector('.avatar');
                    avatarDiv.innerHTML = '<img src="' + e.target.result + '" alt="Avatar" class="rounded-circle" id="avatar-preview">';
                }
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
