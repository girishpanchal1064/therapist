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

  /* Table Styling - Enhanced */
  #therapistsTable {
    width: 100% !important;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  }

  #therapistsTable thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 18px 20px;
    border: none;
    white-space: nowrap;
    position: relative;
  }

  #therapistsTable thead th:first-child {
    border-radius: 12px 0 0 0;
  }

  #therapistsTable thead th:last-child {
    border-radius: 0 12px 0 0;
  }

  #therapistsTable tbody tr {
    transition: all 0.3s ease;
    background: white;
    border-bottom: 1px solid #f0f2f5;
  }

  #therapistsTable tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.04) 0%, rgba(118, 75, 162, 0.04) 100%);
    transform: scale(1.001);
    box-shadow: 0 2px 12px rgba(102, 126, 234, 0.08);
  }

  #therapistsTable tbody tr:last-child {
    border-bottom: none;
  }

  #therapistsTable tbody td {
    padding: 18px 20px;
    vertical-align: middle;
    color: #2d3748;
    font-size: 0.9rem;
    border-bottom: 1px solid #f0f2f5;
  }

  #therapistsTable tbody tr:last-child td {
    border-bottom: none;
  }

  /* Therapist Avatar */
  .therapist-avatar {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }

  .therapist-avatar-default {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
  }

  .therapist-avatar-initials {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
  }

  /* Specialization Badge */
  .spec-badge {
    background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    color: #0369a1;
    padding: 0.3rem 0.65rem;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-right: 0.25rem;
    margin-bottom: 0.25rem;
    display: inline-block;
    border: 1px solid rgba(3, 105, 161, 0.1);
  }

  /* Experience Badge */
  .exp-badge {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
    padding: 0.5rem 0.875rem;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    border: 1px solid rgba(30, 64, 175, 0.15);
    box-shadow: 0 2px 6px rgba(30, 64, 175, 0.1);
  }

  .exp-badge i {
    font-size: 0.9rem;
    color: #3b82f6;
  }

  /* Fee Badge */
  .fee-badge {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #166534;
    padding: 0.5rem 0.875rem;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    border: 1px solid rgba(22, 101, 52, 0.15);
    box-shadow: 0 2px 6px rgba(22, 101, 52, 0.1);
  }

  .fee-badge i {
    font-size: 0.9rem;
    color: #22c55e;
  }

  /* Not Set Badge */
  .not-set-badge {
    background: #f3f4f6;
    color: #6b7280;
    padding: 0.4rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 500;
    font-style: italic;
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

  /* Modern Action Buttons */
  .action-btns {
    display: flex;
    gap: 0.5rem;
    align-items: center;
  }

  .btn-action {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
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

  /* Action Dropdown - Fallback */
  .action-dropdown .dropdown-toggle {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
  }

  .action-dropdown .dropdown-toggle:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
  }

  .action-dropdown .dropdown-menu {
    border: none;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    border-radius: 12px;
    padding: 0.5rem;
    min-width: 180px;
  }

  .action-dropdown .dropdown-item {
    border-radius: 8px;
    padding: 0.625rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
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
            <th>Fee</th>
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
                @if($therapist->therapistProfile && $therapist->therapistProfile->profile_image)
                  <img src="{{ asset('storage/' . $therapist->therapistProfile->profile_image) }}" alt="Avatar" class="therapist-avatar">
                @elseif($therapist->avatar)
                  <img src="{{ asset('storage/' . $therapist->avatar) }}" alt="Avatar" class="therapist-avatar">
                @else
                  <img src="https://ui-avatars.com/api/?name={{ urlencode($therapist->name) }}&background=667eea&color=fff&size=96&bold=true&format=svg" alt="Avatar" class="therapist-avatar-default">
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
                @if($therapist->therapistProfile && $therapist->therapistProfile->experience_years)
                  <span class="exp-badge">
                    <i class="ri-award-line"></i>{{ $therapist->therapistProfile->experience_years }} Years
                  </span>
                @else
                  <span class="not-set-badge">Not set</span>
                @endif
              </td>
              <td>
                @if($therapist->therapistProfile && $therapist->therapistProfile->consultation_fee)
                  <span class="fee-badge">
                    <i class="ri-money-rupee-circle-line"></i>₹{{ number_format($therapist->therapistProfile->consultation_fee, 0) }}
                  </span>
                @else
                  <span class="not-set-badge">Not set</span>
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
                <div class="action-btns">
                  <a href="{{ route('admin.therapists.show', $therapist) }}" class="btn-action view" title="View Profile">
                    <i class="ri-eye-line"></i>
                  </a>
                  <a href="{{ route('admin.therapists.edit', $therapist) }}" class="btn-action edit" title="Edit">
                    <i class="ri-pencil-line"></i>
                  </a>
                  <form action="{{ route('admin.therapists.destroy', $therapist) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action delete" title="Delete" onclick="return confirm('Are you sure you want to delete this therapist?')">
                      <i class="ri-delete-bin-line"></i>
                    </button>
                  </form>
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
