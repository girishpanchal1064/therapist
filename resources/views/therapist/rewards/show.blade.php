@extends('layouts/contentNavbarLayout')

@section('title', 'Reward Details')

@section('page-style')
<style>
  .layout-page .content-wrapper { background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important; }

  .therapist-rewards-apni .rw-detail-shell {
    border-radius: 16px;
    border: 1px solid rgba(186, 194, 210, 0.45);
    background: #fff;
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
  }
  @media (min-width: 768px) {
    .therapist-rewards-apni .rw-detail-shell { padding: 2rem 2.25rem; }
  }
  .therapist-rewards-apni .rw-detail-shell::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #647494 0%, #7484a4 50%, #647494 100%);
  }
  .therapist-rewards-apni .rw-detail-title {
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
    font-size: 1.75rem;
    font-weight: 600;
    color: #041c54;
    margin-bottom: 0.75rem;
    text-align: center;
  }
  @media (min-width: 768px) {
    .therapist-rewards-apni .rw-detail-title { font-size: 2rem; }
  }
  .therapist-rewards-apni .rw-detail-desc {
    font-size: 1rem;
    color: #7484a4;
    text-align: center;
    line-height: 1.6;
    margin-bottom: 1.5rem;
  }
  .therapist-rewards-apni .rw-terms-card {
    border-radius: 14px;
    border: 1px solid rgba(186, 194, 210, 0.45);
    background: rgba(186, 194, 210, 0.06);
    padding: 1.25rem 1.5rem;
    margin: 1.5rem 0;
  }
  .therapist-rewards-apni .rw-terms-title {
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
    font-size: 1.125rem;
    font-weight: 600;
    color: #041c54;
    text-align: center;
    margin-bottom: 1.25rem;
  }
  .therapist-rewards-apni .rw-terms-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .therapist-rewards-apni .rw-terms-list li {
    padding: 0.85rem 1rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    background: #fff;
    border-radius: 10px;
    border: 1px solid rgba(186, 194, 210, 0.35);
    border-left: 3px solid #10b981;
    color: #647494;
    font-size: 0.9375rem;
    line-height: 1.5;
  }
  .therapist-rewards-apni .rw-terms-list li:last-child { margin-bottom: 0; }
  .therapist-rewards-apni .rw-terms-list li i {
    color: #059669;
    font-size: 1.125rem;
    flex-shrink: 0;
    margin-top: 0.1rem;
  }
  .therapist-rewards-apni .rw-coupon-section {
    text-align: center;
    margin: 1.5rem 0 0;
  }
  .therapist-rewards-apni .rw-coupon-hint {
    font-size: 0.9375rem;
    color: #7484a4;
    margin-bottom: 0.75rem;
  }
  .therapist-rewards-apni .rw-coupon-code {
    display: inline-block;
    font-family: ui-monospace, monospace;
    font-size: 1.35rem;
    font-weight: 700;
    color: #041c54;
    padding: 0.85rem 1.5rem;
    border: 2px dashed rgba(4, 28, 84, 0.35);
    border-radius: 12px;
    background: rgba(4, 28, 84, 0.04);
    margin: 0.5rem 0;
    letter-spacing: 0.06em;
  }
  @media (min-width: 768px) {
    .therapist-rewards-apni .rw-coupon-code { font-size: 1.6rem; }
  }
  .therapist-rewards-apni .rw-status-pill {
    display: inline-block;
    margin-top: 0.5rem;
    padding: 0.25rem 0.65rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    background: rgba(16, 185, 129, 0.12);
    color: #047857;
    border: 1px solid rgba(16, 185, 129, 0.35);
  }
  .therapist-rewards-apni .rw-btn-claim {
    border: none;
    background: #041c54;
    color: #fff !important;
    padding: 0.85rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 12px;
    box-shadow: 0 4px 14px rgba(4, 28, 84, 0.25);
    transition: background 0.2s ease, transform 0.15s ease;
  }
  .therapist-rewards-apni .rw-btn-claim:hover:not(:disabled) {
    background: #052a66;
    color: #fff !important;
    transform: translateY(-1px);
  }
  .therapist-rewards-apni .rw-btn-claim:disabled {
    opacity: 0.55;
    cursor: not-allowed;
    transform: none;
  }
  .therapist-rewards-apni .rw-alert-error {
    border-radius: 14px;
    border: 1px solid rgba(239, 68, 68, 0.35);
    background: #fef2f2;
    color: #991b1b;
  }
</style>
@endsection

