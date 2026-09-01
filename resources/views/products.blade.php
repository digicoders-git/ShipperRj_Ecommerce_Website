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
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="sidebar-wrapper sticky-top"
                        style="position: -webkit-sticky; position: sticky; top: 120px; z-index: 90; max-height: calc(100vh - 160px); overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none;">
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
                            <img src="{{ asset('images/photo1.jpg') }}" class="img-fluid" alt="Promo">
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

                    @if(isset($categoryOffer) && $categoryOffer && $categoryOffer->isLive())
                        <!-- Category Wise Live Offer Banner & Countdown -->
                        <div class="category-offer-banner mb-4 p-3 p-md-4 rounded-4 position-relative overflow-hidden shadow-sm"
                            style="background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 50%, #fef3c7 100%); border: 1.5px solid rgba(249, 115, 22, 0.25);">
                            <div class="row align-items-center g-3">
                                @if($categoryOffer->image)
                                    <div class="col-12 col-md-4 col-lg-3 text-center">
                                        <div class="offer-img-wrapper rounded-3 overflow-hidden shadow-sm border" style="aspect-ratio: 16 / 9; width: 100%;">
                                            <img src="{{ asset($categoryOffer->image) }}" alt="{{ $categoryOffer->offer_name }}"
                                                class="w-100 h-100 object-fit-cover">
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12 {{ $categoryOffer->image ? 'col-md-5 col-lg-5' : 'col-md-7 col-lg-7' }} text-start">
                                    <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                        <span class="badge bg-danger text-white px-3 py-1.5 uppercase tracking-wider xx-small fw-bold rounded-pill shadow-sm">
                                            <i class="bi bi-lightning-charge-fill me-1"></i> {{ $categoryOffer->offer_type ?: 'Flash Sale' }}
                                        </span>
                                        <span class="badge bg-warning text-dark px-3 py-1.5 fw-black xx-small rounded-pill shadow-sm">
                                            <i class="bi bi-tag-fill me-1"></i>
                                            @if($categoryOffer->discount_type === 'fixed')
                                                ₹{{ (float)$categoryOffer->discount_value == (int)$categoryOffer->discount_value ? number_format($categoryOffer->discount_value) : number_format($categoryOffer->discount_value, 2) }} OFF
                                            @else
                                                {{ (float) $categoryOffer->discount_value }}% OFF
                                            @endif
                                        </span>
                                    </div>
                                    <h3 class="fw-black mb-1 text-dark fs-4 fs-lg-3">{{ $categoryOffer->offer_name }}</h3>
                                    <p class="text-secondary small mb-0">Live offer automatically applied to all <strong class="text-dark">{{ $selectedCategory->name ?? 'Category' }}</strong> products!</p>
                                </div>

                                <div class="col-12 {{ $categoryOffer->image ? 'col-md-4 col-lg-4' : 'col-md-5 col-lg-5' }} d-flex justify-content-center justify-content-md-end">
                                    <div class="bg-white p-3 rounded-4 border border-warning border-opacity-40 shadow-sm w-100" style="max-width: 320px;">
                                        <div class="text-danger xx-small uppercase fw-black tracking-widest text-center mb-1">
                                            <i class="bi bi-clock-history me-1 text-danger"></i> OFFER ENDS IN
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center gap-2" id="categoryLiveCountdown" data-end="{{ $categoryOffer->end_date->timestamp * 1000 }}">
                                            <div class="text-center px-1"><span class="h4 fw-black text-dark mb-0 d-block" id="timer-days">00</span><div class="xx-small text-muted fw-bold">Days</div></div>
                                            <span class="h4 text-danger mb-3">:</span>
                                            <div class="text-center px-1"><span class="h4 fw-black text-dark mb-0 d-block" id="timer-hours">00</span><div class="xx-small text-muted fw-bold">Hours</div></div>
                                            <span class="h4 text-danger mb-3">:</span>
                                            <div class="text-center px-1"><span class="h4 fw-black text-dark mb-0 d-block" id="timer-mins">00</span><div class="xx-small text-muted fw-bold">Mins</div></div>
                                            <span class="h4 text-danger mb-3">:</span>
                                            <div class="text-center px-1"><span class="h4 fw-black text-danger mb-0 d-block" id="timer-secs">00</span><div class="xx-small text-muted fw-bold">Secs</div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

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
                            @php
                                $catOffer = $prod->getActiveCategoryOffer();
                                $effectivePrice = $prod->getEffectivePrice();
                                $originalPrice = (float) $prod->selling_price;
                                $hasCategoryOffer = ($catOffer && $catOffer->isLive() && $effectivePrice < $originalPrice);
                            @endphp
                            <div class="col-md-6 col-xl-4 fade-in-up" style="animation-delay: {{ ($i % 12) * 0.05 }}s;">
                                        <div class="product-card h-100 p-2">
                                            <div class="product-image-wrapper">
                                                @if($hasCategoryOffer)
                                                    <span class="product-card-badge bg-danger text-white fw-bold">
                                                        @if($catOffer->discount_type === 'fixed')
                                                            ₹{{ (int) $catOffer->discount_value }} OFF
                                                        @else
                                                            {{ (int) $catOffer->discount_value }}% OFF
                                                        @endif
                                                    </span>
                                                @elseif($prod->mrp > $prod->selling_price)
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
                                                        onerror="this.src='{{ asset('images/placeholder.svg') }}'">
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
                                                <div class="price-wrapper d-flex align-items-baseline flex-wrap gap-1 mb-3">
                                                    @if($hasCategoryOffer)
                                                        <span class="h5 fw-black text-danger mb-0">₹{{ (float)$effectivePrice == (int)$effectivePrice ? number_format($effectivePrice) : number_format($effectivePrice, 2) }}</span>
                                                        <span class="text-secondary small text-decoration-line-through me-1">₹{{ (float)$originalPrice == (int)$originalPrice ? number_format($originalPrice) : number_format($originalPrice, 2) }}</span>
                                                        @if($prod->mrp > $originalPrice)
                                                            <span class="text-secondary xx-small text-decoration-line-through">(MRP ₹{{ number_format($prod->mrp) }})</span>
                                                        @endif
                                                    @else
                                                        <span class="h5 fw-black text-primary mb-0">₹{{ (float)$prod->selling_price == (int)$prod->selling_price ? number_format($prod->selling_price) : number_format($prod->selling_price, 2) }}</span>
                                                        @if($prod->mrp > $prod->selling_price)
                                                            <span
                                                                class="text-secondary small text-decoration-line-through">₹{{ number_format($prod->mrp) }}</span>
                                                        @endif
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
            // Live Category Offer Countdown Timer
            document.addEventListener('DOMContentLoaded', function() {
                const timerElem = document.getElementById('categoryLiveCountdown');
                if (!timerElem) return;

                const endVal = timerElem.getAttribute('data-end');
                if (!endVal) return;
                const endDate = parseInt(endVal);
                if (isNaN(endDate)) return;

                function updateCountdown() {
                    const now = new Date().getTime();
                    const distance = endDate - now;

                    const daysEl = document.getElementById('timer-days');
                    const hoursEl = document.getElementById('timer-hours');
                    const minsEl = document.getElementById('timer-mins');
                    const secsEl = document.getElementById('timer-secs');

                    if (distance <= 0) {
                        if (daysEl) daysEl.innerText = '00';
                        if (hoursEl) hoursEl.innerText = '00';
                        if (minsEl) minsEl.innerText = '00';
                        if (secsEl) secsEl.innerText = '00';
                        timerElem.innerHTML = '<span class="badge bg-danger fs-6 py-2 px-3 fw-bold">OFFER EXPIRED</span>';
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    if (daysEl) daysEl.innerText = String(days).padStart(2, '0');
                    if (hoursEl) hoursEl.innerText = String(hours).padStart(2, '0');
                    if (minsEl) minsEl.innerText = String(minutes).padStart(2, '0');
                    if (secsEl) secsEl.innerText = String(seconds).padStart(2, '0');
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            });

            function updatePriceLabel(val) {
                document.getElementById('priceLabel').innerHTML = '₹' + parseInt(val).toLocaleString() + '+';
            }

            // Sticky parent self-healing debugger & auto-fixer for Product Filters Sidebar
            document.addEventListener('DOMContentLoaded', () => {
                const stickyEl = document.querySelector('.sidebar-wrapper');
                if (stickyEl) {
                    let parent = stickyEl.parentElement;
                    while (parent && parent !== document.documentElement) {
                        const style = window.getComputedStyle(parent);
                        const overflowX = style.getPropertyValue('overflow-x');
                        const overflowY = style.getPropertyValue('overflow-y');
                        const overflow = style.getPropertyValue('overflow');

                        if (
                            (overflowX !== 'visible' && overflowX !== 'clip') ||
                            (overflowY !== 'visible' && overflowY !== 'clip') ||
                            (overflow !== 'visible' && overflow !== 'clip')
                        ) {
                            console.log('Fixed sticky-breaking ancestor in products:', parent.tagName, parent.className);
                            if (parent.tagName === 'BODY' || parent.tagName === 'HTML') {
                                parent.style.overflowX = 'clip';
                            } else {
                                parent.style.overflow = 'visible';
                            }
                        }
                        parent = parent.parentElement;
                    }
                }
            });
        </script>
@endsection