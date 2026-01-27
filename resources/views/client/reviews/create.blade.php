@extends('layouts/contentNavbarLayout')

@section('title', 'Write a Review')

@section('page-style')
<style>
:root {
    --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
    --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

/* Page Header */
.page-header {
    background: var(--warning-gradient);
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
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
    position: relative;
    z-index: 1;
}

.btn-back {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.625rem 1.25rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-back:hover {
    background: white;
    color: #d97706;
    border-color: white;
}

/* Alert Styling */
.alert-themed {
    border: none;
    border-radius: 14px;
    border-left: 5px solid;
    padding: 1rem 1.25rem;
}

.alert-themed.alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border-left-color: #ef4444;
    color: #991b1b;
}

/* Session Info Card */
.session-card {
    background: white;
    border: none;
    border-radius: 20px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.06);
    overflow: hidden;
}

.session-card-header {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(102, 126, 234, 0.1);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.session-card-header .icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    background: var(--theme-gradient);
    color: white;
}

.session-card-header h6 {
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.session-card-body {
    padding: 1.5rem;
}

/* Therapist Info */
.therapist-section {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.therapist-avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    object-fit: cover;
    border: 4px solid #f0f2ff;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.15);
}

.therapist-avatar-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    background: var(--theme-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    font-weight: 700;
    color: white;
}

.therapist-name {
    font-weight: 700;
    color: #1f2937;
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

.therapist-role {
    color: #6b7280;
    font-size: 0.9rem;
}

/* Session Details */
.session-details {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(102, 126, 234, 0.1);
}

.detail-item {
    text-align: center;
    padding: 1rem;
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border-radius: 14px;
}

.detail-item i {
    font-size: 1.5rem;
    color: #667eea;
    margin-bottom: 0.5rem;
}

.detail-item strong {
    display: block;
    color: #6b7280;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}

.detail-item span {
    display: block;
    color: #1f2937;
    font-weight: 600;
    font-size: 0.95rem;
}

/* Review Form Card */
.form-card {
    background: white;
    border: none;
    border-radius: 20px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.06);
    overflow: hidden;
}

.form-card-body {
    padding: 2rem;
}

/* Rating Input */
.rating-section {
    margin-bottom: 2rem;
}

.rating-label {
    font-weight: 700;
    color: #1f2937;
    font-size: 1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.rating-label i {
    color: #fbbf24;
}

.rating-input {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border: 2px solid rgba(251, 191, 36, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
}

.rating-stars {
    display: flex;
    justify-content: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.rating-star {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.rating-star:hover {
    transform: scale(1.2);
}

.rating-star i {
    font-size: 3rem;
    color: #fbbf24;
    transition: all 0.2s ease;
}

.rating-display {
    font-size: 1.5rem;
    font-weight: 800;
    color: #d97706;
}

/* Comment Section */
.comment-section {
    margin-bottom: 2rem;
}

.comment-label {
    font-weight: 700;
    color: #1f2937;
    font-size: 1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.comment-label i {
    color: #667eea;
}

.comment-label .optional {
    font-weight: 500;
    color: #9ca3af;
    font-size: 0.85rem;
}

.form-control-comment {
    border: 2px solid #e5e7eb;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    font-size: 0.95rem;
    resize: vertical;
    min-height: 150px;
    transition: all 0.3s ease;
}

.form-control-comment:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
}

.comment-footer {
    display: flex;
    justify-content: space-between;
    margin-top: 0.75rem;
}

.comment-hint {
    color: #9ca3af;
    font-size: 0.8rem;
}

.char-count {
    color: #6b7280;
    font-size: 0.8rem;
    font-weight: 500;
}

.char-count.danger {
    color: #ef4444;
}

/* Privacy Toggle */
.privacy-section {
    margin-bottom: 2rem;
}

.privacy-card {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border: 2px solid rgba(102, 126, 234, 0.15);
    border-radius: 16px;
    padding: 1.25rem;
    transition: all 0.3s ease;
}

.privacy-card:hover {
    border-color: rgba(102, 126, 234, 0.3);
}

.privacy-toggle {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.privacy-toggle .form-check-input {
    width: 50px;
    height: 26px;
    border-radius: 13px;
    cursor: pointer;
}

.privacy-toggle .form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}

.privacy-info {
    flex: 1;
}

.privacy-title {
    font-weight: 700;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
}

.privacy-title i {
    color: #667eea;
}

.privacy-description {
    color: #6b7280;
    font-size: 0.85rem;
    line-height: 1.5;
    margin: 0;
}

/* Submit Buttons */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(102, 126, 234, 0.1);
}

.btn-cancel {
    background: transparent;
    border: 2px solid #d1d5db;
    color: #6b7280;
    padding: 0.875rem 1.75rem;
    border-radius: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
    color: #374151;
}

.btn-submit {
    background: var(--warning-gradient);
    border: none;
    color: white;
    padding: 0.875rem 2rem;
    border-radius: 14px;
    font-weight: 700;
    font-size: 1rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }

    .session-details {
        grid-template-columns: repeat(1, 1fr);
    }

    .therapist-section {
        flex-direction: column;
        text-align: center;
    }

    .rating-star i {
        font-size: 2.25rem;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .btn-cancel,
    .btn-submit {
        width: 100%;
        justify-content: center;
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
                <i class="ri-star-line"></i>
            </div>
            <div>
                <h4 class="mb-1">Write a Review</h4>
                <p class="mb-0">Share your experience with this therapy session</p>
            </div>
        </div>
        <a href="{{ route('client.appointments.index') }}" class="btn btn-back">
            <i class="ri-arrow-left-line me-2"></i>Back
        </a>
    </div>
</div>

<!-- Alerts -->
@if(session('error'))
    <div class="alert alert-themed alert-danger alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="ri-error-warning-fill me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-themed alert-danger alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="ri-error-warning-fill me-2 fs-5"></i>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Session Info Card -->
    <div class="col-lg-4">
        <div class="session-card">
            <div class="session-card-header">
                <div class="icon">
                    <i class="ri-calendar-check-line"></i>
                </div>
                <h6>Session Information</h6>
            </div>
            <div class="session-card-body">
                <!-- Therapist Info -->
                <div class="therapist-section">
                    @if($appointment->therapist->therapistProfile && $appointment->therapist->therapistProfile->profile_image)
                        <img src="{{ asset('storage/' . $appointment->therapist->therapistProfile->profile_image) }}"
                             alt="{{ $appointment->therapist->name }}"
                             class="therapist-avatar-large">
                    @elseif($appointment->therapist->avatar)
                        <img src="{{ asset('storage/' . $appointment->therapist->avatar) }}"
                             alt="{{ $appointment->therapist->name }}"
                             class="therapist-avatar-large">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->therapist->name) }}&background=667eea&color=fff&size=160&bold=true&format=svg"
                             alt="{{ $appointment->therapist->name }}"
                             class="therapist-avatar-large">
                    @endif
                    <div>
                        <div class="therapist-name">{{ $appointment->therapist->name }}</div>
                        <div class="therapist-role">
                            <i class="ri-user-heart-line me-1"></i>Therapist
                        </div>
                    </div>
                </div>

                <!-- Session Details -->
                <div class="session-details">
                    <div class="detail-item">
                        <i class="ri-calendar-line d-block"></i>
                        <strong>Date</strong>
                        <span>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <i class="ri-time-line d-block"></i>
                        <strong>Time</strong>
                        <span>{{ \Carbon\Carbon::parse($appointment->appointment_time, 'Asia/Kolkata')->setTimezone('Asia/Kolkata')->format('g:i A') }} IST</span>
                    </div>
                    <div class="detail-item">
                        <i class="ri-timer-line d-block"></i>
                        <strong>Duration</strong>
                        <span>{{ $appointment->duration_minutes }} min</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Form -->
    <div class="col-lg-8">
        <div class="form-card">
            <div class="form-card-body">
                <form action="{{ route('client.reviews.store', $appointment->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                    <!-- Rating Section -->
                    <div class="rating-section">
                        <label class="rating-label">
                            <i class="ri-star-fill"></i>
                            Rate Your Experience <span class="text-danger">*</span>
                        </label>
                        <div class="rating-input">
                            <input type="hidden" id="rating" name="rating" value="{{ old('rating', 5) }}" required>
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" class="rating-star" data-rating="{{ $i }}">
                                        <i class="ri-star{{ $i <= old('rating', 5) ? '-fill' : '-line' }}"></i>
                                    </button>
                                @endfor
                            </div>
                            <div class="rating-display" id="rating-display">{{ old('rating', 5) }}/5</div>
                        </div>
                        @error('rating')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Comment Section -->
                    <div class="comment-section">
                        <label class="comment-label" for="comment">
                            <i class="ri-message-3-line"></i>
                            Your Review <span class="optional">(Optional)</span>
                        </label>
                        <textarea class="form-control form-control-comment @error('comment') is-invalid @enderror"
                                  id="comment"
                                  name="comment"
                                  rows="5"
                                  placeholder="Share your experience with this therapy session. What did you like? How did it help you?"
                                  maxlength="1000">{{ old('comment') }}</textarea>
                        <div class="comment-footer">
                            <small class="comment-hint">
                                <i class="ri-information-line me-1"></i>Maximum 1000 characters
                            </small>
                            <small class="char-count" id="char-count">0 / 1000</small>
                        </div>
                        @error('comment')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Privacy Section -->
                    <div class="privacy-section">
                        <div class="privacy-card">
                            <label class="privacy-toggle">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_public"
                                       name="is_public"
                                       value="1"
                                       {{ old('is_public', true) ? 'checked' : '' }}>
                                <div class="privacy-info">
                                    <div class="privacy-title">
                                        <i class="ri-eye-line"></i>
                                        Make this review public
                                    </div>
                                    <p class="privacy-description">
                                        Public reviews are visible to other users on the therapist's profile.
                                        Private reviews are only visible to you and the therapist.
                                    </p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="form-actions">
                        <a href="{{ route('client.appointments.index') }}" class="btn btn-cancel">
                            <i class="ri-close-line me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-submit">
                            <i class="ri-send-plane-line"></i>
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Star rating interaction
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');
    const ratingDisplay = document.getElementById('rating-display');
    const commentTextarea = document.getElementById('comment');
    const charCount = document.getElementById('char-count');

    // Initialize character count
    if (commentTextarea && charCount) {
        updateCharCount();
        commentTextarea.addEventListener('input', updateCharCount);
    }

    function updateCharCount() {
        const length = commentTextarea.value.length;
        charCount.textContent = `${length} / 1000`;
        if (length > 900) {
            charCount.classList.add('danger');
        } else {
            charCount.classList.remove('danger');
        }
    }

    // Star rating click handler
    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            ratingInput.value = rating;
            updateStarDisplay(rating);
        });

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            updateStarDisplay(rating, true);
        });
    });

    // Reset stars on mouse leave
    const ratingContainer = document.querySelector('.rating-stars');
    if (ratingContainer) {
        ratingContainer.addEventListener('mouseleave', function() {
            const currentRating = parseInt(ratingInput.value);
            updateStarDisplay(currentRating);
        });
    }

    function updateStarDisplay(rating, isHover = false) {
        ratingStars.forEach((star, index) => {
            const starIndex = index + 1;
            const icon = star.querySelector('i');
            if (starIndex <= rating) {
                icon.classList.remove('ri-star-line');
                icon.classList.add('ri-star-fill');
                icon.style.transform = isHover ? 'scale(1.15)' : 'scale(1)';
            } else {
                icon.classList.remove('ri-star-fill');
                icon.classList.add('ri-star-line');
                icon.style.transform = 'scale(1)';
            }
        });
        ratingDisplay.textContent = `${rating}/5`;
    }

    // Initialize display
    const initialRating = parseInt(ratingInput.value);
    updateStarDisplay(initialRating);
});
</script>
@endsection
