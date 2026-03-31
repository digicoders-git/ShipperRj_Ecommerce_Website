@extends('layouts.app')

@section('content')
    <div class="dashboard-main">
        @include('includes.dashboard_header')

        <div class="container py-5">
            <div class="row g-4 dashboard-main-row">
                <!-- Sidebar -->
                <div class="col-lg-3 dashboard-sidebar-column">
                    @include('includes.dashboard_sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Summary Cards -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <div class="stat-card-premium">
                                <div class="stat-icon orange shadow-sm">
                                    <i class="bi bi-bag-check"></i>
                                </div>
                                <div>
                                    <p class="text-muted small fw-bold mb-0 text-uppercase ls-1">Total Orders</p>
                                    <h4 class="fw-black mb-0">{{ Auth::user()->orders()->count() }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card-premium">
                                <div class="stat-icon green shadow-sm">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <div>
                                    <p class="text-muted small fw-bold mb-0 text-uppercase ls-1">Wallet Card</p>
                                    <h4 class="fw-black mb-0">₹{{ number_format(Auth::user()->wallet_balance ?? 0, 2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card-premium">
                                <div class="stat-icon blue shadow-sm">
                                    <i class="bi bi-lightning-charge"></i>
                                </div>
                                <div>
                                    <p class="text-muted small fw-bold mb-0 text-uppercase ls-1">Active Orders</p>
                                    <h4 class="fw-black mb-0">
                                        {{ Auth::user()->orders()->whereIn('order_status', ['placed', 'pending', 'processing', 'shipped'])->count() }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="dashboard-card p-4 p-lg-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-black mb-0">Recent Activity</h4>
                            <a href="{{ url('/orders') }}"
                                class="btn btn-primary-soft btn-sm rounded-pill px-4 fw-bold">View All</a>
                        </div>

                        @if($recent_orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-premium align-middle">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recent_orders as $order)
                                            <tr>
                                                <td class="fw-bold text-dark">#{{ $order->order_number }}</td>
                                                <td class="text-muted small">{{ $order->created_at->format('d M, Y') }}</td>
                                                <td class="fw-black text-dark">₹{{ number_format($order->total_amount, 2) }}</td>
                                                <td>
                                                    <span class="badge-status {{ strtolower($order->order_status) }}">
                                                        {{ ucfirst($order->order_status) }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('orders') }}"
                                                        class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold">Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="bi bi-cart-x display-1 text-muted opacity-25"></i>
                                </div>
                                <h5 class="fw-bold text-dark">No orders yet!</h5>
                                <p class="text-muted mb-4 small">Looks like you haven't placed any orders recently.</p>
                                <a href="{{ url('/products') }}" class="btn btn-premium px-5 py-3 rounded-pill fw-bold">Start
                                    Shopping</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection