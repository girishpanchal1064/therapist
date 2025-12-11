@extends('layouts/contentNavbarLayout')

@section('title', 'Client Dashboard')

@section('page-style')
<style>
  /* === Therapy Dashboard Custom Styles === */
  :root {
    --therapy-primary: #7c3aed;
    --therapy-primary-light: #a78bfa;
    --therapy-secondary: #10b981;
    --therapy-accent: #f59e0b;
    --therapy-calm: #06b6d4;
    --therapy-soft-bg: #faf5ff;
    --therapy-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --therapy-gradient-calm: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    --therapy-gradient-success: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --therapy-shadow: 0 10px 40px -10px rgba(124, 58, 237, 0.2);
    --therapy-shadow-lg: 0 25px 50px -12px rgba(124, 58, 237, 0.25);
  }

  /* Welcome Section */
  .welcome-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem 2.5rem;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: 2rem;
  }

  .welcome-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
  }

  .welcome-banner::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: 10%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    border-radius: 50%;
  }

  .welcome-content {
    position: relative;
    z-index: 1;
  }

  .welcome-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
  }

  .welcome-subtitle {
    opacity: 0.9;
    font-size: 1rem;
    margin-bottom: 0;
    font-weight: 400;
  }

  .welcome-illustration {
    position: absolute;
    right: 2rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 6rem;
    opacity: 0.2;
  }

  .quick-actions {
    display: flex;
    gap: 0.75rem;
    margin-top: 1.5rem;
  }

  .quick-action-btn {
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    padding: 0.6rem 1.25rem;
    border-radius: 12px;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    text-decoration: none;
  }

  .quick-action-btn:hover {
    background: rgba(255,255,255,0.3);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  }

  .quick-action-btn i {
    margin-right: 0.5rem;
  }

  /* Stats Cards */
  .stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
  }

  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--therapy-shadow);
  }

  .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    border-radius: 16px 16px 0 0;
  }

  .stat-card.primary::before { background: var(--therapy-gradient); }
  .stat-card.success::before { background: var(--therapy-gradient-success); }
  .stat-card.info::before { background: linear-gradient(135deg, #667eea 0%, #00d4ff 100%); }
  .stat-card.warning::before { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }

  .stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
  }

  .stat-icon.primary { 
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%); 
    color: #764ba2;
  }
  .stat-icon.success { 
    background: linear-gradient(135deg, rgba(17, 153, 142, 0.15) 0%, rgba(56, 239, 125, 0.15) 100%); 
    color: #11998e;
  }
  .stat-icon.info { 
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(0, 212, 255, 0.15) 100%); 
    color: #667eea;
  }
  .stat-icon.warning { 
    background: linear-gradient(135deg, rgba(240, 147, 251, 0.15) 0%, rgba(245, 87, 108, 0.15) 100%); 
    color: #f5576c;
  }

  .stat-label {
    font-size: 0.8125rem;
    color: #6b7280;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
  }

  .stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1.2;
    letter-spacing: -0.02em;
  }

  .stat-meta {
    font-size: 0.8125rem;
    color: #9ca3af;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
  }

  .stat-meta.positive { color: #10b981; }
  .stat-meta.neutral { color: #6b7280; }

  .stat-action-btn {
    margin-top: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-size: 0.8125rem;
    font-weight: 500;
  }

  /* Section Headers */
  .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.25rem;
  }

  .section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
  }

  .section-title-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
  }

  .section-title-icon.primary { background: rgba(124, 58, 237, 0.1); color: #7c3aed; }
  .section-title-icon.success { background: rgba(16, 185, 129, 0.1); color: #10b981; }
  .section-title-icon.info { background: rgba(6, 182, 212, 0.1); color: #06b6d4; }
  .section-title-icon.warning { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }

  /* Cards */
  .dashboard-card {
    background: white;
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow: hidden;
    height: 100%;
  }

  .dashboard-card .card-header {
    background: transparent;
    border-bottom: 1px solid #f3f4f6;
    padding: 1.25rem 1.5rem;
  }

  .dashboard-card .card-body {
    padding: 1.5rem;
  }

  /* Today's Sessions Alert */
  .today-sessions-banner {
    background: linear-gradient(135deg, #fef3cd 0%, #fff4e5 100%);
    border: 1px solid #fbbf24;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
  }

  .today-sessions-banner::before {
    content: '🌟';
    position: absolute;
    right: 1.5rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 3rem;
    opacity: 0.3;
  }

  .today-sessions-banner h5 {
    color: #92400e;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .today-sessions-banner p {
    color: #b45309;
    margin: 0;
    font-size: 0.9375rem;
  }

  /* Session Cards */
  .session-card {
    background: white;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    padding: 1.25rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .session-card:hover {
    border-color: var(--therapy-primary-light);
    box-shadow: 0 8px 25px rgba(124, 58, 237, 0.12);
  }

  .session-card.today {
    border-left: 4px solid #10b981;
    background: linear-gradient(90deg, rgba(16, 185, 129, 0.03) 0%, transparent 100%);
  }

  .session-card.upcoming {
    border-left: 4px solid #7c3aed;
  }

  .session-therapist {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
  }

  .therapist-avatar {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid #f3f4f6;
  }

  .therapist-info h6 {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.125rem;
    font-size: 0.9375rem;
  }

  .therapist-info span {
    font-size: 0.8125rem;
    color: #6b7280;
  }

  .session-details {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    padding-top: 0.75rem;
    border-top: 1px dashed #e5e7eb;
  }

  .session-detail-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8125rem;
    color: #6b7280;
  }

  .session-detail-item i {
    font-size: 1rem;
    color: #9ca3af;
  }

  .session-actions {
    margin-top: 1rem;
    display: flex;
    gap: 0.5rem;
  }

  .join-session-btn {
    background: var(--therapy-gradient-success);
    border: none;
    color: white;
    padding: 0.625rem 1.25rem;
    border-radius: 10px;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .join-session-btn:hover {
    color: white;
    transform: scale(1.02);
    box-shadow: 0 8px 20px rgba(17, 153, 142, 0.3);
  }

  .join-session-btn i {
    font-size: 1.125rem;
  }

  /* Status Badges */
  .status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.02em;
  }

  .status-badge.confirmed { background: rgba(16, 185, 129, 0.1); color: #059669; }
  .status-badge.scheduled { background: rgba(124, 58, 237, 0.1); color: #7c3aed; }
  .status-badge.pending { background: rgba(245, 158, 11, 0.1); color: #d97706; }
  .status-badge.in_progress { background: rgba(6, 182, 212, 0.1); color: #0891b2; }
  .status-badge.completed { background: rgba(107, 114, 128, 0.1); color: #4b5563; }

  /* Assessment Cards */
  .assessment-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 0;
    border-bottom: 1px solid #f3f4f6;
    transition: all 0.2s ease;
  }

  .assessment-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }

  .assessment-item:first-child {
    padding-top: 0;
  }

  .assessment-item:hover {
    transform: translateX(5px);
  }

  .assessment-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
  }

  .assessment-info {
    flex: 1;
    margin-left: 1rem;
  }

  .assessment-info h6 {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
    font-size: 0.9375rem;
  }

  .assessment-info small {
    color: #9ca3af;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .assessment-info small span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
  }

  .assessment-action-btn {
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-size: 0.8125rem;
    font-weight: 500;
    transition: all 0.3s ease;
  }

  .assessment-action-btn:hover {
    transform: translateY(-2px);
  }

  /* Transaction List */
  .transaction-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.875rem 0;
    border-bottom: 1px solid #f3f4f6;
  }

  .transaction-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }

  .transaction-item:first-child {
    padding-top: 0;
  }

  .transaction-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
  }

  .transaction-icon.credit { background: rgba(16, 185, 129, 0.1); color: #10b981; }
  .transaction-icon.debit { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

  .transaction-info {
    flex: 1;
    margin-left: 0.875rem;
  }

  .transaction-info h6 {
    font-weight: 500;
    color: #1f2937;
    margin-bottom: 0.125rem;
    font-size: 0.875rem;
  }

  .transaction-info small {
    color: #9ca3af;
    font-size: 0.75rem;
  }

  .transaction-amount {
    font-weight: 600;
    font-size: 0.9375rem;
  }

  .transaction-amount.credit { color: #10b981; }
  .transaction-amount.debit { color: #ef4444; }

  /* Empty States */
  .empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
  }

  .empty-state-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: #9ca3af;
  }

  .empty-state h6 {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
  }

  .empty-state p {
    color: #9ca3af;
    font-size: 0.875rem;
    margin-bottom: 1.5rem;
  }

  .empty-state-btn {
    background: var(--therapy-gradient);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .empty-state-btn:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--therapy-shadow);
  }

  /* Appointments Table */
  .appointments-table {
    width: 100%;
  }

  .appointments-table th {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0.75rem 0;
    border-bottom: 2px solid #f3f4f6;
  }

  .appointments-table td {
    padding: 1rem 0;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
  }

  .appointments-table tbody tr:last-child td {
    border-bottom: none;
  }

  .appointments-table tbody tr {
    transition: all 0.2s ease;
  }

  .appointments-table tbody tr:hover {
    background: #faf5ff;
  }

  /* Animations */
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .animate-fade-in {
    animation: fadeInUp 0.5s ease forwards;
  }

  .animation-delay-1 { animation-delay: 0.1s; opacity: 0; }
  .animation-delay-2 { animation-delay: 0.2s; opacity: 0; }
  .animation-delay-3 { animation-delay: 0.3s; opacity: 0; }
  .animation-delay-4 { animation-delay: 0.4s; opacity: 0; }
  .animation-delay-5 { animation-delay: 0.5s; opacity: 0; }

  /* Responsive */
  @media (max-width: 768px) {
    .welcome-banner {
      padding: 1.5rem;
    }

    .welcome-title {
      font-size: 1.375rem;
    }

    .welcome-illustration {
      display: none;
    }

    .quick-actions {
      flex-wrap: wrap;
    }

    .quick-action-btn {
      flex: 1;
      text-align: center;
      justify-content: center;
    }

    .stat-card {
      padding: 1.25rem;
    }

    .stat-value {
      font-size: 1.5rem;
    }
  }

  /* Scrollbar Styling */
  .custom-scroll::-webkit-scrollbar {
    width: 4px;
    height: 4px;
  }

  .custom-scroll::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 4px;
  }

  .custom-scroll::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 4px;
  }

  .custom-scroll::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
  }
</style>
@endsection

@section('content')
<!-- Welcome Banner -->
<div class="welcome-banner animate-fade-in">
  <div class="welcome-content">
    <h1 class="welcome-title">
      @php
        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');
      @endphp
      {{ $greeting }}, {{ auth()->user()->name }}! 👋
    </h1>
    <p class="welcome-subtitle">Welcome back to your wellness journey. Here's your dashboard overview.</p>
    <div class="quick-actions">
      <a href="{{ route('therapists.index') }}" class="quick-action-btn">
        <i class="ri-calendar-schedule-line"></i> Book a Session
      </a>
      <a href="{{ route('assessments.index') }}" class="quick-action-btn">
        <i class="ri-file-list-3-line"></i> Take Assessment
      </a>
      <a href="{{ route('chat.index') }}" class="quick-action-btn">
        <i class="ri-message-3-line"></i> Messages
        @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
          <span class="badge bg-danger ms-1">{{ $unreadMessagesCount }}</span>
        @endif
      </a>
    </div>
  </div>
  <div class="welcome-illustration">🧘</div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
  <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-lg-0 animate-fade-in animation-delay-1">
    <div class="stat-card primary">
      <div class="stat-icon primary">
        <i class="ri-calendar-check-line"></i>
      </div>
      <div class="stat-label">Total Sessions</div>
      <div class="stat-value">{{ $stats['total_appointments'] }}</div>
      <div class="stat-meta positive">
        <i class="ri-arrow-up-s-line"></i>
        <span>{{ $stats['upcoming_appointments'] }} upcoming</span>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-lg-0 animate-fade-in animation-delay-2">
    <div class="stat-card success">
      <div class="stat-icon success">
        <i class="ri-wallet-3-line"></i>
      </div>
      <div class="stat-label">Wallet Balance</div>
      <div class="stat-value">₹{{ number_format($stats['wallet_balance'], 0) }}</div>
      <button type="button" class="btn btn-sm btn-outline-success stat-action-btn" data-bs-toggle="modal" data-bs-target="#rechargeWalletModal">
        <i class="ri-add-circle-line me-1"></i>Top Up
      </button>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-md-0 animate-fade-in animation-delay-3">
    <div class="stat-card info">
      <div class="stat-icon info">
        <i class="ri-file-list-3-line"></i>
      </div>
      <div class="stat-label">Assessments</div>
      <div class="stat-value">{{ $stats['assessments_completed'] }}</div>
      <div class="stat-meta neutral">
        <i class="ri-checkbox-circle-line"></i>
        <span>Completed</span>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 animate-fade-in animation-delay-4">
    <div class="stat-card warning">
      <div class="stat-icon warning">
        <i class="ri-star-line"></i>
      </div>
      <div class="stat-label">Reviews Given</div>
      <div class="stat-value">{{ $stats['reviews_given'] }}</div>
      <div class="stat-meta neutral">
        <i class="ri-heart-3-line"></i>
        <span>Thank you!</span>
      </div>
    </div>
  </div>
</div>

<!-- Today's Sessions Alert -->
@if($todayAppointments->count() > 0)
<div class="today-sessions-banner animate-fade-in animation-delay-3">
  <h5>
    <i class="ri-calendar-todo-fill"></i>
    You have {{ $todayAppointments->count() }} session(s) today!
  </h5>
  <p>Don't forget to prepare and join on time for the best experience.</p>
</div>

<div class="row mb-4">
  @foreach($todayAppointments as $appointment)
  <div class="col-lg-6 mb-3 animate-fade-in animation-delay-4">
    <div class="session-card today">
      <div class="session-therapist">
        @if($appointment->therapist->therapistProfile && $appointment->therapist->therapistProfile->profile_image)
          <img src="{{ asset('storage/' . $appointment->therapist->therapistProfile->profile_image) }}" alt="{{ $appointment->therapist->name }}" class="therapist-avatar">
        @elseif($appointment->therapist->avatar)
          <img src="{{ asset('storage/' . $appointment->therapist->avatar) }}" alt="{{ $appointment->therapist->name }}" class="therapist-avatar">
        @else
          <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->therapist->name) }}&background=667eea&color=fff&size=100&bold=true&format=svg" alt="{{ $appointment->therapist->name }}" class="therapist-avatar">
        @endif
        <div class="therapist-info">
          <h6>{{ $appointment->therapist->name }}</h6>
          <span>
            @if($appointment->therapist->therapistProfile && $appointment->therapist->therapistProfile->specializations->count() > 0)
              {{ $appointment->therapist->therapistProfile->specializations->pluck('name')->take(2)->implode(', ') }}
            @else
              Therapist
            @endif
          </span>
        </div>
        <span class="status-badge {{ $appointment->status }} ms-auto">{{ ucfirst(str_replace('_', ' ', $appointment->status)) }}</span>
      </div>
      <div class="session-details">
        <div class="session-detail-item">
          <i class="ri-time-line"></i>
          <span>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</span>
        </div>
        <div class="session-detail-item">
          <i class="ri-vidicon-line"></i>
          <span>{{ ucfirst($appointment->session_mode ?? 'Online') }}</span>
        </div>
        <div class="session-detail-item">
          <i class="ri-timer-line"></i>
          <span>{{ $appointment->duration ?? 60 }} mins</span>
        </div>
      </div>
      @if($appointment->status === 'confirmed' || $appointment->status === 'in_progress')
      <div class="session-actions">
        <a href="{{ route('client.sessions.join', $appointment->id) }}" class="join-session-btn">
          <i class="ri-vidicon-line"></i>
          Join Session Now
        </a>
        <a href="{{ route('client.appointments.show', $appointment->id) }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 10px;">
          <i class="ri-eye-line"></i>
        </a>
      </div>
      @endif
    </div>
  </div>
  @endforeach
