@extends('layouts/contentNavbarLayout')

@section('title', 'Reviews Management')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Reviews Management</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.reviews.pending') }}" class="btn btn-outline-warning">
            <i class="ri-time-line me-1"></i> Pending Reviews
          </a>
          <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Add Review
          </a>
        </div>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Filters -->
        <div class="d-flex flex-wrap gap-2 mb-4 align-items-end">
          <div>
            <label class="form-label small">Status</label>
            <form method="GET" action="{{ route('admin.reviews.index') }}" class="d-flex gap-2">
              <select name="status" class="form-select" style="width: 150px;" onchange="this.form.submit()">
                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                <option value="verified" {{ $status === 'verified' ? 'selected' : '' }}>Verified</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="public" {{ $status === 'public' ? 'selected' : '' }}>Public</option>
                <option value="private" {{ $status === 'private' ? 'selected' : '' }}>Private</option>
              </select>
              <input type="hidden" name="search" value="{{ $search }}">
              <input type="hidden" name="rating" value="{{ $rating }}">
              <input type="hidden" name="per_page" value="{{ $perPage }}">
            </form>
          </div>

          <div>
            <label class="form-label small">Rating</label>
            <form method="GET" action="{{ route('admin.reviews.index') }}" class="d-flex gap-2">
              <select name="rating" class="form-select" style="width: 130px;" onchange="this.form.submit()">
                <option value="">All Ratings</option>
                <option value="5" {{ $rating == '5' ? 'selected' : '' }}>5 Stars</option>
                <option value="4" {{ $rating == '4' ? 'selected' : '' }}>4 Stars</option>
                <option value="3" {{ $rating == '3' ? 'selected' : '' }}>3 Stars</option>
                <option value="2" {{ $rating == '2' ? 'selected' : '' }}>2 Stars</option>
                <option value="1" {{ $rating == '1' ? 'selected' : '' }}>1 Star</option>
              </select>
              <input type="hidden" name="search" value="{{ $search }}">
              <input type="hidden" name="status" value="{{ $status }}">
              <input type="hidden" name="per_page" value="{{ $perPage }}">
            </form>
          </div>
          
          <div class="flex-grow-1">
            <form method="GET" action="{{ route('admin.reviews.index') }}" class="d-flex gap-2">
              <input type="text" name="search" class="form-control" placeholder="Search by client, therapist, or comment..." value="{{ $search }}">
              <input type="hidden" name="status" value="{{ $status }}">
              <input type="hidden" name="rating" value="{{ $rating }}">
              <input type="hidden" name="per_page" value="{{ $perPage }}">
              <button type="submit" class="btn btn-outline-primary">
                <i class="ri-search-line"></i>
              </button>
              @if($search)
                <a href="{{ route('admin.reviews.index', ['status' => $status, 'rating' => $rating, 'per_page' => $perPage]) }}" class="btn btn-outline-secondary">
                  <i class="ri-close-line"></i>
                </a>
              @endif
            </form>
          </div>

          <div>
            <button type="button" class="btn btn-outline-success" onclick="location.reload()">
              <i class="ri-refresh-line me-1"></i> REFRESH
            </button>
          </div>
        </div>

        <!-- Reviews Table -->
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Client</th>
                <th>Therapist</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Appointment Date</th>
                <th>Review Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($reviews as $review)
                <tr>
                  <td>{{ $loop->iteration }}</td>
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
                      @if($review->therapist->avatar)
                        <img src="{{ asset('storage/' . $review->therapist->avatar) }}" 
                             alt="{{ $review->therapist->name }}" 
                             class="rounded-circle me-2" 
                             width="32" 
                             height="32">
                      @else
                        <div class="avatar-initial rounded-circle bg-label-success me-2 d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px;">
                          {{ strtoupper(substr($review->therapist->name, 0, 2)) }}
                        </div>
                      @endif
                      <div>
                        <div class="fw-bold">{{ $review->therapist->name }}</div>
                        <small class="text-muted">{{ $review->therapist->email }}</small>
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
                      <div class="text-truncate" style="max-width: 250px;" title="{{ $review->comment }}">
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
                  <td>{{ $review->created_at->format('d-m-Y h:i A') }}</td>
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
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="ri-more-2-line"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.reviews.show', $review) }}">
                          <i class="ri-eye-line me-1"></i> View
                        </a>
                        @if(!$review->is_verified)
                          <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-success">
                              <i class="ri-check-line me-1"></i> Approve
                            </button>
                          </form>
                          <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-warning" onclick="return confirm('Are you sure you want to reject this review?')">
                              <i class="ri-close-line me-1"></i> Reject
                            </button>
                          </form>
                        @endif
                        <a class="dropdown-item" href="{{ route('admin.reviews.edit', $review) }}">
                          <i class="ri-pencil-line me-1"></i> Edit
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">
                            <i class="ri-delete-bin-line me-1"></i> Delete
                          </button>
                        </form>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" class="text-center py-4">
                    <div class="text-muted">
                      <i class="ri-inbox-line" style="font-size: 3rem;"></i>
                      <p class="mt-2">No reviews found.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
          <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
              <span class="text-muted">Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} entries</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <div class="d-flex gap-1">
                <a href="{{ $reviews->url(1) }}" class="btn btn-sm btn-outline-secondary {{ $reviews->onFirstPage() ? 'disabled' : '' }}">
                  <i class="ri-arrow-left-double-line"></i>
                </a>
                <a href="{{ $reviews->previousPageUrl() }}" class="btn btn-sm btn-outline-secondary {{ $reviews->onFirstPage() ? 'disabled' : '' }}">
                  <i class="ri-arrow-left-line"></i>
                </a>
                <a href="{{ $reviews->nextPageUrl() }}" class="btn btn-sm btn-outline-secondary {{ $reviews->hasMorePages() ? '' : 'disabled' }}">
                  <i class="ri-arrow-right-line"></i>
                </a>
                <a href="{{ $reviews->url($reviews->lastPage()) }}" class="btn btn-sm btn-outline-secondary {{ $reviews->hasMorePages() ? '' : 'disabled' }}">
                  <i class="ri-arrow-right-double-line"></i>
                </a>
              </div>
              <span class="text-muted ms-2">Page {{ $reviews->currentPage() }} of {{ $reviews->lastPage() }}</span>
              <select class="form-select form-select-sm" style="width: auto;" onchange="updatePerPage(this.value)">
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
