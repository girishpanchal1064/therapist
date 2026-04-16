@extends('layouts/contentNavbarLayout')

@section('title', 'Session Notes')

@section('page-style')
<style>
  .layout-page .content-wrapper { background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important; }

  .therapist-session-notes-apni .filters-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 0;
  }
  .therapist-session-notes-apni .search-box {
    display: flex;
    gap: 0.5rem;
    flex: 1;
    flex-wrap: wrap;
    max-width: 720px;
    align-items: stretch;
  }
  .therapist-session-notes-apni .search-input {
    flex: 1;
    min-width: 200px;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid rgba(186, 194, 210, 0.85);
    border-radius: 10px;
    font-size: 0.9375rem;
    background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%237484a4'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E") no-repeat 0.875rem center;
    background-size: 18px;
  }
  .therapist-session-notes-apni .search-input:focus {
    outline: none;
    border-color: #041c54;
    background-color: #fff;
    box-shadow: 0 0 0 4px rgba(4, 28, 84, 0.12);
  }
  .therapist-session-notes-apni .btn-search-note {
    padding: 0.75rem 1.15rem;
    background: #041c54;
    color: #fff !important;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.2);
  }
  .therapist-session-notes-apni .btn-search-note:hover {
    background: #052a66;
    color: #fff !important;
  }
  .therapist-session-notes-apni .btn-refresh-note,
  .therapist-session-notes-apni .btn-clear-note {
    padding: 0.75rem 1.15rem;
    background: #fff;
    color: #041c54;
    border: 2px solid rgba(4, 28, 84, 0.35);
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
  }
  .therapist-session-notes-apni .btn-refresh-note:hover,
  .therapist-session-notes-apni .btn-clear-note:hover {
    background: rgba(4, 28, 84, 0.06);
    color: #041c54;
  }

  .therapist-session-notes-apni .sessions-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(186, 194, 210, 0.45);
  }
  .therapist-session-notes-apni .sessions-table thead th {
    background: rgba(186, 194, 210, 0.2);
    color: #4d5d78;
    font-weight: 700;
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 12px 10px;
    border: none;
    white-space: nowrap;
  }
  .therapist-session-notes-apni .sessions-table tbody td {
    padding: 12px 10px;
    border-bottom: 1px solid rgba(186, 194, 210, 0.35);
    vertical-align: middle;
    color: #334155;
    font-size: 0.85rem;
  }
  .therapist-session-notes-apni .sessions-table tbody tr:hover {
    background: rgba(4, 28, 84, 0.03);
  }
  .therapist-session-notes-apni .sessions-table tbody tr:last-child td {
    border-bottom: none;
  }

  .therapist-session-notes-apni .client-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }
  .therapist-session-notes-apni .client-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(186, 194, 210, 0.7);
  }
  .therapist-session-notes-apni .client-name {
    font-weight: 600;
    color: #041c54;
    font-size: 0.875rem;
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
  }

  .therapist-session-notes-apni .session-id-badge {
    font-family: ui-monospace, monospace;
    font-weight: 600;
    color: #041c54;
    background: rgba(4, 28, 84, 0.08);
    padding: 0.25rem 0.65rem;
    border-radius: 6px;
    font-size: 0.8125rem;
  }

  .therapist-session-notes-apni .sn-btn-view,
  .therapist-session-notes-apni .sn-btn-edit,
  .therapist-session-notes-apni .sn-btn-delete {
    border: none;
    padding: 0.45rem 0.65rem;
    border-radius: 8px;
    font-size: 0.85rem;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: opacity 0.2s ease, transform 0.2s ease;
  }
  .therapist-session-notes-apni .sn-btn-view {
    background: #041c54;
  }
  .therapist-session-notes-apni .sn-btn-view:hover {
    background: #052a66;
    color: #fff;
  }
  .therapist-session-notes-apni .sn-btn-edit {
    background: #d97706;
  }
  .therapist-session-notes-apni .sn-btn-edit:hover {
    background: #b45309;
    color: #fff;
  }
  .therapist-session-notes-apni .sn-btn-delete {
    background: #dc2626;
  }
  .therapist-session-notes-apni .sn-btn-delete:hover {
    background: #b91c1c;
    color: #fff;
  }

  .therapist-session-notes-apni .rec-badge {
    background: rgba(16, 185, 129, 0.12);
    color: #047857;
    padding: 0.25rem 0.65rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.8rem;
  }

  .therapist-session-notes-apni .pagination-wrap {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1.25rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(186, 194, 210, 0.45);
  }
  .therapist-session-notes-apni .pagination-wrap .pagination {
    margin-bottom: 0;
  }
  .therapist-session-notes-apni .page-link {
    color: #041c54;
    border-color: rgba(186, 194, 210, 0.85);
    border-radius: 8px !important;
    margin: 0 2px;
  }
  .therapist-session-notes-apni .page-item.active .page-link {
    background: #041c54;
    border-color: #041c54;
    color: #fff;
  }

  .therapist-session-notes-apni .empty-state {
    text-align: center;
    padding: 2.5rem 1rem;
  }
  .therapist-session-notes-apni .empty-state i {
    font-size: 3rem;
    color: #647494;
    margin-bottom: 0.75rem;
    display: block;
  }
  .therapist-session-notes-apni .empty-state p {
    color: #7484a4;
    font-size: 0.9375rem;
    margin: 0;
  }
  .therapist-session-notes-apni .empty-state a {
    color: #041c54;
    font-weight: 600;
    text-decoration: none;
  }
  .therapist-session-notes-apni .empty-state a:hover {
    text-decoration: underline;
  }

  @media (max-width: 768px) {
    .therapist-session-notes-apni .sessions-table {
      display: block;
      overflow-x: auto;
    }
  }
