@extends('layouts.app')

@section('title', 'Create Account - Start Your Wellness Journey')

@section('head')
<style>
  /* === Register Page Custom Styles === */
  .register-page {
    min-height: 100vh;
    display: flex;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
  }

  .register-page::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -25%;
    width: 80%;
    height: 150%;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
  }

  .register-page::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -20%;
    width: 60%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
  }

  /* Left Side - Branding */
  .register-branding {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 4rem;
    color: white;
    position: relative;
    z-index: 1;
  }

  .register-branding-content {
    max-width: 480px;
  }

  .brand-logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 3rem;
  }

  .brand-logo-icon {
    width: 56px;
    height: 56px;
    background: rgba(255,255,255,0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
  }

  .brand-logo-icon svg {
    width: 32px;
    height: 32px;
    color: white;
  }

  .brand-logo-text {
    font-size: 1.75rem;
    font-weight: 700;
    letter-spacing: -0.02em;
  }

  .brand-headline {
    font-size: 2.75rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    letter-spacing: -0.03em;
  }

  .brand-tagline {
    font-size: 1.125rem;
    opacity: 0.9;
    line-height: 1.7;
    margin-bottom: 3rem;
  }

  .brand-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
  }

  .stat-item {
    text-align: center;
    padding: 1.25rem;
    background: rgba(255,255,255,0.1);
    border-radius: 16px;
    backdrop-filter: blur(10px);
  }

  .stat-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
  }

  .stat-label {
    font-size: 0.8125rem;
    opacity: 0.8;
  }

  /* Right Side - Form */
  .register-form-wrapper {
    width: 560px;
    min-height: 100vh;
    background: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 2.5rem 3.5rem;
    position: relative;
    z-index: 1;
    box-shadow: -20px 0 60px rgba(0,0,0,0.15);
    overflow-y: auto;
  }

  .register-form-header {
    margin-bottom: 2rem;
  }

  .register-form-header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
  }

  .register-form-header p {
    color: #6b7280;
    font-size: 0.9375rem;
  }

  .register-form-header p a {
    color: #7c3aed;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s ease;
  }

  .register-form-header p a:hover {
    color: #6d28d9;
    text-decoration: underline;
  }

  /* Form Styles */
  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
  }

  .form-group {
    margin-bottom: 1.25rem;
  }

  .form-label {
    display: block;
    font-weight: 600;
    font-size: 0.8125rem;
    color: #374151;
    margin-bottom: 0.375rem;
    text-transform: uppercase;
    letter-spacing: 0.02em;
  }

  .form-input-wrapper {
    position: relative;
  }

  .form-input-icon {
    position: absolute;
    left: 0.875rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    pointer-events: none;
    transition: color 0.2s ease;
  }

  .form-input,
  .form-select {
    width: 100%;
    padding: 0.75rem 0.875rem 0.75rem 2.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: all 0.2s ease;
    background: #f9fafb;
  }

  .form-input:focus,
  .form-select:focus {
    outline: none;
    border-color: #7c3aed;
    background: white;
    box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
  }

  .form-input:focus + .form-input-icon,
  .form-input-wrapper:focus-within .form-input-icon {
    color: #7c3aed;
  }

  .form-input.error,
  .form-select.error {
    border-color: #ef4444;
    background: #fef2f2;
  }

  .form-error {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    margin-top: 0.375rem;
    font-size: 0.75rem;
    color: #dc2626;
  }

  /* Role Selection */
  .role-selection {
    margin-bottom: 1.5rem;
  }

  .role-selection .form-label {
    margin-bottom: 0.75rem;
  }

  .role-options {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
  }

  .role-option {
    position: relative;
  }

  .role-option input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
  }

  .role-option label {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: #f9fafb;
  }

  .role-option label:hover {
    border-color: #d1d5db;
    background: white;
  }

  .role-option input:checked + label {
    border-color: #7c3aed;
    background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
    box-shadow: 0 4px 12px rgba(124, 58, 237, 0.15);
  }

  .role-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.5rem;
    transition: all 0.2s ease;
  }

  .role-option:nth-child(1) .role-icon { background: rgba(59, 130, 246, 0.15); color: #2563eb; }
  .role-option:nth-child(2) .role-icon { background: rgba(16, 185, 129, 0.15); color: #059669; }
  .role-option:nth-child(3) .role-icon { background: rgba(245, 158, 11, 0.15); color: #d97706; }

  .role-option input:checked + label .role-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
  }

  .role-name {
    font-weight: 600;
    font-size: 0.8125rem;
    color: #374151;
  }

  /* Terms Checkbox */
  .terms-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
  }

  .terms-checkbox input[type="checkbox"] {
    width: 20px;
    height: 20px;
    border: 2px solid #d1d5db;
    border-radius: 5px;
    cursor: pointer;
    accent-color: #7c3aed;
    flex-shrink: 0;
    margin-top: 2px;
  }

  .terms-checkbox label {
    font-size: 0.875rem;
    color: #4b5563;
    line-height: 1.5;
    cursor: pointer;
  }

  .terms-checkbox label a {
    color: #7c3aed;
    font-weight: 500;
    text-decoration: none;
  }

  .terms-checkbox label a:hover {
    text-decoration: underline;
  }

  /* Submit Button */
  .submit-btn {
    width: 100%;
    padding: 0.875rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.35);
  }

  .submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.45);
  }

  .submit-btn:active {
    transform: translateY(0);
  }

  /* Divider */
  .divider {
    display: flex;
    align-items: center;
    margin: 1.5rem 0;
    gap: 1rem;
  }

  .divider::before,
  .divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e5e7eb;
  }

  .divider span {
    font-size: 0.8125rem;
    color: #9ca3af;
    font-weight: 500;
  }

  /* Social Login */
  .social-login {
    display: flex;
    gap: 1rem;
  }

  .social-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    background: white;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
  }

  .social-btn:hover {
    border-color: #d1d5db;
    background: #f9fafb;
  }

  .social-btn svg {
    width: 18px;
    height: 18px;
  }

  /* Password Strength */
  .password-strength {
    margin-top: 0.5rem;
  }

  .strength-bar {
    height: 4px;
    background: #e5e7eb;
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 0.375rem;
  }

  .strength-fill {
    height: 100%;
    transition: all 0.3s ease;
    border-radius: 2px;
  }

  .strength-text {
    font-size: 0.75rem;
    font-weight: 500;
  }

  /* Responsive */
  @media (max-width: 1024px) {
    .register-branding {
      display: none;
    }

    .register-form-wrapper {
      width: 100%;
      max-width: 520px;
      margin: 0 auto;
      box-shadow: none;
      padding: 2rem;
    }

    .register-page {
      align-items: center;
      justify-content: center;
    }
  }

  @media (max-width: 576px) {
    .register-form-wrapper {
      padding: 1.5rem;
    }

    .form-row {
      grid-template-columns: 1fr;
    }

    .role-options {
      grid-template-columns: 1fr;
    }

    .social-login {
      flex-direction: column;
    }
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

  .delay-1 { animation-delay: 0.1s; opacity: 0; }
  .delay-2 { animation-delay: 0.2s; opacity: 0; }
  .delay-3 { animation-delay: 0.3s; opacity: 0; }
</style>
@endsection

@section('content')
<div class="register-page">
  <!-- Left Side - Branding -->
  <div class="register-branding">
    <div class="register-branding-content">
      <div class="brand-logo animate-fade-in">
        <img src="{{ asset('logo.png') }}" alt="Apani Psychology" style="height: 80px; width: auto; max-width: 400px; background: transparent !important; object-fit: contain;">
      </div>

      <h1 class="brand-headline animate-fade-in delay-1">
        Join Thousands on Their Healing Journey
      </h1>

      <p class="brand-tagline animate-fade-in delay-2">
        Whether you're seeking support or want to offer your expertise as a therapist, we welcome you to our community. Together, we can make mental health care accessible to everyone.
      </p>

      <div class="brand-stats animate-fade-in delay-3">
        <div class="stat-item">
          <div class="stat-number">10K+</div>
          <div class="stat-label">Happy Clients</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">500+</div>
          <div class="stat-label">Therapists</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">50K+</div>
          <div class="stat-label">Sessions</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Right Side - Registration Form -->
  <div class="register-form-wrapper">
    <div class="register-form-header animate-fade-in">
      <h1>Create your account ✨</h1>
      <p>Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="animate-fade-in delay-1">
      @csrf

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="name">Full Name</label>
          <div class="form-input-wrapper">
            <input
              id="name"
              name="name"
              type="text"
              autocomplete="name"
              required
              value="{{ old('name') }}"
              class="form-input @error('name') error @enderror"
              placeholder="John Doe"
            >
            <svg class="form-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </div>
          @error('name')
            <div class="form-error">
              <svg fill="currentColor" viewBox="0 0 20 20" width="14" height="14">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="phone">Phone (Optional)</label>
          <div class="form-input-wrapper">
            <input
              id="phone"
              name="phone"
              type="tel"
              autocomplete="tel"
              value="{{ old('phone') }}"
              class="form-input @error('phone') error @enderror"
              placeholder="+91 98765 43210"
            >
            <svg class="form-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
          </div>
          @error('phone')
            <div class="form-error">
              <svg fill="currentColor" viewBox="0 0 20 20" width="14" height="14">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="email">Email Address</label>
        <div class="form-input-wrapper">
          <input
            id="email"
            name="email"
            type="email"
            autocomplete="email"
            required
            value="{{ old('email') }}"
            class="form-input @error('email') error @enderror"
            placeholder="john@example.com"
          >
          <svg class="form-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
          </svg>
        </div>
        @error('email')
          <div class="form-error">
            <svg fill="currentColor" viewBox="0 0 20 20" width="14" height="14">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="role-selection">
        <label class="form-label">I want to join as</label>
        <div class="role-options">
          <div class="role-option">
            <input type="radio" name="role" id="role-client" value="client" {{ old('role') == 'client' ? 'checked' : '' }} required>
            <label for="role-client">
              <div class="role-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="22" height="22">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
              </div>
              <span class="role-name">Client</span>
            </label>
          </div>
          <div class="role-option">
            <input type="radio" name="role" id="role-therapist" value="therapist" {{ old('role') == 'therapist' ? 'checked' : '' }}>
            <label for="role-therapist">
              <div class="role-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="22" height="22">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
              </div>
              <span class="role-name">Therapist</span>
            </label>
          </div>
          <div class="role-option">
            <input type="radio" name="role" id="role-corporate" value="corporate_admin" {{ old('role') == 'corporate_admin' ? 'checked' : '' }}>
            <label for="role-corporate">
              <div class="role-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="22" height="22">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
              </div>
              <span class="role-name">Corporate</span>
            </label>
          </div>
        </div>
        @error('role')
          <div class="form-error" style="margin-top: 0.5rem;">
            <svg fill="currentColor" viewBox="0 0 20 20" width="14" height="14">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <div class="form-input-wrapper">
            <input
              id="password"
              name="password"
              type="password"
              autocomplete="new-password"
              required
              class="form-input @error('password') error @enderror"
              placeholder="Create password"
              onkeyup="checkPasswordStrength(this.value)"
            >
            <svg class="form-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
          </div>
          <div class="password-strength" id="password-strength" style="display: none;">
            <div class="strength-bar">
              <div class="strength-fill" id="strength-fill"></div>
            </div>
            <div class="strength-text" id="strength-text"></div>
          </div>
          @error('password')
            <div class="form-error">
              <svg fill="currentColor" viewBox="0 0 20 20" width="14" height="14">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="password_confirmation">Confirm Password</label>
          <div class="form-input-wrapper">
            <input
              id="password_confirmation"
              name="password_confirmation"
              type="password"
              autocomplete="new-password"
              required
              class="form-input"
              placeholder="Confirm password"
            >
            <svg class="form-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
          </div>
        </div>
      </div>

      <div class="terms-checkbox">
        <input type="checkbox" name="terms" id="terms" required>
        <label for="terms">
          I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>. I understand that my data will be handled as described in the privacy policy.
        </label>
      </div>

      <button type="submit" class="submit-btn">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
        </svg>
        Create My Account
      </button>
    </form>

    <div class="divider animate-fade-in delay-2">
      <span>or sign up with</span>
    </div>

    <div class="social-login animate-fade-in delay-2">
      <a href="#" class="social-btn">
        <svg viewBox="0 0 24 24">
          <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
          <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
          <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
          <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
        </svg>
        Google
      </a>
      <a href="#" class="social-btn">
        <svg fill="#1877F2" viewBox="0 0 24 24">
          <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
        </svg>
        Facebook
      </a>
    </div>
  </div>
</div>

<script>
function checkPasswordStrength(password) {
  const strengthDiv = document.getElementById('password-strength');
  const strengthFill = document.getElementById('strength-fill');
  const strengthText = document.getElementById('strength-text');

  if (password.length === 0) {
    strengthDiv.style.display = 'none';
    return;
  }

  strengthDiv.style.display = 'block';

  let strength = 0;
  let message = '';
  let color = '';

  if (password.length >= 8) strength++;
  if (password.match(/[a-z]/)) strength++;
  if (password.match(/[A-Z]/)) strength++;
  if (password.match(/[0-9]/)) strength++;
  if (password.match(/[^a-zA-Z0-9]/)) strength++;

  switch (strength) {
    case 0:
    case 1:
      message = 'Weak';
      color = '#ef4444';
      break;
    case 2:
      message = 'Fair';
      color = '#f59e0b';
      break;
    case 3:
      message = 'Good';
      color = '#22c55e';
      break;
    case 4:
    case 5:
      message = 'Strong';
      color = '#10b981';
      break;
  }

  strengthFill.style.width = (strength * 20) + '%';
  strengthFill.style.backgroundColor = color;
  strengthText.textContent = message;
  strengthText.style.color = color;
}
</script>
@endsection
