@extends('layouts/contentNavbarLayout')

@section('title', 'Pending Therapists Approval')

@section('page-style')
<style>
  .layout-page .content-wrapper {
    background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important;
  }

  .summary-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: var(--apni-shadow-gulf-05, 0 8px 24px rgb(4 28 84 / 0.05));
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(186, 194, 210, 0.35);
    border-left: 4px solid var(--apni-gulf-blue, #041c54);
  }

  .summary-card .summary-value {
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--apni-gulf-blue, #041c54);
    font-family: var(--apni-font-display, 'Sora', sans-serif);
  }

  .summary-card .summary-label {
    color: var(--apni-bermuda-gray, #7484a4);
    font-size: 0.875rem;
    font-weight: 500;
    margin-top: 0.25rem;
  }

  .btn-back {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.6rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
  }

  .btn-back:hover {
    background: white;
    color: var(--apni-gulf-blue, #041c54);
    border-color: white;
  }

  .therapist-card {
    background: white;
    border: 1px solid rgba(186, 194, 210, 0.35);
    border-radius: 12px;
    box-shadow: 0 6px 10px rgba(4, 28, 84, 0.06), 0 2px 4px rgba(4, 28, 84, 0.04);
    margin-top: 1rem;
    border-left: 4px solid var(--apni-warning, #f59e0b);
  }

  .therapist-card:nth-child(even) {
    background: #fafbfc;
  }

  .therapist-card .card-body {
    padding: 0.875rem 1rem;
  }

  .pending-row {
    display: grid;
    grid-template-columns: minmax(0, 2fr) minmax(110px, 1fr) minmax(140px, 1.2fr) auto auto minmax(100px, auto) auto;
    gap: 0.75rem 1rem;
    align-items: center;
  }

  @media (max-width: 1199px) {
    .pending-row {
      grid-template-columns: 1fr 1fr;
    }
    .pending-row__identity { grid-column: 1 / -1; }
    .pending-row__actions { grid-column: 1 / -1; justify-content: flex-start; }
  }

  @media (max-width: 575px) {
    .pending-row {
      grid-template-columns: 1fr;
    }
  }

  .pending-row__identity {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    min-width: 0;
  }

  .therapist-avatar,
  .therapist-avatar-default {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
    flex-shrink: 0;
    border: 2px solid rgba(186, 194, 210, 0.4);
  }

  .therapist-avatar-default {
    background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
  }

  .therapist-name {
    font-weight: 600;
    color: var(--apni-gulf-blue, #041c54);
    font-size: 0.875rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 0.125rem;
  }

  .therapist-email {
    color: var(--apni-bermuda-gray, #7484a4);
    font-size: 0.75rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .pending-row__phone {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.8125rem;
    color: var(--apni-lynch, #647494);
    white-space: nowrap;
  }

  .pending-row__phone i {
    color: var(--apni-bermuda-gray, #7484a4);
    flex-shrink: 0;
  }

  .pending-row__specs {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
    align-items: center;
    min-width: 0;
  }

  .spec-badge {
    background: var(--apni-lynch-10, rgba(100, 116, 148, 0.1));
    color: var(--apni-gulf-blue, #041c54);
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    white-space: nowrap;
    border: 1px solid var(--apni-lynch-20, rgba(100, 116, 148, 0.2));
  }

  .spec-badge.more {
    background: linear-gradient(90deg, #041c54 0%, #647494 100%);
    color: #fff;
    border-color: transparent;
  }

  .exp-badge,
  .fee-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.35rem 0.6rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
    flex-shrink: 0;
  }

  .exp-badge {
    background: var(--apni-lynch-10, rgba(100, 116, 148, 0.1));
    color: #334155;
    border: 1px solid var(--apni-lynch-20, rgba(100, 116, 148, 0.2));
  }

  .exp-badge i {
    font-size: 0.85rem;
    color: var(--apni-lynch, #647494);
  }

  .fee-badge {
    background: var(--apni-success-soft, #10b98115);
    color: #047857;
    border: 1px solid rgba(16, 185, 129, 0.2);
  }

  .pending-row__meta {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 0.35rem;
    min-width: 0;
  }

  .status-badge.pending {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.65rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
    background: var(--apni-warning-soft, #f59e0b15);
    color: #b45309;
    border: 1px solid rgba(245, 158, 11, 0.25);
  }

  .pending-date {
    font-size: 0.75rem;
    color: var(--apni-bermuda-gray, #7484a4);
    white-space: nowrap;
  }

  .pending-row__actions {
    display: flex;
    gap: 0.4rem;
    align-items: center;
    justify-content: flex-end;
  }

  .btn-action {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
    text-decoration: none;
    flex-shrink: 0;
  }

  .btn-action.view {
    background: var(--apni-gulf-blue, #041c54);
    color: #fff;
  }

  .btn-action.approve {
    background: var(--apni-success, #10b981);
    color: #fff;
  }

  .btn-action.reject {
    background: var(--apni-danger, #ef4444);
    color: #fff;
  }

  .text-muted-small {
    font-size: 0.75rem;
    color: var(--apni-bermuda-gray, #7484a4);
  }

  .empty-state {
    text-align: center;
    padding: 3rem 2rem;
  }

  .empty-state-icon {
    width: 80px;
    height: 80px;
    background: var(--apni-success-soft, #10b98115);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2rem;
    color: var(--apni-success, #10b981);
  }

  .pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(186, 194, 210, 0.35);
  }

  .pagination-info {
    color: var(--apni-bermuda-gray, #7484a4);
    font-size: 0.875rem;
  }
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="d-flex align-items-center gap-3">
      <div class="header-icon" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #fff;">
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

<div class="summary-card">
  <div class="d-flex align-items-center justify-content-between">
    <div>
      <div class="summary-value">{{ $therapists->total() }}</div>
      <div class="summary-label">Pending approval requests</div>
    </div>
    <i class="ri-user-search-line" style="font-size: 2.5rem; color: var(--apni-heather, #bac2d2); opacity: 0.6;"></i>
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

<div class="card main-card">
  <div class="card-header">
    <h5 class="mb-0" style="color: var(--apni-gulf-blue, #041c54); font-weight: 700;">Pending Therapists</h5>
  </div>
  <div class="card-body">
    @if($therapists->count() > 0)
      @foreach($therapists as $therapist)
        <div class="card therapist-card">
          <div class="card-body">
            <div class="pending-row">
              <div class="pending-row__identity">
                <img src="{{ $therapist->avatar }}" alt="{{ $therapist->name }}" class="therapist-avatar">
                <div class="min-width-0">
                  <div class="therapist-name">{{ $therapist->name }}</div>
                  <div class="therapist-email">{{ $therapist->email }}</div>
                </div>
              </div>

              <div class="pending-row__phone">
                <i class="ri-phone-line"></i>
                <span>{{ $therapist->phone ?: '—' }}</span>
              </div>

              <div class="pending-row__specs">
                @if($profile && $profile->specializations->count() > 0)
                  @foreach($profile->specializations->take(1) as $specialization)
                    <span class="spec-badge">{{ Str::limit($specialization->name, 20) }}</span>
                  @endforeach
                  @if($profile->specializations->count() > 1)
                    <span class="spec-badge more">+{{ $profile->specializations->count() - 1 }}</span>
                  @endif
                @else
                  <span class="text-muted-small">No specializations</span>
                @endif
              </div>

              <div>
                @if($profile && $profile->experience_years)
                  <span class="exp-badge">
                    <i class="ri-award-line"></i>{{ $profile->experience_years }} yrs
                  </span>
                @else
                  <span class="text-muted-small">—</span>
                @endif
              </div>

              <div>
                @if($profile)
                  <span class="fee-badge">
                    <i class="ri-money-rupee-circle-line"></i>₹{{ number_format($profile->consultation_fee ?? 0, 0) }}
                  </span>
                @else
                  <span class="text-muted-small">—</span>
                @endif
              </div>

              <div class="pending-row__meta">
                <span class="status-badge pending">
                  <i class="ri-time-line"></i>Pending
                </span>
                <span class="pending-date">{{ $therapist->created_at->format('M d, Y') }}</span>
              </div>

              <div class="pending-row__actions">
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
      @endforeach

      @if($therapists->hasPages())
        <div class="pagination-wrapper">
          <div class="pagination-info">
            Showing <strong>{{ $therapists->firstItem() }}</strong> to <strong>{{ $therapists->lastItem() }}</strong>
            of <strong>{{ $therapists->total() }}</strong> pending therapists
          </div>
          <div>{{ $therapists->links() }}</div>
        </div>
      @endif
    @else
      <div class="empty-state">
        <div class="empty-state-icon">
          <i class="ri-checkbox-circle-line"></i>
        </div>
        <h5>No Pending Therapists</h5>
        <p class="text-muted">All therapist applications have been reviewed.</p>
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
  document.querySelectorAll('.approve-form').forEach(function(form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const text = this.getAttribute('data-text') || 'Are you sure you want to approve this therapist?';
      ApniSwal.confirm({
        title: this.getAttribute('data-title') || 'Approve Therapist',
        text: text,
        confirmButtonText: 'Yes, approve',
        customClass: { confirmButton: 'btn btn-success' },
      }).then((result) => {
        if (result.isConfirmed) this.submit();
      });
    });
  });

  document.querySelectorAll('.reject-form').forEach(function(form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const text = this.getAttribute('data-text') || 'Are you sure you want to reject this therapist?';
      ApniSwal.confirm({
        title: this.getAttribute('data-title') || 'Reject Therapist',
        text: text,
        confirmButtonText: 'Yes, reject',
      }).then((result) => {
        if (result.isConfirmed) this.submit();
      });
    });
  });
});
</script>
@endsection
