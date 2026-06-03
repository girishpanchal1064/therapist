@extends('layouts/contentNavbarLayout')

@section('title', 'My Appointments')

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

/* Appointment Cards */
.appointment-card {
    background: white;
    border: 1px solid rgba(186, 194, 210, 0.45);
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.04);
    overflow: hidden;
    position: relative;
    margin-bottom: 0.5rem;
    border-left: 4px solid #041c54;
}

.appointment-card:nth-child(even) {
    background: rgba(4, 28, 84, 0.02);
}

.appointment-card .card-body {
    padding: 0.875rem 1.25rem;
}

/* Therapist Avatar */
.therapist-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid rgba(186, 194, 210, 0.7);
    box-shadow: 0 1px 4px rgba(4, 28, 84, 0.08);
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
    color: #041c54;
    margin-bottom: 0;
    font-size: 0.875rem;
    line-height: 1.2;
}

.therapist-info small {
    color: #7484a4;
    display: flex;
    align-items: center;
    gap: 0.2rem;
    font-size: 0.65rem;
}

/* Appointment Details */
.detail-item {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
    padding: 0.35rem 0.65rem;
    background: rgba(4, 28, 84, 0.04);
    border-radius: 8px;
    border: 1px solid rgba(186, 194, 210, 0.45);
    margin-right: 0.5rem;
}

.detail-text-today {
    color: #041c54;
    font-weight: 700;
}

.detail-item:last-child {
    margin-bottom: 0;
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
    box-shadow: 0 1px 3px rgba(4, 28, 84, 0.15);
}

.detail-text {
    font-weight: 600;
    color: #041c54;
    font-size: 0.8rem;
    line-height: 1.3;
    white-space: nowrap;
}

/* Session Type Badges */
.session-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.875rem;
    border-radius: 12px;
    font-size: 0.8125rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.session-badge.video,
.session-badge.audio,
.session-badge.chat {
    background: rgba(4, 28, 84, 0.1);
    color: #041c54;
}

.type-badge {
    background: rgba(100, 116, 148, 0.12);
    color: #647494;
    padding: 0.3rem 0.65rem;
    border-radius: 8px;
    font-size: 0.7rem;
    font-weight: 600;
    border: 1px solid rgba(107, 114, 128, 0.15);
    display: inline-block;
}

/* Status Badges */
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

.status-badge.scheduled,
.status-badge.confirmed,
.status-badge.in_progress {
    background: rgba(4, 28, 84, 0.1);
    color: #041c54;
}

.status-badge.completed {
    background: rgba(100, 116, 148, 0.12);
    color: #647494;
}

.status-badge.cancelled {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
    color: #dc2626;
}

.status-badge.expired {
    background: linear-gradient(135deg, rgba(75, 85, 99, 0.15) 0%, rgba(55, 65, 81, 0.15) 100%);
    color: #374151;
}

/* Action Buttons */
.appointment-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    border: none;
    text-decoration: none;
    flex-shrink: 0;
}

.action-btn.view,
.action-btn.review {
    background: rgba(4, 28, 84, 0.1);
    color: #041c54;
}

.action-btn.view:hover,
.action-btn.review:hover {
    background: #041c54;
    color: #fff;
}

.action-btn.join {
    background: #041c54;
    color: #fff;
    padding: 0.4rem 0.85rem;
    width: auto;
    height: auto;
    font-size: 0.8rem;
    font-weight: 600;
    white-space: nowrap;
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.2);
}

.action-btn.join:hover {
    background: #052a66;
    color: #fff;
}

.action-btn.disabled {
    background: rgba(186, 194, 210, 0.35);
    color: #7484a4;
    cursor: not-allowed;
}

/* Payment Section */
.payment-section {
    background: rgba(4, 28, 84, 0.04);
    border-radius: 8px;
    padding: 0.5rem 0.875rem;
    margin-top: 0.75rem;
    border: 1px solid rgba(186, 194, 210, 0.45);
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
}

.payment-status {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.25rem 0.5rem;
    border-radius: 8px;
    font-size: 0.65rem;
    font-weight: 600;
    box-shadow: 0 1px 2px rgba(0,0,0,0.08);
}

.payment-status.completed {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    color: #059669;
}

.payment-status.pending {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.15) 100%);
    color: #d97706;
}