</div>
@endif

<div class="row">
  <!-- Upcoming Sessions -->
  <div class="col-lg-6 mb-4 animate-fade-in animation-delay-4">
    <div class="dashboard-card">
      <div class="card-header">
        <div class="section-header mb-0">
          <h5 class="section-title">
            <span class="section-title-icon primary"><i class="ri-calendar-schedule-line"></i></span>
            Upcoming Sessions
          </h5>
          <a href="{{ route('therapists.index') }}" class="btn btn-sm btn-primary" style="border-radius: 10px;">
            <i class="ri-add-line me-1"></i>Book
          </a>
        </div>
      </div>
      <div class="card-body custom-scroll" style="max-height: 400px; overflow-y: auto;">
        @if($upcomingAppointments->count() > 0)
          @foreach($upcomingAppointments->take(4) as $appointment)
          <div class="session-card upcoming mb-3">
            <div class="session-therapist">
              @if($appointment->therapist->therapistProfile && $appointment->therapist->therapistProfile->profile_image)
          <img src="{{ asset('storage/' . $appointment->therapist->therapistProfile->profile_image) }}" alt="{{ $appointment->therapist->name }}" class="therapist-avatar">
        @elseif($appointment->therapist->avatar)
          <img src="{{ asset('storage/' . $appointment->therapist->avatar) }}" alt="{{ $appointment->therapist->name }}" class="therapist-avatar">
        @else
          <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->therapist->name) }}&background=667eea&color=fff&size=100&bold=true&format=svg" alt="{{ $appointment->therapist->name }}" class="therapist-avatar">
        @endif
              <div class="therapist-info">
                <h6>{{ $appointment->therapist->name }}</h6>
                <span>{{ $appointment->appointment_date->format('D, M d, Y') }}</span>
              </div>
              <span class="status-badge {{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
            </div>
            <div class="session-details">
              <div class="session-detail-item">
                <i class="ri-time-line"></i>
                <span>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</span>
              </div>
              <div class="session-detail-item">
                <i class="ri-vidicon-line"></i>
                <span>{{ ucfirst($appointment->session_mode ?? 'Online') }}</span>
              </div>
            </div>
            <div class="session-actions">
              <a href="{{ route('client.appointments.show', $appointment->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 10px;">
                <i class="ri-eye-line me-1"></i>View Details
              </a>
              @if($appointment->status === 'confirmed')
              <a href="{{ route('client.sessions.join', $appointment->id) }}" class="btn btn-sm btn-success" style="border-radius: 10px;">
                <i class="ri-vidicon-line me-1"></i>Join
              </a>
              @endif
            </div>
          </div>
          @endforeach
          @if($upcomingAppointments->count() > 4)
          <div class="text-center mt-3">
            <a href="{{ route('client.appointments.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 10px;">
              View All ({{ $upcomingAppointments->count() }})
            </a>
          </div>
          @endif
        @else
          <div class="empty-state">
            <div class="empty-state-icon">
              <i class="ri-calendar-line"></i>
            </div>
            <h6>No upcoming sessions</h6>
            <p>Book a session with one of our expert therapists to begin your wellness journey.</p>
            <a href="{{ route('therapists.index') }}" class="empty-state-btn">
              <i class="ri-calendar-schedule-line"></i>
              Find a Therapist
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Recent Sessions -->
  <div class="col-lg-6 mb-4 animate-fade-in animation-delay-5">
    <div class="dashboard-card">
      <div class="card-header">
        <div class="section-header mb-0">
          <h5 class="section-title">
            <span class="section-title-icon success"><i class="ri-history-line"></i></span>
            Recent Sessions
          </h5>
          <a href="{{ route('client.appointments.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 10px;">
            View All
          </a>
        </div>
      </div>
      <div class="card-body custom-scroll" style="max-height: 400px; overflow-y: auto;">
        @if($recentAppointments->count() > 0)
          <table class="appointments-table">
            <thead>
              <tr>
                <th>Therapist</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentAppointments->take(5) as $appointment)
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="{{ $appointment->therapist->avatar ?? asset('assets/img/avatars/default.png') }}" alt="{{ $appointment->therapist->name }}" class="therapist-avatar me-3" style="width: 40px; height: 40px;">
                    <div>
                      <h6 class="mb-0" style="font-size: 0.875rem;">{{ $appointment->therapist->name }}</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <span style="font-size: 0.875rem; color: #4b5563;">{{ $appointment->appointment_date->format('M d, Y') }}</span>
                </td>
                <td>
                  <div class="d-flex gap-2">
                    <a href="{{ route('client.appointments.show', $appointment->id) }}" class="btn btn-sm btn-light" style="border-radius: 8px;" title="View">
                      <i class="ri-eye-line"></i>
                    </a>
                    <a href="{{ route('client.reviews.create', $appointment->id) }}" class="btn btn-sm btn-light" style="border-radius: 8px;" title="Review">
                      <i class="ri-star-line"></i>
                    </a>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="empty-state">
            <div class="empty-state-icon">
              <i class="ri-file-list-3-line"></i>
            </div>
            <h6>No session history</h6>
            <p>Your completed sessions will appear here.</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Assessments -->
  <div class="col-lg-6 mb-4 animate-fade-in animation-delay-4">
    <div class="dashboard-card">
      <div class="card-header">
        <div class="section-header mb-0">
          <h5 class="section-title">
            <span class="section-title-icon info"><i class="ri-mental-health-line"></i></span>
            Wellness Assessments
          </h5>
          <a href="{{ route('assessments.index') }}" class="btn btn-sm btn-outline-info" style="border-radius: 10px;">
            View All
          </a>
        </div>
      </div>
      <div class="card-body">
        @if($availableAssessments->count() > 0)
          @foreach($availableAssessments->take(4) as $assessment)
          <div class="assessment-item">
            <div class="d-flex align-items-center">
              <div class="assessment-icon" style="background-color: {{ $assessment->color ?? '#6366f1' }}15;">
                <i class="{{ $assessment->icon ?? 'ri-file-list-3-line' }}" style="color: {{ $assessment->color ?? '#6366f1' }};"></i>
              </div>
              <div class="assessment-info">
                <h6>{{ $assessment->title }}</h6>
                <small>
                  <span><i class="ri-time-line"></i> {{ $assessment->duration_minutes ?? 10 }} min</span>
                  <span><i class="ri-questionnaire-line"></i> {{ $assessment->question_count ?? 10 }} questions</span>
                </small>
              </div>
            </div>
            <div class="d-flex align-items-center gap-2">
              @if($assessment->user_completed > 0)
                <span class="status-badge completed">Completed</span>
              @endif
              <a href="{{ route('assessments.start', $assessment->slug) }}" class="btn btn-sm {{ $assessment->user_completed > 0 ? 'btn-outline-primary' : 'btn-primary' }} assessment-action-btn">
                {{ $assessment->user_completed > 0 ? 'Retake' : 'Start' }}
              </a>
            </div>
          </div>
          @endforeach
        @else
          <div class="empty-state">
            <div class="empty-state-icon">
              <i class="ri-mental-health-line"></i>
            </div>
            <h6>No assessments available</h6>
            <p>Check back later for wellness assessments.</p>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Wallet Transactions -->
  <div class="col-lg-6 mb-4 animate-fade-in animation-delay-5">
    <div class="dashboard-card">
      <div class="card-header">
        <div class="section-header mb-0">
          <h5 class="section-title">
            <span class="section-title-icon warning"><i class="ri-wallet-3-line"></i></span>
            Recent Transactions
          </h5>
          <button type="button" class="btn btn-sm btn-warning" style="border-radius: 10px; color: white;" data-bs-toggle="modal" data-bs-target="#rechargeWalletModal">
            <i class="ri-add-circle-line me-1"></i>Add Money
          </button>
        </div>
      </div>
      <div class="card-body">
        @if($walletTransactions->count() > 0)
          @foreach($walletTransactions->take(5) as $transaction)
          <div class="transaction-item">
            <div class="d-flex align-items-center">
              <div class="transaction-icon {{ $transaction->type }}">
                <i class="ri-{{ $transaction->type === 'credit' ? 'arrow-down' : 'arrow-up' }}-line"></i>
              </div>
              <div class="transaction-info">
                <h6>{{ Str::limit($transaction->description, 30) }}</h6>
                <small>{{ $transaction->created_at->format('M d, Y · g:i A') }}</small>
              </div>
            </div>
            <div class="transaction-amount {{ $transaction->type }}">
              {{ $transaction->type === 'credit' ? '+' : '-' }}{{ $transaction->formatted_amount }}
            </div>
          </div>
          @endforeach
          <div class="text-center mt-3">
            <a href="{{ route('client.wallet.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 10px;">
              View All Transactions
            </a>
          </div>
        @else
          <div class="empty-state">
            <div class="empty-state-icon">
              <i class="ri-wallet-3-line"></i>
            </div>
            <h6>No transactions yet</h6>
            <p>Add money to your wallet to book sessions easily.</p>
            <button type="button" class="empty-state-btn" data-bs-toggle="modal" data-bs-target="#rechargeWalletModal">
              <i class="ri-add-circle-line"></i>
              Add Money Now
            </button>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Motivational Quote Section -->
