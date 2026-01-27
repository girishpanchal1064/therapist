@extends('layouts/contentNavbarLayout')

@section('title', 'Payments Management')

@section('page-style')
<style>
  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

  /* Action Buttons */
  .btn-action-group {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
  }

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

  .btn-outline-custom {
    border: 2px solid #e2e8f0;
    background: white;
    color: #4a5568;
    padding: 0.625rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-outline-custom:hover {
    border-color: #667eea;
    color: #667eea;
    background: #f0f4ff;
  }

  .btn-outline-custom.warning {
    border-color: #fbbf24;
    color: #d97706;
  }

  .btn-outline-custom.warning:hover {
    background: #fef3c7;
    border-color: #f59e0b;
  }

  .btn-outline-custom.info {
    border-color: #60a5fa;
    color: #2563eb;
  }

  .btn-outline-custom.info:hover {
    background: #eff6ff;
    border-color: #3b82f6;
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

  /* Filter Card */
  .filter-card {
    border-radius: 16px;
    border: 1px solid #e9ecef;
    background: white;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    margin-bottom: 1.5rem;
    display: block !important;
    visibility: visible !important;
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    color: #667eea;
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .btn-filter-toggle:hover {
    background: rgba(102, 126, 234, 0.1);
    border-color: #667eea;
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
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
  }

  .btn-filter {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 10px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-filter:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
  }

  .btn-clear-filter {
    background: white;
    border: 2px solid #e4e6eb;
    color: #64748b;
    padding: 10px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-clear-filter:hover {
    border-color: #cbd5e0;
    background: #f7fafc;
    color: #4a5568;
  }

  /* Table Styling - Enhanced */
  .payments-table {
    width: 100% !important;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  }

  .payments-table thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 18px 20px;
    border: none;
    white-space: nowrap;
  }

  .payments-table thead th:first-child {
    border-radius: 12px 0 0 0;
  }

  .payments-table thead th:last-child {
    border-radius: 0 12px 0 0;
  }

  .payments-table tbody tr {
    transition: all 0.3s ease;
    background: white;
    border-bottom: 1px solid #f0f2f5;
  }

  .payments-table tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.04) 0%, rgba(118, 75, 162, 0.04) 100%);
    transform: scale(1.001);
    box-shadow: 0 2px 12px rgba(102, 126, 234, 0.08);
  }

  .payments-table tbody tr:last-child {
    border-bottom: none;
  }

  .payments-table tbody td {
    padding: 18px 20px;
    vertical-align: middle;
    color: #2d3748;
    font-size: 0.9rem;
    border-bottom: 1px solid #f0f2f5;
  }

  .payments-table tbody tr:last-child td {
    border-bottom: none;
  }

  /* User Info */
  .user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

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

  .user-details {
    display: flex;
    flex-direction: column;
  }

  .user-details .name {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.9rem;
  }

  .user-details .email {
    color: #64748b;
    font-size: 0.75rem;
  }

  /* Transaction ID */
  .transaction-id {
    font-family: 'Monaco', 'Menlo', monospace;
    background: #f1f5f9;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    color: #475569;
  }

  /* Amount Display */
  .amount-display {
    font-weight: 700;
    color: #1e293b;
  }

  .amount-display.total {
    color: #059669;
    font-size: 1rem;
  }

  /* Status Badge */
  .status-badge {
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
  }

  .status-badge.pending {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
  }

  .status-badge.processing {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
  }

  .status-badge.completed {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
  }

  .status-badge.failed {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    color: #991b1b;
  }

  .status-badge.refunded {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    color: #4b5563;
  }

  /* Payment Method */
  .payment-method {
    background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
    color: #4338ca;
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
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

  /* Modern Action Buttons */
  .action-btns {
    display: flex;
    gap: 0.5rem;
    align-items: center;
  }

  .btn-action {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.95rem;
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

  .btn-action.refund {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #b45309;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15);
  }

  .btn-action.refund:hover {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    box-shadow: 0 6px 20px rgba(245, 158, 11, 0.35);
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

  .action-dropdown .dropdown-item.text-warning:hover {
    background: #fef3c7;
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
  }

  .empty-state-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.5rem;
    color: #667eea;
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

  .pagination-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .pagination-controls .btn-page {
    background: white;
    border: 2px solid #e2e8f0;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    transition: all 0.2s ease;
  }

  .pagination-controls .btn-page:hover:not(.disabled) {
    border-color: #667eea;
    color: #667eea;
    background: #f0f4ff;
  }

  .pagination-controls .btn-page.disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  .pagination-controls .form-select {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
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

    .btn-action-group {
      width: 100%;
      justify-content: center;
    }
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <div class="d-flex align-items-center gap-3">
    <div class="header-icon">
      <i class="ri-bank-card-line"></i>
    </div>
    <div>
      <h4 class="mb-1">Payments Management</h4>
      <p class="mb-0">Track and manage all payment transactions</p>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="card filter-card">
  <div class="card-body">
    <div class="filter-title" onclick="toggleFilter()">
      <div class="d-flex align-items-center gap-2">
        <div class="filter-icon-wrapper">
          <i class="ri-filter-3-line"></i>
        </div>
        <h5 class="mb-0">Filter & Search</h5>
      </div>
      <button type="button" class="btn-filter-toggle" id="filterToggle">
        <i class="ri-arrow-down-s-line"></i>
      </button>
    </div>
    <div class="filter-content" id="filterContent">
      <form method="GET" action="{{ route('admin.payments.index') }}" id="filterForm">
        <div class="row g-3 align-items-end">
          <div class="col-md-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
              <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Processing</option>
              <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
              <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed</option>
              <option value="refunded" {{ $status === 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Search by transaction ID, amount, user name or email..." value="{{ $search }}">
            <input type="hidden" name="per_page" value="{{ $perPage }}">
          </div>

          <div class="col-md-3">
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-filter flex-fill">
                <i class="ri-search-line me-1"></i> Apply
              </button>
              <a href="{{ route('admin.payments.index') }}" class="btn btn-clear-filter">
                <i class="ri-close-line"></i>
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Main Card -->
<div class="card main-card">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h5 class="mb-1">All Payments</h5>
      <p class="text-muted mb-0 small">View and manage payment transactions</p>
    </div>
    <div class="btn-action-group">
      <a href="{{ route('admin.payments.pending') }}" class="btn btn-outline-custom warning">
        <i class="ri-time-line me-1"></i> Pending
      </a>
      <a href="{{ route('admin.payments.reports') }}" class="btn btn-outline-custom info">
        <i class="ri-bar-chart-line me-1"></i> Reports
      </a>
      <a href="{{ route('admin.payments.create') }}" class="btn btn-add">
        <i class="ri-add-line me-1"></i> Add Payment
      </a>
    </div>
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

    <!-- Payments Table -->
    @if($payments->count() > 0)
      <div class="table-responsive" style="margin-top: 20px">
        <table class="table payments-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Transaction ID</th>
              <th>User</th>
              <th>Amount</th>
              <th>Tax</th>
              <th>Total</th>
              <th>Method</th>
              <th>Status</th>
              <th>Paid At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $payment)
              <tr>
                <td>
                  <span class="fw-medium text-muted">{{ $loop->iteration }}</span>
                </td>
                <td>
                  @if($payment->transaction_id)
                    <span class="transaction-id">{{ $payment->transaction_id }}</span>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td>
                  <div class="user-info">
                    @if($payment->user->avatar)
                      <img src="{{ asset('storage/' . $payment->user->avatar) }}" alt="{{ $payment->user->name }}" class="user-avatar">
                    @else
                      <div class="user-avatar-initials">
                        {{ strtoupper(substr($payment->user->name, 0, 2)) }}
                      </div>
                    @endif
                    <div class="user-details">
                      <span class="name">{{ $payment->user->name }}</span>
                      <span class="email">{{ $payment->user->email }}</span>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="amount-display">₹{{ number_format($payment->amount, 2) }}</span>
                </td>
                <td>
                  <span class="text-muted">₹{{ number_format($payment->tax_amount, 2) }}</span>
                </td>
                <td>
                  <span class="amount-display total">₹{{ number_format($payment->total_amount, 2) }}</span>
                </td>
                <td>
                  <span class="payment-method">
                    <i class="ri-bank-card-line me-1"></i>{{ $payment->payment_method }}
                  </span>
                </td>
                <td>
                  <span class="status-badge {{ $payment->status }}">
                    @if($payment->status === 'completed')
                      <i class="ri-checkbox-circle-fill"></i>
                    @elseif($payment->status === 'pending')
                      <i class="ri-time-fill"></i>
                    @elseif($payment->status === 'processing')
                      <i class="ri-loader-4-fill"></i>
                    @elseif($payment->status === 'failed')
                      <i class="ri-close-circle-fill"></i>
                    @else
                      <i class="ri-refund-2-fill"></i>
                    @endif
                    {{ ucfirst($payment->status) }}
                  </span>
                </td>
                <td>
                  @if($payment->paid_at)
                    <div class="d-flex flex-column">
                      <span class="fw-medium">{{ $payment->paid_at->format('M d, Y') }}</span>
                      <span class="text-muted small">{{ $payment->paid_at->format('h:i A') }}</span>
                    </div>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td>
                  <div class="action-btns">
                    <a href="{{ route('admin.payments.show', $payment) }}" class="btn-action view" title="View Details">
                      <i class="ri-eye-line"></i>
                    </a>
                    @if($payment->status === 'completed' && $payment->status !== 'refunded')
                      <form action="{{ route('admin.payments.refund', $payment) }}" method="POST" class="d-inline delete-form">
                        @csrf
                        <button type="submit" class="btn-action refund" title="Refund" data-title="Refund Payment" data-text="Are you sure you want to refund this payment?" data-confirm-text="Yes, refund it!" data-cancel-text="Cancel">
                          <i class="ri-refund-line"></i>
                        </button>
                      </form>
                    @endif
                    <a href="{{ route('admin.payments.edit', $payment) }}" class="btn-action edit" title="Edit">
                      <i class="ri-pencil-line"></i>
                    </a>
                    <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-action delete" title="Delete" onclick="return confirm('Are you sure you want to delete this payment?')">
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
      @if($payments->hasPages())
        <div class="pagination-wrapper">
          <div class="pagination-info">
            Showing <strong>{{ $payments->firstItem() }}</strong> to <strong>{{ $payments->lastItem() }}</strong>
            of <strong>{{ $payments->total() }}</strong> payments
          </div>
          <div class="pagination-controls">
            <a href="{{ $payments->url(1) }}" class="btn btn-page {{ $payments->onFirstPage() ? 'disabled' : '' }}">
              <i class="ri-arrow-left-double-line"></i>
            </a>
            <a href="{{ $payments->previousPageUrl() }}" class="btn btn-page {{ $payments->onFirstPage() ? 'disabled' : '' }}">
              <i class="ri-arrow-left-s-line"></i>
            </a>
            <span class="text-muted mx-2">Page {{ $payments->currentPage() }} of {{ $payments->lastPage() }}</span>
            <a href="{{ $payments->nextPageUrl() }}" class="btn btn-page {{ $payments->hasMorePages() ? '' : 'disabled' }}">
              <i class="ri-arrow-right-s-line"></i>
            </a>
            <a href="{{ $payments->url($payments->lastPage()) }}" class="btn btn-page {{ $payments->hasMorePages() ? '' : 'disabled' }}">
              <i class="ri-arrow-right-double-line"></i>
            </a>
            <select class="form-select ms-2" style="width: auto;" onchange="updatePerPage(this.value)">
              <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 rows</option>
              <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 rows</option>
              <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 rows</option>
              <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 rows</option>
            </select>
          </div>
        </div>
      @endif
    @else
      <div class="empty-state">
        <div class="empty-state-icon">
          <i class="ri-bank-card-line"></i>
        </div>
        <h5>No Payments Found</h5>
        <p>There are no payments matching your criteria.</p>
      </div>
    @endif
  </div>
</div>
@endsection

@section('page-script')
<script>
  function updatePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    window.location.href = url.toString();
  }

  function toggleFilter() {
    const filterContent = document.getElementById('filterContent');
    const filterToggle = document.getElementById('filterToggle');

    filterContent.classList.toggle('collapsed');
    filterToggle.classList.toggle('active');
  }

  // Initialize filter state - show by default if filters are applied
  document.addEventListener('DOMContentLoaded', function() {
    const hasFilters = {{ ($status !== 'all' || $search) ? 'true' : 'false' }};
    if (!hasFilters) {
      document.getElementById('filterContent').classList.add('collapsed');
    }
  });
</script>
@endsection
