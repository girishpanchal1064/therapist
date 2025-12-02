@extends('layouts/contentNavbarLayout')

@section('title', 'Create Session')

@section('vendor-style')
<style>
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
  }
  .page-header h4 { margin: 0; font-weight: 700; color: white; font-size: 1.5rem; }
  .page-header p { color: rgba(255, 255, 255, 0.85); margin: 4px 0 0 0; }
  .page-header .btn-header {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .page-header .btn-header:hover { background: rgba(255, 255, 255, 0.3); color: white; }

  .form-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
    overflow: hidden;
  }
  .form-card .card-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    border-bottom: 1px solid #e9ecef;
    padding: 20px 24px;
  }
  .form-card .card-body { padding: 24px; }

  .section-title {
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .section-title .icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  .section-title h5 { margin: 0; font-weight: 700; color: #2d3748; }
  .section-title small { color: #718096; font-size: 0.85rem; }

  .form-label-styled { font-weight: 600; color: #4a5568; margin-bottom: 8px; font-size: 0.9rem; display: block; }
  .form-control, .form-select {
    border: 2px solid #e4e6eb;
    border-radius: 10px;
    padding: 12px 16px;
    transition: all 0.3s ease;
  }
  .form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  }

  /* Option Cards */
  .option-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
  .option-card {
    border: 2px solid #e4e6eb;
    border-radius: 12px;
    padding: 16px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
  }
  .option-card:hover { border-color: #667eea; transform: translateY(-2px); }
  .option-card.selected { border-color: #667eea; background: rgba(102, 126, 234, 0.05); }
  .option-card input { display: none; }
  .option-card .option-icon {
    width: 50px; height: 50px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; margin: 0 auto 10px;
  }
  .option-card h6 { margin: 0 0 4px; font-weight: 600; }
  .option-card small { color: #718096; font-size: 0.75rem; }

  /* Duration Pills */
  .duration-pills { display: flex; gap: 10px; flex-wrap: wrap; }
  .duration-pill {
    border: 2px solid #e4e6eb;
    border-radius: 50px;
    padding: 10px 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    min-width: 80px;
  }
  .duration-pill:hover { border-color: #667eea; }
  .duration-pill.selected { border-color: #667eea; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
  .duration-pill input { display: none; }
  .duration-pill .time { font-weight: 700; font-size: 1.1rem; }
  .duration-pill .unit { font-size: 0.75rem; opacity: 0.8; }

  .btn-cancel {
    background: white; border: 2px solid #e4e6eb; color: #566a7f;
    padding: 12px 24px; border-radius: 10px; font-weight: 600; transition: all 0.3s ease;
  }
  .btn-cancel:hover { border-color: #ea5455; color: #ea5455; }
  .btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none; color: white; padding: 12px 28px; border-radius: 10px;
    font-weight: 600; transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4); color: white; }

  @media (max-width: 768px) { .option-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4><i class="ri-video-chat-line me-2"></i>Create New Session</h4>
      <p>Schedule a therapy session</p>
    </div>
    <a href="{{ route('admin.sessions.index') }}" class="btn btn-header">
      <i class="ri-arrow-left-line me-1"></i> Back to Sessions
    </a>
  </div>
</div>

@if($errors->any())
  <div class="alert alert-danger mb-4"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<form action="{{ route('admin.sessions.store') }}" method="POST">
  @csrf
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="card form-card mb-4">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-user-add-line"></i></div>
            <div><h5>Participants</h5><small>Select therapist and client</small></div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label-styled">Therapist <span class="text-danger">*</span></label>
              <select class="form-select" name="therapist_id" required>
                <option value="">Select Therapist</option>
                @foreach($therapists as $therapist)
                  <option value="{{ $therapist->id }}" {{ old('therapist_id') == $therapist->id ? 'selected' : '' }}>{{ $therapist->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label-styled">Client <span class="text-danger">*</span></label>
              <select class="form-select" name="client_id" required>
                <option value="">Select Client</option>
                @foreach($clients as $client)
                  <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="card form-card mb-4">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-settings-4-line"></i></div>
            <div><h5>Session Type</h5><small>Choose type and mode</small></div>
          </div>
        </div>
        <div class="card-body">
          <label class="form-label-styled mb-3">Appointment Type <span class="text-danger">*</span></label>
          <div class="option-grid mb-4">
            <label class="option-card {{ old('appointment_type') == 'individual' ? 'selected' : '' }}">
              <input type="radio" name="appointment_type" value="individual" {{ old('appointment_type') == 'individual' ? 'checked' : '' }} required>
              <div class="option-icon" style="background: rgba(102, 126, 234, 0.15); color: #667eea;"><i class="ri-user-line"></i></div>
              <h6>Individual</h6><small>One-on-one session</small>
            </label>
            <label class="option-card {{ old('appointment_type') == 'couple' ? 'selected' : '' }}">
              <input type="radio" name="appointment_type" value="couple" {{ old('appointment_type') == 'couple' ? 'checked' : '' }}>
              <div class="option-icon" style="background: rgba(236, 72, 153, 0.15); color: #ec4899;"><i class="ri-hearts-line"></i></div>
              <h6>Couple</h6><small>Couples therapy</small>
            </label>
            <label class="option-card {{ old('appointment_type') == 'family' ? 'selected' : '' }}">
              <input type="radio" name="appointment_type" value="family" {{ old('appointment_type') == 'family' ? 'checked' : '' }}>
              <div class="option-icon" style="background: rgba(255, 159, 67, 0.15); color: #ff9f43;"><i class="ri-parent-line"></i></div>
              <h6>Family</h6><small>Family therapy</small>
            </label>
          </div>

          <label class="form-label-styled mb-3">Session Mode <span class="text-danger">*</span></label>
          <div class="option-grid">
            <label class="option-card {{ old('session_mode') == 'video' ? 'selected' : '' }}">
              <input type="radio" name="session_mode" value="video" {{ old('session_mode') == 'video' ? 'checked' : '' }} required>
              <div class="option-icon" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;"><i class="ri-video-chat-line"></i></div>
              <h6>Video Call</h6><small>Face-to-face</small>
            </label>
            <label class="option-card {{ old('session_mode') == 'audio' ? 'selected' : '' }}">
              <input type="radio" name="session_mode" value="audio" {{ old('session_mode') == 'audio' ? 'checked' : '' }}>
              <div class="option-icon" style="background: rgba(40, 199, 111, 0.15); color: #28c76f;"><i class="ri-phone-line"></i></div>
              <h6>Voice Call</h6><small>Audio only</small>
            </label>
            <label class="option-card {{ old('session_mode') == 'chat' ? 'selected' : '' }}">
              <input type="radio" name="session_mode" value="chat" {{ old('session_mode') == 'chat' ? 'checked' : '' }}>
              <div class="option-icon" style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6;"><i class="ri-chat-3-line"></i></div>
              <h6>Text Chat</h6><small>Messaging</small>
            </label>
          </div>
        </div>
      </div>

      <div class="card form-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-calendar-schedule-line"></i></div>
            <div><h5>Schedule</h5><small>Date, time and duration</small></div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label-styled">Date <span class="text-danger">*</span></label>
              <input type="date" class="form-control" name="appointment_date" value="{{ old('appointment_date') }}" min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label-styled">Time <span class="text-danger">*</span></label>
              <input type="time" class="form-control" name="appointment_time" value="{{ old('appointment_time') }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label-styled">Status <span class="text-danger">*</span></label>
              <select class="form-select" name="status" required>
                <option value="scheduled" {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>📅 Scheduled</option>
                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label-styled mb-3">Duration <span class="text-danger">*</span></label>
              <div class="duration-pills">
                @foreach([30, 45, 60, 90, 120] as $d)
                  <label class="duration-pill {{ old('duration_minutes', 45) == $d ? 'selected' : '' }}">
                    <input type="radio" name="duration_minutes" value="{{ $d }}" {{ old('duration_minutes', 45) == $d ? 'checked' : '' }} required>
                    <div class="time">{{ $d }}</div><div class="unit">min</div>
                  </label>
                @endforeach
              </div>
            </div>
            <div class="col-12">
              <label class="form-label-styled">Session Notes</label>
              <textarea class="form-control" name="session_notes" rows="3" placeholder="Any additional notes...">{{ old('session_notes') }}</textarea>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top">
            <a href="{{ route('admin.sessions.index') }}" class="btn btn-cancel"><i class="ri-close-line me-1"></i> Cancel</a>
            <button type="submit" class="btn btn-submit"><i class="ri-save-line me-1"></i> Create Session</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.option-card, .duration-pill').forEach(el => {
    el.addEventListener('click', function() {
      const name = this.querySelector('input').name;
      document.querySelectorAll(`input[name="${name}"]`).forEach(i => i.closest('.option-card, .duration-pill')?.classList.remove('selected'));
      this.classList.add('selected');
    });
  });
});
</script>
@endsection
