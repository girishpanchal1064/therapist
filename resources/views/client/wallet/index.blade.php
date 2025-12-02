@extends('layouts/contentNavbarLayout')

@section('title', 'My Wallet')

@section('page-style')
<style>
:root {
    --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
    --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    --info-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
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

.page-header::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
}

.header-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    backdrop-filter: blur(10px);
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

/* Balance Card */
.balance-card {
    background: white;
    border: none;
    border-radius: 24px;
    box-shadow: 0 8px 35px rgba(0,0,0,0.08);
    overflow: hidden;
    position: relative;
}

.balance-card-header {
    background: var(--theme-gradient);
    padding: 2rem;
    position: relative;
    overflow: hidden;
}

.balance-card-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -30%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.wallet-icon-large {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    backdrop-filter: blur(10px);
}

.wallet-icon-large i {
    font-size: 2.5rem;
    color: white;
}

.balance-label {
    color: rgba(255, 255, 255, 0.85);
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.balance-amount {
    color: white;
    font-size: 3rem;
    font-weight: 800;
    line-height: 1;
}

.balance-card-body {
    padding: 1.5rem;
}

.btn-recharge {
    width: 100%;
    background: var(--theme-gradient);
    border: none;
    color: white;
    padding: 1rem;
    border-radius: 14px;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.btn-recharge:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.stat-card {
    background: white;
    border: none;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    padding: 1.25rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
}

.stat-card.credit::before {
    background: var(--success-gradient);
}

.stat-card.debit::before {
    background: var(--danger-gradient);
}

.stat-card.transactions::before {
    background: var(--info-gradient);
}

.stat-card.monthly::before {
    background: var(--warning-gradient);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
}

.stat-icon.credit {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    color: #10b981;
}

.stat-icon.debit {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
    color: #ef4444;
}

.stat-icon.transactions {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
    color: #3b82f6;
}

.stat-icon.monthly {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.15) 100%);
    color: #f59e0b;
}

.stat-label {
    color: #6b7280;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.stat-value {
    font-size: 1.35rem;
    font-weight: 700;
}

.stat-value.credit {
    color: #10b981;
}

.stat-value.debit {
    color: #ef4444;
}

.stat-value.transactions {
    color: #3b82f6;
}

.stat-value.monthly {
    color: #f59e0b;
}

/* Transactions Card */
.transactions-card {
    background: white;
    border: none;
    border-radius: 20px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.06);
    overflow: hidden;
}

.transactions-header {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    padding: 1.25rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(102, 126, 234, 0.1);
}

.transactions-header h5 {
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.transactions-header h5 i {
    color: #667eea;
}

.btn-view-all {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    color: #667eea;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.btn-view-all:hover {
    background: var(--theme-gradient);
    color: white;
}

.transactions-body {
    padding: 0;
}

/* Table Styling */
.transactions-table {
    margin: 0;
}

.transactions-table thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem 1.25rem;
    border: none;
}

.transactions-table tbody tr {
    transition: all 0.2s ease;
}

.transactions-table tbody tr:hover {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
}

.transactions-table tbody td {
    padding: 1rem 1.25rem;
    vertical-align: middle;
    border-bottom: 1px solid #f0f2f5;
}

/* Transaction Row */
.txn-date {
    font-weight: 600;
    color: #1f2937;
}

.txn-time {
    color: #6b7280;
    font-size: 0.8rem;
}

.txn-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.txn-icon.credit {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    color: #10b981;
}

.txn-icon.debit {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
    color: #ef4444;
}

.txn-description {
    font-weight: 600;
    color: #1f2937;
}

.txn-id {
    color: #6b7280;
    font-size: 0.75rem;
    font-family: monospace;
}

.txn-type-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.txn-type-badge.credit {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    color: #059669;
}

.txn-type-badge.debit {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
    color: #dc2626;
}

.txn-amount {
    font-weight: 700;
    font-size: 1rem;
}

.txn-amount.credit {
    color: #10b981;
}

.txn-amount.debit {
    color: #ef4444;
}

.txn-balance {
    font-weight: 600;
    color: #1f2937;
}

.payment-method-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.1) 100%);
    color: #3b82f6;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #f0f2ff 0%, #e8e9ff 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.empty-state-icon i {
    font-size: 2.5rem;
    background: var(--theme-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.empty-state h5 {
    color: #1f2937;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 1.5rem;
}

.btn-empty-recharge {
    background: var(--theme-gradient);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-empty-recharge:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .balance-amount {
        font-size: 2.25rem;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }
    
    .stat-card {
        padding: 1rem;
    }
    
    .stat-value {
        font-size: 1.1rem;
    }
}
</style>
@endsection

@section('content')
<!-- Page Header -->
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
    <!-- Balance & Stats Section -->
    <div class="col-lg-4">
        <!-- Balance Card -->
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

        <!-- Stats Grid -->
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

    <!-- Transactions Section -->
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
                    <div class="table-responsive">
                        <table class="table transactions-table">
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
                    
                    <!-- Pagination -->
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

<!-- Recharge Wallet Modal -->
@include('client.wallet.partials.recharge-modal', ['wallet' => $wallet])
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Payment method selection with enhanced UI
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.payment-method-card').forEach(card => {
                card.classList.remove('border-primary', 'shadow-sm');
                card.classList.add('border');
                card.style.transform = 'scale(1)';
            });
            if (this.checked) {
                const card = this.closest('label').querySelector('.payment-method-card');
                card.classList.remove('border');
                card.classList.add('border-primary', 'shadow-sm');
                card.style.transform = 'scale(1.02)';
            }
        });
    });

    // Initialize first payment method
    const firstRadio = document.querySelector('input[name="payment_method"]:checked');
    if (firstRadio) {
        firstRadio.dispatchEvent(new Event('change'));
    }

    // Quick amount buttons
    document.querySelectorAll('.quick-amount-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const amount = this.dataset.amount;
            document.getElementById('rechargeAmount').value = amount;
            document.querySelectorAll('.quick-amount-btn').forEach(b => {
                b.classList.remove('btn-primary');
                b.classList.add('btn-outline-primary');
            });
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-primary');
        });
    });

    // Custom amount input
    const amountInput = document.getElementById('rechargeAmount');
    if (amountInput) {
        amountInput.addEventListener('input', function() {
            const value = parseFloat(this.value);
            document.querySelectorAll('.quick-amount-btn').forEach(b => {
                if (parseFloat(b.dataset.amount) === value) {
                    b.classList.remove('btn-outline-primary');
                    b.classList.add('btn-primary');
                } else {
                    b.classList.remove('btn-primary');
                    b.classList.add('btn-outline-primary');
                }
            });
        });
    }
});
</script>
@endsection
