@extends('layouts/contentNavbarLayout')

@section('title', 'Add Session Notes')

@section('page-style')
<style>
  .layout-page .content-wrapper { background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important; }

  .therapist-session-notes-apni .sn-form-label {
    font-weight: 600;
    color: #041c54;
    margin-bottom: 0.5rem;
  }
  .therapist-session-notes-apni .form-control,
  .therapist-session-notes-apni .form-select {
    border-radius: 10px;
    border: 2px solid rgba(186, 194, 210, 0.85);
    padding: 0.75rem 1rem;
  }
  .therapist-session-notes-apni .form-control:focus,
  .therapist-session-notes-apni .form-select:focus {
    border-color: #041c54;
    box-shadow: 0 0 0 4px rgba(4, 28, 84, 0.12);
    outline: none;
  }
  .therapist-session-notes-apni .form-control.is-invalid {
    border-color: #dc3545;
  }
  .therapist-session-notes-apni .invalid-feedback {
    color: #b91c1c;
    font-size: 0.875rem;
    margin-top: 0.25rem;
  }
  .therapist-session-notes-apni .form-check-input:focus {
    box-shadow: 0 0 0 3px rgba(4, 28, 84, 0.15);
    border-color: #041c54;
  }
  .therapist-session-notes-apni .form-check-input:checked {
    background-color: #041c54;
    border-color: #041c54;
  }
  .therapist-session-notes-apni .btn-sn-submit {
    background: #041c54;
    border: none;
    color: #fff !important;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.2);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
  }
  .therapist-session-notes-apni .btn-sn-submit:hover {
    background: #052a6b;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(4, 28, 84, 0.25);
  }
  .therapist-session-notes-apni .btn-sn-cancel {
    background: #f8fafc;
    border: 2px solid rgba(186, 194, 210, 0.85);
    color: #7484a4 !important;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
  }
  .therapist-session-notes-apni .btn-sn-cancel:hover {
    background: #eef2f6;
    color: #041c54 !important;
    border-color: rgba(4, 28, 84, 0.25);
  }
</style>
@endsection

@section('content')
<div class="therapist-session-notes-apni pb-2">
  <div class="relative mb-8 overflow-hidden rounded-3xl shadow-[0_20px_25px_-5px_rgba(100,116,148,0.2),0_8px_10px_-6px_rgba(100,116,148,0.2)]"
       style="background: linear-gradient(171deg, #647494 0%, #6d7f9d 25%, #7484A4 50%, #6d7f9d 75%, #647494 100%);">
    <div class="pointer-events-none absolute -right-20 top-0 h-64 w-64 rounded-full bg-white/10 blur-[64px]" aria-hidden="true"></div>
    <div class="relative z-10 flex flex-col gap-6 p-6 lg:flex-row lg:items-center lg:justify-between lg:p-8">
      <div class="min-w-0">
        <h1 class="font-display flex items-center gap-3 text-2xl font-medium leading-snug text-white md:text-3xl">
          <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[14px] bg-white/15 text-[1.5rem] backdrop-blur-sm">
            <i class="ri-file-add-line"></i>
          </span>
          Add Session Notes
        </h1>
        <p class="mt-2 max-w-xl text-base text-white/90">
          Create a new session note for your client.
        </p>
      </div>
      <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:items-center">
        <a href="{{ route('therapist.session-notes.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] bg-white px-5 py-2.5 text-sm font-medium text-[#041C54] shadow-md transition hover:bg-[#BAC2D2]/30">
          <i class="ri-arrow-left-line text-lg"></i>
          Back to notes
        </a>
      </div>
    </div>
  </div>

  <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-4 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
    <form action="{{ route('therapist.session-notes.store') }}" method="POST" id="sessionNoteForm">
      @csrf

      <div class="mb-4">
        <label for="appointment_id" class="form-label sn-form-label">Session ID <span class="text-danger">*</span></label>
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

      <div class="mb-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="user_didnt_turn_up" id="user_didnt_turn_up" value="1" {{ old('user_didnt_turn_up') ? 'checked' : '' }}>
          <label class="form-check-label text-[#647494]" for="user_didnt_turn_up">
            The User didn't turn up.
          </label>
        </div>
      </div>

      <div class="mb-4">
        <label for="chief_complaints" class="form-label sn-form-label">Chief Complaints <span class="text-danger">*</span></label>
        <textarea name="chief_complaints" id="chief_complaints" class="form-control @error('chief_complaints') is-invalid @enderror" rows="4" required>{{ old('chief_complaints') }}</textarea>
        @error('chief_complaints')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="observations" class="form-label sn-form-label">Observations <span class="text-danger">*</span></label>
        <textarea name="observations" id="observations" class="form-control @error('observations') is-invalid @enderror" rows="4" required>{{ old('observations') }}</textarea>
        @error('observations')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="recommendations" class="form-label sn-form-label">Recommendations <span class="text-danger">*</span></label>
        <textarea name="recommendations" id="recommendations" class="form-control @error('recommendations') is-invalid @enderror" rows="4" required>{{ old('recommendations') }}</textarea>
        @error('recommendations')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="reason" class="form-label sn-form-label">Reason</label>
        <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" rows="3">{{ old('reason') }}</textarea>
        @error('reason')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="no_follow_up_required" id="no_follow_up_required" value="1" {{ old('no_follow_up_required') ? 'checked' : '' }}>
          <label class="form-check-label text-[#647494]" for="no_follow_up_required">
            No Follow-up Required?
          </label>
        </div>
      </div>

      <div class="mb-4">
        <label for="follow_up_date" class="form-label sn-form-label">Follow-up Date <span class="text-danger">*</span></label>
        <input type="date" name="follow_up_date" id="follow_up_date" class="form-control @error('follow_up_date') is-invalid @enderror" value="{{ old('follow_up_date') }}" required>
        @error('follow_up_date')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="d-flex justify-content-end flex-wrap gap-2 mt-4 pt-2 border-top border-[#BAC2D2]/30">
        <a href="{{ route('therapist.session-notes.index') }}" class="btn btn-sn-cancel">
          <i class="ri-close-line me-1"></i>Cancel
        </a>
        <button type="submit" class="btn btn-sn-submit">
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

  if (noFollowUpCheckbox.checked) {
    followUpDateInput.disabled = true;
    followUpDateInput.removeAttribute('required');
  }
});
</script>
@endsection
