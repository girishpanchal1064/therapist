@extends('layouts/contentNavbarLayout')

@section('title', 'Appointments Management')

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
  .filter-card {
    border-radius: 12px;
    border: 1px solid #e9ecef;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
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
  
  .avatar-group-item {
    margin-left: -12px;
    border: 2px solid #fff;
    transition: all 0.2s ease;
  }
  .avatar-group-item:first-child { margin-left: 0; }
  .avatar-group-item:hover { transform: translateY(-2px); z-index: 10; }
  
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
  
  .time-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 600;
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
  
  .date-picker-wrapper {
    position: relative;
  }
  .date-picker-wrapper i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #697a8d;
    pointer-events: none;
  }
  .date-picker-wrapper input {
    padding-left: 38px;
  }
  
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
  .payment-refunded { background: rgba(234, 84, 85, 0.12); color: #ea5455; }
  
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
  
  .appointment-datetime {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .appointment-date { font-weight: 600; color: #566a7f; }
  .appointment-time { 
    font-size: 0.875rem; 
    color: #697a8d;
    display: flex;
    align-items: center;
    gap: 4px;
  }
  
  .duration-badge {
    background: #f5f5f9;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    color: #566a7f;
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
  <div>
    <h4 class="fw-bold mb-1">
      <i class="ri-calendar-check-line me-2 text-primary"></i>Appointments Management
    </h4>
    <p class="text-muted mb-0">Manage and track all therapy sessions</p>
  </div>
  <div class="d-flex gap-2 flex-wrap">
    <a href="{{ route('admin.appointments.today') }}" class="btn btn-outline-primary">
      <i class="ri-calendar-todo-line me-1"></i> Today's Sessions
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
            <p class="text-muted mb-1 small text-uppercase fw-semibold">Today's Sessions</p>
            <h3 class="fw-bold mb-0">{{ $stats['today'] }}</h3>
            <small class="text-success"><i class="ri-calendar-line me-1"></i>{{ now()->format('M d, Y') }}</small>
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
            <p class="text-muted mb-1 small text-uppercase fw-semibold">Upcoming</p>
            <h3 class="fw-bold mb-0">{{ $stats['upcoming'] }}</h3>
            <small class="text-info"><i class="ri-time-line me-1"></i>Scheduled & Confirmed</small>
          </div>
          <div class="stats-icon bg-label-info">
            <i class="ri-calendar-schedule-line"></i>
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
            <h3 class="fw-bold mb-0">{{ $stats['completed'] }}</h3>
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
            <p class="text-muted mb-1 small text-uppercase fw-semibold">This Month</p>
            <h3 class="fw-bold mb-0">{{ $stats['this_month'] }}</h3>
            <small class="text-primary"><i class="ri-bar-chart-line me-1"></i>{{ now()->format('F Y') }}</small>
          </div>
          <div class="stats-icon bg-label-warning">
            <i class="ri-line-chart-line"></i>
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

<!-- Filters Card -->
<div class="card filter-card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.appointments.index') }}" id="filterForm">
      <div class="row g-3 align-items-end">
        <!-- Search -->
        <div class="col-md-3">
          <label class="form-label small text-uppercase fw-semibold text-muted">Search</label>
          <div class="input-group input-group-merge">
            <span class="input-group-text"><i class="ri-search-line"></i></span>
            <input type="text" name="search" class="form-control" placeholder="Client, therapist, meeting ID..." value="{{ $search }}">
          </div>
        </div>
        
        <!-- Status Filter -->
        <div class="col-md-2">
          <label class="form-label small text-uppercase fw-semibold text-muted">Status</label>
          <select name="status" class="form-select">
            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
            <option value="scheduled" {{ $status === 'scheduled' ? 'selected' : '' }}>📅 Scheduled</option>
            <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
            <option value="in_progress" {{ $status === 'in_progress' ? 'selected' : '' }}>🔄 In Progress</option>
            <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>✔️ Completed</option>
            <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
            <option value="no_show" {{ $status === 'no_show' ? 'selected' : '' }}>⚠️ No Show</option>
          </select>
        </div>
        
        <!-- Type Filter -->
        <div class="col-md-2">
          <label class="form-label small text-uppercase fw-semibold text-muted">Type</label>
          <select name="type" class="form-select">
            <option value="all" {{ $type === 'all' ? 'selected' : '' }}>All Types</option>
            <option value="individual" {{ $type === 'individual' ? 'selected' : '' }}>👤 Individual</option>
            <option value="couple" {{ $type === 'couple' ? 'selected' : '' }}>👫 Couple</option>
            <option value="family" {{ $type === 'family' ? 'selected' : '' }}>👨‍👩‍👧 Family</option>
          </select>
        </div>
        
        <!-- Mode Filter -->
        <div class="col-md-2">
          <label class="form-label small text-uppercase fw-semibold text-muted">Mode</label>
          <select name="mode" class="form-select">
            <option value="all" {{ $mode === 'all' ? 'selected' : '' }}>All Modes</option>
            <option value="video" {{ $mode === 'video' ? 'selected' : '' }}>📹 Video</option>
            <option value="audio" {{ $mode === 'audio' ? 'selected' : '' }}>📞 Audio</option>
            <option value="chat" {{ $mode === 'chat' ? 'selected' : '' }}>💬 Chat</option>
          </select>
        </div>
        
        <!-- Date From -->
        <div class="col-md-2">
          <label class="form-label small text-uppercase fw-semibold text-muted">From Date</label>
          <div class="date-picker-wrapper">
            <i class="ri-calendar-line"></i>
            <input type="date" name="date_from" class="form-control" value="{{ $dateFrom ?? '' }}">
          </div>
        </div>
        
        <!-- Date To -->
        <div class="col-md-2">
          <label class="form-label small text-uppercase fw-semibold text-muted">To Date</label>
          <div class="date-picker-wrapper">
            <i class="ri-calendar-line"></i>
            <input type="date" name="date_to" class="form-control" value="{{ $dateTo ?? '' }}">
          </div>
        </div>
        
        <!-- Per Page -->
        <div class="col-md-2">
          <label class="form-label small text-uppercase fw-semibold text-muted">Show</label>
          <select name="per_page" class="form-select">
            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 entries</option>
            <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 entries</option>
            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 entries</option>
            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 entries</option>
          </select>
        </div>
        
        <!-- Action Buttons -->
        <div class="col-md-3">
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-grow-1">
              <i class="ri-filter-3-line me-1"></i> Apply Filters
            </button>
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
              <i class="ri-refresh-line"></i>
            </a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Quick Status Filters -->
<div class="mb-4">
  <div class="d-flex gap-2 flex-wrap">
    <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm {{ $status === 'all' && !$dateFrom ? 'btn-primary' : 'btn-outline-primary' }}">
      <i class="ri-list-check me-1"></i> All ({{ $stats['total'] }})
    </a>
    <a href="{{ route('admin.appointments.index', ['status' => 'scheduled']) }}" class="btn btn-sm {{ $status === 'scheduled' ? 'btn-primary' : 'btn-outline-secondary' }}">
      <i class="ri-calendar-line me-1"></i> Scheduled
    </a>
    <a href="{{ route('admin.appointments.index', ['status' => 'confirmed']) }}" class="btn btn-sm {{ $status === 'confirmed' ? 'btn-success' : 'btn-outline-success' }}">
      <i class="ri-check-line me-1"></i> Confirmed
    </a>
    <a href="{{ route('admin.appointments.index', ['status' => 'in_progress']) }}" class="btn btn-sm {{ $status === 'in_progress' ? 'btn-warning' : 'btn-outline-warning' }}">
      <i class="ri-loader-4-line me-1"></i> In Progress ({{ $stats['in_progress'] }})
    </a>
    <a href="{{ route('admin.appointments.index', ['status' => 'completed']) }}" class="btn btn-sm {{ $status === 'completed' ? 'btn-secondary' : 'btn-outline-secondary' }}">
      <i class="ri-checkbox-circle-line me-1"></i> Completed
    </a>
    <a href="{{ route('admin.appointments.index', ['status' => 'cancelled']) }}" class="btn btn-sm {{ $status === 'cancelled' ? 'btn-danger' : 'btn-outline-danger' }}">
      <i class="ri-close-circle-line me-1"></i> Cancelled ({{ $stats['cancelled'] }})
    </a>
  </div>
</div>

<!-- Appointments Table -->
<div class="card appointment-card">
  <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
    <div>
      <h5 class="card-title mb-0">Appointments List</h5>
      <small class="text-muted">{{ $appointments->total() }} total appointments</small>
    </div>
    <div class="d-flex gap-2">
      <button type="button" class="btn btn-sm btn-outline-secondary" id="exportBtn">
        <i class="ri-download-2-line me-1"></i> Export
      </button>
    </div>
  </div>
  
  @if($appointments->count() > 0)
    <div class="table-responsive">
      <table class="table table-modern mb-0">
        <thead>
          <tr>
            <th>Appointment</th>
            <th>Client</th>
            <th>Therapist</th>
            <th>Date & Time</th>
            <th>Session Details</th>
            <th>Status</th>
            <th>Payment</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($appointments as $appointment)
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
            @endphp
            <tr class="appointment-row status-{{ $appointment->status }}">
              <td>
                <div class="d-flex flex-column">
                  <span class="fw-semibold text-primary">#{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</span>
                  @if($appointment->meeting_id)
                    <small class="text-muted" title="{{ $appointment->meeting_id }}">
                      <i class="ri-link me-1"></i>{{ Str::limit($appointment->meeting_id, 15) }}
                    </small>
                  @endif
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
                <div class="appointment-datetime">
                  <span class="appointment-date">
                    <i class="ri-calendar-line me-1 text-primary"></i>
                    {{ $appointment->appointment_date->format('M d, Y') }}
                  </span>
                  <span class="appointment-time">
                    <i class="ri-time-line me-1"></i>
                    {{ date('g:i A', strtotime($appointment->appointment_time)) }}
                  </span>
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
                <span class="status-badge bg-label-{{ $statusColors[$appointment->status] ?? 'secondary' }}">
                  <i class="{{ $statusIcons[$appointment->status] ?? 'ri-question-line' }} me-1"></i>
                  {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                </span>
              </td>
              <td>
                @if($appointment->payment)
                  @if($appointment->payment->status === 'completed')
                    <span class="payment-status payment-paid">
                      <i class="ri-checkbox-circle-fill"></i> Paid
                    </span>
                  @elseif($appointment->payment->status === 'refunded')
                    <span class="payment-status payment-refunded">
                      <i class="ri-refund-2-line"></i> Refunded
                    </span>
                  @else
                    <span class="payment-status payment-unpaid">
                      <i class="ri-time-line"></i> {{ ucfirst($appointment->payment->status) }}
                    </span>
                  @endif
                @else
                  <span class="payment-status payment-unpaid">
                    <i class="ri-close-circle-line"></i> Unpaid
                  </span>
                @endif
              </td>
              <td>
                <div class="d-flex justify-content-center gap-1">
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
                    <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" 
                              class="quick-action-btn btn-label-danger" 
                              data-bs-toggle="tooltip" 
                              title="Cancel"
                              onclick="return confirm('Are you sure you want to cancel this appointment?')">
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
                              onsubmit="return confirm('Are you sure you want to delete this appointment? This action cannot be undone.');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger">
                            <i class="ri-delete-bin-line me-2"></i> Delete Appointment
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
    <div class="card-footer d-flex justify-content-between align-items-center py-3">
      <div class="text-muted">
        Showing <strong>{{ $appointments->firstItem() }}</strong> to <strong>{{ $appointments->lastItem() }}</strong> 
        of <strong>{{ $appointments->total() }}</strong> appointments
      </div>
      <div>
        {{ $appointments->appends(request()->query())->links() }}
      </div>
    </div>
  @else
    <div class="card-body">
      <div class="empty-state">
        <div class="empty-state-icon">
          <i class="ri-calendar-close-line"></i>
        </div>
        <h5 class="mb-2">No Appointments Found</h5>
        <p class="text-muted mb-4">
          @if($search || $status !== 'all' || $type !== 'all' || $mode !== 'all' || $dateFrom || $dateTo)
            No appointments match your current filters. Try adjusting your search criteria.
          @else
            There are no appointments yet. Create your first appointment to get started.
          @endif
        </p>
        <div class="d-flex gap-2 justify-content-center">
          @if($search || $status !== 'all' || $type !== 'all' || $mode !== 'all' || $dateFrom || $dateTo)
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-primary">
              <i class="ri-refresh-line me-1"></i> Clear Filters
            </a>
          @endif
          <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Create New Appointment
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
    
    // Export functionality placeholder
    document.getElementById('exportBtn')?.addEventListener('click', function() {
      alert('Export functionality would be implemented here. You can export to CSV, Excel, or PDF.');
    });
  });
</script>
@endsection
