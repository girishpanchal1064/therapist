@extends('layouts/contentNavbarLayout')

@section('title', 'Pending Therapists Approval')

@section('page-style')
<style>
  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-top: 1.5rem;
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
    color: rgba(255, 255, 255, 0.9);
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

  .btn-back {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    text-decoration: none;
  }

  .btn-back:hover {
    background: white;
    color: #f59e0b;
    border-color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
  }

  /* Summary Card */
  .summary-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid #f59e0b;
  }

  .summary-card .summary-value {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .summary-card .summary-label {
    color: #64748b;
    font-size: 0.875rem;
    font-weight: 500;
    margin-top: 0.5rem;
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

  /* Therapist Card */
  .therapist-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    overflow: hidden;
    position: relative;
    margin-top: 20px;
    margin-bottom: 0.5rem;
    border-left: 4px solid #f59e0b;
    transition: all 0.3s ease;
  }

  .therapist-card:hover {
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.15);
    transform: translateY(-2px);
  }

  .therapist-card:nth-child(even) {
    background: #fafbfc;
  }

  .therapist-card .card-body {
    padding: 1rem 1.25rem;
  }

  .therapist-avatar {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid #e5e7eb;
  }

  .therapist-avatar-initials {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    border: 2px solid #e5e7eb;
  }

  .therapist-info {
    display: flex;
    flex-direction: column;
  }

  .therapist-name {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
  }

  .therapist-email {
    color: #64748b;
    font-size: 0.8125rem;
  }

  .spec-badge {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    margin-right: 0.375rem;
    margin-bottom: 0.25rem;
    display: inline-block;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .spec-badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
  }

  .exp-badge {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
  }

  .fee-badge {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    color: white;
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
  }

  .status-badge {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: #78350f;
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
  }

  .action-btns {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    flex-wrap: wrap;
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
    font-size: 0.95rem;
  }

  .btn-action:active {
    transform: translateY(1px);
  }

  .btn-action.view {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
  }

  .btn-action.approve {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
  }

  .btn-action.reject {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2);
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
  }

  .empty-state-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.5rem;
    color: #f59e0b;
  }

  .empty-state h5 {
    color: #1e293b;
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  .empty-state p {
    color: #64748b;
  }

  /* Pagination */
  .pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
  }

  .pagination-info {
    color: #64748b;
    font-size: 0.875rem;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .therapist-card .row {
      flex-wrap: wrap;
    }
    
    .action-btns {
      width: 100%;
      justify-content: flex-start;
      margin-top: 0.5rem;
    }
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="d-flex align-items-center gap-3">
      <div class="header-icon">
        <i class="ri-time-line"></i>
      </div>
      <div>
        <h4 class="mb-1">Pending Therapists Approval</h4>
        <p class="mb-0">Review and approve therapist applications</p>
      </div>
    </div>
    <a href="{{ route('admin.therapists.index') }}" class="btn-back">
      <i class="ri-arrow-left-line me-2"></i>Back to All Therapists
    </a>
  </div>
</div>

<!-- Summary Card -->
<div class="summary-card">
  <div class="d-flex align-items-center justify-content-between">
    <div>
      <div class="summary-value">{{ $therapists->total() }}</div>
      <div class="summary-label">Pending Approval Requests</div>
    </div>
    <div class="text-end">
      <i class="ri-user-search-line" style="font-size: 3rem; color: #fbbf24; opacity: 0.3;"></i>
    </div>
  </div>
</div>

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

<!-- Main Card -->
<div class="card main-card">
  <div class="card-header">
    <h5 class="mb-0">Pending Therapists</h5>
  </div>
  <div class="card-body">
    @if($therapists->count() > 0)
      @foreach($therapists as $therapist)
        <div class="card therapist-card">
          <div class="card-body">
            <div class="row align-items-center">
              <!-- Avatar -->
              <div class="col-lg-1 col-md-2 col-3">
                @if($therapist->avatar)
                  <img src="{{ asset('storage/' . $therapist->avatar) }}" alt="{{ $therapist->name }}" class="therapist-avatar">
                @else
                  <div class="therapist-avatar-initials">
                    {{ strtoupper(substr($therapist->name, 0, 2)) }}
                  </div>
                @endif
              </div>

              <!-- Name & Email -->
              <div class="col-lg-2 col-md-3 col-9">
                <div class="therapist-info">
                  <div class="therapist-name">{{ $therapist->name }}</div>
                  <div class="therapist-email">{{ $therapist->email }}</div>
                </div>
              </div>

              <!-- Phone -->
              <div class="col-lg-1 col-md-2">
                <div class="text-muted small">
                  <i class="ri-phone-line me-1"></i>
                  {{ $therapist->phone ?: 'N/A' }}
                </div>
              </div>

              <!-- Specializations -->
              <div class="col-lg-2 col-md-3">
                @if($therapist->therapistProfile && $therapist->therapistProfile->specializations->count() > 0)
                  @foreach($therapist->therapistProfile->specializations->take(2) as $specialization)
                    <span class="spec-badge">{{ $specialization->name }}</span>
                  @endforeach
                  @if($therapist->therapistProfile->specializations->count() > 2)
                    <span class="spec-badge">+{{ $therapist->therapistProfile->specializations->count() - 2 }}</span>
                  @endif
                @else
                  <span class="text-muted small">No specializations</span>
                @endif
              </div>

              <!-- Experience -->
              <div class="col-lg-1 col-md-2">
                @if($therapist->therapistProfile && $therapist->therapistProfile->experience_years)
                  <span class="exp-badge">
                    <i class="ri-star-line me-1"></i>{{ $therapist->therapistProfile->experience_years }} yrs
                  </span>
                @else
                  <span class="text-muted small">N/A</span>
                @endif
              </div>

              <!-- Rate -->
              <div class="col-lg-1 col-md-2">
                @if($therapist->therapistProfile && $therapist->therapistProfile->consultation_fee)
                  <span class="fee-badge">
                    ₹{{ number_format($therapist->therapistProfile->consultation_fee, 0) }}
                  </span>
                @else
                  <span class="text-muted small">N/A</span>
                @endif
              </div>

              <!-- Status -->
              <div class="col-lg-1 col-md-2">
                <span class="status-badge">
                  <i class="ri-time-line"></i>Pending
                </span>
              </div>

              <!-- Created Date -->
              <div class="col-lg-1 col-md-2">
                <div class="text-muted small">
                  {{ $therapist->created_at->format('M d, Y') }}
                </div>
              </div>

              <!-- Actions -->
              <div class="col-lg-2 col-md-12">
                <div class="action-btns">
                  <a href="{{ route('admin.therapists.show', $therapist) }}" class="btn-action view" title="View Details">
                    <i class="ri-eye-line"></i>
                  </a>
                  <form action="{{ route('admin.therapists.approve', $therapist) }}" method="POST" class="d-inline approve-form" data-title="Approve Therapist" data-text="Are you sure you want to approve this therapist?">
                    @csrf
                    <button type="submit" class="btn-action approve" title="Approve">
                      <i class="ri-check-line"></i>
                    </button>
                  </form>
                  <form action="{{ route('admin.therapists.reject', $therapist) }}" method="POST" class="d-inline reject-form" data-title="Reject Therapist" data-text="Are you sure you want to reject this therapist? This action cannot be undone.">
                    @csrf
                    <button type="submit" class="btn-action reject" title="Reject">
                      <i class="ri-close-line"></i>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach

      <!-- Pagination -->
      @if($therapists->hasPages())
        <div class="pagination-wrapper">
          <div class="pagination-info">
            Showing <strong>{{ $therapists->firstItem() }}</strong> to <strong>{{ $therapists->lastItem() }}</strong> 
            of <strong>{{ $therapists->total() }}</strong> pending therapists
          </div>
          <div>
            {{ $therapists->links() }}
          </div>
        </div>
      @endif
    @else
      <div class="empty-state">
        <div class="empty-state-icon">
          <i class="ri-checkbox-circle-line"></i>
        </div>
        <h5>No Pending Therapists</h5>
        <p>All therapist applications have been reviewed. Great job!</p>
        <a href="{{ route('admin.therapists.index') }}" class="btn btn-primary mt-3">
          <i class="ri-arrow-left-line me-2"></i>View All Therapists
        </a>
      </div>
    @endif
  </div>
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Handle approve form submission
  document.querySelectorAll('.approve-form').forEach(function(form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const title = this.getAttribute('data-title') || 'Approve Therapist';
      const text = this.getAttribute('data-text') || 'Are you sure you want to approve this therapist?';
      
      if (confirm(text)) {
        this.submit();
      }
    });
  });

  // Handle reject form submission
  document.querySelectorAll('.reject-form').forEach(function(form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const title = this.getAttribute('data-title') || 'Reject Therapist';
      const text = this.getAttribute('data-text') || 'Are you sure you want to reject this therapist? This action cannot be undone.';
      
      if (confirm(text)) {
        this.submit();
      }
    });
  });
});
</script>
@endsection
