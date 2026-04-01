@extends('layouts/contentNavbarLayout')

@section('title', 'Rewards')

@section('page-style')
<style>
  .layout-page .content-wrapper { background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important; }

  .therapist-rewards-apni .rw-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid rgba(186, 194, 210, 0.45);
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    height: 100%;
    position: relative;
    overflow: hidden;
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
  }
  .therapist-rewards-apni .rw-card:hover {
    box-shadow: 0 16px 28px rgba(4, 28, 84, 0.08);
    border-color: rgba(100, 116, 148, 0.35);
  }
  .therapist-rewards-apni .rw-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #647494 0%, #7484a4 50%, #647494 100%);
  }
  .therapist-rewards-apni .rw-card-featured {
    border-color: rgba(245, 158, 11, 0.45);
  }
  .therapist-rewards-apni .rw-card-featured::before {
    background: linear-gradient(90deg, #d97706 0%, #f59e0b 50%, #d97706 100%);
  }
  .therapist-rewards-apni .rw-card-inner {
    padding: 1.5rem;
  }
  @media (min-width: 768px) {
    .therapist-rewards-apni .rw-card-inner { padding: 1.75rem; }
  }
  .therapist-rewards-apni .rw-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 1rem;
  }
  .therapist-rewards-apni .rw-title {
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
    font-size: 1.25rem;
    font-weight: 600;
    color: #041c54;
    margin: 0;
    line-height: 1.35;
  }
  .therapist-rewards-apni .rw-badge-featured {
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.3rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.7rem;
    font-weight: 600;
    background: rgba(245, 158, 11, 0.15);
    color: #b45309;
    border: 1px solid rgba(245, 158, 11, 0.35);
  }
  .therapist-rewards-apni .rw-desc {
    color: #7484a4;
    font-size: 0.9375rem;
    line-height: 1.55;
    margin-bottom: 1.25rem;
    min-height: 2.8rem;
  }
  .therapist-rewards-apni .rw-discount-box {
    background: rgba(186, 194, 210, 0.12);
    border: 2px dashed rgba(4, 28, 84, 0.2);
    border-radius: 12px;
    padding: 1.25rem;
    margin-bottom: 1.25rem;
    text-align: center;
  }
  .therapist-rewards-apni .rw-discount-label {
    font-size: 0.72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #7484a4;
    margin-bottom: 0.35rem;
  }
  .therapist-rewards-apni .rw-discount {
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
    font-size: 2rem;
    font-weight: 600;
    color: #041c54;
    margin: 0;
    line-height: 1.2;
  }
  .therapist-rewards-apni .rw-footer {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(186, 194, 210, 0.45);
  }
  .therapist-rewards-apni .rw-validity {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #647494;
    font-size: 0.875rem;
  }
  .therapist-rewards-apni .rw-validity i {
    color: #7484a4;
  }
  .therapist-rewards-apni .rw-btn-view {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.65rem 1.35rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    background: #041c54;
    color: #fff !important;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.2);
    transition: background 0.2s ease, transform 0.15s ease;
  }
  .therapist-rewards-apni .rw-btn-view:hover {
    background: #052a66;
    color: #fff !important;
    transform: translateY(-1px);
  }
  .therapist-rewards-apni .empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
    border-radius: 16px;
    border: 1px solid rgba(186, 194, 210, 0.45);
    background: #fff;
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05);
  }
  .therapist-rewards-apni .empty-state i {
    font-size: 3.5rem;
    color: #647494;
    margin-bottom: 1rem;
    display: block;
  }
  .therapist-rewards-apni .empty-state h2 {
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
    font-size: 1.25rem;
    font-weight: 600;
    color: #041c54;
    margin-bottom: 0.5rem;
  }
  .therapist-rewards-apni .empty-state p {
    color: #7484a4;
    margin: 0;
  }
  .therapist-rewards-apni .pagination-wrap {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(186, 194, 210, 0.45);
  }
  .therapist-rewards-apni .pagination-wrap .pagination { margin-bottom: 0; }
  .therapist-rewards-apni .page-link {
    color: #041c54;
    border-color: rgba(186, 194, 210, 0.85);
    border-radius: 8px !important;
    margin: 0 2px;
  }
  .therapist-rewards-apni .page-item.active .page-link {
    background: #041c54;
    border-color: #041c54;
    color: #fff;
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
          Rewards &amp; offers
        </h1>
        <p class="mt-2 max-w-xl text-base text-white/90">
          Claim exclusive rewards and discounts for your practice.
        </p>
      </div>
      <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:items-center">
        <a href="{{ route('therapist.dashboard') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] bg-white px-5 py-2.5 text-sm font-medium text-[#041C54] shadow-md transition hover:bg-[#BAC2D2]/30">
          <i class="ri-dashboard-line text-lg"></i>
          Dashboard
        </a>
        <a href="{{ route('therapist.profile.index', ['tab' => 'basic-info']) }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] border-2 border-white px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/10">
          <i class="ri-user-settings-line text-lg"></i>
          Profile
        </a>
      </div>
    </div>
  </div>

  @if($rewards->count() > 0)
    <div class="row g-4">
      @foreach($rewards as $reward)
        <div class="col-md-6 col-lg-4">
          <div class="rw-card {{ $reward->is_featured ? 'rw-card-featured' : '' }}">
            <div class="rw-card-inner">
              <div class="rw-header">
                <h3 class="rw-title">{{ $reward->title }}</h3>
                @if($reward->is_featured)
                  <span class="rw-badge-featured">
                    <i class="ri-star-fill"></i> Featured
                  </span>
                @endif
              </div>
              <p class="rw-desc">
                {{ $reward->description ?: 'Exclusive offer of ' . $reward->discount_text . ' on ' . $reward->title }}
              </p>
              <div class="rw-discount-box">
                <div class="rw-discount-label">Discount</div>
                <div class="rw-discount">{{ $reward->discount_text }}</div>
              </div>
              <div class="rw-footer">
                <div class="rw-validity">
                  <i class="ri-calendar-line"></i>
                  <span>Valid until {{ $reward->valid_until->format('M d, Y') }}</span>
                </div>
                <a href="{{ route('therapist.rewards.show', $reward->id) }}" class="rw-btn-view">
                  View details
                </a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    @if($rewards->hasPages())
      <div class="pagination-wrap">
        <div class="text-sm text-[#7484A4]">
          Showing {{ $rewards->firstItem() }}–{{ $rewards->lastItem() }} of {{ $rewards->total() }}
        </div>
        <div>{{ $rewards->links() }}</div>
      </div>
    @endif
  @else
    <div class="empty-state">
      <i class="ri-gift-line"></i>
      <h2>No rewards available</h2>
      <p>Check back later for new offers.</p>
    </div>
  @endif
</div>
@endsection
