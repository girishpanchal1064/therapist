@extends('layouts/contentNavbarLayout')

@section('title', 'Account Summary')

@section('page-style')
<style>
  .layout-page .content-wrapper { background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important; }

  .therapist-account-summary-apni .filter-card {
    background: #fff;
    border-radius: 16px;
    padding: 1rem 1.25rem;
    border: 1px solid rgba(186, 194, 210, 0.55);
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 14px rgba(4, 28, 84, 0.04);
  }
  .therapist-account-summary-apni .filter-title {
    font-weight: 600;
    color: #041c54;
    margin-bottom: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    cursor: pointer;
    padding-bottom: 12px;
    border-bottom: 1px solid rgba(186, 194, 210, 0.5);
    margin-bottom: 16px;
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
  }
  .therapist-account-summary-apni .filter-icon-wrapper {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(100, 116, 148, 0.12);
    color: #647494;
    font-size: 1.125rem;
  }
  .therapist-account-summary-apni .btn-filter-toggle {
    background: #fff;
    border: 2px solid rgba(186, 194, 210, 0.85);
    border-radius: 10px;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #041c54;
    transition: border-color 0.2s ease, background 0.2s ease;
    cursor: pointer;
  }
  .therapist-account-summary-apni .btn-filter-toggle:hover {
    background: rgba(4, 28, 84, 0.04);
    border-color: #647494;
  }
  .therapist-account-summary-apni .btn-filter-toggle i {
    font-size: 1.2rem;
    transition: transform 0.3s ease;
  }
  .therapist-account-summary-apni .btn-filter-toggle.active i {
    transform: rotate(180deg);
  }
  .therapist-account-summary-apni .filter-content {
    overflow: hidden;
    transition: max-height 0.35s ease, opacity 0.25s ease;
  }
  .therapist-account-summary-apni .filter-content.collapsed {
    max-height: 0;
    margin-top: 0;
    opacity: 0;
    pointer-events: none;
  }
  .therapist-account-summary-apni .filter-content:not(.collapsed) {
    max-height: 1200px;
    opacity: 1;
  }

  .therapist-account-summary-apni .filters-section {
    background: rgba(186, 194, 210, 0.12);
    border-radius: 12px;
    padding: 1.25rem;
    border: 1px solid rgba(186, 194, 210, 0.45);
  }
  .therapist-account-summary-apni .filters-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: flex-end;
  }
  .therapist-account-summary-apni .filter-group {
    flex: 1;
    min-width: 180px;
  }
  .therapist-account-summary-apni .filter-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #647494;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 0.5rem;
    display: block;
  }
  .therapist-account-summary-apni .filter-input {
    padding: 0.625rem 1rem;
    border: 2px solid rgba(186, 194, 210, 0.85);
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    background: #fff;
    width: 100%;
    color: #041c54;
  }
  .therapist-account-summary-apni .filter-input:focus {
    outline: none;
    border-color: #041c54;
    box-shadow: 0 0 0 4px rgba(4, 28, 84, 0.1);
  }
  .therapist-account-summary-apni .btn-filter {
    padding: 0.625rem 1.25rem;
    background: #041c54;
    color: #fff !important;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.2);
  }
  .therapist-account-summary-apni .btn-filter:hover {
    background: #052a66;
    color: #fff !important;
  }
  .therapist-account-summary-apni .btn-refresh {
    padding: 0.625rem 1.25rem;
    background: #fff;
    color: #041c54;
    border: 2px solid rgba(4, 28, 84, 0.35);
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
  }
  .therapist-account-summary-apni .btn-refresh:hover {
    background: rgba(4, 28, 84, 0.06);
    border-color: #041c54;
    color: #041c54;
  }

  .therapist-account-summary-apni .summary-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(186, 194, 210, 0.45);
  }
  .therapist-account-summary-apni .summary-table thead th {
    background: rgba(186, 194, 210, 0.2);
    color: #4d5d78;
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 14px 12px;
    border: none;
    text-align: center;
    white-space: nowrap;
  }
  .therapist-account-summary-apni .summary-table tbody td {
    padding: 14px 12px;
    border-bottom: 1px solid rgba(186, 194, 210, 0.35);
    vertical-align: middle;
    color: #334155;
    font-size: 0.875rem;
    text-align: center;
  }
  .therapist-account-summary-apni .summary-table tbody tr {
    background: #fff;
    transition: background 0.2s ease;
  }
  .therapist-account-summary-apni .summary-table tbody tr:hover {
    background: rgba(4, 28, 84, 0.03);
  }
  .therapist-account-summary-apni .summary-table tbody tr:last-child td {
    border-bottom: none;
  }

  .therapist-account-summary-apni .client-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-align: left;
  }
  .therapist-account-summary-apni .client-avatar {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid rgba(186, 194, 210, 0.7);
  }
  .therapist-account-summary-apni .client-name {
    font-weight: 600;
    color: #041c54;
    font-size: 0.875rem;
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
  }
  .therapist-account-summary-apni .client-email {
    font-size: 0.75rem;
    color: #7484a4;
  }

  .therapist-account-summary-apni .session-id {
    font-family: ui-monospace, monospace;
    font-weight: 600;
    color: #041c54;
    background: rgba(4, 28, 84, 0.08);
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.8125rem;
  }

  .therapist-account-summary-apni .mode-badge {
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.02em;
  }
  .therapist-account-summary-apni .mode-badge.video { background: rgba(59, 130, 246, 0.12); color: #2563eb; }
  .therapist-account-summary-apni .mode-badge.audio { background: rgba(245, 158, 11, 0.12); color: #b45309; }
  .therapist-account-summary-apni .mode-badge.chat { background: rgba(100, 116, 148, 0.15); color: #4d5d78; }

  .therapist-account-summary-apni .amount-due { color: #dc2626; font-weight: 600; }
  .therapist-account-summary-apni .amount-available { color: #2563eb; font-weight: 600; }
  .therapist-account-summary-apni .amount-disbursed { color: #059669; font-weight: 600; }

  .therapist-account-summary-apni .description-cell {
    max-width: 180px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #647494;
    font-size: 0.8125rem;
  }

  .therapist-account-summary-apni .pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.25rem;
    margin-top: 1rem;
    border-top: 1px solid rgba(186, 194, 210, 0.45);
    flex-wrap: wrap;
    gap: 1rem;
  }
  .therapist-account-summary-apni .pagination-info,
  .therapist-account-summary-apni .pagination-controls span {
    font-size: 0.875rem;
    color: #7484a4;
  }
  .therapist-account-summary-apni .pagination-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
  }
  .therapist-account-summary-apni .page-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 2px solid rgba(186, 194, 210, 0.85);
    background: #fff;
    color: #647494;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .therapist-account-summary-apni a.page-btn:hover {
    border-color: #041c54;
    color: #041c54;
    background: rgba(4, 28, 84, 0.04);
  }
  .therapist-account-summary-apni .page-btn:disabled {
    opacity: 0.45;
    cursor: not-allowed;
  }
  .therapist-account-summary-apni .per-page-select {
    padding: 0.5rem 0.75rem;
    border: 2px solid rgba(186, 194, 210, 0.85);
    border-radius: 8px;
    font-size: 0.875rem;
    color: #041c54;
    background: #fff;
    cursor: pointer;
  }
  .therapist-account-summary-apni .per-page-select:focus {
    outline: none;
    border-color: #041c54;
  }

  .therapist-account-summary-apni .empty-state {
    text-align: center;
    padding: 2.5rem 1rem;
  }
  .therapist-account-summary-apni .empty-state-icon {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    background: rgba(100, 116, 148, 0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2.25rem;
    color: #647494;
  }
  .therapist-account-summary-apni .empty-state h5 {
    font-weight: 600;
    color: #041c54;
    margin-bottom: 0.5rem;
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
  }
  .therapist-account-summary-apni .empty-state p {
    color: #7484a4;
    font-size: 0.9375rem;
    margin: 0;
  }

  @media (max-width: 768px) {
    .therapist-account-summary-apni .filters-row { flex-direction: column; }
    .therapist-account-summary-apni .filter-group { width: 100%; min-width: 100%; }
    .therapist-account-summary-apni .summary-table thead th,
    .therapist-account-summary-apni .summary-table tbody td {
      padding: 0.65rem 0.45rem;
      font-size: 0.75rem;
    }
  }
</style>
@endsection

@section('content')
<div class="therapist-account-summary-apni pb-2">
  <div class="relative mb-8 overflow-hidden rounded-3xl shadow-[0_20px_25px_-5px_rgba(100,116,148,0.2),0_8px_10px_-6px_rgba(100,116,148,0.2)]"
       style="background: linear-gradient(171deg, #647494 0%, #6d7f9d 25%, #7484A4 50%, #6d7f9d 75%, #647494 100%);">
    <div class="pointer-events-none absolute -right-20 top-0 h-64 w-64 rounded-full bg-white/10 blur-[64px]" aria-hidden="true"></div>
    <div class="relative z-10 flex flex-col gap-6 p-6 md:flex-row md:items-center md:justify-between md:p-8">
      <div class="min-w-0">
        <h1 class="font-display flex items-center gap-3 text-2xl font-medium leading-snug text-white md:text-3xl">
          <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[14px] bg-white/15 text-[1.5rem] backdrop-blur-sm">
            <i class="ri-bar-chart-box-line"></i>
          </span>
          Account Summary
        </h1>
        <p class="mt-2 max-w-xl text-base text-white/90">
          Track session earnings and payment details for your practice.
        </p>
      </div>
      <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:items-center">
        <a href="{{ route('therapist.dashboard') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] bg-white px-5 py-2.5 text-sm font-medium text-[#041C54] shadow-md transition hover:bg-[#BAC2D2]/30">
          <i class="ri-dashboard-line text-lg"></i>
          Dashboard
        </a>
        <a href="{{ route('therapist.reviews.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] border-2 border-white px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/10">
          <i class="ri-star-smile-line text-lg"></i>
          Reviews
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

  {{-- Summary stats — same card language as reviews / dashboard --}}
  <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
      <div class="flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#647494]/10">
        <i class="ri-file-list-3-line text-2xl text-[#647494]"></i>
      </div>
      <p class="mt-4 text-sm text-[#7484A4]">Sessions matching filters</p>
      <p class="font-display mt-1 text-3xl font-medium text-[#041C54]">{{ $summaries->total() }}</p>
    </div>
    <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
      <div class="flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#EF4444]/10">
        <i class="ri-wallet-3-line text-2xl text-[#dc2626]"></i>
      </div>
      <p class="mt-4 text-sm text-[#7484A4]">Total due</p>
      <p class="font-display mt-1 text-2xl font-medium text-[#041C54] sm:text-3xl">₹{{ number_format($totalDue, 2) }}</p>
      <p class="mt-1 text-xs text-[#7484A4]">This page only</p>
    </div>
    <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
      <div class="flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#3B82F6]/10">
        <i class="ri-bank-card-line text-2xl text-[#2563eb]"></i>
      </div>
      <p class="mt-4 text-sm text-[#7484A4]">Available</p>
      <p class="font-display mt-1 text-2xl font-medium text-[#041C54] sm:text-3xl">₹{{ number_format($totalAvailable, 2) }}</p>
      <p class="mt-1 text-xs text-[#7484A4]">This page only</p>
    </div>
    <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
      <div class="flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#10B981]/10">
        <i class="ri-funds-line text-2xl text-[#059669]"></i>
      </div>
      <p class="mt-4 text-sm text-[#7484A4]">Disbursed</p>
      <p class="font-display mt-1 text-2xl font-medium text-[#041C54] sm:text-3xl">₹{{ number_format($totalDisbursed, 2) }}</p>
      <p class="mt-1 text-xs text-[#7484A4]">This page only</p>
    </div>
  </div>

  <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-4 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
    <div class="filter-card mb-0">
      <div class="filter-title" role="button" tabindex="0" onclick="toggleFilterSection()" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();toggleFilterSection();}">
        <div class="d-flex align-items-center gap-2">
          <div class="filter-icon-wrapper">
            <i class="ri-filter-3-line"></i>
          </div>
          <span>Filter &amp; search</span>
        </div>
        <button type="button" class="btn-filter-toggle" onclick="event.stopPropagation(); toggleFilterSection();" aria-expanded="true" aria-controls="filterContent" id="filterToggleBtn">
          <i class="ri-arrow-down-s-line" id="filterToggleIcon"></i>
        </button>
      </div>
      <div class="filter-content" id="filterContent">
        <div class="filters-section">
          <div class="filters-row">
            <form method="GET" action="{{ route('therapist.account-summary.index') }}" class="d-flex w-100 flex-wrap align-items-end gap-3" style="flex: 1;">
              <div class="filter-group">
                <label class="filter-label" for="start_date">Start date</label>
                <input type="date" id="start_date" name="start_date" class="filter-input" value="{{ $startDate }}">
              </div>
              <div class="filter-group">
                <label class="filter-label" for="end_date">End date</label>
                <input type="date" id="end_date" name="end_date" class="filter-input" value="{{ $endDate }}">
              </div>
              <div class="filter-group" style="flex: 2; min-width: 220px;">
                <label class="filter-label" for="search_q">Search</label>
                <input type="text" id="search_q" name="search" class="filter-input" placeholder="Client name, email, or session ID…" value="{{ $search }}">
              </div>
              <input type="hidden" name="per_page" value="{{ $perPage }}">
              <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn-filter">
                  <i class="ri-calendar-check-line"></i>
                  Apply filters
                </button>
                <button type="button" class="btn-refresh" onclick="location.reload()">
                  <i class="ri-refresh-line"></i>
                  Refresh
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="table-responsive mt-4">
      <table class="summary-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Session ID</th>
            <th>Client</th>
            <th>Session date</th>
            <th>Time</th>
            <th>Mode</th>
            <th>Description</th>
            <th>Transaction date</th>
            <th>Due</th>
            <th>Available</th>
            <th>Disbursed</th>
          </tr>
        </thead>
        <tbody>
          @forelse($summaries as $index => $summary)
            <tr>
              <td class="text-[#7484A4]" style="font-weight: 500;">{{ $summaries->firstItem() + $index }}</td>
              <td>
                <span class="session-id">#{{ str_pad($summary->id, 6, '0', STR_PAD_LEFT) }}</span>
              </td>
              <td>
                <div class="client-cell">
                  @if($summary->client->profile && $summary->client->profile->profile_image)
                    <img src="{{ asset('storage/' . $summary->client->profile->profile_image) }}" alt="{{ $summary->client->name }}" class="client-avatar">
                  @elseif($summary->client->getRawOriginal('avatar'))
                    <img src="{{ asset('storage/' . $summary->client->getRawOriginal('avatar')) }}" alt="{{ $summary->client->name }}" class="client-avatar">
                  @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($summary->client->name) }}&background=647494&color=fff&size=80&bold=true&format=svg" alt="{{ $summary->client->name }}" class="client-avatar">
                  @endif
                  <div>
                    <div class="client-name">{{ $summary->client->name }}</div>
                    <div class="client-email">{{ $summary->client->email }}</div>
                  </div>
                </div>
              </td>
              <td class="font-medium text-[#041C54]">{{ $summary->appointment_date->format('d M, Y') }}</td>
              <td class="text-[#7484A4]">{{ date('h:i A', strtotime($summary->appointment_time)) }}</td>
              <td>
                <span class="mode-badge {{ $summary->session_mode }}">{{ strtoupper($summary->session_mode) }}</span>
              </td>
              <td>
                @if($summary->session_notes)
                  <div class="description-cell" title="{{ $summary->session_notes }}">
                    {{ Str::limit($summary->session_notes, 40) }}
                  </div>
                @else
                  <span class="text-[#BAC2D2]">—</span>
                @endif
              </td>
              <td class="text-[#7484A4]">
                @if($summary->payment && $summary->payment->paid_at)
                  {{ $summary->payment->paid_at->format('d M, Y') }}
                @else
                  <span class="text-[#BAC2D2]">—</span>
                @endif
              </td>
              <td class="amount-due">₹{{ number_format($summary->therapistEarning ? $summary->therapistEarning->due_amount : 0, 2) }}</td>
              <td class="amount-available">₹{{ number_format($summary->therapistEarning ? $summary->therapistEarning->available_amount : 0, 2) }}</td>
              <td class="amount-disbursed">₹{{ number_format($summary->therapistEarning ? $summary->therapistEarning->disbursed_amount : 0, 2) }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="11">
                <div class="empty-state">
                  <div class="empty-state-icon">
                    <i class="ri-bar-chart-box-line"></i>
                  </div>
                  <h5>No records found</h5>
                  <p>There are no account summary records matching your filters.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($summaries->hasPages() || $summaries->total() > 0)
      <div class="pagination-wrapper">
        <div class="pagination-info">
          @if($summaries->total() > 0)
            Showing {{ $summaries->firstItem() }} to {{ $summaries->lastItem() }} of {{ $summaries->total() }} entries
          @endif
        </div>
        <div class="pagination-controls">
          @if($summaries->hasPages())
            <span>Page {{ $summaries->currentPage() }} of {{ $summaries->lastPage() }}</span>
            @if($summaries->onFirstPage())
              <button type="button" class="page-btn" disabled aria-label="First page"><i class="ri-arrow-left-double-line"></i></button>
              <button type="button" class="page-btn" disabled aria-label="Previous page"><i class="ri-arrow-left-line"></i></button>
            @else
              <a href="{{ $summaries->url(1) }}" class="page-btn" aria-label="First page"><i class="ri-arrow-left-double-line"></i></a>
              <a href="{{ $summaries->previousPageUrl() }}" class="page-btn" aria-label="Previous page"><i class="ri-arrow-left-line"></i></a>
            @endif
            @if($summaries->hasMorePages())
              <a href="{{ $summaries->nextPageUrl() }}" class="page-btn" aria-label="Next page"><i class="ri-arrow-right-line"></i></a>
              <a href="{{ $summaries->url($summaries->lastPage()) }}" class="page-btn" aria-label="Last page"><i class="ri-arrow-right-double-line"></i></a>
            @else
              <button type="button" class="page-btn" disabled aria-label="Next page"><i class="ri-arrow-right-line"></i></button>
              <button type="button" class="page-btn" disabled aria-label="Last page"><i class="ri-arrow-right-double-line"></i></button>
            @endif
          @endif
          <select class="per-page-select" onchange="updatePerPage(this.value)" aria-label="Rows per page">
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
  function toggleFilterSection() {
    const filterContent = document.getElementById('filterContent');
    const toggleBtn = document.getElementById('filterToggleBtn');
    const toggleIcon = document.getElementById('filterToggleIcon');
    if (!filterContent || !toggleBtn) return;

    filterContent.classList.toggle('collapsed');
    const collapsed = filterContent.classList.contains('collapsed');
    toggleBtn.classList.toggle('active', collapsed);
    toggleBtn.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
    localStorage.setItem('filterSectionCollapsed_therapist_account', collapsed ? 'true' : 'false');
  }

  document.addEventListener('DOMContentLoaded', function() {
    const savedState = localStorage.getItem('filterSectionCollapsed_therapist_account');
    const filterContent = document.getElementById('filterContent');
    const toggleBtn = document.getElementById('filterToggleBtn');
    if (savedState === 'true' && filterContent && toggleBtn) {
      filterContent.classList.add('collapsed');
      toggleBtn.classList.add('active');
      toggleBtn.setAttribute('aria-expanded', 'false');
    }
  });

  function updatePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    window.location.href = url.toString();
  }
</script>
@endsection
