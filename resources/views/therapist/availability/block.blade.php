@extends('layouts/contentNavbarLayout')

@section('title', 'Block Availability')

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

  /* Button Group */
  .btn-group-block {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
  }

  .btn-block-date {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }

  .btn-block-date:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
  }

  .btn-block-slot {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  }

  .btn-block-slot:hover {
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

  /* Sr No */
  .sr-no {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: #374151;
  }

  /* Type Badge */
  .type-badge {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
  }

  .type-badge.by-slot {
    background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
    color: #4338ca;
    border: 1px solid #c7d2fe;
  }

  .type-badge.by-date {
    background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
    color: #7c3aed;
    border: 1px solid #d8b4fe;
  }

  /* Date Display */
  .date-display {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .date-range {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  .date-range .range-text {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.9375rem;
  }

  .date-range .date-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: #667eea;
  }

  /* Time Slots Display */
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

  .all-day-badge {
    background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
    color: #7c3aed;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    border: 1px solid #d8b4fe;
  }

  /* Reason */
  .reason-text {
    color: #64748b;
    font-size: 0.875rem;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  /* Status Badge */
  .status-badge {
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
  }

  .status-badge.blocked {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    color: #dc2626;
  }

  .status-badge.disabled {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    color: #15803d;
  }

  /* Action Buttons */
  .action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  .btn-action {
    padding: 0.5rem 0.75rem;
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

  .btn-action.btn-toggle {
    background: #f0fdf4;
    color: #15803d;
  }

  .btn-action.btn-toggle:hover {
    background: #dcfce7;
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

  .availability-modal-header.orange {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    margin-bottom: 1.5rem;
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

  .availability-card-header.orange {
    background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
    border-bottom: 2px solid #c7d2fe;
  }

  .availability-card-header h6 {
    color: #4338ca;
    font-size: 1rem;
  }

  .availability-card-header.orange h6 {
    color: #4338ca;
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
  .slot-card .form-control,
  .availability-card .form-control {
    border-radius: 6px;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
  }

  .slot-card .form-select:focus,
  .slot-card .form-control:focus,
  .availability-card .form-control:focus {
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

  .btn-save.orange {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);
  }

  .btn-save.orange:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    box-shadow: 0 6px 12px rgba(102, 126, 234, 0.4);
  }

  .availability-modal-body .form-label {
    color: #2d3748;
    font-size: 0.9375rem;
  }

  .availability-modal-body .form-label i {
    font-size: 1.125rem;
  }

  .availability-modal-dialog {
    max-width: 900px;
    width: 90%;
  }

  .availability-modal-dialog .modal-content {
    min-height: 500px;
    border-radius: 0.5rem;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .availability-page-header {
      padding: 1.5rem;
    }

    .availability-modal-body {
      padding: 1.5rem 1rem;
    }

    .availability-modal-dialog {
      width: 95%;
    }

    .action-buttons {
      flex-direction: column;
    }

    .btn-group-block {
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
          <i class="ri-calendar-close-line"></i>
        </div>
        <div>
          <h4 class="mb-1">Block Availability</h4>
          <p class="mb-0">Block dates or time slots when you're unavailable</p>
        </div>
      </div>
    </div>

    <!-- Main Card -->
    <div class="card availability-main-card">
      <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
          <h5 class="mb-1">Blocked Schedule</h5>
          <p class="text-muted mb-0 small">Manage your blocked dates and time slots</p>
        </div>
        <div class="btn-group-block">
          <button type="button" class="btn btn-block-date" data-bs-toggle="modal" data-bs-target="#blockDateModal">
            <i class="ri-calendar-close-line me-1"></i> Block by Date
          </button>
          <button type="button" class="btn btn-block-slot" data-bs-toggle="modal" data-bs-target="#blockSlotModal">
            <i class="ri-time-line me-1"></i> Block by Slot
          </button>
        </div>
      </div>
      <div class="card-body">
        @if($blocks->count() > 0)
          <div class="table-responsive">
            <table class="table availability-table mb-0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Type</th>
                  <th>Blocked Date</th>
                  <th>Blocked Time</th>
                  <th>Reason</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($blocks as $i => $block)
                  <tr>
                    <td>
                      <div class="sr-no">{{ $i + 1 }}</div>
                    </td>
                    <td>
                      @if($block->date)
                        <span class="type-badge by-slot">
                          <i class="ri-time-line"></i>
                          Block by Slot
                        </span>
                      @else
                        <span class="type-badge by-date">
                          <i class="ri-calendar-line"></i>
                          Block by Date
                        </span>
                      @endif
                    </td>
                    <td>
                      <div class="date-display">
                        <div class="date-range">
                          @if($block->date)
                            <span class="range-text">{{ $block->date->format('M d, Y') }}</span>
                          @else
                            <span class="range-text">
                              {{ $block->start_date?->format('M d, Y') }} 
                              <i class="ri-arrow-right-line mx-1 text-muted"></i>
                              {{ $block->end_date?->format('M d, Y') }}
                            </span>
                          @endif
                        </div>
                      </div>
                    </td>
                    <td>
                      @if($block->blocked_slots)
                        <div class="time-slots-display">
                          @foreach($block->blocked_slots as $slot)
                            <span class="time-badge">
                              <i class="ri-time-line"></i>
                              {{ $slot['start'] }} - {{ $slot['end'] }}
                            </span>
                          @endforeach
                        </div>
                      @else
                        <span class="all-day-badge">
                          <i class="ri-calendar-2-line me-1"></i>
                          All Day
                        </span>
                      @endif
                    </td>
                    <td>
                      <span class="reason-text" title="{{ $block->reason ?? 'No reason provided' }}">
                        {{ $block->reason ?? '-' }}
                      </span>
                    </td>
                    <td>
                      @if($block->is_active)
                        <span class="status-badge blocked">
                          <i class="ri-close-circle-fill"></i>
                          Blocked
                        </span>
                      @else
                        <span class="status-badge disabled">
                          <i class="ri-checkbox-circle-line"></i>
                          Restored
                        </span>
                      @endif
                    </td>
                    <td>
                      <div class="action-buttons">
                        <button type="button" class="btn btn-action btn-edit edit-block-btn" 
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
                          <i class="ri-edit-line"></i>
                        </button>
                        <form method="POST" action="{{ route('therapist.availability.block.toggle', $block) }}" class="d-inline">
                          @csrf
                          <button class="btn btn-action btn-toggle" type="submit" title="{{ $block->is_active ? 'Restore' : 'Block again' }}">
                            <i class="ri-{{ $block->is_active ? 'checkbox-circle-line' : 'close-circle-line' }}"></i>
                          </button>
                        </form>
                        <form method="POST" action="{{ route('therapist.availability.block.destroy', $block) }}" class="d-inline delete-form">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-action btn-delete" type="submit" data-title="Delete Block" data-text="Are you sure you want to delete this block? This action cannot be undone." data-confirm-text="Yes, delete it!" data-cancel-text="Cancel">
                            <i class="ri-delete-bin-line"></i>
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
              <i class="ri-calendar-close-line"></i>
            </div>
            <h5>No Blocked Schedule</h5>
            <p>Block dates or time slots when you're not available for sessions.</p>
            <div class="btn-group-block justify-content-center">
              <button type="button" class="btn btn-block-date" data-bs-toggle="modal" data-bs-target="#blockDateModal">
                <i class="ri-calendar-close-line me-1"></i> Block by Date
              </button>
              <button type="button" class="btn btn-block-slot" data-bs-toggle="modal" data-bs-target="#blockSlotModal">
                <i class="ri-time-line me-1"></i> Block by Slot
              </button>
            </div>
          </div>
        @endif
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
                <h5 class="modal-title mb-0 fw-bold">Block by Date Range</h5>
              </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body availability-modal-body">
            <form method="POST" action="{{ route('therapist.availability.block.date.store') }}" id="block-date-form">
              @csrf
              <input type="hidden" name="_method" id="block-date-method" value="POST">
              <input type="hidden" name="block_id" id="block-date-id" value="">

              <div class="card availability-card">
                <div class="card-header availability-card-header">
                  <div class="d-flex align-items-center">
                    <i class="ri-calendar-2-line me-2 text-primary"></i>
                    <h6 class="mb-0 fw-semibold">Select Date Range</h6>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row g-3 mt-2">
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
                      <input type="text" name="reason" class="form-control" placeholder="e.g., Vacation, Personal day, Conference...">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Info Box -->
              <div class="alert d-flex align-items-start mt-0" style="background: #f0f4ff; border: 1px solid #c7d2fe; border-radius: 10px;">
                <i class="ri-information-line me-2 mt-1" style="color: #4338ca;"></i>
                <div style="color: #4338ca;">
                  <strong>Note:</strong> Blocking by date will make you unavailable for the entire day(s). Clients won't be able to book sessions during this period.
                </div>
              </div>
            </form>
          </div>

          <!-- Modal Footer -->
          <div class="modal-footer availability-modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
              <i class="ri-close-line me-1"></i> Cancel
            </button>
            <button type="submit" form="block-date-form" class="btn btn-save">
              <i class="ri-calendar-close-line me-1"></i> BLOCK DATES
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
          <div class="modal-header text-white availability-modal-header orange">
            <div class="d-flex align-items-center">
              <div>
                <h5 class="modal-title mb-0 fw-bold">Block Specific Time Slots</h5>
              </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body availability-modal-body">
            <form method="POST" action="{{ route('therapist.availability.block.slot.store') }}" id="block-slot-form">
              @csrf
              <input type="hidden" name="_method" id="block-slot-method" value="POST">
              <input type="hidden" name="block_id" id="block-slot-id" value="">

              <!-- Date Selection -->
              <div class="card availability-card">
                <div class="card-header availability-card-header orange">
                  <div class="d-flex align-items-center">
                    <i class="ri-calendar-2-line me-2 text-primary"></i>
                    <h6 class="mb-0 fw-semibold">Select Date</h6>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row g-3 mt-2">
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
                      <input type="text" name="reason" class="form-control" placeholder="e.g., Doctor appointment, Meeting...">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Time Slots to Block -->
              <div class="card availability-card">
                <div class="card-header availability-card-header orange">
                  <div class="d-flex align-items-center">
                    <i class="ri-time-line me-2 text-primary"></i>
                    <h6 class="mb-0 fw-semibold">Time Slots to Block</h6>
                  </div>
                </div>
                <div class="card-body mt-2">
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
          <div class="modal-footer availability-modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
              <i class="ri-close-line me-1"></i> Cancel
            </button>
            <button type="submit" form="block-slot-form" class="btn btn-save orange">
              <i class="ri-time-line me-1"></i> BLOCK SLOTS
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
    // Block by Date Modal
    const blockDateModal = document.getElementById('blockDateModal');
    const blockDateForm = document.getElementById('block-date-form');
    const blockStart = document.getElementById('block-start');
    const blockEnd = document.getElementById('block-end');
    const updateDateRouteBase = '{{ route("therapist.availability.block.date.update", 0) }}'.replace('/0', '');

    // Block by Slot Modal
    const blockSlotModal = document.getElementById('blockSlotModal');
    const blockSlotForm = document.getElementById('block-slot-form');
    const blockedSlotsContainer = document.getElementById('blocked-slots');
    const addBlockSlotBtn = document.getElementById('add-block-slot');
    const slotDate = document.getElementById('slot-date');
    const updateSlotRouteBase = '{{ route("therapist.availability.block.slot.update", 0) }}'.replace('/0', '');
    let editSlotData = null;

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

      populateTimes(newSlot);
    }

    // Block by Date Modal Events
    if (blockDateModal) {
      blockDateModal.addEventListener('shown.bs.modal', function() {
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
          blockDateForm.action = '{{ route('therapist.availability.block.date.store') }}';
          const formMethod = document.getElementById('block-date-method');
          const blockIdInput = document.getElementById('block-date-id');
          if (formMethod) formMethod.value = 'POST';
          if (blockIdInput) blockIdInput.value = '';
          
          const modalTitle = blockDateModal.querySelector('.modal-title');
          if (modalTitle) {
            modalTitle.textContent = 'Block by Date Range';
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
        
        if (formMethod && formMethod.value === 'POST') {
          if (slotDate && !slotDate.value) {
            const today = new Date().toISOString().slice(0, 10);
            slotDate.value = today;
          }
        }
        
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
            editSlotData = null;
          }, 50);
        }
      });
      
      blockSlotModal.addEventListener('hidden.bs.modal', function() {
        if (blockSlotForm) {
          blockSlotForm.action = '{{ route('therapist.availability.block.slot.store') }}';
          const formMethod = document.getElementById('block-slot-method');
          const blockIdInput = document.getElementById('block-slot-id');
          if (formMethod) formMethod.value = 'POST';
          if (blockIdInput) blockIdInput.value = '';
          
          editSlotData = null;
          
          const modalTitle = blockSlotModal.querySelector('.modal-title');
          if (modalTitle) {
            modalTitle.textContent = 'Block Specific Time Slots';
          }
          
          blockSlotForm.reset();
          blockedSlotsContainer.setAttribute('data-slot-count', '1');
          const slots = blockedSlotsContainer.querySelectorAll('.col-md-3');
          slots.forEach((slot, slotIndex) => {
            if (slotIndex >= 1) {
              slot.remove();
            }
          });
          if (slotDate) {
            const today = new Date().toISOString().slice(0, 10);
            slotDate.value = today;
          }
        }
      });
    }

    if (addBlockSlotBtn) {
      addBlockSlotBtn.addEventListener('click', addMoreTimingSlot);
    }

    document.querySelectorAll('.edit-block-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const blockData = JSON.parse(this.getAttribute('data-block-data'));
        const blockType = this.getAttribute('data-block-type');
        const blockId = this.getAttribute('data-block-id');
        
        if (blockType === 'date') {
          const formMethod = document.getElementById('block-date-method');
          const blockIdInput = document.getElementById('block-date-id');
          
          blockDateForm.action = updateDateRouteBase + '/' + blockId;
          formMethod.value = 'PUT';
          blockIdInput.value = blockId;
          
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
          
          const modalTitle = blockDateModal.querySelector('.modal-title');
          if (modalTitle) {
            modalTitle.textContent = 'Edit Block by Date';
          }
          
          const modal = new bootstrap.Modal(blockDateModal);
          modal.show();
        } else {
          const formMethod = document.getElementById('block-slot-method');
          const blockIdInput = document.getElementById('block-slot-id');
          
          blockSlotForm.action = updateSlotRouteBase + '/' + blockId;
          formMethod.value = 'PUT';
          blockIdInput.value = blockId;
          
          editSlotData = blockData.blocked_slots || [];
          
          if (slotDate && blockData.date) {
            slotDate.value = blockData.date;
          }
          
          const reasonInput = blockSlotForm.querySelector('input[name="reason"]');
          if (reasonInput && blockData.reason) {
            reasonInput.value = blockData.reason;
          }
          
          blockedSlotsContainer.innerHTML = '';
          blockedSlotsContainer.setAttribute('data-slot-count', blockData.blocked_slots ? blockData.blocked_slots.length : 1);
          
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
          
          const modalTitle = blockSlotModal.querySelector('.modal-title');
          if (modalTitle) {
            modalTitle.textContent = 'Edit Block by Slot';
          }
          
          const modal = new bootstrap.Modal(blockSlotModal);
          modal.show();
        }
      });
    });

    if (blockDateForm) {
      blockDateForm.addEventListener('submit', function(e) {
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

        const modal = bootstrap.Modal.getInstance(blockDateModal);
        if (modal) {
          setTimeout(() => {
            modal.hide();
          }, 100);
        }

        return true;
      });
    }

    if (blockSlotForm) {
      blockSlotForm.addEventListener('submit', function(e) {
        if (!slotDate || !slotDate.value) {
          e.preventDefault();
          alert('Please select a date');
          return false;
        }

        const slot1Start = blockedSlotsContainer.querySelector('select[name="blocked_slots[0][start]"]');
        const slot1End = blockedSlotsContainer.querySelector('select[name="blocked_slots[0][end]"]');
        if (!slot1Start || !slot1Start.value || !slot1End || !slot1End.value) {
          e.preventDefault();
          alert('Slot 1 is required. Please fill in both start and end times.');
          return false;
        }

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
