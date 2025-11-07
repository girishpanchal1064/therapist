@extends('layouts/contentNavbarLayout')

@section('title', 'Pending Therapists')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Pending Therapists Approval</h5>
        <a href="{{ route('admin.therapists.index') }}" class="btn btn-outline-secondary">
          <i class="ri-arrow-left-line me-2"></i>Back to All Therapists
        </a>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

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
                <th>Avatar</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Specializations</th>
                <th>Experience</th>
                <th>Rate</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($therapists as $therapist)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    @if($therapist->avatar)
                      <div class="avatar avatar-sm me-2">
                        <img src="{{ asset('storage/' . $therapist->avatar) }}" alt="Avatar" class="rounded-circle" width="32" height="32">
                      </div>
                    @else
                      <div class="avatar avatar-sm me-2">
                        <span class="avatar-initial rounded bg-label-primary">{{ strtoupper(substr($therapist->name, 0, 2)) }}</span>
                      </div>
                    @endif
                  </td>
                  <td>{{ $therapist->name }}</td>
                  <td>{{ $therapist->email }}</td>
                  <td>{{ $therapist->phone ?: 'Not set' }}</td>
                  <td>
                    @if($therapist->therapistProfile && $therapist->therapistProfile->specializations->count() > 0)
                      @foreach($therapist->therapistProfile->specializations as $specialization)
                        <span class="badge bg-info me-1">{{ $specialization->name }}</span>
                      @endforeach
                    @else
                      <span class="text-muted">No specializations</span>
                    @endif
                  </td>
                  <td>
                    @if($therapist->therapistProfile)
                      {{ $therapist->therapistProfile->experience_years ?? 0 }} years
                    @else
                      <span class="text-muted">Not set</span>
                    @endif
                  </td>
                  <td>
                    @if($therapist->therapistProfile)
                      ₹{{ number_format($therapist->therapistProfile->consultation_fee ?? 0, 2) }}
                    @else
                      <span class="text-muted">Not set</span>
                    @endif
                  </td>
                  <td>
                    <span class="badge bg-warning">
                      Pending Approval
                    </span>
                  </td>
                  <td>{{ $therapist->created_at->format('M d, Y') }}</td>
                  <td>
                    <div class="d-flex gap-2">
                      <a class="btn btn-sm btn-primary" href="{{ route('admin.therapists.show', $therapist) }}">
                        <i class="ri-eye-line"></i> View
                      </a>
                      <form action="{{ route('admin.therapists.approve', $therapist) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to approve this therapist?')">
                          <i class="ri-check-line"></i> Approve
                        </button>
                      </form>
                      <form action="{{ route('admin.therapists.reject', $therapist) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to reject this therapist?')">
                          <i class="ri-close-line"></i> Reject
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="11" class="text-center py-4">
                    <div class="text-muted">
                      <i class="ri-inbox-line" style="font-size: 3rem;"></i>
                      <p class="mt-2">No pending therapists found.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if($therapists->hasPages())
          <div class="d-flex justify-content-center mt-4">
            {{ $therapists->links() }}
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
