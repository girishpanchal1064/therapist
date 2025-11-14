@extends('layouts/contentNavbarLayout')

@section('title', 'Create Appointment')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Create New Appointment</h5>
        <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
          <i class="ri-arrow-left-line me-1"></i> Back to Appointments
        </a>
      </div>
      <div class="card-body">
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

        <form action="{{ route('admin.appointments.store') }}" method="POST">
          @csrf

          <!-- Client and Therapist Selection -->
          <div class="row mb-4">
            <div class="col-md-6">
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

            <div class="col-md-6">
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

          <!-- Appointment Type and Session Mode -->
          <div class="row mb-4">
            <div class="col-md-6">
              <label for="appointment_type" class="form-label">Appointment Type <span class="text-danger">*</span></label>
              <select class="form-select @error('appointment_type') is-invalid @enderror" 
                      id="appointment_type" name="appointment_type" required>
                <option value="">Select Type</option>
                <option value="individual" {{ old('appointment_type') === 'individual' ? 'selected' : '' }}>Individual</option>
                <option value="couple" {{ old('appointment_type') === 'couple' ? 'selected' : '' }}>Couple</option>
                <option value="family" {{ old('appointment_type') === 'family' ? 'selected' : '' }}>Family</option>
              </select>
              @error('appointment_type')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label for="session_mode" class="form-label">Session Mode <span class="text-danger">*</span></label>
              <select class="form-select @error('session_mode') is-invalid @enderror" 
                      id="session_mode" name="session_mode" required>
                <option value="">Select Mode</option>
                <option value="video" {{ old('session_mode') === 'video' ? 'selected' : '' }}>
                  <i class="ri-video-line"></i> Video
                </option>
                <option value="audio" {{ old('session_mode') === 'audio' ? 'selected' : '' }}>
                  <i class="ri-phone-line"></i> Audio
                </option>
                <option value="chat" {{ old('session_mode') === 'chat' ? 'selected' : '' }}>
                  <i class="ri-message-3-line"></i> Chat
                </option>
              </select>
              @error('session_mode')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Date, Time, and Duration -->
          <div class="row mb-4">
            <div class="col-md-4">
              <label for="appointment_date" class="form-label">Appointment Date <span class="text-danger">*</span></label>
              <input type="date" 
                     class="form-control @error('appointment_date') is-invalid @enderror" 
                     id="appointment_date" 
                     name="appointment_date" 
                     value="{{ old('appointment_date') }}" 
                     min="{{ date('Y-m-d') }}" 
                     required>
              @error('appointment_date')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-4">
              <label for="appointment_time" class="form-label">Appointment Time <span class="text-danger">*</span></label>
              <input type="time" 
                     class="form-control @error('appointment_time') is-invalid @enderror" 
                     id="appointment_time" 
                     name="appointment_time" 
                     value="{{ old('appointment_time') }}" 
                     required>
              @error('appointment_time')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-4">
              <label for="duration_minutes" class="form-label">Duration (Minutes) <span class="text-danger">*</span></label>
              <input type="number" 
                     class="form-control @error('duration_minutes') is-invalid @enderror" 
                     id="duration_minutes" 
                     name="duration_minutes" 
                     value="{{ old('duration_minutes', 45) }}" 
                     min="30" 
                     max="120" 
                     step="15" 
                     required>
              @error('duration_minutes')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="form-text">Duration between 30-120 minutes (in 15-minute increments)</div>
            </div>
          </div>

          <!-- Status -->
          <div class="row mb-4">
            <div class="col-md-6">
              <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
              <select class="form-select @error('status') is-invalid @enderror" 
                      id="status" name="status" required>
                <option value="scheduled" {{ old('status', 'scheduled') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="confirmed" {{ old('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="no_show" {{ old('status') === 'no_show' ? 'selected' : '' }}>No Show</option>
              </select>
              @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Meeting Information (Optional) -->
          <div class="mb-4">
            <h6 class="text-muted mb-3">
              <i class="ri-video-line me-2"></i>Meeting Information (Optional)
            </h6>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="meeting_link" class="form-label">Meeting Link</label>
                <input type="url" 
                       class="form-control @error('meeting_link') is-invalid @enderror" 
                       id="meeting_link" 
                       name="meeting_link" 
                       value="{{ old('meeting_link') }}" 
                       placeholder="https://meet.example.com/room-id">
                <div class="form-text">Leave empty to auto-generate</div>
                @error('meeting_link')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-3 mb-3">
                <label for="meeting_id" class="form-label">Meeting ID</label>
                <input type="text" 
                       class="form-control @error('meeting_id') is-invalid @enderror" 
                       id="meeting_id" 
                       name="meeting_id" 
                       value="{{ old('meeting_id') }}" 
                       placeholder="Auto-generated">
                <div class="form-text">Leave empty to auto-generate</div>
                @error('meeting_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-3 mb-3">
                <label for="meeting_password" class="form-label">Meeting Password</label>
                <input type="text" 
                       class="form-control @error('meeting_password') is-invalid @enderror" 
                       id="meeting_password" 
                       name="meeting_password" 
                       value="{{ old('meeting_password') }}" 
                       placeholder="Auto-generated">
                <div class="form-text">Leave empty to auto-generate</div>
                @error('meeting_password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- Session Notes -->
          <div class="mb-4">
            <label for="session_notes" class="form-label">Session Notes</label>
            <textarea class="form-control @error('session_notes') is-invalid @enderror" 
                      id="session_notes" 
                      name="session_notes" 
                      rows="4" 
                      placeholder="Any additional notes about this appointment...">{{ old('session_notes') }}</textarea>
            @error('session_notes')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
              <i class="ri-close-line me-2"></i>Cancel
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="ri-save-line me-2"></i>Create Appointment
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
    // Set minimum date to today
    const dateInput = document.getElementById('appointment_date');
    if (dateInput && !dateInput.value) {
      const today = new Date().toISOString().split('T')[0];
      dateInput.value = today;
    }

    // Auto-generate meeting link when session mode changes
    const sessionModeSelect = document.getElementById('session_mode');
    const meetingLinkInput = document.getElementById('meeting_link');
    const meetingIdInput = document.getElementById('meeting_id');
    const meetingPasswordInput = document.getElementById('meeting_password');

    if (sessionModeSelect && meetingLinkInput) {
      sessionModeSelect.addEventListener('change', function() {
        if (!meetingLinkInput.value && !meetingIdInput.value) {
          // Only auto-generate if fields are empty
          const timestamp = Date.now();
          const therapistId = document.getElementById('therapist_id').value || 'therapist';
          const clientId = document.getElementById('client_id').value || 'client';
          const meetingId = 'meeting_' + timestamp + '_' + therapistId + '_' + clientId;
          
          meetingIdInput.value = meetingId;
          meetingLinkInput.value = window.location.origin + '/session/' + meetingId;
          
          // Generate random password
          const password = Math.random().toString(36).substring(2, 10);
          meetingPasswordInput.value = password;
        }
      });
    }
  });
</script>
@endsection
