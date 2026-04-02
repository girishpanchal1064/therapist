@extends('layouts.app')

@section('title', 'Mental Health Assessments - Apani Psychology')
@section('description', 'Take our comprehensive mental health assessments to better understand your mental wellness and get personalized recommendations.')

@section('content')
<div class="assessments-page min-h-screen bg-gradient-to-b from-white to-[#BAC2D2]/5">
    {{-- Hero — Figma node 1:1458; solid Gulf Blue, buttons per colors.txt --}}
    <section class="marketing-page-hero">
        <div class="pointer-events-none absolute inset-0 opacity-10" aria-hidden="true">
            <div class="absolute left-4 top-16 h-64 w-64 rounded-full bg-white blur-[64px] md:left-10 md:h-72 md:w-72"></div>
            <div class="absolute -right-8 top-6 h-80 w-80 rounded-full bg-[#647494] blur-[64px] md:right-0 md:h-96 md:w-96"></div>
        </div>
        <div class="relative z-10 mx-auto w-full max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <h1 class="font-display text-4xl font-medium leading-tight text-white md:text-5xl lg:text-[3.75rem] lg:leading-[1.1]">
                Mental Health <span class="text-[#BAC2D2]">Assessments</span>
            </h1>
            <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-[#BAC2D2] md:text-lg">
                Take our comprehensive mental health assessments to better understand your mental wellness. Get personalized recommendations for your mental health journey.
            </p>
            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="#assessments"
                   class="inline-flex min-h-[3.5rem] w-full items-center justify-center rounded-[14px] border-2 border-white bg-[#041C54] px-8 text-base font-medium text-white shadow-[0_10px_15px_rgba(0,0,0,0.15)] transition hover:bg-[#031340] sm:w-auto sm:min-w-[12rem]">
                    Start Assessment
                </a>
                <a href="#how-it-works"
                   class="inline-flex min-h-[3.75rem] w-full items-center justify-center rounded-[14px] border-2 border-white px-8 text-base font-medium text-white transition hover:bg-white/10 sm:w-auto sm:min-w-[10rem]">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    {{-- Available Assessments — Figma 1:1096 --}}
    <section id="assessments" class="scroll-mt-20 px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="mx-auto max-w-7xl">
            <div class="mb-12 text-center lg:mb-16">
                <h2 class="font-display text-3xl font-medium text-[#041C54] md:text-4xl">
                    Available Assessments
                </h2>
                <p class="mx-auto mt-4 max-w-2xl text-base text-[#7484A4]">
                    Choose an assessment that best fits your needs. Each assessment is designed by mental health professionals to provide accurate insights into your mental health.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse($assessments as $assessment)
                    @php
                        $level = $assessment->question_count <= 15
                            ? 'Beginner'
                            : ($assessment->question_count <= 28 ? 'Intermediate' : 'Advanced');
                        $showPopular = $loop->iteration <= 2;
                    @endphp
                    <article class="relative flex flex-col overflow-hidden rounded-2xl border border-[#BAC2D2]/30 bg-white shadow-[0_10px_15px_-3px_rgba(4,28,84,0.05),0_4px_6px_-4px_rgba(4,28,84,0.05)] transition-shadow duration-300 hover:shadow-[0_20px_40px_-12px_rgba(4,28,84,0.12)]">
                        @if($showPopular)
                            <div class="absolute right-4 top-4 z-10 inline-flex items-center gap-1 rounded-full bg-[#041C54] px-3 py-1 text-xs font-medium text-white shadow-md">
                                <svg class="h-3 w-3 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Popular
                            </div>
                        @endif

                        <div class="flex flex-1 flex-col p-8 pt-8">
                            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-[linear-gradient(135deg,rgba(100,116,148,0.1)_0%,rgba(4,28,84,0.05)_100%)]">
                                <div class="text-[#647494] [&_svg]:h-8 [&_svg]:w-8">
                                    @if($assessment->icon === 'depression')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                        </svg>
                                    @elseif($assessment->icon === 'anxiety')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    @elseif($assessment->icon === 'stress')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @elseif($assessment->icon === 'sleep')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                        </svg>
                                    @elseif($assessment->icon === 'relationships')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    @elseif($assessment->icon === 'wellness')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @else
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            <h3 class="font-display mt-6 text-xl font-medium leading-snug text-[#041C54]">
                                {{ $assessment->title }}
                            </h3>
                            <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-[#7484A4]">
                                {{ $assessment->description }}
                            </p>

                            <div class="mt-6 grid grid-cols-3 gap-2 rounded-[14px] bg-[#BAC2D2]/10 px-3 py-4">
                                <div class="flex flex-col items-center gap-1 text-center">
                                    <svg class="h-4 w-4 text-[#7484A4]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-xs text-[#7484A4]">{{ $assessment->duration_minutes }} min</span>
                                </div>
                                <div class="flex flex-col items-center gap-1 text-center">
                                    <svg class="h-4 w-4 text-[#7484A4]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-xs text-[#7484A4]">{{ $assessment->question_count }} Qs</span>
                                </div>
                                <div class="flex flex-col items-center gap-1 text-center">
                                    <svg class="h-4 w-4 text-[#7484A4]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                    <span class="text-xs text-[#7484A4]">{{ $level }}</span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('assessments.start', $assessment->slug) }}"
                                   class="inline-flex h-[52px] w-full items-center justify-center gap-2 rounded-[14px] bg-[#041C54] text-base font-medium text-white shadow-[0_8px_20px_rgba(4,28,84,0.35)] transition hover:bg-[#647494]">
                                    Start Assessment
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-[#BAC2D2]/20">
                            <svg class="h-12 w-12 text-[#7484A4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="font-display text-xl font-medium text-[#041C54]">No Assessments Available</h3>
                        <p class="mt-2 text-[#7484A4]">We're working on adding more assessments to our platform.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- How It Works — Figma 1:1360 --}}
    <section id="how-it-works" class="scroll-mt-20 px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="mx-auto max-w-7xl">
            <div class="mb-12 text-center lg:mb-16">
                <h2 class="font-display text-3xl font-medium text-[#041C54] md:text-4xl">How It Works</h2>
                <p class="mx-auto mt-4 max-w-2xl text-base text-[#7484A4]">
                    Simple steps to get your personalized mental health insights and recommendations
                </p>
            </div>

            <div class="flex flex-col gap-6 lg:flex-row lg:items-stretch">
                {{-- Step 1 --}}
                <div class="relative flex flex-1 flex-col rounded-2xl border border-[#BAC2D2]/30 bg-white p-8 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[14px] bg-gradient-to-br from-[#647494] to-[#041C54] text-xl font-medium text-white shadow-md">
                            1
                        </div>
                        <div class="hidden h-px flex-1 bg-gradient-to-r from-[#647494]/40 to-transparent md:block"></div>
                    </div>
                    <!-- <div class="mt-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-[#BAC2D2]/20 to-[#647494]/10">
                        <svg class="h-8 w-8 text-[#647494]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div> -->
                    <h3 class="font-display mt-6 text-xl font-medium text-[#041C54]">Choose Assessment</h3>
                    <p class="mt-3 text-sm leading-relaxed text-[#7484A4]">
                        Select from our range of scientifically-backed assessments designed to provide specific insights into your mental health.
                    </p>
                </div>

                <div class="hidden shrink-0 items-center justify-center self-center text-[#647494] lg:flex" aria-hidden="true">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>

                {{-- Step 2 --}}
                <div class="relative flex flex-1 flex-col rounded-2xl border border-[#BAC2D2]/30 bg-white p-8 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[14px] bg-gradient-to-br from-[#647494] to-[#041C54] text-xl font-medium text-white shadow-md">
                            2
                        </div>
                        <div class="hidden h-px flex-1 bg-gradient-to-r from-[#647494]/40 to-transparent md:block"></div>
                    </div>
                    <!-- <div class="mt-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-[#BAC2D2]/20 to-[#647494]/10">
                        <svg class="h-8 w-8 text-[#647494]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div> -->
                    <h3 class="font-display mt-6 text-xl font-medium text-[#041C54]">Answer Questions</h3>
                    <p class="mt-3 text-sm leading-relaxed text-[#7484A4]">
                        Complete a series of carefully designed questions. Be honest and take your time to provide accurate responses.
                    </p>
                </div>

                <div class="hidden shrink-0 items-center justify-center self-center text-[#647494] lg:flex" aria-hidden="true">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>

                {{-- Step 3 --}}
                <div class="relative flex flex-1 flex-col rounded-2xl border border-[#BAC2D2]/30 bg-white p-8 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[14px] bg-gradient-to-br from-[#647494] to-[#041C54] text-xl font-medium text-white shadow-md">
                            3
                        </div>
                    </div>
                    <!-- <div class="mt-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-[#BAC2D2]/20 to-[#647494]/10">
                        <svg class="h-8 w-8 text-[#647494]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div> -->
                    <h3 class="font-display mt-6 text-xl font-medium text-[#041C54]">Get Results</h3>
                    <p class="mt-3 text-sm leading-relaxed text-[#7484A4]">
                        Receive detailed insights, personalized recommendations, and understand your mental health better.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Why Take Our Assessments — Figma 1:1417 --}}
    <section class="px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="mx-auto max-w-7xl">
            <div class="mb-12 text-center lg:mb-16">
                <h2 class="font-display text-3xl font-medium text-[#041C54] md:text-4xl">Why Take Our Assessments?</h2>
                <p class="mx-auto mt-4 max-w-3xl text-base text-[#7484A4]">
                    Our assessments are designed to provide valuable insights into your mental health and well-being
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-8 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <!-- <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[linear-gradient(135deg,rgba(100,116,148,0.1)_0%,rgba(4,28,84,0.05)_100%)] shadow-sm">
                        <svg class="h-8 w-8 text-[#647494]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div> -->
                    <h3 class="font-display mt-6 text-lg font-medium text-[#041C54]">Professional Design</h3>
                    <p class="mt-3 text-sm leading-relaxed text-[#7484A4]">
                        Our assessments are developed with mental health professionals and based on clinical research.
                    </p>
                </div>
                <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-8 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[linear-gradient(135deg,rgba(100,116,148,0.1)_0%,rgba(4,28,84,0.05)_100%)] shadow-sm">
                        <svg class="h-8 w-8 text-[#647494]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="font-display mt-6 text-lg font-medium text-[#041C54]">Privacy Protected</h3>
                    <p class="mt-3 text-sm leading-relaxed text-[#7484A4]">
                        Your responses are completely confidential and secure. We never share your personal data.
                    </p>
                </div>
                <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-8 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[linear-gradient(135deg,rgba(100,116,148,0.1)_0%,rgba(4,28,84,0.05)_100%)] shadow-sm">
                        <svg class="h-8 w-8 text-[#647494]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-display mt-6 text-lg font-medium text-[#041C54]">Instant Results</h3>
                    <p class="mt-3 text-sm leading-relaxed text-[#7484A4]">
                        Get immediate feedback with detailed insights and personalized recommendations.
                    </p>
                </div>
                <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-8 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[linear-gradient(135deg,rgba(100,116,148,0.1)_0%,rgba(4,28,84,0.05)_100%)] shadow-sm">
                        <svg class="h-8 w-8 text-[#647494]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <h3 class="font-display mt-6 text-lg font-medium text-[#041C54]">Actionable Insights</h3>
                    <p class="mt-3 text-sm leading-relaxed text-[#7484A4]">
                        Receive practical advice and next steps to improve your mental health and wellbeing.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA — Figma 1:1472; solid Gulf Blue --}}
    <section class="relative overflow-hidden bg-[#041C54] px-4 py-16 sm:px-6 md:py-20 lg:px-8">
        <div class="pointer-events-none absolute inset-0 opacity-10" aria-hidden="true">
            <div class="absolute left-4 top-10 h-72 w-72 rounded-full bg-white blur-[64px] md:h-96 md:w-96"></div>
            <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-[#BAC2D2] blur-[64px]"></div>
        </div>
        <div class="relative mx-auto max-w-3xl text-center">
            <h2 class="font-display text-3xl font-medium text-white md:text-4xl">
                Ready to Understand Your Mental Health Better?
            </h2>
            <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-[#BAC2D2] md:text-lg">
                Take the first step towards better mental wellness. Our assessments are free, confidential, and designed to help you.
            </p>
            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="#assessments"
                   class="inline-flex min-h-[3.5rem] w-full items-center justify-center rounded-[14px] border-2 border-white bg-[#041C54] px-8 text-base font-medium text-white shadow-[0_10px_15px_rgba(0,0,0,0.15)] transition hover:bg-[#031340] sm:w-auto">
                    Start Free Assessment
                </a>
                <a href="{{ route('therapists.index') }}"
                   class="inline-flex min-h-[3.75rem] w-full items-center justify-center rounded-[14px] border-2 border-white px-8 text-base font-medium text-white transition hover:bg-white/10 sm:w-auto">
                    Talk to Therapist
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
