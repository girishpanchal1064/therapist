@extends('layouts/contentNavbarLayout')

@section('title', 'Financial Report')

@section('vendor-style')
<style>
:root {
    --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.page-header {
    background: var(--theme-gradient);
    border-radius: 16px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    color: white;
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
}

.stats-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--theme-gradient);
}

.report-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.report-table thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 18px 20px;
    border: none;
}

.report-table tbody td {
    padding: 18px 20px;
    border-bottom: 1px solid #f0f2f5;
    vertical-align: middle;
    color: #2d3748;
    font-size: 0.9rem;
}

.report-table tbody tr {
    background: white;
}

.report-table tbody tr:last-child td {
    border-bottom: none;
}
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
        <div>
            <h4 class="mb-1 fw-bold">Financial Report</h4>
            <p class="mb-0 text-white opacity-75">Comprehensive financial analytics and revenue statistics</p>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">Total Revenue</div>
                        <div class="h4 mb-0 fw-bold text-success">₹{{ number_format($stats['total_revenue'], 2) }}</div>
                    </div>
                    <i class="ri-money-dollar-circle-line" style="font-size: 2.5rem; color: #10b981; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">Monthly Revenue</div>
                        <div class="h4 mb-0 fw-bold">₹{{ number_format($stats['monthly_revenue'], 2) }}</div>
                    </div>
                    <i class="ri-calendar-line" style="font-size: 2.5rem; color: #667eea; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">Platform Earnings</div>
                        <div class="h4 mb-0 fw-bold text-primary">₹{{ number_format($stats['platform_earnings'], 2) }}</div>
                    </div>
                    <i class="ri-building-line" style="font-size: 2.5rem; color: #3b82f6; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">Therapist Earnings</div>
                        <div class="h4 mb-0 fw-bold text-info">₹{{ number_format($stats['therapist_earnings'], 2) }}</div>
                    </div>
                    <i class="ri-user-heart-line" style="font-size: 2.5rem; color: #17a2b8; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">Total Payments</div>
                        <div class="h4 mb-0 fw-bold">{{ number_format($stats['total_payments']) }}</div>
                    </div>
                    <i class="ri-bank-line" style="font-size: 2.5rem; color: #667eea; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">Completed</div>
                        <div class="h4 mb-0 fw-bold text-success">{{ number_format($stats['completed_payments']) }}</div>
                    </div>
                    <i class="ri-checkbox-circle-line" style="font-size: 2.5rem; color: #10b981; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">Pending</div>
                        <div class="h4 mb-0 fw-bold text-warning">{{ number_format($stats['pending_payments']) }}</div>
                    </div>
                    <i class="ri-time-line" style="font-size: 2.5rem; color: #f59e0b; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.financial') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by transaction ID, user..." value="{{ $search }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ $status == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Date From</label>
                <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Date To</label>
                <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ri-search-line"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Payments Table -->
<div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
    <div class="card-header" style="background: white; border-bottom: 2px solid #f0f2f5; padding: 1.5rem;">
        <h5 class="mb-0 fw-bold">Payments List</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Transaction ID</th>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Tax</th>
                        <th>Total</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td><strong>#{{ $payment->id }}</strong></td>
                            <td>
                                <code class="bg-light px-2 py-1 rounded">{{ $payment->transaction_id ?: '-' }}</code>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        @if($payment->user)
                                            @if($payment->user->hasRole('Therapist') && $payment->user->therapistProfile && $payment->user->therapistProfile->profile_image)
                                                <img src="{{ asset('storage/' . $payment->user->therapistProfile->profile_image) }}" alt="{{ $payment->user->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                            @elseif($payment->user->hasRole('Client') && $payment->user->profile && $payment->user->profile->profile_image)
                                                <img src="{{ asset('storage/' . $payment->user->profile->profile_image) }}" alt="{{ $payment->user->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                            @elseif($payment->user->getRawOriginal('avatar'))
                                                <img src="{{ asset('storage/' . $payment->user->getRawOriginal('avatar')) }}" alt="{{ $payment->user->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($payment->user->name) }}&background=667eea&color=fff&size=80&bold=true&format=svg" alt="{{ $payment->user->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                            @endif
                                        @endif
                                    </div>
                                    <span class="fw-semibold">{{ $payment->user->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td><strong>₹{{ number_format($payment->amount, 2) }}</strong></td>
                            <td>₹{{ number_format($payment->tax_amount, 2) }}</td>
                            <td><strong class="text-success">₹{{ number_format($payment->total_amount, 2) }}</strong></td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                            </td>
                            <td>
                                @if($payment->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($payment->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($payment->status === 'failed')
                                    <span class="badge bg-danger">Failed</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($payment->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $payment->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="ri-money-dollar-circle-line" style="font-size: 3rem; color: #dee2e6;"></i>
                                <p class="text-muted mt-3">No payments found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($payments->hasPages())
        <div class="card-footer bg-light">
            {{ $payments->links() }}
        </div>
    @endif
</div>
@endsection
