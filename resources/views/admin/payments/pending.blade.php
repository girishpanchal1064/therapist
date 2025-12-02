@extends('layouts/contentNavbarLayout')

@section('title', 'Pending Payments')

@section('page-style')
<style>
    :root {
        --theme-primary: #696cff;
        --theme-primary-dark: #5f61e6;
        --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .page-header {
        background: var(--theme-gradient);
        border-radius: 12px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        color: white;
    }
    
    .page-header h4 {
        margin: 0;
        font-weight: 600;
        color: white;
    }
    
    .page-header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
    }
    
    .btn-theme {
        background: var(--theme-gradient);
        border: none;
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-theme:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .btn-theme-outline {
        background: transparent;
        border: 2px solid rgba(255,255,255,0.5);
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-theme-outline:hover {
        background: rgba(255,255,255,0.15);
        border-color: white;
        color: white;
    }
    
    .card-modern {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
    
    .filter-card {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
        border: 1px solid rgba(102, 126, 234, 0.1);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    .filter-card .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }
    
    .table-modern {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table-modern thead th {
        background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
        color: #4a5568;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        border: none;
    }
    
    .table-modern thead th:first-child {
        border-radius: 8px 0 0 0;
    }
    
    .table-modern thead th:last-child {
        border-radius: 0 8px 0 0;
    }
    
    .table-modern tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-modern tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
    }
    
    .table-modern tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #f0f0f0;
    }
    
    .user-avatar-initial {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.8rem;
        color: white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .transaction-id {
        font-family: monospace;
        font-size: 0.85rem;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8e9ff 100%);
        padding: 0.35rem 0.65rem;
        border-radius: 6px;
        color: #667eea;
        font-weight: 600;
    }
    
    .amount-cell {
        font-weight: 600;
        color: #495057;
    }
    
    .amount-total {
        font-weight: 700;
        color: #667eea;
        font-size: 1rem;
    }
    
    .badge-pending {
        background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        color: #212529;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .payment-method {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8e9ff 100%);
        padding: 0.35rem 0.65rem;
        border-radius: 20px;
        color: #667eea;
        font-weight: 500;
        font-size: 0.8rem;
        text-transform: capitalize;
    }
    
    .action-dropdown .dropdown-toggle {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .action-dropdown .dropdown-toggle::after {
        display: none;
    }
    
    .action-dropdown .dropdown-menu {
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        border-radius: 8px;
        padding: 0.5rem;
    }
    
    .action-dropdown .dropdown-item {
        border-radius: 6px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    
    .action-dropdown .dropdown-item:hover {
        background-color: rgba(102, 126, 234, 0.1);
    }
    
    .pagination-modern .btn {
        border: none;
        background: #f8f9fa;
        color: #495057;
        margin: 0 2px;
        border-radius: 6px;
    }
    
    .pagination-modern .btn:hover:not(.disabled) {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .empty-state {
        padding: 3rem;
        text-align: center;
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }
    
    .empty-state-icon i {
        font-size: 2rem;
        color: white;
    }
    
    .alert-themed {
        border: none;
        border-radius: 10px;
        border-left: 4px solid;
    }
    
    .alert-themed.alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border-left-color: #28a745;
        color: #155724;
    }
    
    .alert-themed.alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        border-left-color: #dc3545;
        color: #721c24;
    }
    
    .btn-refresh {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
    }
    
    .btn-refresh:hover {
        background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
        color: white;
    }
    
    .btn-search {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
    }
    
    .btn-search:hover {
        background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
        color: white;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4><i class="ri-time-line me-2"></i>Pending Payments</h4>
            <p>Review and process pending payment transactions</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.payments.index') }}" class="btn btn-theme-outline">
                <i class="ri-arrow-left-line me-1"></i> All Payments
            </a>
            <a href="{{ route('admin.payments.reports') }}" class="btn btn-theme-outline">
                <i class="ri-bar-chart-line me-1"></i> Reports
            </a>
        </div>
    </div>
</div>

<div class="card card-modern">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-themed alert-success alert-dismissible" role="alert">
                <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-themed alert-danger alert-dismissible" role="alert">
                <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Search -->
        <div class="filter-card">
            <div class="d-flex flex-wrap gap-3 align-items-end">
                <div class="flex-grow-1">
                    <form method="GET" action="{{ route('admin.payments.pending') }}" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Search by transaction ID, amount, user name or email..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-search">
                            <i class="ri-search-line"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.payments.pending') }}" class="btn btn-outline-secondary">
                                <i class="ri-close-line"></i>
                            </a>
                        @endif
                    </form>
                </div>

                <div>
                    <button type="button" class="btn btn-refresh" onclick="location.reload()">
                        <i class="ri-refresh-line me-1"></i> Refresh
                    </button>
                </div>
            </div>
        </div>

        <!-- Pending Payments Table -->
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Transaction ID</th>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Tax</th>
                        <th>Total</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td><span class="fw-bold text-muted">{{ $loop->iteration }}</span></td>
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
                                        <img src="{{ asset('storage/' . $payment->user->avatar) }}" 
                                             alt="{{ $payment->user->name }}" 
                                             class="user-avatar">
                                    @else
                                        <div class="user-avatar-initial">
                                            {{ strtoupper(substr($payment->user->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $payment->user->name }}</div>
                                        <small class="text-muted">{{ $payment->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="amount-cell">₹{{ number_format($payment->amount, 2) }}</td>
                            <td class="amount-cell">₹{{ number_format($payment->tax_amount, 2) }}</td>
                            <td class="amount-total">₹{{ number_format($payment->total_amount, 2) }}</td>
                            <td>
                                <span class="payment-method">{{ $payment->payment_method }}</span>
                            </td>
                            <td>
                                <span class="badge-pending">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted">
                                    <i class="ri-time-line me-1"></i>
                                    {{ $payment->created_at->format('d-m-Y h:i A') }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown action-dropdown">
                                    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="ri-more-2-line"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('admin.payments.show', $payment) }}">
                                            <i class="ri-eye-line me-2"></i> View Details
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.payments.edit', $payment) }}">
                                            <i class="ri-pencil-line me-2"></i> Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this payment?')">
                                                <i class="ri-delete-bin-line me-2"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="ri-money-dollar-circle-line"></i>
                                    </div>
                                    <h5 class="text-muted">No Pending Payments</h5>
                                    <p class="text-muted">All payments have been processed.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($payments->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <span class="text-muted">Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} entries</span>
                </div>
                <div class="d-flex align-items-center gap-2 pagination-modern">
                    <div class="d-flex gap-1">
                        <a href="{{ $payments->url(1) }}" class="btn btn-sm {{ $payments->onFirstPage() ? 'disabled' : '' }}">
                            <i class="ri-arrow-left-double-line"></i>
                        </a>
                        <a href="{{ $payments->previousPageUrl() }}" class="btn btn-sm {{ $payments->onFirstPage() ? 'disabled' : '' }}">
                            <i class="ri-arrow-left-line"></i>
                        </a>
                        <a href="{{ $payments->nextPageUrl() }}" class="btn btn-sm {{ $payments->hasMorePages() ? '' : 'disabled' }}">
                            <i class="ri-arrow-right-line"></i>
                        </a>
                        <a href="{{ $payments->url($payments->lastPage()) }}" class="btn btn-sm {{ $payments->hasMorePages() ? '' : 'disabled' }}">
                            <i class="ri-arrow-right-double-line"></i>
                        </a>
                    </div>
                    <span class="text-muted ms-2">Page {{ $payments->currentPage() }} of {{ $payments->lastPage() }}</span>
                    <select class="form-select form-select-sm" style="width: auto;" onchange="updatePerPagePending(this.value)">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 rows</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 rows</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 rows</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 rows</option>
                    </select>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('page-script')
<script>
    function updatePerPagePending(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', value);
        window.location.href = url.toString();
    }
</script>
@endsection
