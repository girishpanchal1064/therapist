@extends('layouts/contentNavbarLayout')

@section('title', 'Session Notes')

@section('page-style')
<style>
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    color: white;
    position: relative;
    overflow: hidden;
  }
  .page-header h4 {
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: white;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  .page-header p {
    opacity: 0.9;
    margin: 0;
    font-size: 0.9375rem;
    z-index: 1;
  }
  .table-modern {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
  }
  .table-modern thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    padding: 1rem 1.25rem;
    border: none;
  }
  .table-modern tbody td {
    padding: 1rem 1.25rem;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
  }
  .table-modern tbody tr:hover {
    background: #f8f9fc;
    transform: scale(1.01);
    transition: all 0.2s ease;
  }
  .btn-action {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    border: none;
  }
  .btn-view {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
  }
  .btn-edit {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
  }
  .btn-delete {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
  }
  .btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h4>
        <i class="ri-file-text-line"></i>
        Session Notes
      </h4>
      <p>Manage and track all your session notes</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('therapist.session-notes.index') }}" class="btn btn-light">
        <i class="ri-refresh-line me-1"></i>Refresh
      </a>
      <a href="{{ route('therapist.session-notes.create') }}" class="btn btn-light" style="background: #ec4899; color: white; border: none;">
        <i class="ri-add-line me-1"></i>Add Notes
      </a>
    </div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #059669;">
    <i class="ri-checkbox-circle-line me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Search Bar -->
<div class="card mb-4" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
  <div class="card-body">
    <form method="GET" action="{{ route('therapist.session-notes.index') }}" class="d-flex gap-2">
      <input type="text" name="search" class="form-control" placeholder="Search by client name, session ID, complaints, observations..." value="{{ $search }}" style="border-radius: 10px;">
      <button type="submit" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px;">
        <i class="ri-search-line me-1"></i>Search
      </button>
      @if($search)
        <a href="{{ route('therapist.session-notes.index') }}" class="btn btn-outline-secondary" style="border-radius: 10px;">
          <i class="ri-close-line"></i>
        </a>
      @endif
    </form>
  </div>
</div>

<!-- Session Notes Table -->
<div class="table-modern">
  <table class="table table-hover mb-0">
    <thead>
      <tr>
        <th>Sr. No.</th>
        <th>User Name</th>
        <th>Session ID</th>
        <th>Session Date</th>
        <th>Start Time</th>
        <th>Chief Complaints</th>
        <th>Observations</th>
        <th>Recommendations</th>
        <th>Reason</th>
        <th>Follow Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse($sessionNotes as $index => $note)
        <tr>
          <td>{{ $sessionNotes->firstItem() + $index }}</td>
          <td>
            <div class="d-flex align-items-center">
              <div class="avatar avatar-sm me-2">
                @if($note->client)
                  @if($note->client->profile && $note->client->profile->profile_image)
                    <img src="{{ asset('storage/' . $note->client->profile->profile_image) }}" alt="{{ $note->client->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                  @elseif($note->client->getRawOriginal('avatar'))
                    <img src="{{ asset('storage/' . $note->client->getRawOriginal('avatar')) }}" alt="{{ $note->client->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                  @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($note->client->name ?? 'U') }}&background=3b82f6&color=fff&size=80&bold=true&format=svg" alt="{{ $note->client->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                  @endif
                @else
                  <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.75rem;">
                    U
                  </div>
                @endif
              </div>
              <span class="fw-semibold">{{ $note->client->name ?? 'N/A' }}</span>
            </div>
          </td>
          <td>
            @if($note->appointment)
              <span class="badge bg-info">S-{{ $note->appointment->id }}</span>
            @else
              <span class="text-muted">N/A</span>
            @endif
          </td>
          <td>{{ $note->session_date ? $note->session_date->format('Y-m-d') : 'N/A' }}</td>
          <td>{{ $note->start_time ? \Carbon\Carbon::parse($note->start_time)->format('H:i:s') : 'N/A' }}</td>
          <td>
            <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $note->chief_complaints }}">
              {{ Str::limit($note->chief_complaints, 30) }}
            </div>
          </td>
          <td>
            <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $note->observations }}">
              {{ Str::limit($note->observations, 30) }}
            </div>
          </td>
          <td>
            <span class="badge bg-success">{{ Str::limit($note->recommendations, 20) }}</span>
          </td>
          <td>
            <span class="text-muted">{{ $note->reason ? Str::limit($note->reason, 20) : '-' }}</span>
          </td>
          <td>{{ $note->follow_up_date ? $note->follow_up_date->format('Y-m-d') : '-' }}</td>
          <td>
            <div class="d-flex gap-1">
              <a href="{{ route('therapist.session-notes.show', $note->id) }}" class="btn btn-action btn-view btn-sm">
                <i class="ri-eye-line"></i>
              </a>
              <a href="{{ route('therapist.session-notes.edit', $note->id) }}" class="btn btn-action btn-edit btn-sm">
                <i class="ri-pencil-line"></i>
              </a>
              <form action="{{ route('therapist.session-notes.destroy', $note->id) }}" method="POST" class="d-inline delete-form" data-title="Delete Session Note" data-text="Are you sure you want to delete this session note? This action cannot be undone.">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-action btn-delete btn-sm">
                  <i class="ri-delete-bin-line"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="11" class="text-center py-5">
            <i class="ri-file-text-line" style="font-size: 3rem; color: #cbd5e0;"></i>
            <p class="mt-3 text-muted">No session notes found. <a href="{{ route('therapist.session-notes.create') }}">Create your first session note</a></p>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Pagination -->
@if($sessionNotes->hasPages())
  <div class="d-flex justify-content-between align-items-center mt-4">
    <div class="text-muted">
      Showing {{ $sessionNotes->firstItem() }} to {{ $sessionNotes->lastItem() }} of {{ $sessionNotes->total() }} entries
    </div>
    <div>
      {{ $sessionNotes->links() }}
    </div>
  </div>
@endif
@endsection
