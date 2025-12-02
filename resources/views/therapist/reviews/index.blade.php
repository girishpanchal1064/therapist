@extends('layouts/contentNavbarLayout')

@section('title', 'My Reviews')

@section('page-style')
<style>
  /* === Reviews Page Custom Styles === */
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

  /* Stats Cards */
  .stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  .stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
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

  .stat-card.total::before { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
  .stat-card.average::before { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
  .stat-card.distribution::before { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }

  .stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    margin-bottom: 1rem;
  }

  .stat-card.total .stat-icon { background: rgba(102, 126, 234, 0.1); color: #667eea; }
  .stat-card.average .stat-icon { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
  .stat-card.distribution .stat-icon { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }

  .stat-label {
    font-size: 0.75rem;
    color: #6b7280;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.375rem;
  }

  .stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .stat-value i {
    color: #f59e0b;
    font-size: 1.5rem;
  }

  /* Rating Distribution */
  .rating-distribution {
    display: flex;
    gap: 0.75rem;
    margin-top: 0.5rem;
  }

  .rating-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: #f9fafb;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    min-width: 44px;
  }

  .rating-item .count {
    font-weight: 700;
    color: #1f2937;
    font-size: 1rem;
  }

  .rating-item .stars {
    font-size: 0.6875rem;
    color: #f59e0b;
    font-weight: 600;
  }

  /* Reviews Card */
  .reviews-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow: hidden;
  }

  .reviews-card .card-body {
    padding: 1.5rem;
  }

  /* Filters */
  .filters-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
  }

  .search-filters {
    display: flex;
    gap: 0.75rem;
    flex: 1;
    max-width: 600px;
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
    border-color: #f59e0b;
    background-color: white;
    box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
  }

  .rating-filter {
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9375rem;
    background: #f9fafb;
    cursor: pointer;
    min-width: 140px;
  }

  .rating-filter:focus {
    outline: none;
    border-color: #f59e0b;
    box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
  }

  .btn-search {
    padding: 0.75rem 1.25rem;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    color: white;
  }

  .btn-clear {
    padding: 0.75rem 1rem;
    background: white;
    color: #6b7280;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
  }

  .btn-clear:hover {
    background: #f3f4f6;
    color: #374151;
  }

  .btn-refresh {
    padding: 0.75rem 1.25rem;
    background: white;
    color: #f59e0b;
    border: 2px solid #f59e0b;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-refresh:hover {
    background: #f59e0b;
    color: white;
    transform: translateY(-2px);
  }

  /* Table Styles - Enhanced */
  .reviews-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  }

  .reviews-table thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 18px 20px;
    border: none;
    text-align: left;
    white-space: nowrap;
  }

  .reviews-table thead th:first-child {
    border-radius: 12px 0 0 0;
  }

  .reviews-table thead th:last-child {
    border-radius: 0 12px 0 0;
  }

  .reviews-table tbody td {
    padding: 18px 20px;
    border-bottom: 1px solid #f0f2f5;
    vertical-align: middle;
    color: #2d3748;
    font-size: 0.9rem;
  }

  .reviews-table tbody tr {
    transition: all 0.3s ease;
    background: white;
  }

  .reviews-table tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.04) 0%, rgba(118, 75, 162, 0.04) 100%);
    transform: scale(1.001);
    box-shadow: 0 2px 12px rgba(102, 126, 234, 0.08);
  }

  .reviews-table tbody tr:last-child td {
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
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid #e5e7eb;
  }

  .client-avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.8125rem;
  }

  .client-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.9375rem;
  }

  .client-email {
    font-size: 0.75rem;
    color: #9ca3af;
  }

  /* Rating Stars */
  .rating-stars {
    display: flex;
    align-items: center;
    gap: 0.25rem;
  }

  .rating-stars i {
    font-size: 1rem;
    color: #e5e7eb;
  }

  .rating-stars i.filled {
    color: #f59e0b;
  }

  .rating-score {
    font-weight: 700;
    color: #1f2937;
    margin-left: 0.5rem;
    font-size: 0.9375rem;
  }

  /* Comment Cell */
  .comment-cell {
    max-width: 280px;
  }

  .comment-text {
    color: #4b5563;
    font-size: 0.875rem;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .no-comment {
    color: #d1d5db;
    font-style: italic;
    font-size: 0.875rem;
  }

  /* Status Badges */
  .status-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.375rem;
  }

  .status-badge {
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
    font-size: 0.6875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.02em;
  }

  .status-badge.verified { background: rgba(16, 185, 129, 0.1); color: #059669; }
  .status-badge.pending { background: rgba(245, 158, 11, 0.1); color: #d97706; }
  .status-badge.public { background: rgba(59, 130, 246, 0.1); color: #2563eb; }
  .status-badge.private { background: rgba(107, 114, 128, 0.1); color: #4b5563; }

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

  .page-btn:hover:not(:disabled) {
    border-color: #f59e0b;
    color: #f59e0b;
    background: #fffbeb;
  }

  .page-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
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
    border-color: #f59e0b;
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
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.5rem;
    color: #f59e0b;
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
  @media (max-width: 992px) {
    .stats-row {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 768px) {
    .filters-row {
      flex-direction: column;
    }

    .search-filters {
      max-width: 100%;
      width: 100%;
      flex-wrap: wrap;
    }

    .reviews-table {
      display: block;
      overflow-x: auto;
    }
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <h4>
    <i class="ri-star-smile-line"></i>
    My Reviews
  </h4>
  <p>See what your clients are saying about your sessions</p>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border-left: 4px solid #10b981;">
    <i class="ri-checkbox-circle-line me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Stats Cards -->
<div class="stats-row">
  <div class="stat-card total">
    <div class="stat-icon">
      <i class="ri-chat-quote-line"></i>
    </div>
    <div class="stat-label">Total Reviews</div>
    <div class="stat-value">{{ $totalReviews }}</div>
  </div>

  <div class="stat-card average">
    <div class="stat-icon">
      <i class="ri-star-fill"></i>
    </div>
    <div class="stat-label">Average Rating</div>
    <div class="stat-value">
      {{ number_format($averageRating, 1) }}
      <i class="ri-star-fill"></i>
    </div>
  </div>

  <div class="stat-card distribution">
    <div class="stat-icon">
      <i class="ri-bar-chart-grouped-line"></i>
    </div>
    <div class="stat-label">Rating Distribution</div>
    <div class="rating-distribution">
      @for($i = 5; $i >= 1; $i--)
        <div class="rating-item">
          <span class="count">{{ $ratingDistribution[$i] ?? 0 }}</span>
          <span class="stars">{{ $i }}★</span>
        </div>
      @endfor
    </div>
  </div>
</div>

<!-- Reviews Card -->
<div class="reviews-card">
  <div class="card-body">
    <!-- Filters -->
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
        <button type="submit" class="btn-search">
          <i class="ri-search-line"></i>
        </button>
        @if($search || $rating)
          <a href="{{ route('therapist.reviews.index') }}" class="btn-clear">
            <i class="ri-close-line"></i>
          </a>
        @endif
      </form>
      <button type="button" class="btn-refresh" onclick="location.reload()">
        <i class="ri-refresh-line"></i>
        Refresh
      </button>
    </div>

    <!-- Reviews Table -->
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
              <td style="font-weight: 500; color: #6b7280;">{{ $reviews->firstItem() + $index }}</td>
              <td>
                <div class="client-cell">
                  @if($review->client->avatar)
                    <img src="{{ asset('storage/' . $review->client->avatar) }}" alt="{{ $review->client->name }}" class="client-avatar">
                  @else
                    <div class="client-avatar-placeholder">
                      {{ strtoupper(substr($review->client->name, 0, 2)) }}
                    </div>
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
              <td style="font-weight: 500;">
                @if($review->appointment)
                  {{ $review->appointment->appointment_date->format('d M, Y') }}
                @else
                  <span style="color: #d1d5db;">N/A</span>
                @endif
              </td>
              <td style="color: #6b7280;">{{ $review->created_at->format('d M, Y') }}</td>
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

    <!-- Pagination -->
    @if($reviews->hasPages() || $reviews->total() > 0)
      <div class="pagination-wrapper">
        <div class="pagination-info">
          @if($reviews->total() > 0)
            Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} reviews
          @endif
        </div>
        <div class="pagination-controls">
          @if($reviews->hasPages())
            <span style="font-size: 0.875rem; color: #6b7280; margin-right: 0.5rem;">
              Page {{ $reviews->currentPage() }} of {{ $reviews->lastPage() }}
            </span>
            @if($reviews->onFirstPage())
              <button class="page-btn" disabled><i class="ri-arrow-left-double-line"></i></button>
              <button class="page-btn" disabled><i class="ri-arrow-left-line"></i></button>
            @else
              <a href="{{ $reviews->url(1) }}" class="page-btn"><i class="ri-arrow-left-double-line"></i></a>
              <a href="{{ $reviews->previousPageUrl() }}" class="page-btn"><i class="ri-arrow-left-line"></i></a>
            @endif
            @if($reviews->hasMorePages())
              <a href="{{ $reviews->nextPageUrl() }}" class="page-btn"><i class="ri-arrow-right-line"></i></a>
              <a href="{{ $reviews->url($reviews->lastPage()) }}" class="page-btn"><i class="ri-arrow-right-double-line"></i></a>
            @else
              <button class="page-btn" disabled><i class="ri-arrow-right-line"></i></button>
              <button class="page-btn" disabled><i class="ri-arrow-right-double-line"></i></button>
            @endif
          @endif
          <select class="per-page-select" onchange="updatePerPage(this.value)">
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
