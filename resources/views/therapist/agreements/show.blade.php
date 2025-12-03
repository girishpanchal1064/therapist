@extends('layouts/contentNavbarLayout')

@section('title', 'View Agreement')

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
        <i class="ri-file-paper-2-line"></i>
        Agreement Details
      </h4>
      <p class="mb-0">View complete agreement information</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('therapist.agreements.index') }}" class="btn btn-light">
        <i class="ri-arrow-left-line me-1"></i>Back
      </a>
      <a href="{{ route('therapist.agreements.edit', $agreement->id) }}" class="btn btn-light" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none;">
        <i class="ri-pencil-line me-1"></i>Edit
      </a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="card info-card">
      <div class="card-body">
        <h3 class="mb-3">{{ $agreement->title }}</h3>
        <div class="content-section" style="line-height: 1.8; color: #374151;">
          {!! nl2br(e($agreement->content)) !!}
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card info-card">
      <div class="card-body">
        <h5 class="mb-4">Agreement Information</h5>
        <div class="mb-3">
          <div class="info-label">Type</div>
          <div class="info-value">
            <span class="badge {{ $agreement->type == 'general' ? 'bg-info' : 'bg-primary' }}">
              {{ ucfirst(str_replace('_', ' ', $agreement->type)) }}
            </span>
          </div>
        </div>
        @if($agreement->client)
        <div class="mb-3">
          <div class="info-label">Client</div>
          <div class="info-value">
            <div class="d-flex align-items-center">
              <div class="avatar avatar-sm me-2">
                @if($agreement->client->avatar)
                  <img src="{{ $agreement->client->avatar }}" alt="{{ $agreement->client->name }}" class="rounded-circle">
                @else
                  <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.75rem;">
                    {{ strtoupper(substr($agreement->client->name, 0, 2)) }}
                  </div>
                @endif
              </div>
              <span>{{ $agreement->client->name }}</span>
            </div>
          </div>
        </div>
        @endif
        <div class="mb-3">
          <div class="info-label">Status</div>
          <div class="info-value">
            @php
              $statusColors = [
                'draft' => 'bg-secondary',
                'active' => 'bg-success',
                'signed' => 'bg-primary',
                'expired' => 'bg-danger'
              ];
            @endphp
            <span class="badge {{ $statusColors[$agreement->status] ?? 'bg-secondary' }}">
              {{ ucfirst($agreement->status) }}
            </span>
          </div>
        </div>
        @if($agreement->effective_date)
        <div class="mb-3">
          <div class="info-label">Effective Date</div>
          <div class="info-value">{{ $agreement->effective_date->format('M d, Y') }}</div>
        </div>
        @endif
        @if($agreement->expiry_date)
        <div class="mb-3">
          <div class="info-label">Expiry Date</div>
          <div class="info-value">{{ $agreement->expiry_date->format('M d, Y') }}</div>
        </div>
        @endif
        @if($agreement->signed_date)
        <div class="mb-3">
          <div class="info-label">Signed Date</div>
          <div class="info-value">{{ $agreement->signed_date->format('M d, Y') }}</div>
        </div>
        @endif
        <div class="mb-3">
          <div class="info-label">Created At</div>
          <div class="info-value">{{ $agreement->created_at->format('M d, Y H:i') }}</div>
        </div>
        <div class="mb-3">
          <div class="info-label">Last Updated</div>
          <div class="info-value">{{ $agreement->updated_at->format('M d, Y H:i') }}</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
