@extends('layouts/contentNavbarLayout')

@section('title', 'Appointment Details')

@section('vendor-style')
<style>
  :root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --danger-gradient: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
  }

  /* Header Card */
  .appointment-header {
    background: var(--primary-gradient);
    border-radius: 24px;
    padding: 40px;
    color: white;
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
  }
  .appointment-header::before {
    content: '';
    position: absolute;
    top: -80px;
    right: -80px;
    width: 250px;
    height: 250px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
  }
  .appointment-header::after {
    content: '';
    position: absolute;
    bottom: -60px;
    left: 30%;
    width: 180px;
    height: 180px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
  }

  .header-content { position: relative; z-index: 1; }
  .appointment-id {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.2);
    padding: 8px 16px;
    border-radius: 30px;
    font-size: 0.9rem;
    margin-bottom: 16px;
    backdrop-filter: blur(10px);
  }
  .header-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 8px;
    color: white;
  }
  .header-meta {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
    opacity: 0.9;
  }
  .header-meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1rem;
  }

  .header-actions {
    position: absolute;
    right: 40px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1;
    display: flex;
    gap: 12px;
  }
  .header-btn {
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    text-decoration: none;
    border: none;
    cursor: pointer;
  }
  .header-btn.light {
    background: rgba(255,255,255,0.2);
    color: white;
    border: 2px solid rgba(255,255,255,0.3);
  }
  .header-btn.light:hover {
    background: rgba(255,255,255,0.3);
    transform: translateY(-2px);
  }
  .header-btn.white {
    background: white;
    color: #667eea;
  }
  .header-btn.white:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
  }
  .header-btn.danger {
    background: rgba(234, 84, 85, 0.9);
    color: white;
  }
  .header-btn.danger:hover {
    background: #ea5455;
  }

  /* Status Badge Large */
  .status-badge-lg {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    border-radius: 16px;
    font-size: 1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .status-badge-lg.scheduled { background: rgba(102, 126, 234, 0.15); color: #667eea; }
  .status-badge-lg.confirmed { background: rgba(40, 199, 111, 0.15); color: #28c76f; }
  .status-badge-lg.in-progress { background: rgba(255, 159, 67, 0.15); color: #ff9f43; }
  .status-badge-lg.completed { background: rgba(130, 134, 139, 0.15); color: #82868b; }
  .status-badge-lg.cancelled { background: rgba(234, 84, 85, 0.15); color: #ea5455; }
  .status-badge-lg.no-show { background: rgba(255, 159, 67, 0.15); color: #ff9f43; }

  /* Info Cards */
  .info-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow: hidden;
    height: 100%;
  }
  .info-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #eef2f7;
    display: flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(to right, #f8f9ff, #fff);
  }
  .info-card-header .icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: white;
  }
  .info-card-header .icon.primary { background: var(--primary-gradient); }
  .info-card-header .icon.success { background: var(--success-gradient); }
  .info-card-header .icon.warning { background: var(--warning-gradient); }
  .info-card-header .icon.info { background: var(--info-gradient); }
  .info-card-header h5 { margin: 0; font-weight: 700; color: #2e3a59; }
  .info-card-body { padding: 24px; }

  /* Participant Card */
  .participant-card {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    background: #f8fafc;
    border-radius: 16px;
    margin-bottom: 16px;
    transition: all 0.3s ease;
  }
  .participant-card:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
  }
  .participant-card:last-child { margin-bottom: 0; }

  .participant-avatar {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    object-fit: cover;
    flex-shrink: 0;
  }
  .participant-initials {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1.3rem;
    color: white;
    flex-shrink: 0;
  }
  .participant-initials.client { background: var(--primary-gradient); }
  .participant-initials.therapist { background: var(--success-gradient); }

  .participant-info { flex: 1; }
  .participant-info h5 { margin: 0 0 4px; font-size: 1.1rem; font-weight: 700; color: #2e3a59; }
  .participant-info p { margin: 0 0 8px; color: #8f9bb3; font-size: 0.9rem; }
  .participant-role {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .participant-role.client { background: rgba(102, 126, 234, 0.1); color: #667eea; }
  .participant-role.therapist { background: rgba(17, 153, 142, 0.1); color: #11998e; }

  .participant-actions {
    display: flex;
    gap: 8px;
  }
  .participant-btn {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
  }
  .participant-btn.view { background: rgba(102, 126, 234, 0.1); color: #667eea; }
  .participant-btn.view:hover { background: #667eea; color: white; }
  .participant-btn.email { background: rgba(79, 172, 254, 0.1); color: #4facfe; }
  .participant-btn.email:hover { background: #4facfe; color: white; }

  /* Detail Row */
  .detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 0;
    border-bottom: 1px dashed #eef2f7;
  }
  .detail-row:last-child { border-bottom: none; }
  .detail-row .label {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #8f9bb3;
    font-size: 0.95rem;
  }
  .detail-row .label i {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f0f3f8;
    color: #667eea;
  }
  .detail-row .value {
    font-weight: 600;
    color: #2e3a59;
    text-align: right;
  }

  /* Meeting Card */
  .meeting-link-card {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    border: 2px solid rgba(102, 126, 234, 0.2);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 16px;
  }
  .meeting-link-card h6 {
    margin: 0 0 12px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #667eea;
    font-weight: 600;
  }
  .meeting-link-card .link-box {
    display: flex;
    gap: 12px;
  }
  .meeting-link-card input {
    flex: 1;
    padding: 12px 16px;
    border: 2px solid #eef2f7;
    border-radius: 10px;
    background: white;
    font-size: 0.9rem;
    color: #2e3a59;
  }
  .meeting-link-card .copy-btn,
  .meeting-link-card .join-btn {
    padding: 12px 20px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .meeting-link-card .copy-btn {
    background: #f0f3f8;
    color: #667eea;
  }
  .meeting-link-card .copy-btn:hover { background: #e0e5f0; }
  .meeting-link-card .join-btn {
    background: var(--success-gradient);
    color: white;
  }
  .meeting-link-card .join-btn:hover { transform: translateY(-2px); }

  /* Notes Section */
  .notes-box {
    background: #f8fafc;
    border-radius: 12px;
    padding: 20px;
    min-height: 100px;
  }
  .notes-box.empty {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8f9bb3;
    font-style: italic;
  }

  /* Payment Card */
  .payment-status-card {
    padding: 24px;
    border-radius: 16px;
    text-align: center;
  }
  .payment-status-card.paid {
    background: linear-gradient(135deg, rgba(40, 199, 111, 0.1) 0%, rgba(56, 239, 125, 0.1) 100%);
    border: 2px solid rgba(40, 199, 111, 0.2);
  }
  .payment-status-card.unpaid {
    background: linear-gradient(135deg, rgba(255, 159, 67, 0.1) 0%, rgba(255, 159, 67, 0.05) 100%);
    border: 2px solid rgba(255, 159, 67, 0.2);
  }
  .payment-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto 16px;
  }
  .payment-status-card.paid .payment-icon { background: var(--success-gradient); color: white; }
  .payment-status-card.unpaid .payment-icon { background: var(--warning-gradient); color: white; }
  .payment-status-card h5 { margin: 0 0 8px; font-weight: 700; }
  .payment-status-card.paid h5 { color: #28c76f; }
  .payment-status-card.unpaid h5 { color: #ff9f43; }
  .payment-status-card p { margin: 0; color: #8f9bb3; font-size: 0.9rem; }

  /* Timeline */
  .timeline {
    position: relative;
    padding-left: 30px;
  }
  .timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #eef2f7;
  }
  .timeline-item {
    position: relative;
    padding-bottom: 24px;
  }
  .timeline-item:last-child { padding-bottom: 0; }
  .timeline-item::before {
    content: '';
    position: absolute;
    left: -22px;
    top: 4px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: var(--primary-gradient);
    border: 3px solid white;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
  }
  .timeline-item .time {
    font-size: 0.8rem;
    color: #8f9bb3;
    margin-bottom: 4px;
  }
  .timeline-item .event {
    font-weight: 600;
    color: #2e3a59;
  }

  /* Quick Actions */
  .quick-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
  }
  .quick-action-btn {
    flex: 1;
    min-width: 140px;
    padding: 16px 20px;
    border-radius: 14px;
    border: 2px solid #eef2f7;
    background: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
  }
  .quick-action-btn:hover {
    border-color: #667eea;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
  }
  .quick-action-btn i {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
  }
  .quick-action-btn.edit i { background: rgba(79, 172, 254, 0.15); color: #4facfe; }
  .quick-action-btn.complete i { background: rgba(40, 199, 111, 0.15); color: #28c76f; }
  .quick-action-btn.cancel i { background: rgba(234, 84, 85, 0.15); color: #ea5455; }
  .quick-action-btn.reschedule i { background: rgba(255, 159, 67, 0.15); color: #ff9f43; }
  .quick-action-btn span {
    font-weight: 600;
    color: #2e3a59;
    font-size: 0.9rem;
  }

  /* Responsive */
  @media (max-width: 1199px) {
    .header-actions { position: static; transform: none; margin-top: 24px; flex-wrap: wrap; }
    .appointment-header { text-align: center; }
    .header-meta { justify-content: center; }
  }
</style>
@endsection

@section('content')
@php
  $statusClass = str_replace('_', '-', $appointment->status);
  $statusLabels = [
    'scheduled' => 'Scheduled',
    'confirmed' => 'Confirmed',
    'in_progress' => 'In Progress',
    'completed' => 'Completed',
    'cancelled' => 'Cancelled',
    'no_show' => 'No Show'
  ];
  $statusIcons = [
    'scheduled' => 'ri-calendar-line',
    'confirmed' => 'ri-check-line',
    'in_progress' => 'ri-loader-4-line',
    'completed' => 'ri-checkbox-circle-line',
    'cancelled' => 'ri-close-circle-line',
    'no_show' => 'ri-user-unfollow-line'
  ];
  $modeIcons = ['video' => 'ri-video-line', 'audio' => 'ri-phone-line', 'chat' => 'ri-message-3-line'];
  $typeIcons = ['individual' => 'ri-user-line', 'couple' => 'ri-hearts-line', 'family' => 'ri-parent-line'];
@endphp

<!-- Header -->
<div class="appointment-header">
  <div class="header-content">
    <div class="appointment-id">
      <i class="ri-hashtag"></i>
      <span>Appointment #{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</span>
    </div>
    <h1 class="header-title">Appointment Details</h1>
    <div class="header-meta">
      <div class="header-meta-item">
        <i class="ri-calendar-line"></i>
        <span>{{ $appointment->appointment_date->format('l, F d, Y') }}</span>
      </div>
      <div class="header-meta-item">
        <i class="ri-time-line"></i>
        <span>{{ \Carbon\Carbon::parse($appointment->appointment_time, 'Asia/Kolkata')->setTimezone('Asia/Kolkata')->format('g:i A') }} IST</span>
      </div>
      <div class="header-meta-item">
        <i class="ri-timer-line"></i>
        <span>{{ $appointment->duration_minutes }} minutes</span>
      </div>
    </div>
  </div>
  <div class="header-actions">
    <a href="{{ route('admin.appointments.index') }}" class="header-btn light">
      <i class="ri-arrow-left-line"></i> Back
    </a>
    <a href="{{ route('admin.appointments.edit', $appointment) }}" class="header-btn white">
      <i class="ri-pencil-line"></i> Edit
    </a>
    @if(in_array($appointment->status, ['scheduled', 'confirmed']))
      <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
        @csrf
        <button type="submit" class="header-btn danger">
          <i class="ri-close-circle-line"></i> Cancel
        </button>
      </form>
    @endif
  </div>
</div>

<!-- Alerts -->
@if(session('success'))
  <div class="alert alert-success alert-dismissible d-flex align-items-center mb-4" role="alert">
    <i class="ri-checkbox-circle-line me-3 ri-xl"></i>
    <span>{{ session('success') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="row g-4">
  <!-- Left Column -->
  <div class="col-lg-8">
    <!-- Participants -->
    <div class="info-card mb-4">
      <div class="info-card-header">
        <div class="icon primary"><i class="ri-group-line"></i></div>
        <h5>Session Participants</h5>
      </div>
      <div class="info-card-body">
        <!-- Client -->
        <div class="participant-card">
          @if($appointment->client)
            @if($appointment->client->profile && $appointment->client->profile->profile_image)
              <img src="{{ asset('storage/' . $appointment->client->profile->profile_image) }}" alt="{{ $appointment->client->name }}" class="participant-avatar">
            @elseif($appointment->client->getRawOriginal('avatar'))
              <img src="{{ asset('storage/' . $appointment->client->getRawOriginal('avatar')) }}" alt="{{ $appointment->client->name }}" class="participant-avatar">
            @else
              <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->client->name) }}&background=3b82f6&color=fff&size=200&bold=true&format=svg" alt="{{ $appointment->client->name }}" class="participant-avatar">
            @endif
          @else
            <div class="participant-initials client">
              NA
            </div>
          @endif
          <div class="participant-info">
            <h5>{{ $appointment->client->name ?? 'N/A' }}</h5>
            <p>{{ $appointment->client->email ?? 'N/A' }}</p>
            <span class="participant-role client">Client</span>
          </div>
          <div class="participant-actions">
            <a href="{{ route('admin.users.show', $appointment->client_id) }}" class="participant-btn view" data-bs-toggle="tooltip" title="View Profile">
              <i class="ri-user-line"></i>
            </a>
            <a href="mailto:{{ $appointment->client->email ?? '' }}" class="participant-btn email" data-bs-toggle="tooltip" title="Send Email">
              <i class="ri-mail-line"></i>
            </a>
          </div>
        </div>

        <!-- Therapist -->
        <div class="participant-card">
          @if($appointment->therapist && $appointment->therapist->getRawOriginal('avatar'))
            <img src="{{ $appointment->therapist->avatar }}" alt="{{ $appointment->therapist->name }}" class="participant-avatar">
          @else
            <div class="participant-initials therapist">
              {{ $appointment->therapist ? strtoupper(substr($appointment->therapist->name, 0, 2)) : 'NA' }}
            </div>
          @endif
          <div class="participant-info">
            <h5>{{ $appointment->therapist->name ?? 'N/A' }}</h5>
            <p>{{ $appointment->therapist->therapistProfile->qualification ?? $appointment->therapist->email ?? 'N/A' }}</p>
            <span class="participant-role therapist">Therapist</span>
          </div>
          <div class="participant-actions">
            <a href="{{ route('admin.therapists.show', $appointment->therapist_id) }}" class="participant-btn view" data-bs-toggle="tooltip" title="View Profile">
              <i class="ri-user-star-line"></i>
            </a>
            <a href="mailto:{{ $appointment->therapist->email ?? '' }}" class="participant-btn email" data-bs-toggle="tooltip" title="Send Email">
              <i class="ri-mail-line"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Session Details -->
    <div class="info-card mb-4">
      <div class="info-card-header">
        <div class="icon info"><i class="ri-settings-4-line"></i></div>
        <h5>Session Details</h5>
      </div>
      <div class="info-card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="detail-row">
              <span class="label"><i class="{{ $typeIcons[$appointment->appointment_type] ?? 'ri-user-line' }}"></i> Type</span>
              <span class="value">{{ ucfirst($appointment->appointment_type) }} Session</span>
            </div>
            <div class="detail-row">
              <span class="label"><i class="{{ $modeIcons[$appointment->session_mode] ?? 'ri-question-line' }}"></i> Mode</span>
              <span class="value">{{ ucfirst($appointment->session_mode) }} Call</span>
            </div>
            <div class="detail-row">
              <span class="label"><i class="ri-calendar-2-line"></i> Date</span>
              <span class="value">{{ $appointment->appointment_date->format('M d, Y') }}</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-row">
              <span class="label"><i class="ri-time-line"></i> Time</span>
              <span class="value">{{ \Carbon\Carbon::parse($appointment->appointment_time, 'Asia/Kolkata')->setTimezone('Asia/Kolkata')->format('g:i A') }} IST</span>
            </div>
            <div class="detail-row">
              <span class="label"><i class="ri-timer-line"></i> Duration</span>
              <span class="value">{{ $appointment->duration_minutes }} minutes</span>
            </div>
            <div class="detail-row">
              <span class="label"><i class="ri-calendar-check-line"></i> Created</span>
              <span class="value">{{ $appointment->created_at->format('M d, Y') }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Meeting Information -->
    <div class="info-card mb-4">
      <div class="info-card-header">
        <div class="icon warning"><i class="ri-video-add-line"></i></div>
        <h5>Meeting Information</h5>
      </div>
      <div class="info-card-body">
        @if($appointment->meeting_link)
          <div class="meeting-link-card">
            <h6><i class="ri-link"></i> Meeting Link</h6>
            <div class="link-box">
              <input type="text" value="{{ $appointment->meeting_link }}" id="meetingLink" readonly>
              <button type="button" class="copy-btn" onclick="copyMeetingLink()">
                <i class="ri-file-copy-line"></i> Copy
              </button>
              <a href="{{ $appointment->meeting_link }}" target="_blank" class="join-btn">
                <i class="ri-video-line"></i> Join Meeting
              </a>
            </div>
          </div>
        @endif

        <div class="row">
          <div class="col-md-6">
            <div class="detail-row">
              <span class="label"><i class="ri-id-card-line"></i> Meeting ID</span>
              <span class="value">{{ $appointment->meeting_id ?? 'N/A' }}</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-row">
              <span class="label"><i class="ri-lock-password-line"></i> Password</span>
              <span class="value">{{ $appointment->meeting_password ?? 'N/A' }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Session Notes -->
    <div class="info-card">
      <div class="info-card-header">
        <div class="icon success"><i class="ri-file-text-line"></i></div>
        <h5>Session Notes</h5>
      </div>
      <div class="info-card-body">
        @if($appointment->session_notes)
          <div class="notes-box">
            {{ $appointment->session_notes }}
          </div>
        @else
          <div class="notes-box empty">
            <span>No notes have been added for this session.</span>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Right Column -->
  <div class="col-lg-4">
    <!-- Status Card -->
    <div class="info-card mb-4">
      <div class="info-card-header">
        <div class="icon primary"><i class="ri-checkbox-circle-line"></i></div>
        <h5>Status</h5>
      </div>
      <div class="info-card-body text-center">
        <span class="status-badge-lg {{ $statusClass }}">
          <i class="{{ $statusIcons[$appointment->status] ?? 'ri-question-line' }}"></i>
          {{ $statusLabels[$appointment->status] ?? ucfirst($appointment->status) }}
        </span>
      </div>
    </div>

    <!-- Payment Status -->
    <div class="info-card mb-4">
      <div class="info-card-header">
        <div class="icon success"><i class="ri-money-dollar-circle-line"></i></div>
        <h5>Payment</h5>
      </div>
      <div class="info-card-body">
        @if($appointment->payment && $appointment->payment->status === 'completed')
          <div class="payment-status-card paid">
            <div class="payment-icon">
              <i class="ri-checkbox-circle-fill"></i>
            </div>
            <h5>Payment Completed</h5>
            <p>₹{{ number_format($appointment->payment->total_amount ?? 0, 2) }}</p>
          </div>
        @else
          <div class="payment-status-card unpaid">
            <div class="payment-icon">
              <i class="ri-time-line"></i>
            </div>
            <h5>Payment Pending</h5>
            <p>No payment received yet</p>
          </div>
        @endif
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="info-card mb-4">
      <div class="info-card-header">
        <div class="icon info"><i class="ri-flashlight-line"></i></div>
        <h5>Quick Actions</h5>
      </div>
      <div class="info-card-body">
        <div class="quick-actions">
          <a href="{{ route('admin.appointments.edit', $appointment) }}" class="quick-action-btn edit">
            <i class="ri-pencil-line"></i>
            <span>Edit</span>
          </a>
          @if(in_array($appointment->status, ['scheduled', 'confirmed']))
            <form action="{{ route('admin.appointments.complete', $appointment) }}" method="POST" class="quick-action-btn complete" style="border: none; background: none; padding: 0;">
              @csrf
              <button type="submit" style="all: unset; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 10px; padding: 16px 20px; border: 2px solid #eef2f7; border-radius: 14px; background: white; width: 100%;">
                <i class="ri-check-line" style="width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; background: rgba(40, 199, 111, 0.15); color: #28c76f;"></i>
                <span style="font-weight: 600; color: #2e3a59; font-size: 0.9rem;">Complete</span>
              </button>
            </form>
            <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST" class="quick-action-btn cancel" style="border: none; background: none; padding: 0;" onsubmit="return confirm('Cancel this appointment?')">
              @csrf
              <button type="submit" style="all: unset; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 10px; padding: 16px 20px; border: 2px solid #eef2f7; border-radius: 14px; background: white; width: 100%;">
                <i class="ri-close-line" style="width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; background: rgba(234, 84, 85, 0.15); color: #ea5455;"></i>
                <span style="font-weight: 600; color: #2e3a59; font-size: 0.9rem;">Cancel</span>
              </button>
            </form>
          @endif
        </div>
      </div>
    </div>

    <!-- Activity Timeline -->
    <div class="info-card">
      <div class="info-card-header">
        <div class="icon warning"><i class="ri-history-line"></i></div>
        <h5>Activity</h5>
      </div>
      <div class="info-card-body">
        <div class="timeline">
          <div class="timeline-item">
            <div class="time">{{ $appointment->created_at->format('M d, Y g:i A') }}</div>
            <div class="event">Appointment Created</div>
          </div>
          @if($appointment->status === 'confirmed')
            <div class="timeline-item">
              <div class="time">{{ $appointment->updated_at->format('M d, Y g:i A') }}</div>
              <div class="event">Appointment Confirmed</div>
            </div>
          @elseif($appointment->status === 'completed')
            <div class="timeline-item">
              <div class="time">{{ $appointment->updated_at->format('M d, Y g:i A') }}</div>
              <div class="event">Session Completed</div>
            </div>
          @elseif($appointment->status === 'cancelled')
            <div class="timeline-item">
              <div class="time">{{ $appointment->updated_at->format('M d, Y g:i A') }}</div>
              <div class="event">Appointment Cancelled</div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initialize tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
});

function copyMeetingLink() {
  const input = document.getElementById('meetingLink');
  input.select();
  input.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(input.value);

  // Show feedback
  const btn = event.target.closest('.copy-btn');
  const originalHtml = btn.innerHTML;
  btn.innerHTML = '<i class="ri-check-line"></i> Copied!';
  btn.style.background = '#28c76f';
  btn.style.color = 'white';

  setTimeout(() => {
    btn.innerHTML = originalHtml;
    btn.style.background = '';
    btn.style.color = '';
  }, 2000);
}
</script>
@endsection
