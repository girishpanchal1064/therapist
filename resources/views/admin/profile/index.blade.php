@extends('layouts/contentNavbarLayout')

@section('title', 'My Profile')

@section('content')
<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body text-center">
        <div class="avatar avatar-xl mb-3">
          @if($user->avatar)
            <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="rounded-circle">
          @else
            <span class="avatar-initial rounded bg-primary">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
          @endif
        </div>
        <h5 class="card-title">{{ $user->name }}</h5>
        <p class="text-muted">{{ $user->email }}</p>

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

    <div class="card mt-3">
      <div class="card-header">
        <h6 class="card-title mb-0">Account Information</h6>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Member Since:</span>
          <span>{{ $user->created_at->format('M d, Y') }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Last Login:</span>
          <span>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Email Verified:</span>
          <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
            {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
          </span>
        </div>
        @if($user->phone)
          <div class="d-flex justify-content-between">
            <span class="text-muted">Phone:</span>
            <span>{{ $user->phone }}</span>
          </div>
        @endif
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Profile Information</h5>
        <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">
          <i class="ri-pencil-line me-2"></i>Edit Profile
        </a>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <p class="form-control-plaintext">{{ $user->name }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Email Address</label>
              <p class="form-control-plaintext">{{ $user->email }}</p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Phone Number</label>
              <p class="form-control-plaintext">{{ $user->phone ?: 'Not provided' }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Account Status</label>
              <p class="form-control-plaintext">
                <span class="badge bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'suspended' ? 'danger' : 'secondary') }}">
                  {{ ucfirst($user->status) }}
                </span>
              </p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">User Roles</label>
              <div>
                @foreach($user->roles as $role)
                  <span class="badge bg-primary me-1">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                @endforeach
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Member Since</label>
              <p class="form-control-plaintext">{{ $user->created_at->format('F d, Y') }}</p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Last Login</label>
              <p class="form-control-plaintext">{{ $user->last_login_at ? $user->last_login_at->format('F d, Y H:i') : 'Never' }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Email Verification</label>
              <p class="form-control-plaintext">
                <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                  {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                </span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Change Password Card -->
    <div class="card mt-3">
      <div class="card-header">
        <h6 class="card-title mb-0">Change Password</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.profile.password') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                       id="current_password" name="current_password" required>
                @error('current_password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="password" name="password" required>
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
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3 d-flex align-items-end">
                <button type="submit" class="btn btn-warning">
                  <i class="ri-lock-line me-2"></i>Change Password
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
