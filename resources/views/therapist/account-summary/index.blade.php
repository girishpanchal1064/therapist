@extends('layouts/contentNavbarLayout')

@section('title', 'Account Summary')

@section('page-style')
<style>
  /* === Account Summary Page Custom Styles === */
  .page-header {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
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

  /* Summary Card */
  .summary-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow: hidden;
  }

  .summary-card .card-body {
    padding: 1.5rem;
  }

  /* Filters */
  .filters-section {
    background: #f9fafb;
    border-radius: 12px;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e5e7eb;
  }

  .filters-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: flex-end;
  }

  .filter-group {
    flex: 1;
    min-width: 200px;
  }

  .filter-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
    display: block;
  }

  .filter-input {
    padding: 0.625rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: all 0.2s ease;
    background: white;
    width: 100%;
  }

  .filter-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
  }

  .btn-filter {
    padding: 0.625rem 1.25rem;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
  }

  .btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    color: white;
  }

  .btn-refresh {
    padding: 0.625rem 1.25rem;
    background: white;
    color: #3b82f6;
    border: 2px solid #3b82f6;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
  }

  .btn-refresh:hover {
    background: #3b82f6;
    color: white;
    transform: translateY(-2px);
  }

  /* Table Styles */
  .summary-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }

  .summary-table thead th {
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    color: #374151;
    font-weight: 600;
    font-size: 0.6875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1rem 0.75rem;
    border-bottom: 2px solid #e5e7eb;
    text-align: center;
    white-space: nowrap;
  }

  .summary-table tbody td {
    padding: 1rem 0.75rem;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
    font-size: 0.875rem;
    text-align: center;
  }

  .summary-table tbody tr {
    transition: all 0.2s ease;
  }

  .summary-table tbody tr:hover {
    background: #eff6ff;
  }

  .summary-table tbody tr:last-child td {
    border-bottom: none;
  }

  /* Client Cell */
  .client-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-align: left;
  }

  .client-avatar {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid #e5e7eb;
  }

  .client-avatar-placeholder {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.75rem;
  }

  .client-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.875rem;
  }

  .client-email {
    font-size: 0.75rem;
    color: #9ca3af;
  }

  /* Session ID */
  .session-id {
    font-family: monospace;
    font-weight: 600;
    color: #3b82f6;
    background: rgba(59, 130, 246, 0.1);
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.8125rem;
  }

  /* Mode Badge */
  .mode-badge {
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
    font-size: 0.6875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.02em;
  }

  .mode-badge.video { background: rgba(59, 130, 246, 0.1); color: #2563eb; }
  .mode-badge.audio { background: rgba(245, 158, 11, 0.1); color: #d97706; }
  .mode-badge.chat { background: rgba(107, 114, 128, 0.1); color: #4b5563; }

  /* Amount Styles */
  .amount-due {
    color: #ef4444;
    font-weight: 600;
  }

  .amount-available {
    color: #3b82f6;
    font-weight: 600;
  }

  .amount-disbursed {
    color: #10b981;
    font-weight: 600;
  }

  /* Description Cell */
  .description-cell {
    max-width: 180px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #6b7280;
    font-size: 0.8125rem;
  }

  /* Pagination */
  .pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 1px solid #f3f4f6;
    margin-top: 1rem;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .pagination-info {
    font-size: 0.875rem;
    color: #6b7280;
  }

  .pagination-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .page-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 2px solid #e5e7eb;
    background: white;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    text-decoration: none;
  }

  .page-btn:hover:not(.disabled) {
    border-color: #3b82f6;
    color: #3b82f6;
    background: #eff6ff;
  }

  .page-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
  }

  .per-page-select {
    padding: 0.5rem 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.875rem;
    color: #374151;
    background: white;
    cursor: pointer;
  }

  .per-page-select:focus {
    outline: none;
    border-color: #3b82f6;
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
  }

  .empty-state-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.5rem;
    color: #3b82f6;
  }

  .empty-state h5 {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
  }

  .empty-state p {
    color: #6b7280;
    font-size: 0.9375rem;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .filters-row {
      flex-direction: column;
    }

    .filter-group {
      width: 100%;
    }

    .summary-table {
      display: block;
      overflow-x: auto;
    }

    .summary-table thead th,
    .summary-table tbody td {
      padding: 0.75rem 0.5rem;
      font-size: 0.75rem;
    }
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <h4>
    <i class="ri-bar-chart-box-line"></i>
    Account Summary
  </h4>
  <p>Track your session earnings and payment details</p>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #10b981;">
    <i class="ri-checkbox-circle-line me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Summary Card -->
<div class="summary-card">
  <div class="card-body">
    <!-- Filters -->
    <div class="filters-section">
      <div class="filters-row">
        <form method="GET" action="{{ route('therapist.account-summary.index') }}" class="d-contents" style="display: contents;">
          <div class="filter-group">
            <label class="filter-label">Start Date</label>
            <input type="date" name="start_date" class="filter-input" value="{{ $startDate }}">
          </div>
          <div class="filter-group">
            <label class="filter-label">End Date</label>
            <input type="date" name="end_date" class="filter-input" value="{{ $endDate }}">
          </div>
          <div class="filter-group" style="flex: 2;">
            <label class="filter-label">Search</label>
            <input type="text" name="search" class="filter-input" placeholder="Search by client name..." value="{{ $search }}">
          </div>
          <input type="hidden" name="per_page" value="{{ $perPage }}">
          <div class="d-flex gap-2">
            <button type="submit" class="btn-filter">
              <i class="ri-calendar-line"></i>
              Apply Filters
            </button>
            <button type="button" class="btn-refresh" onclick="location.reload()">
              <i class="ri-refresh-line"></i>
              Refresh
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Summary Table -->
    <div class="table-responsive">
      <table class="summary-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Session ID</th>
            <th>Client</th>
            <th>Session Date</th>
            <th>Time</th>
            <th>Mode</th>
            <th>Description</th>
            <th>Transaction Date</th>
            <th>Due Amount</th>
            <th>Available</th>
            <th>Disbursed</th>
          </tr>
        </thead>
        <tbody>
          @forelse($summaries as $index => $summary)
            <tr>
              <td style="font-weight: 500; color: #6b7280;">{{ $summaries->firstItem() + $index }}</td>
              <td>
                <span class="session-id">#{{ str_pad($summary->id, 6, '0', STR_PAD_LEFT) }}</span>
              </td>
              <td>
                <div class="client-cell">
                  @if($summary->client->avatar)
                    <img src="{{ asset('storage/' . $summary->client->avatar) }}" alt="{{ $summary->client->name }}" class="client-avatar">
                  @else
                    <div class="client-avatar-placeholder">
                      {{ strtoupper(substr($summary->client->name, 0, 2)) }}
                    </div>
                  @endif
                  <div>
                    <div class="client-name">{{ $summary->client->name }}</div>
                    <div class="client-email">{{ $summary->client->email }}</div>
                  </div>
                </div>
              </td>
              <td style="font-weight: 500;">{{ $summary->appointment_date->format('d M, Y') }}</td>
              <td style="color: #6b7280;">{{ date('h:i A', strtotime($summary->appointment_time)) }}</td>
              <td>
                <span class="mode-badge {{ $summary->session_mode }}">{{ strtoupper($summary->session_mode) }}</span>
              </td>
              <td>
                @if($summary->session_notes)
                  <div class="description-cell" title="{{ $summary->session_notes }}">
                    {{ Str::limit($summary->session_notes, 40) }}
                  </div>
                @else
                  <span style="color: #d1d5db;">—</span>
                @endif
              </td>
              <td>
                @if($summary->payment && $summary->payment->paid_at)
                  {{ $summary->payment->paid_at->format('d M, Y') }}
                @else
                  <span style="color: #d1d5db;">—</span>
                @endif
              </td>
              <td class="amount-due">₹{{ number_format($summary->payment ? $summary->payment->amount : 0, 2) }}</td>
              <td class="amount-available">₹{{ number_format($summary->payment ? $summary->payment->amount : 0, 2) }}</td>
              <td class="amount-disbursed">₹0.00</td>
            </tr>
          @empty
            <tr>
              <td colspan="11">
                <div class="empty-state">
                  <div class="empty-state-icon">
                    <i class="ri-bar-chart-box-line"></i>
                  </div>
                  <h5>No records found</h5>
                  <p>There are no account summary records matching your filter criteria.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($summaries->hasPages())
      <div class="pagination-wrapper">
        <div class="pagination-info">
          Showing {{ $summaries->firstItem() }} to {{ $summaries->lastItem() }} of {{ $summaries->total() }} entries
        </div>
        <div class="pagination-controls">
          <span style="font-size: 0.875rem; color: #6b7280; margin-right: 0.5rem;">
            Page {{ $summaries->currentPage() }} of {{ $summaries->lastPage() }}
          </span>
          <a href="{{ $summaries->url(1) }}" class="page-btn {{ $summaries->onFirstPage() ? 'disabled' : '' }}">
            <i class="ri-arrow-left-double-line"></i>
          </a>
          <a href="{{ $summaries->previousPageUrl() }}" class="page-btn {{ $summaries->onFirstPage() ? 'disabled' : '' }}">
            <i class="ri-arrow-left-line"></i>
          </a>
          <a href="{{ $summaries->nextPageUrl() }}" class="page-btn {{ $summaries->hasMorePages() ? '' : 'disabled' }}">
            <i class="ri-arrow-right-line"></i>
          </a>
          <a href="{{ $summaries->url($summaries->lastPage()) }}" class="page-btn {{ $summaries->hasMorePages() ? '' : 'disabled' }}">
            <i class="ri-arrow-right-double-line"></i>
          </a>
          <select class="per-page-select" onchange="updatePerPage(this.value)">
            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 rows</option>
            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 rows</option>
            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 rows</option>
            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 rows</option>
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
