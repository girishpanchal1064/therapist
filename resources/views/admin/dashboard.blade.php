@extends('layouts/contentNavbarLayout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
  <!-- Statistics Cards -->
  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="ri-user-line text-primary" style="font-size: 2rem;"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Total Users</span>
        <h3 class="card-title mb-2">{{ $stats['total_users'] }}</h3>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="ri-user-heart-line text-info" style="font-size: 2rem;"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Total Therapists</span>
        <h3 class="card-title mb-2">{{ $stats['total_therapists'] }}</h3>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="ri-calendar-check-line text-success" style="font-size: 2rem;"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Total Appointments</span>
        <h3 class="card-title mb-2">{{ $stats['total_appointments'] }}</h3>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="ri-money-dollar-circle-line text-warning" style="font-size: 2rem;"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Monthly Revenue</span>
        <h3 class="card-title mb-2">${{ number_format($stats['monthly_revenue'], 2) }}</h3>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Recent Appointments -->
  <div class="col-md-6 col-lg-6 mb-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Recent Appointments</h5>
        <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
      </div>
      <div class="card-body">
        @if($recent_appointments->count() > 0)
          <div class="table-responsive">
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th>Client</th>
                  <th>Therapist</th>
                  <th>Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recent_appointments as $appointment)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar avatar-sm me-2">
                        <img src="{{ $appointment->client->avatar }}" alt="Avatar" class="rounded-circle">
                      </div>
                      <div>
                        <h6 class="mb-0">{{ $appointment->client->name }}</h6>
                      </div>
                    </div>
                  </td>
                  <td>{{ $appointment->therapist->name }}</td>
                  <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                  <td>
                    <span class="badge bg-{{ $appointment->status === 'completed' ? 'success' : ($appointment->status === 'scheduled' ? 'warning' : 'secondary') }}">
                      {{ ucfirst($appointment->status) }}
                    </span>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <p class="text-muted">No recent appointments found.</p>
        @endif
      </div>
    </div>
  </div>

  <!-- Recent Users -->
  <div class="col-md-6 col-lg-6 mb-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Recent Users</h5>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
      </div>
      <div class="card-body">
        @if($recent_users->count() > 0)
          <div class="table-responsive">
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recent_users as $user)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar avatar-sm me-2">
                        <img src="{{ $user->avatar }}" alt="Avatar" class="rounded-circle">
                      </div>
                      <div>
                        <h6 class="mb-0">{{ $user->name }}</h6>
                      </div>
                    </div>
                  </td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @foreach($user->roles as $role)
                      <span class="badge bg-primary">{{ ucfirst($role->name) }}</span>
                    @endforeach
                  </td>
                  <td>
                    <span class="badge bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'suspended' ? 'danger' : 'secondary') }}">
                      {{ ucfirst($user->status) }}
                    </span>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <p class="text-muted">No recent users found.</p>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Quick Actions -->
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Quick Actions</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3 col-sm-6 mb-3">
            <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary w-100">
              <i class="ri-user-add-line me-2"></i>Add User
            </a>
          </div>
          <div class="col-md-3 col-sm-6 mb-3">
            <a href="{{ route('admin.therapists.create') }}" class="btn btn-outline-info w-100">
              <i class="ri-user-heart-line me-2"></i>Add Therapist
            </a>
          </div>
          <div class="col-md-3 col-sm-6 mb-3">
            <a href="{{ route('admin.appointments.create') }}" class="btn btn-outline-success w-100">
              <i class="ri-calendar-check-line me-2"></i>Schedule Appointment
            </a>
          </div>
          <div class="col-md-3 col-sm-6 mb-3">
            <a href="{{ route('admin.blog.create') }}" class="btn btn-outline-warning w-100">
              <i class="ri-article-line me-2"></i>Create Blog Post
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
