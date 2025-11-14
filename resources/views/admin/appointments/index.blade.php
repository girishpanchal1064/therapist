@extends('layouts/contentNavbarLayout')

@section('title', 'Appointments Management')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">All Appointments</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.appointments.today') }}" class="btn btn-outline-primary">
            <i class="ri-calendar-todo-line me-1"></i> Today's Appointments
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

        <!-- Filters -->
        <div class="row mb-4">
          <div class="col-md-4">
            <form method="GET" action="{{ route('admin.appointments.index') }}" class="d-flex gap-2">
              <input type="text" 
                     name="search" 
                     class="form-control" 
                     placeholder="Search by client, therapist, or meeting ID..." 
                     value="{{ $search }}">
              <button type="submit" class="btn btn-outline-primary">
                <i class="ri-search-line"></i>
              </button>
              @if($search)
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
                  <i class="ri-close-line"></i>
                </a>
              @endif
            </form>
          </div>
          <div class="col-md-2">
            <form method="GET" action="{{ route('admin.appointments.index') }}" id="statusForm">
              <input type="hidden" name="search" value="{{ $search }}">
              <input type="hidden" name="type" value="{{ $type }}">
              <input type="hidden" name="mode" value="{{ $mode }}">
              <select name="status" class="form-select" onchange="document.getElementById('statusForm').submit();">
                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                <option value="scheduled" {{ $status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="in_progress" {{ $status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="no_show" {{ $status === 'no_show' ? 'selected' : '' }}>No Show</option>
              </select>
            </form>
          </div>
          <div class="col-md-2">
            <form method="GET" action="{{ route('admin.appointments.index') }}" id="typeForm">
              <input type="hidden" name="search" value="{{ $search }}">
              <input type="hidden" name="status" value="{{ $status }}">
              <input type="hidden" name="mode" value="{{ $mode }}">
              <select name="type" class="form-select" onchange="document.getElementById('typeForm').submit();">
                <option value="all" {{ $type === 'all' ? 'selected' : '' }}>All Types</option>
                <option value="individual" {{ $type === 'individual' ? 'selected' : '' }}>Individual</option>
                <option value="couple" {{ $type === 'couple' ? 'selected' : '' }}>Couple</option>
                <option value="family" {{ $type === 'family' ? 'selected' : '' }}>Family</option>
              </select>
            </form>
          </div>
          <div class="col-md-2">
            <form method="GET" action="{{ route('admin.appointments.index') }}" id="modeForm">
              <input type="hidden" name="search" value="{{ $search }}">
              <input type="hidden" name="status" value="{{ $status }}">
              <input type="hidden" name="type" value="{{ $type }}">
              <select name="mode" class="form-select" onchange="document.getElementById('modeForm').submit();">
                <option value="all" {{ $mode === 'all' ? 'selected' : '' }}>All Modes</option>
                <option value="video" {{ $mode === 'video' ? 'selected' : '' }}>Video</option>
                <option value="audio" {{ $mode === 'audio' ? 'selected' : '' }}>Audio</option>
                <option value="chat" {{ $mode === 'chat' ? 'selected' : '' }}>Chat</option>
              </select>
            </form>
          </div>
          <div class="col-md-2">
            <form method="GET" action="{{ route('admin.appointments.index') }}" id="perPageForm">
              <input type="hidden" name="search" value="{{ $search }}">
              <input type="hidden" name="status" value="{{ $status }}">
              <input type="hidden" name="type" value="{{ $type }}">
              <input type="hidden" name="mode" value="{{ $mode }}">
              <select name="per_page" class="form-select" onchange="document.getElementById('perPageForm').submit();">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 per page</option>
                <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 per page</option>
                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 per page</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 per page</option>
              </select>
            </form>
          </div>
        </div>

        <!-- Appointments Table -->
        @if($appointments->count() > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Client</th>
                  <th>Therapist</th>
                  <th>Date & Time</th>
                  <th>Type</th>
                  <th>Mode</th>
                  <th>Duration</th>
                  <th>Status</th>
                  <th>Payment</th>
                  <th style="width: 120px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($appointments as $appointment)
                  <tr>
                    <td>
                      <span class="text-muted">#{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</span>
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
                      <div class="fw-semibold">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                      <small class="text-muted">{{ date('g:i A', strtotime($appointment->appointment_time)) }}</small>
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
                          <div class="dropdown-divider"></div>
                          <form action="{{ route('admin.appointments.destroy', $appointment) }}" 
                                method="POST" 
                                class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger">
                              <i class="ri-delete-bin-line me-1"></i> Delete
                            </button>
                          </form>
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
              Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }} of {{ $appointments->total() }} appointments
            </div>
            <div>
              {{ $appointments->links() }}
            </div>
          </div>
        @else
          <div class="text-center py-5">
            <i class="ri-calendar-close-line" style="font-size: 4rem; color: #d1d5db;"></i>
            <h5 class="mt-3 text-muted">No appointments found</h5>
            <p class="text-muted">
              @if($search || $status !== 'all' || $type !== 'all' || $mode !== 'all')
                Try adjusting your filters to see more results.
              @else
                Get started by creating a new appointment.
              @endif
            </p>
            @if(!$search && $status === 'all' && $type === 'all' && $mode === 'all')
              <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary mt-2">
                <i class="ri-add-line me-1"></i> Create New Appointment
              </a>
            @endif
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
