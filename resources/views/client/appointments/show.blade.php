@extends('layouts/contentNavbarLayout')

@section('title', 'Appointment Details')

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

.btn-back {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-back:hover {
    background: white;
    color: #667eea;
    border-color: white;
}

/* Info Cards */
.info-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    overflow: hidden;
    height: 60%;
}

.info-card-header {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    padding: 0.7rem 1rem;
    border-bottom: 1px solid rgba(102, 126, 234, 0.1);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-card-header .icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: white;
}

.info-card-header .icon.primary { background: var(--theme-gradient); }
.info-card-header .icon.success { background: var(--success-gradient); }
.info-card-header .icon.warning { background: var(--warning-gradient); }
.info-card-header .icon.info { background: var(--info-gradient); }

.info-card-header h6 {
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    font-size: 0.95rem;
}

.info-card-body {
    padding: 0.75rem 1rem;
}

/* Therapist Profile */
.therapist-profile {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 0;
}

.therapist-avatar-large {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid #f0f2ff;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
    margin-bottom: 0.5rem;
}

.therapist-avatar-placeholder-large {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: var(--theme-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.5rem;
}

.therapist-profile h5 {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.15rem;
    font-size: 0.9rem;
}

.therapist-profile p {
    color: #6b7280;
    font-size: 0.75rem;
    margin-bottom: 0.5rem;
}

.btn-view-profile {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    color: #667eea;
    border: none;
    padding: 0.4rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.8rem;
    transition: all 0.3s ease;
}

.btn-view-profile:hover {
    background: var(--theme-gradient);
    color: white;
    transform: translateY(-2px);
}

/* Detail Items */
.detail-row {
    display: flex;
    align-items: center;
    padding: 0.5rem 0.7rem;
    border-radius: 8px;
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    margin-bottom: 0.4rem;
}

.detail-row:last-child {
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
    font-size: 0.85rem;
    margin-right: 0.6rem;
    flex-shrink: 0;
}

.detail-content strong {
    display: block;
    color: #6b7280;
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.15rem;
    line-height: 1.2;
}

.detail-content span {
    color: #1f2937;
    font-weight: 600;
    font-size: 0.8rem;
    line-height: 1.3;
}

/* Status Badge Large */
.status-badge-large {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.85rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-top: 0;
}

.status-badge-large.scheduled {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.15) 100%);
    color: #d97706;
}

.status-badge-large.confirmed {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    color: #059669;
}

.status-badge-large.in_progress {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
    color: #2563eb;
}

.status-badge-large.completed {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    color: #667eea;
}

.status-badge-large.cancelled {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
    color: #dc2626;
}

/* Session Badge */
.session-type-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
    color: #2563eb;
}

.appointment-type-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    background: linear-gradient(135deg, rgba(107, 114, 128, 0.1) 0%, rgba(75, 85, 99, 0.1) 100%);
    color: #4b5563;
}

/* Meeting Card */
.meeting-card {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(5, 150, 105, 0.08) 100%);
    border: 2px solid rgba(16, 185, 129, 0.2);
    border-radius: 12px;
    padding: 1rem 1.25rem;
}

.meeting-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.meeting-info code {
    background: white;
    padding: 0.4rem 0.85rem;
    border-radius: 8px;
    font-size: 0.85rem;
    color: #059669;
    font-weight: 600;
}

.meeting-link {
    background: white;
    padding: 0.6rem 0.85rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 0.75rem;
    overflow: hidden;
}

.meeting-link a {
    color: #059669;
    font-weight: 500;
    font-size: 0.85rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.btn-join-session {
    background: var(--success-gradient);
    border: none;
    color: white;
    padding: 0.7rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    width: 100%;
}

.btn-join-session:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    color: white;
}

/* Payment Card */
.payment-card {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 2px solid #86efac;
    border-radius: 12px;
    padding: 1rem 1.25rem;
}

.payment-card.pending {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-color: #fcd34d;
}

