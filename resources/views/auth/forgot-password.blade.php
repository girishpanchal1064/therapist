@extends('layouts.app')

@section('title', 'Forgot Password - Your Wellness Journey')

@section('head')
@include('auth.partials.page-styles')
@endsection

@section('content')
<div class="login-page">
  <div class="login-hero">
    <div></div>
    <div class="hero-copy">
      <h2>Reset your password</h2>
      <p>Enter the email address linked to your account and we will send you reset instructions.</p>
    </div>
  </div>
  <div class="login-form-wrapper">
    <div class="login-form-card">
      <div class="login-form-header">
        <h1>Forgot password</h1>
      </div>

      @if (session('status'))
        <div class="login-alert success">
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}">
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
              autofocus
              value="{{ old('email') }}"
              class="form-input @error('email') error @enderror"
              placeholder="Enter your email">
          </div>
          @error('email')
            <div class="form-error">
              <i class="ri-error-warning-line"></i>{{ $message }}
            </div>
          @enderror
        </div>

        <button type="submit" class="submit-btn">Send Reset Link</button>
      </form>

      <p class="auth-back-link">
        <a href="{{ route('login') }}">Back to sign in</a>
      </p>
    </div>
  </div>
</div>
@endsection
