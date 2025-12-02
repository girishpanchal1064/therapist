@extends('layouts/contentNavbarLayout')

@section('title', 'My Sessions')

@section('page-style')
<style>
:root {
    --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
    --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    --info-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

/* Page Header */
.page-header {
    background: var(--info-gradient);
    border-radius: 20px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.page-header::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
}

.header-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    backdrop-filter: blur(10px);
}

.page-header h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.page-header p {
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 0;
    position: relative;
    z-index: 1;
}

/* Session Cards */
.session-card {
    background: white;
    border: none;
    border-radius: 20px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.session-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: var(--info-gradient);
}

.session-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.1);
}

.session-card .card-body {
    padding: 1.5rem;
}

/* Therapist Avatar */
.therapist-avatar {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    object-fit: cover;
    border: 3px solid #dbeafe;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
}

.therapist-avatar-placeholder {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: var(--info-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
}

/* Session Details */
.session-detail {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0.75rem;
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border-radius: 10px;
    margin-bottom: 0.5rem;
}

.session-detail:last-child {
    margin-bottom: 0;
}

.detail-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--info-gradient);
    color: white;
    font-size: 1rem;
}

.detail-text {
    font-weight: 600;
    color: #1e40af;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.85rem;
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

/* Join Button */
.btn-join {
    background: var(--success-gradient);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 700;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-join:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    color: white;
}

.btn-join.disabled {
    background: #d1d5db;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.btn-view {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.1) 100%);
    color: #2563eb;
    border: none;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-view:hover {
    background: var(--info-gradient);
    color: white;
}

/* Live Indicator */
.live-indicator {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
}

.live-indicator::before {
    content: '';
    width: 8px;
    height: 8px;
    background: white;
    border-radius: 50%;
    animation: blink 1s infinite;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

/* Time Badge */
.time-badge {
    background: var(--info-gradient);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.empty-state-icon i {
    font-size: 3rem;
    background: var(--info-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.empty-state h5 {
    color: #1f2937;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 1.5rem;
}

.btn-book {
    background: var(--theme-gradient);
    border: none;
    color: white;
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-book:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Session Mode */
.session-mode {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.session-mode.video {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
    color: #2563eb;
}

.session-mode.audio {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    color: #059669;
}

.session-mode.chat {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(124, 58, 237, 0.15) 100%);
    color: #7c3aed;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .session-card .card-body {
        padding: 1rem;
    }
}
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex align-items-center gap-3 position-relative" style="z-index: 1;">
        <div class="header-icon">
            <i class="ri-video-chat-line"></i>
        </div>
        <div>
            <h4 class="mb-1">My Sessions</h4>
            <p class="mb-0">View and join your upcoming therapy sessions</p>
        </div>
    </div>
</div>

<!-- Sessions List -->
@if($sessions->count() > 0)
    <div class="row g-4">
        @foreach($sessions as $session)
        @php
            $appointmentDateTime = \Carbon\Carbon::parse($session->appointment_date->format('Y-m-d') . ' ' . $session->appointment_time->format('H:i:s'));
            $canJoin = in_array($session->status, ['confirmed', 'in_progress']) && now()->gte($appointmentDateTime->copy()->subMinutes(10));
            $isLive = $session->status === 'in_progress';
            $isToday = $session->appointment_date->isToday();
        @endphp
        <div class="col-lg-6">
            <div class="session-card">
                <div class="card-body">
                    <!-- Header with Status -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-3">
                            @if($session->therapist->avatar)
                                <img src="{{ $session->therapist->avatar }}" 
                                     alt="{{ $session->therapist->name }}" 
                                     class="therapist-avatar"
                                     onerror="this.src='{{ asset('assets/img/avatars/1.png') }}'">
                            @else
                                <div class="therapist-avatar-placeholder">
                                    {{ strtoupper(substr($session->therapist->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <h6 class="fw-bold mb-1">{{ $session->therapist->name }}</h6>
                                <small class="text-muted">
                                    <i class="ri-user-heart-line me-1"></i>Therapist
                                </small>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-2">
                            @if($isLive)
                                <span class="live-indicator">Live Now</span>
                            @endif
                            <span class="status-badge {{ $session->status }}">
                                <i class="ri-{{ $session->status === 'in_progress' ? 'broadcast' : ($session->status === 'confirmed' ? 'check-double' : 'time') }}-line"></i>
                                {{ ucfirst(str_replace('_', ' ', $session->status)) }}
                            </span>
                        </div>
                    </div>

                    <!-- Session Details -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="session-detail">
                                <div class="detail-icon">
                                    <i class="ri-calendar-line"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Date</small>
                                    <span class="detail-text">
                                        @if($isToday)
                                            <span class="text-success">Today</span>
                                        @else
                                            {{ $session->appointment_date->format('M d, Y') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="session-detail">
                                <div class="detail-icon">
                                    <i class="ri-time-line"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Time</small>
                                    <span class="detail-text">{{ $session->appointment_time->format('g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="session-detail">
                                <div class="detail-icon">
                                    <i class="ri-timer-line"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Duration</small>
                                    <span class="detail-text">{{ $session->duration_minutes }} min</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="session-detail">
                                <div class="detail-icon">
                                    <i class="ri-{{ $session->session_mode === 'video' ? 'video' : ($session->session_mode === 'audio' ? 'mic' : 'chat-3') }}-line"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Mode</small>
                                    <span class="session-mode {{ $session->session_mode }}">
                                        {{ ucfirst($session->session_mode) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        @if($canJoin)
                            <a href="{{ route('client.sessions.join', $session->id) }}" class="btn btn-join flex-grow-1">
                                <i class="ri-video-line"></i>
                                Join Session
                            </a>
                        @else
                            <button class="btn btn-join disabled flex-grow-1" disabled>
                                <i class="ri-time-line"></i>
                                @if($session->status === 'scheduled')
                                    Waiting Confirmation
                                @else
                                    Available {{ $appointmentDateTime->copy()->subMinutes(10)->diffForHumans() }}
                                @endif
                            </button>
                        @endif
                        <a href="{{ route('client.appointments.show', $session->id) }}" class="btn btn-view">
                            <i class="ri-eye-line"></i>
                        </a>
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
