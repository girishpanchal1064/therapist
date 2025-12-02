@extends('layouts/contentNavbarLayout')

@section('title', 'Account Summary')

@section('page-style')
<style>
  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
  }
  .page-header h4 {
    margin: 0;
    font-weight: 700;
    color: white;
    font-size: 1.5rem;
  }
  .page-header p {
    color: rgba(255, 255, 255, 0.85);
    margin: 4px 0 0 0;
  }
  .page-header .btn-header {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .page-header .btn-header:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    color: white;
  }

  /* Stats Cards */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 24px;
  }
  @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 576px) { .stats-grid { grid-template-columns: 1fr; } }

  .stat-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
  }
  .stat-card.purple::before { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
  .stat-card.green::before { background: linear-gradient(135deg, #28c76f 0%, #1e9d58 100%); }
  .stat-card.blue::before { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
  .stat-card.orange::before { background: linear-gradient(135deg, #ff9f43 0%, #ff8510 100%); }

  .stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  }
  .stat-card .stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 16px;
  }
  .stat-card.purple .stat-icon { background: rgba(102, 126, 234, 0.12); color: #667eea; }
  .stat-card.green .stat-icon { background: rgba(40, 199, 111, 0.12); color: #28c76f; }
  .stat-card.blue .stat-icon { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
  .stat-card.orange .stat-icon { background: rgba(255, 159, 67, 0.12); color: #ff9f43; }

  .stat-card .stat-label { color: #718096; font-size: 0.85rem; margin-bottom: 4px; }
  .stat-card .stat-value { font-size: 1.75rem; font-weight: 700; color: #2d3748; }

  /* Filter Card */
  .filter-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    margin-bottom: 24px;
  }
  .filter-card .filter-title {
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .filter-card .filter-title i {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 1rem;
  }

  .filter-group { margin-bottom: 0; }
  .filter-group label {
    font-weight: 600;
    color: #4a5568;
    font-size: 0.85rem;
    margin-bottom: 8px;
    display: block;
  }
  .filter-group .form-control,
  .filter-group .form-select {
    border: 2px solid #e4e6eb;
    border-radius: 10px;
    padding: 10px 14px;
    transition: all 0.3s ease;
  }
  .filter-group .form-control:focus,
  .filter-group .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  }

  .btn-filter {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    color: white;
  }
  .btn-refresh {
    background: linear-gradient(135deg, #28c76f 0%, #1e9d58 100%);
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .btn-refresh:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(40, 199, 111, 0.3);
    color: white;
  }

  /* Table Card */
  .table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    overflow: hidden;
  }
  .table-card .card-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    padding: 20px 24px;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .table-card .card-header h5 {
    margin: 0;
    font-weight: 700;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .table-card .card-header h5 i {
    color: #667eea;
  }

  /* Table Styling */
  .table-modern {
    margin: 0;
  }
  .table-modern thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 600;
    padding: 16px;
    border: none;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
  }
  .table-modern tbody td {
    padding: 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f5;
    color: #4a5568;
  }
  .table-modern tbody tr:hover {
    background: rgba(102, 126, 234, 0.03);
  }
  .table-modern tbody tr:last-child td {
    border-bottom: none;
  }

  /* User Info */
  .user-info {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
  }
  .user-initials {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.85rem;
  }
  .user-initials.therapist {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    color: #667eea;
  }
  .user-initials.client {
    background: linear-gradient(135deg, rgba(40, 199, 111, 0.15) 0%, rgba(30, 157, 88, 0.15) 100%);
    color: #28c76f;
  }
  .user-details .name { font-weight: 600; color: #2d3748; font-size: 0.9rem; }
  .user-details .email { color: #8e9baa; font-size: 0.8rem; }

  /* Badges */
  .badge-mode {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
  }
  .badge-mode.video { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
  .badge-mode.audio { background: rgba(40, 199, 111, 0.12); color: #28c76f; }
  .badge-mode.chat { background: rgba(139, 92, 246, 0.12); color: #8b5cf6; }

  .session-id {
    font-family: 'Courier New', monospace;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    color: #667eea;
    font-size: 0.85rem;
  }

  .amount {
    font-weight: 700;
    font-size: 0.95rem;
  }
  .amount.due { color: #ff9f43; }
  .amount.available { color: #28c76f; }
  .amount.disbursed { color: #667eea; }

  .date-badge {
    background: #f8f9fc;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.85rem;
    color: #4a5568;
  }
  .time-badge {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.85rem;
    color: #667eea;
    font-weight: 600;
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 60px 20px;
  }
  .empty-state i {
    font-size: 4rem;
    color: #e4e6eb;
    margin-bottom: 16px;
  }
  .empty-state h5 { color: #4a5568; margin-bottom: 8px; }
  .empty-state p { color: #8e9baa; }

  /* Pagination */
  .pagination-wrapper {
    padding: 20px 24px;
    border-top: 1px solid #f0f0f5;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
  }
  .pagination-info { color: #718096; font-size: 0.9rem; }
  .pagination-controls {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .pagination-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 2px solid #e4e6eb;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4a5568;
    transition: all 0.3s ease;
    text-decoration: none;
  }
  .pagination-btn:hover:not(.disabled) {
    border-color: #667eea;
    color: #667eea;
    background: rgba(102, 126, 234, 0.05);
  }
  .pagination-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
  }
  .page-info {
    padding: 8px 16px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 8px;
    font-weight: 600;
    color: #667eea;
    font-size: 0.85rem;
  }

  /* Alert */
  .alert-modern {
    border-radius: 12px;
    border: none;
    padding: 16px 20px;
    margin-bottom: 24px;
  }
  .alert-modern.alert-success {
    background: linear-gradient(135deg, rgba(40, 199, 111, 0.1) 0%, rgba(40, 199, 111, 0.05) 100%);
    border-left: 4px solid #28c76f;
    color: #1e7e34;
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4><i class="ri-bar-chart-box-line me-2"></i>Account Summary</h4>
      <p>Track therapist earnings and payment disbursements</p>
    </div>
    <div class="d-flex gap-2">
      <button type="button" class="btn btn-header" onclick="window.print()">
        <i class="ri-printer-line me-1"></i> Print Report
      </button>
      <button type="button" class="btn btn-header" onclick="location.reload()">
        <i class="ri-refresh-line me-1"></i> Refresh
      </button>
    </div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-modern alert-success alert-dismissible">
    <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<!-- Stats Cards -->
<div class="stats-grid">
  <div class="stat-card purple">
    <div class="stat-icon"><i class="ri-calendar-check-line"></i></div>
    <div class="stat-label">Total Sessions</div>
    <div class="stat-value">{{ $summaries->total() }}</div>
  </div>
  <div class="stat-card green">
    <div class="stat-icon"><i class="ri-money-dollar-circle-line"></i></div>
    <div class="stat-label">Total Due Amount</div>
    <div class="stat-value">₹{{ number_format($summaries->sum(fn($s) => $s->payment ? $s->payment->amount : 0), 2) }}</div>
  </div>
  <div class="stat-card blue">
    <div class="stat-icon"><i class="ri-wallet-3-line"></i></div>
    <div class="stat-label">Available Amount</div>
    <div class="stat-value">₹{{ number_format($summaries->sum(fn($s) => $s->payment ? $s->payment->amount : 0), 2) }}</div>
  </div>
  <div class="stat-card orange">
    <div class="stat-icon"><i class="ri-hand-coin-line"></i></div>
    <div class="stat-label">Disbursed Amount</div>
    <div class="stat-value">₹0.00</div>
  </div>
</div>

<!-- Filters -->
<div class="filter-card">
  <div class="filter-title">
    <i class="ri-filter-3-line"></i>
    <span>Filter & Search</span>
  </div>
  <div class="row g-3 align-items-end">
    <div class="col-md-3">
      <div class="filter-group">
        <label>Therapist</label>
        <form method="GET" action="{{ route('admin.account-summary.index') }}" id="therapistForm">
          <select name="therapist_id" class="form-select" onchange="this.form.submit()">
            <option value="">All Therapists</option>
            @foreach($therapists as $therapist)
              <option value="{{ $therapist->id }}" {{ $therapistId == $therapist->id ? 'selected' : '' }}>
                {{ $therapist->name }}
              </option>
            @endforeach
          </select>
          <input type="hidden" name="start_date" value="{{ $startDate }}">
          <input type="hidden" name="end_date" value="{{ $endDate }}">
          <input type="hidden" name="search" value="{{ $search }}">
          <input type="hidden" name="per_page" value="{{ $perPage }}">
        </form>
      </div>
    </div>
    <div class="col-md-2">
      <div class="filter-group">
        <label>Start Date</label>
        <input type="date" class="form-control" id="start_date" value="{{ $startDate }}">
      </div>
    </div>
    <div class="col-md-2">
      <div class="filter-group">
        <label>End Date</label>
        <input type="date" class="form-control" id="end_date" value="{{ $endDate }}">
      </div>
    </div>
    <div class="col-md-3">
      <div class="filter-group">
        <label>Search</label>
        <input type="text" class="form-control" id="search_input" value="{{ $search }}" placeholder="Search sessions...">
      </div>
    </div>
    <div class="col-md-2">
      <div class="d-flex gap-2">
        <button type="button" class="btn btn-filter flex-grow-1" onclick="applyFilters()">
          <i class="ri-search-line me-1"></i> Apply
        </button>
        <a href="{{ route('admin.account-summary.index') }}" class="btn btn-outline-secondary">
          <i class="ri-refresh-line"></i>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Table -->
<div class="table-card">
  <div class="card-header">
    <h5><i class="ri-table-line"></i> Session Transactions</h5>
    <div class="d-flex align-items-center gap-2">
      <span class="text-muted">Per page:</span>
      <select class="form-select form-select-sm" style="width: auto;" onchange="updatePerPage(this.value)">
        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
      </select>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-modern">
      <thead>
        <tr>
          <th>#</th>
          <th>Session ID</th>
          <th>Therapist</th>
          <th>Client</th>
          <th>Date & Time</th>
          <th>Mode</th>
          <th>Transaction Date</th>
          <th>Due Amount</th>
          <th>Available</th>
          <th>Disbursed</th>
        </tr>
      </thead>
      <tbody>
        @forelse($summaries as $index => $summary)
          <tr>
            <td><span class="fw-semibold text-muted">{{ $summaries->firstItem() + $index }}</span></td>
            <td><span class="session-id">#{{ str_pad($summary->id, 6, '0', STR_PAD_LEFT) }}</span></td>
            <td>
              <div class="user-info">
                @if($summary->therapist->avatar)
                  <img src="{{ asset('storage/' . $summary->therapist->avatar) }}" alt="{{ $summary->therapist->name }}" class="user-avatar">
                @else
                  <div class="user-initials therapist">{{ strtoupper(substr($summary->therapist->name, 0, 2)) }}</div>
                @endif
                <div class="user-details">
                  <div class="name">{{ $summary->therapist->name }}</div>
                  <div class="email">{{ Str::limit($summary->therapist->email, 20) }}</div>
                </div>
              </div>
            </td>
            <td>
              <div class="user-info">
                @if($summary->client->avatar)
                  <img src="{{ asset('storage/' . $summary->client->avatar) }}" alt="{{ $summary->client->name }}" class="user-avatar">
                @else
                  <div class="user-initials client">{{ strtoupper(substr($summary->client->name, 0, 2)) }}</div>
                @endif
                <div class="user-details">
                  <div class="name">{{ $summary->client->name }}</div>
                  <div class="email">{{ Str::limit($summary->client->email, 20) }}</div>
                </div>
              </div>
            </td>
            <td>
              <div class="d-flex flex-column gap-1">
                <span class="date-badge"><i class="ri-calendar-line me-1"></i>{{ $summary->appointment_date->format('d M, Y') }}</span>
                <span class="time-badge"><i class="ri-time-line me-1"></i>{{ date('h:i A', strtotime($summary->appointment_time)) }}</span>
              </div>
            </td>
            <td>
              <span class="badge-mode {{ $summary->session_mode }}">
                @if($summary->session_mode === 'video')
                  <i class="ri-video-chat-line me-1"></i>
                @elseif($summary->session_mode === 'audio')
                  <i class="ri-phone-line me-1"></i>
                @else
                  <i class="ri-chat-3-line me-1"></i>
                @endif
                {{ ucfirst($summary->session_mode) }}
              </span>
            </td>
            <td>
              @if($summary->payment && $summary->payment->paid_at)
                <span class="date-badge">{{ $summary->payment->paid_at->format('d M, Y') }}</span>
              @else
                <span class="text-muted">—</span>
              @endif
            </td>
            <td><span class="amount due">₹{{ number_format($summary->payment ? $summary->payment->amount : 0, 2) }}</span></td>
            <td><span class="amount available">₹{{ number_format($summary->payment ? $summary->payment->amount : 0, 2) }}</span></td>
            <td><span class="amount disbursed">₹0.00</span></td>
          </tr>
        @empty
          <tr>
            <td colspan="10">
              <div class="empty-state">
                <i class="ri-file-search-line"></i>
                <h5>No Records Found</h5>
                <p>No matching session transactions found. Try adjusting your filters.</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($summaries->hasPages())
    <div class="pagination-wrapper">
      <div class="pagination-info">
        Showing <strong>{{ $summaries->firstItem() }}</strong> to <strong>{{ $summaries->lastItem() }}</strong> of <strong>{{ $summaries->total() }}</strong> entries
      </div>
      <div class="pagination-controls">
        <a href="{{ $summaries->url(1) }}" class="pagination-btn {{ $summaries->onFirstPage() ? 'disabled' : '' }}">
          <i class="ri-arrow-left-double-line"></i>
        </a>
        <a href="{{ $summaries->previousPageUrl() }}" class="pagination-btn {{ $summaries->onFirstPage() ? 'disabled' : '' }}">
          <i class="ri-arrow-left-s-line"></i>
        </a>
        <span class="page-info">Page {{ $summaries->currentPage() }} of {{ $summaries->lastPage() }}</span>
        <a href="{{ $summaries->nextPageUrl() }}" class="pagination-btn {{ $summaries->hasMorePages() ? '' : 'disabled' }}">
          <i class="ri-arrow-right-s-line"></i>
        </a>
        <a href="{{ $summaries->url($summaries->lastPage()) }}" class="pagination-btn {{ $summaries->hasMorePages() ? '' : 'disabled' }}">
          <i class="ri-arrow-right-double-line"></i>
        </a>
      </div>
    </div>
  @endif
</div>
@endsection

@section('page-script')
<script>
  function applyFilters() {
    const url = new URL(window.location.href);
    url.searchParams.set('start_date', document.getElementById('start_date').value);
    url.searchParams.set('end_date', document.getElementById('end_date').value);
    url.searchParams.set('search', document.getElementById('search_input').value);
    window.location.href = url.toString();
  }

  function updatePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    window.location.href = url.toString();
  }

  // Enter key to search
  document.getElementById('search_input')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') applyFilters();
  });
</script>
@endsection