<div class="row">
  <div class="col-12 animate-fade-in animation-delay-5">
    <div class="dashboard-card" style="background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%); border: 1px solid #e9d5ff;">
      <div class="card-body text-center py-4">
        <div style="font-size: 2.5rem; margin-bottom: 1rem;">🌸</div>
        <blockquote style="font-size: 1.125rem; font-weight: 500; color: #6b21a8; font-style: italic; margin-bottom: 0.5rem;">
          "{{ collect([
            'Taking care of your mental health is an act of self-love.',
            'Every day is a new opportunity to grow and heal.',
            'You are stronger than you think, and more resilient than you know.',
            'Small steps every day lead to big changes over time.',
            'Your mental health matters. You matter.',
            'Be kind to yourself. Healing is a journey, not a destination.',
            'It\'s okay to ask for help. Seeking support is a sign of strength.'
          ])->random() }}"
        </blockquote>
        <small style="color: #9333ea;">— Your Daily Wellness Reminder</small>
      </div>
    </div>
  </div>
</div>

<!-- Recharge Wallet Modal -->
@include('client.wallet.partials.recharge-modal', ['wallet' => (object)['balance' => $stats['wallet_balance']]])
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

  // Animate elements on scroll
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, observerOptions);

  document.querySelectorAll('.animate-fade-in').forEach(el => {
    observer.observe(el);
  });
});
</script>
@endsection
