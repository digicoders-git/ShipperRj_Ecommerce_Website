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
            <form action="{{ route('cart.update') }}" method="POST" id="update-cart-form">
                @csrf
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
                                        @php 
                                            $totalAmount = 0; 
                                            $totalShipping = 0;
                                            $global_online = ($settingsData['global_online_shipping'] ?? '') !== '' ? (float) $settingsData['global_online_shipping'] : 0;
                                        @endphp
                                        @forelse($cartItems as $item)
                                            @php 
                                                $prodPrice = $item->product ? $item->product->getEffectivePrice($item->quantity) : 0; 
                                                $origPrice = $item->product ? $item->product->getSellingPriceForQuantity($item->quantity) : 0;
                                                $catOffer = $item->product ? $item->product->getActiveCategoryOffer() : null;
                                                $hasOffer = ($catOffer && $catOffer->isLive() && $prodPrice < $origPrice);

                                                $totalAmount += ($prodPrice * $item->quantity);
                                                
                                                // Shipping Calculation (Using Online Rate as default for Cart view)
                                                $shipPct = ((float) ($item->product->online_shipping_charges ?? 0) > 0) ? $item->product->online_shipping_charges : $global_online;
                                                $itemShipping = ($prodPrice * $shipPct / 100) * $item->quantity;
                                                $totalShipping += $itemShipping;

                                                $imagePath = ($item->product && $item->product->image) ? asset($item->product->image) : asset('images/placeholder.svg');
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
                                                            @if($hasOffer)
                                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 xx-small">
                                                                    <i class="bi bi-lightning-fill me-1"></i> {{ $catOffer->offer_name }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-4 fw-bold">
                                                    @if($hasOffer)
                                                        <div class="text-danger fw-black">₹{{ number_format($prodPrice, 2) }}</div>
                                                        <div class="text-muted small text-decoration-line-through">₹{{ number_format($origPrice, 2) }}</div>
                                                    @else
                                                        ₹{{ number_format($prodPrice) }}
                                                    @endif
                                                </td>
                                                <td class="py-4">
                                                    <div class="quantity-wrapper d-inline-flex align-items-center bg-light rounded-pill px-3 py-1"
                                                        style="max-width: 120px;">
                                                        <button type="button" class="btn btn-link link-dark p-0 decrease-qty"><i
                                                                class="bi bi-dash"></i></button>
                                                        <input type="number" name="quantities[{{ $item->id }}]"
                                                            class="form-control bg-transparent border-0 text-center fw-bold px-1 qty-input"
                                                            value="{{ max($item->quantity, $item->product->minimum_order_quantity ?? 1) }}"
                                                            min="{{ $item->product->minimum_order_quantity ?? 1 }}"
                                                            data-min="{{ $item->product->minimum_order_quantity ?? 1 }}"
                                                            data-product-name="{{ $item->product->name ?? 'this product' }}">
                                                        <button type="button" class="btn btn-link link-dark p-0 increase-qty"><i
                                                                class="bi bi-plus"></i></button>
                                                    </div>
                                                </td>
                                                <td class="py-4 fw-bold text-end text-primary">₹{{ number_format($prodPrice * $item->quantity) }}
                                                </td>
                                                <td class="py-4 text-end">
                                                    <button type="button" onclick="removeItem('{{ $item->id }}')" class="btn btn-link link-danger p-2 rounded-circle hover-bg-light shadow-none">
                                                        <i class="bi bi-trash fs-5"></i>
                                                    </button>
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

                            <div class="d-flex flex-wrap justify-content-end align-items-center mt-5 gap-3">
                                <button type="submit" class="btn btn-outline-dark rounded-pill px-5 py-2 fw-bold shadow-none">Update
                                    Cart</button>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-4">
                        <div class="bg-white rounded-5 shadow-premium p-4 p-md-5 border sticky-top" style="top: 100px; z-index: 10;">
                            <h5 class="fw-black mb-4">Cart Total Sum</h5>
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                                <span class="text-secondary">Subtotal</span>
                                <span class="fw-bold fs-5">₹{{ number_format($totalAmount) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                                <span class="text-secondary">Shipping</span>
                                <span class="text-primary fw-bold" id="shipping-display">
                                    @if($totalShipping > 0)
                                        ₹{{ number_format($totalShipping,2) }}
                                    @else
                                        Free
                                    @endif
                                </span>
                            </div>

                            <div class="d-flex justify-content-between mb-5">
                                <h4 class="fw-black mb-0">Total</h4>
                                <h4 class="fw-black text-primary mb-0" id="grand-total-display">₹{{ number_format($totalAmount + $totalShipping,2) }}</h4>
                            </div>

                            <a href="{{ url('/checkout') }}" onclick="return validateCartCheckout(event)"
                                class="btn btn-premium w-100 py-3 rounded-pill btn-lg mb-3 shadow-premium text-uppercase fw-bold">Proceed
                                to Checkout</a>
                            <p class="text-center text-secondary small mb-0"><i
                                    class="bi bi-shield-check text-success me-2"></i> 100% Secure Checkout Guaranteed</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        function validateCartCheckout(e) {
            @php
                $settingsData = \App\Models\Setting::getAllCached();
                $minOrderVal = (isset($settingsData['min_order_price']) && $settingsData['min_order_price'] !== '') ? (float) $settingsData['min_order_price'] : 0;
            @endphp
            const minOrderVal = {{ $minOrderVal }};
            const cartSubtotal = {{ $totalAmount }};

            @foreach($cartItems as $item)
                if ({{ $item->quantity }} < {{ $item->product->minimum_order_quantity ?? 1 }}) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'MINIMUM QUANTITY REQUIRED',
                        html: `<p class="mb-2">Item <b>"{{ $item->product->name }}"</b> requires a minimum order quantity of <b>{{ $item->product->minimum_order_quantity }}</b> units (Current: {{ $item->quantity }}).</p><p class="text-secondary small mb-0">Please update the quantity in your cart before proceeding.</p>`,
                        confirmButtonColor: '#f2701a'
                    });
                    return false;
                }
            @endforeach

            if (minOrderVal > 0 && cartSubtotal < minOrderVal) {
                e.preventDefault();
                let diff = minOrderVal - cartSubtotal;
                Swal.fire({
                    icon: 'warning',
                    title: 'MINIMUM ORDER VALUE REQUIRED',
                    html: `<p class="mb-2">Your cart subtotal is <b>₹${cartSubtotal.toLocaleString()}</b>. A minimum shopping amount of <b>₹${minOrderVal.toLocaleString()}</b> is required.</p><p class="text-secondary small mb-0">Please add items worth <b>₹${diff.toLocaleString()}</b> more to your cart to proceed.</p>`,
                    confirmButtonColor: '#f2701a'
                });
                return false;
            }
            return true;
        }
    </script>

    <!-- Hidden form for deletion -->
    <form id="remove-item-form" method="POST" style="display:none;">
        @csrf
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity Controls
        document.querySelectorAll('.increase-qty').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.qty-input');
                input.value = (parseInt(input.value) || 0) + 1;
            });
        });

        document.querySelectorAll('.decrease-qty').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.qty-input');
                const minQty = parseInt(input.getAttribute('data-min') || input.getAttribute('min')) || 1;
                const prodName = input.getAttribute('data-product-name') || 'this product';
                const currentVal = parseInt(input.value) || 1;

                if (currentVal > minQty) {
                    input.value = currentVal - 1;
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Minimum Order Quantity',
                            text: `Required quantity for "${prodName}" is ${minQty}. It cannot be reduced further.`,
                            confirmButtonColor: '#0d6efd'
                        });
                    } else if (typeof showToast === 'function') {
                        showToast('Minimum Order Quantity', `Required quantity for "${prodName}" is ${minQty}.`, 'warning');
                    } else {
                        alert(`Required quantity for "${prodName}" is ${minQty}.`);
                    }
                }
            });
        });

        document.querySelectorAll('.qty-input').forEach(input => {
            input.addEventListener('change', function() {
                const minQty = parseInt(this.getAttribute('data-min') || this.getAttribute('min')) || 1;
                const prodName = this.getAttribute('data-product-name') || 'this product';
                const currentVal = parseInt(this.value) || 0;

                if (currentVal < minQty) {
                    this.value = minQty;
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Minimum Order Quantity',
                            text: `Required quantity for "${prodName}" is ${minQty}.`,
                            confirmButtonColor: '#0d6efd'
                        });
                    } else if (typeof showToast === 'function') {
                        showToast('Minimum Order Quantity', `Required quantity for "${prodName}" is ${minQty}.`, 'warning');
                    } else {
                        alert(`Required quantity for "${prodName}" is ${minQty}.`);
                    }
                }
            });
        });
    });

    function removeItem(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to remove this item from cart?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('remove-item-form');
                form.action = `/cart/remove/${id}`;
                form.submit();
            }
        });
    }
</script>
@endpush