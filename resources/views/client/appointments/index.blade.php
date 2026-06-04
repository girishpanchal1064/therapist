@extends('layouts/contentNavbarLayout')

@section('title', 'My Appointments & Sessions')

@section('page-style')
<style>
:root {
    --theme-gradient: #041c54;
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
    color: #041c54;
    border-color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
}

.btn-book-new:active {
    background: white;
    color: #041c54;
    border-color: white;
    transform: translateY(0);
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

/* Filter Card */
.filter-card {
    background: #fff;
    border: 1px solid rgba(186, 194, 210, 0.45);
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.04);
}

.filter-card .form-select,
.filter-card input {
    border-radius: 8px;
    border: 2px solid rgba(186, 194, 210, 0.85);
    padding: 0.5rem 0.85rem;
    font-size: 0.9rem;
}

.filter-card .form-select:focus,
.filter-card input:focus {
    border-color: #041c54;
    box-shadow: 0 0 0 0.2rem rgba(4, 28, 84, 0.12);
}

.btn-clear-filter {
    background: transparent;
    border: 2px solid #041c54;
    color: #041c54;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-clear-filter:hover,
.btn-clear-filter:active {
    background: #041c54;
    border-color: #041c54;
    color: #fff;
}

/* Summary bar */
.appointments-summary {
    background: #fff;
    border: 1px solid rgba(186, 194, 210, 0.45);
    border-radius: 14px;
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05);
    margin-bottom: 1rem;
}

.appointments-summary .card-body {
    padding: 1rem 1.25rem;
}

.appointments-summary-icon {
    width: 48px;
    height: 48px;
    background: rgba(4, 28, 84, 0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #041c54;
    font-size: 1.25rem;
}

.appointments-summary-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #7484a4;
    margin-bottom: 0.25rem;
}

.appointments-summary-value {
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    color: #041c54;
}

.summary-pill {
    display: inline-flex;
    align-items: center;
    font-size: 0.75rem;
    padding: 0.5rem 0.875rem;
    border-radius: 10px;
    font-weight: 600;
}

.summary-pill-upcoming {
    background: rgba(4, 28, 84, 0.08);
    color: #041c54;
    border: 1px solid rgba(4, 28, 84, 0.2);
}

.summary-pill-completed {
    background: #041c54;
    color: #fff;
}

/* Session list cards */
.appt-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.appt-card {
    background: #fff;
    border: 1px solid rgba(186, 194, 210, 0.5);
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(4, 28, 84, 0.05);
    overflow: hidden;
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}

.appt-card:hover {
    box-shadow: 0 6px 20px rgba(4, 28, 84, 0.08);
    border-color: rgba(4, 28, 84, 0.2);
}

