@extends('layouts/contentNavbarLayout')

@section('title', 'Roles Management')

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
    
    .count-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .count-badge-users {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }
    
    .role-name {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .role-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
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
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: none !important;
        background: #f8f9fa !important;
        border-radius: 6px !important;
        margin: 0 2px !important;
        padding: 6px 12px !important;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4><i class="ri-shield-user-line me-2"></i>Roles Management</h4>
            <p>Manage user roles and permissions</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-theme">
            <i class="ri-add-line me-1"></i> Add New Role
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
            <table class="table table-modern" id="rolesTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Role Name</th>
                        <th>Permissions Count</th>
                        <th>Users Count</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
$(document).ready(function() {
    $('#rolesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.roles.index') }}",
            type: 'GET'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'role_name', name: 'name', orderable: false, searchable: false },
            { data: 'permissions_count', name: 'permissions_count', orderable: false, searchable: false },
            { data: 'users_count', name: 'users_count', orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        order: [[0, 'desc']],
        pageLength: 25,
        responsive: true,
        language: {
            processing: '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>',
            search: "<i class='ri-search-line me-2'></i>Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ roles",
            infoEmpty: "No roles found",
            infoFiltered: "(filtered from _MAX_ total roles)",
            emptyTable: '<div class="empty-state"><div class="empty-state-icon"><i class="ri-shield-user-line"></i></div><h5 class="text-muted">No Roles Found</h5><p class="text-muted">Create your first role to get started.</p></div>',
            paginate: {
                first: '<i class="ri-arrow-left-double-line"></i>',
                last: '<i class="ri-arrow-right-double-line"></i>',
                next: '<i class="ri-arrow-right-line"></i>',
                previous: '<i class="ri-arrow-left-line"></i>'
            }
        }
    });
});
</script>
@endsection
