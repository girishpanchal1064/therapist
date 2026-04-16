@extends('layouts/contentNavbarLayout')

@section('title', 'Payment Details')

@section('page-style')
<style>
  .layout-page .content-wrapper {
    background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important;
  }
  .page-header {
    background: linear-gradient(90deg, #041C54 0%, #2f4a76 55%, #647494 100%);
    border-radius: 24px;
    padding: 1.75rem 2rem;
    margin-bottom: 1.5rem;
    color: #fff;
  }
  .page-header h4 { color: #fff; font-weight: 700; margin: 0; }
  .page-header p { margin: 0.35rem 0 0; opacity: 0.9; }
  .detail-card {
    border: 1px solid rgba(186, 194, 210, 0.35);
    border-radius: 16px;
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05);
  }
  .detail-card .card-body { padding: 1.5rem; }
  .detail-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em; color: #7484a4; font-weight: 600; margin-bottom: 0.25rem; }
  .detail-value { font-size: 1rem; color: #041C54; font-weight: 600; }
</style>
@endsection

@section('content')
@php
  $payment->loadMissing(['user', 'payable']);
@endphp
<div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
  <div>
    <h4><i class="ri-bank-card-line me-2"></i>Payment #{{ $payment->id }}</h4>
    <p class="mb-0">{{ $payment->transaction_id ?: 'No transaction ID' }}</p>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-light"><i class="ri-pencil-line me-1"></i> Edit</a>
    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-light"><i class="ri-arrow-left-line me-1"></i> Back</a>
  </div>
</div>

<div class="card detail-card">
  <div class="card-body">
    <div class="row g-4">
      <div class="col-md-6">
        <div class="detail-label">User</div>
        <div class="detail-value">
          @if($payment->user)
            {{ $payment->user->name }} — {{ $payment->user->email }}
          @else
            <span class="text-muted">—</span>
          @endif
        </div>
      </div>
      <div class="col-md-6">
        <div class="detail-label">Status</div>
        <div class="detail-value text-capitalize">{{ $payment->status }}</div>
      </div>
      <div class="col-md-6">
        <div class="detail-label">Amount / Tax / Total</div>
        <div class="detail-value">
          ₹{{ number_format($payment->amount, 2) }} + ₹{{ number_format($payment->tax_amount ?? 0, 2) }} = ₹{{ number_format($payment->total_amount, 2) }} {{ $payment->currency }}
        </div>
      </div>
      <div class="col-md-6">
        <div class="detail-label">Method</div>
        <div class="detail-value text-capitalize">{{ str_replace('_', ' ', $payment->payment_method) }}</div>
      </div>
      <div class="col-md-6">
        <div class="detail-label">Payable</div>
        <div class="detail-value">
          {{ $payment->payable_type ? class_basename($payment->payable_type) : '—' }}
          @if($payment->payable_id) #{{ $payment->payable_id }} @endif
        </div>
      </div>
      <div class="col-md-6">
        <div class="detail-label">Paid at</div>
        <div class="detail-value">{{ $payment->paid_at ? $payment->paid_at->format('M d, Y H:i') : '—' }}</div>
      </div>
    </div>
  </div>
</div>
@endsection
