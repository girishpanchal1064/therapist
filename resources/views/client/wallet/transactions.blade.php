@extends('layouts/contentNavbarLayout')

@section('title', 'Wallet Transactions')

@section('page-style')
@include('client.wallet.partials.page-styles')
@endsection

@section('content')
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

<div class="balance-card-inline">
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

<div class="transactions-card">
    <div class="transactions-header">
        <h5 class="mb-0">Transaction History</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table transactions-table mb-0">
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
                                <span class="txn-id-badge">#{{ $transaction->id }}</span>
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
                                <div class="txn-description">{{ $transaction->description }}</div>
                                @if($transaction->transactionable_type)
                                    <div class="txn-id">{{ class_basename($transaction->transactionable_type) }}</div>
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
                                <span class="txn-balance">₹{{ number_format($transaction->balance_after, 2) }}</span>
                            </td>
                            <td>
                                <div class="txn-date">{{ $transaction->created_at->format('M d, Y') }}</div>
                                <div class="txn-time">{{ $transaction->created_at->format('h:i A') }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state py-0">
                                    <div class="empty-state-icon">
                                        <i class="ri-file-list-3-line"></i>
                                    </div>
                                    <h5>No Transactions Found</h5>
                                    <p>You haven't made any transactions yet.</p>
                                    <a href="{{ route('client.wallet.index') }}" class="btn btn-empty-recharge">
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

@if($transactions->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4 p-3 transactions-card">
        <div class="text-muted small">
            Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} entries
        </div>
        <div>
            {{ $transactions->links() }}
        </div>
    </div>
@endif
@endsection
