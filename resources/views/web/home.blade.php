@extends('layouts.app')

@section('title', 'Apani Psychology - Online Mental Health Counseling')
@section('description', 'Connect with verified therapists for online counseling, therapy sessions, and mental health support. Professional help when you need it most.')

@section('head')
<style>
    /* Page Background Helpers */
    .apni-hero-bg {
        background-color: #FFFFFFE5;
        padding-top: clamp(4rem, 10vw + 2rem, 10rem);
        padding-bottom: clamp(3rem, 6vw + 1.25rem, 8rem);
    }

    @media (max-width: 639px) {
        .apni-hero-bg {
            padding-top: clamp(3rem, 8vw + 1.5rem, 5.5rem);
            padding-bottom: 2.75rem;
        }
    }

    .apni-section-light {
        background: linear-gradient(to bottom, #ffffff 0, #f5f7fb 100%);
    }

    .apni-section-dark {
        background: #041C54;
        color: #ffffff;
    }

    .apni-section-soft-gradient {
        background: radial-gradient(circle at top left, #ffffff 0, #f3f4ff 40%, #e5e7f5 100%);
    }

    /* Generic Card */
    .apni-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 24px 80px rgba(4, 28, 84, 0.08);
        border: 1px solid rgba(186, 194, 210, 0.35);
    }

    /* Hero Layout */
    .apni-hero-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
        gap: clamp(1.5rem, 4vw, 3.25rem);
        align-items: center;
    }

    .apni-hero-grid > * {
        min-width: 0;
    }

    @media (max-width: 1024px) {
        .apni-hero-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 2rem;
        }
    }

    .apni-hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        background: rgba(100, 116, 148, 0.06);
        color: #647494;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .apni-hero-heading-main {
        font-size: clamp(2.25rem, 3.1vw + 1rem, 3.5rem);
        line-height: 1.1;
        color: #041C54;
    }

    .apni-hero-heading-highlight {
        background: linear-gradient(135deg, #647494 0%, #8B5CF6 40%, #EC4899 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .apni-hero-body {
        color: #7484A4;
        font-size: clamp(0.95rem, 0.35vw + 0.9rem, 1.05rem);
        line-height: 1.65;
        max-width: 34rem;
    }

    .apni-hero-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .apni-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 0.9rem;
        border-radius: 999px;
        background: rgba(186, 194, 210, 0.18);
        color: #647494;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .apni-hero-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: clamp(0.65rem, 3vw, 1.25rem);
        margin-top: 1.75rem;
    }

    @media (min-width: 640px) {
        .apni-hero-stats {
            margin-top: 2rem;
        }
    }

    .apni-hero-stat-label {
        font-size: 0.8rem;
        color: #7484A4;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 0.15rem;
    }

    .apni-hero-stat-value {
        font-size: clamp(1.1rem, 2.5vw + 0.85rem, 1.35rem);
        font-weight: 700;
        color: #041C54;
    }

    @media (max-width: 380px) {
        .apni-hero-stat-label {
            font-size: 0.68rem;
            letter-spacing: 0.06em;
        }
    }

    .apni-hero-cta-primary,
    .apni-hero-cta-primary:visited {
        background: linear-gradient(135deg, #647494 0%, #041C54 100%);
        color: #ffffff !important;
        text-decoration: none;
        border-radius: 999px;
        padding: 0.85rem 1.5rem;
        font-weight: 600;
        font-size: clamp(0.9rem, 0.5vw + 0.85rem, 0.98rem);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 18px 40px rgba(4, 28, 84, 0.35);
    }

    @media (min-width: 640px) {
        .apni-hero-cta-primary,
        .apni-hero-cta-primary:visited {
            padding: 0.9rem 1.8rem;
        }
    }

    .apni-hero-cta-primary:hover,
    .apni-hero-cta-primary:focus-visible {
        color: #ffffff !important;
        text-decoration: none;
        background: linear-gradient(135deg, #5c6d8a 0%, #031540 100%);
        box-shadow: 0 20px 44px rgba(4, 28, 84, 0.42);
    }

    .apni-hero-cta-primary:focus-visible {
        outline: 2px solid #647494;
        outline-offset: 3px;
    }

    .apni-hero-cta-secondary,
    .apni-hero-cta-secondary:visited {
        border-radius: 999px;
        padding: 0.85rem 1.35rem;
        font-weight: 600;
        font-size: clamp(0.88rem, 0.5vw + 0.82rem, 0.95rem);
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border: 1px solid rgba(186, 194, 210, 0.9);
        color: #041C54 !important;
        text-decoration: none;
        background: #ffffff;
    }

    @media (min-width: 640px) {
        .apni-hero-cta-secondary,
        .apni-hero-cta-secondary:visited {
            padding: 0.9rem 1.6rem;
        }
    }

    .apni-hero-cta-secondary:hover,
    .apni-hero-cta-secondary:focus-visible {
        color: #041C54 !important;
        text-decoration: none;
        background: #eef1f6;
        border-color: rgba(100, 116, 148, 0.45);
    }

    .apni-hero-cta-secondary:focus-visible {
        outline: 2px solid #647494;
        outline-offset: 3px;
    }

    .apni-hero-cta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.65rem;
        margin-top: 1.5rem;
    }

    @media (min-width: 640px) {
        .apni-hero-cta-row {
            gap: 0.75rem;
            margin-top: 1.75rem;
        }
    }

    /* Hero Right Image Card (homepage hero redesign) */
    .apni-hero-card {
        position: relative;
        border-radius: 28px;
        overflow: hidden;
        background: #e5e7f5;
        box-shadow: 0 32px 80px rgba(4, 28, 84, 0.18);
        border: 1px solid rgba(186, 194, 210, 0.65);
        aspect-ratio: 3 / 3;
    }

    @media (max-width: 1024px) {
        .apni-hero-card {
            margin-top: 1.5rem;
            margin-left: auto;
            margin-right: auto;
            max-width: min(100%, 26rem);
        }
    }

    @media (max-width: 768px) {
        .apni-hero-card {
            margin-top: 2rem;
        }
    }

    .apni-hero-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: scale(1.02);
        transform-origin: center;
    }

    .apni-hero-floating-pill {
        position: absolute;
        top: 1.25rem;
        left: 1.25rem;
        padding: 0.45rem 0.9rem;
        border-radius: 999px;
        background: #ffffff;
        box-shadow: 0 18px 45px rgba(4, 28, 84, 0.28);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: #041C54;
        font-weight: 500;
    }

    .apni-hero-floating-pill .dot {
        width: 9px;
        height: 9px;
        border-radius: 999px;
        background-color: #10B981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.18);
    }

    .apni-hero-floating-card {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        padding: 0.6rem 1rem;
        border-radius: 999px;
        background: #ffffff;
        box-shadow: 0 22px 55px rgba(4, 28, 84, 0.28);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: #041C54;
        font-weight: 500;
    }

    .apni-hero-floating-card .check {
        width: 20px;
        height: 20px;
        border-radius: 999px;
        background: #10B981;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 0.9rem;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.18);
    }

    .apni-hero-floating-stat {
        position: absolute;
        right: 1.5rem;
        bottom: 1.5rem;
        padding: 0.55rem 1.1rem;
        border-radius: 999px;
        background: #ffffff;
        box-shadow: 0 18px 45px rgba(4, 28, 84, 0.26);
        font-size: 0.8rem;
        color: #041C54;
        font-weight: 600;
    }

    @media (max-width: 480px) {
        .apni-hero-floating-pill {
            top: 0.75rem;
            left: 0.75rem;
            padding: 0.32rem 0.65rem;
            font-size: 0.68rem;
            max-width: calc(100% - 7.5rem);
        }

        .apni-hero-floating-pill span:last-child {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .apni-hero-floating-card {
            top: auto;
            bottom: 3.25rem;
            right: 0.65rem;
            left: 0.65rem;
            padding: 0.45rem 0.75rem;
            font-size: 0.72rem;
            border-radius: 14px;
        }

        .apni-hero-floating-stat {
            right: 0.65rem;
            bottom: 0.65rem;
            left: 0.65rem;
            padding: 0.45rem 0.75rem;
            font-size: 0.72rem;
            text-align: center;
        }
    }

    /* Section Headings */
    .apni-section-title {
        font-size: clamp(2rem, 2.4vw + 0.5rem, 2.6rem);
        font-weight: 700;
        color: #041C54;
        margin-bottom: 0.75rem;
    }

    .apni-section-subtitle {
        color: #7484A4;
        max-width: 34rem;
        margin-left: auto;
        margin-right: auto;
    }

    .apni-services-heading-main {
        font-size: clamp(2.1rem, 2.7vw + 0.65rem, 3rem);
        line-height: 1.1;
        color: #041C54;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .apni-services-heading-highlight {
        background: linear-gradient(135deg, #041C54 0%, #647494 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .apni-services-subtitle {
        color: #7484A4;
        max-width: 44rem;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.7;
    }

    .apni-expertise-section {
        background: linear-gradient(to bottom, #ffffff 0%, #BAC2D205 100%);
    }

    .apni-expertise-heading-main {
        font-size: clamp(2.1rem, 2.7vw + 0.65rem, 3rem);
        line-height: 1.1;
        color: #041C54;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .apni-expertise-heading-highlight {
        background: linear-gradient(135deg, #041C54 0%, #647494 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .apni-expertise-subtitle {
        color: #7484A4;
        max-width: 48rem;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.7;
    }

    .apni-expertise-card {
        border-radius: 18px;
        border: 1px solid #BAC2D230;
        background: #ffffff;
        box-shadow: 0 18px 40px rgba(4, 28, 84, 0.06);
        padding: 1.35rem 1.25rem;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        height: 100%;
    }

    .apni-expertise-card:hover {
        transform: translateY(-6px);
        border-color: #64749440;
        box-shadow: 0 28px 70px rgba(100, 116, 148, 0.2);
    }

    .apni-expertise-icon {
        width: 56px;
        height: 56px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        background: #64749410;
        color: #647494;
    }

    .apni-expertise-name {
        color: #041C54;
        font-size: 1.05rem;
        font-weight: 600;
        text-align: center;
    }

    .apni-expertise-description {
        color: #7484A4;
        margin-top: 0.55rem;
        text-align: center;
        line-height: 1.5;
    }

    /* Service / Feature Cards */
    .apni-service-card {
        border-radius: 18px;
        border: 1px solid rgba(186, 194, 210, 0.45);
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 18px 40px rgba(4, 28, 84, 0.05);
        padding: 1.4rem 1.4rem 1.3rem;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease, background 0.25s ease;
    }

    .apni-service-card:hover {
        transform: translateY(-6px);
        border-color: rgba(100, 116, 148, 0.75);
        box-shadow: 0 28px 70px rgba(4, 28, 84, 0.14);
        background: #ffffff;
    }

    .apni-service-icon {
        width: 48px;
        height: 48px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        background: rgba(100, 116, 148, 0.06);
        color: #647494;
    }

    /* Dark Therapist Section */
    .apni-therapist-section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1.5rem;
        color: #ffffff;
    }

    @media (max-width: 767px) {
        .apni-therapist-section-header {
            flex-direction: column;
            align-items: stretch;
            gap: 1.25rem;
        }

        .apni-therapist-section-header .apni-therapist-viewall {
            align-self: flex-start;
        }
    }

    .apni-therapist-section-header p {
        color: rgba(255, 255, 255, 0.75);
        max-width: 30rem;
    }

    .apni-dark-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.9rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.06);
        color: #ffffff;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .apni-therapist-heading-main {
        font-size: clamp(2rem, 2.2vw + 1rem, 3rem);
        line-height: 1.1;
        font-weight: 700;
        color: #ffffff;
    }

    .apni-therapist-heading-highlight {
        background: linear-gradient(135deg, #BAC2D2 0%, #ffffff 48%, #BAC2D2 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    /* Therapist Cards - modern image-top layout */
    .apni-therapist-viewall {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border-radius: 999px;
        background: #ffffff;
        color: #041C54;
        padding: 0.7rem 1.4rem;
        font-size: 0.9rem;
        font-weight: 500;
        box-shadow: 0 10px 30px rgba(4, 28, 84, 0.28);
        border: 1px solid #BAC2D220;
    }

    .apni-therapist-viewall:hover {
        background: #BAC2D2;
        color: #041C54;
    }

    .therapist-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        box-shadow: 0 24px 60px rgba(4, 28, 84, 0.35);
        border: 1px solid #BAC2D220;
        height: 100%;
    }

    .therapist-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 32px 90px rgba(4, 28, 84, 0.45);
        border-color: #64749440;
    }

    .therapist-image-wrap {
        position: relative;
        height: 210px;
        background: #BAC2D2;
    }

    .therapist-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .therapist-verified-badge {
        position: absolute;
        top: 0.85rem;
        right: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        background: #10B981;
        color: #ffffff;
        padding: 0.3rem 0.7rem;
        border-radius: 999px;
        font-size: 0.68rem;
        font-weight: 500;
        box-shadow: 0 8px 18px rgba(16, 185, 129, 0.45);
    }

    .therapist-verified-badge svg {
        width: 12px;
        height: 12px;
    }

    .therapist-rating-chip {
        position: absolute;
        left: 0.85rem;
        bottom: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.98);
        color: #647494;
        padding: 0.28rem 0.7rem;
        font-size: 0.72rem;
        font-weight: 500;
        box-shadow: 0 10px 22px rgba(4, 28, 84, 0.35);
    }

    .therapist-rating-chip svg {
        width: 13px;
        height: 13px;
        color: #F59E0B;
    }

    .therapist-content {
        padding: 1.15rem 1.15rem 1.2rem;
    }

    .therapist-name {
        color: #041C54;
        font-size: 1.5rem;
        font-weight: 500;
        line-height: 1.25;
        margin-bottom: 0.25rem;
        font-family: var(--font-display);
    }

    .therapist-role {
        color: #7484A4;
        font-size: 0.8rem;
        margin-bottom: 0.15rem;
    }

    .therapist-focus {
        color: #647494;
        font-size: 0.82rem;
        margin-bottom: 0.7rem;
    }

    .therapist-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
        margin-bottom: 0.9rem;
    }

    .therapist-tag {
        border-radius: 999px;
        background: #BAC2D210;
        color: #7484A4;
        padding: 0.2rem 0.55rem;
        font-size: 0.7rem;
        line-height: 1.2;
    }

    .therapist-meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #7484A4;
        font-size: 0.72rem;
        margin-bottom: 0.7rem;
        padding-bottom: 0.65rem;
        border-bottom: 1px solid #BAC2D220;
    }

    .therapist-next {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        color: #647494;
        font-size: 0.8rem;
        margin-bottom: 0.95rem;
    }

    .therapist-next svg {
        width: 14px;
        height: 14px;
        color: #10B981;
    }

    .therapist-footer {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
    }

    .therapist-price-value {
        color: #041C54;
        font-size: 1.15rem;
        font-weight: 500;
        line-height: 1.2;
    }

    .therapist-price-label {
        color: #7484A4;
        font-size: 0.7rem;
    }

    .btn-book-session {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #647494 0%, #041C54 100%);
        color: #ffffff;
        padding: 0.55rem 1.2rem;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 500;
        min-width: 96px;
        box-shadow: 0 14px 30px rgba(4, 28, 84, 0.4);
    }

    .btn-book-session:hover {
        filter: brightness(1.05);
        color: #ffffff;
    }

    .apni-online-therapy-section {
        background: #BAC2D220;
    }

    .apni-online-therapy-title {
        font-size: clamp(2rem, 2.3vw + 0.8rem, 3rem);
        line-height: 1.15;
        color: #041C54;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .apni-online-therapy-subtitle {
        color: #7484A4;
        max-width: 42rem;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.7;
    }

    .apni-online-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 1rem;
    }

    @media (min-width: 768px) {
        .apni-online-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1024px) {
        .apni-online-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.2rem;
        }
    }

    .apni-online-card {
        background: #ffffff;
        border: 1px solid #BAC2D220;
        border-radius: 16px;
        padding: 1.25rem;
        min-height: 170px;
        box-shadow: 0 14px 34px rgba(4, 28, 84, 0.06);
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }

    .apni-online-card:hover {
        transform: translateY(-4px);
        border-color: #64749440;
        box-shadow: 0 22px 52px rgba(4, 28, 84, 0.12);
    }

    .apni-online-icon {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        background: #BAC2D210;
        color: #647494;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.85rem;
    }

    .apni-online-icon svg {
        width: 19px;
        height: 19px;
    }

    .apni-online-card h3 {
        color: #041C54;
        font-size: 1.6rem;
        font-weight: 500;
        font-family: var(--font-display);
        line-height: 1.2;
        margin-bottom: 0.45rem;
    }

    .apni-online-card p {
        color: #7484A4;
        font-size: 0.98rem;
        line-height: 1.55;
    }

    .apni-online-help {
        text-align: center;
        margin-top: 2.1rem;
        color: #7484A4;
        font-size: 0.95rem;
    }

    .apni-online-help a {
        color: #647494;
        text-decoration: underline;
        text-underline-offset: 2px;
    }

    .apni-online-help a:hover {
        color: #041C54;
    }

    .apni-final-cta-section {
        background: #041C54;
    }

    .apni-final-cta-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1.2rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        color: #BAC2D2;
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 1.75rem;
    }

    .apni-final-cta-eyebrow-dot {
        width: 10px;
        height: 10px;
        border-radius: 999px;
        background: #EC4899;
        box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.35);
    }

    .apni-final-cta-title {
        font-size: clamp(2.4rem, 2.8vw + 1rem, 3.4rem);
        line-height: 1.1;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1rem;
        font-family: var(--font-display);
    }

    .apni-final-cta-subtitle {
        color: rgba(186, 194, 210, 0.92);
        max-width: 40rem;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.7;
        font-size: 1rem;
    }

    .apni-final-cta-actions {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
        justify-content: center;
        margin-top: 2.1rem;
    }

    @media (min-width: 640px) {
        .apni-final-cta-actions {
            flex-direction: row;
        }
    }

    .apni-final-cta-primary,
    .apni-final-cta-secondary {
        border-radius: 999px;
        padding: 0.8rem 1.9rem;
        font-size: 0.95rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
    }

    .apni-final-cta-primary {
        background: #ffffff;
        color: #041C54;
        box-shadow: 0 20px 45px rgba(4, 28, 84, 0.45);
    }

    .apni-final-cta-primary:hover {
        background: #f9fafb;
        color: #041C54;
    }

    .apni-final-cta-secondary {
        border: 1.5px solid rgba(255, 255, 255, 0.65);
        color: #ffffff;
        background: transparent;
    }

    .apni-final-cta-secondary:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
    }

    .apni-final-cta-primary svg,
    .apni-final-cta-secondary svg {
        width: 15px;
        height: 15px;
    }

    .apni-final-cta-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        justify-content: center;
        margin-top: 2.5rem;
        color: rgba(186, 194, 210, 0.9);
        font-size: 0.85rem;
    }

    .apni-final-cta-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .apni-final-cta-badge-icon {
        width: 18px;
        height: 18px;
        border-radius: 999px;
        background: rgba(186, 194, 210, 0.08);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .apni-final-cta-badge-icon svg {
        width: 12px;
        height: 12px;
    }
</style>
@endsection

@section('content')
<!-- Hero + Stats Section (Figma-style top hero) -->
<section class="relative apni-hero-bg overflow-x-clip">
    <div class="max-w-7xl mx-auto w-full min-w-0 px-5 sm:px-6 lg:px-8">
        <div class="apni-hero-grid">
            <!-- Hero Left -->
            <div>
                <div class="mb-4">
                    <span class="apni-hero-eyebrow">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Trusted by 50,000+ people
                    </span>
                </div>
                <h1 class="apni-hero-heading-main mb-4">
                    Your Mental Health
                    <span class="block">Matters</span>
                </h1>
                <p class="apni-hero-body">
                    Connect with verified therapists for online consultations.
                    Professional support from the comfort of your home.
                </p>

                <div class="apni-hero-cta-row">
                    <a href="{{ route('therapists.index') }}" class="apni-hero-cta-primary">
                        <span>Find Your Therapist</span>
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-white/10">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none">
                                <path d="M7 4l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </a>
                    <a href="{{ route('assessments.index') }}" class="apni-hero-cta-secondary">
                        <span>How it works</span>
                    </a>
                </div>

                <div class="apni-hero-stats">
                    <div>
                        <div class="apni-hero-stat-label">Therapists</div>
                        <div class="apni-hero-stat-value">750+</div>
                    </div>
                    <div>
                        <div class="apni-hero-stat-label">Happy Clients</div>
                        <div class="apni-hero-stat-value">50K+</div>
                    </div>
                    <div>
                        <div class="apni-hero-stat-label">Rating</div>
                        <div class="apni-hero-stat-value">4.9★</div>
                    </div>
                </div>
            </div>

            <!-- Hero Right: Large therapist image with floating badges (visual only) -->
            <div class="apni-card apni-hero-card">
                <img
                    src="{{ asset('assets/img/home/hero.png') }}"
                    alt="Online therapist"
                    class="apni-hero-photo"
                    width="800"
                    height="800"
                >

                <div class="apni-hero-floating-pill">
                    <span class="dot"></span>
                    <span>Trusted by 50,000+ people</span>
                </div>

                <div class="apni-hero-floating-card">
                    <span class="check">✓</span>
                    <div class="flex flex-col">
                        <span class="text-[0.7rem] uppercase tracking-[0.16em] text-[#7484A4]">Available now</span>
                        <span class="text-sm font-semibold text-[#041C54]">Dr. Sarah Johnson</span>
                    </div>
                </div>

                <div class="apni-hero-floating-stat">
                    1.2M+ Sessions
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section: Comprehensive Mental Health Support -->
<section class="py-12 md:py-14 lg:py-16 apni-expertise-section">
    <div class="max-w-7xl mx-auto w-full min-w-0 px-5 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="apni-expertise-heading-main">
                Comprehensive Mental Health <span class="apni-expertise-heading-highlight">Support</span>
            </h2>
            <p class="apni-expertise-subtitle text-base md:text-lg">
                Choose the type of support that best fits your needs. All sessions are led by licensed, experienced professionals.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            <!-- Individual Counselling -->
            <div class="apni-expertise-card service-hover-overlay" data-thoughts="Thoughts of therapy for personal growth and healing">
                <div class="apni-expertise-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="apni-expertise-name">Individual Counselling</h3>
                <p class="apni-expertise-description text-sm">One‑on‑one sessions designed around your unique experiences, goals, and pace of healing.</p>
            </div>

            <!-- Couple Counselling -->
            <div class="apni-expertise-card service-hover-overlay" data-thoughts="Thoughts of therapy for relationship healing and growth">
                <div class="apni-expertise-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="apni-expertise-name">Couple Counselling</h3>
                <p class="apni-expertise-description text-sm">Improve communication, rebuild trust and navigate conflicts together in a safe space.</p>
            </div>

            <!-- Psychiatric Consultation -->
            <div class="apni-expertise-card service-hover-overlay" data-thoughts="Thoughts of therapy for mental health evaluation and treatment">
                <div class="apni-expertise-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="apni-expertise-name">Psychiatric Consultation</h3>
                <p class="apni-expertise-description text-sm">Comprehensive assessments, diagnosis and medication management when clinically needed.</p>
            </div>

            <!-- Employee Assistance Program -->
            <div class="apni-expertise-card service-hover-overlay" data-thoughts="Thoughts of therapy for workplace wellness and support">
                <div class="apni-expertise-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="apni-expertise-name">Employee Assistance Program</h3>
                <p class="apni-expertise-description text-sm">End‑to‑end mental wellness programs tailored for organisations and their teams.</p>
            </div>

            <!-- Teen Therapy -->
            <div class="apni-expertise-card service-hover-overlay" data-thoughts="Thoughts of therapy for teenage challenges and growth">
                <div class="apni-expertise-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <h3 class="apni-expertise-name">Teen Therapy</h3>
                <p class="apni-expertise-description text-sm">Support for teenagers navigating academic pressure, identity, friendships and more.</p>
            </div>

            <!-- Kids Therapy -->
            <div class="apni-expertise-card service-hover-overlay" data-thoughts="Thoughts of therapy for children's emotional development">
                <div class="apni-expertise-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-5-8V6a2 2 0 114 0v2m-4 0h4m-4 0v8a2 2 0 002 2h4a2 2 0 002-2v-8m-4 0V6"/>
                    </svg>
                </div>
                <h3 class="apni-expertise-name">Kids Therapy</h3>
                <p class="apni-expertise-description text-sm">Play‑based, age‑appropriate sessions that help children express and process emotions.</p>
            </div>

            <!-- Elder Care -->
            <div class="apni-expertise-card service-hover-overlay" data-thoughts="Thoughts of therapy for aging with dignity and support">
                <div class="apni-expertise-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="apni-expertise-name">Elder Care</h3>
                <p class="apni-expertise-description text-sm">Support for seniors coping with loss, loneliness, health concerns and life changes.</p>
            </div>

            <!-- Campus Wellness Program -->
            <div class="apni-expertise-card service-hover-overlay" data-thoughts="Thoughts of therapy for student mental health and academic success">
                <div class="apni-expertise-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="apni-expertise-name">Campus Wellness Program</h3>
                <p class="apni-expertise-description text-sm">Partner with institutions to build psychologically safe, thriving student communities.</p>
            </div>
        </div>
    </div>
</section>

<!-- Areas of Expertise Section -->
<section class="py-12 md:py-16 lg:py-20 apni-expertise-section">
    <div class="max-w-7xl mx-auto w-full min-w-0 px-5 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="apni-expertise-heading-main">
                Areas of <span class="apni-expertise-heading-highlight">Expertise</span>
            </h2>
            <p class="apni-expertise-subtitle text-base md:text-lg">
                Our therapists specialize in various areas of mental health to provide targeted support for your specific needs.
            </p>
        </div>

        @if($areasOfExpertise->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($areasOfExpertise as $area)
                <a href="{{ route('therapists.index', ['area' => $area->slug]) }}" 
                   class="spec-hover-overlay apni-expertise-card block"
                   data-thoughts="Thoughts of therapy for focused support and healing">
                    <div class="apni-expertise-icon">
                        @if($area->icon)
                            <i class="{{ $area->icon }} w-10 h-10" style="font-size: 2.35rem; display: flex; align-items: center; justify-content: center;"></i>
                        @else
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="apni-expertise-name">{{ $area->name }}</div>
                    @if($area->description)
                        <p class="apni-expertise-description text-sm px-4 line-clamp-2">{{ Str::limit($area->description, 80) }}</p>
                    @endif
                </a>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('therapists.index') }}" class="btn-outline text-lg px-8 py-4">
                View All Therapists
            </a>
        </div>
        @else
        <!-- Fallback static content if no areas exist -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="spec-hover-overlay apni-expertise-card" data-thoughts="Thoughts of therapy for anxiety management and peace">
                <div class="apni-expertise-icon">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <div class="apni-expertise-name">Anxiety</div>
            </div>

            <div class="spec-hover-overlay apni-expertise-card" data-thoughts="Thoughts of therapy for depression recovery and hope">
                <div class="apni-expertise-icon">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="apni-expertise-name">Depression</div>
            </div>

            <div class="spec-hover-overlay apni-expertise-card" data-thoughts="Thoughts of therapy for healthy relationships and connection">
                <div class="apni-expertise-icon">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div class="apni-expertise-name">Relationships</div>
            </div>

            <div class="spec-hover-overlay apni-expertise-card" data-thoughts="Thoughts of therapy for stress relief and balance">
                <div class="apni-expertise-icon">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="apni-expertise-name">Stress</div>
            </div>

            <div class="spec-hover-overlay apni-expertise-card" data-thoughts="Thoughts of therapy for addiction recovery and freedom">
                <div class="apni-expertise-icon">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div class="apni-expertise-name">Addiction</div>
            </div>

            <div class="spec-hover-overlay apni-expertise-card" data-thoughts="Thoughts of therapy for trauma healing and resilience">
                <div class="apni-expertise-icon">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div class="apni-expertise-name">Trauma</div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Featured Therapists Section -->
