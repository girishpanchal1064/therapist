@extends('layouts/contentNavbarLayout')

@section('title', 'Online Sessions')

@section('page-style')
<style>
  .layout-page .content-wrapper { background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important; }

  .therapist-sessions-apni .filters-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.25rem;
  }
  .therapist-sessions-apni .search-box {
    display: flex;
    gap: 0.5rem;
    flex: 1;
    max-width: 420px;
  }
  .therapist-sessions-apni .search-input {
    flex: 1;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid rgba(186, 194, 210, 0.85);
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%237484a4'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E") no-repeat 0.875rem center;
    background-size: 18px;
  }
  .therapist-sessions-apni .search-input:focus {
    outline: none;
    border-color: #041c54;
    background-color: #fff;
    box-shadow: 0 0 0 4px rgba(4, 28, 84, 0.12);
  }
  .therapist-sessions-apni .btn-search {
    padding: 0.75rem 1.15rem;
    background: #041c54;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: background 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.2);
  }
  .therapist-sessions-apni .btn-search:hover {
    background: #052a66;
    color: #fff;
  }
  .therapist-sessions-apni .btn-refresh {
    padding: 0.75rem 1.25rem;
    background: #fff;
    color: #041c54;
    border: 2px solid rgba(4, 28, 84, 0.35);
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }
  .therapist-sessions-apni .btn-refresh:hover {
    background: rgba(4, 28, 84, 0.06);
    border-color: #041c54;
    color: #041c54;
  }

  .therapist-sessions-apni .session-card {
    background: #fff;
    border: 1px solid rgba(186, 194, 210, 0.55);
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(4, 28, 84, 0.04);
    overflow: hidden;
    margin-bottom: 0.5rem;
    border-left: 4px solid #647494;
  }
  .therapist-sessions-apni .session-card:nth-child(even) {
    background: rgba(186, 194, 210, 0.06);
    border-left-color: #041c54;
  }
  .therapist-sessions-apni .session-card .card-body {
    padding: 0.875rem 1.25rem;
  }

  .therapist-sessions-apni .client-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid rgba(186, 194, 210, 0.6);
    box-shadow: 0 1px 4px rgba(4, 28, 84, 0.08);
  }
  .therapist-sessions-apni .client-avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: #041c54;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 700;
    color: #fff;
  }
  .therapist-sessions-apni .client-info h6 {
    font-weight: 600;
    color: #041c54;
    margin-bottom: 0;
    font-size: 0.875rem;
    line-height: 1.2;
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
  }
  .therapist-sessions-apni .client-info small {
    color: #7484a4;
    display: flex;
    align-items: center;
    gap: 0.2rem;
    font-size: 0.65rem;
  }

  .therapist-sessions-apni .detail-item {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0 0.5rem 0 0;
    padding: 0.35rem 0.65rem;
    background: rgba(186, 194, 210, 0.2);
    border-radius: 8px;
    border: 1px solid rgba(100, 116, 148, 0.15);
  }
  .therapist-sessions-apni .detail-icon {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #647494;
    color: #fff;
    font-size: 0.75rem;
    flex-shrink: 0;
  }
  .therapist-sessions-apni .detail-text {
    font-weight: 600;
    color: #041c54;
    font-size: 0.8rem;
    line-height: 1.3;
    white-space: nowrap;
  }

  .therapist-sessions-apni .session-badge.video {
    background: rgba(59, 130, 246, 0.12);
    color: #2563eb;
  }
  .therapist-sessions-apni .session-badge.audio {
    background: rgba(16, 185, 129, 0.12);
    color: #059669;
  }
  .therapist-sessions-apni .session-badge.chat {
    background: rgba(100, 116, 148, 0.15);
    color: #4d5d78;
  }
  .therapist-sessions-apni .type-badge {
    background: rgba(186, 194, 210, 0.25);
    color: #4d5d78;
    padding: 0.3rem 0.65rem;
    border-radius: 8px;
    font-size: 0.7rem;
    font-weight: 600;
    border: 1px solid rgba(100, 116, 148, 0.2);
    display: inline-block;
  }

  .therapist-sessions-apni .session-badge,
  .therapist-sessions-apni .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.3rem 0.65rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    margin: 0 0.5rem 0 0;
  }
  .therapist-sessions-apni .status-badge.scheduled,
  .therapist-sessions-apni .status-badge.pending {
    background: rgba(245, 158, 11, 0.15);
    color: #b45309;
  }
  .therapist-sessions-apni .status-badge.confirmed {
    background: rgba(16, 185, 129, 0.15);
    color: #059669;
  }
  .therapist-sessions-apni .status-badge.in_progress {
    background: rgba(59, 130, 246, 0.15);
    color: #2563eb;
  }
  .therapist-sessions-apni .status-badge.completed {
    background: rgba(100, 116, 148, 0.18);
    color: #4d5d78;
  }
  .therapist-sessions-apni .status-badge.cancelled,
  .therapist-sessions-apni .status-badge.cancel {
    background: rgba(239, 68, 68, 0.12);
    color: #dc2626;
  }
  .therapist-sessions-apni .status-badge.expired {
    background: rgba(75, 85, 99, 0.12);
    color: #4b5563;
  }

  .therapist-sessions-apni .action-btn.join {
    background: #10b981;
    color: #fff;
    padding: 0.45rem 0.9rem;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    text-decoration: none;
    border: none;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
  }
  .therapist-sessions-apni .action-btn.join:hover {
    background: #059669;
    color: #fff;
  }
  .therapist-sessions-apni .action-btn.disabled {
    background: #f1f5f9;
    color: #7484a4;
    cursor: not-allowed;
    padding: 0.4rem 0.85rem;
    border-radius: 10px;
    font-size: 0.75rem;
    border: 1px solid rgba(186, 194, 210, 0.8);
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
  }
  .therapist-sessions-apni .action-btn.disabled.expired {
    background: #fef2f2;
    color: #991b1b;
    border-color: #fecaca;
  }
  .therapist-sessions-apni .action-btn.disabled.waiting {
    background: #fffbeb;
    color: #92400e;
    border-color: #fde68a;
  }
  .therapist-sessions-apni .action-btn.disabled.not-available {
    background: #f8fafc;
    color: #647494;
    border-color: #cbd5e1;
  }

  @keyframes therapist-sessions-blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
  }
  .therapist-sessions-apni .live-indicator {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #fff;
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    margin-right: 0.5rem;
  }
  .therapist-sessions-apni .live-indicator::before {
    content: '';
    width: 6px;
    height: 6px;
    background: #fff;
    border-radius: 50%;
    animation: therapist-sessions-blink 1s infinite;
  }

  .therapist-sessions-apni .empty-state {
    text-align: center;
    padding: 3.5rem 1.5rem;
  }
  .therapist-sessions-apni .empty-state-icon {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    background: rgba(100, 116, 148, 0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 2.25rem;
    color: #647494;
  }
  .therapist-sessions-apni .empty-state h5 {
    font-weight: 600;
    color: #041c54;
    margin-bottom: 0.5rem;
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
  }
  .therapist-sessions-apni .empty-state p {
    color: #7484a4;
    font-size: 0.9375rem;
    margin: 0;
  }

  .therapist-sessions-apni .pagination {
    margin-bottom: 0;
  }
  .therapist-sessions-apni .page-link {
    color: #041c54;
    border-color: rgba(186, 194, 210, 0.8);
    border-radius: 8px !important;
    margin: 0 2px;
  }
  .therapist-sessions-apni .page-item.active .page-link {
    background: #041c54;
    border-color: #041c54;
    color: #fff;
  }
  .therapist-sessions-apni .page-link:hover {
    color: #041c54;
    background: rgba(4, 28, 84, 0.06);
    border-color: #647494;
  }

  @media (max-width: 768px) {
    .therapist-sessions-apni .filters-row { flex-direction: column; align-items: stretch; }
    .therapist-sessions-apni .search-box { max-width: 100%; width: 100%; }
    .therapist-sessions-apni .session-card .card-body { padding: 0.75rem 1rem; }
  }
</style>
@endsection

@php
  $tabActive = 'inline-flex items-center gap-2 rounded-[10px] border-2 border-transparent px-3 py-2 text-xs font-semibold whitespace-nowrap transition sm:px-4 sm:text-sm bg-[#041C54] text-white shadow-[0_4px_14px_rgba(4,28,84,0.28)]';
  $tabIdle = 'inline-flex items-center gap-2 rounded-[10px] border-2 border-[#BAC2D2]/50 bg-white px-3 py-2 text-xs font-semibold whitespace-nowrap text-[#7484A4] transition hover:border-[#647494]/60 hover:text-[#041C54] sm:px-4 sm:text-sm';
  $sessionsHeroTitle = match ($status) {
    'pending' => 'Pending Sessions',
    'upcoming' => 'Upcoming Sessions',
    'completed' => 'Completed Sessions',
    'cancel_by_me' => 'Cancelled By Me',
    'cancelled_by_user' => 'Cancelled By Client',
    'expired' => 'Expired Sessions',
    default => 'Online Sessions',
  };
@endphp

@section('content')
<div class="therapist-sessions-apni pb-2">
  <div class="relative mb-8 overflow-hidden rounded-3xl shadow-[0_20px_25px_-5px_rgba(100,116,148,0.2),0_8px_10px_-6px_rgba(100,116,148,0.2)]"
       style="background: #041c54;">
    <div class="pointer-events-none absolute -right-20 top-0 h-64 w-64 rounded-full bg-white/10 blur-[64px]" aria-hidden="true"></div>
    <div class="relative z-10 flex flex-col gap-6 p-6 md:flex-row md:items-center md:justify-between md:p-8">
      <div class="min-w-0">
        <h1 class="font-display flex items-center gap-3 text-2xl font-medium leading-snug text-white md:text-3xl">
          <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[14px] bg-white/15 text-[1.5rem] backdrop-blur-sm">
            <i class="ri-video-chat-line"></i>
          </span>
          <span>{{ $sessionsHeroTitle }}</span>
        </h1>
        <p class="mt-2 max-w-xl text-base text-white/90">
          Manage and track your therapy sessions in one place.
        </p>
      </div>
      <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:items-center">
        <a href="{{ route('therapist.dashboard') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] bg-white px-5 py-2.5 text-sm font-medium text-[#041C54] shadow-md transition hover:bg-[#BAC2D2]/30">
          <i class="ri-dashboard-line text-lg"></i>
          Dashboard
        </a>
        <a href="{{ route('therapist.profile.index', ['tab' => 'basic-info']) }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] border-2 border-white px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/10">
          <i class="ri-user-settings-line text-lg"></i>
          Profile
        </a>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-2xl border border-[#10B981]/30 bg-[#ecfdf5] px-4 py-3 text-sm text-[#065f46] md:px-5" role="status">
      <i class="ri-checkbox-circle-fill mt-0.5 text-lg text-[#059669]"></i>
      <div class="min-w-0 flex-1">{{ session('success') }}</div>
    </div>
  @endif

  <div class="mb-6 overflow-x-auto rounded-2xl border border-[#BAC2D2]/30 bg-white p-3 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-4">
    <div class="flex min-w-max flex-wrap gap-2">
      <a href="{{ route('therapist.sessions.index', ['status' => 'pending']) }}" class="{{ $status === 'pending' ? $tabActive : $tabIdle }}">
        <i class="ri-time-line"></i> Pending
      </a>
      <a href="{{ route('therapist.sessions.index', ['status' => 'upcoming']) }}" class="{{ $status === 'upcoming' ? $tabActive : $tabIdle }}">
        <i class="ri-calendar-check-line"></i> Upcoming
      </a>
      <a href="{{ route('therapist.sessions.index', ['status' => 'completed']) }}" class="{{ $status === 'completed' ? $tabActive : $tabIdle }}">
        <i class="ri-checkbox-circle-line"></i> Completed
      </a>
      <a href="{{ route('therapist.sessions.index', ['status' => 'cancel_by_me']) }}" class="{{ $status === 'cancel_by_me' ? $tabActive : $tabIdle }}">
        <i class="ri-close-circle-line"></i> Cancel by Me
      </a>
      <a href="{{ route('therapist.sessions.index', ['status' => 'cancelled_by_user']) }}" class="{{ $status === 'cancelled_by_user' ? $tabActive : $tabIdle }}">
        <i class="ri-user-unfollow-line"></i> Cancelled by Client
      </a>
      <a href="{{ route('therapist.sessions.index', ['status' => 'expired']) }}" class="{{ $status === 'expired' ? $tabActive : $tabIdle }}">
        <i class="ri-history-line"></i> Expired
      </a>
    </div>
  </div>

  <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-4 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
    <div class="filters-row">
      <form method="GET" action="{{ route('therapist.sessions.index') }}" class="search-box">
        <input type="hidden" name="status" value="{{ $status }}">
        <input type="text" name="search" class="search-input" placeholder="Search by client name..." value="{{ $search }}">
        <button type="submit" class="btn-search" aria-label="Search">
          <i class="ri-search-line"></i>
        </button>
      </form>
      <button type="button" class="btn-refresh" onclick="location.reload()">
        <i class="ri-refresh-line"></i>
        Refresh
      </button>
    </div>

    @if($sessions->count() > 0)
      <div class="row g-2">
        @foreach($sessions as $session)
        @php
            $timeString = is_string($session->appointment_time)
                ? $session->appointment_time
                : (is_object($session->appointment_time)
                    ? $session->appointment_time->format('H:i:s')
                    : $session->appointment_time);

            if (strlen($timeString) > 8 || strpos($timeString, '-') !== false) {
                try {
                    $parsedTime = \Carbon\Carbon::parse($timeString, 'Asia/Kolkata');
                    $timeString = $parsedTime->format('H:i:s');
                } catch (\Exception $e) {
                    if (preg_match('/(\d{2}:\d{2}:\d{2})/', $timeString, $matches)) {
                        $timeString = $matches[1];
                    } elseif (preg_match('/(\d{2}:\d{2})/', $timeString, $matches)) {
                        $timeString = $matches[1] . ':00';
                    }
                }
            }

            if (strlen($timeString) <= 5) {
                $timeString = $timeString . ':00';
            }

            $appointmentDateTime = \Carbon\Carbon::parse($session->appointment_date->format('Y-m-d') . ' ' . $timeString, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
            $nowIST = \Carbon\Carbon::now('Asia/Kolkata');
            $minutesDiff = $appointmentDateTime->diffInMinutes($nowIST, false);
            $canJoin = $minutesDiff >= -5;
            $sessionEndTime = $appointmentDateTime->copy()->addMinutes($session->duration_minutes ?? 60);
            $isSessionExpired = $nowIST->greaterThan($sessionEndTime);

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
                        <div class="col-lg-2 col-md-3 mb-0">
                            <div class="d-flex align-items-center" style="gap: 0.5rem;">
                                @if($session->client)
                                    @if($session->client->profile && $session->client->profile->profile_image)
                                        <img src="{{ asset('storage/' . $session->client->profile->profile_image) }}" alt="{{ $session->client->name }}" class="client-avatar">
                                    @elseif($session->client->getRawOriginal('avatar'))
                                        <img src="{{ asset('storage/' . $session->client->getRawOriginal('avatar')) }}" alt="{{ $session->client->name }}" class="client-avatar">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($session->client->name ?? 'N') }}&background=647494&color=fff&size=80&bold=true&format=svg" alt="{{ $session->client->name }}" class="client-avatar">
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

                        <div class="col-lg-2 col-md-2 mb-0">
                            <span class="type-badge">{{ ucfirst($session->appointment_type ?? 'Session') }}</span>
                        </div>

                        <div class="col-lg-3 col-md-12 mb-0">
                            <div class="d-flex align-items-center justify-content-lg-end justify-content-start" style="gap: 0.5rem;">
                                @if($isSessionExpired)
                                    <span class="status-badge expired">
                                        <i class="ri-time-off-line"></i>Expired
                                    </span>
                                @elseif($isActive && in_array($session->session_mode, ['video', 'audio']))
                                    <a href="{{ route('sessions.join', $session->id) }}" class="action-btn join" title="Join Session" target="_blank" rel="noopener noreferrer">
                                        <i class="ri-{{ $session->session_mode === 'video' ? 'video' : 'mic' }}-line me-1"></i>Join Session
                                    </a>
                                @elseif(!$isVideoOrAudio)
                                    <button type="button" class="action-btn disabled not-available" disabled title="Session mode is {{ $session->session_mode }} (only video/audio sessions can be joined)">
                                        <i class="ri-video-off-line"></i>
                                        <span>Not Available</span>
                                    </button>
                                @elseif(!$canJoin)
                                    @php
                                        $joinAvailableAt = $appointmentDateTime->copy()->subMinutes(5);
                                        $timeUntilJoin = $joinAvailableAt->diffForHumans($nowIST, ['syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW]);
                                    @endphp
                                    <button type="button" class="action-btn disabled waiting" disabled title="Join button will be available {{ $timeUntilJoin }} (at {{ $joinAvailableAt->format('g:i A') }} IST)">
                                        <i class="ri-time-line"></i>
                                        <span>Available {{ $timeUntilJoin }}</span>
                                    </button>
                                @else
                                    <button type="button" class="action-btn disabled not-available" disabled title="Session not available at this time">
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
      <div class="empty-state">
        <div class="empty-state-icon">
          <i class="ri-calendar-line"></i>
        </div>
        <h5>No sessions found</h5>
        <p>There are no sessions matching your current filter criteria.</p>
      </div>
    @endif

    @if($sessions->hasPages() || $sessions->total() > 0)
      <div class="d-flex justify-content-center mt-4 pt-4" style="border-top: 1px solid rgba(186, 194, 210, 0.45);">
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
