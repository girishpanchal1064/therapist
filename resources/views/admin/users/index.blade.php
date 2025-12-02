@extends('layouts/contentNavbarLayout')

@section('title', 'Users Management')

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
  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
  }

  .page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  .page-header h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
  }

  .page-header p {
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 0;
    position: relative;
    z-index: 1;
  }

  .header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: white;
    backdrop-filter: blur(10px);
  }

  /* Main Card */
  .main-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
  }

  .main-card .card-header {
    background: white;
    border-bottom: 2px solid #f0f2f5;
    padding: 1.5rem;
  }

  .main-card .card-body {
    padding: 1.5rem;
  }

  /* Add Button */
  .btn-add {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }

  .btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
  }

  /* Alert Styling */
  .alert-success {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 1px solid #86efac;
    color: #166534;
    border-radius: 12px;
    padding: 1rem 1.25rem;
  }

  .alert-danger {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    border: 1px solid #fecaca;
    color: #991b1b;
    border-radius: 12px;
    padding: 1rem 1.25rem;
  }

  /* DataTables Customization */
  #usersTable {
    width: 100% !important;
  }

  #usersTable thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem;
    border: none;
  }

  #usersTable tbody tr {
    transition: all 0.2s ease;
  }

  #usersTable tbody tr:hover {
    background: #f8fafc;
  }

  #usersTable tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #f0f2f5;
  }

  /* User Avatar */
  .user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
  }

  .user-avatar-initials {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
  }

  /* Role Badge */
  .role-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
    font-size: 0.6875rem;
    font-weight: 600;
    margin-right: 0.25rem;
  }

  /* Status Badge */
  .status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
  }

  .status-badge.active {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
  }

  .status-badge.suspended {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    color: #991b1b;
  }

  .status-badge.inactive {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    color: #4b5563;
  }

  /* Action Buttons */
  .action-dropdown .dropdown-toggle {
    background: #f1f5f9;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
  }

  .action-dropdown .dropdown-toggle:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
  }

  .action-dropdown .dropdown-menu {
    border: none;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    border-radius: 12px;
    padding: 0.5rem;
  }

  .action-dropdown .dropdown-item {
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }

  .action-dropdown .dropdown-item:hover {
    background: #f1f5f9;
  }

  .action-dropdown .dropdown-item.text-danger:hover {
    background: #fef2f2;
  }

  /* DataTables Filter */
  .dataTables_wrapper .dataTables_filter input {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
  }

  .dataTables_wrapper .dataTables_filter input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
    outline: none;
  }

  .dataTables_wrapper .dataTables_length select {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.375rem 2rem 0.375rem 0.75rem;
  }

  /* Loading State */
  #loadingMessage {
    padding: 3rem;
  }

  .spinner-border {
    width: 3rem;
    height: 3rem;
    border-width: 0.25rem;
  }

  /* Error Message */
  #errorMessage {
    border-radius: 12px;
    padding: 1.5rem;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .main-card .card-header {
      flex-direction: column;
      gap: 1rem;
    }
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <div class="d-flex align-items-center gap-3">
    <div class="header-icon">
      <i class="ri-user-settings-line"></i>
    </div>
    <div>
      <h4 class="mb-1">Users Management</h4>
      <p class="mb-0">Manage all users, their roles and permissions</p>
    </div>
  </div>
</div>

<!-- Main Card -->
<div class="card main-card">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h5 class="mb-1">All Users</h5>
      <p class="text-muted mb-0 small">View and manage user accounts</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-add">
      <i class="ri-add-line me-2"></i>Add New User
    </a>
  </div>
  <div class="card-body">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="table-responsive">
      <table class="table" id="usersTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Avatar</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Roles</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Data will be loaded via AJAX -->
        </tbody>
      </table>
    </div>

    <!-- Fallback loading message -->
    <div id="loadingMessage" class="text-center py-4" style="display: none;">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="mt-3 text-muted">Loading users...</p>
    </div>

    <!-- Error message -->
    <div id="errorMessage" class="alert alert-danger" style="display: none;">
      <div class="d-flex align-items-center">
        <i class="ri-error-warning-line me-3" style="font-size: 2rem;"></i>
        <div>
          <h6 class="mb-1">Error Loading Users</h6>
          <p id="errorText" class="mb-2"></p>
          <button class="btn btn-sm btn-outline-danger" onclick="location.reload()">
            <i class="ri-refresh-line me-1"></i>Retry
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
$(document).ready(function() {
    console.log('Initializing DataTable...');

    // Show loading message
    $('#loadingMessage').show();
    $('#usersTable').hide();

    $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.users.index') }}",
            type: 'GET',
            data: function(d) {
                console.log('DataTables AJAX Request Data:', d);
                return d;
            },
            dataSrc: function(json) {
                console.log('DataTables AJAX Response:', json);
                // Hide loading message and show table
                $('#loadingMessage').hide();
                $('#usersTable').show();
                return json.data;
            },
            error: function(xhr, error, thrown) {
                console.error('DataTables AJAX Error:', error);
                console.error('Response Status:', xhr.status);
                console.error('Response Text:', xhr.responseText);
                console.error('Thrown:', thrown);

                // Hide loading message and show error
                $('#loadingMessage').hide();
                $('#usersTable').hide();
                $('#errorText').text('Failed to load users data. Please check the console for details.');
                $('#errorMessage').show();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'avatar', name: 'avatar', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'roles', name: 'roles', orderable: false, searchable: false },
            { data: 'status_badge', name: 'status', orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        order: [[0, 'desc']],
        pageLength: 25,
        responsive: true,
        language: {
            processing: "<div class='spinner-border spinner-border-sm text-primary me-2'></div> Loading...",
            search: "<i class='ri-search-line me-2'></i>",
            searchPlaceholder: "Search users...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ users",
            infoEmpty: "No users found",
            infoFiltered: "(filtered from _MAX_ total users)",
            paginate: {
                first: "<i class='ri-arrow-left-double-line'></i>",
                last: "<i class='ri-arrow-right-double-line'></i>",
                next: "<i class='ri-arrow-right-s-line'></i>",
                previous: "<i class='ri-arrow-left-s-line'></i>"
            }
        },
        drawCallback: function(settings) {
            console.log('DataTable draw completed');
        },
        initComplete: function(settings, json) {
            console.log('DataTable initialization completed');
        }
    });

    console.log('DataTable initialized');

    // Set a timeout to show error if DataTables doesn't load within 10 seconds
    setTimeout(function() {
        if ($('#loadingMessage').is(':visible')) {
            $('#loadingMessage').hide();
            $('#usersTable').hide();
            $('#errorText').text('DataTables failed to load within 10 seconds. Please refresh the page.');
            $('#errorMessage').show();
        }
    }, 10000);
});
</script>
@endsection
