@extends('layouts/contentNavbarLayout')

@section('title', ($userAssessment->assessment->title ?? 'Assessment') . ' — Result')

@section('page-style')
<style>
.page-header {
    background: #041c54;
    border-radius: 14px;
    padding: 1.25rem 1.75rem;
    margin-bottom: 1.25rem;
}
.page-header h4 { color: #fff; font-weight: 700; margin-bottom: 0.25rem; }
.page-header p { color: rgba(255, 255, 255, 0.85); margin-bottom: 0; font-size: 0.875rem; }
.btn-back {
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
.btn-back:hover { background: #fff; color: #041c54; }
.result-card {
    background: #fff;
    border: 1px solid rgba(186, 194, 210, 0.45);
    border-radius: 14px;
    margin-bottom: 1rem;
    overflow: hidden;
}
.result-card .card-header-custom {
    padding: 1rem 1.25rem;
    background: rgba(4, 28, 84, 0.04);
    border-bottom: 1px solid rgba(186, 194, 210, 0.4);
    font-weight: 700;
    color: #041c54;
    font-size: 0.95rem;
}
.result-card .card-body-custom { padding: 1.15rem 1.25rem; }
.score-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 0.75rem;
}
.score-item {
    background: rgba(4, 28, 84, 0.04);
    border-radius: 12px;
    padding: 0.85rem 1rem;
    text-align: center;
    border: 1px solid rgba(186, 194, 210, 0.4);
}
.score-item .label { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: #7484a4; }
.score-item .value { font-size: 1.35rem; font-weight: 700; color: #041c54; }
.answer-row {
    padding: 0.85rem 0;
    border-bottom: 1px solid rgba(186, 194, 210, 0.35);
}
.answer-row:last-child { border-bottom: none; padding-bottom: 0; }
.answer-q { font-weight: 600; color: #041c54; font-size: 0.875rem; margin-bottom: 0.35rem; }
.answer-a { color: #475569; font-size: 0.85rem; margin: 0; }
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.3rem 0.65rem;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: capitalize;
    background: rgba(16, 185, 129, 0.12);
    color: #059669;
}
.recommendation-list { margin: 0; padding-left: 1.15rem; }
.recommendation-list li { margin-bottom: 0.35rem; color: #475569; font-size: 0.875rem; }
</style>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
    <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@php
    $assessment = $userAssessment->assessment;
    $completedAt = $userAssessment->completed_at ?? $userAssessment->created_at;
    $summary = is_array($userAssessment->result_summary) ? $userAssessment->result_summary : [];
    $recommendations = is_array($userAssessment->recommendations) ? $userAssessment->recommendations : [];

    $formatAnswer = function ($answer) {
        $text = $answer->answer_text;
        if ($text === null || $text === '') {
            return $answer->answer_value !== null ? (string) $answer->answer_value : '—';
        }
        $decoded = json_decode($text, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return collect($decoded)->map(fn ($v) => is_scalar($v) ? $v : json_encode($v))->implode(', ');
        }
        return $text;
    };
@endphp

<div class="page-header">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <a href="{{ route('client.assessments.history') }}" class="btn-back mb-3">
                <i class="ri-arrow-left-line"></i> Back to History
            </a>
            <h4 class="mb-1">{{ $assessment->title ?? 'Assessment Result' }}</h4>
            <p class="mb-0">
                Completed {{ $completedAt?->timezone('Asia/Kolkata')->format('M d, Y \a\t g:i A') }} IST
            </p>
        </div>
        <span class="status-pill">
            <i class="ri-checkbox-circle-line"></i>
            {{ str_replace('_', ' ', $userAssessment->status) }}
        </span>
    </div>
</div>

@if($userAssessment->status === 'completed' && ($userAssessment->percentage !== null || $userAssessment->total_score !== null))
<div class="result-card mb-3" style="border: 2px solid rgba(4, 28, 84, 0.2);">
    <div class="card-body-custom text-center py-4">
        <div class="text-uppercase small fw-semibold mb-1" style="color: #7484a4; letter-spacing: 0.05em;">Your result</div>
        @if($userAssessment->percentage !== null)
        <div class="display-4 fw-bold mb-1" style="color: #041c54; line-height: 1.1;">{{ number_format($userAssessment->percentage, 0) }}%</div>
        @endif
        @if($userAssessment->total_score !== null && $userAssessment->max_score)
        <p class="mb-0" style="color: #647494;">Score {{ $userAssessment->total_score }} out of {{ $userAssessment->max_score }}</p>
        @endif
    </div>
</div>
<div class="result-card">
    <div class="card-header-custom"><i class="ri-bar-chart-box-line me-2"></i>Score details</div>
    <div class="card-body-custom">
        <div class="score-grid">
            @if($userAssessment->percentage !== null)
            <div class="score-item">
                <div class="label">Percentage</div>
                <div class="value">{{ number_format($userAssessment->percentage, 1) }}%</div>
            </div>
            @endif
            @if($userAssessment->total_score !== null)
            <div class="score-item">
                <div class="label">Total Score</div>
                <div class="value">{{ $userAssessment->total_score }}</div>
            </div>
            @endif
            @if($userAssessment->max_score)
            <div class="score-item">
                <div class="label">Max Score</div>
                <div class="value">{{ $userAssessment->max_score }}</div>
            </div>
            @endif
            @if(!empty($summary['level']) || !empty($summary['severity']))
            <div class="score-item">
                <div class="label">Level</div>
                <div class="value" style="font-size: 1rem;">{{ $summary['level'] ?? $summary['severity'] ?? '—' }}</div>
            </div>
            @endif
        </div>
        @if(!empty($summary['message']) || !empty($summary['interpretation']))
        <p class="mt-3 mb-0 text-muted small">
            {{ $summary['message'] ?? $summary['interpretation'] }}
        </p>
        @endif
    </div>
</div>
@endif

@if(count($recommendations) > 0)
<div class="result-card">
    <div class="card-header-custom"><i class="ri-lightbulb-line me-2"></i>Recommendations</div>
    <div class="card-body-custom">
        <ul class="recommendation-list">
            @foreach($recommendations as $item)
                <li>{{ is_string($item) ? $item : (is_array($item) ? ($item['text'] ?? json_encode($item)) : $item) }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="result-card">
    <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="ri-question-answer-line me-2"></i>Your Answers</span>
        <span class="text-muted small fw-normal">{{ $userAssessment->answers->count() }} responses</span>
    </div>
    <div class="card-body-custom">
        @forelse($userAssessment->answers as $index => $answer)
            <div class="answer-row">
                <div class="answer-q">Q{{ $index + 1 }}. {{ $answer->question->question_text ?? 'Question' }}</div>
                <p class="answer-a">{{ $formatAnswer($answer) }}</p>
            </div>
        @empty
            <p class="text-muted mb-0 small">No answer details were stored for this attempt.</p>
        @endforelse
    </div>
</div>

<div class="d-flex flex-wrap gap-2">
    @if($assessment?->slug)
        <a href="{{ route('assessments.start', $assessment->slug) }}" class="btn btn-primary" target="_blank" style="background:#041c54;border-color:#041c54;">
            <i class="ri-restart-line me-1"></i> Retake Assessment
        </a>
    @endif
    <a href="{{ route('therapists.index') }}" class="btn btn-outline-primary" style="border-color:#041c54;color:#041c54;">
        <i class="ri-user-heart-line me-1"></i> Find a Therapist
    </a>
</div>
@endsection
