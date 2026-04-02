@extends('layouts.app')

@section('title', 'Sign In - Your Wellness Journey')

@section('head')
<style>
  .login-page {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1fr 44%;
    background: #f8f9fc;
  }

  .login-hero {
    position: relative;
    overflow: hidden;
    padding: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    color: #fff;
    background-image:
      linear-gradient(127.7deg, rgba(4, 28, 84, 0.85) 0%, rgba(100, 116, 148, 0.7) 100%),
      url('https://www.figma.com/api/mcp/asset/ac7bbbdf-028b-4ffc-93e9-79c718f034bf');
    background-size: cover;
    background-position: center;
  }

  .hero-brand {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .hero-brand-badge {
    width: 40px;
    height: 40px;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
  }

  .hero-brand-text {
    font-size: 1.25rem;
    font-weight: 500;
  }

  .hero-copy h2 {
    max-width: 480px;
    font-size: 3rem;
    line-height: 1.2;
    font-weight: 500;
    color: #ffffff;
    margin: 0 0 1.25rem;
  }

  .hero-copy p {
    max-width: 380px;
    font-size: 1.1rem;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.78);
    margin: 0 0 1.75rem;
  }

  .hero-trust {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: rgba(255, 255, 255, 0.82);
    font-size: 0.95rem;
  }

  .hero-avatars {
    display: flex;
    align-items: center;
    margin-right: 0.2rem;
  }

  .hero-avatar {
    width: 40px;
    height: 40px;
    border-radius: 999px;
    border: 2px solid rgba(255, 255, 255, 0.35);
    background: rgba(255, 255, 255, 0.15);
    margin-left: -10px;
  }

  .hero-avatar:first-child {
    margin-left: 0;
  }

  .hero-avatar.count {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 0.78rem;
  }

  .login-form-wrapper {
    background: #f8f9fc;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2.5rem;
  }

  .login-form-card {
    width: 100%;
    max-width: 448px;
  }

  .login-form-header h1 {
    margin: 0 0 0.45rem;
    font-size: 2.1rem;
    color: #041C54;
    font-weight: 500;
  }

  .login-form-header p {
    margin: 0;
    color: #7484A4;
    font-size: 1rem;
  }

  .social-login {
    margin-top: 2rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
  }

  .social-btn {
    height: 48px;
    border: 1px solid rgba(186, 194, 210, 0.45);
    border-radius: 14px;
    background: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    color: #041C54;
    font-weight: 500;
    text-decoration: none;
    font-size: 0.88rem;
  }

  .social-btn:hover {
    border-color: rgba(100, 116, 148, 0.45);
    color: #041C54;
  }

  .divider {
    margin: 1.4rem 0 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .divider::before,
  .divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(186, 194, 210, 0.4);
  }

  .divider span {
    color: #7484A4;
    font-size: 0.88rem;
  }

  .form-group {
    margin-bottom: 1.1rem;
  }

  .form-label {
    display: block;
    margin-bottom: 0.35rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: #041C54;
  }

  .form-input-wrapper {
    position: relative;
  }

  .form-input-icon {
    position: absolute;
    top: 50%;
    left: 1rem;
    transform: translateY(-50%);
    color: #7484A4;
    pointer-events: none;
  }

  .form-input {
    width: 100%;
    height: 48px;
    border: 1px solid rgba(186, 194, 210, 0.45);
    border-radius: 14px;
    background: #fff;
    padding: 0.8rem 2.8rem 0.8rem 2.7rem;
    color: #041C54;
    font-size: 0.9rem;
  }

  .form-input::placeholder {
    color: #BAC2D2;
  }

  .form-input:focus {
    outline: none;
    border-color: #647494;
    box-shadow: 0 0 0 3px rgba(100, 116, 148, 0.15);
  }

  .form-input.error {
    border-color: #ef4444;
  }

  .toggle-password {
    position: absolute;
    top: 50%;
    right: 1rem;
    transform: translateY(-50%);
    background: transparent;
    border: 0;
    color: #7484A4;
    padding: 0;
  }

  .form-error {
    margin-top: 0.4rem;
    font-size: 0.8rem;
    color: #dc2626;
    display: flex;
    gap: 0.4rem;
    align-items: center;
  }

  .form-options {
    margin-top: 0.9rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .remember-me {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.88rem;
    color: #7484A4;
  }

  .remember-me input {
    accent-color: #647494;
  }

  .forgot-link {
    color: #647494;
    font-size: 0.88rem;
    text-decoration: none;
  }

  .submit-btn {
    width: 100%;
    height: 48px;
    border: 0;
    border-radius: 14px;
    color: #fff;
    font-size: 0.95rem;
    font-weight: 500;
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.2), 0 4px 6px rgba(4, 28, 84, 0.2);
  }

  .submit-btn:hover {
    filter: brightness(1.03);
  }

  .signup-text {
    text-align: center;
    margin-top: 1.2rem;
    color: #7484A4;
    font-size: 0.9rem;
  }

  .signup-text a {
    color: #647494;
    text-decoration: none;
  }

  .login-alert {
    margin: 0.8rem 0 1rem;
    border-radius: 12px;
    padding: 0.85rem 1rem;
    font-size: 0.85rem;
  }

  .login-alert.info {
    border: 1px solid #bfdbfe;
    background: #eff6ff;
    color: #1d4ed8;
  }

  .login-alert.success {
    border: 1px solid #bbf7d0;
    background: #f0fdf4;
    color: #047857;
  }

  @media (max-width: 1080px) {
    .login-page {
      grid-template-columns: 1fr;
    }

    .login-hero {
      min-height: 340px;
      padding: 2rem;
    }

    .hero-copy h2 {
      font-size: 2rem;
    }

    .login-form-wrapper {
      min-height: auto;
      padding: 2rem 1rem 2.5rem;
    }
  }
