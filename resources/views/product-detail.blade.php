@extends('layouts.app')

@push('styles')
    <style>
        :root {
            --premium-gradient: linear-gradient(135deg, #f2701a 0%, #e96715 100%);
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.3);
            --soft-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --premium-shadow: 0 20px 40px rgba(242, 112, 26, 0.15);
        }

        .product-breadcrumb {
            background: #fdfdfd;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "\F285";
            font-family: "bootstrap-icons";
            font-size: 0.6rem;
            opacity: 0.3;
        }

        /* Gallery Styles */
        .product-gallery-container {
            position: sticky;
            top: 100px;
        }

        .main-image-wrapper {
            background: #f8f9fa;
            border-radius: 30px;
            padding: 40px;
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 1px solid rgba(0, 0, 0, 0.02);
            cursor: zoom-in;
            overflow: hidden;
        }

        .main-image-wrapper:hover {
            transform: translateY(-5px);
            box-shadow: var(--soft-shadow);
            border-color: rgba(242, 112, 26, 0.1);
        }

        .main-image-wrapper img {
            transition: transform 0.5s ease;
        }

        .main-image-wrapper:hover img {
            transform: scale(1.05);
        }

        .thumb-btn {
            width: 80px;
            height: 80px;
            border-radius: 18px;
            padding: 5px;
            border: 2px solid transparent;
            background: #fff;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
        }

        .thumb-btn.active {
            border-color: #f2701a;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(242, 112, 26, 0.15);
        }

        /* Info Styles */
        .product-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            letter-spacing: -1.5px;
            line-height: 1.1;
            color: #1a1a1a;
        }

        .price-display {
            background: linear-gradient(to right, #fdfdfd, #fff);
            padding: 25px;
            border-radius: 24px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            margin: 30px 0;
            position: relative;
            overflow: hidden;
        }

        .price-display::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(242, 112, 26, 0.05) 0%, transparent 70%);
            z-index: 0;
        }

        .sell-price {
            font-size: 2.8rem;
            font-weight: 800;
            color: #f2701a;
            margin-bottom: 0;
        }

        .mrp-price {
            font-size: 1.2rem;
            color: #999;
            text-decoration: line-through;
            font-weight: 500;
        }

        .save-badge {
            background: #e6f4ea;
            color: #1e7e34;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Action Buttons */
        .qty-picker {
            background: #f1f3f5;
            border-radius: 50px;
            padding: 5px;
            display: flex;
            align-items: center;
            max-width: 130px;
        }

        .qty-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: #fff;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .qty-btn:hover {
            background: #f2701a;
            color: #fff;
        }

        .btn-cart-premium {
            background: #fff;
            border: 2px solid #f2701a;
            color: #f2701a;
            padding: 16px 30px;
            border-radius: 50px;
            font-weight: 800;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .btn-cart-premium:hover {
            background: rgba(242, 112, 26, 0.03);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(242, 112, 26, 0.1);
        }

        .btn-buy-premium {
            background: var(--premium-gradient);
            border: none;
            color: #fff;
            padding: 16px 30px;
            border-radius: 50px;
            font-weight: 800;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 0.9rem;
            box-shadow: var(--premium-shadow);
        }

        .btn-buy-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(242, 112, 26, 0.25);
            color: #fff;
        }

        /* Tabs UI */
        .premium-tabs {
            border-bottom: 2px solid #f1f3f5;
            margin-bottom: 50px;
            display: flex;
            gap: 40px;
            overflow-x: auto;
            padding-bottom: 2px;
        }

        .tab-link {
            color: #888;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding-bottom: 15px;
            position: relative;
            white-space: nowrap;
            transition: all 0.3s ease;
        }

        .tab-link:hover {
            color: #333;
        }

        .tab-link.active {
            color: #f2701a;
        }

        .tab-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #f2701a;
            box-shadow: 0 2px 10px rgba(242, 112, 26, 0.3);
        }

        /* Feature Cards */
        .feature-card {
            padding: 20px;
            border-radius: 20px;
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            background: #fafafa;
            border-color: rgba(242, 112, 26, 0.1);
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 45px;
            height: 45px;
            background: rgba(242, 112, 26, 0.1);
            color: #f2701a;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 15px;
        }

        /* Review Card */
        .review-item {
            background: #fff;
            border-radius: 24px;
            padding: 30px;
            border: 1px solid rgba(0, 0, 0, 0.03);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .review-item:hover {
            box-shadow: var(--soft-shadow);
        }

        .review-avatar {
            width: 50px;
            height: 50px;
            background: #f8f9fa;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #f2701a;
            border: 1px solid rgba(242, 112, 26, 0.1);
        }

        /* Floating Side Bar */
        .seller-box {
            background: #1a1a1a;
            border-radius: 30px;
            padding: 35px;
            color: #fff;
            position: sticky;
            top: 100px;
        }

        .seller-label {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: block;
            margin-bottom: 15px;
        }

        /* Related Products */
        .related-card {
            background: #fff;
            border-radius: 20px;
            padding: 15px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .related-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--soft-shadow);
            border-color: rgba(242, 112, 26, 0.1);
        }

        .related-img-box {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 200px;
        }

        /* Mobile Sticky Bar */
        @media (max-width: 768px) {
            .mobile-action-bar {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                padding: 15px 20px;
                box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.08);
                z-index: 1000;
                display: flex;
                gap: 10px;
                border-top: 1px solid rgba(0, 0, 0, 0.05);
            }

            .main-image-wrapper {
                padding: 20px;
                border-radius: 20px;
            }

            .product-title {
                font-size: 2rem;
            }

            .sell-price {
                font-size: 2.2rem;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Breadcrumb -->
    <div class="product-breadcrumb py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 align-items-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"
                            class="text-decoration-none text-muted small fw-medium">Home</a></li>
                    @if($product->subCategory && $product->subCategory->category)
                        <li class="breadcrumb-item"><a
                                href="{{ url('/products?category=' . $product->subCategory->category->id) }}"
                                class="text-decoration-none text-muted small fw-medium">{{ $product->subCategory->category->name }}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ url('/products?sub_category=' . $product->subCategory->id) }}"
                                class="text-decoration-none text-muted small fw-medium">{{ $product->subCategory->name }}</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active text-dark small fw-bold" aria-current="page">
                        {{ Str::limit($product->name, 30) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Left: Gallery -->
                <div class="col-lg-6">
                    <div class="product-gallery-container animate-fade-in">
                        <div class="main-image-wrapper mb-4">
                            <img id="mainDisplayImage" src="{{ asset($product->image) }}"
                                class="img-fluid w-100 h-100 object-fit-contain" style="max-height: 500px;"
                                alt="{{ $product->name }}">
                        </div>

                        <div class="d-flex flex-wrap gap-3 pb-2" id="galleryThumbs">
                            <div class="thumb-btn active"
                                onclick="updateDisplayImage('{{ asset($product->image) }}', this)">
                                <img src="{{ asset($product->image) }}" class="w-100 h-100 object-fit-cover rounded-3">
                            </div>
                            @foreach($product->images as $img)
                                <div class="thumb-btn" onclick="updateDisplayImage('{{ asset($img->image_path) }}', this)">
                                    <img src="{{ asset($img->image_path) }}" class="w-100 h-100 object-fit-cover rounded-3">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right: Details -->
                <div class="col-lg-6">
                    <div class="product-info-panel ps-lg-4">
                        <!-- Badges -->
                        <div class="d-flex gap-2 mb-3">
                            @if($product->trending)
                                <span
                                    class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 py-2 fw-bold text-uppercase"
                                    style="font-size: 0.65rem;">
                                    <i class="bi bi-fire me-1"></i> Trending
                                </span>
                            @endif
                            @if($product->featured)
                                <span
                                    class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2 fw-bold text-uppercase"
                                    style="font-size: 0.65rem;">
                                    <i class="bi bi-patch-check-fill me-1"></i> Featured
                                </span>
                            @endif
                        </div>

                        <h1 class="product-title mb-2">{{ $product->name }}</h1>

                        <div class="d-flex align-items-center gap-3 mb-4">
                            @php
                                $avgRating = $product->approvedReviews->avg('rating') ?? 5;
                                $reviewCount = $product->approvedReviews->count();
                            @endphp
                            <div class="d-flex align-items-center gap-1 text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= round($avgRating) ? '-fill' : '' }}"></i>
                                @endfor
                            </div>
                            <span class="text-muted small fw-medium">({{ number_format($avgRating, 1) }} /
                                {{ $reviewCount }} Reviews)</span>
                            <div class="vr opacity-10" style="height: 15px;"></div>
                            <span class="text-muted small">SKU: <span
                                    class="text-dark fw-bold">{{ $product->sku }}</span></span>
                        </div>

                        <div class="price-display">
                            <div class="d-flex align-items-baseline gap-3 flex-wrap">
                                <h2 class="sell-price">₹{{ number_format($product->selling_price) }}</h2>
                                @if($product->mrp > $product->selling_price)
                                    <span class="mrp-price">₹{{ number_format($product->mrp) }}</span>
                                    <span class="save-badge">Save
                                        {{ round((($product->mrp - $product->selling_price) / $product->mrp) * 100) }}%
                                        Off</span>
                                @endif
                            </div>
                            <p class="text-muted small mt-2 mb-0">Inclusive of all taxes</p>
                        </div>

                        <!-- Options/Meta -->
                        <div class="row g-4 mb-5">
                            <div class="col-6">
                                <label
                                    class="xx-small text-muted fw-bold uppercase tracking-widest d-block mb-2">Color</label>
                                <span
                                    class="d-inline-flex align-items-center gap-2 px-3 py-2 bg-light rounded-pill small fw-bold">
                                    {{ $product->color ?? 'Standard' }}
                                </span>
                            </div>
                            <div class="col-6">
                                <label
                                    class="xx-small text-muted fw-bold uppercase tracking-widest d-block mb-2">Availability</label>
                                <span
                                    class="d-inline-flex align-items-center gap-2 px-3 py-2 {{ $product->stock > 5 ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} rounded-pill small fw-bold">
                                    <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i>
                                    {{ $product->stock > 0 ? $product->stock . ' In Stock' : 'Out of Stock' }}
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex flex-wrap gap-3 mb-5">
                            <div class="qty-picker">
                                <button class="qty-btn" type="button" onclick="changeQty(-1)"><i
                                        class="bi bi-dash"></i></button>
                                <input type="number" id="productQty"
                                    class="form-control border-0 bg-transparent text-center fw-bold py-0" value="1" min="1"
                                    max="{{ $product->stock }}" style="width: 50px; box-shadow: none;">
                                <button class="qty-btn" type="button" onclick="changeQty(1)"><i
                                        class="bi bi-plus"></i></button>
                            </div>

                            <form action="{{ url('/cart/add/' . $product->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <input type="hidden" name="quantity" value="1" id="cartQtyInput">
                                <button type="submit" class="btn btn-cart-premium w-100">
                                    <i class="bi bi-handbag me-2"></i> Add To Cart
                                </button>
                            </form>

                            <form action="{{ url('/wishlist/add/' . $product->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="btn btn-outline-light border rounded-circle d-flex align-items-center justify-content-center wishlist-hover-premium"
                                    style="width: 58px; height: 58px;">
                                    <i class="bi bi-heart fs-5"></i>
                                </button>
                            </form>
                        </div>

                        <div class="mb-5">
                            <form action="{{ url('/checkout') }}" method="GET">
                                <input type="hidden" name="buy_now" value="{{ $product->id }}">
                                <input type="hidden" name="qty" value="1" id="buyNowQtyInput">
                                <button type="submit" class="btn btn-buy-premium w-100 py-3">
                                    <i class="bi bi-lightning-fill me-2 text-warning"></i> Buy it Now
                                </button>
                            </form>
                        </div>

                        <!-- Trust Bar -->
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="feature-card">
                                    <div class="feature-icon"><i class="bi bi-truck"></i></div>
                                    <h6 class="fw-bold small mb-1">Standard Shipping</h6>
                                    <p class="xx-small text-muted mb-0">Flat rate
                                        ₹{{ number_format($product->shipping_charges) }} across India</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="feature-card">
                                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                                    <h6 class="fw-bold small mb-1">100% Authentic</h6>
                                    <p class="xx-small text-muted mb-0">Direct from Shopping Club India Warehouse</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secondary Info Tabs -->
            <div class="mt-5 pt-lg-5">
                <div class="row g-5">
                    <div class="col-lg-8">
                        <div class="premium-tabs scroll-hide" id="productTabs">
                            <a href="#tab-description" class="tab-link active">Narrative</a>
                            <a href="#tab-specs" class="tab-link">Specifications</a>
                            <a href="#tab-reviews" class="tab-link">Chronicles ({{ $reviewCount }})</a>
                            <a href="#tab-policy" class="tab-link">Logistics</a>
                        </div>

                        <div class="tab-content-container">
                            <div id="tab-description" class="mb-5">
                                <h4 class="fw-bold mb-4">Product Description</h4>
                                <div class="lead text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                            </div>

                            <div id="tab-specs" class="mb-5" style="display: none;">
                                <h4 class="fw-bold mb-4">Technical Details</h4>
                                <div class="table-responsive">
                                    <table class="table table-borderless align-middle">
                                        <tbody class="small">
                                            <tr class="border-bottom">
                                                <td class="text-muted py-3 fw-medium uppercase tracking-wider xx-small"
                                                    style="width: 30%">Manufacturer</td>
                                                <td class="text-dark fw-bold py-3">
                                                    {{ $product->manufacturer ?? 'S.C.I Private Limited' }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-muted py-3 fw-medium uppercase tracking-wider xx-small">
                                                    Weight</td>
                                                <td class="text-dark fw-bold py-3">{{ $product->weight ?? 'N/A' }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-muted py-3 fw-medium uppercase tracking-wider xx-small">
                                                    Dimensions</td>
                                                <td class="text-dark fw-bold py-3">{{ $product->dimensions ?? 'N/A' }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-muted py-3 fw-medium uppercase tracking-wider xx-small">
                                                    Warranty</td>
                                                <td class="text-dark fw-bold py-3">
                                                    {{ $product->warranty ?? '1 Year Manufacturer Warranty' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="tab-reviews" class="mb-5" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="fw-bold mb-0">Customer Stories</h4>
                                    <button
                                        class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-bold xx-small uppercase tracking-widest"
                                        data-bs-toggle="modal" data-bs-target="#reviewModal">
                                        Share Your Story
                                    </button>
                                </div>

                                @forelse($product->approvedReviews as $review)
                                    <div class="review-item">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="review-avatar">
                                                    {{ substr($review->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold">{{ $review->user->name }}</h6>
                                                    <span
                                                        class="xx-small text-muted fw-medium">{{ $review->created_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-1 text-warning small">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-muted mb-0 italic" style="font-size: 0.95rem;">"{{ $review->comment }}"
                                        </p>

                                        @if($review->admin_reply)
                                            <div class="mt-3 p-3 bg-light rounded-4 border-start border-4 border-primary">
                                                <span
                                                    class="xx-small fw-black text-primary uppercase tracking-widest d-block mb-1">Official
                                                    Response</span>
                                                <p class="xx-small text-dark mb-0 fw-medium">{{ $review->admin_reply }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center py-5 bg-light rounded-5 border-dashed border-2">
                                        <i class="bi bi-chat-square-quote display-4 text-muted mb-3 d-block"></i>
                                        <p class="fw-bold text-muted mb-0">Be the first to share your experience!</p>
                                    </div>
                                @endforelse
                            </div>

                            <div id="tab-policy" class="mb-5" style="display: none;">
                                <h4 class="fw-bold mb-4">Logistics & Policy</h4>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="p-4 rounded-4 bg-light border-0">
                                            <h6 class="fw-bold text-primary mb-2 uppercase xx-small tracking-widest">Return
                                                Policy</h6>
                                            <p class="text-muted small mb-0">
                                                {{ $product->return_policy ?? 'Standard 7-day return policy for unused products in original packaging.' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 rounded-4 bg-light border-0">
                                            <h6 class="fw-bold text-success mb-2 uppercase xx-small tracking-widest">
                                                Fulfillment</h6>
                                            <p class="text-muted small mb-0">This product is fulfilled directly by Shopping
                                                Club India with multi-level quality checks.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Box -->
                    <div class="col-lg-4">
                        <div class="seller-box animate-fade-in shadow-premium">
                            <span class="seller-label">Authorized Seller</span>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="rounded-circle bg-white bg-opacity-10 d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px;">
                                    <img src="{{ asset('assets/images/favicon.png') }}" class="img-fluid" width="30">
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold text-white">{{ $product->seller_name ?? 'Shopping Club India' }}
                                    </h5>
                                    <div class="badge bg-success-subtle text-success xx-small fw-bold px-2 py-1 mt-1">
                                        <i class="bi bi-patch-check-fill me-1"></i> Top Rated
                                    </div>
                                </div>
                            </div>

                            <hr class="opacity-10 my-4">

                            <div class="space-y-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <i class="bi bi-lightning text-primary fs-5"></i>
                                    <div>
                                        <span class="d-block small fw-bold text-white">Fast Dispatch</span>
                                        <span class="xx-small text-white-50">Usually ships within 24 hours</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-arrow-repeat text-info fs-5"></i>
                                    <div>
                                        <span class="d-block small fw-bold text-white">Secure Checkout</span>
                                        <span class="xx-small text-white-50">SSL Encrypted Safe Payments</span>
                                    </div>
                                </div>
                            </div>

                            <button
                                class="btn btn-outline-light w-100 py-3 rounded-pill mt-5 fw-bold xx-small uppercase tracking-widest opacity-75">
                                Contact Support
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <section class="py-5 bg-light bg-opacity-50">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div>
                    <span class="xx-small text-primary fw-bold uppercase tracking-widest d-block mb-2">Curated for
                        you</span>
                    <h2 class="fw-bold mb-0" style="letter-spacing: -1.5px;">Recommended <span
                            class="text-primary">Styles</span></h2>
                </div>
                <a href="{{ url('/products?sub_category=' . $product->subcategory_id) }}"
                    class="btn btn-link text-decoration-none text-dark fw-bold small">View All <i
                        class="bi bi-arrow-right ms-1"></i></a>
            </div>

            <div class="row g-4">
                @php
                    $related = \App\Models\Product::where('subcategory_id', $product->subcategory_id)->where('id', '!=', $product->id)->limit(4)->get();
                @endphp
                @forelse($related as $rel)
                    <div class="col-md-3 col-6">
                        <div class="related-card border-0 h-100 d-flex flex-column">
                            <a href="{{ url('product-detail/' . $rel->slug) }}" class="text-decoration-none">
                                <div class="related-img-box">
                                    <img src="{{ asset($rel->image) }}" class="img-fluid object-fit-contain"
                                        style="max-height: 150px;" alt="{{ $rel->name }}">
                                </div>
                                <h6 class="text-dark fw-bold text-truncate mb-1 px-2" title="{{ $rel->name }}">{{ $rel->name }}
                                </h6>
                            </a>
                            <div class="px-2 mt-auto">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="text-primary fw-black">₹{{ number_format($rel->selling_price) }}</span>
                                    @if($rel->mrp > $rel->selling_price)
                                        <span
                                            class="text-muted xx-small text-decoration-line-through">₹{{ number_format($rel->mrp) }}</span>
                                    @endif
                                </div>
                                <form action="{{ route('cart.add', $rel->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-dark w-100 py-2 xx-small fw-bold uppercase tracking-widest rounded-pill">
                                        <i class="bi bi-cart3 me-1"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fw-medium">No related products found in this category.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Mobile Sticky Bar -->
    <div class="mobile-action-bar d-md-none">
        <div class="d-flex gap-2 flex-grow-1">
            <form action="{{ url('/cart/add/' . $product->id) }}" method="POST" class="flex-grow-1">
                @csrf
                <input type="hidden" name="quantity" value="1" class="mob-qty-sync">
                <button type="submit" class="btn btn-cart-premium w-100 py-3 small" style="padding: 12px !important;">
                    Cart
                </button>
            </form>
            <form action="{{ url('/checkout') }}" method="GET" class="flex-grow-1">
                <input type="hidden" name="buy_now" value="{{ $product->id }}">
                <input type="hidden" name="qty" value="1" class="mob-qty-sync">
                <button type="submit" class="btn btn-buy-premium w-100 py-3 small" style="padding: 12px !important;">
                    Buy Now
                </button>
            </form>
        </div>
    </div>

    <script>
        function updateDisplayImage(url, el) {
            document.getElementById('mainDisplayImage').src = url;
            document.querySelectorAll('.thumb-btn').forEach(btn => btn.classList.remove('active'));
            el.classList.add('active');
        }

        function changeQty(delta) {
            const input = document.getElementById('productQty');
            const cartInput = document.getElementById('cartQtyInput');
            const buyNowInput = document.getElementById('buyNowQtyInput');
            const mobSyncs = document.querySelectorAll('.mob-qty-sync');

            let val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            if (val > parseInt(input.max)) val = parseInt(input.max);

            input.value = val;
            cartInput.value = val;
            buyNowInput.value = val;
            mobSyncs.forEach(s => s.value = val);
        }

        // Tabs Logic
        document.querySelectorAll('.tab-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const target = this.getAttribute('href').substring(1);

                // Update active link
                document.querySelectorAll('.tab-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                // Update tab content
                document.querySelectorAll('.tab-content-container > div').forEach(c => c.style.display = 'none');
                document.getElementById(target).style.display = 'block';
            });
        });

        // Synchronize initial values
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('productQty');
            document.getElementById('cartQtyInput').value = input.value;
            document.getElementById('buyNowQtyInput').value = input.value;
            document.querySelectorAll('.mob-qty-sync').forEach(s => s.value = input.value);
        });
    </script>
@endsection