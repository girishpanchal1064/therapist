@extends('layouts/contentNavbarLayout')

@section('title', 'My Sessions')

@section('page-style')
<style>
:root {
    --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
    --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    --info-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

/* Page Header */
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

.btn-book-new {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.6rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-book-new:hover {
    background: white;
    color: #667eea;
    border-color: white;
    transform: translateY(-2px);
}

/* Alert Styling */
.alert-themed {
    border: none;
    border-radius: 14px;
    border-left: 5px solid;
    padding: 1rem 1.25rem;
}

.alert-themed.alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border-left-color: #10b981;
    color: #065f46;
}

.alert-themed.alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border-left-color: #ef4444;
    color: #991b1b;
}

.alert-themed.alert-info {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border-left-color: #3b82f6;
    color: #1e40af;
}

/* Summary Card */
.summary-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.summary-item {
    text-align: center;
    padding: 0.5rem;
}

.summary-value {
    font-size: 1.5rem;
    font-weight: 700;
    background: var(--theme-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.25rem;
    display: block;
}

.summary-label {
    font-size: 0.75rem;
    color: #6b7280;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Session Cards */
.session-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: all 0.2s ease;
    overflow: hidden;
    position: relative;
}

.session-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--theme-gradient);
    opacity: 0;
    transition: opacity 0.2s ease;
}

.session-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    border-color: #667eea;
}

.session-card:hover::before {
    opacity: 1;
}

.session-card .card-body {
    padding: 0.75rem 1rem;
}

/* Therapist Avatar */
.therapist-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid #f0f2ff;
    box-shadow: 0 1px 4px rgba(102, 126, 234, 0.1);
}

.therapist-avatar-placeholder {
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

.therapist-info h6 {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.1rem;
    font-size: 0.875rem;
    line-height: 1.2;
}

.therapist-info small {
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 0.2rem;
    font-size: 0.7rem;
}

/* Session Details */
.detail-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.35rem;
    padding: 0.3rem 0.5rem;
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border-radius: 6px;
}

.detail-item:last-child {
    margin-bottom: 0;
}

.detail-icon {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--theme-gradient);
    color: white;
    font-size: 0.8rem;
    flex-shrink: 0;
}

