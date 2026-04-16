@extends('layouts/contentNavbarLayout')

@section('title', 'View Session Note')

@section('page-style')
<style>
  .layout-page .content-wrapper { background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important; }

  .therapist-session-notes-apni .sn-info-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #7484a4;
    font-weight: 600;
    margin-bottom: 0.35rem;
  }
  .therapist-session-notes-apni .sn-info-value {
    font-size: 1rem;
    color: #041c54;
    font-weight: 500;
  }
  .therapist-session-notes-apni .sn-session-badge {
    display: inline-block;
    padding: 0.25rem 0.65rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.8rem;
    background: rgba(4, 28, 84, 0.08);
    color: #041c54;
  }
  .therapist-session-notes-apni .sn-pill {
    display: inline-block;
    padding: 0.25rem 0.65rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
  }
  .therapist-session-notes-apni .sn-card-title {
    font-family: inherit;
    font-size: 1.125rem;
    font-weight: 500;
    color: #041c54;
    margin-bottom: 1rem;
  }
  .therapist-session-notes-apni .sn-body-text {
    color: #647494;
    line-height: 1.6;
    margin: 0;
  }
</style>
@endsection

@section('content')
<div class="therapist-session-notes-apni pb-2">
  <div class="relative mb-8 overflow-hidden rounded-3xl shadow-[0_20px_25px_-5px_rgba(100,116,148,0.2),0_8px_10px_-6px_rgba(100,116,148,0.2)]"
       style="background: #041c54;">
    <div class="pointer-events-none absolute -right-20 top-0 h-64 w-64 rounded-full bg-white/10 blur-[64px]" aria-hidden="true"></div>
    <div class="relative z-10 flex flex-col gap-6 p-6 lg:flex-row lg:items-center lg:justify-between lg:p-8">
      <div class="min-w-0">
        <h1 class="font-display flex items-center gap-3 text-2xl font-medium leading-snug text-white md:text-3xl">
          <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[14px] bg-white/15 text-[1.5rem] backdrop-blur-sm">
            <i class="ri-file-text-line"></i>
          </span>
          Session Note Details
        </h1>
        <p class="mt-2 max-w-xl text-base text-white/90">
          View complete session note information.
        </p>
      </div>
      <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
        <a href="{{ route('therapist.session-notes.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] bg-white px-5 py-2.5 text-sm font-medium text-[#041C54] shadow-md transition hover:bg-[#BAC2D2]/30">
          <i class="ri-arrow-left-line text-lg"></i>
          Back to notes
        </a>
        <a href="{{ route('therapist.session-notes.edit', $sessionNote->id) }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] border-2 border-white px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/10">
          <i class="ri-pencil-line text-lg"></i>
          Edit
        </a>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-lg-8">
      <div class="mb-4 rounded-2xl border border-[#BAC2D2]/30 bg-white p-5 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
        <h2 class="sn-card-title mb-4">Session Information</h2>
        <div class="row g-4">
          <div class="col-md-6">
            <div class="sn-info-label">Client Name</div>
            <div class="sn-info-value">{{ $sessionNote->client->name ?? 'N/A' }}</div>
          </div>
          <div class="col-md-6">
            <div class="sn-info-label">Session ID</div>
            <div class="sn-info-value">
              @if($sessionNote->appointment)
                <span class="sn-session-badge">S-{{ $sessionNote->appointment->id }}</span>
              @else
                <span class="text-[#BAC2D2]">N/A</span>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="sn-info-label">Session Date</div>
            <div class="sn-info-value">{{ $sessionNote->session_date ? $sessionNote->session_date->format('Y-m-d') : 'N/A' }}</div>
          </div>
          <div class="col-md-6">
            <div class="sn-info-label">Start Time</div>
            <div class="sn-info-value">{{ $sessionNote->start_time ? \Carbon\Carbon::parse($sessionNote->start_time)->format('H:i:s') : 'N/A' }}</div>
          </div>
        </div>
      </div>

      <div class="mb-4 rounded-2xl border border-[#BAC2D2]/30 bg-white p-5 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
        <h2 class="sn-card-title">Chief Complaints</h2>
        <p class="sn-body-text">{{ $sessionNote->chief_complaints }}</p>
      </div>

      <div class="mb-4 rounded-2xl border border-[#BAC2D2]/30 bg-white p-5 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
        <h2 class="sn-card-title">Observations</h2>
        <p class="sn-body-text">{{ $sessionNote->observations }}</p>
      </div>

      <div class="mb-4 rounded-2xl border border-[#BAC2D2]/30 bg-white p-5 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
        <h2 class="sn-card-title">Recommendations</h2>
        <p class="sn-body-text">{{ $sessionNote->recommendations }}</p>
      </div>

      @if($sessionNote->reason)
        <div class="mb-4 rounded-2xl border border-[#BAC2D2]/30 bg-white p-5 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
          <h2 class="sn-card-title">Reason</h2>
          <p class="sn-body-text">{{ $sessionNote->reason }}</p>
        </div>
      @endif
    </div>

    <div class="col-lg-4">
      <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-5 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)] sm:p-6">
        <h2 class="sn-card-title">Additional Information</h2>
        <div class="mb-4">
          <div class="sn-info-label">User Didn't Turn Up</div>
          <div class="sn-info-value">
            @if($sessionNote->user_didnt_turn_up)
              <span class="sn-pill bg-red-50 text-red-700 border border-red-200/80">Yes</span>
            @else
              <span class="sn-pill bg-emerald-50 text-emerald-800 border border-emerald-200/80">No</span>
            @endif
          </div>
        </div>
        <div class="mb-4">
          <div class="sn-info-label">No Follow-up Required</div>
          <div class="sn-info-value">
            @if($sessionNote->no_follow_up_required)
              <span class="sn-pill bg-amber-50 text-amber-900 border border-amber-200/80">Yes</span>
            @else
              <span class="sn-pill bg-sky-50 text-sky-900 border border-sky-200/80">No</span>
            @endif
          </div>
        </div>
        @if($sessionNote->follow_up_date)
          <div class="mb-4">
            <div class="sn-info-label">Follow-up Date</div>
            <div class="sn-info-value">{{ $sessionNote->follow_up_date->format('Y-m-d') }}</div>
          </div>
        @endif
        <div class="mb-3">
          <div class="sn-info-label">Created At</div>
          <div class="sn-info-value" style="font-size: 0.9375rem;">{{ $sessionNote->created_at->format('M d, Y H:i') }}</div>
        </div>
        <div class="mb-0">
          <div class="sn-info-label">Last Updated</div>
          <div class="sn-info-value" style="font-size: 0.9375rem;">{{ $sessionNote->updated_at->format('M d, Y H:i') }}</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