</style>
@endsection

@section('content')
<div class="therapist-session-notes-apni pb-2">
  <div class="relative mb-8 overflow-hidden rounded-3xl shadow-[0_20px_25px_-5px_rgba(100,116,148,0.2),0_8px_10px_-6px_rgba(100,116,148,0.2)]"
       style="background: #041c54;">
    <div class="pointer-events-none absolute -right-20 top-0 h-64 w-64 rounded-full bg-white/10 blur-[64px]" aria-hidden="true"></div>
    <div class="relative z-10 flex flex-col gap-6 p-6 lg:flex-row lg:items-center lg:justify-between lg:p-8">
      <div class="min-w-0">
        <h1 class="font-display flex items-center gap-3 text-2xl font-medium leading-snug text-white md:text-3xl">
          <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[14px] bg-white/15 text-[1.5rem] backdrop-blur-sm">
            <i class="ri-file-text-line"></i>
          </span>
          Session Notes
        </h1>
        <p class="mt-2 max-w-xl text-base text-white/90">
          Manage and track clinical notes for your sessions.
        </p>
      </div>
      <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
        <button type="button" class="btn-refresh-note order-2 sm:order-1" onclick="location.reload()">
          <i class="ri-refresh-line"></i> Refresh
        </button>
        <a href="{{ route('therapist.dashboard') }}"
           class="order-3 inline-flex items-center justify-center gap-2 rounded-[14px] bg-white px-5 py-2.5 text-sm font-medium text-[#041C54] shadow-md transition hover:bg-[#BAC2D2]/30 sm:order-2">
          <i class="ri-dashboard-line text-lg"></i>
          Dashboard
        </a>
        <a href="{{ route('therapist.session-notes.create') }}"
           class="order-1 inline-flex items-center justify-center gap-2 rounded-[14px] border-2 border-white px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/10 sm:order-3">
          <i class="ri-add-line text-lg"></i>
          Add notes
        </a>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-2xl border border-[#10B981]/30 bg-[#ecfdf5] px-4 py-3 text-sm text-[#065f46] md:px-5" role="status">
      <i class="ri-checkbox-circle-fill mt-0.5 text-lg text-[#059669]"></i>
      <div class="min-w-0 flex-1">{{ session('success') }}</div>
    </div>
  @endif

  <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-4 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
    <form method="GET" action="{{ route('therapist.session-notes.index') }}" class="filters-row">
      <div class="search-box">
        <input type="text" name="search" class="search-input" placeholder="Search by client, session ID, complaints, observations…" value="{{ $search }}">
        <button type="submit" class="btn-search-note">
          <i class="ri-search-line"></i>
        </button>
        @if($search)
          <a href="{{ route('therapist.session-notes.index') }}" class="btn-clear-note" aria-label="Clear search"><i class="ri-close-line"></i></a>
        @endif
      </div>
    </form>

    <div class="mt-6 border-t border-[#BAC2D2]/30 pt-6">
      <h2 class="font-display mb-4 text-lg font-medium text-[#041C54]">All session notes</h2>
      <div class="table-responsive">
        <table class="sessions-table">
          <thead>
            <tr>
              <th style="width: 56px;">#</th>
              <th>User</th>
              <th>Session ID</th>
              <th>Session date</th>
              <th>Start</th>
              <th>Complaints</th>
              <th>Observations</th>
              <th>Recommendations</th>
              <th>Reason</th>
              <th>Follow-up</th>
              <th style="width: 140px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($sessionNotes as $index => $note)
              <tr>
                <td class="text-[#7484A4]" style="font-weight: 500;">{{ $sessionNotes->firstItem() + $index }}</td>
                <td>
                  <div class="client-cell">
                    @if($note->client)
                      @if($note->client->profile && $note->client->profile->profile_image)
                        <img src="{{ asset('storage/' . $note->client->profile->profile_image) }}" alt="" class="client-avatar">
                      @elseif($note->client->getRawOriginal('avatar'))
                        <img src="{{ asset('storage/' . $note->client->getRawOriginal('avatar')) }}" alt="" class="client-avatar">
                      @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($note->client->name ?? 'U') }}&background=647494&color=fff&size=80&bold=true&format=svg" alt="" class="client-avatar">
                      @endif
                    @else
                      <div class="client-avatar d-flex align-items-center justify-content-center text-white" style="background: #647494; font-size: 0.75rem;">U</div>
                    @endif
                    <span class="client-name">{{ $note->client->name ?? 'N/A' }}</span>
                  </div>
                </td>
                <td>
                  @if($note->appointment)
                    <span class="session-id-badge">S-{{ $note->appointment->id }}</span>
                  @else
                    <span class="text-[#BAC2D2]">N/A</span>
                  @endif
                </td>
                <td class="font-medium text-[#041C54]">{{ $note->session_date ? $note->session_date->format('M d, Y') : 'N/A' }}</td>
                <td class="text-[#7484A4]">{{ $note->start_time ? \Carbon\Carbon::parse($note->start_time)->format('H:i') : 'N/A' }}</td>
                <td>
                  <div class="text-[#647494]" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $note->chief_complaints }}">{{ Str::limit($note->chief_complaints, 30) ?: '—' }}</div>
                </td>
                <td>
                  <div class="text-[#647494]" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $note->observations }}">{{ Str::limit($note->observations, 30) ?: '—' }}</div>
                </td>
                <td>
                  <span class="rec-badge">{{ Str::limit($note->recommendations, 20) ?: '—' }}</span>
                </td>
                <td class="text-[#7484A4]">{{ $note->reason ? Str::limit($note->reason, 20) : '—' }}</td>
                <td class="text-[#041C54]">{{ $note->follow_up_date ? $note->follow_up_date->format('M d, Y') : '—' }}</td>
                <td>
                  <div class="d-flex flex-wrap gap-1">
                    <a href="{{ route('therapist.session-notes.show', $note->id) }}" class="sn-btn-view" title="View"><i class="ri-eye-line"></i></a>
                    <a href="{{ route('therapist.session-notes.edit', $note->id) }}" class="sn-btn-edit" title="Edit"><i class="ri-pencil-line"></i></a>
                    <form action="{{ route('therapist.session-notes.destroy', $note->id) }}" method="POST" class="d-inline delete-form" data-title="Delete Session Note" data-text="Are you sure you want to delete this session note? This action cannot be undone.">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="sn-btn-delete" title="Delete"><i class="ri-delete-bin-line"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="11">
                  <div class="empty-state">
                    <i class="ri-file-text-line"></i>
                    <p>No session notes found. <a href="{{ route('therapist.session-notes.create') }}">Create your first note</a></p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    @if($sessionNotes->hasPages() || $sessionNotes->total() > 0)
      <div class="pagination-wrap">
        <div class="text-sm text-[#7484A4]">
          @if($sessionNotes->total() > 0)
            Showing {{ $sessionNotes->firstItem() }}–{{ $sessionNotes->lastItem() }} of {{ $sessionNotes->total() }}
          @endif
        </div>
        <div>{{ $sessionNotes->links() }}</div>
      </div>
    @endif
  </div>
</div>
@endsection
