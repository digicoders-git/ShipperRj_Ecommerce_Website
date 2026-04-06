@extends('layouts.app')

@section('content')
    <style>
        .transition-all {
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .hover-bg-light:hover {
            background-color: #f8f9fa !important;
            transform: translateX(5px);
        }

        .filter-card {
            border-radius: 24px !important;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02) !important;
        }

        .filter-card:hover {
            border-color: var(--primary) !important;
        }

        .cat-link {
            padding: 10px 16px;
            border-radius: 14px;
            color: #6c757d;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .cat-link:hover {
            background: rgba(255, 122, 24, 0.05);
            color: var(--primary);
        }

        .cat-link.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 15px rgba(255, 122, 24, 0.3);
        }

        .cat-link .badge {
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 10px;
        }

        .cat-link.active .badge {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
        }

        /* Range Slider Styling */
        .form-range::-webkit-slider-thumb {
            background: var(--primary);
            border: 3px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-range::-moz-range-thumb {
            background: var(--primary);
            border: 3px solid #fff;
        }

        .price-box {
            background: #F8F9FA;
            border: 1px solid #E9ECEF;
            border-radius: 12px;
            padding: 8px 15px;
            font-weight: 700;
            color: #212529;
            font-size: 0.9rem;
        }

        /* Sorting Bar */
        .shop-bar {
            border-radius: 20px !important;
        }

        .view-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 1px solid #eee;
            color: #6c757d;
        }

        .view-btn.active {
            background: #dee2e6;
            color: #212529;
            border-color: #dee2e6;
        }

        .form-select-premium {
            background-color: #F8F9FA;
            border: none;
            border-radius: 15px;
            padding: 10px 25px;
            font-weight: 600;
            font-size: 0.85rem;
            color: #495057;
            cursor: pointer;
            outline: none;
        }

        @media (max-width: 768px) {
            .page-header-section {
                padding: 2.5rem 0 !important;
            }

            .page-header-container {
                padding: 1rem 0 !important;
            }

            .page-header-section h1 {
                font-size: 1.8rem !important;
                margin-bottom: 0.5rem !important;
            }

            .shop-layout-section {
                padding: 2.5rem 0 !important;
            }
        }
    </style>

    <!-- Page Header -->
    <section class="page-header-section py-5" style="background: linear-gradient(135deg, #F4F7F9 0%, #E9EEF2 100%);">
        <div class="container page-header-container text-center py-4">
            <h1 class="fw-black mb-3">Premium Collection</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"
                            class="text-decoration-none text-secondary">Home</a></li>
                    <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">All Products</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Shop Layout -->
    <section class="shop-layout-section py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Sidebar -->
                <div class="col-lg-3 d-none d-lg-block" style="align-self: flex-start;">
                    <div class="sidebar-wrapper sticky-top"
                        style="top: 90px; z-index: 1; max-height: calc(100vh - 110px); overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none;">
                        <!-- Filter Header -->
                        <div class="d-flex align-items-center justify-content-between mb-4 px-1">
                            <h5 class="fw-black mb-0"><i class="bi bi-funnel-fill me-2 text-primary"></i>Filters</h5>
                            <a href="{{ url('/products') }}"
                                class="text-secondary small text-decoration-none bg-white shadow-sm border px-3 py-1 rounded-pill hover-bg-light transition-all">Clear
                                All</a>
                        </div>

                        <!-- Categories -->
                        <div class="bg-white p-4 mb-4 filter-card transition-all">
                            <h6 class="fw-bold mb-4 text-dark d-flex align-items-center"><i
                                    class="bi bi-ui-radios-grid me-2 text-primary"></i> Categories</h6>
                            <div class="d-flex flex-column gap-2">
                                <a href="{{ url('/products') }}"
                                    class="cat-link {{ !request('category') ? 'active' : '' }}">
                                    <span>All Categories</span>
                                    <span class="badge bg-light text-secondary">All</span>
                                </a>
                                @foreach($categories as $cat)
                                    <a href="{{ url('/products?category=' . $cat->id . '&sort=' . request('sort') . '&search=' . request('search')) }}"
                                        class="cat-link {{ request('category') == $cat->id ? 'active' : '' }}">
                                        <span>{{ $cat->name }}</span>
                                        <span
                                            class="badge {{ request('category') == $cat->id ? 'bg-white text-primary' : 'bg-light text-secondary' }} border">
                                            {{ $cat->products_count }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div class="bg-white p-4 mb-4 filter-card transition-all">
                            <h6 class="fw-bold mb-4 text-dark d-flex align-items-center"><i
                                    class="bi bi-cash-stack me-2 text-primary"></i> Price Range</h6>
                            <form action="{{ url('/products') }}" method="GET" id="priceFilterForm">
                                @if(request('category')) <input type="hidden" name="category"
                                value="{{ request('category') }}"> @endif
                                @if(request('sub_category')) <input type="hidden" name="sub_category"
                                value="{{ request('sub_category') }}"> @endif
                                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                                @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif

                                <div class="px-2 mt-2">
                                    <input type="range" class="form-range" name="max_price" min="0" max="100000" step="500"
                                        value="{{ request('max_price', 100000) }}" id="priceRange"
                                        oninput="updatePriceLabel(this.value)">
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="price-box">₹0</div>
                                        <div class="price-box" id="priceLabel">
                                            ₹{{ number_format(request('max_price', 100000)) }}+</div>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary w-100 mt-4 rounded-pill fw-bold shadow-sm py-2">Apply
                                        Filter</button>
                                </div>
                            </form>
                        </div>

                        <!-- Filter by Rating -->
                        <div class="bg-white p-4 mb-4 filter-card transition-all">
                            <h6 class="fw-bold mb-4 text-dark d-flex align-items-center"><i
                                    class="bi bi-star-half me-2 text-primary"></i> Customer Rating</h6>
                            <div class="d-flex flex-column gap-3 mt-2">
                                @for($r = 4; $r >= 3; $r--)
                                    <div class="form-check d-flex align-items-center gap-2 m-0 p-0 ps-4">
                                        <input class="form-check-input mt-0 shadow-sm border-2 border-secondary" type="checkbox"
                                            id="r{{ $r }}" style="width: 22px; height: 22px;" {{ $r == 4 ? 'checked' : '' }}>
                                        <label
                                            class="form-check-label w-100 d-flex justify-content-between align-items-center ms-2"
                                            for="r{{ $r }}" style="cursor: pointer;">
                                            <span class="text-warning small fs-6">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="bi bi-star{{ $i <= $r ? '-fill' : '' }} {{ $i > $r ? 'text-light' : '' }}"></i>
                                                @endfor
                                            </span>
                                            <span class="text-secondary small fw-medium">& up</span>
                                        </label>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Promo Banner -->
                        <div class="promo-banner rounded-4 overflow-hidden shadow-premium position-relative border mt-2">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=500&auto=format&fit=crop"
                                class="img-fluid" alt="Promo">
                            <div
                                class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-40 d-flex flex-column justify-content-end p-4 text-white">
                                <h5 class="fw-bold mb-1">Weekly Deals</h5>
                                <p class="small mb-2">Save up to 40%</p>
                                <a href="#" class="btn btn-premium btn-sm w-fit-content px-3">Explore</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Shop Content -->
                <div class="col-lg-9">

                    <!-- Sorting Bar -->
                    <div
                        class="shop-bar d-flex flex-wrap justify-content-between align-items-center mb-5 bg-white p-3 border">
                        <div class="mb-2 mb-md-0 ps-2">
                            <span class="text-secondary small">Showing <span
                                    class="fw-bold text-dark">{{ $products->count() }}</span> of <span
                                    class="fw-bold text-dark">{{ $products->total() }}</span> Products</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-none d-md-flex align-items-center gap-2">
                                <button class="view-btn active"><i class="bi bi-grid-3x3-gap"></i></button>
                                <button class="view-btn"><i class="bi bi-list"></i></button>
                            </div>
                            <form action="{{ url('/products') }}" method="GET" id="sortForm">
                                @if(request('category')) <input type="hidden" name="category"
                                value="{{ request('category') }}"> @endif
                                @if(request('sub_category')) <input type="hidden" name="sub_category"
                                value="{{ request('sub_category') }}"> @endif
                                @if(request('max_price')) <input type="hidden" name="max_price"
                                value="{{ request('max_price') }}"> @endif
                                @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                <select name="sort" class="form-select-premium"
                                    onchange="document.getElementById('sortForm').submit()">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals
                                    </option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price:
                                        Low to High</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price:
                                        High to Low</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="row g-4">
                        @forelse ($products as $i => $prod)
                            <div class="col-md-6 col-xl-4 fade-in-up" style="animation-delay: {{ ($i % 12) * 0.05 }}s;">
                                <div class="product-card h-100 p-2">
                                    <div class="product-image-wrapper">
                                        @if($prod->mrp > $prod->selling_price)
                                            <span class="product-card-badge bg-primary text-white">SALE</span>
                                        @else
                                            <span class="product-card-badge bg-dark text-white">NEW</span>
                                        @endif

                                        <div class="product-actions-floating">
                                            <form action="{{ route('wishlist.add', $prod->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="action-btn border-0 shadow-sm" title="Wishlist"><i
                                                        class="bi bi-heart"></i></button>
                                            </form>
                                            <button type="button" class="action-btn border-0 shadow-sm" title="Quick View"
                                                onclick="openQuickView('{{ $prod->id }}')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>

                                        <a href="{{ url('/product-detail/' . $prod->slug) }}" class="w-100 h-100">
                                            <img src="{{ asset($prod->image) }}" alt="{{ $prod->name }}"
                                                onerror="this.src='https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=400'">
                                        </a>
                                    </div>
                                    <div class="p-3">
                                        <div class="mb-1 text-start">
                                            <span
                                                class="text-secondary xx-small fw-black uppercase tracking-widest">{{ $prod->subCategory->name ?? 'Category' }}</span>
                                        </div>
                                        <h6 class="fw-bold mb-2 text-truncate text-start">
                                            <a href="{{ url('/product-detail/' . $prod->slug) }}"
                                                class="text-dark text-decoration-none"
                                                style="font-size: 0.95rem;">{{ $prod->name }}</a>
                                        </h6>
                                        <div class="price-wrapper d-flex align-items-center gap-2 mb-3">
                                            <span
                                                class="h5 fw-black text-primary mb-0">₹{{ number_format($prod->selling_price) }}</span>
                                            @if($prod->mrp > $prod->selling_price)
                                                <span
                                                    class="text-secondary small text-decoration-line-through">₹{{ number_format($prod->mrp) }}</span>
                                            @endif
                                        </div>
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('cart.add', $prod->id) }}" method="POST" class="flex-grow-1">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-dark w-100 py-2 fw-black uppercase xx-small tracking-widest rounded-3 shadow-sm hover-float">
                                                    Cart
                                                </button>
                                            </form>
                                            <a href="{{ url('/product-detail/' . $prod->slug) }}"
                                                class="btn btn-primary bg-gradient-primary flex-grow-1 py-2 fw-black uppercase xx-small tracking-widest rounded-3 shadow-sm hover-float d-flex align-items-center justify-content-center text-white text-decoration-none">
                                                Buy Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 py-5 text-center">
                                <i class="bi bi-box-seam fs-1 text-secondary mb-3 opacity-50"></i>
                                <h4 class="fw-bold text-dark">No Products Found</h4>
                                <p class="text-secondary small">Try adjusting your filters to find what you're looking for.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-5 d-flex justify-content-center">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <script>
        function updatePriceLabel(val) {
            document.getElementById('priceLabel').innerHTML = '₹' + parseInt(val).toLocaleString() + '+';
        }
    </script>
@endsection