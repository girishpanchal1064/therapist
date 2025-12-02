@extends('layouts/contentNavbarLayout')

@section('title', 'Blog Management')

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
        background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
        color: #4a5568;
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
    
    .post-image {
        width: 70px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #f0f0f0;
    }
    
    .post-image-placeholder {
        width: 70px;
        height: 50px;
        border-radius: 8px;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8e9ff 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
    }
    
    .author-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .author-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .author-avatar-initial {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.7rem;
        color: white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .badge-draft {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .badge-published {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .badge-archived {
        background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        color: #212529;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .badge-category {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
        color: white;
    }
    
    .views-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8e9ff 100%);
        padding: 0.35rem 0.65rem;
        border-radius: 20px;
        color: #667eea;
        font-weight: 500;
        font-size: 0.8rem;
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
    
    .featured-star {
        color: #ffc107;
        margin-left: 5px;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4><i class="ri-article-line me-2"></i>Blog Management</h4>
            <p>Create and manage blog posts</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.blog.categories') }}" class="btn btn-theme-outline">
                <i class="ri-folder-line me-1"></i> Categories
            </a>
            <a href="{{ route('admin.blog.create') }}" class="btn btn-theme">
                <i class="ri-add-line me-1"></i> Add Post
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
                    <form method="GET" action="{{ route('admin.blog.index') }}" class="d-flex gap-2">
                        <select name="status" class="form-select" style="width: 150px;" onchange="this.form.submit()">
                            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                            <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ $status === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ $status === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        <input type="hidden" name="search" value="{{ $search }}">
                        <input type="hidden" name="category_id" value="{{ $categoryId }}">
                        <input type="hidden" name="featured" value="{{ $featured }}">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                    </form>
                </div>

                @if($categories->count() > 0)
                    <div>
                        <label class="form-label">Category</label>
                        <form method="GET" action="{{ route('admin.blog.index') }}" class="d-flex gap-2">
                            <select name="category_id" class="form-select" style="width: 180px;" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="search" value="{{ $search }}">
                            <input type="hidden" name="status" value="{{ $status }}">
                            <input type="hidden" name="featured" value="{{ $featured }}">
                            <input type="hidden" name="per_page" value="{{ $perPage }}">
                        </form>
                    </div>
                @endif

                <div>
                    <label class="form-label">Featured</label>
                    <form method="GET" action="{{ route('admin.blog.index') }}" class="d-flex gap-2">
                        <select name="featured" class="form-select" style="width: 130px;" onchange="this.form.submit()">
                            <option value="">All Posts</option>
                            <option value="1" {{ $featured === '1' ? 'selected' : '' }}>Featured Only</option>
                            <option value="0" {{ $featured === '0' ? 'selected' : '' }}>Not Featured</option>
                        </select>
                        <input type="hidden" name="search" value="{{ $search }}">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input type="hidden" name="category_id" value="{{ $categoryId }}">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                    </form>
                </div>
                
                <div class="flex-grow-1">
                    <label class="form-label">Search</label>
                    <form method="GET" action="{{ route('admin.blog.index') }}" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Search by title, content, or author..." value="{{ $search }}">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input type="hidden" name="category_id" value="{{ $categoryId }}">
                        <input type="hidden" name="featured" value="{{ $featured }}">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                        <button type="submit" class="btn btn-search">
                            <i class="ri-search-line"></i>
                        </button>
                        @if($search)
                            <a href="{{ route('admin.blog.index', ['status' => $status, 'category_id' => $categoryId, 'featured' => $featured, 'per_page' => $perPage]) }}" class="btn btn-outline-secondary">
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

        <!-- Blog Posts Table -->
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Published At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td><span class="fw-bold text-muted">{{ $loop->iteration }}</span></td>
                            <td>
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                         alt="{{ $post->title }}" 
                                         class="post-image">
                                @else
                                    <div class="post-image-placeholder">
                                        <i class="ri-image-line"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <div class="fw-bold">
                                        {{ $post->title }}
                                        @if($post->is_featured)
                                            <i class="ri-star-fill featured-star" title="Featured"></i>
                                        @endif
                                    </div>
                                    @if($post->excerpt)
                                        <small class="text-muted">{{ Str::limit($post->excerpt, 60) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($post->category)
                                    <span class="badge-category" style="background-color: {{ $post->category->color ?? '#667eea' }};">
                                        {{ $post->category->name }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="author-info">
                                    @if($post->author->avatar)
                                        <img src="{{ asset('storage/' . $post->author->avatar) }}" 
                                             alt="{{ $post->author->name }}" 
                                             class="author-avatar">
                                    @else
                                        <div class="author-avatar-initial">
                                            {{ strtoupper(substr($post->author->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <span class="small fw-bold">{{ $post->author->name }}</span>
                                </div>
                            </td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'draft' => 'badge-draft',
                                        'published' => 'badge-published',
                                        'archived' => 'badge-archived'
                                    ];
                                    $statusClass = $statusClasses[$post->status] ?? 'badge-draft';
                                @endphp
                                <span class="{{ $statusClass }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="views-badge">
                                    <i class="ri-eye-line"></i>
                                    {{ number_format($post->views_count) }}
                                </div>
                            </td>
                            <td>
                                @if($post->published_at)
                                    <span class="text-muted">
                                        <i class="ri-calendar-line me-1"></i>
                                        {{ $post->published_at->format('d-m-Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown action-dropdown">
                                    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="ri-more-2-line"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('admin.blog.show', $post) }}">
                                            <i class="ri-eye-line me-2"></i> View
                                        </a>
                                        @if($post->status !== 'published')
                                            <form action="{{ route('admin.blog.publish', $post) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-success">
                                                    <i class="ri-checkbox-circle-line me-2"></i> Publish
                                                </button>
                                            </form>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('admin.blog.edit', $post) }}">
                                            <i class="ri-pencil-line me-2"></i> Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this post?')">
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
                                        <i class="ri-article-line"></i>
                                    </div>
                                    <h5 class="text-muted">No Blog Posts Found</h5>
                                    <p class="text-muted">Start creating amazing content for your audience.</p>
                                    <a href="{{ route('admin.blog.create') }}" class="btn btn-theme mt-2">
                                        <i class="ri-add-line me-1"></i> Create First Post
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <span class="text-muted">Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} entries</span>
                </div>
                <div class="d-flex align-items-center gap-2 pagination-modern">
                    <div class="d-flex gap-1">
                        <a href="{{ $posts->url(1) }}" class="btn btn-sm {{ $posts->onFirstPage() ? 'disabled' : '' }}">
                            <i class="ri-arrow-left-double-line"></i>
                        </a>
                        <a href="{{ $posts->previousPageUrl() }}" class="btn btn-sm {{ $posts->onFirstPage() ? 'disabled' : '' }}">
                            <i class="ri-arrow-left-line"></i>
                        </a>
                        <a href="{{ $posts->nextPageUrl() }}" class="btn btn-sm {{ $posts->hasMorePages() ? '' : 'disabled' }}">
                            <i class="ri-arrow-right-line"></i>
                        </a>
                        <a href="{{ $posts->url($posts->lastPage()) }}" class="btn btn-sm {{ $posts->hasMorePages() ? '' : 'disabled' }}">
                            <i class="ri-arrow-right-double-line"></i>
                        </a>
                    </div>
                    <span class="text-muted ms-2">Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</span>
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
