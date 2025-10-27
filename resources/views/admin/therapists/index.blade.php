@extends('layouts/contentNavbarLayout')

@section('title', 'Therapists Management')

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
        <h5 class="card-title mb-0">Therapists Management</h5>
        <a href="{{ route('admin.therapists.create') }}" class="btn btn-primary">
          <i class="ri-add-line me-2"></i>Add New Therapist
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
          <table class="table table-hover" id="therapistsTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Avatar</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Specializations</th>
                <th>Experience</th>
                <th>Rate</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($therapists as $therapist)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    @if($therapist->avatar)
                      <div class="avatar avatar-sm me-2">
                        <img src="{{ asset('storage/' . $therapist->avatar) }}" alt="Avatar" class="rounded-circle" width="32" height="32">
                      </div>
                    @else
                      <div class="avatar avatar-sm me-2">
                        <span class="avatar-initial rounded bg-label-primary">{{ strtoupper(substr($therapist->name, 0, 2)) }}</span>
                      </div>
                    @endif
                  </td>
                  <td>{{ $therapist->name }}</td>
                  <td>{{ $therapist->email }}</td>
                  <td>{{ $therapist->phone ?: 'Not set' }}</td>
                  <td>
                    @if($therapist->therapistProfile && $therapist->therapistProfile->specializations->count() > 0)
                      @foreach($therapist->therapistProfile->specializations as $specialization)
                        <span class="badge bg-info me-1">{{ $specialization->name }}</span>
                      @endforeach
                    @else
                      <span class="text-muted">No specializations</span>
                    @endif
                  </td>
                  <td>
                    @if($therapist->therapistProfile)
                      {{ $therapist->therapistProfile->experience_years }} years
                    @else
                      <span class="text-muted">Not set</span>
                    @endif
                  </td>
                  <td>
                    @if($therapist->therapistProfile)
                      ${{ number_format($therapist->therapistProfile->hourly_rate, 2) }}/hr
                    @else
                      <span class="text-muted">Not set</span>
                    @endif
                  </td>
                  <td>
                    <span class="badge bg-{{ $therapist->status === 'active' ? 'success' : ($therapist->status === 'suspended' ? 'danger' : 'secondary') }}">
                      {{ ucfirst($therapist->status ?: 'inactive') }}
                    </span>
                  </td>
                  <td>{{ $therapist->created_at->format('M d, Y') }}</td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="ri-more-2-line"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.therapists.show', $therapist) }}">
                          <i class="ri-eye-line me-1"></i> View
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.therapists.edit', $therapist) }}">
                          <i class="ri-pencil-line me-1"></i> Edit
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('admin.therapists.destroy', $therapist) }}" method="POST" class="d-inline">
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
          {{ $therapists->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
$(document).ready(function() {
    $('#therapistsTable').DataTable({
        processing: true,
        paging: false, // Disable DataTables pagination since we're using Laravel pagination
        searching: true,
        ordering: true,
        info: false,
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
