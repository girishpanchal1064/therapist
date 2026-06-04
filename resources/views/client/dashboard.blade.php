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
    --therapy-gradient: #041c54;
    --therapy-gradient-calm: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    --therapy-gradient-success: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --therapy-shadow: 0 10px 40px -10px rgba(124, 58, 237, 0.2);
    --therapy-shadow-lg: 0 25px 50px -12px rgba(124, 58, 237, 0.25);
  }

  /* Welcome Section */
  .welcome-banner {
    background: #041c54;
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

  .stat-card.primary::before,
  .stat-card.success::before,
  .stat-card.info::before,
  .stat-card.warning::before {
    background: #041c54;
  }

  .stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    background: rgba(4, 28, 84, 0.1);
    color: #041c54;
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

  .stat-meta.positive { color: #041c54; }
  .stat-meta.neutral { color: #7484a4; }

  .stat-action-btn {
    margin-top: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-size: 0.8125rem;
    font-weight: 500;
    border: 2px solid rgba(4, 28, 84, 0.35);
    color: #041c54;
    background: transparent;
  }

  .stat-action-btn:hover,
  .stat-action-btn:focus {
    background: #041c54;
    border-color: #041c54;
    color: #fff;
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
    color: #041c54;
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

  .section-title-icon.primary,
  .section-title-icon.success,
  .section-title-icon.info,
  .section-title-icon.warning {
    background: rgba(4, 28, 84, 0.1);
    color: #041c54;
  }

  .btn-dashboard-primary {
    background: #041c54 !important;
    border-color: #041c54 !important;
    color: #fff !important;
    border-radius: 10px;
    font-weight: 500;
  }

  .btn-dashboard-primary:hover {
    background: #052a66 !important;
    border-color: #052a66 !important;
    color: #fff !important;
  }

  .btn.btn-dashboard-outline,
  a.btn.btn-dashboard-outline {
    border: 2px solid #041c54 !important;
    color: #041c54 !important;
    background: transparent !important;
    border-radius: 10px;
    font-weight: 500;
    text-decoration: none;
    box-shadow: none !important;
  }

  .btn.btn-dashboard-outline:hover,
  a.btn.btn-dashboard-outline:hover,
  .btn.btn-dashboard-outline:focus,
  a.btn.btn-dashboard-outline:focus {
    background: #041c54 !important;
    border-color: #041c54 !important;
    color: #fff !important;
  }

  .btn-dashboard-icon {
    width: 38px;
    height: 38px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border: 2px solid rgba(4, 28, 84, 0.35) !important;
    color: #041c54 !important;
    background: transparent !important;
    border-radius: 10px;
  }

  .btn-dashboard-icon:hover {
    background: #041c54 !important;
    border-color: #041c54 !important;
    color: #fff !important;
  }

  /* Cards */
  .dashboard-card {
    background: white;
    border-radius: 16px;
    border: 1px solid rgba(186, 194, 210, 0.45);
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
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
    border: 1px solid rgba(186, 194, 210, 0.45);
    padding: 1.25rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .session-card:hover {
    border-color: rgba(4, 28, 84, 0.25);
    box-shadow: 0 8px 25px rgba(4, 28, 84, 0.08);
  }

  .session-card.today,
  .session-card.upcoming {
    border-left: 4px solid #041c54;
    background: linear-gradient(90deg, rgba(4, 28, 84, 0.04) 0%, transparent 100%);
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
    color: #041c54;
    margin-bottom: 0.125rem;
    font-size: 0.9375rem;
  }

  .therapist-info span {
    font-size: 0.8125rem;
    color: #7484a4;
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
    color: #7484a4;
  }

  .session-actions {
    margin-top: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .session-action-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .session-join-hint {
    margin: 0;
    font-size: 0.8125rem;
    color: #7484a4;
    line-height: 1.45;
    display: flex;
    align-items: flex-start;
    gap: 0.35rem;
  }

  .session-join-hint i {
    flex-shrink: 0;
    margin-top: 0.1rem;
    color: #647494;
  }

  .btn-session-join {
    flex: 1;
    min-width: 0;
    background: #041c54;
    border: none;
    color: #fff;
    padding: 0.625rem 1rem;
    border-radius: 10px;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    text-decoration: none;
  }

  .btn-session-join:hover {
    background: #052a66;
    color: #fff;
    box-shadow: 0 6px 16px rgba(4, 28, 84, 0.2);
  }

  .btn-session-join:disabled,
  .btn-session-join.disabled {
    background: rgba(186, 194, 210, 0.35);
    color: #7484a4;
    cursor: not-allowed;
    box-shadow: none;
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

  .status-badge.confirmed,
  .status-badge.scheduled,
  .status-badge.in_progress {
    background: rgba(4, 28, 84, 0.1);
    color: #041c54;
  }

  .status-badge.pending {
    background: rgba(245, 158, 11, 0.1);
    color: #b45309;
  }

  .status-badge.completed {
    background: rgba(100, 116, 148, 0.12);
    color: #647494;
  }

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

  /* Custom Scrollbar */
  .custom-scroll {
    scrollbar-width: thin;
    scrollbar-color: rgba(4, 28, 84, 0.25) transparent;
  }

  .custom-scroll::-webkit-scrollbar {
    width: 6px;
  }

  .custom-scroll::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 10px;
  }

  .custom-scroll::-webkit-scrollbar-thumb {
    background: rgba(4, 28, 84, 0.25);
    border-radius: 10px;
  }

  .custom-scroll::-webkit-scrollbar-thumb:hover {
    background: rgba(4, 28, 84, 0.4);
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
    background: rgba(4, 28, 84, 0.03);
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
        $hour = \Carbon\Carbon::now('Asia/Kolkata')->hour;
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
      <button type="button" class="btn btn-sm stat-action-btn" data-bs-toggle="modal" data-bs-target="#rechargeWalletModal">
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
          <img src="{{ $appointment->therapist->avatar }}" alt="{{ $appointment->therapist->name }}" class="therapist-avatar">
        @else
          <img src="{{ \App\Support\ProfileAvatar::placeholderUrl() }}" alt="{{ $appointment->therapist->name }}" class="therapist-avatar">
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
          <span>{{ \Carbon\Carbon::parse($appointment->appointment_time, 'Asia/Kolkata')->setTimezone('Asia/Kolkata')->format('g:i A') }} IST</span>
        </div>
        <div class="session-detail-item">
          <i class="ri-vidicon-line"></i>
          <span>{{ ucfirst($appointment->session_mode ?? 'Online') }}</span>
        </div>
        <div class="session-detail-item">
          <i class="ri-timer-line"></i>
          <span>{{ $appointment->duration_minutes ?? 60 }} mins</span>
        </div>
      </div>
      @php
        // Check if join button should be shown
        $timeString = is_string($appointment->appointment_time)
            ? $appointment->appointment_time
            : (is_object($appointment->appointment_time)
                ? $appointment->appointment_time->format('H:i:s')
                : $appointment->appointment_time);

        // Extract just time if it's a full datetime string (contains date part)
        if (strlen($timeString) > 8 || strpos($timeString, '-') !== false) {
            // If it contains a date (has dashes or is longer than time format), extract just time
            try {
                $parsedTime = \Carbon\Carbon::parse($timeString, 'Asia/Kolkata');
                $timeString = $parsedTime->format('H:i:s');
            } catch (\Exception $e) {
                // If parsing fails, try to extract time manually
                if (preg_match('/(\d{2}:\d{2}:\d{2})/', $timeString, $matches)) {
                    $timeString = $matches[1];
                } elseif (preg_match('/(\d{2}:\d{2})/', $timeString, $matches)) {
                    $timeString = $matches[1] . ':00';
                }
            }
        }

        // Ensure we have a valid time string (HH:MM:SS format)
        if (strlen($timeString) <= 5) {
            $timeString = $timeString . ':00'; // Add seconds if missing
        }

        $appointmentDateTime = \Carbon\Carbon::parse($appointment->appointment_date->format('Y-m-d') . ' ' . $timeString, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
        // diffInMinutes(now(), false) returns negative for future times, positive for past times
        $nowIST = \Carbon\Carbon::now('Asia/Kolkata');
        $minutesDiff = $appointmentDateTime->diffInMinutes($nowIST, false);
        $canJoin = $minutesDiff >= -5; // True if within 5 minutes before or anytime after
        $sessionEndTime = $appointmentDateTime->copy()->addMinutes($appointment->duration_minutes ?? 60);
        $isSessionExpired = $nowIST->greaterThan($sessionEndTime);

        // Allow join button even if status is still 'scheduled' as long as we're within 5 minutes (cron may not have run yet)
        $isVideoOrAudio = in_array($appointment->session_mode, ['video', 'audio']);
        $statusCheck = in_array($appointment->status, ['confirmed', 'in_progress']) ||
            ($appointment->status === 'scheduled' && ($appointmentDateTime->lessThan(\Carbon\Carbon::now('Asia/Kolkata')) || $canJoin));

        $isActive = $canJoin && $isVideoOrAudio && $statusCheck && !$isSessionExpired;
      @endphp
      @if($isActive)
      <div class="session-actions">
        <div class="session-action-row">
          <a href="{{ route('sessions.join', $appointment->id) }}" class="btn-session-join" target="_blank">
            <i class="ri-vidicon-line"></i>
            Join Session Now
          </a>
          <a href="{{ route('client.appointments.show', $appointment->id) }}" class="btn btn-sm btn-dashboard-icon" title="View details">
            <i class="ri-eye-line"></i>
          </a>
        </div>
      </div>
      @elseif(!empty($isSessionExpired) && $isSessionExpired)
      <div class="session-actions">
        <p class="session-join-hint"><i class="ri-timer-line"></i> This session has ended.</p>
        <div class="session-action-row">
          <a href="{{ route('client.appointments.show', $appointment->id) }}" class="btn btn-sm btn-dashboard-outline">
            <i class="ri-eye-line me-1"></i>View Details
          </a>
        </div>
      </div>
      @elseif(!$canJoin)
      @php
          $joinAvailableAt = $appointmentDateTime->copy()->subMinutes(5);
          $timeUntilJoin = $joinAvailableAt->diffForHumans(\Carbon\Carbon::now('Asia/Kolkata'), ['syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW]);
      @endphp
      <div class="session-actions">
        <p class="session-join-hint">
          <i class="ri-time-line"></i>
          Join opens {{ $timeUntilJoin }} (at {{ $joinAvailableAt->format('g:i A') }} IST)
        </p>
        <div class="session-action-row">
          <a href="{{ route('client.appointments.show', $appointment->id) }}" class="btn btn-sm btn-dashboard-outline">
            <i class="ri-eye-line me-1"></i>View Details
          </a>
        </div>
      </div>
      @endif
    </div>
  </div>
  @endforeach
</div>
@endif

@if(isset($onlineSessions) && $onlineSessions->count() > 0)
<div class="row mb-4">
  <!-- Online Sessions -->
  <div class="col-12 animate-fade-in animation-delay-3">
    <div class="dashboard-card" style="border-left: 4px solid #041c54;">
      <div class="card-header">
        <div class="section-header mb-0">
          <h5 class="section-title">
            <span class="section-title-icon primary"><i class="ri-broadcast-line"></i></span>
            Online Sessions
            <span class="badge ms-2" style="background: rgba(4, 28, 84, 0.1); color: #041c54;">{{ $onlineSessions->count() }}</span>
          </h5>
          <a href="{{ route('client.appointments.index') }}" class="btn btn-sm btn-dashboard-outline">
            View All
          </a>
        </div>
      </div>
      <div class="card-body custom-scroll" style="max-height: 300px; overflow-y: auto; padding: 1rem;">
        <div class="row g-3">
          @foreach($onlineSessions as $session)
          @php
            $timeString = is_string($session->appointment_time)
                ? $session->appointment_time
                : (is_object($session->appointment_time)
                    ? $session->appointment_time->format('H:i:s')
                    : $session->appointment_time);

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

            $appointmentDateTime = \Carbon\Carbon::parse($session->appointment_date->format('Y-m-d') . ' ' . $timeString, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
            $nowIST = \Carbon\Carbon::now('Asia/Kolkata');
            $minutesDiff = $appointmentDateTime->diffInMinutes($nowIST, false);
            $canJoin = $minutesDiff >= -5;
            $sessionEndTime = $appointmentDateTime->copy()->addMinutes($session->duration_minutes ?? 60);
            $isSessionExpired = $nowIST->greaterThan($sessionEndTime);
            $isActive = $canJoin && !$isSessionExpired && in_array($session->session_mode, ['video', 'audio']);
          @endphp
          <div class="col-md-6">
            <div class="session-card today">
              <div class="session-therapist">
                @if($session->therapist && $session->therapist->therapistProfile && $session->therapist->therapistProfile->profile_image)
                  <img src="{{ asset('storage/' . $session->therapist->therapistProfile->profile_image) }}" alt="{{ $session->therapist->name }}" class="therapist-avatar">
                @elseif($session->therapist && $session->therapist->avatar)
                  <img src="{{ $session->therapist->avatar }}" alt="{{ $session->therapist->name }}" class="therapist-avatar">
                @else
                  <img src="{{ \App\Support\ProfileAvatar::placeholderUrl() }}" alt="Therapist" class="therapist-avatar">
                @endif
                <div class="therapist-info">
                  <h6>{{ $session->therapist->name ?? 'N/A' }}</h6>
                  <span>{{ $session->appointment_date->format('D, M d') }}</span>
                </div>
                @if($session->status === 'in_progress')
                  <span class="badge bg-danger" style="animation: pulse 2s infinite;">LIVE</span>
                @endif
              </div>
              <div class="session-details">
                <div class="session-detail-item">
                  <i class="ri-time-line"></i>
                  <span>{{ \Carbon\Carbon::parse($timeString, 'Asia/Kolkata')->setTimezone('Asia/Kolkata')->format('g:i A') }} IST</span>
                </div>
                <div class="session-detail-item">
                  <i class="ri-{{ $session->session_mode === 'video' ? 'video' : 'mic' }}-line"></i>
                  <span>{{ ucfirst($session->session_mode ?? 'Online') }}</span>
                </div>
              </div>
              <div class="session-actions">
                @if($isActive)
                <div class="session-action-row">
                  <a href="{{ route('sessions.join', $session->id) }}" class="btn-session-join" target="_blank">
                    <i class="ri-{{ $session->session_mode === 'video' ? 'video' : 'mic' }}-line"></i>
                    Join Now
                  </a>
                  <a href="{{ route('client.appointments.show', $session->id) }}" class="btn btn-sm btn-dashboard-icon" title="View details">
                    <i class="ri-eye-line"></i>
                  </a>
                </div>
                @else
                <p class="session-join-hint"><i class="ri-time-off-line"></i> Session has ended.</p>
                <div class="session-action-row">
                  <a href="{{ route('client.appointments.show', $session->id) }}" class="btn btn-sm btn-dashboard-outline">
                    <i class="ri-eye-line me-1"></i>View Details
                  </a>
                </div>
                @endif
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
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
          <a href="{{ route('therapists.index') }}" class="btn btn-sm btn-dashboard-primary">
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
          <img src="{{ $appointment->therapist->avatar }}" alt="{{ $appointment->therapist->name }}" class="therapist-avatar">
        @else
          <img src="{{ \App\Support\ProfileAvatar::placeholderUrl() }}" alt="{{ $appointment->therapist->name }}" class="therapist-avatar">
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
                <span>{{ \Carbon\Carbon::parse($appointment->appointment_time, 'Asia/Kolkata')->setTimezone('Asia/Kolkata')->format('g:i A') }} IST</span>
              </div>
              <div class="session-detail-item">
                <i class="ri-vidicon-line"></i>
                <span>{{ ucfirst($appointment->session_mode ?? 'Online') }}</span>
              </div>
            </div>
            <div class="session-actions">
              @php
                // Check if join button should be shown for upcoming appointments
                $timeString = is_string($appointment->appointment_time)
                    ? $appointment->appointment_time
                    : (is_object($appointment->appointment_time)
                        ? $appointment->appointment_time->format('H:i:s')
                        : $appointment->appointment_time);

                // Extract just time if it's a full datetime string (contains date part)
                if (strlen($timeString) > 8 || strpos($timeString, '-') !== false) {
                    // If it contains a date (has dashes or is longer than time format), extract just time
                    try {
                        $parsedTime = \Carbon\Carbon::parse($timeString, 'Asia/Kolkata');
                        $timeString = $parsedTime->format('H:i:s');
                    } catch (\Exception $e) {
                        // If parsing fails, try to extract time manually
                        if (preg_match('/(\d{2}:\d{2}:\d{2})/', $timeString, $matches)) {
                            $timeString = $matches[1];
                        } elseif (preg_match('/(\d{2}:\d{2})/', $timeString, $matches)) {
                            $timeString = $matches[1] . ':00';
                        }
                    }
                }

                // Ensure we have a valid time string (HH:MM:SS format)
                if (strlen($timeString) <= 5) {
                    $timeString = $timeString . ':00'; // Add seconds if missing
                }

                $appointmentDateTime = \Carbon\Carbon::parse($appointment->appointment_date->format('Y-m-d') . ' ' . $timeString, 'Asia/Kolkata')->setTimezone('Asia/Kolkata');
                $nowISTUpcoming = \Carbon\Carbon::now('Asia/Kolkata');
                $canJoinUpcoming = $appointmentDateTime->diffInMinutes($nowISTUpcoming, false) >= -5;
                // Allow join button even if status is still 'scheduled' as long as we're within 5 minutes (cron may not have run yet)
                $isActiveUpcoming = $canJoinUpcoming && in_array($appointment->session_mode, ['video', 'audio']) && (
                    in_array($appointment->status, ['confirmed', 'in_progress']) ||
                    ($appointment->status === 'scheduled' && ($appointmentDateTime->lessThan(\Carbon\Carbon::now('Asia/Kolkata')) || $canJoinUpcoming))
                );
              @endphp
              @if($isActiveUpcoming)
              <div class="session-action-row">
                <a href="{{ route('sessions.join', $appointment->id) }}" class="btn-session-join" target="_blank">
                  <i class="ri-vidicon-line"></i>Join Session
                </a>
                <a href="{{ route('client.appointments.show', $appointment->id) }}" class="btn btn-sm btn-dashboard-icon" title="View details">
                  <i class="ri-eye-line"></i>
                </a>
              </div>
              @else
              @if(!$canJoinUpcoming)
              @php
                  $joinAvailableAtUpcoming = $appointmentDateTime->copy()->subMinutes(5);
                  $timeUntilJoinUpcoming = $joinAvailableAtUpcoming->diffForHumans(\Carbon\Carbon::now('Asia/Kolkata'), ['syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW]);
              @endphp
              <p class="session-join-hint">
                <i class="ri-time-line"></i>
                Join opens {{ $timeUntilJoinUpcoming }} (at {{ $joinAvailableAtUpcoming->format('g:i A') }} IST)
              </p>
              @endif
              <div class="session-action-row">
                <a href="{{ route('client.appointments.show', $appointment->id) }}" class="btn btn-sm btn-dashboard-outline">
                  <i class="ri-eye-line me-1"></i>View Details
                </a>
              </div>
              @endif
            </div>
          </div>
          @endforeach
          @if($upcomingAppointments->count() > 4)
          <div class="text-center mt-3">
            <a href="{{ route('client.appointments.index') }}" class="btn btn-sm btn-dashboard-outline">
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
          <a href="{{ route('client.appointments.index') }}" class="btn btn-sm btn-dashboard-outline">
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
                    <a href="{{ route('client.appointments.show', $appointment->id) }}" class="btn btn-sm btn-dashboard-icon" title="View">
                      <i class="ri-eye-line"></i>
                    </a>
                    <a href="{{ route('client.reviews.create', $appointment->id) }}" class="btn btn-sm btn-dashboard-icon" title="Review">
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
          <a href="{{ route('assessments.index') }}" class="btn btn-sm btn-dashboard-outline">
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
            <span class="section-title-icon primary"><i class="ri-wallet-3-line"></i></span>
            Recent Transactions
          </h5>
          <button type="button" class="btn btn-sm btn-dashboard-primary" data-bs-toggle="modal" data-bs-target="#rechargeWalletModal">
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
            <a href="{{ route('client.wallet.index') }}" class="btn btn-sm btn-dashboard-outline">
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
