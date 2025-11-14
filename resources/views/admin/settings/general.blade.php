@extends('layouts/contentNavbarLayout')

@section('title', 'General Settings')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">General Settings</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.settings.roles') }}" class="btn btn-outline-primary">
            <i class="ri-shield-user-line me-1"></i> Roles Settings
          </a>
          <a href="{{ route('admin.settings.system') }}" class="btn btn-outline-info">
            <i class="ri-settings-3-line me-1"></i> System Settings
          </a>
        </div>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible" role="alert">
            <i class="ri-error-warning-line me-2"></i>
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form action="{{ route('admin.settings.general.update') }}" method="POST">
          @csrf

          <div class="row">
            <div class="col-md-6">
              <div class="mb-4">
                <h6 class="text-muted mb-3">
                  <i class="ri-global-line me-2"></i>Site Information
                </h6>

                <div class="mb-3">
                  <label for="site_name" class="form-label">Site Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                         id="site_name" name="site_name"
                         value="{{ old('site_name', config('app.name')) }}" 
                         placeholder="Therapist Platform" required>
                  @error('site_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="site_tagline" class="form-label">Site Tagline</label>
                  <input type="text" class="form-control @error('site_tagline') is-invalid @enderror" 
                         id="site_tagline" name="site_tagline"
                         value="{{ old('site_tagline') }}" 
                         placeholder="Your trusted therapy platform">
                  @error('site_tagline')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="site_description" class="form-label">Site Description</label>
                  <textarea class="form-control @error('site_description') is-invalid @enderror" 
                            id="site_description" name="site_description" 
                            rows="3" placeholder="Brief description of your platform">{{ old('site_description') }}</textarea>
                  @error('site_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="site_keywords" class="form-label">Site Keywords</label>
                  <input type="text" class="form-control @error('site_keywords') is-invalid @enderror" 
                         id="site_keywords" name="site_keywords"
                         value="{{ old('site_keywords') }}" 
                         placeholder="therapy, counseling, mental health">
                  <small class="text-muted">Separate keywords with commas</small>
                  @error('site_keywords')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-4">
                <h6 class="text-muted mb-3">
                  <i class="ri-contacts-line me-2"></i>Contact Information
                </h6>

                <div class="mb-3">
                  <label for="contact_email" class="form-label">Contact Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                         id="contact_email" name="contact_email"
                         value="{{ old('contact_email') }}" 
                         placeholder="contact@your-domain.com" required>
                  @error('contact_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="contact_phone" class="form-label">Contact Phone</label>
                  <input type="tel" class="form-control @error('contact_phone') is-invalid @enderror" 
                         id="contact_phone" name="contact_phone"
                         value="{{ old('contact_phone') }}" 
                         placeholder="+1 (555) 123-4567">
                  @error('contact_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="contact_address" class="form-label">Contact Address</label>
                  <textarea class="form-control @error('contact_address') is-invalid @enderror" 
                            id="contact_address" name="contact_address" 
                            rows="3" placeholder="Street address, City, State, ZIP">{{ old('contact_address') }}</textarea>
                  @error('contact_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-4">
                <h6 class="text-muted mb-3">
                  <i class="ri-file-text-line me-2"></i>Legal Information
                </h6>

                <div class="mb-3">
                  <label for="terms_url" class="form-label">Terms & Conditions URL</label>
                  <input type="url" class="form-control @error('terms_url') is-invalid @enderror" 
                         id="terms_url" name="terms_url"
                         value="{{ old('terms_url') }}" 
                         placeholder="https://your-domain.com/terms">
                  @error('terms_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="privacy_url" class="form-label">Privacy Policy URL</label>
                  <input type="url" class="form-control @error('privacy_url') is-invalid @enderror" 
                         id="privacy_url" name="privacy_url"
                         value="{{ old('privacy_url') }}" 
                         placeholder="https://your-domain.com/privacy">
                  @error('privacy_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-4">
                <h6 class="text-muted mb-3">
                  <i class="ri-share-line me-2"></i>Social Media
                </h6>

                <div class="mb-3">
                  <label for="facebook_url" class="form-label">Facebook URL</label>
                  <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" 
                         id="facebook_url" name="facebook_url"
                         value="{{ old('facebook_url') }}" 
                         placeholder="https://facebook.com/yourpage">
                  @error('facebook_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="twitter_url" class="form-label">Twitter URL</label>
                  <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" 
                         id="twitter_url" name="twitter_url"
                         value="{{ old('twitter_url') }}" 
                         placeholder="https://twitter.com/yourhandle">
                  @error('twitter_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                  <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror" 
                         id="linkedin_url" name="linkedin_url"
                         value="{{ old('linkedin_url') }}" 
                         placeholder="https://linkedin.com/company/yourcompany">
                  @error('linkedin_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="instagram_url" class="form-label">Instagram URL</label>
                  <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" 
                         id="instagram_url" name="instagram_url"
                         value="{{ old('instagram_url') }}" 
                         placeholder="https://instagram.com/yourhandle">
                  @error('instagram_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="mb-4">
                <h6 class="text-muted mb-3">
                  <i class="ri-settings-2-line me-2"></i>Platform Settings
                </h6>
                <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="maintenance_mode" class="form-label">Maintenance Mode</label>
                      <select class="form-select @error('maintenance_mode') is-invalid @enderror" 
                              id="maintenance_mode" name="maintenance_mode">
                        <option value="0" {{ old('maintenance_mode', '0') == '0' ? 'selected' : '' }}>Disabled</option>
                        <option value="1" {{ old('maintenance_mode') == '1' ? 'selected' : '' }}>Enabled</option>
                      </select>
                      @error('maintenance_mode')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="registration_enabled" class="form-label">User Registration</label>
                      <select class="form-select @error('registration_enabled') is-invalid @enderror" 
                              id="registration_enabled" name="registration_enabled">
                        <option value="1" {{ old('registration_enabled', '1') == '1' ? 'selected' : '' }}>Enabled</option>
                        <option value="0" {{ old('registration_enabled') == '0' ? 'selected' : '' }}>Disabled</option>
                      </select>
                      @error('registration_enabled')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="default_timezone" class="form-label">Default Timezone</label>
                      <select class="form-select @error('default_timezone') is-invalid @enderror" 
                              id="default_timezone" name="default_timezone">
                        <option value="UTC" {{ old('default_timezone', config('app.timezone')) === 'UTC' ? 'selected' : '' }}>UTC</option>
                        <option value="Asia/Kolkata" {{ old('default_timezone', config('app.timezone')) === 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata (IST)</option>
                        <option value="America/New_York" {{ old('default_timezone', config('app.timezone')) === 'America/New_York' ? 'selected' : '' }}>America/New_York (EST)</option>
                        <option value="America/Chicago" {{ old('default_timezone', config('app.timezone')) === 'America/Chicago' ? 'selected' : '' }}>America/Chicago (CST)</option>
                        <option value="America/Los_Angeles" {{ old('default_timezone', config('app.timezone')) === 'America/Los_Angeles' ? 'selected' : '' }}>America/Los_Angeles (PST)</option>
                      </select>
                      @error('default_timezone')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
              <i class="ri-close-line me-2"></i>Cancel
            </a>
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
