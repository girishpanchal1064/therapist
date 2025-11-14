@extends('layouts/contentNavbarLayout')

@section('title', 'Assessments Management')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Assessments Management</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.assessments.results') }}" class="btn btn-outline-info">
            <i class="ri-bar-chart-line me-1"></i> Results
          </a>
          <a href="{{ route('admin.assessments.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Add Assessment
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

        <!-- Bulk Actions -->
        <form id="bulkActionForm" action="{{ route('admin.assessments.bulk-update') }}" method="POST" class="mb-3">
          @csrf
          <div class="d-flex flex-wrap gap-2 align-items-center">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
              <label class="form-check-label" for="selectAll">
                Select All
              </label>
            </div>
            <div class="vr"></div>
            <span class="text-muted small" id="selectedCount">0 selected</span>
            <div class="vr"></div>
            <button type="button" class="btn btn-sm btn-success" onclick="submitBulkAction('activate')" id="bulkActivateBtn" disabled>
              <i class="ri-checkbox-circle-line me-1"></i> Activate Selected
            </button>
            <button type="button" class="btn btn-sm btn-warning" onclick="submitBulkAction('deactivate')" id="bulkDeactivateBtn" disabled>
              <i class="ri-close-circle-line me-1"></i> Deactivate Selected
            </button>
            <input type="hidden" name="action" id="bulkAction">
            <input type="hidden" name="ids" id="bulkIds">
          </div>
        </form>

        <!-- Filters -->
        <div class="d-flex flex-wrap gap-2 mb-4 align-items-end">
          <div>
            <label class="form-label small">Status</label>
            <form method="GET" action="{{ route('admin.assessments.index') }}" class="d-flex gap-2">
              <select name="status" class="form-select" style="width: 150px;" onchange="this.form.submit()">
                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive</option>
              </select>
              <input type="hidden" name="search" value="{{ $search }}">
              <input type="hidden" name="category" value="{{ $category }}">
              <input type="hidden" name="per_page" value="{{ $perPage }}">
            </form>
          </div>

          @if($categories->count() > 0)
            <div>
              <label class="form-label small">Category</label>
              <form method="GET" action="{{ route('admin.assessments.index') }}" class="d-flex gap-2">
                <select name="category" class="form-select" style="width: 180px;" onchange="this.form.submit()">
                  <option value="">All Categories</option>
                  @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                  @endforeach
                </select>
                <input type="hidden" name="search" value="{{ $search }}">
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="hidden" name="per_page" value="{{ $perPage }}">
              </form>
            </div>
          @endif
          
          <div class="flex-grow-1">
            <form method="GET" action="{{ route('admin.assessments.index') }}" class="d-flex gap-2">
              <input type="text" name="search" class="form-control" placeholder="Search by title, description, or category..." value="{{ $search }}">
              <input type="hidden" name="status" value="{{ $status }}">
              <input type="hidden" name="category" value="{{ $category }}">
              <input type="hidden" name="per_page" value="{{ $perPage }}">
              <button type="submit" class="btn btn-outline-primary">
                <i class="ri-search-line"></i>
              </button>
              @if($search)
                <a href="{{ route('admin.assessments.index', ['status' => $status, 'category' => $category, 'per_page' => $perPage]) }}" class="btn btn-outline-secondary">
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

        <!-- Assessments Table -->
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th style="width: 40px;">
                  <input type="checkbox" class="form-check-input" id="selectAllHeader" onchange="toggleSelectAll(this)">
                </th>
                <th>#</th>
                <th>Title</th>
                <th>Category</th>
                <th>Questions</th>
                <th>Completions</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Sort Order</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($assessments as $assessment)
                <tr>
                  <td>
                    <input type="checkbox" class="form-check-input assessment-checkbox" 
                           value="{{ $assessment->id }}" 
                           onchange="updateBulkButtons()">
                  </td>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    <div class="d-flex align-items-center">
                      @if($assessment->icon)
                        <i class="{{ $assessment->icon }} me-2" style="color: {{ $assessment->color ?? '#3B82F6' }}; font-size: 1.5rem;"></i>
                      @else
                        <div class="avatar-initial rounded-circle bg-label-primary me-2 d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px; background-color: {{ $assessment->color ?? '#3B82F6' }};">
                          {{ strtoupper(substr($assessment->title, 0, 2)) }}
                        </div>
                      @endif
                      <div>
                        <div class="fw-bold">{{ $assessment->title }}</div>
                        @if($assessment->description)
                          <small class="text-muted">{{ Str::limit($assessment->description, 50) }}</small>
                        @endif
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="badge bg-label-secondary">{{ $assessment->category }}</span>
                  </td>
                  <td>
                    <span class="badge bg-info">{{ $assessment->questions_count ?? 0 }}</span>
                  </td>
                  <td>
                    <span class="badge bg-success">{{ $assessment->user_assessments_count ?? 0 }}</span>
                  </td>
                  <td>
                    <i class="ri-time-line me-1"></i>{{ $assessment->duration_minutes }} min
                  </td>
                  <td>
                    @if($assessment->is_active)
                      <span class="badge bg-success">Active</span>
                    @else
                      <span class="badge bg-secondary">Inactive</span>
                    @endif
                  </td>
                  <td>{{ $assessment->sort_order }}</td>
                  <td>{{ $assessment->created_at->format('d-m-Y') }}</td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="ri-more-2-line"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.assessments.show', $assessment) }}">
                          <i class="ri-eye-line me-1"></i> View
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.assessments.edit', $assessment) }}">
                          <i class="ri-pencil-line me-1"></i> Edit
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('admin.assessments.destroy', $assessment) }}" method="POST" class="d-inline">
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
                  <td colspan="11" class="text-center py-4">
                    <div class="text-muted">
                      <i class="ri-inbox-line" style="font-size: 3rem;"></i>
                      <p class="mt-2">No assessments found.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if($assessments->hasPages())
          <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
              <span class="text-muted">Showing {{ $assessments->firstItem() }} to {{ $assessments->lastItem() }} of {{ $assessments->total() }} entries</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <div class="d-flex gap-1">
                <a href="{{ $assessments->url(1) }}" class="btn btn-sm btn-outline-secondary {{ $assessments->onFirstPage() ? 'disabled' : '' }}">
                  <i class="ri-arrow-left-double-line"></i>
                </a>
                <a href="{{ $assessments->previousPageUrl() }}" class="btn btn-sm btn-outline-secondary {{ $assessments->onFirstPage() ? 'disabled' : '' }}">
                  <i class="ri-arrow-left-line"></i>
                </a>
                <a href="{{ $assessments->nextPageUrl() }}" class="btn btn-sm btn-outline-secondary {{ $assessments->hasMorePages() ? '' : 'disabled' }}">
                  <i class="ri-arrow-right-line"></i>
                </a>
                <a href="{{ $assessments->url($assessments->lastPage()) }}" class="btn btn-sm btn-outline-secondary {{ $assessments->hasMorePages() ? '' : 'disabled' }}">
                  <i class="ri-arrow-right-double-line"></i>
                </a>
              </div>
              <span class="text-muted ms-2">Page {{ $assessments->currentPage() }} of {{ $assessments->lastPage() }}</span>
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

  function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.assessment-checkbox');
    const selectAllHeader = document.getElementById('selectAllHeader');
    const selectAll = document.getElementById('selectAll');
    
    checkboxes.forEach(cb => {
      cb.checked = checkbox.checked;
    });
    
    if (selectAllHeader) selectAllHeader.checked = checkbox.checked;
    if (selectAll) selectAll.checked = checkbox.checked;
    
    updateBulkButtons();
  }

  function updateBulkButtons() {
    const checkboxes = document.querySelectorAll('.assessment-checkbox:checked');
    const count = checkboxes.length;
    const selectedCount = document.getElementById('selectedCount');
    const bulkActivateBtn = document.getElementById('bulkActivateBtn');
    const bulkDeactivateBtn = document.getElementById('bulkDeactivateBtn');
    
    selectedCount.textContent = count + ' selected';
    
    if (count > 0) {
      bulkActivateBtn.disabled = false;
      bulkDeactivateBtn.disabled = false;
    } else {
      bulkActivateBtn.disabled = true;
      bulkDeactivateBtn.disabled = true;
    }
    
    // Update select all checkboxes
    const allCheckboxes = document.querySelectorAll('.assessment-checkbox');
    const allChecked = allCheckboxes.length > 0 && Array.from(allCheckboxes).every(cb => cb.checked);
    const selectAllHeader = document.getElementById('selectAllHeader');
    const selectAll = document.getElementById('selectAll');
    
    if (selectAllHeader) selectAllHeader.checked = allChecked;
    if (selectAll) selectAll.checked = allChecked;
  }

  function submitBulkAction(action) {
    const checkboxes = document.querySelectorAll('.assessment-checkbox:checked');
    const ids = Array.from(checkboxes).map(cb => cb.value);
    
    if (ids.length === 0) {
      alert('Please select at least one assessment.');
      return;
    }
    
    if (!confirm(`Are you sure you want to ${action === 'activate' ? 'activate' : 'deactivate'} ${ids.length} assessment(s)?`)) {
      return;
    }
    
    document.getElementById('bulkAction').value = action;
    document.getElementById('bulkIds').value = JSON.stringify(ids);
    document.getElementById('bulkActionForm').submit();
  }

  // Initialize on page load
  document.addEventListener('DOMContentLoaded', function() {
    updateBulkButtons();
  });
</script>
@endsection
