@extends('layouts/contentNavbarLayout')

@section('title', 'Appointments Management')

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

  /* Filter Card */
  .filter-card {
    border-radius: 16px;
    border: 1px solid #e9ecef;
    background: white;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
  }
  .filter-card .card-body {
    padding: 24px;
  }
  .filter-card .filter-title {
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    cursor: pointer;
    padding-bottom: 16px;
    border-bottom: 1px solid #e9ecef;
    margin-bottom: 20px;
  }
  .filter-icon-wrapper {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 1rem;
  }
  .btn-filter-toggle {
    background: transparent;
    border: 2px solid #e4e6eb;
    border-radius: 8px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667eea;
    transition: all 0.3s ease;
    cursor: pointer;
  }
  .btn-filter-toggle:hover {
    background: rgba(102, 126, 234, 0.1);
    border-color: #667eea;
  }
  .btn-filter-toggle i {
    font-size: 1.2rem;
    transition: transform 0.3s ease;
  }
  .btn-filter-toggle.active i {
    transform: rotate(180deg);
  }
  .filter-content {
    overflow: hidden;
    transition: all 0.3s ease;
  }
  .filter-content.collapsed {
    max-height: 0;
    margin-top: 0;
    opacity: 0;
    padding-top: 0;
  }
  .filter-content:not(.collapsed) {
    max-height: 1000px;
    opacity: 1;
  }
  .filter-card .form-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    color: #8e9baa;
    margin-bottom: 6px;
  }
  .filter-card .form-control,
  .filter-card .form-select {
    border-radius: 10px;
    border: 1px solid #e4e6eb;
    padding: 10px 14px;
    transition: all 0.2s ease;
  }
  .filter-card .form-control:focus,
  .filter-card .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
  }
  .btn-apply-filter {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 10px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .btn-apply-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    color: white;
  }

  /* Quick Status Filters */
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
    text-decoration: none;
  }
  .quick-filter-btn:hover {
    border-color: #667eea;
    color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
  }
  .quick-filter-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  .quick-filter-btn.active-success {
    background: linear-gradient(135deg, #28c76f 0%, #1e9d58 100%);
  }
  .quick-filter-btn.active-warning {
    background: linear-gradient(135deg, #ff9f43 0%, #ff8510 100%);
  }
  .quick-filter-btn.active-danger {
    background: linear-gradient(135deg, #ea5455 0%, #d63031 100%);
  }
  .quick-filter-btn .badge-count {
    background: rgba(255, 255, 255, 0.25);
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
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
  .table-appointments {
    margin: 0;
  }
  .table-appointments thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border: none;
    white-space: nowrap;
  }
  .table-appointments tbody tr {
    transition: all 0.2s ease;
    border-left: 4px solid transparent;
  }
  .table-appointments tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.04);
  }
  .table-appointments tbody td {
    padding: 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
  }
  .table-appointments tbody tr.status-scheduled { border-left-color: #667eea; }
  .table-appointments tbody tr.status-confirmed { border-left-color: #28c76f; }
  .table-appointments tbody tr.status-in_progress { border-left-color: #ff9f43; }
  .table-appointments tbody tr.status-completed { border-left-color: #82868b; }
  .table-appointments tbody tr.status-cancelled { border-left-color: #ea5455; }
  .table-appointments tbody tr.status-no_show { border-left-color: #ff9f43; }

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

  /* Appointment Info */
  .appointment-id {
    font-weight: 700;
    color: #667eea;
    font-size: 0.9rem;
  }
  .appointment-meeting-id {
    font-size: 0.75rem;
    color: #8e9baa;
    display: flex;
    align-items: center;
    gap: 4px;
  }
  .appointment-datetime {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .appointment-date {
    font-weight: 600;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .appointment-date i {
    color: #667eea;
  }
  .appointment-time {
    font-size: 0.85rem;
    color: #718096;
    display: flex;
    align-items: center;
    gap: 6px;
  }

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
  .payment-refunded {
    background: linear-gradient(135deg, rgba(234, 84, 85, 0.15) 0%, rgba(214, 48, 49, 0.15) 100%);
    color: #ea5455;
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

  /* Date Picker */
  .date-picker-wrapper {
    position: relative;
  }
  .date-picker-wrapper i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #8e9baa;
    pointer-events: none;
  }
  .date-picker-wrapper input {
    padding-left: 40px;
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

  /* Pagination */
  .card-footer {
    background: #fafbfc;
    border-top: 1px solid #e9ecef;
  }

  /* Export Button */
  .btn-export {
    background: white;
    border: 2px solid #e4e6eb;
    color: #566a7f;
    padding: 8px 16px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .btn-export:hover {
    border-color: #667eea;
    color: #667eea;
    background: rgba(102, 126, 234, 0.05);
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
<!-- Page Header -->
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4><i class="ri-calendar-check-line me-2"></i>Appointments Management</h4>
      <p>Manage and track all therapy sessions efficiently</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ route('admin.appointments.today') }}" class="btn btn-header">
        <i class="ri-calendar-todo-line me-1"></i> Today's Sessions
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
            <p class="text-muted mb-2 small text-uppercase fw-semibold">Today's Sessions</p>
            <h3 class="stats-value mb-1">{{ $stats['today'] ?? 0 }}</h3>
            <small class="text-muted"><i class="ri-calendar-line me-1"></i>{{ now()->format('M d, Y') }}</small>
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
            <p class="text-muted mb-2 small text-uppercase fw-semibold">Upcoming</p>
            <h3 class="stats-value mb-1">{{ $stats['upcoming'] ?? 0 }}</h3>
            <small class="text-muted"><i class="ri-time-line me-1"></i>Scheduled & Confirmed</small>
          </div>
          <div class="stats-icon">
            <i class="ri-calendar-schedule-line"></i>
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
            <h3 class="stats-value mb-1">{{ $stats['completed'] ?? 0 }}</h3>
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
            <p class="text-muted mb-2 small text-uppercase fw-semibold">This Month</p>
            <h3 class="stats-value mb-1">{{ $stats['this_month'] ?? 0 }}</h3>
            <small class="text-muted"><i class="ri-bar-chart-line me-1"></i>{{ now()->format('F Y') }}</small>
          </div>
          <div class="stats-icon">
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
    <div class="filter-title mb-3">
      <div class="d-flex align-items-center gap-2">
        <div class="filter-icon-wrapper">
          <i class="ri-filter-3-line"></i>
        </div>
        <span>Filter & Search</span>
      </div>
      <button type="button" class="btn-filter-toggle" onclick="toggleFilterSection()">
        <i class="ri-arrow-down-s-line" id="filterToggleIcon"></i>
      </button>
    </div>
    <div class="filter-content" id="filterContent">
      <form method="GET" action="{{ route('admin.appointments.index') }}" id="filterForm">
        <div class="row g-3 align-items-end">
          <!-- Search -->
        <div class="col-md-3">
          <label class="form-label small text-uppercase fw-semibold text-muted">Search</label>
          <div class="input-group input-group-merge">
            <span class="input-group-text"><i class="ri-search-line"></i></span>
            <input type="text" name="search" class="form-control" placeholder="Client, therapist, meeting ID..." value="{{ $search ?? '' }}">
          </div>
        </div>

        <!-- Status Filter -->
        <div class="col-md-2">
          <label class="form-label small text-uppercase fw-semibold text-muted">Status</label>
          <select name="status" class="form-select">
            <option value="all" {{ ($status ?? 'all') === 'all' ? 'selected' : '' }}>All Status</option>
            <option value="scheduled" {{ ($status ?? '') === 'scheduled' ? 'selected' : '' }}>📅 Scheduled</option>
            <option value="confirmed" {{ ($status ?? '') === 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
            <option value="in_progress" {{ ($status ?? '') === 'in_progress' ? 'selected' : '' }}>🔄 In Progress</option>
            <option value="completed" {{ ($status ?? '') === 'completed' ? 'selected' : '' }}>✔️ Completed</option>
            <option value="cancelled" {{ ($status ?? '') === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
            <option value="no_show" {{ ($status ?? '') === 'no_show' ? 'selected' : '' }}>⚠️ No Show</option>
          </select>
        </div>

        <!-- Type Filter -->
        <div class="col-md-2">
          <label class="form-label small text-uppercase fw-semibold text-muted">Type</label>
          <select name="type" class="form-select">
            <option value="all" {{ ($type ?? 'all') === 'all' ? 'selected' : '' }}>All Types</option>
            <option value="individual" {{ ($type ?? '') === 'individual' ? 'selected' : '' }}>👤 Individual</option>
            <option value="couple" {{ ($type ?? '') === 'couple' ? 'selected' : '' }}>👫 Couple</option>
            <option value="family" {{ ($type ?? '') === 'family' ? 'selected' : '' }}>👨‍👩‍👧 Family</option>
          </select>
        </div>

        <!-- Mode Filter -->
        <div class="col-md-2">
          <label class="form-label small text-uppercase fw-semibold text-muted">Mode</label>
          <select name="mode" class="form-select">
            <option value="all" {{ ($mode ?? 'all') === 'all' ? 'selected' : '' }}>All Modes</option>
            <option value="video" {{ ($mode ?? '') === 'video' ? 'selected' : '' }}>📹 Video</option>
            <option value="audio" {{ ($mode ?? '') === 'audio' ? 'selected' : '' }}>📞 Audio</option>
            <option value="chat" {{ ($mode ?? '') === 'chat' ? 'selected' : '' }}>💬 Chat</option>
          </select>
        </div>

        <!-- Per Page -->
        <div class="col-md-2">
          <label class="form-label small text-uppercase fw-semibold text-muted">Show</label>
          <select name="per_page" class="form-select">
            <option value="10" {{ ($perPage ?? 15) == 10 ? 'selected' : '' }}>10 entries</option>
            <option value="15" {{ ($perPage ?? 15) == 15 ? 'selected' : '' }}>15 entries</option>
            <option value="25" {{ ($perPage ?? 15) == 25 ? 'selected' : '' }}>25 entries</option>
            <option value="50" {{ ($perPage ?? 15) == 50 ? 'selected' : '' }}>50 entries</option>
          </select>
        </div>

        <!-- Action Buttons -->
        <div class="col-md-3">
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-apply-filter flex-grow-1">
              <i class="ri-filter-3-line me-1"></i> Apply Filters
            </button>
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary" title="Reset">
              <i class="ri-refresh-line"></i>
            </a>
          </div>
        </div>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Quick Status Filters -->
<div class="quick-filters">
  <a href="{{ route('admin.appointments.index') }}" class="quick-filter-btn {{ ($status ?? 'all') === 'all' ? 'active' : '' }}">
    <i class="ri-list-check"></i> All
    <span class="badge-count">{{ $stats['total'] ?? 0 }}</span>
  </a>
  <a href="{{ route('admin.appointments.index', ['status' => 'scheduled']) }}" class="quick-filter-btn {{ ($status ?? '') === 'scheduled' ? 'active' : '' }}">
    <i class="ri-calendar-line"></i> Scheduled
  </a>
  <a href="{{ route('admin.appointments.index', ['status' => 'confirmed']) }}" class="quick-filter-btn {{ ($status ?? '') === 'confirmed' ? 'active active-success' : '' }}">
    <i class="ri-check-line"></i> Confirmed
  </a>
  <a href="{{ route('admin.appointments.index', ['status' => 'in_progress']) }}" class="quick-filter-btn {{ ($status ?? '') === 'in_progress' ? 'active active-warning' : '' }}">
    <i class="ri-loader-4-line"></i> In Progress
    <span class="badge-count">{{ $stats['in_progress'] ?? 0 }}</span>
  </a>
  <a href="{{ route('admin.appointments.index', ['status' => 'completed']) }}" class="quick-filter-btn {{ ($status ?? '') === 'completed' ? 'active' : '' }}">
    <i class="ri-checkbox-circle-line"></i> Completed
  </a>
  <a href="{{ route('admin.appointments.index', ['status' => 'cancelled']) }}" class="quick-filter-btn {{ ($status ?? '') === 'cancelled' ? 'active active-danger' : '' }}">
    <i class="ri-close-circle-line"></i> Cancelled
    <span class="badge-count">{{ $stats['cancelled'] ?? 0 }}</span>
  </a>
</div>

<!-- Appointments Table -->
<div class="card appointment-card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <div>
      <h5 class="card-title mb-1"><i class="ri-list-check me-2"></i>Appointments List</h5>
      <small class="text-muted">{{ $appointments->total() }} total appointments found</small>
    </div>
    <div class="d-flex gap-2">
      <button type="button" class="btn btn-export" id="exportBtn">
        <i class="ri-download-2-line me-1"></i> Export
      </button>
    </div>
  </div>

  @if($appointments->count() > 0)
    <div class="table-responsive">
      <table class="table table-appointments mb-0">
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
            <tr class="status-{{ $appointment->status }}">
              <td>
                <div class="d-flex flex-column">
                  <span class="appointment-id">#{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</span>
                  @if($appointment->meeting_id)
                    <span class="appointment-meeting-id" title="{{ $appointment->meeting_id }}">
                      <i class="ri-link"></i>{{ Str::limit($appointment->meeting_id, 15) }}
                    </span>
                  @endif
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
                    <div class="user-avatar-initials">
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
                <div class="appointment-datetime">
                  <span class="appointment-date">
                    <i class="ri-calendar-line"></i>
                    {{ $appointment->appointment_date->format('M d, Y') }}
                  </span>
                  <span class="appointment-time">
                    <i class="ri-time-line"></i>
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
                      <i class="ri-timer-line"></i>{{ $appointment->duration_minutes }}m
                    </span>
                  </div>
                </div>
              </td>
              <td>
                <span class="status-badge bg-label-{{ $statusColors[$appointment->status] ?? 'secondary' }}">
                  <i class="{{ $statusIcons[$appointment->status] ?? 'ri-question-line' }}"></i>
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
                <div class="action-buttons">
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
                    <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit"
                              class="btn-action btn-action-cancel"
                              data-bs-toggle="tooltip"
                              title="Cancel"
                              data-title="Cancel Appointment" data-text="Are you sure you want to cancel this appointment?" data-confirm-text="Yes, cancel it!" data-cancel-text="No, keep it" class="cancel-appointment-btn">
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
                              class="delete-form">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger" data-title="Delete Appointment" data-text="Are you sure you want to delete this appointment? This action cannot be undone." data-confirm-text="Yes, delete it!" data-cancel-text="Cancel">
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
          @if(($search ?? '') || ($status ?? 'all') !== 'all' || ($type ?? 'all') !== 'all' || ($mode ?? 'all') !== 'all')
            No appointments match your current filters. Try adjusting your search criteria.
          @else
            There are no appointments yet. Create your first appointment to get started.
          @endif
        </p>
        <div class="d-flex gap-2 justify-content-center">
          @if(($search ?? '') || ($status ?? 'all') !== 'all' || ($type ?? 'all') !== 'all' || ($mode ?? 'all') !== 'all')
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
  // Toggle filter section
  function toggleFilterSection() {
    const filterContent = document.getElementById('filterContent');
    const toggleIcon = document.getElementById('filterToggleIcon');
    const toggleBtn = document.querySelector('.btn-filter-toggle');

    filterContent.classList.toggle('collapsed');
    toggleBtn.classList.toggle('active');

    // Save state to localStorage
    const isCollapsed = filterContent.classList.contains('collapsed');
    localStorage.setItem('filterSectionCollapsed_appointments', isCollapsed);
  }

  // Restore filter state on page load
  document.addEventListener('DOMContentLoaded', function() {
    const savedState = localStorage.getItem('filterSectionCollapsed_appointments');
    if (savedState === 'true') {
      const filterContent = document.getElementById('filterContent');
      const toggleBtn = document.querySelector('.btn-filter-toggle');
      if (filterContent && toggleBtn) {
        filterContent.classList.add('collapsed');
        toggleBtn.classList.add('active');
      }
    }
  });
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Export functionality placeholder
    document.getElementById('exportBtn')?.addEventListener('click', function() {
      Swal.fire({
        icon: 'info',
        title: 'Export',
        text: 'Export functionality would be implemented here. You can export to CSV, Excel, or PDF.',
        confirmButtonColor: '#667eea',
        confirmButtonText: 'OK'
      });
    });

    // Handle cancel appointment buttons
    document.querySelectorAll('.cancel-appointment-btn').forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('form');
        const title = this.dataset.title || 'Cancel Appointment';
        const text = this.dataset.text || 'Are you sure you want to cancel this appointment?';
        const confirmText = this.dataset.confirmText || 'Yes, cancel it!';
        const cancelText = this.dataset.cancelText || 'No, keep it';

        Swal.fire({
          title: title,
          text: text,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ffc107',
          cancelButtonColor: '#6c757d',
          confirmButtonText: confirmText,
          cancelButtonText: cancelText,
          reverseButtons: true,
          customClass: {
            confirmButton: 'btn btn-warning',
            cancelButton: 'btn btn-secondary',
            actions: 'swal2-actions'
          },
          buttonsStyling: false
        }).then((result) => {
          if (result.isConfirmed && form) {
            form.submit();
          }
        });
      });
    });
  });
</script>
@endsection
