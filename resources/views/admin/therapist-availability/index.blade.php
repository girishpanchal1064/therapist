@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Therapist Availability')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Select Therapist to Manage Availability</h5>
      </div>
      <div class="card-body">
        @if(session('error'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Therapist Name</th>
                <th>Email</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($therapists as $index => $therapist)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    <div class="d-flex align-items-center">
                      @if($therapist->therapistProfile && $therapist->therapistProfile->profile_image)
                        <img src="{{ asset('storage/' . $therapist->therapistProfile->profile_image) }}" 
                             alt="{{ $therapist->name }}" 
                             class="rounded-circle me-2" 
                             width="40" 
                             height="40"
                             style="object-fit: cover;">
                      @elseif($therapist->getRawOriginal('avatar'))
                        <img src="{{ asset('storage/' . $therapist->getRawOriginal('avatar')) }}" 
                             alt="{{ $therapist->name }}" 
                             class="rounded-circle me-2" 
                             width="40" 
                             height="40"
                             style="object-fit: cover;">
                      @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($therapist->name) }}&background=667eea&color=fff&size=80&bold=true&format=svg" 
                             alt="{{ $therapist->name }}" 
                             class="rounded-circle me-2" 
                             width="40" 
                             height="40"
                             style="object-fit: cover;">
                      @endif
                      <span>{{ $therapist->name }}</span>
                    </div>
                  </td>
                  <td>{{ $therapist->email }}</td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        Manage Availability
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.therapist-availability.set', ['therapist_id' => $therapist->id]) }}">
                          <i class="ri-calendar-line me-1"></i> Set Availability
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.therapist-availability.single', ['therapist_id' => $therapist->id]) }}">
                          <i class="ri-calendar-check-line me-1"></i> Single Availability
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.therapist-availability.block', ['therapist_id' => $therapist->id]) }}">
                          <i class="ri-calendar-close-line me-1"></i> Block Availability
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted py-4">No therapists found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
