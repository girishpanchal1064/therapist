@extends('layouts/contentNavbarLayout')

@section('title', 'Payment Reports')

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

  /* Stats Cards */
  .stats-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
  }

  .stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  }

  .stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.15);
  }

  .stats-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    font-size: 1.6rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    color: #667eea;
  }

  .stats-card .stats-value {
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .stats-card .stats-label {
    color: #64748b;
    font-size: 0.875rem;
    font-weight: 500;
    margin-top: 0.5rem;
  }

  /* Filter Card */
  .filter-card {
    border-radius: 16px;
    border: 1px solid #e9ecef;
    background: white;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    margin-bottom: 1.5rem;
  }

  .filter-card .card-body {
    padding: 1rem 24px 24px 24px;
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

  /* Main Card */
  .main-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 1.5rem;
  }

  .main-card .card-header {
    background: white;
    border-bottom: 2px solid #f0f2f5;
    padding: 1.5rem;
  }

  .main-card .card-body {
    padding: 1.5rem;
  }

  /* Table Styling */
  .reports-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }

  .reports-table thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border: none;
    white-space: nowrap;
  }

  .reports-table tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f0f0f0;
  }

  .reports-table tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.04);
  }

  .reports-table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    color: #2d3748;
    font-size: 0.9rem;
  }

  .badge-status {
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
  }

  .badge-status.completed {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
  }

  .badge-status.pending {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
  }

  .badge-status.failed {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    color: #991b1b;
  }

  .badge-status.refunded {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    color: #4b5563;
  }

  .amount-display {
    font-weight: 700;
    color: #1e293b;
  }

  .amount-display.total {
    color: #059669;
    font-size: 1rem;
  }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
  <div class="d-flex align-items-center gap-3">
    <div class="header-icon">
      <i class="ri-bar-chart-line"></i>
    </div>
    <div>
      <h4 class="mb-1">Payment Reports</h4>
      <p class="mb-0">Comprehensive payment analytics and insights</p>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="card filter-card">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.payments.reports') }}" class="row g-3 align-items-end">
      <div class="col-md-4">
        <label class="form-label">Start Date</label>
        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">End Date</label>
        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
      </div>
      <div class="col-md-4">
        <button type="submit" class="btn btn-filter w-100">
          <i class="ri-search-line me-1"></i> Generate Report
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
  <div class="col-md-3">
    <div class="card stats-card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="stats-value">₹{{ number_format($totalRevenue, 2) }}</div>
            <div class="stats-label">Total Revenue</div>
          </div>
          <div class="stats-icon">
            <i class="ri-money-dollar-circle-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stats-card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="stats-value">{{ $completedCount }}</div>
            <div class="stats-label">Completed Payments</div>
          </div>
          <div class="stats-icon">
            <i class="ri-checkbox-circle-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stats-card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="stats-value">{{ $pendingCount }}</div>
            <div class="stats-label">Pending Payments</div>
          </div>
          <div class="stats-icon">
            <i class="ri-time-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stats-card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="stats-value">₹{{ number_format($totalRefunded, 2) }}</div>
            <div class="stats-label">Total Refunded</div>
          </div>
          <div class="stats-icon">
            <i class="ri-refund-2-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Payment Methods Statistics -->
<div class="card main-card">
  <div class="card-header">
    <h5 class="mb-0">Payment Methods</h5>
  </div>
  <div class="card-body" style="margin-top: 10px">
    <div class="table-responsive">
      <table class="table reports-table">
        <thead>
          <tr>
            <th>Payment Method</th>
            <th>Total Transactions</th>
            <th>Total Amount</th>
            <th>Percentage</th>
          </tr>
        </thead>
        <tbody>
          @foreach($paymentMethods as $method)
            @php
              $percentage = $totalRevenue > 0 ? ($method->total / $totalRevenue) * 100 : 0;
            @endphp
            <tr>
              <td>
                <span class="text-capitalize fw-semibold">{{ $method->payment_method }}</span>
              </td>
              <td>{{ $method->count }}</td>
              <td>
                <span class="amount-display">₹{{ number_format($method->total, 2) }}</span>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="progress flex-fill" style="height: 8px;">
                    <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <span class="text-muted small">{{ number_format($percentage, 1) }}%</span>
                </div>
              </td>
            </tr>
          @endforeach
          @if($paymentMethods->isEmpty())
            <tr>
              <td colspan="4" class="text-center text-muted py-4">No payment data available</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Recent Payments -->
<div class="card main-card">
  <div class="card-header">
    <h5 class="mb-0">Recent Payments</h5>
  </div>
  <div class="card-body" style="margin-top: 10px">
    <div class="table-responsive">
      <table class="table reports-table">
        <thead>
          <tr>
            <th>Transaction ID</th>
            <th>User</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentPayments as $payment)
            <tr>
              <td>
                @if($payment->transaction_id)
                  <span class="font-monospace small">{{ $payment->transaction_id }}</span>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td>
                <div>
                  <div class="fw-semibold">{{ $payment->user->name }}</div>
                  <div class="text-muted small">{{ $payment->user->email }}</div>
                </div>
              </td>
              <td>
                <span class="amount-display">₹{{ number_format($payment->total_amount, 2) }}</span>
              </td>
              <td>
                <span class="text-capitalize">{{ $payment->payment_method }}</span>
              </td>
              <td>
                <span class="badge-status {{ $payment->status }}">
                  @if($payment->status === 'completed')
                    <i class="ri-checkbox-circle-fill"></i>
                  @elseif($payment->status === 'pending')
                    <i class="ri-time-fill"></i>
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
                  <div>
                    <div class="fw-medium">{{ $payment->paid_at->format('M d, Y') }}</div>
                    <div class="text-muted small">{{ $payment->paid_at->format('h:i A') }}</div>
                  </div>
                @else
                  <span class="text-muted">{{ $payment->created_at->format('M d, Y') }}</span>
                @endif
              </td>
            </tr>
          @endforeach
          @if($recentPayments->isEmpty())
            <tr>
              <td colspan="6" class="text-center text-muted py-4">No recent payments</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
