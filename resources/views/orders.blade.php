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
                    <div class="dashboard-card p-4 p-lg-5">
                        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
                            <div>
                                <h3 class="fw-black mb-1 letter-spacing-n1">My Shopping Odyssey</h3>
                                <p class="text-muted small mb-0 fw-medium">Relive your purchases and trace their journey to
                                    your doorstep.</p>
                            </div>
                            <div class="badge bg-primary-soft text-primary px-4 py-2 rounded-pill small fw-bold">
                                {{ $orders->total() }} Milestones
                            </div>
                        </div>

                        @if($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-premium align-middle">
                                    <thead class="bg-light bg-opacity-50">
                                        <tr>
                                            <th style="width: 15%"
                                                class="ps-3 uppercase xx-small fw-black tracking-widest text-dark py-3">ID &
                                                DATE</th>
                                            <th style="width: 30%"
                                                class="uppercase xx-small fw-black tracking-widest text-dark py-3">COLLECTION
                                            </th>
                                            <th style="width: 15%"
                                                class="uppercase xx-small fw-black tracking-widest text-dark text-center py-3">
                                                PAYMENT</th>
                                            <th style="width: 15%"
                                                class="uppercase xx-small fw-black tracking-widest text-dark text-center py-3">
                                                STATUS</th>
                                            <th style="width: 12%"
                                                class="uppercase xx-small fw-black tracking-widest text-dark text-center py-3">
                                                ACTION</th>
                                            <th style="width: 13%"
                                                class="pe-3 text-end uppercase xx-small fw-black tracking-widest text-dark py-3">
                                                FEEDBACK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr class="transition-all hover-translate-y">
                                                <td class="ps-0 py-4">
                                                    <span class="d-block fw-black text-dark mb-1">#{{ $order->order_number }}</span>
                                                    <span
                                                        class="x-small text-muted fw-medium">{{ $order->created_at->format('d M, Y') }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="avatar-group d-flex">
                                                            @foreach($order->orderItems->take(3) as $item)
                                                                <div class="avatar-sm rounded-circle border border-2 border-white overflow-hidden shadow-sm ms-n2 first-ms-0"
                                                                    style="width: 32px; height: 32px; background: #f8f9fa;">
                                                                    <img src="{{ asset($item->product->image ?? 'assets/images/placeholder.png') }}"
                                                                        class="w-100 h-100 object-fit-cover">
                                                                </div>
                                                            @endforeach
                                                            @if($order->orderItems->count() > 3)
                                                                <div class="avatar-sm rounded-circle border border-2 border-white bg-light text-muted x-small d-flex align-items-center justify-content-center shadow-sm ms-n2"
                                                                    style="width: 32px; height: 32px; font-weight: 800;">
                                                                    +{{ $order->orderItems->count() - 3 }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <span
                                                                class="d-block small fw-bold text-dark">{{ $order->orderItems->first()->product->name ?? 'Package' }}</span>
                                                            <span
                                                                class="xx-small text-muted fw-bold uppercase">{{ $order->orderItems->count() }}
                                                                {{ Str::plural('Item', $order->orderItems->count()) }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-inline-block text-start">
                                                        <span
                                                            class="d-block fw-black text-dark fs-6">₹{{ number_format($order->total_amount, 2) }}</span>
                                                        @if($order->payment_method == 'cod')
                                                            <div class="d-flex align-items-center gap-1 mt-1">
                                                                <span class="xx-small text-success fw-bold">Adv:
                                                                    ₹{{ number_format($order->prepaid_amount) }}</span>
                                                                <span class="xx-small text-muted opacity-25">|</span>
                                                                <span class="xx-small text-danger fw-bold">Due:
                                                                    ₹{{ number_format($order->cod_amount) }}</span>
                                                            </div>
                                                        @else
                                                            <span
                                                                class="badge bg-success-soft text-success xx-small fw-bold uppercase px-2 mt-1">Full
                                                                Online</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $status = strtolower($order->order_status);
                                                        $statusMap = [
                                                            'placed' => ['bg' => 'warning', 'text' => 'Placed'],
                                                            'confirmed' => ['bg' => 'info', 'text' => 'Confirmed'],
                                                            'processing' => ['bg' => 'info', 'text' => 'In Prep'],
                                                            'dispatched' => ['bg' => 'warning', 'text' => 'Dispatched'],
                                                            'shipped' => ['bg' => 'warning', 'text' => 'On the Way'],
                                                            'out_for_delivery' => ['bg' => 'warning', 'text' => 'Out for Delivery'],
                                                            'delivered' => ['bg' => 'success', 'text' => 'Delivered'],
                                                            'cancelled' => ['bg' => 'danger', 'text' => 'Cancelled'],
                                                            'returned' => ['bg' => 'dark', 'text' => 'Returned'],
                                                        ];
                                                        $cur = $statusMap[$status] ?? ['bg' => 'secondary', 'text' => str_replace('_', ' ', $order->order_status)];
                                                        $rgbMap = [
                                                            'primary' => '13, 110, 253',
                                                            'warning' => '242, 112, 26',
                                                            'success' => '25, 135, 84',
                                                            'danger' => '220, 53, 69',
                                                            'info' => '13, 202, 240',
                                                            'dark' => '33, 37, 41'
                                                        ];
                                                        $rgb = $rgbMap[$cur['bg']] ?? '108, 117, 125';
                                                    @endphp
                                                    <span
                                                        class="badge-status-premium bg-{{ $cur['bg'] }}-soft text-{{ $cur['bg'] }} py-1 px-3 rounded-pill xx-small fw-black uppercase tracking-wider d-inline-flex align-items-center justify-content-center gap-1"
                                                        style="border: 1px solid rgba({{ $rgb }}, 0.2) !important;">
                                                        <span class="p-1 bg-current rounded-circle me-1"
                                                            style="background-color: currentColor; width: 6px; height: 6px;"></span>
                                                        {{ $cur['text'] }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center align-items-center">
                                                        <a href="{{ route('orders.track', $order->order_number) }}"
                                                            class="btn btn-premium-outline btn-sm rounded-pill px-3 fw-black tracking-tighter">
                                                            TRACK
                                                        </a>

                                                        @if(in_array(strtolower($order->order_status), ['placed', 'confirmed']))
                                                            <button type="button"
                                                                class="btn btn-danger-soft text-danger btn-sm rounded-pill px-3 fw-black tracking-tighter border-0"
                                                                data-bs-toggle="modal" data-bs-target="#cancelOrderModal{{$order->id}}">
                                                                CANCEL
                                                            </button>
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
                                                            <button type="button"
                                                                class="btn btn-warning-soft text-warning btn-sm rounded-pill px-3 fw-black tracking-tighter border-0"
                                                                data-bs-toggle="modal" data-bs-target="#returnOrderModal{{$order->id}}">
                                                                RETURN
                                                            </button>
                                                        @elseif($order->return_status)
                                                            <span
                                                                class="badge bg-info-soft text-info xx-small fw-bold px-2 py-1 rounded-pill">{{ strtoupper($order->return_status) }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    @if(strtolower($order->order_status) == 'delivered')
                                                        <button type="button"
                                                            class="btn btn-success btn-sm rounded-pill px-3 fw-black tracking-tighter"
                                                            data-bs-toggle="modal" data-bs-target="#reviewModal{{$order->id}}">
                                                            REVIEW
                                                        </button>
                                                    @else
                                                        <span class="xx-small text-muted fw-bold opacity-50 pe-3">LOCKED</span>
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
                    </div> <!-- End Dashboard Card Inner -->
                </div>
            </div>
        </div>
    </div>

    @push('modals')
        @foreach($orders as $order)
            <!-- Review Modal (Only for delivered) -->
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

            <!-- Cancel Order Modal -->
            @if(in_array(strtolower($order->order_status), ['placed', 'confirmed']))
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

            <!-- Return Order Modal -->
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
            .badge-status-premium {
                min-width: 90px;
                letter-spacing: 0.8px;
                white-space: nowrap;
                line-height: normal;
                display: inline-flex;
                transition: all 0.3s ease;
            }

            .bg-warning-soft {
                background-color: rgba(242, 112, 26, 0.08) !important;
                color: #f2701aff !important;
            }

            .bg-primary-soft {
                background-color: rgba(13, 110, 253, 0.08) !important;
                color: #0d6efd !important;
            }

            .bg-success-soft {
                background-color: rgba(25, 135, 84, 0.08) !important;
                color: #198754 !important;
            }

            .bg-danger-soft {
                background-color: rgba(220, 53, 69, 0.08) !important;
                color: #dc3545 !important;
            }

            .bg-info-soft {
                background-color: rgba(13, 202, 240, 0.08) !important;
                color: #0dcaf0 !important;
            }

            .bg-dark-soft {
                background-color: rgba(33, 37, 41, 0.08) !important;
                color: #212529 !important;
            }

            .line-height-1 {
                line-height: 1;
            }

            .hover-translate-y:hover {
                transform: translateY(-2px);
                background-color: rgba(var(--bs-primary-rgb), 0.01);
            }

            .pipeline-container {
                height: 80px;
            }

            .pipeline-progress-bg {
                position: absolute;
                top: 22px;
                left: 20px;
                right: 20px;
                height: 4px;
                background: #f0f0f0;
                border-radius: 10px;
                z-index: 1;
            }

            .pipeline-progress-active {
                position: absolute;
                top: 22px;
                left: 20px;
                height: 4px;
                background: var(--bs-primary);
                border-radius: 10px;
                z-index: 2;
                transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .pipeline-step {
                position: relative;
                z-index: 3;
                text-align: center;
                flex: 1;
            }

            .step-icon-wrapper {
                position: relative;
                display: inline-block;
            }

            .step-icon {
                width: 48px;
                height: 48px;
                background: #fff;
                border: 2px solid #f0f0f0;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.4s ease;
                color: #ccc;
                font-size: 1.25rem;
                margin: 0 auto;
            }

            .pipeline-step.active .step-icon {
                background: var(--bs-primary);
                border-color: var(--bs-primary);
                color: #fff;
                transform: scale(1.05);
            }

            .step-label {
                font-size: 9px;
                font-weight: 800;
                color: #adb5bd;
                display: block;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .pipeline-step.active .step-label {
                color: var(--bs-primary);
            }

            .current-pulse .step-icon {
                box-shadow: 0 0 0 0 rgba(var(--bs-primary-rgb), 0.4);
                animation: pulse-primary 2s infinite;
            }

            @keyframes pulse-primary {
                0% {
                    transform: scale(1.05);
                }

                50% {
                    transform: scale(1.15);
                    box-shadow: 0 0 0 10px rgba(var(--bs-primary-rgb), 0);
                }

                100% {
                    transform: scale(1.05);
                }
            }

            .pulse-ring {
                position: absolute;
                top: 0;
                left: 0;
                width: 48px;
                height: 48px;
                border-radius: 50%;
                border: 4px solid var(--bs-primary);
                animation: ripple 2s infinite;
                opacity: 0;
            }

            @keyframes ripple {
                0% {
                    transform: scale(1);
                    opacity: 0.5;
                }

                100% {
                    transform: scale(1.8);
                    opacity: 0;
                }
            }

            .feed-visual {
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 20px;
                position: relative;
            }

            .feed-dot {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                background: #dee2e6;
                border: 2px solid #fff;
                position: relative;
                z-index: 2;
                margin-top: 15px;
            }

            .feed-dot.active {
                background: var(--bs-primary);
                transform: scale(1.4);
            }

            .feed-line {
                width: 2px;
                flex-grow: 1;
                background: #f0f0f0;
                position: absolute;
                top: 27px;
                z-index: 1;
            }

            .hover-translate-x:hover {
                transform: translateX(5px);
                border-color: rgba(var(--bs-primary-rgb), 0.2) !important;
                background: #fff !important;
            }

            .tracking-summary-card {
                background: #fff;
            }

            .summary-bg-icon {
                position: absolute;
                right: -20px;
                bottom: -20px;
                font-size: 8rem;
                color: #f8f9fa;
                transform: rotate(-15deg);
                pointer-events: none;
            }

            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #eee;
                border-radius: 10px;
            }

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

            table.table-premium thead tr th {
                border-bottom: 2px solid #f0f0f0;
                border-top: none;
            }

            table.table-premium tbody tr {
                border-bottom: 1px solid #f8f9fa;
                transition: all 0.2s ease;
            }

            table.table-premium tbody tr:hover {
                background-color: rgba(var(--bs-primary-rgb), 0.02);
            }

            table.table-premium tbody tr:last-child {
                border-bottom: none;
            }

            .btn-premium-outline {
                border: 2px solid #f0f0f0;
                color: #444;
                transition: all 0.3s ease;
            }

            .btn-premium-outline:hover {
                background: var(--bs-primary);
                border-color: var(--bs-primary);
                color: #fff;
                transform: scale(1.05);
            }

            .refresh-pill {
                background: rgba(var(--bs-primary-rgb), 0.05);
                padding: 4px 12px;
                border-radius: 50px;
                transition: all 0.3s ease;
            }

            .refresh-pill:hover {
                background: rgba(var(--bs-primary-rgb), 0.1);
                transform: rotate(180deg);
            }
        </style>
    @endpush
@endsection