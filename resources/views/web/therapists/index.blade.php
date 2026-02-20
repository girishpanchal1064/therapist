@extends('layouts.app')

@section('title', 'Find Your Perfect Therapist - Apani Psychology')

@section('head')
<style>
    /* Therapist Card Styles - Two Column Layout */
    .therapist-card {
        background: white;
        border-radius: 16px;
        overflow: visible;
        transition: all 0.3s ease;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        position: relative;
        height: 100%;
        padding: 1.5rem;
        min-height: 380px;
    }
    .therapist-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }
    .therapist-card-inner {
        display: flex;
        gap: 1.25rem;
        height: 100%;
    }
    /* Left Column - Profile Info */
    .therapist-left {
        flex: 0 0 auto;
        text-align: center;
        width: 140px;
    }
    .therapist-avatar-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
    }
    .therapist-avatar-ring {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        padding: 4px;
        background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .therapist-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background: white;
    }
    .therapist-avatar-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        color: #ec4899;
    }
    .therapist-name {
        color: #0d9488;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
        line-height: 1.3;
    }
    .therapist-specialization {
        color: #374151;
        font-size: 0.85rem;
        margin-bottom: 0.2rem;
    }
    .therapist-title {
        color: #6b7280;
        font-size: 0.85rem;
        margin-bottom: 0.2rem;
    }
    .therapist-experience {
        color: #6b7280;
        font-size: 0.85rem;
        margin-bottom: 0.2rem;
    }
    .therapist-qualification {
        color: #6b7280;
        font-size: 0.85rem;
        margin-bottom: 0.6rem;
    }
    .therapist-rating {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
        margin-bottom: 0.3rem;
    }
    .therapist-rating svg {
        width: 18px;
        height: 18px;
        color: #fbbf24;
    }
    .therapist-rating .rating-value {
        font-size: 0.9rem;
        color: #374151;
        font-weight: 600;
    }
    .therapist-reviews {
        font-size: 0.8rem;
        color: #f59e0b;
    }
    /* Right Column - Actions */
    .therapist-right {
        flex: 1;
        display: flex;
        flex-direction: column;
        position: relative;
        padding-top: 2.5rem;
    }
    .see-availability {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.8rem;
        color: #0d9488;
        background: linear-gradient(135deg, #ccfbf1 0%, #99f6e4 100%);
        padding: 0.4rem 0.85rem;
        border-radius: 20px;
        font-weight: 500;
        text-decoration: none;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }
    .see-availability:hover {
        background: linear-gradient(135deg, #99f6e4 0%, #5eead4 100%);
        color: #0f766e;
        transform: translateY(-1px);
    }
    .see-availability svg {
        width: 14px;
        height: 14px;
    }
    .recommend-badge {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: #0d9488;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 10;
        box-shadow: 0 2px 8px rgba(13, 148, 136, 0.3);
    }
    .recommend-badge svg {
        width: 15px;
        height: 15px;
    }
    .online-status {
        font-size: 1.2rem;
        color: #374151;
        font-style: italic;
        margin-bottom: 0.75rem;
    }
    .session-price {
        margin-bottom: 1.25rem;
    }
    .session-price-label {
        font-size: 0.9rem;
        color: #6b7280;
    }
    .session-price-amount {
        font-size: 1.75rem;
        font-weight: 700;
        color: #ec4899;
    }
    .btn-book-session {
        display: block;
        width: 100%;
        background: linear-gradient(135deg, #f472b6 0%, #ec4899 100%);
        color: white;
        padding: 0.85rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 0.6rem;
        font-size: 0.95rem;
    }
    .btn-book-session:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(236, 72, 153, 0.35);
        color: white;
    }
    .btn-view-profile {
        display: block;
        width: 100%;
        background: #0d9488;
        color: white;
        padding: 0.85rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }
    .btn-view-profile:hover {
        background: #0f766e;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(13, 148, 136, 0.35);
    }

    /* =============== LIST VIEW STYLES =============== */
    .therapist-list-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
    .therapist-list-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    }
    .therapist-list-inner {
        display: flex;
        align-items: center;
        gap: 2rem;
    }
    /* List - Avatar Section */
    .list-avatar-section {
        flex: 0 0 auto;
        text-align: center;
    }
    .list-avatar-ring {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        padding: 4px;
        background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .list-avatar-ring img,
    .list-avatar-ring .list-avatar-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background: white;
    }
    .list-avatar-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        font-weight: 700;
        color: #ec4899;
        background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%) !important;
    }
    /* List - Info Section */
    .list-info-section {
        flex: 1;
        min-width: 0;
    }
    .list-therapist-name {
        color: #0d9488;
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    .list-meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
        color: #6b7280;
    }
    .list-meta-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    .list-rating {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    .list-rating svg {
        width: 16px;
        height: 16px;
        color: #fbbf24;
    }
    .list-rating-text {
        font-size: 0.85rem;
        color: #374151;
        font-weight: 600;
    }
    .list-rating-count {
        font-size: 0.8rem;
        color: #f59e0b;
    }
    /* List - Price Section */
    .list-price-section {
        flex: 0 0 auto;
        text-align: center;
        padding: 0 1.5rem;
        border-left: 1px solid #e5e7eb;
        border-right: 1px solid #e5e7eb;
    }
    .list-online-status {
        font-size: 1rem;
        color: #374151;
        font-style: italic;
        margin-bottom: 0.25rem;
    }
    .list-price-label {
        font-size: 0.8rem;
        color: #6b7280;
    }
    .list-price-amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ec4899;
    }
    /* List - Actions Section */
    .list-actions-section {
        flex: 0 0 auto;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        min-width: 160px;
    }
    .list-recommend-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        background: #0d9488;
        color: white;
        padding: 0.4rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .list-recommend-badge svg {
        width: 14px;
        height: 14px;
    }
    .list-btn-book {
        display: block;
        background: linear-gradient(135deg, #f472b6 0%, #ec4899 100%);
        color: white;
        padding: 0.6rem 1.25rem;
        border-radius: 25px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.85rem;
    }
    .list-btn-book:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(236, 72, 153, 0.35);
        color: white;
    }
    .list-btn-profile {
        display: block;
        background: #0d9488;
        color: white;
        padding: 0.6rem 1.25rem;
        border-radius: 25px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.85rem;
    }
    .list-btn-profile:hover {
        background: #0f766e;
        color: white;
        transform: translateY(-2px);
    }
    .list-availability-link {
        font-size: 0.8rem;
        color: #374151;
        text-decoration: underline;
        text-align: center;
    }
    .list-availability-link:hover {
        color: #0d9488;
    }

    /* Page Header Gradient */
    .page-header-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    /* Responsive adjustments for list view */
    @media (max-width: 768px) {
        .therapist-list-inner {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
        .list-price-section {
            border: none;
            padding: 0;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 0;
            width: 100%;
        }
        .list-actions-section {
            width: 100%;
        }
        .list-meta-row {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <!-- Search and Filter -->
                <div class="flex flex-col sm:flex-row gap-4 flex-1">
                    <!-- Filter Button -->
                    <button id="filterToggle" class="flex items-center gap-2 px-5 py-2.5 text-white rounded-lg transition-all duration-300 hover:shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter
                    </button>

                    <!-- Search Bar -->
                    <div class="flex-1 relative">
                        <input type="text"
                               id="searchInput"
                               placeholder="Search by Name"
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- View Toggle and Sort -->
                <div class="flex items-center gap-4">
                    <!-- View Toggle -->
                    <div class="flex bg-gray-100 rounded-lg p-1">
                        <button id="cardViewBtn" class="flex items-center gap-2 px-3 py-2 rounded-md bg-white shadow-sm text-sm font-medium text-gray-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            Cards
                        </button>
                        <button id="listViewBtn" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            List
                        </button>
                    </div>

                    <!-- Sort Dropdown -->
                    <select id="sortSelect" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="rating">Sort by Rating</option>
                        <option value="experience">Sort by Experience</option>
                        <option value="fee_low">Price: Low to High</option>
                        <option value="fee_high">Price: High to Low</option>
                        <option value="name">Sort by Name</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Panel -->
    <div id="filterPanel" class="bg-white border-b shadow-sm hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <form id="filterForm" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Specializations -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Specializations</label>
                    <div class="space-y-2 max-h-40 overflow-y-auto">
                        @foreach($filterOptions['specializations'] as $specialization)
                            <label class="flex items-center">
                                <input type="checkbox"
                                       name="specializations[]"
                                       value="{{ $specialization->slug }}"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $specialization->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Languages -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Languages</label>
                    <div class="space-y-2 max-h-40 overflow-y-auto">
                        @foreach($filterOptions['languages'] as $language)
                            <label class="flex items-center">
                                <input type="checkbox"
                                       name="languages[]"
                                       value="{{ $language }}"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $language }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Experience -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Experience</label>
                    <div class="space-y-2">
                        @foreach($filterOptions['experience_ranges'] as $range)
                            <label class="flex items-center">
                                <input type="radio"
                                       name="experience_range"
                                       value="{{ $range['min'] }}-{{ $range['max'] }}"
                                       class="border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $range['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Fee Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fee Range</label>
                    <div class="space-y-2">
                        @foreach($filterOptions['fee_ranges'] as $range)
                            <label class="flex items-center">
                                <input type="radio"
                                       name="fee_range"
                                       value="{{ $range['min'] }}-{{ $range['max'] }}"
                                       class="border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $range['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Areas of Expertise -->
                @if(isset($filterOptions['areasOfExpertise']) && $filterOptions['areasOfExpertise']->count() > 0)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Areas of Expertise</label>
                    <div class="space-y-2 max-h-40 overflow-y-auto">
                        @foreach($filterOptions['areasOfExpertise'] as $area)
                            <label class="flex items-center">
                                <input type="radio"
                                       name="area"
                                       value="{{ $area->slug }}"
                                       {{ request('area') === $area->slug ? 'checked' : '' }}
                                       class="border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $area->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Filter Actions -->
                <div class="col-span-full flex justify-end gap-3 pt-4 border-t">
                    <button type="button" id="clearFilters" class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium">
                        Clear All
                    </button>
                    <button type="submit" class="px-6 py-2.5 text-white rounded-lg font-medium transition-all duration-300 hover:shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Area of Expertise Banner (when filtering) -->
        @if(isset($currentArea) && $currentArea)
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-6 mb-6 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                        @if($currentArea->icon)
                            <i class="{{ $currentArea->icon }} text-white" style="font-size: 2rem;"></i>
                        @else
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">{{ $currentArea->name }}</h2>
                        @if($currentArea->description)
                            <p class="text-white/80 mt-1">{{ Str::limit($currentArea->description, 120) }}</p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('therapists.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Clear Filter
                </a>
            </div>
        </div>
        @endif

        <!-- Results Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    @if(isset($currentArea) && $currentArea)
                        Therapists Specializing in {{ $currentArea->name }}
                    @else
                        Find Your Perfect Therapist
                    @endif
                </h1>
                <p id="resultsCount" class="text-gray-600 mt-1">
                    Showing {{ $therapists->total() }} therapists
                </p>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div id="loadingIndicator" class="hidden text-center py-8">
            <div class="inline-flex items-center gap-2 text-gray-600">
                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading therapists...
            </div>
        </div>

        <!-- Therapists Grid/List -->
        <div id="therapistsContainer">
            @include('web.therapists.partials.card-view', ['therapists' => $therapists])
        </div>

        <!-- Pagination -->
        <div id="paginationContainer" class="mt-8">
            {{ $therapists->links() }}
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterToggle = document.getElementById('filterToggle');
    const filterPanel = document.getElementById('filterPanel');
    const filterForm = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const cardViewBtn = document.getElementById('cardViewBtn');
    const listViewBtn = document.getElementById('listViewBtn');
    const clearFilters = document.getElementById('clearFilters');
    const therapistsContainer = document.getElementById('therapistsContainer');
    const paginationContainer = document.getElementById('paginationContainer');
    const resultsCount = document.getElementById('resultsCount');
    const loadingIndicator = document.getElementById('loadingIndicator');

    let currentViewType = 'card';
    let searchTimeout;

    // Toggle filter panel
    filterToggle.addEventListener('click', function() {
        filterPanel.classList.toggle('hidden');
    });

    // View type toggle
    cardViewBtn.addEventListener('click', function() {
        currentViewType = 'card';
        cardViewBtn.classList.add('bg-white', 'shadow-sm', 'text-gray-900');
        cardViewBtn.classList.remove('text-gray-600');
        listViewBtn.classList.remove('bg-white', 'shadow-sm', 'text-gray-900');
        listViewBtn.classList.add('text-gray-600');
        loadTherapists();
    });

    listViewBtn.addEventListener('click', function() {
        currentViewType = 'list';
        listViewBtn.classList.add('bg-white', 'shadow-sm', 'text-gray-900');
        listViewBtn.classList.remove('text-gray-600');
        cardViewBtn.classList.remove('bg-white', 'shadow-sm', 'text-gray-900');
        cardViewBtn.classList.add('text-gray-600');
        loadTherapists();
    });

    // Search functionality
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadTherapists();
        }, 500);
    });

    // Sort functionality
    sortSelect.addEventListener('change', function() {
        loadTherapists();
    });

    // Filter form submission
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        loadTherapists();
    });

    // Clear filters
    clearFilters.addEventListener('click', function() {
        filterForm.reset();
        searchInput.value = '';
        loadTherapists();
    });

    // Load therapists via AJAX
    function loadTherapists(page = 1) {
        loadingIndicator.classList.remove('hidden');
        therapistsContainer.classList.add('opacity-50');

        const formData = new FormData(filterForm);
        formData.append('search', searchInput.value);
        formData.append('sort', sortSelect.value);
        formData.append('view_type', currentViewType);
        formData.append('page', page);

        // Convert FormData to URL parameters
        const params = new URLSearchParams();
        for (let [key, value] of formData.entries()) {
            if (params.has(key)) {
                params.append(key, value);
            } else {
                params.set(key, value);
            }
        }

        fetch('{{ route("therapists.index") }}?' + params.toString(), {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            therapistsContainer.innerHTML = data.html;
            paginationContainer.innerHTML = data.pagination;
            resultsCount.textContent = `Showing ${data.total} therapists`;

            loadingIndicator.classList.add('hidden');
            therapistsContainer.classList.remove('opacity-50');
        })
        .catch(error => {
            console.error('Error:', error);
            loadingIndicator.classList.add('hidden');
            therapistsContainer.classList.remove('opacity-50');
        });
    }

    // Handle pagination clicks
    document.addEventListener('click', function(e) {
        if (e.target.matches('.pagination a')) {
            e.preventDefault();
            const url = new URL(e.target.href);
            const page = url.searchParams.get('page') || 1;
            loadTherapists(page);
        }
    });
});
</script>
@endsection
