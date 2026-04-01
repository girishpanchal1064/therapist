@extends('layouts.app')

@section('title', 'About Us - Apani Psychology')
@section('description', 'Learn about our mission to make mental health support accessible, affordable, and effective for everyone.')

@section('content')
<div class="about-page min-h-screen bg-gradient-to-b from-white to-[#BAC2D2]/5">
    {{-- Hero — marketing-page-hero + CTAs (aligned with therapists / assessments / blog) --}}
    <section class="marketing-page-hero">
        <div class="pointer-events-none absolute inset-0 opacity-10" aria-hidden="true">
            <div class="absolute left-4 top-16 h-64 w-64 rounded-full bg-white blur-[64px] md:left-10 md:h-72 md:w-72"></div>
            <div class="absolute -right-8 top-6 h-80 w-80 rounded-full bg-[#647494] blur-[64px] md:right-0 md:h-96 md:w-96"></div>
        </div>
        <div class="relative z-10 mx-auto w-full max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <h1 class="font-display text-4xl font-medium leading-tight text-white md:text-5xl lg:text-[3.75rem] lg:leading-[1.1]">
                About <span class="text-[#BAC2D2]">Apani Psychology</span>
            </h1>
            <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-[#BAC2D2] md:text-lg">
                We're on a mission to make mental health support accessible, affordable, and effective for everyone, everywhere.
            </p>
            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="#mission"
                   class="inline-flex min-h-[3.5rem] w-full items-center justify-center rounded-[14px] border-2 border-white bg-[#041C54] px-8 text-base font-medium text-white shadow-[0_10px_15px_rgba(0,0,0,0.15)] transition hover:bg-[#031340] sm:w-auto sm:min-w-[12rem]">
                    Our Mission
                </a>
                <a href="{{ route('therapists.index') }}"
                   class="inline-flex min-h-[3.75rem] w-full items-center justify-center rounded-[14px] border-2 border-white px-8 text-base font-medium text-white transition hover:bg-white/10 sm:w-auto sm:min-w-[10rem]">
                    Find a Therapist
                </a>
            </div>
        </div>
    </section>

    {{-- Our Mission — Figma 1:1903: text left, stat cards right --}}
    <section id="mission" class="scroll-mt-20 bg-white px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
        <div class="mx-auto grid max-w-7xl gap-10 lg:grid-cols-2 lg:items-start lg:gap-14">
            <div>
                <h2 class="font-display text-3xl font-medium text-[#041C54] md:text-4xl">Our Mission</h2>
                <p class="mt-6 text-base leading-relaxed text-[#7484A4]">
                    Mental health is a fundamental part of human well-being, yet millions of people around the world lack access to quality mental health care and support services. This gap affects individuals, families, and communities on their journey, regardless of their locations, schedules, or financial situation.
                </p>
                <p class="mt-4 text-base leading-relaxed text-[#7484A4]">
                    Through technology and compassionate care, we're breaking down barriers and making professional mental health support accessible to anyone who needs it, when they need it.
                </p>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:gap-6">
                <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white px-6 py-8 text-center shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <p class="font-display text-4xl font-medium text-[#647494]">50K+</p>
                    <p class="mt-2 text-sm text-[#7484A4]">Lives Impacted</p>
                </div>
                <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white px-6 py-8 text-center shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <p class="font-display text-4xl font-medium text-[#647494]">500+</p>
                    <p class="mt-2 text-sm text-[#7484A4]">Licensed Therapists</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Our Values — Figma 1:1922 --}}
    <section id="values" class="scroll-mt-20 px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
        <div class="mx-auto max-w-7xl">
            <div class="mb-10 text-center lg:mb-14">
                <h2 class="font-display text-3xl font-medium text-[#041C54] md:text-4xl">Our Values</h2>
                <p class="mx-auto mt-4 max-w-2xl text-base text-[#7484A4]">The principles that guide everything we do</p>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-8 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EF4444]/10 shadow-sm">
                        <svg class="h-8 w-8 text-[#EF4444]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-display mt-6 text-xl font-medium text-[#041C54]">Compassion</h3>
                    <p class="mt-3 text-sm leading-relaxed text-[#7484A4]">
                        We approach every interaction with empathy, understanding, and genuine care for our client's well-being and mental health.
                    </p>
                </div>
                <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-8 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#10B981]/10 shadow-sm">
                        <svg class="h-8 w-8 text-[#10B981]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-display mt-6 text-xl font-medium text-[#041C54]">Quality</h3>
                    <p class="mt-3 text-sm leading-relaxed text-[#7484A4]">
                        We maintain the highest standards in our services, from the care we provide to the trust we build with each client.
                    </p>
                </div>
                <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-8 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#F59E0B]/10 shadow-sm">
                        <svg class="h-8 w-8 text-[#F59E0B]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-display mt-6 text-xl font-medium text-[#041C54]">Accessibility</h3>
                    <p class="mt-3 text-sm leading-relaxed text-[#7484A4]">
                        We believe mental health support should be available to everyone, regardless of location or circumstances.
                    </p>
                </div>
                <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-8 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#8B5CF6]/10 shadow-sm">
                        <svg class="h-8 w-8 text-[#8B5CF6]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="font-display mt-6 text-xl font-medium text-[#041C54]">Privacy</h3>
                    <p class="mt-3 text-sm leading-relaxed text-[#7484A4]">
                        We uphold strict confidentiality with all information and data, ensuring a safe and secure environment for our clients.
                    </p>
                </div>
                <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-8 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EC4899]/10 shadow-sm">
                        <svg class="h-8 w-8 text-[#EC4899]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-display mt-6 text-xl font-medium text-[#041C54]">Community</h3>
                    <p class="mt-3 text-sm leading-relaxed text-[#7484A4]">
                        We foster a supportive community where people can share experiences and find understanding.
                    </p>
                </div>
                <div class="rounded-2xl border border-[#BAC2D2]/30 bg-white p-8 shadow-[0_10px_15px_rgba(4,28,84,0.05),0_4px_6px_rgba(4,28,84,0.05)]">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#06B6D4]/10 shadow-sm">
                        <svg class="h-8 w-8 text-[#06B6D4]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <h3 class="font-display mt-6 text-xl font-medium text-[#041C54]">Growth</h3>
                    <p class="mt-3 text-sm leading-relaxed text-[#7484A4]">
                        We're committed to continuous improvement and innovation in mental health care delivery.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Meet Our Team — Figma 1:1986 --}}
    <section class="bg-white px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
        <div class="mx-auto max-w-7xl">
            <div class="mb-10 text-center lg:mb-14">
                <h2 class="font-display text-3xl font-medium text-[#041C54] md:text-4xl">Meet Our Team</h2>
                <p class="mx-auto mt-4 max-w-2xl text-base text-[#7484A4]">The passionate people behind our mission</p>
            </div>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                <article class="overflow-hidden rounded-2xl border border-[#BAC2D2]/30 bg-white shadow-[0_10px_15px_-3px_rgba(4,28,84,0.05),0_4px_6px_-4px_rgba(4,28,84,0.05)]">
                    <div class="aspect-[4/5] w-full overflow-hidden bg-[#BAC2D2]/20">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&amp;fit=crop&amp;w=800&amp;q=80"
                             alt="Dr. Sarah Johnson"
                             class="h-full w-full object-cover"
                             width="800"
                             height="1000"
                             loading="lazy">
                    </div>
                    <div class="px-6 py-6 text-center">
                        <h3 class="font-display text-xl font-medium text-[#041C54]">Dr. Sarah Johnson</h3>
                        <p class="mt-1 text-sm font-medium text-[#647494]">Chief Medical Officer</p>
                        <p class="mt-1 text-xs text-[#7484A4]">Clinical Psychology</p>
                        <p class="mt-4 text-sm leading-relaxed text-[#7484A4]">
                            Licensed psychologist with 15+ years of experience in cognitive behavioral therapy and trauma counseling.
                        </p>
                    </div>
                </article>
                <article class="overflow-hidden rounded-2xl border border-[#BAC2D2]/30 bg-white shadow-[0_10px_15px_-3px_rgba(4,28,84,0.05),0_4px_6px_-4px_rgba(4,28,84,0.05)]">
                    <div class="aspect-[4/5] w-full overflow-hidden bg-[#BAC2D2]/20">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&amp;fit=crop&amp;w=800&amp;q=80"
                             alt="Michael Chen"
                             class="h-full w-full object-cover"
                             width="800"
                             height="1000"
                             loading="lazy">
                    </div>
                    <div class="px-6 py-6 text-center">
                        <h3 class="font-display text-xl font-medium text-[#041C54]">Michael Chen</h3>
                        <p class="mt-1 text-sm font-medium text-[#647494]">CEO &amp; Co-Founder</p>
                        <p class="mt-1 text-xs text-[#7484A4]">Mental Health Advocate</p>
                        <p class="mt-4 text-sm leading-relaxed text-[#7484A4]">
                            Technology entrepreneur passionate about making mental health support more accessible through innovation.
                        </p>
                    </div>
                </article>
                <article class="overflow-hidden rounded-2xl border border-[#BAC2D2]/30 bg-white shadow-[0_10px_15px_-3px_rgba(4,28,84,0.05),0_4px_6px_-4px_rgba(4,28,84,0.05)]">
                    <div class="aspect-[4/5] w-full overflow-hidden bg-[#BAC2D2]/20">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&amp;fit=crop&amp;w=800&amp;q=80"
                             alt="Dr. Emily Rodriguez"
                             class="h-full w-full object-cover"
                             width="800"
                             height="1000"
                             loading="lazy">
                    </div>
                    <div class="px-6 py-6 text-center">
                        <h3 class="font-display text-xl font-medium text-[#041C54]">Dr. Emily Rodriguez</h3>
                        <p class="mt-1 text-sm font-medium text-[#647494]">Clinical Director</p>
                        <p class="mt-1 text-xs text-[#7484A4]">Marriage &amp; Family Therapy</p>
                        <p class="mt-4 text-sm leading-relaxed text-[#7484A4]">
                            Licensed therapist and family therapist specializing in relationship dynamics and family systems therapy.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- Our Impact — Figma 1:2038: Lynch / Bermuda gradient (not Gulf Blue) --}}
    <section class="relative overflow-hidden bg-[linear-gradient(166deg,#647494_0%,#6d7f9d_22%,#7484A4_50%,#6d7f9d_78%,#647494_100%)] px-4 py-14 sm:px-6 md:py-16 lg:px-8">
        <div class="pointer-events-none absolute inset-0 opacity-10" aria-hidden="true">
            <div class="absolute left-4 top-10 h-72 w-72 rounded-full bg-white blur-[64px]"></div>
            <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-[#041C54] blur-[64px]"></div>
        </div>
        <div class="relative z-10 mx-auto max-w-7xl text-center">
            <h2 class="font-display text-3xl font-medium text-white md:text-4xl">Our Impact</h2>
            <p class="mx-auto mt-4 max-w-2xl text-base text-white/90">Making a difference in people's lives every day</p>
            <div class="mt-12 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4 lg:gap-8">
                <div>
                    <p class="font-display text-4xl font-medium text-white md:text-5xl">50,000+</p>
                    <p class="mt-2 text-sm text-white/80">Lives Impacted</p>
                </div>
                <div>
                    <p class="font-display text-4xl font-medium text-white md:text-5xl">500+</p>
                    <p class="mt-2 text-sm text-white/80">Licensed Therapists</p>
                </div>
                <div>
                    <p class="font-display text-4xl font-medium text-white md:text-5xl">100,000+</p>
                    <p class="mt-2 text-sm text-white/80">Sessions Completed</p>
                </div>
                <div>
                    <p class="font-display text-4xl font-medium text-white md:text-5xl">95%</p>
                    <p class="mt-2 text-sm text-white/80">Client Satisfaction</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Join Our Mission — Figma CTA --}}
    <section id="join-mission" class="scroll-mt-20 border-t border-white/10 bg-[#041C54] px-4 py-14 sm:px-6 md:py-16 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="font-display text-3xl font-medium text-white md:text-4xl">Join Our Mission</h2>
            <p class="mx-auto mt-4 text-base leading-relaxed text-[#BAC2D2] md:text-lg">
                Whether you're seeking support or looking to help others, there's a place for you in our community.
            </p>
            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="{{ route('therapists.index') }}"
                   class="inline-flex min-h-[3.5rem] w-full items-center justify-center rounded-[14px] bg-white px-8 text-base font-medium text-[#041C54] shadow-[0_10px_15px_rgba(0,0,0,0.12)] transition hover:bg-[#BAC2D2]/30 sm:w-auto sm:min-w-[12rem]">
                    Find a Therapist
                </a>
                <a href="{{ route('register') }}"
                   class="inline-flex min-h-[3.75rem] w-full items-center justify-center rounded-[14px] border-2 border-white px-8 text-base font-medium text-white transition hover:bg-white/10 sm:w-auto sm:min-w-[12rem]">
                    Get Started Today
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
