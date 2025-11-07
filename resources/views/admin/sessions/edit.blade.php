@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Session')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Edit Session</h5>
        <a href="{{ route('admin.sessions.index') }}" class="btn btn-secondary btn-sm">
          <i class="ri-arrow-left-line me-1"></i> Back
        </a>
      </div>
      <div class="card-body">
        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('admin.sessions.update', $session->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="therapist_id" class="form-label">Therapist <span class="text-danger">*</span></label>
              <select class="form-select @error('therapist_id') is-invalid @enderror" 
                      id="therapist_id" name="therapist_id" required>
                <option value="">Select Therapist</option>
                @foreach($therapists as $therapist)
                  <option value="{{ $therapist->id }}" {{ old('therapist_id', $session->therapist_id) == $therapist->id ? 'selected' : '' }}>
                    {{ $therapist->name }} ({{ $therapist->email }})
                  </option>
                @endforeach
              </select>
              @error('therapist_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label for="client_id" class="form-label">Client <span class="text-danger">*</span></label>
              <select class="form-select @error('client_id') is-invalid @enderror" 
                      id="client_id" name="client_id" required>
                <option value="">Select Client</option>
                @foreach($clients as $client)
                  <option value="{{ $client->id }}" {{ old('client_id', $session->client_id) == $client->id ? 'selected' : '' }}>
                    {{ $client->name }} ({{ $client->email }})
                  </option>
                @endforeach
              </select>
              @error('client_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="appointment_type" class="form-label">Appointment Type <span class="text-danger">*</span></label>
              <select class="form-select @error('appointment_type') is-invalid @enderror" 
                      id="appointment_type" name="appointment_type" required>
                <option value="">Select Type</option>
                <option value="individual" {{ old('appointment_type', $session->appointment_type) == 'individual' ? 'selected' : '' }}>Individual</option>
                <option value="couple" {{ old('appointment_type', $session->appointment_type) == 'couple' ? 'selected' : '' }}>Couple</option>
                <option value="family" {{ old('appointment_type', $session->appointment_type) == 'family' ? 'selected' : '' }}>Family</option>
              </select>
              @error('appointment_type')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label for="session_mode" class="form-label">Session Mode <span class="text-danger">*</span></label>
              <select class="form-select @error('session_mode') is-invalid @enderror" 
                      id="session_mode" name="session_mode" required>
                <option value="">Select Mode</option>
                <option value="video" {{ old('session_mode', $session->session_mode) == 'video' ? 'selected' : '' }}>Video</option>
                <option value="audio" {{ old('session_mode', $session->session_mode) == 'audio' ? 'selected' : '' }}>Audio</option>
                <option value="chat" {{ old('session_mode', $session->session_mode) == 'chat' ? 'selected' : '' }}>Chat</option>
              </select>
              @error('session_mode')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="appointment_date" class="form-label">Appointment Date <span class="text-danger">*</span></label>
              <input type="date" class="form-control @error('appointment_date') is-invalid @enderror" 
                     id="appointment_date" name="appointment_date" 
                     value="{{ old('appointment_date', $session->appointment_date->format('Y-m-d')) }}" required>
              @error('appointment_date')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-4 mb-3">
              <label for="appointment_time" class="form-label">Appointment Time <span class="text-danger">*</span></label>
              <input type="time" class="form-control @error('appointment_time') is-invalid @enderror" 
                     id="appointment_time" name="appointment_time" 
                     value="{{ old('appointment_time', is_string($session->appointment_time) ? date('H:i', strtotime($session->appointment_time)) : $session->appointment_time->format('H:i')) }}" required>
              @error('appointment_time')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-4 mb-3">
              <label for="duration_minutes" class="form-label">Duration (Minutes) <span class="text-danger">*</span></label>
              <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" 
                     id="duration_minutes" name="duration_minutes" 
                     value="{{ old('duration_minutes', $session->duration_minutes) }}" 
                     min="30" max="120" step="15" required>
              @error('duration_minutes')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="form-text">Duration between 30-120 minutes (in 15-minute increments)</div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
              <select class="form-select @error('status') is-invalid @enderror" 
                      id="status" name="status" required>
                <option value="scheduled" {{ old('status', $session->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="confirmed" {{ old('status', $session->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="in_progress" {{ old('status', $session->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ old('status', $session->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ old('status', $session->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="no_show" {{ old('status', $session->status) == 'no_show' ? 'selected' : '' }}>No Show</option>
              </select>
              @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-3" id="cancellation_reason_field" style="display: {{ old('status', $session->status) == 'cancelled' ? 'block' : 'none' }};">
            <label for="cancellation_reason" class="form-label">Cancellation Reason</label>
            <textarea class="form-control @error('cancellation_reason') is-invalid @enderror" 
                      id="cancellation_reason" name="cancellation_reason" rows="3">{{ old('cancellation_reason', $session->cancellation_reason) }}</textarea>
            @error('cancellation_reason')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="session_notes" class="form-label">Session Notes</label>
            <textarea class="form-control @error('session_notes') is-invalid @enderror" 
                      id="session_notes" name="session_notes" rows="3">{{ old('session_notes', $session->session_notes) }}</textarea>
            @error('session_notes')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.sessions.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Session</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
  document.getElementById('status').addEventListener('change', function() {
    const cancellationField = document.getElementById('cancellation_reason_field');
    if (this.value === 'cancelled') {
      cancellationField.style.display = 'block';
      document.getElementById('cancellation_reason').required = true;
    } else {
      cancellationField.style.display = 'none';
      document.getElementById('cancellation_reason').required = false;
    }
  });
</script>
@endsection