@section('content')
<div class="therapist-rewards-apni pb-2">
  <div class="relative mb-8 overflow-hidden rounded-3xl shadow-[0_20px_25px_-5px_rgba(100,116,148,0.2),0_8px_10px_-6px_rgba(100,116,148,0.2)]"
       style="background: linear-gradient(171deg, #647494 0%, #6d7f9d 25%, #7484A4 50%, #6d7f9d 75%, #647494 100%);">
    <div class="pointer-events-none absolute -right-20 top-0 h-64 w-64 rounded-full bg-white/10 blur-[64px]" aria-hidden="true"></div>
    <div class="relative z-10 flex flex-col gap-6 p-6 md:flex-row md:items-center md:justify-between md:p-8">
      <div class="min-w-0">
        <h1 class="font-display flex items-center gap-3 text-2xl font-medium leading-snug text-white md:text-3xl">
          <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[14px] bg-white/15 text-[1.5rem] backdrop-blur-sm">
            <i class="ri-gift-line"></i>
          </span>
          Reward details
        </h1>
        <p class="mt-2 max-w-xl text-base text-white/90">
          Review terms and claim your coupon code.
        </p>
      </div>
      <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
        <a href="{{ route('therapist.rewards.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] bg-white px-5 py-2.5 text-sm font-medium text-[#041C54] shadow-md transition hover:bg-[#BAC2D2]/30">
          <i class="ri-arrow-left-line text-lg"></i>
          All rewards
        </a>
        <a href="{{ route('therapist.dashboard') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] border-2 border-white px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/10">
          <i class="ri-dashboard-line text-lg"></i>
          Dashboard
        </a>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-2xl border border-[#10B981]/30 bg-[#ecfdf5] px-4 py-3 text-sm text-[#065f46] md:px-5" role="status">
      <i class="ri-checkbox-circle-fill mt-0.5 text-lg text-[#059669]"></i>
      <div class="min-w-0 flex-1">{{ session('success') }}</div>
    </div>
  @endif

  @if(session('error'))
    <div class="mb-6 flex items-start gap-3 rounded-2xl border px-4 py-3 text-sm md:px-5 rw-alert-error" role="alert">
      <i class="ri-error-warning-fill mt-0.5 text-lg text-red-600"></i>
      <div class="min-w-0 flex-1">{{ session('error') }}</div>
    </div>
  @endif

  @if(session('info'))
    <div class="mb-6 flex items-start gap-3 rounded-2xl border border-sky-200/90 bg-sky-50 px-4 py-3 text-sm text-sky-950 md:px-5" role="status">
      <i class="ri-information-line mt-0.5 text-lg text-sky-600"></i>
      <div class="min-w-0 flex-1">{{ session('info') }}</div>
    </div>
  @endif

  <div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
      <div class="rw-detail-shell">
        <h2 class="rw-detail-title">{{ $reward->title }}</h2>
        @if($reward->description)
          <p class="rw-detail-desc">{{ $reward->description }}</p>
        @else
          <p class="rw-detail-desc">Exclusive offer of {{ $reward->discount_text }} on {{ $reward->title }}</p>
        @endif

        <div class="rw-terms-card">
          <h3 class="rw-terms-title">Terms &amp; conditions</h3>
          <ul class="rw-terms-list">
            @if($reward->terms_conditions)
              @php
                $terms = explode("\n", $reward->terms_conditions);
              @endphp
              @foreach($terms as $term)
                @if(trim($term))
                  <li>
                    <i class="ri-checkbox-circle-fill"></i>
                    <span>{{ trim($term) }}</span>
                  </li>
                @endif
              @endforeach
            @else
              <li>
                <i class="ri-checkbox-circle-fill"></i>
                <span>Offer is applicable on purchase {{ $reward->title }} only.</span>
              </li>
              <li>
                <i class="ri-checkbox-circle-fill"></i>
                <span>Offer is applicable in all cities across India.</span>
              </li>
              <li>
                <i class="ri-checkbox-circle-fill"></i>
                <span>Coupon code can be used {{ $reward->can_use_multiple_times ? 'multiple times' : 'once' }}.</span>
              </li>
              <li>
                <i class="ri-checkbox-circle-fill"></i>
                <span>Offer applicable for all new and repeat users.</span>
              </li>
              <li>
                <i class="ri-checkbox-circle-fill"></i>
                <span>Coupon code valid until {{ $reward->valid_until->format('F d, Y') }}</span>
              </li>
            @endif
          </ul>
        </div>

        <div class="rw-coupon-section">
          @if($userReward)
            <p class="rw-coupon-hint">Your coupon code</p>
            <div class="rw-coupon-code">{{ $userReward->coupon_code }}</div>
            <p class="text-[#7484A4] small mt-2 mb-0">
              Status: <span class="rw-status-pill">{{ ucfirst($userReward->status) }}</span>
            </p>
            <p class="text-[#7484A4] small mt-2 mb-0">Claimed on {{ $userReward->claimed_at->format('F d, Y') }}</p>
          @else
            <p class="rw-coupon-hint">Claim this offer to receive your coupon code.</p>
            @if($reward->canBeClaimedBy(auth()->user()))
              <form action="{{ route('therapist.rewards.claim', $reward->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn rw-btn-claim">
                  <i class="ri-gift-line me-2"></i>Claim reward
                </button>
              </form>
            @else
              <button type="button" class="btn rw-btn-claim" disabled>
                <i class="ri-close-circle-line me-2"></i>Not available
              </button>
              <p class="text-danger small mt-3 mb-0">This reward cannot be claimed at this time.</p>
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
