@extends('layouts/contentNavbarLayout')

@section('title', 'Create Reward')

@section('vendor-style')
<style>
.layout-page .content-wrapper {
    background: linear-gradient(to bottom, #fff, rgba(186, 194, 210, 0.05)) !important;
}

/* Match admin dashboard header */
.dashboard-header {
    background: #041c54;
    border-radius: 24px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.dashboard-header::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
}

.dashboard-header h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.dashboard-header p {
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
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}

.btn-header-back {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}

.btn-header-back:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
}

/* Match dashboard content-card + stats top accent */
.form-card {
    border: 1px solid rgba(186, 194, 210, 0.3);
    border-radius: 16px;
    box-shadow: 0 10px 15px rgba(4, 28, 84, 0.05), 0 4px 6px rgba(4, 28, 84, 0.05);
    position: relative;
    overflow: hidden;
}

.form-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    z-index: 1;
}

.form-card .card-body > .row {
    margin-top: 20px;
}

.form-card .card-body > .row:first-child {
    margin-top: 0;
}

.form-section-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(186, 194, 210, 0.35);
    display: flex;
    align-items: center;
    color: #041C54;
}

.form-section-title i {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(100, 116, 148, 0.12);
    color: #647494;
    border-radius: 12px;
    margin-right: 0.75rem;
    font-size: 1.1rem;
}

.form-label {
    font-weight: 600;
    color: #041C54;
}

.form-control:focus, .form-select:focus {
    border-color: #647494;
    box-shadow: 0 0 0 0.2rem rgba(100, 116, 148, 0.12);
}

.form-card .form-check-input:checked {
    background-color: #041C54;
    border-color: #041C54;
}

.form-card-footer {
    background: #fff;
    border-top: 1px solid rgba(186, 194, 210, 0.35);
    padding: 1.25rem 1.5rem;
}

