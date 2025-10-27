@extends('layouts/blankLayout')

@section('title', 'Admin Login')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
<style>
  .login-container {
    background: #ffffff;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }

  .login-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
    overflow: hidden;
    max-width: 450px;
    width: 100%;
  }

  .login-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40px 30px;
    text-align: center;
    color: white;
    border-bottom: 3px solid rgba(255, 255, 255, 0.2);
  }

  .login-header .logo {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 32px;
  }

  .login-header h2 {
    margin: 0;
    font-weight: 600;
    font-size: 28px;
  }

  .login-header p {
    margin: 10px 0 0;
    opacity: 0.9;
    font-size: 16px;
  }

  .login-body {
    padding: 40px 30px;
  }

  .form-floating {
    margin-bottom: 20px;
  }

  .form-floating .form-control {
    border-radius: 12px;
    border: 2px solid #e9ecef;
    padding: 1rem 0.75rem;
    height: auto;
    transition: all 0.3s ease;
  }

  .form-floating .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
  }

  .form-floating label {
    padding: 1rem 0.75rem;
  }

  .btn-login {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    padding: 15px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }

  .btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
  }

  .remember-me {
    margin: 20px 0;
  }

  .remember-me .form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
  }

  .test-accounts {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin-top: 30px;
  }

  .test-accounts h6 {
    color: #495057;
    margin-bottom: 15px;
    font-weight: 600;
  }

  .account-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #e9ecef;
  }

  .account-item:last-child {
    border-bottom: none;
  }

  .account-role {
    font-weight: 600;
    color: #667eea;
  }

  .account-credentials {
    font-size: 12px;
    color: #6c757d;
  }

  .alert {
    border-radius: 12px;
    border: none;
    margin-bottom: 20px;
  }

  .alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
  }

  .alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
  }

  .password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6c757d;
    transition: color 0.3s ease;
  }

  .password-toggle:hover {
    color: #667eea;
  }

  .forgot-password {
    text-align: center;
    margin-top: 20px;
  }

  .forgot-password a {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
  }

  .forgot-password a:hover {
    color: #764ba2;
  }
</style>
@endsection

@section('content')
<div class="login-container">
  <div class="login-card">
    <!-- Header -->
    <div class="login-header">
      <div class="logo">
        <i class="ri-shield-user-line"></i>
      </div>
      <h2>Admin Panel</h2>
      <p>Secure Access Portal</p>
    </div>

    <!-- Body -->
    <div class="login-body">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <i class="ri-check-line me-2"></i>{{ session('success') }}
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

      <form action="{{ route('admin.login') }}" method="POST">
        @csrf

        <!-- Email Field -->
        <div class="form-floating">
          <input
            type="email"
            class="form-control @error('email') is-invalid @enderror"
            id="email"
            name="email"
            placeholder="Enter your email"
            value="{{ old('email') }}"
            required
            autofocus
          />
          <label for="email">
            <i class="ri-mail-line me-2"></i>Email Address
          </label>
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Password Field -->
        <div class="form-floating position-relative">
          <input
            type="password"
            class="form-control @error('password') is-invalid @enderror"
            id="password"
            name="password"
            placeholder="Enter your password"
            required
          />
          <label for="password">
            <i class="ri-lock-line me-2"></i>Password
          </label>
          <span class="password-toggle" onclick="togglePassword()">
            <i class="ri-eye-off-line" id="toggleIcon"></i>
          </span>
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Remember Me -->
        <div class="remember-me">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember-me" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember-me">
              <i class="ri-checkbox-line me-2"></i>Remember me for 30 days
            </label>
          </div>
        </div>

        <!-- Login Button -->
        <button class="btn btn-primary btn-login w-100" type="submit">
          <i class="ri-login-box-line me-2"></i>Sign In to Admin Panel
        </button>
      </form>

      <!-- Forgot Password -->
      <div class="forgot-password">
        <a href="#" onclick="alert('Contact system administrator for password reset')">
          <i class="ri-question-line me-2"></i>Forgot your password?
        </a>
      </div>

      <!-- Test Accounts -->
      <div class="test-accounts">
        <h6><i class="ri-user-settings-line me-2"></i>Test Accounts</h6>

        <div class="account-item">
          <div>
            <div class="account-role">SuperAdmin</div>
            <div class="account-credentials">Full system access</div>
          </div>
          <div class="account-credentials">superadmin@therapist.com</div>
        </div>

        <div class="account-item">
          <div>
            <div class="account-role">Admin</div>
            <div class="account-credentials">Administrative access</div>
          </div>
          <div class="account-credentials">admin@therapist.com</div>
        </div>

        <div class="account-item">
          <div>
            <div class="account-role">Therapist</div>
            <div class="account-credentials">Therapist panel access</div>
          </div>
          <div class="account-credentials">therapist@therapist.com</div>
        </div>

        <div class="text-center mt-3">
          <small class="text-muted">
            <i class="ri-key-line me-1"></i>Password for all accounts: <strong>password</strong>
          </small>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function togglePassword() {
  const passwordField = document.getElementById('password');
  const toggleIcon = document.getElementById('toggleIcon');

  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    toggleIcon.className = 'ri-eye-line';
  } else {
    passwordField.type = 'password';
    toggleIcon.className = 'ri-eye-off-line';
  }
}

// Add click handlers for test accounts
document.addEventListener('DOMContentLoaded', function() {
  const accountItems = document.querySelectorAll('.account-item');

  accountItems.forEach(item => {
    item.addEventListener('click', function() {
      const email = this.querySelector('.account-credentials').textContent;
      document.getElementById('email').value = email;
      document.getElementById('password').value = 'password';
      document.getElementById('email').focus();
    });

    // Add hover effect
    item.style.cursor = 'pointer';
    item.addEventListener('mouseenter', function() {
      this.style.backgroundColor = '#e9ecef';
    });

    item.addEventListener('mouseleave', function() {
      this.style.backgroundColor = 'transparent';
    });
  });
});
</script>
@endsection
