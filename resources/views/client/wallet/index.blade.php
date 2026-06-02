@extends('layouts/contentNavbarLayout')

@section('title', 'My Wallet')

@section('page-style')
@include('client.wallet.partials.page-styles')
@endsection

@section('content')
<div class="page-header">
    <div class="d-flex align-items-center gap-3 position-relative" style="z-index: 1;">
        <div class="header-icon">
            <i class="ri-wallet-3-line"></i>
        </div>
        <div>
            <h4 class="mb-1">My Wallet</h4>
            <p class="mb-0">Manage your funds and view transaction history</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="balance-card mb-4">
            <div class="balance-card-header text-center">
                <div class="wallet-icon-large">
                    <i class="ri-wallet-3-fill"></i>
                </div>
                <div class="balance-label">Available Balance</div>
                <div class="balance-amount">₹{{ number_format($wallet->balance ?? 0, 2) }}</div>
            </div>
            <div class="balance-card-body">
                <button type="button" class="btn btn-recharge" data-bs-toggle="modal" data-bs-target="#rechargeWalletModal">
                    <i class="ri-add-circle-line"></i>
                    Add Money
                </button>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card credit">
                <div class="stat-icon credit">
                    <i class="ri-arrow-down-circle-line"></i>
                </div>
                <div class="stat-label">Total Added</div>
                <div class="stat-value credit">₹{{ number_format($wallet->transactions()->where('type', 'credit')->sum('amount') ?? 0, 2) }}</div>
            </div>
            <div class="stat-card debit">
                <div class="stat-icon debit">
                    <i class="ri-arrow-up-circle-line"></i>
                </div>
                <div class="stat-label">Total Spent</div>
                <div class="stat-value debit">₹{{ number_format($wallet->transactions()->where('type', 'debit')->sum('amount') ?? 0, 2) }}</div>
            </div>
            <div class="stat-card transactions">
                <div class="stat-icon transactions">
                    <i class="ri-exchange-line"></i>
                </div>
                <div class="stat-label">Transactions</div>
                <div class="stat-value transactions">{{ $wallet->transactions()->count() ?? 0 }}</div>
            </div>
            <div class="stat-card monthly">
                <div class="stat-icon monthly">
                    <i class="ri-calendar-line"></i>
                </div>
                <div class="stat-label">This Month</div>
                <div class="stat-value monthly">₹{{ number_format($wallet->transactions()->whereMonth('created_at', now()->month)->where('type', 'credit')->sum('amount') ?? 0, 2) }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="transactions-card">
            <div class="transactions-header">
                <h5>
                    <i class="ri-history-line"></i>
                    Transaction History
                </h5>
                <a href="{{ route('client.wallet.transactions') }}" class="btn btn-view-all">
                    View All <i class="ri-arrow-right-s-line"></i>
                </a>
            </div>
            <div class="transactions-body">
                @if($transactions->count() > 0)
                    <div class="table-responsive admin-table-scroll">
                        <table class="table transactions-table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Balance</th>
                                    <th>Method</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>
                                        <div class="txn-date">{{ $transaction->created_at->format('M d, Y') }}</div>
                                        <div class="txn-time">{{ $transaction->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="txn-icon {{ $transaction->type }}">
                                                <i class="ri-{{ $transaction->type === 'credit' ? 'arrow-down-circle' : 'arrow-up-circle' }}-line"></i>
                                            </div>
                                            <div>
                                                <div class="txn-description">{{ $transaction->description }}</div>
                                                @if($transaction->transaction_id)
                                                    <div class="txn-id">Txn: {{ $transaction->transaction_id }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="txn-type-badge {{ $transaction->type }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="txn-amount {{ $transaction->type }}">
                                            {{ $transaction->type === 'credit' ? '+' : '-' }}₹{{ number_format($transaction->amount, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="txn-balance">₹{{ number_format($transaction->balance_after ?? 0, 2) }}</span>
                                    </td>
                                    <td>
                                        @if($transaction->payment_method)
                                            <span class="payment-method-badge">
                                                <i class="ri-bank-card-line"></i>
                                                {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center p-3">
                        {{ $transactions->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="ri-wallet-3-line"></i>
                        </div>
                        <h5>No transactions yet</h5>
                        <p>Start by recharging your wallet to book therapy sessions</p>
                        <button type="button" class="btn btn-empty-recharge" data-bs-toggle="modal" data-bs-target="#rechargeWalletModal">
                            <i class="ri-add-circle-line me-2"></i>Recharge Wallet
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@include('client.wallet.partials.recharge-modal', ['wallet' => $wallet])
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('rechargeWalletModal');
    if (!modalEl) return;

    modalEl.addEventListener('shown.bs.modal', function() {
        const body = modalEl.querySelector('.recharge-modal-body');
        if (body) body.scrollTop = 0;
    });

    modalEl.querySelectorAll('.quick-amount-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('rechargeAmount').value = this.dataset.amount;
            modalEl.querySelectorAll('.quick-amount-btn').forEach(b => b.classList.remove('is-active'));
            this.classList.add('is-active');
        });
    });

    const amountInput = document.getElementById('rechargeAmount');
    if (amountInput) {
        amountInput.addEventListener('input', function() {
            const value = parseFloat(this.value);
            modalEl.querySelectorAll('.quick-amount-btn').forEach(b => {
                b.classList.toggle('is-active', parseFloat(b.dataset.amount) === value);
            });
        });
    }
});
</script>
@endsection
