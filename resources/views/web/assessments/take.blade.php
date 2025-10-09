@extends('layouts.app')

@section('title', $assessment->title . ' - Mental Health Assessment')
@section('description', $assessment->meta_description ?? $assessment->description)

@section('content')
<!-- Assessment Header -->
<section class="bg-gradient-to-br from-primary-50 to-secondary-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('assessments.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Assessments
                </a>
            </div>

            <!-- Assessment Info -->
            <div class="flex items-center justify-center mb-6">
                <div class="w-16 h-16 rounded-xl flex items-center justify-center shadow-lg mr-6" style="background-color: {{ $assessment->color }};">
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
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">{{ $assessment->title }}</h1>
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
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
                        <span class="px-3 py-1 rounded-full text-xs font-semibold text-white" style="background-color: {{ $assessment->color }};">
                            {{ $assessment->category }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <p class="text-lg text-gray-600 max-w-3xl mx-auto mb-8">
                {{ $assessment->description }}
            </p>

            <!-- Start Button -->
            <button onclick="startAssessment()" class="inline-flex items-center px-8 py-4 text-lg font-semibold text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5" style="background-color: {{ $assessment->color }};">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Start Assessment
            </button>
        </div>
    </div>
</section>

<!-- Assessment Instructions -->
<section id="instructions-section" class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl p-8 mb-8 border border-gray-200">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-4 mt-0.5 flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Privacy Protected</h3>
                            <p class="text-gray-600 text-sm">Your responses are completely confidential and secure.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-4 mt-0.5 flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Estimated Time</h3>
                            <p class="text-gray-600 text-sm">This assessment takes approximately {{ $assessment->duration_minutes }} minutes.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-4 mt-0.5 flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
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
            <div class="bg-white rounded-xl p-6 border border-gray-200">
                <div class="grid grid-cols-3 gap-6 text-center">
                    <div>
                        <div class="text-2xl font-bold text-primary-600 mb-1">{{ $assessment->question_count }}</div>
                        <div class="text-sm text-gray-600">Questions</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-primary-600 mb-1">{{ $assessment->duration_minutes }}</div>
                        <div class="text-sm text-gray-600">Minutes</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-primary-600 mb-1">{{ $assessment->category }}</div>
                        <div class="text-sm text-gray-600">Category</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assessment Questions (Hidden Initially) -->
        <div id="assessment-questions" class="hidden">
            <form id="assessment-form" class="space-y-8">
                @foreach($assessment->questions as $index => $question)
                    <div class="question-card bg-white rounded-xl shadow-sm border border-gray-200 p-6 {{ $index === 0 ? 'current-question' : 'hidden-question' }}" data-question="{{ $index + 1 }}" data-question-id="{{ $question->id }}">
                        <div class="flex items-start mb-4">
                            <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center mr-4 mt-1">
                                <span class="text-sm font-semibold text-primary-600">{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $question->question_text }}</h3>

                                @if($question->question_type === 'multiple_choice')
                                    <div class="space-y-3">
                                        @foreach($question->options as $option)
                                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-primary-300 hover:bg-primary-50 cursor-pointer transition-colors">
                                                <input type="radio" name="question_{{ $question->id }}" value="{{ $option['value'] }}" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500" required>
                                                <span class="ml-3 text-gray-700">{{ $option['text'] }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif($question->question_type === 'scale')
                                    <div class="space-y-3">
                                        @foreach($question->options as $option)
                                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-primary-300 hover:bg-primary-50 cursor-pointer transition-colors">
                                                <input type="radio" name="question_{{ $question->id }}" value="{{ $option['value'] }}" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500" required>
                                                <span class="ml-3 text-gray-700">{{ $option['text'] }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif($question->question_type === 'yes_no')
                                    <div class="space-y-3">
                                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-primary-300 hover:bg-primary-50 cursor-pointer transition-colors">
                                            <input type="radio" name="question_{{ $question->id }}" value="1" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500" required>
                                            <span class="ml-3 text-gray-700">Yes</span>
                                        </label>
                                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-primary-300 hover:bg-primary-50 cursor-pointer transition-colors">
                                            <input type="radio" name="question_{{ $question->id }}" value="0" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500" required>
                                            <span class="ml-3 text-gray-700">No</span>
                                        </label>
                                    </div>
                                @elseif($question->question_type === 'text')
                                    <textarea name="question_{{ $question->id }}" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" placeholder="Please provide your response..." required></textarea>
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
                                <button type="button" onclick="nextQuestion()" class="flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all duration-200 shadow-sm hover:shadow-md">
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

<!-- Progress Bar (Hidden Initially) -->
<div id="progress-container" class="fixed top-0 left-0 right-0 bg-white shadow-lg z-50 hidden border-b border-gray-200">
    <div class="max-w-4xl mx-auto px-4 py-4">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3" style="background-color: {{ $assessment->color }}20;">
                    <svg class="w-5 h-5" style="color: {{ $assessment->color }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $assessment->title }}</h3>
                    <p class="text-sm text-gray-600">Question <span id="current-question">1</span> of {{ $assessment->question_count }}</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-lg font-bold text-gray-900" id="progress-percentage">0%</div>
                <div class="text-sm text-gray-600">Complete</div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
            <div id="progress-bar" class="h-full rounded-full transition-all duration-500 ease-out relative" style="background: linear-gradient(90deg, {{ $assessment->color }}, {{ $assessment->color }}dd); width: 0%">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-pulse"></div>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="flex justify-between mt-2">
            @for($i = 1; $i <= $assessment->question_count; $i++)
                <div class="w-2 h-2 rounded-full bg-gray-300 progress-step" data-step="{{ $i }}"></div>
            @endfor
        </div>
    </div>
</div>

<script>
let currentQuestionIndex = 0;
const totalQuestions = {{ $assessment->questions->count() }};
const answers = {};

function startAssessment() {
    // Show the assessment questions
    document.getElementById('assessment-questions').classList.remove('hidden');

    // Show the progress bar
    document.getElementById('progress-container').classList.remove('hidden');

    // Scroll to top
    window.scrollTo(0, 0);

    // Update progress
    updateProgress();
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
        // Complete the assessment
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

function getCurrentAnswer(questionId) {
    const currentQuestion = document.querySelector('.current-question');
    const radioInputs = currentQuestion.querySelectorAll(`input[name="question_${questionId}"]:checked`);
    const textInput = currentQuestion.querySelector(`textarea[name="question_${questionId}"]`);

    if (radioInputs.length > 0) {
        return radioInputs[0].value;
    } else if (textInput && textInput.value.trim()) {
        return textInput.value.trim();
    }

    return null;
}

function completeAssessment() {
    // Show completion message
    const completionMessage = `
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Assessment Completed!</h2>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                Thank you for completing the {{ $assessment->title }}. Your responses have been recorded and will be processed to provide personalized insights.
            </p>
            <div class="space-y-4">
                <a href="{{ route('assessments.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    Browse More Assessments
                </a>
                <a href="{{ route('therapists.index') }}" class="inline-flex items-center px-6 py-3 border border-primary-600 text-primary-600 rounded-lg hover:bg-primary-50 transition-colors ml-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Find a Therapist
                </a>
            </div>
        </div>
    `;

    document.getElementById('assessment-questions').innerHTML = completionMessage;

    // Hide progress bar
    document.getElementById('progress-container').classList.add('hidden');

    // In a real application, you would submit the answers to the server
    console.log('Assessment answers:', answers);
}

function updateProgress() {
    const answeredQuestions = Object.keys(answers).length;
    const progress = Math.round((answeredQuestions / totalQuestions) * 100);

    // Update progress bar
    document.getElementById('progress-bar').style.width = progress + '%';
    document.getElementById('progress-percentage').textContent = progress + '%';

    // Update current question number
    document.getElementById('current-question').textContent = currentQuestionIndex + 1;

    // Update progress steps
    document.querySelectorAll('.progress-step').forEach((step, index) => {
        if (index < answeredQuestions) {
            step.style.backgroundColor = '{{ $assessment->color }}';
            step.style.transform = 'scale(1.2)';
        } else if (index === answeredQuestions) {
            step.style.backgroundColor = '{{ $assessment->color }}80';
            step.style.transform = 'scale(1.1)';
        } else {
            step.style.backgroundColor = '#D1D5DB';
            step.style.transform = 'scale(1)';
        }
    });
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

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .progress-step {
        transition: all 0.3s ease;
    }
`;
document.head.appendChild(style);
</script>
@endsection
