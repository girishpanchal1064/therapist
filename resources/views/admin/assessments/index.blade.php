@extends('layouts/contentNavbarLayout')

@section('title', 'Assessments Management')

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
    
    .bulk-actions {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
        border: 1px solid rgba(102, 126, 234, 0.1);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .bulk-actions .btn-sm {
        border-radius: 6px;
        font-weight: 500;
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
    
    .assessment-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .assessment-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
    }
    
    .assessment-icon-placeholder {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
        font-weight: 600;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .badge-category {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8e9ff 100%);
        color: #667eea;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .badge-count {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.35rem 0.6rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    
    .badge-count-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }
    
    .badge-active {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .badge-inactive {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .duration-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: #667eea;
        font-weight: 500;
    }
    
    .sort-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.75rem;
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
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.95rem;
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
    
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4><i class="ri-file-list-3-line me-2"></i>Assessments Management</h4>
            <p>Create and manage assessment tools</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.assessments.results') }}" class="btn btn-theme-outline">
                <i class="ri-bar-chart-line me-1"></i> Results
            </a>
            <a href="{{ route('admin.assessments.create') }}" class="btn btn-theme">
                <i class="ri-add-line me-1"></i> Add Assessment
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

        <!-- Bulk Actions -->
        <form id="bulkActionForm" action="{{ route('admin.assessments.bulk-update') }}" method="POST">
            @csrf
            <div class="bulk-actions">
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                        <label class="form-check-label fw-bold" for="selectAll">
                            Select All
                        </label>
                    </div>
                    <div class="vr"></div>
                    <span class="text-muted small fw-bold" id="selectedCount">0 selected</span>
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
            </div>
        </form>

        <!-- Filters -->
        <div class="filter-card">
            <div class="d-flex flex-wrap gap-3 align-items-end">
                <div>
                    <label class="form-label">Status</label>
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
                        <label class="form-label">Category</label>
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
                    <label class="form-label">Search</label>
                    <form method="GET" action="{{ route('admin.assessments.index') }}" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Search by title, description, or category..." value="{{ $search }}">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input type="hidden" name="category" value="{{ $category }}">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                        <button type="submit" class="btn btn-search">
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
                    <button type="button" class="btn btn-refresh" onclick="location.reload()">
                        <i class="ri-refresh-line me-1"></i> Refresh
                    </button>
                </div>
            </div>
        </div>

        <!-- Assessments Table -->
        <div class="table-responsive">
            <table class="table table-modern">
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
                            <td><span class="fw-bold text-muted">{{ $loop->iteration }}</span></td>
                            <td>
                                <div class="assessment-info">
                                    @if($assessment->icon)
                                        <div class="assessment-icon" style="background: {{ $assessment->color ?? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' }};">
                                            <i class="{{ $assessment->icon }}"></i>
                                        </div>
                                    @else
                                        <div class="assessment-icon-placeholder">
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
                                <span class="badge-category">{{ $assessment->category }}</span>
                            </td>
                            <td>
                                <span class="badge-count">{{ $assessment->questions_count ?? 0 }}</span>
                            </td>
                            <td>
                                <span class="badge-count badge-count-success">{{ $assessment->user_assessments_count ?? 0 }}</span>
                            </td>
                            <td>
                                <span class="duration-badge">
                                    <i class="ri-time-line"></i>
                                    {{ $assessment->duration_minutes }} min
                                </span>
                            </td>
                            <td>
                                @if($assessment->is_active)
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <span class="sort-badge">{{ $assessment->sort_order }}</span>
                            </td>
                            <td>
                                <span class="text-muted">
                                    <i class="ri-calendar-line me-1"></i>
                                    {{ $assessment->created_at->format('d-m-Y') }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.assessments.show', $assessment) }}" class="btn-action view" title="View">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    <a href="{{ route('admin.assessments.edit', $assessment) }}" class="btn-action edit" title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <form action="{{ route('admin.assessments.destroy', $assessment) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Delete" data-title="Delete Assessment" data-text="Are you sure you want to delete this assessment? This action cannot be undone." data-confirm-text="Yes, delete it!" data-cancel-text="Cancel">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="ri-file-list-3-line"></i>
                                    </div>
                                    <h5 class="text-muted">No Assessments Found</h5>
                                    <p class="text-muted">Create your first assessment to get started.</p>
                                    <a href="{{ route('admin.assessments.create') }}" class="btn btn-theme mt-2">
                                        <i class="ri-add-line me-1"></i> Add Assessment
                                    </a>
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
                <div class="d-flex align-items-center gap-2 pagination-modern">
                    <div class="d-flex gap-1">
                        <a href="{{ $assessments->url(1) }}" class="btn btn-sm {{ $assessments->onFirstPage() ? 'disabled' : '' }}">
                            <i class="ri-arrow-left-double-line"></i>
                        </a>
                        <a href="{{ $assessments->previousPageUrl() }}" class="btn btn-sm {{ $assessments->onFirstPage() ? 'disabled' : '' }}">
                            <i class="ri-arrow-left-line"></i>
                        </a>
                        <a href="{{ $assessments->nextPageUrl() }}" class="btn btn-sm {{ $assessments->hasMorePages() ? '' : 'disabled' }}">
                            <i class="ri-arrow-right-line"></i>
                        </a>
                        <a href="{{ $assessments->url($assessments->lastPage()) }}" class="btn btn-sm {{ $assessments->hasMorePages() ? '' : 'disabled' }}">
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
