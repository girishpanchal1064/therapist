@extends('layouts/contentNavbarLayout')

@section('title', 'Online Sessions')

@section('content')
<div class="row">
  <div class="col-12 mb-4">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
      <div class="card-body">
        <!-- Status Filter Tabs -->
        <div class="d-flex flex-wrap gap-2 mb-4 session-filter-tabs">
          <a href="{{ route('therapist.sessions.index', ['status' => 'pending']) }}"
             class="btn {{ $status === 'pending' ? 'btn-primary' : 'btn-outline-secondary' }} session-tab-btn">
            <i class="ri-file-text-line me-1"></i> PENDING
          </a>
          <a href="{{ route('therapist.sessions.index', ['status' => 'upcoming']) }}"
             class="btn {{ $status === 'upcoming' ? 'btn-primary' : 'btn-outline-secondary' }} session-tab-btn">
            <i class="ri-user-line me-1"></i> UPCOMING
          </a>
          <a href="{{ route('therapist.sessions.index', ['status' => 'completed']) }}"
             class="btn {{ $status === 'completed' ? 'btn-primary' : 'btn-outline-secondary' }} session-tab-btn">
            <i class="ri-calendar-check-line me-1"></i> COMPLETED
          </a>
          <a href="{{ route('therapist.sessions.index', ['status' => 'cancel_by_me']) }}"
             class="btn {{ $status === 'cancel_by_me' ? 'btn-primary' : 'btn-outline-secondary' }} session-tab-btn">
            <i class="ri-checkbox-circle-line me-1"></i> CANCEL BY ME
          </a>
          <a href="{{ route('therapist.sessions.index', ['status' => 'cancelled_by_user']) }}"
             class="btn {{ $status === 'cancelled_by_user' ? 'btn-primary' : 'btn-outline-secondary' }} session-tab-btn">
            <i class="ri-settings-3-line me-1"></i> CANCELLED BY USER
          </a>
          <a href="{{ route('therapist.sessions.index', ['status' => 'expired']) }}"
             class="btn {{ $status === 'expired' ? 'btn-primary' : 'btn-outline-secondary' }} session-tab-btn">
            <i class="ri-rocket-line me-1"></i> EXPIRED
          </a>
        </div>

        <!-- Page Title -->
        <h4 class="mb-4 fw-bold">
          @if($status === 'pending')
            Pending Sessions
          @elseif($status === 'upcoming')
            Upcoming Sessions
          @elseif($status === 'completed')
            Completed Sessions
          @elseif($status === 'cancel_by_me')
            Cancelled By Me Sessions
          @elseif($status === 'cancelled_by_user')
            Cancelled By User Sessions
          @elseif($status === 'expired')
            Expired Sessions
          @else
            Online Sessions
          @endif
        </h4>

        <!-- Search and Refresh -->
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div class="col-md-4">
            <form method="GET" action="{{ route('therapist.sessions.index') }}" class="d-flex gap-2">
              <input type="hidden" name="status" value="{{ $status }}">
              <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ $search }}">
              <button type="submit" class="btn btn-outline-primary">
                <i class="ri-search-line"></i>
              </button>
            </form>
          </div>
          <div>
            <button type="button" class="btn btn-success" onclick="location.reload()">
              <i class="ri-refresh-line me-1"></i> REFRESH
            </button>
          </div>
        </div>

        <!-- Sessions Table -->
        <div class="table-responsive">
          <table class="table table-bordered sessions-table">
            <thead class="table-primary">
              <tr>
                <th>Sr. No.</th>
                <th>Session ID</th>
                <th>User Name</th>
                <th>Mode</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($sessions as $index => $session)
                <tr>
                  <td>{{ $sessions->firstItem() + $index }}</td>
                  <td>S-{{ $session->created_at ? $session->created_at->timestamp : $session->id }}</td>
                  <td>{{ $session->client->name ?? 'N/A' }}</td>
                  <td>
                    @if($session->session_mode === 'video')
                      <span class="badge bg-info">VIDEO</span>
                    @elseif($session->session_mode === 'audio')
                      <span class="badge bg-warning">AUDIO</span>
                    @elseif($session->session_mode === 'chat')
                      <span class="badge bg-secondary">CHAT</span>
                    @else
                      <span class="badge bg-light text-dark">{{ strtoupper($session->session_mode) }}</span>
                    @endif
                  </td>
                  <td>{{ $session->appointment_date->format('d-m-Y') }}</td>
                  <td>{{ \Carbon\Carbon::parse($session->appointment_time)->format('g:i A') }}</td>
                  <td>
                    @if($session->status === 'scheduled')
                      <span class="badge bg-warning">PENDING</span>
                    @elseif($session->status === 'confirmed')
                      <span class="badge bg-info">UPCOMING</span>
                    @elseif($session->status === 'completed')
                      <span class="badge bg-success">COMPLETED</span>
                    @elseif($session->status === 'cancelled')
                      @if($session->cancelled_by == auth()->id())
                        <span class="badge bg-danger">CANCEL BY ME</span>
                      @else
                        <span class="badge bg-danger">CANCELLED BY USER</span>
                      @endif
                    @elseif($session->appointment_date < now()->toDateString() && !in_array($session->status, ['completed', 'cancelled']))
                      <span class="badge bg-dark">EXPIRED</span>
                    @else
                      <span class="badge bg-secondary">{{ strtoupper($session->status) }}</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">No sessions found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if($sessions->hasPages() || $sessions->total() > 0)
          <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
              @if($sessions->total() > 0)
                <span class="text-muted">
                  Showing {{ $sessions->firstItem() }} to {{ $sessions->lastItem() }} of {{ $sessions->total() }} entries
                </span>
              @endif
            </div>
            <div class="d-flex align-items-center gap-2">
              @if($sessions->hasPages())
                <span class="text-muted me-2">Page {{ $sessions->currentPage() }} of {{ $sessions->lastPage() }}</span>
                <div class="btn-group" role="group">
                  @if($sessions->onFirstPage())
                    <button class="btn btn-outline-primary btn-sm" disabled>
                      <i class="ri-arrow-left-double-line"></i>
                    </button>
                    <button class="btn btn-outline-primary btn-sm" disabled>
                      <i class="ri-arrow-left-line"></i>
                    </button>
                  @else
                    <a href="{{ $sessions->url(1) }}" class="btn btn-outline-primary btn-sm">
                      <i class="ri-arrow-left-double-line"></i>
                    </a>
                    <a href="{{ $sessions->previousPageUrl() }}" class="btn btn-outline-primary btn-sm">
                      <i class="ri-arrow-left-line"></i>
                    </a>
                  @endif
                  @if($sessions->hasMorePages())
                    <a href="{{ $sessions->nextPageUrl() }}" class="btn btn-outline-primary btn-sm">
                      <i class="ri-arrow-right-line"></i>
                    </a>
                    <a href="{{ $sessions->url($sessions->lastPage()) }}" class="btn btn-outline-primary btn-sm">
                      <i class="ri-arrow-right-double-line"></i>
                    </a>
                  @else
                    <button class="btn btn-outline-primary btn-sm" disabled>
                      <i class="ri-arrow-right-line"></i>
                    </button>
                    <button class="btn btn-outline-primary btn-sm" disabled>
                      <i class="ri-arrow-right-double-line"></i>
                    </button>
                  @endif
                </div>
              @endif
              <select class="form-select form-select-sm" style="width: auto;" onchange="updatePerPage(this.value)">
                <option value="10" {{ $sessions->perPage() == 10 ? 'selected' : '' }}>10 rows</option>
                <option value="25" {{ $sessions->perPage() == 25 ? 'selected' : '' }}>25 rows</option>
                <option value="50" {{ $sessions->perPage() == 50 ? 'selected' : '' }}>50 rows</option>
                <option value="100" {{ $sessions->perPage() == 100 ? 'selected' : '' }}>100 rows</option>
              </select>
              <span class="text-muted ms-2">per page</span>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
  function updatePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    window.location.href = url.toString();
  }
</script>
@endsection

@section('page-style')
<style>
  .session-filter-tabs {
    border-bottom: 2px solid #e0e6ed;
    padding-bottom: 1rem;
  }

  .session-tab-btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
    text-decoration: none;
  }

  .session-tab-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .sessions-table {
    margin-top: 1rem;
  }

  .sessions-table thead th {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
    font-weight: 600;
    padding: 1rem;
    border: none;
    text-align: center;
  }

  .sessions-table tbody td {
    padding: 1rem;
    text-align: center;
    vertical-align: middle;
  }

  .sessions-table tbody tr:hover {
    background-color: #f8f9fa;
  }
</style>
@endsection
