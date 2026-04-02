@extends('layouts/contentNavbarLayout')

@section('title', 'System Settings')

@section('page-style')
<style>
  .layout-page .content-wrapper {
    background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important;
  }

  .system-settings-page {
    padding-top: 1.5rem;
    padding-bottom: 2.75rem;
  }

  @media (min-width: 992px) {
    .system-settings-page {
      padding-top: 1.75rem;
      padding-bottom: 3rem;
    }
  }

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
    flex-shrink: 0;
    position: relative;
    z-index: 1;
  }

  .btn-header {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
  }

  .btn-header:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
  }

  .content-card {
    border: 1px solid rgba(186, 194, 210, 0.3);
    border-radius: 16px;
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    overflow: hidden;
    margin-bottom: 1.5rem;
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
    font-size: 1.05rem;
  }

  .content-card .card-header small {
    color: #7484A4;
    font-size: 0.8125rem;
  }

  .content-card .card-body {
    padding: 1.5rem;
  }

  .stats-card {
    border: 1px solid rgba(186, 194, 210, 0.3);
    border-radius: 16px;
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
    height: 100%;
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
    transform: translateY(-3px);
    box-shadow: 0 14px 28px rgba(4, 28, 84, 0.12);
  }

  .stats-label {
    font-size: 0.875rem;
    color: #7484A4;
    font-weight: 500;
    margin-bottom: 0.35rem;
  }

  .stats-value {
    font-size: 1.35rem;
    font-weight: 700;
    color: #041C54;
    line-height: 1.2;
    word-break: break-word;
  }

  .form-label-sys {
    font-weight: 600;
    color: #041C54;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
  }

  .content-card .form-control,
  .content-card .form-select {
    border: 2px solid #e4e6eb;
    border-radius: 10px;
    padding: 0.65rem 1rem;
    transition: all 0.2s ease;
  }

  .content-card .form-control:focus,
  .content-card .form-select:focus {
    border-color: #647494;
    box-shadow: 0 0 0 4px rgba(100, 116, 148, 0.12);
  }

  .form-hint {
    font-size: 0.8rem;
    color: #7484A4;
    margin-top: 0.35rem;
  }

  .alert-modern {
    border-radius: 12px;
    border: none;
    padding: 16px 20px;
  }

  .alert-modern.alert-success {
    background: linear-gradient(135deg, rgba(40, 199, 111, 0.1) 0%, rgba(40, 199, 111, 0.05) 100%);
    border-left: 4px solid #28c76f;
  }

  .form-actions {
    display: flex;
    justify-content: flex-end;
    flex-wrap: wrap;
    gap: 12px;
    padding-top: 0.5rem;
  }

  .btn-sys-save {
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    border: none;
    color: white;
    padding: 12px 28px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(4, 28, 84, 0.2);
  }

  .btn-sys-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(4, 28, 84, 0.28);
    color: white;
  }

  @media (max-width: 768px) {
    .dashboard-header {
      padding: 1.5rem;
    }
  }
</style>
@endsection

