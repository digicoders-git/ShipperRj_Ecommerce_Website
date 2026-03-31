@extends('layouts.app')

@section('content')
    <style>
        .hero-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 0 0 50px 50px;
            padding: 100px 0;
            margin-bottom: -50px;
            position: relative;
            z-index: 1;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: 30px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            text-align: center;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            background: #fff;
        }

        .feature-icon-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #fff;
            font-size: 1.8rem;
            box-shadow: 0 10px 20px rgba(255, 122, 24, 0.2);
        }

        .about-image {
            border-radius: 30px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
            transition: transform 0.5s ease;
        }

        .about-image:hover {
            transform: scale(1.02);
        }

        .bg-soft-primary { background: rgba(255, 122, 24, 0.08); }
        .text-gradient { background: linear-gradient(90deg, #1a1a1a, #4a4a4a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container py-4 text-center">
            <h6 class="text-primary fw-bold text-uppercase tracking-widest mb-3">Our Story</h6>
            <h1 class="display-3 fw-black text-gradient mb-4">Redefining the <br>Future of Shopping</h1>
            <p class="lead text-secondary mx-auto" style="max-width: 700px;">We are more than just a marketplace. We are a community of dreamers and doers dedicated to building a premium shopping experience for everyone.</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-5 position-relative" style="z-index: 2;">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=800&auto=format&fit=crop" class="img-fluid about-image" alt="About Us">
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <h2 class="fw-black mb-4">Our Mission & <span class="text-primary">Vision</span></h2>
                    <p class="text-secondary mb-4 fs-5">Founded in 2024, Shopping Club India started with a simple idea: to make high-quality premium products accessible to everyone through a seamless digital experience.</p>
                    <p class="text-secondary mb-5">We believe in quality over quantity, service over profit, and people over everything. Every product on our platform is handpicked and verified to ensure you get nothing but the best.</p>
                    
                    <div class="row g-4 mb-5">
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-soft-primary p-3 rounded-4"><i class="bi bi-patch-check text-primary fs-4"></i></div>
                                <div><h6 class="fw-bold mb-0">100% Authentic</h6><span class="text-muted small">Guaranteed Products</span></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-soft-primary p-3 rounded-4"><i class="bi bi-clock-history text-primary fs-4"></i></div>
                                <div><h6 class="fw-bold mb-0">Fast Express</h6><span class="text-muted small">Doorstep Delivery</span></div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ url('/products') }}" class="btn btn-primary bg-gradient-primary px-5 py-3 rounded-pill fw-black shadow-lg">Start Shopping</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="feature-icon-wrapper"><i class="bi bi-people"></i></div>
                        <h3 class="fw-black mb-1">50K+</h3>
                        <p class="text-secondary mb-0">Happy Customers</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="feature-icon-wrapper"><i class="bi bi-box-seam"></i></div>
                        <h3 class="fw-black mb-1">1200+</h3>
                        <p class="text-secondary mb-0">Premium Products</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="feature-icon-wrapper"><i class="bi bi-geo-alt"></i></div>
                        <h3 class="fw-black mb-1">20+</h3>
                        <p class="text-secondary mb-0">Cities Served</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
