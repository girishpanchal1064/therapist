@extends('layouts/contentNavbarLayout')

@section('title', 'Reviews Management')

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
    
    .btn-theme-outline {
        background: transparent;
        border: 2px solid rgba(255,255,255,0.5);
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-theme-outline:hover {
        background: rgba(255,255,255,0.15);
        border-color: white;
        color: white;
    }
    
    .card-modern {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
    
    .filter-card {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
        border: 1px solid rgba(102, 126, 234, 0.1);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    .filter-card .form-label {
        color: #5a5c69;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    
    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
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
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
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
    }
    
    .rating-stars {
        display: flex;
        align-items: center;
        gap: 2px;
    }
    
    .rating-stars i {
        font-size: 1rem;
    }
    
    .badge-verified {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .badge-pending {
        background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        color: #212529;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .badge-public {
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .badge-private {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .comment-preview {
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #6c757d;
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
    
    .pagination-modern .btn:hover:not(.disabled) {
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
    
    .alert-themed.alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        border-left-color: #dc3545;
        color: #721c24;
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
            <h4><i class="ri-star-smile-line me-2"></i>Reviews Management</h4>
            <p>Manage and moderate all client reviews</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reviews.pending') }}" class="btn btn-theme-outline">
                <i class="ri-time-line me-1"></i> Pending Reviews
            </a>
            <a href="{{ route('admin.reviews.create') }}" class="btn btn-theme">
                <i class="ri-add-line me-1"></i> Add Review
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

        @if(session('error'))
            <div class="alert alert-themed alert-danger alert-dismissible" role="alert">
                <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filters -->
        <div class="filter-card">
            <div class="d-flex flex-wrap gap-3 align-items-end">
                <div>
                    <label class="form-label">Status</label>
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
                    <label class="form-label">Rating</label>
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
                    <label class="form-label">Search</label>
                    <form method="GET" action="{{ route('admin.reviews.index') }}" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Search by client, therapist, or comment..." value="{{ $search }}">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input type="hidden" name="rating" value="{{ $rating }}">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                        <button type="submit" class="btn btn-search">
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
                    <button type="button" class="btn btn-refresh" onclick="location.reload()">
                        <i class="ri-refresh-line me-1"></i> Refresh
                    </button>
                </div>
            </div>
        </div>

        <!-- Reviews Table -->
        <div class="table-responsive">
            <table class="table table-modern">
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
                            <td><span class="fw-bold text-muted">{{ $loop->iteration }}</span></td>
                            <td>
                                <div class="user-info">
                                    @if($review->client->avatar)
                                        <img src="{{ asset('storage/' . $review->client->avatar) }}" 
                                             alt="{{ $review->client->name }}" 
                                             class="user-avatar">
                                    @else
                                        <div class="user-avatar-initial" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
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
                                <div class="user-info">
                                    @if($review->therapist->avatar)
                                        <img src="{{ asset('storage/' . $review->therapist->avatar) }}" 
                                             alt="{{ $review->therapist->name }}" 
                                             class="user-avatar">
                                    @else
                                        <div class="user-avatar-initial" style="background: linear-gradient(135deg, #20c997 0%, #28a745 100%);">
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
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="ri-star{{ $i <= $review->rating ? '-fill' : '-line' }} text-warning"></i>
                                    @endfor
                                    <span class="ms-2 fw-bold">{{ $review->rating }}/5</span>
                                </div>
                            </td>
                            <td>
                                @if($review->comment)
                                    <div class="comment-preview" title="{{ $review->comment }}">
                                        {{ $review->comment }}
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">No comment</span>
                                @endif
                            </td>
                            <td>
                                @if($review->appointment)
                                    <span class="text-muted">
                                        <i class="ri-calendar-line me-1"></i>
                                        {{ $review->appointment->appointment_date->format('d-m-Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted">
                                    <i class="ri-time-line me-1"></i>
                                    {{ $review->created_at->format('d-m-Y h:i A') }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    @if($review->is_verified)
                                        <span class="badge-verified">Verified</span>
                                    @else
                                        <span class="badge-pending">Pending</span>
                                    @endif
                                    @if($review->is_public)
                                        <span class="badge-public">Public</span>
                                    @else
                                        <span class="badge-private">Private</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="dropdown action-dropdown">
                                    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="ri-more-2-line"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('admin.reviews.show', $review) }}">
                                            <i class="ri-eye-line me-2"></i> View Details
                                        </a>
                                        @if(!$review->is_verified)
                                            <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-success">
                                                    <i class="ri-check-line me-2"></i> Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-warning" onclick="return confirm('Are you sure you want to reject this review?')">
                                                    <i class="ri-close-line me-2"></i> Reject
                                                </button>
                                            </form>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('admin.reviews.edit', $review) }}">
                                            <i class="ri-pencil-line me-2"></i> Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this review?')">
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
                                        <i class="ri-star-smile-line"></i>
                                    </div>
                                    <h5 class="text-muted">No Reviews Found</h5>
                                    <p class="text-muted">There are no reviews matching your criteria.</p>
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
                <div class="d-flex align-items-center gap-2 pagination-modern">
                    <div class="d-flex gap-1">
                        <a href="{{ $reviews->url(1) }}" class="btn btn-sm {{ $reviews->onFirstPage() ? 'disabled' : '' }}">
                            <i class="ri-arrow-left-double-line"></i>
                        </a>
                        <a href="{{ $reviews->previousPageUrl() }}" class="btn btn-sm {{ $reviews->onFirstPage() ? 'disabled' : '' }}">
                            <i class="ri-arrow-left-line"></i>
                        </a>
                        <a href="{{ $reviews->nextPageUrl() }}" class="btn btn-sm {{ $reviews->hasMorePages() ? '' : 'disabled' }}">
                            <i class="ri-arrow-right-line"></i>
                        </a>
                        <a href="{{ $reviews->url($reviews->lastPage()) }}" class="btn btn-sm {{ $reviews->hasMorePages() ? '' : 'disabled' }}">
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
