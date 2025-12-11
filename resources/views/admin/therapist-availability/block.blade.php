@extends('layouts/contentNavbarLayout')

@section('title', 'Block Availability')

@section('content')
<div class="row">
  <div class="col-12 mb-4">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-0">Block Availability</h5>
          <small class="text-muted">Therapist: <strong>{{ $therapist->name }}</strong> ({{ $therapist->email }})</small>
        </div>
        <a href="{{ route('admin.therapist-availability.index') }}" class="btn btn-secondary btn-sm">
          <i class="ri-arrow-left-line me-1"></i> Back to Therapists
        </a>
      </div>
      <div class="card-body">
        <!-- Block Availability Buttons -->
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#blockDateModal">
              <i class="ri-calendar-line me-1"></i> Block by Date
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#blockSlotModal">
              <i class="ri-time-line me-1"></i> Block by Slot
            </button>
          </div>
        </div>

        <!-- Blocked List -->
        <div class="mt-4">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Type</th>
                  <th>Blocked Date</th>
                  <th>Blocked Time</th>
                  <th>Reason</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($blocks as $i => $block)
                  <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                      @if($block->date)
                        <span class="badge bg-info">Block by Slot</span>
                      @else
                        <span class="badge bg-primary">Block by Date</span>
                      @endif
                    </td>
                    <td>
                      @if($block->date)
                        {{ $block->date->format('M d, Y') }}
                      @else
                        {{ $block->start_date?->format('M d, Y') }} - {{ $block->end_date?->format('M d, Y') }}
                      @endif
                    </td>
                    <td>
                      @if($block->blocked_slots)
                        @foreach($block->blocked_slots as $slot)
                          <span class="badge bg-light text-dark me-1">{{ $slot['start'] }} - {{ $slot['end'] }}</span>
                        @endforeach
                      @else
                        <span class="text-muted">All Day</span>
                      @endif
                    </td>
                    <td>{{ $block->reason ?? '-' }}</td>
                    <td>
                      @if($block->is_active)
                        <span class="badge bg-danger">Blocked</span>
                      @else
                        <span class="badge bg-secondary">Disabled</span>
                      @endif
                    </td>
                    <td class="d-flex gap-1">
                      <button type="button" class="btn btn-sm btn-primary edit-block-btn" 
                        data-block-id="{{ $block->id }}"
                        data-block-type="{{ $block->date ? 'slot' : 'date' }}"
                        data-block-data="{{ json_encode([
                          'id' => $block->id,
                          'date' => $block->date ? $block->date->format('Y-m-d') : null,
                          'start_date' => $block->start_date ? $block->start_date->format('Y-m-d') : null,
                          'end_date' => $block->end_date ? $block->end_date->format('Y-m-d') : null,
                          'blocked_slots' => $block->blocked_slots,
                          'reason' => $block->reason
                        ]) }}">
                        <i class="ri-edit-line me-1"></i> Edit
                      </button>
                      <form method="POST" action="{{ route('admin.therapist-availability.block.toggle', $block) }}">
                        @csrf
                        <button class="btn btn-sm btn-warning" type="submit">
                          <i class="ri-refresh-line me-1"></i> {{ $block->is_active ? 'Restore' : 'Disable' }}
                        </button>
                      </form>
                      <form method="POST" action="{{ route('admin.therapist-availability.block.destroy', $block) }}" onsubmit="return confirm('Delete this block?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">
                          <i class="ri-delete-bin-line me-1"></i> Delete
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="7" class="text-muted">No blocked records yet.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Block by Date Modal -->
    <div class="modal fade" id="blockDateModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen-lg-down availability-modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header text-white availability-modal-header">
            <div class="d-flex align-items-center">
              <div>
                <h5 class="modal-title mb-4 fw-bold">Block by Date</h5>
              </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body availability-modal-body">
            <form method="POST" action="{{ route('admin.therapist-availability.block.date.store') }}" id="block-date-form">
              @csrf
              <input type="hidden" name="_method" id="block-date-method" value="POST">
              <input type="hidden" name="block_id" id="block-date-id" value="">
              <input type="hidden" name="therapist_id" value="{{ $therapist->id }}">

              <div class="card availability-card mb-4">
                <div class="card-header availability-card-header">
                  <div class="d-flex align-items-center">
                    <i class="ri-calendar-2-line me-2 text-primary"></i>
                    <h6 class="mb-0 fw-semibold">Select Date Range</h6>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row g-3 mt-6">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold d-flex align-items-center">
                        <i class="ri-calendar-line me-2 text-primary"></i>
                        Start Date <span class="text-danger ms-1">*</span>
                      </label>
                      <input type="date" name="start_date" id="block-start" class="form-control" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-semibold d-flex align-items-center">
                        <i class="ri-calendar-line me-2 text-primary"></i>
                        End Date <span class="text-danger ms-1">*</span>
                      </label>
                      <input type="date" name="end_date" id="block-end" class="form-control" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-12">
                      <label class="form-label fw-semibold d-flex align-items-center">
                        <i class="ri-file-text-line me-2 text-primary"></i>
                        Reason (optional)
                      </label>
                      <input type="text" name="reason" class="form-control" placeholder="Enter reason for blocking">
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <!-- Modal Footer -->
          <div class="modal-footer availability-modal-footer pt-4">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
              <i class="ri-close-line me-1"></i> Cancel
            </button>
            <button type="submit" form="block-date-form" class="btn btn-primary btn-save">
              <i class="ri-save-line me-1"></i> BLOCK DATES
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Block by Slot Modal -->
    <div class="modal fade" id="blockSlotModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen-lg-down availability-modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header text-white availability-modal-header">
            <div class="d-flex align-items-center">
              <div>
                <h5 class="modal-title mb-4 fw-bold">Block by Slot</h5>
              </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body availability-modal-body">
            <form method="POST" action="{{ route('admin.therapist-availability.block.slot.store') }}" id="block-slot-form">
              @csrf
              <input type="hidden" name="therapist_id" value="{{ $therapist->id }}">
              <input type="hidden" name="_method" id="block-slot-method" value="POST">
              <input type="hidden" name="block_id" id="block-slot-id" value="">

              <!-- Date Selection -->
              <div class="card availability-card ">
                <div class="card-header availability-card-header">
                  <div class="d-flex align-items-center">
                    <i class="ri-calendar-2-line me-2 text-primary"></i>
                    <h6 class="mb-0 fw-semibold">Select Date</h6>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row g-3 mt-4">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold d-flex align-items-center">
                        <i class="ri-calendar-line me-2 text-primary"></i>
                        Date <span class="text-danger ms-1">*</span>
                      </label>
                      <input type="date" name="date" id="slot-date" class="form-control" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-semibold d-flex align-items-center">
                        <i class="ri-file-text-line me-2 text-primary"></i>
                        Reason (optional)
                      </label>
                      <input type="text" name="reason" class="form-control" placeholder="Enter reason for blocking">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Time Slots to Block -->
              <div class="card availability-card mb-4">
                <div class="card-header availability-card-header">
                  <div class="d-flex align-items-center">
                    <i class="ri-time-line me-2 text-primary"></i>
                    <h6 class="mb-0 fw-semibold">Time Slots to Block</h6>
                  </div>
                </div>
                <div class="card-body mt-4">
                  <div class="time-slots-wrapper">
                    <div class="row g-3 align-items-start" id="blocked-slots" data-slot-count="1">
                      <div class="col-md-3">
                        <div class="slot-card">
                          <label class="form-label d-block fw-semibold mb-2">
                            <span class="slot-number">Slot 1</span>
                            <span class="text-danger ms-1">*</span>
                          </label>
                          <div class="mb-2">
                            <select name="blocked_slots[0][start]" class="form-select time-start" required>
                              <option value="">Start Time</option>
                            </select>
                          </div>
                          <div>
                            <select name="blocked_slots[0][end]" class="form-select time-end" required>
                              <option value="">End Time</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Add More Timing Button -->
                    <div class="mt-3">
                      <button type="button" class="btn btn-outline-primary add-more-timing-btn" id="add-block-slot">
                        <i class="ri-add-circle-line me-2"></i> ADD MORE TIMING
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <!-- Modal Footer -->
          <div class="modal-footer availability-modal-footer pt-4">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
              <i class="ri-close-line me-1"></i> Cancel
            </button>
            <button type="submit" form="block-slot-form" class="btn btn-primary btn-save">
              <i class="ri-save-line me-1"></i> BLOCK SLOTS
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@section('page-script')
<script>
  (function(){
    // Block by Date Modal
    const blockDateModal = document.getElementById('blockDateModal');
    const blockDateForm = document.getElementById('block-date-form');
    const blockStart = document.getElementById('block-start');
    const blockEnd = document.getElementById('block-end');
    const updateDateRouteBase = '{{ route("admin.therapist-availability.block.date.update", 0) }}'.replace('/0', '');

    // Block by Slot Modal
    const blockSlotModal = document.getElementById('blockSlotModal');
    const blockSlotForm = document.getElementById('block-slot-form');
    const blockedSlotsContainer = document.getElementById('blocked-slots');
    const addBlockSlotBtn = document.getElementById('add-block-slot');
    const slotDate = document.getElementById('slot-date');
    const updateSlotRouteBase = '{{ route("admin.therapist-availability.block.slot.update", 0) }}'.replace('/0', '');
    let editSlotData = null; // Store edit data for slot blocks

    // Function to populate time dropdowns
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

    // Function to add more timing slots
    function addMoreTimingSlot() {
      const currentSlotCount = parseInt(blockedSlotsContainer.getAttribute('data-slot-count')) || 1;

      if (currentSlotCount >= 4) {
        alert('Maximum 4 slots allowed');
        return;
      }

      const newSlotCount = currentSlotCount + 1;
      blockedSlotsContainer.setAttribute('data-slot-count', newSlotCount);

      const slotHtml = `
        <div class="col-md-3">
          <div class="slot-card">
            <label class="form-label d-block fw-semibold mb-2">
              <span class="slot-number">Slot ${newSlotCount}</span>
            </label>
            <div class="mb-2">
              <select name="blocked_slots[${newSlotCount - 1}][start]" class="form-select time-start">
                <option value="">Start Time</option>
              </select>
            </div>
            <div>
              <select name="blocked_slots[${newSlotCount - 1}][end]" class="form-select time-end">
                <option value="">End Time</option>
              </select>
            </div>
          </div>
        </div>
      `;

      const tempDiv = document.createElement('div');
      tempDiv.innerHTML = slotHtml;
      const newSlot = tempDiv.firstElementChild;
      blockedSlotsContainer.appendChild(newSlot);

      // Populate the new slot's time options
      populateTimes(newSlot);
    }

    // Block by Date Modal Events
    if (blockDateModal) {
      blockDateModal.addEventListener('shown.bs.modal', function() {
        // Set default dates if not set (only for create mode)
        const formMethod = document.getElementById('block-date-method');
        if (formMethod && formMethod.value === 'POST') {
          if (blockStart && !blockStart.value) {
            const today = new Date().toISOString().slice(0, 10);
            blockStart.value = today;
          }
          if (blockEnd && !blockEnd.value) {
            const today = new Date();
            today.setDate(today.getDate() + 3);
            blockEnd.value = today.toISOString().slice(0, 10);
          }
        }
      });
      
      blockDateModal.addEventListener('hidden.bs.modal', function() {
        if (blockDateForm) {
          // Reset form to create mode
          blockDateForm.action = '{{ route('admin.therapist-availability.block.date.store') }}';
          const formMethod = document.getElementById('block-date-method');
          const blockIdInput = document.getElementById('block-date-id');
          if (formMethod) formMethod.value = 'POST';
          if (blockIdInput) blockIdInput.value = '';
          
          // Update modal title
          const modalTitle = blockDateModal.querySelector('.modal-title');
          if (modalTitle) {
            modalTitle.textContent = 'Block by Date';
          }
          
          blockDateForm.reset();
        }
      });
    }

    // Block by Slot Modal Events
    if (blockSlotModal) {
      blockSlotModal.addEventListener('shown.bs.modal', function() {
        populateTimes(blockSlotModal);
        
        const formMethod = document.getElementById('block-slot-method');
        
        // Set minimum date to today (only for create mode)
        if (formMethod && formMethod.value === 'POST') {
          if (slotDate && !slotDate.value) {
            const today = new Date().toISOString().slice(0, 10);
            slotDate.value = today;
          }
        }
        
        // Restore edit values after populateTimes
        if (formMethod && formMethod.value === 'PUT' && editSlotData) {
          setTimeout(() => {
            editSlotData.forEach((slot, slotIndex) => {
              const startSelect = blockedSlotsContainer.querySelector(`select[name="blocked_slots[${slotIndex}][start]"]`);
              const endSelect = blockedSlotsContainer.querySelector(`select[name="blocked_slots[${slotIndex}][end]"]`);
              
              if (startSelect && slot.start) {
                startSelect.value = slot.start;
              }
              if (endSelect && slot.end) {
                endSelect.value = slot.end;
              }
            });
            editSlotData = null; // Clear after use
          }, 50);
        }
      });
      
      blockSlotModal.addEventListener('hidden.bs.modal', function() {
        if (blockSlotForm) {
          // Reset form to create mode
          blockSlotForm.action = '{{ route('admin.therapist-availability.block.slot.store') }}';
          const formMethod = document.getElementById('block-slot-method');
          const blockIdInput = document.getElementById('block-slot-id');
          if (formMethod) formMethod.value = 'POST';
          if (blockIdInput) blockIdInput.value = '';
          
          // Clear edit data
          editSlotData = null;
          
          // Update modal title
          const modalTitle = blockSlotModal.querySelector('.modal-title');
          if (modalTitle) {
            modalTitle.textContent = 'Block by Slot';
          }
          
          blockSlotForm.reset();
          // Reset slots to 1
          blockedSlotsContainer.setAttribute('data-slot-count', '1');
          const slots = blockedSlotsContainer.querySelectorAll('.col-md-3');
          slots.forEach((slot, slotIndex) => {
            if (slotIndex >= 1) {
              slot.remove();
            }
          });
          // Reset date to today
          if (slotDate) {
            const today = new Date().toISOString().slice(0, 10);
            slotDate.value = today;
          }
        }
      });
    }

    // Add More Timing button
    if (addBlockSlotBtn) {
      addBlockSlotBtn.addEventListener('click', addMoreTimingSlot);
    }

    // Handle Edit button clicks
    document.querySelectorAll('.edit-block-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const blockData = JSON.parse(this.getAttribute('data-block-data'));
        const blockType = this.getAttribute('data-block-type');
        const blockId = this.getAttribute('data-block-id');
        
        if (blockType === 'date') {
          // Edit Block by Date
          const formMethod = document.getElementById('block-date-method');
          const blockIdInput = document.getElementById('block-date-id');
          
          blockDateForm.action = updateDateRouteBase + '/' + blockId;
          formMethod.value = 'PUT';
          blockIdInput.value = blockId;
          
          // Populate form fields
          if (blockStart && blockData.start_date) {
            blockStart.value = blockData.start_date;
          }
          if (blockEnd && blockData.end_date) {
            blockEnd.value = blockData.end_date;
          }
          const reasonInput = blockDateForm.querySelector('input[name="reason"]');
          if (reasonInput && blockData.reason) {
            reasonInput.value = blockData.reason;
          }
          
          // Update modal title
          const modalTitle = blockDateModal.querySelector('.modal-title');
          if (modalTitle) {
            modalTitle.textContent = 'Edit Block by Date';
          }
          
          // Show modal
          const modal = new bootstrap.Modal(blockDateModal);
          modal.show();
        } else {
          // Edit Block by Slot
          const formMethod = document.getElementById('block-slot-method');
          const blockIdInput = document.getElementById('block-slot-id');
          
          blockSlotForm.action = updateSlotRouteBase + '/' + blockId;
          formMethod.value = 'PUT';
          blockIdInput.value = blockId;
          
          // Store edit data for use in shown.bs.modal
          editSlotData = blockData.blocked_slots || [];
          
          // Populate date
          if (slotDate && blockData.date) {
            slotDate.value = blockData.date;
          }
          
          // Populate reason
          const reasonInput = blockSlotForm.querySelector('input[name="reason"]');
          if (reasonInput && blockData.reason) {
            reasonInput.value = blockData.reason;
          }
          
          // Clear existing slots
          blockedSlotsContainer.innerHTML = '';
          blockedSlotsContainer.setAttribute('data-slot-count', blockData.blocked_slots ? blockData.blocked_slots.length : 1);
          
          // Create slots based on block data
          const slots = blockData.blocked_slots || [];
          slots.forEach((slot, slotIndex) => {
            const slotHtml = `
              <div class="col-md-3">
                <div class="slot-card">
                  <label class="form-label d-block fw-semibold mb-2">
                    <span class="slot-number">Slot ${slotIndex + 1}</span>${slotIndex === 0 ? ' <span class="text-danger ms-1">*</span>' : ''}
                  </label>
                  <div class="mb-2">
                    <select name="blocked_slots[${slotIndex}][start]" class="form-select time-start" ${slotIndex === 0 ? 'required' : ''}>
                      <option value="">Start Time</option>
                    </select>
                  </div>
                  <div>
                    <select name="blocked_slots[${slotIndex}][end]" class="form-select time-end" ${slotIndex === 0 ? 'required' : ''}>
                      <option value="">End Time</option>
                    </select>
                  </div>
                </div>
              </div>
            `;
            
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = slotHtml;
            const newSlot = tempDiv.firstElementChild;
            blockedSlotsContainer.appendChild(newSlot);
          });
          
          // Update modal title
          const modalTitle = blockSlotModal.querySelector('.modal-title');
          if (modalTitle) {
            modalTitle.textContent = 'Edit Block by Slot';
          }
          
          // Show modal (populateTimes will be called in shown.bs.modal)
          const modal = new bootstrap.Modal(blockSlotModal);
          modal.show();
        }
      });
    });

    // Handle Block Date Form Submission
    if (blockDateForm) {
      blockDateForm.addEventListener('submit', function(e) {
        // Validate dates
        if (!blockStart || !blockStart.value || !blockEnd || !blockEnd.value) {
          e.preventDefault();
          alert('Please select both start and end dates');
          return false;
        }

        if (new Date(blockStart.value) > new Date(blockEnd.value)) {
          e.preventDefault();
          alert('End date must be after or equal to start date');
          return false;
        }

        // Close modal after successful submission
        const modal = bootstrap.Modal.getInstance(blockDateModal);
        if (modal) {
          setTimeout(() => {
            modal.hide();
          }, 100);
        }

        return true;
      });
    }

    // Handle Block Slot Form Submission
    if (blockSlotForm) {
      blockSlotForm.addEventListener('submit', function(e) {
        // Validate date is selected
        if (!slotDate || !slotDate.value) {
          e.preventDefault();
          alert('Please select a date');
          return false;
        }

        // Validate Slot 1 is filled
        const slot1Start = blockedSlotsContainer.querySelector('select[name="blocked_slots[0][start]"]');
        const slot1End = blockedSlotsContainer.querySelector('select[name="blocked_slots[0][end]"]');
        if (!slot1Start || !slot1Start.value || !slot1End || !slot1End.value) {
          e.preventDefault();
          alert('Slot 1 is required. Please fill in both start and end times.');
          return false;
        }

        // Process and clean up slots - disable empty slots so they won't be submitted
        const allSlotStarts = blockedSlotsContainer.querySelectorAll('select.time-start');
        const allSlotEnds = blockedSlotsContainer.querySelectorAll('select.time-end');

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
        const modal = bootstrap.Modal.getInstance(blockSlotModal);
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
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border-radius: 12px;
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
  }

  .availability-card:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
  }

  .availability-card-header {
    background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
    border-bottom: 2px solid #e0e6ed;
    padding: 1rem 1.25rem;
    border-radius: 12px 12px 0 0;
  }

  .availability-card-header h6 {
    color: #2d3748;
    font-weight: 600;
    margin: 0;
  }

  .availability-card-header i {
    font-size: 1.25rem;
  }

  .time-slots-wrapper {
    padding: 1.5rem;
    background: #ffffff;
    border-radius: 8px;
    border: 1px solid #e0e6ed;
  }

  .slot-card {
    background: #ffffff;
    border: 2px solid #e0e6ed;
    border-radius: 10px;
    padding: 1.25rem;
    transition: all 0.3s ease;
    height: 100%;
  }

  .slot-card:hover {
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
  }

  .slot-number {
    color: #667eea;
    font-weight: 600;
    font-size: 0.95rem;
  }

  .add-more-timing-btn {
    border: 2px dashed #667eea;
    color: #667eea;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .add-more-timing-btn:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
  }

  .btn-save {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    font-weight: 600;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
  }

  .availability-modal-footer {
    padding: 1.25rem 2rem;
    background: #ffffff;
    border-top: 1px solid #e0e6ed;
    border-radius: 0 0 0.5rem 0.5rem;
  }

  .availability-modal-dialog {
    max-width: 900px;
    width: 90%;
  }

  .availability-modal-dialog .modal-content {
    min-height: 500px;
  }

  @media (max-width: 768px) {
    .availability-modal-body {
      padding: 1.5rem 1rem;
    }

    .availability-modal-dialog {
      width: 95%;
    }
  }
</style>
@endsection
@endsection
