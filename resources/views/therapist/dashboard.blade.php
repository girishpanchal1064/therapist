@extends('layouts/contentNavbarLayout')

@section('title', 'Therapist Dashboard')

@section('page-style')
<style>
  /* Page background behind cards (Figma: gradient page shell) */
  .layout-page .content-wrapper { background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important; }
</style>
@endsection

@section('content')
@php
  $hour = \Carbon\Carbon::now('Asia/Kolkata')->hour;
  $greeting = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');
  $therapistName = auth()->user()->name;
@endphp

<div class="therapist-dashboard-apni pb-2">
  {{-- Welcome banner — Figma 2:7 Lynch gradient --}}
  <div class="theme-header-bar relative mb-8 overflow-hidden rounded-3xl shadow-[0_20px_25px_-5px_rgba(100,116,148,0.2),0_8px_10px_-6px_rgba(100,116,148,0.2)]"
       style="background: linear-gradient(171deg, #647494 0%, #6d7f9d 25%, #7484A4 50%, #6d7f9d 75%, #647494 100%);">
    <div class="pointer-events-none absolute -right-20 top-0 h-64 w-64 rounded-full bg-white/10 blur-[64px]" aria-hidden="true"></div>
    <div class="relative z-10 flex flex-col gap-6 p-6 md:flex-row md:items-center md:justify-between md:p-8">
      <div class="min-w-0">
        <h1 class="font-display text-2xl font-medium leading-snug text-white md:text-3xl">
          {{ $greeting }}, Dr. {{ $therapistName }}! 👋
        </h1>
        <p class="mt-2 max-w-xl text-base text-white/90">
          Here's your practice overview for today. You're making a difference!
        </p>
      </div>
      <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:items-center">
        <a href="{{ route('therapist.availability.set') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] bg-white px-5 py-2.5 text-sm font-medium text-[#041C54] shadow-md transition hover:bg-[#BAC2D2]/30">
          <i class="ri-calendar-schedule-line text-lg"></i>
          Manage Availability
        </a>
        <a href="{{ route('therapist.sessions.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-[14px] border-2 border-white px-5 py-2.5 text-sm font-medium text-white transition hover:bg-white/10">
          <i class="ri-video-line text-lg"></i>
          View All Sessions
        </a>
      </div>
    </div>
  </div>

  {{-- Stats row — Figma 2:29 --}}
  <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
      <div class="flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#10B981]/10">
        <i class="ri-calendar-todo-line text-2xl text-[#10B981]"></i>
      </div>
      <p class="mt-4 text-sm text-[#7484A4]">Today's Sessions</p>
      <p class="font-display mt-1 text-3xl font-medium text-[#041C54]">{{ $todayAppointments->count() }}</p>
      <p class="mt-2 text-xs text-[#7484A4]">{{ $todayAppointments->count() > 0 ? 'Sessions scheduled' : 'No sessions today' }}</p>
    </div>
    <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
      <div class="flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#06B6D4]/10">
        <i class="ri-check-double-line text-2xl text-[#0891b2]"></i>
      </div>
      <p class="mt-4 text-sm text-[#7484A4]">Completed This Month</p>
      <p class="font-display mt-1 text-3xl font-medium text-[#041C54]">{{ $completedThisMonth }}</p>
      <p class="mt-2 text-xs text-[#7484A4]">Great progress!</p>
    </div>
    <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
      <div class="flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#F59E0B]/10">
        <i class="ri-money-rupee-circle-line text-2xl text-[#d97706]"></i>
      </div>
      <p class="mt-4 text-sm text-[#7484A4]">Monthly Earnings</p>
      <p class="font-display mt-1 text-3xl font-medium text-[#041C54]">₹{{ number_format($monthlyEarnings, 0) }}</p>
      <p class="mt-2 text-xs text-[#7484A4]">This month</p>
    </div>
    <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
      <div class="flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#647494]/10">
        <i class="ri-star-line text-2xl text-[#647494]"></i>
      </div>
      <p class="mt-4 text-sm text-[#7484A4]">Pending Reviews</p>
      <p class="font-display mt-1 text-3xl font-medium text-[#041C54]">{{ $pendingReviews }}</p>
      <p class="mt-2 text-xs text-[#7484A4]">Awaiting feedback</p>
    </div>
  </div>

  @if($todayAppointments->count() > 0)
  <div class="mb-8 rounded-2xl border border-[#F59E0B]/30 bg-amber-50/80 px-4 py-3 text-sm text-amber-900 md:px-5">
    <span class="font-medium"><i class="ri-calendar-check-fill me-1"></i>You have {{ $todayAppointments->count() }} session(s) today.</span>
    <span class="text-amber-800/90"> Prepare and join on time for the best client experience.</span>
  </div>
  @endif

  <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
    {{-- Today's Sessions — Figma 2:80 --}}
    <div class="flex flex-col rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
      <div class="mb-6 flex items-center gap-2">
        <i class="ri-calendar-todo-line text-xl text-[#10B981]"></i>
        <h2 class="font-display text-xl font-medium text-[#041C54]">Today's Sessions</h2>
        @if($todayAppointments->count() > 0)
          <span class="ms-auto rounded-full bg-[#10B981]/15 px-2.5 py-0.5 text-xs font-medium text-[#059669]">{{ $todayAppointments->count() }} session(s)</span>
        @endif
      </div>
      <div class="custom-scroll max-h-[min(28rem,60vh)] flex-1 overflow-y-auto pr-1">
        @if($todayAppointments->count() > 0)
          <div class="space-y-4">
            @foreach($todayAppointments as $appointment)
              <div class="rounded-[14px] border border-[#BAC2D2]/30 bg-[#BAC2D2]/5 p-4">
                <div class="flex flex-wrap items-start gap-3">
                  @if($appointment->client)
                    @if($appointment->client->profile && $appointment->client->profile->profile_image)
                      <img src="{{ asset('storage/' . $appointment->client->profile->profile_image) }}" alt="" class="h-12 w-12 shrink-0 rounded-full border-2 border-white object-cover shadow-sm">
                    @elseif($appointment->client->getRawOriginal('avatar'))
                      <img src="{{ asset('storage/' . $appointment->client->getRawOriginal('avatar')) }}" alt="" class="h-12 w-12 shrink-0 rounded-full border-2 border-white object-cover shadow-sm">
                    @else
                      <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->client->name ?? 'U') }}&background=647494&color=fff&size=96&bold=true&format=svg" alt="" class="h-12 w-12 shrink-0 rounded-full border-2 border-white object-cover shadow-sm">
                    @endif
                  @else
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#647494] text-sm font-semibold text-white">U</div>
                  @endif
                  <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                      <p class="font-display font-medium text-[#041C54]">{{ $appointment->client?->name ?? 'Unknown Client' }}</p>
                      <span class="rounded-md bg-[#3B82F6]/10 px-2 py-0.5 text-[0.65rem] font-semibold uppercase tracking-wide text-[#2563eb]">{{ strtoupper($appointment->session_mode) }}</span>
                      <span class="rounded-md bg-[#F59E0B]/15 px-2 py-0.5 text-[0.65rem] font-semibold uppercase tracking-wide text-[#b45309]">{{ ucfirst($appointment->status) }}</span>
                    </div>
                    <p class="mt-1 text-sm text-[#7484A4]">{{ \Carbon\Carbon::parse($appointment->appointment_time, 'Asia/Kolkata')->setTimezone('Asia/Kolkata')->format('g:i A') }} IST · {{ $appointment->duration_minutes ?? 60 }} mins</p>
                  </div>
                </div>
                @php
                  $timeString = is_string($appointment->appointment_time)
                      ? $appointment->appointment_time
                      : (is_object($appointment->appointment_time)
                          ? $appointment->appointment_time->format('H:i:s')
                          : $appointment->appointment_time);
                  if (strlen($timeString) > 8 || strpos($timeString, '-') !== false) {
                      try {
                          $parsedTime = \Carbon\Carbon::parse($timeString, 'Asia/Kolkata');
                          $timeString = $parsedTime->format('H:i:s');
                      } catch (\Exception $e) {
                          if (preg_match('/(\d{2}:\d{2}:\d{2})/', $timeString, $matches)) {
                              $timeString = $matches[1];
                          } elseif (preg_match('/(\d{2}:\d{2})/', $timeString, $matches)) {
                              $timeString = $matches[1] . ':00';
                          }
                      }
                  }
                  if (strlen($timeString) <= 5) {
                      $timeString = $timeString . ':00';
                  }
                  $appointmentDateTime = \Carbon\Carbon::parse($appointment->appointment_date->format('Y-m-d') . ' ' . $timeString, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
                  $nowIST = \Carbon\Carbon::now('Asia/Kolkata');
                  $canJoin = $appointmentDateTime->diffInMinutes($nowIST, false) >= -5;
                  $sessionEndTime = $appointmentDateTime->copy()->addMinutes($appointment->duration_minutes ?? 60);
                  $isSessionExpired = $nowIST->greaterThan($sessionEndTime);
                  $isActiveTherapist = $canJoin && !$isSessionExpired && in_array($appointment->session_mode, ['video', 'audio']) && (
                      in_array($appointment->status, ['confirmed', 'in_progress']) ||
                      ($appointment->status === 'scheduled' && $appointmentDateTime->lessThan(\Carbon\Carbon::now('Asia/Kolkata')))
                  );
                @endphp
                <div class="mt-3">
                  @if($isActiveTherapist)
                    <a href="{{ route('sessions.join', $appointment->id) }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-[10px] bg-[#10B981] py-2.5 text-sm font-medium text-white transition hover:bg-[#059669]">
                      <i class="ri-{{ $appointment->session_mode === 'video' ? 'video' : 'mic' }}-line"></i>
                      Join Session
                    </a>
                  @elseif($isSessionExpired)
                    <button type="button" class="w-full cursor-not-allowed rounded-[10px] border border-[#BAC2D2]/40 bg-[#BAC2D2]/10 py-2 text-xs text-[#7484A4]" disabled>
                      <i class="ri-timer-line me-1"></i>Session ended
                    </button>
                  @else
                    <button type="button" class="w-full cursor-not-allowed rounded-[10px] border border-[#BAC2D2]/40 bg-white py-2 text-xs text-[#7484A4]" disabled>
                      <i class="ri-time-line me-1"></i>Available {{ $appointmentDateTime->copy()->subMinutes(5)->diffForHumans() }}
                    </button>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="flex flex-col items-center justify-center py-10 text-center">
            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-[#BAC2D2]/20">
              <i class="ri-calendar-line text-4xl text-[#7484A4]"></i>
            </div>
            <p class="mt-6 font-medium text-[#041C54]">No sessions scheduled for today</p>
            <p class="mt-2 max-w-sm text-sm text-[#7484A4]">Enjoy your free time or review upcoming appointments.</p>
          </div>
        @endif
      </div>
    </div>

    {{-- Upcoming — Figma 2:100 (card rows) --}}
    <div class="flex flex-col rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
      <div class="mb-6 flex items-center justify-between gap-3">
        <div class="flex items-center gap-2">
          <i class="ri-time-line text-xl text-[#647494]"></i>
          <h2 class="font-display text-xl font-medium text-[#041C54]">Upcoming (Next 7 Days)</h2>
        </div>
        <a href="{{ route('therapist.sessions.index', ['status' => 'upcoming']) }}" class="text-sm font-medium text-[#647494] transition hover:text-[#041C54]">View All</a>
      </div>
      <div class="custom-scroll max-h-[min(28rem,60vh)] flex-1 space-y-3 overflow-y-auto pr-1">
        @if($upcomingAppointments->count() > 0)
          @foreach($upcomingAppointments->take(6) as $appointment)
            <div class="flex flex-wrap items-center justify-between gap-3 rounded-[14px] border border-[#BAC2D2]/30 bg-[#BAC2D2]/10 px-4 py-3">
              <div class="flex min-w-0 items-center gap-3">
                @if($appointment->client)
                  @if($appointment->client->profile && $appointment->client->profile->profile_image)
                    <img src="{{ asset('storage/' . $appointment->client->profile->profile_image) }}" alt="" class="h-12 w-12 shrink-0 rounded-full border-2 border-white object-cover shadow-sm">
                  @elseif($appointment->client->getRawOriginal('avatar'))
                    <img src="{{ asset('storage/' . $appointment->client->getRawOriginal('avatar')) }}" alt="" class="h-12 w-12 shrink-0 rounded-full border-2 border-white object-cover shadow-sm">
                  @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->client->name ?? 'U') }}&background=647494&color=fff&size=96&bold=true&format=svg" alt="" class="h-12 w-12 shrink-0 rounded-full border-2 border-white object-cover shadow-sm">
                  @endif
                @else
                  <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#647494] text-sm font-semibold text-white">U</div>
                @endif
                <div class="min-w-0">
                  <p class="font-display font-medium text-[#041C54]">{{ $appointment->client?->name ?? 'Unknown' }}</p>
                  <span class="text-xs font-semibold uppercase tracking-wide text-[#647494]">{{ strtoupper($appointment->session_mode) }}</span>
                </div>
              </div>
              <div class="text-end text-sm">
                <p class="font-medium text-[#041C54]">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</p>
                <p class="text-[#7484A4]">{{ \Carbon\Carbon::parse($appointment->appointment_time, 'Asia/Kolkata')->setTimezone('Asia/Kolkata')->format('g:i A') }} IST</p>
                <span class="mt-1 inline-block rounded-md bg-[#F59E0B]/15 px-2 py-0.5 text-[0.65rem] font-semibold uppercase tracking-wide text-[#b45309]">{{ strtoupper($appointment->status) }}</span>
              </div>
            </div>
          @endforeach
          @if($upcomingAppointments->count() > 6)
            <div class="pt-2 text-center">
              <a href="{{ route('therapist.sessions.index', ['status' => 'upcoming']) }}" class="text-sm font-medium text-[#647494] hover:text-[#041C54]">View all {{ $upcomingAppointments->count() }} upcoming</a>
            </div>
          @endif
        @else
          <div class="flex flex-col items-center justify-center py-10 text-center">
            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-[#BAC2D2]/20">
              <i class="ri-calendar-schedule-line text-4xl text-[#7484A4]"></i>
            </div>
            <p class="mt-6 font-medium text-[#041C54]">No upcoming sessions</p>
            <p class="mt-2 max-w-sm text-sm text-[#7484A4]">You have no sessions scheduled for the next 7 days.</p>
          </div>
        @endif
      </div>
    </div>
  </div>

  {{-- Quick Actions — Figma --}}
  <div class="mb-8 rounded-2xl border border-[#BAC2D2]/30 bg-white p-6 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
    <div class="mb-6 flex items-center gap-2">
      <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#F59E0B]/10 text-[#d97706]"><i class="ri-settings-3-line"></i></span>
      <h2 class="font-display text-xl font-medium text-[#041C54]">Quick Actions</h2>
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
      <a href="{{ route('therapist.profile.index') }}" class="group rounded-2xl border border-[#BAC2D2]/30 bg-white p-5 text-center shadow-sm transition hover:border-[#647494]/40 hover:shadow-md">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#8B5CF6]/10 text-[#8B5CF6] transition group-hover:bg-[#8B5CF6]/15">
          <i class="ri-user-settings-line text-xl"></i>
        </div>
        <p class="font-display mt-4 font-medium text-[#041C54]">Edit Profile</p>
        <p class="mt-1 text-xs text-[#7484A4]">Update your information</p>
      </a>
      <a href="{{ route('therapist.availability.set') }}" class="group rounded-2xl border border-[#BAC2D2]/30 bg-white p-5 text-center shadow-sm transition hover:border-[#647494]/40 hover:shadow-md">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#10B981]/10 text-[#059669] transition group-hover:bg-[#10B981]/15">
          <i class="ri-calendar-schedule-line text-xl"></i>
        </div>
        <p class="font-display mt-4 font-medium text-[#041C54]">Set Availability</p>
        <p class="mt-1 text-xs text-[#7484A4]">Manage your schedule</p>
      </a>
      <a href="{{ route('therapist.reviews.index') }}" class="group rounded-2xl border border-[#BAC2D2]/30 bg-white p-5 text-center shadow-sm transition hover:border-[#647494]/40 hover:shadow-md">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#F59E0B]/10 text-[#d97706] transition group-hover:bg-[#F59E0B]/15">
          <i class="ri-star-line text-xl"></i>
        </div>
        <p class="font-display mt-4 font-medium text-[#041C54]">My Reviews</p>
        <p class="mt-1 text-xs text-[#7484A4]">View client feedback</p>
      </a>
      <a href="{{ route('therapist.account-summary.index') }}" class="group rounded-2xl border border-[#BAC2D2]/30 bg-white p-5 text-center shadow-sm transition hover:border-[#647494]/40 hover:shadow-md">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-[14px] bg-[#3B82F6]/10 text-[#2563eb] transition group-hover:bg-[#3B82F6]/15">
          <i class="ri-bar-chart-box-line text-xl"></i>
        </div>
        <p class="font-display mt-4 font-medium text-[#041C54]">Account Summary</p>
        <p class="mt-1 text-xs text-[#7484A4]">View your earnings</p>
      </a>
    </div>
  </div>

  {{-- Motivational quote — Figma mint / teal --}}
  <div class="rounded-2xl border border-[#10B981]/25 bg-[#ecfdf5] px-6 py-8 text-center md:px-10">
    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#14B8A6] text-white shadow-md">
      <i class="ri-heart-3-fill text-2xl"></i>
    </div>
    <blockquote class="font-display mx-auto mt-6 max-w-2xl text-lg font-medium leading-relaxed text-[#041C54] md:text-xl">
      "{{ collect([
        'Every session you conduct is a step towards someone\'s healing journey.',
        'Your compassion and expertise are making a real difference in people\'s lives.',
        'The work you do matters. Thank you for being a healer.',
        'Your dedication to mental health is changing lives, one session at a time.',
        'You are not just a therapist; you are a beacon of hope for many.',
      ])->random() }}"
    </blockquote>
    <p class="mt-4 text-sm font-medium text-[#0d9488]">— A reminder of your impact</p>
  </div>
</div>

<style>
  .custom-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
  .custom-scroll::-webkit-scrollbar-track { background: rgba(186, 194, 210, 0.25); border-radius: 6px; }
  .custom-scroll::-webkit-scrollbar-thumb { background: rgba(100, 116, 148, 0.35); border-radius: 6px; }
  .custom-scroll::-webkit-scrollbar-thumb:hover { background: rgba(4, 28, 84, 0.25); }
</style>
@endsection
