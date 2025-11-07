@extends('layouts/contentNavbarLayout')

@section('title', 'Therapist Dashboard')

@section('content')
<div class="row">
  <div class="col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-1">Welcome back, {{ auth()->user()->name }}!</h4>
        <p class="mb-0 text-muted">Here's your practice overview.</p>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="ri-calendar-line text-primary" style="font-size: 2rem;"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Today's Sessions</span>
        <h3 class="card-title mb-2">{{ $todayAppointments->count() }}</h3>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="ri-check-line text-success" style="font-size: 2rem;"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Completed This Month</span>
        <h3 class="card-title mb-2">{{ $completedThisMonth }}</h3>
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
        <span class="fw-semibold d-block mb-1">Monthly Earnings</span>
        <h3 class="card-title mb-2">₹{{ number_format($monthlyEarnings, 2) }}</h3>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="ri-star-line text-info" style="font-size: 2rem;"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Pending Reviews</span>
        <h3 class="card-title mb-2">{{ $pendingReviews }}</h3>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 col-lg-6 mb-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Today's Sessions</h5>
      </div>
      <div class="card-body">
        @if($todayAppointments->count() > 0)
          <div class="table-responsive">
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th>Client</th>
                  <th>Time</th>
                  <th>Mode</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($todayAppointments as $appointment)
                <tr>
                  <td class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                      <img src="{{ $appointment->client?->avatar ?? asset('default-avatar.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                    <div>
                      <h6 class="mb-0">{{ $appointment->client?->name ?? 'Unknown' }}</h6>
                    </div>
                  </td>
                  <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</td>
                  <td>{{ ucfirst($appointment->session_mode) }}</td>
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
          <p class="text-muted mb-0">No sessions today.</p>
        @endif
      </div>
    </div>
  </div>

  <div class="col-md-6 col-lg-6 mb-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Upcoming (Next 7 Days)</h5>
      </div>
      <div class="card-body">
        @if($upcomingAppointments->count() > 0)
          <div class="table-responsive">
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th>Client</th>
                  <th>Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($upcomingAppointments->take(5) as $appointment)
                <tr>
                  <td class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                      <img src="{{ $appointment->client?->avatar ?? asset('default-avatar.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                    <div>
                      <h6 class="mb-0">{{ $appointment->client?->name ?? 'Unknown' }}</h6>
                    </div>
                  </td>
                  <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }} {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</td>
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
          <p class="text-muted mb-0">No upcoming sessions.</p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
