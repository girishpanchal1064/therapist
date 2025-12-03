@extends('layouts/contentNavbarLayout')

@section('title', 'Admin Dashboard')

@section('page-style')
<style>
  /* Page Header */
  .dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
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
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  }

  .stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
  }

  .stats-icon.info {
    background: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%);
    color: white;
  }

  .stats-icon.success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: white;
  }

  .stats-icon.warning {
    background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
    color: white;
  }

  .stats-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.2;
  }

  .stats-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 500;
  }

  /* Content Cards */
  .content-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
  }

  .content-card .card-header {
    background: white;
    border-bottom: 2px solid #f0f2f5;
    padding: 1.25rem 1.5rem;
  }

  .content-card .card-header h5 {
    color: #1e293b;
    font-weight: 600;
    margin: 0;
  }

  .content-card .card-body {
    padding: 1.5rem;
  }

  /* Table Styling - Enhanced */
  .dashboard-table {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    width: 100%;
  }

  .dashboard-table thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 18px 20px;
    border: none;
    white-space: nowrap;
  }

  .dashboard-table thead th:first-child {
    border-radius: 12px 0 0 0;
  }

  .dashboard-table thead th:last-child {
    border-radius: 0 12px 0 0;
  }

  .dashboard-table tbody tr {
    transition: all 0.3s ease;
    background: white;
    border-bottom: 1px solid #f0f2f5;
  }

  .dashboard-table tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.04) 0%, rgba(118, 75, 162, 0.04) 100%);
    transform: scale(1.001);
    box-shadow: 0 2px 12px rgba(102, 126, 234, 0.08);
  }

  .dashboard-table tbody tr:last-child {
    border-bottom: none;
  }

  .dashboard-table tbody td {
    padding: 18px 20px;
    vertical-align: middle;
    color: #2d3748;
    font-size: 0.9rem;
    border-bottom: 1px solid #f0f2f5;
  }

  .dashboard-table tbody tr:last-child td {
    border-bottom: none;
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
  }

  .user-details h6 {
    margin: 0;
    font-size: 0.9rem;
    font-weight: 600;
    color: #1e293b;
  }

  .user-details small {
    color: #64748b;
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
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
  }

  .status-badge.pending {
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    color: #4338ca;
  }

  .role-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
    font-size: 0.6875rem;
    font-weight: 600;
  }

  /* Quick Actions */
  .quick-actions-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
  }

  .quick-actions-card .card-header {
    background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
    border-bottom: none;
    padding: 1.25rem 1.5rem;
  }

  .quick-actions-card .card-header h5 {
    color: #4338ca;
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }

  .quick-action-btn.primary:hover {
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
  }

  .quick-action-btn.info {
    background: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%);
    border: none;
    color: white;
    box-shadow: 0 4px 15px rgba(91, 134, 229, 0.3);
  }

  .quick-action-btn.info:hover {
    box-shadow: 0 6px 20px rgba(91, 134, 229, 0.4);
    color: white;
  }

  .quick-action-btn.success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    border: none;
    color: white;
    box-shadow: 0 4px 15px rgba(56, 239, 125, 0.3);
  }

  .quick-action-btn.success:hover {
    box-shadow: 0 6px 20px rgba(56, 239, 125, 0.4);
    color: white;
  }

  .quick-action-btn.warning {
    background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
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
    background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
    color: #4338ca;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    transition: all 0.2s ease;
  }

  .btn-view-all:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
          <div class="table-responsive">
            <table class="table dashboard-table">
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
          <div class="table-responsive">
            <table class="table dashboard-table">
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
