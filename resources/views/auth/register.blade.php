@extends('layouts.app')

@section('title', 'Create Account - Start Your Wellness Journey')

@section('head')
<style>
  .register-page {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1fr 44%;
    background: #f8f9fc;
  }

  .register-hero {
    position: relative;
    overflow: hidden;
    padding: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
    color: #fff;
    background-image:
      linear-gradient(123.55deg, rgba(4, 28, 84, 0.85) 0%, rgba(100, 116, 148, 0.7) 100%),
      url('https://www.figma.com/api/mcp/asset/a489ff19-4543-4075-822c-5160666351da');
    background-size: cover;
    background-position: center;
  }

  .hero-copy h2 {
    max-width: 520px;
    margin: 0 0 1.2rem;
    font-size: 3rem;
    line-height: 1.2;
    font-weight: 500;
    color: #fff;
  }

  .hero-copy p {
    max-width: 390px;
    margin: 0 0 1.7rem;
    font-size: 1.1rem;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.78);
  }

  .hero-features {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
  }

  .hero-feature {
    display: flex;
    align-items: center;
    gap: 0.7rem;
    color: rgba(255, 255, 255, 0.84);
    font-size: 0.95rem;
  }

  .hero-feature i {
    width: 24px;
    height: 24px;
    border-radius: 999px;
    border: 1px solid rgba(255, 255, 255, 0.35);
    background: rgba(255, 255, 255, 0.2);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.72rem;
  }

  .register-form-wrapper {
    background: #f8f9fc;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2.5rem;
  }

  .register-form-card {
    width: 100%;
    max-width: 448px;
  }

  .register-form-header h1 {
    margin: 0 0 0.45rem;
    font-size: 2.1rem;
    color: #041C54;
    font-weight: 500;
  }

  .register-form-header p {
    margin: 0;
    color: #7484A4;
    font-size: 1rem;
  }

  .social-login {
    margin-top: 1.6rem;
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

  .divider {
    margin: 1.3rem 0 1rem;
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
    margin-bottom: 0.95rem;
  }

  .form-label {
    display: block;
    margin-bottom: 0.35rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: #041C54;
  }

  .form-label .muted {
    color: #BAC2D2;
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

  .role-selection {
    margin: 0.3rem 0 0.7rem;
  }

  .role-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
  }

  .role-option input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
  }

  .role-option label {
    height: 56px;
    border: 2px solid rgba(186, 194, 210, 0.45);
    border-radius: 14px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    color: #7484A4;
    cursor: pointer;
    font-weight: 500;
    margin: 0;
  }

  .role-option input:checked + label {
    border-color: #647494;
    background: rgba(100, 116, 148, 0.05);
    color: #041C54;
  }

  .role-dot {
    width: 16px;
    height: 16px;
    border-radius: 999px;
    border: 2px solid #BAC2D2;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .role-dot::after {
    content: '';
    width: 8px;
    height: 8px;
    border-radius: 999px;
    background: transparent;
  }

  .role-option input:checked + label .role-dot {
    border-color: #647494;
    background: #647494;
  }

  .role-option input:checked + label .role-dot::after {
    background: #fff;
  }

  .terms-checkbox {
    margin: 0.75rem 0 1rem;
    display: flex;
    gap: 0.6rem;
    align-items: flex-start;
    color: #7484A4;
    font-size: 0.88rem;
  }

  .terms-checkbox input {
    margin-top: 2px;
    accent-color: #647494;
  }

  .terms-checkbox a {
    color: #647494;
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

  .form-error {
    margin-top: 0.35rem;
    font-size: 0.78rem;
    color: #dc2626;
    display: flex;
    gap: 0.4rem;
    align-items: center;
  }

  @media (max-width: 1080px) {
    .register-page {
      grid-template-columns: 1fr;
    }

    .register-hero {
      min-height: 360px;
      padding: 2rem;
    }

    .hero-copy h2 {
      font-size: 2rem;
    }

    .register-form-wrapper {
      min-height: auto;
      padding: 2rem 1rem 2.5rem;
    }
  }
</style>
@endsection

@section('content')
<div class="register-page">
  <div class="register-hero">
    <div></div>
    <div class="hero-copy">
      <h2>Begin your path to wellness today</h2>
      <p>Join thousands who have found support, healing, and growth through our professional mental health services.</p>
      <div class="hero-features">
        <div class="hero-feature"><i class="ri-check-line"></i>Access to licensed therapists</div>
        <div class="hero-feature"><i class="ri-check-line"></i>Personalized self-assessments</div>
        <div class="hero-feature"><i class="ri-check-line"></i>Secure and confidential sessions</div>
        <div class="hero-feature"><i class="ri-check-line"></i>24/7 support resources</div>
      </div>
    </div>
  </div>

  <div class="register-form-wrapper">
    <div class="register-form-card">
      <div class="register-form-header">
        <h1>Create your account</h1>
        <p>Start your journey to better mental health and wellness</p>
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
        <a href="#" class="social-btn"><i class="ri-apple-fill"></i>Apple</a>
      </div>

      <div class="divider"><span>or register with email</span></div> -->

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="role-selection">
          <label class="form-label">I want to join as</label>
          <div class="role-options">
            <div class="role-option">
              <input type="radio" name="role" id="role-client" value="client" {{ old('role', 'client') == 'client' ? 'checked' : '' }} required>
              <label for="role-client"><span class="role-dot"></span>Client</label>
            </div>
            <div class="role-option">
              <input type="radio" name="role" id="role-therapist" value="therapist" {{ old('role') == 'therapist' ? 'checked' : '' }}>
              <label for="role-therapist"><span class="role-dot"></span>Therapist</label>
            </div>
          </div>
          @error('role')
            <div class="form-error"><i class="ri-error-warning-line"></i>{{ $message }}</div>
          @enderror
        </div>

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
              placeholder="Enter your full name">
            <svg class="form-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </div>
          @error('name')
            <div class="form-error"><i class="ri-error-warning-line"></i>{{ $message }}</div>
          @enderror
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
              placeholder="Enter your email">
            <svg class="form-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
            </svg>
          </div>
          @error('email')
            <div class="form-error"><i class="ri-error-warning-line"></i>{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="phone">Phone Number <span class="muted">(Optional)</span></label>
          <div class="form-input-wrapper">
            <input
              id="phone"
              name="phone"
              type="tel"
              autocomplete="tel"
              value="{{ old('phone') }}"
              class="form-input @error('phone') error @enderror"
              placeholder="Enter your phone number">
            <svg class="form-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
          </div>
          @error('phone')
            <div class="form-error"><i class="ri-error-warning-line"></i>{{ $message }}</div>
          @enderror
        </div>

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
              placeholder="Create a password">
            <svg class="form-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <button type="button" class="toggle-password" onclick="togglePassword('password','eye-icon-password')">
              <i class="ri-eye-line" id="eye-icon-password"></i>
            </button>
          </div>
          @error('password')
            <div class="form-error"><i class="ri-error-warning-line"></i>{{ $message }}</div>
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
              placeholder="Confirm your password">
            <svg class="form-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation','eye-icon-confirm')">
              <i class="ri-eye-line" id="eye-icon-confirm"></i>
            </button>
          </div>
        </div>

        <div class="terms-checkbox">
          <input type="checkbox" name="terms" id="terms" required>
          <label for="terms">
            I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
          </label>
        </div>

        <button type="submit" class="submit-btn">Create Account</button>
      </form>
      {{-- Footer removed as requested --}}
    </div>
  </div>
</div>

<script>
function togglePassword(fieldId, iconId) {
  const input = document.getElementById(fieldId);
  const icon = document.getElementById(iconId);
  if (!input || !icon) return;
  if (input.type === 'password') {
    input.type = 'text';
    icon.className = 'ri-eye-off-line';
  } else {
    input.type = 'password';
    icon.className = 'ri-eye-line';
  }
}
</script>
@endsection
