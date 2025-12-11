@extends('layouts/contentNavbarLayout')

@section('title', 'Single Availability (Single Day)')

@section('content')
<div class="row">
  <div class="col-12 mb-4">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-0">Single Availability</h5>
          <small class="text-muted">Therapist: <strong>{{ $therapist->name }}</strong> ({{ $therapist->email }})</small>
        </div>
        <a href="{{ route('admin.therapist-availability.index') }}" class="btn btn-secondary btn-sm">
          <i class="ri-arrow-left-line me-1"></i> Back to Therapists
        </a>
      </div>
      <div class="card-body">
        <!-- Add Single Availability Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editSingleAvailabilityModal">
              <i class="ri-add-line me-1"></i> Add Single Availability
            </button>
          </div>
        </div>

        <!-- Single Day Availabilities Listing -->
        <div class="mt-4">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Mode</th>
                  <th>Type</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($availabilities as $availability)
                  <tr>
                    <td>{{ $availability->date->format('M d, Y') }}</td>
                    <td>
                      @foreach($availability->slots as $slot)
                        <span class="badge bg-light text-dark me-1">{{ $slot['start'] }} - {{ $slot['end'] }}</span>
                      @endforeach
                    </td>
                    <td class="text-capitalize">{{ $availability->mode }}</td>
                    <td>Once</td>
                    <td class="d-flex gap-1">
                      <button type="button" class="btn btn-sm btn-primary edit-single-availability-btn" data-availability-id="{{ $availability->id }}" data-availability-data="{{ json_encode([
                        'id' => $availability->id,
                        'date' => $availability->date->format('Y-m-d'),
                        'slots' => $availability->slots,
                        'mode' => $availability->mode,
                        'timezone' => $availability->timezone
                      ]) }}">
                        <i class="ri-edit-line me-1"></i> Edit
                      </button>
                      <form method="POST" action="{{ route('admin.therapist-availability.single.destroy', $availability) }}" onsubmit="return confirm('Delete this availability?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                          <i class="ri-delete-bin-line me-1"></i> Delete
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="5" class="text-muted">No single day availabilities yet.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
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
                <h5 class="modal-title mb-0 fw-bold">Edit Single Availability</h5>
              </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body availability-modal-body">
            <form method="POST" action="{{ route('admin.therapist-availability.single.store') }}" id="single-availability-form">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="availability_id" id="availability-id" value="">
                <input type="hidden" name="therapist_id" value="{{ $therapist->id }}">

              <!-- Date Selection -->
              <div class="card availability-card mb-4">
                <div class="card-header availability-card-header">
                  <div class="d-flex align-items-center">
                    <i class="ri-calendar-2-line me-2 text-primary"></i>
                    <h6 class="mb-0 fw-semibold">Select Date</h6>
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
                <div class="card-body mt-6">
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
    const updateRouteBase = '{{ route("admin.therapist-availability.single.update", 0) }}'.replace('/0', '');
    let editSingleSlotData = null; // Store edit data for single availability

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

      // Populate the new slot's time options
      populateTimes(newSlot);
    }

    // Initialize when modal is shown
    if (editSingleAvailabilityModal) {
      editSingleAvailabilityModal.addEventListener('shown.bs.modal', function() {
        populateTimes(editSingleAvailabilityModal);
        
        const formMethod = document.getElementById('form-method');
        
        // Set minimum date to today (only for create mode)
        if (formMethod && formMethod.value === 'POST') {
          const dateInput = document.getElementById('single-date');
          if (dateInput && !dateInput.value) {
            const today = new Date().toISOString().slice(0, 10);
            dateInput.value = today;
          }
        }
        
        // Restore edit values after populateTimes
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
            editSingleSlotData = null; // Clear after use
          }, 50);
        }
      });

      // Reset modal when hidden
      editSingleAvailabilityModal.addEventListener('hidden.bs.modal', function() {
        const form = document.getElementById('single-availability-form');
        if (form) {
          // Reset form to create mode
          form.action = '{{ route('admin.therapist-availability.single.store') }}';
          const formMethod = document.getElementById('form-method');
          const availabilityIdInput = document.getElementById('availability-id');
          if (formMethod) formMethod.value = 'POST';
          if (availabilityIdInput) availabilityIdInput.value = '';
          
          // Clear edit data
          editSingleSlotData = null;
          
          // Update modal title back to create
          const modalTitle = editSingleAvailabilityModal.querySelector('.modal-title');
          if (modalTitle) {
            modalTitle.textContent = 'Edit Single Availability';
          }
          
          form.reset();
          // Reset slots to 1
          singleSlotsContainer.setAttribute('data-slot-count', '1');
          const slots = singleSlotsContainer.querySelectorAll('.col-md-3');
          slots.forEach((slot, slotIndex) => {
            if (slotIndex >= 1) {
              slot.remove();
            }
          });
          // Reset date to today
          const dateInput = document.getElementById('single-date');
          if (dateInput) {
            const today = new Date().toISOString().slice(0, 10);
            dateInput.value = today;
          }
        }
      });
    }

    // Handle Edit button clicks
    document.querySelectorAll('.edit-single-availability-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const availabilityData = JSON.parse(this.getAttribute('data-availability-data'));
        const availabilityId = this.getAttribute('data-availability-id');
        
        // Set form to update mode
        const form = document.getElementById('single-availability-form');
        const formMethod = document.getElementById('form-method');
        const availabilityIdInput = document.getElementById('availability-id');
        
        form.action = updateRouteBase + '/' + availabilityId;
        formMethod.value = 'PUT';
        availabilityIdInput.value = availabilityId;
        
        // Update modal title
        const modalTitle = editSingleAvailabilityModal.querySelector('.modal-title');
        if (modalTitle) {
          modalTitle.textContent = 'Edit Single Availability';
        }
        
        // Set date
        const dateInput = document.getElementById('single-date');
        if (dateInput && availabilityData.date) {
          dateInput.value = availabilityData.date;
        }
        
        // Set mode
        const modeSelect = form.querySelector('select[name="mode"]');
        if (modeSelect && availabilityData.mode) {
          modeSelect.value = availabilityData.mode;
        }
        
        // Set timezone
        const timezoneSelect = form.querySelector('select[name="timezone"]');
        if (timezoneSelect && availabilityData.timezone) {
          timezoneSelect.value = availabilityData.timezone;
        }
        
        // Store edit data for use in shown.bs.modal
        editSingleSlotData = availabilityData.slots || [];
        
        // Clear existing slots
        singleSlotsContainer.innerHTML = '';
        singleSlotsContainer.setAttribute('data-slot-count', availabilityData.slots ? availabilityData.slots.length : 1);
        
        // Create slots based on availability data
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
        
        // Show modal (populateTimes will be called in shown.bs.modal)
        const modal = new bootstrap.Modal(editSingleAvailabilityModal);
        modal.show();
      });
    });

    // Add More Timing button
    if (addSlotBtn) {
      addSlotBtn.addEventListener('click', addMoreTimingSlot);
    }

    // Handle form submission
    if (singleAvailabilityForm) {
      singleAvailabilityForm.addEventListener('submit', function(e) {
        // Validate date is selected
        const dateInput = document.getElementById('single-date');
        if (!dateInput || !dateInput.value) {
          e.preventDefault();
          alert('Please select a date');
          return false;
        }

        // Validate Slot 1 is filled
        const slot1Start = singleSlotsContainer.querySelector('select[name="slots[0][start]"]');
        const slot1End = singleSlotsContainer.querySelector('select[name="slots[0][end]"]');
        if (!slot1Start || !slot1Start.value || !slot1End || !slot1End.value) {
          e.preventDefault();
          alert('Slot 1 is required. Please fill in both start and end times.');
          return false;
        }

        // Process and clean up slots - disable empty slots so they won't be submitted
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

        // Close modal after successful submission
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

@section('page-style')
<style>
  /* Reuse the same styles from set availability modal */
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
    margin-top: 0;
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
</style>
@endsection
@endsection
