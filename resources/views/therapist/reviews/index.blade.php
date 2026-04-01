@extends('layouts/contentNavbarLayout')

@section('title', 'My Reviews')

@section('page-style')
<style>
  .layout-page .content-wrapper { background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important; }

  .therapist-reviews-apni .search-filters {
    display: flex;
    gap: 0.75rem;
    flex: 1;
    max-width: 720px;
    flex-wrap: wrap;
    align-items: stretch;
  }
  .therapist-reviews-apni .search-input {
    flex: 1;
    min-width: 180px;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid rgba(186, 194, 210, 0.85);
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%237484a4'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E") no-repeat 0.875rem center;
    background-size: 18px;
  }
  .therapist-reviews-apni .search-input:focus {
    outline: none;
    border-color: #041c54;
    background-color: #fff;
    box-shadow: 0 0 0 4px rgba(4, 28, 84, 0.12);
  }
  .therapist-reviews-apni .rating-filter {
    padding: 0.75rem 1rem;
    border: 2px solid rgba(186, 194, 210, 0.85);
    border-radius: 10px;
    font-size: 0.9375rem;
    background: #f8fafc;
    cursor: pointer;
    min-width: 150px;
    color: #041c54;
  }
  .therapist-reviews-apni .rating-filter:focus {
    outline: none;
    border-color: #041c54;
    box-shadow: 0 0 0 4px rgba(4, 28, 84, 0.12);
  }
  .therapist-reviews-apni .btn-search {
    padding: 0.75rem 1.15rem;
    background: #041c54;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.2);
  }
  .therapist-reviews-apni .btn-search:hover {
    background: #052a66;
    color: #fff;
  }
  .therapist-reviews-apni .btn-clear {
    padding: 0.75rem 1rem;
    background: #fff;
    color: #647494;
    border: 2px solid rgba(100, 116, 148, 0.4);
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  .therapist-reviews-apni .btn-clear:hover {
    background: rgba(186, 194, 210, 0.2);
    color: #041c54;
    border-color: #647494;
  }
  .therapist-reviews-apni .btn-refresh {
    padding: 0.75rem 1.25rem;
    background: #fff;
    color: #041c54;
    border: 2px solid rgba(4, 28, 84, 0.35);
    border-radius: 10px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }
  .therapist-reviews-apni .btn-refresh:hover {
    background: rgba(4, 28, 84, 0.06);
    border-color: #041c54;
    color: #041c54;
  }

  .therapist-reviews-apni .filters-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
  }

  .therapist-reviews-apni .reviews-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(186, 194, 210, 0.45);
  }
  .therapist-reviews-apni .reviews-table thead th {
    background: rgba(186, 194, 210, 0.2);
    color: #4d5d78;
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 14px 16px;
    border: none;
    text-align: left;
    white-space: nowrap;
  }
  .therapist-reviews-apni .reviews-table tbody td {
    padding: 14px 16px;
    border-bottom: 1px solid rgba(186, 194, 210, 0.35);
    vertical-align: middle;
    color: #334155;
    font-size: 0.875rem;
  }
  .therapist-reviews-apni .reviews-table tbody tr {
    background: #fff;
    transition: background 0.2s ease;
  }
  .therapist-reviews-apni .reviews-table tbody tr:hover {
    background: rgba(4, 28, 84, 0.03);
  }
  .therapist-reviews-apni .reviews-table tbody tr:last-child td {
    border-bottom: none;
  }

  .therapist-reviews-apni .client-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }
  .therapist-reviews-apni .client-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid rgba(186, 194, 210, 0.7);
  }
  .therapist-reviews-apni .client-name {
    font-weight: 600;
    color: #041c54;
    font-size: 0.9375rem;
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
  }
  .therapist-reviews-apni .client-email {
    font-size: 0.75rem;
    color: #7484a4;
  }

  .therapist-reviews-apni .rating-stars {
    display: flex;
    align-items: center;
    gap: 0.2rem;
  }
  .therapist-reviews-apni .rating-stars i {
    font-size: 1rem;
    color: #e2e8f0;
  }
  .therapist-reviews-apni .rating-stars i.filled {
    color: #f59e0b;
  }
  .therapist-reviews-apni .rating-score {
    font-weight: 700;
    color: #041c54;
    margin-left: 0.5rem;
    font-size: 0.875rem;
  }

  .therapist-reviews-apni .comment-cell { max-width: 280px; }
  .therapist-reviews-apni .comment-text {
    color: #647494;
    font-size: 0.875rem;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .therapist-reviews-apni .no-comment {
    color: #bac2d2;
    font-style: italic;
    font-size: 0.875rem;
  }

  .therapist-reviews-apni .status-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.375rem;
  }
  .therapist-reviews-apni .status-badge {
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.02em;
  }
  .therapist-reviews-apni .status-badge.verified { background: rgba(16, 185, 129, 0.12); color: #059669; }
  .therapist-reviews-apni .status-badge.pending { background: rgba(245, 158, 11, 0.12); color: #b45309; }
  .therapist-reviews-apni .status-badge.public { background: rgba(59, 130, 246, 0.12); color: #2563eb; }
  .therapist-reviews-apni .status-badge.private { background: rgba(100, 116, 148, 0.15); color: #4d5d78; }

  .therapist-reviews-apni .pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.25rem;
    margin-top: 1rem;
    border-top: 1px solid rgba(186, 194, 210, 0.45);
    flex-wrap: wrap;
    gap: 1rem;
  }
  .therapist-reviews-apni .pagination-info,
  .therapist-reviews-apni .pagination-controls span {
    font-size: 0.875rem;
    color: #7484a4;
  }
  .therapist-reviews-apni .pagination-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
  }
  .therapist-reviews-apni .page-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 2px solid rgba(186, 194, 210, 0.85);
    background: #fff;
    color: #647494;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    text-decoration: none;
  }
  .therapist-reviews-apni a.page-btn:hover {
    border-color: #041c54;
    color: #041c54;
    background: rgba(4, 28, 84, 0.04);
  }
  .therapist-reviews-apni .page-btn:disabled {
    opacity: 0.45;
    cursor: not-allowed;
  }
  .therapist-reviews-apni .per-page-select {
    padding: 0.5rem 0.75rem;
    border: 2px solid rgba(186, 194, 210, 0.85);
    border-radius: 8px;
    font-size: 0.875rem;
    color: #041c54;
    background: #fff;
    cursor: pointer;
  }
  .therapist-reviews-apni .per-page-select:focus {
    outline: none;
    border-color: #041c54;
  }

  .therapist-reviews-apni .empty-state {
    text-align: center;
    padding: 2.5rem 1rem;
  }
  .therapist-reviews-apni .empty-state-icon {
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
  .therapist-reviews-apni .empty-state h5 {
    font-weight: 600;
    color: #041c54;
    margin-bottom: 0.5rem;
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
  }
  .therapist-reviews-apni .empty-state p {
    color: #7484a4;
    font-size: 0.9375rem;
    margin: 0;
  }

  @media (max-width: 768px) {
    .therapist-reviews-apni .filters-row { flex-direction: column; align-items: stretch; }
    .therapist-reviews-apni .search-filters { max-width: 100%; }
  }
</style>
@endsection

@section('content')
<div class="therapist-reviews-apni pb-2">
  <div class="relative mb-8 overflow-hidden rounded-3xl shadow-[0_20px_25px_-5px_rgba(100,116,148,0.2),0_8px_10px_-6px_rgba(100,116,148,0.2)]"
       style="background: linear-gradient(171deg, #647494 0%, #6d7f9d 25%, #7484A4 50%, #6d7f9d 75%, #647494 100%);">
    <div class="pointer-events-none absolute -right-20 top-0 h-64 w-64 rounded-full bg-white/10 blur-[64px]" aria-hidden="true"></div>
    <div class="relative z-10 flex flex-col gap-6 p-6 md:flex-row md:items-center md:justify-between md:p-8">
      <div class="min-w-0">
        <h1 class="font-display flex items-center gap-3 text-2xl font-medium leading-snug text-white md:text-3xl">
          <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[14px] bg-white/15 text-[1.5rem] backdrop-blur-sm">
            <i class="ri-star-smile-line"></i>
          </span>
          My Reviews
        </h1>
        <p class="mt-2 max-w-xl text-base text-white/90">
          See what your clients are saying about your sessions.
        </p>
      </div>
      <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:items-center">
        <a href="{{ route('therapist.dashboard') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] bg-white px-5 py-2.5 text-sm font-medium text-[#041C54] shadow-md transition hover:bg-[#BAC2D2]/30">
          <i class="ri-dashboard-line text-lg"></i>
          Dashboard
        </a>
        <a href="{{ route('therapist.profile.index', ['tab' => 'basic-info']) }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] border-2 border-white px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/10">
          <i class="ri-user-settings-line text-lg"></i>
          Profile
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

  {{-- Stats — same card language as dashboard --}}
  <div class="mb-8 grid grid-cols-1 gap-4 lg:grid-cols-3">
    <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
      <div class="flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#647494]/10">
        <i class="ri-chat-quote-line text-2xl text-[#647494]"></i>
      </div>
      <p class="mt-4 text-sm text-[#7484A4]">Total Reviews</p>
      <p class="font-display mt-1 text-3xl font-medium text-[#041C54]">{{ $totalReviews }}</p>
    </div>
    <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
      <div class="flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#F59E0B]/10">
        <i class="ri-star-fill text-2xl text-[#d97706]"></i>
      </div>
      <p class="mt-4 text-sm text-[#7484A4]">Average Rating</p>
      <p class="font-display mt-1 flex items-center gap-2 text-3xl font-medium text-[#041C54]">
        {{ number_format($averageRating, 1) }}
        <i class="ri-star-fill text-2xl text-[#F59E0B]"></i>
      </p>
    </div>
    <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
      <div class="flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#06B6D4]/10">
        <i class="ri-bar-chart-grouped-line text-2xl text-[#0891b2]"></i>
      </div>
      <p class="mt-4 text-sm text-[#7484A4]">Rating distribution</p>
      <div class="mt-3 flex flex-wrap gap-2">
        @for($i = 5; $i >= 1; $i--)
          <div class="flex min-w-[3rem] flex-col items-center rounded-[10px] bg-[#BAC2D2]/15 px-2 py-1.5">
            <span class="text-sm font-semibold text-[#041C54]">{{ $ratingDistribution[$i] ?? 0 }}</span>
            <span class="text-[0.65rem] font-semibold text-[#d97706]">{{ $i }}★</span>
          </div>
        @endfor
      </div>
    </div>
  </div>

  <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-4 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
    <div class="filters-row">
      <form method="GET" action="{{ route('therapist.reviews.index') }}" class="search-filters">
        <input type="text" name="search" class="search-input" placeholder="Search by client name or comment..." value="{{ $search }}">
        <select name="rating" class="rating-filter">
          <option value="">All Ratings</option>
          <option value="5" {{ $rating == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 Stars</option>
          <option value="4" {{ $rating == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ 4 Stars</option>
          <option value="3" {{ $rating == '3' ? 'selected' : '' }}>⭐⭐⭐ 3 Stars</option>
          <option value="2" {{ $rating == '2' ? 'selected' : '' }}>⭐⭐ 2 Stars</option>
          <option value="1" {{ $rating == '1' ? 'selected' : '' }}>⭐ 1 Star</option>
        </select>
        <button type="submit" class="btn-search" aria-label="Search">
          <i class="ri-search-line"></i>
        </button>
        @if($search || $rating)
          <a href="{{ route('therapist.reviews.index') }}" class="btn-clear" aria-label="Clear filters">
            <i class="ri-close-line"></i>
          </a>
        @endif
      </form>
      <button type="button" class="btn-refresh" onclick="location.reload()">
        <i class="ri-refresh-line"></i>
        Refresh
      </button>
    </div>

    <div class="table-responsive">
      <table class="reviews-table">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>Client</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Appointment Date</th>
            <th>Review Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reviews as $index => $review)
            <tr>
              <td class="text-[#7484A4]" style="font-weight: 500;">{{ $reviews->firstItem() + $index }}</td>
              <td>
                <div class="client-cell">
                  @if($review->client->profile && $review->client->profile->profile_image)
                    <img src="{{ asset('storage/' . $review->client->profile->profile_image) }}" alt="{{ $review->client->name }}" class="client-avatar">
                  @elseif($review->client->getRawOriginal('avatar'))
                    <img src="{{ asset('storage/' . $review->client->getRawOriginal('avatar')) }}" alt="{{ $review->client->name }}" class="client-avatar">
                  @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->client->name) }}&background=647494&color=fff&size=80&bold=true&format=svg" alt="{{ $review->client->name }}" class="client-avatar">
                  @endif
                  <div>
                    <div class="client-name">{{ $review->client->name }}</div>
                    <div class="client-email">{{ $review->client->email }}</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="rating-stars">
                  @for($i = 1; $i <= 5; $i++)
                    <i class="ri-star-fill {{ $i <= $review->rating ? 'filled' : '' }}"></i>
                  @endfor
                  <span class="rating-score">{{ $review->rating }}/5</span>
                </div>
              </td>
              <td>
                <div class="comment-cell">
                  @if($review->comment)
                    <div class="comment-text" title="{{ $review->comment }}">{{ $review->comment }}</div>
                  @else
                    <span class="no-comment">No comment provided</span>
                  @endif
                </div>
              </td>
              <td class="font-medium text-[#041C54]">
                @if($review->appointment)
                  {{ $review->appointment->appointment_date->format('d M, Y') }}
                @else
                  <span class="text-[#BAC2D2]">N/A</span>
                @endif
              </td>
              <td class="text-[#7484A4]">{{ $review->created_at->format('d M, Y') }}</td>
              <td>
                <div class="status-badges">
                  @if($review->is_verified)
                    <span class="status-badge verified">Verified</span>
                  @else
                    <span class="status-badge pending">Pending</span>
                  @endif
                  @if($review->is_public)
                    <span class="status-badge public">Public</span>
                  @else
                    <span class="status-badge private">Private</span>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7">
                <div class="empty-state">
                  <div class="empty-state-icon">
                    <i class="ri-star-line"></i>
                  </div>
                  <h5>No reviews yet</h5>
                  <p>Once your clients submit reviews, they'll appear here.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($reviews->hasPages() || $reviews->total() > 0)
      <div class="pagination-wrapper">
        <div class="pagination-info">
          @if($reviews->total() > 0)
            Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} reviews
          @endif
        </div>
        <div class="pagination-controls">
          @if($reviews->hasPages())
            <span>
              Page {{ $reviews->currentPage() }} of {{ $reviews->lastPage() }}
            </span>
            @if($reviews->onFirstPage())
              <button type="button" class="page-btn" disabled aria-label="First page"><i class="ri-arrow-left-double-line"></i></button>
              <button type="button" class="page-btn" disabled aria-label="Previous page"><i class="ri-arrow-left-line"></i></button>
            @else
              <a href="{{ $reviews->url(1) }}" class="page-btn" aria-label="First page"><i class="ri-arrow-left-double-line"></i></a>
              <a href="{{ $reviews->previousPageUrl() }}" class="page-btn" aria-label="Previous page"><i class="ri-arrow-left-line"></i></a>
            @endif
            @if($reviews->hasMorePages())
              <a href="{{ $reviews->nextPageUrl() }}" class="page-btn" aria-label="Next page"><i class="ri-arrow-right-line"></i></a>
              <a href="{{ $reviews->url($reviews->lastPage()) }}" class="page-btn" aria-label="Last page"><i class="ri-arrow-right-double-line"></i></a>
            @else
              <button type="button" class="page-btn" disabled aria-label="Next page"><i class="ri-arrow-right-line"></i></button>
              <button type="button" class="page-btn" disabled aria-label="Last page"><i class="ri-arrow-right-double-line"></i></button>
            @endif
          @endif
          <select class="per-page-select" onchange="updatePerPage(this.value)" aria-label="Rows per page">
            <option value="10" {{ $reviews->perPage() == 10 ? 'selected' : '' }}>10 rows</option>
            <option value="25" {{ $reviews->perPage() == 25 ? 'selected' : '' }}>25 rows</option>
            <option value="50" {{ $reviews->perPage() == 50 ? 'selected' : '' }}>50 rows</option>
            <option value="100" {{ $reviews->perPage() == 100 ? 'selected' : '' }}>100 rows</option>
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
