@extends('layouts/contentNavbarLayout')

@section('title', 'My Reviews')

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

/* Review Cards */
.review-card {
    background: white;
    border: none;
    border-radius: 20px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.review-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: var(--warning-gradient);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.review-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.1);
}

.review-card:hover::before {
    opacity: 1;
}

.review-card .card-body {
    padding: 1.5rem;
}

/* Therapist Info */
.therapist-info-section {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid rgba(102, 126, 234, 0.1);
}

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

.therapist-details h6 {
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.therapist-details small {
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Rating Section */
.rating-section {
    margin-bottom: 1.25rem;
}

.star-rating {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-bottom: 0.5rem;
}

.star-rating i {
    font-size: 1.5rem;
    color: #fbbf24;
}

.rating-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
    background: linear-gradient(135deg, rgba(251, 191, 36, 0.15) 0%, rgba(245, 158, 11, 0.15) 100%);
    color: #d97706;
    margin-left: 0.75rem;
}

.review-comment {
    color: #4b5563;
    line-height: 1.7;
    font-size: 0.95rem;
}

.review-comment.empty {
    color: #9ca3af;
    font-style: italic;
}

/* Status Badges */
.status-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.4rem 0.85rem;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 600;
}

.status-badge.verified {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    color: #059669;
}

.status-badge.pending {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.15) 100%);
    color: #d97706;
}

.status-badge.public {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
    color: #2563eb;
}

.status-badge.private {
    background: linear-gradient(135deg, rgba(107, 114, 128, 0.1) 0%, rgba(75, 85, 99, 0.1) 100%);
    color: #4b5563;
}

/* Meta Info */
.meta-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.85rem;
}

.meta-info i {
    color: #667eea;
    margin-right: 0.5rem;
}

/* Read More Section */
.read-more-section {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border-radius: 12px;
    padding: 1rem;
    margin-top: 1rem;
}

.btn-read-more {
    background: transparent;
    border: none;
    color: #667eea;
    font-weight: 600;
    font-size: 0.85rem;
    padding: 0;
    display: flex;
    align-items: center;
    gap: 0.35rem;
    transition: all 0.2s ease;
}

.btn-read-more:hover {
    color: #5a6fd6;
}

/* Action Buttons */
.review-actions {
    display: flex;
    gap: 0.75rem;
    margin-top: 1.25rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(102, 126, 234, 0.1);
}

.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
}

.btn-action.primary {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    color: #667eea;
}

.btn-action.primary:hover {
    background: var(--theme-gradient);
    color: white;
    transform: translateY(-2px);
}

.btn-action.secondary {
    background: linear-gradient(135deg, rgba(107, 114, 128, 0.08) 0%, rgba(75, 85, 99, 0.08) 100%);
    color: #4b5563;
}

