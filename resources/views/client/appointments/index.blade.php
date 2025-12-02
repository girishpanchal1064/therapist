@extends('layouts/contentNavbarLayout')

@section('title', 'My Appointments')

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

.btn-book-new {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
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

/* Filter Card */
.filter-card {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border: 1px solid rgba(102, 126, 234, 0.15);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.filter-card .form-select,
.filter-card input {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    padding: 0.75rem 1rem;
}

.filter-card .form-select:focus,
.filter-card input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
}

.btn-clear-filter {
    background: transparent;
    border: 2px solid #667eea;
    color: #667eea;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-clear-filter:hover {
    background: var(--theme-gradient);
    border-color: transparent;
    color: white;
}

/* Appointment Cards */
.appointment-card {
    background: white;
    border: none;
    border-radius: 20px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.appointment-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: var(--theme-gradient);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.appointment-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.1);
}

.appointment-card:hover::before {
    opacity: 1;
}

.appointment-card .card-body {
    padding: 1.5rem;
}

/* Therapist Avatar */
.therapist-avatar {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    object-fit: cover;
    border: 3px solid #f0f2ff;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
}

.therapist-avatar-placeholder {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: var(--theme-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
}

.therapist-info h6 {
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.therapist-info small {
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Appointment Details */
.detail-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    padding: 0.5rem 0.75rem;
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border-radius: 10px;
}

.detail-item:last-child {
    margin-bottom: 0;
}

.detail-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--theme-gradient);
    color: white;
    font-size: 1rem;
}

.detail-text {
    font-weight: 600;
    color: #374151;
}

/* Session Type Badges */
.session-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
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
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
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
}

.status-badge.completed {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    color: #667eea;
}

.status-badge.cancelled {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
    color: #dc2626;
}

/* Action Buttons */
.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    transition: all 0.3s ease;
    border: none;
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

.action-btn.join {
    background: var(--success-gradient);
    color: white;
    padding: 0.5rem 1rem;
    width: auto;
}

.action-btn.join:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

.action-btn.review {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
    color: #d97706;
}

.action-btn.review:hover {
    background: var(--warning-gradient);
    color: white;
    transform: translateY(-2px);
}

/* Payment Section */
.payment-section {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border-radius: 12px;
    padding: 1rem;
    margin-top: 1rem;
}

.payment-status {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
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
    font-size: 1.25rem;
    font-weight: 700;
    background: var(--theme-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #f0f2ff 0%, #e8e9ff 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.empty-state-icon i {
    font-size: 3rem;
    background: var(--theme-gradient);
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
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Pagination */
.pagination-modern .page-link {
    border: none;
    border-radius: 10px;
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    color: #667eea;
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    font-weight: 600;
    transition: all 0.3s ease;
}

.pagination-modern .page-link:hover {
    background: var(--theme-gradient);
    color: white;
}

.pagination-modern .page-item.active .page-link {
    background: var(--theme-gradient);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .appointment-card .card-body {
        padding: 1rem;
    }
    
    .detail-item {
        padding: 0.35rem 0.5rem;
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

<!-- Appointments List -->
@if($appointments->count() > 0)
    <div class="row g-4">
        @foreach($appointments as $appointment)
        <div class="col-12">
            <div class="card appointment-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Therapist Info -->
                        <div class="col-lg-3 col-md-4 mb-3 mb-lg-0">
                            <div class="d-flex align-items-center gap-3">
                                @if($appointment->therapist->therapistProfile && $appointment->therapist->therapistProfile->profile_image)
                                    <img src="{{ asset('storage/' . $appointment->therapist->therapistProfile->profile_image) }}" 
                                         alt="{{ $appointment->therapist->name }}" 
                                         class="therapist-avatar">
                                @elseif($appointment->therapist->avatar)
                                    <img src="{{ asset('storage/' . $appointment->therapist->avatar) }}" 
                                         alt="{{ $appointment->therapist->name }}" 
                                         class="therapist-avatar">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->therapist->name) }}&background=667eea&color=fff&size=80&bold=true&format=svg" 
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
                        <div class="col-lg-4 col-md-4 mb-3 mb-lg-0">
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="ri-calendar-line"></i>
                                </div>
                                <span class="detail-text">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="ri-time-line"></i>
                                </div>
                                <span class="detail-text">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</span>
                            </div>
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="ri-timer-line"></i>
                                </div>
                                <span class="detail-text">{{ $appointment->duration_minutes }} minutes</span>
                            </div>
                        </div>

                        <!-- Session Type -->
                        <div class="col-lg-2 col-md-4 mb-3 mb-lg-0">
                            <div class="d-flex flex-column gap-2">
                                <span class="session-badge {{ $appointment->session_mode }}">
                                    <i class="ri-{{ $appointment->session_mode === 'video' ? 'video' : ($appointment->session_mode === 'audio' ? 'mic' : 'chat-3') }}-line"></i>
                                    {{ ucfirst($appointment->session_mode) }}
                                </span>
                                <span class="type-badge">{{ ucfirst($appointment->appointment_type) }}</span>
                            </div>
                        </div>

                        <!-- Status & Actions -->
                        <div class="col-lg-3 col-md-12">
                            <div class="d-flex flex-column align-items-lg-end align-items-start gap-3">
                                <span class="status-badge {{ $appointment->status }}">
                                    <i class="ri-{{ $appointment->status === 'completed' ? 'checkbox-circle' : ($appointment->status === 'cancelled' ? 'close-circle' : ($appointment->status === 'confirmed' ? 'check-double' : 'time')) }}-line"></i>
                                    {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                                </span>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('client.appointments.show', $appointment->id) }}" 
                                       class="action-btn view" 
                                       title="View Details">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    @if(in_array($appointment->status, ['confirmed', 'in_progress']))
                                        <a href="{{ route('client.sessions.join', $appointment->id) }}" 
                                           class="action-btn join" 
                                           title="Join Session">
                                            <i class="ri-video-line me-1"></i>Join
                                        </a>
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

                    <!-- Payment Section -->
                    @if($appointment->payment)
                    <div class="payment-section">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <span class="text-muted fw-medium">Payment:</span>
                                <span class="payment-status {{ $appointment->payment->status === 'completed' ? 'completed' : 'pending' }}">
                                    <i class="ri-{{ $appointment->payment->status === 'completed' ? 'checkbox-circle' : 'time' }}-line"></i>
                                    {{ ucfirst($appointment->payment->status) }}
                                </span>
                            </div>
                            <span class="payment-amount">₹{{ number_format($appointment->payment->total_amount ?? 0, 2) }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
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