.payment-amount-large {
    font-size: 1.5rem;
    font-weight: 700;
    background: var(--theme-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.payment-detail {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    font-size: 0.85rem;
}

.payment-detail:last-child {
    border-bottom: none;
}

.payment-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.4rem 0.85rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.payment-status-badge.completed {
    background: white;
    color: #059669;
}

.payment-status-badge.pending {
    background: white;
    color: #d97706;
}

/* Notes Card */
.notes-card {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border: 2px solid #93c5fd;
    border-radius: 12px;
    padding: 1rem 1.25rem;
}

.notes-card p {
    color: #1e40af;
    line-height: 1.6;
    margin: 0;
    font-size: 0.9rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-top: 1.25rem;
}

.btn-action {
    padding: 0.7rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

.btn-action.primary {
    background: var(--theme-gradient);
    border: none;
    color: white;
}

.btn-action.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-action.success {
    background: var(--success-gradient);
    border: none;
    color: white;
}

.btn-action.success:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    color: white;
}

.btn-action.warning {
    background: var(--warning-gradient);
    border: none;
    color: white;
}

.btn-action.warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
    color: white;
}

.btn-action.outline {
    background: transparent;
    border: 2px solid #d1d5db;
    color: #6b7280;
}

.btn-action.outline:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
    color: #374151;
}

