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
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <a href="{{ route('orders') }}" class="btn btn-light btn-sm rounded-circle p-1">
                                        <i class="bi bi-arrow-left fs-5"></i>
                                    </a>
                                    <h3 class="fw-black mb-0 letter-spacing-n1">Order Intelligence</h3>
                                </div>
                                <p class="text-muted small mb-0 fw-medium">Order #{{ $order->order_number }} &bull; Placed
                                    on {{ $order->created_at->format('d M, Y') }}</p>
                            </div>
                            <div class="badge bg-success-soft text-success px-4 py-2 rounded-pill small fw-bold">
                                <i class="bi bi-shield-check me-1"></i> Secure Delivery
                            </div>
                        </div>

                        <!-- Progress Pipeline -->
                        <div class="tracking-pipeline-premium mb-5 px-lg-4">
                            @php
                                $steps = [
                                    ['id' => 'placed', 'label' => 'Placed', 'icon' => 'bi-cart-check'],
                                    ['id' => 'confirmed', 'label' => 'Confirmed', 'icon' => 'bi-patch-check'],
                                    ['id' => 'shipped', 'label' => 'Shipped', 'icon' => 'bi-truck'],
                                    ['id' => 'out_for_delivery', 'label' => 'Out for Delivery', 'icon' => 'bi-geo-alt'],
                                    ['id' => 'delivered', 'label' => 'Delivered', 'icon' => 'bi-house-heart']
                                ];

                                $currentStatus = strtolower($order->order_status);

                                // Progression mapping
                                if ($currentStatus == 'delivered')
                                    $activeStepIndex = 4;
                                elseif ($currentStatus == 'out_for_delivery')
                                    $activeStepIndex = 3;
                                elseif (in_array($currentStatus, ['shipped', 'dispatched']))
                                    $activeStepIndex = 2;
                                elseif (in_array($currentStatus, ['confirmed', 'processing']))
                                    $activeStepIndex = 1;
                                else
                                    $activeStepIndex = 0;
                            @endphp

                            <div class="d-flex justify-content-between position-relative pipeline-container-premium">
                                <div class="pipeline-progress-bg-premium"></div>
                                <div class="pipeline-progress-active-premium"
                                    style="width: {{ ($activeStepIndex / (count($steps) - 1)) * 100 }}%;"></div>

                                @foreach($steps as $index => $step)
                                    <div
                                        class="pipeline-step-premium {{ $index <= $activeStepIndex ? 'completed' : '' }} {{ $index == $activeStepIndex && $currentStatus != 'delivered' ? 'current' : '' }}">
                                        <div class="step-icon-wrapper-premium shadow-sm">
                                            <div class="step-icon-premium">
                                                <i class="bi {{ $step['icon'] }}"></i>
                                            </div>
                                            @if($index == $activeStepIndex && $currentStatus != 'delivered')
                                                <div class="pulse-ring-premium"></div>
                                            @endif
                                        </div>
                                        <span class="step-label-premium mt-3">{{ $step['label'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row g-5 mt-2">
                            <!-- Left: Status Feed -->
                            <div class="col-lg-7">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h6
                                        class="fw-black mb-0 uppercase tracking-widest text-dark d-flex align-items-center gap-2">
                                        <span class="p-1 px-2 bg-success rounded text-white x-small">LIVE</span> Track
                                        History
                                    </h6>
                                </div>

                                <div class="status-feed-vertical">
                                    @forelse($order->orderTrackings()->latest()->get() as $track)
                                        <div class="feed-item-premium d-flex gap-4 mb-4 timeline-animation"
                                            style="animation-delay: {{ $loop->index * 0.1 }}s">
                                            <div class="feed-visual-premium text-center">
                                                <div class="feed-dot-premium {{ $loop->first ? 'active' : 'completed' }}">
                                                    @if(!$loop->first) <i class="bi bi-check text-white x-small"></i> @endif
                                                </div>
                                                @if(!$loop->last)
                                                    <div class="feed-line-premium completed"></div>
                                                @endif
                                            </div>
                                            <div
                                                class="feed-content-premium p-3 rounded-4 bg-light bg-opacity-50 border border-light w-100 transition-all hover-translate-x shadow-hover">
                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                    <span
                                                        class="d-block small fw-black text-dark uppercase tracking-tight">{{ str_replace('_', ' ', $track->status) }}</span>
                                                    <span
                                                        class="xx-small text-muted fw-bold">{{ $track->created_at->format('d M, h:i A') }}</span>
                                                </div>
                                                <p class="text-secondary small mb-0 lh-base fw-medium">{{ $track->message }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-5 bg-light rounded-5 border border-dashed border-2">
                                            <div class="mb-3">
                                                <div class="spinner-grow text-success spinner-grow-sm" role="status"></div>
                                            </div>
                                            <span class="small text-dark fw-bold uppercase tracking-widest d-block">Telemetry
                                                Initializing</span>
                                            <p class="xx-small text-muted mb-0 mt-1">Our logistics system is calibrating your
                                                package's coordinates.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="tracking-summary-sidebar sticky-top"
                                    style="top: 115px; max-height: calc(100vh - 140px); overflow-y: auto; z-index: 100;">
                                    <!-- Package Summary -->
                                    <div class="p-4 rounded-5 bg-white border shadow-soft mb-4 hover-lift">
                                        <h6 class="xx-small text-muted fw-black uppercase tracking-widest mb-4">Package
                                            Content</h6>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-lg rounded-4 overflow-hidden bg-light border p-1"
                                                style="width: 70px; height: 70px;">
                                                <img src="{{ asset($order->orderItems->first()->product->image ?? 'assets/images/placeholder.png') }}"
                                                    class="w-100 h-100 object-fit-cover rounded-3">
                                            </div>
                                            <div>
                                                <h6 class="fw-black text-dark mb-1">
                                                    {{ $order->orderItems->first()->product->name ?? 'Premium Package' }}
                                                </h6>
                                                <p class="xx-small text-muted fw-bold uppercase mb-0 tracking-tighter">
                                                    {{ $order->orderItems->count() }}
                                                    {{ Str::plural('Item', $order->orderItems->count()) }} &bull; Total
                                                    ₹{{ number_format($order->total_amount) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Terminal Location -->
                                    <div
                                        class="p-4 rounded-5 bg-white border shadow-soft mb-4 position-relative overflow-hidden hover-lift">
                                        <div class="position-absolute opacity-5 end-n1 top-n1"
                                            style="transform: rotate(-15deg); font-size: 5rem; top: -10px; right: -10px;">
                                            <i class="bi bi-geo-alt-fill text-dark"></i>
                                        </div>
                                        <h6 class="xx-small text-success fw-black uppercase tracking-widest mb-3">Delivery
                                            Terminal</h6>
                                        @if($order->address)
                                            <div class="text-dark fw-black small mb-1">{{ $order->address->name }}</div>
                                            <p class="xx-small text-secondary fw-bold mb-0 opacity-75 lh-base">
                                                {{ $order->address->address_line }}<br>
                                                {{ $order->address->city }}, {{ $order->address->state }} -
                                                {{ $order->address->pincode }}
                                            </p>
                                        @else
                                            <p class="small text-danger italic">No delivery address found.</p>
                                        @endif
                                    </div>

                                    <!-- ETA Card -->
                                    <div class="p-4 rounded-5 shadow-premium text-white position-relative overflow-hidden hover-scale-sm"
                                        style="background: linear-gradient(135deg, #138808 0%, #28a745 100%);">
                                        <div class="d-flex justify-content-between align-items-end position-relative z-1">
                                            <div>
                                                <span class="xx-small fw-black uppercase opacity-75 d-block mb-1">Estimated
                                                    Arrival</span>
                                                @if($order->order_status == 'delivered')
                                                    <div class="h5 fw-black mb-0">Delivered Successfully</div>
                                                    <span class="x-small fw-bold opacity-75">Package Received</span>
                                                @else
                                                    <div class="h4 fw-black mb-0">
                                                        {{ $order->created_at->addDays(5)->format('d M, Y') }}
                                                    </div>
                                                    <span class="x-small fw-bold opacity-75">Express Courier</span>
                                                @endif
                                            </div>
                                            <i class="bi bi-calendar-check display-5 opacity-25"></i>
                                        </div>
                                        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10"
                                            style="background: url('https://www.transparenttextures.com/patterns/cubes.png');">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Premium Pipeline */
            .pipeline-container-premium {
                height: 100px;
                padding-top: 20px;
            }

            .pipeline-progress-bg-premium {
                position: absolute;
                top: 38px;
                left: 30px;
                right: 30px;
                height: 6px;
                background: #f0f0f0;
                border-radius: 10px;
                z-index: 1;
            }

            .pipeline-progress-active-premium {
                position: absolute;
                top: 38px;
                left: 30px;
                height: 6px;
                background: #28a745;
                border-radius: 10px;
                z-index: 2;
                transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .pipeline-step-premium {
                position: relative;
                z-index: 3;
                text-align: center;
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .step-icon-wrapper-premium {
                width: 44px;
                height: 44px;
                background: #fff;
                border: 3px solid #f0f0f0;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.4s ease;
                color: #ced4da;
            }

            .pipeline-step-premium.completed .step-icon-wrapper-premium {
                border-color: #28a745;
                background: #28a745;
                color: #fff;
            }

            .pipeline-step-premium.current .step-icon-wrapper-premium {
                border-color: #28a745;
                color: #28a745;
                transform: scale(1.15);
                box-shadow: 0 0 15px rgba(40, 167, 69, 0.2);
            }

            .step-label-premium {
                font-size: 10px;
                font-weight: 800;
                color: #adb5bd;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
            }

            .pipeline-step-premium.completed .step-label-premium {
                color: #138808;
            }

            .pipeline-step-premium.current .step-label-premium {
                color: #28a745;
                font-weight: 900;
            }

            .pulse-ring-premium {
                position: absolute;
                width: 44px;
                height: 44px;
                border-radius: 50%;
                border: 4px solid #28a745;
                animation: ripple-premium 2s infinite;
                opacity: 0;
            }

            @keyframes ripple-premium {
                0% {
                    transform: scale(0.8);
                    opacity: 0.5;
                }

                100% {
                    transform: scale(1.8);
                    opacity: 0;
                }
            }

            /* Feed Styles */
            .feed-visual-premium {
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 24px;
                position: relative;
            }

            .feed-dot-premium {
                width: 14px;
                height: 14px;
                border-radius: 50%;
                background: #dee2e6;
                border: 3px solid #fff;
                position: relative;
                z-index: 2;
                margin-top: 15px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .feed-dot-premium.active {
                background: #28a745;
                transform: scale(1.4);
                box-shadow: 0 0 15px rgba(40, 167, 69, 0.4);
            }

            .feed-dot-premium.completed {
                background: #28a745;
                border-color: #e8f5e9;
            }

            .feed-line-premium {
                width: 3px;
                flex-grow: 1;
                background: #f0f2f5;
                position: absolute;
                top: 27px;
                z-index: 1;
            }

            .feed-line-premium.completed {
                background: #28a745;
                opacity: 0.4;
            }

            .feed-content-premium {
                transition: all 0.3s ease;
            }

            .feed-content-premium:hover {
                transform: translateX(8px);
                border-color: rgba(40, 167, 69, 0.2) !important;
                background: #f8fdf9 !important;
            }

            /* General Layout */
            .hover-lift {
                transition: transform 0.3s ease;
            }

            .hover-lift:hover {
                transform: translateY(-5px);
            }

            .hover-scale-sm {
                transition: transform 0.3s ease;
            }

            .hover-scale-sm:hover {
                transform: scale(1.02);
            }

            .shadow-hover:hover {
                box-shadow: 0 10px 25px -10px rgba(0, 0, 0, 0.1);
            }

            .timeline-animation {
                opacity: 0;
                animation: staggerIn 0.5s ease forwards;
            }

            @keyframes staggerIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .fw-black {
                font-weight: 900;
            }

            .xx-small {
                font-size: 0.65rem;
            }

            .x-small {
                font-size: 0.75rem;
            }

            .letter-spacing-n1 {
                letter-spacing: -1px;
            }

            .bg-success-soft {
                background: rgba(40, 167, 69, 0.1);
            }
        </style>
    @endpush
@endsection