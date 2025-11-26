@extends('layouts/contentNavbarLayout')

@section('title', 'Join Session')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <i class="ri-video-line me-2"></i>Online Session
        </h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-8">
            <!-- Video Container -->
            <div class="card border-primary mb-3">
              <div class="card-body p-0" style="background: #000; min-height: 400px; position: relative;">
                <div id="videoContainer" class="d-flex align-items-center justify-content-center" style="min-height: 400px;">
                  <div class="text-center text-white">
                    <i class="ri-video-line" style="font-size: 4rem;"></i>
                    <p class="mt-3">Video session will start here</p>
                    <p class="text-muted">Meeting Link: {{ $appointment->meeting_link ?? 'Not available' }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Session Controls -->
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-center gap-2">
                  <button class="btn btn-primary" id="toggleVideo">
                    <i class="ri-video-line me-1"></i>Video
                  </button>
                  <button class="btn btn-primary" id="toggleAudio">
                    <i class="ri-mic-line me-1"></i>Audio
                  </button>
                  <button class="btn btn-danger" id="endSession">
                    <i class="ri-phone-line me-1"></i>End Session
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <!-- Session Info -->
            <div class="card mb-3">
              <div class="card-header">
                <h6 class="mb-0">Session Details</h6>
              </div>
              <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <div class="avatar avatar-md me-3">
                    <img src="{{ $appointment->therapist->avatar }}" alt="{{ $appointment->therapist->name }}" class="rounded-circle">
                  </div>
                  <div>
                    <h6 class="mb-0">{{ $appointment->therapist->name }}</h6>
                    <small class="text-muted">Therapist</small>
                  </div>
                </div>
                <hr>
                <div class="mb-2">
                  <small class="text-muted d-block">Date & Time</small>
                  <strong>{{ $appointment->appointment_date->format('M d, Y') }}</strong><br>
                  <strong>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</strong>
                </div>
                <div class="mb-2">
                  <small class="text-muted d-block">Duration</small>
                  <strong>{{ $appointment->duration_minutes }} minutes</strong>
                </div>
                <div class="mb-2">
                  <small class="text-muted d-block">Mode</small>
                  <strong>{{ ucfirst($appointment->session_mode) }}</strong>
                </div>
                <div>
                  <small class="text-muted d-block">Status</small>
                  <span class="badge bg-success">{{ ucfirst($appointment->status) }}</span>
                </div>
              </div>
            </div>

            <!-- Chat/Notes -->
            <div class="card">
              <div class="card-header">
                <h6 class="mb-0">Session Notes</h6>
              </div>
              <div class="card-body">
                <div id="sessionNotes" style="max-height: 200px; overflow-y: auto;">
                  @if($appointment->session_notes)
                    <p>{{ $appointment->session_notes }}</p>
                  @else
                    <p class="text-muted">No notes available</p>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  let videoEnabled = true;
  let audioEnabled = true;

  // Toggle Video
  document.getElementById('toggleVideo').addEventListener('click', function() {
    videoEnabled = !videoEnabled;
    this.innerHTML = videoEnabled 
      ? '<i class="ri-video-line me-1"></i>Video' 
      : '<i class="ri-video-off-line me-1"></i>Video Off';
    this.classList.toggle('btn-outline-primary', !videoEnabled);
    this.classList.toggle('btn-primary', videoEnabled);
  });

  // Toggle Audio
  document.getElementById('toggleAudio').addEventListener('click', function() {
    audioEnabled = !audioEnabled;
    this.innerHTML = audioEnabled 
      ? '<i class="ri-mic-line me-1"></i>Audio' 
      : '<i class="ri-mic-off-line me-1"></i>Audio Off';
    this.classList.toggle('btn-outline-primary', !audioEnabled);
    this.classList.toggle('btn-primary', audioEnabled);
  });

  // End Session
  document.getElementById('endSession').addEventListener('click', function() {
    if (confirm('Are you sure you want to end this session?')) {
      // In production, make API call to end session
      window.location.href = '{{ route("client.dashboard") }}';
    }
  });

  // Auto-join meeting link if available
  @if($appointment->meeting_link)
    console.log('Meeting Link: {{ $appointment->meeting_link }}');
    // In production, integrate with video calling service (Zoom, Google Meet, etc.)
  @endif
});
</script>
@endpush
@endsection
