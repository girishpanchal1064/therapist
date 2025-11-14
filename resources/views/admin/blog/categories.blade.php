@extends('layouts/contentNavbarLayout')

@section('title', 'Blog Categories')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Blog Categories</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
          <i class="ri-add-line me-1"></i> Add New Category
        </button>
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
        <div class="row mb-4">
          <div class="col-md-4">
            <form method="GET" action="{{ route('admin.blog.categories') }}" class="d-flex gap-2">
              <input type="text" 
                     name="search" 
                     class="form-control" 
                     placeholder="Search categories..." 
                     value="{{ $search }}">
              <button type="submit" class="btn btn-outline-primary">
                <i class="ri-search-line"></i>
              </button>
              @if($search)
                <a href="{{ route('admin.blog.categories') }}" class="btn btn-outline-secondary">
                  <i class="ri-close-line"></i>
                </a>
              @endif
            </form>
          </div>
          <div class="col-md-3">
            <form method="GET" action="{{ route('admin.blog.categories') }}" id="statusForm">
              <input type="hidden" name="search" value="{{ $search }}">
              <select name="status" class="form-select" onchange="document.getElementById('statusForm').submit();">
                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive</option>
              </select>
            </form>
          </div>
          <div class="col-md-2">
            <form method="GET" action="{{ route('admin.blog.categories') }}" id="perPageForm">
              <input type="hidden" name="search" value="{{ $search }}">
              <input type="hidden" name="status" value="{{ $status }}">
              <select name="per_page" class="form-select" onchange="document.getElementById('perPageForm').submit();">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 per page</option>
                <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 per page</option>
                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 per page</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 per page</option>
              </select>
            </form>
          </div>
        </div>

        <!-- Categories Table -->
        @if($categories->count() > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th style="width: 50px;">Color</th>
                  <th>Name</th>
                  <th>Slug</th>
                  <th>Icon</th>
                  <th>Posts</th>
                  <th>Sort Order</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th style="width: 120px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($categories as $category)
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="rounded-circle" 
                             style="width: 24px; height: 24px; background-color: {{ $category->color ?? '#3B82F6' }};"></div>
                      </div>
                    </td>
                    <td>
                      <div class="fw-bold">{{ $category->name }}</div>
                      @if($category->description)
                        <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                      @endif
                    </td>
                    <td>
                      <code class="text-muted">{{ $category->slug }}</code>
                    </td>
                    <td>
                      @if($category->icon)
                        <i class="{{ $category->icon }} fs-5"></i>
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                    <td>
                      <span class="badge bg-label-info">{{ $category->posts_count ?? 0 }}</span>
                    </td>
                    <td>
                      <span class="badge bg-label-secondary">{{ $category->sort_order }}</span>
                    </td>
                    <td>
                      @if($category->is_active)
                        <span class="badge bg-label-success">Active</span>
                      @else
                        <span class="badge bg-label-danger">Inactive</span>
                      @endif
                    </td>
                    <td>
                      <small class="text-muted">{{ $category->created_at->format('d M Y') }}</small>
                    </td>
                    <td>
                      <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                          <i class="ri-more-2-line"></i>
                        </button>
                        <div class="dropdown-menu">
                          <button type="button" 
                                  class="dropdown-item" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#editCategoryModal{{ $category->id }}">
                            <i class="ri-pencil-line me-1"></i> Edit
                          </button>
                          <form action="{{ route('admin.blog.categories.destroy', $category) }}" 
                                method="POST" 
                                class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger">
                              <i class="ri-delete-bin-line me-1"></i> Delete
                            </button>
                          </form>
                        </div>
                      </div>
                    </td>
                  </tr>

                  <!-- Edit Category Modal -->
                  <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <form action="{{ route('admin.blog.categories.update', $category) }}" method="POST">
                          @csrf
                          @method('PUT')
                          <div class="modal-header">
                            <h5 class="modal-title">Edit Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                            <div class="mb-3">
                              <label for="edit_name{{ $category->id }}" class="form-label">Name <span class="text-danger">*</span></label>
                              <input type="text" 
                                     class="form-control" 
                                     id="edit_name{{ $category->id }}" 
                                     name="name" 
                                     value="{{ old('name', $category->name) }}" 
                                     required>
                            </div>
                            <div class="mb-3">
                              <label for="edit_slug{{ $category->id }}" class="form-label">Slug <span class="text-danger">*</span></label>
                              <input type="text" 
                                     class="form-control" 
                                     id="edit_slug{{ $category->id }}" 
                                     name="slug" 
                                     value="{{ old('slug', $category->slug) }}" 
                                     required>
                            </div>
                            <div class="mb-3">
                              <label for="edit_description{{ $category->id }}" class="form-label">Description</label>
                              <textarea class="form-control" 
                                        id="edit_description{{ $category->id }}" 
                                        name="description" 
                                        rows="3">{{ old('description', $category->description) }}</textarea>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="mb-3">
                                  <label for="edit_color{{ $category->id }}" class="form-label">Color</label>
                                  <input type="color" 
                                         class="form-control form-control-color" 
                                         id="edit_color{{ $category->id }}" 
                                         name="color" 
                                         value="{{ old('color', $category->color ?? '#3B82F6') }}">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="mb-3">
                                  <label for="edit_icon{{ $category->id }}" class="form-label">Icon (Remix Icon Class)</label>
                                  <input type="text" 
                                         class="form-control" 
                                         id="edit_icon{{ $category->id }}" 
                                         name="icon" 
                                         value="{{ old('icon', $category->icon) }}" 
                                         placeholder="ri-heart-line">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="mb-3">
                                  <label for="edit_sort_order{{ $category->id }}" class="form-label">Sort Order</label>
                                  <input type="number" 
                                         class="form-control" 
                                         id="edit_sort_order{{ $category->id }}" 
                                         name="sort_order" 
                                         value="{{ old('sort_order', $category->sort_order) }}" 
                                         min="0">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="mb-3">
                                  <label class="form-label">Status</label>
                                  <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="edit_is_active{{ $category->id }}" 
                                           name="is_active" 
                                           value="1" 
                                           {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edit_is_active{{ $category->id }}">
                                      Active
                                    </label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Category</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
              Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} categories
            </div>
            <div>
              {{ $categories->links() }}
            </div>
          </div>
        @else
          <div class="text-center py-5">
            <i class="ri-folder-open-line" style="font-size: 4rem; color: #d1d5db;"></i>
            <h5 class="mt-3 text-muted">No categories found</h5>
            <p class="text-muted">Get started by creating your first blog category.</p>
            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
              <i class="ri-add-line me-1"></i> Add New Category
            </button>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.blog.categories.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Create New Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
            <input type="text" 
                   class="form-control @error('slug') is-invalid @enderror" 
                   id="slug" 
                   name="slug" 
                   value="{{ old('slug') }}" 
                   required>
            <small class="text-muted">URL-friendly identifier (auto-generated from name)</small>
            @error('slug')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                      id="description" 
                      name="description" 
                      rows="3">{{ old('description') }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="color" class="form-label">Color</label>
                <input type="color" 
                       class="form-control form-control-color @error('color') is-invalid @enderror" 
                       id="color" 
                       name="color" 
                       value="{{ old('color', '#3B82F6') }}">
                @error('color')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="icon" class="form-label">Icon (Remix Icon Class)</label>
                <input type="text" 
                       class="form-control @error('icon') is-invalid @enderror" 
                       id="icon" 
                       name="icon" 
                       value="{{ old('icon') }}" 
                       placeholder="ri-heart-line">
                <small class="text-muted">e.g., ri-heart-line, ri-user-line</small>
                @error('icon')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="sort_order" class="form-label">Sort Order</label>
                <input type="number" 
                       class="form-control @error('sort_order') is-invalid @enderror" 
                       id="sort_order" 
                       name="sort_order" 
                       value="{{ old('sort_order', 0) }}" 
                       min="0">
                @error('sort_order')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Status</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" 
                         type="checkbox" 
                         id="is_active" 
                         name="is_active" 
                         value="1" 
                         {{ old('is_active', true) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_active">
                    Active
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Category</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    if (nameInput && slugInput) {
      nameInput.addEventListener('input', function() {
        if (!slugInput.dataset.manualEdit) {
          const slug = this.value
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
          slugInput.value = slug;
        }
      });

      slugInput.addEventListener('input', function() {
        this.dataset.manualEdit = 'true';
      });
    }

    // Auto-generate slug for edit modals
    document.querySelectorAll('[id^="edit_name"]').forEach(function(input) {
      const categoryId = input.id.replace('edit_name', '');
      const slugInput = document.getElementById('edit_slug' + categoryId);
      
      if (slugInput) {
        input.addEventListener('input', function() {
          if (!slugInput.dataset.manualEdit) {
            const slug = this.value
              .toLowerCase()
              .trim()
              .replace(/[^\w\s-]/g, '')
              .replace(/[\s_-]+/g, '-')
              .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
          }
        });

        slugInput.addEventListener('input', function() {
          this.dataset.manualEdit = 'true';
        });
      }
    });
  });
</script>
@endsection
