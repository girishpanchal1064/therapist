@extends('layouts/contentNavbarLayout')

@section('title', 'General Settings')

@section('page-style')
<style>
  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
  }
  .page-header h4 { margin: 0; font-weight: 700; color: white; font-size: 1.5rem; }
  .page-header p { color: rgba(255, 255, 255, 0.85); margin: 4px 0 0 0; }
  .page-header .btn-header {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .page-header .btn-header:hover { background: rgba(255, 255, 255, 0.3); color: white; }

  .settings-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 24px;
  }
  .settings-card .card-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    border-bottom: 1px solid #e9ecef;
    padding: 20px 24px;
  }
  .settings-card .card-body { padding: 24px; }

  .section-title {
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .section-title .icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  .section-title h5 { margin: 0; font-weight: 700; color: #2d3748; }
  .section-title small { color: #718096; font-size: 0.85rem; }

  .form-label-styled { font-weight: 600; color: #4a5568; margin-bottom: 8px; font-size: 0.9rem; display: block; }
  .form-control, .form-select {
    border: 2px solid #e4e6eb;
    border-radius: 10px;
    padding: 12px 16px;
    transition: all 0.3s ease;
  }
  .form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
  }
  .form-text { color: #8e9baa; font-size: 0.8rem; margin-top: 6px; }
  .required-asterisk { color: #ea5455; }

  /* Toggle Card */
  .toggle-card {
    background: #f8f9fc;
    border-radius: 12px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
  }
  .toggle-card:hover { border-color: rgba(102, 126, 234, 0.2); }
  .toggle-card:last-child { margin-bottom: 0; }
  .toggle-card .toggle-info h6 { margin: 0 0 4px; font-weight: 600; color: #2d3748; }
  .toggle-card .toggle-info small { color: #718096; }
  .toggle-card .form-check-input { width: 50px; height: 26px; }
  .toggle-card .form-check-input:checked { background-color: #667eea; border-color: #667eea; }

  /* Social Input */
  .social-input {
    position: relative;
  }
  .social-input i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.2rem;
    color: #8e9baa;
  }
  .social-input input { padding-left: 45px; }
  .social-input.facebook i { color: #1877f2; }
  .social-input.twitter i { color: #1da1f2; }
  .social-input.linkedin i { color: #0a66c2; }
  .social-input.instagram i { color: #e4405f; }

  /* Alert */
  .alert-modern {
    border-radius: 12px;
    border: none;
    padding: 16px 20px;
  }
  .alert-modern.alert-success {
    background: linear-gradient(135deg, rgba(40, 199, 111, 0.1) 0%, rgba(40, 199, 111, 0.05) 100%);
    border-left: 4px solid #28c76f;
  }
  .alert-modern.alert-danger {
    background: linear-gradient(135deg, rgba(234, 84, 85, 0.1) 0%, rgba(234, 84, 85, 0.05) 100%);
    border-left: 4px solid #ea5455;
  }

  .btn-cancel {
    background: white; border: 2px solid #e4e6eb; color: #566a7f;
    padding: 12px 24px; border-radius: 10px; font-weight: 600; transition: all 0.3s ease;
  }
  .btn-cancel:hover { border-color: #ea5455; color: #ea5455; }
  .btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none; color: white; padding: 12px 28px; border-radius: 10px;
    font-weight: 600; transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }
  .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4); color: white; }
</style>
@endsection

@section('content')
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h4><i class="ri-settings-3-line me-2"></i>General Settings</h4>
      <p>Configure your platform's core settings</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ route('admin.settings.roles') }}" class="btn btn-header">
        <i class="ri-shield-user-line me-1"></i> Roles
      </a>
      <a href="{{ route('admin.settings.system') }}" class="btn btn-header">
        <i class="ri-server-line me-1"></i> System
      </a>
    </div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-modern alert-success alert-dismissible mb-4">
    <i class="ri-checkbox-circle-line me-2 text-success"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-modern alert-danger alert-dismissible mb-4">
    <i class="ri-error-warning-line me-2 text-danger"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if($errors->any())
  <div class="alert alert-modern alert-danger mb-4">
    <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
  </div>
@endif

<form action="{{ route('admin.settings.general.update') }}" method="POST">
  @csrf
  <div class="row g-4">
    <!-- Left Column -->
    <div class="col-lg-6">
      <!-- Site Information -->
      <div class="card settings-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-global-line"></i></div>
            <div>
              <h5>Site Information</h5>
              <small>Basic site details and branding</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label-styled">Site Name <span class="required-asterisk">*</span></label>
            <input type="text" class="form-control" name="site_name" value="{{ old('site_name', config('app.name')) }}" placeholder="Therapist Platform" required>
          </div>
          <div class="mb-3">
            <label class="form-label-styled">Site Tagline</label>
            <input type="text" class="form-control" name="site_tagline" value="{{ old('site_tagline') }}" placeholder="Your trusted therapy platform">
          </div>
          <div class="mb-3">
            <label class="form-label-styled">Site Description</label>
            <textarea class="form-control" name="site_description" rows="3" placeholder="Brief description of your platform">{{ old('site_description') }}</textarea>
          </div>
          <div>
            <label class="form-label-styled">Site Keywords</label>
            <input type="text" class="form-control" name="site_keywords" value="{{ old('site_keywords') }}" placeholder="therapy, counseling, mental health">
            <div class="form-text">Comma-separated keywords for SEO</div>
          </div>
        </div>
      </div>

      <!-- Legal Information -->
      <div class="card settings-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-file-shield-2-line"></i></div>
            <div>
              <h5>Legal Information</h5>
              <small>Terms, privacy and legal pages</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label-styled">Terms & Conditions URL</label>
            <input type="url" class="form-control" name="terms_url" value="{{ old('terms_url') }}" placeholder="https://your-domain.com/terms">
          </div>
          <div>
            <label class="form-label-styled">Privacy Policy URL</label>
            <input type="url" class="form-control" name="privacy_url" value="{{ old('privacy_url') }}" placeholder="https://your-domain.com/privacy">
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-6">
      <!-- Contact Information -->
      <div class="card settings-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-contacts-book-line"></i></div>
            <div>
              <h5>Contact Information</h5>
              <small>How users can reach you</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label-styled">Contact Email <span class="required-asterisk">*</span></label>
            <input type="email" class="form-control" name="contact_email" value="{{ old('contact_email') }}" placeholder="contact@your-domain.com" required>
          </div>
          <div class="mb-3">
            <label class="form-label-styled">Contact Phone</label>
            <input type="tel" class="form-control" name="contact_phone" value="{{ old('contact_phone') }}" placeholder="+91 98765 43210">
          </div>
          <div>
            <label class="form-label-styled">Contact Address</label>
            <textarea class="form-control" name="contact_address" rows="2" placeholder="Street, City, State, ZIP">{{ old('contact_address') }}</textarea>
          </div>
        </div>
      </div>

      <!-- Social Media -->
      <div class="card settings-card">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-share-line"></i></div>
            <div>
              <h5>Social Media</h5>
              <small>Connect your social profiles</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label-styled">Facebook</label>
            <div class="social-input facebook">
              <i class="ri-facebook-circle-fill"></i>
              <input type="url" class="form-control" name="facebook_url" value="{{ old('facebook_url') }}" placeholder="https://facebook.com/yourpage">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label-styled">Twitter</label>
            <div class="social-input twitter">
              <i class="ri-twitter-x-fill"></i>
              <input type="url" class="form-control" name="twitter_url" value="{{ old('twitter_url') }}" placeholder="https://twitter.com/yourhandle">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label-styled">LinkedIn</label>
            <div class="social-input linkedin">
              <i class="ri-linkedin-box-fill"></i>
              <input type="url" class="form-control" name="linkedin_url" value="{{ old('linkedin_url') }}" placeholder="https://linkedin.com/company/yourcompany">
            </div>
          </div>
          <div>
            <label class="form-label-styled">Instagram</label>
            <div class="social-input instagram">
              <i class="ri-instagram-fill"></i>
              <input type="url" class="form-control" name="instagram_url" value="{{ old('instagram_url') }}" placeholder="https://instagram.com/yourhandle">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Full Width - Platform Settings -->
    <div class="col-12">
      <div class="card settings-card mb-0">
        <div class="card-header">
          <div class="section-title">
            <div class="icon"><i class="ri-settings-2-line"></i></div>
            <div>
              <h5>Platform Settings</h5>
              <small>System-wide configuration options</small>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-4 mb-4">
            <div class="col-md-4">
              <div class="toggle-card">
                <div class="toggle-info">
                  <h6><i class="ri-tools-line me-2 text-warning"></i>Maintenance Mode</h6>
                  <small>Take site offline for maintenance</small>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1" {{ old('maintenance_mode') == '1' ? 'checked' : '' }}>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="toggle-card">
                <div class="toggle-info">
                  <h6><i class="ri-user-add-line me-2 text-success"></i>User Registration</h6>
                  <small>Allow new user sign-ups</small>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="registration_enabled" value="1" {{ old('registration_enabled', '1') == '1' ? 'checked' : '' }}>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <label class="form-label-styled">Default Timezone</label>
              <select class="form-select" name="default_timezone">
                <option value="UTC" {{ old('default_timezone', config('app.timezone')) === 'UTC' ? 'selected' : '' }}>UTC</option>
                <option value="Asia/Kolkata" {{ old('default_timezone', config('app.timezone')) === 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata (IST)</option>
                <option value="America/New_York" {{ old('default_timezone', config('app.timezone')) === 'America/New_York' ? 'selected' : '' }}>America/New_York (EST)</option>
                <option value="America/Chicago" {{ old('default_timezone', config('app.timezone')) === 'America/Chicago' ? 'selected' : '' }}>America/Chicago (CST)</option>
                <option value="America/Los_Angeles" {{ old('default_timezone', config('app.timezone')) === 'America/Los_Angeles' ? 'selected' : '' }}>America/Los_Angeles (PST)</option>
                <option value="Europe/London" {{ old('default_timezone', config('app.timezone')) === 'Europe/London' ? 'selected' : '' }}>Europe/London (GMT)</option>
              </select>
            </div>
          </div>
          <div class="row g-4">
            <div class="col-md-6">
              <div class="commission-setting-card">
                <div class="d-flex align-items-center mb-3">
                  <div class="icon-wrapper me-3" style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                    <i class="ri-percent-line"></i>
                  </div>
                  <div>
                    <h6 class="mb-0">Therapist Commission Percentage</h6>
                    <small class="text-muted">Set the percentage therapists receive from payments</small>
                  </div>
                </div>
                <div class="input-group">
                  <input type="number" class="form-control" name="therapist_commission_percentage" 
                         value="{{ old('therapist_commission_percentage', \App\Models\Setting::getCommissionPercentage()) }}" 
                         min="0" max="100" step="0.1" required>
                  <span class="input-group-text">%</span>
                </div>
                <small class="text-muted mt-2 d-block">
                  <i class="ri-information-line me-1"></i>
                  Current setting: Therapist gets <strong>{{ \App\Models\Setting::getCommissionPercentage() }}%</strong>, Platform keeps <strong>{{ 100 - \App\Models\Setting::getCommissionPercentage() }}%</strong>
                </small>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center pt-4 border-top">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-cancel"><i class="ri-close-line me-1"></i> Cancel</a>
            <button type="submit" class="btn btn-submit"><i class="ri-save-line me-1"></i> Save Settings</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
