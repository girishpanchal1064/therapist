@extends('layouts/contentNavbarLayout')

@section('title', "Today's Appointments")

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Today's Appointments - {{ date('F d, Y') }}</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
            <i class="ri-arrow-left-line me-1"></i> All Appointments
          </a>
          <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> New Appointment
          </a>
        </div>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row mb-4">
          <div class="col-md-3">
            <div class="card bg-label-primary">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <i class="ri-calendar-todo-line fs-1 text-primary"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <div class="small text-muted">Total Today</div>
                    <div class="h4 mb-0">{{ $appointments->total() }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card bg-label-success">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <i class="ri-checkbox-circle-line fs-1 text-success"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <div class="small text-muted">Completed</div>
                    <div class="h4 mb-0">{{ $appointments->where('status', 'completed')->count() }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card bg-label-warning">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <i class="ri-time-line fs-1 text-warning"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <div class="small text-muted">Upcoming</div>
                    <div class="h4 mb-0">{{ $appointments->whereIn('status', ['scheduled', 'confirmed', 'in_progress'])->count() }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card bg-label-danger">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <i class="ri-close-circle-line fs-1 text-danger"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <div class="small text-muted">Cancelled</div>
                    <div class="h4 mb-0">{{ $appointments->where('status', 'cancelled')->count() }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Appointments Table -->
        @if($appointments->count() > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Time</th>
                  <th>Client</th>
                  <th>Therapist</th>
                  <th>Type</th>
                  <th>Mode</th>
                  <th>Duration</th>
                  <th>Status</th>
                  <th>Payment</th>
                  <th style="width: 120px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($appointments->sortBy('appointment_time') as $appointment)
                  <tr>
                    <td>
                      <div class="fw-semibold">{{ date('g:i A', strtotime($appointment->appointment_time)) }}</div>
                      <small class="text-muted">{{ $appointment->duration_minutes }} min</small>
                    </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="avatar-initial rounded-circle bg-label-primary me-2 d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px; font-size: 0.875rem;">
                          {{ strtoupper(substr($appointment->client->name ?? 'N/A', 0, 2)) }}
                        </div>
                        <div>
                          <div class="fw-semibold">{{ $appointment->client->name ?? 'N/A' }}</div>
                          <small class="text-muted">{{ $appointment->client->email ?? 'N/A' }}</small>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="avatar-initial rounded-circle bg-label-success me-2 d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px; font-size: 0.875rem;">
                          {{ strtoupper(substr($appointment->therapist->name ?? 'N/A', 0, 2)) }}
                        </div>
                        <div>
                          <div class="fw-semibold">{{ $appointment->therapist->name ?? 'N/A' }}</div>
                          <small class="text-muted">{{ $appointment->therapist->email ?? 'N/A' }}</small>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="badge bg-label-info text-capitalize">{{ $appointment->appointment_type }}</span>
                    </td>
                    <td>
                      @php
                        $modeIcons = [
                          'video' => 'ri-video-line',
                          'audio' => 'ri-phone-line',
                          'chat' => 'ri-message-3-line'
                        ];
                        $modeColors = [
                          'video' => 'primary',
                          'audio' => 'success',
                          'chat' => 'warning'
                        ];
                      @endphp
                      <span class="badge bg-label-{{ $modeColors[$appointment->session_mode] ?? 'secondary' }}">
                        <i class="{{ $modeIcons[$appointment->session_mode] ?? 'ri-circle-line' }} me-1"></i>
                        {{ ucfirst($appointment->session_mode) }}
                      </span>
                    </td>
                    <td>
                      <span class="text-muted">{{ $appointment->duration_minutes }} min</span>
                    </td>
                    <td>
                      @php
                        $statusColors = [
                          'scheduled' => 'primary',
                          'confirmed' => 'success',
                          'in_progress' => 'warning',
                          'completed' => 'secondary',
                          'cancelled' => 'danger',
                          'no_show' => 'warning'
                        ];
                        $statusLabels = [
                          'scheduled' => 'Scheduled',
                          'confirmed' => 'Confirmed',
                          'in_progress' => 'In Progress',
                          'completed' => 'Completed',
                          'cancelled' => 'Cancelled',
                          'no_show' => 'No Show'
                        ];
                      @endphp
                      <span class="badge bg-label-{{ $statusColors[$appointment->status] ?? 'secondary' }}">
                        {{ $statusLabels[$appointment->status] ?? ucfirst($appointment->status) }}
                      </span>
                    </td>
                    <td>
                      @if($appointment->payment)
                        <span class="badge bg-label-success">
                          <i class="ri-checkbox-circle-line me-1"></i> Paid
                        </span>
                      @else
                        <span class="badge bg-label-warning">
                          <i class="ri-close-circle-line me-1"></i> Unpaid
                        </span>
                      @endif
                    </td>
                    <td>
                      <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                          <i class="ri-more-2-line"></i>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="{{ route('admin.appointments.show', $appointment) }}">
                            <i class="ri-eye-line me-1"></i> View Details
                          </a>
                          <a class="dropdown-item" href="{{ route('admin.appointments.edit', $appointment) }}">
                            <i class="ri-pencil-line me-1"></i> Edit
                          </a>
                          @if(in_array($appointment->status, ['scheduled', 'confirmed']))
                            <form action="{{ route('admin.appointments.complete', $appointment) }}" 
                                  method="POST" 
                                  class="d-inline">
                              @csrf
                              <button type="submit" class="dropdown-item text-success">
                                <i class="ri-checkbox-circle-line me-1"></i> Mark Complete
                              </button>
                            </form>
                            <form action="{{ route('admin.appointments.cancel', $appointment) }}" 
                                  method="POST" 
                                  class="d-inline">
                              @csrf
                              <button type="submit" class="dropdown-item text-danger">
                                <i class="ri-close-circle-line me-1"></i> Cancel
                              </button>
                            </form>
                          @endif
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          @if($appointments->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
              <div>
                Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }} of {{ $appointments->total() }} appointments
              </div>
              <div>
                {{ $appointments->links() }}
              </div>
            </div>
          @endif
        @else
          <div class="text-center py-5">
            <i class="ri-calendar-close-line" style="font-size: 4rem; color: #d1d5db;"></i>
            <h5 class="mt-3 text-muted">No appointments scheduled for today</h5>
            <p class="text-muted">There are no appointments scheduled for {{ date('F d, Y') }}.</p>
            <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary mt-2">
              <i class="ri-add-line me-1"></i> Create New Appointment
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
