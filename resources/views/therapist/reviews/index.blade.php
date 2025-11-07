@extends('layouts/contentNavbarLayout')

@section('title', 'My Reviews')

@section('content')
<div class="row">
  <div class="col-12 mb-4">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="card">
      <div class="card-body">
        <!-- Page Title -->
        <h4 class="mb-4 fw-bold">My Reviews</h4>

        <!-- Statistics Cards -->
        <div class="row mb-4">
          <div class="col-md-4">
            <div class="card bg-primary text-white">
              <div class="card-body">
                <h6 class="card-title text-white-50">Total Reviews</h6>
                <h3 class="mb-0">{{ $totalReviews }}</h3>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card bg-success text-white">
              <div class="card-body">
                <h6 class="card-title text-white-50">Average Rating</h6>
                <h3 class="mb-0">{{ number_format($averageRating, 1) }} <i class="ri-star-fill"></i></h3>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card bg-info text-white">
              <div class="card-body">
                <h6 class="card-title text-white-50">Rating Distribution</h6>
                <div class="d-flex gap-2">
                  @for($i = 5; $i >= 1; $i--)
                    <div class="text-center">
                      <div class="fw-bold">{{ $ratingDistribution[$i] ?? 0 }}</div>
                      <small>{{ $i }}★</small>
                    </div>
                  @endfor
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Search and Filter -->
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div class="col-md-6">
            <form method="GET" action="{{ route('therapist.reviews.index') }}" class="d-flex gap-2">
              <input type="text" name="search" class="form-control" placeholder="Search by client name or comment..." value="{{ $search }}">
              <select name="rating" class="form-select" style="width: auto;">
                <option value="">All Ratings</option>
                <option value="5" {{ $rating == '5' ? 'selected' : '' }}>5 Stars</option>
                <option value="4" {{ $rating == '4' ? 'selected' : '' }}>4 Stars</option>
                <option value="3" {{ $rating == '3' ? 'selected' : '' }}>3 Stars</option>
                <option value="2" {{ $rating == '2' ? 'selected' : '' }}>2 Stars</option>
                <option value="1" {{ $rating == '1' ? 'selected' : '' }}>1 Star</option>
              </select>
              <button type="submit" class="btn btn-outline-primary">
                <i class="ri-search-line"></i>
              </button>
              @if($search || $rating)
                <a href="{{ route('therapist.reviews.index') }}" class="btn btn-outline-secondary">
                  <i class="ri-close-line"></i> Clear
                </a>
              @endif
            </form>
          </div>
          <div>
            <button type="button" class="btn btn-success" onclick="location.reload()">
              <i class="ri-refresh-line me-1"></i> REFRESH
            </button>
          </div>
        </div>

        <!-- Reviews Table -->
        <div class="table-responsive">
          <table class="table table-bordered reviews-table">
            <thead class="table-primary">
              <tr>
                <th>Sr. No.</th>
                <th>Client Name</th>
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
                  <td>{{ $reviews->firstItem() + $index }}</td>
                  <td>
                    <div class="d-flex align-items-center">
                      @if($review->client->avatar)
                        <img src="{{ asset('storage/' . $review->client->avatar) }}" 
                             alt="{{ $review->client->name }}" 
                             class="rounded-circle me-2" 
                             width="32" 
                             height="32">
                      @else
                        <div class="avatar-initial rounded-circle bg-label-primary me-2 d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px;">
                          {{ strtoupper(substr($review->client->name, 0, 2)) }}
                        </div>
                      @endif
                      <div>
                        <div class="fw-bold">{{ $review->client->name }}</div>
                        <small class="text-muted">{{ $review->client->email }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      @for($i = 1; $i <= 5; $i++)
                        <i class="ri-star{{ $i <= $review->rating ? '-fill' : '-line' }} text-warning"></i>
                      @endfor
                      <span class="ms-2 fw-bold">{{ $review->rating }}/5</span>
                    </div>
                  </td>
                  <td>
                    @if($review->comment)
                      <div class="text-truncate" style="max-width: 300px;" title="{{ $review->comment }}">
                        {{ $review->comment }}
                      </div>
                    @else
                      <span class="text-muted">No comment</span>
                    @endif
                  </td>
                  <td>
                    @if($review->appointment)
                      {{ $review->appointment->appointment_date->format('d-m-Y') }}
                    @else
                      <span class="text-muted">N/A</span>
                    @endif
                  </td>
                  <td>{{ $review->created_at->format('d-m-Y') }}</td>
                  <td>
                    @if($review->is_verified)
                      <span class="badge bg-success">Verified</span>
                    @else
                      <span class="badge bg-warning">Pending</span>
                    @endif
                    @if($review->is_public)
                      <span class="badge bg-info ms-1">Public</span>
                    @else
                      <span class="badge bg-secondary ms-1">Private</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">No reviews found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages() || $reviews->total() > 0)
          <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
              @if($reviews->total() > 0)
                <span class="text-muted">
                  Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} entries
                </span>
              @endif
            </div>
            <div class="d-flex align-items-center gap-2">
              @if($reviews->hasPages())
                <span class="text-muted me-2">Page {{ $reviews->currentPage() }} of {{ $reviews->lastPage() }}</span>
                <div class="btn-group" role="group">
                  @if($reviews->onFirstPage())
                    <button class="btn btn-outline-primary btn-sm" disabled>
                      <i class="ri-arrow-left-double-line"></i>
                    </button>
                    <button class="btn btn-outline-primary btn-sm" disabled>
                      <i class="ri-arrow-left-line"></i>
                    </button>
                  @else
                    <a href="{{ $reviews->url(1) }}" class="btn btn-outline-primary btn-sm">
                      <i class="ri-arrow-left-double-line"></i>
                    </a>
                    <a href="{{ $reviews->previousPageUrl() }}" class="btn btn-outline-primary btn-sm">
                      <i class="ri-arrow-left-line"></i>
                    </a>
                  @endif
                  @if($reviews->hasMorePages())
                    <a href="{{ $reviews->nextPageUrl() }}" class="btn btn-outline-primary btn-sm">
                      <i class="ri-arrow-right-line"></i>
                    </a>
                    <a href="{{ $reviews->url($reviews->lastPage()) }}" class="btn btn-outline-primary btn-sm">
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
                <option value="10" {{ $reviews->perPage() == 10 ? 'selected' : '' }}>10 rows</option>
                <option value="25" {{ $reviews->perPage() == 25 ? 'selected' : '' }}>25 rows</option>
                <option value="50" {{ $reviews->perPage() == 50 ? 'selected' : '' }}>50 rows</option>
                <option value="100" {{ $reviews->perPage() == 100 ? 'selected' : '' }}>100 rows</option>
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
  .reviews-table {
    margin-top: 1rem;
  }

  .reviews-table thead th {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
    font-weight: 600;
    padding: 1rem;
    border: none;
    text-align: center;
  }

  .reviews-table tbody td {
    padding: 1rem;
    text-align: center;
    vertical-align: middle;
  }

  .reviews-table tbody tr:hover {
    background-color: #f8f9fa;
  }

  .avatar-initial {
    font-size: 12px;
    font-weight: 600;
  }

  .text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
</style>
@endsection