</style>
@endsection

@section('content')
<div class="login-page">
  <div class="login-hero">
    <div></div>
    <div class="hero-copy">
      <h2>Your journey to better mental health starts here</h2>
      <p>Connect with licensed therapists, take self-assessments, and access resources tailored to your needs.</p>
      <div class="hero-trust">
        <div class="hero-avatars">
          <div class="hero-avatar"></div>
          <div class="hero-avatar"></div>
          <div class="hero-avatar"></div>
          <div class="hero-avatar count">2k+</div>
        </div>
        Trusted by 2,000+ clients
      </div>
    </div>
  </div>
  <div class="login-form-wrapper">
    <div class="login-form-card">
      <div class="login-form-header">
        <h1>Welcome back</h1>
        <!-- <p>Sign in to your account to continue your wellness journey</p> -->
      </div>
      <!-- <div class="social-login">
        <a href="#" class="social-btn">
          <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
          </svg>
          Google
        </a>
        <a href="#" class="social-btn">
          <i class="ri-apple-fill"></i>
          Apple
        </a>
      </div> -->
      <!-- <div class="divider">
        <span>or continue with email</span>
      </div> -->

      @if(session('message'))
        <div class="login-alert info">
          {{ session('message') }}
        </div>
      @endif

      @if(session('booking_redirect'))
        <div class="login-alert success">
          After logging in, you'll be redirected to complete your session booking.
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
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
              placeholder="Enter your email">
            <svg class="form-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
            </svg>
          </div>
          @error('email')
            <div class="form-error">
              <i class="ri-error-warning-line"></i>{{ $message }}
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
              placeholder="Enter your password">
            <svg class="form-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <button type="button" class="toggle-password" onclick="togglePassword()">
              <svg id="eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
            </button>
          </div>
          @error('password')
            <div class="form-error">
              <i class="ri-error-warning-line"></i>{{ $message }}
            </div>
          @enderror
        </div>

        <div class="form-options">
          <label class="remember-me">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <span>Remember me</span>
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
          @else
            <a href="#" class="forgot-link">Forgot Password?</a>
          @endif
        </div>

        <button type="submit" class="submit-btn">Sign In</button>
      </form>

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
