<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Apani Psychology - Online Mental Health Counseling')</title>
    <meta name="description" content="@yield('description', 'Connect with verified therapists for online counseling, therapy sessions, and mental health support.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Head Content -->
    @yield('head')
    <style>
      :root {
        --font-display: 'Sora', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        --font-body: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        --font-weight-normal: 400;
        --font-weight-medium: 500;
      }

      body {
        font-family: var(--font-body);
        font-weight: var(--font-weight-normal);
      }

      h1, h2, h3, h4, h5, h6,
      .apni-section-title,
      .apni-hero-heading-main,
      .nav-link,
      .btn-primary,
      .btn-outline,
      .app-header-cta,
      .app-header-cta-mobile {
        font-family: var(--font-display);
        font-weight: var(--font-weight-medium);
      }

      img.app-brand-logo,
      img[src*="APNIPSYCHOLOGY-(dark).png"] {
        background: transparent !important;
        object-fit: contain;
      }

      /* Public header — explicit brand colors (overrides global Materio/Bootstrap link styles) */
      .app-navbar .nav-link {
        color: #7484A4;
        text-decoration: none;
        transition: color 0.2s ease;
      }

      .app-navbar .nav-link:hover {
        color: #041C54;
      }

      .app-navbar .nav-link.nav-link-active {
        color: #041C54 !important;
        font-weight: 600;
        background-color: transparent !important;
        text-decoration: underline;
        text-decoration-color: #647494;
        text-decoration-thickness: 2px;
        text-underline-offset: 0.35rem;
      }

      .app-navbar .app-header-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #647494 0%, #041C54 100%);
        color: #ffffff !important;
        text-decoration: none;
        padding: 0.5rem 1.35rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
        box-shadow: 0 8px 22px rgba(4, 28, 84, 0.28);
        transition: box-shadow 0.2s ease, filter 0.2s ease;
      }

      .app-navbar .app-header-cta:hover {
        color: #ffffff !important;
        filter: brightness(1.06);
        box-shadow: 0 10px 26px rgba(4, 28, 84, 0.34);
      }

      .app-navbar .app-header-cta:focus-visible {
        outline: 2px solid #647494;
        outline-offset: 2px;
      }

      .app-navbar .app-header-signin {
        color: #7484A4;
        text-decoration: none;
        transition: color 0.2s ease;
      }

      .app-navbar .app-header-signin:hover {
        color: #041C54;
      }

      .app-navbar-mobile-link {
        color: #4d5d78;
        text-decoration: none;
        transition: color 0.15s ease;
      }

      .app-navbar-mobile-link:hover {
        color: #041C54;
      }

      .app-navbar-mobile-link.app-navbar-mobile-link-active {
        color: #041C54 !important;
        font-weight: 600;
        background-color: transparent !important;
        text-decoration: underline;
        text-decoration-color: #647494;
        text-decoration-thickness: 2px;
        text-underline-offset: 0.25rem;
      }

      .app-navbar .app-header-cta-mobile {
        display: block;
        text-align: center;
        margin-top: 0.25rem;
        background: linear-gradient(135deg, #647494 0%, #041C54 100%);
        color: #ffffff !important;
        text-decoration: none;
        padding: 0.65rem 1rem;
        border-radius: 9999px;
        font-weight: 500;
        box-shadow: 0 8px 20px rgba(4, 28, 84, 0.22);
        transition: filter 0.2s ease;
      }

      .app-navbar .app-header-cta-mobile:hover {
        color: #ffffff !important;
        filter: brightness(1.05);
      }
    </style>
</head>
<body class="h-full bg-gray-50" x-data="{ mobileMenuOpen: false }">
    <!-- Skip to content link -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-primary-600 text-white px-4 py-2 rounded-md z-50">
        Skip to main content
    </a>

    <!-- Navigation -->
    <nav class="app-navbar bg-white shadow-sm border-b border-gray-200" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-[80px]">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <div class="flex-shrink-0 py-2">
                            <img
                                src="{{ asset('assets/img/logo/APNIPSYCHOLOGY-(dark).png') }}"
                                alt="Apni Psychology"
                                class="app-brand-logo h-14 w-auto max-w-[180px]"
                                style="background: transparent !important; object-fit: contain;"
                            >
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'nav-link-active' : '' }}">
                        Contact Us
                    </a>
                    <a href="{{ route('therapists.index') }}" class="nav-link {{ request()->routeIs('therapists.*') ? 'nav-link-active' : '' }}">
                        Find Therapists
                    </a>
                    <a href="{{ route('assessments.index') }}" class="nav-link {{ request()->routeIs('assessments.*') ? 'nav-link-active' : '' }}">
                        Self Assessment
                    </a>
                    <a href="{{ route('blog.index') }}" class="nav-link {{ request()->routeIs('blog.*') ? 'nav-link-active' : '' }}">
                        Blog
                    </a>
                </div>

                <!-- User Menu -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <div class="relative" x-data="{ userMenuOpen: false }">
                            <button @click="userMenuOpen = !userMenuOpen" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}">
                                <span class="ml-2 text-gray-700">{{ auth()->user()->name }}</span>
                                <svg class="ml-1 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                @if(auth()->user()->isTherapist())
                                    <a href="{{ route('therapist.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Therapist Dashboard</a>
                                @else
                                    <a href="{{ route('client.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Dashboard</a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile Settings</a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="app-header-signin px-3 py-2 rounded-md text-sm font-medium">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="app-header-cta">
                            Get Started
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
                <a href="{{ route('home') }}" class="app-navbar-mobile-link block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'app-navbar-mobile-link-active' : '' }}">Home</a>
                <a href="{{ route('contact') }}" class="app-navbar-mobile-link block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('contact') ? 'app-navbar-mobile-link-active' : '' }}">Contact Us</a>
                <a href="{{ route('therapists.index') }}" class="app-navbar-mobile-link block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('therapists.*') ? 'app-navbar-mobile-link-active' : '' }}">Find Therapists</a>
                <a href="{{ route('assessments.index') }}" class="app-navbar-mobile-link block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('assessments.*') ? 'app-navbar-mobile-link-active' : '' }}">Self Assessment</a>
                <a href="{{ route('blog.index') }}" class="app-navbar-mobile-link block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('blog.*') ? 'app-navbar-mobile-link-active' : '' }}">Blog</a>

                @auth
                    <div class="border-t border-gray-200 pt-4">
                        @if(auth()->user()->isTherapist())
                            <a href="{{ route('therapist.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Therapist Dashboard</a>
                        @else
                            <a href="{{ route('client.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">My Dashboard</a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Profile Settings</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                Sign Out
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border-t border-gray-200 pt-4 space-y-1">
                        <a href="{{ route('login') }}" class="app-navbar-mobile-link block px-3 py-2 rounded-md text-base font-medium">Sign In</a>
                        <a href="{{ route('register') }}" class="app-header-cta-mobile">Get Started</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white text-[#041C54] border-t border-[#BAC2D2]/30">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-10 md:flex-row md:justify-between md:items-start md:gap-12 lg:gap-16">
                <div class="max-w-md shrink-0">
                    <div class="flex items-center mb-4">
                        <img
                            src="{{ asset('assets/img/logo/APNIPSYCHOLOGY-(dark).png') }}"
                            alt="Apni Psychology"
                            class="app-brand-logo h-14 w-auto max-w-[260px]"
                            style="background: transparent !important; object-fit: contain;"
                        >
                    </div>
                    <p class="text-[#7484A4] mb-4">
                        Connect with verified therapists for online counseling, therapy sessions, and mental health support.
                        Your mental health matters, and we're here to help.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://x.com" target="_blank" rel="noopener noreferrer" class="text-[#647494] hover:text-[#041C54] transition-colors" aria-label="X (formerly Twitter)">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="text-[#647494] hover:text-[#041C54] transition-colors" aria-label="Instagram">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 11-2.881.001 1.44 1.44 0 012.881-.001z"/>
                            </svg>
                        </a>
                        <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="text-[#647494] hover:text-[#041C54] transition-colors" aria-label="LinkedIn">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Two-row grid: headings share row 1, lists share row 2 so first links align even if a heading wraps --}}
                <div class="grid grid-cols-2 gap-x-8 gap-y-4 sm:gap-x-12 md:gap-x-14 lg:gap-x-20 shrink-0 justify-items-start">
                    <h3 id="footer-nav-services" class="text-sm font-semibold text-[#041C54] tracking-wider uppercase leading-tight self-start">Services</h3>
                    <h3 id="footer-nav-support" class="text-sm font-semibold text-[#041C54] tracking-wider uppercase leading-tight self-start">Support</h3>
                    <ul class="space-y-2 min-w-0 pl-0" aria-labelledby="footer-nav-services">
                        <li><a href="{{ route('therapists.index') }}" class="text-[#7484A4] hover:text-[#041C54] transition-colors">Find Therapists</a></li>
                        <li><a href="{{ route('assessments.index') }}" class="text-[#7484A4] hover:text-[#041C54] transition-colors">Self Assessment</a></li>
                        <li><a href="#" class="text-[#7484A4] hover:text-[#041C54] transition-colors">Couple Therapy</a></li>
                        <li><a href="#" class="text-[#7484A4] hover:text-[#041C54] transition-colors">Family Therapy</a></li>
                        <li><a href="#" class="text-[#7484A4] hover:text-[#041C54] transition-colors">Corporate EAP</a></li>
                    </ul>
                    <ul class="space-y-2 min-w-0 pl-0" aria-labelledby="footer-nav-support">
                        <li><a href="#" class="text-[#7484A4] hover:text-[#041C54] transition-colors">Help Center</a></li>
                        <li><a href="{{ route('contact') }}" class="text-[#7484A4] hover:text-[#041C54] transition-colors">Contact Us</a></li>
                        <li><a href="#" class="text-[#7484A4] hover:text-[#041C54] transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-[#7484A4] hover:text-[#041C54] transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="text-[#7484A4] hover:text-[#041C54] transition-colors">FAQ</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-[#BAC2D2]/30">
                <p class="text-center text-[#7484A4] text-sm">
                    &copy; {{ date('Y') }} Apani Psychology. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @yield('scripts')
</body>
</html>