.detail-text {
    font-weight: 600;
    color: #374151;
    font-size: 0.8rem;
    line-height: 1.3;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
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
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Session Type Badges */
.session-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 0.35rem;
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
    border-radius: 18px;
    font-size: 0.7rem;
    font-weight: 600;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.action-btn {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    border: none;
    font-size: 0.875rem;
    font-weight: 600;
    white-space: nowrap;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none;
}

.action-btn:hover {
    transform: translateY(-2px);
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
}

.action-btn.join:hover {
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    color: white;
    transform: translateY(-2px);
}

.action-btn.view {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    color: #667eea;
}

.action-btn.view:hover {
    background: var(--theme-gradient);
    color: white;
    transform: translateY(-2px);
}

.action-btn.disabled {
    background: #f3f4f6;
    color: #6b7280;
    cursor: not-allowed;
    transform: none;
    padding: 0.5rem 1rem;
    width: auto;
    height: auto;
    font-size: 0.875rem;
    position: relative;
}

.action-btn.disabled:hover {
    transform: none;
    box-shadow: none;
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

/* Live Indicator */
.live-indicator {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    padding: 0.25rem 0.6rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
}

.live-indicator::before {
    content: '';
    width: 6px;
    height: 6px;
    background: white;
    border-radius: 50%;
    animation: blink 1s infinite;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-state-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
}

.empty-state-icon i {
    font-size: 2.5rem;
    background: var(--theme-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.empty-state h5 {
    color: #1f2937;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 1.25rem;
    font-size: 0.9rem;
}

.btn-book {
    background: var(--theme-gradient);
    border: none;
    color: white;
    padding: 0.75rem 1.75rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-book:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1rem 1.25rem;
    }
    
    .header-icon {
        width: 42px;
        height: 42px;
        font-size: 1.25rem;
    }
    
    .page-header h4 {
        font-size: 1.15rem;
    }
    
    .session-card .card-body {
        padding: 0.85rem 1rem;
    }
    
    .therapist-avatar {
        width: 42px;
        height: 42px;
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        font-size: 0.85rem;
    }
    
    .action-btn.join {
        padding: 0.35rem 0.7rem;
        font-size: 0.75rem;
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
                <h4 class="mb-1">My Sessions</h4>
                <p class="mb-0">View and join your upcoming therapy sessions</p>
            </div>
        </div>
        <a href="{{ route('therapists.index') }}" class="btn btn-book-new">
            <i class="ri-add-circle-line me-2"></i>Book New Session
        </a>
    </div>
</div>

<!-- Alerts -->
@if(session('success'))
    <div class="alert alert-themed alert-success alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="ri-checkbox-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-themed alert-danger alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="ri-error-warning-fill me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-themed alert-info alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="ri-information-fill me-2 fs-5"></i>
            <div>{{ session('info') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Summary Card -->
@if($sessions->count() > 0)
<div class="summary-card">
    <div class="row g-3 text-center">
        <div class="col-md-4">
            <div class="summary-item">
                <span class="summary-value">{{ $sessions->total() }}</span>
                <span class="summary-label">Total Sessions</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-item">
                <span class="summary-value">{{ $sessions->whereIn('status', ['confirmed', 'in_progress'])->count() }}</span>
                <span class="summary-label">Active Sessions</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-item">
                <span class="summary-value">{{ $sessions->where('status', 'scheduled')->count() }}</span>
                <span class="summary-label">Pending Sessions</span>
            </div>
        </div>
    </div>
</div>
@endif

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
            // diffInMinutes(now(), false) returns negative for future times, positive for past times
            // So if appointment is 3 minutes away, it returns -3, and -3 >= -5 is TRUE
            $nowIST = \Carbon\Carbon::now('Asia/Kolkata');
            $minutesDiff = $appointmentDateTime->diffInMinutes($nowIST, false);
            $canJoin = $minutesDiff >= -5; // True if within 5 minutes before or anytime after
            $sessionEndTime = $appointmentDateTime->copy()->addMinutes($session->duration_minutes ?? 60);
            $isSessionExpired = $nowIST->greaterThan($sessionEndTime);
            
            // Show join button if time has arrived (or within 5 min) AND status allows it AND session mode is video/audio AND admin activated
            // Allow join button even if status is still 'scheduled' as long as we're within 5 minutes (cron may not have run yet)
            $isVideoOrAudio = in_array($session->session_mode, ['video', 'audio']);
            $isActivated = $session->is_activated_by_admin;
            $statusCheck = in_array($session->status, ['confirmed', 'in_progress']) || 
                ($session->status === 'scheduled' && ($appointmentDateTime->isPast() || $canJoin));
            
            $isActive = $canJoin && !$isSessionExpired && $isVideoOrAudio && $isActivated && $statusCheck;
            $isLive = $session->status === 'in_progress';
            $isToday = $session->appointment_date->isToday();
        @endphp
        <div class="col-12">
            <div class="card session-card">
                <div class="card-body">
                    <div class="row align-items-center g-2">
                        <!-- Therapist Info -->
                        <div class="col-lg-3 col-md-4 mb-1 mb-lg-0">
                            <div class="d-flex align-items-center" style="gap: 0.5rem;">
                                @if($session->therapist->therapistProfile && $session->therapist->therapistProfile->profile_image)
                                    <img src="{{ asset('storage/' . $session->therapist->therapistProfile->profile_image) }}" 
                                         alt="{{ $session->therapist->name }}" 
                                         class="therapist-avatar">
                                @elseif($session->therapist->avatar)
                                    <img src="{{ asset('storage/' . $session->therapist->avatar) }}" 
                                         alt="{{ $session->therapist->name }}" 
                                         class="therapist-avatar">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($session->therapist->name) }}&background=667eea&color=fff&size=80&bold=true&format=svg" 
                                         alt="{{ $session->therapist->name }}" 
                                         class="therapist-avatar">
                                @endif
                                <div class="therapist-info">
                                    <h6>{{ $session->therapist->name }}</h6>
                                    <small>
                                        <i class="ri-user-heart-line"></i>Therapist
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Session Details -->
                        <div class="col-lg-4 col-md-4 mb-1 mb-lg-0">
                            <div class="d-flex flex-column" style="gap: 0.25rem;">
                                <div class="detail-item mb-0">
                                    <div class="detail-icon">
                                        <i class="ri-calendar-line"></i>
                                    </div>
                                    <span class="detail-text">
                                        @if($isToday)
                                            <span class="text-success">Today</span>
                                        @else
                                            {{ $session->appointment_date->format('M d, Y') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="detail-item mb-0">
                                    <div class="detail-icon">
                                        <i class="ri-time-line"></i>
                                    </div>
                                    <div>
                                        @php
                                          $startTime = \Carbon\Carbon::parse($timeString, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
                                          $endTime = $startTime->copy()->addMinutes($session->duration_minutes ?? 60);
                                        @endphp
                                        <span class="detail-text">{{ $startTime->format('g:i A') }} IST - {{ $endTime->format('g:i A') }} IST</span>
                                        <small class="text-muted d-block" style="font-size: 0.65rem; margin-top: 1px; line-height: 1.2;">
                                          <i class="ri-timer-line"></i> {{ $session->duration_minutes }} mins
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Session Mode -->
                        <div class="col-lg-2 col-md-4 mb-1 mb-lg-0">
                            <div class="d-flex flex-column" style="gap: 0.25rem;">
                                <span class="session-badge {{ $session->session_mode }}">
                                    <i class="ri-{{ $session->session_mode === 'video' ? 'video' : ($session->session_mode === 'audio' ? 'mic' : 'chat-3') }}-line"></i>
                                    {{ ucfirst($session->session_mode) }}
                                </span>
                                <span class="type-badge">{{ ucfirst($session->appointment_type) }}</span>
                            </div>
                        </div>

                        <!-- Status & Actions -->
                        <div class="col-lg-3 col-md-12">
                            <div class="d-flex flex-column align-items-lg-end align-items-start" style="gap: 0.5rem;">
                                @if($isLive)
                                    <span class="live-indicator">Live Now</span>
                                @endif
                                <span class="status-badge {{ $session->status }}">
                                    <i class="ri-{{ $session->status === 'in_progress' ? 'broadcast' : ($session->status === 'confirmed' ? 'check-double' : 'time') }}-line"></i>
                                    {{ ucfirst(str_replace('_', ' ', $session->status)) }}
                                </span>
                                <div class="d-flex" style="gap: 0.5rem;">
                                    <a href="{{ route('client.appointments.show', $session->id) }}" 
                                       class="action-btn view" 
                                       title="View Details">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    @if($isActive)
                                        <a href="{{ route('sessions.join', $session->id) }}" 
                                           class="action-btn join" 
                                           title="Join Session"
                                           target="_blank">
                                            <i class="ri-{{ $session->session_mode === 'video' ? 'video' : 'mic' }}-line me-1"></i>Join Session
                                        </a>
                                    @elseif(!empty($isSessionExpired) && $isSessionExpired)
                                        <button class="action-btn disabled expired" disabled title="Session Expired - This session has ended">
                                            <i class="ri-time-off-line"></i>
                                            <span>Session Expired</span>
                                        </button>
                                    @elseif(!$session->is_activated_by_admin)
                                        <button class="action-btn disabled waiting" disabled title="Waiting for Admin Activation - Your session is pending approval">
                                            <i class="ri-hourglass-line"></i>
                                            <span>Waiting for Confirmation</span>
                                        </button>
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
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $sessions->links() }}
    </div>
@else
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="ri-video-chat-line"></i>
        </div>
        <h5>No upcoming sessions</h5>
        <p>You don't have any upcoming therapy sessions scheduled.<br>Book a session with one of our therapists!</p>
        <a href="{{ route('therapists.index') }}" class="btn btn-book">
            <i class="ri-add-circle-line me-2"></i>Book a Session
        </a>
    </div>
@endif
@endsection
