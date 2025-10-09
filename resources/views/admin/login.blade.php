@extends('layouts/blankLayout')

@section('title', 'Admin Login')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                @include('_partials.macros',["height"=>20])
              </span>
              <span class="app-brand-text demo text-body fw-bolder">Therapist Admin</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Welcome to Admin Panel! 👋</h4>
          <p class="mb-4">Please sign-in to your account</p>

          <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input
                type="text"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                placeholder="Enter your email"
                autofocus
                value="{{ old('email') }}"
              />
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
                <a href="{{url('auth/forgot-password-basic')}}">
                  <small>Forgot Password?</small>
                </a>
              </div>
              <div class="input-group input-group-merge">
                <input
                  type="password"
                  id="password"
                  class="form-control @error('password') is-invalid @enderror"
                  name="password"
                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                  aria-describedby="password"
                />
                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember-me">
                  Remember Me
                </label>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
            </div>
          </form>

          <div class="text-center">
            <p class="mb-2">
              <strong>Test Accounts:</strong>
            </p>
            <p class="mb-1">
              <strong>SuperAdmin:</strong> superadmin@therapist.com / password
            </p>
            <p class="mb-1">
              <strong>Admin:</strong> admin@therapist.com / password
            </p>
            <p class="mb-1">
              <strong>Therapist:</strong> therapist@therapist.com / password
            </p>
          </div>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
</div>
@endsection
