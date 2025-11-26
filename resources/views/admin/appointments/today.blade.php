@extends('layouts/contentNavbarLayout')

@section('title', "Today's Appointments")

@section('vendor-style')
<style>
  .stats-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 12px;
    overflow: hidden;
  }
  .stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  }
  .stats-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.5rem;
  }
  .appointment-card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
  }
  .appointment-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
  }
  .appointment-row {
    transition: all 0.2s ease;
    border-left: 4px solid transparent;
  }
  .appointment-row:hover {
    background-color: rgba(105, 108, 255, 0.04);
  }
  .appointment-row.status-scheduled { border-left-color: #696cff; }
  .appointment-row.status-confirmed { border-left-color: #28c76f; }
  .appointment-row.status-in_progress { border-left-color: #ff9f43; }
  .appointment-row.status-completed { border-left-color: #82868b; }
  .appointment-row.status-cancelled { border-left-color: #ea5455; }
  .appointment-row.status-no_show { border-left-color: #ff9f43; }
  
  .mode-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .mode-video { background: rgba(105, 108, 255, 0.12); color: #696cff; }
  .mode-audio { background: rgba(40, 199, 111, 0.12); color: #28c76f; }
  .mode-chat { background: rgba(255, 159, 67, 0.12); color: #ff9f43; }
  
  .status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .quick-action-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    border: none;
  }
  .quick-action-btn:hover { transform: scale(1.1); }
  
  .empty-state {
    padding: 60px 20px;
    text-align: center;
  }
  .empty-state-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
  }
  .empty-state-icon i { font-size: 3rem; color: #a1a1a1; }
  
  .payment-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
  }
  .payment-paid { background: rgba(40, 199, 111, 0.12); color: #28c76f; }
  .payment-unpaid { background: rgba(255, 159, 67, 0.12); color: #ff9f43; }
  
  .table-modern { 
    border-collapse: separate; 
    border-spacing: 0 8px; 
  }
  .table-modern thead th {
    border: none;
    background: transparent;
    font-weight: 600;
    color: #566a7f;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 16px;
  }
  .table-modern tbody tr {
    background: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    border-radius: 10px;
  }
  .table-modern tbody td {
    border: none;
    padding: 16px;
    vertical-align: middle;
  }
  .table-modern tbody td:first-child { border-radius: 10px 0 0 10px; }
  .table-modern tbody td:last-child { border-radius: 0 10px 10px 0; }
  
  .user-info {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
  }
  .user-avatar-initials {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
  }
  .user-details h6 { margin: 0; font-size: 0.9rem; font-weight: 600; }
  .user-details small { color: #697a8d; font-size: 0.75rem; }
  
  .time-display {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .time-display .time {
    font-size: 1.1rem;
    font-weight: 700;
    color: #566a7f;
  }
  .time-display .period {
    font-size: 0.7rem;
    color: #8f9bb3;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .duration-badge {
    background: #f5f5f9;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    color: #566a7f;
  }

  .live-indicator {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: linear-gradient(135deg, #ea5455 0%, #ff6b6b 100%);
    color: white;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    animation: pulse 2s infinite;
  }
  .live-indicator::before {
    content: '';
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
    animation: blink 1s infinite;
  }
  @keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(234, 84, 85, 0.4); }
    50% { box-shadow: 0 0 0 10px rgba(234, 84, 85, 0); }
  }
  @keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
  }

  .current-time-bar {
    background: linear-gradient(to right, rgba(255, 159, 67, 0.1), transparent);
    border-left: 4px solid #ff9f43;
    padding: 12px 20px;
    border-radius: 0 8px 8px 0;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .current-time-bar i { color: #ff9f43; font-size: 1.2rem; }
  .current-time-bar span { font-weight: 600; color: #ff9f43; }
</style>
@endsection

@section('content')
@php
  $totalToday = $appointments->total();
  $completedCount = $appointments->where('status', 'completed')->count();
  $upcomingCount = $appointments->whereIn('status', ['scheduled', 'confirmed'])->count();
  $inProgressCount = $appointments->where('status', 'in_progress')->count();
  $cancelledCount = $appointments->where('status', 'cancelled')->count();
@endphp

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
  <div>
    <h4 class="fw-bold mb-1">
      <i class="ri-calendar-todo-line me-2 text-primary"></i>Today's Appointments
    </h4>
    <p class="text-muted mb-0">{{ now()->format('l, F d, Y') }} • Manage today's therapy sessions</p>
  </div>
  <div class="d-flex gap-2 flex-wrap">
    <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
      <i class="ri-list-check me-1"></i> All Appointments
    </a>
    <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
      <i class="ri-add-line me-1"></i> New Appointment
    </a>
  </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-muted mb-1 small text-uppercase fw-semibold">Total Today</p>
            <h3 class="fw-bold mb-0">{{ $totalToday }}</h3>
            <small class="text-primary"><i class="ri-calendar-line me-1"></i>Sessions scheduled</small>
          </div>
          <div class="stats-icon bg-label-primary">
            <i class="ri-calendar-check-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-muted mb-1 small text-uppercase fw-semibold">In Progress</p>
            <h3 class="fw-bold mb-0">{{ $inProgressCount }}</h3>
            <small class="text-warning"><i class="ri-loader-4-line me-1"></i>Currently active</small>
          </div>
          <div class="stats-icon bg-label-warning">
            <i class="ri-video-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-muted mb-1 small text-uppercase fw-semibold">Completed</p>
            <h3 class="fw-bold mb-0">{{ $completedCount }}</h3>
            <small class="text-success"><i class="ri-check-double-line me-1"></i>Sessions done</small>
          </div>
          <div class="stats-icon bg-label-success">
            <i class="ri-checkbox-circle-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-muted mb-1 small text-uppercase fw-semibold">Upcoming</p>
            <h3 class="fw-bold mb-0">{{ $upcomingCount }}</h3>
            <small class="text-info"><i class="ri-time-line me-1"></i>Waiting to start</small>
          </div>
          <div class="stats-icon bg-label-info">
            <i class="ri-calendar-schedule-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Alerts -->
@if(session('success'))
  <div class="alert alert-success alert-dismissible d-flex align-items-center mb-4" role="alert">
    <span class="alert-icon rounded-circle"><i class="ri-checkbox-circle-line ri-22px"></i></span>
    <span>{{ session('success') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible d-flex align-items-center mb-4" role="alert">
    <span class="alert-icon rounded-circle"><i class="ri-error-warning-line ri-22px"></i></span>
    <span>{{ session('error') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Quick Status Filters -->
<div class="mb-4">
  <div class="d-flex gap-2 flex-wrap">
    <a href="{{ route('admin.appointments.today') }}" class="btn btn-sm btn-primary">
      <i class="ri-list-check me-1"></i> All ({{ $totalToday }})
    </a>
    @if($inProgressCount > 0)
      <span class="btn btn-sm btn-warning">
        <i class="ri-loader-4-line me-1"></i> Live Now ({{ $inProgressCount }})
      </span>
    @endif
    <span class="btn btn-sm btn-outline-success">
      <i class="ri-checkbox-circle-line me-1"></i> Completed ({{ $completedCount }})
    </span>
    <span class="btn btn-sm btn-outline-info">
      <i class="ri-time-line me-1"></i> Upcoming ({{ $upcomingCount }})
    </span>
    @if($cancelledCount > 0)
      <span class="btn btn-sm btn-outline-danger">
        <i class="ri-close-circle-line me-1"></i> Cancelled ({{ $cancelledCount }})
      </span>
    @endif
  </div>
</div>

<!-- Appointments Table -->
<div class="card appointment-card">
  <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
    <div>
      <h5 class="card-title mb-0">Today's Sessions</h5>
      <small class="text-muted">{{ $totalToday }} appointments for {{ now()->format('F d, Y') }}</small>
    </div>
    <div class="d-flex gap-2">
      <button type="button" class="btn btn-sm btn-outline-primary" onclick="location.reload()">
        <i class="ri-refresh-line me-1"></i> Refresh
      </button>
    </div>
  </div>
  
  @if($appointments->count() > 0)
    <div class="card-body pb-0">
      <!-- Current Time Bar -->
      <div class="current-time-bar">
        <i class="ri-time-line"></i>
        <span>Current Time: {{ now()->format('g:i A') }}</span>
      </div>
    </div>
    
    <div class="table-responsive">
      <table class="table table-modern mb-0">
        <thead>
          <tr>
            <th>Time</th>
            <th>Client</th>
            <th>Therapist</th>
            <th>Session Details</th>
            <th>Status</th>
            <th>Payment</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($appointments->sortBy('appointment_time') as $appointment)
            @php
              $statusColors = [
                'scheduled' => 'primary',
                'confirmed' => 'success',
                'in_progress' => 'warning',
                'completed' => 'secondary',
                'cancelled' => 'danger',
                'no_show' => 'warning'
              ];
              $statusIcons = [
                'scheduled' => 'ri-calendar-line',
                'confirmed' => 'ri-check-line',
                'in_progress' => 'ri-loader-4-line',
                'completed' => 'ri-checkbox-circle-line',
                'cancelled' => 'ri-close-circle-line',
                'no_show' => 'ri-user-unfollow-line'
              ];
              $modeIcons = ['video' => 'ri-video-line', 'audio' => 'ri-phone-line', 'chat' => 'ri-message-3-line'];
              $typeIcons = ['individual' => 'ri-user-line', 'couple' => 'ri-group-line', 'family' => 'ri-parent-line'];
              $appointmentTime = \Carbon\Carbon::parse($appointment->appointment_time);
              $isLive = $appointment->status === 'in_progress';
            @endphp
            <tr class="appointment-row status-{{ $appointment->status }}">
              <td>
                <div class="time-display">
                  <span class="time">{{ $appointmentTime->format('g:i') }}</span>
                  <span class="period">{{ $appointmentTime->format('A') }}</span>
                </div>
              </td>
              <td>
                <div class="user-info">
                  @if($appointment->client && $appointment->client->getRawOriginal('avatar'))
                    <img src="{{ $appointment->client->avatar }}" alt="{{ $appointment->client->name }}" class="user-avatar">
                  @else
                    <div class="user-avatar-initials bg-label-primary">
                      {{ $appointment->client ? strtoupper(substr($appointment->client->name, 0, 2)) : 'NA' }}
                    </div>
                  @endif
                  <div class="user-details">
                    <h6>{{ $appointment->client->name ?? 'N/A' }}</h6>
                    <small>{{ $appointment->client->email ?? 'N/A' }}</small>
                  </div>
                </div>
              </td>
              <td>
                <div class="user-info">
                  @if($appointment->therapist && $appointment->therapist->getRawOriginal('avatar'))
                    <img src="{{ $appointment->therapist->avatar }}" alt="{{ $appointment->therapist->name }}" class="user-avatar">
                  @else
                    <div class="user-avatar-initials bg-label-success">
                      {{ $appointment->therapist ? strtoupper(substr($appointment->therapist->name, 0, 2)) : 'NA' }}
                    </div>
                  @endif
                  <div class="user-details">
                    <h6>{{ $appointment->therapist->name ?? 'N/A' }}</h6>
                    <small>{{ $appointment->therapist->therapistProfile->qualification ?? 'Therapist' }}</small>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-flex flex-column gap-1">
                  <span class="mode-badge mode-{{ $appointment->session_mode }}">
                    <i class="{{ $modeIcons[$appointment->session_mode] ?? 'ri-question-line' }}"></i>
                    {{ ucfirst($appointment->session_mode) }}
                  </span>
                  <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-label-info text-capitalize">
                      <i class="{{ $typeIcons[$appointment->appointment_type] ?? 'ri-user-line' }} me-1"></i>
                      {{ $appointment->appointment_type }}
                    </span>
                    <span class="duration-badge">
                      <i class="ri-timer-line me-1"></i>{{ $appointment->duration_minutes }}m
                    </span>
                  </div>
                </div>
              </td>
              <td>
                @if($isLive)
                  <span class="live-indicator">Live Now</span>
                @else
                  <span class="status-badge bg-label-{{ $statusColors[$appointment->status] ?? 'secondary' }}">
                    <i class="{{ $statusIcons[$appointment->status] ?? 'ri-question-line' }} me-1"></i>
                    {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                  </span>
                @endif
              </td>
              <td>
                @if($appointment->payment && $appointment->payment->status === 'completed')
                  <span class="payment-status payment-paid">
                    <i class="ri-checkbox-circle-fill"></i> Paid
                  </span>
                @else
                  <span class="payment-status payment-unpaid">
                    <i class="ri-time-line"></i> Unpaid
                  </span>
                @endif
              </td>
              <td>
                <div class="d-flex justify-content-center gap-1">
                  @if($isLive && $appointment->meeting_link)
                    <a href="{{ $appointment->meeting_link }}" target="_blank" 
                       class="btn btn-sm btn-success" 
                       data-bs-toggle="tooltip" 
                       title="Join Session">
                      <i class="ri-video-add-line me-1"></i> Join
                    </a>
                  @endif
                  
                  <a href="{{ route('admin.appointments.show', $appointment) }}" 
                     class="quick-action-btn btn-label-primary" 
                     data-bs-toggle="tooltip" 
                     title="View Details">
                    <i class="ri-eye-line"></i>
                  </a>
                  <a href="{{ route('admin.appointments.edit', $appointment) }}" 
                     class="quick-action-btn btn-label-info" 
                     data-bs-toggle="tooltip" 
                     title="Edit">
                    <i class="ri-pencil-line"></i>
                  </a>
                  @if(in_array($appointment->status, ['scheduled', 'confirmed']))
                    <form action="{{ route('admin.appointments.complete', $appointment) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" 
                              class="quick-action-btn btn-label-success" 
                              data-bs-toggle="tooltip" 
                              title="Mark Complete">
                        <i class="ri-check-line"></i>
                      </button>
                    </form>
                    <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel this appointment?')">
                      @csrf
                      <button type="submit" 
                              class="quick-action-btn btn-label-danger" 
                              data-bs-toggle="tooltip" 
                              title="Cancel">
                        <i class="ri-close-line"></i>
                      </button>
                    </form>
                  @endif
                  <div class="dropdown d-inline">
                    <button type="button" class="quick-action-btn btn-label-secondary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="ri-more-2-fill"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      @if($appointment->meeting_link)
                        <li>
                          <a class="dropdown-item" href="{{ $appointment->meeting_link }}" target="_blank">
                            <i class="ri-video-add-line me-2"></i> Join Meeting
                          </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                      @endif
                      <li>
                        <a class="dropdown-item" href="{{ route('admin.users.show', $appointment->client_id) }}">
                          <i class="ri-user-line me-2"></i> View Client
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="{{ route('admin.therapists.show', $appointment->therapist_id) }}">
                          <i class="ri-user-star-line me-2"></i> View Therapist
                        </a>
                      </li>
                      <li><hr class="dropdown-divider"></li>
                      <li>
                        <form action="{{ route('admin.appointments.destroy', $appointment) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger">
                            <i class="ri-delete-bin-line me-2"></i> Delete
                          </button>
                        </form>
                      </li>
                    </ul>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($appointments->hasPages())
      <div class="card-footer d-flex justify-content-between align-items-center py-3">
        <div class="text-muted">
          Showing <strong>{{ $appointments->firstItem() }}</strong> to <strong>{{ $appointments->lastItem() }}</strong> 
          of <strong>{{ $appointments->total() }}</strong> appointments
        </div>
        <div>
          {{ $appointments->links() }}
        </div>
      </div>
    @endif
  @else
    <div class="card-body">
      <div class="empty-state">
        <div class="empty-state-icon">
          <i class="ri-calendar-close-line"></i>
        </div>
        <h5 class="mb-2">No Appointments Today</h5>
        <p class="text-muted mb-4">
          There are no therapy sessions scheduled for {{ now()->format('l, F d, Y') }}.
        </p>
        <div class="d-flex gap-2 justify-content-center">
          <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-primary">
            <i class="ri-list-check me-1"></i> View All Appointments
          </a>
          <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Create Appointment
          </a>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Update current time every minute
    function updateCurrentTime() {
      const timeBar = document.querySelector('.current-time-bar span');
      if (timeBar) {
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const period = hours >= 12 ? 'PM' : 'AM';
        const hour12 = hours % 12 || 12;
        timeBar.textContent = `Current Time: ${hour12}:${minutes} ${period}`;
      }
    }
    setInterval(updateCurrentTime, 60000);
  });
</script>
@endsection
