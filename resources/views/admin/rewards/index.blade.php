@extends('layouts/contentNavbarLayout')

@section('title', 'Rewards Management')

@section('page-style')
<style>
  .layout-page .content-wrapper {
    background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important;
  }

  /* Page Header */
  .page-header {
    background: linear-gradient(90deg, #041C54 0%, #2f4a76 55%, #647494 100%);
    border-radius: 24px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 18px rgba(4, 28, 84, 0.28);
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
    border: 1px solid rgba(186, 194, 210, 0.35);
    border-radius: 16px;
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    overflow: hidden;
  }

  .main-card .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
    border-bottom: 1px solid rgba(186, 194, 210, 0.35);
    padding: 1.5rem;
  }

  .main-card .card-body {
    padding: 1.5rem;
  }

  /* Add Button */
  .btn-add {
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 8px 14px rgba(4, 28, 84, 0.2);
  }

  .btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 18px rgba(4, 28, 84, 0.28);
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

  /* Table Styling */
  .rewards-table-wrap {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  #rewardsTable {
    width: 100% !important;
    min-width: 1180px;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  }

  #rewardsTable th.cell-nowrap,
  #rewardsTable td.cell-nowrap {
    white-space: nowrap;
    width: 1%;
  }

  #rewardsTable th.col-actions,
  #rewardsTable td.col-actions {
    width: 72px;
    min-width: 72px;
    text-align: center;
  }

  #rewardsTable thead th {
    background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
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

  #rewardsTable thead th:first-child {
    border-radius: 12px 0 0 0;
  }

  #rewardsTable thead th:last-child {
    border-radius: 0 12px 0 0;
  }

  #rewardsTable tbody td {
    padding: 18px 20px;
    border-bottom: 1px solid #f0f2f5;
    vertical-align: middle;
    color: #4a5568;
    font-size: 0.9rem;
  }

  #rewardsTable tbody tr:last-child td {
    border-bottom: none;
  }

  #rewardsTable tbody tr {
    background: white;
  }

  /* Action Buttons */
  .btn-action-view {
    background: rgba(100, 116, 148, 0.15);
    color: #041C54;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-action-view:hover {
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    color: white;
  }

  .btn-action-edit {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-action-delete {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .reward-code-pill {
    display: inline-flex;
    align-items: center;
    background: rgba(239, 68, 68, 0.1);
    color: #b91c1c;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    white-space: nowrap;
    flex-shrink: 0;
    line-height: 1.2;
    border: 1px solid rgba(239, 68, 68, 0.2);
  }

  .badge-discount {
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    color: white;
    padding: 0.4rem 0.85rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
    flex-shrink: 0;
    line-height: 1.2;
  }

  .reward-status-pill {
    display: inline-flex;
    align-items: center;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
    flex-shrink: 0;
    line-height: 1.2;
  }

  .reward-status-pill.active {
    background: rgba(16, 185, 129, 0.15);
    color: #059669;
  }

  .reward-status-pill.expired {
    background: rgba(239, 68, 68, 0.12);
    color: #dc2626;
  }

  .reward-status-pill.inactive {
    background: rgba(100, 116, 148, 0.15);
    color: #647494;
  }

  .reward-desc-cell {
    max-width: 180px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #64748b;
    font-size: 0.85rem;
  }

  .reward-actions-dropdown .btn-actions-toggle {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    color: #475569;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
  }

  .reward-actions-dropdown .btn-actions-toggle:hover {
    background: #041c54;
    border-color: #041c54;
    color: #fff;
  }

  .reward-actions-dropdown .dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  /* Filter Card */
  .filter-card {
    border-radius: 16px;
    border: 1px solid rgba(186, 194, 210, 0.35);
    background: white;
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    margin-bottom: 1.5rem;
  }
  .filter-card .card-body {
    padding: 1rem 24px 24px 24px;
  }
  .filter-card .filter-title {
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    cursor: pointer;
    padding-bottom: 16px;
    border-bottom: 1px solid #e9ecef;
    margin-bottom: 20px;
  }
  .filter-icon-wrapper {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    color: white;
    font-size: 1rem;
  }
  .btn-filter-toggle {
    background: transparent;
    border: 2px solid #e4e6eb;
    border-radius: 8px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #647494;
    transition: all 0.3s ease;
    cursor: pointer;
  }
  .btn-filter-toggle:hover {
    background: rgba(100, 116, 148, 0.1);
    border-color: #647494;
  }
  .btn-filter-toggle i {
    font-size: 1.2rem;
    transition: transform 0.3s ease;
  }
  .btn-filter-toggle.active i {
    transform: rotate(180deg);
  }
  .filter-content {
    overflow: hidden;
    transition: all 0.3s ease;
  }
  .filter-content.collapsed {
    max-height: 0;
    margin-top: 0;
    opacity: 0;
    padding-top: 0;
  }
  .filter-content:not(.collapsed) {
    max-height: 1000px;
    opacity: 1;
  }
  .filter-card .form-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    color: #8e9baa;
    margin-bottom: 6px;
  }
  .filter-card .form-control,
  .filter-card .form-select {
    border-radius: 10px;
    border: 1px solid #e4e6eb;
    padding: 10px 14px;
    transition: all 0.2s ease;
  }
  .filter-card .form-control:focus,
  .filter-card .form-select:focus {
    border-color: #647494;
    box-shadow: 0 0 0 3px rgba(100, 116, 148, 0.12);
  }
  .filter-card .input-group {
    border-radius: 10px;
    border: 1px solid #e4e6eb;
    overflow: hidden;
  }
  .filter-card .input-group-text {
    background: #f8f9fa;
    border: none;
    color: #647494;
    padding: 10px 14px;
  }
  .filter-card .input-group .form-control {
    border: none;
    padding-left: 0;
  }
  .filter-card .input-group:focus-within {
    border-color: #647494;
    box-shadow: 0 0 0 3px rgba(100, 116, 148, 0.12);
  }
  .btn-apply-filter {
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    border: none;
    color: white;
    padding: 10px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 8px 14px rgba(4, 28, 84, 0.2);
  }
  .btn-apply-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 18px rgba(4, 28, 84, 0.28);
    color: white;
  }
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
    <div class="d-flex align-items-center gap-3">
      <div class="header-icon">
        <i class="ri-gift-line"></i>
      </div>
      <div>
        <h4 class="mb-1">Rewards Management</h4>
        <p class="mb-0">Manage rewards, offers, and coupon codes</p>
      </div>
    </div>
    <a href="{{ route('admin.rewards.create') }}" class="btn btn-add">
      <i class="ri-add-line me-2"></i>Create New Reward
    </a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <div class="d-flex align-items-center">
      <i class="ri-checkbox-circle-fill me-2 fs-5"></i>
      <div>{{ session('success') }}</div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Filter Card -->
