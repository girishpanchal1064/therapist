@extends('layouts/contentNavbarLayout')

@section('title', 'Online Sessions')

@section('page-style')
<style>
  /* === Sessions Page Custom Styles === */
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    color: white;
    position: relative;
    overflow: hidden;
  }

  .page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
  }

  .page-header h4 {
    font-weight: 700;
    margin-bottom: 0.25rem;
    position: relative;
    color: white;
    z-index: 1;
  }

  .page-header p {
    opacity: 0.9;
    margin: 0;
    font-size: 0.9375rem;
    position: relative;
    z-index: 1;
  }

  /* Tab Navigation */
  .session-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
  }

  .session-tab {
    padding: 0.625rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.8125rem;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border: 2px solid transparent;
  }

  .session-tab:not(.active) {
    background: #f3f4f6;
    color: #6b7280;
    border-color: #e5e7eb;
  }

  .session-tab:not(.active):hover {
    background: #e5e7eb;
    color: #374151;
    transform: translateY(-2px);
  }

  .session-tab.active {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
  }

  .session-tab i {
    font-size: 1rem;
  }

  .tab-count {
    background: rgba(255,255,255,0.2);
    padding: 0.125rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 700;
  }

  .session-tab:not(.active) .tab-count {
    background: #e5e7eb;
  }

  /* Main Card */
  .sessions-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow: hidden;
  }

  .sessions-card .card-header {
    background: transparent;
    border-bottom: 1px solid #f3f4f6;
    padding: 1.25rem 1.5rem;
  }

  .sessions-card .card-body {
    padding: 1.5rem;
  }

  /* Search & Filters */
  .filters-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
  }

  .search-box {
    display: flex;
    gap: 0.5rem;
    flex: 1;
    max-width: 400px;
  }

  .search-input {
    flex: 1;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: all 0.2s ease;
    background: #f9fafb url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E") no-repeat 0.875rem center;
    background-size: 18px;
  }

  .search-input:focus {
    outline: none;
    border-color: #059669;
    background-color: white;
    box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
  }

  .btn-search {
    padding: 0.75rem 1.25rem;
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
    color: white;
  }

  .btn-refresh {
    padding: 0.75rem 1.25rem;
    background: white;
    color: #059669;
    border: 2px solid #059669;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-refresh:hover {
    background: #059669;
    color: white;
    transform: translateY(-2px);
  }

  /* Table Styles */
  .sessions-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  }

  .sessions-table thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 18px 20px;
    border: none;
    text-align: left;
    white-space: nowrap;
  }

  .sessions-table thead th:first-child {
    border-radius: 12px 0 0 0;
  }

  .sessions-table thead th:last-child {
    border-radius: 0 12px 0 0;
  }

  .sessions-table tbody td {
    padding: 18px 20px;
    border-bottom: 1px solid #f0f2f5;
    vertical-align: middle;
    color: #2d3748;
    font-size: 0.9rem;
  }

  .sessions-table tbody tr {
    transition: all 0.3s ease;
    background: white;
  }

  .sessions-table tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.04) 0%, rgba(118, 75, 162, 0.04) 100%);
    transform: scale(1.001);
    box-shadow: 0 2px 12px rgba(102, 126, 234, 0.08);
  }

  .sessions-table tbody tr:last-child td {
    border-bottom: none;
  }

  /* Client Cell */
  .client-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .client-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid #e5e7eb;
  }

  .client-avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.8125rem;
  }

  .client-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.9375rem;
  }

  /* Mode Badge */
  .mode-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.02em;
  }

  .mode-badge.video {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.1) 100%);
    color: #2563eb;
  }

  .mode-badge.audio {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
    color: #d97706;
  }

  .mode-badge.chat {
    background: linear-gradient(135deg, rgba(107, 114, 128, 0.1) 0%, rgba(75, 85, 99, 0.1) 100%);
    color: #4b5563;
  }

  /* Status Badge */
  .status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.02em;
  }

  .status-badge.pending {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
    color: #d97706;
  }

  .status-badge.upcoming {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.1) 100%);
    color: #2563eb;
  }

  .status-badge.completed {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
    color: #059669;
  }

  .status-badge.cancelled, .status-badge.cancel {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%);
    color: #dc2626;
  }

  .status-badge.expired {
    background: linear-gradient(135deg, rgba(75, 85, 99, 0.1) 0%, rgba(55, 65, 81, 0.1) 100%);
    color: #374151;
  }

  /* Pagination */
  .pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 1px solid #f3f4f6;
    margin-top: 1rem;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .pagination-info {
    font-size: 0.875rem;
    color: #6b7280;
  }

  .pagination-controls {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .page-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 2px solid #e5e7eb;
    background: white;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    text-decoration: none;
  }

  .page-btn:hover:not(:disabled) {
    border-color: #059669;
    color: #059669;
    background: #f0fdf4;
  }

  .page-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  .per-page-select {
    padding: 0.5rem 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.875rem;
    color: #374151;
    background: white;
    cursor: pointer;
  }

  .per-page-select:focus {
    outline: none;
    border-color: #059669;
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
  }

  .empty-state-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.5rem;
    color: #059669;
  }

  .empty-state h5 {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
  }

  .empty-state p {
    color: #6b7280;
    font-size: 0.9375rem;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .filters-row {
      flex-direction: column;
    }

    .search-box {
      max-width: 100%;
      width: 100%;
    }

    .session-tabs {
      overflow-x: auto;
      flex-wrap: nowrap;
      padding: 0.75rem;
    }

    .session-tab {
      white-space: nowrap;
      font-size: 0.75rem;
      padding: 0.5rem 1rem;
    }

    .sessions-table {
      display: block;
      overflow-x: auto;
    }
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <h4>
    <i class="ri-video-line me-2"></i>
    @if($status === 'pending')
      Pending Sessions
    @elseif($status === 'upcoming')
      Upcoming Sessions
    @elseif($status === 'completed')
      Completed Sessions
    @elseif($status === 'cancel_by_me')
      Cancelled By Me
    @elseif($status === 'cancelled_by_user')
      Cancelled By Client
    @elseif($status === 'expired')
      Expired Sessions
    @else
      Online Sessions
    @endif
  </h4>
  <p>Manage and track all your therapy sessions in one place</p>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #059669;">
    <i class="ri-checkbox-circle-line me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Session Tabs -->
<div class="session-tabs">
  <a href="{{ route('therapist.sessions.index', ['status' => 'pending']) }}"
     class="session-tab {{ $status === 'pending' ? 'active' : '' }}">
    <i class="ri-time-line"></i>
    Pending
  </a>
  <a href="{{ route('therapist.sessions.index', ['status' => 'upcoming']) }}"
     class="session-tab {{ $status === 'upcoming' ? 'active' : '' }}">
    <i class="ri-calendar-check-line"></i>
    Upcoming
  </a>
  <a href="{{ route('therapist.sessions.index', ['status' => 'completed']) }}"
     class="session-tab {{ $status === 'completed' ? 'active' : '' }}">
    <i class="ri-checkbox-circle-line"></i>
    Completed
  </a>
  <a href="{{ route('therapist.sessions.index', ['status' => 'cancel_by_me']) }}"
     class="session-tab {{ $status === 'cancel_by_me' ? 'active' : '' }}">
    <i class="ri-close-circle-line"></i>
    Cancel by Me
  </a>
  <a href="{{ route('therapist.sessions.index', ['status' => 'cancelled_by_user']) }}"
     class="session-tab {{ $status === 'cancelled_by_user' ? 'active' : '' }}">
    <i class="ri-user-unfollow-line"></i>
    Cancelled by Client
  </a>
  <a href="{{ route('therapist.sessions.index', ['status' => 'expired']) }}"
     class="session-tab {{ $status === 'expired' ? 'active' : '' }}">
    <i class="ri-history-line"></i>
    Expired
  </a>
</div>

<!-- Sessions Card -->
<div class="sessions-card">
  <div class="card-body">
    <!-- Filters Row -->
    <div class="filters-row">
      <form method="GET" action="{{ route('therapist.sessions.index') }}" class="search-box">
        <input type="hidden" name="status" value="{{ $status }}">
        <input type="text" name="search" class="search-input" placeholder="Search by client name..." value="{{ $search }}">
        <button type="submit" class="btn-search">
          <i class="ri-search-line"></i>
        </button>
      </form>
      <button type="button" class="btn-refresh" onclick="location.reload()">
        <i class="ri-refresh-line"></i>
        Refresh
      </button>
    </div>

    <!-- Sessions Table -->
    <div class="table-responsive">
      <table class="sessions-table">
        <thead>
          <tr>
            <th style="width: 60px;">#</th>
            <th>Session ID</th>
            <th>Client</th>
            <th>Mode</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sessions as $index => $session)
            <tr>
              <td style="font-weight: 500; color: #6b7280;">{{ $sessions->firstItem() + $index }}</td>
              <td>
                <span style="font-family: monospace; font-weight: 600; color: #059669;">
                  S-{{ $session->created_at ? $session->created_at->timestamp : $session->id }}
                </span>
              </td>
              <td>
                <div class="client-cell">
                  @if($session->client)
                    @if($session->client->profile && $session->client->profile->profile_image)
                      <img src="{{ asset('storage/' . $session->client->profile->profile_image) }}" alt="{{ $session->client->name }}" class="client-avatar">
                    @elseif($session->client->getRawOriginal('avatar'))
                      <img src="{{ asset('storage/' . $session->client->getRawOriginal('avatar')) }}" alt="{{ $session->client->name }}" class="client-avatar">
                    @else
                      <img src="https://ui-avatars.com/api/?name={{ urlencode($session->client->name ?? 'N') }}&background=3b82f6&color=fff&size=80&bold=true&format=svg" alt="{{ $session->client->name }}" class="client-avatar">
                    @endif
                  @else
                    <div class="client-avatar-placeholder">
                      N
                    </div>
                  @endif
                  <span class="client-name">{{ $session->client->name ?? 'N/A' }}</span>
                </div>
              </td>
              <td>
                <span class="mode-badge {{ $session->session_mode }}">
                  {{ strtoupper($session->session_mode) }}
                </span>
              </td>
              <td style="font-weight: 500;">{{ $session->appointment_date->format('d M, Y') }}</td>
              <td style="color: #6b7280;">
                @php
                  $startTime = \Carbon\Carbon::parse($session->appointment_time, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
                  $endTime = $startTime->copy()->addMinutes($session->duration_minutes ?? 60);
                  $duration = $session->duration_minutes ?? 60;
                @endphp
                <div style="display: flex; flex-direction: column; gap: 4px;">
                  <span style="font-weight: 500;">
                    {{ $startTime->format('g:i A') }} IST - {{ $endTime->format('g:i A') }} IST
                  </span>
                  <span style="font-size: 0.75rem; color: #9ca3af;">
                    <i class="ri-timer-line" style="margin-right: 4px;"></i>{{ $duration }} mins
                  </span>
                </div>
              </td>
              <td>
                @php
                  // Handle appointment_time - it might be a datetime or time string
                  $timeString = is_string($session->appointment_time) 
                    ? $session->appointment_time 
                    : (is_object($session->appointment_time) 
                        ? $session->appointment_time->format('H:i:s') 
                        : $session->appointment_time);
                  
                  // Extract just time if it's a full datetime string (contains date part)
                  if (strlen($timeString) > 8 || strpos($timeString, '-') !== false) {
                    // If it contains a date (has dashes or is longer than time format), extract just time
                    try {
                        $parsedTime = \Carbon\Carbon::parse($timeString, 'Asia/Kolkata');
                        $timeString = $parsedTime->format('H:i:s');
                    } catch (\Exception $e) {
                        // If parsing fails, try to extract time manually
                        if (preg_match('/(\d{2}:\d{2}:\d{2})/', $timeString, $matches)) {
                            $timeString = $matches[1];
                        } elseif (preg_match('/(\d{2}:\d{2})/', $timeString, $matches)) {
                            $timeString = $matches[1] . ':00';
                        }
                    }
                  }
                  
                  // Ensure we have a valid time string (HH:MM:SS format)
                  if (strlen($timeString) <= 5) {
                      $timeString = $timeString . ':00'; // Add seconds if missing
                  }
                  
                  $appointmentDateTime = \Carbon\Carbon::parse($session->appointment_date->format('Y-m-d') . ' ' . $timeString, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
                  // Allow joining 5 minutes before appointment time or anytime after
                  // diffInMinutes(now(), false) returns negative for future times, positive for past times
                  $nowIST = \Carbon\Carbon::now('Asia/Kolkata');
                  $minutesDiff = $appointmentDateTime->diffInMinutes($nowIST, false);
                  $canJoin = $minutesDiff >= -5; // True if within 5 minutes before or anytime after
                  $sessionEndTime = $appointmentDateTime->copy()->addMinutes($session->duration_minutes ?? 60);
                  $isSessionExpired = $nowIST->greaterThan($sessionEndTime);
                  
                  // Show join button if time has arrived (or within 5 min) AND status allows it AND admin activated
                  // Allow join button even if status is still 'scheduled' as long as we're within 5 minutes (cron may not have run yet)
                  $isVideoOrAudio = in_array($session->session_mode, ['video', 'audio']);
                  $isActivated = $session->is_activated_by_admin;
                  $statusCheck = in_array($session->status, ['confirmed', 'in_progress']) || 
                    ($session->status === 'scheduled' && ($appointmentDateTime->isPast() || $canJoin));
                  
                  $isActive = $canJoin && !$isSessionExpired && $isVideoOrAudio && $isActivated && $statusCheck;
                @endphp
                
                <div style="display: flex; flex-direction: column; gap: 8px;">
                  @if($session->status === 'scheduled')
                    @if($session->is_activated_by_admin)
                      <span class="status-badge upcoming">Activated</span>
                      <small class="text-success" style="font-size: 0.7rem;">
                        <i class="ri-checkbox-circle-line"></i> Ready
                      </small>
                    @else
                      <span class="status-badge pending">Pending</span>
                      <small class="text-warning" style="font-size: 0.7rem;">
                        <i class="ri-time-line"></i> Waiting Activation
                      </small>
                    @endif
                  @elseif($session->status === 'confirmed')
                    <span class="status-badge upcoming">Upcoming</span>
                    @if($session->is_activated_by_admin)
                      <small class="text-success" style="font-size: 0.7rem;">
                        <i class="ri-checkbox-circle-line"></i> Activated
                      </small>
                    @endif
                  @elseif($session->status === 'completed')
                    <span class="status-badge completed">Completed</span>
                  @elseif($session->status === 'cancelled')
                    @if($session->cancelled_by == auth()->id())
                      <span class="status-badge cancel">Cancel by Me</span>
                    @else
                      <span class="status-badge cancelled">Cancelled by Client</span>
                    @endif
                  @elseif($session->appointment_date < now()->toDateString() && !in_array($session->status, ['completed', 'cancelled']))
                    <span class="status-badge expired">Expired</span>
                  @else
                    <span class="status-badge">{{ strtoupper($session->status) }}</span>
                  @endif
                  
                  @if($isActive && in_array($session->session_mode, ['video', 'audio']))
                    <a href="{{ route('sessions.join', $session->id) }}" class="btn btn-sm btn-success" style="white-space: nowrap;" target="_blank">
                      <i class="ri-{{ $session->session_mode === 'video' ? 'video' : 'mic' }}-line me-1"></i>
                      Join Session
                    </a>
                  @elseif(!empty($isSessionExpired) && $isSessionExpired)
                    <button class="btn btn-sm btn-outline-secondary" disabled style="white-space: nowrap; font-size: 0.75rem;">
                      <i class="ri-timer-line me-1"></i>
                      Session Expired
                    </button>
                  @elseif($session->is_activated_by_admin && $session->status === 'scheduled' && !$isActive)
                    <button class="btn btn-sm btn-outline-secondary" disabled style="white-space: nowrap; font-size: 0.75rem;">
                      <i class="ri-time-line me-1"></i>
                      Available {{ $appointmentDateTime->copy()->subMinutes(5)->diffForHumans() }}
                    </button>
                  @elseif(!$session->is_activated_by_admin)
                    <button class="btn btn-sm btn-outline-warning" disabled style="white-space: nowrap; font-size: 0.75rem;">
                      <i class="ri-time-line me-1"></i>
                      Waiting Activation
                    </button>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7">
                <div class="empty-state">
                  <div class="empty-state-icon">
                    <i class="ri-calendar-line"></i>
                  </div>
                  <h5>No sessions found</h5>
                  <p>There are no sessions matching your current filter criteria.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($sessions->hasPages() || $sessions->total() > 0)
      <div class="pagination-wrapper">
        <div class="pagination-info">
          @if($sessions->total() > 0)
            Showing {{ $sessions->firstItem() }} to {{ $sessions->lastItem() }} of {{ $sessions->total() }} sessions
          @endif
        </div>
        <div class="pagination-controls">
          @if($sessions->hasPages())
            <span style="font-size: 0.875rem; color: #6b7280; margin-right: 0.5rem;">
              Page {{ $sessions->currentPage() }} of {{ $sessions->lastPage() }}
            </span>
            @if($sessions->onFirstPage())
              <button class="page-btn" disabled><i class="ri-arrow-left-double-line"></i></button>
              <button class="page-btn" disabled><i class="ri-arrow-left-line"></i></button>
            @else
              <a href="{{ $sessions->url(1) }}" class="page-btn"><i class="ri-arrow-left-double-line"></i></a>
              <a href="{{ $sessions->previousPageUrl() }}" class="page-btn"><i class="ri-arrow-left-line"></i></a>
            @endif
            @if($sessions->hasMorePages())
              <a href="{{ $sessions->nextPageUrl() }}" class="page-btn"><i class="ri-arrow-right-line"></i></a>
              <a href="{{ $sessions->url($sessions->lastPage()) }}" class="page-btn"><i class="ri-arrow-right-double-line"></i></a>
            @else
              <button class="page-btn" disabled><i class="ri-arrow-right-line"></i></button>
              <button class="page-btn" disabled><i class="ri-arrow-right-double-line"></i></button>
            @endif
          @endif
          <select class="per-page-select" onchange="updatePerPage(this.value)">
            <option value="10" {{ $sessions->perPage() == 10 ? 'selected' : '' }}>10 rows</option>
            <option value="25" {{ $sessions->perPage() == 25 ? 'selected' : '' }}>25 rows</option>
            <option value="50" {{ $sessions->perPage() == 50 ? 'selected' : '' }}>50 rows</option>
            <option value="100" {{ $sessions->perPage() == 100 ? 'selected' : '' }}>100 rows</option>
          </select>
        </div>
      </div>
    @endif
  </div>
</div>
@endsection

@section('page-script')
<script>
  function updatePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    window.location.href = url.toString();
  }
</script>
@endsection
