@extends('layouts/contentNavbarLayout')

@section('title', 'Appointments Report')

@section('vendor-style')
<style>
:root {
    --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.page-header {
    background: var(--theme-gradient);
    border-radius: 16px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.page-header h4 {
    color: white;
}

.stats-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--theme-gradient);
}

.report-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.report-table thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    color: #4a5568;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 18px 20px;
    border: none;
}

.report-table tbody td {
    padding: 18px 20px;
    border-bottom: 1px solid #f0f2f5;
    vertical-align: middle;
    color: #2d3748;
    font-size: 0.9rem;
}

.report-table tbody tr {
    background: white;
}

.report-table tbody tr:last-child td {
    border-bottom: none;
}
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
        <div>
            <h4 class="mb-1 fw-bold">Appointments Report</h4>
            <p class="mb-0 text-white opacity-75">Comprehensive appointment analytics and statistics</p>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">Total Appointments</div>
                        <div class="h4 mb-0 fw-bold">{{ number_format($stats['total']) }}</div>
                    </div>
                    <i class="ri-calendar-check-line" style="font-size: 2.5rem; color: #667eea; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">Completed</div>
                        <div class="h4 mb-0 fw-bold text-success">{{ number_format($stats['completed']) }}</div>
                    </div>
                    <i class="ri-checkbox-circle-line" style="font-size: 2.5rem; color: #10b981; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">This Month</div>
                        <div class="h4 mb-0 fw-bold">{{ number_format($stats['this_month']) }}</div>
                    </div>
                    <i class="ri-calendar-line" style="font-size: 2.5rem; color: #667eea; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">Cancelled</div>
                        <div class="h4 mb-0 fw-bold text-danger">{{ number_format($stats['cancelled']) }}</div>
                    </div>
                    <i class="ri-close-circle-line" style="font-size: 2.5rem; color: #ef4444; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.appointments') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search appointments..." value="{{ $search }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="scheduled" {{ $status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="confirmed" {{ $status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="all" {{ $type == 'all' ? 'selected' : '' }}>All Types</option>
                    <option value="consultation" {{ $type == 'consultation' ? 'selected' : '' }}>Consultation</option>
                    <option value="therapy" {{ $type == 'therapy' ? 'selected' : '' }}>Therapy</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Date From</label>
                <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Date To</label>
                <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ri-search-line"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Appointments Table -->
<div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
    <div class="card-header" style="background: white; border-bottom: 2px solid #f0f2f5; padding: 1.5rem;">
        <h5 class="mb-0 fw-bold">Appointments List</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Therapist</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td><strong>#{{ $appointment->id }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        @if($appointment->client)
                                            @if($appointment->client->profile && $appointment->client->profile->profile_image)
                                                <img src="{{ asset('storage/' . $appointment->client->profile->profile_image) }}" alt="{{ $appointment->client->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                            @elseif($appointment->client->getRawOriginal('avatar'))
                                                <img src="{{ asset('storage/' . $appointment->client->getRawOriginal('avatar')) }}" alt="{{ $appointment->client->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->client->name) }}&background=667eea&color=fff&size=80&bold=true&format=svg" alt="{{ $appointment->client->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                            @endif
                                        @endif
                                    </div>
                                    <span class="fw-semibold">{{ $appointment->client->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        @if($appointment->therapist)
                                            @if($appointment->therapist->therapistProfile && $appointment->therapist->therapistProfile->profile_image)
                                                <img src="{{ asset('storage/' . $appointment->therapist->therapistProfile->profile_image) }}" alt="{{ $appointment->therapist->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                            @elseif($appointment->therapist->getRawOriginal('avatar'))
                                                <img src="{{ asset('storage/' . $appointment->therapist->getRawOriginal('avatar')) }}" alt="{{ $appointment->therapist->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->therapist->name) }}&background=10b981&color=fff&size=80&bold=true&format=svg" alt="{{ $appointment->therapist->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                            @endif
                                        @endif
                                    </div>
                                    <span class="fw-semibold">{{ $appointment->therapist->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                            <td>{{ $appointment->appointment_time }}</td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($appointment->appointment_type) }}</span>
                            </td>
                            <td>
                                @if($appointment->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($appointment->status === 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @elseif($appointment->status === 'scheduled')
                                    <span class="badge bg-warning">Scheduled</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($appointment->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($appointment->payment)
                                    <strong>₹{{ number_format($appointment->payment->total_amount, 2) }}</strong>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="ri-calendar-check-line" style="font-size: 3rem; color: #dee2e6;"></i>
                                <p class="text-muted mt-3">No appointments found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($appointments->hasPages())
        <div class="card-footer bg-light">
            {{ $appointments->links() }}
        </div>
    @endif
</div>
@endsection
