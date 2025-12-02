@extends('layouts/contentNavbarLayout')

@section('title', 'General Settings')

@section('page-style')
<style>
    :root {
        --theme-primary: #696cff;
        --theme-primary-dark: #5f61e6;
        --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .page-header {
        background: var(--theme-gradient);
        border-radius: 12px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        color: white;
    }
    
    .page-header h4 {
        margin: 0;
        font-weight: 600;
    }
    
    .page-header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
    }
    
    .btn-theme {
        background: var(--theme-gradient);
        border: none;
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-theme:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .btn-theme-outline {
        background: transparent;
        border: 2px solid rgba(255,255,255,0.5);
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-theme-outline:hover {
        background: rgba(255,255,255,0.15);
        border-color: white;
        color: white;
    }
    
    .card-modern {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
    
    .settings-section {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
        border: 1px solid rgba(102, 126, 234, 0.1);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        color: #667eea;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .section-title i {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .form-label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 0.5rem;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 0.65rem 1rem;
    }
    
    .alert-themed {
        border: none;
        border-radius: 10px;
        border-left: 4px solid;
    }
    
    .alert-themed.alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border-left-color: #28a745;
        color: #155724;
    }
    
    .alert-themed.alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        border-left-color: #dc3545;
        color: #721c24;
    }
    
    .form-helper {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 0.35rem;
    }
    
    .required-asterisk {
        color: #dc3545;
    }
    
    .btn-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.65rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .btn-cancel {
        background: transparent;
        border: 2px solid #e0e0e0;
        color: #6c757d;
        padding: 0.65rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: #f8f9fa;
        border-color: #c0c0c0;
        color: #495057;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4><i class="ri-settings-3-line me-2"></i>General Settings</h4>
            <p>Configure your platform's general settings</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.settings.roles') }}" class="btn btn-theme-outline">
                <i class="ri-shield-user-line me-1"></i> Roles Settings
            </a>
            <a href="{{ route('admin.settings.system') }}" class="btn btn-theme-outline">
                <i class="ri-settings-3-line me-1"></i> System Settings
            </a>
        </div>
    </div>
</div>

<div class="card card-modern">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-themed alert-success alert-dismissible" role="alert">
                <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-themed alert-danger alert-dismissible" role="alert">
                <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-themed alert-danger alert-dismissible" role="alert">
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
                    <!-- Site Information Section -->
                    <div class="settings-section">
                        <div class="section-title">
                            <i class="ri-global-line"></i>
                            <span>Site Information</span>
                        </div>

                        <div class="mb-3">
                            <label for="site_name" class="form-label">Site Name <span class="required-asterisk">*</span></label>
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

                        <div class="mb-0">
                            <label for="site_keywords" class="form-label">Site Keywords</label>
                            <input type="text" class="form-control @error('site_keywords') is-invalid @enderror" 
                                   id="site_keywords" name="site_keywords"
                                   value="{{ old('site_keywords') }}" 
                                   placeholder="therapy, counseling, mental health">
                            <div class="form-helper">Separate keywords with commas</div>
                            @error('site_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Legal Information Section -->
                    <div class="settings-section">
                        <div class="section-title">
                            <i class="ri-file-text-line"></i>
                            <span>Legal Information</span>
                        </div>

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

                        <div class="mb-0">
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
                    <!-- Contact Information Section -->
                    <div class="settings-section">
                        <div class="section-title">
                            <i class="ri-contacts-line"></i>
                            <span>Contact Information</span>
                        </div>

                        <div class="mb-3">
                            <label for="contact_email" class="form-label">Contact Email <span class="required-asterisk">*</span></label>
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

                        <div class="mb-0">
                            <label for="contact_address" class="form-label">Contact Address</label>
                            <textarea class="form-control @error('contact_address') is-invalid @enderror" 
                                      id="contact_address" name="contact_address" 
                                      rows="3" placeholder="Street address, City, State, ZIP">{{ old('contact_address') }}</textarea>
                            @error('contact_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Social Media Section -->
                    <div class="settings-section">
                        <div class="section-title">
                            <i class="ri-share-line"></i>
                            <span>Social Media</span>
                        </div>

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

                        <div class="mb-0">
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

            <!-- Platform Settings Section -->
            <div class="settings-section">
                <div class="section-title">
                    <i class="ri-settings-2-line"></i>
                    <span>Platform Settings</span>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3 mb-md-0">
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
                        <div class="mb-3 mb-md-0">
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
                        <div class="mb-0">
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

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-cancel">
                    <i class="ri-close-line me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-save">
                    <i class="ri-save-line me-2"></i>Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
