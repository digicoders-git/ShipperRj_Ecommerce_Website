<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Shopping Club India - Ecommerce' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        /* Extra styles for the layout that might not be in style.css yet */
        .grayscale {
            filter: grayscale(1);
        }

        .trust-badge-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 8px 12px;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: default;
            flex: 1;
            min-width: 0;
        }

        .trust-badge-card:hover {
            background: rgba(255, 255, 255, 0.07);
            transform: translateY(-3px);
            border-color: rgba(242, 112, 26, 0.3);
        }

        .icon-box-sm {
            width: 38px;
            height: 38px;
            background: rgba(242, 112, 26, 0.1);
            color: #f2701aff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.1rem;
        }

        .trust-label {
            font-size: 0.6rem;
            font-weight: 800;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1;
            margin-bottom: 2px;
        }

        .trust-sub {
            font-size: 0.58rem;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 500;
            line-height: 1;
        }

        /* Utility Classes for Premium UI */
        .xx-small {
            font-size: 0.6rem;
        }

        .x-small {
            font-size: 0.75rem;
        }

        .fw-black {
            font-weight: 900;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .tracking-widest {
            letter-spacing: 0.15em;
        }

        .tracking-tighter {
            letter-spacing: -0.05em;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .scrollable-modal-body::-webkit-scrollbar {
            width: 4px;
        }

        .scrollable-modal-body::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }

        .scrollable-modal-body::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .wishlist-hover-premium:hover {
            background-color: #fff0f0 !important;
            color: #ff4747 !important;
            border-color: #ff4747 !important;
            transform: scale(1.1);
        }
    </style>
    @stack('styles')
</head>

<body>
    <div id="scroll-progress"></div>
    <!-- Loader -->
    <div id="loader" class="loader-wrapper">
        <div class="loader-spinner"></div>
    </div>

    <div class="top-bar d-none d-lg-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="top-info d-flex gap-4 align-items-center">
                <a href="tel:+919838048633"><i class="bi bi-telephone-fill me-1"></i> +91 98380 48633</a>
                <div class="vr bg-secondary opacity-25" style="height: 15px;"></div>
                <a href="mailto:shoppingserviceclub@gmail.com"><i class="bi bi-envelope-fill me-1"></i> shoppingserviceclub@gmail.com</a>
            </div>
            <div class="top-links d-flex gap-4 align-items-center">
                <a href="{{ route('orders') }}"><i class="bi bi-bag-heart-fill me-1"></i> My Orders</a>
                <div class="vr bg-secondary opacity-25" style="height: 15px;"></div>
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#supportFeedbackModal">
                    <i class="bi bi-headset me-1"></i> Support & Feedback
                </a>
                <div class="vr bg-secondary opacity-25" style="height: 15px;"></div>
                @if(Auth::check())
                    <a href="{{ route('profile') }}"><i class="bi bi-person-fill me-1"></i> My Profile</a>
                @else
                    <a href="{{ route('login') }}"><i class="bi bi-person-fill me-1"></i> Login</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header sticky-top shadow-sm">
        <div class="container d-flex align-items-center justify-content-between py-2">
            <!-- Logo -->
            <a class="navbar-brand m-0 d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo1.png') }}" alt="Shopping Club India"
                    class="logo-image transform-transition hover-scale"
                    style="height: 60px; width: auto; object-fit: contain;">
            </a>

            <!-- Search (Desktop Only) -->
            <div class="search-container d-none d-md-block flex-grow-1 mx-3 mx-lg-5">
                <form action="{{ url('/products') }}" method="GET"
                    class="d-flex align-items-center bg-white border rounded-pill p-1 shadow-sm">
                    <select name="category"
                        class="form-select border-0 bg-transparent w-auto fw-bold opacity-75 d-none d-lg-block"
                        style="min-width: 160px; cursor: pointer; font-size: 0.85rem;">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="vr mx-2 my-2 opacity-10 d-none d-lg-block"></div>
                    <input type="text" name="search" class="form-control border-0 bg-transparent py-2 px-3"
                        placeholder="Search for products..." style="font-size: 0.9rem;">
                    <button type="submit"
                        class="btn btn-premium rounded-circle d-flex align-items-center justify-content-center ms-2"
                        style="width: 38px; height: 38px;">
                        <i class="bi bi-search text-white"></i>
                    </button>
                </form>
            </div>

            <!-- Icons/Actions -->
            <div class="header-icons d-flex align-items-center gap-2 gap-sm-3">
                <!-- Wishlist (Desktop) -->
                <a href="{{ url('/wishlist') }}" class="icon-link position-relative d-none d-lg-inline-flex"
                    title="Wishlist">
                    <i class="bi bi-heart fs-4"></i>
                    @auth
                        <span class="badge-count">{{ Auth::user()->wishlists()->count() }}</span>
                    @endauth
                </a>

                <!-- Mobile Search Trigger (Hidden on Desktop) -->
                <button class="btn d-md-none border-0 p-1 text-white shadow-none me-1" type="button"
                    data-bs-toggle="collapse" data-bs-target="#mobileSearchRow" aria-label="Search">
                    <i class="bi bi-search fs-4"></i>
                </button>

                <!-- Cart (Desktop Only) -->
                <a href="{{ url('/cart') }}"
                    class="icon-link position-relative d-none d-lg-inline-flex align-items-center" title="Cart">
                    <div class="position-relative">
                        <i class="bi bi-handbag fs-4"></i>
                        @auth
                            <span class="badge-count">{{ Auth::user()->carts()->count() }}</span>
                        @endauth
                    </div>
                </a>

                @auth
                    <!-- Account (Desktop) -->
                    <div class="dropdown d-none d-lg-inline-flex">
                        <a href="#" class="icon-link dropdown-toggle" data-bs-toggle="dropdown" title="My Account">
                            <i class="bi bi-person-check fs-4"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-premium border-0 rounded-4 p-2 mt-3">
                            <li class="px-3 py-2 border-bottom mb-2">
                                <p class="small text-secondary mb-0">Signed in as</p>
                                <p class="fw-bold text-dark mb-0 text-truncate">{{ Auth::user()->name }}</p>
                            </li>
                            <li><a class="dropdown-item rounded-3" href="{{ url('/dashboard') }}"><i
                                        class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                            <li><a class="dropdown-item rounded-3" href="{{ url('/orders') }}"><i
                                        class="bi bi-box-seam me-2"></i>My Orders</a></li>
                            <li><a class="dropdown-item rounded-3" href="{{ url('/wallet') }}"><i
                                        class="bi bi-wallet me-2"></i>My Wallet</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item rounded-3 text-danger"><i
                                            class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="icon-link d-none d-lg-inline-flex" title="Login / Register">
                        <i class="bi bi-person fs-4"></i>
                    </a>
                @endauth

                <!-- Mobile Menu Trigger -->
                <button class="btn d-lg-none border-0 p-1 text-white shadow-none" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                    <i class="bi bi-grid-fill fs-3"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Search Row (Collapsible) -->
        <div class="collapse d-md-none" id="mobileSearchRow">
            <div class="container pb-3 pt-1">
                <form action="{{ url('/products') }}" method="GET"
                    class="d-flex align-items-center bg-white border border-white border-opacity-20 rounded-pill p-1 shadow-sm">
                    <input type="text" name="search" class="form-control border-0 bg-transparent py-2 px-3 text-dark"
                        placeholder="Search products..." style="font-size: 0.85rem;">
                    <button type="submit" class="btn btn-premium rounded-circle p-2 ms-2"
                        style="width: 36px; height: 36px;">
                        <i class="bi bi-search fs-6 text-white"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Offcanvas -->
    <div class="offcanvas offcanvas-start mobile-menu-offcanvas" tabindex="-1" id="mobileMenu"
        aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header border-bottom py-4 bg">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('assets/images/logo1.png') }}" alt="Logo" height="50">
                <h5 class="offcanvas-title fw-bold" id="mobileMenuLabel">Menu</h5>
            </div>
            <button type="button" class="btn-close text-reset shadow-none" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <!-- User Account Brief -->
            <div class="user-brief p-4 bg-light d-flex align-items-center gap-3">
                <div class="user-avatar rounded-circle bg-primary-gradient d-flex align-items-center justify-content-center text-white shadow-sm"
                    style="width: 50px; height: 50px;">
                    <i class="bi bi-person-fill fs-4"></i>
                </div>
                <div>
                    @auth
                        <h6 class="mb-0 fw-bold">{{ Auth::user()->name }}</h6>
                        <a href="{{ url('/dashboard') }}" class="text-primary small text-decoration-none fw-medium">View
                            Profile</a>
                    @else
                        <h6 class="mb-0 fw-bold">Welcome Guest</h6>
                        <a href="{{ route('login') }}" class="text-primary small text-decoration-none fw-medium">Login /
                            Register</a>
                    @endauth
                </div>
            </div>

            <!-- Mobile Nav Links -->
            <div class="mobile-nav-list py-2">
                <div class="list-group list-group-flush">
                    <a href="{{ url('/') }}"
                        class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center gap-3 {{ request()->is('/') ? 'active' : '' }}">
                        <i class="bi bi-house-door fs-5 text-primary"></i> Home
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center gap-3 {{ request()->routeIs('products.index') && !request()->has('filter') ? 'active' : '' }}">
                        <i class="bi bi-box-seam fs-5 text-primary"></i> All Products
                    </a>
                    <a href="{{ route('products.index', ['filter' => 'trending']) }}"
                        class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center gap-3 {{ request()->get('filter') === 'trending' ? 'active' : '' }}">
                        <i class="bi bi-star fs-5 text-primary"></i> Trending Products
                    </a>
                    <a href="{{ url('/wishlist') }}"
                        class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center gap-3 {{ request()->is('wishlist') ? 'active' : '' }}">
                        <i class="bi bi-heart fs-5 text-primary"></i> My Wishlist
                        @auth
                            <span
                                class="badge rounded-pill bg-primary ms-auto">{{ Auth::user()->wishlists()->count() }}</span>
                        @endauth
                    </a>
                    <a href="{{ url('/dashboard') }}"
                        class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center gap-3 {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-person-circle fs-5 text-primary"></i> My Account
                    </a>
                    <a href="{{ url('/cart') }}"
                        class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center gap-3 {{ request()->is('cart') ? 'active' : '' }}">
                        <i class="bi bi-handbag fs-5 text-primary"></i> Shopping Cart
                        @auth
                            <span class="badge rounded-pill bg-primary ms-auto">{{ Auth::user()->carts()->count() }}</span>
                        @endauth
                    </a>
                </div>

                <hr class="mx-4 opacity-10">

                <div class="px-4 py-2">
                    <h6 class="text-muted text-uppercase small fw-bold mb-3">Categories</h6>
                    <div class="list-group list-group-flush category-mobile-list">
                        @foreach($categories as $category)
                            <div class="category-item-mobile">
                                <a href="{{ url('/products?category=' . $category->id) }}"
                                    class="list-group-item list-group-item-action border-0 p-2 d-flex align-items-center justify-content-between">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-tag small text-primary"></i> {{ $category->name }}
                                    </span>
                                    @if($category->subCategories->count() > 0)
                                        <i class="bi bi-chevron-right small opacity-50"></i>
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr class="mx-4 opacity-10">

                <div class="list-group list-group-flush pb-4">
                    <a href="{{ route('about') }}"
                        class="list-group-item list-group-item-action border-0 px-4 py-2 small {{ request()->routeIs('about') ? 'active' : '' }}">About
                        Us</a>
                    <a href="{{ route('seller.inquiry') }}"
                        class="list-group-item list-group-item-action border-0 px-4 py-2 small {{ request()->routeIs('seller.inquiry') ? 'active' : '' }}">Become a Seller</a>
                    <a href="{{ route('contact') }}"
                        class="list-group-item list-group-item-action border-0 px-4 py-2 small {{ request()->routeIs('contact') ? 'active' : '' }}">Contact
                        Us</a>
                    <a href="#" class="list-group-item list-group-item-action border-0 px-4 py-2 small">Help Center</a>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer p-4 border-top">
            <div class="social-links d-flex gap-3">
                <a href="#" class="text-secondary fs-5"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-secondary fs-5"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-secondary fs-5"><i class="bi bi-twitter-x"></i></a>
            </div>
        </div>
    </div>


    <!-- Navigation Bar -->
    <nav class="main-nav d-none d-lg-block py-0 shadow-sm">
        <div class="container d-flex align-items-center">


            <ul class="nav flex-grow-1">
                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->is('/') ? 'active' : '' }}"
                        href="{{ url('/') }}">Home</a>
                </li>

                <!-- Category Mega Menu -->
                <li class="nav-item position-relative has-mega-menu">
                    <a class="nav-link nav-link-custom d-flex align-items-center gap-2" href="#">
                        Categories <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="mega-menu-content shadow-premium border-0">
                        <div class="row g-0 h-100">
                            <!-- Categories List -->
                            <div class="col-lg-3 bg-light-orange border-end p-0">
                                <ul class="list-unstyled mb-0 py-2 category-main-list">
                                    @foreach($categories as $category)
                                        <li class="category-main-item">
                                            <a href="{{ url('/products?category=' . $category->id) }}"
                                                class="category-link d-flex align-items-center justify-content-between px-4 py-3 text-decoration-none">
                                                <span class="d-flex align-items-center gap-3">
                                                    <i class="bi bi-tag-fill text-primary"></i>
                                                    <span class="fw-bold">{{ $category->name }}</span>
                                                </span>
                                                <i class="bi bi-chevron-right small arrow-icon"></i>
                                            </a>

                                            <!-- Sub-Categories Panel -->
                                            @if($category->subCategories->count() > 0)
                                                <div class="subcategory-panel p-4">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h5
                                                                class="fw-black text-dark mb-4 pb-2 border-bottom border-primary-soft display-6 fs-4">
                                                                {{ $category->name }} Collections
                                                            </h5>
                                                            <div class="row g-3">
                                                                @foreach($category->subCategories as $sub)
                                                                    <div class="col-lg-3">
                                                                        <a href="{{ url('/products?sub_category=' . $sub->id) }}"
                                                                            class="sub-link d-flex align-items-center gap-3 p-2 rounded-4 text-decoration-none transition-all">
                                                                            <div class="sub-icon bg-light shadow-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                                                style="width: 38px; height: 38px;">
                                                                                <i
                                                                                    class="bi bi-chevron-right small text-primary"></i>
                                                                            </div>
                                                                            <span
                                                                                class="text-dark fw-semibold small text-truncate">{{ $sub->name }}</span>
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Featured Section or Banner -->
                            <div
                                class="col-lg-9 d-flex align-items-center justify-content-center p-5 empty-state-panel">
                                <div class="text-center p-5">
                                    <div class="mb-4 position-relative d-inline-block">
                                        <div
                                            class="position-absolute top-50 start-50 translate-middle w-150 h-150 opacity-10 bg-primary rounded-circle animate-pulse">
                                        </div>
                                        <i class="bi bi-grid-3x3-gap display-3 text-primary position-relative z-1"></i>
                                    </div>
                                    <h4 class="fw-black text-dark mb-2">Explore Our Collections</h4>
                                    <p class="text-muted small mx-auto" style="max-width: 300px;">Hover over any
                                        category on the left to discover a world of premium products and exclusive
                                        deals.</p>
                                    <div class="mt-4 pt-2">
                                        <span
                                            class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill fw-bold xx-small uppercase tracking-widest">
                                            <i class="bi bi-star-fill me-1"></i> Featured Categories
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ (request()->routeIs('products.index') && !request()->has('filter')) ? 'active' : '' }}"
                        href="{{ route('products.index') }}">All Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->get('filter') === 'trending' ? 'active' : '' }}"
                        href="{{ route('products.index', ['filter' => 'trending']) }}">Trending Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('about') ? 'active' : '' }}"
                        href="{{ route('about') }}">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>

            <div class="promo-text-nav d-none d-xl-flex align-items-center gap-3">
                <a href="{{ route('seller.inquiry') }}" class="text-decoration-none d-flex align-items-center gap-2">
                    <span class="badge bg-primary-soft text-primary px-3 py-1 rounded-pill fw-bold xx-small uppercase tracking-widest">
                        Grow Your Business With Us 🚀
                    </span>
                </a>
            </div>
            
        </div>
    </nav>
    <main>
        @yield('content')
    </main>

    <style>
        /* Quick View Soft Light Theme Utilities */
        .bg-primary-soft {
            background-color: rgba(112, 0, 255, 0.08);
        }

        .btn-outline-light-custom {
            border: 1px solid #edf2f7;
            background: #fff;
            color: #4a5568;
            transition: all 0.3s ease;
        }

        .btn-outline-light-custom:hover {
            background: #f7fafc;
            border-color: #e2e8f0;
            transform: translateY(-2px);
        }

        .shadow-premium {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        }

        .shadow-soft {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .elevation-1 {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Essential Premium Footer UI */
        .social-circle {
            width: 34px;
            height: 34px;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #fff;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255, 255, 255, 0.05);
            text-decoration: none;
        }

        .social-circle:hover {
            background: var(--primary);
            transform: scale(1.1) rotate(5deg);
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.5) !important;
            font-size: 0.72rem;
            font-weight: 500;
            text-decoration: none;
            display: block;
            margin-bottom: 0.85rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .footer-link:hover {
            color: #e96715ff !important;
            transform: translateX(6px);
            opacity: 1 !important;
        }

        .social-capsule {
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, 0.04);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255, 255, 255, 0.06);
            text-decoration: none !important;
        }

        .social-capsule:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #e96715ff !important;
            transform: translateY(-4px) rotate(8deg);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.3);
        }

        .btn-subscribe-premium {
            background: #0d6efd;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.2);
        }

        .btn-subscribe-premium:hover {
            background: #0b5ed7;
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.4);
        }

        .footer-header {
            font-size: 0.65rem;
            font-weight: 800;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.9;
            margin-bottom: 1.8rem;
        }
    </style> <!-- Footer -->
    <!-- Premium E-commerce Footer -->
    <footer class="footer-main py-5 text-white border-top border-white border-opacity-5" style="background: #09090b;">
        <div class="container py-4">
            <div class="row g-5">
                <!-- Column 1: Brand Essence -->
                <div class="col-lg-3 col-md-6 text-start">
                    <div class="footer-brand-hub mb-4">
                        <img src="{{ asset('assets/images/logo1.png') }}" alt="Shopping Club India" height="55"
                            class="mb-4 brightness-110">
                        <p class="text-white-50 small fw-medium mb-4"
                            style="line-height: 1.8; opacity: 0.8 !important;">
                            Shopping Club India is India's leading destination for premium electronics, trendy fashion,
                            and modern lifestyle essentials. We bring quality and value right to your doorstep with
                            unmatched delivery speed and customer care.
                        </p>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 ms-lg-auto">
                    <h6 class="footer-header">Quick Links</h6>
                    <ul class="list-unstyled footer-link-list">
                        <li><a href="{{ route('about') }}" class="footer-link">About Us</a></li>
                        <li><a href="{{ route('profile') }}" class="footer-link">My Account</a></li>
                        <li><a href="{{ route('orders') }}" class="footer-link">Track Order</a></li>
                        <li><a href="{{ route('contact') }}" class="footer-link">Contact Us</a></li>
                        <li><a href="{{ url('/terms') }}" class="footer-link">Terms & Conditions</a></li>
                    </ul>
                </div>

                <!-- Column Utility -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-header">Customer Care</h6>
                    <ul class="list-unstyled footer-link-list">
                        <li><a href="{{ url('/helpdesk') }}" class="footer-link">Help Center</a></li>
                        <li><a href="{{ url('/refund-policy') }}" class="footer-link">Returns & Refunds</a></li>
                        <li><a href="{{ url('/helpdesk') }}" class="footer-link">FAQs</a></li>
                        <li><a href="{{ url('/privacy') }}" class="footer-link">Privacy Policy</a></li>
                        <li><a href="{{ url('/terms') }}" class="footer-link">Terms & Conditions</a></li>
                    </ul>
                </div>

                <!-- Column 4: Newsletter & Trust -->
                <div class="col-lg-4 col-md-6">
                    <h6 class="footer-header">India's Trust</h6>
                    <p class="text-white x-small mb-4 opacity-75 mt-0 pt-0" style="font-weight: 500;">shoppingclubindia
                        is
                        a trusted name in the Indian e-commerce industry. We are committed to providing our customers
                        with the best possible shopping experience. We offer a wide range of products at competitive
                        prices. Our website is easy to navigate and use. We offer a variety of payment options and
                        shipping methods. We are committed to customer satisfaction and offer a money-back guarantee if
                        you are not satisfied with your purchase.</p>
                    <div class="newsletter-group mb-4">
                        <!-- <div class="input-group overflow-hidden rounded-pill p-1 bg-white shadow-sm"
                            style="border: none !important;">
                            <input type="email" class="form-control border-0 py-2 px-4 shadow-none fs-6"
                                placeholder="Email address"
                                style="color: #333 !important; background: transparent; font-size: 0.85rem !important;">
                            <button
                                class="btn btn-primary rounded-pill border-0 px-4 py-2 fs-6 fw-black uppercase tracking-tight btn-subscribe-premium"
                                type="button" style="min-width: 120px;">Subscribe</button>
                        </div> -->
                    </div>

                    <!-- Updated Premium Trust Badges -->
                    <div class="d-flex flex-row gap-2 mt-4">
                        <div class="trust-badge-card d-flex align-items-center gap-2">
                            <div class="icon-box-sm flex-shrink-0">
                                <i class="bi bi-shield-lock-fill"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="d-block trust-label text-truncate">100% Secure</span>
                                <span class="d-block trust-sub text-truncate">Protected Payments</span>
                            </div>
                        </div>
                        <div class="trust-badge-card d-flex align-items-center gap-2">
                            <div class="icon-box-sm flex-shrink-0">
                                <i class="bi bi-truck"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="d-block trust-label text-truncate">Express Delivery</span>
                                <span class="d-block trust-sub text-truncate">Fast Pan-India Shipping</span>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="pt-5 mt-5 border-top" style="border-top: 1px solid rgba(255,255,255,0.08) !important;">
                <div class="row align-items-center g-4">
                    <!-- Column 1: Social Hub (Left) -->
                    <div class="col-lg-3 col-md-12 text-center text-lg-start order-2 order-lg-1">
                        <div class="d-flex justify-content-center justify-content-lg-start gap-3">
                            <a href="#" class="social-capsule" title="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="social-capsule" title="Instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="social-capsule" title="Twitter"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" class="social-capsule" title="Youtube"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>

                    <!-- Column 2: Copyright & Credits (Center) -->
                    <div class="col-lg-6 col-md-12 text-center order-1 order-lg-2">
                        <span class="xx-small fw-bold text-white uppercase tracking-widest d-block d-lg-inline lh-base"
                            style="letter-spacing: 0.5px;">
                            &copy; <?php echo date('Y'); ?> Shopping Club India — All Rights Reserved.
                            <span class="opacity-25 d-none d-lg-inline px-2">|</span>
                            <span class="d-block d-lg-inline mt-1 mt-lg-0">
                                Crafted by <a href="https://digicoders.in" target="_blank"
                                    style="color: #f2701aff !important; text-decoration: none !important; font-weight: 800;">#Team
                                    Digicoders</a>
                            </span>
                        </span>
                    </div>

                    <!-- Column 3: Trusted Gateways (Right) -->
                    <div class="col-lg-3 col-md-12 text-center text-lg-end order-3 order-lg-3">
                        <div
                            class="d-flex justify-content-center justify-content-lg-end align-items-center gap-3 footer-payments">
                            <img src="{{ asset('images/visa.png') }}" height="20"
                                class="hover-scale transition-all pointer">
                            <img src="{{ asset('images/mastercard.png') }}" height="26"
                                class="hover-scale transition-all pointer">
                            <img src="{{ asset('images/paypal.png') }}" height="18"
                                class="hover-scale transition-all pointer">
                            <img src="{{ asset('images/gpay.png') }}" height="22"
                                class="hover-scale transition-all pointer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top -->
    <button id="scrollToTop"
        class="btn btn-premium rounded-circle position-fixed bottom-0 end-0 m-4 shadow-lg p-0 d-flex align-items-center justify-content-center"
        style="width: 45px; height: 45px; visibility: hidden; opacity: 0; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); z-index: 1000; bottom: 20px !important;">
        <i class="bi bi-arrow-up fs-4"></i>
    </button>

    <!-- JS Snippets -->
    <script>
        // Consolidated Scroll Handler (Sticky Header & Back-to-Top)
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.main-header');
            const topBtn = document.getElementById('scrollToTop');
            const scrollPos = window.scrollY || document.documentElement.scrollTop;

            // Header Logic
            if (header) {
                if (scrollPos > 150) {
                    header.classList.add('sticky');
                } else {
                    header.classList.remove('sticky');
                }
            }

            // Back to Top Button Logic
            if (topBtn) {
                if (scrollPos > 400) {
                    topBtn.style.visibility = "visible";
                    topBtn.style.opacity = "1";
                    topBtn.style.transform = "scale(1)";
                    topBtn.style.bottom = "30px";
                } else {
                    topBtn.style.opacity = "0";
                    topBtn.style.transform = "scale(0)";
                    topBtn.style.bottom = "0";
                    // Delay hiding until animation finishes
                    setTimeout(() => {
                        if (scrollPos <= 400) {
                            topBtn.style.visibility = "hidden";
                        }
                    }, 400);
                }
            }
        });

        // Click Handler for Scroll to Top
        document.getElementById('scrollToTop')?.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Unified Page Loader Handling
        (function () {
            const loader = document.getElementById('loader');
            if (loader) {
                const hideLoader = () => {
                    loader.style.opacity = '0';
                    setTimeout(() => { loader.style.display = 'none'; }, 500);
                };
                window.addEventListener('load', hideLoader);
                document.addEventListener('DOMContentLoaded', hideLoader);
                setTimeout(hideLoader, 3000); // Safety timeout
            }
        })();

        // Always show mega-menu categories from top on open.
        const megaMenuTrigger = document.querySelector('.has-mega-menu');
        const categoryList = document.querySelector('.category-main-list');
        if (megaMenuTrigger && categoryList) {
            megaMenuTrigger.addEventListener('mouseenter', () => {
                categoryList.scrollTop = 0;
            });
        }
    </script>

    <!-- Quick View Modal (Global) - Soft Light Theme -->
    <div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 p-0 shadow-premium overflow-hidden"
                style="background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(20px); border-radius: 24px; border: 1px solid rgba(0,0,0,0.05) !important;">
                <div id="quickViewContent">
                    <!-- Dynamic Content -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeQuickViewImage(imgUrl, element) {
            document.getElementById('mainViewImage').src = imgUrl;
            // Remove selection from all thumbs in the same gallery
            element.closest('.row').querySelectorAll('.thumb-wrapper').forEach(el => {
                el.style.borderColor = 'rgba(0,0,0,0.05)';
                el.classList.remove('active-thumb');
                el.style.opacity = '0.6';
            });
            // Add selection to clicked thumb
            element.style.borderColor = 'var(--primary)';
            element.classList.add('active-thumb');
            element.style.opacity = '1';
        }

        function openQuickView(id) {
            let myModal = new bootstrap.Modal(document.getElementById('quickViewModal'));
            myModal.show();

            document.getElementById('quickViewContent').innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>';

            fetch('/product/quickview/' + id)
                .then(res => res.json())
                .then(data => {
                    let mainImg = data.image ? '/' + data.image : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=400';
                    let offPercent = data.mrp > data.selling_price ? Math.round(((data.mrp - data.selling_price) / data.mrp) * 100) : 0;

                    let galleryHtml = '';
                    if (data.images && data.images.length > 0) {
                        galleryHtml = `
                            <div class="px-3 pb-3">
                                <h6 class="text-secondary xx-small fw-black mb-2 d-flex align-items-center gap-2 uppercase tracking-widest opacity-75">
                                    <i class="bi bi-grid-3x3-gap text-primary"></i> GALLERY
                                </h6>
                                <div class="row g-2">
                                    <div class="col-3">
                                        <div class="ratio ratio-1x1 rounded-3 overflow-hidden border border-primary thumb-wrapper active-thumb cursor-pointer shadow-sm hover-scale transition-all"
                                            style="border-width: 2px !important; opacity: 1;"
                                            onclick="changeQuickViewImage('${mainImg}', this)">
                                            <img src="${mainImg}" class="object-fit-cover w-100 h-100">
                                        </div>
                                    </div>
                                    ${data.images.map(img => `
                                        <div class="col-3">
                                            <div class="ratio ratio-1x1 rounded-3 overflow-hidden border thumb-wrapper cursor-pointer shadow-sm hover-scale transition-all"
                                                style="border-color: rgba(0,0,0,0.05); border-width: 2px !important; opacity: 0.6;"
                                                onclick="changeQuickViewImage('/${img.image_path}', this)">
                                                <img src="/${img.image_path}" class="object-fit-cover w-100 h-100">
                                            </div>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        `;
                    }

                    let html = `
                        <!-- Soft Premium Header -->
                        <div class="modal-header border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="p-2 rounded-3 me-3"
                                    style="background: var(--primary-soft); border: 1px solid rgba(255, 122, 24, 0.1);">
                                    <i class="bi bi-box-seam text-primary fs-5"></i>
                                </div>
                                <div>
                                    <h5 class="modal-title fw-black text-dark mb-0" style="letter-spacing: -0.3px;">Product Intel</h5>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-secondary opacity-50 xx-small fw-bold uppercase tracking-widest">SKU: ${data.sku ?? 'N/A'}</span>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-0 scrollable-modal-body" style="max-height: 75vh; overflow-y: auto;">
                            <div class="p-4 pt-4">
                                <div class="row g-4">
                                    <!-- Media & Logistics -->
                                    <div class="col-lg-5">
                                        <div class="position-relative mb-4 group">
                                            <div class="p-2 text-center rounded-4 overflow-hidden border border-light shadow-sm bg-light position-relative d-flex align-items-center justify-content-center"
                                                style="min-height: 320px;">
                                                <img id="mainViewImage" src="${mainImg}" class="img-fluid rounded-3" style="max-height: 300px; width: auto; object-fit: contain;">
                                                <div class="position-absolute bottom-0 start-0 w-100 p-2 bg-gradient-to-t from-black opacity-0 group-hover-opacity-100 transition-all">
                                                    <span class="badge ${data.status ? 'bg-success' : 'bg-danger'} px-2 py-1 rounded-pill xx-small fw-bold">
                                                        ${data.status ? 'ONLINE' : 'OFFLINE'}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        ${galleryHtml}

                                        <div class="p-3 rounded-4 bg-light border border-light mb-3">
                                            <h6 class="text-dark xx-small fw-black mb-2 d-flex align-items-center gap-2 uppercase tracking-widest opacity-75">
                                                <i class="bi bi-truck text-primary"></i> LOGISTICS
                                            </h6>
                                            <div class="small">
                                                <div class="d-flex justify-content-between py-1">
                                                    <span class="xx-small text-secondary fw-bold uppercase px-1">Shipping</span>
                                                    <span class="text-dark fw-bold">₹${parseFloat(data.shipping_charges || 0).toLocaleString()}</span>
                                                </div>
                                                <div class="d-flex justify-content-between py-1 border-top mt-1">
                                                    <span class="xx-small text-secondary fw-bold uppercase px-1">Weight</span>
                                                    <span class="text-dark fw-bold">${data.weight ?? '--'}</span>
                                                </div>
                                                <div class="d-flex justify-content-between py-1 border-top mt-1">
                                                    <span class="xx-small text-secondary fw-bold uppercase px-1">Dimensions</span>
                                                    <span class="text-dark fw-bold">${data.dimensions ?? '--'}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Data Display -->
                                    <div class="col-lg-7">
                                        <div class="mb-4">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="x-small text-primary fw-bold uppercase tracking-wider">${data.subCategory?.category?.name || 'Home'}</span>
                                                <i class="bi bi-chevron-right xx-small text-secondary opacity-50"></i>
                                                <span class="x-small text-secondary fw-bold uppercase tracking-wider">${data.subCategory?.name || 'Collection'}</span>
                                            </div>
                                            <h3 class="fw-black text-dark mb-2" style="letter-spacing: -1px; line-height: 1.2;">${data.name}</h3>
                                            <div class="d-flex align-items-center flex-wrap gap-2">
                                                ${data.brand ? `<span class="badge bg-primary text-white border-0 shadow-sm xx-small px-3 py-1 rounded-pill fw-black">${data.brand.toUpperCase()}</span>` : ''}
                                                ${data.trending ? `<span class="badge bg-danger text-white border-0 shadow-sm xx-small px-3 py-1 rounded-pill fw-black"><i class="bi bi-fire me-1"></i>TRENDING</span>` : ''}
                                                <span class="badge bg-light text-secondary xx-small px-3 py-1 rounded-pill border fw-bold tracking-tight">ID: ${data.id}</span>
                                            </div>
                                        </div>

                                        <!-- Financial Insights -->
                                        <div class="p-4 rounded-4 mb-4 border-0 position-relative overflow-hidden shadow-sm"
                                            style="background: linear-gradient(135deg, #FFF9F5 0%, #FFFFFF 100%); border: 1px solid rgba(255, 122, 24, 0.1) !important;">
                                            <div class="row align-items-center position-relative z-1">
                                                <div class="col-6 col-md-5">
                                                    <p class="xx-small text-secondary uppercase fw-black mb-1 opacity-50 tracking-widest">Pricing</p>
                                                    <div class="d-flex align-items-baseline gap-2 flex-wrap">
                                                        <h2 class="text-primary fw-black mb-0">₹${data.selling_price.toLocaleString()}</h2>
                                                        ${data.mrp > data.selling_price ? `<span class="text-muted text-decoration-line-through x-small opacity-50">₹${data.mrp.toLocaleString()}</span>` : ''}
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3 ps-3">
                                                    <p class="xx-small text-success uppercase fw-black mb-0 tracking-widest">Off</p>
                                                    <h4 class="text-success fw-black mb-0">${offPercent}%</h4>
                                                </div>
                                                <div class="col-12 col-md-4 text-md-end ps-md-3 mt-3 mt-md-0">
                                                    <p class="xx-small text-secondary uppercase fw-black mb-1 opacity-50 tracking-widest">Stock</p>
                                                    <div class="d-flex align-items-center justify-content-md-end gap-2">
                                                        <span class="h4 text-dark fw-black mb-0">${data.stock}</span>
                                                        <span class="badge ${data.stock > 10 ? 'bg-success' : 'bg-warning'} px-2 py-1 rounded-pill xx-small fw-bold">
                                                            ${(data.stock_status || (data.stock > 0 ? 'In Stock' : 'Out of Stock')).toUpperCase()}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Grid Specs -->
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-6">
                                                <div class="p-3 rounded-4 h-100 border bg-light bg-opacity-50">
                                                    <h6 class="text-primary xx-small fw-black mb-2 uppercase tracking-widest">SPECIFICATIONS</h6>
                                                    <div class="space-y-2">
                                                        <div class="mb-2">
                                                            <label class="xx-small text-secondary fw-bold opacity-50 uppercase tracking-tighter d-block">Sizes</label>
                                                            <span class="x-small text-dark fw-bold mb-0">${data.size || 'Standard'}</span>
                                                        </div>
                                                        <div>
                                                            <label class="xx-small text-secondary fw-bold opacity-50 uppercase tracking-tighter d-block">Colors</label>
                                                            <span class="x-small text-dark fw-bold mb-0">${data.color || 'Variable'}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-3 rounded-4 h-100 border bg-light bg-opacity-50">
                                                    <h6 class="text-primary xx-small fw-black mb-2 uppercase tracking-widest">SUPPLY Chain</h6>
                                                    <div class="space-y-2">
                                                        <div class="mb-2">
                                                            <label class="xx-small text-secondary fw-bold opacity-50 uppercase tracking-tighter d-block">Manufacturer</label>
                                                            <span class="x-small text-dark fw-bold mb-0">${data.manufacturer || 'Standard OEM'}</span>
                                                        </div>
                                                        <div>
                                                            <label class="xx-small text-secondary fw-bold opacity-50 uppercase tracking-tighter d-block">Seller</label>
                                                            <span class="x-small text-dark fw-bold mb-0">${data.seller_name || 'Direct Fulfillment'}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="d-flex flex-wrap gap-2 mt-auto">
                                            <form action="/cart/add/${data.id}" method="POST" class="flex-grow-1">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-primary bg-gradient-primary w-100 py-3 rounded-pill fw-bold shadow-md border-0 transform-transition hover-scale">
                                                    <i class="bi bi-cart-plus me-2"></i> ADD TO CART
                                                </button>
                                            </form>
                                            <form action="/wishlist/add/${data.id}" method="POST">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-outline-light border px-4 py-3 rounded-pill text-dark wishlist-hover-premium transition-all shadow-sm">
                                                    <i class="bi bi-heart"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Narrative (Full Width Bottom) -->
                            <div class="px-4 pb-4">
                                <div class="p-4 rounded-4 border bg-light shadow-inner">
                                    <h6 class="text-primary xx-small fw-black mb-3 uppercase tracking-widest">DESCRIPTIVE NARRATIVE</h6>
                                    <p class="text-muted x-small mb-4 pe-lg-5" style="line-height: 1.8;">
                                        ${data.description || 'Experience high-performance quality with this exclusive item from our premium collection.'}
                                    </p>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-arrow-return-left text-danger p-2 bg-danger bg-opacity-10 rounded-circle"></i>
                                                <div>
                                                    <span class="d-block xx-small fw-bold text-dark uppercase">Returns Policy</span>
                                                    <span class="d-block x-small text-secondary">${data.return_policy ?? '7 Days Easy Return'}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-patch-check text-success p-2 bg-success bg-opacity-10 rounded-circle"></i>
                                                <div>
                                                    <span class="d-block xx-small fw-bold text-dark uppercase">Warranty Cover</span>
                                                    <span class="d-block x-small text-secondary">${data.warranty ?? '1 Year Standard'}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Full Details Footer -->
                        <div class="modal-footer border-0 p-4 bg-light d-flex justify-content-between align-items-center rounded-bottom-4">
                            <span class="text-secondary xx-small fw-bold uppercase">Ready to elevate? Explore details below.</span>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-light px-4 py-2 rounded-pill x-small fw-bold border" data-bs-dismiss="modal">Close</button>
                                <a href="/product-detail/${data.slug}" class="btn btn-dark px-4 py-2 rounded-pill x-small fw-bold shadow-sm">View Full Specs</a>
                            </div>
                        </div>
                    `;
                    document.getElementById('quickViewContent').innerHTML = html;
                });
        }

        function swapMainViewImage(element, src) {
            // Update Main Image
            const mainImg = document.getElementById('mainViewImage');
            if (mainImg) {
                mainImg.style.opacity = '0';
                setTimeout(() => {
                    mainImg.src = src;
                    mainImg.style.opacity = '1';
                }, 150);
            }

            // Update Active Thumbnail State
            const thumbs = document.querySelectorAll('.thumbnail-item');
            thumbs.forEach(t => t.classList.remove('active-thumb'));
            if (element) {
                element.classList.add('active-thumb');
            }
        }
    </script>
    <!-- Support & Feedback Modal (Premium Solid Design) -->
    <div class="modal fade" id="supportFeedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-premium rounded-5 overflow-hidden shadow-lg h-auto">
                <!-- Branding Header -->
                <div class="modal-header-premium p-4 pb-0 bg-white border-0">
                    <div class="d-flex align-items-center gap-3 w-100 position-relative">
                        <div class="p-2 bg-primary bg-opacity-10 rounded-4">
                            <i class="bi bi-headset text-white fs-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="fw-black mb-0 letter-spacing-n1 text-dark">Support & Feedback</h4>
                            <p class="text-muted small mb-0 fw-medium">We're here to help you.</p>
                        </div>
                        <button type="button" class="btn-close-premium" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>

                <div class="modal-body p-4 pt-3">
                    <form id="supportForm" action="{{ route('support.submit') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-6 slide-in-bottom" style="animation-delay: 0.1s">
                                <div class="premium-field">
                                    <label
                                        class="small fw-black uppercase tracking-widest text-primary mb-2 d-block">Your
                                        Name</label>
                                    <div class="input-wrapper-glass">
                                        <i class="bi bi-person ms-3 text-muted"></i>
                                        <input type="text" name="name" class="form-control-minimal"
                                            placeholder="Full Name"
                                            value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 slide-in-bottom" style="animation-delay: 0.2s">
                                <div class="premium-field">
                                    <label
                                        class="small fw-black uppercase tracking-widest text-primary mb-2 d-block">Mobile
                                        No.</label>
                                    <div class="input-wrapper-glass">
                                        <i class="bi bi-phone ms-3 text-muted"></i>
                                        <input type="tel" name="phone" class="form-control-minimal"
                                            placeholder="10 Digits" pattern="[6-9][0-9]{9}" maxlength="10"
                                            title="Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                            value="{{ Auth::check() ? Auth::user()->mobile_primary ?? Auth::user()->mobile : '' }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 slide-in-bottom" style="animation-delay: 0.15s">
                                <div class="premium-field">
                                    <label
                                        class="small fw-black uppercase tracking-widest text-primary mb-2 d-block">Email
                                        Address</label>
                                    <div class="input-wrapper-glass">
                                        <i class="bi bi-envelope ms-3 text-muted"></i>
                                        <input type="email" name="email" class="form-control-minimal"
                                            placeholder="Email Address"
                                            value="{{ Auth::check() ? Auth::user()->email : '' }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 slide-in-bottom" style="animation-delay: 0.25s">
                                <div class="premium-field">
                                    <label
                                        class="small fw-black uppercase tracking-widest text-primary mb-2 d-block">Your
                                        Message</label>
                                    <div class="input-wrapper-glass align-items-start pt-2">
                                        <i class="bi bi-chat-left-dots ms-3 text-muted mt-2"></i>
                                        <textarea name="message" class="form-control-minimal" rows="2"
                                            placeholder="How can we help?" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 slide-in-bottom" style="animation-delay: 0.3s">
                                <div class="premium-field">
                                    <label
                                        class="small fw-black uppercase tracking-widest text-success mb-2 d-block">Suggestions
                                        (Optional)</label>
                                    <div
                                        class="input-wrapper-glass align-items-start pt-2 border-success border-opacity-10">
                                        <i class="bi bi-stars ms-3 text-success opacity-50 mt-2"></i>
                                        <textarea name="suggestion" class="form-control-minimal" rows="2"
                                            placeholder="Any feedback for us?"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3 slide-in-bottom" style="animation-delay: 0.35s">
                                <button type="submit"
                                    class="btn-transmit shadow-premium w-100 py-3 rounded-pill fw-black uppercase tracking-widest overflow-hidden position-relative">
                                    <span
                                        class="btn-label position-relative z-1 d-flex align-items-center justify-content-center gap-3">
                                        Send Message <i class="bi bi-send-fill"></i>
                                    </span>
                                    <div class="btn-shimmer"></div>
                                </button>
                                <p
                                    class="xx-small text-center text-muted fw-bold uppercase tracking-widest mt-2 opacity-50 mb-0">
                                    Direct support guaranteed</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification Logic -->
    <script>
        function showToast(title, message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            if (!toastContainer) {
                document.body.insertAdjacentHTML('beforeend', '<div id="toastContainer" class="position-fixed top-0 end-0 p-3 mt-5" style="z-index: 9999;"></div>');
            }
            const toastId = 'toast' + Date.now();

            // Map types to classes
            const typeClasses = {
                'success': 'glass-toast-success',
                'danger': 'glass-toast-error',
                'error': 'glass-toast-error',
                'warning': 'glass-toast-warning',
                'info': 'glass-toast-info'
            };
            const currentClass = typeClasses[type] || 'glass-toast-primary';

            const toastHtml = `
                <div id="${toastId}" class="toast premium-glass-toast ${currentClass} border-0 shadow-lg mb-3 overflow-hidden position-relative animate-toast-in" role="alert" aria-live="assertive" aria-atomic="true" style="border-radius: 20px !important;">
                    <div class="toast-shimmer"></div>
                    <div class="d-flex p-3 align-items-center position-relative z-1">
                        <div class="toast-icon-wrapper me-3">
                            <i class="bi ${type == 'success' ? 'bi-check-circle-fill' : (type == 'danger' || type == 'error' ? 'bi-exclamation-triangle-fill' : 'bi-info-circle-fill')} fs-4"></i>
                        </div>
                        <div class="toast-body p-0 flex-grow-1">
                            <strong class="d-block mb-0 text-white" style="font-size: 0.95rem; font-family: 'Outfit', sans-serif;">${title}</strong>
                            <span class="x-small text-white opacity-90 fw-medium">${message}</span>
                        </div>
                        <button type="button" class="btn-close-white btn-close ms-2 shadow-none opacity-75 hover-opacity-100" data-bs-dismiss="toast" aria-label="Close" style="font-size: 0.65rem;"></button>
                    </div>
                    <div class="toast-progress-bar"></div>
                </div>
            `;

            document.getElementById('toastContainer').insertAdjacentHTML('beforeend', toastHtml);
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, { autohide: true, delay: 5000 });
            toast.show();

            toastElement.addEventListener('hidden.bs.toast', () => toastElement.remove());
        }

        // Global Session Listeners
        window.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                showToast('Success!', "{{ session('success') }}", 'success');
            @endif
            @if(session('error'))
                showToast('Error!', "{{ session('error') }}", 'danger');
            @endif
            @if(session('info'))
                showToast('Information', "{{ session('info') }}", 'info');
            @endif
            @if(session('status'))
                showToast('Status', "{{ session('status') }}", 'primary');
            @endif
        });

        document.getElementById('supportForm')?.addEventListener('submit', async function (e) {
            e.preventDefault();
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.classList.add('transmitting');
            submitBtn.querySelector('.btn-label').innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Sending...';

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    showToast('Message Sent!', data.success, 'success');
                    bootstrap.Modal.getInstance(document.getElementById('supportFeedbackModal')).hide();
                    form.reset();
                    // Auto-refresh after a short delay to clear backdrop and update UI
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else if (data.errors) {
                    const errorMsg = Object.values(data.errors).flat().join('<br>');
                    showToast('Error', errorMsg, 'danger');
                } else {
                    showToast('Error!', 'An unexpected error occurred. Please try again.', 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Network Error!', 'Please check your connection.', 'danger');
            } finally {
                submitBtn.disabled = false;
                submitBtn.classList.remove('transmitting');
                submitBtn.querySelector('.btn-label').innerHTML = `Send Message <i class="bi bi-send-fill"></i>`;
            }
        });
    </script>
    @stack('modals')
    @stack('scripts')

    <style>
        /* Acura / Premium Modal Enhancements */
        .modal-content {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
        }

        .input-wrapper-glass {
            background: #f8f9fa;
            border: 1px solid #eef0f2;
            border-radius: 16px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .input-wrapper-glass:focus-within {
            background: #fff;
            border-color: var(--bs-primary);
            box-shadow: 0 0 20px rgba(var(--bs-primary-rgb), 0.08);
            transform: translateY(-1px);
        }

        .form-control-minimal {
            border: none;
            background: transparent;
            padding: 14px 15px;
            width: 100%;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1a1a1a;
            outline: none !important;
        }

        .form-control-minimal::placeholder {
            color: #adb5bd;
            font-weight: 500;
        }

        .icon-pulse-wrapper {
            position: relative;
        }

        .pulse-ring-sm {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid var(--bs-primary);
            animation: ripple-sm 2s infinite;
            top: 0;
            left: 0;
            opacity: 0;
        }

        @keyframes ripple-sm {
            0% {
                transform: scale(0.9);
                opacity: 0.7;
            }

            100% {
                transform: scale(1.6);
                opacity: 0;
            }
        }

        .btn-close-premium {
            position: absolute;
            top: 0;
            right: 0;
            background: #f8f9fa;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #adb5bd;
            transition: all 0.3s ease;
        }

        .btn-close-premium:hover {
            background: #fee;
            color: #f55;
            transform: rotate(90deg);
        }

        .btn-transmit {
            background: linear-gradient(135deg, #FF7A18 0%, #f2701a 100%);
            color: #fff;
            border: none;
            transition: all 0.4s ease;
        }

        .btn-transmit:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(242, 112, 26, 0.4);
            filter: brightness(1.1);
        }

        .btn-transmit:active {
            transform: translateY(-1px);
        }

        .btn-shimmer {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        .slide-in-bottom {
            opacity: 0;
            transform: translateY(20px);
            animation: slideInUp 0.6s ease forwards;
        }

        @keyframes slideInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .premium-glass-toast {
            backdrop-filter: blur(20px) saturate(200%);
            -webkit-backdrop-filter: blur(20px) saturate(200%);
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 18px !important;
            min-width: 300px;
            transition: all 0.4s ease-in-out;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.35) !important;
            color: #fff;
        }

        /* ✅ SUCCESS – Soft Green Glow */
        .glass-toast-success {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.25), rgba(16, 185, 129, 0.2)) !important;
            border-color: rgba(34, 197, 94, 0.5) !important;
            box-shadow: 0 0 25px rgba(34, 197, 94, 0.35) !important;
        }

        /* ❌ ERROR – Smooth Red Glow */
        .glass-toast-error {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.25), rgba(220, 38, 38, 0.2)) !important;
            border-color: rgba(239, 68, 68, 0.5) !important;
            box-shadow: 0 0 25px rgba(239, 68, 68, 0.35) !important;
        }

        /* 🔵 PRIMARY – Elegant Blue Glow */
        .glass-toast-primary {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(37, 99, 235, 0.2)) !important;
            border-color: rgba(59, 130, 246, 0.5) !important;
            box-shadow: 0 0 25px rgba(59, 130, 246, 0.35) !important;
        }

        /* 🟡 WARNING – Premium Amber Glow */
        .glass-toast-warning {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.25), rgba(245, 158, 11, 0.2)) !important;
            border-color: rgba(251, 191, 36, 0.5) !important;
            box-shadow: 0 0 25px rgba(251, 191, 36, 0.35) !important;
        }

        .toast-progress-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 100%;
            background: rgba(255, 255, 255, 0.3);
            transform-origin: left;
            animation: toast-progress 5s linear forwards;
        }

        @keyframes toast-progress {
            from {
                transform: scaleX(1);
            }

            to {
                transform: scaleX(0);
            }
        }

        /* Global Layout Stabilization & Overflow Fix */
        html,
        body {
            width: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            position: relative;
            max-width: 100%;
        }

        .main-header {
            width: 100% !important;
        }

        /* Header Responsiveness & Premium Polish */
        @media (max-width: 991px) {
            .main-header {
                padding: 8px 0 !important;
            }

            .logo-image {
                height: 50px !important;
            }

            .header-icons .icon-link {
                padding: 6px !important;
            }

            .header-icons .bi {
                font-size: 1.4rem !important;
            }

            .badge-count {
                font-size: 0.6rem !important;
                min-width: 18px !important;
                padding: 1px 5px !important;
            }
        }

        @media (max-width: 576px) {
            .logo-image {
                height: 42px !important;
            }

            .header-icons {
                gap: 1.5rem !important;
            }
        }

        .main-header.sticky {
            background: rgba(17, 24, 39, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
        }


        .animate-toast-in {
            animation: toastIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes toastIn {
            from {
                transform: translateX(100%) scale(0.9);
                opacity: 0;
            }

            to {
                transform: translateX(0) scale(1);
                opacity: 1;
            }
        }

        .toast-shimmer {
            position: absolute;
            top: 0;
            left: -150%;
            width: 200%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: skewX(-20deg);
            animation: toast-shimmer 4s infinite linear;
        }

        @keyframes toast-shimmer {
            0% {
                left: -150%;
            }

            100% {
                left: 150%;
            }
        }

        .toast-icon-wrapper {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.1);
        }

        .toast.showing {
            transform: translateX(0) scale(1);
            opacity: 1;
        }

        .toast.hide {
            transform: translateX(40px) scale(0.8);
            opacity: 0;
        }

        .hover-opacity-100:hover {
            opacity: 1 !important;
        }

        <style>@keyframes pincode-pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(242, 112, 26, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(242, 112, 26, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(242, 112, 26, 0);
            }
        }

        .loading-pincode {
            animation: pincode-pulse 1.5s infinite;
            border-color: #f2701a !important;
        }
    </style>

    <script>
        /**
         * Pincode Auto-fetch Logic
         * Detects 6-digit pincode input and fetches City/State from data.postalpincode.in
         */
        document.addEventListener('input', function (e) {
            if (e.target.matches('input[name="pincode"], input[id*="pincode"], input[id*="Pincode"]')) {
                const pincode = e.target.value.trim();
                if (pincode.length === 6 && /^\d{6}$/.test(pincode)) {
                    const field = e.target;
                    const container = field.closest('form') || field.closest('.modal-content') || field.closest('.modal-body') || document;

                    // Add loading state
                    field.classList.add('loading-pincode');

                    fetch(`https://api.postalpincode.in/pincode/${pincode}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data && data[0] && data[0].Status === 'Success') {
                                const postOfficeList = data[0].PostOffice;
                                if (postOfficeList && postOfficeList.length > 0) {
                                    const details = postOfficeList[0];
                                    const city = details.District;
                                    const state = details.State;
                                    const landmarkSug = details.Name;

                                    // Find target fields in the same container
                                    const cityField = container.querySelector('input[name="city"], input[id*="city"], input[id*="City"]');
                                    const stateField = container.querySelector('input[name="state"], input[id*="state"], input[id*="State"]');
                                    const landmarkField = container.querySelector('input[name="landmark"], [name="landmark"], input[id*="landmark"], input[id*="Landmark"]');

                                    if (cityField) {
                                        cityField.value = city;
                                        cityField.classList.add('is-valid');
                                        setTimeout(() => cityField.classList.remove('is-valid'), 2000);
                                    }
                                    if (stateField) {
                                        stateField.value = state;
                                        stateField.classList.add('is-valid');
                                        setTimeout(() => stateField.classList.remove('is-valid'), 2000);
                                    }
                                    if (landmarkField && (!landmarkField.value || landmarkField.value.trim() === "")) {
                                        landmarkField.value = landmarkSug;
                                    }

                                    // Visual success
                                    field.style.borderColor = '#22c55e';
                                    setTimeout(() => field.style.borderColor = '', 3000);
                                }
                            } else {
                                // Invalid pincode or API error
                                field.style.borderColor = '#ef4444';
                            }
                        })
                        .catch(err => {
                            console.error('Pincode API Error:', err);
                            field.style.borderColor = '#ef4444';
                        })
                        .finally(() => {
                            field.classList.remove('loading-pincode');
                        });
                }
            }
        });
    </script>
    <!-- Floating Contact Icons -->
    <div class="floating-contact-container">
        <a href="https://wa.me/918800123456" class="floating-btn whatsapp-btn shadow-lg" target="_blank"
            title="Chat on WhatsApp">
            <i class="bi bi-whatsapp"></i>
        </a>
        <a href="tel:+918800123456" class="floating-btn phone-btn shadow-lg" title="Call Us">
            <i class="bi bi-telephone-fill"></i>
        </a>
    </div>

    <style>
        .floating-contact-container {
            position: fixed;
            left: 30px;
            bottom: 30px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            z-index: 1050;
        }

        .floating-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.6rem;
            text-decoration: none !important;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .whatsapp-btn {
            background-color: #25D366;
            border: 2px solid #fff;
        }

        .phone-btn {
            background-color: var(--primary);
            border: 2px solid #fff;
        }

        .floating-btn:hover {
            transform: scale(1.1) translateY(-5px);
            color: #fff;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3) !important;
        }

        @media (max-width: 768px) {
            .floating-contact-container {
                left: 15px;
                bottom: 15px;
                gap: 10px;
            }

            .floating-btn {
                width: 42px;
                height: 42px;
                font-size: 1.35rem;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    @stack('modals')
    @stack('scripts')
</body>

</html>