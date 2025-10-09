@extends('layouts/contentNavbarLayout')

@section('title', 'System Settings')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">System Settings</h5>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form action="{{ route('admin.settings.system.update') }}" method="POST">
          @csrf

          <div class="row">
            <div class="col-md-6">
              <div class="mb-4">
                <h6 class="text-muted mb-3">Application Settings</h6>

                <div class="mb-3">
                  <label for="app_name" class="form-label">Application Name</label>
                  <input type="text" class="form-control" id="app_name" name="app_name"
                         value="{{ config('app.name') }}" placeholder="Therapist Platform">
                </div>

                <div class="mb-3">
                  <label for="app_url" class="form-label">Application URL</label>
                  <input type="url" class="form-control" id="app_url" name="app_url"
                         value="{{ config('app.url') }}" placeholder="https://your-domain.com">
                </div>

                <div class="mb-3">
                  <label for="app_timezone" class="form-label">Timezone</label>
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

            <div class="col-md-6">
              <div class="mb-4">
                <h6 class="text-muted mb-3">Email Settings</h6>

                <div class="mb-3">
                  <label for="mail_from_address" class="form-label">From Email Address</label>
                  <input type="email" class="form-control" id="mail_from_address" name="mail_from_address"
                         value="{{ config('mail.from.address') }}" placeholder="noreply@your-domain.com">
                </div>

                <div class="mb-3">
                  <label for="mail_from_name" class="form-label">From Name</label>
                  <input type="text" class="form-control" id="mail_from_name" name="mail_from_name"
                         value="{{ config('mail.from.name') }}" placeholder="Therapist Platform">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-4">
                <h6 class="text-muted mb-3">Session Settings</h6>

                <div class="mb-3">
                  <label for="session_lifetime" class="form-label">Session Lifetime (minutes)</label>
                  <input type="number" class="form-control" id="session_lifetime" name="session_lifetime"
                         value="{{ config('session.lifetime') }}" min="1" max="525600">
                </div>

                <div class="mb-3">
                  <label for="session_secure" class="form-label">Secure Cookies</label>
                  <select class="form-select" id="session_secure" name="session_secure">
                    <option value="0" {{ !config('session.secure') ? 'selected' : '' }}>Disabled</option>
                    <option value="1" {{ config('session.secure') ? 'selected' : '' }}>Enabled</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-4">
                <h6 class="text-muted mb-3">Cache Settings</h6>

                <div class="mb-3">
                  <label for="cache_driver" class="form-label">Cache Driver</label>
                  <select class="form-select" id="cache_driver" name="cache_driver">
                    <option value="file" {{ config('cache.default') === 'file' ? 'selected' : '' }}>File</option>
                    <option value="redis" {{ config('cache.default') === 'redis' ? 'selected' : '' }}>Redis</option>
                    <option value="memcached" {{ config('cache.default') === 'memcached' ? 'selected' : '' }}>Memcached</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="queue_driver" class="form-label">Queue Driver</label>
                  <select class="form-select" id="queue_driver" name="queue_driver">
                    <option value="sync" {{ config('queue.default') === 'sync' ? 'selected' : '' }}>Synchronous</option>
                    <option value="database" {{ config('queue.default') === 'database' ? 'selected' : '' }}>Database</option>
                    <option value="redis" {{ config('queue.default') === 'redis' ? 'selected' : '' }}>Redis</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="mb-4">
                <h6 class="text-muted mb-3">System Information</h6>
                <div class="row">
                  <div class="col-md-3">
                    <div class="card">
                      <div class="card-body text-center">
                        <h6 class="card-title">Laravel Version</h6>
                        <p class="card-text">{{ app()->version() }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card">
                      <div class="card-body text-center">
                        <h6 class="card-title">PHP Version</h6>
                        <p class="card-text">{{ PHP_VERSION }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card">
                      <div class="card-body text-center">
                        <h6 class="card-title">Environment</h6>
                        <p class="card-text">{{ config('app.env') }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card">
                      <div class="card-body text-center">
                        <h6 class="card-title">Debug Mode</h6>
                        <p class="card-text">{{ config('app.debug') ? 'Enabled' : 'Disabled' }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
              <i class="ri-save-line me-2"></i>Save Settings
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
