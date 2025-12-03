@extends('layouts/contentNavbarLayout')

@section('title', 'View Session Note')

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
  }
  .info-card {
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    border: none;
    margin-bottom: 1.5rem;
  }
  .info-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #6b7280;
    font-weight: 600;
    margin-bottom: 0.25rem;
  }
  .info-value {
    font-size: 1rem;
    color: #1f2937;
    font-weight: 500;
  }
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h4>
        <i class="ri-file-text-line"></i>
        Session Note Details
      </h4>
      <p class="mb-0">View complete session note information</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('therapist.session-notes.index') }}" class="btn btn-light">
        <i class="ri-arrow-left-line me-1"></i>Back
      </a>
      <a href="{{ route('therapist.session-notes.edit', $sessionNote->id) }}" class="btn btn-light" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none;">
        <i class="ri-pencil-line me-1"></i>Edit
      </a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="card info-card">
      <div class="card-body">
        <h5 class="mb-4">Session Information</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <div class="info-label">Client Name</div>
            <div class="info-value">{{ $sessionNote->client->name ?? 'N/A' }}</div>
          </div>
          <div class="col-md-6">
            <div class="info-label">Session ID</div>
            <div class="info-value">
              @if($sessionNote->appointment)
                <span class="badge bg-info">S-{{ $sessionNote->appointment->id }}</span>
              @else
                N/A
              @endif
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <div class="info-label">Session Date</div>
            <div class="info-value">{{ $sessionNote->session_date ? $sessionNote->session_date->format('Y-m-d') : 'N/A' }}</div>
          </div>
          <div class="col-md-6">
            <div class="info-label">Start Time</div>
            <div class="info-value">{{ $sessionNote->start_time ? \Carbon\Carbon::parse($sessionNote->start_time)->format('H:i:s') : 'N/A' }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="card info-card">
      <div class="card-body">
        <h5 class="mb-4">Chief Complaints</h5>
        <p class="text-muted">{{ $sessionNote->chief_complaints }}</p>
      </div>
    </div>

    <div class="card info-card">
      <div class="card-body">
        <h5 class="mb-4">Observations</h5>
        <p class="text-muted">{{ $sessionNote->observations }}</p>
      </div>
    </div>

    <div class="card info-card">
      <div class="card-body">
        <h5 class="mb-4">Recommendations</h5>
        <p class="text-muted">{{ $sessionNote->recommendations }}</p>
      </div>
    </div>

    @if($sessionNote->reason)
    <div class="card info-card">
      <div class="card-body">
        <h5 class="mb-4">Reason</h5>
        <p class="text-muted">{{ $sessionNote->reason }}</p>
      </div>
    </div>
    @endif
  </div>

  <div class="col-md-4">
    <div class="card info-card">
      <div class="card-body">
        <h5 class="mb-4">Additional Information</h5>
        <div class="mb-3">
          <div class="info-label">User Didn't Turn Up</div>
          <div class="info-value">
            <span class="badge {{ $sessionNote->user_didnt_turn_up ? 'bg-danger' : 'bg-success' }}">
              {{ $sessionNote->user_didnt_turn_up ? 'Yes' : 'No' }}
            </span>
          </div>
        </div>
        <div class="mb-3">
          <div class="info-label">No Follow-up Required</div>
          <div class="info-value">
            <span class="badge {{ $sessionNote->no_follow_up_required ? 'bg-warning' : 'bg-info' }}">
              {{ $sessionNote->no_follow_up_required ? 'Yes' : 'No' }}
            </span>
          </div>
        </div>
        @if($sessionNote->follow_up_date)
        <div class="mb-3">
          <div class="info-label">Follow-up Date</div>
          <div class="info-value">{{ $sessionNote->follow_up_date->format('Y-m-d') }}</div>
        </div>
        @endif
        <div class="mb-3">
          <div class="info-label">Created At</div>
          <div class="info-value">{{ $sessionNote->created_at->format('M d, Y H:i') }}</div>
        </div>
        <div class="mb-3">
          <div class="info-label">Last Updated</div>
          <div class="info-value">{{ $sessionNote->updated_at->format('M d, Y H:i') }}</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
