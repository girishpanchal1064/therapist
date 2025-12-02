@extends('layouts/contentNavbarLayout')

@section('title', 'Set Availability (Week wise)')

@section('page-style')
<style>
  /* Page Header */
  .availability-page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
  }

  .availability-page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  .availability-page-header::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
  }

  .availability-page-header h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
  }

  .availability-page-header p {
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 0;
    position: relative;
    z-index: 1;
  }

  .header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: white;
    backdrop-filter: blur(10px);
  }

  /* Main Card */
  .availability-main-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
  }

  .availability-main-card .card-header {
    background: white;
    border-bottom: 2px solid #f0f2f5;
    padding: 1.5rem;
  }

  .availability-main-card .card-body {
    padding: 1.5rem;
  }

  /* Add Button */
  .btn-add-availability {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }

  .btn-add-availability:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
  }

  /* Table Styles */
  .availability-table {
    border-collapse: separate;
    border-spacing: 0;
  }

  .availability-table thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 600;
    font-size: 0.8125rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem 1.25rem;
    border: none;
    white-space: nowrap;
  }

  .availability-table thead th:first-child {
    border-radius: 10px 0 0 10px;
  }

  .availability-table thead th:last-child {
    border-radius: 0 10px 10px 0;
  }

  .availability-table tbody tr {
    transition: all 0.2s ease;
  }

  .availability-table tbody tr:hover {
    background: #f8fafc;
  }

  .availability-table tbody td {
    padding: 1.25rem;
    vertical-align: middle;
    border-bottom: 1px solid #f0f2f5;
  }

  /* Schedule Info */
  .schedule-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .schedule-days {
    display: flex;
    flex-wrap: wrap;
    gap: 0.375rem;
  }

  .day-badge {
    background: linear-gradient(135deg, #e8f0fe 0%, #d4e4fc 100%);
    color: #1a73e8;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
  }

  .schedule-times {
    display: flex;
    flex-wrap: wrap;
    gap: 0.375rem;
    margin-top: 0.25rem;
  }

  .time-badge {
    background: #f0fdf4;
    color: #15803d;
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    border: 1px solid #bbf7d0;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
  }

  .time-badge i {
    font-size: 0.875rem;
  }

  /* Mode Badge */
  .mode-badge {
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
  }

  .mode-badge.online {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
  }

  .mode-badge.offline {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
  }

  /* Type Badge */
  .type-badge {
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
    background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
    color: #7c3aed;
  }

  /* Timezone */
  .timezone-info {
    color: #64748b;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
  }

  .timezone-info i {
    color: #94a3b8;
  }

  /* Action Buttons */
  .action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  .btn-action {
    padding: 0.5rem 0.875rem;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    transition: all 0.2s ease;
    border: none;
  }

  .btn-action.btn-edit {
    background: #eff6ff;
    color: #2563eb;
  }

  .btn-action.btn-edit:hover {
    background: #dbeafe;
    transform: translateY(-1px);
  }

  .btn-action.btn-delete {
    background: #fef2f2;
    color: #dc2626;
  }

  .btn-action.btn-delete:hover {
    background: #fee2e2;
    transform: translateY(-1px);
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
  }

  .empty-state-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.5rem;
    color: #667eea;
  }

  .empty-state h5 {
    color: #1e293b;
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  .empty-state p {
    color: #64748b;
    margin-bottom: 1.5rem;
  }

  /* Alert Styling */
  .alert-success {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 1px solid #86efac;
    color: #166534;
    border-radius: 12px;
    padding: 1rem 1.25rem;
  }

  /* Modal Header with Gradient */
  .availability-modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 1.5rem 1.75rem;
    border-radius: 0.5rem 0.5rem 0 0;
  }

  .availability-icon-wrapper {
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    backdrop-filter: blur(10px);
  }

  .availability-modal-header .modal-title {
    font-size: 1.25rem;
    letter-spacing: -0.02em;
  }

  .availability-modal-header small {
    font-size: 0.875rem;
    display: block;
    margin-top: 0.25rem;
  }

  /* Modal Body */
  .availability-modal-body {
    padding: 2rem 2rem;
    background: #f8f9fa;
  }

  #groups-wrapper {
    margin-top: 0;
    margin-bottom: 0;
  }

  .availability-group {
    margin-top: 0;
    margin-bottom: 1.5rem;
  }

  .availability-group:first-child {
    margin-top: 0;
  }

  .availability-group:last-child {
    margin-bottom: 0;
  }

  /* Availability Card */
  .availability-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 1px 3px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    overflow: hidden;
  }

  .availability-card:hover {
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);
    transform: translateY(-2px);
  }

  .availability-card-header {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    border-bottom: 2px solid #e9ecef;
    padding: 1rem 1.25rem;
    border-radius: 12px 12px 0 0;
  }

  .availability-card-header h6 {
    color: #2d3748;
    font-size: 1rem;
  }

  .availability-card .card-body {
    padding: 1.5rem;
    background: #ffffff;
  }

  /* Days Selection */
  .days-selection-wrapper {
    background: #f8f9fa;
    padding: 1.25rem;
    border-radius: 10px;
    border: 1px solid #e9ecef;
  }

  .days-switch-container {
    display: flex;
    flex-wrap: nowrap;
    gap: 0.75rem;
    align-items: center;
    overflow-x: auto;
  }

  .days-switch-container::-webkit-scrollbar {
    height: 4px;
  }

  .days-switch-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
  }

  .days-switch-container::-webkit-scrollbar-thumb {
    background: #667eea;
    border-radius: 4px;
  }

  .day-switch-item {
    background: white;
    padding: 0.625rem 0.875rem;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    transition: all 0.2s ease;
    white-space: nowrap;
    flex-shrink: 0;
    min-width: fit-content;
  }

  .day-switch-item:hover {
    border-color: #667eea;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.1);
  }

  .day-switch-item .form-switch {
    margin: 0;
  }

  .form-switch .form-check-input {
    width: 3rem;
    height: 1.5rem;
    margin-top: 0.125rem;
    cursor: pointer;
    background-color: #dee2e6;
    border-color: #dee2e6;
    transition: all 0.3s ease;
  }

  .form-switch .form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
  }

  .form-switch .form-check-input:focus {
    border-color: #667eea;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
  }

  .form-switch .form-check-label {
    margin-left: 0.75rem;
    font-weight: 500;
    cursor: pointer;
    color: #2d3748;
    font-size: 0.9375rem;
  }

  /* Time Slots */
  .time-slots-wrapper {
    background: #f8f9fa;
    padding: 1.25rem;
    border-radius: 10px;
    border: 1px solid #e9ecef;
  }

  .slot-card {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    transition: all 0.2s ease;
    height: 100%;
  }

  .slot-card:hover {
    border-color: #667eea;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
  }

  .slot-number {
    color: #667eea;
    font-weight: 600;
  }

  .slot-card .form-select {
    border-radius: 6px;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
  }

  .slot-card .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
  }

  /* Buttons */
  .add-more-timing-btn {
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-weight: 500;
    transition: all 0.2s ease;
    border: 1.5px solid #667eea;
    color: #667eea;
  }

  .add-more-timing-btn:hover {
    background: #667eea;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
  }

  #add-group {
    border-radius: 8px;
    padding: 0.625rem 1.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  #add-group:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.2);
  }

  /* Modal Footer */
  .availability-modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 1.5rem 2rem;
    background: #f8f9fa;
    border-radius: 0 0 0.5rem 0.5rem;
    margin-top: 0;
  }

  /* Ensure consistent spacing throughout modal */
  #editAvailabilityModal .modal-content {
    border-radius: 0.5rem;
  }

  #editAvailabilityModal .modal-body {
    margin-top: 0;
    margin-bottom: 0;
  }

  /* Make modal bigger */
  .availability-modal-dialog {
    max-width: 95%;
    width: 95%;
  }

  @media (min-width: 1200px) {
    .availability-modal-dialog {
      max-width: 90%;
      width: 90%;
    }
  }

  @media (min-width: 1400px) {
    .availability-modal-dialog {
      max-width: 85%;
      width: 85%;
    }
  }

  #editAvailabilityModal .modal-content {
    min-height: 80vh;
  }

  .availability-modal-footer .btn {
    border-radius: 8px;
    padding: 0.625rem 1.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .availability-modal-footer .btn-light {
    background: white;
    border: 1px solid #dee2e6;
    color: #6c757d;
  }

  .availability-modal-footer .btn-light:hover {
    background: #f8f9fa;
    border-color: #adb5bd;
    color: #495057;
  }

  .btn-save {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);
  }

  .btn-save:hover {
    background: linear-gradient(135deg, #5568d3 0%, #653a8f 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(102, 126, 234, 0.4);
    color: white;
  }

  /* Form Labels */
  .availability-modal-body .form-label {
    color: #2d3748;
    font-size: 0.9375rem;
  }

  .availability-modal-body .form-label i {
    font-size: 1.125rem;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .availability-modal-body {
      padding: 1.5rem;
    }

    .days-switch-container {
      grid-template-columns: 1fr;
    }

    .availability-page-header {
      padding: 1.5rem;
    }

    .action-buttons {
      flex-direction: column;
    }
  }
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ri-checkbox-circle-line me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <!-- Page Header -->
    <div class="availability-page-header">
      <div class="d-flex align-items-center gap-3">
        <div class="header-icon">
          <i class="ri-calendar-schedule-line"></i>
        </div>
        <div>
          <h4 class="mb-1">Weekly Availability</h4>
          <p class="mb-0">Set your recurring weekly schedule for client sessions</p>
        </div>
      </div>
    </div>

    <!-- Main Card -->
    <div class="card availability-main-card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-1">Your Availability Schedule</h5>
          <p class="text-muted mb-0 small">Manage your weekly recurring time slots</p>
        </div>
        <button type="button" class="btn btn-add-availability" data-bs-toggle="modal" data-bs-target="#editAvailabilityModal">
          <i class="ri-add-line me-1"></i> Add Availability
        </button>
      </div>
      <div class="card-body">
        @if($availabilities->count() > 0)
          <div class="table-responsive">
            <table class="table availability-table mb-0">
              <thead>
                <tr>
                  <th>Schedule (Days + Time)</th>
                  <th>Mode</th>
                  <th>Type</th>
                  <th>Timezone</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($availabilities as $availability)
                  <tr>
                    <td>
                      <div class="schedule-info">
                        <div class="schedule-days">
                          @foreach($availability->days as $day)
                            <span class="day-badge">{{ ucfirst($day) }}</span>
                          @endforeach
                        </div>
                        <div class="schedule-times">
                          @foreach($availability->slots as $slot)
                            <span class="time-badge">
                              <i class="ri-time-line"></i>
                              {{ $slot['start'] }} - {{ $slot['end'] }}
                            </span>
                          @endforeach
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="mode-badge {{ $availability->mode }}">
                        <i class="ri-{{ $availability->mode === 'online' ? 'global-line' : 'building-line' }} me-1"></i>
                        {{ $availability->mode }}
                      </span>
                    </td>
                    <td>
                      <span class="type-badge">
                        <i class="ri-repeat-line me-1"></i>
                        {{ $availability->type }}
                      </span>
                    </td>
                    <td>
                      <div class="timezone-info">
                        <i class="ri-earth-line"></i>
                        {{ $availability->timezone ?? 'Not Set' }}
                      </div>
                    </td>
                    <td>
                      <div class="action-buttons">
                        <button type="button" class="btn btn-action btn-edit edit-availability-btn" 
                          data-availability-id="{{ $availability->id }}" 
                          data-availability-data="{{ json_encode([
                            'id' => $availability->id,
                            'days' => $availability->days,
                            'slots' => $availability->slots,
                            'mode' => $availability->mode,
                            'type' => $availability->type,
                            'timezone' => $availability->timezone
                          ]) }}">
                          <i class="ri-edit-line"></i> Edit
                        </button>
                        <form method="POST" action="{{ route('therapist.availability.set.destroy', $availability) }}" onsubmit="return confirm('Are you sure you want to delete this availability?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-action btn-delete">
                            <i class="ri-delete-bin-line"></i> Delete
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="empty-state">
            <div class="empty-state-icon">
              <i class="ri-calendar-schedule-line"></i>
            </div>
            <h5>No Weekly Availability Set</h5>
            <p>Start by adding your weekly recurring schedule to let clients know when you're available.</p>
            <button type="button" class="btn btn-add-availability" data-bs-toggle="modal" data-bs-target="#editAvailabilityModal">
              <i class="ri-add-line me-1"></i> Add Your First Availability
            </button>
          </div>
        @endif
      </div>
    </div>

    <!-- Edit Availability Modal -->
    <div class="modal fade" id="editAvailabilityModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen-lg-down availability-modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <!-- Modal Header with Gradient Background -->
          <div class="modal-header text-white availability-modal-header">
            <div class="d-flex align-items-center">
              <div>
                <h5 class="modal-title mb-0 fw-bold" style="padding-bottom: 1rem;">Edit Availability</h5>
              </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body availability-modal-body">
            <form method="POST" action="{{ route('therapist.availability.set.store') }}" id="set-availability-form">
              @csrf
              <input type="hidden" name="_method" id="form-method" value="POST">
              <input type="hidden" name="availability_id" id="availability-id" value="">

              <div id="groups-wrapper">
                <!-- Group Template (first group) -->
                <div class="availability-group card availability-card">
                  <div class="card-header availability-card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                      <i class="ri-time-line me-2 text-primary"></i>
                      <h6 class="mb-0 fw-semibold">Availability Group 1</h6>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-group d-none">
                      <i class="ri-delete-bin-line me-1"></i> Remove
                    </button>
                  </div>
                  <div class="card-body">
                    <!-- Days Selection with Switches -->
                    <div class="days-selection-wrapper mb-4" style="margin-top: 1.5rem;">
                      <label class="form-label fw-semibold mb-3 d-flex align-items-center">
                        <i class="ri-calendar-2-line me-2 text-primary"></i>
                        Select Days
                      </label>
                      <div class="days-switch-container">
                        @php($days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'])
                        @foreach($days as $index => $day)
                          <div class="day-switch-item">
                            <div class="form-check form-switch">
                              <input class="form-check-input day-switch" type="checkbox" name="groups[0][days][]" value="{{ strtolower($day) }}" id="g0-day-{{ strtolower($day) }}" checked role="switch">
                              <label class="form-check-label fw-medium" for="g0-day-{{ strtolower($day) }}">{{ $day }}</label>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>

                    <!-- Time Slots -->
                    <div class="time-slots-wrapper mb-4">
                      <label class="form-label fw-semibold mb-3 d-flex align-items-center">
                        <i class="ri-time-line me-2 text-primary"></i>
                        Time Slots
                      </label>
                      <div class="row g-3 align-items-start" data-group-index="0" data-slot-count="4">
                        <div class="col-md-3">
                          <div class="slot-card">
                            <label class="form-label d-block fw-semibold mb-2">
                              <span class="slot-number">Slot 1</span>
                              <span class="text-danger ms-1">*</span>
                            </label>
                            <div class="mb-2">
                              <select name="groups[0][slots][0][start]" class="form-select time-start" required>
                                <option value="">Start Time</option>
                              </select>
                            </div>
                            <div>
                              <select name="groups[0][slots][0][end]" class="form-select time-end" required>
                                <option value="">End Time</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="slot-card">
                            <label class="form-label d-block fw-semibold mb-2">
                              <span class="slot-number">Slot 2</span>
                            </label>
                            <div class="mb-2">
                              <select name="groups[0][slots][1][start]" class="form-select time-start">
                                <option value="">Start Time</option>
                              </select>
                            </div>
                            <div>
                              <select name="groups[0][slots][1][end]" class="form-select time-end">
                                <option value="">End Time</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="slot-card">
                            <label class="form-label d-block fw-semibold mb-2">
                              <span class="slot-number">Slot 3</span>
                            </label>
                            <div class="mb-2">
                              <select name="groups[0][slots][2][start]" class="form-select time-start">
                                <option value="">Start Time</option>
                              </select>
                            </div>
                            <div>
                              <select name="groups[0][slots][2][end]" class="form-select time-end">
                                <option value="">End Time</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="slot-card">
                            <label class="form-label d-block fw-semibold mb-2">
                              <span class="slot-number">Slot 4</span>
                            </label>
                            <div class="mb-2">
                              <select name="groups[0][slots][3][start]" class="form-select time-start">
                                <option value="">Start Time</option>
                              </select>
                            </div>
                            <div>
                              <select name="groups[0][slots][3][end]" class="form-select time-end">
                                <option value="">End Time</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Add More Timing Button -->
                    <div class="mb-3">
                      <button type="button" class="btn btn-outline-primary add-more-timing-btn add-more-timing" data-group-index="0">
                        <i class="ri-add-circle-line me-2"></i> ADD MORE TIMING
                      </button>
                    </div>

                    <!-- Hidden fields for Mode, Type, Timezone -->
                    <input type="hidden" name="groups[0][mode]" value="online">
                    <input type="hidden" name="groups[0][type]" value="repeat">
                    <input type="hidden" name="groups[0][timezone]" value="Asia/Kolkata">
                  </div>
                </div>
              </div>

              <!-- Add Another Availability Button -->
              <div class="text-center mt-4 mb-0 pt-3 border-top">
                <button type="button" class="btn btn-outline-primary waves-effect" id="add-group">
                  <i class="ri-add-line me-2"></i> Add Another Availability
                </button>
              </div>
            </form>
          </div>

          <!-- Modal Footer -->
          <div class="modal-footer availability-modal-footer" style="padding-top: 1.5rem;">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
              <i class="ri-close-line me-1"></i> Cancel
            </button>
            <button type="submit" form="set-availability-form" class="btn btn-primary btn-save">
              <i class="ri-save-line me-1"></i> SAVE
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
  (function() {
    const groupsWrapper = document.getElementById('groups-wrapper');
    const addGroupBtn = document.getElementById('add-group');
    const editAvailabilityModal = document.getElementById('editAvailabilityModal');
    const updateRouteBase = '{{ route("therapist.availability.set.update", 0) }}'.replace('/0', '');
    let editSetSlotData = null;

    function populateTimes(container) {
      const starts = container.querySelectorAll('select.time-start');
      const ends = container.querySelectorAll('select.time-end');

      function buildOptions(sel) {
        const isStart = sel.classList.contains('time-start');
        sel.innerHTML = '<option value="">' + (isStart ? 'Start Time' : 'End Time') + '</option>';

        for (let h = 0; h < 24; h++) {
          for (let m = 0; m < 60; m += 30) {
            const hh = String(h).padStart(2, '0');
            const mm = String(m).padStart(2, '0');
            const val = `${hh}:${mm}`;
            const hour12 = ((h + 11) % 12 + 1);
            const ampm = h < 12 ? 'AM' : 'PM';
            const label = `${hour12}:${mm} ${ampm}`;
            const opt = document.createElement('option');
            opt.value = val;
            opt.textContent = label;
            sel.appendChild(opt);
          }
        }
      }

      starts.forEach(buildOptions);
      ends.forEach(buildOptions);
    }

    function addMoreTimingSlot(groupIndex) {
      const group = groupsWrapper.querySelectorAll('.availability-group')[groupIndex];
      const slotsContainer = group.querySelector('.row.g-3');
      const currentSlotCount = parseInt(slotsContainer.getAttribute('data-slot-count')) || 4;

      if (currentSlotCount >= 8) {
        alert('Maximum 8 slots allowed per availability group');
        return;
      }

      const newSlotCount = currentSlotCount + 1;
      slotsContainer.setAttribute('data-slot-count', newSlotCount);

      const slotHtml = `
        <div class="col-md-3">
          <div class="slot-card">
            <label class="form-label d-block fw-semibold mb-2">
              <span class="slot-number">Slot ${newSlotCount}</span>
            </label>
            <div class="mb-2">
              <select name="groups[${groupIndex}][slots][${newSlotCount - 1}][start]" class="form-select time-start">
                <option value="">Start Time</option>
              </select>
            </div>
            <div>
              <select name="groups[${groupIndex}][slots][${newSlotCount - 1}][end]" class="form-select time-end">
                <option value="">End Time</option>
              </select>
            </div>
          </div>
        </div>
      `;

      const tempDiv = document.createElement('div');
      tempDiv.innerHTML = slotHtml;
      const newSlot = tempDiv.firstElementChild;
      slotsContainer.appendChild(newSlot);

      populateTimes(newSlot);
    }

    function bindGroup(groupEl, index) {
      populateTimes(groupEl);

      const addMoreTimingBtn = groupEl.querySelector('.add-more-timing');
      if (addMoreTimingBtn) {
        addMoreTimingBtn.setAttribute('data-group-index', index);
        addMoreTimingBtn.addEventListener('click', function() {
          addMoreTimingSlot(index);
        });
      }

      const removeBtn = groupEl.querySelector('.remove-group');
      if (removeBtn) {
        if (index === 0) {
          removeBtn.classList.add('d-none');
        } else {
          removeBtn.classList.remove('d-none');
          removeBtn.addEventListener('click', function() {
            groupEl.remove();
            updateGroupIndices();
          });
        }
      }
    }

    function updateGroupIndices() {
      const groups = groupsWrapper.querySelectorAll('.availability-group');
      groups.forEach((group, index) => {
        const title = group.querySelector('h6');
        if (title) {
          title.textContent = `Availability Group ${index + 1}`;
        }

        const inputs = group.querySelectorAll('input, select');
        inputs.forEach(input => {
          if (input.name) {
            input.name = input.name.replace(/groups\[\d+\]/, `groups[${index}]`);
          }
          if (input.id) {
            input.id = input.id.replace(/g\d+-/, `g${index}-`);
          }
        });

        const labels = group.querySelectorAll('label');
        labels.forEach(label => {
          if (label.htmlFor) {
            label.htmlFor = label.htmlFor.replace(/g\d+-/, `g${index}-`);
          }
        });

        const addMoreBtn = group.querySelector('.add-more-timing');
        if (addMoreBtn) {
          addMoreBtn.setAttribute('data-group-index', index);
        }

        const slotsContainer = group.querySelector('.row.g-3');
        if (slotsContainer) {
          slotsContainer.setAttribute('data-group-index', index);
        }
      });
    }

    if (editAvailabilityModal) {
      editAvailabilityModal.addEventListener('shown.bs.modal', function() {
        const firstGroup = groupsWrapper.querySelector('.availability-group');
        if (firstGroup) {
          bindGroup(firstGroup, 0);

          const formMethod = document.getElementById('form-method');
          if (formMethod && formMethod.value === 'PUT' && editSetSlotData) {
            setTimeout(() => {
              editSetSlotData.forEach((slot, slotIndex) => {
                const startSelect = firstGroup.querySelector(`select[name="groups[0][slots][${slotIndex}][start]"]`);
                const endSelect = firstGroup.querySelector(`select[name="groups[0][slots][${slotIndex}][end]"]`);

                if (startSelect && slot.start) {
                  startSelect.value = slot.start;
                }
                if (endSelect && slot.end) {
                  endSelect.value = slot.end;
                }
              });
              editSetSlotData = null;
            }, 50);
          }
        }
      });

      editAvailabilityModal.addEventListener('hidden.bs.modal', function() {
        const form = document.getElementById('set-availability-form');
        if (form) {
          form.action = '{{ route('therapist.availability.set.store') }}';
          const formMethod = document.getElementById('form-method');
          const availabilityIdInput = document.getElementById('availability-id');
          if (formMethod) formMethod.value = 'POST';
          if (availabilityIdInput) availabilityIdInput.value = '';

          editSetSlotData = null;

          const modalTitle = editAvailabilityModal.querySelector('.modal-title');
          if (modalTitle) {
            modalTitle.textContent = 'Edit Availability';
          }

          const addAnotherBtn = document.getElementById('add-group');
          if (addAnotherBtn) {
            addAnotherBtn.style.display = 'block';
          }

          form.reset();
          editAvailabilityModal.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = true);
          const groups = groupsWrapper.querySelectorAll('.availability-group');
          groups.forEach((group, index) => {
            if (index > 0) {
              group.remove();
            } else {
              const slotsContainer = group.querySelector('.row.g-3');
              if (slotsContainer) {
                slotsContainer.setAttribute('data-slot-count', '4');
                const slots = slotsContainer.querySelectorAll('.col-md-3');
                slots.forEach((slot, slotIndex) => {
                  if (slotIndex >= 4) {
                    slot.remove();
                  }
                });
              }
            }
          });
        }
      });
    }

    if (addGroupBtn) {
      addGroupBtn.addEventListener('click', function() {
        const index = groupsWrapper.querySelectorAll('.availability-group').length;
        const groupHtml = `
          <div class="availability-group card availability-card">
            <div class="card-header availability-card-header d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <i class="ri-time-line me-2 text-primary"></i>
                <h6 class="mb-0 fw-semibold">Availability Group ${index + 1}</h6>
              </div>
              <button type="button" class="btn btn-sm btn-outline-danger remove-group">
                <i class="ri-delete-bin-line me-1"></i> Remove
              </button>
            </div>
            <div class="card-body">
              <div class="mb-4 days-selection-wrapper">
                <label class="form-label fw-semibold mb-3 d-flex align-items-center">
                  <i class="ri-calendar-2-line me-2 text-primary"></i>
                  Select Days
                </label>
                <div class="days-switch-container">
                  ${['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'].map(d => `
                    <div class="day-switch-item">
                      <div class="form-check form-switch">
                        <input class="form-check-input day-switch" type="checkbox" name="groups[${index}][days][]" value="${d.toLowerCase()}" id="g${index}-day-${d.toLowerCase()}" checked role="switch">
                        <label class="form-check-label fw-medium" for="g${index}-day-${d.toLowerCase()}">${d}</label>
                      </div>
                    </div>`).join('')}
                </div>
              </div>
              <div class="time-slots-wrapper mb-4">
                <label class="form-label fw-semibold mb-3 d-flex align-items-center">
                  <i class="ri-time-line me-2 text-primary"></i>
                  Time Slots
                </label>
                <div class="row g-3 align-items-start" data-group-index="${index}" data-slot-count="4">
                  ${[0,1,2,3].map(i => `
                    <div class="col-md-3">
                      <div class="slot-card">
                        <label class="form-label d-block fw-semibold mb-2">
                          <span class="slot-number">Slot ${i+1}</span>${i === 0 ? ' <span class="text-danger ms-1">*</span>' : ''}
                        </label>
                        <div class="mb-2">
                          <select name="groups[${index}][slots][${i}][start]" class="form-select time-start" ${i === 0 ? 'required' : ''}>
                            <option value="">Start Time</option>
                          </select>
                        </div>
                        <div>
                          <select name="groups[${index}][slots][${i}][end]" class="form-select time-end" ${i === 0 ? 'required' : ''}>
                            <option value="">End Time</option>
                          </select>
                        </div>
                      </div>
                    </div>`).join('')}
                </div>
              </div>
              <div class="mb-3">
                <button type="button" class="btn btn-outline-primary add-more-timing-btn add-more-timing" data-group-index="${index}">
                  <i class="ri-add-circle-line me-2"></i> ADD MORE TIMING
                </button>
              </div>
              <input type="hidden" name="groups[${index}][mode]" value="online">
              <input type="hidden" name="groups[${index}][type]" value="repeat">
              <input type="hidden" name="groups[${index}][timezone]" value="Asia/Kolkata">
            </div>
          </div>
        `;

        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = groupHtml;
        const newGroup = tempDiv.firstElementChild;
        groupsWrapper.appendChild(newGroup);
        bindGroup(newGroup, index);
      });
    }

    document.querySelectorAll('.edit-availability-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const availabilityData = JSON.parse(this.getAttribute('data-availability-data'));
        const availabilityId = this.getAttribute('data-availability-id');

        const form = document.getElementById('set-availability-form');
        const formMethod = document.getElementById('form-method');
        const availabilityIdInput = document.getElementById('availability-id');

        form.action = updateRouteBase + '/' + availabilityId;
        formMethod.value = 'PUT';
        availabilityIdInput.value = availabilityId;

        const modalTitle = editAvailabilityModal.querySelector('.modal-title');
        if (modalTitle) {
          modalTitle.textContent = 'Edit Availability';
        }

        groupsWrapper.innerHTML = '';

        const groupHtml = `
          <div class="availability-group card availability-card">
            <div class="card-header availability-card-header d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <i class="ri-time-line me-2 text-primary"></i>
                <h6 class="mb-0 fw-semibold">Availability Group 1</h6>
              </div>
              <button type="button" class="btn btn-sm btn-outline-danger remove-group d-none">
                <i class="ri-delete-bin-line me-1"></i> Remove
              </button>
            </div>
            <div class="card-body">
              <div class="days-selection-wrapper mb-4" style="margin-top: 1.5rem;">
                <label class="form-label fw-semibold mb-3 d-flex align-items-center">
                  <i class="ri-calendar-2-line me-2 text-primary"></i>
                  Select Days
                </label>
                <div class="days-switch-container">
                  ${['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'].map(d => {
                    const dayLower = d.toLowerCase();
                    const isChecked = availabilityData.days && availabilityData.days.includes(dayLower);
                    return `
                      <div class="day-switch-item">
                        <div class="form-check form-switch">
                          <input class="form-check-input day-switch" type="checkbox" name="groups[0][days][]" value="${dayLower}" id="g0-day-${dayLower}" ${isChecked ? 'checked' : ''} role="switch">
                          <label class="form-check-label fw-medium" for="g0-day-${dayLower}">${d}</label>
                        </div>
                      </div>`;
                  }).join('')}
                </div>
              </div>
              <div class="time-slots-wrapper mb-4">
                <label class="form-label fw-semibold mb-3 d-flex align-items-center">
                  <i class="ri-time-line me-2 text-primary"></i>
                  Time Slots
                </label>
                <div class="row g-3 align-items-start" data-group-index="0" data-slot-count="${availabilityData.slots ? availabilityData.slots.length : 4}">
                  ${(availabilityData.slots || []).map((slot, i) => `
                    <div class="col-md-3">
                      <div class="slot-card">
                        <label class="form-label d-block fw-semibold mb-2">
                          <span class="slot-number">Slot ${i+1}</span>${i === 0 ? ' <span class="text-danger ms-1">*</span>' : ''}
                        </label>
                        <div class="mb-2">
                          <select name="groups[0][slots][${i}][start]" class="form-select time-start" ${i === 0 ? 'required' : ''}>
                            <option value="">Start Time</option>
                          </select>
                        </div>
                        <div>
                          <select name="groups[0][slots][${i}][end]" class="form-select time-end" ${i === 0 ? 'required' : ''}>
                            <option value="">End Time</option>
                          </select>
                        </div>
                      </div>
                    </div>`).join('')}
                </div>
              </div>
              <div class="mb-3">
                <button type="button" class="btn btn-outline-primary add-more-timing-btn add-more-timing" data-group-index="0">
                  <i class="ri-add-circle-line me-2"></i> ADD MORE TIMING
                </button>
              </div>
              <input type="hidden" name="groups[0][mode]" value="${availabilityData.mode || 'online'}">
              <input type="hidden" name="groups[0][type]" value="${availabilityData.type || 'repeat'}">
              <input type="hidden" name="groups[0][timezone]" value="${availabilityData.timezone || 'Asia/Kolkata'}">
            </div>
          </div>
        `;

        groupsWrapper.innerHTML = groupHtml;

        editSetSlotData = availabilityData.slots || [];

        const firstGroup = groupsWrapper.querySelector('.availability-group');
        if (firstGroup) {
          bindGroup(firstGroup, 0);
        }

        const addAnotherBtn = document.getElementById('add-group');
        if (addAnotherBtn) {
          addAnotherBtn.style.display = 'none';
        }

        const modal = new bootstrap.Modal(editAvailabilityModal);
        modal.show();
      });
    });

    const setAvailabilityForm = document.getElementById('set-availability-form');
    if (setAvailabilityForm) {
      setAvailabilityForm.addEventListener('submit', function(e) {
        const groups = groupsWrapper.querySelectorAll('.availability-group');
        let isValid = true;
        let errorMessage = '';

        groups.forEach((group, groupIndex) => {
          const checkedDays = group.querySelectorAll('input[type="checkbox"]:checked');
          if (checkedDays.length === 0) {
            isValid = false;
            errorMessage = `Please select at least one day for Availability Group ${groupIndex + 1}`;
            return;
          }

          const slot1Start = group.querySelector('select[name*="[slots][0][start]"]');
          const slot1End = group.querySelector('select[name*="[slots][0][end]"]');
          if (!slot1Start || !slot1Start.value || !slot1End || !slot1End.value) {
            isValid = false;
            errorMessage = `Slot 1 is required for Availability Group ${groupIndex + 1}. Please fill in both start and end times.`;
            return;
          }

          const allSlotStarts = group.querySelectorAll('select[name*="[slots]"][name*="[start]"]');
          const allSlotEnds = group.querySelectorAll('select[name*="[slots]"][name*="[end]"]');

          const validSlots = [];
          allSlotStarts.forEach((startSelect, slotIndex) => {
            const endSelect = allSlotEnds[slotIndex];
            const startValue = startSelect.value.trim();
            const endValue = endSelect.value.trim();

            if (startValue && endValue) {
              validSlots.push({
                start: startSelect,
                end: endSelect,
                originalIndex: slotIndex
              });
            }
          });

          validSlots.forEach((slot, newIndex) => {
            const originalIndex = slot.originalIndex;
            if (originalIndex !== newIndex) {
              const startName = slot.start.getAttribute('name');
              const endName = slot.end.getAttribute('name');

              if (startName) {
                slot.start.setAttribute('name', startName.replace(/\[slots\]\[\d+\]/, `[slots][${newIndex}]`));
              }
              if (endName) {
                slot.end.setAttribute('name', endName.replace(/\[slots\]\[\d+\]/, `[slots][${newIndex}]`));
              }
            }
          });

          allSlotStarts.forEach((startSelect, slotIndex) => {
            const endSelect = allSlotEnds[slotIndex];
            const startValue = startSelect.value.trim();
            const endValue = endSelect.value.trim();

            if (!startValue || !endValue) {
              startSelect.removeAttribute('name');
              endSelect.removeAttribute('name');
              startSelect.disabled = true;
              endSelect.disabled = true;
            }
          });
        });

        if (!isValid) {
          e.preventDefault();
          alert(errorMessage);
          return false;
        }

        const modal = bootstrap.Modal.getInstance(editAvailabilityModal);
        if (modal) {
          setTimeout(() => {
            modal.hide();
          }, 100);
        }

        return true;
      });
    }
  })();
</script>
@endsection
