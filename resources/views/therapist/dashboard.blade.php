@extends('layouts/contentNavbarLayout')

@section('title', 'Therapist Dashboard')

@section('page-style')
<style>
  /* === Therapist Dashboard Custom Styles === */
  :root {
    --therapist-primary: #059669;
    --therapist-primary-light: #34d399;
    --therapist-secondary: #7c3aed;
    --therapist-accent: #f59e0b;
    --therapist-gradient: linear-gradient(135deg, #059669 0%, #10b981 100%);
    --therapist-gradient-alt: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --therapist-shadow: 0 10px 40px -10px rgba(5, 150, 105, 0.2);
  }

  /* Welcome Banner */
  .welcome-banner {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
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
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .welcome-text h1 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
  }

  .welcome-text p {
    opacity: 0.9;
    font-size: 1rem;
    margin-bottom: 0;
    font-weight: 400;
  }

  .welcome-actions {
    display: flex;
    gap: 0.75rem;
  }

  .welcome-action-btn {
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
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .welcome-action-btn:hover {
    background: rgba(255,255,255,0.3);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
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
    box-shadow: var(--therapist-shadow);
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

  .stat-card.primary::before { background: var(--therapist-gradient); }
  .stat-card.success::before { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); }
  .stat-card.warning::before { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
  .stat-card.info::before { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }

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
    background: linear-gradient(135deg, rgba(5, 150, 105, 0.15) 0%, rgba(16, 185, 129, 0.15) 100%); 
    color: #059669;
  }
  .stat-icon.success { 
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(22, 163, 74, 0.15) 100%); 
    color: #16a34a;
  }
  .stat-icon.warning { 
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.15) 100%); 
    color: #d97706;
  }
  .stat-icon.info { 
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%); 
    color: #2563eb;
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

  .section-title-icon.primary { background: rgba(5, 150, 105, 0.1); color: #059669; }
  .section-title-icon.warning { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
  .section-title-icon.info { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }

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

  /* Session Cards */
  .session-card {
    background: white;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    padding: 1.25rem;
    transition: all 0.3s ease;
    position: relative;
    margin-bottom: 1rem;
  }

  .session-card:last-child {
    margin-bottom: 0;
  }

  .session-card:hover {
    border-color: #34d399;
    box-shadow: 0 8px 25px rgba(5, 150, 105, 0.12);
  }

  .session-card.today {
    border-left: 4px solid #059669;
    background: linear-gradient(90deg, rgba(5, 150, 105, 0.03) 0%, transparent 100%);
  }

  .session-card.upcoming {
    border-left: 4px solid #3b82f6;
  }

  .session-client {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
  }

  .client-avatar {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid #f3f4f6;
  }

  .client-avatar-placeholder {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1rem;
  }

  .client-info h6 {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.125rem;
    font-size: 0.9375rem;
  }

  .client-info span {
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
  .status-badge.scheduled { background: rgba(245, 158, 11, 0.1); color: #d97706; }
  .status-badge.completed { background: rgba(107, 114, 128, 0.1); color: #4b5563; }

  /* Mode Badges */
  .mode-badge {
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
    font-size: 0.6875rem;
    font-weight: 600;
    text-transform: uppercase;
  }

  .mode-badge.video { background: rgba(59, 130, 246, 0.1); color: #2563eb; }
  .mode-badge.audio { background: rgba(245, 158, 11, 0.1); color: #d97706; }
  .mode-badge.chat { background: rgba(107, 114, 128, 0.1); color: #4b5563; }

  /* Table Styles */
  .sessions-table {
    width: 100%;
  }

  .sessions-table th {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0.75rem 0;
    border-bottom: 2px solid #f3f4f6;
  }

  .sessions-table td {
    padding: 1rem 0;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
  }

  .sessions-table tbody tr:last-child td {
    border-bottom: none;
  }

  .sessions-table tbody tr {
    transition: all 0.2s ease;
  }

  .sessions-table tbody tr:hover {
    background: #f0fdf4;
  }

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
    margin-bottom: 0;
  }

  /* Quick Tip Card */
  .tip-card {
    background: linear-gradient(135deg, #fef3cd 0%, #fff4e5 100%);
    border: 1px solid #fbbf24;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
  }

  .tip-card h5 {
    color: #92400e;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .tip-card p {
    color: #b45309;
    margin: 0;
    font-size: 0.9375rem;
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

  /* Responsive */
  @media (max-width: 768px) {
    .welcome-banner {
      padding: 1.5rem;
    }

    .welcome-content {
      flex-direction: column;
      align-items: flex-start;
      gap: 1rem;
    }

    .welcome-text h1 {
      font-size: 1.375rem;
    }

    .welcome-actions {
      flex-wrap: wrap;
    }

    .stat-card {
      padding: 1.25rem;
    }

    .stat-value {
      font-size: 1.5rem;
    }
  }

  /* Custom scrollbar */
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
    <div class="welcome-text">
      <h1>
        @php
          $hour = now()->hour;
          $greeting = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');
        @endphp
        {{ $greeting }}, Dr. {{ auth()->user()->name }}! 👋
      </h1>
      <p>Here's your practice overview for today. You're making a difference!</p>
    </div>
    <div class="welcome-actions">
      <a href="{{ route('therapist.availability.set') }}" class="welcome-action-btn">
        <i class="ri-calendar-schedule-line"></i> Manage Availability
      </a>
      <a href="{{ route('therapist.sessions.index') }}" class="welcome-action-btn">
        <i class="ri-video-line"></i> View All Sessions
      </a>
    </div>
  </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
  <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-lg-0 animate-fade-in animation-delay-1">
    <div class="stat-card primary">
      <div class="stat-icon primary">
        <i class="ri-calendar-todo-line"></i>
      </div>
      <div class="stat-label">Today's Sessions</div>
      <div class="stat-value">{{ $todayAppointments->count() }}</div>
      <div class="stat-meta {{ $todayAppointments->count() > 0 ? 'positive' : '' }}">
        @if($todayAppointments->count() > 0)
          <i class="ri-checkbox-circle-line"></i>
          <span>Sessions scheduled</span>
        @else
          <span>No sessions today</span>
        @endif
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-lg-0 animate-fade-in animation-delay-2">
    <div class="stat-card success">
      <div class="stat-icon success">
        <i class="ri-check-double-line"></i>
      </div>
      <div class="stat-label">Completed This Month</div>
      <div class="stat-value">{{ $completedThisMonth }}</div>
      <div class="stat-meta positive">
        <i class="ri-arrow-up-s-line"></i>
        <span>Great progress!</span>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-md-0 animate-fade-in animation-delay-3">
    <div class="stat-card warning">
      <div class="stat-icon warning">
        <i class="ri-money-rupee-circle-line"></i>
      </div>
      <div class="stat-label">Monthly Earnings</div>
      <div class="stat-value">₹{{ number_format($monthlyEarnings, 0) }}</div>
      <div class="stat-meta">
        <i class="ri-wallet-3-line"></i>
        <span>This month</span>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 animate-fade-in animation-delay-4">
    <div class="stat-card info">
      <div class="stat-icon info">
        <i class="ri-star-line"></i>
      </div>
      <div class="stat-label">Pending Reviews</div>
      <div class="stat-value">{{ $pendingReviews }}</div>
      <div class="stat-meta">
        <i class="ri-feedback-line"></i>
        <span>Awaiting feedback</span>
      </div>
    </div>
  </div>
</div>

<!-- Today's Sessions Alert -->
@if($todayAppointments->count() > 0)
<div class="tip-card animate-fade-in animation-delay-3">
  <h5>
    <i class="ri-calendar-check-fill"></i>
    You have {{ $todayAppointments->count() }} session(s) scheduled today!
  </h5>
  <p>Make sure to prepare for your upcoming sessions and join on time for the best client experience.</p>
</div>
@endif

<div class="row">
  <!-- Today's Sessions -->
  <div class="col-lg-6 mb-4 animate-fade-in animation-delay-4">
    <div class="dashboard-card">
      <div class="card-header">
        <div class="section-header mb-0">
          <h5 class="section-title">
            <span class="section-title-icon primary"><i class="ri-calendar-todo-line"></i></span>
            Today's Sessions
          </h5>
          @if($todayAppointments->count() > 0)
            <span class="badge bg-success" style="border-radius: 8px;">{{ $todayAppointments->count() }} session(s)</span>
          @endif
        </div>
      </div>
      <div class="card-body custom-scroll" style="max-height: 450px; overflow-y: auto;">
        @if($todayAppointments->count() > 0)
          @foreach($todayAppointments as $appointment)
          <div class="session-card today">
            <div class="session-client">
              @if($appointment->client?->avatar)
                <img src="{{ $appointment->client->avatar }}" alt="{{ $appointment->client->name }}" class="client-avatar">
              @else
                <div class="client-avatar-placeholder">
                  {{ strtoupper(substr($appointment->client?->name ?? 'U', 0, 2)) }}
                </div>
              @endif
              <div class="client-info">
                <h6>{{ $appointment->client?->name ?? 'Unknown Client' }}</h6>
                <span>{{ $appointment->client?->email ?? '' }}</span>
              </div>
              <span class="status-badge {{ $appointment->status }} ms-auto">{{ ucfirst($appointment->status) }}</span>
            </div>
            <div class="session-details">
              <div class="session-detail-item">
                <i class="ri-time-line"></i>
                <span>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</span>
              </div>
              <div class="session-detail-item">
                <span class="mode-badge {{ $appointment->session_mode }}">{{ strtoupper($appointment->session_mode) }}</span>
              </div>
              <div class="session-detail-item">
                <i class="ri-timer-line"></i>
                <span>{{ $appointment->duration ?? 60 }} mins</span>
              </div>
            </div>
          </div>
          @endforeach
        @else
          <div class="empty-state">
            <div class="empty-state-icon">
              <i class="ri-calendar-line"></i>
            </div>
            <h6>No sessions scheduled for today</h6>
            <p>Enjoy your free time or review upcoming appointments.</p>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Upcoming Sessions -->
  <div class="col-lg-6 mb-4 animate-fade-in animation-delay-4">
    <div class="dashboard-card">
      <div class="card-header">
        <div class="section-header mb-0">
          <h5 class="section-title">
            <span class="section-title-icon info"><i class="ri-calendar-schedule-line"></i></span>
            Upcoming (Next 7 Days)
          </h5>
          <a href="{{ route('therapist.sessions.index', ['status' => 'upcoming']) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 10px;">
            View All
          </a>
        </div>
      </div>
      <div class="card-body custom-scroll" style="max-height: 450px; overflow-y: auto;">
        @if($upcomingAppointments->count() > 0)
          <table class="sessions-table">
            <thead>
              <tr>
                <th>Client</th>
                <th>Date & Time</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($upcomingAppointments->take(6) as $appointment)
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    @if($appointment->client?->avatar)
                      <img src="{{ $appointment->client->avatar }}" alt="{{ $appointment->client->name }}" class="client-avatar me-3" style="width: 40px; height: 40px;">
                    @else
                      <div class="client-avatar-placeholder me-3" style="width: 40px; height: 40px; font-size: 0.875rem;">
                        {{ strtoupper(substr($appointment->client?->name ?? 'U', 0, 2)) }}
                      </div>
                    @endif
                    <div>
                      <h6 class="mb-0" style="font-size: 0.875rem; font-weight: 600;">{{ $appointment->client?->name ?? 'Unknown' }}</h6>
                      <span class="mode-badge {{ $appointment->session_mode }}">{{ strtoupper($appointment->session_mode) }}</span>
                    </div>
                  </div>
                </td>
                <td>
                  <div style="font-size: 0.875rem; font-weight: 500; color: #1f2937;">
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                  </div>
                  <div style="font-size: 0.8125rem; color: #6b7280;">
                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                  </div>
                </td>
                <td>
                  <span class="status-badge {{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @if($upcomingAppointments->count() > 6)
          <div class="text-center mt-3">
            <a href="{{ route('therapist.sessions.index', ['status' => 'upcoming']) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 10px;">
              View All ({{ $upcomingAppointments->count() }})
            </a>
          </div>
          @endif
        @else
          <div class="empty-state">
            <div class="empty-state-icon">
              <i class="ri-calendar-schedule-line"></i>
            </div>
            <h6>No upcoming sessions</h6>
            <p>You have no sessions scheduled for the next 7 days.</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Quick Links Section -->
<div class="row">
  <div class="col-12 animate-fade-in animation-delay-4">
    <div class="dashboard-card">
      <div class="card-header">
        <div class="section-header mb-0">
          <h5 class="section-title">
            <span class="section-title-icon warning"><i class="ri-flashlight-line"></i></span>
            Quick Actions
          </h5>
        </div>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-lg-3 col-md-6">
            <a href="{{ route('therapist.profile.index') }}" class="d-block p-3 text-center rounded-3" style="background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%); border: 1px solid #e9d5ff; text-decoration: none; transition: all 0.3s ease;">
              <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                <i class="ri-user-settings-line text-white" style="font-size: 1.25rem;"></i>
              </div>
              <h6 style="font-weight: 600; color: #6b21a8; margin-bottom: 0.25rem;">Edit Profile</h6>
              <p style="font-size: 0.75rem; color: #9333ea; margin: 0;">Update your information</p>
            </a>
          </div>
          <div class="col-lg-3 col-md-6">
            <a href="{{ route('therapist.availability.set') }}" class="d-block p-3 text-center rounded-3" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #86efac; text-decoration: none; transition: all 0.3s ease;">
              <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #059669 0%, #10b981 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                <i class="ri-calendar-schedule-line text-white" style="font-size: 1.25rem;"></i>
              </div>
              <h6 style="font-weight: 600; color: #166534; margin-bottom: 0.25rem;">Set Availability</h6>
              <p style="font-size: 0.75rem; color: #16a34a; margin: 0;">Manage your schedule</p>
            </a>
          </div>
          <div class="col-lg-3 col-md-6">
            <a href="{{ route('therapist.reviews.index') }}" class="d-block p-3 text-center rounded-3" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1px solid #fcd34d; text-decoration: none; transition: all 0.3s ease;">
              <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                <i class="ri-star-line text-white" style="font-size: 1.25rem;"></i>
              </div>
              <h6 style="font-weight: 600; color: #92400e; margin-bottom: 0.25rem;">My Reviews</h6>
              <p style="font-size: 0.75rem; color: #b45309; margin: 0;">View client feedback</p>
            </a>
          </div>
          <div class="col-lg-3 col-md-6">
            <a href="{{ route('therapist.account-summary.index') }}" class="d-block p-3 text-center rounded-3" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #93c5fd; text-decoration: none; transition: all 0.3s ease;">
              <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                <i class="ri-bar-chart-box-line text-white" style="font-size: 1.25rem;"></i>
              </div>
              <h6 style="font-weight: 600; color: #1e40af; margin-bottom: 0.25rem;">Account Summary</h6>
              <p style="font-size: 0.75rem; color: #2563eb; margin: 0;">View your earnings</p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Motivational Quote -->
<div class="row mt-4">
  <div class="col-12 animate-fade-in animation-delay-4">
    <div class="dashboard-card" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #86efac;">
      <div class="card-body text-center py-4">
        <div style="font-size: 2.5rem; margin-bottom: 1rem;">💚</div>
        <blockquote style="font-size: 1.125rem; font-weight: 500; color: #166534; font-style: italic; margin-bottom: 0.5rem;">
          "{{ collect([
            'Every session you conduct is a step towards someone\'s healing journey.',
            'Your compassion and expertise are making a real difference in people\'s lives.',
            'The work you do matters. Thank you for being a healer.',
            'Your dedication to mental health is changing lives, one session at a time.',
            'You are not just a therapist; you are a beacon of hope for many.'
          ])->random() }}"
        </blockquote>
        <small style="color: #059669;">— A reminder of your impact</small>
      </div>
    </div>
  </div>
</div>
@endsection
