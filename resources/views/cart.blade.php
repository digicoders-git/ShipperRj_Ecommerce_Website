@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <section class="py-5" style="background: linear-gradient(135deg, #F4F7F9 0%, #E9EEF2 100%);">
        <div class="container text-center py-4">
            <h1 class="fw-black mb-3">Shopping Cart</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"
                            class="text-decoration-none text-secondary">Home</a></li>
                    <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">Your Cart</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Cart Section -->
    <section class="py-5">
        <div class="container py-lg-5">
            <div class="row g-5">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="bg-white rounded-5 shadow-premium p-4 p-md-5 border">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="text-uppercase small fw-bold border-bottom">
                                    <tr>
                                        <th class="py-3 px-1 border-0 text-secondary">Product</th>
                                        <th class="py-3 px-1 border-0 text-secondary">Price</th>
                                        <th class="py-3 px-1 border-0 text-secondary text-center">Quantity</th>
                                        <th class="py-3 px-1 border-0 text-secondary text-end">Total</th>
                                        <th class="py-3 px-1 border-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalAmount = 0; @endphp
                                    @forelse($cartItems as $item)
                                        @php 
                                            $prodPrice = $item->product->selling_price ?? 0; 
                                            $totalAmount += ($prodPrice * $item->quantity);
                                            $imagePath = $item->product->image ? asset($item->product->image) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=400';
                                        @endphp
                                        <tr class="border-bottom">
                                            <td class="py-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="thumb-wrapper p-2 bg-light rounded-4 overflow-hidden"
                                                        style="width: 80px; height: 80px;">
                                                        <img src="{{ $imagePath }}"
                                                            class="img-fluid rounded-3 h-100 object-fit-contain" alt="{{ $item->product->name ?? 'Unknown' }}">
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-1">{{ $item->product->name ?? 'Product Unavailable' }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 fw-bold">₹{{ number_format($prodPrice) }}</td>
                                            <td class="py-4">
                                                <div class="quantity-wrapper d-inline-flex align-items-center bg-light rounded-pill px-3 py-1"
                                                    style="max-width: 120px;">
                                                    <button class="btn btn-link link-dark p-0"><i
                                                            class="bi bi-dash"></i></button>
                                                    <input type="text"
                                                        class="form-control bg-transparent border-0 text-center fw-bold px-1"
                                                        value="{{ $item->quantity }}" readonly>
                                                    <button class="btn btn-link link-dark p-0"><i
                                                            class="bi bi-plus"></i></button>
                                                </div>
                                            </td>
                                            <td class="py-4 fw-bold text-end text-primary">₹{{ number_format($prodPrice * $item->quantity) }}
                                            </td>
                                            <td class="py-4 text-end">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link link-danger p-2 rounded-circle hover-bg-light shadow-none">
                                                        <i class="bi bi-trash fs-5"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-5 text-center text-secondary">Your cart is completely empty. Start adding some premium products!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 gap-3">
                            <div class="input-group" style="max-width: 350px;">
                                <input type="text"
                                    class="form-control search-input rounded-start-pill border-end-0 bg-light"
                                    placeholder="Coupon Code">
                                <button class="btn btn-dark rounded-end-pill px-4" type="button">Apply Coupon</button>
                            </div>
                            <button class="btn btn-outline-dark rounded-pill px-5 py-2 fw-bold shadow-none">Update
                                Cart</button>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="bg-white rounded-5 shadow-premium p-4 p-md-5 border sticky-top" style="top: 150px;">
                        <h5 class="fw-black mb-4">Cart Total Sum</h5>
                        <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                            <span class="text-secondary">Subtotal</span>
                            <span class="fw-bold fs-5">₹{{ number_format($totalAmount ?? 0) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                            <span class="text-secondary">Shipping</span>
                            <span class="text-success fw-bold">Free</span>
                        </div>
                        <div class="d-flex justify-content-between mb-5">
                            <h4 class="fw-black mb-0">Total</h4>
                            <h4 class="fw-black text-primary mb-0">₹{{ number_format($totalAmount ?? 0) }}</h4>
                        </div>

                        <a href="{{ url('/checkout') }}"
                            class="btn btn-premium w-100 py-3 rounded-pill btn-lg mb-3 shadow-premium text-uppercase fw-bold">Proceed
                            to Checkout</a>
                        <p class="text-center text-secondary small mb-0"><i
                                class="bi bi-shield-check text-success me-2"></i> 100% Secure Checkout Guaranteed</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection