@extends('layouts.app')

@section('content')
    <div class="dashboard-main">
        @include('includes.dashboard_header')

        <div class="container py-5">
            <div class="row g-4 align-items-start dashboard-row-premium">
                <!-- Sidebar -->
                <div class="col-lg-3 dashboard-sidebar-column">
                    @include('includes.dashboard_sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9 fade-in-up">
                    <div class="dashboard-card p-4 p-lg-5">
                        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
                            <div>
                                <h3 class="fw-black mb-1 letter-spacing-n1">My Wishlist</h3>
                                <p class="text-muted small mb-0 fw-medium">Items you've saved for later shopping.</p>
                            </div>
                        </div>

                        <div class="row g-4 pt-2">
                            @forelse($wishlistItems as $item)
                                @php 
                                                                $prodPrice = $item->product->selling_price ?? 0;
                                    $imagePath = $item->product->image ? asset($item->product->image) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=400';
                                @endphp
                                <div class="col-md-6 col-xl-4">
                                    <div class="wishlist-item-card border rounded-4 p-3 h-100 position-relative transition">
                                        <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="position-absolute top-0 end-0 m-2 z-3">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-white rounded-circle shadow-sm border p-1" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-x fs-5 text-danger"></i>
                                            </button>
                                        </form>

                                        <a href="{{ url('/product-detail/' . ($item->product->slug ?? '')) }}" class="text-decoration-none d-block text-center mb-3">
                                            <div class="bg-light rounded-3 p-3 mb-3 d-flex align-items-center justify-content-center" style="height: 180px;">
                                                <img src="{{ $imagePath }}" class="img-fluid object-fit-contain h-100 transition shadow-sm" alt="{{ $item->product->name ?? 'Product' }}">
                                            </div>
                                            <h6 class="text-dark fw-bold mb-1 text-truncate">{{ $item->product->name ?? 'Unavailable' }}</h6>
                                            <p class="text-primary fw-black mb-0 fs-5">₹{{ number_format($prodPrice) }}</p>
                                        </a>

                                        <form action="{{ route('cart.add', $item->product_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-premium btn-sm w-100 py-2 rounded-pill fw-bold">
                                                <i class="bi bi-cart-plus me-2"></i> Move to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="text-center py-5">
                                        <div class="mb-4">
                                            <i class="bi bi-heart fs-1 text-muted opacity-25" style="font-size: 5rem !important;"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-2">Wishlist is empty</h5>
                                        <p class="text-muted small mb-4">You haven't added any items to your wishlist yet.</p>
                                        <a href="{{ url('/products') }}" class="btn btn-outline-primary px-5 py-2 rounded-pill fw-bold">Explore Store</a>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .wishlist-item-card {
            background: #ffffff;
            border-color: #f1f5f9 !important;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .wishlist-item-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
            border-color: var(--primary) !important;
        }

        .wishlist-item-card img {
            transition: transform 0.5s ease;
        }

        .wishlist-item-card:hover img {
            transform: scale(1.1);
        }
    </style>
@endsection
