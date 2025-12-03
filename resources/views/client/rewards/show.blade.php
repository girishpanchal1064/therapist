@extends('layouts/contentNavbarLayout')

@section('title', 'Reward Details')

@section('vendor-style')
<style>
:root {
    --theme-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.reward-card {
    background: linear-gradient(135deg, #eef1f6 0%, #f8f9fc 100%);
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
}

.reward-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(102, 126, 234, 0.05);
    border-radius: 50%;
}

.reward-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #212529;
    margin-bottom: 1rem;
    text-align: center;
}

.reward-description {
    font-size: 1.1rem;
    color: #6c757d;
    text-align: center;
    margin-bottom: 2rem;
}

.terms-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin: 2rem 0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.terms-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #212529;
    text-align: center;
    margin-bottom: 1.5rem;
}

.terms-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.terms-list li {
    padding: 1rem;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border-radius: 12px;
    border-left: 4px solid #28a745;
}

.terms-list li i {
    color: #28a745;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.coupon-section {
    text-align: center;
    margin: 2rem 0;
}

.coupon-text {
    font-size: 1rem;
    color: #6c757d;
    margin-bottom: 1rem;
}

.coupon-code {
    display: inline-block;
    font-size: 2rem;
    font-weight: 700;
    color: #212529;
    padding: 1rem 2rem;
    border: 3px dashed #ff6b9d;
    border-radius: 12px;
    background: white;
    margin: 1rem 0;
    letter-spacing: 2px;
}

.btn-claim {
    background: var(--theme-gradient);
    border: none;
    color: white;
    padding: 1rem 3rem;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-claim:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-claim:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.alert-themed {
    border: none;
    border-radius: 12px;
    border-left: 5px solid;
}

.alert-themed.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border-left-color: #28a745;
    color: #155724;
}

.alert-themed.alert-info {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    border-left-color: #17a2b8;
    color: #0c5460;
}
</style>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-themed alert-success alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="ri-checkbox-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="ri-error-warning-fill me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-themed alert-info alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="ri-information-line me-2 fs-5"></i>
            <div>{{ session('info') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="reward-card">
                <h1 class="reward-title">{{ $reward->title }}</h1>
                @if($reward->description)
                    <p class="reward-description">{{ $reward->description }}</p>
                @else
                    <p class="reward-description">Exclusive offer of {{ $reward->discount_text }} on {{ $reward->title }}</p>
                @endif

                <div class="terms-card">
                    <h3 class="terms-title">Terms & Conditions</h3>
                    <ul class="terms-list">
                        @if($reward->terms_conditions)
                            @php
                                $terms = explode("\n", $reward->terms_conditions);
                            @endphp
                            @foreach($terms as $term)
                                @if(trim($term))
                                    <li>
                                        <i class="ri-checkbox-circle-fill"></i>
                                        <span>{{ trim($term) }}</span>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <li>
                                <i class="ri-checkbox-circle-fill"></i>
                                <span>Offer is applicable on purchase {{ $reward->title }} only.</span>
                            </li>
                            <li>
                                <i class="ri-checkbox-circle-fill"></i>
                                <span>Offer is applicable all all cities across India</span>
                            </li>
                            <li>
                                <i class="ri-checkbox-circle-fill"></i>
                                <span>Coupon code can be used {{ $reward->can_use_multiple_times ? 'multiple times' : 'once' }}.</span>
                            </li>
                            <li>
                                <i class="ri-checkbox-circle-fill"></i>
                                <span>Offer applicable for all new and repeat users.</span>
                            </li>
                            <li>
                                <i class="ri-checkbox-circle-fill"></i>
                                <span>Coupon code valid until {{ $reward->valid_until->format('F d, Y') }}</span>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="coupon-section">
                    @if($userReward)
                        <p class="coupon-text">Click here to claim this offer, Your coupon code is</p>
                        <div class="coupon-code">{{ $userReward->coupon_code }}</div>
                        <p class="text-muted small mt-2">Status: <span class="badge bg-success">{{ ucfirst($userReward->status) }}</span></p>
                        <p class="text-muted small">Claimed on: {{ $userReward->claimed_at->format('F d, Y') }}</p>
                    @else
                        <p class="coupon-text">Click here to claim this offer, Your coupon code is</p>
                        @if($reward->canBeClaimedBy(auth()->user()))
                            <form action="{{ route('client.rewards.claim', $reward->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-claim">
                                    <i class="ri-gift-line me-2"></i>Claim Reward
                                </button>
                            </form>
                        @else
                            <button type="button" class="btn btn-claim" disabled>
                                <i class="ri-close-circle-line me-2"></i>Not Available
                            </button>
                            <p class="text-danger small mt-2">This reward cannot be claimed at this time.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
