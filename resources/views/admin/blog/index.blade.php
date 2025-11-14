@extends('layouts/contentNavbarLayout')

@section('title', 'Blog Management')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Blog Posts Management</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.blog.categories') }}" class="btn btn-outline-info">
            <i class="ri-folder-line me-1"></i> Categories
          </a>
          <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Add Post
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
              <label class="form-label small">Category</label>
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
            <label class="form-label small">Featured</label>
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
            <form method="GET" action="{{ route('admin.blog.index') }}" class="d-flex gap-2">
              <input type="text" name="search" class="form-control" placeholder="Search by title, content, or author..." value="{{ $search }}">
              <input type="hidden" name="status" value="{{ $status }}">
              <input type="hidden" name="category_id" value="{{ $categoryId }}">
              <input type="hidden" name="featured" value="{{ $featured }}">
              <input type="hidden" name="per_page" value="{{ $perPage }}">
              <button type="submit" class="btn btn-outline-primary">
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
            <button type="button" class="btn btn-outline-success" onclick="location.reload()">
              <i class="ri-refresh-line me-1"></i> REFRESH
            </button>
          </div>
        </div>

        <!-- Blog Posts Table -->
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Featured Image</th>
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
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    @if($post->featured_image)
                      <img src="{{ asset('storage/' . $post->featured_image) }}" 
                           alt="{{ $post->title }}" 
                           class="rounded" 
                           style="width: 60px; height: 60px; object-fit: cover;">
                    @else
                      <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center" 
                           style="width: 60px; height: 60px;">
                        <i class="ri-image-line text-muted"></i>
                      </div>
                    @endif
                  </td>
                  <td>
                    <div>
                      <div class="fw-bold">
                        {{ $post->title }}
                        @if($post->is_featured)
                          <i class="ri-star-fill text-warning" title="Featured"></i>
                        @endif
                      </div>
                      @if($post->excerpt)
                        <small class="text-muted">{{ Str::limit($post->excerpt, 60) }}</small>
                      @endif
                    </div>
                  </td>
                  <td>
                    @if($post->category)
                      <span class="badge" style="background-color: {{ $post->category->color ?? '#3B82F6' }};">
                        {{ $post->category->name }}
                      </span>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      @if($post->author->avatar)
                        <img src="{{ asset('storage/' . $post->author->avatar) }}" 
                             alt="{{ $post->author->name }}" 
                             class="rounded-circle me-2" 
                             width="24" 
                             height="24">
                      @else
                        <div class="avatar-initial rounded-circle bg-label-primary me-2 d-flex align-items-center justify-content-center" 
                             style="width: 24px; height: 24px; font-size: 0.75rem;">
                          {{ strtoupper(substr($post->author->name, 0, 2)) }}
                        </div>
                      @endif
                      <div>
                        <div class="small fw-bold">{{ $post->author->name }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    @php
                      $statusColors = [
                        'draft' => 'secondary',
                        'published' => 'success',
                        'archived' => 'warning'
                      ];
                      $color = $statusColors[$post->status] ?? 'secondary';
                    @endphp
                    <span class="badge bg-{{ $color }}">
                      {{ ucfirst($post->status) }}
                    </span>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <i class="ri-eye-line me-1 text-muted"></i>
                      <span>{{ number_format($post->views_count) }}</span>
                    </div>
                  </td>
                  <td>
                    @if($post->published_at)
                      {{ $post->published_at->format('d-m-Y h:i A') }}
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="ri-more-2-line"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.blog.show', $post) }}">
                          <i class="ri-eye-line me-1"></i> View
                        </a>
                        @if($post->status !== 'published')
                          <form action="{{ route('admin.blog.publish', $post) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-success">
                              <i class="ri-checkbox-circle-line me-1"></i> Publish
                            </button>
                          </form>
                        @endif
                        <a class="dropdown-item" href="{{ route('admin.blog.edit', $post) }}">
                          <i class="ri-pencil-line me-1"></i> Edit
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="d-inline">
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
                      <p class="mt-2">No blog posts found.</p>
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
            <div class="d-flex align-items-center gap-2">
              <div class="d-flex gap-1">
                <a href="{{ $posts->url(1) }}" class="btn btn-sm btn-outline-secondary {{ $posts->onFirstPage() ? 'disabled' : '' }}">
                  <i class="ri-arrow-left-double-line"></i>
                </a>
                <a href="{{ $posts->previousPageUrl() }}" class="btn btn-sm btn-outline-secondary {{ $posts->onFirstPage() ? 'disabled' : '' }}">
                  <i class="ri-arrow-left-line"></i>
                </a>
                <a href="{{ $posts->nextPageUrl() }}" class="btn btn-sm btn-outline-secondary {{ $posts->hasMorePages() ? '' : 'disabled' }}">
                  <i class="ri-arrow-right-line"></i>
                </a>
                <a href="{{ $posts->url($posts->lastPage()) }}" class="btn btn-sm btn-outline-secondary {{ $posts->hasMorePages() ? '' : 'disabled' }}">
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
