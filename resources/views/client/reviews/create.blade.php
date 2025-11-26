@extends('layouts/contentNavbarLayout')

@section('title', 'Write a Review')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header border-bottom bg-white">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h5 class="card-title mb-1">
              <i class="ri-star-line me-2"></i>Write a Review
            </h5>
            <small class="text-muted">Share your experience with this therapy session</small>
          </div>
          <a href="{{ route('client.appointments.index') }}" class="btn btn-outline-secondary">
            <i class="ri-arrow-left-line me-2"></i>Back
          </a>
        </div>
      </div>
      <div class="card-body">
        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri-error-warning-line me-2"></i>
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Appointment Info Card -->
        <div class="card border mb-4">
          <div class="card-body">
            <h6 class="card-title mb-3">
              <i class="ri-calendar-check-line me-2 text-primary"></i>Session Information
            </h6>
            <div class="row">
              <div class="col-md-6">
                <div class="d-flex align-items-center mb-3">
                  <div class="avatar avatar-lg me-3">
                    <img src="{{ $appointment->therapist->avatar ?? asset('assets/img/avatars/1.png') }}" 
                         alt="{{ $appointment->therapist->name }}" 
                         class="rounded-circle"
                         onerror="this.src='{{ asset('assets/img/avatars/1.png') }}'">
                  </div>
                  <div>
                    <h6 class="mb-0 fw-semibold">{{ $appointment->therapist->name }}</h6>
                    <small class="text-muted">Therapist</small>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-2">
                  <i class="ri-calendar-line text-primary me-2"></i>
                  <strong>Date:</strong>
                  <span class="ms-2">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</span>
                </div>
                <div class="mb-2">
                  <i class="ri-time-line text-primary me-2"></i>
                  <strong>Time:</strong>
                  <span class="ms-2">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</span>
                </div>
                <div>
                  <i class="ri-timer-line text-primary me-2"></i>
                  <strong>Duration:</strong>
                  <span class="ms-2">{{ $appointment->duration_minutes }} minutes</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Review Form -->
        <form action="{{ route('client.reviews.store', $appointment->id) }}" method="POST">
          @csrf
          <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

          <!-- Rating -->
          <div class="mb-4">
            <label class="form-label fw-semibold mb-3">
              <i class="ri-star-line me-2"></i>Rate Your Experience <span class="text-danger">*</span>
            </label>
            <div class="rating-input">
              <input type="hidden" id="rating" name="rating" value="{{ old('rating', 5) }}" required>
              <div class="d-flex gap-2 align-items-center">
                @for($i = 1; $i <= 5; $i++)
                  <button type="button" 
                          class="btn btn-link p-0 rating-star" 
                          data-rating="{{ $i }}" 
                          style="font-size: 2.5rem; line-height: 1; text-decoration: none;">
                    <i class="ri-star{{ $i <= old('rating', 5) ? '-fill' : '-line' }} text-warning"></i>
                  </button>
                @endfor
                <span class="ms-3 fw-bold fs-5" id="rating-display">{{ old('rating', 5) }}/5</span>
              </div>
            </div>
            @error('rating')
              <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
          </div>

          <!-- Comment -->
          <div class="mb-4">
            <label for="comment" class="form-label fw-semibold">
              <i class="ri-message-3-line me-2"></i>Your Review <span class="text-muted">(Optional)</span>
            </label>
            <textarea class="form-control @error('comment') is-invalid @enderror" 
                      id="comment" 
                      name="comment" 
                      rows="6" 
                      placeholder="Share your experience with this therapy session. What did you like? How did it help you? (Maximum 1000 characters)"
                      maxlength="1000">{{ old('comment') }}</textarea>
            <div class="d-flex justify-content-between mt-2">
              <small class="text-muted">Maximum 1000 characters</small>
              <small class="text-muted" id="char-count">0 / 1000</small>
            </div>
            @error('comment')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Public/Private Toggle -->
          <div class="mb-4">
            <div class="card border">
              <div class="card-body">
                <div class="form-check form-switch">
                  <input class="form-check-input" 
                         type="checkbox" 
                         id="is_public" 
                         name="is_public" 
                         value="1" 
                         {{ old('is_public', true) ? 'checked' : '' }}>
                  <label class="form-check-label fw-semibold" for="is_public">
                    <i class="ri-eye-line me-2"></i>Make this review public
                  </label>
                </div>
                <small class="text-muted d-block mt-2">
                  Public reviews will be visible to other users on the therapist's profile. Private reviews are only visible to you and the therapist.
                </small>
              </div>
            </div>
          </div>

          <!-- Submit Buttons -->
          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('client.appointments.index') }}" class="btn btn-outline-secondary">
              <i class="ri-close-line me-2"></i>Cancel
            </a>
            <button type="submit" class="btn btn-primary btn-lg">
              <i class="ri-send-plane-line me-2"></i>Submit Review
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
    if (length > 1000) {
      charCount.classList.add('text-danger');
    } else {
      charCount.classList.remove('text-danger');
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
  const ratingContainer = document.querySelector('.rating-input');
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
        icon.style.transform = isHover ? 'scale(1.1)' : 'scale(1)';
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

<style>
.rating-star {
  transition: transform 0.2s ease;
  cursor: pointer;
}

.rating-star:hover {
  transform: scale(1.15);
}

.rating-star i {
  transition: all 0.2s ease;
}
</style>
@endsection