@section('content')
<div class="system-settings-page">
<div class="dashboard-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="d-flex align-items-center gap-3">
      <div class="header-icon">
        <i class="ri-server-line"></i>
      </div>
      <div>
        <h4 class="mb-1">System settings</h4>
        <p class="mb-0">Application, mail, session, and infrastructure options</p>
      </div>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ route('admin.settings.general') }}" class="btn btn-header">
        <i class="ri-global-line me-1"></i> General
      </a>
      <a href="{{ route('admin.settings.roles') }}" class="btn btn-header">
        <i class="ri-shield-user-line me-1"></i> Roles
      </a>
    </div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-modern alert-success alert-dismissible mb-4" role="alert">
    <i class="ri-checkbox-circle-line me-2 text-success"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<form action="{{ route('admin.settings.system.update') }}" method="POST">
  @csrf

  <div class="row g-4 mb-4">
    <div class="col-lg-6">
      <div class="card content-card mb-0">
        <div class="card-header">
          <h5><i class="ri-apps-2-line me-2" style="color: #647494;"></i>Application</h5>
          <small>Core app identity and locale</small>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label for="app_name" class="form-label-sys">Application name</label>
            <input type="text" class="form-control" id="app_name" name="app_name"
                   value="{{ config('app.name') }}" placeholder="Therapist Platform">
          </div>
          <div class="mb-3">
            <label for="app_url" class="form-label-sys">Application URL</label>
            <input type="url" class="form-control" id="app_url" name="app_url"
                   value="{{ config('app.url') }}" placeholder="https://your-domain.com">
          </div>
          <div class="mb-0">
            <label for="app_timezone" class="form-label-sys">Timezone</label>
            <select class="form-select" id="app_timezone" name="app_timezone">
              <option value="UTC" {{ config('app.timezone') === 'UTC' ? 'selected' : '' }}>UTC</option>
              <option value="America/New_York" {{ config('app.timezone') === 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
              <option value="America/Chicago" {{ config('app.timezone') === 'America/Chicago' ? 'selected' : '' }}>Central Time</option>
              <option value="America/Denver" {{ config('app.timezone') === 'America/Denver' ? 'selected' : '' }}>Mountain Time</option>
              <option value="America/Los_Angeles" {{ config('app.timezone') === 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card content-card mb-0">
        <div class="card-header">
          <h5><i class="ri-mail-line me-2" style="color: #647494;"></i>Email</h5>
          <small>Outbound mail identity</small>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label for="mail_from_address" class="form-label-sys">From email address</label>
            <input type="email" class="form-control" id="mail_from_address" name="mail_from_address"
                   value="{{ config('mail.from.address') }}" placeholder="noreply@your-domain.com">
          </div>
          <div class="mb-0">
            <label for="mail_from_name" class="form-label-sys">From name</label>
            <input type="text" class="form-control" id="mail_from_name" name="mail_from_name"
                   value="{{ config('mail.from.name') }}" placeholder="Therapist Platform">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-lg-6">
      <div class="card content-card mb-0">
        <div class="card-header">
          <h5><i class="ri-time-line me-2" style="color: #647494;"></i>Session</h5>
          <small>Cookie and lifetime behavior</small>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label for="session_lifetime" class="form-label-sys">Session lifetime (minutes)</label>
            <input type="number" class="form-control" id="session_lifetime" name="session_lifetime"
                   value="{{ config('session.lifetime') }}" min="1" max="525600">
            <div class="form-hint">Max 525600 (one year).</div>
          </div>
          <div class="mb-0">
            <label for="session_secure" class="form-label-sys">Secure cookies</label>
            <select class="form-select" id="session_secure" name="session_secure">
              <option value="0" {{ !config('session.secure') ? 'selected' : '' }}>Disabled</option>
              <option value="1" {{ config('session.secure') ? 'selected' : '' }}>Enabled</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card content-card mb-0">
        <div class="card-header">
          <h5><i class="ri-database-2-line me-2" style="color: #647494;"></i>Cache &amp; queue</h5>
          <small>Backend drivers</small>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label for="cache_driver" class="form-label-sys">Cache driver</label>
            <select class="form-select" id="cache_driver" name="cache_driver">
              <option value="file" {{ config('cache.default') === 'file' ? 'selected' : '' }}>File</option>
              <option value="redis" {{ config('cache.default') === 'redis' ? 'selected' : '' }}>Redis</option>
              <option value="memcached" {{ config('cache.default') === 'memcached' ? 'selected' : '' }}>Memcached</option>
            </select>
          </div>
          <div class="mb-0">
            <label for="queue_driver" class="form-label-sys">Queue driver</label>
            <select class="form-select" id="queue_driver" name="queue_driver">
              <option value="sync" {{ config('queue.default') === 'sync' ? 'selected' : '' }}>Synchronous</option>
              <option value="database" {{ config('queue.default') === 'database' ? 'selected' : '' }}>Database</option>
              <option value="redis" {{ config('queue.default') === 'redis' ? 'selected' : '' }}>Redis</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card content-card">
    <div class="card-header">
      <h5><i class="ri-information-line me-2" style="color: #647494;"></i>System information</h5>
      <small>Read-only runtime details</small>
    </div>
    <div class="card-body">
      <div class="row g-4">
        <div class="col-md-3 col-sm-6">
          <div class="card stats-card mb-0">
            <div class="card-body text-center py-4">
              <div class="stats-label">Laravel version</div>
              <div class="stats-value">{{ app()->version() }}</div>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="card stats-card mb-0">
            <div class="card-body text-center py-4">
              <div class="stats-label">PHP version</div>
              <div class="stats-value">{{ PHP_VERSION }}</div>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="card stats-card mb-0">
            <div class="card-body text-center py-4">
              <div class="stats-label">Environment</div>
              <div class="stats-value">{{ config('app.env') }}</div>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="card stats-card mb-0">
            <div class="card-body text-center py-4">
              <div class="stats-label">Debug mode</div>
              <div class="stats-value">{{ config('app.debug') ? 'On' : 'Off' }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-sys-save">
      <i class="ri-save-line me-2"></i>Save settings
    </button>
  </div>
</form>
</div>
@endsection