<div class="card filter-card mb-4">
  <div class="card-body">
    <div class="filter-title mb-3">
      <div class="d-flex align-items-center gap-2">
        <div class="filter-icon-wrapper">
          <i class="ri-filter-3-line"></i>
        </div>
        <span>Filter & Search</span>
      </div>
      <button type="button" class="btn-filter-toggle" onclick="toggleFilterSection()">
        <i class="ri-arrow-down-s-line" id="filterToggleIcon"></i>
      </button>
    </div>
    <div class="filter-content" id="filterContent">
      <form method="GET" action="{{ route('admin.rewards.index') }}" id="filterForm">
        <div class="row g-3 align-items-end">
          <!-- Search -->
          <div class="col-md-4">
            <label class="form-label">Search</label>
            <div class="input-group input-group-merge">
              <span class="input-group-text"><i class="ri-search-line"></i></span>
              <input type="text" name="search" class="form-control" placeholder="Search by title, code, description..." value="{{ request('search') }}">
            </div>
          </div>

          <!-- Status Filter -->
          <div class="col-md-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="">All</option>
              <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
              <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
            </select>
          </div>

          <!-- Applicable For Filter -->
          <div class="col-md-2">
            <label class="form-label">Applicable For</label>
            <select name="applicable_for" class="form-select">
              <option value="">All</option>
              <option value="therapist" {{ request('applicable_for') == 'therapist' ? 'selected' : '' }}>Therapist</option>
              <option value="client" {{ request('applicable_for') == 'client' ? 'selected' : '' }}>Client</option>
              <option value="both" {{ request('applicable_for') == 'both' ? 'selected' : '' }}>Both</option>
            </select>
          </div>

          <!-- Action Buttons -->
          <div class="col-md-4">
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-apply-filter flex-grow-1">
                <i class="ri-filter-3-line me-1"></i> Apply Filters
              </button>
              <a href="{{ route('admin.rewards.index') }}" class="btn btn-outline-secondary" title="Reset">
                <i class="ri-refresh-line"></i>
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Rewards Table -->
<div class="card main-card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0 fw-bold">All Rewards</h5>
  </div>
  <div class="card-body p-0" style="margin-top: 20px">
    <div class="table-responsive admin-table-scroll rewards-table-wrap">
      <table id="rewardsTable" class="table table-modern table-hover align-middle mb-0">
        <thead>
          <tr>
            <th class="cell-nowrap">ID</th>
            <th>Title</th>
            <th class="cell-nowrap">Code</th>
            <th>Affiliation URL</th>
            <th>Description</th>
            <th class="cell-nowrap">Discount</th>
            <th class="cell-nowrap">Valid From</th>
            <th class="cell-nowrap">Expire Date</th>
            <th class="cell-nowrap">Status</th>
            <th class="text-center col-actions">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($rewards as $reward)
            <tr>
              <td><strong>#{{ $reward->id }}</strong></td>
              <td>
                <div class="fw-bold">{{ $reward->title }}</div>
                @if($reward->is_featured)
                  <span class="badge bg-warning text-dark mt-1">Featured</span>
                @endif
              </td>
              <td class="cell-nowrap">
                <span class="reward-code-pill" title="{{ $reward->coupon_code }}">{{ $reward->coupon_code }}</span>
              </td>
              <td>
                @if($reward->affiliation_url)
                  <a href="{{ $reward->affiliation_url }}" target="_blank" class="text-primary text-decoration-none">
                    <i class="ri-external-link-line me-1"></i>View URL
                  </a>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td>
                <div class="reward-desc-cell" title="{{ $reward->description }}">
                  {{ $reward->description ?: '-' }}
                </div>
              </td>
              <td class="cell-nowrap">
                <span class="badge-discount">{{ $reward->discount_text }}</span>
              </td>
              <td class="cell-nowrap">
                <span class="small fw-semibold">{{ $reward->valid_from->format('M d, Y') }}</span>
              </td>
              <td class="cell-nowrap">
                <span class="small fw-semibold {{ $reward->valid_until < now() ? 'text-danger' : '' }}">
                  {{ $reward->valid_until->format('M d, Y') }}
                </span>
              </td>
              <td class="cell-nowrap">
                @if($reward->valid_until < now())
                  <span class="reward-status-pill expired">Expired</span>
                @elseif($reward->is_active)
                  <span class="reward-status-pill active">Active</span>
                @else
                  <span class="reward-status-pill inactive">Inactive</span>
                @endif
              </td>
              <td class="col-actions">
                <div class="dropdown reward-actions-dropdown">
                  <button type="button"
                          class="btn btn-actions-toggle dropdown-toggle hide-arrow"
                          data-bs-toggle="dropdown"
                          aria-expanded="false"
                          title="Actions">
                    <i class="ri-more-2-fill"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="{{ route('admin.rewards.show', $reward->id) }}">
                        <i class="ri-eye-line"></i> View Details
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('admin.rewards.edit', $reward->id) }}">
                        <i class="ri-pencil-line"></i> Edit Reward
                      </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <form action="{{ route('admin.rewards.destroy', $reward->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="dropdown-item text-danger"
                                data-title="Delete Reward"
                                data-text="Are you sure you want to delete this reward?">
                          <i class="ri-delete-bin-line"></i> Delete Reward
                        </button>
                      </form>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="10" class="text-center py-5">
                <i class="ri-gift-line" style="font-size: 3rem; color: #dee2e6;"></i>
                <p class="text-muted mt-3">No rewards found</p>
                <a href="{{ route('admin.rewards.create') }}" class="btn btn-primary mt-2">
                  <i class="ri-add-line me-2"></i>Create First Reward
                </a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($rewards->hasPages())
    <div class="card-footer bg-light">
      {{ $rewards->links() }}
    </div>
  @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const hasFilters = {{ (request('search') || request('status') || request('applicable_for')) ? 'true' : 'false' }};
  if (!hasFilters) {
    document.getElementById('filterContent').classList.add('collapsed');
  }
});

function toggleFilterSection() {
  const filterContent = document.getElementById('filterContent');
  const filterToggle = document.querySelector('.btn-filter-toggle');
  const filterIcon = document.getElementById('filterToggleIcon');
  
  filterContent.classList.toggle('collapsed');
  filterToggle.classList.toggle('active');
}
</script>
@endsection