.footer{
  margin-top: 30px !important;
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

    .info-card-body {
        padding: 0.85rem 1rem;
    }

    .info-card-header {
        padding: 0.75rem 1rem;
    }

    .therapist-avatar-large {
        width: 60px;
        height: 60px;
    }

    .detail-row {
        padding: 0.5rem 0.7rem;
    }

    .detail-icon {
        width: 28px;
        height: 28px;
        font-size: 0.85rem;
    }

    .action-buttons {
        flex-direction: column;
        gap: 0.5rem;
    }

    .btn-action {
        width: 100%;
        justify-content: center;
    }

    .meeting-card,
    .payment-card,
    .notes-card {
        padding: 0.85rem 1rem;
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
                <i class="ri-calendar-check-line"></i>
            </div>
            <div>
                <h4 class="mb-1">Appointment Details</h4>
                <p class="mb-0">View complete details of your therapy session</p>
            </div>
        </div>
        <a href="{{ route('client.appointments.index') }}" class="btn btn-back">
            <i class="ri-arrow-left-line me-2"></i>Back to Appointments
        </a>
    </div>
</div>

<div class="row g-3">
    <!-- Left Column -->
    <div class="col-lg-4">
        <!-- Therapist Card -->
        <div class="info-card mb-3">
            <div class="info-card-header">
                <div class="icon primary">
                    <i class="ri-user-heart-line"></i>
                </div>
                <h6>Your Therapist</h6>
            </div>
            <div class="info-card-body" style="padding-top: 0.75rem; padding-bottom: 0.75rem;">
                <div class="therapist-profile">
                    @if($appointment->therapist->therapistProfile && $appointment->therapist->therapistProfile->profile_image)
                        <img src="{{ asset('storage/' . $appointment->therapist->therapistProfile->profile_image) }}"
                             alt="{{ $appointment->therapist->name }}"
                             class="therapist-avatar-large">
                    @elseif($appointment->therapist->avatar)
                        <img src="{{ asset('storage/' . $appointment->therapist->avatar) }}"
                             alt="{{ $appointment->therapist->name }}"
                             class="therapist-avatar-large">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->therapist->name) }}&background=667eea&color=fff&size=200&bold=true&format=svg"
                             alt="{{ $appointment->therapist->name }}"
                             class="therapist-avatar-large">
                    @endif
                    <h5>{{ $appointment->therapist->name }}</h5>
                    <p>{{ $appointment->therapist->email }}</p>
                    @if($appointment->therapist->therapistProfile)
                        <a href="{{ route('therapists.show', $appointment->therapist->id) }}" class="btn btn-view-profile">
                            <i class="ri-eye-line me-2"></i>View Profile
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Session Status Card -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="icon info">
                    <i class="ri-information-line"></i>
                </div>
                <h6>Session Status</h6>
            </div>
            <div class="info-card-body text-center" style="padding-top: 0.5rem; padding-bottom: 0.75rem;">
                @php
                    $statusColors = [
                        'scheduled' => 'warning',
                        'confirmed' => 'success',
                        'in_progress' => 'info',
                        'completed' => 'primary',
                        'cancelled' => 'danger'
                    ];
                    $statusColor = $statusColors[$appointment->status] ?? 'secondary';
                @endphp
                <span class="status-badge-large {{ $appointment->status }}">
                    <i class="ri-{{ $appointment->status === 'completed' ? 'checkbox-circle' : ($appointment->status === 'cancelled' ? 'close-circle' : ($appointment->status === 'confirmed' ? 'check-double' : 'time')) }}-line"></i>
                    {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                </span>

                <div class="d-flex justify-content-center mt-1.5 flex-wrap" style="gap: 0.4rem; margin-top: 0.5rem;">
                    <span class="session-type-badge">
                        <i class="ri-{{ $appointment->session_mode === 'video' ? 'video' : ($appointment->session_mode === 'audio' ? 'mic' : 'chat-3') }}-line"></i>
                        {{ ucfirst($appointment->session_mode) }}
                    </span>
                    <span class="appointment-type-badge">
                        {{ ucfirst($appointment->appointment_type) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-8">
        <!-- Appointment Info Card -->
        <div class="info-card mb-3">
            <div class="info-card-header">
                <div class="icon primary">
                    <i class="ri-calendar-line"></i>
                </div>
                <h6>Appointment Information</h6>
            </div>
            <div class="info-card-body" style="padding-top: 0.75rem;">
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="detail-row">
                            <div class="detail-icon">
                                <i class="ri-calendar-line"></i>
                            </div>
                            <div class="detail-content">
                                <strong>Date</strong>
                                <span>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-row">
                            <div class="detail-icon">
                                <i class="ri-time-line"></i>
                            </div>
                            <div class="detail-content">
                                <strong>Time</strong>
                                <span>{{ \Carbon\Carbon::parse($appointment->appointment_time, 'Asia/Kolkata')->setTimezone('Asia/Kolkata')->format('g:i A') }} IST</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-row">
                            <div class="detail-icon">
                                <i class="ri-timer-line"></i>
                            </div>
                            <div class="detail-content">
                                <strong>Duration</strong>
                                <span>{{ $appointment->duration_minutes }} minutes</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-row">
                            <div class="detail-icon">
                                <i class="ri-video-line"></i>
                            </div>
                            <div class="detail-content">
                                <strong>Session Mode</strong>
                                <span>{{ ucfirst($appointment->session_mode) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meeting Information -->
        @if($appointment->meeting_id || $appointment->meeting_link)
        <div class="meeting-card mb-3">
            <h6 class="fw-bold mb-2" style="font-size: 0.95rem;">
                <i class="ri-video-chat-line me-2 text-success"></i>Meeting Information
            </h6>
            @if($appointment->meeting_id)
            <div class="meeting-info">
                <strong>Meeting ID:</strong>
                <code>{{ $appointment->meeting_id }}</code>
            </div>
            @endif
            @if($appointment->meeting_link)
            <div class="meeting-link">
                <i class="ri-link text-success"></i>
                <a href="{{ $appointment->meeting_link }}" target="_blank">
                    {{ $appointment->meeting_link }}
                </a>
                <i class="ri-external-link-line text-muted"></i>
            </div>
            @endif
            @php
                // Handle appointment_time - it might be a datetime or time string
                $timeString = is_string($appointment->appointment_time)
                    ? $appointment->appointment_time
                    : (is_object($appointment->appointment_time)
                        ? $appointment->appointment_time->format('H:i:s')
                        : $appointment->appointment_time);

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

                $appointmentDateTime = \Carbon\Carbon::parse($appointment->appointment_date->format('Y-m-d') . ' ' . $timeString, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
                // Allow joining 5 minutes before appointment time or anytime after
                // diffInMinutes(nowIST(), false) returns negative for future times, positive for past times
                $nowIST = \Carbon\Carbon::now('Asia/Kolkata');
                $minutesDiff = $appointmentDateTime->diffInMinutes($nowIST, false);
                $canJoin = $minutesDiff >= -5; // True if within 5 minutes before or anytime after

                // Show join button if time has arrived (or within 5 min) AND status allows it
                // Allow join button even if status is still 'scheduled' as long as we're within 5 minutes (cron may not have run yet)
                $isVideoOrAudio = in_array($appointment->session_mode, ['video', 'audio']);
                $statusCheck = in_array($appointment->status, ['confirmed', 'in_progress']) ||
                    ($appointment->status === 'scheduled' && ($appointmentDateTime->lessThan(\Carbon\Carbon::now('Asia/Kolkata')) || $canJoin));

                $isActive = $canJoin && $isVideoOrAudio && $statusCheck;
            @endphp
            @if($isActive)
            <a href="{{ route('sessions.join', $appointment->id) }}" class="btn btn-join-session" target="_blank">
                <i class="ri-video-line me-2"></i>Join Session Now
            </a>
            @elseif(!$canJoin)
            @php
                $joinAvailableAt = $appointmentDateTime->copy()->subMinutes(5);
                $timeUntilJoin = $joinAvailableAt->diffForHumans(\Carbon\Carbon::now('Asia/Kolkata'), ['syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW]);
            @endphp
            <button class="btn btn-join-session" disabled style="opacity: 0.6; cursor: not-allowed;">
                <i class="ri-time-line me-2"></i>Join button will be available {{ $timeUntilJoin }} (at {{ $joinAvailableAt->format('g:i A') }})
            </button>
            @endif
        </div>
        @endif

        <!-- Payment Information -->
        @if($appointment->payment)
        <div class="payment-card {{ $appointment->payment->status !== 'completed' ? 'pending' : '' }} mb-3">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h6 class="fw-bold mb-1" style="font-size: 0.95rem;">
                        <i class="ri-money-rupee-circle-line me-2"></i>Payment Information
                    </h6>
                    <span class="payment-status-badge {{ $appointment->payment->status === 'completed' ? 'completed' : 'pending' }}">
                        <i class="ri-{{ $appointment->payment->status === 'completed' ? 'checkbox-circle' : 'time' }}-line"></i>
                        {{ ucfirst($appointment->payment->status) }}
                    </span>
                </div>
                <span class="payment-amount-large">₹{{ number_format($appointment->payment->total_amount ?? 0, 2) }}</span>
            </div>

            <div class="payment-details">
                @if($appointment->payment->payment_method)
                <div class="payment-detail">
                    <span class="text-muted">Payment Method</span>
                    <span class="fw-semibold">{{ ucfirst(str_replace('_', ' ', $appointment->payment->payment_method)) }}</span>
                </div>
                @endif
                @if($appointment->payment->paid_at)
                <div class="payment-detail">
                    <span class="text-muted">Paid At</span>
                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($appointment->payment->paid_at)->format('M d, Y h:i A') }}</span>
                </div>
                @endif
                @if($appointment->payment->transaction_id)
                <div class="payment-detail">
                    <span class="text-muted">Transaction ID</span>
                    <code class="fw-semibold">{{ $appointment->payment->transaction_id }}</code>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Notes -->
        @if($appointment->notes)
        <div class="notes-card mb-3">
            <h6 class="fw-bold mb-2" style="font-size: 0.95rem;">
                <i class="ri-file-text-line me-2"></i>Session Notes
            </h6>
            <p>{{ $appointment->notes }}</p>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="action-buttons">
            @if(isset($isActive) && $isActive)
                <a href="{{ route('sessions.join', $appointment->id) }}" class="btn btn-action success" target="_blank">
                    <i class="ri-video-line"></i>Join Session
                </a>
            @elseif(isset($canJoin) && !$canJoin)
                @php
                    $joinAvailableAt = $appointmentDateTime->copy()->subMinutes(5);
                    $timeUntilJoin = $joinAvailableAt->diffForHumans(\Carbon\Carbon::now('Asia/Kolkata'), ['syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW]);
                @endphp
                <button class="btn btn-action" disabled style="opacity: 0.6; cursor: not-allowed;">
                    <i class="ri-time-line"></i>Available {{ $timeUntilJoin }} (at {{ $joinAvailableAt->format('g:i A') }})
                </button>
            @endif
            @if($appointment->status === 'completed')
                <a href="{{ route('client.reviews.create', $appointment->id) }}" class="btn btn-action warning">
                    <i class="ri-star-line"></i>Write Review
                </a>
            @endif
            <a href="{{ route('client.appointments.index') }}" class="btn btn-action outline">
                <i class="ri-arrow-left-line"></i>Back to List
            </a>
        </div>
    </div>
</div>
@endsection
