<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{url('/')}}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title') | {{ config('app.name', 'Apani Psychology') }}</title>
  <meta name="description" content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
  <meta name="keywords" content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
  <!-- laravel CRUD token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Canonical SEO -->
  <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />


  <!-- Include Styles -->
  @include('layouts/sections/styles')
  
  <!-- Logo & Global Styles -->
  <style>
    /* Global theme gradient for backend headers */
    :root {
      --theme-gradient: var(--apni-gradient-light);
    }

    /* Unified backend page header */
    .layout-wrapper .page-header {
      background: var(--theme-gradient);
      border-radius: 16px;
      padding: 1.5rem 2rem;
      margin-bottom: 1.5rem;
    }

    .layout-wrapper .page-header h4 {
      color: #ffffff;
      font-weight: 700;
      margin-bottom: 0.25rem;
    }

    .layout-wrapper .page-header p {
      color: rgba(255, 255, 255, 0.85);
      margin-bottom: 0;
    }

    /* Unified main listing card */
    .layout-wrapper .main-card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      background: #ffffff;
      margin-bottom: 1.5rem;
    }

    .layout-wrapper .main-card .card-header {
      background: #ffffff;
      border-bottom: 2px solid #f0f2f5;
      padding: 1.5rem;
    }

    .layout-wrapper .main-card .card-body {
      padding: 1.5rem;
    }

    /* Hide inline success alerts across admin/therapist modules */
    .layout-wrapper .alert.alert-success.alert-dismissible.fade.show {
      display: none !important;
    }

    .app-brand-logo,
    img[src*="APNIPSYCHOLOGY-(dark).png"] {
      background: transparent !important;
      object-fit: contain;
    }
    /* Ensure logo displays properly without white background */
    .app-brand-logo img,
    img.app-brand-logo {
      background: transparent !important;
    }

    /* Disable hover animations across all modules (requested) */
    *:hover {
      transform: none !important;
      box-shadow: none !important;
      transition: none !important;
    }

    /* Unified dark-blue header bars across modules */
    .page-header,
    .dashboard-header,
    .welcome-banner,
    .theme-header-bar {
      background: #041c54 !important;
      color: #ffffff !important;
    }

    .page-header h1,
    .page-header h2,
    .page-header h3,
    .page-header h4,
    .page-header h5,
    .page-header h6,
    .page-header p,
    .dashboard-header h1,
    .dashboard-header h2,
    .dashboard-header h3,
    .dashboard-header h4,
    .dashboard-header h5,
    .dashboard-header h6,
    .dashboard-header p,
    .welcome-banner h1,
    .welcome-banner h2,
    .welcome-banner h3,
    .welcome-banner h4,
    .welcome-banner h5,
    .welcome-banner h6,
    .welcome-banner p,
    .theme-header-bar h1,
    .theme-header-bar h2,
    .theme-header-bar h3,
    .theme-header-bar h4,
    .theme-header-bar h5,
    .theme-header-bar h6,
    .theme-header-bar p {
      color: #ffffff !important;
    }
  </style>

  <!-- Include Scripts for customizer, helper, analytics, config -->
  @include('layouts/sections/scriptsIncludes')
</head>

<body>

  <!-- Layout Content -->
  @yield('layoutContent')
  <!--/ Layout Content -->


  <!-- Include Scripts -->
  @include('layouts/sections/scripts')

</body>

</html>
