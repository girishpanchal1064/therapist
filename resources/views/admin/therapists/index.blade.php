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

  /* Table Styling */
  #therapistsTable {
    width: 100% !important;
  }

  #therapistsTable thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem;
    border: none;
  }

  #therapistsTable tbody tr {
    transition: all 0.2s ease;
  }

  #therapistsTable tbody tr:hover {
    background: #f8fafc;
  }

  #therapistsTable tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #f0f2f5;
  }

  /* Therapist Avatar */
  .therapist-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
  }

  .therapist-avatar-initials {
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

  /* Specialization Badge */
  .spec-badge {
    background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    color: #0369a1;
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
    font-size: 0.6875rem;
    font-weight: 600;
    margin-right: 0.25rem;
    margin-bottom: 0.25rem;
    display: inline-block;
  }

  /* Info Badge */
  .info-badge {
    background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
    color: #4338ca;
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
  }

  .rate-badge {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
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

  /* Action Dropdown */
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

  /* Pagination */
  .pagination {
    gap: 0.25rem;
  }

  .page-link {
    border: none;
    border-radius: 8px !important;
    padding: 0.5rem 0.875rem;
    color: #4a5568;
    transition: all 0.2s ease;
  }

  .page-link:hover {
    background: #f1f5f9;
    color: #667eea;
  }

  .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
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
      <i class="ri-user-heart-line"></i>
    </div>
    <div>
      <h4 class="mb-1">Therapists Management</h4>
      <p class="mb-0">Manage therapist profiles, specializations and availability</p>
    </div>
  </div>
</div>

<!-- Main Card -->
<div class="card main-card">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h5 class="mb-1">All Therapists</h5>
      <p class="text-muted mb-0 small">View and manage therapist accounts</p>
    </div>
    <a href="{{ route('admin.therapists.create') }}" class="btn btn-add">
      <i class="ri-add-line me-2"></i>Add New Therapist
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
      <table class="table" id="therapistsTable">
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
                  <img src="{{ asset('storage/' . $therapist->avatar) }}" alt="Avatar" class="therapist-avatar">
                @else
                  <div class="therapist-avatar-initials">
                    {{ strtoupper(substr($therapist->name, 0, 2)) }}
                  </div>
                @endif
              </td>
              <td>
                <div class="fw-semibold">{{ $therapist->name }}</div>
              </td>
              <td>
                <span class="text-muted">{{ $therapist->email }}</span>
              </td>
              <td>{{ $therapist->phone ?: 'Not set' }}</td>
              <td>
                @if($therapist->therapistProfile && $therapist->therapistProfile->specializations->count() > 0)
                  <div style="max-width: 200px;">
                    @foreach($therapist->therapistProfile->specializations->take(3) as $specialization)
                      <span class="spec-badge">{{ $specialization->name }}</span>
                    @endforeach
                    @if($therapist->therapistProfile->specializations->count() > 3)
                      <span class="spec-badge">+{{ $therapist->therapistProfile->specializations->count() - 3 }}</span>
                    @endif
                  </div>
                @else
                  <span class="text-muted small">No specializations</span>
                @endif
              </td>
              <td>
                @if($therapist->therapistProfile)
                  <span class="info-badge">
                    <i class="ri-briefcase-line me-1"></i>{{ $therapist->therapistProfile->experience_years }} yrs
                  </span>
                @else
                  <span class="text-muted small">Not set</span>
                @endif
              </td>
              <td>
                @if($therapist->therapistProfile)
                  <span class="rate-badge">
                    <i class="ri-money-dollar-circle-line me-1"></i>${{ number_format($therapist->therapistProfile->hourly_rate, 0) }}/hr
                  </span>
                @else
                  <span class="text-muted small">Not set</span>
                @endif
              </td>
              <td>
                <span class="status-badge {{ $therapist->status ?? 'inactive' }}">
                  {{ ucfirst($therapist->status ?: 'inactive') }}
                </span>
              </td>
              <td>
                <span class="text-muted">{{ $therapist->created_at->format('M d, Y') }}</span>
              </td>
              <td>
                <div class="dropdown action-dropdown">
                  <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="ri-more-2-line"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('admin.therapists.show', $therapist) }}">
                      <i class="ri-eye-line me-2 text-primary"></i> View Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.therapists.edit', $therapist) }}">
                      <i class="ri-pencil-line me-2 text-info"></i> Edit
                    </a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('admin.therapists.destroy', $therapist) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this therapist?')">
                        <i class="ri-delete-bin-line me-2"></i> Delete
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
@endsection

@section('page-script')
<script>
$(document).ready(function() {
    $('#therapistsTable').DataTable({
        processing: true,
        paging: false,
        searching: true,
        ordering: true,
        info: false,
        responsive: true,
        language: {
            processing: "<div class='spinner-border spinner-border-sm text-primary me-2'></div> Loading...",
            search: "<i class='ri-search-line me-2'></i>",
            searchPlaceholder: "Search therapists..."
        }
    });
});
</script>
@endsection
