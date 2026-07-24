@extends('layouts.app')

@push('styles')
<style>
    /* ── Hero ── */
    .about-hero {
        background: linear-gradient(135deg, #0d1117 0%, #161b22 50%, #1a1f2e 100%);
        padding: 65px 0 45px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(255,122,24,0.12);
    }
    .about-hero::before {
        content: '';
        position: absolute;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(255,122,24,0.10) 0%, transparent 70%);
        top: -180px; right: -120px;
        border-radius: 50%;
        pointer-events: none;
    }
    .about-hero::after {
        content: '';
        position: absolute;
        width: 320px; height: 320px;
        background: radial-gradient(circle, rgba(242,112,26,0.07) 0%, transparent 70%);
        bottom: -120px; left: -80px;
        border-radius: 50%;
        pointer-events: none;
    }
    .hero-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,122,24,0.10);
        border: 1px solid rgba(255,122,24,0.22);
        color: #ff7a18;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        padding: 7px 18px;
        border-radius: 50px;
        margin-bottom: 22px;
    }
    .about-hero h1 {
        font-size: clamp(2.2rem, 5vw, 3.8rem);
        font-weight: 700;
        line-height: 1.12;
        color: #ffffff;
    }
    .about-hero h1 span {
        background: linear-gradient(90deg, #ff7a18, #f2701a);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .about-hero .lead {
        color: rgba(255,255,255,0.60);
        font-size: 1.05rem;
        max-width: 620px;
    }

    /* ── Section wrapper ── */
    .about-section {
        padding: 90px 0;
    }
    .about-section-alt {
        background: #f8f9fb;
    }
    .section-eyebrow {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: #ff7a18;
        margin-bottom: 10px;
    }
    .section-title {
        font-size: clamp(1.7rem, 3.5vw, 2.4rem);
        font-weight: 900;
        color: #0d1117;
        line-height: 1.2;
    }
    .section-title span { color: #ff7a18; }

    /* ── Stats bar ── */
    .stat-strip {
        background: linear-gradient(135deg, #ff7a18 0%, #f2701a 100%);
        padding: 50px 0;
    }
    .stat-item {
        text-align: center;
        color: #fff;
        border-right: 1px solid rgba(255,255,255,0.20);
        padding: 0 30px;
    }
    .stat-item:last-child { border-right: none; }
    .stat-number {
        font-size: 2.6rem;
        font-weight: 900;
        line-height: 1;
        display: block;
    }
    .stat-label {
        font-size: 0.82rem;
        font-weight: 600;
        opacity: 0.85;
        letter-spacing: 0.5px;
        margin-top: 6px;
    }

    /* ── Who We Are ── */
    .brand-card {
        background: #fff;
        border-radius: 24px;
        padding: 36px 38px;
        box-shadow: 0 4px 30px rgba(0,0,0,0.06);
        border: 1px solid #f0f0f0;
        height: 100%;
        transition: transform 0.35s ease, box-shadow 0.35s ease;
    }
    .brand-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(255,122,24,0.12);
    }
    .brand-icon {
        width: 56px; height: 56px;
        background: linear-gradient(135deg, #ff7a18, #f2701a);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        color: #fff;
        font-size: 1.5rem;
        margin-bottom: 18px;
        box-shadow: 0 8px 20px rgba(255,122,24,0.25);
    }
    .brand-card h5 {
        font-weight: 800;
        font-size: 1.05rem;
        color: #0d1117;
        margin-bottom: 10px;
    }
    .brand-card p {
        color: #6c757d;
        font-size: 0.92rem;
        line-height: 1.7;
        margin: 0;
    }

    /* ── Services list ── */
    .service-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 16px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .service-item:last-child { border-bottom: none; }
    .service-dot {
        width: 34px; height: 34px;
        min-width: 34px;
        background: rgba(255,122,24,0.10);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #ff7a18;
        font-size: 1rem;
        margin-top: 2px;
    }
    .service-item span {
        font-weight: 700;
        color: #1a1f2e;
        font-size: 0.97rem;
        line-height: 1.5;
    }

    /* ── Founder Card ── */
    .founder-section {
        background: linear-gradient(135deg, #0d1117 0%, #1a1f2e 100%);
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }
    .founder-section::before {
        content: '';
        position: absolute;
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(255,122,24,0.08) 0%, transparent 70%);
        top: -200px; right: -150px;
        border-radius: 50%;
    }
    .founder-photo-wrap {
        position: relative;
        display: inline-block;
    }
    .founder-photo-wrap img {
        width: 100%;
        max-width: 420px;
        border-radius: 28px;
        object-fit: cover;
        object-position: top center;
        box-shadow: 0 30px 80px rgba(0,0,0,0.45);
        display: block;
    }
    .founder-badge {
        position: absolute;
        bottom: -18px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #ff7a18, #f2701a);
        color: #fff;
        font-weight: 800;
        font-size: 0.82rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 10px 28px;
        border-radius: 50px;
        white-space: nowrap;
        box-shadow: 0 8px 24px rgba(255,122,24,0.40);
    }
    .founder-name {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 900;
        color: #fff;
        line-height: 1.1;
    }
    .founder-title {
        font-size: 0.80rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: #ff7a18;
        margin-bottom: 20px;
    }
    .founder-quote {
        border-left: 3px solid #ff7a18;
        padding-left: 20px;
        color: rgba(255,255,255,0.60);
        font-size: 1.05rem;
        line-height: 1.75;
        font-style: italic;
        margin: 22px 0 30px;
    }
    .founder-info-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
        color: rgba(255,255,255,0.75);
        font-size: 0.92rem;
    }
    .founder-info-row i {
        color: #ff7a18;
        font-size: 1rem;
        width: 20px;
        text-align: center;
    }
    .founder-info-row a {
        color: rgba(255,255,255,0.75);
        text-decoration: none;
        transition: color 0.2s;
    }
    .founder-info-row a:hover { color: #ff7a18; }

    /* ── Why Choose Us ── */
    .why-card {
        background: #fff;
        border-radius: 20px;
        padding: 30px 28px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 2px 20px rgba(0,0,0,0.05);
        display: flex;
        align-items: flex-start;
        gap: 18px;
        transition: all 0.35s ease;
        height: 100%;
    }
    .why-card:hover {
        border-color: rgba(255,122,24,0.30);
        box-shadow: 0 10px 30px rgba(255,122,24,0.10);
        transform: translateY(-4px);
    }
    .why-icon {
        width: 50px; height: 50px;
        min-width: 50px;
        background: linear-gradient(135deg, rgba(255,122,24,0.12), rgba(242,112,26,0.06));
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        color: #ff7a18;
        font-size: 1.3rem;
    }
    .why-card h6 {
        font-weight: 800;
        color: #0d1117;
        font-size: 0.97rem;
        margin-bottom: 5px;
    }
    .why-card p {
        color: #6c757d;
        font-size: 0.87rem;
        margin: 0;
        line-height: 1.6;
    }

    /* ── CTA ── */
    .about-cta {
        background: linear-gradient(135deg, #ff7a18 0%, #f2701a 100%);
        border-radius: 28px;
        padding: 60px 50px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .about-cta::before {
        content: '';
        position: absolute;
        width: 300px; height: 300px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
        top: -120px; right: -80px;
    }
    .about-cta h2 {
        font-size: clamp(1.6rem, 3vw, 2.3rem);
        font-weight: 900;
        color: #fff;
        margin-bottom: 12px;
    }
    .about-cta p {
        color: rgba(255,255,255,0.80);
        font-size: 1rem;
        max-width: 520px;
        margin: 0 auto 30px;
    }
    .btn-cta-light {
        background: #fff;
        color: #f2701a;
        font-weight: 800;
        padding: 14px 36px;
        border-radius: 50px;
        border: none;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }
    .btn-cta-light:hover {
        background: #0d1117;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 32px rgba(0,0,0,0.25);
    }
    .btn-cta-outline {
        background: transparent;
        color: #fff;
        font-weight: 700;
        padding: 14px 36px;
        border-radius: 50px;
        border: 2px solid rgba(255,255,255,0.45);
        font-size: 0.95rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    .btn-cta-outline:hover {
        border-color: #fff;
        background: rgba(255,255,255,0.10);
        color: #fff;
    }

    /* ── Hero Buttons ── */
    .about-btn-orange {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #ff7a18, #e8650e);
        color: #fff;
        font-weight: 800;
        font-size: 0.93rem;
        padding: 13px 30px;
        border-radius: 50px;
        border: none;
        text-decoration: none;
        box-shadow: 0 8px 24px rgba(255,122,24,0.38);
        transition: all 0.3s ease;
    }
    .about-btn-orange:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 32px rgba(255,122,24,0.50);
        background: linear-gradient(135deg, #e8650e, #cc5400);
    }
    .about-btn-ghost {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,122,24,0.08);
        color: #ff7a18;
        font-weight: 700;
        font-size: 0.93rem;
        padding: 13px 30px;
        border-radius: 50px;
        border: 1.5px solid rgba(255,122,24,0.35);
        text-decoration: none;
        backdrop-filter: blur(6px);
        transition: all 0.3s ease;
    }
    .about-btn-ghost:hover {
        background: rgba(255,122,24,0.16);
        border-color: #ff7a18;
        color: #ff7a18;
        transform: translateY(-2px);
    }

    /* ── Animations ── */
    .fade-up {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.65s ease, transform 0.65s ease;
    }
    .fade-up.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')

{{-- ══ HERO ══ --}}
<section class="about-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <div class="hero-pill">
                    <i class="bi bi-shop"></i> Our Story
                </div>
                <h1 class="mb-4">
                    Building India's Most<br>
                    <span>Trusted B2B Platform</span>
                </h1>
                <p class="lead mx-auto mb-4">
                    Shopping Club India — proudly serving customers and business partners
                    across India since <strong style="color:#ff7a18;">07 May 2016</strong>.
                    Quality products, trusted service, and real growth opportunities.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ url('/products') }}" class="about-btn-orange">
                        <i class="bi bi-bag-fill"></i> Shop Now
                    </a>
                    <a href="{{ route('contact') }}" class="about-btn-ghost">
                        <i class="bi bi-telephone-fill"></i> Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ WHO WE ARE ══ --}}
<section class="about-section about-section-alt">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5 fade-up">
                <p class="section-eyebrow"><i class="bi bi-building me-1"></i> Who We Are</p>
                <h2 class="section-title mb-4">More Than Just a <span>Shopping Platform</span></h2>
                <p class="text-secondary mb-4" style="font-size:1.02rem;line-height:1.80;">
                    At <strong>SCIB2B by Shopping Club India</strong>, we believe business becomes successful with
                    trust, support, and strong relationships. We are not just a shopping platform —
                    we are a team dedicated to helping people grow.
                </p>
                <p class="text-secondary mb-5" style="font-size:0.97rem;line-height:1.80;">
                    We provide services all over India and continuously work to deliver better
                    products, better pricing, and better support to our customers and partners.
                </p>
                <a href="https://scib2b.com" target="_blank" class="about-btn-orange">
                    <i class="bi bi-globe2"></i> Visit Official Website
                </a>
            </div>
            <div class="col-lg-7 fade-up" style="transition-delay:0.15s">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="brand-card">
                            <div class="brand-icon"><i class="bi bi-award"></i></div>
                            <h5>Trusted Since 2016</h5>
                            <p>Over 9+ years of experience in B2B and retail supply across India with a track record of reliability.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="brand-card">
                            <div class="brand-icon"><i class="bi bi-geo-alt"></i></div>
                            <h5>All India Network</h5>
                            <p>Our service reaches every corner of India, from metro cities to smaller towns and regions.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="brand-card">
                            <div class="brand-icon"><i class="bi bi-truck"></i></div>
                            <h5>Self Courier Service</h5>
                            <p>We offer our own courier service for selected locations ensuring faster, safer delivery.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="brand-card">
                            <div class="brand-icon"><i class="bi bi-people"></i></div>
                            <h5>Business Growth</h5>
                            <p>We actively help resellers, entrepreneurs and shop owners build and grow their business with us.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ SERVICES ══ --}}
