@extends('layouts.app')

@section('title', 'Find Your Perfect Therapist - Apani Psychology')

@section('content')
<div class="therapists-page min-h-screen bg-gradient-to-b from-white to-[#BAC2D2]/5">
    {{-- Hero (matches Figma: Find Therapists — nK9mM9VbraE6UNKrccKDTo node 1:638) --}}
    <section class="marketing-page-hero">
        <div class="pointer-events-none absolute inset-0 opacity-10" aria-hidden="true">
            <div class="absolute left-4 top-16 h-64 w-64 rounded-full bg-white blur-[64px] md:left-10 md:h-72 md:w-72"></div>
            <div class="absolute -right-8 top-6 h-80 w-80 rounded-full bg-[#647494] blur-[64px] md:right-0 md:h-96 md:w-96"></div>
        </div>
        <div class="relative z-10 mx-auto w-full max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <h1 class="font-display text-4xl font-medium leading-tight text-white md:text-5xl lg:text-[3.75rem] lg:leading-[1.1]">
                @if(isset($currentArea) && $currentArea)
                    Therapists for <span class="text-[#BAC2D2]">{{ $currentArea->name }}</span>
                @else
                    Find Your Perfect <span class="text-[#BAC2D2]">Therapist</span>
                @endif
            </h1>
            <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-[#BAC2D2] md:text-lg">
                Connect with licensed professionals who fit your needs. Search by name or specialty and refine with filters.
            </p>

            {{-- Combined search + Filters (white bar) --}}
            <div class="mx-auto mt-10 max-w-2xl overflow-hidden rounded-2xl border border-[#BAC2D2]/30 bg-white shadow-[0_20px_50px_-12px_rgba(4,28,84,0.35)]">
                <div class="flex flex-col sm:flex-row sm:items-stretch">
                    <div class="flex min-w-0 flex-1 items-center gap-3 border-b border-[#BAC2D2]/25 px-4 py-3 sm:border-b-0 sm:border-r sm:py-3.5">
                        <svg class="h-5 w-5 shrink-0 text-[#7484A4]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text"
                               id="searchInput"
                               placeholder="Search by name or specialty..."
                               class="w-full border-0 bg-transparent text-[#041C54] placeholder-[#7484A4] focus:ring-0 text-[15px]">
                    </div>
                    <button type="button" id="filterToggle" class="inline-flex items-center justify-center gap-2 bg-[#041C54] px-6 py-3.5 text-sm font-medium text-white transition hover:bg-[#031340] sm:min-w-[9.5rem]">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filters
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- Filter panel --}}
    <div id="filterPanel" class="hidden border-b border-[#BAC2D2]/30 bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-5 py-6 sm:px-6 lg:px-8">
            <form id="filterForm" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="mb-2 block text-sm font-medium text-[#041C54]">Specializations</label>
                    <div class="max-h-40 space-y-2 overflow-y-auto">
                        @foreach($filterOptions['specializations'] as $specialization)
                            <label class="flex items-center">
                                <input type="checkbox" name="specializations[]" value="{{ $specialization->slug }}"
                                       class="rounded border-[#BAC2D2] text-[#647494] focus:ring-[#647494]">
                                <span class="ml-2 text-sm text-[#7484A4]">{{ $specialization->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-[#041C54]">Languages</label>
                    <div class="max-h-40 space-y-2 overflow-y-auto">
                        @foreach($filterOptions['languages'] as $language)
                            <label class="flex items-center">
                                <input type="checkbox" name="languages[]" value="{{ $language }}"
                                       class="rounded border-[#BAC2D2] text-[#647494] focus:ring-[#647494]">
                                <span class="ml-2 text-sm text-[#7484A4]">{{ $language }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-[#041C54]">Experience</label>
                    <div class="space-y-2">
                        @foreach($filterOptions['experience_ranges'] as $range)
                            <label class="flex items-center">
                                <input type="radio" name="experience_range" value="{{ $range['min'] }}-{{ $range['max'] }}"
                                       class="border-[#BAC2D2] text-[#647494] focus:ring-[#647494]">
                                <span class="ml-2 text-sm text-[#7484A4]">{{ $range['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-[#041C54]">Fee Range</label>
                    <div class="space-y-2">
                        @foreach($filterOptions['fee_ranges'] as $range)
                            <label class="flex items-center">
                                <input type="radio" name="fee_range" value="{{ $range['min'] }}-{{ $range['max'] }}"
                                       class="border-[#BAC2D2] text-[#647494] focus:ring-[#647494]">
                                <span class="ml-2 text-sm text-[#7484A4]">{{ $range['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @if(isset($filterOptions['areasOfExpertise']) && $filterOptions['areasOfExpertise']->count() > 0)
                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#041C54]">Areas of Expertise</label>
                        <div class="max-h-40 space-y-2 overflow-y-auto">
                            @foreach($filterOptions['areasOfExpertise'] as $area)
                                <label class="flex items-center">
                                    <input type="radio" name="area" value="{{ $area->slug }}"
                                           {{ request('area') === $area->slug ? 'checked' : '' }}
                                           class="border-[#BAC2D2] text-[#647494] focus:ring-[#647494]">
                                    <span class="ml-2 text-sm text-[#7484A4]">{{ $area->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="col-span-full flex justify-end gap-3 border-t border-[#BAC2D2]/30 pt-4">
                    <button type="button" id="clearFilters" class="px-4 py-2 text-sm font-medium text-[#7484A4] transition hover:text-[#041C54]">
                        Clear All
                    </button>
                    <button type="submit" class="rounded-xl bg-[#647494] px-6 py-2.5 text-sm font-medium text-white shadow-[0_8px_20px_rgba(100,116,148,0.35)] transition hover:bg-[#041C54]">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        @if(isset($currentArea) && $currentArea)
            <div class="mb-10 overflow-hidden rounded-2xl bg-[#041C54] p-6 text-white shadow-lg shadow-[#041C54]/15 lg:mb-12">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-4">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-white/15">
                            @if($currentArea->icon)
                                <i class="{{ $currentArea->icon }} text-3xl text-white"></i>
                            @else
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h2 class="font-display text-xl font-medium md:text-2xl">{{ $currentArea->name }}</h2>
                            @if($currentArea->description)
                                <p class="mt-1 max-w-xl text-sm text-white/85">{{ Str::limit($currentArea->description, 160) }}</p>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('therapists.index') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl border border-white/40 bg-white/10 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-white/20">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Clear filter
                    </a>
                </div>
            </div>
        @endif

        {{-- Toolbar: title + view toggle + sort --}}
        <div class="mb-10 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between lg:mb-12">
            <div>
                <h2 class="font-display text-3xl font-medium text-[#041C54] md:text-4xl">Available Therapists</h2>
                <p id="resultsCount" class="mt-4 text-base text-[#7484A4]">
                    Showing {{ $therapists->total() }} therapists
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <div class="inline-flex rounded-[14px] bg-[#BAC2D2]/25 p-1">
                    <button type="button" id="cardViewBtn" class="inline-flex items-center gap-2 rounded-[10px] bg-white px-3 py-2 text-sm font-medium text-primary-800 shadow-md">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        Cards
                    </button>
                    <button type="button" id="listViewBtn" class="inline-flex items-center gap-2 rounded-[10px] px-3 py-2 text-sm font-medium text-primary-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        List
                    </button>
                </div>
                <select id="sortSelect" class="rounded-[14px] border border-[#BAC2D2]/40 bg-white py-2 pl-3 pr-8 text-sm text-[#041C54] focus:border-[#647494] focus:outline-none focus:ring-2 focus:ring-[#647494]/30">
                    <option value="rating">Sort by Rating</option>
                    <option value="experience">Sort by Experience</option>
                    <option value="fee_low">Price: Low to High</option>
                    <option value="fee_high">Price: High to Low</option>
                    <option value="name">Sort by Name</option>
                </select>
            </div>
        </div>

        <div id="loadingIndicator" class="hidden py-8 text-center">
            <div class="inline-flex items-center gap-2 text-[#7484A4]">
                <svg class="h-5 w-5 animate-spin text-[#647494]" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading therapists...
            </div>
        </div>

        <div id="therapistsContainer">
            @include('web.therapists.partials.card-view', ['therapists' => $therapists])
        </div>

        <div id="paginationContainer" class="mt-8">
            {{ $therapists->links() }}
        </div>
    </div>
</div>

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

    filterToggle.addEventListener('click', function() {
        filterPanel.classList.toggle('hidden');
    });

    function setCardActive() {
        cardViewBtn.classList.add('bg-white', 'shadow-md', 'text-primary-800');
        cardViewBtn.classList.remove('text-primary-500');
        listViewBtn.classList.remove('bg-white', 'shadow-md', 'text-primary-800');
        listViewBtn.classList.add('text-primary-500');
    }
    function setListActive() {
        listViewBtn.classList.add('bg-white', 'shadow-md', 'text-primary-800');
        listViewBtn.classList.remove('text-primary-500');
        cardViewBtn.classList.remove('bg-white', 'shadow-md', 'text-primary-800');
        cardViewBtn.classList.add('text-primary-500');
    }

    cardViewBtn.addEventListener('click', function() {
        currentViewType = 'card';
        setCardActive();
        loadTherapists();
    });

    listViewBtn.addEventListener('click', function() {
        currentViewType = 'list';
        setListActive();
        loadTherapists();
    });

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => { loadTherapists(); }, 500);
    });

    sortSelect.addEventListener('change', function() { loadTherapists(); });

    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        loadTherapists();
    });

    clearFilters.addEventListener('click', function() {
        filterForm.reset();
        searchInput.value = '';
        loadTherapists();
    });

    function loadTherapists(page = 1) {
        loadingIndicator.classList.remove('hidden');
        therapistsContainer.classList.add('opacity-50');

        const formData = new FormData(filterForm);
        formData.append('search', searchInput.value);
        formData.append('sort', sortSelect.value);
        formData.append('view_type', currentViewType);
        formData.append('page', page);

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