<section class="py-12 md:py-16 lg:py-20 apni-section-dark">
    <div class="max-w-7xl mx-auto w-full min-w-0 px-5 sm:px-6 lg:px-8">
        <div class="apni-therapist-section-header mb-12">
            <div>
                <div class="apni-dark-pill mb-3">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 inline-block"></span>
                    <span>Top Rated</span>
                </div>
                <h2 class="apni-therapist-heading-main mb-2">Meet Our <span class="apni-therapist-heading-highlight">Expert Therapists</span></h2>
                <p>Verified professionals with years of experience in mental health care.</p>
            </div>
            <div class="flex items-end gap-3">
                <a href="{{ route('therapists.index') }}" class="apni-therapist-viewall">
                    <span>View All Therapists</span>
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#BAC2D220]">
                        <svg class="w-3 h-3" viewBox="0 0 20 20" fill="none">
                            <path d="M7 4l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($featuredTherapists as $therapist)
                @php
                    $profile = $therapist->therapistProfile;
                    $specializations = $profile ? $profile->specializations->pluck('name')->take(3) : collect();
                    $years = $profile->experience_years ?? 0;
                    $sessions = $profile->total_sessions ?? 0;
                    $rating = number_format($profile->rating_average ?? 0, 1);
                    $reviews = $profile->total_reviews ?? 0;
                    $fee = number_format($profile->consultation_fee ?? 0);
                @endphp
                <div class="therapist-card">
                    <div class="therapist-image-wrap">
                        @if($profile && $profile->profile_image)
                            <img src="{{ asset('storage/' . $profile->profile_image) }}"
                                 alt="{{ $therapist->name }}"
                                 class="therapist-cover">
                        @elseif($therapist->avatar)
                            <img src="{{ asset('storage/' . $therapist->avatar) }}"
                                 alt="{{ $therapist->name }}"
                                 class="therapist-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($therapist->name) }}&background=BAC2D2&color=041C54&size=640&bold=true&format=svg"
                                 alt="{{ $therapist->name }}"
                                 class="therapist-cover">
                        @endif

                        <span class="therapist-verified-badge">
                            <svg fill="none" viewBox="0 0 20 20">
                                <path d="M7.5 10.5l1.6 1.6 3.4-3.6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Verified
                        </span>

                        <span class="therapist-rating-chip">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ $rating }} ({{ $reviews }})
                        </span>
                    </div>

                    <div class="therapist-content">
                        <h3 class="therapist-name">Dr. {{ $therapist->name }}</h3>
                        <p class="therapist-role">{{ $profile->qualification ?? 'Clinical Psychologist' }}</p>
                        <p class="therapist-focus">
                            @if($specializations->count() > 0)
                                {{ $specializations->implode(' & ') }}
                            @else
                                Anxiety & Stress Management
                            @endif
                        </p>

                        <div class="therapist-tags">
                            @forelse($specializations as $specialization)
                                <span class="therapist-tag">{{ $specialization }}</span>
                            @empty
                                <span class="therapist-tag">Anxiety</span>
                                <span class="therapist-tag">Depression</span>
                                <span class="therapist-tag">Wellness</span>
                            @endforelse
                        </div>

                        <div class="therapist-meta">
                            <span>{{ $years }}+ Years</span>
                            <span>•</span>
                            <span>{{ number_format($sessions) }}+ sessions</span>
                        </div>

                        <div class="therapist-next">
                            <svg fill="none" viewBox="0 0 20 20">
                                <path d="M6 2.5v2M14 2.5v2M3.5 7.5h13M5.5 4h9A1.5 1.5 0 0116 5.5v9A1.5 1.5 0 0114.5 16h-9A1.5 1.5 0 014 14.5v-9A1.5 1.5 0 015.5 4z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Next available: Today, 3:00 PM
                        </div>

                        <div class="therapist-footer">
                            <div>
                                <div class="therapist-price-value">₹{{ $fee }}</div>
                                <div class="therapist-price-label">per session</div>
                            </div>
                            @auth
                                <a href="{{ route('booking.form', $therapist->id) }}" class="btn-book-session">Book Now</a>
                            @else
                                <a href="{{ route('login', ['redirect' => route('booking.form', $therapist->id)]) }}" class="btn-book-session">Book Now</a>
                            @endauth
                        </div>
                    </div>
