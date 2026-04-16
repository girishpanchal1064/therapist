@extends('layouts/contentNavbarLayout')

@section('title', 'Users Report')

@section('vendor-style')
<style>
:root {
    --theme-gradient: linear-gradient(90deg, #041C54 0%, #2f4a76 55%, #647494 100%);
}

.layout-page .content-wrapper {
    background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important;
}

.page-header {
    background: var(--theme-gradient);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 18px rgba(4, 28, 84, 0.28);
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
    border: 1px solid rgba(186, 194, 210, 0.35);
    border-radius: 16px;
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
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

</style>
@endsection

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
        <div>
            <h4 class="mb-1 fw-bold">Users Report</h4>
            <p class="mb-0 text-white opacity-75">Comprehensive user analytics and statistics</p>
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
                        <div class="text-muted small mb-1">Total Users</div>
                        <div class="h4 mb-0 fw-bold">{{ number_format($stats['total_users']) }}</div>
                    </div>
                    <i class="ri-user-line" style="font-size: 2.5rem; color: #647494; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">Total Clients</div>
                        <div class="h4 mb-0 fw-bold">{{ number_format($stats['total_clients']) }}</div>
                    </div>
                    <i class="ri-user-3-line" style="font-size: 2.5rem; color: #647494; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">Total Therapists</div>
                        <div class="h4 mb-0 fw-bold">{{ number_format($stats['total_therapists']) }}</div>
                    </div>
                    <i class="ri-user-heart-line" style="font-size: 2.5rem; color: #647494; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">New This Month</div>
                        <div class="h4 mb-0 fw-bold">{{ number_format($stats['new_this_month']) }}</div>
                    </div>
                    <i class="ri-user-add-line" style="font-size: 2.5rem; color: #647494; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4" style="border: 1px solid rgba(186, 194, 210, 0.35); border-radius: 16px; box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.users') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ $search }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="all" {{ $role == 'all' ? 'selected' : '' }}>All Roles</option>
                    <option value="Client" {{ $role == 'Client' ? 'selected' : '' }}>Client</option>
                    <option value="Therapist" {{ $role == 'Therapist' ? 'selected' : '' }}>Therapist</option>
                    <option value="Admin" {{ $role == 'Admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ $status == 'suspended' ? 'selected' : '' }}>Suspended</option>
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

<!-- Users Table -->
<div class="card" style="border: 1px solid rgba(186, 194, 210, 0.35); border-radius: 16px; box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05); overflow: hidden;">
    <div class="card-header" style="background: white; border-bottom: 2px solid #f0f2f5; padding: 1.5rem;">
        <h5 class="mb-0 fw-bold">Users List</h5>
    </div>
    <div class="card-body p-0" style="margin-top: 20px">
        <div class="table-responsive admin-table-scroll">
            <table class="table report-table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Registered Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td><strong>#{{ $user->id }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        @if($user->hasRole('Therapist') && $user->therapistProfile && $user->therapistProfile->profile_image)
                                            <img src="{{ asset('storage/' . $user->therapistProfile->profile_image) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                        @elseif($user->hasRole('Client') && $user->profile && $user->profile->profile_image)
                                            <img src="{{ asset('storage/' . $user->profile->profile_image) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                        @elseif($user->getRawOriginal('avatar'))
                                            <img src="{{ asset('storage/' . $user->getRawOriginal('avatar')) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=647494&color=fff&size=80&bold=true&format=svg" alt="{{ $user->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                        @endif
                                    </div>
                                    <span class="fw-semibold">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?: '-' }}</td>
                            <td>
                                @if($user->roles->count() > 0)
                                    <span class="badge bg-primary">{{ $user->roles->first()->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($user->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($user->status === 'suspended')
                                    <span class="badge bg-danger">Suspended</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="ri-user-line" style="font-size: 3rem; color: #dee2e6;"></i>
                                <p class="text-muted mt-3">No users found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
        <div class="card-footer bg-light">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection

