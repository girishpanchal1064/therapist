@extends('layouts/contentNavbarLayout')

@section('title', 'Wallet Transactions')

@section('page-style')
<style>
:root {
    --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
    --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

/* Page Header */
.page-header {
    background: var(--theme-gradient);
    border-radius: 20px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
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

.header-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    backdrop-filter: blur(10px);
}

/* Balance Card */
.balance-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
    border: 2px solid #f0f2f5;
}

.balance-label {
    font-size: 0.875rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.balance-amount {
    font-size: 2.5rem;
    font-weight: 700;
    background: var(--theme-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
}

/* Table Styling */
.transactions-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.transactions-table thead th {
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

.transactions-table thead th:first-child {
    border-radius: 12px 0 0 0;
}

.transactions-table thead th:last-child {
    border-radius: 0 12px 0 0;
}

.transactions-table tbody td {
    padding: 18px 20px;
    border-bottom: 1px solid #f0f2f5;
    vertical-align: middle;
    color: #2d3748;
    font-size: 0.9rem;
}

.transactions-table tbody tr {
    background: white;
}

.transactions-table tbody tr:last-child td {
    border-bottom: none;
}

/* Transaction Type Badges */
.badge-credit {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    color: #059669;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.badge-debit {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
    color: #dc2626;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

/* Amount Styling */
.amount-credit {
    color: #059669;
    font-weight: 700;
    font-size: 1.1rem;
}

.amount-debit {
    color: #dc2626;
    font-weight: 700;
    font-size: 1.1rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state i {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}

.empty-state h4 {
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #6b7280;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.5rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.pagination-info {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
}

.btn-back {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    color: white;
}
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon">
                <i class="ri-file-list-3-line"></i>
            </div>
            <div>
                <h4 class="mb-1 fw-bold text-white">Wallet Transactions</h4>
                <p class="mb-0 text-white opacity-75">View all your wallet transactions history</p>
            </div>
        </div>
        <a href="{{ route('client.wallet.index') }}" class="btn btn-back">
            <i class="ri-arrow-left-line me-2"></i>Back to Wallet
        </a>
    </div>
</div>

<!-- Balance Card -->
<div class="balance-card">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <div class="balance-label">Current Balance</div>
            <div class="balance-amount">₹{{ number_format($wallet->balance, 2) }}</div>
        </div>
        <div class="text-end">
            <div class="balance-label">Currency</div>
            <div class="fw-bold text-muted">{{ $wallet->currency }}</div>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
    <div class="card-header" style="background: white; border-bottom: 2px solid #f0f2f5; padding: 1.5rem;">
        <h5 class="mb-0 fw-bold">Transaction History</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="transactions-table">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Balance After</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td>
                                <span style="font-family: monospace; font-weight: 600; color: #667eea; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); padding: 0.25rem 0.75rem; border-radius: 6px;">
                                    #{{ $transaction->id }}
                                </span>
                            </td>
                            <td>
                                @if($transaction->type === 'credit')
                                    <span class="badge-credit">
                                        <i class="ri-arrow-down-line"></i>Credit
                                    </span>
                                @else
                                    <span class="badge-debit">
                                        <i class="ri-arrow-up-line"></i>Debit
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 500; color: #374151;">
                                    {{ $transaction->description }}
                                </div>
                                @if($transaction->transactionable_type)
                                    <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">
                                        {{ class_basename($transaction->transactionable_type) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($transaction->type === 'credit')
                                    <span class="amount-credit">+₹{{ number_format($transaction->amount, 2) }}</span>
                                @else
                                    <span class="amount-debit">-₹{{ number_format($transaction->amount, 2) }}</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #4a5568;">
                                    ₹{{ number_format($transaction->balance_after, 2) }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 500; color: #374151;">
                                    {{ $transaction->created_at->format('M d, Y') }}
                                </div>
                                <div style="font-size: 0.75rem; color: #6b7280;">
                                    {{ $transaction->created_at->format('h:i A') }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="ri-file-list-3-line"></i>
                                    <h4>No Transactions Found</h4>
                                    <p>You haven't made any transactions yet.</p>
                                    <a href="{{ route('client.wallet.index') }}" class="btn btn-primary mt-3">
                                        <i class="ri-wallet-3-line me-2"></i>Recharge Wallet
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
@if($transactions->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} entries
        </div>
        <div>
            {{ $transactions->links() }}
        </div>
    </div>
@endif
@endsection
