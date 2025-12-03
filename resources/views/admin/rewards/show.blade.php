@extends('layouts/contentNavbarLayout')

@section('title', 'Reward Details')

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
    position: relative;
    z-index: 1;
}

.info-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.info-card .card-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #eef1f6 100%);
    border-bottom: 2px solid #f0f2f5;
    padding: 1.25rem 1.5rem;
}

.info-card .card-header h6 {
    color: #4a5568;
    font-weight: 700;
    margin: 0;
}

.info-item {
    padding: 1rem 0;
    border-bottom: 1px solid #f0f2f5;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.info-value {
    font-size: 1rem;
    font-weight: 500;
    color: #212529;
}

.badge-status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

.badge-active {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    color: #059669;
}

.badge-inactive {
    background: linear-gradient(135deg, rgba(107, 114, 128, 0.15) 0%, rgba(75, 85, 99, 0.15) 100%);
    color: #6b7280;
}

.badge-expired {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
    color: #dc2626;
}

.badge-featured {
    background: linear-gradient(135deg, rgba(255, 107, 157, 0.15) 0%, rgba(255, 143, 171, 0.15) 100%);
    color: #ff6b9d;
}

.badge-discount {
    background: var(--theme-gradient);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 1rem;
}

.coupon-code-display {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border: 3px dashed #667eea;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    margin: 1rem 0;
}

.coupon-code-display code {
    font-size: 2rem;
    font-weight: 700;
    color: #667eea;
    letter-spacing: 3px;
    background: transparent;
    padding: 0;
}

.btn-action {
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-edit {
    background: var(--theme-gradient);
    border: none;
    color: white;
}

.btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
        <div>
            <h4 class="mb-1 fw-bold">Reward Details</h4>
            <p class="mb-0 text-white opacity-75">View complete reward information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.rewards.edit', $reward->id) }}" class="btn btn-light">
                <i class="ri-pencil-line me-2"></i>Edit
            </a>
            <a href="{{ route('admin.rewards.index') }}" class="btn btn-light">
                <i class="ri-arrow-left-line me-2"></i>Back to List
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Left Column - Basic Information -->
    <div class="col-lg-8">
        <!-- Basic Information -->
        <div class="card info-card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="ri-information-line me-2"></i>Basic Information
                </h6>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <div class="info-label">Title</div>
                    <div class="info-value">{{ $reward->title }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Description</div>
                    <div class="info-value">{{ $reward->description ?: 'No description provided' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Affiliation URL</div>
                    <div class="info-value">
                        @if($reward->affiliation_url)
                            <a href="{{ $reward->affiliation_url }}" target="_blank" class="text-primary text-decoration-none">
                                <i class="ri-external-link-line me-1"></i>{{ $reward->affiliation_url }}
                            </a>
                        @else
                            <span class="text-muted">Not provided</span>
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Coupon Code</div>
                    <div class="coupon-code-display">
                        <code>{{ $reward->coupon_code }}</code>
                    </div>
                </div>
            </div>
        </div>

        <!-- Discount Information -->
        <div class="card info-card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="ri-price-tag-3-line me-2"></i>Discount Information
                </h6>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <div class="info-label">Discount Type</div>
                    <div class="info-value">
                        <span class="badge bg-primary">{{ ucfirst($reward->discount_type) }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Discount</div>
                    <div class="info-value">
                        <span class="badge-discount">{{ $reward->discount_text }}</span>
                    </div>
                </div>
                @if($reward->discount_type === 'percentage')
                    <div class="info-item">
                        <div class="info-label">Discount Percentage</div>
                        <div class="info-value">{{ $reward->discount_percentage }}%</div>
                    </div>
                @else
                    <div class="info-item">
                        <div class="info-label">Discount Amount</div>
                        <div class="info-value">₹{{ number_format($reward->discount_amount, 2) }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Terms & Conditions -->
        @if($reward->terms_conditions)
        <div class="card info-card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="ri-file-text-line me-2"></i>Terms & Conditions
                </h6>
            </div>
            <div class="card-body">
                @php
                    $terms = explode("\n", $reward->terms_conditions);
                @endphp
                <ul class="list-unstyled mb-0">
                    @foreach($terms as $term)
                        @if(trim($term))
                            <li class="mb-2 d-flex align-items-start">
                                <i class="ri-checkbox-circle-fill text-success me-2 mt-1"></i>
                                <span>{{ trim($term) }}</span>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>

    <!-- Right Column - Settings & Statistics -->
    <div class="col-lg-4">
        <!-- Status & Settings -->
        <div class="card info-card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="ri-settings-3-line me-2"></i>Status & Settings
                </h6>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        @if($reward->valid_until < now())
                            <span class="badge-status badge-expired">Expired</span>
                        @elseif($reward->is_active)
                            <span class="badge-status badge-active">Active</span>
                        @else
                            <span class="badge-status badge-inactive">Inactive</span>
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Featured</div>
                    <div class="info-value">
                        @if($reward->is_featured)
                            <span class="badge-status badge-featured">
                                <i class="ri-star-fill me-1"></i>Featured
                            </span>
                        @else
                            <span class="text-muted">No</span>
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Applicable For</div>
                    <div class="info-value">
                        <span class="badge bg-info">{{ ucfirst($reward->applicable_for) }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Multiple Uses</div>
                    <div class="info-value">
                        @if($reward->can_use_multiple_times)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </div>
                </div>
                @if($reward->max_uses_per_user)
                    <div class="info-item">
                        <div class="info-label">Max Uses Per User</div>
                        <div class="info-value">{{ $reward->max_uses_per_user }}</div>
                    </div>
                @endif
                @if($reward->total_max_uses)
                    <div class="info-item">
                        <div class="info-label">Total Max Uses</div>
                        <div class="info-value">{{ $reward->total_max_uses }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Validity Period -->
        <div class="card info-card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="ri-calendar-line me-2"></i>Validity Period
                </h6>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <div class="info-label">Valid From</div>
                    <div class="info-value">
                        <i class="ri-calendar-check-line me-1"></i>
                        {{ $reward->valid_from->format('F d, Y') }}
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Expire Date</div>
                    <div class="info-value {{ $reward->valid_until < now() ? 'text-danger' : '' }}">
                        <i class="ri-calendar-close-line me-1"></i>
                        {{ $reward->valid_until->format('F d, Y') }}
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Days Remaining</div>
                    <div class="info-value">
                        @if($reward->valid_until < now())
                            <span class="text-danger">Expired</span>
                        @else
                            <span class="text-success">{{ $reward->valid_until->diffInDays(now()) }} days</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card info-card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="ri-bar-chart-line me-2"></i>Statistics
                </h6>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <div class="info-label">Total Claims</div>
                    <div class="info-value">
                        <strong>{{ $reward->userRewards()->count() }}</strong>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Active Claims</div>
                    <div class="info-value">
                        <strong>{{ $reward->userRewards()->where('status', 'claimed')->count() }}</strong>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Used</div>
                    <div class="info-value">
                        <strong>{{ $reward->userRewards()->where('status', 'used')->count() }}</strong>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Expired</div>
                    <div class="info-value">
                        <strong>{{ $reward->userRewards()->where('status', 'expired')->count() }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card info-card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.rewards.edit', $reward->id) }}" class="btn btn-action btn-edit">
                        <i class="ri-pencil-line me-2"></i>Edit Reward
                    </a>
                    <form action="{{ route('admin.rewards.destroy', $reward->id) }}" method="POST" class="delete-form" data-title="Delete Reward" data-text="Are you sure you want to delete this reward? This action cannot be undone.">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="ri-delete-bin-line me-2"></i>Delete Reward
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