</div>
            @empty
                <div class="col-span-full text-center py-12 bg-white/5 rounded-2xl border border-white/10">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">No Featured Therapists Available</h3>
                    <p class="text-primary-100 mb-6">We're working on adding more therapists to our platform.</p>
                    <a href="{{ route('therapists.index') }}" class="bg-white text-[#041C54] hover:bg-gray-100 font-medium py-3 px-8 rounded-full transition-colors duration-200 inline-block">
                        View All Therapists
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</section>

<!-- Why Choose Online Therapy Section -->
<section class="py-12 md:py-16 lg:py-20 apni-online-therapy-section">
    <div class="max-w-7xl mx-auto w-full min-w-0 px-5 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="apni-online-therapy-title">
                Why Choose Online Therapy?
            </h2>
            <p class="apni-online-therapy-subtitle text-base md:text-lg">
                Professional mental health care that fits your lifestyle with all the benefits of traditional therapy.
            </p>
        </div>

        <div class="apni-online-grid">
            <div class="apni-online-card">
                <div class="apni-online-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3>Flexible Scheduling</h3>
                <p>Book sessions that fit your schedule. Available 24/7.</p>
            </div>

            <div class="apni-online-card">
                <div class="apni-online-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3>Complete Privacy</h3>
                <p>End-to-end encrypted sessions. Your data is secure.</p>
            </div>

            <div class="apni-online-card">
                <div class="apni-online-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <h3>Always Available</h3>
                <p>Access to support resources anytime you need them.</p>
            </div>

            <div class="apni-online-card">
                <div class="apni-online-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3>From Anywhere</h3>
                <p>Connect from home, office, or any private space.</p>
            </div>

            <div class="apni-online-card">
                <div class="apni-online-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <h3>Affordable Care</h3>
                <p>Transparent pricing with flexible payment options.</p>
            </div>

            <div class="apni-online-card">
                <div class="apni-online-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3>Verified Experts</h3>
                <p>All therapists are licensed and background verified.</p>
            </div>
        </div>

        <div class="apni-online-help">
            Still have questions? <a href="{{ route('about') }}">Learn more about our process</a>
        </div>
    </div>
