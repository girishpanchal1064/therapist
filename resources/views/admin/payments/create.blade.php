@extends('layouts/contentNavbarLayout')

@section('title', 'Create Payment')

@section('page-style')
<style>
@include('admin.payments.partials.payment-form-css')
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex align-items-center gap-3">
    <div class="header-icon">
      <i class="ri-add-circle-line"></i>
    </div>
    <div>
      <h4 class="mb-1">Create Payment</h4>
      <p class="mb-0">Record a manual payment (linked to an appointment or wallet)</p>
    </div>
  </div>
</div>

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<form action="{{ route('admin.payments.store') }}" method="POST">
  @csrf

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
                <option value="{{ $user->id }}" {{ (string) old('user_id') === (string) $user->id ? 'selected' : '' }}>
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
              <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
              <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
              <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
              <option value="refunded" {{ old('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="payable_type" class="form-label">Related to <span class="text-danger">*</span></label>
            <select name="payable_type" id="payable_type" class="form-select @error('payable_type') is-invalid @enderror" required>
              <option value="">Select type</option>
              <option value="{{ \App\Models\Appointment::class }}" {{ old('payable_type') == \App\Models\Appointment::class ? 'selected' : '' }}>Appointment</option>
              <option value="{{ \App\Models\Wallet::class }}" {{ old('payable_type') == \App\Models\Wallet::class ? 'selected' : '' }}>Wallet (recharge)</option>
            </select>
            @error('payable_type')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Must match an existing appointment or wallet ID below.</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="payable_id" class="form-label">Related record ID <span class="text-danger">*</span></label>
            <input type="number" min="1" class="form-control @error('payable_id') is-invalid @enderror"
                   id="payable_id" name="payable_id" value="{{ old('payable_id') }}" placeholder="e.g. appointment or wallet id" required>
            @error('payable_id')
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
                   id="amount" name="amount" value="{{ old('amount') }}" placeholder="0.00" required>
            @error('amount')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="tax_amount" class="form-label">Tax Amount</label>
            <input type="number" step="0.01" class="form-control @error('tax_amount') is-invalid @enderror"
                   id="tax_amount" name="tax_amount" value="{{ old('tax_amount', '0') }}" placeholder="0.00">
            @error('tax_amount')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="total_amount" class="form-label">Total Amount <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control @error('total_amount') is-invalid @enderror"
                   id="total_amount" name="total_amount" value="{{ old('total_amount') }}" placeholder="0.00" required>
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
              <option value="INR" {{ old('currency', 'INR') == 'INR' ? 'selected' : '' }}>INR</option>
              <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
              <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
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
              <option value="razorpay" {{ old('payment_method', 'razorpay') == 'razorpay' ? 'selected' : '' }}>Razorpay</option>
              <option value="stripe" {{ old('payment_method') == 'stripe' ? 'selected' : '' }}>Stripe</option>
              <option value="wallet" {{ old('payment_method') == 'wallet' ? 'selected' : '' }}>Wallet</option>
              <option value="coupon" {{ old('payment_method') == 'coupon' ? 'selected' : '' }}>Coupon</option>
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
                   id="payment_gateway" name="payment_gateway" value="{{ old('payment_gateway') }}" placeholder="Optional">
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
                   id="transaction_id" name="transaction_id" value="{{ old('transaction_id') }}" placeholder="Optional">
            @error('transaction_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="paid_at" class="form-label">Paid At</label>
            <input type="datetime-local" class="form-control @error('paid_at') is-invalid @enderror"
                   id="paid_at" name="paid_at" value="{{ old('paid_at') }}">
            @error('paid_at')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Leave empty if payment is not completed</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="action-buttons-wrapper">
    <a href="{{ route('admin.payments.index') }}" class="btn-cancel">
      <i class="ri-close-line"></i> Cancel
    </a>
    <button type="submit" class="btn-submit">
      <i class="ri-save-line"></i> Create Payment
    </button>
  </div>
</form>
@endsection

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const taxInput = document.getElementById('tax_amount');
    const totalInput = document.getElementById('total_amount');

    function calculateTotal() {
      const amount = parseFloat(amountInput.value) || 0;
      const tax = parseFloat(taxInput.value) || 0;
      totalInput.value = (amount + tax).toFixed(2);
    }

    amountInput.addEventListener('input', calculateTotal);
    taxInput.addEventListener('input', calculateTotal);
  });
</script>
@endsection
