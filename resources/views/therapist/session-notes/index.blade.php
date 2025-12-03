@extends('layouts/contentNavbarLayout')

@section('title', 'Session Notes')

@section('page-style')
<style>
  /* === Session Notes Page Custom Styles === */
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    color: white;
    position: relative;
    overflow: hidden;
  }

  .page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
  }

  .page-header h4 {
    font-weight: 700;
    margin-bottom: 0.25rem;
    position: relative;
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
    position: relative;
    z-index: 1;
  }

  /* Main Card */
  .sessions-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow: hidden;
  }

  .sessions-card .card-header {
    background: transparent;
    border-bottom: 1px solid #f3f4f6;
    padding: 1.25rem 1.5rem;
  }

  .sessions-card .card-body {
    padding: 1.5rem;
  }

  /* Search & Filters */
  .filters-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
  }

  .search-box {
    display: flex;
    gap: 0.5rem;
    flex: 1;
    max-width: 400px;
  }

  .search-input {
    flex: 1;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: all 0.2s ease;
    background: #f9fafb url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E") no-repeat 0.875rem center;
    background-size: 18px;
  }

  .search-input:focus {
    outline: none;
    border-color: #667eea;
    background-color: white;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  }

  .btn-search {
    padding: 0.75rem 1.25rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    color: white;
  }

  .btn-refresh {
    padding: 0.75rem 1.25rem;
    background: white;
    color: #667eea;
    border: 2px solid #667eea;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-refresh:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
  }

  /* Table Styles */
  .sessions-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  }

  .sessions-table thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 18px 20px;
    border: none;
    white-space: nowrap;
    position: relative;
  }

  .sessions-table thead th:first-child {
    border-radius: 12px 0 0 0;
  }

  .sessions-table thead th:last-child {
    border-radius: 0 12px 0 0;
  }

  .sessions-table tbody td {
    padding: 18px 20px;
    border-bottom: 1px solid #f0f2f5;
    vertical-align: middle;
    color: #2d3748;
    font-size: 0.9rem;
  }

  .sessions-table tbody tr {
    background: white;
  }

  .sessions-table tbody tr:last-child td {
    border-bottom: none;
  }

  /* Client Cell */
  .client-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .client-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e5e7eb;
  }

  .client-info {
    display: flex;
    flex-direction: column;
  }

  .client-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.9375rem;
    margin-bottom: 0.125rem;
  }

  /* Action Buttons */
  .btn-action-view {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-action-edit {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-action-delete {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  /* Pagination */
  .pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.5rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  }

  .pagination-info {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
  }

  /* Alert Styling */
  .alert-success {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 1px solid #86efac;
    color: #166534;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 3rem 2rem;
  }

  .empty-state i {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
  }

  .empty-state p {
    color: #6b7280;
    font-size: 0.9375rem;
  }

  @media (max-width: 768px) {
    .sessions-table {
      display: block;
      overflow-x: auto;
    }
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
    <div>
      <h4>
        <i class="ri-file-text-line"></i>
        Session Notes
      </h4>
      <p>Manage and track all your session notes</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('therapist.session-notes.index') }}" class="btn btn-refresh">
        <i class="ri-refresh-line"></i>Refresh
      </a>
      <a href="{{ route('therapist.session-notes.create') }}" class="btn btn-search">
        <i class="ri-add-line me-1"></i>Add Notes
      </a>
    </div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-center">
      <i class="ri-checkbox-circle-fill me-2 fs-5"></i>
      <div>{{ session('success') }}</div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Search Bar -->
<div class="card sessions-card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('therapist.session-notes.index') }}" class="filters-row">
      <div class="search-box">
        <input type="text" name="search" class="search-input" placeholder="Search by client name, session ID, complaints, observations..." value="{{ $search }}">
        <button type="submit" class="btn btn-search">
          <i class="ri-search-line me-1"></i>Search
        </button>
        @if($search)
          <a href="{{ route('therapist.session-notes.index') }}" class="btn btn-refresh">
            <i class="ri-close-line"></i>
          </a>
        @endif
      </div>
    </form>
  </div>
</div>

<!-- Session Notes Table -->
<div class="card sessions-card">
  <div class="card-header">
    <h5 class="mb-0 fw-bold">All Session Notes</h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="sessions-table">
        <thead>
          <tr>
            <th style="width: 60px;">Sr. No.</th>
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
              <td style="font-weight: 500; color: #6b7280;">{{ $sessionNotes->firstItem() + $index }}</td>
              <td>
                <div class="client-cell">
                  <div class="avatar avatar-sm">
                    @if($note->client)
                      @if($note->client->profile && $note->client->profile->profile_image)
                        <img src="{{ asset('storage/' . $note->client->profile->profile_image) }}" alt="{{ $note->client->name }}" class="client-avatar">
                      @elseif($note->client->getRawOriginal('avatar'))
                        <img src="{{ asset('storage/' . $note->client->getRawOriginal('avatar')) }}" alt="{{ $note->client->name }}" class="client-avatar">
                      @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($note->client->name ?? 'U') }}&background=667eea&color=fff&size=80&bold=true&format=svg" alt="{{ $note->client->name }}" class="client-avatar">
                      @endif
                    @else
                      <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center client-avatar" style="font-size: 0.75rem;">
                        U
                      </div>
                    @endif
                  </div>
                  <div class="client-info">
                    <span class="client-name">{{ $note->client->name ?? 'N/A' }}</span>
                  </div>
                </div>
              </td>
              <td>
                @if($note->appointment)
                  <span style="font-family: monospace; font-weight: 600; color: #667eea; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); padding: 0.25rem 0.75rem; border-radius: 6px;">S-{{ $note->appointment->id }}</span>
                @else
                  <span class="text-muted">N/A</span>
                @endif
              </td>
              <td>
                <div style="font-weight: 500; color: #374151;">
                  {{ $note->session_date ? $note->session_date->format('M d, Y') : 'N/A' }}
                </div>
              </td>
              <td>
                <div style="font-weight: 500; color: #374151;">
                  {{ $note->start_time ? \Carbon\Carbon::parse($note->start_time)->format('H:i') : 'N/A' }}
                </div>
              </td>
              <td>
                <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #4b5563;" title="{{ $note->chief_complaints }}">
                  {{ Str::limit($note->chief_complaints, 30) ?: '-' }}
                </div>
              </td>
              <td>
                <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #4b5563;" title="{{ $note->observations }}">
                  {{ Str::limit($note->observations, 30) ?: '-' }}
                </div>
              </td>
              <td>
                <span style="background: linear-gradient(135deg, rgba(5, 150, 105, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%); color: #059669; padding: 0.25rem 0.75rem; border-radius: 6px; font-weight: 600; font-size: 0.85rem;">
                  {{ Str::limit($note->recommendations, 20) ?: '-' }}
                </span>
              </td>
              <td>
                <span style="color: #6b7280;">{{ $note->reason ? Str::limit($note->reason, 20) : '-' }}</span>
              </td>
              <td>
                <div style="font-weight: 500; color: #374151;">
                  {{ $note->follow_up_date ? $note->follow_up_date->format('M d, Y') : '-' }}
                </div>
              </td>
              <td>
                <div class="d-flex gap-2">
                  <a href="{{ route('therapist.session-notes.show', $note->id) }}" class="btn btn-action-view" title="View">
                    <i class="ri-eye-line"></i>
                  </a>
                  <a href="{{ route('therapist.session-notes.edit', $note->id) }}" class="btn btn-action-edit" title="Edit">
                    <i class="ri-pencil-line"></i>
                  </a>
                  <form action="{{ route('therapist.session-notes.destroy', $note->id) }}" method="POST" class="d-inline delete-form" data-title="Delete Session Note" data-text="Are you sure you want to delete this session note? This action cannot be undone.">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-action-delete" title="Delete">
                      <i class="ri-delete-bin-line"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="11" class="text-center py-5">
                <div class="empty-state">
                  <i class="ri-file-text-line"></i>
                  <p class="mt-3">No session notes found. <a href="{{ route('therapist.session-notes.create') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">Create your first session note</a></p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Pagination -->
@if($sessionNotes->hasPages())
  <div class="pagination-wrapper">
    <div class="pagination-info">
      Showing {{ $sessionNotes->firstItem() }} to {{ $sessionNotes->lastItem() }} of {{ $sessionNotes->total() }} entries
    </div>
    <div>
      {{ $sessionNotes->links() }}
    </div>
  </div>
@endif
@endsection