</section>

<!-- Final CTA Section (bottom gradient) -->
<section class="py-12 md:py-16 lg:py-20 apni-final-cta-section">
    <div class="max-w-5xl mx-auto w-full min-w-0 px-5 sm:px-6 lg:px-8 text-center">
        <div class="apni-final-cta-eyebrow">
            <span class="apni-final-cta-eyebrow-dot"></span>
            <span>Start Your Journey Today</span>
        </div>

        <h2 class="apni-final-cta-title">
            Take the First Step Towards Better Mental Health
        </h2>
        <p class="apni-final-cta-subtitle">
            Join thousands who have found support and healing through professional therapy. Your mental wellness journey starts here.
        </p>

        <div class="apni-final-cta-actions">
            <a href="{{ route('register') }}" class="apni-final-cta-primary">
                <span>Get Started Now</span>
                <svg viewBox="0 0 20 20" fill="none">
                    <path d="M7 4l6 6-6 6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <a href="{{ route('therapists.index') }}" class="apni-final-cta-secondary">
                <span>Browse Therapists</span>
            </a>
        </div>

        <div class="apni-final-cta-badges">
            <div class="apni-final-cta-badge">
                <span class="apni-final-cta-badge-icon">
                    <svg viewBox="0 0 20 20" fill="none">
                        <path d="M10 2.5l5 2v4.25c0 3.1-2.14 5.94-5 6.75-2.86-.81-5-3.65-5-6.75V4.5l5-2z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span>Licensed Professionals</span>
            </div>
            <div class="apni-final-cta-badge">
                <span class="apni-final-cta-badge-icon">
                    <svg viewBox="0 0 20 20" fill="none">
                        <path d="M10 3.5a3 3 0 00-3 3v1H6a1.5 1.5 0 00-1.5 1.5v5A1.5 1.5 0 006 15.5h8a1.5 1.5 0 001.5-1.5v-5A1.5 1.5 0 0014 7.5h-1v-1a3 3 0 00-3-3z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span>100% Confidential</span>
            </div>
            <div class="apni-final-cta-badge">
                <span class="apni-final-cta-badge-icon">
                    <svg viewBox="0 0 20 20" fill="none">
                        <path d="M10 2.5l2.1 2.36 3.1.74-1.98 2.7.22 3.19L10 10.8 6.56 11.5l.22-3.19L4.8 5.6l3.1-.74L10 2.5z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8.1 9.75L9.6 11l2.4-3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span>Verified &amp; Trusted</span>
            </div>
        </div>
    </div>
</section>
@endsection
