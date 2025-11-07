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
                      @if($therapist->avatar)
                        <img src="{{ asset('storage/' . $therapist->avatar) }}" 
                             alt="{{ $therapist->name }}" 
                             class="rounded-circle me-2" 
                             width="32" 
                             height="32">
                      @else
                        <div class="avatar-initial rounded-circle bg-label-primary me-2 d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px;">
                          {{ strtoupper(substr($therapist->name, 0, 2)) }}
                        </div>
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
