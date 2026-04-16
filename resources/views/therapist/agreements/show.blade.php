@extends('layouts/contentNavbarLayout')

@section('title', 'View Agreement')

@section('page-style')
<style>
  .layout-page .content-wrapper { background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important; }

  .therapist-agreements-apni .agr-info-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #7484a4;
    font-weight: 600;
    margin-bottom: 0.35rem;
  }
  .therapist-agreements-apni .agr-info-value {
    font-size: 1rem;
    color: #041c54;
    font-weight: 500;
  }
  .therapist-agreements-apni .agr-card-title {
    font-family: var(--apni-font-display, 'Sora', system-ui, sans-serif);
    font-size: 1.125rem;
    font-weight: 500;
    color: #041c54;
    margin-bottom: 1rem;
  }
  .therapist-agreements-apni .agr-content-body {
    line-height: 1.75;
    color: #647494;
  }
  .therapist-agreements-apni .client-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(186, 194, 210, 0.7);
  }
</style>
@endsection

@section('content')
@php
  $agrTypeClass = function ($t) {
    return $t === 'general'
      ? 'inline-block rounded-full border border-sky-200/90 bg-sky-50 px-2.5 py-0.5 text-xs font-semibold text-sky-900'
      : 'inline-block rounded-full border border-[#041C54]/25 bg-[#041C54]/10 px-2.5 py-0.5 text-xs font-semibold text-[#041C54]';
  };
  $agrStatusClass = function ($s) {
    return match ($s) {
      'draft' => 'inline-block rounded-full border border-slate-200 bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700',
      'active' => 'inline-block rounded-full border border-emerald-200/90 bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-900',
      'signed' => 'inline-block rounded-full border border-[#041C54]/30 bg-[#041C54]/12 px-2.5 py-0.5 text-xs font-semibold text-[#041C54]',
      'expired' => 'inline-block rounded-full border border-red-200/90 bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-900',
      default => 'inline-block rounded-full border border-slate-200 bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600',
    };
  };
@endphp

<div class="therapist-agreements-apni pb-2">
  <div class="relative mb-8 overflow-hidden rounded-3xl shadow-[0_20px_25px_-5px_rgba(100,116,148,0.2),0_8px_10px_-6px_rgba(100,116,148,0.2)]"
       style="background: #041c54;">
    <div class="pointer-events-none absolute -right-20 top-0 h-64 w-64 rounded-full bg-white/10 blur-[64px]" aria-hidden="true"></div>
    <div class="relative z-10 flex flex-col gap-6 p-6 lg:flex-row lg:items-center lg:justify-between lg:p-8">
      <div class="min-w-0">
        <h1 class="font-display flex items-center gap-3 text-2xl font-medium leading-snug text-white md:text-3xl">
          <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[14px] bg-white/15 text-[1.5rem] backdrop-blur-sm">
            <i class="ri-file-paper-2-line"></i>
          </span>
          Agreement Details
        </h1>
        <p class="mt-2 max-w-xl text-base text-white/90">
          View complete agreement information.
        </p>
      </div>
      <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
        <a href="{{ route('therapist.agreements.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] bg-white px-5 py-2.5 text-sm font-medium text-[#041C54] shadow-md transition hover:bg-[#BAC2D2]/30">
          <i class="ri-arrow-left-line text-lg"></i>
          Back to agreements
        </a>
        <a href="{{ route('therapist.agreements.edit', $agreement->id) }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] border-2 border-white px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/10">
          <i class="ri-pencil-line text-lg"></i>
          Edit
        </a>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-lg-8">
      <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-5 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
        <h2 class="agr-card-title font-display text-xl">{{ $agreement->title }}</h2>
        <div class="agr-content-body">
          {!! nl2br(e($agreement->content)) !!}
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-5 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
        <h2 class="agr-card-title">Agreement information</h2>
        <div class="mb-4">
          <div class="agr-info-label">Type</div>
          <div class="agr-info-value">
            <span class="{{ $agrTypeClass($agreement->type) }}">
              {{ ucfirst(str_replace('_', ' ', $agreement->type)) }}
            </span>
          </div>
        </div>
        @if($agreement->client)
          <div class="mb-4">
            <div class="agr-info-label">Client</div>
            <div class="agr-info-value">
              <div class="d-flex align-items-center gap-2">
                @if($agreement->client->profile && $agreement->client->profile->profile_image)
                  <img src="{{ asset('storage/' . $agreement->client->profile->profile_image) }}" alt="{{ $agreement->client->name }}" class="client-avatar">
                @elseif($agreement->client->getRawOriginal('avatar'))
                  <img src="{{ asset('storage/' . $agreement->client->getRawOriginal('avatar')) }}" alt="{{ $agreement->client->name }}" class="client-avatar">
                @else
                  <img src="https://ui-avatars.com/api/?name={{ urlencode($agreement->client->name) }}&background=647494&color=fff&size=80&bold=true&format=svg" alt="{{ $agreement->client->name }}" class="client-avatar">
                @endif
                <span>{{ $agreement->client->name }}</span>
              </div>
            </div>
          </div>
        @endif
        <div class="mb-4">
          <div class="agr-info-label">Status</div>
          <div class="agr-info-value">
            <span class="{{ $agrStatusClass($agreement->status) }}">
              {{ ucfirst($agreement->status) }}
            </span>
          </div>
        </div>
        @if($agreement->effective_date)
          <div class="mb-4">
            <div class="agr-info-label">Effective date</div>
            <div class="agr-info-value">{{ $agreement->effective_date->format('M d, Y') }}</div>
          </div>
        @endif
        @if($agreement->expiry_date)
          <div class="mb-4">
            <div class="agr-info-label">Expiry date</div>
            <div class="agr-info-value">{{ $agreement->expiry_date->format('M d, Y') }}</div>
          </div>
        @endif
        @if($agreement->signed_date)
          <div class="mb-4">
            <div class="agr-info-label">Signed date</div>
            <div class="agr-info-value">{{ $agreement->signed_date->format('M d, Y') }}</div>
          </div>
        @endif
        <div class="mb-3">
          <div class="agr-info-label">Created at</div>
          <div class="agr-info-value" style="font-size: 0.9375rem;">{{ $agreement->created_at->format('M d, Y H:i') }}</div>
        </div>
        <div class="mb-0">
          <div class="agr-info-label">Last updated</div>
          <div class="agr-info-value" style="font-size: 0.9375rem;">{{ $agreement->updated_at->format('M d, Y H:i') }}</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
