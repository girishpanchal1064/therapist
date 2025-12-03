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
        color: white;
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
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        width: 100%;
    }
    
    .table-modern thead th {
        background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
        color: #4a5568;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 18px 20px;
        border: none;
        white-space: nowrap;
    }
    
    .table-modern thead th:first-child {
        border-radius: 12px 0 0 0;
    }
    
    .table-modern thead th:last-child {
        border-radius: 0 12px 0 0;
    }
    
    .table-modern tbody tr {
        transition: all 0.3s ease;
        background: white;
        border-bottom: 1px solid #f0f2f5;
    }
    
    .table-modern tbody tr:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.04) 0%, rgba(118, 75, 162, 0.04) 100%);
        transform: scale(1.001);
        box-shadow: 0 2px 12px rgba(102, 126, 234, 0.08);
    }
    
    .table-modern tbody tr:last-child {
        border-bottom: none;
    }
    
    .table-modern tbody td {
        padding: 18px 20px;
        vertical-align: middle;
        color: #2d3748;
        font-size: 0.9rem;
        border-bottom: 1px solid #f0f2f5;
    }
    
    .table-modern tbody tr:last-child td {
        border-bottom: none;
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
    
    /* Modern Action Buttons */
    .action-btns {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-action:hover {
        transform: translateY(-3px);
    }

    .btn-action.view {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1d4ed8;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
    }

    .btn-action.view:hover {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
    }

    .btn-action.edit {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15);
    }

    .btn-action.edit:hover {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.35);
    }

    .btn-action.delete {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #dc2626;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.15);
    }

    .btn-action.delete:hover {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35);
    }

    .btn-action.approve {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #059669;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15);
    }

    .btn-action.approve:hover {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
    }

    .btn-action.reject {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15);
    }

    .btn-action.reject:hover {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.35);
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
                                    @if($review->client->profile && $review->client->profile->profile_image)
                                        <img src="{{ asset('storage/' . $review->client->profile->profile_image) }}" 
                                             alt="{{ $review->client->name }}" 
                                             class="user-avatar">
                                    @elseif($review->client->getRawOriginal('avatar'))
                                        <img src="{{ asset('storage/' . $review->client->getRawOriginal('avatar')) }}" 
                                             alt="{{ $review->client->name }}" 
                                             class="user-avatar">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($review->client->name) }}&background=3b82f6&color=fff&size=80&bold=true&format=svg" 
                                             alt="{{ $review->client->name }}" 
                                             class="user-avatar">
                                    @endif
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
                                    @if($review->therapist->therapistProfile && $review->therapist->therapistProfile->profile_image)
                                        <img src="{{ asset('storage/' . $review->therapist->therapistProfile->profile_image) }}" 
                                             alt="{{ $review->therapist->name }}" 
                                             class="user-avatar">
                                    @elseif($review->therapist->avatar)
                                        <img src="{{ asset('storage/' . $review->therapist->avatar) }}" 
                                             alt="{{ $review->therapist->name }}" 
                                             class="user-avatar">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($review->therapist->name) }}&background=667eea&color=fff&size=72&bold=true&format=svg" 
                                             alt="{{ $review->therapist->name }}" 
                                             class="user-avatar">
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
                                <div class="action-btns">
                                    <a href="{{ route('admin.reviews.show', $review) }}" class="btn-action view" title="View Details">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    @if(!$review->is_verified)
                                        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-action approve" title="Approve">
                                                <i class="ri-check-line"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            <button type="submit" class="btn-action reject" title="Reject" data-title="Reject Review" data-text="Are you sure you want to reject this review?" data-confirm-text="Yes, reject it!" data-cancel-text="Cancel">
                                                <i class="ri-close-line"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.reviews.edit', $review) }}" class="btn-action edit" title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Delete" data-title="Delete Review" data-text="Are you sure you want to delete this review? This action cannot be undone." data-confirm-text="Yes, delete it!" data-cancel-text="Cancel">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
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
