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

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Users Management</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
          <i class="ri-add-line me-2"></i>Add New User
        </a>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="table-responsive">
          <table class="table table-hover" id="usersTable">
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
          <p class="mt-2">Loading users...</p>
        </div>

        <!-- Error message -->
        <div id="errorMessage" class="alert alert-danger" style="display: none;">
          <h6>Error Loading Users</h6>
          <p id="errorText"></p>
          <button class="btn btn-sm btn-outline-danger" onclick="location.reload()">Retry</button>
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
            processing: "Loading...",
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        drawCallback: function(settings) {
            console.log('DataTable draw completed');
            console.log('Data:', settings.json);
        },
        initComplete: function(settings, json) {
            console.log('DataTable initialization completed');
            console.log('Initial data:', json);
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
