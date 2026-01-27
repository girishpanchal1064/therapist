@extends('layouts.app')

@section('title', 'Sign In - Your Wellness Journey')

@section('head')
<style>
  /* === Login Page Custom Styles === */
  .login-page {
    min-height: 100vh;
    display: flex;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
  }

  .login-page::before {
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

  .login-page::after {
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
  .login-branding {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 4rem;
    color: white;
    position: relative;
    z-index: 1;
  }

  .login-branding-content {
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
    font-size: 3rem;
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

  .brand-features {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .brand-feature {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
  }

  .brand-feature:hover {
    background: rgba(255,255,255,0.15);
    transform: translateX(5px);
  }

  .brand-feature-icon {
    width: 44px;
    height: 44px;
    background: rgba(255,255,255,0.2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .brand-feature-icon svg {
    width: 24px;
    height: 24px;
  }

  .brand-feature-text h4 {
    font-weight: 600;
    font-size: 0.9375rem;
    margin-bottom: 0.25rem;
  }

  .brand-feature-text p {
    font-size: 0.8125rem;
    opacity: 0.8;
    margin: 0;
  }

  /* Right Side - Form */
  .login-form-wrapper {
    width: 520px;
    min-height: 100vh;
    background: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 3rem 4rem;
    position: relative;
    z-index: 1;
    box-shadow: -20px 0 60px rgba(0,0,0,0.15);
  }

  .login-form-header {
    margin-bottom: 2.5rem;
  }

  .login-form-header h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.75rem;
    letter-spacing: -0.02em;
  }

  .login-form-header p {
    color: #6b7280;
    font-size: 1rem;
  }

  .login-form-header p a {
    color: #7c3aed;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s ease;
  }

  .login-form-header p a:hover {
    color: #6d28d9;
    text-decoration: underline;
  }

  /* Alerts */
  .login-alert {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
  }

  .login-alert.info {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border: 1px solid #93c5fd;
  }

  .login-alert.success {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 1px solid #86efac;
  }

  .login-alert-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .login-alert.info .login-alert-icon {
    background: rgba(59, 130, 246, 0.15);
    color: #2563eb;
  }

  .login-alert.success .login-alert-icon {
    background: rgba(16, 185, 129, 0.15);
    color: #059669;
  }

  .login-alert-content h4 {
    font-weight: 600;
    font-size: 0.9375rem;
    margin-bottom: 0.25rem;
  }

  .login-alert.info .login-alert-content h4 { color: #1e40af; }
  .login-alert.success .login-alert-content h4 { color: #166534; }

  .login-alert-content p {
    font-size: 0.875rem;
    margin: 0;
  }

  .login-alert.info .login-alert-content p { color: #3b82f6; }
  .login-alert.success .login-alert-content p { color: #16a34a; }

  /* Form Styles */
  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-label {
    display: block;
    font-weight: 600;
    font-size: 0.875rem;
    color: #374151;
    margin-bottom: 0.5rem;
  }

  .form-input-wrapper {
    position: relative;
  }

  .form-input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    pointer-events: none;
    transition: color 0.2s ease;
  }

  .form-input {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 3rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.2s ease;
    background: #f9fafb;
  }

  .form-input:focus {
    outline: none;
    border-color: #7c3aed;
    background: white;
    box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
  }

  .form-input:focus + .form-input-icon,
  .form-input-wrapper:focus-within .form-input-icon {
    color: #7c3aed;
  }

  .form-input.error {
    border-color: #ef4444;
    background: #fef2f2;
  }

  .form-error {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
    font-size: 0.8125rem;
    color: #dc2626;
  }

  /* Toggle Password */
  .toggle-password {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #9ca3af;
    cursor: pointer;
    padding: 0.25rem;
    transition: color 0.2s ease;
  }

  .toggle-password:hover {
    color: #6b7280;
  }

  /* Remember & Forgot */
  .form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
  }

  .remember-me {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    cursor: pointer;
  }

  .remember-me input[type="checkbox"] {
    width: 18px;
    height: 18px;
    border: 2px solid #d1d5db;
    border-radius: 5px;
    cursor: pointer;
    accent-color: #7c3aed;
  }

  .remember-me span {
    font-size: 0.9375rem;
    color: #4b5563;
  }

  .forgot-link {
    font-size: 0.9375rem;
    color: #7c3aed;
    font-weight: 500;
    text-decoration: none;
    transition: color 0.2s ease;
  }

  .forgot-link:hover {
    color: #6d28d9;
    text-decoration: underline;
  }

  /* Submit Button */
  .submit-btn {
    width: 100%;
    padding: 1rem;
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
    margin: 2rem 0;
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
    gap: 0.75rem;
    padding: 0.875rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    background: white;
    font-size: 0.9375rem;
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
    width: 20px;
    height: 20px;
  }

  /* Footer */
  .login-footer {
    margin-top: 2rem;
    text-align: center;
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
  }

  .login-footer p {
    font-size: 0.8125rem;
    color: #9ca3af;
  }

  .login-footer a {
    color: #7c3aed;
    text-decoration: none;
    font-weight: 500;
  }

  .login-footer a:hover {
    text-decoration: underline;
  }

  /* Responsive */
  @media (max-width: 1024px) {
    .login-branding {
      display: none;
    }

    .login-form-wrapper {
      width: 100%;
      max-width: 480px;
      margin: 0 auto;
      box-shadow: none;
      padding: 2rem;
    }

    .login-page {
      align-items: center;
      justify-content: center;
    }
  }

  @media (max-width: 480px) {
    .login-form-wrapper {
      padding: 1.5rem;
    }

    .brand-headline {
      font-size: 2rem;
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
  .delay-4 { animation-delay: 0.4s; opacity: 0; }
</style>
@endsection

@section('content')
<div class="login-page">
  <!-- Left Side - Branding -->
  <div class="login-branding">
    <div class="login-branding-content">
      <div class="brand-logo animate-fade-in">
        <img src="{{ asset('logo.png') }}" alt="Apani Psychology" style="height: 80px; width: auto; max-width: 400px; background: transparent !important; object-fit: contain;">
      </div>

      <h1 class="brand-headline animate-fade-in delay-1">
        Your Mental Wellness Journey Starts Here
      </h1>

      <p class="brand-tagline animate-fade-in delay-2">
        Connect with verified therapists, take self-assessments, and start your path to a healthier mind. We're here to support you every step of the way.
      </p>

      <div class="brand-features animate-fade-in delay-3">
        <div class="brand-feature">
          <div class="brand-feature-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
          </div>
          <div class="brand-feature-text">
            <h4>100% Confidential</h4>
            <p>Your privacy is our top priority</p>
          </div>
        </div>

        <div class="brand-feature">
          <div class="brand-feature-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div class="brand-feature-text">
            <h4>24/7 Support</h4>
            <p>Access help whenever you need it</p>
          </div>
        </div>

        <div class="brand-feature">
          <div class="brand-feature-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </div>
          <div class="brand-feature-text">
            <h4>Expert Therapists</h4>
            <p>Verified & experienced professionals</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Right Side - Login Form -->
  <div class="login-form-wrapper">
    <div class="login-form-header animate-fade-in">
      <h1>Welcome back! 👋</h1>
      <p>Don't have an account? <a href="{{ route('register') }}">Create one for free</a></p>
    </div>

    @if(session('message'))
      <div class="login-alert info animate-fade-in delay-1">
        <div class="login-alert-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
        <div class="login-alert-content">
          <h4>Login Required</h4>
          <p>{{ session('message') }}</p>
        </div>
      </div>
    @endif

    @if(session('booking_redirect'))
      <div class="login-alert success animate-fade-in delay-1">
        <div class="login-alert-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
        <div class="login-alert-content">
          <h4>Ready to Book!</h4>
          <p>After logging in, you'll be redirected to complete your session booking.</p>
        </div>
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="animate-fade-in delay-2">
      @csrf

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
            placeholder="Enter your email"
          >
          <svg class="form-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
          </svg>
        </div>
        @error('email')
          <div class="form-error">
            <svg fill="currentColor" viewBox="0 0 20 20" width="16" height="16">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div class="form-input-wrapper">
          <input
            id="password"
            name="password"
            type="password"
            autocomplete="current-password"
            required
            class="form-input @error('password') error @enderror"
            placeholder="Enter your password"
          >
          <svg class="form-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
          <button type="button" class="toggle-password" onclick="togglePassword()">
            <svg id="eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>
        @error('password')
          <div class="form-error">
            <svg fill="currentColor" viewBox="0 0 20 20" width="16" height="16">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="form-options">
        <label class="remember-me">
          <input type="checkbox" name="remember" id="remember">
          <span>Remember me</span>
        </label>
        <a href="#" class="forgot-link">Forgot password?</a>
      </div>

      <button type="submit" class="submit-btn">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
        </svg>
        Sign In to Your Account
      </button>
    </form>

    <div class="divider animate-fade-in delay-3">
      <span>or continue with</span>
    </div>

    <div class="social-login animate-fade-in delay-3">
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

    <div class="login-footer animate-fade-in delay-4">
      <p>By signing in, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></p>
    </div>
  </div>
</div>

<script>
function togglePassword() {
  const passwordInput = document.getElementById('password');
  const eyeIcon = document.getElementById('eye-icon');

  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    eyeIcon.innerHTML = `
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
    `;
  } else {
    passwordInput.type = 'password';
    eyeIcon.innerHTML = `
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
    `;
  }
}
</script>
@endsection
