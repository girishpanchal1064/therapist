@extends('layouts/contentNavbarLayout')

@section('title', 'Appointment Details')

@section('content')
<div class="row">
  <div class="col-12">
    <!-- Back Button -->
    <div class="mb-3">
      <a href="{{ route('client.appointments.index') }}" class="btn btn-outline-secondary">
        <i class="ri-arrow-left-line me-2"></i>Back to Appointments
      </a>
    </div>

    <!-- Appointment Details Card -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header border-bottom bg-white">
        <h5 class="card-title mb-0">
          <i class="ri-calendar-check-line me-2"></i>Appointment Details
        </h5>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- Therapist Info -->
          <div class="col-md-6 mb-4">
            <div class="card border h-100">
              <div class="card-body">
                <h6 class="card-title mb-3">
                  <i class="ri-user-heart-line me-2 text-primary"></i>Therapist Information
                </h6>
                <div class="d-flex align-items-center mb-3">
                  <div class="avatar avatar-xl me-3">
                    <img src="{{ $appointment->therapist->avatar ?? asset('assets/img/avatars/1.png') }}" 
                         alt="{{ $appointment->therapist->name }}" 
                         class="rounded-circle"
                         onerror="this.src='{{ asset('assets/img/avatars/1.png') }}'">
                  </div>
                  <div>
                    <h5 class="mb-1">{{ $appointment->therapist->name }}</h5>
                    <p class="text-muted mb-0">{{ $appointment->therapist->email }}</p>
                  </div>
                </div>
                @if($appointment->therapist->therapistProfile)
                <div class="mt-3">
                  <a href="{{ route('therapists.show', $appointment->therapist->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="ri-eye-line me-2"></i>View Therapist Profile
                  </a>
                </div>
                @endif
              </div>
            </div>
          </div>

          <!-- Appointment Info -->
          <div class="col-md-6 mb-4">
            <div class="card border h-100">
              <div class="card-body">
                <h6 class="card-title mb-3">
                  <i class="ri-information-line me-2 text-primary"></i>Appointment Information
                </h6>
                <div class="mb-3">
                  <div class="d-flex align-items-center mb-2">
                    <i class="ri-calendar-line text-primary me-2"></i>
                    <div>
                      <strong>Date:</strong>
                      <span class="ms-2">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F d, Y') }}</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <i class="ri-time-line text-primary me-2"></i>
                    <div>
                      <strong>Time:</strong>
                      <span class="ms-2">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <i class="ri-timer-line text-primary me-2"></i>
                    <div>
                      <strong>Duration:</strong>
                      <span class="ms-2">{{ $appointment->duration_minutes }} minutes</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <i class="ri-video-line text-primary me-2"></i>
                    <div>
                      <strong>Session Mode:</strong>
                      <span class="badge bg-info-subtle text-info ms-2">{{ ucfirst($appointment->session_mode) }}</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center">
                    <i class="ri-file-list-3-line text-primary me-2"></i>
                    <div>
                      <strong>Type:</strong>
                      <span class="badge bg-secondary-subtle text-secondary ms-2">{{ ucfirst($appointment->appointment_type) }}</span>
                    </div>
                  </div>
                </div>
                <div class="mt-3">
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
                  <strong>Status:</strong>
                  <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} fs-6 ms-2">
                    {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Meeting Information -->
        @if($appointment->meeting_id || $appointment->meeting_link)
        <div class="card border mb-4">
          <div class="card-body">
            <h6 class="card-title mb-3">
              <i class="ri-video-line me-2 text-primary"></i>Meeting Information
            </h6>
            @if($appointment->meeting_id)
            <div class="mb-2">
              <strong>Meeting ID:</strong>
              <code class="ms-2">{{ $appointment->meeting_id }}</code>
            </div>
            @endif
            @if($appointment->meeting_link)
            <div class="mb-3">
              <strong>Meeting Link:</strong>
              <a href="{{ $appointment->meeting_link }}" target="_blank" class="ms-2">
                {{ $appointment->meeting_link }}
                <i class="ri-external-link-line"></i>
              </a>
            </div>
            @endif
            @if(in_array($appointment->status, ['confirmed', 'in_progress']))
            <a href="{{ route('client.sessions.join', $appointment->id) }}" class="btn btn-primary">
              <i class="ri-video-line me-2"></i>Join Session
            </a>
            @endif
          </div>
        </div>
        @endif

        <!-- Payment Information -->
        @if($appointment->payment)
        <div class="card border mb-4">
          <div class="card-body">
            <h6 class="card-title mb-3">
              <i class="ri-money-rupee-circle-line me-2 text-primary"></i>Payment Information
            </h6>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-2">
                  <strong>Amount:</strong>
                  <span class="text-primary fs-5 fw-bold ms-2">₹{{ number_format($appointment->payment->total_amount ?? 0, 2) }}</span>
                </div>
                <div class="mb-2">
                  <strong>Payment Status:</strong>
                  <span class="badge bg-{{ $appointment->payment->status === 'completed' ? 'success' : 'warning' }}-subtle text-{{ $appointment->payment->status === 'completed' ? 'success' : 'warning' }} ms-2">
                    {{ ucfirst($appointment->payment->status) }}
                  </span>
                </div>
                @if($appointment->payment->payment_method)
                <div class="mb-2">
                  <strong>Payment Method:</strong>
                  <span class="ms-2">{{ ucfirst(str_replace('_', ' ', $appointment->payment->payment_method)) }}</span>
                </div>
                @endif
              </div>
              <div class="col-md-6">
                @if($appointment->payment->paid_at)
                <div class="mb-2">
                  <strong>Paid At:</strong>
                  <span class="ms-2">{{ \Carbon\Carbon::parse($appointment->payment->paid_at)->format('M d, Y h:i A') }}</span>
                </div>
                @endif
                @if($appointment->payment->transaction_id)
                <div class="mb-2">
                  <strong>Transaction ID:</strong>
                  <code class="ms-2">{{ $appointment->payment->transaction_id }}</code>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
        @endif

        <!-- Notes -->
        @if($appointment->notes)
        <div class="card border mb-4">
          <div class="card-body">
            <h6 class="card-title mb-3">
              <i class="ri-file-text-line me-2 text-primary"></i>Notes
            </h6>
            <p class="mb-0">{{ $appointment->notes }}</p>
          </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="d-flex gap-2">
          @if(in_array($appointment->status, ['confirmed', 'in_progress']))
            <a href="{{ route('client.sessions.join', $appointment->id) }}" class="btn btn-primary">
              <i class="ri-video-line me-2"></i>Join Session
            </a>
          @endif
          @if($appointment->status === 'completed')
            <a href="{{ route('client.reviews.create', $appointment->id) }}" class="btn btn-success">
              <i class="ri-star-line me-2"></i>Add Review
            </a>
          @endif
          <a href="{{ route('client.appointments.index') }}" class="btn btn-outline-secondary">
            <i class="ri-arrow-left-line me-2"></i>Back to List
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