.btn-cancel-form {
    background: white;
    border: 2px solid rgba(186, 194, 210, 0.5);
    color: #647494;
    padding: 0.65rem 1.5rem;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.btn-cancel-form:hover {
    background: rgba(100, 116, 148, 0.08);
    border-color: #647494;
    color: #041C54;
}

.btn-save {
    background: linear-gradient(90deg, #041C54 0%, #647494 100%);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(4, 28, 84, 0.2);
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(4, 28, 84, 0.28);
    color: white;
}

@media (max-width: 768px) {
    .dashboard-header {
        padding: 1.5rem;
    }
}
</style>
@endsection

@section('content')
<div class="dashboard-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon">
                <i class="ri-gift-2-line"></i>
            </div>
            <div>
                <h4 class="mb-1">Create New Reward</h4>
                <p class="mb-0">Add a new reward, offer, or coupon code</p>
            </div>
        </div>
        <a href="{{ route('admin.rewards.index') }}" class="btn btn-header-back">
            <i class="ri-arrow-left-line me-2"></i>Back to List
        </a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="ri-error-warning-fill me-2 fs-5"></i>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('admin.rewards.store') }}" method="POST">
    @csrf
    <div class="card form-card">
        <div class="card-body p-4">
            <!-- Basic Information -->
            <div class="form-section-title">
                <i class="ri-information-line"></i>Basic Information
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="coupon_code" class="form-label">Coupon Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('coupon_code') is-invalid @enderror" id="coupon_code" name="coupon_code" value="{{ old('coupon_code') }}" placeholder="Leave empty to auto-generate" style="text-transform: uppercase;">
                    <small class="text-muted">Leave empty to auto-generate a random code</small>
                    @error('coupon_code')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="affiliation_url" class="form-label">Affiliation URL</label>
                    <input type="url" class="form-control @error('affiliation_url') is-invalid @enderror" id="affiliation_url" name="affiliation_url" value="{{ old('affiliation_url') }}" placeholder="https://example.com">
                    @error('affiliation_url')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Discount Information -->
            <div class="form-section-title mt-4">
                <i class="ri-price-tag-3-line"></i>Discount Information
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <label for="discount_type" class="form-label">Discount Type <span class="text-danger">*</span></label>
                    <select class="form-select @error('discount_type') is-invalid @enderror" id="discount_type" name="discount_type" required>
                        <option value="">Select Type</option>
                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                    </select>
                    @error('discount_type')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4" id="percentage_field" style="display: none;">
                    <label for="discount_percentage" class="form-label">Discount Percentage <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('discount_percentage') is-invalid @enderror" id="discount_percentage" name="discount_percentage" value="{{ old('discount_percentage') }}" min="0" max="100" step="0.01">
                    @error('discount_percentage')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4" id="fixed_field" style="display: none;">
                    <label for="discount_amount" class="form-label">Discount Amount (₹) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('discount_amount') is-invalid @enderror" id="discount_amount" name="discount_amount" value="{{ old('discount_amount') }}" min="0" step="0.01">
                    @error('discount_amount')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Validity & Settings -->
            <div class="form-section-title mt-4">
                <i class="ri-calendar-line"></i>Validity & Settings
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <label for="valid_from" class="form-label">Valid From (Date) <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('valid_from') is-invalid @enderror" id="valid_from" name="valid_from" value="{{ old('valid_from', now()->format('Y-m-d')) }}" required>
                    @error('valid_from')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="valid_until" class="form-label">Expire Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('valid_until') is-invalid @enderror" id="valid_until" name="valid_until" value="{{ old('valid_until') }}" required>
                    @error('valid_until')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="applicable_for" class="form-label">Applicable For <span class="text-danger">*</span></label>
                    <select class="form-select @error('applicable_for') is-invalid @enderror" id="applicable_for" name="applicable_for" required>
                        <option value="">Select</option>
                        <option value="therapist" {{ old('applicable_for') == 'therapist' ? 'selected' : '' }}>Therapist</option>
                        <option value="client" {{ old('applicable_for') == 'client' ? 'selected' : '' }}>Client</option>
                        <option value="both" {{ old('applicable_for') == 'both' ? 'selected' : '' }}>Both</option>
                    </select>
                    @error('applicable_for')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Terms & Conditions -->
            <div class="form-section-title mt-4">
                <i class="ri-file-text-line"></i>Terms & Conditions
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <label for="terms_conditions" class="form-label">Terms & Conditions</label>
                    <textarea class="form-control @error('terms_conditions') is-invalid @enderror" id="terms_conditions" name="terms_conditions" rows="5" placeholder="Enter each term on a new line">{{ old('terms_conditions') }}</textarea>
                    <small class="text-muted">Enter each term on a new line. They will be displayed as a list with checkmarks.</small>
                    @error('terms_conditions')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Additional Settings -->
            <div class="form-section-title mt-4">
                <i class="ri-settings-3-line"></i>Additional Settings
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="can_use_multiple_times" name="can_use_multiple_times" value="1" {{ old('can_use_multiple_times') ? 'checked' : '' }}>
                        <label class="form-check-label" for="can_use_multiple_times">
                            Can be used multiple times
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            Featured Reward
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="max_uses_per_user" class="form-label">Max Uses Per User</label>
                    <input type="number" class="form-control @error('max_uses_per_user') is-invalid @enderror" id="max_uses_per_user" name="max_uses_per_user" value="{{ old('max_uses_per_user') }}" min="1" placeholder="Leave empty for unlimited">
                    <small class="text-muted">Leave empty for unlimited uses per user</small>
                    @error('max_uses_per_user')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="total_max_uses" class="form-label">Total Max Uses</label>
                    <input type="number" class="form-control @error('total_max_uses') is-invalid @enderror" id="total_max_uses" name="total_max_uses" value="{{ old('total_max_uses') }}" min="1" placeholder="Leave empty for unlimited">
                    <small class="text-muted">Leave empty for unlimited total uses</small>
                    @error('total_max_uses')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card-footer form-card-footer d-flex justify-content-between flex-wrap gap-2">
            <a href="{{ route('admin.rewards.index') }}" class="btn btn-cancel-form">
                <i class="ri-close-line me-2"></i>Cancel
            </a>
            <button type="submit" class="btn btn-save">
                <i class="ri-save-line me-2"></i>Create Reward
            </button>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const discountType = document.getElementById('discount_type');
    const percentageField = document.getElementById('percentage_field');
    const fixedField = document.getElementById('fixed_field');

    function toggleDiscountFields() {
        if (discountType.value === 'percentage') {
            percentageField.style.display = 'block';
            fixedField.style.display = 'none';
            document.getElementById('discount_percentage').required = true;
            document.getElementById('discount_amount').required = false;
        } else if (discountType.value === 'fixed') {
            percentageField.style.display = 'none';
            fixedField.style.display = 'block';
            document.getElementById('discount_percentage').required = false;
            document.getElementById('discount_amount').required = true;
        } else {
            percentageField.style.display = 'none';
            fixedField.style.display = 'none';
            document.getElementById('discount_percentage').required = false;
            document.getElementById('discount_amount').required = false;
        }
    }

    discountType.addEventListener('change', toggleDiscountFields);
    toggleDiscountFields(); // Initial call
});
</script>
@endsection
