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
                    @php
                        $steps = [
                            ['id' => 'placed', 'label' => 'Placed', 'icon' => 'bi-cart-check'],
                            ['id' => 'confirmed', 'label' => 'Confirmed', 'icon' => 'bi-patch-check'],
                            ['id' => 'shipped', 'label' => 'Shipped', 'icon' => 'bi-truck'],
                            ['id' => 'out_for_delivery', 'label' => 'Out for Delivery', 'icon' => 'bi-geo-alt'],
                            ['id' => 'delivered', 'label' => 'Delivered', 'icon' => 'bi-house-heart'],
                        ];
                        $currentStatus = strtolower((string) $order->order_status);
                        $isCancelled = in_array($currentStatus, ['cancelled', 'canceled'], true);

                        if ($isCancelled) {
                            $activeStepIndex = -1;
                        } elseif ($currentStatus === 'delivered') {
                            $activeStepIndex = 4;
                        } elseif ($currentStatus === 'out_for_delivery') {
                            $activeStepIndex = 3;
                        } elseif (in_array($currentStatus, ['shipped', 'dispatched'], true)) {
                            $activeStepIndex = 2;
                        } elseif (in_array($currentStatus, ['confirmed', 'processing'], true)) {
                            $activeStepIndex = 1;
                        } else {
                            $activeStepIndex = 0;
                        }

                        $progressPct = $isCancelled ? 0 : ($activeStepIndex / max(count($steps) - 1, 1)) * 100;

                        $statusPillClass = match (true) {
                            $isCancelled => 'otp-status-pill otp-status-pill--danger',
                            $currentStatus === 'delivered' => 'otp-status-pill otp-status-pill--success',
                            in_array($currentStatus, ['shipped', 'dispatched', 'out_for_delivery'], true) => 'otp-status-pill otp-status-pill--info',
                            default => 'otp-status-pill otp-status-pill--warn',
                        };

                        $firstItem = $order->orderItems->first();
                        $firstProduct = $firstItem?->product;
                        $etaDate = $order->created_at->copy()->addDays(5);
                    @endphp

                    <div class="order-track-premium dashboard-card border-0 overflow-hidden shadow-premium">
                        <!-- Hero -->
                        <div class="order-track-hero position-relative text-white px-4 py-4 px-lg-5 py-lg-5">
                            <div class="order-track-hero__glow"></div>
                            <div class="position-relative z-1">
                                <div class="d-flex flex-wrap align-items-start justify-content-between gap-4">
                                    <div class="d-flex align-items-start gap-3">
                                        <a href="{{ route('orders') }}"
                                            class="order-track-back btn btn-light btn-sm rounded-circle shadow-sm border-0">
                                            <i class="bi bi-arrow-left"></i>
                                        </a>
                                        <div>
                                            <p class="order-track-eyebrow mb-2">Shipment tracking</p>
                                            <h2 class="fw-black mb-2 letter-spacing-n1">Track your order</h2>
                                            <div class="d-flex flex-wrap align-items-center gap-2">
                                                <span class="order-track-order-pill font-monospace">{{ $order->order_number }}</span>
                                                <span class="order-track-meta-dot d-none d-sm-inline">•</span>
                                                <span class="order-track-meta">Placed {{ $order->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <span class="{{ $statusPillClass }}">{{ ucfirst(str_replace('_', ' ', $order->order_status)) }}</span>
                                        <a href="{{ route('order.invoice', $order->id) }}" target="_blank"
                                            class="btn btn-light btn-sm rounded-pill px-3 fw-bold shadow-sm border-0 d-inline-flex align-items-center gap-2">
                                            <i class="bi bi-file-earmark-pdf text-danger"></i> Invoice
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 p-lg-5 pt-lg-4 bg-white">
                            @if($isCancelled)
                                <div class="alert alert-danger border-0 rounded-4 shadow-sm d-flex align-items-start gap-3 mb-4">
                                    <i class="bi bi-x-octagon-fill fs-4 flex-shrink-0"></i>
                                    <div>
                                        <strong class="d-block">This order was cancelled</strong>
                                        <span class="small text-danger-emphasis">Updates below reflect history up to cancellation.</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Progress pipeline -->
                            <div class="order-track-pipeline-wrap mb-5">
                                <div class="d-flex justify-content-between align-items-end mb-3 flex-wrap gap-2">
                                    <h6 class="fw-black mb-0 text-dark d-flex align-items-center gap-2">
                                        <span class="order-track-section-icon"><i class="bi bi-signpost-split"></i></span>
                                        Delivery journey
                                    </h6>
                                    @unless($isCancelled)
                                        <span class="xx-small text-muted fw-bold text-uppercase tracking-widest">Live progress</span>
                                    @endunless
                                </div>
                                <div class="pipeline-scroll">
                                    <div class="d-flex justify-content-between position-relative pipeline-container-premium {{ $isCancelled ? 'pipeline-container-premium--cancelled' : '' }}">
                                        <div class="pipeline-progress-bg-premium"></div>
                                        @unless($isCancelled)
                                            <div class="pipeline-progress-active-premium" style="width: {{ $progressPct }}%;"></div>
                                        @endunless

                                        @foreach($steps as $index => $step)
                                            @php
                                                $done = !$isCancelled && $index <= $activeStepIndex;
                                                $current = !$isCancelled && $index === $activeStepIndex && $currentStatus !== 'delivered';
                                            @endphp
                                            <div class="pipeline-step-premium {{ $done ? 'completed' : '' }} {{ $current ? 'current' : '' }}">
                                                <div class="step-icon-wrapper-premium">
                                                    <div class="step-icon-premium">
                                                        <i class="bi {{ $step['icon'] }}"></i>
                                                    </div>
                                                    @if($current)
                                                        <div class="pulse-ring-premium" aria-hidden="true"></div>
                                                    @endif
                                                </div>
                                                <span class="step-label-premium">{{ $step['label'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 g-lg-5">
                                <div class="col-lg-7">
                                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                                        <h6 class="fw-black mb-0 text-dark d-flex align-items-center gap-2">
                                            <span class="order-track-section-icon order-track-section-icon--live"><i class="bi bi-activity"></i></span>
                                            Activity timeline
                                        </h6>
                                        <span class="badge rounded-pill bg-light bg-opacity-10 text-dark x-small fw-bold px-3 py-2">{{ $order->orderTrackings->count() }} updates</span>
                                    </div>

                                    <div class="status-feed-vertical">
                                        @forelse($order->orderTrackings as $track)
                                            <div class="feed-item-premium d-flex gap-3 gap-md-4 mb-3 timeline-animation"
                                                style="animation-delay: {{ min($loop->index * 0.08, 0.6) }}s">
                                                <div class="feed-visual-premium text-center flex-shrink-0">
                                                    <div class="feed-dot-premium {{ $loop->first ? 'active' : 'completed' }}">
                                                        @if(!$loop->first)
                                                            <i class="bi bi-check-lg"></i>
                                                        @endif
                                                    </div>
                                                    @if(!$loop->last)
                                                        <div class="feed-line-premium"></div>
                                                    @endif
                                                </div>
                                                <div class="feed-content-premium flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                                        <span class="feed-status-title">{{ str_replace('_', ' ', $track->status) }}</span>
                                                        <span class="feed-time">{{ $track->created_at->format('d M, h:i A') }}</span>
                                                    </div>
                                                    <p class="feed-message mb-0">{{ $track->message }}</p>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="order-track-empty text-center py-5 rounded-4">
                                                <div class="order-track-empty__icon mx-auto mb-3">
                                                    <i class="bi bi-radar"></i>
                                                </div>
                                                <p class="fw-black text-dark mb-1">Waiting for first scan</p>
                                                <p class="small text-muted mb-0 px-3">As soon as your package moves, updates will show up here.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <div class="tracking-summary-sidebar sticky-top"
                                        style="top: 115px; max-height: calc(100vh - 140px); overflow-y: auto; z-index: 5;">

                                        @if($order->tracking_link)
                                            <div class="otp-card otp-card--accent mb-4">
                                                <div class="d-flex align-items-start justify-content-between gap-3 mb-2">
                                                    <div>
                                                        <p class="otp-card__label mb-1">Courier tracking</p>
                                                        <p class="otp-card__title mb-0">Live map &amp; ETA</p>
                                                    </div>
                                                    <span class="otp-card__badge"><i class="bi bi-broadcast"></i></span>
                                                </div>
                                                <a href="{{ $order->tracking_link }}" target="_blank" rel="noopener noreferrer"
                                                    class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm">
                                                    <i class="bi bi-box-arrow-up-right me-2"></i>Open tracking link
                                                </a>
                                                <p class="otp-card__hint mb-0 mt-2">Opens your carrier page in a new tab.</p>
                                            </div>
                                        @endif

                                        <div class="otp-card mb-4">
                                            <p class="otp-card__label mb-2">Order summary</p>
                                            @if($firstProduct)
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="otp-thumb rounded-4 overflow-hidden flex-shrink-0">
                                                        <img src="{{ asset($firstProduct->image ?? 'assets/images/placeholder.png') }}"
                                                            alt="" class="w-100 h-100 object-fit-cover">
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="otp-card__title text-truncate mb-1">{{ $firstProduct->name }}</p>
                                                        <p class="otp-card__hint mb-0">
                                                            {{ $order->orderItems->count() }} {{ Str::plural('item', $order->orderItems->count()) }}
                                                            · ₹{{ number_format($order->total_amount, 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="otp-card__title mb-0">₹{{ number_format($order->total_amount, 2) }}</p>
                                                <p class="otp-card__hint mb-0 mt-1">Line items unavailable.</p>
                                            @endif
                                        </div>

                                        <div class="otp-card otp-card--map mb-4">
                                            <p class="otp-card__label mb-2 text-success">Deliver to</p>
                                            @if($order->address)
                                                <p class="otp-card__title mb-1">{{ $order->address->name }}</p>
                                                <p class="otp-card__hint mb-0 lh-lg">
                                                    {{ $order->address->address_line }}<br>
                                                    {{ $order->address->city }}, {{ $order->address->state }} — {{ $order->address->pincode }}
                                                </p>
                                            @else
                                                <p class="small text-danger mb-0">No delivery address on file.</p>
                                            @endif
                                        </div>

                                        <div class="otp-eta-card text-white position-relative overflow-hidden">
                                            <div class="position-relative z-1">
                                                @if($currentStatus === 'delivered')
                                                    <p class="otp-card__label text-white-50 mb-1">Status</p>
                                                    <p class="otp-eta-card__big mb-0">Delivered</p>
                                                    <p class="otp-card__hint text-white-50 mb-0 mt-1">Thank you for shopping with us.</p>
                                                @elseif($isCancelled)
                                                    <p class="otp-card__label text-white-50 mb-1">Order</p>
                                                    <p class="otp-eta-card__big mb-0">Cancelled</p>
                                                    <p class="otp-card__hint text-white-50 mb-0 mt-1">No further delivery expected.</p>
                                                @else
                                                    <p class="otp-card__label text-white-50 mb-1">Estimated arrival</p>
                                                    <p class="otp-eta-card__big mb-0">{{ $etaDate->format('d M Y') }}</p>
                                                    <p class="otp-card__hint text-white-50 mb-0 mt-1">Express handling · subject to carrier</p>
                                                @endif
                                            </div>
                                            <i class="bi bi-calendar-event otp-eta-card__deco" aria-hidden="true"></i>
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
            .order-track-premium {
                border-radius: 24px;
            }

            .order-track-hero {
                background: linear-gradient(125deg, #0f172a 0%, #1e293b 42%, #c2410c 160%);
            }

            .order-track-hero__glow {
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(ellipse 80% 60% at 85% 0%, rgba(255, 122, 24, 0.35), transparent 55%),
                    radial-gradient(ellipse 50% 50% at 10% 100%, rgba(99, 102, 241, 0.2), transparent 50%);
                pointer-events: none;
            }

            .order-track-eyebrow {
                font-size: 0.7rem;
                font-weight: 800;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                opacity: 0.75;
                margin: 0;
            }

            .order-track-order-pill {
                display: inline-block;
                font-size: 0.8rem;
                font-weight: 700;
                padding: 0.35rem 0.85rem;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.12);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .order-track-meta {
                font-size: 0.85rem;
                opacity: 0.85;
                font-weight: 600;
            }

            .order-track-meta-dot {
                opacity: 0.5;
            }

            .order-track-back {
                width: 40px;
                height: 40px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .otp-status-pill {
                font-size: 0.7rem;
                font-weight: 800;
                letter-spacing: 0.06em;
                text-transform: uppercase;
                padding: 0.45rem 1rem;
                border-radius: 999px;
                border: 1px solid transparent;
            }

            .otp-status-pill--success {
                background: rgba(34, 197, 94, 0.2);
                border-color: rgba(34, 197, 94, 0.45);
                color: #bbf7d0;
            }

            .otp-status-pill--info {
                background: rgba(56, 189, 248, 0.15);
                border-color: rgba(56, 189, 248, 0.4);
                color: #e0f2fe;
            }

            .otp-status-pill--warn {
                background: rgba(251, 191, 36, 0.15);
                border-color: rgba(251, 191, 36, 0.4);
                color: #fef3c7;
            }

            .otp-status-pill--danger {
                background: rgba(248, 113, 113, 0.2);
                border-color: rgba(248, 113, 113, 0.45);
                color: #fecaca;
            }

            .order-track-section-icon {
                width: 36px;
                height: 36px;
                border-radius: 12px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, rgba(255, 122, 24, 0.12), rgba(255, 122, 24, 0.04));
                color: var(--primary, #f2701a);
                font-size: 1.1rem;
            }

            .order-track-section-icon--live {
                background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));
                color: #059669;
            }

            .order-track-pipeline-wrap {
                padding: 1.25rem 1.25rem 1.5rem;
                border-radius: 20px;
                background: linear-gradient(180deg, #f8fafc 0%, #fff 100%);
                border: 1px solid rgba(15, 23, 42, 0.06);
                box-shadow: 0 12px 40px -24px rgba(15, 23, 42, 0.25);
            }

            .pipeline-scroll {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                margin: 0 -0.25rem;
                padding: 0 0.25rem;
            }

            .pipeline-container-premium {
                min-width: 520px;
                height: 108px;
                padding-top: 12px;
                align-items: flex-start;
            }

            .pipeline-container-premium--cancelled .step-icon-premium {
                opacity: 0.45;
            }

            .pipeline-progress-bg-premium {
                position: absolute;
                top: 40px;
                left: 28px;
                right: 28px;
                height: 8px;
                background: #e2e8f0;
                border-radius: 999px;
                z-index: 1;
            }

            .pipeline-progress-active-premium {
                position: absolute;
                top: 40px;
                left: 28px;
                height: 8px;
                border-radius: 999px;
                z-index: 2;
                background: linear-gradient(90deg, #f97316, #22c55e);
                box-shadow: 0 0 20px rgba(34, 197, 94, 0.35);
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
                position: relative;
                width: 56px;
                height: 56px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .step-icon-premium {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #fff;
                border: 2px solid #e2e8f0;
                color: #94a3b8;
                font-size: 1.15rem;
                transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
            }

            .pipeline-step-premium.completed .step-icon-premium {
                border-color: rgba(34, 197, 94, 0.5);
                color: #16a34a;
                background: linear-gradient(180deg, #f0fdf4, #fff);
            }

            .pipeline-step-premium.current .step-icon-premium {
                border-color: #f97316;
                color: #ea580c;
                background: linear-gradient(180deg, #fff7ed, #fff);
                box-shadow: 0 8px 24px rgba(249, 115, 22, 0.25);
                transform: scale(1.06);
            }

            .pulse-ring-premium {
                position: absolute;
                inset: 0;
                border-radius: 50%;
                border: 2px solid rgba(249, 115, 22, 0.45);
                animation: otp-pulse 1.8s ease-out infinite;
            }

            @keyframes otp-pulse {
                0% {
                    transform: scale(0.85);
                    opacity: 0.9;
                }
                100% {
                    transform: scale(1.35);
                    opacity: 0;
                }
            }

            .step-label-premium {
                margin-top: 0.65rem;
                font-size: 0.68rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                color: #64748b;
                max-width: 88px;
                line-height: 1.25;
            }

            .pipeline-step-premium.completed .step-label-premium {
                color: #334155;
            }

            .pipeline-step-premium.current .step-label-premium {
                color: #c2410c;
            }

            .timeline-animation {
                opacity: 0;
                animation: staggerIn 0.55s ease forwards;
            }

            @keyframes staggerIn {
                from {
                    opacity: 0;
                    transform: translateY(12px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .feed-visual-premium {
                width: 28px;
            }

            .feed-dot-premium {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.65rem;
                border: 2px solid #e2e8f0;
                background: #fff;
                color: #fff;
                transition: transform 0.25s ease;
            }

            .feed-dot-premium.completed {
                background: linear-gradient(135deg, #22c55e, #16a34a);
                border-color: #16a34a;
            }

            .feed-dot-premium.active {
                background: linear-gradient(135deg, #f97316, #ea580c);
                border-color: #ea580c;
                box-shadow: 0 4px 14px rgba(234, 88, 12, 0.35);
                transform: scale(1.08);
            }

            .feed-line-premium {
                width: 2px;
                flex: 1;
                min-height: 2.5rem;
                margin: 0.35rem auto 0;
                background: linear-gradient(180deg, #cbd5e1, #e2e8f0);
                border-radius: 2px;
            }

            .feed-content-premium {
                padding: 1rem 1.15rem;
                border-radius: 16px;
                background: #fff;
                border: 1px solid rgba(15, 23, 42, 0.06);
                box-shadow: 0 8px 30px -18px rgba(15, 23, 42, 0.2);
                transition: transform 0.25s ease, box-shadow 0.25s ease;
            }

            .feed-item-premium:hover .feed-content-premium {
                transform: translateX(4px);
                box-shadow: 0 14px 40px -20px rgba(15, 23, 42, 0.28);
            }

            .feed-status-title {
                font-size: 0.78rem;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                color: #0f172a;
            }

            .feed-time {
                font-size: 0.65rem;
                font-weight: 700;
                color: #94a3b8;
                white-space: nowrap;
            }

            .feed-message {
                font-size: 0.875rem;
                color: #475569;
                line-height: 1.55;
                font-weight: 500;
            }

            .order-track-empty {
                border: 1px dashed rgba(148, 163, 184, 0.5);
                background: linear-gradient(180deg, #f8fafc, #fff);
            }

            .order-track-empty__icon {
                width: 56px;
                height: 56px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(99, 102, 241, 0.1);
                color: #6366f1;
                font-size: 1.5rem;
            }

            .otp-card {
                padding: 1.25rem 1.35rem;
                border-radius: 20px;
                background: #fff;
                border: 1px solid rgba(15, 23, 42, 0.06);
                box-shadow: 0 12px 40px -28px rgba(15, 23, 42, 0.35);
                transition: transform 0.25s ease, box-shadow 0.25s ease;
            }

            .otp-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 20px 50px -28px rgba(15, 23, 42, 0.4);
            }

            .otp-card--accent {
                background: linear-gradient(135deg, rgba(255, 122, 24, 0.08), rgba(255, 255, 255, 1) 55%);
                border-color: rgba(255, 122, 24, 0.15);
            }

            .otp-card--map {
                background: linear-gradient(180deg, #f0fdf4 0%, #fff 65%);
                border-color: rgba(34, 197, 94, 0.12);
            }

            .otp-card__label {
                font-size: 0.65rem;
                font-weight: 800;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: #64748b;
                margin: 0;
            }

            .otp-card__title {
                font-size: 1rem;
                font-weight: 900;
                color: #0f172a;
                line-height: 1.3;
            }

            .otp-card__hint {
                font-size: 0.78rem;
                color: #64748b;
                font-weight: 600;
            }

            .otp-card__badge {
                width: 40px;
                height: 40px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(255, 122, 24, 0.12);
                color: var(--primary, #f2701a);
                font-size: 1.1rem;
            }

            .otp-thumb {
                width: 72px;
                height: 72px;
                border: 1px solid rgba(15, 23, 42, 0.06);
                background: #f8fafc;
            }

            .otp-eta-card {
                border-radius: 20px;
                padding: 1.35rem 1.4rem;
                background: linear-gradient(135deg, #0f766e 0%, #059669 45%, #10b981 100%);
                box-shadow: 0 16px 40px -12px rgba(5, 150, 105, 0.45);
            }

            .otp-eta-card__big {
                font-size: 1.35rem;
                font-weight: 900;
                letter-spacing: -0.02em;
            }

            .otp-eta-card__deco {
                position: absolute;
                right: 0.75rem;
                bottom: 0.5rem;
                font-size: 4rem;
                opacity: 0.12;
            }

            @media (max-width: 575.98px) {
                .order-track-hero h2 {
                    font-size: 1.35rem;
                }

                .pipeline-container-premium {
                    min-width: 480px;
                }
            }
        </style>
    @endpush
@endsection