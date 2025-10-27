@extends('layouts/contentNavbarLayout')

@section('title', 'Therapist Details')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Therapist Details</h5>
        <div>
          <a href="{{ route('admin.therapists.edit', $therapist) }}" class="btn btn-primary me-2">
            <i class="ri-pencil-line me-1"></i>Edit
          </a>
          <a href="{{ route('admin.therapists.index') }}" class="btn btn-secondary">
            <i class="ri-arrow-left-line me-1"></i>Back to List
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- Profile Information -->
          <div class="col-md-4">
            <div class="card">
              <div class="card-body text-center">
                @if($therapist->avatar)
                  <img src="{{ asset('storage/' . $therapist->avatar) }}" alt="Avatar" class="rounded-circle mb-3" width="120" height="120">
                @else
                  <div class="avatar avatar-xl mb-3">
                    <span class="avatar-initial rounded bg-label-primary" style="font-size: 3rem;">{{ strtoupper(substr($therapist->name, 0, 2)) }}</span>
                  </div>
                @endif

                <h4 class="mb-1">{{ $therapist->name }}</h4>
                <p class="text-muted mb-3">{{ $therapist->email }}</p>

                <span class="badge bg-{{ $therapist->status === 'active' ? 'success' : ($therapist->status === 'suspended' ? 'danger' : 'secondary') }} fs-6">
                  {{ ucfirst($therapist->status ?: 'inactive') }}
                </span>
              </div>
            </div>

            <!-- Contact Information -->
            <div class="card mt-3">
              <div class="card-header">
                <h6 class="mb-0">Contact Information</h6>
              </div>
              <div class="card-body">
                <div class="mb-2">
                  <strong>Email:</strong><br>
                  <a href="mailto:{{ $therapist->email }}">{{ $therapist->email }}</a>
                </div>
                <div class="mb-2">
                  <strong>Phone:</strong><br>
                  {{ $therapist->phone ?: 'Not provided' }}
                </div>
                <div class="mb-0">
                  <strong>Member Since:</strong><br>
                  {{ $therapist->created_at->format('M d, Y') }}
                </div>
              </div>
            </div>
          </div>

          <!-- Detailed Information -->
          <div class="col-md-8">
            <!-- Professional Information -->
            <div class="card mb-4">
              <div class="card-header">
                <h6 class="mb-0">Professional Information</h6>
              </div>
              <div class="card-body">
                @if($therapist->therapistProfile)
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <strong>Experience:</strong><br>
                        {{ $therapist->therapistProfile->experience_years }} years
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <strong>Hourly Rate:</strong><br>
                        ${{ number_format($therapist->therapistProfile->hourly_rate, 2) }}/hour
                      </div>
                    </div>
                  </div>

                  <div class="mb-3">
                    <strong>Bio:</strong><br>
                    <p class="mt-2">{{ $therapist->therapistProfile->bio ?: 'No bio provided' }}</p>
                  </div>

                  @if($therapist->therapistProfile->certifications)
                    <div class="mb-3">
                      <strong>Certifications:</strong><br>
                      <p class="mt-2">{{ $therapist->therapistProfile->certifications }}</p>
                    </div>
                  @endif

                  @if($therapist->therapistProfile->education)
                    <div class="mb-3">
                      <strong>Education:</strong><br>
                      <p class="mt-2">{{ $therapist->therapistProfile->education }}</p>
                    </div>
                  @endif
                @else
                  <div class="alert alert-warning">
                    <i class="ri-alert-line me-2"></i>
                    No therapist profile found. Please create a therapist profile.
                  </div>
                @endif
              </div>
            </div>

            <!-- Specializations -->
            <div class="card mb-4">
              <div class="card-header">
                <h6 class="mb-0">Specializations</h6>
              </div>
              <div class="card-body">
                @if($therapist->therapistProfile && $therapist->therapistProfile->specializations->count() > 0)
                  <div class="d-flex flex-wrap gap-2">
                    @foreach($therapist->therapistProfile->specializations as $specialization)
                      <span class="badge bg-primary fs-6">{{ $specialization->name }}</span>
                    @endforeach
                  </div>
                @else
                  <p class="text-muted mb-0">No specializations assigned</p>
                @endif
              </div>
            </div>

            <!-- Recent Appointments -->
            <div class="card">
              <div class="card-header">
                <h6 class="mb-0">Recent Appointments</h6>
              </div>
              <div class="card-body">
                @if($therapist->appointmentsAsTherapist && $therapist->appointmentsAsTherapist->count() > 0)
                  <div class="table-responsive">
                    <table class="table table-sm">
                      <thead>
                        <tr>
                          <th>Client</th>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($therapist->appointmentsAsTherapist->take(5) as $appointment)
                          <tr>
                            <td>{{ $appointment->client->name ?? 'N/A' }}</td>
                            <td>{{ $appointment->appointment_date ? $appointment->appointment_date->format('M d, Y') : 'N/A' }}</td>
                            <td>{{ $appointment->appointment_time ?? 'N/A' }}</td>
                            <td>
                              <span class="badge bg-{{ $appointment->status === 'completed' ? 'success' : ($appointment->status === 'scheduled' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($appointment->status) }}
                              </span>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @else
                  <p class="text-muted mb-0">No appointments found</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
