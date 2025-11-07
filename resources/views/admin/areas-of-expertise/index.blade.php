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

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Areas of Expertise Management</h5>
        <a href="{{ route('admin.areas-of-expertise.create') }}" class="btn btn-primary">
          <i class="ri-add-line me-2"></i>Add New Area
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
          <table class="table table-hover" id="areasTable">
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
              @foreach($areas as $area)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $area->name }}</td>
                  <td><code>{{ $area->slug }}</code></td>
                  <td>{{ Str::limit($area->description, 50) ?: 'N/A' }}</td>
                  <td>{{ $area->icon ?: 'N/A' }}</td>
                  <td>{{ $area->sort_order }}</td>
                  <td>
                    <span class="badge bg-{{ $area->is_active ? 'success' : 'secondary' }}">
                      {{ $area->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>{{ $area->created_at->format('M d, Y') }}</td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="ri-more-2-line"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.areas-of-expertise.show', $area) }}">
                          <i class="ri-eye-line me-1"></i> View
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.areas-of-expertise.edit', $area) }}">
                          <i class="ri-pencil-line me-1"></i> Edit
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('admin.areas-of-expertise.destroy', $area) }}" method="POST" class="d-inline">
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
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
          {{ $areas->links() }}
        </div>
      </div>
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
