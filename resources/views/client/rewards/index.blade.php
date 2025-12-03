@extends('layouts/contentNavbarLayout')

@section('title', 'Rewards')

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
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.reward-card {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    height: 100%;
    border: 2px solid #f0f2f5;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.reward-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: var(--theme-gradient);
}

.reward-card-featured {
    border: 2px solid #ff6b9d;
    box-shadow: 0 8px 30px rgba(255, 107, 157, 0.2);
}

.reward-card-featured::before {
    background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
}

.reward-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
}

.reward-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #212529;
    margin: 0;
    line-height: 1.3;
}

.badge-featured {
    background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
    color: white;
    padding: 0.4rem 1rem;
    border-radius: 25px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 4px 12px rgba(255, 107, 157, 0.3);
}

.reward-description {
    color: #6c757d;
    margin-bottom: 1.5rem;
    line-height: 1.6;
    font-size: 0.95rem;
    min-height: 50px;
}

.reward-discount-section {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    text-align: center;
    border: 2px dashed #667eea;
}

.reward-discount-label {
    font-size: 0.85rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.reward-discount {
    font-size: 2.5rem;
    font-weight: 700;
    background: var(--theme-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
}

.reward-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 2px solid #f0f2f5;
}

.reward-validity {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6c757d;
    font-size: 0.9rem;
}

.reward-validity i {
    color: #667eea;
}

.btn-view {
    background: var(--theme-gradient);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
}

.btn-view:hover {
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
    transform: translateY(-2px);
}

.empty-state {
    text-align: center;
    padding: 5rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.empty-state i {
    font-size: 5rem;
    color: #dee2e6;
    margin-bottom: 1.5rem;
}

.empty-state h4 {
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #6c757d;
}
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
        <div>
            <h4 class="mb-1 fw-bold text-white">Rewards & Offers</h4>
            <p class="mb-0 text-white opacity-75">Claim exclusive rewards and discounts</p>
        </div>
        <i class="ri-gift-line" style="font-size: 3rem; opacity: 0.3;"></i>
    </div>
</div>

@if($rewards->count() > 0)
    <div class="row g-4">
        @foreach($rewards as $reward)
            <div class="col-md-6 col-lg-4">
                <div class="reward-card {{ $reward->is_featured ? 'reward-card-featured' : '' }}">
                    <div class="reward-header">
                        <h3 class="reward-title">{{ $reward->title }}</h3>
                        @if($reward->is_featured)
                            <span class="badge-featured">
                                <i class="ri-star-fill"></i>Featured
                            </span>
                        @endif
                    </div>
                    
                    <p class="reward-description">
                        {{ $reward->description ?: 'Exclusive offer of ' . $reward->discount_text . ' on ' . $reward->title }}
                    </p>
                    
                    <div class="reward-discount-section">
                        <div class="reward-discount-label">Discount</div>
                        <div class="reward-discount">{{ $reward->discount_text }}</div>
                    </div>
                    
                    <div class="reward-footer">
                        <div class="reward-validity">
                            <i class="ri-calendar-line"></i>
                            <span>Valid until {{ $reward->valid_until->format('M d, Y') }}</span>
                        </div>
                        <a href="{{ route('client.rewards.show', $reward->id) }}" class="btn btn-view">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $rewards->links() }}
    </div>
@else
    <div class="empty-state">
        <i class="ri-gift-line"></i>
        <h4>No Rewards Available</h4>
        <p class="text-muted">Check back later for exciting rewards and offers!</p>
    </div>
@endif
@endsection