.appt-card--cancelled { border-left: 4px solid #dc2626; }
.appt-card--completed { border-left: 4px solid #94a3b8; }
.appt-card--in_progress { border-left: 4px solid #ef4444; }
.appt-card--scheduled,
.appt-card--confirmed { border-left: 4px solid #041c54; }

.appt-card__inner {
    display: flex;
    align-items: stretch;
    gap: 0;
    padding: 1rem 1.15rem;
}

.appt-card__avatar {
    flex-shrink: 0;
    padding-right: 1rem;
    display: flex;
    align-items: center;
}

.appt-card__avatar img {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid rgba(186, 194, 210, 0.6);
}

.appt-card__content {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.appt-card__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.appt-card__title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #041c54;
    margin: 0;
    line-height: 1.3;
}

.appt-card__role {
    font-size: 0.7rem;
    color: #7484a4;
    font-weight: 500;
    margin-top: 0.1rem;
}

.appt-status {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.3rem 0.65rem;
    border-radius: 999px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: capitalize;
    white-space: nowrap;
    flex-shrink: 0;
}

.appt-status--scheduled,
.appt-status--confirmed {
    background: rgba(4, 28, 84, 0.08);
    color: #041c54;
}

.appt-status--in_progress {
    background: rgba(239, 68, 68, 0.12);
    color: #b91c1c;
}

.appt-status--in_progress::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #ef4444;
    animation: live-blink 1s infinite;
}

.appt-status--completed {
    background: rgba(100, 116, 148, 0.12);
    color: #647494;
}

.appt-status--cancelled {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.appt-card__schedule {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.35rem 0.5rem;
    font-size: 0.8125rem;
    color: #334155;
    margin: 0;
    line-height: 1.4;
}

.appt-card__schedule i {
    color: #041c54;
    font-size: 0.9rem;
    vertical-align: -1px;
}

.appt-card__schedule .is-today {
    color: #041c54;
    font-weight: 700;
}

.appt-card__sep {
    color: #bac2d2;
    user-select: none;
}

.appt-card__tags {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.4rem;
}

.appt-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.2rem 0.55rem;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    background: rgba(4, 28, 84, 0.05);
    color: #475569;
    border: 1px solid rgba(186, 194, 210, 0.5);
}

.appt-tag--mode {
    color: #041c54;
    background: rgba(4, 28, 84, 0.06);
    border-color: rgba(4, 28, 84, 0.12);
}

.appt-tag--paid {
    color: #059669;
    background: rgba(16, 185, 129, 0.08);
    border-color: rgba(16, 185, 129, 0.2);
}

.appt-tag--pending {
    color: #d97706;
    background: rgba(245, 158, 11, 0.08);
    border-color: rgba(245, 158, 11, 0.2);
}

.appt-tag--muted {
    color: #7484a4;
    background: transparent;
    border-style: dashed;
}

.appt-card__actions {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    justify-content: center;
    gap: 0.5rem;
    padding-left: 1rem;
    border-left: 1px solid rgba(186, 194, 210, 0.4);
    margin-left: 0.5rem;
    min-width: 140px;
}

.appt-card__actions-row {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.appt-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.appt-btn--icon {
    width: 38px;
    height: 38px;
    padding: 0;
    background: rgba(4, 28, 84, 0.08);
    color: #041c54;
}

.appt-btn--icon:hover {
    background: #041c54;
    color: #fff;
}

.appt-btn--join {
    padding: 0.5rem 1rem;
    background: #041c54;
    color: #fff;
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.2);
}

.appt-btn--join:hover {
    background: #052a66;
    color: #fff;
}

.appt-btn--hint {
    padding: 0.4rem 0.65rem;
    font-size: 0.7rem;
    font-weight: 500;
    cursor: default;
    max-width: 160px;
    text-align: center;
    line-height: 1.3;
}

.appt-btn--hint.is-waiting {
    background: rgba(4, 28, 84, 0.06);
    color: #041c54;
    border: 1px solid rgba(4, 28, 84, 0.15);
}

.appt-btn--hint.is-muted {
    background: rgba(186, 194, 210, 0.2);
    color: #7484a4;
    border: 1px solid rgba(186, 194, 210, 0.5);
}

.appt-btn--hint.is-expired {
    background: rgba(75, 85, 99, 0.08);
    color: #64748b;
    border: 1px solid rgba(186, 194, 210, 0.5);
}

.appt-card__notice {
    padding: 0.65rem 1.15rem 0.85rem;
    margin: 0 1.15rem 1rem;
    background: rgba(254, 226, 226, 0.5);
    border-radius: 10px;
    border: 1px solid rgba(239, 68, 68, 0.2);
    font-size: 0.8rem;
    color: #991b1b;
    line-height: 1.45;
}

.appt-card__notice strong {
    font-weight: 700;
}

@keyframes live-blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.35; }
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state-icon {
    width: 120px;
    height: 120px;
    background: rgba(4, 28, 84, 0.08);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.empty-state-icon i {
    font-size: 3rem;
    color: #041c54;
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

.btn-book-first {
    background: var(--theme-gradient);
    border: none;
    color: white;
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-book-first:hover {
    background: #052a66;
    color: #fff;
}

.btn-book-first:active {
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.25);
    color: #fff;
}

/* Pagination */
.pagination-modern .page-link {
    border: 1px solid rgba(186, 194, 210, 0.45);
    border-radius: 10px;
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    color: #041c54;
    background: #fff;
    font-weight: 600;
    transition: all 0.2s ease;
}

.pagination-modern .page-link:hover {
    background: rgba(4, 28, 84, 0.06);
    color: #041c54;
}

.pagination-modern .page-item.active .page-link {
    background: #041c54;
    border-color: #041c54;
    color: #fff;
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

    .appt-card__inner {
        flex-direction: column;
        padding: 1rem;
    }

    .appt-card__avatar {
        padding-right: 0;
        padding-bottom: 0.75rem;
    }

    .appt-card__actions {
        border-left: none;
        border-top: 1px solid rgba(186, 194, 210, 0.4);
        margin-left: 0;
        padding-left: 0;
        padding-top: 0.75rem;
        min-width: 0;
        width: 100%;
        align-items: stretch;
    }

    .appt-card__actions-row {
        justify-content: flex-start;
    }

    .appt-btn--hint {
        max-width: none;
        flex: 1;
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
                <h4 class="mb-1">My Appointments & Sessions</h4>
                <p class="mb-0">View, join, and manage all your therapy sessions</p>
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

<!-- Filter Card -->
<div class="filter-card">
    <form method="GET" action="{{ route('client.appointments.index') }}" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-semibold">
                <i class="ri-filter-3-line me-1"></i>Filter by Status
            </label>
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">
                <i class="ri-calendar-line me-1"></i>Filter by Date
            </label>
            <input type="date" name="date" class="form-control" value="{{ request('date') }}" onchange="this.form.submit()">
        </div>
        <div class="col-md-4">
            @if(request('status') || request('date'))
                <a href="{{ route('client.appointments.index') }}" class="btn btn-clear-filter w-100">
                    <i class="ri-close-line me-2"></i>Clear Filters
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Appointments Summary -->
@if(($stats['total'] ?? 0) > 0)
    <div class="card appointments-summary mb-3">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="appointments-summary-icon">
                        <i class="ri-calendar-check-line"></i>
                    </div>
                    <div>
                        <div class="appointments-summary-label">Total Sessions</div>
                        <div class="appointments-summary-value">{{ $stats['total'] }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="summary-pill summary-pill-upcoming">
                        <i class="ri-calendar-todo-line me-1"></i>{{ $stats['upcoming'] }} Upcoming
                    </span>
                    <span class="summary-pill summary-pill-completed">
                        <i class="ri-checkbox-circle-line me-1"></i>{{ $stats['completed'] }} Completed
                    </span>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Appointments List -->
@if($appointments->count() > 0)
    <div class="appt-list">
        @foreach($appointments as $appointment)
        @php
            $isToday = \Carbon\Carbon::parse($appointment->appointment_date)->isToday();
            $timeString = is_string($appointment->appointment_time)
                ? $appointment->appointment_time
                : (is_object($appointment->appointment_time)
                    ? $appointment->appointment_time->format('H:i:s')
                    : $appointment->appointment_time);

            if (strlen($timeString) > 8 || strpos($timeString, '-') !== false) {
                try {
                    $timeString = \Carbon\Carbon::parse($timeString, 'Asia/Kolkata')->format('H:i:s');
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

            $startTime = \Carbon\Carbon::parse($timeString, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
            $endTime = $startTime->copy()->addMinutes($appointment->duration_minutes ?? 60);
            $appointmentDateTime = \Carbon\Carbon::parse(
                $appointment->appointment_date->format('Y-m-d') . ' ' . $timeString,
                'Asia/Kolkata'
            )->setTimezone('Asia/Kolkata');
            $sessionEndTime = $appointmentDateTime->copy()->addMinutes($appointment->duration_minutes ?? 60);
            $nowIST = \Carbon\Carbon::now('Asia/Kolkata');
            $minutesDiff = $appointmentDateTime->diffInMinutes($nowIST, false);
            $canJoin = $minutesDiff >= -5;
            $isSessionExpired = $nowIST->greaterThan($sessionEndTime);
            $isVideoOrAudio = in_array($appointment->session_mode, ['video', 'audio']);
            $statusCheck = in_array($appointment->status, ['confirmed', 'in_progress'])
                || ($appointment->status === 'scheduled' && ($appointmentDateTime->lessThan($nowIST) || $canJoin));
            $isActive = $canJoin && !$isSessionExpired && $isVideoOrAudio && $statusCheck;

            $statusIcon = match ($appointment->status) {
                'completed' => 'checkbox-circle',
                'cancelled' => 'close-circle',
                'in_progress' => 'broadcast',
                'confirmed' => 'check-double',
                default => 'time',
            };
            $modeIcon = match ($appointment->session_mode) {
                'video' => 'video',
                'audio' => 'mic',
                default => 'chat-3',
            };
        @endphp
        <article class="appt-card appt-card--{{ $appointment->status }}">
            <div class="appt-card__inner">
                <div class="appt-card__avatar">
                    @if($appointment->therapist->therapistProfile && $appointment->therapist->therapistProfile->profile_image)
                        <img src="{{ asset('storage/' . $appointment->therapist->therapistProfile->profile_image) }}"
                             alt="{{ $appointment->therapist->name }}">
                    @elseif($appointment->therapist->avatar)
                        <img src="{{ $appointment->therapist->avatar }}"
                             alt="{{ $appointment->therapist->name }}">
                    @else
                        <img src="{{ \App\Support\ProfileAvatar::placeholderUrl() }}"
                             alt="{{ $appointment->therapist->name }}">
                    @endif
                </div>

                <div class="appt-card__content">
                    <div class="appt-card__header">
                        <div>
                            <h6 class="appt-card__title">{{ $appointment->therapist->name }}</h6>
                            <div class="appt-card__role">Therapist</div>
                        </div>
                        <span class="appt-status appt-status--{{ $appointment->status }}">
                            <i class="ri-{{ $statusIcon }}-line"></i>
                            {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                        </span>
                    </div>

                    <p class="appt-card__schedule">
                        <span>
                            <i class="ri-calendar-line me-1"></i>
                            @if($isToday)
                                <span class="is-today">Today</span>
                            @else
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                            @endif
                        </span>
                        <span class="appt-card__sep">·</span>
                        <span>
                            <i class="ri-time-line me-1"></i>
                            {{ $startTime->format('g:i A') }} – {{ $endTime->format('g:i A') }} IST
                        </span>
                    </p>

                    <div class="appt-card__tags">
                        <span class="appt-tag appt-tag--mode">
                            <i class="ri-{{ $modeIcon }}-line"></i>
                            {{ ucfirst($appointment->session_mode) }}
                        </span>
                        <span class="appt-tag">{{ ucfirst($appointment->appointment_type) }}</span>
                        @if($appointment->payment)
                            <span class="appt-tag appt-tag--{{ $appointment->payment->status === 'completed' ? 'paid' : 'pending' }}">
                                <i class="ri-{{ $appointment->payment->status === 'completed' ? 'checkbox-circle' : 'time' }}-line"></i>
                                {{ ucfirst($appointment->payment->status) }} · ₹{{ number_format($appointment->payment->total_amount ?? 0, 0) }}
                            </span>
                        @else
                            <span class="appt-tag appt-tag--muted">No payment</span>
                        @endif
                    </div>
                </div>

                <div class="appt-card__actions">
                    <div class="appt-card__actions-row">
                        <a href="{{ route('client.appointments.show', $appointment->id) }}"
                           class="appt-btn appt-btn--icon"
                           title="View details">
                            <i class="ri-eye-line"></i>
                        </a>
                        @if($appointment->status === 'completed')
                            <a href="{{ route('client.reviews.create', $appointment->id) }}"
                               class="appt-btn appt-btn--icon"
                               title="Add review">
                                <i class="ri-star-line"></i>
                            </a>
                        @endif
                    </div>
                    <div class="appt-card__actions-row">
                        @if($isSessionExpired)
                            <span class="appt-btn appt-btn--hint is-expired">
                                <i class="ri-time-off-line"></i> Session ended
                            </span>
                        @elseif($isActive)
                            <a href="{{ route('sessions.join', $appointment->id) }}"
                               class="appt-btn appt-btn--join"
                               title="Join session"
                               target="_blank">
                                <i class="ri-{{ $modeIcon }}-line"></i> Join
                            </a>
                        @elseif(!$isVideoOrAudio)
                            <span class="appt-btn appt-btn--hint is-muted" title="Only video/audio sessions can be joined">
                                <i class="ri-video-off-line"></i> Chat only
                            </span>
                        @elseif(!$canJoin)
                            @php
                                $joinAvailableAt = $appointmentDateTime->copy()->subMinutes(5);
                                $timeUntilJoin = $joinAvailableAt->diffForHumans($nowIST, ['syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW]);
                            @endphp
                            <span class="appt-btn appt-btn--hint is-waiting"
                                  title="Join opens {{ $timeUntilJoin }} ({{ $joinAvailableAt->format('g:i A') }} IST)">
                                <i class="ri-time-line"></i> Opens {{ $timeUntilJoin }}
                            </span>
                        @else
                            <span class="appt-btn appt-btn--hint is-muted">
                                <i class="ri-information-line"></i> Unavailable
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            @if($appointment->wasDeclinedByTherapist())
            <div class="appt-card__notice">
                <i class="ri-error-warning-line me-1"></i>
                <strong>Declined by therapist:</strong> {{ $appointment->cancellation_reason }}
                @if($appointment->payment && $appointment->payment->status === 'refunded')
                    <span class="d-block mt-1" style="color: #7f1d1d; opacity: 0.85;">Payment refunded to your wallet.</span>
                @endif
            </div>
            @endif
        </article>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5 mb-4">
        <nav class="pagination-modern">
            {{ $appointments->links() }}
        </nav>
    </div>
@else
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="ri-calendar-line"></i>
        </div>
        <h5>No appointments found</h5>
        <p>
            @if(request('status') || request('date'))
                Try adjusting your filters or book a new session.
            @else
                You haven't booked any therapy sessions yet. Start your wellness journey today!
            @endif
        </p>
        <a href="{{ route('therapists.index') }}" class="btn btn-book-first">
            <i class="ri-add-circle-line me-2"></i>Book Your First Session
        </a>
    </div>
@endif
@endsection
