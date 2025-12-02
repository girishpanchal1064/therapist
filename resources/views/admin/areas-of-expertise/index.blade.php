@extends('layouts/contentNavbarLayout')

@section('title', 'Areas of Expertise Management')

@section('vendor-style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
@endsection

@section('vendor-script')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
@endsection

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
    
    .card-modern {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
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
    
    .slug-badge {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8e9ff 100%);
        color: #667eea;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-family: monospace;
        font-size: 0.8rem;
    }
    
    .sort-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .icon-preview {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8e9ff 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
        font-size: 1.1rem;
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
    
    /* DataTables Custom Styling */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        margin-left: 0.5rem;
    }
    
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #667eea;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }
    
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 0.35rem 0.75rem;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4><i class="ri-lightbulb-line me-2"></i>Areas of Expertise Management</h4>
            <p>Manage therapist expertise areas</p>
        </div>
        <a href="{{ route('admin.areas-of-expertise.create') }}" class="btn btn-theme">
            <i class="ri-add-line me-1"></i> Add New Area
        </a>
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

        <div class="table-responsive">
            <table class="table table-modern" id="areasTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Icon</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($areas as $area)
                        <tr>
                            <td><span class="fw-bold text-muted">{{ $loop->iteration }}</span></td>
                            <td>
                                <span class="fw-bold">{{ $area->name }}</span>
                            </td>
                            <td>
                                <span class="slug-badge">{{ $area->slug }}</span>
                            </td>
                            <td>
                                @if($area->description)
                                    <span class="text-muted" title="{{ $area->description }}">
                                        {{ Str::limit($area->description, 50) }}
                                    </span>
                                @else
                                    <span class="text-muted fst-italic">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($area->icon)
                                    <div class="icon-preview">
                                        <i class="{{ $area->icon }}"></i>
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">N/A</span>
                                @endif
                            </td>
                            <td>
                                <span class="sort-badge">{{ $area->sort_order }}</span>
                            </td>
                            <td>
                                @if($area->is_active)
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted">
                                    <i class="ri-calendar-line me-1"></i>
                                    {{ $area->created_at->format('M d, Y') }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.areas-of-expertise.show', $area) }}" class="btn-action view" title="View">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    <a href="{{ route('admin.areas-of-expertise.edit', $area) }}" class="btn-action edit" title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <form action="{{ route('admin.areas-of-expertise.destroy', $area) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Delete" onclick="return confirm('Are you sure you want to delete this area?')">
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
                                        <i class="ri-lightbulb-line"></i>
                                    </div>
                                    <h5 class="text-muted">No Areas of Expertise Found</h5>
                                    <p class="text-muted">Create your first area to get started.</p>
                                    <a href="{{ route('admin.areas-of-expertise.create') }}" class="btn btn-theme mt-2">
                                        <i class="ri-add-line me-1"></i> Add Area
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $areas->links() }}
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
$(document).ready(function() {
    $('#areasTable').DataTable({
        processing: true,
        paging: false,
        searching: true,
        ordering: true,
        info: false,
        responsive: true
    });
});
</script>
@endsection
