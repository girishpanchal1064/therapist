@extends('layouts/contentNavbarLayout')

@section('title', 'Online Sessions')

@section('page-style')
<style>
    :root {
        --theme-primary: #696cff;
        --theme-primary-dark: #5f61e6;
        --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .page-header {
        background: var(--theme-gradient);
        border-radius: 12px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        color: white;
    }
    
    .page-header h4 {
        margin: 0;
        font-weight: 600;
    }
    
    .page-header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
    }
    
    .btn-theme {
        background: var(--theme-gradient);
        border: none;
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-theme:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .card-modern {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
    
    .status-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 1rem;
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }
    
    .status-tab {
        padding: 0.6rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: white;
        color: #6c757d;
        border: 1px solid #e0e0e0;
    }
    
    .status-tab:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        color: #667eea;
        border-color: #667eea;
    }
    
    .status-tab.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
    }
    
    .filter-card {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
        border: 1px solid rgba(102, 126, 234, 0.1);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    .filter-card .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }
    
    .table-modern {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table-modern thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        border: none;
        text-align: center;
    }
    
    .table-modern thead th:first-child {
        border-radius: 8px 0 0 0;
    }
    
    .table-modern thead th:last-child {
        border-radius: 0 8px 0 0;
    }
    
    .table-modern tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-modern tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
    }
    
    .table-modern tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        text-align: center;
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
        justify-content: center;
    }
    
    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #f0f0f0;
    }
    
    .user-avatar-initial {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.8rem;
        color: white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .session-id {
        font-family: monospace;
        font-size: 0.85rem;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8e9ff 100%);
        padding: 0.35rem 0.65rem;
        border-radius: 6px;
        color: #667eea;
        font-weight: 600;
    }
    
    .badge-video {
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
        color: white;
    }
    
    .badge-audio {
        background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        color: #212529;
    }
    
    .badge-chat {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
    }
    
    .badge-pending {
        background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        color: #212529;
    }
    
    .badge-upcoming {
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
        color: white;
    }
    
    .badge-completed {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    
    .badge-cancelled {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }
    
    .badge-expired {
        background: linear-gradient(135deg, #343a40 0%, #212529 100%);
        color: white;
    }
    
    .mode-badge, .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .action-dropdown .dropdown-toggle {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .action-dropdown .dropdown-toggle::after {
        display: none;
    }
    
    .action-dropdown .dropdown-menu {
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        border-radius: 8px;
        padding: 0.5rem;
    }
    
    .action-dropdown .dropdown-item {
        border-radius: 6px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    
    .action-dropdown .dropdown-item:hover {
        background-color: rgba(102, 126, 234, 0.1);
    }
    
    .pagination-modern .btn {
        border: none;
        background: #f8f9fa;
        color: #495057;
        margin: 0 2px;
        border-radius: 6px;
    }
    
    .pagination-modern .btn:hover:not(:disabled) {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .empty-state {
        padding: 3rem;
        text-align: center;
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }
    
    .empty-state-icon i {
        font-size: 2rem;
        color: white;
    }
    
    .alert-themed {
        border: none;
        border-radius: 10px;
        border-left: 4px solid;
    }
    
    .alert-themed.alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border-left-color: #28a745;
        color: #155724;
    }
    
    .btn-refresh {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
    }
    
    .btn-refresh:hover {
        background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
        color: white;
    }
    
    .btn-search {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
    }
    
    .btn-search:hover {
        background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
        color: white;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4><i class="ri-video-chat-line me-2"></i>Online Sessions</h4>
            <p>Manage all therapy sessions</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.sessions.create') }}" class="btn btn-theme">
                <i class="ri-add-line me-1"></i> Add New Session
            </a>
        </div>
    </div>
</div>

<div class="card card-modern">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-themed alert-success alert-dismissible" role="alert">
                <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Status Filter Tabs -->
        <div class="status-tabs">
            <a href="{{ route('admin.sessions.index', ['status' => 'pending']) }}"
               class="status-tab {{ $status === 'pending' ? 'active' : '' }}">
                <i class="ri-time-line"></i> Pending
            </a>
            <a href="{{ route('admin.sessions.index', ['status' => 'upcoming']) }}"
               class="status-tab {{ $status === 'upcoming' ? 'active' : '' }}">
                <i class="ri-calendar-schedule-line"></i> Upcoming
            </a>
            <a href="{{ route('admin.sessions.index', ['status' => 'completed']) }}"
               class="status-tab {{ $status === 'completed' ? 'active' : '' }}">
                <i class="ri-checkbox-circle-line"></i> Completed
            </a>
            <a href="{{ route('admin.sessions.index', ['status' => 'cancelled']) }}"
               class="status-tab {{ $status === 'cancelled' ? 'active' : '' }}">
                <i class="ri-close-circle-line"></i> Cancelled
            </a>
            <a href="{{ route('admin.sessions.index', ['status' => 'expired']) }}"
               class="status-tab {{ $status === 'expired' ? 'active' : '' }}">
                <i class="ri-history-line"></i> Expired
            </a>
        </div>

        <!-- Search and Actions -->
        <div class="filter-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="flex-grow-1" style="max-width: 400px;">
                    <form method="GET" action="{{ route('admin.sessions.index') }}" class="d-flex gap-2">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input type="text" name="search" class="form-control" placeholder="Search by Session ID, Client, or Therapist..." value="{{ $search }}">
                        <button type="submit" class="btn btn-search">
                            <i class="ri-search-line"></i>
                        </button>
                    </form>
                </div>
                <button type="button" class="btn btn-refresh" onclick="location.reload()">
                    <i class="ri-refresh-line me-1"></i> Refresh
                </button>
            </div>
        </div>

        <!-- Sessions Table -->
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Session ID</th>
                        <th>Therapist</th>
                        <th>Client</th>
                        <th>Mode</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessions as $index => $session)
                        <tr>
                            <td><span class="fw-bold text-muted">{{ $sessions->firstItem() + $index }}</span></td>
                            <td>
                                <span class="session-id">S-{{ $session->created_at ? $session->created_at->timestamp : $session->id }}</span>
                            </td>
                            <td>
                                @if($session->therapist)
                                    <div class="user-info">
                                        @if($session->therapist->avatar)
                                            <img src="{{ asset('storage/' . $session->therapist->avatar) }}" 
                                                 alt="{{ $session->therapist->name }}" 
                                                 class="user-avatar">
                                        @else
                                            <div class="user-avatar-initial">
                                                {{ strtoupper(substr($session->therapist->name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <span class="fw-bold">{{ $session->therapist->name }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold">{{ $session->client->name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                @if($session->session_mode === 'video')
                                    <span class="mode-badge badge-video">VIDEO</span>
                                @elseif($session->session_mode === 'audio')
                                    <span class="mode-badge badge-audio">AUDIO</span>
                                @elseif($session->session_mode === 'chat')
                                    <span class="mode-badge badge-chat">CHAT</span>
                                @else
                                    <span class="mode-badge" style="background: #f0f0f0; color: #6c757d;">{{ strtoupper($session->session_mode ?? 'N/A') }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted">
                                    <i class="ri-calendar-line me-1"></i>
                                    {{ $session->appointment_date->format('d-m-Y') }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted">
                                    <i class="ri-time-line me-1"></i>
                                    {{ \Carbon\Carbon::parse($session->appointment_time)->format('g:i A') }}
                                </span>
                            </td>
                            <td>
                                @if($session->status === 'scheduled')
                                    <span class="status-badge badge-pending">PENDING</span>
                                @elseif($session->status === 'confirmed')
                                    <span class="status-badge badge-upcoming">UPCOMING</span>
                                @elseif($session->status === 'completed')
                                    <span class="status-badge badge-completed">COMPLETED</span>
                                @elseif($session->status === 'cancelled')
                                    <span class="status-badge badge-cancelled">CANCELLED</span>
                                @elseif($session->appointment_date < now()->toDateString() && !in_array($session->status, ['completed', 'cancelled']))
                                    <span class="status-badge badge-expired">EXPIRED</span>
                                @else
                                    <span class="status-badge" style="background: #6c757d; color: white;">{{ strtoupper($session->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown action-dropdown">
                                    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="ri-more-2-line"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('admin.sessions.edit', $session->id) }}">
                                            <i class="ri-pencil-line me-2"></i> Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('admin.sessions.destroy', $session->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this session?')">
                                                <i class="ri-delete-bin-line me-2"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="ri-video-chat-line"></i>
                                    </div>
                                    <h5 class="text-muted">No Sessions Found</h5>
                                    <p class="text-muted">There are no sessions matching your criteria.</p>
                                </div>
                            </td>
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
                <div class="d-flex align-items-center gap-2 pagination-modern">
                    @if($sessions->hasPages())
                        <span class="text-muted me-2">Page {{ $sessions->currentPage() }} of {{ $sessions->lastPage() }}</span>
                        <div class="d-flex gap-1">
                            @if($sessions->onFirstPage())
                                <button class="btn btn-sm" disabled>
                                    <i class="ri-arrow-left-double-line"></i>
                                </button>
                                <button class="btn btn-sm" disabled>
                                    <i class="ri-arrow-left-line"></i>
                                </button>
                            @else
                                <a href="{{ $sessions->url(1) }}" class="btn btn-sm">
                                    <i class="ri-arrow-left-double-line"></i>
                                </a>
                                <a href="{{ $sessions->previousPageUrl() }}" class="btn btn-sm">
                                    <i class="ri-arrow-left-line"></i>
                                </a>
                            @endif
                            @if($sessions->hasMorePages())
                                <a href="{{ $sessions->nextPageUrl() }}" class="btn btn-sm">
                                    <i class="ri-arrow-right-line"></i>
                                </a>
                                <a href="{{ $sessions->url($sessions->lastPage()) }}" class="btn btn-sm">
                                    <i class="ri-arrow-right-double-line"></i>
                                </a>
                            @else
                                <button class="btn btn-sm" disabled>
                                    <i class="ri-arrow-right-line"></i>
                                </button>
                                <button class="btn btn-sm" disabled>
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
                </div>
            </div>
        @endif
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
