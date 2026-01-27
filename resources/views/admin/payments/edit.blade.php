@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Payment')

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

  /* Form Card */
  .form-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 1.5rem;
  }

  .form-card .card-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    border-bottom: 2px solid #f0f2f5;
    padding: 1.25rem 1.5rem;
  }

  .form-card .card-header h6 {
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
  }

  .form-card .card-header .header-icon-sm {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
  }

  .form-card .card-body {
    padding: 1.5rem;
  }

  .form-card .card-body > .row {
    margin-top: 20px;
  }

  .form-card .card-body > .row:first-child {
    margin-top: 0;
  }

  /* Form Styling */
  .form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
  }

  .form-control, .form-select {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.625rem 1rem;
    transition: all 0.2s ease;
    font-size: 0.9375rem;
    background: #ffffff;
  }

  .form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
    outline: none;
  }

  .form-control.is-invalid, .form-select.is-invalid {
    border-color: #ef4444;
    background: #fef2f2;
  }

  .form-text {
    color: #64748b;
    font-size: 0.8125rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
  }

  .form-text::before {
    content: 'ℹ️';
    font-size: 0.875rem;
  }

  .invalid-feedback {
    display: block;
    color: #ef4444;
    font-size: 0.8125rem;
    margin-top: 0.375rem;
  }

  /* Action Buttons */
  .action-buttons-wrapper {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding-top: 1.5rem;
    margin-top: 1.5rem;
    border-top: 2px solid #f0f2f5;
    flex-wrap: wrap;
  }

  .btn-cancel {
    background: white;
    border: 2px solid #e2e8f0;
    color: #64748b;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-cancel:hover {
    border-color: #cbd5e0;
    background: #f7fafc;
    color: #4a5568;
  }

  .btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }

  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
  }

  .btn-submit:active {
    transform: translateY(0);
  }

  /* Alert Styling */
  .alert-success {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 1px solid #86efac;
    color: #166534;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
  }

  .alert-danger {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    border: 1px solid #fecaca;
    color: #991b1b;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
  }

  /* Readonly fields */
  .form-control[readonly] {
    background-color: #f8f9fa;
    cursor: not-allowed;
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
      <h4 class="mb-1">Edit Payment</h4>
      <p class="mb-0">Update payment information</p>
    </div>
  </div>
</div>

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

<form action="{{ route('admin.payments.update', $payment) }}" method="POST">
  @csrf
  @method('PUT')

  <!-- Payment Information -->
  <div class="card form-card">
    <div class="card-header">
      <h6>
        <span class="header-icon-sm"><i class="ri-bank-card-line"></i></span>
        Payment Information
      </h6>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="user_id" class="form-label">User <span class="text-danger">*</span></label>
            <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
              <option value="">Select User</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', $payment->user_id) == $user->id ? 'selected' : '' }}>
                  {{ $user->name }} ({{ $user->email }})
                </option>
              @endforeach
            </select>
            @error('user_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
              <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="processing" {{ old('status', $payment->status) == 'processing' ? 'selected' : '' }}>Processing</option>
              <option value="completed" {{ old('status', $payment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
              <option value="failed" {{ old('status', $payment->status) == 'failed' ? 'selected' : '' }}>Failed</option>
              <option value="refunded" {{ old('status', $payment->status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="mb-3">
            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                   id="amount" name="amount" value="{{ old('amount', $payment->amount) }}" placeholder="0.00" required>
            @error('amount')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="tax_amount" class="form-label">Tax Amount</label>
            <input type="number" step="0.01" class="form-control @error('tax_amount') is-invalid @enderror"
                   id="tax_amount" name="tax_amount" value="{{ old('tax_amount', $payment->tax_amount) }}" placeholder="0.00">
            @error('tax_amount')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="total_amount" class="form-label">Total Amount <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control @error('total_amount') is-invalid @enderror"
                   id="total_amount" name="total_amount" value="{{ old('total_amount', $payment->total_amount) }}" placeholder="0.00" required>
            @error('total_amount')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="mb-3">
            <label for="currency" class="form-label">Currency</label>
            <select name="currency" id="currency" class="form-select @error('currency') is-invalid @enderror">
              <option value="INR" {{ old('currency', $payment->currency) == 'INR' ? 'selected' : '' }}>INR</option>
              <option value="USD" {{ old('currency', $payment->currency) == 'USD' ? 'selected' : '' }}>USD</option>
              <option value="EUR" {{ old('currency', $payment->currency) == 'EUR' ? 'selected' : '' }}>EUR</option>
            </select>
            @error('currency')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
            <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
              <option value="razorpay" {{ old('payment_method', $payment->payment_method) == 'razorpay' ? 'selected' : '' }}>Razorpay</option>
              <option value="stripe" {{ old('payment_method', $payment->payment_method) == 'stripe' ? 'selected' : '' }}>Stripe</option>
              <option value="wallet" {{ old('payment_method', $payment->payment_method) == 'wallet' ? 'selected' : '' }}>Wallet</option>
              <option value="coupon" {{ old('payment_method', $payment->payment_method) == 'coupon' ? 'selected' : '' }}>Coupon</option>
            </select>
            @error('payment_method')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="payment_gateway" class="form-label">Payment Gateway</label>
            <input type="text" class="form-control @error('payment_gateway') is-invalid @enderror"
                   id="payment_gateway" name="payment_gateway" value="{{ old('payment_gateway', $payment->payment_gateway) }}" placeholder="Enter payment gateway">
            @error('payment_gateway')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="transaction_id" class="form-label">Transaction ID</label>
            <input type="text" class="form-control @error('transaction_id') is-invalid @enderror"
                   id="transaction_id" name="transaction_id" value="{{ old('transaction_id', $payment->transaction_id) }}" placeholder="Enter transaction ID">
            @error('transaction_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="paid_at" class="form-label">Paid At</label>
            <input type="datetime-local" class="form-control @error('paid_at') is-invalid @enderror"
                   id="paid_at" name="paid_at" value="{{ old('paid_at', $payment->paid_at ? $payment->paid_at->format('Y-m-d\TH:i') : '') }}">
            @error('paid_at')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Leave empty if payment is not completed</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Refund Information -->
  <div class="card form-card">
    <div class="card-header">
      <h6>
        <span class="header-icon-sm"><i class="ri-refund-2-line"></i></span>
        Refund Information
      </h6>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <div class="mb-3">
            <label for="refund_amount" class="form-label">Refund Amount</label>
            <input type="number" step="0.01" class="form-control @error('refund_amount') is-invalid @enderror"
                   id="refund_amount" name="refund_amount" value="{{ old('refund_amount', $payment->refund_amount) }}" placeholder="0.00">
            @error('refund_amount')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="refunded_at" class="form-label">Refunded At</label>
            <input type="datetime-local" class="form-control @error('refunded_at') is-invalid @enderror"
                   id="refunded_at" name="refunded_at" value="{{ old('refunded_at', $payment->refunded_at ? $payment->refunded_at->format('Y-m-d\TH:i') : '') }}">
            @error('refunded_at')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="refund_reason" class="form-label">Refund Reason</label>
            <textarea class="form-control @error('refund_reason') is-invalid @enderror"
                      id="refund_reason" name="refund_reason" rows="3" placeholder="Enter refund reason">{{ old('refund_reason', $payment->refund_reason) }}</textarea>
            @error('refund_reason')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="action-buttons-wrapper">
    <a href="{{ route('admin.payments.index') }}" class="btn-cancel">
      <i class="ri-close-line"></i> Cancel
    </a>
    <button type="submit" class="btn-submit">
      <i class="ri-save-line"></i> Update Payment
    </button>
  </div>
</form>
@endsection

@section('page-script')
<script>
  // Auto-calculate total amount
  document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const taxInput = document.getElementById('tax_amount');
    const totalInput = document.getElementById('total_amount');

    function calculateTotal() {
      const amount = parseFloat(amountInput.value) || 0;
      const tax = parseFloat(taxInput.value) || 0;
      const total = amount + tax;
      totalInput.value = total.toFixed(2);
    }

    amountInput.addEventListener('input', calculateTotal);
    taxInput.addEventListener('input', calculateTotal);
  });
</script>
@endsection
