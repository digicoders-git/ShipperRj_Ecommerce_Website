@extends('layouts.admin')

@section('title', 'Customer Carts')

@section('admin_content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h5 class="fw-bold text-dark mb-1">Live Customer Carts</h5>
            <p class="text-secondary small mb-0">View and monitor active shopping carts across all customers in real-time.
            </p>
        </div>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.user-carts.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm bg-white text-dark border shadow-none"
                    placeholder="Search user, email, phone, product..." value="{{ request('search') }}"
                    style="min-width: 260px;">
                <button type="submit" class="btn btn-primary btn-sm px-3 shadow-none">
                    <i class="bi bi-search"></i>
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.user-carts.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="bg-white rounded-4 p-4 shadow-sm border d-flex align-items-center gap-3">
                <div class="rounded-3 bg-primary text-white p-3 fs-3 shadow-sm">
                    <i class="bi bi-cart3"></i>
                </div>
                <div>
                    <div class="text-secondary x-small fw-bold text-uppercase">Active Carts</div>
                    <h3 class="fw-bold text-dark mb-0">{{ number_format($totalActiveCarts) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white rounded-4 p-4 shadow-sm border d-flex align-items-center gap-3">
                <div class="rounded-3 bg-warning text-white p-3 fs-3 shadow-sm">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <div class="text-secondary x-small fw-bold text-uppercase">Total Items In Carts</div>
                    <h3 class="fw-bold text-dark mb-0">{{ number_format($totalCartItems) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white rounded-4 p-4 shadow-sm border d-flex align-items-center gap-3">
                <div class="rounded-3 bg-success text-white p-3 fs-3 shadow-sm">
                    <i class="bi bi-currency-rupee"></i>
                </div>
                <div>
                    <div class="text-secondary x-small fw-bold text-uppercase">Potential Cart Value</div>
                    <h3 class="fw-bold text-success mb-0">₹{{ number_format($totalCartValue, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Carts List -->
    <div class="d-flex flex-column gap-4">
        @forelse($usersWithCarts as $user)
            @php
                $userCartTotal = 0;
                $distinctProducts = $user->carts->pluck('product_id')->unique()->count();
                foreach ($user->carts as $c) {
                    $price = $c->product->getSellingPriceForQuantity($c->quantity) ?? $c->product->selling_price ?? 0;
                    $userCartTotal += ($price * $c->quantity);
                }
            @endphp
            <div class="bg-white rounded-4 shadow-sm border overflow-hidden">
                <!-- User Header -->
                <div class="p-3 border-bottom bg-light d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center shadow-sm"
                            style="width: 44px; height: 44px; font-size: 1.1rem; color: #ffffff !important;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="fw-bold text-dark mb-0">{{ $user->name }}</h6>
                                <span
                                    class="badge bg-primary text-white px-3 py-1.5 rounded-pill small fw-bold shadow-sm">
                                    {{ $distinctProducts }} {{ Str::plural('Product', $distinctProducts) }}
                                </span>
                            </div>
                            <div class="x-small text-muted mt-1">
                                <span class="me-3"><i class="bi bi-envelope me-1"></i>{{ $user->email ?? 'N/A' }}</span>
                                <span class="me-3"><i class="bi bi-telephone me-1"></i>{{ $user->mobile ?? $user->phone ?? 'N/A' }}</span>
                                <span><i class="bi bi-clock me-1"></i>Last active:
                                    {{ $user->updated_at ? $user->updated_at->diffForHumans() : 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-end me-2">
                            <span class="x-small text-muted d-block uppercase fw-bold">Cart Total</span>
                            <span class="fw-bold text-success fs-5">₹{{ number_format($userCartTotal, 2) }}</span>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.users.show', $user->id) }}"
                                class="btn btn-outline-dark btn-sm px-3 fw-bold" title="View Customer Profile">
                                <i class="bi bi-person-lines-fill me-1"></i> Profile
                            </a>
                            <form action="{{ route('admin.user-carts.clear', $user->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to clear this customer\'s cart?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold"
                                    title="Clear Customer Cart">
                                    <i class="bi bi-trash me-1"></i> Clear Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Cart Items Table -->
                <div class="table-responsive p-3">
                    <table class="table align-middle table-hover mb-0">
                        <thead>
                            <tr class="text-uppercase x-small fw-bold text-muted border-bottom">
                                <th class="py-2 px-3">Product</th>
                                <th class="py-2 px-3">Unit Price</th>
                                <th class="py-2 px-3 text-center">Quantity</th>
                                <th class="py-2 px-3 text-end">Line Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->carts as $cart)
                                @php
                                    $unitPrice = $cart->product->getSellingPriceForQuantity($cart->quantity) ?? $cart->product->selling_price ?? 0;
                                    $lineTotal = $unitPrice * $cart->quantity;
                                @endphp
                                <tr class="border-bottom">
                                    <td class="py-3 px-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($cart->product->image)
                                                <img src="{{ asset($cart->product->image) }}" class="rounded-3 border"
                                                    style="width: 45px; height: 45px; object-fit: cover;">
                                            @else
                                                <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center text-muted x-small"
                                                    style="width: 45px; height: 45px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ url('/product-detail/' . $cart->product->slug) }}" target="_blank"
                                                    class="text-dark text-decoration-none fw-bold hover-primary">
                                                    {{ $cart->product->name ?? 'Product Unavailable' }}
                                                </a>
                                                <div class="x-small text-muted">
                                                    MOQ: {{ $cart->product->minimum_order_quantity ?? 1 }} | Stock:
                                                    {{ $cart->product->stock }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 fw-bold text-dark">
                                        ₹{{ number_format($unitPrice, 2) }}
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <span
                                            class="badge bg-light text-dark border px-3 py-2 fw-bold fs-6">{{ $cart->quantity }}</span>
                                    </td>
                                    <td class="py-3 px-3 text-end fw-bold text-primary">
                                        ₹{{ number_format($lineTotal, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-4 p-5 text-center shadow-sm border">
                <i class="bi bi-cart-x fs-1 d-block mb-3 text-muted"></i>
                <h6 class="fw-bold text-dark mb-1">No Active Customer Carts Found</h6>
                <p class="small text-muted mb-0">Currently there are no items in any customer's shopping cart.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-end mt-4">
        {{ $usersWithCarts->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
@endsection