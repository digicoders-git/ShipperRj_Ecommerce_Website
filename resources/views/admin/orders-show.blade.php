@extends('layouts.admin')

@section('title', 'Order Details')

@section('admin_content')
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <h4 class="fw-black text-dark mb-1">Order #{{ $order->id }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}"
                            class="text-primary text-decoration-none small fw-bold">Orders</a></li>
                    <li class="breadcrumb-item active small fw-bold text-secondary" aria-current="page">Details</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.index') }}"
                class="btn btn-light border bg-white px-3 shadow-sm rounded-3 small fw-bold transition-all">
                <i class="bi bi-arrow-left me-1 text-secondary"></i> <span class="text-secondary">Back to List</span>
            </a>
            <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank"
                class="btn btn-info px-4 py-2 shadow-sm rounded-3 border-0 transition-all hover-scale fw-bold text-white">
                <i class="bi bi-file-earmark-pdf me-2"></i> Generate Invoice
            </a>
            <button class="btn btn-premium px-4 py-2 shadow-lg rounded-3 border-0 transition-all hover-scale"
                data-bs-toggle="modal" data-bs-target="#updateOrderModal{{ $order->id }}">
                <i class="bi bi-pencil-square me-2"></i> Update Order Status
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Details & Items -->
        <div class="col-lg-8">
            <!-- Order Stats Overview Header -->
            <div class="row g-3 mb-4 text-dark">
                <div class="col-sm-4">
                    <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white border-start border-4 border-primary">
                        <p class="xx-small text-secondary fw-black uppercase tracking-widest mb-1 opacity-75">Current Status
                        </p>
                        <div class="d-flex align-items-center gap-2">
                            @php
                                $statusColors = [
                                    'placed' => 'primary',
                                    'confirmed' => 'info',
                                    'processing' => 'info',
                                    'dispatched' => 'warning',
                                    'shipped' => 'warning',
                                    'out_for_delivery' => 'warning',
                                    'delivered' => 'success',
                                    'cancelled' => 'danger',
                                    'returned' => 'dark'
                                ];
                                $color = $statusColors[strtolower($order->order_status)] ?? 'secondary';
                            @endphp
                            <span
                                class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} px-3 py-1 rounded-pill x-small fw-black uppercase tracking-widest">
                                {{ str_replace('_', ' ', $order->order_status) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white border-start border-4 border-info">
                        <p class="xx-small text-secondary fw-black uppercase tracking-widest mb-1 opacity-75">Payment Method
                        </p>
                        <h6 class="fw-black mb-0 uppercase small">{{ str_replace('_', ' ', $order->payment_method) }}</h6>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white border-start border-4 border-success">
                        <p class="xx-small text-secondary fw-black uppercase tracking-widest mb-1 opacity-75">Date & Time
                        </p>
                        <h6 class="fw-black mb-0 small">{{ $order->created_at->format('d M, Y - h:i A') }}</h6>
                    </div>
                </div>
                @if($order->tracking_link)
                    <div class="col-sm-12">
                        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white border-start border-4 border-primary">
                            <p class="xx-small text-secondary fw-black uppercase tracking-widest mb-1 opacity-75">Live Tracking
                                Link</p>
                            <a href="{{ $order->tracking_link }}" target="_blank"
                                class="small fw-bold text-primary text-truncate d-block">{{ $order->tracking_link }}</a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Order Items Card -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
                <div class="card-header bg-white border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-black text-dark tracking-tight mb-0">
                        <i class="bi bi-cart3 text-primary me-2"></i>Order Summary
                    </h6>
                    <span
                        class="badge bg-secondary bg-opacity-10 text-secondary border border-dark border-opacity-10 px-2 py-1 xx-small fw-bold">
                        {{ $order->orderItems->count() }} ITEM(S)
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="bg-light bg-opacity-50">
                                <tr class="xx-small text-secondary fw-black uppercase tracking-tighter">
                                    <th class="ps-4 py-3">Product Name</th>
                                    <th class="py-3 text-center">Price</th>
                                    <th class="py-3 text-center">Quantity</th>
                                    <th class="pe-4 py-3 text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr class="border-bottom border-light">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3 py-2">
                                                <div class="position-relative">
                                                    <div class="rounded-3 border border-dark border-opacity-10 p-1 bg-white"
                                                        style="width: 55px; height: 55px;">
                                                        <img src="{{ asset($item->product->image) }}"
                                                            class="img-fluid rounded-2 h-100 w-100 object-fit-contain" alt="">
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="small fw-black text-dark mb-0 line-clamp-1">
                                                        {{ $item->product->name }}</div>
                                                    <div class="xx-small text-secondary tracking-widest uppercase opacity-75">
                                                        SKU: {{ $item->product->sku ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center small fw-bold text-dark">₹{{ number_format($item->price, 2) }}
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-light text-dark px-3 py-1 rounded-pill small border border-dark border-opacity-10">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="pe-4 text-end small fw-black text-dark">
                                            ₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light bg-opacity-25 border-top-0 p-4">
                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="xx-small text-secondary fw-black uppercase tracking-widest">Net Amount</span>
                                <span
                                    class="small fw-bold text-dark">₹{{ number_format($order->total_amount - $order->shipping_amount + $order->coupon_discount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="xx-small text-secondary fw-black uppercase tracking-widest">Shipping
                                    Charges</span>
                                <span
                                    class="small fw-bold text-dark">₹{{ number_format($order->shipping_amount, 2) }}</span>
                            </div>
                            @if($order->coupon_discount > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="xx-small text-secondary fw-black uppercase tracking-widest">Coupon Discount
                                        ({{ $order->coupon_code }})</span>
                                    <span
                                        class="small fw-bold text-success">-₹{{ number_format($order->coupon_discount, 2) }}</span>
                                </div>
                            @endif

                            <div class="dashed-divider my-2"></div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="xx-small text-secondary fw-black uppercase tracking-widest">Advanced
                                    Paid</span>
                                <span
                                    class="small fw-bold text-primary">₹{{ number_format($order->prepaid_amount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 border-top border-dark border-opacity-5 pt-2">
                                <span class="xx-small text-danger fw-black uppercase tracking-widest">COD Pending</span>
                                <span class="small fw-black text-danger">₹{{ number_format($order->cod_amount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mt-3 pt-3 border-top border-dark border-opacity-10">
                                <h6 class="fw-black text-dark uppercase tracking-widest mb-0 small">Grand Total</h6>
                                <h4 class="fw-black text-primary mb-0">₹{{ number_format($order->total_amount, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tracking Timeline -->
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div class="card-header bg-white border-0 p-4 pb-2">
                    <h6 class="fw-black text-dark mb-0">
                        <i class="bi bi-clock-history text-primary me-2"></i>Order Timeline & Activities
                    </h6>
                </div>
                <div class="card-body p-4 pt-1">
                    <div class="timeline position-relative ps-4 py-3">
                        <div
                            class="timeline-line position-absolute start-0 top-0 bottom-0 ms-1 border-start border-2 border-light border-opacity-75">
                        </div>

                        @forelse($order->orderTrackings as $track)
                            <div class="timeline-item position-relative mb-4 last-no-border">
                                <div class="timeline-marker position-absolute rounded-circle bg-primary border border-4 border-white shadow-sm"
                                    style="width: 18px; height: 18px; left: -28px; top: 2px;"></div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="x-small fw-black text-dark uppercase mb-0">{{ $track->status }}</h6>
                                    <span
                                        class="xx-small text-secondary opacity-75 font-monospace">{{ $track->created_at->format('d M, Y | h:i A') }}</span>
                                </div>
                                <p class="small text-secondary mb-0 p-3 rounded-3 bg-light bg-opacity-50 border border-light">
                                    {{ $track->message }}</p>
                            </div>
                        @empty
                            <div class="text-center py-5 opacity-40">
                                <i class="bi bi-inbox fs-2 d-block mb-3"></i>
                                <p class="small fw-bold">No tracking records available for this order.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Customer & Delivery Info -->
        <div class="col-lg-4">
            <!-- Customer Details -->
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h6 class="fw-black text-dark mb-0 uppercase tracking-widest x-small">Customer Profile</h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-4 bg-primary bg-opacity-10 text-light d-flex align-items-center justify-content-center border-0"
                            style="width: 55px; height: 55px;">
                            <i class="bi bi-person h4 mb-0"></i>
                        </div>
                        <div>
                            <h6 class="fw-black text-dark mb-0 small">{{ $order->user->name }}</h6>
                            <p class="xx-small text-secondary fw-bold mb-0 opacity-75">{{ $order->user->email }}</p>
                            <p class="xx-small text-secondary fw-bold mb-0 opacity-75">{{ $order->user->mobile }}</p>
                        </div>
                    </div>

                    <hr class="border-dark border-opacity-5 my-4">

                    <div class="mb-4">
                        <h6 class="xx-small text-secondary fw-black uppercase tracking-widest mb-3 opacity-75">Shipping
                            Address</h6>
                        <div class="bg-light bg-opacity-50 p-3 rounded-4 border border-light">
                            <h6 class="small fw-black text-dark mb-1">{{ $order->address->name }}</h6>
                            <p class="x-small text-secondary mb-1 fw-medium lh-base">
                                {{ $order->address->address_line1 }}<br>
                                @if($order->address->address_line2)
                                    {{ $order->address->address_line2 }}<br>
                                @endif
                                {{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->pincode }}
                            </p>
                            <div class="mt-2 d-flex align-items-center gap-2">
                                <i class="bi bi-phone-vibrate text-primary xx-small"></i>
                                <span class="x-small fw-black text-dark">{{ $order->address->phone }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Insight Card -->
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div class="card-header bg-white border-0 p-4 pb-0 d-flex justify-content-between">
                    <h6 class="fw-black text-dark mb-0 uppercase tracking-widest x-small">Payment Insight</h6>
                    @if($order->payment_status == 'paid')
                        <i class="bi bi-patch-check-fill text-success"></i>
                    @endif
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3 border-bottom border-light pb-2">
                        <span class="xx-small text-secondary fw-black uppercase tracking-widest">Payment Status</span>
                        <span
                            class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} bg-opacity-10 text-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} px-3 py-1 rounded-pill xx-small fw-black uppercase">
                            {{ $order->payment_status }}
                        </span>
                    </div>

                    @if($order->razorpay_payment_id)
                        <div class="mb-3">
                            <span class="xx-small text-secondary fw-black uppercase tracking-widest d-block mb-1">Gateway
                                Reference</span>
                            <div
                                class="small fw-black text-light bg-primary bg-opacity-5 p-2 rounded border border-primary border-opacity-10 font-monospace">
                                {{ $order->razorpay_payment_id }}
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="xx-small text-secondary fw-black uppercase tracking-widest">Transaction Method</span>
                        <span class="small fw-black text-dark uppercase">{{ $order->payment_method }}</span>
                    </div>
                </div>
            </div>

            <!-- Internal Notes -->
            <!-- <div class="card border-0 shadow-sm rounded-4 bg-gradient-light" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                <div class="card-body p-4">
                    <h6 class="fw-black text-dark mb-3 uppercase tracking-widest x-small">Administrator Notes</h6>
                    @if($order->admin_note)
                        <div class="p-3 bg-white bg-opacity-50 rounded-3 border border-dark border-opacity-5 small text-secondary italic">
                            "{{ $order->admin_note }}"
                        </div>
                    @else
                        <div class="text-center py-2">
                            <span class="xx-small text-secondary opacity-50 fw-bold italic">No internal notes for this shipment.</span>
                        </div>
                    @endif
                    <button class="btn btn-outline-dark btn-sm w-100 mt-3 rounded-pill fw-bold x-small opacity-75" data-bs-toggle="modal" data-bs-target="#updateOrderModal{{ $order->id }}">
                        Add Private Note
                    </button>
                </div>
            </div> -->
        </div>
    </div>

@endsection

@push('modals')
    <!-- Modal Fix: Background and Colors -->
    <div class="modal fade" id="updateOrderModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-2xl rounded-4" style="background: #ffffff;">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-black text-dark mb-0">Order Control Center #{{ $order->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-4">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label
                                    class="xx-small text-secondary fw-black uppercase tracking-widest mb-2 d-block">Logistics
                                    Status</label>
                                <select name="order_status"
                                    class="form-select shadow-none border-1 x-small fw-bold py-2 rounded-3 bg-light order-status-select"
                                    data-order-id="{{ $order->id }}">
                                    <option value="placed" {{ $order->order_status == 'placed' ? 'selected' : '' }}>Order
                                        Placed</option>
                                    <option value="confirmed" {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>
                                        Confirmed</option>
                                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>
                                        Processing</option>
                                    <option value="dispatched" {{ $order->order_status == 'dispatched' ? 'selected' : '' }}>
                                        Dispatched</option>
                                    <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped
                                    </option>
                                    <option value="out_for_delivery" {{ $order->order_status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                    <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>
                                        Delivered</option>
                                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                    <option value="returned" {{ $order->order_status == 'returned' ? 'selected' : '' }}>
                                        Returned</option>
                                </select>
                            </div>
                            <div class="col-12 mt-3" id="trackingLinkContainer{{ $order->id }}"
                                style="{{ $order->order_status == 'confirmed' ? '' : 'display: none;' }}">
                                <label class="xx-small text-secondary fw-black uppercase tracking-widest mb-2 d-block">Live
                                    Tracking Link</label>
                                <input type="url" name="tracking_link"
                                    class="form-control shadow-none border-1 x-small fw-bold py-2 rounded-3 bg-light"
                                    placeholder="Paste the live tracking link here..." value="{{ $order->tracking_link }}">
                            </div>
                            <div class="col-6">
                                <label
                                    class="xx-small text-secondary fw-black uppercase tracking-widest mb-2 d-block">Settlement
                                    Status</label>
                                <select name="payment_status"
                                    class="form-select shadow-none border-1 x-small fw-bold py-2 rounded-3 bg-light">
                                    <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid
                                    </option>
                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid
                                    </option>
                                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="xx-small text-secondary fw-black uppercase tracking-widest mb-2 d-block">Global
                                Tracking Update</label>
                            <textarea name="tracking_message"
                                class="form-control shadow-none border-1 x-small py-3 rounded-3 bg-light"
                                placeholder="Explain the current status to the customer..." rows="3" required></textarea>
                            <div class="x-small text-secondary opacity-50 mt-1"><i class="bi bi-info-circle me-1"></i>
                                Customer will see this on their dashboard tracking.</div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <button type="button"
                                class="btn btn-light px-4 py-2 rounded-pill x-small fw-black text-secondary uppercase tracking-widest border"
                                data-bs-dismiss="modal">Discard</button>
                            <button type="submit"
                                class="btn btn-premium px-4 py-2 rounded-pill x-small fw-black uppercase tracking-widest shadow-lg">Push
                                Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('styles')
    <style>
        .fw-black {
            font-weight: 800 !important;
        }

        .xx-small {
            font-size: 0.65rem !important;
        }

        .x-small {
            font-size: 0.75rem !important;
        }

        .tracking-tight {
            letter-spacing: -0.5px;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .last-no-border:last-child {
            margin-bottom: 0 !important;
        }

        .last-no-border:last-child .timeline-line {
            display: none;
        }

        /* Premium Button Background Override if needed */
        .btn-premium {
            background: linear-gradient(135deg, #FFB800 0%, #FF8A00 100%);
            color: #000 !important;
            font-weight: 800;
            border: none;
        }

        .btn-premium:hover {
            background: linear-gradient(135deg, #FF8A00 0%, #FFB800 100%);
            box-shadow: 0 5px 15px rgba(255, 184, 0, 0.4);
        }

        .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
@endpush
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelects = document.querySelectorAll('.order-status-select');
        statusSelects.forEach(select => {
            select.addEventListener('change', function() {
                const orderId = this.getAttribute('data-order-id');
                const container = document.getElementById(`trackingLinkContainer${orderId}`);
                if (this.value === 'confirmed') {
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush