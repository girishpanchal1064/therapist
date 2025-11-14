@extends('layouts/contentNavbarLayout')

@section('title', 'Create Review')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Create New Review</h5>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
          <i class="ri-arrow-left-line me-1"></i> Back to Reviews
        </a>
      </div>
      <div class="card-body">
        @if(session('error'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible" role="alert">
            <i class="ri-error-warning-line me-2"></i>
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form action="{{ route('admin.reviews.store') }}" method="POST">
          @csrf

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="client_id" class="form-label">Client <span class="text-danger">*</span></label>
                <select class="form-select @error('client_id') is-invalid @enderror" 
                        id="client_id" name="client_id" required>
                  <option value="">Select Client</option>
                  @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                      {{ $client->name }} ({{ $client->email }})
                    </option>
                  @endforeach
                </select>
                @error('client_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="therapist_id" class="form-label">Therapist <span class="text-danger">*</span></label>
                <select class="form-select @error('therapist_id') is-invalid @enderror" 
                        id="therapist_id" name="therapist_id" required>
                  <option value="">Select Therapist</option>
                  @foreach($therapists as $therapist)
                    <option value="{{ $therapist->id }}" {{ old('therapist_id') == $therapist->id ? 'selected' : '' }}>
                      {{ $therapist->name }} ({{ $therapist->email }})
                    </option>
                  @endforeach
                </select>
                @error('therapist_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="appointment_id" class="form-label">Appointment (Optional)</label>
            <select class="form-select @error('appointment_id') is-invalid @enderror" 
                    id="appointment_id" name="appointment_id">
              <option value="">No Appointment</option>
              @foreach($appointments as $appointment)
                <option value="{{ $appointment->id }}" {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                  {{ $appointment->appointment_date->format('d-m-Y') }} - 
                  {{ $appointment->client->name }} → {{ $appointment->therapist->name }}
                </option>
              @endforeach
            </select>
            <small class="text-muted">Select an appointment if this review is related to a specific appointment</small>
            @error('appointment_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
            <div class="rating-input">
              <input type="hidden" id="rating" name="rating" value="{{ old('rating', 5) }}" required>
              <div class="d-flex gap-2 align-items-center">
                @for($i = 1; $i <= 5; $i++)
                  <button type="button" class="btn btn-link p-0 rating-star" data-rating="{{ $i }}" style="font-size: 2rem; line-height: 1;">
                    <i class="ri-star{{ $i <= old('rating', 5) ? '-fill' : '-line' }} text-warning"></i>
                  </button>
                @endfor
                <span class="ms-2 fw-bold" id="rating-display">{{ old('rating', 5) }}/5</span>
              </div>
            </div>
            @error('rating')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea class="form-control @error('comment') is-invalid @enderror" 
                      id="comment" name="comment" rows="5" 
                      placeholder="Enter review comment...">{{ old('comment') }}</textarea>
            <small class="text-muted">Maximum 1000 characters</small>
            @error('comment')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="is_verified" 
                         name="is_verified" value="1" {{ old('is_verified') ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_verified">
                    Verified
                  </label>
                </div>
                <small class="text-muted d-block">Mark this review as verified</small>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="is_public" 
                         name="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_public">
                    Public
                  </label>
                </div>
                <small class="text-muted d-block">Make this review visible to the public</small>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
              <i class="ri-close-line me-2"></i>Cancel
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="ri-save-line me-2"></i>Create Review
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
    const ratingInput = document.getElementById('rating');
    const ratingDisplay = document.getElementById('rating-display');
    const ratingStars = document.querySelectorAll('.rating-star');

    ratingStars.forEach((star, index) => {
      star.addEventListener('click', function() {
        const rating = parseInt(this.getAttribute('data-rating'));
        ratingInput.value = rating;
        ratingDisplay.textContent = rating + '/5';

        // Update star display
        ratingStars.forEach((s, i) => {
          const icon = s.querySelector('i');
          if (i < rating) {
            icon.classList.remove('ri-star-line');
            icon.classList.add('ri-star-fill');
          } else {
            icon.classList.remove('ri-star-fill');
            icon.classList.add('ri-star-line');
          }
        });
      });

      star.addEventListener('mouseenter', function() {
        const rating = parseInt(this.getAttribute('data-rating'));
        ratingStars.forEach((s, i) => {
          const icon = s.querySelector('i');
          if (i < rating) {
            icon.classList.add('ri-star-fill');
            icon.classList.remove('ri-star-line');
          }
        });
      });
    });

    // Reset on mouse leave
    document.querySelector('.rating-input').addEventListener('mouseleave', function() {
      const currentRating = parseInt(ratingInput.value);
      ratingStars.forEach((s, i) => {
        const icon = s.querySelector('i');
        if (i < currentRating) {
          icon.classList.add('ri-star-fill');
          icon.classList.remove('ri-star-line');
        } else {
          icon.classList.remove('ri-star-fill');
          icon.classList.add('ri-star-line');
        }
      });
    });
  });
</script>
@endsection
