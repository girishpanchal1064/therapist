@extends('layouts/contentNavbarLayout')

@section('title', 'My Wallet')

@section('content')
<div class="row">
  <!-- Wallet Balance Card -->
  <div class="col-lg-4 col-md-6 mb-4">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-body text-center p-4">
        <div class="avatar avatar-xl mx-auto mb-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
          <i class="ri-wallet-3-line text-white" style="font-size: 3rem;"></i>
        </div>
        <h4 class="card-title mb-2">Wallet Balance</h4>
        <h2 class="text-primary mb-3">₹{{ number_format($wallet->balance ?? 0, 2) }}</h2>
        <button type="button" class="btn btn-primary btn-lg w-100" data-bs-toggle="modal" data-bs-target="#rechargeWalletModal">
          <i class="ri-add-circle-line me-2"></i>Recharge Wallet
        </button>
      </div>
    </div>
  </div>

  <!-- Quick Stats -->
  <div class="col-lg-8 col-md-6 mb-4">
    <div class="row g-3">
      <div class="col-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body text-center">
            <div class="avatar avatar-md mx-auto mb-2" style="background-color: #10b98120;">
              <i class="ri-arrow-down-circle-line text-success" style="font-size: 1.5rem;"></i>
            </div>
            <h6 class="text-muted mb-1">Total Added</h6>
            <h5 class="mb-0 text-success">₹{{ number_format($wallet->transactions()->where('type', 'credit')->sum('amount') ?? 0, 2) }}</h5>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body text-center">
            <div class="avatar avatar-md mx-auto mb-2" style="background-color: #ef444420;">
              <i class="ri-arrow-up-circle-line text-danger" style="font-size: 1.5rem;"></i>
            </div>
            <h6 class="text-muted mb-1">Total Spent</h6>
            <h5 class="mb-0 text-danger">₹{{ number_format($wallet->transactions()->where('type', 'debit')->sum('amount') ?? 0, 2) }}</h5>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body text-center">
            <div class="avatar avatar-md mx-auto mb-2" style="background-color: #3b82f620;">
              <i class="ri-exchange-line text-info" style="font-size: 1.5rem;"></i>
            </div>
            <h6 class="text-muted mb-1">Transactions</h6>
            <h5 class="mb-0 text-info">{{ $wallet->transactions()->count() ?? 0 }}</h5>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body text-center">
            <div class="avatar avatar-md mx-auto mb-2" style="background-color: #f59e0b20;">
              <i class="ri-calendar-line text-warning" style="font-size: 1.5rem;"></i>
            </div>
            <h6 class="text-muted mb-1">This Month</h6>
            <h5 class="mb-0 text-warning">₹{{ number_format($wallet->transactions()->whereMonth('created_at', now()->month)->where('type', 'credit')->sum('amount') ?? 0, 2) }}</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Transactions Table -->
<div class="card border-0 shadow-sm">
  <div class="card-header border-bottom d-flex justify-content-between align-items-center">
    <h5 class="card-title mb-0">
      <i class="ri-history-line me-2"></i>Transaction History
    </h5>
    <a href="{{ route('client.wallet.transactions') }}" class="btn btn-sm btn-outline-primary">
      View All
    </a>
  </div>
  <div class="card-body">
    @if($transactions->count() > 0)
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Date & Time</th>
              <th>Description</th>
              <th>Type</th>
              <th>Amount</th>
              <th>Balance After</th>
              <th>Payment Method</th>
            </tr>
          </thead>
          <tbody>
            @foreach($transactions as $transaction)
            <tr>
              <td>
                <div>
                  <div class="fw-semibold">{{ $transaction->created_at->format('M d, Y') }}</div>
                  <small class="text-muted">{{ $transaction->created_at->format('h:i A') }}</small>
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm me-2" style="background-color: {{ $transaction->type === 'credit' ? '#10b98120' : '#ef444420' }};">
                    <i class="ri-{{ $transaction->type === 'credit' ? 'arrow-down-circle' : 'arrow-up-circle' }}-line text-{{ $transaction->type === 'credit' ? 'success' : 'danger' }}" style="font-size: 1.2rem;"></i>
                  </div>
                  <div>
                    <div class="fw-semibold">{{ $transaction->description }}</div>
                    @if($transaction->transaction_id)
                    <small class="text-muted">Txn: {{ $transaction->transaction_id }}</small>
                    @endif
                  </div>
                </div>
              </td>
              <td>
                <span class="badge bg-{{ $transaction->type === 'credit' ? 'success' : 'danger' }}-subtle text-{{ $transaction->type === 'credit' ? 'success' : 'danger' }}">
                  {{ ucfirst($transaction->type) }}
                </span>
              </td>
              <td>
                <span class="fw-semibold text-{{ $transaction->type === 'credit' ? 'success' : 'danger' }}">
                  {{ $transaction->type === 'credit' ? '+' : '-' }}₹{{ number_format($transaction->amount, 2) }}
                </span>
              </td>
              <td>
                <span class="fw-semibold">₹{{ number_format($transaction->balance_after ?? 0, 2) }}</span>
              </td>
              <td>
                @if($transaction->payment_method)
                <span class="badge bg-info-subtle text-info">
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
      <div class="d-flex justify-content-center mt-3">
        {{ $transactions->links() }}
      </div>
    @else
      <div class="text-center py-5">
        <div class="avatar avatar-xl mx-auto mb-3" style="background-color: #f3f4f6;">
          <i class="ri-wallet-3-line text-muted" style="font-size: 3rem;"></i>
        </div>
        <h5 class="text-muted">No transactions yet</h5>
        <p class="text-muted mb-4">Start by recharging your wallet</p>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rechargeWalletModal">
          <i class="ri-add-circle-line me-2"></i>Recharge Wallet
        </button>
      </div>
    @endif
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