.payment-amount {
    font-size: 0.8rem;
    font-weight: 600;
    color: #1f2937;
    letter-spacing: 0.3px;
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

    .appointment-card .card-body {
        padding: 0.85rem 1rem;
    }

    .detail-item {
        padding: 0.35rem 0.5rem;
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
                <i class="ri-calendar-check-line"></i>
            </div>
            <div>
                <h4 class="mb-1">My Appointments</h4>
                <p class="mb-0">View and manage all your therapy sessions</p>
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
@if($appointments->count() > 0)
    @php
        $totalAppointments = $appointments->total();
        $upcomingCount = $appointments->whereIn('status', ['scheduled', 'confirmed'])->where('appointment_date', '>=', today())->count();
        $completedCount = $appointments->where('status', 'completed')->count();
    @endphp
    <div class="card appointments-summary mb-3">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="appointments-summary-icon">
                        <i class="ri-calendar-check-line"></i>
                    </div>
                    <div>
                        <div class="appointments-summary-label">Total Appointments</div>
                        <div class="appointments-summary-value">{{ $totalAppointments }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="summary-pill summary-pill-upcoming">
                        <i class="ri-calendar-todo-line me-1"></i>{{ $upcomingCount }} Upcoming
                    </span>
                    <span class="summary-pill summary-pill-completed">
                        <i class="ri-checkbox-circle-line me-1"></i>{{ $completedCount }} Completed
                    </span>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Appointments List -->
@if($appointments->count() > 0)
    <div class="row g-2">
        @foreach($appointments as $appointment)
        <div class="col-12">
            <div class="card appointment-card">
                <div class="card-body">
                    <div class="row align-items-center g-2">
                        <!-- Therapist Info -->
                        <div class="col-lg-2 col-md-3 mb-0">
                            <div class="d-flex align-items-center" style="gap: 0.5rem;">
                                @if($appointment->therapist->therapistProfile && $appointment->therapist->therapistProfile->profile_image)
                                    <img src="{{ asset('storage/' . $appointment->therapist->therapistProfile->profile_image) }}"
                                         alt="{{ $appointment->therapist->name }}"
                                         class="therapist-avatar">
                                @elseif($appointment->therapist->avatar)
                                    <img src="{{ $appointment->therapist->avatar }}"
                                         alt="{{ $appointment->therapist->name }}"
                                         class="therapist-avatar">
                                @else
                                    <img src="{{ \App\Support\ProfileAvatar::placeholderUrl() }}"
                                         alt="{{ $appointment->therapist->name }}"
                                         class="therapist-avatar">
                                @endif
                                <div class="therapist-info">
                                    <h6>{{ $appointment->therapist->name }}</h6>
                                    <small>
                                        <i class="ri-user-heart-line"></i>Therapist
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Appointment Details -->
                        <div class="col-lg-3 col-md-4 mb-0">
                            <div class="d-flex align-items-center flex-wrap" style="gap: 0.25rem;">
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="ri-calendar-line"></i>
                                    </div>
                                    <span class="detail-text">
                                        @php
                                            $isToday = \Carbon\Carbon::parse($appointment->appointment_date)->isToday();
                                        @endphp
                                        @if($isToday)
                                            <span class="detail-text-today">Today</span>
                                        @else
                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="ri-time-line"></i>
                                    </div>
                                    <span class="detail-text">
                                        @php
                                          $startTime = \Carbon\Carbon::parse($appointment->appointment_time, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
                                          $endTime = $startTime->copy()->addMinutes($appointment->duration_minutes ?? 60);
                                        @endphp
                                        {{ $startTime->format('g:i A') }} - {{ $endTime->format('g:i A') }} IST
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Session Mode & Status -->
                        <div class="col-lg-2 col-md-3 mb-0">
                            <div class="d-flex align-items-center flex-wrap" style="gap: 0.5rem;">
                                <span class="session-badge {{ $appointment->session_mode }}">
                                    <i class="ri-{{ $appointment->session_mode === 'video' ? 'video' : ($appointment->session_mode === 'audio' ? 'mic' : 'chat-3') }}-line"></i>
                                    {{ ucfirst($appointment->session_mode) }}
                                </span>
                                <span class="status-badge {{ $appointment->status }}">
                                    <i class="ri-{{ $appointment->status === 'completed' ? 'checkbox-circle' : ($appointment->status === 'cancelled' ? 'close-circle' : ($appointment->status === 'confirmed' ? 'check-double' : 'time')) }}-line"></i>
                                    {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                                </span>
                            </div>
                        </div>

                        <!-- Session Type & Payment -->
                        <div class="col-lg-2 col-md-2 mb-0">
                            <div class="d-flex flex-column" style="gap: 0.35rem;">
                                <span class="type-badge">{{ ucfirst($appointment->appointment_type) }}</span>
                                @if($appointment->payment)
                                    <div class="d-flex align-items-center gap-1" style="font-size: 0.7rem;">
                                        <span class="payment-status {{ $appointment->payment->status === 'completed' ? 'completed' : 'pending' }}" style="font-size: 0.65rem; padding: 0.2rem 0.45rem;">
                                            <i class="ri-{{ $appointment->payment->status === 'completed' ? 'checkbox-circle' : 'time' }}-line"></i>
                                            {{ ucfirst($appointment->payment->status) }}
                                        </span>
                                        <span class="payment-amount" style="font-size: 0.8rem; font-weight: 600;">₹{{ number_format($appointment->payment->total_amount ?? 0, 0) }}</span>
                                    </div>
                                @else
                                    <span class="text-muted" style="font-size: 0.7rem;">No payment</span>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="col-lg-3 col-md-12 mb-0">
                            <div class="appointment-actions justify-content-lg-end justify-content-start">
                                    <a href="{{ route('client.appointments.show', $appointment->id) }}"
                                       class="action-btn view"
                                       title="View Details">
                                        <i class="ri-eye-line"></i>
                                    </a>
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
                                      // Calculate session end time
                                      $sessionEndTime = $appointmentDateTime->copy()->addMinutes($appointment->duration_minutes ?? 60);
                                      
                                      // Allow joining 5 minutes before appointment time or anytime after
                                      // diffInMinutes(nowIST(), false) returns negative for future times, positive for past times
                                      $nowIST = \Carbon\Carbon::now('Asia/Kolkata');
                                      $minutesDiff = $appointmentDateTime->diffInMinutes($nowIST, false);
                                      $canJoin = $minutesDiff >= -5; // True if within 5 minutes before or anytime after
                                      
                                      // Check if session has expired (current time is past session end time)
                                      $isSessionExpired = $nowIST->greaterThan($sessionEndTime);

                                      // Show join button if time has arrived (or within 5 min) AND status allows it
                                      // Allow join button even if status is still 'scheduled' as long as we're within 5 minutes (cron may not have run yet)
                                      $isVideoOrAudio = in_array($appointment->session_mode, ['video', 'audio']);
                                      $statusCheck = in_array($appointment->status, ['confirmed', 'in_progress']) ||
                                        ($appointment->status === 'scheduled' && ($appointmentDateTime->lessThan(\Carbon\Carbon::now('Asia/Kolkata')) || $canJoin));

                                      $isActive = $canJoin && !$isSessionExpired && $isVideoOrAudio && $statusCheck;
                                    @endphp
                                    @if($isSessionExpired)
                                        <span class="status-badge expired">
                                            <i class="ri-time-off-line"></i>Expired
                                        </span>
                                    @elseif($isActive)
                                        <a href="{{ route('sessions.join', $appointment->id) }}"
                                           class="action-btn join"
                                           title="Join Session"
                                           target="_blank">
                                            <i class="ri-{{ $appointment->session_mode === 'video' ? 'video' : 'mic' }}-line me-1"></i>Join Session
                                        </a>
                                    @elseif(!$canJoin)
                                        @php
                                            $joinAvailableAt = $appointmentDateTime->copy()->subMinutes(5);
                                            $timeUntilJoin = $joinAvailableAt->diffForHumans(\Carbon\Carbon::now('Asia/Kolkata'), ['syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW]);
                                        @endphp
                                        <button class="action-btn disabled" disabled title="Join button will be available {{ $timeUntilJoin }} (at {{ $joinAvailableAt->format('g:i A') }})">
                                            <i class="ri-time-line"></i>
                                        </button>
                                    @else
                                        <button class="action-btn disabled" disabled title="Not available yet">
                                            <i class="ri-time-line"></i>
                                        </button>
                                    @endif
                                    @if($appointment->status === 'completed')
                                        <a href="{{ route('client.reviews.create', $appointment->id) }}"
                                           class="action-btn review"
                                           title="Add Review">
                                            <i class="ri-star-line"></i>
                                        </a>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
