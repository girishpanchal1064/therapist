@extends('layouts/contentNavbarLayout')

@section('title', 'User Details')

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

    <div class="card mt-3">
      <div class="card-header">
        <h6 class="card-title mb-0">Quick Actions</h6>
      </div>
      <div class="card-body">
        <div class="d-grid gap-2">
          <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
            <i class="ri-pencil-line me-2"></i>Edit User
          </a>

          @if($user->status === 'active')
            <form action="{{ route('admin.users.suspend', $user) }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Are you sure you want to suspend this user?')">
                <i class="ri-pause-line me-2"></i>Suspend User
              </button>
            </form>
          @else
            <form action="{{ route('admin.users.activate', $user) }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-success w-100" onclick="return confirm('Are you sure you want to activate this user?')">
                <i class="ri-play-line me-2"></i>Activate User
              </button>
            </form>
          @endif

          <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
              <i class="ri-delete-bin-line me-2"></i>Delete User
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">User Details</h5>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
          <i class="ri-arrow-left-line me-2"></i>Back to Users
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
                @if($user->roles->count() == 0)
                  <span class="text-muted">No roles assigned</span>
                @endif
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

        @if($user->date_of_birth || $user->gender || $user->address)
          <div class="card mt-4">
            <div class="card-header">
              <h6 class="card-title mb-0">Additional Information</h6>
            </div>
            <div class="card-body">
              <div class="row">
                @if($user->date_of_birth)
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Date of Birth</label>
                      <p class="form-control-plaintext">{{ $user->date_of_birth->format('F d, Y') }}</p>
                    </div>
                  </div>
                @endif

                @if($user->gender)
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Gender</label>
                      <p class="form-control-plaintext">{{ ucfirst($user->gender) }}</p>
                    </div>
                  </div>
                @endif
              </div>

              @if($user->address)
                <div class="mb-3">
                  <label class="form-label">Address</label>
                  <p class="form-control-plaintext">{{ $user->address }}</p>
                </div>
              @endif
            </div>
          </div>
        @endif
      </div>
    </div>

    <!-- User Activity -->
    <div class="card mt-3">
      <div class="card-header">
        <h6 class="card-title mb-0">Recent Activity</h6>
      </div>
      <div class="card-body">
        <div class="timeline">
          <div class="timeline-item">
            <div class="timeline-marker bg-primary"></div>
            <div class="timeline-content">
              <h6 class="timeline-title">Account Created</h6>
              <p class="timeline-text">{{ $user->created_at->format('F d, Y H:i') }}</p>
            </div>
          </div>

          @if($user->last_login_at)
            <div class="timeline-item">
              <div class="timeline-marker bg-success"></div>
              <div class="timeline-content">
                <h6 class="timeline-title">Last Login</h6>
                <p class="timeline-text">{{ $user->last_login_at->format('F d, Y H:i') }}</p>
              </div>
            </div>
          @endif

          @if($user->email_verified_at)
            <div class="timeline-item">
              <div class="timeline-marker bg-info"></div>
              <div class="timeline-content">
                <h6 class="timeline-title">Email Verified</h6>
                <p class="timeline-text">{{ $user->email_verified_at->format('F d, Y H:i') }}</p>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.timeline {
  position: relative;
  padding-left: 30px;
}

.timeline-item {
  position: relative;
  margin-bottom: 20px;
}

.timeline-marker {
  position: absolute;
  left: -35px;
  top: 5px;
  width: 10px;
  height: 10px;
  border-radius: 50%;
}

.timeline-content {
  background: #f8f9fa;
  padding: 15px;
  border-radius: 8px;
  border-left: 3px solid #dee2e6;
}

.timeline-title {
  margin: 0 0 5px 0;
  font-size: 14px;
  font-weight: 600;
  color: #495057;
}

.timeline-text {
  margin: 0;
  font-size: 12px;
  color: #6c757d;
}
</style>
@endsection
