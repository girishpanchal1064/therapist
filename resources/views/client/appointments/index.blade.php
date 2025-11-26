@extends('layouts/contentNavbarLayout')

@section('title', 'My Appointments')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header border-bottom d-flex justify-content-between align-items-center bg-white">
        <div>
          <h5 class="card-title mb-1">
            <i class="ri-calendar-check-line me-2"></i>My Appointments
          </h5>
          <small class="text-muted">View and manage all your therapy sessions</small>
        </div>
        <a href="{{ route('therapists.index') }}" class="btn btn-primary">
          <i class="ri-add-circle-line me-2"></i>Book New Session
        </a>
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

        <!-- Filters -->
        <form method="GET" action="{{ route('client.appointments.index') }}" class="row g-3 mb-4">
          <div class="col-md-4">
            <label class="form-label">Filter by Status</label>
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
            <label class="form-label">Filter by Date</label>
            <input type="date" name="date" class="form-select" value="{{ request('date') }}" onchange="this.form.submit()">
          </div>
          <div class="col-md-4 d-flex align-items-end">
            @if(request('status') || request('date'))
              <a href="{{ route('client.appointments.index') }}" class="btn btn-outline-secondary w-100">
                <i class="ri-close-line me-2"></i>Clear Filters
              </a>
            @endif
          </div>
        </form>

        <!-- Appointments List -->
        @if($appointments->count() > 0)
          <div class="row g-4">
            @foreach($appointments as $appointment)
            <div class="col-12">
              <div class="card border h-100 hover-shadow transition-all">
                <div class="card-body">
                  <div class="row align-items-center">
                    <!-- Therapist Info -->
                    <div class="col-md-3">
                      <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg me-3">
                          <img src="{{ $appointment->therapist->avatar ?? asset('assets/img/avatars/1.png') }}" 
                               alt="{{ $appointment->therapist->name }}" 
                               class="rounded-circle"
                               onerror="this.src='{{ asset('assets/img/avatars/1.png') }}'">
                        </div>
                        <div>
                          <h6 class="mb-0 fw-semibold">{{ $appointment->therapist->name }}</h6>
                          <small class="text-muted">
                            <i class="ri-user-heart-line me-1"></i>Therapist
                          </small>
                        </div>
                      </div>
                    </div>

                    <!-- Appointment Details -->
                    <div class="col-md-4">
                      <div class="mb-2">
                        <i class="ri-calendar-line text-primary me-2"></i>
                        <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</strong>
                      </div>
                      <div class="mb-2">
                        <i class="ri-time-line text-primary me-2"></i>
                        <strong>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</strong>
                      </div>
                      <div>
                        <i class="ri-timer-line text-primary me-2"></i>
                        <span>{{ $appointment->duration_minutes }} minutes</span>
                      </div>
                    </div>

                    <!-- Session Info -->
                    <div class="col-md-2">
                      <div class="mb-2">
                        <span class="badge bg-info-subtle text-info">
                          <i class="ri-{{ $appointment->session_mode === 'video' ? 'video' : ($appointment->session_mode === 'audio' ? 'mic' : 'chat') }}-line me-1"></i>
                          {{ ucfirst($appointment->session_mode) }}
                        </span>
                      </div>
                      <div>
                        <span class="badge bg-secondary-subtle text-secondary">
                          {{ ucfirst($appointment->appointment_type) }}
                        </span>
                      </div>
                    </div>

                    <!-- Status & Actions -->
                    <div class="col-md-3 text-end">
                      <div class="mb-2">
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
                        <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} fs-6">
                          {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                        </span>
                      </div>
                      <div class="btn-group" role="group">
                        <a href="{{ route('client.appointments.show', $appointment->id) }}" 
                           class="btn btn-sm btn-outline-primary" 
                           title="View Details">
                          <i class="ri-eye-line"></i>
                        </a>
                        @if(in_array($appointment->status, ['confirmed', 'in_progress']))
                          <a href="{{ route('client.sessions.join', $appointment->id) }}" 
                             class="btn btn-sm btn-primary" 
                             title="Join Session">
                            <i class="ri-video-line me-1"></i>Join
                          </a>
                        @endif
                        @if($appointment->status === 'completed')
                          <a href="{{ route('client.reviews.create', $appointment->id) }}" 
                             class="btn btn-sm btn-outline-success" 
                             title="Add Review">
                            <i class="ri-star-line"></i>
                          </a>
                        @endif
                      </div>
                    </div>
                  </div>

                  <!-- Payment Status -->
                  @if($appointment->payment)
                  <div class="row mt-3 pt-3 border-top">
                    <div class="col-12">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <small class="text-muted">Payment Status:</small>
                          <span class="badge bg-{{ $appointment->payment->status === 'completed' ? 'success' : 'warning' }}-subtle text-{{ $appointment->payment->status === 'completed' ? 'success' : 'warning' }} ms-2">
                            {{ ucfirst($appointment->payment->status) }}
                          </span>
                        </div>
                        <div>
                          <strong class="text-primary">₹{{ number_format($appointment->payment->total_amount ?? 0, 2) }}</strong>
                        </div>
                      </div>
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
            {{ $appointments->links() }}
          </div>
        @else
          <div class="text-center py-5">
            <div class="avatar avatar-xl mx-auto mb-3" style="background-color: #f3f4f6;">
              <i class="ri-calendar-line text-muted" style="font-size: 3rem;"></i>
            </div>
            <h5 class="text-muted">No appointments found</h5>
            <p class="text-muted mb-4">
              @if(request('status') || request('date'))
                Try adjusting your filters or
              @else
                You haven't booked any sessions yet.
              @endif
            </p>
            <a href="{{ route('therapists.index') }}" class="btn btn-primary">
              <i class="ri-add-circle-line me-2"></i>Book Your First Session
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
</style>
@endsection
