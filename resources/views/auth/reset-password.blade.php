@extends('layouts.app')

@section('title', 'Reset Password - Your Wellness Journey')

@section('head')
@include('auth.partials.page-styles')
@endsection

@section('content')
<div class="login-page">
  <div class="login-hero">
    <div></div>
    <div class="hero-copy">
      <h2>Create a new password</h2>
      <p>Choose a strong password to secure your account.</p>
    </div>
  </div>
  <div class="login-form-wrapper">
    <div class="login-form-card">
      <div class="login-form-header">
        <h1>Reset password</h1>
      </div>

      <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
          <label class="form-label" for="email">Email Address</label>
          <div class="form-input-wrapper">
            <input
              id="email"
              name="email"
              type="email"
              autocomplete="email"
              required
              value="{{ old('email', $request->email) }}"
              class="form-input @error('email') error @enderror"
              placeholder="Enter your email">
          </div>
          @error('email')
            <div class="form-error">
              <i class="ri-error-warning-line"></i>{{ $message }}
            </div>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="password">New Password</label>
          <div class="form-input-wrapper">
            <input
              id="password"
              name="password"
              type="password"
              autocomplete="new-password"
              required
              class="form-input @error('password') error @enderror"
              placeholder="Enter a new password">
          </div>
          @error('password')
            <div class="form-error">
              <i class="ri-error-warning-line"></i>{{ $message }}
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
              placeholder="Confirm your new password">
          </div>
        </div>

        <button type="submit" class="submit-btn">Reset Password</button>
      </form>

      <p class="auth-back-link">
        <a href="{{ route('login') }}">Back to sign in</a>
      </p>
    </div>
  </div>
</div>
@endsection