<section class="about-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 fade-up">
                <div style="background: linear-gradient(135deg, #0d1117, #1a1f2e); border-radius: 28px; padding: 50px 44px;">
                    <p class="section-eyebrow"><i class="bi bi-grid me-1"></i> Our Services</p>
                    <h2 class="mb-4" style="font-size:2rem;font-weight:900;color:#fff;line-height:1.2;">
                        Everything You Need <span style="color:#ff7a18;">to Grow</span>
                    </h2>
                    <div>
                        @php
                        $services = [
                            ['icon' => 'bi-box-seam', 'label' => 'B2B Product Supply Across India'],
                            ['icon' => 'bi-shop-window', 'label' => 'Wholesale & Retail Support'],
                            ['icon' => 'bi-truck', 'label' => 'Self Courier Service Available'],
                            ['icon' => 'bi-rocket-takeoff', 'label' => 'Business Startup Guidance'],
                            ['icon' => 'bi-person-badge', 'label' => 'Reseller & Partner Opportunities'],
                            ['icon' => 'bi-headset', 'label' => 'Customer Support Services'],
                            ['icon' => 'bi-lightning-charge', 'label' => 'Fast & Friendly Assistance'],
                        ];
                        @endphp
                        @foreach($services as $s)
                        <div class="service-item" style="border-color: rgba(255,255,255,0.08);">
                            <div class="service-dot" style="background:rgba(255,122,24,0.15);">
                                <i class="bi {{ $s['icon'] }}"></i>
                            </div>
                            <span style="color:rgba(255,255,255,0.85); font-weight:600;">{{ $s['label'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-6 fade-up" style="transition-delay:0.15s">
                <div class="mb-5">
                    <p class="section-eyebrow"><i class="bi bi-truck me-1"></i> Courier & Delivery</p>
                    <h3 class="section-title mb-3">Self Courier <span>Service</span></h3>
                    <p class="text-secondary" style="font-size:0.97rem;line-height:1.80;">
                        We provide <strong>Self Courier Service</strong> support for selected locations and orders.
                        Our goal is to ensure faster, safer, and more reliable delivery experience
                        for our customers whenever possible.
                    </p>
                    <p class="text-secondary" style="font-size:0.97rem;line-height:1.80;">
                        For areas where self-delivery is not available, trusted third-party courier
                        partners are used to ensure your order reaches you safely.
                    </p>
                </div>
                <div>
                    <p class="section-eyebrow"><i class="bi bi-briefcase me-1"></i> Business Opportunity</p>
                    <h3 class="section-title mb-3">Start Your <span>Business</span> With Us</h3>
                    <p class="text-secondary" style="font-size:0.97rem;line-height:1.80;">
                        Whether you are a <strong>reseller, online seller, entrepreneur, shop owner, or beginner</strong>,
                        our team supports you in building your business journey with confidence.
                        We grow together.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ FOUNDER ══ --}}
<section class="founder-section">
    <div class="container position-relative" style="z-index:2;">
        <div class="row align-items-center g-5">
            {{-- Photo --}}
            <div class="col-lg-5 text-center fade-up">
                <div class="founder-photo-wrap mx-auto" style="max-width: 400px;">
                    <img src="{{ asset('images/founder-rj-shiva.jpg') }}" alt="RJ Shiva - Founder of Shopping Club India">
                    <div class="founder-badge">
                        <i class="bi bi-patch-check-fill me-1"></i> Founder & Visionary
                    </div>
                </div>
            </div>
            {{-- Info --}}
            <div class="col-lg-7 pt-5 pt-lg-0 fade-up" style="transition-delay:0.15s">
                <p class="section-eyebrow"><i class="bi bi-person-circle me-1"></i> Founder Information</p>
                <h2 class="founder-name mb-1">RJ Shiva</h2>
                <p class="founder-title mb-0">Fateh Singh — Founder, Shopping Club India</p>

                <blockquote class="founder-quote">
                    "RJ Shiva founded Shopping Club India with a vision to create a trusted platform
                    where people can shop smartly and also build their own business opportunities
                    across India. Empowering India, One Shop at a Time."
                </blockquote>

                <div class="founder-info-row">
                    <i class="bi bi-globe2"></i>
                    <a href="https://scib2b.com" target="_blank">scib2b.com — Official Platform</a>
                </div>
                <div class="founder-info-row">
                    <i class="bi bi-telephone-fill"></i>
                    <a href="tel:{{ $global_settings['clean_phone'] }}">{{ $global_settings['support_phone'] }}</a>
                </div>
                <div class="founder-info-row">
                    <i class="bi bi-envelope-fill"></i>
                    <a href="mailto:{{ $global_settings['support_email'] }}">{{ $global_settings['support_email'] }}</a>
                </div>
                <div class="founder-info-row">
                    <i class="bi bi-calendar-check"></i>
                    <span>Operating Since 07 May 2016</span>
                </div>

                <div class="mt-4 p-4 rounded-4" style="background:rgba(255,122,24,0.08);border:1px solid rgba(255,122,24,0.18);">
                    <p class="mb-0" style="color:rgba(255,255,255,0.70);font-size:0.97rem;line-height:1.7;">
                        We are proud to have a professional, supportive, and friendly staff team that always
                        focuses on customer satisfaction and long-term relationships. Our goal is simple:
                        <em style="color:#ff7a18;font-weight:700;">"Grow Together with Trust and Service."</em>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ WHY CHOOSE US ══ --}}
