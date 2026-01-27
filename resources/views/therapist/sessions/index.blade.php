@extends('layouts/contentNavbarLayout')

@section('title', 'Online Sessions')

@section('page-style')
<style>
:root {
    --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
    --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    --info-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

  /* === Sessions Page Custom Styles === */
  .page-header {
    background: var(--theme-gradient);
    border-radius: 14px;
    padding: 1.25rem 1.75rem;
    margin-bottom: 1.25rem;
    position: relative;
    overflow: hidden;
  }

  .page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  .page-header::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 150px;
    height: 150px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
  }

  .header-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    backdrop-filter: blur(10px);
  }

  .page-header h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 0.25rem;
    position: relative;
    z-index: 1;
    font-size: 1.35rem;
  }

  .page-header p {
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 0;
    position: relative;
    z-index: 1;
    font-size: 0.875rem;
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

  .session-tab:not(.active):active {
    background: #e5e7eb;
    color: #374151;
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
    background: transparent;
    border-radius: 0;
    box-shadow: none;
    overflow: visible;
  }

  .sessions-card .card-header {
    display: none;
  }

  .sessions-card .card-body {
    padding: 0;
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

  .btn-search:active {
    box-shadow: 0 2px 8px rgba(5, 150, 105, 0.3);
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

  .btn-refresh:active {
    background: #059669;
    color: white;
  }

  /* Session Cards */
  .session-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    overflow: hidden;
    position: relative;
    margin-bottom: 0.5rem;
    border-left: 4px solid transparent;
  }

  .session-card:nth-child(even) {
    background: #fafbfc;
    border-left-color: #667eea;
  }

  .session-card:nth-child(odd) {
    border-left-color: #764ba2;
  }

  .session-card .card-body {
    padding: 0.875rem 1.25rem;
  }

  /* Client Avatar */
  .client-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid #f0f2ff;
    box-shadow: 0 1px 4px rgba(102, 126, 234, 0.1);
  }

  .client-avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--theme-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 700;
    color: white;
  }

  .client-info h6 {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0;
    font-size: 0.875rem;
    line-height: 1.2;
  }

  .client-info small {
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 0.2rem;
    font-size: 0.65rem;
  }

  /* Session Details */
  .detail-item {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
    padding: 0.35rem 0.65rem;
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border-radius: 8px;
    border: 1px solid rgba(102, 126, 234, 0.1);
    margin-right: 0.5rem;
  }

  .detail-icon {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--theme-gradient);
    color: white;
    font-size: 0.75rem;
    flex-shrink: 0;
    box-shadow: 0 1px 3px rgba(102, 126, 234, 0.2);
  }

  .detail-text {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.8rem;
    line-height: 1.3;
    white-space: nowrap;
  }

  /* Session Type Badges */
  .session-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.3rem 0.65rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    margin: 0;
    margin-right: 0.5rem;
    box-shadow: 0 1px 2px rgba(0,0,0,0.08);
  }

  .session-badge.video {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
    color: #2563eb;
  }

  .session-badge.audio {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    color: #059669;
  }

  .session-badge.chat {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(124, 58, 237, 0.15) 100%);
    color: #7c3aed;
  }

  .type-badge {
    background: linear-gradient(135deg, rgba(107, 114, 128, 0.1) 0%, rgba(75, 85, 99, 0.1) 100%);
    color: #4b5563;
    padding: 0.3rem 0.65rem;
    border-radius: 8px;
    font-size: 0.7rem;
    font-weight: 600;
    border: 1px solid rgba(107, 114, 128, 0.15);
    display: inline-block;
  }

  /* Status Badge */
  .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    box-shadow: 0 1px 2px rgba(0,0,0,0.08);
  }

  .status-badge.scheduled {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.15) 100%);
    color: #d97706;
  }

  .status-badge.confirmed {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    color: #059669;
  }

  .status-badge.in_progress {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
    color: #2563eb;
  }

  .status-badge.completed {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    color: #667eea;
  }

  .status-badge.cancelled, .status-badge.cancel {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
    color: #dc2626;
  }

  .status-badge.expired {
    background: linear-gradient(135deg, rgba(75, 85, 99, 0.15) 0%, rgba(55, 65, 81, 0.15) 100%);
    color: #374151;
  }

  .status-badge.pending {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.15) 100%);
    color: #d97706;
  }

  .status-badge.upcoming {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
    color: #2563eb;
  }

  /* Action Buttons */
  .action-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    border: none;
    text-decoration: none;
    box-shadow: 0 1px 2px rgba(0,0,0,0.08);
    cursor: pointer;
  }

  .action-btn.join {
    background: var(--success-gradient);
    color: white;
    padding: 0.4rem 0.85rem;
    width: auto;
    height: auto;
    font-size: 0.8rem;
    font-weight: 600;
    gap: 0.35rem;
    box-shadow: 0 1px 4px rgba(16, 185, 129, 0.25);
  }

  .action-btn.view {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    color: #667eea;
  }

  .action-btn.disabled {
    background: #f3f4f6;
    color: #6b7280;
    cursor: not-allowed;
    padding: 0.4rem 0.85rem;
    width: auto;
    height: auto;
    font-size: 0.75rem;
  }

  .action-btn.disabled.expired {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
    border: 1px solid #fca5a5;
  }

  .action-btn.disabled.waiting {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
    border: 1px solid #fcd34d;
  }

  .action-btn.disabled.not-available {
    background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
    color: #4b5563;
    border: 1px solid #9ca3af;
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

  .page-btn:active:not(:disabled) {
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

  @keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
  }

  .live-indicator {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
    margin-right: 0.5rem;
  }

  .live-indicator::before {
    content: '';
    width: 6px;
    height: 6px;
    background: white;
    border-radius: 50%;
    animation: blink 1s infinite;
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

    .session-card .card-body {
      padding: 0.75rem 1rem;
    }
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 position-relative" style="z-index: 1;">
    <div class="d-flex align-items-center gap-3">
      <div class="header-icon">
        <i class="ri-video-chat-line"></i>
      </div>
      <div>
        <h4 class="mb-1">
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
        <p class="mb-0">Manage and track all your therapy sessions in one place</p>
      </div>
    </div>
  </div>
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
    <div class="filters-row mb-3">
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

    <!-- Sessions List -->
    @if($sessions->count() > 0)
      <div class="row g-2">
        @foreach($sessions as $session)
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
            $nowIST = \Carbon\Carbon::now('Asia/Kolkata');
            $minutesDiff = $appointmentDateTime->diffInMinutes($nowIST, false);
            $canJoin = $minutesDiff >= -5; // True if within 5 minutes before or anytime after
            $sessionEndTime = $appointmentDateTime->copy()->addMinutes($session->duration_minutes ?? 60);
            $isSessionExpired = $nowIST->greaterThan($sessionEndTime);

            // Show join button if time has arrived (or within 5 min) AND status allows it AND session mode is video/audio
            $isVideoOrAudio = in_array($session->session_mode, ['video', 'audio']);
            $statusCheck = in_array($session->status, ['confirmed', 'in_progress']) ||
                ($session->status === 'scheduled' && ($appointmentDateTime->lessThan($nowIST) || $canJoin));

            $isActive = $canJoin && !$isSessionExpired && $isVideoOrAudio && $statusCheck;
            $isLive = $session->status === 'in_progress';
            $isToday = $session->appointment_date->isToday();
        @endphp
        <div class="col-12">
            <div class="card session-card">
                <div class="card-body">
                    <div class="row align-items-center g-2">
                        <!-- Client Info -->
                        <div class="col-lg-2 col-md-3 mb-0">
                            <div class="d-flex align-items-center" style="gap: 0.5rem;">
                                @if($session->client)
                                    @if($session->client->profile && $session->client->profile->profile_image)
                                        <img src="{{ asset('storage/' . $session->client->profile->profile_image) }}" alt="{{ $session->client->name }}" class="client-avatar">
                                    @elseif($session->client->getRawOriginal('avatar'))
                                        <img src="{{ asset('storage/' . $session->client->getRawOriginal('avatar')) }}" alt="{{ $session->client->name }}" class="client-avatar">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($session->client->name ?? 'N') }}&background=667eea&color=fff&size=80&bold=true&format=svg" alt="{{ $session->client->name }}" class="client-avatar">
                                    @endif
                                @else
                                    <div class="client-avatar-placeholder">
                                        N
                                    </div>
                                @endif
                                <div class="client-info">
                                    <h6>{{ $session->client->name ?? 'N/A' }}</h6>
                                    <small>
                                        <i class="ri-user-line"></i>Client
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Session Details -->
                        <div class="col-lg-3 col-md-4 mb-0">
                            <div class="d-flex align-items-center flex-wrap" style="gap: 0.25rem;">
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="ri-calendar-line"></i>
                                    </div>
                                    <span class="detail-text">
                                        @if($isToday)
                                            <span class="text-success fw-bold">Today</span>
                                        @else
                                            {{ $session->appointment_date->format('M d, Y') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="ri-time-line"></i>
                                    </div>
                                    <span class="detail-text">
                                        @php
                                          $startTime = \Carbon\Carbon::parse($timeString, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
                                          $endTime = $startTime->copy()->addMinutes($session->duration_minutes ?? 60);
                                        @endphp
                                        {{ $startTime->format('g:i A') }} - {{ $endTime->format('g:i A') }} IST
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Session Mode & Status -->
                        <div class="col-lg-2 col-md-3 mb-0">
                            <div class="d-flex align-items-center flex-wrap" style="gap: 0.5rem;">
                                @if($isLive)
                                    <span class="live-indicator">Live</span>
                                @endif
                                <span class="session-badge {{ $session->session_mode }}">
                                    <i class="ri-{{ $session->session_mode === 'video' ? 'video' : ($session->session_mode === 'audio' ? 'mic' : 'chat-3') }}-line"></i>
                                    {{ ucfirst($session->session_mode) }}
                                </span>
                                <span class="status-badge {{ $session->status }}">
                                    <i class="ri-{{ $session->status === 'in_progress' ? 'broadcast' : ($session->status === 'confirmed' ? 'check-double' : ($session->status === 'completed' ? 'checkbox-circle' : ($session->status === 'cancelled' ? 'close-circle' : 'time'))) }}-line"></i>
                                    @if($session->status === 'scheduled')
                                        Scheduled
                                    @elseif($session->status === 'confirmed')
                                        Upcoming
                                    @elseif($session->status === 'completed')
                                        Completed
                                    @elseif($session->status === 'cancelled')
                                        @if($session->cancelled_by == auth()->id())
                                            Cancel by Me
                                        @else
                                            Cancelled by Client
                                        @endif
                                    @elseif($session->appointment_date < \Carbon\Carbon::now('Asia/Kolkata')->toDateString() && !in_array($session->status, ['completed', 'cancelled']))
                                        Expired
                                    @else
                                        {{ ucfirst(str_replace('_', ' ', $session->status)) }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Session Type -->
                        <div class="col-lg-2 col-md-2 mb-0">
                            <span class="type-badge">{{ ucfirst($session->appointment_type ?? 'Session') }}</span>
                        </div>

                        <!-- Actions -->
                        <div class="col-lg-3 col-md-12 mb-0">
                            <div class="d-flex align-items-center justify-content-lg-end justify-content-start" style="gap: 0.5rem;">
                                @if($isSessionExpired)
                                    <span class="status-badge expired">
                                        <i class="ri-time-off-line"></i>Expired
                                    </span>
                                @elseif($isActive && in_array($session->session_mode, ['video', 'audio']))
                                    <a href="{{ route('sessions.join', $session->id) }}" class="action-btn join" title="Join Session" target="_blank">
                                        <i class="ri-{{ $session->session_mode === 'video' ? 'video' : 'mic' }}-line me-1"></i>Join Session
                                    </a>
                                @elseif(!$isVideoOrAudio)
                                    <button class="action-btn disabled not-available" disabled title="Session mode is {{ $session->session_mode }} (only video/audio sessions can be joined)">
                                        <i class="ri-video-off-line"></i>
                                        <span>Not Available</span>
                                    </button>
                                @elseif(!$canJoin)
                                    @php
                                        $joinAvailableAt = $appointmentDateTime->copy()->subMinutes(5);
                                        $timeUntilJoin = $joinAvailableAt->diffForHumans($nowIST, ['syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW]);
                                    @endphp
                                    <button class="action-btn disabled waiting" disabled title="Join button will be available {{ $timeUntilJoin }} (at {{ $joinAvailableAt->format('g:i A') }} IST)">
                                        <i class="ri-time-line"></i>
                                        <span>Available {{ $timeUntilJoin }}</span>
                                    </button>
                                @else
                                    <button class="action-btn disabled not-available" disabled title="Session not available at this time">
                                        <i class="ri-information-line"></i>
                                        <span>Not Available</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
      </div>
    @else
      <!-- Empty State -->
      <div class="empty-state">
        <div class="empty-state-icon">
          <i class="ri-calendar-line"></i>
        </div>
        <h5>No sessions found</h5>
        <p>There are no sessions matching your current filter criteria.</p>
      </div>
    @endif

    <!-- Pagination -->
    @if($sessions->hasPages() || $sessions->total() > 0)
      <div class="d-flex justify-content-center mt-5 mb-4">
        {{ $sessions->links() }}
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
