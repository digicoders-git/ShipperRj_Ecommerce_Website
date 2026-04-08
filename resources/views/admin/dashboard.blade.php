@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('admin_content')
    <div class="mb-5 d-flex justify-content-between align-items-end flex-wrap gap-3">
        <div>
            <h3 class="fw-black mb-1 text-dark d-flex align-items-center gap-2" style="letter-spacing: -1px;">
                <div class="bg-primary bg-opacity-10 text-primary rounded p-2 d-inline-flex">
                    <i class="bi bi-grid-1x2-fill fs-5"></i>
                </div>
                Executive Overview
            </h3>
            <p class="text-secondary small fw-bold mb-0 mt-2">Real-time marketplace insights & system analytics.</p>
        </div>
        <div>
            <button
                class="btn btn-dark btn-sm rounded-pill px-4 py-2 shadow-sm d-flex align-items-center gap-2 fw-bold transition-all hover-translate-y"
                onclick="window.location.reload();">
                <i class="bi bi-arrow-clockwise"></i> Sync Data
            </button>
        </div>
    </div>

    @php
        $rev = \App\Models\Order::where('order_status', 'completed')->sum('total_amount') ?? 0;
        $pending = \App\Models\Order::where('order_status', 'pending')->count() ?? 0;
        $totalSubcategories = \App\Models\SubCategory::count() ?? 0;
        $users = $stats['total_users'] ?? 0;
        $orders = $stats['total_orders'] ?? 0;
        $products = $stats['total_products'] ?? 0;
        $categories = $stats['total_categories'] ?? 0;
    @endphp

    <!-- Executive Status Cards Row -->
    <div class="row g-4 mb-5">
        <!-- Revenue Card -->
        <div class="col-sm-6 col-xl-3">
            <div
                class="card bg-white border-0 rounded-4 p-4 h-100 shadow-sm transition-all hover-shadow-lg position-relative overflow-hidden group border-top border-4 border-success">
                <div class="position-absolute top-0 end-0 bg-success bg-opacity-10 w-50 h-100"
                    style="border-radius: 100% 0 0 100%; transform: translateX(50%);"></div>

                <div class="d-flex justify-content-between align-items-start mb-4 position-relative z-1">
                    <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="bi bi-wallet2 fs-4"></i>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill fw-bold px-3 py-2 x-small"><i
                            class="bi bi-arrow-up-right me-1"></i>+12.5%</span>
                </div>
                <div class="text-secondary x-small fw-bold text-uppercase tracking-widest mb-2 position-relative z-1">Total
                    Revenue</div>
                <h2 class="fw-black mb-0 text-dark position-relative z-1" style="letter-spacing: -1px;">
                    ₹{{ number_format($rev, 2) }}</h2>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-sm-6 col-xl-3">
            <div
                class="card bg-white border-0 rounded-4 p-4 h-100 shadow-sm transition-all hover-shadow-lg position-relative overflow-hidden group border-top border-4 border-primary">
                <div class="position-absolute top-0 end-0 bg-primary bg-opacity-10 w-50 h-100"
                    style="border-radius: 100% 0 0 100%; transform: translateX(50%);"></div>

                <div class="d-flex justify-content-between align-items-start mb-4 position-relative z-1">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="bi bi-bag-check fs-4"></i>
                    </div>
                    @if($pending > 0)
                        <span
                            class="badge bg-warning bg-opacity-10 text-white rounded-pill fw-bold px-3 py-2 x-small border border-warning border-opacity-25 pulse-border"><span
                                class="pulse-dot bg-warning d-inline-block me-2"
                                style="width: 6px; height: 6px; border-radius: 50%;"></span>{{ $pending }} Pending</span>
                    @endif
                </div>
                <div class="text-secondary x-small fw-bold text-uppercase tracking-widest mb-2 position-relative z-1">Total
                    Orders</div>
                <h2 class="fw-black mb-0 text-dark position-relative z-1" style="letter-spacing: -1px;">
                    {{ number_format($orders) }}
                </h2>
            </div>
        </div>

        <!-- Users Card -->
        <div class="col-sm-6 col-xl-3">
            <div
                class="card bg-white border-0 rounded-4 p-4 h-100 shadow-sm transition-all hover-shadow-lg position-relative overflow-hidden group border-top border-4 border-danger">
                <div class="position-absolute top-0 end-0 bg-danger bg-opacity-10 w-50 h-100"
                    style="border-radius: 100% 0 0 100%; transform: translateX(50%);"></div>

                <div class="d-flex justify-content-between align-items-start mb-4 position-relative z-1">
                    <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
                <div class="text-secondary x-small fw-bold text-uppercase tracking-widest mb-2 position-relative z-1">Active
                    Users</div>
                <h2 class="fw-black mb-0 text-dark position-relative z-1" style="letter-spacing: -1px;">
                    {{ number_format($users) }}
                </h2>
                <div class="progress mt-3 bg-light rounded-pill" style="height: 6px;">
                    <div class="progress-bar rounded-pill bg-danger" style="width: 75%;"></div>
                </div>
            </div>
        </div>

        <!-- Inventory Card -->
        <div class="col-sm-6 col-xl-3">
            <div
                class="card bg-white border-0 rounded-4 p-4 h-100 shadow-sm transition-all hover-shadow-lg position-relative overflow-hidden group border-top border-4 border-warning">
                <div class="position-absolute top-0 end-0 bg-warning bg-opacity-10 w-50 h-100"
                    style="border-radius: 100% 0 0 100%; transform: translateX(50%);"></div>

                <div class="d-flex justify-content-between align-items-start mb-4 position-relative z-1">
                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
                <div class="text-secondary x-small fw-bold text-uppercase tracking-widest mb-2 position-relative z-1">
                    Products Base</div>
                <h2 class="fw-black mb-0 text-dark position-relative z-1" style="letter-spacing: -1px;">
                    {{ number_format($products) }}
                </h2>
                <div class="text-secondary xx-small fw-bold mt-2 d-flex gap-2 position-relative z-1 pb-1">
                    <span class="bg-light px-2 py-1 rounded text-dark"><i
                            class="bi bi-folder-fill text-warning opacity-75 me-1"></i> {{ $categories }} Cats</span>
                    <span class="bg-light px-2 py-1 rounded text-dark"><i
                            class="bi bi-diagram-3-fill text-warning opacity-75 me-1"></i> {{ $totalSubcategories }}
                        Subs</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Chart & Modules -->
    <div class="row g-4 mb-5">
        <!-- Chart Area -->
        <div class="col-xl-8">
            <div class="card bg-white border-0 rounded-4 p-4 h-100 shadow-sm">
                <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
                    <div>
                        <h5 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                            Revenue Growth Graph
                        </h5>
                        <p class="text-secondary x-small mb-0 fw-medium">Sales trajectory over the last 6 months</p>
                    </div>
                    <select
                        class="form-select bg-light border-0 text-dark small w-auto shadow-none rounded-pill px-4 py-2 fw-bold">
                        <option>Last 6 Months</option>
                        <option>This Year</option>
                        <option>All Time</option>
                    </select>
                </div>
                <div class="flex-grow-1 position-relative" style="min-height: 340px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- System Hotlinks -->
        <div class="col-xl-4">
            <div class="card bg-white border-0 rounded-4 p-4 h-100 shadow-sm d-flex flex-column">
                <h5 class="fw-bold mb-1 text-dark">System Modules</h5>
                <p class="text-secondary x-small mb-4 fw-medium">Jump directly to your important modules.</p>

                <div class="d-flex flex-column gap-3 flex-grow-1">
                    <a href="{{ route('admin.products.index') }}"
                        class="card bg-light border-0 p-3 rounded-4 text-decoration-none transition-all hover-shadow-sm group">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white text-dark rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                    style="width: 45px; height: 45px;"><i class="bi bi-cart fs-5 text-primary"></i></div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark small">Products Database</h6>
                                    <span class="text-secondary xx-small fw-bold text-uppercase tracking-widest">Manage
                                        Inventory</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm text-dark transition-all group-hover-bg-primary"
                                style="width: 32px; height: 32px;"><i class="bi bi-chevron-right small"></i></div>
                        </div>
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                        class="card bg-light border-0 p-3 rounded-4 text-decoration-none transition-all hover-shadow-sm group">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white text-dark rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                    style="width: 45px; height: 45px;"><i class="bi bi-grid fs-5 text-warning"></i></div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark small">Category Structure</h6>
                                    <span class="text-secondary xx-small fw-bold text-uppercase tracking-widest">Organize
                                        Layout</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm text-dark transition-all group-hover-bg-warning"
                                style="width: 32px; height: 32px;"><i class="bi bi-chevron-right small"></i></div>
                        </div>
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                        class="card bg-light border-0 p-3 rounded-4 text-decoration-none transition-all hover-shadow-sm group">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white text-dark rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                    style="width: 45px; height: 45px;"><i class="bi bi-receipt fs-5 text-success"></i></div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark small">Live Order Book <span
                                            class="badge bg-success ms-1 px-2 py-0 rounded-pill">{{ $pending }}</span></h6>
                                    <span class="text-secondary xx-small fw-bold text-uppercase tracking-widest">Fulfill &
                                        Track</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm text-dark transition-all group-hover-bg-success"
                                style="width: 32px; height: 32px;"><i class="bi bi-chevron-right small"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="card bg-white border-0 rounded-4 shadow-sm overflow-hidden mb-4 p-0">
        <div
            class="p-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-3 bg-light bg-opacity-50">
            <div>
                <h5 class="fw-bold mb-1 text-dark">Latest Real-time Transactions</h5>
                <p class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-0">Recent
                    {{ count($stats['recent_orders']) }} incoming orders across all hubs
                </p>
            </div>
            <a href="{{ route('admin.orders.index') }}"
                class="btn btn-dark btn-sm rounded-pill px-4 py-2 x-small fw-bold shadow-sm d-flex align-items-center gap-2">View
                Entire Ledger <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-borderless align-middle mb-0 w-100">
                <thead class="bg-light text-secondary border-bottom">
                    <tr>
                        <th class="x-small fw-bold py-3 px-4 tracking-widest text-uppercase">Trx ID</th>
                        <th class="x-small fw-bold py-3 px-3 tracking-widest text-uppercase">Customer Profile</th>
                        <th class="x-small fw-bold py-3 px-3 tracking-widest text-uppercase">Fulfillment Status</th>
                        <th class="x-small fw-bold py-3 px-4 text-end tracking-widest text-uppercase">Invoice Value</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['recent_orders'] as $order)
                        <tr class="border-bottom transition-all">
                            <td class="small fw-black py-4 px-4 text-dark">
                                <span
                                    class="bg-light text-dark px-3 py-2 rounded-3 shadow-sm border border-black border-opacity-10">
                                    <i class="bi bi-hash text-primary opacity-50"></i>{{ $order->order_number }}
                                </span>
                            </td>
                            <td class="px-3">
                                <div class="d-flex align-items-center gap-3">
                                    @php
                                        $colors = ['primary', 'success', 'warning', 'danger', 'info'];
                                        $scolor = $colors[abs(crc32($order->user->id)) % count($colors)];
                                    @endphp
                                    <div class="rounded-circle bg-{{ $scolor }} bg-opacity-10 text-{{ $scolor }} d-flex align-items-center justify-content-center fw-black shadow-sm"
                                        style="width: 40px; height: 40px; font-size: 1.1rem;">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-dark small fw-bold">{{ $order->user->name }}</div>
                                        <div class="xx-small text-secondary fw-bold mt-1">{{ $order->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3">
                                @php
                                    $badgeColor = 'primary';
                                    $ordStatus = strtolower($order->order_status ?? '');
                                    if ($ordStatus == 'completed' || $ordStatus == 'delivered')
                                        $badgeColor = 'success';
                                    if ($ordStatus == 'pending')
                                        $badgeColor = 'white';
                                    if ($ordStatus == 'cancelled')
                                        $badgeColor = 'danger';
                                @endphp
                                <span
                                    class="badge bg-{{ $badgeColor }} px-3 py-2 rounded-pill x-small fw-bold d-inline-flex align-items-center shadow-sm text-white">
                                    <span style="letter-spacing: 0.5px;">{{ strtoupper($ordStatus ?: 'UNKNOWN') }}</span>
                                </span>
                            </td>
                            <td class="text-end fw-black fs-6 text-dark px-4">
                                ₹{{ number_format($order->total_amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox fs-1 text-secondary opacity-25 mb-3 d-block"></i>
                                    <h6 class="text-dark fw-bold">No active transactions.</h6>
                                    <p class="text-secondary small mb-0">It looks like there are no recent orders to show here.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('revenueChart');
            if (!ctx) return;

            const ctx2d = ctx.getContext('2d');

            // Premium Light Theme Gradient Fill
            let gradientFill = ctx2d.createLinearGradient(0, 0, 0, 400);
            gradientFill.addColorStop(0, 'rgba(16, 185, 129, 0.25)'); // Success green at top
            gradientFill.addColorStop(1, 'rgba(255, 255, 255, 0)');     // Fade to white

            new Chart(ctx2d, {
                type: 'line',
                data: {
                    labels: ['Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'],
                    datasets: [{
                        label: 'Revenue Tracker',
                        data: [18000, 32000, 24500, 52000, 43000, 85500],
                        borderColor: '#10b981', // Solid premium green
                        backgroundColor: gradientFill,
                        borderWidth: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#10b981',
                        pointHoverBorderColor: '#fff',
                        fill: true,
                        tension: 0.4 // Smooth Bezier
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#111827',
                            titleColor: '#9ca3af',
                            bodyColor: '#fff',
                            titleFont: { size: 13, weight: 'bold' },
                            bodyFont: { size: 16, weight: 'bold' },
                            padding: 16,
                            cornerRadius: 12,
                            displayColors: false,
                            callbacks: {
                                label: function (context) {
                                    return '₹ ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.04)',
                                drawBorder: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                color: '#6b7280',
                                font: { size: 12, weight: '600' },
                                callback: function (value) { return '₹' + (value / 1000) + 'k'; },
                                padding: 15
                            }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: {
                                color: '#6b7280',
                                font: { size: 13, weight: 'bold' },
                                padding: 10
                            }
                        }
                    }
                }
            });
        });
    </script>

    <style>
        /* Premium Utilities Extracted for Dashboard */
        .pulse-dot-container {
            display: inline-flex;
            align-items: center;
        }

        .pulse-dot {
            box-shadow: 0 0 0 0 rgba(255, 184, 0, 0.7);
            animation: pulseDot 2s infinite;
        }

        @keyframes pulseDot {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 184, 0, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(255, 184, 0, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 184, 0, 0);
            }
        }

        .tracking-widest {
            letter-spacing: 0.1em;
        }

        .hover-shadow-lg:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06) !important;
            transform: translateY(-3px);
        }

        .hover-translate-y:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .hover-shadow-sm:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.04) !important;
            transform: translateX(3px);
        }

        /* Elegant Hover State mapping for modules */
        .group:hover .group-hover-bg-primary {
            background: #0d6efd !important;
            color: white !important;
        }

        .group:hover .group-hover-bg-warning {
            background: #ffc107 !important;
            color: white !important;
            text-shadow: none;
        }

        .group:hover .group-hover-bg-success {
            background: #198754 !important;
            color: white !important;
        }
    </style>
@endpush