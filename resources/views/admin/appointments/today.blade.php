@extends('layouts/contentNavbarLayout')

@section('title', "Today's Appointments")

@section('vendor-style')
<style>
  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
  }
  .page-header h4 {
    margin: 0;
    font-weight: 700;
    color: white;
    font-size: 1.5rem;
  }
  .page-header p {
    color: rgba(255, 255, 255, 0.85);
    margin: 4px 0 0 0;
  }
  .page-header .btn-header {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
  }
  .page-header .btn-header:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    color: white;
  }
  .page-header .btn-header-primary {
    background: white;
    color: #667eea;
    border: none;
  }
  .page-header .btn-header-primary:hover {
    background: #f8f9fa;
    color: #764ba2;
  }
  
  /* Stats Cards */
  .stats-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 16px;
    overflow: hidden;
    background: white;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    position: relative;
  }
  .stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  .stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.15);
  }
  .stats-card:hover::before {
    opacity: 1;
  }
  .stats-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    font-size: 1.6rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    color: #667eea;
  }
  .stats-card .stats-value {
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
  
  /* Appointments Card */
  .appointment-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
    overflow: hidden;
  }
  .appointment-card .card-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    padding: 20px 24px;
    border-bottom: 1px solid #e9ecef;
  }
  .appointment-card .card-title {
    font-weight: 700;
    color: #4a5568;
    font-size: 1.1rem;
  }
  
  /* Table Styling */
  .table-today {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    width: 100%;
  }
  .table-today thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border: none;
    white-space: nowrap;
  }
  .table-today thead th:first-child {
    border-radius: 12px 0 0 0;
  }
  .table-today thead th:last-child {
    border-radius: 0 12px 0 0;
  }
  .table-today tbody tr {
    transition: all 0.3s ease;
    background: white;
    border-left: 4px solid transparent;
    border-bottom: 1px solid #f0f2f5;
  }
  .table-today tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.04) 0%, rgba(118, 75, 162, 0.04) 100%);
    transform: scale(1.001);
    box-shadow: 0 2px 12px rgba(102, 126, 234, 0.08);
  }
  .table-today tbody tr:last-child {
    border-bottom: none;
  }
  .table-today tbody td {
    padding: 18px 20px;
    vertical-align: middle;
    color: #2d3748;
    font-size: 0.9rem;
    border-bottom: 1px solid #f0f2f5;
  }
  .table-today tbody tr:last-child td {
    border-bottom: none;
  }
  .table-today tbody tr.status-scheduled { border-left-color: #667eea; }
  .table-today tbody tr.status-confirmed { border-left-color: #28c76f; }
  .table-today tbody tr.status-in_progress { border-left-color: #ff9f43; }
  .table-today tbody tr.status-completed { border-left-color: #82868b; }
  .table-today tbody tr.status-cancelled { border-left-color: #ea5455; }
  .table-today tbody tr.status-no_show { border-left-color: #ff9f43; }
  
  /* Badges */
  .mode-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  .mode-video { 
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%); 
    color: #667eea; 
  }
  .mode-audio { 
    background: linear-gradient(135deg, rgba(40, 199, 111, 0.15) 0%, rgba(30, 157, 88, 0.15) 100%); 
    color: #28c76f; 
  }
  .mode-chat { 
    background: linear-gradient(135deg, rgba(255, 159, 67, 0.15) 0%, rgba(255, 133, 16, 0.15) 100%); 
    color: #ff9f43; 
  }
  
  .status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  
  .duration-badge {
    background: #f5f5f9;
    padding: 4px 12px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    color: #566a7f;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  
  .payment-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
  }
  .payment-paid { 
    background: linear-gradient(135deg, rgba(40, 199, 111, 0.15) 0%, rgba(30, 157, 88, 0.15) 100%); 
    color: #28c76f; 
  }
  .payment-unpaid { 
    background: linear-gradient(135deg, rgba(255, 159, 67, 0.15) 0%, rgba(255, 133, 16, 0.15) 100%); 
    color: #ff9f43; 
  }
  
  /* User Info */
  .user-info {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .user-avatar {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid #f0f0f5;
  }
  .user-avatar-initials {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    color: #667eea;
  }
  .user-avatar-initials.therapist {
    background: linear-gradient(135deg, rgba(40, 199, 111, 0.15) 0%, rgba(30, 157, 88, 0.15) 100%);
    color: #28c76f;
  }
  .user-details h6 { margin: 0; font-size: 0.9rem; font-weight: 600; color: #2d3748; }
  .user-details small { color: #718096; font-size: 0.75rem; }
  
  /* Time Display */
  .time-display {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 8px 16px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 10px;
  }
  .time-display .time {
    font-size: 1.2rem;
    font-weight: 700;
    color: #667eea;
  }
  .time-display .period {
    font-size: 0.7rem;
    color: #764ba2;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
  }

  .live-indicator {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
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
    background: linear-gradient(to right, rgba(102, 126, 234, 0.1), transparent);
    border-left: 4px solid #667eea;
    padding: 14px 20px;
    border-radius: 0 10px 10px 0;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .current-time-bar i { color: #667eea; font-size: 1.3rem; }
  .current-time-bar span { font-weight: 600; color: #667eea; }
  
  /* Quick Filters */
  .quick-filters {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 24px;
  }
  .quick-filter-btn {
    padding: 8px 18px;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 600;
    border: 2px solid #e4e6eb;
    background: white;
    color: #566a7f;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .quick-filter-btn:hover {
    border-color: #667eea;
    color: #667eea;
  }
  .quick-filter-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  .quick-filter-btn .badge-count {
    background: rgba(255, 255, 255, 0.25);
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
  }
  .quick-filter-live {
    background: linear-gradient(135deg, #ea5455 0%, #ff6b6b 100%);
    border-color: transparent;
    color: white;
    animation: pulse 2s infinite;
  }
  
  /* Action Buttons */
  .action-buttons {
    display: flex;
    gap: 6px;
    justify-content: center;
    align-items: center;
  }
  .btn-action {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    font-size: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
  }
  .btn-action:hover {
    transform: translateY(-3px);
  }
  .btn-action-view {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
  }
  .btn-action-view:hover {
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    color: white;
  }
  .btn-action-edit {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
  }
  .btn-action-edit:hover {
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
    color: white;
  }
  .btn-action-complete {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
  }
  .btn-action-complete:hover {
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    color: white;
  }
  .btn-action-cancel {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
  }
  .btn-action-cancel:hover {
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
    color: white;
  }
  .btn-action-more {
    background: #f1f5f9;
    color: #64748b;
  }
  .btn-action-more:hover {
    background: #e2e8f0;
    color: #475569;
  }
  .btn-join {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 8px 16px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    border: none;
    transition: all 0.3s ease;
  }
  .btn-join:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    color: white;
  }
  
  /* Empty State */
  .empty-state {
    padding: 80px 20px;
    text-align: center;
  }
  .empty-state-icon {
    width: 130px;
    height: 130px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
  }
  .empty-state-icon i { 
    font-size: 3.5rem; 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
  .empty-state h5 {
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 8px;
  }
  .empty-state p {
    color: #718096;
    max-width: 400px;
    margin: 0 auto 24px;
  }
  
  /* Dropdown Menu */
  .dropdown-menu {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    padding: 8px;
  }
  .dropdown-item {
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }
  .dropdown-item:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    color: #667eea;
  }
  .dropdown-item.text-danger:hover {
    background: rgba(234, 84, 85, 0.1);
    color: #ea5455;
  }
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
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4><i class="ri-calendar-todo-line me-2"></i>Today's Appointments</h4>
      <p>{{ now()->format('l, F d, Y') }} • Manage today's therapy sessions</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ route('admin.appointments.index') }}" class="btn btn-header">
        <i class="ri-list-check me-1"></i> All Appointments
      </a>
      <a href="{{ route('admin.appointments.create') }}" class="btn btn-header btn-header-primary">
        <i class="ri-add-line me-1"></i> New Appointment
      </a>
    </div>
  </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card stats-card h-100">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-muted mb-2 small text-uppercase fw-semibold">Total Today</p>
            <h3 class="stats-value mb-1">{{ $totalToday }}</h3>
            <small class="text-muted"><i class="ri-calendar-line me-1"></i>Sessions scheduled</small>
          </div>
          <div class="stats-icon">
            <i class="ri-calendar-check-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card stats-card h-100">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-muted mb-2 small text-uppercase fw-semibold">In Progress</p>
            <h3 class="stats-value mb-1">{{ $inProgressCount }}</h3>
            <small class="text-muted"><i class="ri-loader-4-line me-1"></i>Currently active</small>
          </div>
          <div class="stats-icon">
            <i class="ri-video-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card stats-card h-100">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-muted mb-2 small text-uppercase fw-semibold">Completed</p>
            <h3 class="stats-value mb-1">{{ $completedCount }}</h3>
            <small class="text-muted"><i class="ri-check-double-line me-1"></i>Sessions done</small>
          </div>
          <div class="stats-icon">
            <i class="ri-checkbox-circle-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card stats-card h-100">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="text-muted mb-2 small text-uppercase fw-semibold">Upcoming</p>
            <h3 class="stats-value mb-1">{{ $upcomingCount }}</h3>
            <small class="text-muted"><i class="ri-time-line me-1"></i>Waiting to start</small>
          </div>
          <div class="stats-icon">
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
<div class="quick-filters">
  <a href="{{ route('admin.appointments.today') }}" class="quick-filter-btn active">
    <i class="ri-list-check"></i> All
    <span class="badge-count">{{ $totalToday }}</span>
  </a>
  @if($inProgressCount > 0)
    <span class="quick-filter-btn quick-filter-live">
      <i class="ri-loader-4-line"></i> Live Now
      <span class="badge-count">{{ $inProgressCount }}</span>
    </span>
  @endif
  <span class="quick-filter-btn">
    <i class="ri-checkbox-circle-line"></i> Completed
    <span class="badge-count">{{ $completedCount }}</span>
  </span>
  <span class="quick-filter-btn">
    <i class="ri-time-line"></i> Upcoming
    <span class="badge-count">{{ $upcomingCount }}</span>
  </span>
  @if($cancelledCount > 0)
    <span class="quick-filter-btn">
      <i class="ri-close-circle-line"></i> Cancelled
      <span class="badge-count">{{ $cancelledCount }}</span>
    </span>
  @endif
</div>

<!-- Appointments Table -->
<div class="card appointment-card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <div>
      <h5 class="card-title mb-1"><i class="ri-calendar-event-line me-2"></i>Today's Sessions</h5>
      <small class="text-muted">{{ $totalToday }} appointments for {{ now()->format('F d, Y') }}</small>
    </div>
    <div class="d-flex gap-2">
      <button type="button" class="btn btn-header btn-header-primary" onclick="location.reload()" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
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
      <table class="table table-today mb-0">
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
            <tr class="status-{{ $appointment->status }}">
              <td>
                <div class="time-display">
                  <span class="time">{{ $appointmentTime->format('g:i') }}</span>
                  <span class="period">{{ $appointmentTime->format('A') }}</span>
                </div>
              </td>
              <td>
                <div class="user-info">
                  @if($appointment->client)
                    @if($appointment->client->profile && $appointment->client->profile->profile_image)
                      <img src="{{ asset('storage/' . $appointment->client->profile->profile_image) }}" alt="{{ $appointment->client->name }}" class="user-avatar">
                    @elseif($appointment->client->getRawOriginal('avatar'))
                      <img src="{{ asset('storage/' . $appointment->client->getRawOriginal('avatar')) }}" alt="{{ $appointment->client->name }}" class="user-avatar">
                    @else
                      <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->client->name) }}&background=3b82f6&color=fff&size=80&bold=true&format=svg" alt="{{ $appointment->client->name }}" class="user-avatar">
                    @endif
                  @else
                    <div class="user-avatar-initials bg-label-primary">
                      NA
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
                  @if($appointment->therapist)
                    @if($appointment->therapist->therapistProfile && $appointment->therapist->therapistProfile->profile_image)
                      <img src="{{ asset('storage/' . $appointment->therapist->therapistProfile->profile_image) }}" alt="{{ $appointment->therapist->name }}" class="user-avatar">
                    @elseif($appointment->therapist->avatar)
                      <img src="{{ asset('storage/' . $appointment->therapist->avatar) }}" alt="{{ $appointment->therapist->name }}" class="user-avatar">
                    @else
                      <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->therapist->name) }}&background=667eea&color=fff&size=80&bold=true&format=svg" alt="{{ $appointment->therapist->name }}" class="user-avatar">
                    @endif
                  @else
                    <div class="user-avatar-initials therapist">NA</div>
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
                <div class="action-buttons">
                  @if($isLive && $appointment->meeting_link)
                    <a href="{{ $appointment->meeting_link }}" target="_blank" 
                       class="btn-join" 
                       data-bs-toggle="tooltip" 
                       title="Join Session">
                      <i class="ri-video-add-line me-1"></i> Join
                    </a>
                  @endif
                  
                  <a href="{{ route('admin.appointments.show', $appointment) }}" 
                     class="btn-action btn-action-view" 
                     data-bs-toggle="tooltip" 
                     title="View Details">
                    <i class="ri-eye-line"></i>
                  </a>
                  <a href="{{ route('admin.appointments.edit', $appointment) }}" 
                     class="btn-action btn-action-edit" 
                     data-bs-toggle="tooltip" 
                     title="Edit">
                    <i class="ri-pencil-line"></i>
                  </a>
                  @if(in_array($appointment->status, ['scheduled', 'confirmed']))
                    <form action="{{ route('admin.appointments.complete', $appointment) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" 
                              class="btn-action btn-action-complete" 
                              data-bs-toggle="tooltip" 
                              title="Mark Complete">
                        <i class="ri-check-line"></i>
                      </button>
                    </form>
                    <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel this appointment?')">
                      @csrf
                      <button type="submit" 
                              class="btn-action btn-action-cancel" 
                              data-bs-toggle="tooltip" 
                              title="Cancel">
                        <i class="ri-close-line"></i>
                      </button>
                    </form>
                  @endif
                  <div class="dropdown d-inline">
                    <button type="button" class="btn-action btn-action-more dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
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
