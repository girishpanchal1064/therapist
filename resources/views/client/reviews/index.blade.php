@extends('layouts/contentNavbarLayout')

@section('title', 'My Reviews')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header border-bottom d-flex justify-content-between align-items-center bg-white">
        <div>
          <h5 class="card-title mb-1">
            <i class="ri-star-line me-2"></i>My Reviews
          </h5>
          <small class="text-muted">View all reviews you've submitted for therapy sessions</small>
        </div>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('info'))
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="ri-information-line me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Reviews List -->
        @if($reviews->count() > 0)
          <div class="row g-4">
            @foreach($reviews as $review)
            <div class="col-12">
              <div class="card border h-100 hover-shadow transition-all">
                <div class="card-body">
                  <div class="row">
                    <!-- Therapist Info -->
                    <div class="col-md-3 mb-3 mb-md-0">
                      <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg me-3">
                          <img src="{{ $review->therapist->avatar ?? asset('assets/img/avatars/1.png') }}" 
                               alt="{{ $review->therapist->name }}" 
                               class="rounded-circle"
                               onerror="this.src='{{ asset('assets/img/avatars/1.png') }}'">
                        </div>
                        <div>
                          <h6 class="mb-0 fw-semibold">{{ $review->therapist->name }}</h6>
                          <small class="text-muted">
                            <i class="ri-user-heart-line me-1"></i>Therapist
                          </small>
                        </div>
                      </div>
                    </div>

                    <!-- Rating & Comment -->
                    <div class="col-md-6">
                      <div class="mb-2">
                        <div class="d-flex align-items-center mb-2">
                          <div class="star-rating me-2">
                            @for($i = 1; $i <= 5; $i++)
                              <i class="ri-star{{ $i <= $review->rating ? '-fill' : '-line' }} text-warning" style="font-size: 1.2rem;"></i>
                            @endfor
                          </div>
                          <span class="badge bg-warning-subtle text-warning">{{ $review->rating }}.0</span>
                        </div>
                        @if($review->comment)
                        <p class="mb-0 text-muted">{{ Str::limit($review->comment, 150) }}</p>
                        @else
                        <p class="mb-0 text-muted fst-italic">No comment provided</p>
                        @endif
                      </div>
                    </div>

                    <!-- Status & Date -->
                    <div class="col-md-3 text-md-end">
                      <div class="mb-2">
                        @if($review->is_verified)
                          <span class="badge bg-success-subtle text-success">
                            <i class="ri-checkbox-circle-line me-1"></i>Verified
                          </span>
                        @else
                          <span class="badge bg-warning-subtle text-warning">
                            <i class="ri-time-line me-1"></i>Pending
                          </span>
                        @endif
                        @if($review->is_public)
                          <span class="badge bg-info-subtle text-info ms-1">
                            <i class="ri-eye-line me-1"></i>Public
                          </span>
                        @else
                          <span class="badge bg-secondary-subtle text-secondary ms-1">
                            <i class="ri-eye-off-line me-1"></i>Private
                          </span>
                        @endif
                      </div>
                      <div>
                        <small class="text-muted">
                          <i class="ri-calendar-line me-1"></i>
                          {{ $review->created_at->format('M d, Y') }}
                        </small>
                      </div>
                      @if($review->appointment)
                      <div>
                        <small class="text-muted">
                          <i class="ri-calendar-check-line me-1"></i>
                          Session: {{ \Carbon\Carbon::parse($review->appointment->appointment_date)->format('M d, Y') }}
                        </small>
                      </div>
                      @endif
                    </div>
                  </div>

                  <!-- Full Comment (if truncated) -->
                  @if($review->comment && strlen($review->comment) > 150)
                  <div class="row mt-3 pt-3 border-top">
                    <div class="col-12">
                      <div class="collapse" id="commentCollapse{{ $review->id }}">
                        <div class="card card-body bg-light">
                          <p class="mb-0">{{ $review->comment }}</p>
                        </div>
                      </div>
                      <button class="btn btn-sm btn-link p-0" type="button" data-bs-toggle="collapse" data-bs-target="#commentCollapse{{ $review->id }}">
                        <i class="ri-arrow-down-s-line me-1"></i>Read more
                      </button>
                    </div>
                  </div>
                  @endif

                  <!-- Actions -->
                  <div class="row mt-3 pt-3 border-top">
                    <div class="col-12">
                      <div class="d-flex gap-2">
                        @if($review->appointment)
                        <a href="{{ route('client.appointments.show', $review->appointment->id) }}" 
                           class="btn btn-sm btn-outline-primary">
                          <i class="ri-eye-line me-1"></i>View Appointment
                        </a>
                        @endif
                        @if($review->therapist)
                        <a href="{{ route('therapists.show', $review->therapist->id) }}" 
                           class="btn btn-sm btn-outline-secondary">
                          <i class="ri-user-heart-line me-1"></i>View Therapist
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
          <div class="d-flex justify-content-center mt-4">
            {{ $reviews->links() }}
          </div>
        @else
          <div class="text-center py-5">
            <div class="avatar avatar-xl mx-auto mb-3" style="background-color: #f3f4f6;">
              <i class="ri-star-line text-muted" style="font-size: 3rem;"></i>
            </div>
            <h5 class="text-muted">No reviews yet</h5>
            <p class="text-muted mb-4">You haven't submitted any reviews for your therapy sessions.</p>
            <a href="{{ route('client.appointments.index') }}" class="btn btn-primary">
              <i class="ri-calendar-check-line me-2"></i>View Appointments
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<style>
.hover-shadow {
  transition: all 0.3s ease;
}

.hover-shadow:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
  transform: translateY(-2px);
}

.transition-all {
  transition: all 0.3s ease;
}

.star-rating {
  display: inline-flex;
  gap: 2px;
}
</style>
@endsection
