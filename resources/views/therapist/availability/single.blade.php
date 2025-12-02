@extends('layouts/contentNavbarLayout')

@section('title', 'Single Availability (Single Day)')

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

  /* Date Display */
  .date-display {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .date-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 2px solid #a5b4fc;
  }

  .date-icon .day {
    font-size: 1.125rem;
    font-weight: 700;
    color: #4338ca;
    line-height: 1;
  }

  .date-icon .month {
    font-size: 0.625rem;
    font-weight: 600;
    color: #667eea;
    text-transform: uppercase;
  }

  .date-info {
    display: flex;
    flex-direction: column;
  }

  .date-info .full-date {
    font-weight: 600;
    color: #1e293b;
  }

  .date-info .day-name {
    font-size: 0.8125rem;
    color: #64748b;
  }

  /* Time Slots */
  .time-slots-display {
    display: flex;
    flex-wrap: wrap;
    gap: 0.375rem;
  }

  .time-badge {
    background: #f0f4ff;
    color: #4338ca;
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    border: 1px solid #c7d2fe;
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
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
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

  /* Modal Styles */
  .availability-modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 1.5rem 1.75rem;
    border-radius: 0.5rem 0.5rem 0 0;
  }

  .availability-modal-header .modal-title {
    font-size: 1.25rem;
    letter-spacing: -0.02em;
  }

  .availability-modal-body {
    padding: 2rem 2rem;
    background: #f8f9fa;
  }

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
    background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
    border-bottom: 2px solid #c7d2fe;
    padding: 1rem 1.25rem;
    border-radius: 12px 12px 0 0;
  }

  .availability-card-header h6 {
    color: #4338ca;
    font-size: 1rem;
  }

  .availability-card .card-body {
    padding: 1.5rem;
    background: #ffffff;
  }

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

  .slot-card .form-select,
  .slot-card .form-control {
    border-radius: 6px;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
  }

  .slot-card .form-select:focus,
  .slot-card .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
  }

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

  .availability-modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 1.5rem 2rem;
    background: #f8f9fa;
    border-radius: 0 0 0.5rem 0.5rem;
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
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(102, 126, 234, 0.4);
    color: white;
  }

  .availability-modal-body .form-label {
    color: #2d3748;
    font-size: 0.9375rem;
  }

  .availability-modal-body .form-label i {
    font-size: 1.125rem;
  }

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

  #editSingleAvailabilityModal .modal-content {
    min-height: 80vh;
    border-radius: 0.5rem;
  }

  #editSingleAvailabilityModal .modal-body {
    margin-top: 0;
    margin-bottom: 0;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .availability-page-header {
      padding: 1.5rem;
    }

    .availability-modal-body {
      padding: 1.5rem;
    }

    .action-buttons {
      flex-direction: column;
    }

    .date-display {
      flex-direction: column;
      align-items: flex-start;
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
          <i class="ri-calendar-event-line"></i>
        </div>
        <div>
          <h4 class="mb-1">Single Day Availability</h4>
          <p class="mb-0">Set one-time availability for specific dates</p>
        </div>
      </div>
    </div>

    <!-- Main Card -->
    <div class="card availability-main-card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-1">Single Date Slots</h5>
          <p class="text-muted mb-0 small">Manage availability for specific dates</p>
        </div>
        <button type="button" class="btn btn-add-availability" data-bs-toggle="modal" data-bs-target="#editSingleAvailabilityModal">
          <i class="ri-add-line me-1"></i> Add Single Availability
        </button>
      </div>
      <div class="card-body">
        @if($availabilities->count() > 0)
          <div class="table-responsive">
            <table class="table availability-table mb-0">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Time Slots</th>
                  <th>Mode</th>
                  <th>Type</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($availabilities as $availability)
                  @php
                    $date = $availability->date;
                    $dayNum = $date->format('d');
                    $month = $date->format('M');
                    $fullDate = $date->format('M d, Y');
                    $dayName = $date->format('l');
                  @endphp
                  <tr>
                    <td>
                      <div class="date-display">
                        <div class="date-icon">
                          <span class="day">{{ $dayNum }}</span>
                          <span class="month">{{ $month }}</span>
                        </div>
                        <div class="date-info">
                          <span class="full-date">{{ $fullDate }}</span>
                          <span class="day-name">{{ $dayName }}</span>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="time-slots-display">
                        @foreach($availability->slots as $slot)
                          <span class="time-badge">
                            <i class="ri-time-line"></i>
                            {{ $slot['start'] }} - {{ $slot['end'] }}
                          </span>
                        @endforeach
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
                        <i class="ri-calendar-check-line me-1"></i>
                        Once
                      </span>
                    </td>
                    <td>
                      <div class="action-buttons">
                        <button type="button" class="btn btn-action btn-edit edit-single-availability-btn" 
                          data-availability-id="{{ $availability->id }}" 
                          data-availability-data="{{ json_encode([
                            'id' => $availability->id,
                            'date' => $availability->date->format('Y-m-d'),
                            'slots' => $availability->slots,
                            'mode' => $availability->mode,
                            'timezone' => $availability->timezone
                          ]) }}">
                          <i class="ri-edit-line"></i> Edit
                        </button>
                        <form method="POST" action="{{ route('therapist.availability.single.destroy', $availability) }}" class="delete-form">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-action btn-delete" data-title="Delete Availability" data-text="Are you sure you want to delete this availability? This action cannot be undone." data-confirm-text="Yes, delete it!" data-cancel-text="Cancel">
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
              <i class="ri-calendar-event-line"></i>
            </div>
            <h5>No Single Day Availability Set</h5>
            <p>Add availability for specific dates when you want to offer one-time sessions.</p>
            <button type="button" class="btn btn-add-availability" data-bs-toggle="modal" data-bs-target="#editSingleAvailabilityModal">
              <i class="ri-add-line me-1"></i> Add Your First Date
            </button>
          </div>
        @endif
      </div>
    </div>

    <!-- Edit Single Availability Modal -->
    <div class="modal fade" id="editSingleAvailabilityModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen-lg-down availability-modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <!-- Modal Header with Gradient Background -->
          <div class="modal-header text-white availability-modal-header" style="padding-bottom: 15px">
            <div class="d-flex align-items-center">
              <div>
                <h5 class="modal-title mb-0 fw-bold">Add Single Availability</h5>
              </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body availability-modal-body">
            <form method="POST" action="{{ route('therapist.availability.single.store') }}" id="single-availability-form">
              @csrf
              <input type="hidden" name="_method" id="form-method" value="POST">
              <input type="hidden" name="availability_id" id="availability-id" value="">

              <!-- Date Selection -->
              <div class="card availability-card mb-4">
                <div class="card-header availability-card-header">
                  <div class="d-flex align-items-center">
                    <i class="ri-calendar-2-line me-2 text-primary"></i>
                    <h6 class="mb-0 fw-semibold">Select Date & Settings</h6>
                  </div>
                </div>
                <div class="card-body mt-4">
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label fw-semibold d-flex align-items-center">
                        <i class="ri-calendar-line me-2 text-primary"></i>
                        Date <span class="text-danger ms-1">*</span>
                      </label>
                      <input type="date" name="date" id="single-date" class="form-control" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label fw-semibold d-flex align-items-center">
                        <i class="ri-computer-line me-2 text-primary"></i>
                        Mode <span class="text-danger ms-1">*</span>
                      </label>
                      <select name="mode" class="form-select" required>
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label fw-semibold d-flex align-items-center">
                        <i class="ri-global-line me-2 text-primary"></i>
                        Timezone
                      </label>
                      <input type="text" name="timezone" class="form-control" placeholder="e.g., Asia/Kolkata" value="Asia/Kolkata">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Time Slots -->
              <div class="card availability-card mb-4">
                <div class="card-header availability-card-header">
                  <div class="d-flex align-items-center">
                    <i class="ri-time-line me-2 text-primary"></i>
                    <h6 class="mb-0 fw-semibold">Time Slots</h6>
                  </div>
                </div>
                <div class="card-body mt-4">
                  <div class="time-slots-wrapper">
                    <div class="row g-3 align-items-start" id="single-slots" data-slot-count="1">
                      <div class="col-md-3">
                        <div class="slot-card">
                          <label class="form-label d-block fw-semibold mb-2">
                            <span class="slot-number">Slot 1</span>
                            <span class="text-danger ms-1">*</span>
                          </label>
                          <div class="mb-2">
                            <select name="slots[0][start]" class="form-select time-start" required>
                              <option value="">Start Time</option>
                            </select>
                          </div>
                          <div>
                            <select name="slots[0][end]" class="form-select time-end" required>
                              <option value="">End Time</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Add More Timing Button -->
                    <div class="mt-3">
                      <button type="button" class="btn btn-outline-primary add-more-timing-btn" id="single-add-slot">
                        <i class="ri-add-circle-line me-2"></i> ADD MORE TIMING
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <!-- Modal Footer -->
          <div class="modal-footer availability-modal-footer" style="padding-top: 20px">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
              <i class="ri-close-line me-1"></i> Cancel
            </button>
            <button type="submit" form="single-availability-form" class="btn btn-primary btn-save">
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
  (function(){
    const editSingleAvailabilityModal = document.getElementById('editSingleAvailabilityModal');
    const singleSlotsContainer = document.getElementById('single-slots');
    const addSlotBtn = document.getElementById('single-add-slot');
    const singleAvailabilityForm = document.getElementById('single-availability-form');
    const updateRouteBase = '{{ route("therapist.availability.single.update", 0) }}'.replace('/0', '');
    let editSingleSlotData = null;

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

    function addMoreTimingSlot() {
      const currentSlotCount = parseInt(singleSlotsContainer.getAttribute('data-slot-count')) || 1;

      if (currentSlotCount >= 4) {
        alert('Maximum 4 slots allowed');
        return;
      }

      const newSlotCount = currentSlotCount + 1;
      singleSlotsContainer.setAttribute('data-slot-count', newSlotCount);

      const slotHtml = `
        <div class="col-md-3">
          <div class="slot-card">
            <label class="form-label d-block fw-semibold mb-2">
              <span class="slot-number">Slot ${newSlotCount}</span>
            </label>
            <div class="mb-2">
              <select name="slots[${newSlotCount - 1}][start]" class="form-select time-start">
                <option value="">Start Time</option>
              </select>
            </div>
            <div>
              <select name="slots[${newSlotCount - 1}][end]" class="form-select time-end">
                <option value="">End Time</option>
              </select>
            </div>
          </div>
        </div>
      `;

      const tempDiv = document.createElement('div');
      tempDiv.innerHTML = slotHtml;
      const newSlot = tempDiv.firstElementChild;
      singleSlotsContainer.appendChild(newSlot);

      populateTimes(newSlot);
    }

    if (editSingleAvailabilityModal) {
      editSingleAvailabilityModal.addEventListener('shown.bs.modal', function() {
        populateTimes(editSingleAvailabilityModal);
        
        const formMethod = document.getElementById('form-method');
        
        if (formMethod && formMethod.value === 'POST') {
          const dateInput = document.getElementById('single-date');
          if (dateInput && !dateInput.value) {
            const today = new Date().toISOString().slice(0, 10);
            dateInput.value = today;
          }
        }
        
        if (formMethod && formMethod.value === 'PUT' && editSingleSlotData) {
          setTimeout(() => {
            editSingleSlotData.forEach((slot, slotIndex) => {
              const startSelect = singleSlotsContainer.querySelector(`select[name="slots[${slotIndex}][start]"]`);
              const endSelect = singleSlotsContainer.querySelector(`select[name="slots[${slotIndex}][end]"]`);
              
              if (startSelect && slot.start) {
                startSelect.value = slot.start;
              }
              if (endSelect && slot.end) {
                endSelect.value = slot.end;
              }
            });
            editSingleSlotData = null;
          }, 50);
        }
      });

      editSingleAvailabilityModal.addEventListener('hidden.bs.modal', function() {
        const form = document.getElementById('single-availability-form');
        if (form) {
          form.action = '{{ route('therapist.availability.single.store') }}';
          const formMethod = document.getElementById('form-method');
          const availabilityIdInput = document.getElementById('availability-id');
          if (formMethod) formMethod.value = 'POST';
          if (availabilityIdInput) availabilityIdInput.value = '';
          
          editSingleSlotData = null;
          
          const modalTitle = editSingleAvailabilityModal.querySelector('.modal-title');
          if (modalTitle) {
            modalTitle.textContent = 'Add Single Availability';
          }
          
          form.reset();
          singleSlotsContainer.setAttribute('data-slot-count', '1');
          const slots = singleSlotsContainer.querySelectorAll('.col-md-3');
          slots.forEach((slot, slotIndex) => {
            if (slotIndex >= 1) {
              slot.remove();
            }
          });
          const dateInput = document.getElementById('single-date');
          if (dateInput) {
            const today = new Date().toISOString().slice(0, 10);
            dateInput.value = today;
          }
        }
      });
    }

    document.querySelectorAll('.edit-single-availability-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const availabilityData = JSON.parse(this.getAttribute('data-availability-data'));
        const availabilityId = this.getAttribute('data-availability-id');
        
        const form = document.getElementById('single-availability-form');
        const formMethod = document.getElementById('form-method');
        const availabilityIdInput = document.getElementById('availability-id');
        
        form.action = updateRouteBase + '/' + availabilityId;
        formMethod.value = 'PUT';
        availabilityIdInput.value = availabilityId;
        
        const modalTitle = editSingleAvailabilityModal.querySelector('.modal-title');
        if (modalTitle) {
          modalTitle.textContent = 'Edit Single Availability';
        }
        
        const dateInput = document.getElementById('single-date');
        if (dateInput && availabilityData.date) {
          dateInput.value = availabilityData.date;
        }
        
        const modeSelect = form.querySelector('select[name="mode"]');
        if (modeSelect && availabilityData.mode) {
          modeSelect.value = availabilityData.mode;
        }
        
        const timezoneSelect = form.querySelector('select[name="timezone"]');
        if (timezoneSelect && availabilityData.timezone) {
          timezoneSelect.value = availabilityData.timezone;
        }
        
        editSingleSlotData = availabilityData.slots || [];
        
        singleSlotsContainer.innerHTML = '';
        singleSlotsContainer.setAttribute('data-slot-count', availabilityData.slots ? availabilityData.slots.length : 1);
        
        const slots = availabilityData.slots || [];
        slots.forEach((slot, slotIndex) => {
          const slotHtml = `
            <div class="col-md-3">
              <div class="slot-card">
                <label class="form-label d-block fw-semibold mb-2">
                  <span class="slot-number">Slot ${slotIndex + 1}</span>${slotIndex === 0 ? ' <span class="text-danger ms-1">*</span>' : ''}
                </label>
                <div class="mb-2">
                  <select name="slots[${slotIndex}][start]" class="form-select time-start" ${slotIndex === 0 ? 'required' : ''}>
                    <option value="">Start Time</option>
                  </select>
                </div>
                <div>
                  <select name="slots[${slotIndex}][end]" class="form-select time-end" ${slotIndex === 0 ? 'required' : ''}>
                    <option value="">End Time</option>
                  </select>
                </div>
              </div>
            </div>
          `;
          
          const tempDiv = document.createElement('div');
          tempDiv.innerHTML = slotHtml;
          const newSlot = tempDiv.firstElementChild;
          singleSlotsContainer.appendChild(newSlot);
        });
        
        const modal = new bootstrap.Modal(editSingleAvailabilityModal);
        modal.show();
      });
    });

    if (addSlotBtn) {
      addSlotBtn.addEventListener('click', addMoreTimingSlot);
    }

    if (singleAvailabilityForm) {
      singleAvailabilityForm.addEventListener('submit', function(e) {
        const dateInput = document.getElementById('single-date');
        if (!dateInput || !dateInput.value) {
          e.preventDefault();
          alert('Please select a date');
          return false;
        }

        const slot1Start = singleSlotsContainer.querySelector('select[name="slots[0][start]"]');
        const slot1End = singleSlotsContainer.querySelector('select[name="slots[0][end]"]');
        if (!slot1Start || !slot1Start.value || !slot1End || !slot1End.value) {
          e.preventDefault();
          alert('Slot 1 is required. Please fill in both start and end times.');
          return false;
        }

        const allSlotStarts = singleSlotsContainer.querySelectorAll('select.time-start');
        const allSlotEnds = singleSlotsContainer.querySelectorAll('select.time-end');

        allSlotStarts.forEach((startSelect, slotIndex) => {
          const endSelect = allSlotEnds[slotIndex];
          const startValue = startSelect.value.trim();
          const endValue = endSelect.value.trim();

          if (startValue && endValue) {
            startSelect.disabled = false;
            endSelect.disabled = false;
          } else if (slotIndex > 0) {
            startSelect.disabled = true;
            endSelect.disabled = true;
            startSelect.removeAttribute('name');
            endSelect.removeAttribute('name');
          }
        });

        const modal = bootstrap.Modal.getInstance(editSingleAvailabilityModal);
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
