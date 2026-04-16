@extends('layouts/contentNavbarLayout')

@section('title', 'Admin Dashboard')

@section('page-style')
<style>
  .layout-page .content-wrapper { background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important; }

  /* Page Header */
  .dashboard-header {
    background: linear-gradient(171deg, #647494 0%, #6d7f9d 25%, #7484A4 50%, #6d7f9d 75%, #647494 100%);
    border-radius: 24px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
  }

  .dashboard-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  .dashboard-header::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
  }

  .dashboard-header h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
  }

  .dashboard-header p {
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 0;
    position: relative;
    z-index: 1;
  }

  .header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: white;
    backdrop-filter: blur(10px);
  }

  /* Stats Cards */
  .stats-card {
    border: 1px solid rgba(186, 194, 210, 0.3);
    border-radius: 16px;
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
  }

  .stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
  }

  .stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 28px rgba(4, 28, 84, 0.12);
  }

  .stats-card .card-body {
    padding: 1.5rem;
  }

  .stats-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
  }

  .stats-icon.primary {
    background: rgba(100, 116, 148, 0.12);
    color: #647494;
  }

  .stats-icon.info {
    background: rgba(6, 182, 212, 0.12);
    color: #0891b2;
  }

  .stats-icon.success {
    background: rgba(16, 185, 129, 0.12);
    color: #059669;
  }

  .stats-icon.warning {
    background: rgba(245, 158, 11, 0.12);
    color: #d97706;
  }

  .stats-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #041C54;
    line-height: 1.2;
  }

  .stats-label {
    font-size: 0.875rem;
    color: #7484A4;
    font-weight: 500;
  }

  /* Content Cards */
  .content-card {
    border: 1px solid rgba(186, 194, 210, 0.3);
    border-radius: 16px;
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    overflow: hidden;
  }

  .content-card .card-header {
    background: white;
    border-bottom: 1px solid rgba(186, 194, 210, 0.35);
    padding: 1.25rem 1.5rem;
  }

  .content-card .card-header h5 {
    color: #041C54;
    font-weight: 600;
    margin: 0;
  }

  .content-card .card-body {
    padding: 1.5rem;
  }

  /* User Info */
  .user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
  }

  .user-avatar-initials {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    color: white;
  }

  .user-details h6 {
    margin: 0;
    font-size: 0.9rem;
    font-weight: 600;
    color: #041C54;
  }

  .user-details small {
    color: #7484A4;
    font-size: 0.75rem;
  }

  /* Badges */
  .status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
  }

  .status-badge.completed {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
  }

  .status-badge.scheduled {
    background: rgba(245, 158, 11, 0.14);
    color: #b45309;
  }

  .status-badge.pending {
    background: rgba(100, 116, 148, 0.14);
    color: #334155;
  }

  .role-badge {
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    color: white;
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
    font-size: 0.6875rem;
    font-weight: 600;
  }

  /* Quick Actions */
  .quick-actions-card {
    border: 1px solid rgba(186, 194, 210, 0.3);
    border-radius: 16px;
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    overflow: hidden;
  }

  .quick-actions-card .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
    border-bottom: none;
    padding: 1.25rem 1.5rem;
  }

  .quick-actions-card .card-header h5 {
    color: #041C54;
    font-weight: 600;
    margin: 0;
  }

  .quick-action-btn {
    border-radius: 12px;
    padding: 1rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
  }

  .quick-action-btn:hover {
    transform: translateY(-2px);
  }

  .quick-action-btn.primary {
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    border: none;
    color: white;
    box-shadow: 0 8px 14px rgba(4, 28, 84, 0.2);
  }

  .quick-action-btn.primary:hover {
    box-shadow: 0 10px 18px rgba(4, 28, 84, 0.28);
    color: white;
  }

  .quick-action-btn.info {
    background: linear-gradient(90deg, #0ea5b7 0%, #3b82f6 100%);
    border: none;
    color: white;
    box-shadow: 0 4px 15px rgba(91, 134, 229, 0.3);
  }

  .quick-action-btn.info:hover {
    box-shadow: 0 6px 20px rgba(91, 134, 229, 0.4);
    color: white;
  }

  .quick-action-btn.success {
    background: linear-gradient(90deg, #059669 0%, #10b981 100%);
    border: none;
    color: white;
    box-shadow: 0 4px 15px rgba(56, 239, 125, 0.3);
  }

  .quick-action-btn.success:hover {
    box-shadow: 0 6px 20px rgba(56, 239, 125, 0.4);
    color: white;
  }

  .quick-action-btn.warning {
    background: linear-gradient(90deg, #d97706 0%, #f59e0b 100%);
    border: none;
    color: white;
    box-shadow: 0 4px 15px rgba(255, 210, 0, 0.3);
  }

  .quick-action-btn.warning:hover {
    box-shadow: 0 6px 20px rgba(255, 210, 0, 0.4);
    color: white;
  }

  /* View All Button */
  .btn-view-all {
    background: rgba(100, 116, 148, 0.1);
    color: #647494;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    transition: all 0.2s ease;
  }

  .btn-view-all:hover {
    background: #041C54;
    color: white;
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 2rem;
    color: #64748b;
  }

  .empty-state i {
    font-size: 2.5rem;
    color: #cbd5e1;
    margin-bottom: 0.75rem;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .dashboard-header {
      padding: 1.5rem;
    }

    .stats-card .card-body {
      padding: 1rem;
    }

    .stats-value {
      font-size: 1.5rem;
    }
  }
</style>
@endsection

@section('content')
<!-- Dashboard Header -->
<div class="dashboard-header">
  <div class="d-flex align-items-center gap-3">
    <div class="header-icon">
      <i class="ri-dashboard-3-line"></i>
    </div>
    <div>
      <h4 class="mb-1">Welcome back, {{ auth()->user()->name }}!</h4>
      <p class="mb-0">Here's what's happening with your platform today.</p>
    </div>
  </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
  <div class="col-lg-3 col-md-6 col-12">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="stats-label mb-1">Total Users</div>
            <div class="stats-value">{{ number_format($stats['total_users']) }}</div>
            <small class="text-success">
              <i class="ri-arrow-up-line"></i> Active accounts
            </small>
          </div>
          <div class="stats-icon primary">
            <i class="ri-user-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="stats-label mb-1">Total Therapists</div>
            <div class="stats-value">{{ number_format($stats['total_therapists']) }}</div>
            <small class="text-info">
              <i class="ri-heart-pulse-line"></i> Healthcare providers
            </small>
          </div>
          <div class="stats-icon info">
            <i class="ri-user-heart-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="stats-label mb-1">Total Appointments</div>
            <div class="stats-value">{{ number_format($stats['total_appointments']) }}</div>
            <small class="text-success">
              <i class="ri-calendar-check-line"></i> Sessions booked
            </small>
          </div>
          <div class="stats-icon success">
            <i class="ri-calendar-check-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-12">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="stats-label mb-1">Monthly Revenue</div>
            <div class="stats-value">${{ number_format($stats['monthly_revenue'], 2) }}</div>
            <small class="text-warning">
              <i class="ri-money-dollar-circle-line"></i> This month
            </small>
          </div>
          <div class="stats-icon warning">
            <i class="ri-money-dollar-circle-line"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Recent Data Tables -->
<div class="row g-4 mb-4">
  <!-- Recent Appointments -->
  <div class="col-lg-6">
    <div class="card content-card h-100">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5><i class="ri-calendar-line me-2 text-primary"></i>Recent Appointments</h5>
        <a href="{{ route('admin.appointments.index') }}" class="btn btn-view-all">
          View All <i class="ri-arrow-right-line ms-1"></i>
        </a>
      </div>
      <div class="card-body p-0">
        @if($recent_appointments->count() > 0)
          <div class="table-responsive admin-table-scroll">
            <table class="table dashboard-table table-hover align-middle">
              <thead>
                <tr>
                  <th>Client</th>
                  <th>Therapist</th>
                  <th>Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recent_appointments as $appointment)
                <tr>
                  <td>
                    <div class="user-info">
                      @if($appointment->client)
                        @if($appointment->client->profile && $appointment->client->profile->profile_image)
                          <img src="{{ asset('storage/' . $appointment->client->profile->profile_image) }}" alt="{{ $appointment->client->name }}" class="user-avatar">
                        @elseif($appointment->client->getRawOriginal('avatar'))
                          <img src="{{ asset('storage/' . $appointment->client->getRawOriginal('avatar')) }}" alt="{{ $appointment->client->name }}" class="user-avatar">
                        @else
                          <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->client->name) }}&background=3b82f6&color=fff&size=80&bold=true&format=svg" alt="{{ $appointment->client->name }}" class="user-avatar">
                        @endif
                      @else
                        <div class="user-avatar-initials">
                          NA
                        </div>
                      @endif
                      <div class="user-details">
                        <h6>{{ $appointment->client->name ?? 'N/A' }}</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="text-muted">{{ $appointment->therapist->name ?? 'N/A' }}</span>
                  </td>
                  <td>
                    <span class="fw-medium">{{ $appointment->appointment_date->format('M d, Y') }}</span>
                  </td>
                  <td>
                    <span class="status-badge {{ $appointment->status }}">
                      {{ ucfirst($appointment->status) }}
                    </span>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="empty-state">
            <i class="ri-calendar-close-line d-block"></i>
            <p class="mb-0">No recent appointments found.</p>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Recent Users -->
  <div class="col-lg-6">
    <div class="card content-card h-100">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5><i class="ri-user-line me-2 text-primary"></i>Recent Users</h5>
        <a href="{{ route('admin.users.index') }}" class="btn btn-view-all">
          View All <i class="ri-arrow-right-line ms-1"></i>
        </a>
      </div>
      <div class="card-body p-0">
        @if($recent_users->count() > 0)
          <div class="table-responsive admin-table-scroll">
            <table class="table dashboard-table table-hover align-middle">
              <thead>
                <tr>
                  <th>User</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recent_users as $user)
                <tr>
                  <td>
                    <div class="user-info">
                      @if($user->getRawOriginal('avatar'))
                        <img src="{{ $user->avatar }}" alt="Avatar" class="user-avatar">
                      @else
                        <div class="user-avatar-initials">
                          {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                      @endif
                      <div class="user-details">
                        <h6>{{ $user->name }}</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="text-muted">{{ $user->email }}</span>
                  </td>
                  <td>
                    @foreach($user->roles as $role)
                      <span class="role-badge">{{ ucfirst($role->name) }}</span>
                    @endforeach
                  </td>
                  <td>
                    <span class="status-badge {{ $user->status === 'active' ? 'completed' : ($user->status === 'suspended' ? 'scheduled' : 'pending') }}">
                      {{ ucfirst($user->status) }}
                    </span>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="empty-state">
            <i class="ri-user-unfollow-line d-block"></i>
            <p class="mb-0">No recent users found.</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Quick Actions -->
<div class="row">
  <div class="col-12">
    <div class="card quick-actions-card">
      <div class="card-header">
        <h5><i class="ri-flashlight-line me-2"></i>Quick Actions</h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-3 col-sm-6">
            <a href="{{ route('admin.users.create') }}" class="btn quick-action-btn primary w-100">
              <i class="ri-user-add-line"></i>
              Add User
            </a>
          </div>
          <div class="col-md-3 col-sm-6">
            <a href="{{ route('admin.therapists.create') }}" class="btn quick-action-btn info w-100">
              <i class="ri-user-heart-line"></i>
              Add Therapist
            </a>
          </div>
          <div class="col-md-3 col-sm-6">
            <a href="{{ route('admin.appointments.create') }}" class="btn quick-action-btn success w-100">
              <i class="ri-calendar-check-line"></i>
              Schedule Session
            </a>
          </div>
          <div class="col-md-3 col-sm-6">
            <a href="{{ route('admin.blog.create') }}" class="btn quick-action-btn warning w-100">
              <i class="ri-article-line"></i>
              Create Blog
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
