@extends('layouts/contentNavbarLayout')

@section('title', 'My Assessment History')

@section('page-style')
<style>
.page-header {
    background: #041c54;
    border-radius: 14px;
    padding: 1.25rem 1.75rem;
    margin-bottom: 1.25rem;
    position: relative;
    overflow: hidden;
}
.page-header h4 { color: #fff; font-weight: 700; margin-bottom: 0.25rem; position: relative; z-index: 1; }
.page-header p { color: rgba(255, 255, 255, 0.85); margin-bottom: 0; font-size: 0.875rem; position: relative; z-index: 1; }
.header-icon {
    width: 50px; height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: white;
}
.btn-header-outline {
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.35);
    color: #fff;
    border-radius: 10px;
    font-weight: 600;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}
.btn-header-outline:hover { background: #fff; color: #041c54; }
.stats-row .stat-card {
    background: #fff;
    border: 1px solid rgba(186, 194, 210, 0.45);
    border-radius: 12px;
    padding: 1rem 1.15rem;
    box-shadow: 0 4px 12px rgba(4, 28, 84, 0.04);
}
.stat-card .stat-label { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #7484a4; }
.stat-card .stat-value { font-size: 1.5rem; font-weight: 700; color: #041c54; line-height: 1.2; }
.filter-card {
    background: #fff;
    border: 1px solid rgba(186, 194, 210, 0.45);
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1rem;
}
.filter-card .form-select, .filter-card input {
    border-radius: 8px;
    border: 2px solid rgba(186, 194, 210, 0.85);
    font-size: 0.9rem;
}
.filter-card .form-select:focus { border-color: #041c54; box-shadow: 0 0 0 0.2rem rgba(4, 28, 84, 0.12); }
.btn-clear-filter {
    border: 2px solid #041c54;
    color: #041c54;
    border-radius: 10px;
    font-weight: 600;
    background: transparent;
}
.btn-clear-filter:hover { background: #041c54; color: #fff; }
.history-list { display: flex; flex-direction: column; gap: 0.75rem; }
.history-card {
    background: #fff;
    border: 1px solid rgba(186, 194, 210, 0.5);
    border-radius: 14px;
    padding: 1rem 1.15rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    border-left: 4px solid #041c54;
    transition: box-shadow 0.2s ease;
}
.history-card:hover { box-shadow: 0 6px 20px rgba(4, 28, 84, 0.08); }
.history-card--completed { border-left-color: #10b981; }
.history-card--cancelled, .history-card--abandoned { border-left-color: #94a3b8; }
.history-card--in_progress, .history-card--started { border-left-color: #f59e0b; }
.history-card__icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
    background: rgba(4, 28, 84, 0.08);
    color: #041c54;
}
.history-card__title { font-size: 0.95rem; font-weight: 700; color: #041c54; margin: 0 0 0.2rem; }
.history-card__meta { font-size: 0.8rem; color: #7484a4; margin: 0; }
.history-card__meta i { color: #041c54; }
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.25rem 0.6rem;
    border-radius: 999px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: capitalize;
}
.status-pill--completed { background: rgba(16, 185, 129, 0.12); color: #059669; }
.status-pill--in_progress, .status-pill--started { background: rgba(245, 158, 11, 0.12); color: #d97706; }
.status-pill--abandoned { background: rgba(148, 163, 184, 0.2); color: #64748b; }
.score-badge {
    font-size: 0.85rem;
    font-weight: 700;
    color: #041c54;
    background: rgba(4, 28, 84, 0.06);
    padding: 0.35rem 0.65rem;
    border-radius: 8px;
    border: 1px solid rgba(4, 28, 84, 0.12);
}
.btn-view-result {
    background: #041c54;
    color: #fff;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.8rem;
    padding: 0.45rem 0.9rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    white-space: nowrap;
}
.btn-view-result:hover { background: #052a66; color: #fff; }
.empty-state { text-align: center; padding: 3rem 1.5rem; }
.empty-state-icon {
    width: 100px; height: 100px;
    background: rgba(4, 28, 84, 0.08);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 2.5rem;
    color: #041c54;
}
@media (max-width: 768px) {
    .history-card { flex-direction: column; align-items: flex-start; }
    .history-card__actions { width: 100%; }
    .btn-view-result { width: 100%; justify-content: center; }
}
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 position-relative" style="z-index: 1;">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon"><i class="ri-mental-health-line"></i></div>
            <div>
                <h4 class="mb-1">My Assessment History</h4>
                <p class="mb-0">View results from assessments you've completed on the app or website</p>
            </div>
        </div>
        <a href="{{ route('assessments.index') }}" class="btn-header-outline" target="_blank">
            <i class="ri-add-circle-line"></i> Take New Assessment
        </a>
    </div>
</div>

@if(($stats['total'] ?? 0) > 0)
<div class="row g-3 mb-3 stats-row">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-label">Total Attempts</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-label">Completed</div>
            <div class="stat-value">{{ $stats['completed'] }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-label">In Progress</div>
            <div class="stat-value">{{ $stats['in_progress'] }}</div>
        </div>
    </div>
</div>
@endif

<div class="filter-card">
    <form method="GET" action="{{ route('client.assessments.history') }}" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-semibold small"><i class="ri-filter-3-line me-1"></i>Status</label>
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="started" {{ request('status') === 'started' ? 'selected' : '' }}>Started</option>
                <option value="abandoned" {{ request('status') === 'abandoned' ? 'selected' : '' }}>Abandoned</option>
            </select>
        </div>
        @if($assessmentFilters->count() > 0)
        <div class="col-md-4">
            <label class="form-label fw-semibold small"><i class="ri-file-list-3-line me-1"></i>Assessment</label>
            <select name="assessment_id" class="form-select" onchange="this.form.submit()">
                <option value="">All assessments</option>
                @foreach($assessmentFilters as $filterAssessment)
                    <option value="{{ $filterAssessment->id }}" {{ (string) request('assessment_id') === (string) $filterAssessment->id ? 'selected' : '' }}>
                        {{ $filterAssessment->title }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="col-md-4">
            @if(request('status') || request('assessment_id'))
                <a href="{{ route('client.assessments.history') }}" class="btn btn-clear-filter w-100">
                    <i class="ri-close-line me-1"></i> Clear Filters
                </a>
            @endif
        </div>
    </form>
</div>

@if($responses->count() > 0)
    <div class="history-list">
        @foreach($responses as $response)
            @php
                $assessment = $response->assessment;
                $completedAt = $response->completed_at ?? $response->created_at;
                $color = $assessment->color ?? '#041c54';
            @endphp
            <article class="history-card history-card--{{ $response->status }}">
                <div class="d-flex align-items-center gap-3 flex-grow-1 min-w-0">
                    <div class="history-card__icon" style="background: {{ $color }}15; color: {{ $color }};">
                        <i class="ri-file-list-3-line"></i>
                    </div>
                    <div class="min-w-0">
                        <h6 class="history-card__title text-truncate">
                            {{ $assessment->title ?? 'Assessment' }}
                        </h6>
                        <p class="history-card__meta mb-1">
                            <i class="ri-calendar-line me-1"></i>
                            {{ $completedAt?->timezone('Asia/Kolkata')->format('M d, Y · g:i A') }} IST
                            @if($assessment?->category)
                                <span class="mx-1">·</span>{{ $assessment->category }}
                            @endif
                        </p>
                        <span class="status-pill status-pill--{{ $response->status }}">
                            <i class="ri-{{ $response->status === 'completed' ? 'checkbox-circle' : 'time' }}-line"></i>
                            {{ str_replace('_', ' ', $response->status) }}
                        </span>
                    </div>
                </div>
                <div class="history-card__actions d-flex align-items-center gap-2 flex-shrink-0">
                    @if($response->status === 'completed' && $response->percentage !== null)
                        <span class="score-badge">
                            {{ number_format($response->percentage, 0) }}%
                            @if($response->total_score !== null && $response->max_score)
                                <span class="fw-normal text-muted">({{ $response->total_score }}/{{ $response->max_score }})</span>
                            @endif
                        </span>
                    @endif
                    <a href="{{ route('client.assessments.history.show', $response->id) }}" class="btn-view-result">
                        <i class="ri-eye-line"></i> View Result
                    </a>
                </div>
            </article>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4 mb-3">
        {{ $responses->links() }}
    </div>
@else
    <div class="card border-0 shadow-sm">
        <div class="card-body empty-state">
            <div class="empty-state-icon"><i class="ri-mental-health-line"></i></div>
            <h5 class="fw-bold" style="color: #041c54;">No assessment history yet</h5>
            <p class="text-muted mb-4">
                @if(request('status') || request('assessment_id'))
                    No results match your filters. Try clearing filters or take a new assessment.
                @else
                    Complete an assessment on the mobile app or website to see your results here.
                @endif
            </p>
            <a href="{{ route('assessments.index') }}" class="btn-view-result" target="_blank">
                <i class="ri-play-circle-line"></i> Browse Assessments
            </a>
        </div>
    </div>
@endif
@endsection
