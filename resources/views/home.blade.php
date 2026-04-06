@extends('layouts.app')

@section('content')
    <style>
        @media (max-width: 768px) {
            .carousel-item {
                min-height: 420px !important;
            }

            .hero-slider .container {
                padding-top: 3rem !important;
                padding-bottom: 3rem !important;
            }

            .hero-slider h1 {
                font-size: 2.5rem !important;
                line-height: 1.2 !important;
                margin-bottom: 1rem !important;
            }

            .hero-slider h2 {
                font-size: 1.4rem !important;
            }

            .hero-slider p {
                font-size: 0.95rem !important;
                margin-bottom: 2rem !important;
            }
        }
    </style>
    <!-- Hero Slider -->
    <section class="hero-slider overflow-hidden">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" style="background: #F4F7F9; min-height: 500px;">
                    <div class="container py-5">
                        <div class="row align-items-center">
                            <div class="col-lg-6 fade-in-up text-start">
                                <span
                                    class="badge bg-primary bg-opacity-10 text-white rounded-pill px-3 py-2 mb-4 fw-black uppercase tracking-widest border border-primary border-opacity-10">Super
                                    Deal</span>
                                <h1 class="display-3 fw-bold mb-4 text-dark" style="letter-spacing: -2px;">India's <br><span
                                        class="text-gradient-primary">E-Shopping</span></h1>
                                <h2 class="h1 fw-light mb-4 text-secondary">BIG SALE <span class="text-primary fw-bold">UP
                                        TO 50% OFF</span></h2>
                                <p class="lead text-secondary mb-5 pe-lg-5 opacity-75">Discover premium electronics,
                                    fashion, and lifestyle brands at the best prices. Experience the joy of shopping with
                                    Club India.</p>
                                <div class="d-flex gap-4">
                                    <a href="{{ url('/products') }}"
                                        class="btn btn-premium btn-lg shadow-lg px-5 py-3 rounded-pill fw-bold">Shop Now</a>
                                </div>
                            </div>
                            <div class="col-lg-6 d-none d-lg-block">
                                <img src="{{asset('images/slider-1.png')}}" class="img-fluid  animate-float animate-delay-1"
                                    alt="Electronics Deal" style="object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="carousel-item" style="background: #E8F9F9; min-height: 500px;">
                    <div class="container py-5">
                        <div class="row align-items-center">
                            <div class="col-lg-6 fade-in-up text-start">
                                <span
                                    class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 mb-4 fw-black uppercase tracking-widest border border-danger border-opacity-10">Hot
                                    New Collection</span>
                                <h1 class="display-3 fw-bold mb-4 text-dark" style="letter-spacing: -2px;">Quality <br><span
                                        class="text-gradient-primary">Lifestyle</span></h1>
                                <p class="lead text-secondary mb-5 pe-lg-5 opacity-75">Everything you need for your home and
                                    lifestyle. From gadgets to furniture, we've got you covered.</p>
                                <a href="{{ url('/products') }}"
                                    class="btn btn-premium btn-lg shadow-lg px-5 py-3 rounded-pill fw-bold">Explore More</a>
                            </div>
                            <div class="col-lg-6 d-none d-lg-block">
                                <img src="{{asset('images/slider-2.png')}}"
                                    class="img-fluid  animate-float animate-delay-1 " alt="Fashion Sale"
                                    style="object-fit: cover; ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Removed carousel controls as requested -->
        </div>
    </section>

    <!-- Features Row -->
    <section class="py-5 border-bottom bg-white">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-3">
                    <div
                        class="d-flex align-items-center gap-3 p-4 rounded-4 shadow-sm border bg-light transition-all hover-float">
                        <i class="bi bi-truck fs-1 text-primary"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Fast Delivery</h6>
                            <p class="small text-secondary mb-0">Within 1-3 Business days</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div
                        class="d-flex align-items-center gap-3 p-4 rounded-4 shadow-sm border bg-light transition-all hover-float">
                        <i class="bi bi-arrow-repeat fs-1 text-primary"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Returns & Refund</h6>
                            <p class="small text-secondary mb-0">30 days return policy</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div
                        class="d-flex align-items-center gap-3 p-4 rounded-4 shadow-sm border bg-light transition-all hover-float">
                        <i class="bi bi-shield-lock-fill fs-1 text-primary"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Safe Shipping</h6>
                            <p class="small text-secondary mb-0">100% Secure payment</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div
                        class="d-flex align-items-center gap-3 p-4 rounded-4 shadow-sm border bg-light transition-all hover-float">
                        <i class="bi bi-headset fs-1 text-primary"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Help & Support</h6>
                            <p class="small text-secondary mb-0">24/7 Hours online help</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Categories -->
    <section class="py-5 mt-4 position-relative overflow-hidden">
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-5"
            style="background: radial-gradient(circle at 10% 20%, var(--primary) 0%, transparent 50%);"></div>
        <div class="container position-relative">
            <div class="section-header text-start mb-5 d-flex align-items-end justify-content-between">
                <div>
                    <h2 class="mb-0">Shop by <span class="text-gradient-primary">Department</span></h2>
                    <p class="ms-0">Discover our wide collections of premium goods.</p>
                </div>
                <a href="{{ url('/products') }}"
                    class="btn btn-outline-primary rounded-pill px-4 py-2 d-none d-md-block">View All Categories</a>
            </div>
            <div class="row g-4">

                @foreach($home_categories as $cat)
                    <div class="col-md-4 col-lg-2 col-6">
                        <a href="{{ url('/products?category=' . $cat->id) }}"
                            class="cat-card border-0 shadow-sm p-4 text-center d-block rounded-5 bg-white transition-all hover-float">
                            <div class="cat-icon mb-3 mx-auto rounded-4 d-flex align-items-center justify-content-center overflow-hidden"
                                style="width: 70px; height: 70px; background: #FFF7ED;">
                                @if($cat->image)
                                    <img src="{{ asset($cat->image) }}" class="img-fluid w-100 h-100 object-fit-contain p-2"
                                        alt="{{ $cat->name }}" loading="lazy"
                                        onerror="this.parentElement.innerHTML='<i class=\'bi bi-tag fs-1\' style=\'color: #FF7D00\'></i>'">
                                @else
                                    <i class="bi bi-tag fs-1" style="color: #FF7D00;"></i>
                                @endif
                            </div>
                            <h6 class="fw-bold mb-1 text-dark text-truncate">{{ $cat->name }}</h6>
                            <span class="x-small text-secondary fw-semibold">{{ ($cat->sub_categories_count ?? 0)  }}+
                                Items</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-5" style="background: #FAFAFB;">
        <div class="container">
            <div
                class="section-header d-flex flex-column flex-md-row justify-content-between align-items-end mb-5 text-start">
                <div class="text-start">
                    <h2 class="mb-0">Featured <span class="text-gradient-primary">Products</span></h2>
                    <p class="ms-0">Our most wanted products this week</p>
                </div>
                <div class="mt-4 mt-md-0">
                    <a href="{{ url('/products') }}" class="btn btn-primary bg-gradient-primary rounded-pill px-4 py-2 fw-bold shadow-sm d-flex align-items-center gap-2">
                        View All Products <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="row g-4">

                @forelse($featured_products as $prod)
                    <div class="col-md-6 col-lg-3">
                        <div class="product-card h-100 shadow-hover transition-all">
                            @if($prod->mrp > $prod->selling_price)
                                <span class="product-card-badge bg-danger text-white">SAVE
                                    {{ round((($prod->mrp - $prod->selling_price) / $prod->mrp) * 100) }}%</span>
                            @elseif($prod->featured)
                                <span class="product-card-badge bg-primary text-white">Featured</span>
                            @endif

                            <div class="product-actions-floating">
                                <form action="{{ route('wishlist.add', $prod->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn border-0 shadow-sm" title="Wishlist"><i
                                            class="bi bi-heart"></i></button>
                                </form>
                                <button type="button" class="action-btn border-0 shadow-sm" title="Quick View"
                                    onclick="openQuickView('{{ $prod->id }}')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="product-image-wrapper p-3 overflow-hidden bg-light d-flex align-items-center justify-content-center"
                                style="height: 220px;">
                                <a href="{{ url('product-detail/' . $prod->slug) }}" class="h-100 d-block text-center w-100">
                                    <img src="{{ asset($prod->image) }}"
                                        class="img-fluid h-100 object-fit-contain transition-all hover-scale"
                                        alt="{{ $prod->name }}" loading="lazy"
                                        onerror="this.src='https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=400'">
                                </a>
                            </div>
                            <div class="p-4">
                                <h6 class="text-secondary xx-small fw-black mb-1 uppercase tracking-widest text-start">
                                    {{ $prod->subCategory->name ?? 'Collection' }}
                                </h6>
                                <h5 class="fw-bold mb-2 text-dark text-truncate-2 text-start"
                                    style="font-size: 0.95rem; line-height: 1.4; height: 2.8em;">{{ $prod->name }}</h5>
                                <div class="price-wrapper d-flex align-items-baseline gap-2 mb-3">
                                    <span
                                        class="h5 fw-black text-primary mb-0">₹{{ number_format($prod->selling_price) }}</span>
                                    @if($prod->mrp > $prod->selling_price)
                                        <span
                                            class="text-muted x-small text-decoration-line-through">₹{{ number_format($prod->mrp) }}</span>
                                    @endif
                                </div>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('cart.add', $prod->id) }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-dark w-100 py-2 fw-black uppercase xx-small tracking-widest rounded-3 shadow-sm hover-float px-1">
                                            <i class="bi bi-bag-plus"></i> Cart
                                        </button>
                                    </form>
                                    <a href="{{ url('product-detail/' . $prod->slug) }}"
                                        class="btn btn-primary bg-gradient-primary flex-grow-1 py-2 fw-black uppercase xx-small tracking-widest rounded-3 shadow-sm hover-float d-flex align-items-center justify-content-center text-white text-decoration-none">
                                        Buy Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-secondary">No products found in featured collection.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Promotional Banners -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="rounded-4 overflow-hidden position-relative shadow-sm hover-float" style="height: 300px;">
                        <img src="{{asset('images/photo2.jpg')}}"
                            class="img-fluid w-100 h-100 object-fit-cover transition-all" alt="Electronics" loading="lazy">
                        <div class="position-absolute top-50 start-0 translate-middle-y ps-5 text-dark" style="z-index: 2;">
                            <h6 class="text-primary fw-bold text-uppercase mb-2">SAVE UP TO 40% OFF</h6>
                            <h3 class="fw-bold mb-2 text-white">Electronic <br>Mega Deal</h3>
                            <a href="{{ url('/products') }}" class="btn btn-premium px-4 mt-3">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="rounded-4 overflow-hidden position-relative shadow-sm hover-float" style="height: 300px;">
                        <img src="{{asset('images/photo1.jpg')}}"
                            class="img-fluid w-100 h-100 object-fit-cover transition-all" alt="Fashion Sale" loading="lazy">
                        <div class="position-absolute top-50 start-0 translate-middle-y ps-5 text-dark" style="z-index: 2;">
                            <h6 class="text-primary fw-bold text-uppercase mb-2">BUY 1 GET 1 FREE</h6>
                            <h3 class="fw-bold mb-2 text-white">Fashion <br>Summer Sale</h3>
                            <a href="{{ url('/products') }}" class="btn btn-premium px-4 mt-3">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lifestyle Highlights -->
    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="section-header text-center mb-5">
                <h2 class="display-5 fw-black mb-0">Highlights <span class="text-gradient-primary">Of The Week</span></h2>
                <div class="header-line mx-auto mt-2"
                    style="width: 80px; height: 4px; background: var(--primary-gradient); border-radius: 2px;"></div>
                <p class="mt-3 opacity-75">Curated collections for your modern lifestyle</p>
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="rounded-4 overflow-hidden position-relative shadow-sm transition-all hover-scale"
                        style="height: 400px;">
                        <img src="{{asset('images/photo3.jpg')}}" class="img-fluid h-100 w-100 object-fit-cover"
                            alt="Highlights" loading="lazy">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="rounded-4 overflow-hidden position-relative shadow-sm transition-all hover-scale mb-3"
                        style="height: 190px;">
                        <img src="{{asset('images/photo4.jpg')}}" class="img-fluid h-100 w-100 object-fit-cover"
                            alt="Highlights" loading="lazy">
                    </div>
                    <div class="rounded-4 overflow-hidden position-relative shadow-sm transition-all hover-scale"
                        style="height: 194px;">
                        <img src="{{asset('images/photo5.jpg')}}" class="img-fluid h-100 w-100 object-fit-cover"
                            alt="Highlights" loading="lazy">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rounded-4 overflow-hidden position-relative shadow-sm transition-all hover-scale"
                        style="height: 400px;">
                        <img src="{{asset('images/photo6.jpg')}}" class="img-fluid h-100 w-100 object-fit-cover"
                            alt="Highlights" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section (Soft White Theme) -->
    <section class="py-5 text-center" style="background: #F9FAFB;  ">
        <div class="container py-5">
            <span class="text-primary fw-bold text-uppercase mb-3 d-block" style="letter-spacing: 2px;">JOIN THE
                FAMILY</span>
            <h2 class="display-4 fw-black text-dark mb-4" style="letter-spacing: -1.5px;">Ready to Upgrade <br>Your Daily
                Lifestyle?</h2>
            <p class="lead text-secondary opacity-75 mb-5 max-width-600 mx-auto">Experience the premium quality,
                lightning-fast delivery, and world-class service that thousands of Indian shoppers love.</p>
            <div class="cta-actions d-flex flex-wrap justify-content-center gap-4 align-items-center">
                <a href="{{ url('/products') }}"
                    class="btn btn-premium btn-lg px-5 py-3 rounded-pill shadow-lg transform-transition hover-scale fw-bold">Shop
                    Full Collection</a>
                <a href="{{ url('/contact') }}" class="btn btn-outline-dark btn-lg px-5 py-3 rounded-pill fw-bold">Contact
                    Support</a>
            </div>

        </div>
    </section>
@endsection