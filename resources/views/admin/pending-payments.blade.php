@extends('layouts.admin')

@section('title', 'Pending Payments / Abandoned Checkouts')

@section('admin_content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h5 class="fw-bold text-dark mb-1">Pending Payments & Abandoned Checkouts</h5>
            <p class="text-secondary small mb-0">Track and manage customers who initiated checkout but did not complete payment.</p>
        </div>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.pending-payments.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm bg-white text-dark border shadow-none" 
                    placeholder="Search Order #, User, Mobile, Email..." value="{{ request('search') }}" style="min-width: 260px;">
                <button type="submit" class="btn btn-primary btn-sm px-3 shadow-none">
                    <i class="bi bi-search"></i>
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.pending-payments.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="bg-white rounded-4 p-4 shadow-sm border d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 text-white fs-3 shadow-sm" style="background: linear-gradient(135deg, #fd7e14, #ff922b);">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <div class="text-secondary x-small fw-bold text-uppercase">Pending Payments</div>
                    <h3 class="fw-bold text-dark mb-0">{{ number_format($totalPendingCount) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white rounded-4 p-4 shadow-sm border d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 text-dark fs-3 shadow-sm" style="background: linear-gradient(135deg, #ffc107, #ffd43b);">
                    <i class="bi bi-currency-rupee"></i>
                </div>
                <div>
                    <div class="text-secondary x-small fw-bold text-uppercase">Unpaid Amount</div>
                    <h3 class="fw-bold text-dark mb-0">₹{{ number_format($totalPendingAmount, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white rounded-4 p-4 shadow-sm border d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 text-white fs-3 shadow-sm" style="background: linear-gradient(135deg, #dc3545, #f76707);">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div>
                    <div class="text-secondary x-small fw-bold text-uppercase">Failed Payments</div>
                    <h3 class="fw-bold text-danger mb-0">{{ number_format($totalFailedCount) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    <div class="d-flex flex-column gap-4">
        @forelse($pendingOrders as $order)
            <div class="bg-white rounded-4 shadow-sm border overflow-hidden">
                <!-- Order Header -->
                <div class="p-3 border-bottom bg-light d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; font-size: 1.1rem; background: linear-gradient(135deg, #1a2233, #2d3748); color: #ffffff !important;">
                            {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="fw-bold text-dark mb-0">#{{ $order->order_number }}</h6>
                                <span class="badge bg-warning bg-opacity-10 text-dark border border-warning px-2 py-1 small fw-bold">
                                    {{ strtoupper($order->payment_status ?? 'PENDING') }}
                                </span>
                                <span class="badge bg-secondary bg-opacity-10 text-dark border px-2 py-1 x-small fw-bold uppercase">
                                    {{ $order->payment_method ?? 'ONLINE' }}
                                </span>
                            </div>
                            <div class="x-small text-muted mt-1">
                                <span class="me-3"><i class="bi bi-person me-1"></i>{{ $order->user->name ?? 'Guest/Unknown' }}</span>
                                <span class="me-3"><i class="bi bi-envelope me-1"></i>{{ $order->user->email ?? 'N/A' }}</span>
                                <span class="me-3"><i class="bi bi-telephone me-1"></i>{{ $order->user->mobile ?? $order->user->phone ?? 'N/A' }}</span>
                                <span><i class="bi bi-calendar3 me-1"></i>{{ $order->created_at ? $order->created_at->format('d M, Y H:i A') : 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-end me-2">
                            <span class="x-small text-muted d-block uppercase fw-bold">Total Amount</span>
                            <span class="fw-bold text-dark fs-5">₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-dark btn-sm px-3 fw-bold" title="View Order Details">
                                <i class="bi bi-eye me-1"></i> Details
                            </a>
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" onsubmit="return confirm('Mark this pending order as Paid & Confirmed?');">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="order_status" value="placed">
                                <input type="hidden" name="payment_status" value="paid">
                                <button type="submit" class="btn btn-success btn-sm px-3 fw-bold shadow-sm" title="Mark Payment as Paid">
                                    <i class="bi bi-check-circle me-1"></i> Mark Paid
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Order Items Table -->
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
                            @forelse($order->orderItems as $item)
                                <tr class="border-bottom">
                                    <td class="py-3 px-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($item->product->image ?? false)
                                                <img src="{{ asset($item->product->image) }}" class="rounded-3 border" style="width: 45px; height: 45px; object-fit: cover;">
                                            @else
                                                <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center text-muted x-small" style="width: 45px; height: 45px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-dark fw-bold">
                                                    {{ $item->product->name ?? 'Product Item' }}
                                                </div>
                                                <div class="x-small text-muted">
                                                    SKU: {{ $item->product->sku ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 fw-bold text-dark">
                                        ₹{{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <span class="badge bg-light text-dark border px-3 py-2 fw-bold fs-6">{{ $item->quantity }}</span>
                                    </td>
                                    <td class="py-3 px-3 text-end fw-bold text-primary">
                                        ₹{{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted small">No item breakdown details found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-4 p-5 text-center shadow-sm border">
                <i class="bi bi-check-circle fs-1 d-block mb-3 text-success"></i>
                <h6 class="fw-bold text-dark mb-1">No Pending Payments or Abandoned Checkouts</h6>
                <p class="small text-muted mb-0">Currently there are no pending or abandoned checkouts requiring attention.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-end mt-4">
        {{ $pendingOrders->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
@endsection
