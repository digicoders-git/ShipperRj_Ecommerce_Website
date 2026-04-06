@extends('layouts.admin')

@section('title', 'User Profile - ' . $user->name)

@section('admin_content')
    <div class="mb-4 d-flex align-items-center justify-content-between animation-fade-in">
        <div>
            <h4 class="fw-bold mb-0 text-dark">User Detailed Profile</h4>
            <p class="text-secondary small mb-0">Full view of user information, orders, and wallet history.</p>
        </div>
        <a href="{{ route('admin.users.index') }}"
            class="btn btn-sm btn-white border px-4 rounded-pill shadow-sm transition-all hover-translate-x-left">
            <i class="bi bi-arrow-left me-2"></i> Return to Users List
        </a>
    </div>

    <div class="row g-4 animation-slide-up">
        <!-- Sidebar: User Brief -->
        <div class="col-lg-5 col-xl-4">
            <div class="glass-card h-100 p-0 overflow-hidden shadow-sm border-0 border-radius-24">
                <!-- Header Section with Gradient -->
                <div class="p-4 text-center bg-white border-bottom position-relative">
                    <div class="profile-photo-wrapper mb-3 position-relative d-inline-block">
                        @php
                            $profile_photo = $user->profile_photo ? asset('storage/' . $user->profile_photo) : null;
                        @endphp
                        @if($profile_photo)
                            <img src="{{ $profile_photo }}"
                                class="rounded-circle shadow-sm p-1 border border-primary border-opacity-25"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center text-primary display-4 fw-bold shadow-sm"
                                style="width: 120px; height: 120px;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="position-absolute bottom-0 end-0 mb-1 me-1 shadow-sm">
                            @if($user->is_blocked)
                                <span class="badge bg-danger rounded-circle p-2 border border-white border-2"
                                    title="User Blocked">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                            @else
                                <span class="badge bg-success rounded-circle p-2 border border-white border-2"
                                    title="User Active">
                                    <i class="bi bi-check-lg"></i>
                                </span>
                            @endif
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                    <p class="text-secondary small mb-3">{{ $user->email }}</p>

                    <div class="d-flex justify-content-center gap-2">
                        @if($user->is_blocked)
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 fw-bold small">ACCESS
                                BLOCKED</span>
                        @else
                            <span
                                class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-bold small">ACTIVE
                                ACCOUNT</span>
                        @endif
                    </div>
                </div>

                <!-- Stats Bar -->
                <div class="p-4 bg-light bg-opacity-50">
                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <div
                                class="stat-card p-3 bg-white rounded-4 border border-dark border-opacity-5 text-center shadow-sm">
                                <label class="xx-small text-primary fw-bold uppercase d-block mb-1">Wallet Money</label>
                                <span class="text-dark fw-bold small">₹{{ number_format($user->wallet_balance, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div
                                class="stat-card p-3 bg-white rounded-4 border border-dark border-opacity-5 text-center shadow-sm">
                                <label class="xx-small text-primary fw-bold uppercase d-block mb-1">Total Orders</label>
                                <span class="text-dark fw-bold small">{{ $user->orders->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Info List -->
                    <div class="info-list space-y-3">
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="p-3 bg-white rounded-4 border border-dark border-opacity-5 shadow-sm d-flex align-items-center h-100">
                                    <div class="icon-box me-3"><i class="bi bi-person-badge text-primary"></i></div>
                                    <div>
                                        <label class="xx-small text-secondary fw-bold uppercase d-block">User ID</label>
                                        <span class="text-dark x-small fw-bold d-block" style="word-break: break-all; line-height: 1.2;">{{ $user->id }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 bg-white rounded-4 border border-dark border-opacity-5 shadow-sm d-flex align-items-center h-100">
                                    <div class="icon-box me-3"><i class="bi bi-telephone text-primary"></i></div>
                                    <div>
                                        <label class="xx-small text-secondary fw-bold uppercase d-block">Phone</label>
                                        <span class="text-dark x-small fw-bold d-block">{{ $user->mobile ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="p-3 bg-white rounded-4 border border-dark border-opacity-5 shadow-sm d-flex align-items-center font-monospace">
                            <div class="icon-box me-3"><i class="bi bi-shield-lock text-warning"></i></div>
                            <div>
                                <label class="xx-small text-secondary fw-bold uppercase d-block">Login Password</label>
                                <span class="text-info small fw-black d-block">{{ $user->plain_password ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div
                            class="p-3 bg-white rounded-4 border border-dark border-opacity-5 shadow-sm d-flex align-items-center">
                            <div class="icon-box me-3"><i class="bi bi-geo-alt text-primary"></i></div>
                            <div>
                                <label class="xx-small text-secondary fw-bold uppercase d-block">Profile Address</label>
                                <span class="text-dark small fw-bold">
                                    @if($user->address)
                                        {{ $user->address }}, {{ $user->city }}, {{ $user->state }}
                                    @else
                                        <span class="opacity-50">Not Set</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div
                            class="p-3 bg-white rounded-4 border border-dark border-opacity-5 shadow-sm d-flex align-items-center">
                            <div class="icon-box me-3"><i class="bi bi-calendar-event text-primary"></i></div>
                            <div>
                                <label class="xx-small text-secondary fw-bold uppercase d-block">Registered On</label>
                                <span class="text-dark small fw-bold">{{ $user->created_at->format('d M, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Block Toggle Button -->
                <div class="p-4 bg-white border-top">
                    <form action="{{ route('admin.users.toggle-block', $user->id) }}" method="POST" class="w-100">
                        @csrf
                        @if($user->is_blocked)
                            <button type="submit"
                                class="btn btn-success w-100 py-3 rounded-pill fw-bold shadow-sm transition-all hover-scale border-0 btn-block-toggle"
                                data-status="unblock">
                                <i class="bi bi-unlock-fill me-2"></i> ACTIVATE USER
                            </button>
                        @else
                            <button type="submit"
                                class="btn btn-danger w-100 py-3 rounded-pill fw-bold shadow-sm transition-all hover-scale border-0 btn-block-toggle"
                                data-status="block">
                                <i class="bi bi-slash-circle-fill me-2"></i> BLOCK USER ACCESS
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content: Tabs Section -->
        <div class="col-lg-7 col-xl-8">
            <div class="glass-card shadow-sm border-0 p-0 overflow-hidden border-radius-24">
                <div class="bg-white p-2 border-bottom">
                    <ul class="nav nav-pills custom-pills-new gap-2" id="userTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active px-4 py-2 rounded-pill small fw-bold" id="orders-tab"
                                data-bs-toggle="tab" data-bs-target="#orders-pane" type="button" role="tab">Orders
                                List</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-4 py-2 rounded-pill small fw-bold" id="wallet-tab"
                                data-bs-toggle="tab" data-bs-target="#wallet-pane" type="button" role="tab">Wallet
                                Actions</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-4 py-2 rounded-pill small fw-bold" id="addresses-tab"
                                data-bs-toggle="tab" data-bs-target="#addresses-pane" type="button" role="tab">Saved
                                Addresses</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-4 py-2 rounded-pill small fw-bold" id="wishlist-tab"
                                data-bs-toggle="tab" data-bs-target="#wishlist-pane" type="button" role="tab">Cart &
                                Items</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="userTabsContent" style="max-height: 700px; overflow-y: auto;">
                    <!-- Orders -->
                    <div class="tab-pane fade show active p-4" id="orders-pane" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold text-dark mb-0">Recent User Orders ({{ $user->orders->count() }})</h6>
                        </div>

                        @if($user->orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="bg-light">
                                        <tr class="border-bottom">
                                            <th class="ps-3 py-3 x-small fw-bold text-secondary">Order #</th>
                                            <th class="py-3 x-small fw-bold text-secondary">Date</th>
                                            <th class="py-3 x-small fw-bold text-secondary">Total Amount</th>
                                            <th class="py-3 x-small fw-bold text-secondary">Status</th>
                                            <th class="pe-3 py-3 text-end x-small fw-bold text-secondary">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->orders as $order)
                                            <tr class="border-bottom transition-all">
                                                <td class="ps-3 fw-bold text-primary small">#{{ $order->order_number }}</td>
                                                <td class="small text-dark fw-bold">{{ $order->created_at->format('d M, Y') }}</td>
                                                <td class="small fw-bold text-dark">₹{{ number_format($order->total_amount, 2) }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-primary bg-opacity-10 text-white rounded-pill px-3 py-1 fw-bold"
                                                        style="font-size: 0.65rem;">{{ strtoupper($order->order_status) }}</span>
                                                </td>
                                                <td class="pe-3 text-end">
                                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                                        class="btn btn-sm btn-outline-primary p-1 rounded-circle">
                                                        <i class="bi bi-arrow-right fs-6"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5 opacity-25">
                                <i class="bi bi-cart-x display-1 d-block mb-3"></i>
                                <p class="fw-bold">No orders found.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Wallet Actions -->
                    <div class="tab-pane fade p-4" id="wallet-pane" role="tabpanel">
                        <h6 class="fw-bold text-dark mb-4">Wallet History & Deals</h6>
                        @if($user->walletTransactions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="bg-light">
                                        <tr class="border-bottom">
                                            <th class="ps-3 py-3 x-small fw-bold text-secondary">Tran ID</th>
                                            <th class="py-3 x-small fw-bold text-secondary">Date</th>
                                            <th class="py-3 x-small fw-bold text-secondary">Money</th>
                                            <th class="py-3 x-small fw-bold text-secondary">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->walletTransactions as $tx)
                                            <tr class="border-bottom">
                                                <td class="ps-3 fw-bold small">#T{{ $tx->id }}</td>
                                                <td class="small">{{ $tx->created_at->format('d M, Y • H:i') }}</td>
                                                <td>
                                                    <span
                                                        class="{{ $tx->amount > 0 ? 'text-success' : 'text-danger' }} fw-bold px-3 py-1 rounded-pill bg-light border shadow-sm small">
                                                        {{ $tx->amount > 0 ? '+' : '' }}₹{{ number_format($tx->amount, 2) }}
                                                    </span>
                                                </td>
                                                <td class="text-dark small fw-bold">{{ $tx->description }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5 opacity-25">
                                <i class="bi bi-cash display-1 d-block mb-3"></i>
                                <p class="fw-bold">No transactions logged.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Addresses -->
                    <div class="tab-pane fade p-4" id="addresses-pane" role="tabpanel">
                        <h6 class="fw-bold text-dark mb-4">Customer Addresses</h6>
                        <div class="row g-3">
                            @forelse($user->addresses as $address)
                                <div class="col-md-6">
                                    <div
                                        class="p-4 rounded-4 bg-light border border-opacity-10 h-100 shadow-sm transition-all hover-translate-y">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span
                                                class="badge bg-primary text-white rounded-pill px-3 py-1 fw-bold x-small">{{ strtoupper($address->type) }}</span>
                                            @if($address->is_default)
                                                <span class="text-primary xx-small fw-bold"><i
                                                        class="bi bi-star-fill me-1"></i>Default</span>
                                            @endif
                                        </div>
                                        <h6 class="text-dark fw-bold mb-1">{{ $address->name }}</h6>
                                        <p class="text-secondary small fw-bold mb-3"><i
                                                class="bi bi-phone me-1"></i>{{ $address->mobile }}</p>
                                        <div class="p-3 bg-white rounded-3 border">
                                            <p class="text-dark small mb-0 opacity-75">
                                                {{ $address->address_line }},
                                                {{ $address->landmark ? $address->landmark . ',' : '' }}
                                                <span class="d-block mt-2 fw-bold text-primary">{{ $address->city }},
                                                    {{ $address->state }} - {{ $address->pincode }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5 opacity-25">
                                    <i class="bi bi-geo-alt display-1 d-block mb-3"></i>
                                    <p class="fw-bold">No addresses found.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Wishlist and Cart -->
                    <div class="tab-pane fade p-4" id="wishlist-pane" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-dark mb-4 d-flex justify-content-between">
                                    <span>Cart Items</span>
                                    <span class="badge bg-primary rounded-pill px-2">{{ $user->carts->count() }}</span>
                                </h6>
                                <div class="space-y-3">
                                    @forelse($user->carts as $cart)
                                        <div
                                            class="p-3 bg-white rounded-4 border d-flex align-items-center gap-3 shadow-sm hover-translate-y transition-all">
                                            <img src="{{ asset($cart->product->image) }}" class="rounded-3 border"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <div class="text-dark fw-bold small text-truncate">{{ $cart->product->name }}
                                                </div>
                                                <div class="text-secondary xx-small uppercase fw-bold">Qty:
                                                    {{ $cart->quantity }} •
                                                    ₹{{ number_format($cart->product->selling_price, 2) }}</div>
                                            </div>
                                            <div class="text-primary fw-bold">
                                                ₹{{ number_format($cart->product->selling_price * $cart->quantity, 2) }}</div>
                                        </div>
                                    @empty
                                        <div class="bg-light py-5 text-center text-muted small border rounded-4">Cart is empty
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-dark mb-4 d-flex justify-content-between">
                                    <span>Wishlist Products</span>
                                    <span class="badge bg-danger rounded-pill px-2">{{ $user->wishlists->count() }}</span>
                                </h6>
                                <div class="space-y-3">
                                    @forelse($user->wishlists as $wish)
                                        <div
                                            class="p-3 bg-white rounded-4 border d-flex align-items-center gap-3 shadow-sm hover-translate-y transition-all">
                                            <img src="{{ asset($wish->product->image) }}" class="rounded-3 border"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                            <div class="flex-grow-1 overflow-hidden pe-2">
                                                <div class="text-dark fw-bold small text-truncate">{{ $wish->product->name }}
                                                </div>
                                                <div class="text-primary fw-bold small mt-1">
                                                    ₹{{ number_format($wish->product->selling_price, 2) }}</div>
                                            </div>
                                            <a href="{{ route('admin.products.show', $wish->product->id) }}"
                                                class="btn btn-sm btn-dark rounded-pill px-3">View</a>
                                        </div>
                                    @empty
                                        <div class="bg-light py-5 text-center text-muted small border rounded-4">Wishlist is
                                            empty</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Card Styles */
        .border-radius-24 {
            border-radius: 24px !important;
        }

        .icon-box {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Tabs Styling */
        .custom-pills-new .nav-link {
            color: #64748b;
            transition: all 0.3s ease;
        }

        .custom-pills-new .nav-link.active {
            background: #f2701a !important;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(242, 112, 26, 0.25);
        }

        /* Animation & Transitions */
        .animation-fade-in {
            animation: fadeIn 0.4s ease-out;
        }

        .animation-slide-up {
            animation: slideUp 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hover-translate-y:hover {
            transform: translateY(-4px);
        }

        .hover-translate-x-left:hover {
            transform: translateX(-4px);
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        .transition-all {
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        /* Text Utilities */
        .xx-small {
            font-size: 0.65rem;
        }

        .x-small {
            font-size: 0.75rem;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .space-y-3>*+* {
            margin-top: 1rem;
        }
    </style>
@endsection