<section class="about-section about-section-alt">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-7 fade-up">
                <p class="section-eyebrow"><i class="bi bi-star me-1"></i> Why Choose Us</p>
                <h2 class="section-title">The SCIB2B <span>Advantage</span></h2>
            </div>
        </div>
        <div class="row g-4">
            @php
            $whys = [
                ['icon'=>'bi-award-fill',        'title'=>'Trusted Since 2016',         'desc'=>'9+ years of reliable business service across India with a proven track record.'],
                ['icon'=>'bi-geo-alt-fill',       'title'=>'All India Service Network',   'desc'=>'We serve customers and business partners in every state across the country.'],
                ['icon'=>'bi-truck',              'title'=>'Self Courier Facility',        'desc'=>'Own courier service for selected areas ensuring speed and reliability of delivery.'],
                ['icon'=>'bi-headset',            'title'=>'Friendly Support Team',        'desc'=>'Our team is always available to help you with any query, order or business question.'],
                ['icon'=>'bi-rocket-takeoff-fill','title'=>'Business Growth Support',      'desc'=>'Dedicated guidance for resellers, entrepreneurs and newcomers to launch their business.'],
                ['icon'=>'bi-patch-check-fill',   'title'=>'Quality Products',             'desc'=>'Every product on our platform is vetted for quality to give you the best value.'],
               
            ];
            @endphp
            @foreach($whys as $w)
            <div class="col-md-6 col-lg-4 fade-up">
                <div class="why-card">
                    <div class="why-icon">
                        <i class="bi {{ $w['icon'] }}"></i>
                    </div>
                    <div>
                        <h6>{{ $w['title'] }}</h6>
                        <p>{{ $w['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
            {{-- 7th item centers on lg --}}
        </div>
    </div>
</section>

{{-- ══ CTA ══ --}}
<section class="py-5">
    <div class="container">
        <div class="about-cta fade-up">
            <h2>Ready to Start Your Journey?</h2>
            <p>Join thousands of customers and business partners who trust Shopping Club India for quality products and real growth opportunities.</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ url('/products') }}" class="btn-cta-light">
                    <i class="bi bi-bag me-2"></i>Shop Now
                </a>
                <a href="{{ route('contact') }}" class="btn-cta-outline">
                    <i class="bi bi-telephone me-2"></i>Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Intersection Observer for fade-up animations
    const fadeEls = document.querySelectorAll('.fade-up');
    const obs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });
    fadeEls.forEach(el => obs.observe(el));
</script>
@endpush
