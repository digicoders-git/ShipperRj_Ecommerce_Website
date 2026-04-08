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
                    <div class="dashboard-card p-3 p-lg-4">
                        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                            <div>
                                <h4 class="fw-black mb-0 letter-spacing-n1">My Orders</h4>
                                <p class="text-muted xx-small mb-0 fw-medium">Track your journey and milestones.</p>
                            </div>
                            <div
                                class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill x-small fw-bold border border-primary border-opacity-10">
                                {{ $orders->total() }} Total
                            </div>
                        </div>

                        @if($orders->count() > 0)
                            <div class="orders-table-wrap">
                                <table class="orders-table">
                                    <thead>
                                        <tr>
                                            <th class="th-order">Order</th>
                                            <th class="th-collection">Collection</th>
                                            <th class="th-payment">Payment</th>
                                            <th class="th-status">Status</th>
                                            <th class="th-action">Action</th>
                                            <th class="th-feedback">Feedback</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td class="td-order">
                                                    <span class="order-num">#{{ $order->order_number }}</span>
                                                    <span class="order-date">{{ $order->created_at->format('d M, Y') }}</span>
                                                </td>
                                                <td class="td-collection">
                                                    <div class="collection-inner">
                                                        <div class="avatar-stack">
                                                            @foreach($order->orderItems->take(3) as $item)
                                                                <div class="avatar-chip">
                                                                    <img src="{{ asset($item->product->image ?? 'assets/images/placeholder.png') }}"
                                                                        alt="">
                                                                </div>
                                                            @endforeach
                                                            @if($order->orderItems->count() > 3)
                                                                <div class="avatar-chip avatar-more">
                                                                    +{{ $order->orderItems->count() - 3 }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="collection-meta">
                                                            <span
                                                                class="collection-name">{{ Str::limit($order->orderItems->first()->product->name ?? 'Package', 28) }}</span>
                                                            <span class="collection-count">{{ $order->orderItems->count() }}
                                                                {{ Str::plural('item', $order->orderItems->count()) }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="td-payment">
                                                    <span
                                                        class="payment-amount">₹{{ number_format($order->total_amount, 2) }}</span>
                                                    @if($order->payment_method == 'cod')
                                                        <div class="payment-split">
                                                            <span class="split-adv">Adv
                                                                ₹{{ number_format($order->prepaid_amount, 2) }}</span>
                                                            <span class="split-sep">·</span>
                                                            <span class="split-due">Due ₹{{ number_format($order->cod_amount, 2) }}</span>
                                                        </div>
                                                    @else
                                                        <span class="payment-badge-online">Online</span>
                                                    @endif
                                                </td>
                                                <td class="td-status">
                                                    @php
                                                        $status = strtolower($order->order_status);
                                                        $statusMap = [
                                                            'placed' => ['cls' => 'st-placed', 'text' => 'Placed'],
                                                            'confirmed' => ['cls' => 'st-confirmed', 'text' => 'Confirmed'],
                                                            'processing' => ['cls' => 'st-processing', 'text' => 'In Prep'],
                                                            'dispatched' => ['cls' => 'st-dispatched', 'text' => 'Dispatched'],
                                                            'shipped' => ['cls' => 'st-shipped', 'text' => 'On the Way'],
                                                            'out_for_delivery' => ['cls' => 'st-ofd', 'text' => 'Out for Delivery'],
                                                            'delivered' => ['cls' => 'st-delivered', 'text' => 'Delivered'],
                                                            'cancelled' => ['cls' => 'st-cancelled', 'text' => 'Cancelled'],
                                                            'returned' => ['cls' => 'st-returned', 'text' => 'Returned'],
                                                        ];
                                                        $cur = $statusMap[$status] ?? ['cls' => 'st-default', 'text' => str_replace('_', ' ', $order->order_status)];
                                                    @endphp
                                                    <span class="status-pill {{ $cur['cls'] }}">
                                                        <i class="status-dot"></i>{{ $cur['text'] }}
                                                    </span>
                                                </td>
                                                <td class="td-action">
                                                    <div class="action-group">
                                                        <a href="{{ route('orders.track', $order->order_number) }}"
                                                            class="act-btn act-track">Track</a>
                                                        <a href="{{ route('order.invoice', $order->id) }}" target="_blank"
                                                            class="act-btn act-invoice">Invoice</a>

                                                        @if(in_array(strtolower($order->order_status), ['placed', 'confirmed']))
                                                            <button type="button" class="act-btn act-cancel" data-bs-toggle="modal"
                                                                data-bs-target="#cancelOrderModal{{$order->id}}">Cancel</button>
                                                        @endif

                                                        @php
                                                            $isDelivered = strtolower($order->order_status) == 'delivered';
                                                            $canReturn = false;
                                                            if ($isDelivered) {
                                                                $deliveryDate = $order->delivered_at ?? $order->updated_at;
                                                                $maxReturnDays = $order->orderItems->max(function ($item) {
                                                                    return $item->product->return_days ?? 7;
                                                                });
                                                                if ($deliveryDate->diffInDays(now()) <= $maxReturnDays) {
                                                                    $canReturn = true;
                                                                }
                                                            }
                                                        @endphp

                                                        @if($canReturn && !$order->return_status)
                                                            <button type="button" class="act-btn act-return" data-bs-toggle="modal"
                                                                data-bs-target="#returnOrderModal{{$order->id}}">Return</button>
                                                        @elseif($order->return_status)
                                                            <span
                                                                class="return-status-badge">{{ strtoupper($order->return_status) }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="td-feedback">
                                                    @if(strtolower($order->order_status) == 'delivered')
                                                        <button type="button" class="act-btn act-review" data-bs-toggle="modal"
                                                            data-bs-target="#reviewModal{{$order->id}}">Review</button>
                                                    @else
                                                        <span class="feedback-locked">
                                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2.5">
                                                                <rect x="3" y="11" width="18" height="11" rx="2" />
                                                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                                            </svg>
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-5 d-flex justify-content-center">
                                <div class="custom-pagination">
                                    {{ $orders->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-5">
                                <i class="bi bi-bag-x display-1 text-muted opacity-25 d-block mb-3"></i>
                                <h4 class="fw-black text-dark">No Orders Yet</h4>
                                <p class="text-muted small">Your stylish journey starts here. Explore our collections!</p>
                                <a href="{{ route('products.index') }}"
                                    class="btn btn-primary rounded-pill px-5 fw-black mt-3">START SHOPPING</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('modals')
        @foreach($orders as $order)
            @if(strtolower($order->order_status) == 'delivered')
                <div class="modal fade" id="reviewModal{{$order->id}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
                            <div class="modal-header border-0 pb-0 pt-4 px-4">
                                <h5 class="modal-title fw-black letter-spacing-n1">Share Your Experience</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                @foreach($order->orderItems as $item)
                                    @php
                                        $hasReviewed = \App\Models\ProductReview::where('user_id', Auth::id())->where('product_id', $item->product_id)->exists();
                                    @endphp
                                    <div class="card mb-3 border shadow-none rounded-4 p-3 bg-light bg-opacity-25">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset($item->product->image) }}" class="rounded-3 shadow-sm"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @endif
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 fw-bold small">{{ Str::limit($item->product->name ?? 'Product', 40) }}</h6>
                                                @if($hasReviewed)
                                                    <span class="badge bg-success-soft text-success xx-small mt-1">Reviewed</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if(!$hasReviewed)
                                            <form action="{{ route('product.review.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                                <div class="mb-3">
                                                    <label class="form-label xx-small fw-black uppercase opacity-50">Rate this product</label>
                                                    <div class="star-rating d-flex gap-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <div class="form-check form-check-inline p-0 m-0">
                                                                <input class="btn-check" type="radio" name="rating" id="rating{{$item->id}}_{{$i}}"
                                                                    value="{{$i}}" required {{ $i == 5 ? 'checked' : '' }}>
                                                                <label class="btn btn-outline-warning btn-sm border-0 p-1"
                                                                    for="rating{{$item->id}}_{{$i}}">
                                                                    <i class="bi bi-star-fill fs-5"></i>
                                                                </label>
                                                            </div>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label xx-small fw-black uppercase opacity-50">Write a comment</label>
                                                    <textarea name="comment" class="form-control border-0 bg-white" rows="3"
                                                        placeholder="Describe your experience..."
                                                        style="border-radius: 12px; font-size: 0.9rem;"></textarea>
                                                </div>
                                                <button type="submit"
                                                    class="btn btn-primary w-100 fw-black rounded-pill py-2 small shadow-sm">SUBMIT
                                                    REVIEW</button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- @if(in_array(strtolower($order->order_status), ['placed', 'confirmed'])) --}}
            @if(strtolower($order->order_status) == 'placed')
                <div class="modal fade" id="cancelOrderModal{{$order->id}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
                            <div class="modal-header border-0 pb-0 pt-4 px-4">
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="w-100">
                                    @csrf
                                    <h5 class="modal-title fw-black mb-3 letter-spacing-n1">Cancel Order #{{ $order->order_number }}
                                    </h5>
                                    <div class="alert alert-warning-soft text-warning x-small border-0 rounded-4 p-3 mb-4">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Once cancelled, the refund will be processed and you'll receive the amount back on your original
                                        payment method (if online).
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label xx-small fw-black uppercase opacity-50 ps-1">Reason for
                                            Cancellation</label>
                                        <textarea name="cancel_reason" class="form-control border-0 bg-light bg-opacity-50" rows="3"
                                            required placeholder="Tell us why you want to cancel this order..."
                                            style="border-radius: 12px;"></textarea>
                                    </div>
                                    <div class="d-flex gap-2 mb-4">
                                        <button type="button" class="btn btn-light rounded-pill w-100 fw-bold py-2 border"
                                            data-bs-dismiss="modal">NOT NOW</button>
                                        <button type="submit"
                                            class="btn btn-danger-soft text-danger w-100 rounded-pill border-0 py-2 fw-black shadow-sm">CONFIRM
                                            CANCEL</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @php
                $isDelivered = strtolower($order->order_status) == 'delivered';
                $canReturn = false;
                if ($isDelivered) {
                    $deliveryDate = $order->delivered_at ?? $order->updated_at;
                    $maxReturnDays = $order->orderItems->max(function ($item) {
                        return $item->product->return_days ?? 7;
                    });
                    if ($deliveryDate->diffInDays(now()) <= $maxReturnDays) {
                        $canReturn = true;
                    }
                }
            @endphp

            @if($canReturn && !$order->return_status)
                <div class="modal fade" id="returnOrderModal{{$order->id}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
                            <div class="modal-header border-0 pb-0 pt-4 px-4">
                                <form action="{{ route('orders.return', $order->id) }}" method="POST" class="w-100">
                                    @csrf
                                    <h5 class="modal-title fw-black mb-3 letter-spacing-n1">Return Request #{{ $order->order_number }}
                                    </h5>
                                    <div class="alert alert-primary-soft text-primary x-small border-0 rounded-4 p-3 mb-4">
                                        <i class="bi bi-shield-check me-2"></i>
                                        We values your trust. Please describe the issue and our team will approve the return shortly.
                                    </div>
                                    <div class="mb-4 text-start">
                                        <label class="form-label xx-small fw-black uppercase opacity-50 ps-1">Items being
                                            returned</label>
                                        <ul class="list-unstyled p-0 m-0 x-small fw-medium opacity-75">
                                            @foreach($order->orderItems as $item)
                                                <li class="mb-1 d-flex gap-2">
                                                    <i class="bi bi-check2-circle text-success"></i> {{ $item->product->name }}
                                                    (x{{ $item->quantity }})
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label xx-small fw-black uppercase opacity-50 ps-1">Reason for Return</label>
                                        <textarea name="return_reason" class="form-control border-0 bg-light bg-opacity-50" rows="3"
                                            required placeholder="Size issue, damaged product, or something else?"
                                            style="border-radius: 12px;"></textarea>
                                    </div>
                                    <div class="d-flex gap-2 mb-4">
                                        <button type="button" class="btn btn-light rounded-pill w-100 fw-bold py-2 border"
                                            data-bs-dismiss="modal">DISMISS</button>
                                        <button type="submit"
                                            class="btn btn-warning-soft text-warning w-100 rounded-pill border-0 py-2 fw-black shadow-sm">SUBMIT
                                            REQUEST</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endpush

    @push('styles')
        <style>
            /* ── Table wrapper ── */
            .orders-table-wrap {
                overflow-x: auto;
                border-radius: 16px;
                border: 1px solid #f0f0f0;
            }

            /* ── Table base ── */
            .orders-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 13px;
            }

            /* ── Header ── */
            .orders-table thead tr {
                background: #fafafa;
                border-bottom: 1px solid #efefef;
            }

            .orders-table thead th {
                padding: 11px 14px;
                font-size: 10px;
                font-weight: 800;
                letter-spacing: 0.9px;
                text-transform: uppercase;
                color: #aaa;
                white-space: nowrap;
                border: none;
            }

            .th-order {
                width: 12%;
            }

            .th-collection {
                width: 30%;
            }

            .th-payment {
                width: 16%;
                text-align: center;
            }

            .th-status {
                width: 14%;
                text-align: center;
            }

            .th-action {
                width: 18%;
                text-align: center;
            }

            .th-feedback {
                width: 10%;
                text-align: center;
            }

            /* ── Body rows ── */
            .orders-table tbody tr {
                border-bottom: 1px solid #f5f5f5;
                transition: background 0.15s ease;
            }

            .orders-table tbody tr:last-child {
                border-bottom: none;
            }

            .orders-table tbody tr:hover {
                background: #fafbff;
            }

            .orders-table tbody td {
                padding: 13px 14px;
                vertical-align: middle;
            }

            /* ── Order cell ── */
            .td-order {
                white-space: nowrap;
            }

            .order-num {
                display: block;
                font-weight: 800;
                font-size: 12.5px;
                color: #1a1a1a;
                letter-spacing: -0.3px;
            }

            .order-date {
                display: block;
                font-size: 11px;
                color: #aaa;
                font-weight: 600;
                margin-top: 2px;
            }

            /* ── Collection cell ── */
            .collection-inner {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .avatar-stack {
                display: flex;
                align-items: center;
            }

            .avatar-chip {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                border: 2px solid #fff;
                overflow: hidden;
                margin-left: -6px;
                background: #f3f3f3;
                flex-shrink: 0;
            }

            .avatar-chip:first-child {
                margin-left: 0;
            }

            .avatar-chip img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .avatar-more {
                background: #f0f0f0;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 9px;
                font-weight: 800;
                color: #888;
            }

            .collection-meta {
                min-width: 0;
            }

            .collection-name {
                display: block;
                font-weight: 700;
                color: #1a1a1a;
                font-size: 12.5px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 160px;
            }

            .collection-count {
                display: block;
                font-size: 10.5px;
                color: #bbb;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-top: 1px;
            }

            /* ── Payment cell ── */
            .td-payment {
                text-align: center;
            }

            .payment-amount {
                display: block;
                font-weight: 800;
                font-size: 13.5px;
                color: #1a1a1a;
                letter-spacing: -0.3px;
            }

            .payment-split {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 4px;
                margin-top: 3px;
            }

            .split-adv {
                font-size: 10px;
                font-weight: 700;
                color: #19875499;
            }

            .split-due {
                font-size: 10px;
                font-weight: 700;
                color: #dc354599;
            }

            .split-sep {
                font-size: 10px;
                color: #ccc;
            }

            .payment-badge-online {
                display: inline-block;
                margin-top: 3px;
                font-size: 9.5px;
                font-weight: 800;
                letter-spacing: 0.5px;
                text-transform: uppercase;
                color: #198754;
                background: rgba(25, 135, 84, 0.08);
                padding: 2px 8px;
                border-radius: 20px;
            }

            /* ── Status pill ── */
            .td-status {
                text-align: center;
            }

            .status-pill {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 4px 10px;
                border-radius: 20px;
                font-size: 10px;
                font-weight: 800;
                letter-spacing: 0.6px;
                text-transform: uppercase;
                white-space: nowrap;
            }

            .status-dot {
                width: 5px;
                height: 5px;
                border-radius: 50%;
                background: currentColor;
                display: inline-block;
                flex-shrink: 0;
            }

            .st-placed {
                background: rgba(242, 112, 26, .09);
                color: #c85d00;
            }

            .st-confirmed {
                background: rgba(13, 202, 240, .09);
                color: #0591b0;
            }

            .st-processing {
                background: rgba(13, 202, 240, .09);
                color: #0591b0;
            }

            .st-dispatched {
                background: rgba(242, 112, 26, .09);
                color: #c85d00;
            }

            .st-shipped {
                background: rgba(242, 112, 26, .09);
                color: #c85d00;
            }

            .st-ofd {
                background: rgba(13, 110, 253, .09);
                color: #0d6efd;
            }

            .st-delivered {
                background: rgba(25, 135, 84, .09);
                color: #0f6b40;
            }

            .st-cancelled {
                background: rgba(220, 53, 69, .09);
                color: #b02a37;
            }

            .st-returned {
                background: rgba(33, 37, 41, .07);
                color: #444;
            }

            .st-default {
                background: rgba(108, 117, 125, .09);
                color: #555;
            }

            /* ── Action buttons ── */
            .td-action {
                text-align: center;
            }

            .action-group {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 5px;
                flex-wrap: wrap;
            }

            .act-btn {
                display: inline-block;
                padding: 4px 11px;
                border-radius: 20px;
                font-size: 10px;
                font-weight: 800;
                letter-spacing: 0.5px;
                text-transform: uppercase;
                cursor: pointer;
                border: none;
                text-decoration: none;
                transition: all 0.18s ease;
                white-space: nowrap;
                line-height: 1.6;
            }

            .act-track {
                background: #f0f0f0;
                color: #444;
            }

            .act-track:hover {
                background: #0d6efd;
                color: #fff;
            }

            .act-cancel {
                background: rgba(220, 53, 69, .08);
                color: #b02a37;
            }

            .act-cancel:hover {
                background: #dc3545;
                color: #fff;
            }

            .act-return {
                background: rgba(242, 112, 26, .08);
                color: #c85d00;
            }

            .act-return:hover {
                background: #f2701a;
                color: #fff;
            }

            .act-review {
                background: rgba(25, 135, 84, .08);
                color: #0f6b40;
            }

            .act-review:hover {
                background: #198754;
                color: #fff;
            }

            .act-invoice {
                background: rgba(13, 202, 240, .08);
                color: #0591b0;
            }

            .act-invoice:hover {
                background: #0dcaf0;
                color: #fff;
            }

            .return-status-badge {
                font-size: 9.5px;
                font-weight: 800;
                letter-spacing: 0.5px;
                color: #0591b0;
                background: rgba(13, 202, 240, .08);
                padding: 3px 9px;
                border-radius: 20px;
            }

            /* ── Feedback cell ── */
            .td-feedback {
                text-align: center;
            }

            .feedback-locked {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: #ccc;
            }

            /* ── Pagination ── */
            .custom-pagination nav svg {
                width: 14px !important;
                height: 14px !important;
            }

            .custom-pagination .pagination {
                gap: 6px;
            }

            .custom-pagination .page-link {
                border: 1px solid #eee;
                border-radius: 12px !important;
                padding: 10px 18px;
                font-weight: 800;
                color: #444;
                font-size: 0.85rem;
                transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }

            .custom-pagination .page-item.active .page-link {
                background: var(--bs-primary);
                border-color: var(--bs-primary);
                color: #fff;
                box-shadow: 0 8px 15px rgba(var(--bs-primary-rgb), 0.25);
            }

            .custom-pagination .page-link:hover {
                background: #fff;
                border-color: var(--bs-primary);
                color: var(--bs-primary);
                transform: translateY(-3px);
            }

            /* ── Soft color utilities (used in modals) ── */
            .bg-warning-soft {
                background-color: rgba(242, 112, 26, .08) !important;
            }

            .bg-primary-soft {
                background-color: rgba(13, 110, 253, .08) !important;
            }

            .bg-success-soft {
                background-color: rgba(25, 135, 84, .08) !important;
            }

            .bg-danger-soft {
                background-color: rgba(220, 53, 69, .08) !important;
            }

            .bg-info-soft {
                background-color: rgba(13, 202, 240, .08) !important;
            }

            .bg-dark-soft {
                background-color: rgba(33, 37, 41, .08) !important;
            }
        </style>
    @endpush
@endsection