@extends('layouts/contentNavbarLayout')

@section('title', 'Permissions Management')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Permissions Management</h5>
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
          <i class="ri-add-line me-2"></i>Add New Permission
        </a>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="table-responsive">
          <table class="table table-hover" id="permissionsTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Permission Name</th>
                <th>Description</th>
                <th>Roles Count</th>
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
  </div>
</div>
@endsection

@section('page-script')
<script>
$(document).ready(function() {
    $('#permissionsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.permissions.index') }}",
            type: 'GET'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'permission_name', name: 'name', orderable: false, searchable: false },
            { data: 'description', name: 'description', orderable: false, searchable: false },
            { data: 'roles_count', name: 'roles_count', orderable: false, searchable: false },
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
        }
    });
});
</script>
@endsection
