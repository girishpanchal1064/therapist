@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
$containerNav = $containerNav ?? 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');
$currentUser = Auth::user();
@endphp

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
  @endif
  @if(isset($navbarDetached) && $navbarDetached == '')
  <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="{{$containerNav}}">
      @endif

      <!--  Brand demo (display only for navbar-full and hide on below xl) -->
      @if(isset($navbarFull))
      <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-6">
        <a href="{{url('/')}}" class="app-brand-link gap-2">
          <span class="app-brand-logo demo">@include('_partials.macros',["height"=>20])</span>
          <span class="app-brand-text demo menu-text fw-semibold ms-1">{{config('variables.templateName')}}</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
          <i class="ri-close-fill align-middle"></i>
        </a>
      </div>
      @endif

      <!-- ! Not required for layout-without-menu -->
      @if(!isset($navbarHideToggle))
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
          <i class="ri-menu-fill ri-24px"></i>
        </a>
      </div>
      @endif

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
          <div class="nav-item d-flex align-items-center">
            <i class="ri-search-line ri-22px me-1_5"></i>
            <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50" placeholder="Search..." aria-label="Search...">
          </div>
        </div>
        <!-- /Search -->
        <ul class="navbar-nav flex-row align-items-center ms-auto">

          <!-- Notifications -->
          <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
              <span class="position-relative">
                <i class="ri-notification-3-line ri-22px"></i>
                <span class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
              </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end p-0">
              <li class="dropdown-menu-header border-bottom">
                <div class="dropdown-header d-flex align-items-center py-3">
                  <h6 class="mb-0 me-auto">Notifications</h6>
                  <div class="d-flex align-items-center h-px-20">
                    <span class="badge bg-label-primary rounded-pill badge-notifications">3 New</span>
                  </div>
                </div>
              </li>
              <li class="dropdown-notifications-list scrollable-container">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                          <span class="avatar-initial rounded-circle bg-label-success">
                            <i class="ri-check-line"></i>
                          </span>
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="small mb-0">Welcome to the Admin Panel!</h6>
                        <small class="text-muted">Just now</small>
                      </div>
                    </div>
                  </li>
                </ul>
              </li>
              <li class="border-top">
                <div class="d-grid p-4">
                  <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                    <small class="align-middle">View all notifications</small>
                  </a>
                </div>
              </li>
            </ul>
          </li>
          <!--/ Notifications -->

          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                @if($currentUser)
                  @if($currentUser->hasRole('Therapist') && $currentUser->therapistProfile && $currentUser->therapistProfile->profile_image)
                    <img src="{{ asset('storage/' . $currentUser->therapistProfile->profile_image) }}" alt="{{ $currentUser->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #e9ecef;">
                  @elseif($currentUser->hasRole('Client') && $currentUser->profile && $currentUser->profile->profile_image)
                    <img src="{{ asset('storage/' . $currentUser->profile->profile_image) }}" alt="{{ $currentUser->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #e9ecef;">
                  @elseif($currentUser->getRawOriginal('avatar'))
                    <img src="{{ asset('storage/' . $currentUser->getRawOriginal('avatar')) }}" alt="{{ $currentUser->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #e9ecef;">
                  @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($currentUser->name) }}&background=667eea&color=fff&size=80&bold=true&format=svg" alt="{{ $currentUser->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #e9ecef;">
                  @endif
                @else
                  <span class="avatar-initial rounded-circle bg-primary" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 600;">
                    NA
                  </span>
                @endif
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
              <li>
                <a class="dropdown-item pb-2 mb-1 waves-effect" href="@if($currentUser && $currentUser->hasRole('Therapist')){{ route('therapist.profile.index') }}@elseif($currentUser && $currentUser->hasRole('Client')){{ route('client.profile.index') }}@else{{ route('admin.profile.index') }}@endif">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-2">
                      <div class="avatar avatar-online">
                        @if($currentUser)
                          @if($currentUser->hasRole('Therapist') && $currentUser->therapistProfile && $currentUser->therapistProfile->profile_image)
                            <img src="{{ asset('storage/' . $currentUser->therapistProfile->profile_image) }}" alt="{{ $currentUser->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #e9ecef;">
                          @elseif($currentUser->hasRole('Client') && $currentUser->profile && $currentUser->profile->profile_image)
                            <img src="{{ asset('storage/' . $currentUser->profile->profile_image) }}" alt="{{ $currentUser->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #e9ecef;">
                          @elseif($currentUser->getRawOriginal('avatar'))
                            <img src="{{ asset('storage/' . $currentUser->getRawOriginal('avatar')) }}" alt="{{ $currentUser->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #e9ecef;">
                          @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($currentUser->name) }}&background=667eea&color=fff&size=80&bold=true&format=svg" alt="{{ $currentUser->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #e9ecef;">
                          @endif
                        @else
                          <span class="avatar-initial rounded-circle bg-primary" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 600;">
                            NA
                          </span>
                        @endif
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <h6 class="mb-0 small fw-semibold">{{ $currentUser ? $currentUser->name : 'Guest' }}</h6>
                      <small class="text-muted">
                        @if($currentUser && $currentUser->roles->count() > 0)
                          {{ $currentUser->roles->first()->name }}
                        @else
                          User
                        @endif
                      </small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <div class="dropdown-divider my-1"></div>
              </li>
              <li>
                @if($currentUser && $currentUser->hasRole('Therapist'))
                  <a class="dropdown-item" href="{{ route('therapist.profile.index') }}">
                    <i class="ri-user-3-line ri-22px me-2"></i>
                    <span class="align-middle">My Profile</span>
                  </a>
                @elseif($currentUser && $currentUser->hasRole('Client'))
                  <a class="dropdown-item" href="{{ route('client.profile.index') }}">
                    <i class="ri-user-3-line ri-22px me-2"></i>
                    <span class="align-middle">My Profile</span>
                  </a>
                @else
                  <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                    <i class="ri-user-3-line ri-22px me-2"></i>
                    <span class="align-middle">My Profile</span>
                  </a>
                @endif
              </li>
              <li>
                @if($currentUser && ($currentUser->hasRole('SuperAdmin') || $currentUser->hasRole('Admin')))
                  <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                    <i class='ri-settings-4-line ri-22px me-2'></i>
                    <span class="align-middle">Settings</span>
                  </a>
                @elseif($currentUser && $currentUser->hasRole('Therapist'))
                  <a class="dropdown-item" href="{{ route('therapist.profile.index') }}">
                    <i class='ri-settings-4-line ri-22px me-2'></i>
                    <span class="align-middle">Settings</span>
                  </a>
                @elseif($currentUser && $currentUser->hasRole('Client'))
                  <a class="dropdown-item" href="{{ route('client.wallet.index') }}">
                    <i class='ri-wallet-3-line ri-22px me-2'></i>
                    <span class="align-middle">My Wallet</span>
                  </a>
                @endif
              </li>
              @if($currentUser && ($currentUser->hasRole('SuperAdmin') || $currentUser->hasRole('Admin')))
              <li>
                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                  <i class="ri-dashboard-line ri-22px me-2"></i>
                  <span class="align-middle">Dashboard</span>
                </a>
              </li>
              @endif
              <li>
                <a class="dropdown-item" href="{{ url('/') }}" target="_blank">
                  <i class="ri-global-line ri-22px me-2"></i>
                  <span class="align-middle">Visit Website</span>
                </a>
              </li>
              <li>
                <div class="dropdown-divider my-1"></div>
              </li>
              <li>
                @if($currentUser && ($currentUser->hasRole('SuperAdmin') || $currentUser->hasRole('Admin')))
                  <form method="POST" action="{{ route('admin.logout') }}" class="d-grid px-4 pt-2 pb-1">
                    @csrf
                    <button type="submit" class="btn btn-danger d-flex w-100 justify-content-center align-items-center">
                      <small class="align-middle">Logout</small>
                      <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                    </button>
                  </form>
                @else
                  <form method="POST" action="{{ route('logout') }}" class="d-grid px-4 pt-2 pb-1">
                    @csrf
                    <button type="submit" class="btn btn-danger d-flex w-100 justify-content-center align-items-center">
                      <small class="align-middle">Logout</small>
                      <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                    </button>
                  </form>
                @endif
              </li>
            </ul>
          </li>
          <!--/ User -->
        </ul>
      </div>

      @if(!isset($navbarDetached))
    </div>
    @endif
  </nav>
  <!-- / Navbar -->
