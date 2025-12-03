@extends('layouts/contentNavbarLayout')

@section('title', 'Add Session Notes')

@section('page-style')
<style>
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    color: white;
  }
  .page-header h4 {
    font-weight: 700;
    color: white;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  .form-card {
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    border: none;
  }
  .form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
  }
  .form-control, .form-select {
    border-radius: 10px;
    border: 1px solid #e4e6eb;
    padding: 0.75rem 1rem;
  }
  .form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  }
  .form-control.is-invalid {
    border-color: #ef4444;
  }
  .invalid-feedback {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.25rem;
  }
  .btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
  }
  .btn-cancel {
    background: #f3f4f6;
    border: none;
    color: #6b7280;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .btn-cancel:hover {
    background: #e5e7eb;
    color: #374151;
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h4>
        <i class="ri-file-add-line"></i>
        Add Session Notes
      </h4>
      <p class="mb-0">Create a new session note for your client</p>
    </div>
    <a href="{{ route('therapist.session-notes.index') }}" class="btn btn-light">
      <i class="ri-arrow-left-line me-1"></i>Back
    </a>
  </div>
</div>

<!-- Form Card -->
<div class="card form-card">
  <div class="card-body p-4">
    <form action="{{ route('therapist.session-notes.store') }}" method="POST" id="sessionNoteForm">
      @csrf

      <!-- Session Selection -->
      <div class="mb-4">
        <label for="appointment_id" class="form-label">Session ID <span class="text-danger">*</span></label>
        <select name="appointment_id" id="appointment_id" class="form-select @error('appointment_id') is-invalid @enderror">
          <option value="">Please select a session</option>
          @foreach($appointments as $appointment)
            <option value="{{ $appointment->id }}" data-client-id="{{ $appointment->client_id }}" data-date="{{ $appointment->appointment_date }}" data-time="{{ $appointment->appointment_time ? $appointment->appointment_time->format('H:i:s') : '' }}">
              S-{{ $appointment->id }} - {{ $appointment->client->name }} ({{ $appointment->appointment_date->format('M d, Y') }})
            </option>
          @endforeach
        </select>
        <input type="hidden" name="client_id" id="client_id" value="{{ old('client_id') }}">
        <input type="hidden" name="session_date" id="session_date" value="{{ old('session_date') }}">
        <input type="hidden" name="start_time" id="start_time" value="{{ old('start_time') }}">
        @error('appointment_id')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- User didn't turn up checkbox -->
      <div class="mb-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="user_didnt_turn_up" id="user_didnt_turn_up" value="1" {{ old('user_didnt_turn_up') ? 'checked' : '' }}>
          <label class="form-check-label" for="user_didnt_turn_up">
            The User didn't turn up.
          </label>
        </div>
      </div>

      <!-- Chief Complaints -->
      <div class="mb-4">
        <label for="chief_complaints" class="form-label">Chief Complaints <span class="text-danger">*</span></label>
        <textarea name="chief_complaints" id="chief_complaints" class="form-control @error('chief_complaints') is-invalid @enderror" rows="4" required>{{ old('chief_complaints') }}</textarea>
        @error('chief_complaints')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Observations -->
      <div class="mb-4">
        <label for="observations" class="form-label">Observations <span class="text-danger">*</span></label>
        <textarea name="observations" id="observations" class="form-control @error('observations') is-invalid @enderror" rows="4" required>{{ old('observations') }}</textarea>
        @error('observations')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Recommendations -->
      <div class="mb-4">
        <label for="recommendations" class="form-label">Recommendations <span class="text-danger">*</span></label>
        <textarea name="recommendations" id="recommendations" class="form-control @error('recommendations') is-invalid @enderror" rows="4" required>{{ old('recommendations') }}</textarea>
        @error('recommendations')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Reason -->
      <div class="mb-4">
        <label for="reason" class="form-label">Reason</label>
        <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" rows="3">{{ old('reason') }}</textarea>
        @error('reason')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- No Follow-up Required checkbox -->
      <div class="mb-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="no_follow_up_required" id="no_follow_up_required" value="1" {{ old('no_follow_up_required') ? 'checked' : '' }}>
          <label class="form-check-label" for="no_follow_up_required">
            No Follow-up Required?
          </label>
        </div>
      </div>

      <!-- Follow-up Date -->
      <div class="mb-4">
        <label for="follow_up_date" class="form-label">Follow-up Date <span class="text-danger">*</span></label>
        <input type="date" name="follow_up_date" id="follow_up_date" class="form-control @error('follow_up_date') is-invalid @enderror" value="{{ old('follow_up_date') }}" required>
        @error('follow_up_date')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Action Buttons -->
      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('therapist.session-notes.index') }}" class="btn btn-cancel">
          <i class="ri-close-line me-1"></i>Cancel
        </a>
        <button type="submit" class="btn btn-submit">
          <i class="ri-save-line me-1"></i>Save Session Note
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const appointmentSelect = document.getElementById('appointment_id');
  const clientIdInput = document.getElementById('client_id');
  const sessionDateInput = document.getElementById('session_date');
  const startTimeInput = document.getElementById('start_time');
  const noFollowUpCheckbox = document.getElementById('no_follow_up_required');
  const followUpDateInput = document.getElementById('follow_up_date');

  // Auto-fill client, date, and time when appointment is selected
  appointmentSelect.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.value) {
      clientIdInput.value = selectedOption.dataset.clientId;
      sessionDateInput.value = selectedOption.dataset.date;
      startTimeInput.value = selectedOption.dataset.time || '';
    } else {
      clientIdInput.value = '';
      sessionDateInput.value = '';
      startTimeInput.value = '';
    }
  });

  // Handle "No Follow-up Required" checkbox
  noFollowUpCheckbox.addEventListener('change', function() {
    if (this.checked) {
      followUpDateInput.value = '';
      followUpDateInput.disabled = true;
      followUpDateInput.removeAttribute('required');
    } else {
      followUpDateInput.disabled = false;
      followUpDateInput.setAttribute('required', 'required');
    }
  });

  // Initialize on page load
  if (noFollowUpCheckbox.checked) {
    followUpDateInput.disabled = true;
    followUpDateInput.removeAttribute('required');
  }
});
</script>
@endsection
