@extends('layouts.app')

@section('title', $assessment->title . ' - Mental Health Assessment')
@section('description', $assessment->meta_description ?? $assessment->description)

@section('head')
<style>
    .assessment-take-theme {
        --theme-navy: #041c54;
        --theme-slate: #647494;
        --theme-muted: #7484a4;
        --theme-border: rgba(186, 194, 210, 0.55);
    }
    .assessment-take-header {
        background: linear-gradient(180deg, rgba(4, 28, 84, 0.06) 0%, rgba(186, 194, 210, 0.12) 100%);
    }
    .assessment-take-theme .theme-back-link {
        color: #041c54;
        font-weight: 600;
    }
    .assessment-take-theme .theme-back-link:hover {
        color: #647494;
    }
    .assessment-take-theme .theme-icon-box {
        background: #041c54;
    }
    .assessment-take-theme .theme-badge {
        background: #041c54;
        color: #fff;
    }
    .assessment-take-theme .theme-title {
        color: #041c54;
    }
    .assessment-take-theme .theme-meta {
        color: #7484a4;
    }
    .assessment-take-theme .theme-desc {
        color: #647494;
    }
    .assessment-take-theme .theme-progress-card {
        border-color: var(--theme-border);
        box-shadow: 0 4px 12px rgba(4, 28, 84, 0.06);
    }
    .assessment-take-theme .theme-progress-icon {
        background: rgba(4, 28, 84, 0.1);
        color: #041c54;
    }
    .assessment-take-theme .theme-progress-bar {
        background: linear-gradient(90deg, #041c54 0%, #647494 100%);
    }
    .assessment-take-theme .theme-progress-pct {
        color: #041c54;
    }
    .assessment-take-theme .btn-theme-primary {
        background: #041c54;
        color: #fff;
    }
    .assessment-take-theme .btn-theme-primary:hover {
        background: #052a66;
        color: #fff;
    }
    .assessment-take-theme .question-num {
        background: rgba(4, 28, 84, 0.1);
        color: #041c54;
    }
    .assessment-take-theme .option-label:hover {
        border-color: rgba(4, 28, 84, 0.35);
        background: rgba(4, 28, 84, 0.04);
    }
    .assessment-take-theme input[type="radio"]:checked,
    .assessment-take-theme input[type="radio"]:focus {
        accent-color: #041c54;
        border-color: #041c54;
    }
    .assessment-take-theme .btn-next {
        background: #041c54;
        color: #fff;
    }
    .assessment-take-theme .btn-next:hover {
        background: #052a66;
    }
    .assessment-take-theme .instructions-card {
        border-color: var(--theme-border);
        background: linear-gradient(135deg, #fff 0%, rgba(4, 28, 84, 0.03) 100%);
    }
    .assessment-take-theme .instructions-icon {
        background: rgba(4, 28, 84, 0.1);
        color: #041c54;
    }
    .assessment-take-theme .stat-value {
        color: #041c54;
    }
    .assessment-take-theme .info-icon-theme {
        background: rgba(4, 28, 84, 0.1);
        color: #041c54;
    }
</style>
@endsection

@section('content')
<div class="assessment-take-theme">
<!-- Assessment page header (always visible — do not hide during quiz) -->
<section id="assessment-page-header" class="assessment-take-header py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('assessments.index') }}" class="theme-back-link inline-flex items-center font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Assessments
                </a>
            </div>

            <!-- Assessment Info -->
            <div class="flex items-center justify-center mb-6">
                <div class="theme-icon-box w-16 h-16 rounded-xl flex items-center justify-center shadow-lg mr-6">
                    @if($assessment->icon === 'depression')
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    @elseif($assessment->icon === 'anxiety')
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    @elseif($assessment->icon === 'stress')
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @elseif($assessment->icon === 'sleep')
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    @elseif($assessment->icon === 'relationships')
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    @elseif($assessment->icon === 'wellness')
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @else
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    @endif
                </div>
                <div class="text-left">
                    <h1 class="theme-title text-3xl md:text-4xl font-bold mb-2">{{ $assessment->title }}</h1>
                    <div class="theme-meta flex items-center space-x-4 text-sm">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            {{ $assessment->duration_minutes }} minutes
                        </span>
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                            </svg>
                            {{ $assessment->question_count }} questions
                        </span>
                        <span class="theme-badge px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $assessment->category }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <p class="theme-desc text-lg max-w-3xl mx-auto mb-0">
                {{ $assessment->description }}
            </p>
        </div>
    </div>
</section>

<!-- Assessment Instructions (step 1 — quiz hidden until Continue) -->
<section id="instructions-section" class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="instructions-card rounded-2xl p-8 mb-8 border">
            <div class="text-center mb-8">
                <div class="instructions-icon w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Before You Begin</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Please read these important instructions to ensure you get the most accurate results from your assessment.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4 mt-0.5 flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Answer Honestly</h3>
                            <p class="text-gray-600 text-sm">There are no right or wrong answers. Be truthful about your experiences.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4 mt-0.5 flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Take Your Time</h3>
                            <p class="text-gray-600 text-sm">Read each question carefully and think about your response.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4 mt-0.5 flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Complete All Questions</h3>
                            <p class="text-gray-600 text-sm">Answer all {{ $assessment->question_count }} questions for accurate results.</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="info-icon-theme w-8 h-8 rounded-full flex items-center justify-center mr-4 mt-0.5 flex-shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Privacy Protected</h3>
                            <p class="text-gray-600 text-sm">Your responses are completely confidential and secure.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="info-icon-theme w-8 h-8 rounded-full flex items-center justify-center mr-4 mt-0.5 flex-shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Estimated Time</h3>
                            <p class="text-gray-600 text-sm">This assessment takes approximately {{ $assessment->duration_minutes }} minutes.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="info-icon-theme w-8 h-8 rounded-full flex items-center justify-center mr-4 mt-0.5 flex-shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Can Pause Anytime</h3>
                            <p class="text-gray-600 text-sm">You can pause and resume the assessment at any time.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assessment Stats -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 mb-8">
                <div class="grid grid-cols-3 gap-6 text-center">
                    <div>
                        <div class="stat-value text-2xl font-bold mb-1">{{ $assessment->questions->count() ?: $assessment->question_count }}</div>
                        <div class="text-sm text-gray-600">Questions</div>
                    </div>
                    <div>
                        <div class="stat-value text-2xl font-bold mb-1">{{ $assessment->duration_minutes }}</div>
                        <div class="text-sm text-gray-600">Minutes</div>
                    </div>
                    <div>
                        <div class="stat-value text-2xl font-bold mb-1">{{ $assessment->category }}</div>
                        <div class="text-sm text-gray-600">Category</div>
                    </div>
                </div>
            </div>

            @guest
            <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                <i class="ri-information-line me-1"></i>
                <strong>Sign in required to save results.</strong>
                Please <a href="{{ route('login') }}" class="font-semibold underline" style="color: #041c54;">log in</a> as a client before finishing so your score is stored and visible in My Assessments.
            </div>
            @else
            @unless(auth()->user()->isClient())
            <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                Only client accounts can save assessment results. Therapist or admin accounts cannot store scores here.
            </div>
            @endunless
            @endguest

            <div class="text-center">
                <button type="button" onclick="beginQuiz()" id="btn-continue-assessment"
                        class="btn-theme-primary inline-flex items-center justify-center px-10 py-4 text-lg font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 min-w-[220px]">
                    Continue
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
                <p class="mt-4 text-sm text-gray-500">You'll answer one question at a time after continuing.</p>
            </div>
        </div>
    </div>
</section>

<!-- Assessment quiz (step 2 — shown only after Continue) -->
<section id="quiz-section" class="py-8 bg-white hidden" style="display: none;" aria-hidden="true">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress (below page header, not fixed over navbar) -->
        <div id="progress-container" class="theme-progress-card mb-8 rounded-xl border bg-white p-4 hidden" style="display: none;" aria-hidden="true">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center">
                    <div class="theme-progress-icon w-8 h-8 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $assessment->title }}</h3>
                        <p class="text-sm text-gray-600">Question <span id="current-question">1</span> of {{ $assessment->questions->count() ?: $assessment->question_count }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="theme-progress-pct text-lg font-bold" id="progress-percentage">0%</div>
                    <div class="text-sm text-gray-600">Complete</div>
                </div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                <div id="progress-bar" class="theme-progress-bar h-full rounded-full transition-all duration-500 ease-out" style="width: 0%"></div>
            </div>
        </div>

        <div id="assessment-questions">
            <form id="assessment-form" class="space-y-8">
                @foreach($assessment->questions as $index => $question)
                    <div class="question-card bg-white rounded-xl shadow-sm border border-gray-200 p-6 {{ $index === 0 ? 'current-question' : 'hidden-question' }}" data-question="{{ $index + 1 }}" data-question-id="{{ $question->id }}">
                        <div class="flex items-start mb-4">
                            <div class="question-num w-8 h-8 rounded-full flex items-center justify-center mr-4 mt-1">
                                <span class="text-sm font-semibold">{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $question->question_text }}</h3>

                                @if($question->question_type === 'multiple_choice')
                                    <div class="space-y-3">
                                        @foreach($question->options as $option)
                                            <label class="option-label flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer transition-colors">
                                                <input type="radio" name="question_{{ $question->id }}" value="{{ $option['value'] }}" class="w-4 h-4 border-gray-300" required>
                                                <span class="ml-3 text-gray-700">{{ $option['text'] }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif($question->question_type === 'scale')
                                    <div class="space-y-3">
                                        @foreach($question->options as $option)
                                            <label class="option-label flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer transition-colors">
                                                <input type="radio" name="question_{{ $question->id }}" value="{{ $option['value'] }}" class="w-4 h-4 border-gray-300" required>
                                                <span class="ml-3 text-gray-700">{{ $option['text'] }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif($question->question_type === 'yes_no')
                                    <div class="space-y-3">
                                        <label class="option-label flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer transition-colors">
                                            <input type="radio" name="question_{{ $question->id }}" value="1" class="w-4 h-4 border-gray-300" required>
                                            <span class="ml-3 text-gray-700">Yes</span>
                                        </label>
                                        <label class="option-label flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer transition-colors">
                                            <input type="radio" name="question_{{ $question->id }}" value="0" class="w-4 h-4 border-gray-300" required>
                                            <span class="ml-3 text-gray-700">No</span>
                                        </label>
                                    </div>
                                @elseif($question->question_type === 'text')
                                    <textarea name="question_{{ $question->id }}" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#041c54] focus:border-[#041c54]" placeholder="Please provide your response..." required></textarea>
                                @endif
                            </div>
                        </div>

                        <!-- Question Navigation -->
                        <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                            <button type="button" onclick="previousQuestion()" class="flex items-center px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 {{ $index === 0 ? 'invisible' : '' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span class="font-medium">Previous</span>
                            </button>

                            <div class="flex items-center text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Question {{ $index + 1 }} of {{ $assessment->question_count }}
                            </div>

                            @if($index === $assessment->questions->count() - 1)
                                <button type="button" onclick="nextQuestion(true)" class="flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">Complete Assessment</span>
                                </button>
                            @else
                                <button type="button" onclick="nextQuestion()" class="btn-next flex items-center px-4 py-2 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                    <span class="font-medium">Next Question</span>
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </form>
        </div>
    </div>
</section>

<script>
const assessmentConfig = {
    submitUrl: @json(route('assessments.submit', $assessment->slug)),
    loginUrl: @json(route('login')),
    isAuthenticated: @json(auth()->check()),
    isClient: @json(auth()->check() && auth()->user()->isClient()),
    assessmentTitle: @json($assessment->title),
};

let currentQuestionIndex = 0;
const totalQuestions = {{ $assessment->questions->count() }};
const answers = {};
let isSubmitting = false;

function showEl(el) {
    if (!el) return;
    el.classList.remove('hidden');
    el.style.display = '';
    el.setAttribute('aria-hidden', 'false');
}

function hideEl(el) {
    if (!el) return;
    el.classList.add('hidden');
    el.style.display = 'none';
    el.setAttribute('aria-hidden', 'true');
}

function beginQuiz() {
    hideEl(document.getElementById('instructions-section'));
    showEl(document.getElementById('quiz-section'));
    showEl(document.getElementById('progress-container'));

    updateProgress();

    const quizSection = document.getElementById('quiz-section');
    if (quizSection) {
        quizSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function nextQuestion(isComplete = false) {
    // Validate current question
    const currentQuestion = document.querySelector('.current-question');
    const questionId = currentQuestion.dataset.questionId;
    const answer = getCurrentAnswer(questionId);

    if (!answer && !isComplete) {
        alert('Please select an answer before proceeding.');
        return;
    }

    // Save the answer
    if (answer) {
        answers[questionId] = answer;
    }

    if (isComplete) {
        if (!answer) {
            alert('Please select an answer before completing the assessment.');
            return;
        }
        completeAssessment();
        return;
    }

    // Hide current question
    currentQuestion.classList.remove('current-question');
    currentQuestion.classList.add('hidden-question');

    // Show next question
    currentQuestionIndex++;
    const nextQuestion = document.querySelector(`[data-question="${currentQuestionIndex + 1}"]`);
    if (nextQuestion) {
        nextQuestion.classList.remove('hidden-question');
        nextQuestion.classList.add('current-question');

        // Update previous button visibility
        const prevButton = nextQuestion.querySelector('button[onclick="previousQuestion()"]');
        if (prevButton) {
            prevButton.classList.remove('invisible');
        }
    }

    // Update progress
    updateProgress();

    // Scroll to the next question smoothly
    setTimeout(() => {
        nextQuestion.scrollIntoView({
            behavior: 'smooth',
            block: 'start',
            inline: 'nearest'
        });
    }, 100);
}

function previousQuestion() {
    if (currentQuestionIndex === 0) return;

    // Hide current question
    const currentQuestion = document.querySelector('.current-question');
    currentQuestion.classList.remove('current-question');
    currentQuestion.classList.add('hidden-question');

    // Show previous question
    currentQuestionIndex--;
    const prevQuestion = document.querySelector(`[data-question="${currentQuestionIndex + 1}"]`);
    if (prevQuestion) {
        prevQuestion.classList.remove('hidden-question');
        prevQuestion.classList.add('current-question');

        // Update previous button visibility
        const prevButton = prevQuestion.querySelector('button[onclick="previousQuestion()"]');
        if (prevButton && currentQuestionIndex === 0) {
            prevButton.classList.add('invisible');
        }
    }

    // Update progress
    updateProgress();

    // Scroll to the previous question smoothly
    setTimeout(() => {
        prevQuestion.scrollIntoView({
            behavior: 'smooth',
            block: 'start',
            inline: 'nearest'
        });
    }, 100);
}

function getAnswerFromCard(card, questionId) {
    if (!card) return null;
    const radio = card.querySelector(`input[name="question_${questionId}"]:checked`);
    const textInput = card.querySelector(`textarea[name="question_${questionId}"]`);
    if (radio) return radio.value;
    if (textInput && textInput.value.trim()) return textInput.value.trim();
    return null;
}

function getCurrentAnswer(questionId) {
    const currentQuestion = document.querySelector('.current-question');
    return getAnswerFromCard(currentQuestion, questionId);
}

function collectAllAnswers() {
    document.querySelectorAll('.question-card[data-question-id]').forEach((card) => {
        const questionId = card.dataset.questionId;
        const answer = getAnswerFromCard(card, questionId);
        if (answer !== null && answer !== '') {
            answers[questionId] = answer;
        }
    });
}

function renderCompletionHtml(contentHtml) {
    document.getElementById('assessment-questions').innerHTML = contentHtml;
    showEl(document.getElementById('quiz-section'));
    hideEl(document.getElementById('instructions-section'));
    hideEl(document.getElementById('progress-container'));
    document.getElementById('quiz-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function showSubmittingState() {
    renderCompletionHtml(`
        <div class="text-center py-12">
            <div class="inline-block h-12 w-12 animate-spin rounded-full border-4 border-[#041c54] border-t-transparent mb-4" role="status"></div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Saving your results…</h2>
            <p class="text-gray-600">Please wait while we calculate your score.</p>
        </div>
    `);
}

async function completeAssessment() {
    if (isSubmitting) {
        return;
    }

    collectAllAnswers();

    const currentQuestion = document.querySelector('.current-question');
    if (currentQuestion) {
        const questionId = currentQuestion.dataset.questionId;
        const answer = getCurrentAnswer(questionId);
        if (!answer) {
            alert('Please select an answer before completing the assessment.');
            return;
        }
        answers[questionId] = answer;
    }

    if (!assessmentConfig.isAuthenticated) {
        renderCompletionHtml(`
            <div class="text-center py-12 max-w-xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Assessment finished</h2>
                <p class="text-gray-600 mb-6">Sign in with a client account to save your score and view it in My Assessments.</p>
                <a href="${assessmentConfig.loginUrl}" class="btn-theme-primary inline-flex items-center px-6 py-3 rounded-lg">Sign in to save results</a>
            </div>
        `);
        return;
    }

    if (!assessmentConfig.isClient) {
        renderCompletionHtml(`
            <div class="text-center py-12 max-w-xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Cannot save results</h2>
                <p class="text-gray-600 mb-6">Only client accounts can store assessment scores on the website.</p>
                <a href="{{ route('assessments.index') }}" class="btn-theme-primary inline-flex items-center px-6 py-3 rounded-lg">Browse Assessments</a>
            </div>
        `);
        return;
    }

    isSubmitting = true;
    showSubmittingState();

    try {
        const response = await fetch(assessmentConfig.submitUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ answers }),
            credentials: 'same-origin',
        });

        const data = await response.json().catch(() => ({}));

        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Failed to save assessment.');
        }

        if (data.redirect_url) {
            window.location.href = data.redirect_url;
            return;
        }

        const pct = data.result?.percentage != null ? Math.round(data.result.percentage) : '—';
        renderCompletionHtml(`
            <div class="text-center py-12">
                <h2 class="text-3xl font-bold mb-2" style="color: #041c54;">Assessment completed</h2>
                <p class="text-5xl font-bold my-4" style="color: #041c54;">${pct}%</p>
                <p class="text-gray-600 mb-6">Score: ${data.result?.total_score ?? '—'} / ${data.result?.max_score ?? '—'}</p>
            </div>
        `);
    } catch (error) {
        isSubmitting = false;
        renderCompletionHtml(`
            <div class="text-center py-12 max-w-xl mx-auto">
                <h2 class="text-2xl font-bold text-red-700 mb-3">Could not save</h2>
                <p class="text-gray-600 mb-6">${error.message || 'Something went wrong. Please try again.'}</p>
                <button type="button" onclick="completeAssessment()" class="btn-theme-primary px-6 py-3 rounded-lg">Try again</button>
            </div>
        `);
    }
}

function updateProgress() {
    const progress = Math.round(((currentQuestionIndex + 1) / totalQuestions) * 100);

    document.getElementById('progress-bar').style.width = progress + '%';
    document.getElementById('progress-percentage').textContent = progress + '%';
    document.getElementById('current-question').textContent = currentQuestionIndex + 1;
}

// Add CSS for smooth transitions
const style = document.createElement('style');
style.textContent = `
    .current-question {
        display: block !important;
        animation: fadeIn 0.3s ease-in-out;
    }

    .hidden-question {
        display: none !important;
    }

    #quiz-section.hidden,
    #instructions-section.hidden,
    #progress-container.hidden {
        display: none !important;
    }

    #assessment-page-header {
        display: block !important;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);
</script>
</div>
@endsection