.btn-action.secondary:hover {
    background: linear-gradient(135deg, rgba(107, 114, 128, 0.15) 0%, rgba(75, 85, 99, 0.15) 100%);
    color: #374151;
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
    background: var(--warning-gradient);
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

.btn-view-appointments {
    background: var(--theme-gradient);
    border: none;
    color: white;
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-view-appointments:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .review-card .card-body {
        padding: 1.25rem;
    }
    
    .therapist-info-section {
        flex-direction: column;
        text-align: center;
    }
    
    .star-rating i {
        font-size: 1.25rem;
    }
}
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex align-items-center gap-3 position-relative" style="z-index: 1;">
        <div class="header-icon">
            <i class="ri-star-line"></i>
        </div>
        <div>
            <h4 class="mb-1">My Reviews</h4>
            <p class="mb-0">View all reviews you've submitted for therapy sessions</p>
        </div>
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

<!-- Reviews List -->
@if($reviews->count() > 0)
    <div class="row g-4">
        @foreach($reviews as $review)
        <div class="col-12">
            <div class="card review-card">
                <div class="card-body">
                    <div class="row">
                        <!-- Main Content -->
                        <div class="col-lg-8">
                            <!-- Therapist Info -->
                            <div class="therapist-info-section">
                                @if($review->therapist->therapistProfile && $review->therapist->therapistProfile->profile_image)
                                    <img src="{{ asset('storage/' . $review->therapist->therapistProfile->profile_image) }}" 
                                         alt="{{ $review->therapist->name }}" 
                                         class="therapist-avatar">
                                @elseif($review->therapist->avatar)
                                    <img src="{{ asset('storage/' . $review->therapist->avatar) }}" 
                                         alt="{{ $review->therapist->name }}" 
                                         class="therapist-avatar">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->therapist->name) }}&background=667eea&color=fff&size=120&bold=true&format=svg" 
                                         alt="{{ $review->therapist->name }}" 
                                         class="therapist-avatar">
                                @endif
                                <div class="therapist-details">
                                    <h6>{{ $review->therapist->name }}</h6>
                                    <small>
                                        <i class="ri-user-heart-line"></i>Therapist
                                    </small>
                                </div>
                            </div>

                            <!-- Rating -->
                            <div class="rating-section">
                                <div class="d-flex align-items-center">
                                    <div class="star-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="ri-star{{ $i <= $review->rating ? '-fill' : '-line' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="rating-badge">
                                        <i class="ri-star-fill"></i>
                                        {{ $review->rating }}.0
                                    </span>
                                </div>
                            </div>

                            <!-- Comment -->
                            @if($review->comment)
                                <p class="review-comment">{{ Str::limit($review->comment, 200) }}</p>
                                
                                @if(strlen($review->comment) > 200)
                                <div class="collapse" id="commentCollapse{{ $review->id }}">
                                    <div class="read-more-section">
                                        <p class="mb-0">{{ $review->comment }}</p>
                                    </div>
                                </div>
                                <button class="btn btn-read-more mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#commentCollapse{{ $review->id }}">
                                    <i class="ri-arrow-down-s-line"></i>Read full review
                                </button>
                                @endif
                            @else
                                <p class="review-comment empty">No comment provided</p>
                            @endif
                        </div>

                        <!-- Status & Meta -->
                        <div class="col-lg-4">
                            <div class="d-flex flex-column align-items-lg-end">
                                <!-- Status Badges -->
                                <div class="status-badges mb-3">
                                    @if($review->is_verified)
                                        <span class="status-badge verified">
                                            <i class="ri-checkbox-circle-line"></i>Verified
                                        </span>
                                    @else
                                        <span class="status-badge pending">
                                            <i class="ri-time-line"></i>Pending
                                        </span>
                                    @endif
                                    @if($review->is_public)
                                        <span class="status-badge public">
                                            <i class="ri-eye-line"></i>Public
                                        </span>
                                    @else
                                        <span class="status-badge private">
                                            <i class="ri-eye-off-line"></i>Private
                                        </span>
                                    @endif
                                </div>

                                <!-- Meta Info -->
                                <div class="meta-info text-lg-end">
                                    <div>
                                        <i class="ri-calendar-line"></i>
                                        {{ $review->created_at->format('M d, Y') }}
                                    </div>
                                    @if($review->appointment)
                                    <div>
                                        <i class="ri-calendar-check-line"></i>
                                        Session: {{ \Carbon\Carbon::parse($review->appointment->appointment_date)->format('M d, Y') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="review-actions">
                        @if($review->appointment)
                            <a href="{{ route('client.appointments.show', $review->appointment->id) }}" class="btn btn-action primary">
                                <i class="ri-eye-line"></i>View Appointment
                            </a>
                        @endif
                        @if($review->therapist)
                            <a href="{{ route('therapists.show', $review->therapist->id) }}" class="btn btn-action secondary">
                                <i class="ri-user-heart-line"></i>View Therapist
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $reviews->links() }}
    </div>
@else
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="ri-star-line"></i>
        </div>
        <h5>No reviews yet</h5>
        <p>You haven't submitted any reviews for your therapy sessions.<br>Complete a session and share your experience!</p>
        <a href="{{ route('client.appointments.index') }}" class="btn btn-view-appointments">
            <i class="ri-calendar-check-line me-2"></i>View Appointments
        </a>
    </div>
@endif
@endsection
