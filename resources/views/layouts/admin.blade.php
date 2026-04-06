<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | SHOPPING CLUB INDIA Admin</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Global Custom CSS (Glassmorphism Utilities) -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=1.0.2">
    <!-- Admin Specific Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}?v=1.0.2">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
        .sidebar-logo-img {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-collapsed .sidebar-logo-img {
            max-height: 35px !important;
            transform: scale(0.9);
        }

        .sidebar-collapsed .admin-sidebar:hover .sidebar-logo-img {
            max-height: 80px !important;
            transform: scale(1);
        }

        .sidebar-logo-wrapper {
            background: transparent;
            border-radius: 0;
            padding: 0;
            border: none;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 100%;
        }

        .sidebar-header {
            height: 80px !important;
            padding: 2px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            overflow: hidden;
        }

        .sidebar-toggle-btn {
            z-index: 1100 !important;
            position: relative;
            cursor: pointer !important;
            pointer-events: auto !important;
        }
    </style>
</head>

<body>
    <!-- Glass Toasts Container -->
    <div id="glassToastContainer" class="glass-toast-container"></div>

    @php
        $isAdmin = auth('admin')->check();
        $subAdmin = auth('subadmin')->user();
    @endphp

    <div class="admin-sidebar">
        <!-- Sidebar Header (Fixed) -->
        <div class="sidebar-header d-flex align-items-center justify-content-center py-2 px-1">
            <div class="sidebar-logo-wrapper w-100 px-1">
                <div class="d-flex align-items-center justify-content-center">
                    <img src="{{ asset('assets/images/logo1.png') }}" alt="SHOPPING CLUB INDIA Logo"
                        class="img-fluid sidebar-logo-img"
                        style="max-height: 70px; width: auto; transition: all 0.3s_ease;">
                </div>
            </div>
            <!-- Close Button for Mobile -->
            <div id="sidebarCloseBtn" class="sidebar-close-btn d-lg-none position-absolute top-0 end-0 m-2">
                <i class="bi bi-x-lg"></i>
            </div>
        </div>

        <!-- Sidebar Nav (Scrollable) -->
        <div class="sidebar-nav">
            <div class="nav flex-column">

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('dashboard_view')))
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                @endif

                @if($isAdmin || ($subAdmin && ($subAdmin->hasPermission('categories_view') || $subAdmin->hasPermission('sub_categories_view') || $subAdmin->hasPermission('products_view'))))
                    <div class="sidebar-section-title">Catalog & Inventory</div>
                @endif

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('categories_view')))
                    <a href="{{ route('admin.categories.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-grid-3x3-gap"></i> <span>Categories</span>
                    </a>
                @endif

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('sub_categories_view')))
                    <a href="{{ route('admin.sub-categories.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.sub-categories.*') ? 'active' : '' }}">
                        <i class="bi bi-grid"></i> <span>Sub Categories</span>
                    </a>
                @endif

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('products_view')))
                    <a href="{{ route('admin.products.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i> <span>Products</span>
                    </a>
                @endif

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('coupons_view')))
                    <a href="{{ route('admin.coupons.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                        <i class="bi bi-ticket-perforated"></i> <span>Offers & Coupons</span>
                    </a>
                @endif

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('orders_view')))
                    <div class="sidebar-section-title">Orders & Logistics</div>
                    <a href="{{ route('admin.orders.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="bi bi-cart-check"></i> <span>Orders</span>
                    </a>
                    @if($isAdmin)
                        <a href="{{ route('admin.settings') }}"
                            class="nav-link-admin {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                            <i class="bi bi-funnel"></i> <span>Set Minimum Global Order Value</span>
                        </a>
                    @endif
                @endif

                @if($isAdmin || ($subAdmin && ($subAdmin->hasPermission('transactions_view') || $subAdmin->hasPermission('wallet_deals_view') || $subAdmin->hasPermission('users_view'))))
                    <div class="sidebar-section-title">Finance & Users</div>
                @endif

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('transactions_view')))
                    <a href="{{ route('admin.transactions.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.transactions.index') ? 'active' : '' }}">
                        <i class="bi bi-journal-text"></i> <span>Payments & Transactions</span>
                    </a>
                @endif

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('wallet_deals_view')))
                    <a href="{{ route('admin.wallet-offers.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.wallet-offers.*') ? 'active' : '' }}">
                        <i class="bi bi-gift"></i> <span>Wallet Bonus Deals</span>
                    </a>
                @endif

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('users_view')))
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> <span>Users/Customers</span>
                    </a>
                @endif

                @if($isAdmin || ($subAdmin && ($subAdmin->hasPermission('complaints_view') || $subAdmin->hasPermission('contacts_view') || $subAdmin->hasPermission('support_view') || $subAdmin->hasPermission('reviews_view') || $subAdmin->hasPermission('seller_inquiries_view'))))
                    <div class="sidebar-section-title">Customer Support</div>
                @endif

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('seller_inquiries_view')))
                    <a href="{{ route('admin.seller-inquiries.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.seller-inquiries.*') ? 'active' : '' }}">
                        <i class="bi bi-shop"></i> <span>Seller Inquiries</span>
                    </a>
                @endif

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('complaints_view')))
                    <a href="{{ route('admin.complaints.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-left-text"></i> <span>Complaints</span>
                    </a>
                @endif

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('contacts_view')))
                    <a href="{{ route('admin.contacts.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                        <i class="bi bi-envelope"></i> <span>Contact Inquiries</span>
                    </a>
                @endif

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('support_view')))
                    <a href="{{ route('admin.support-tickets.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.support-tickets.*') ? 'active' : '' }}">
                        <i class="bi bi-headset"></i> <span>Support & Feedback</span>
                    </a>
                @endif

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('reviews_view')))
                    <a href="{{ route('admin.reviews.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                        <i class="bi bi-star-half"></i> <span>Product Reviews</span>
                    </a>
                @endif

                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('refunds_view')))
                    <a href="{{ route('admin.refunds.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.refunds.*') ? 'active' : '' }}">
                        <i class="bi bi-arrow-counterclockwise"></i> <span>Refund & Cancellations</span>
                    </a>
                @endif

                @if($isAdmin)
                    <div class="sidebar-section-title">System Administration</div>
                    <a href="{{ route('admin.subadmins.index') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.subadmins.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-lock"></i> <span>Sub Admin System</span>
                    </a>
                    <a href="{{ route('admin.profile') }}"
                        class="nav-link-admin {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i> <span>My Profile</span>
                    </a>
                    <a href="{{ route('admin.profile') }}#changePasswordSection" class="nav-link-admin">
                        <i class="bi bi-key"></i> <span>Change Password</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Sidebar Footer (Fixed) -->
        <div class="sidebar-footer">
            <form action="{{ route('admin.logout') }}" method="POST" id="logout-form" class="d-none">
                @csrf
            </form>
            <a href="#" class="logout-btn-premium" onclick="confirmLogout(event)">
                <i class="bi bi-box-arrow-right me-2"></i> <span class="logout-text">Logout System</span>
            </a>
        </div>
    </div>

    <header class="admin-header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <!-- Left Side: Toggle & Title -->
            <div class="d-flex align-items-center overflow-hidden">
                <div id="sidebarToggle" class="sidebar-toggle-btn flex-shrink-0">
                    <i class="bi bi-list fs-5"></i>
                </div>
                <div class="text-truncate ms-2">
                    <h6 class="fw-bold mb-0 text-white text-truncate" style="letter-spacing: 0.5px;">Dashboard</h6>
                    <div class="d-flex align-items-center x-small mt-1">
                        <span class="text-success d-flex align-items-center fw-bold">
                            <span class="pulse-dot me-2 ms-1"></span>
                            <span class="d-none d-sm-inline">System Active</span>
                        </span>
                        <span class="text-secondary opacity-50 d-none d-sm-inline mx-2">|</span>
                        <span class="text-white opacity-75 d-none d-sm-inline font-monospace" id="liveClock">Loading
                            time...</span>
                    </div>
                </div>
            </div>

            <!-- Right Side: Profile & Actions -->
            <div class="d-flex align-items-center ms-2 flex-shrink-0">
                <div class="header-glass-pill py-2 px-3 d-flex align-items-center">
                    <i
                        class="bi bi-bell text-white opacity-75 me-3 d-none d-sm-block hover-white cursor-pointer transition-all"></i>
                    <div class="vr bg-white opacity-25 me-3 d-none d-sm-block" style="height: 20px;"></div>
                    <div class="dropdown">
                        <div class="d-flex align-items-center cursor-pointer" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if($isAdmin)
                                <img src="https://ui-avatars.com/api/?name=Admin&background=FFB800&color=000"
                                    class="rounded-circle me-0 me-md-2 shadow-sm"
                                    style="width: 32px; height: 32px; border: 2px solid rgba(255,255,255,0.2);">
                                <span class="small fw-bold d-none d-md-block text-white transition-all"
                                    style="white-space: nowrap;">Shopping Club Admin <i
                                        class="bi bi-chevron-down ms-1 xx-small opacity-50"></i></span>
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($subAdmin->name) }}&background=0DCAF0&color=000"
                                    class="rounded-circle me-0 me-md-2 shadow-sm"
                                    style="width: 32px; height: 32px; border: 2px solid rgba(255,255,255,0.2);">
                                <span class="small fw-bold d-none d-md-block text-white transition-all"
                                    style="white-space: nowrap;">{{ $subAdmin->name }} (Sub Admin) <i
                                        class="bi bi-chevron-down ms-1 xx-small opacity-50"></i></span>
                            @endif
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg rounded-4 mt-3"
                            style="background: #ffffff; min-width: 220px; padding: 10px; border: 1px solid rgba(0,0,0,0.08) !important; box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;">
                            @if($isAdmin)
                                <li>
                                    <a class="d-flex align-items-center rounded-3 text-dark text-decoration-none py-2 px-3 fw-bold small transition-all"
                                        href="{{ url('admin/profile') }}"
                                        onmouseover="this.style.background='rgba(0,0,0,0.04)'"
                                        onmouseout="this.style.background='transparent'">
                                        <i class="bi bi-person text-primary fs-5 me-3"></i>
                                        <span>My Profile</span>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <hr class="dropdown-divider my-2 opacity-10">
                            </li>
                            <li>
                                <a class="d-flex align-items-center rounded-3 text-danger text-decoration-none fw-black py-2 px-3 small transition-all"
                                    href="#" onclick="confirmLogout(event)"
                                    onmouseover="this.style.background='rgba(239, 68, 68, 0.08)'"
                                    onmouseout="this.style.background='transparent'">
                                    <i class="bi bi-box-arrow-right fs-5 me-3"></i>
                                    <span>Secure Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script>
        // Live Clock Logic
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' };
            const dateString = now.toLocaleDateString('en-US', options);
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;
            const timeString = hours + ':' + minutes + ':' + seconds + ' ' + ampm;

            const clockEl = document.getElementById('liveClock');
            if (clockEl) clockEl.innerHTML = dateString + ' &nbsp;&bull;&nbsp; ' + timeString;
        }
        setInterval(updateClock, 1000);
        updateClock(); // initial call
    </script>

    <main class="admin-main">
        @yield('admin_content')
    </main>

    @stack('modals')

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Global Toast Function
        window.showToast = function (message, type = 'success') {
            console.log("Triggering Toast:", message, type);
            const icon = type === 'success' ? 'bi-check-circle-fill' : (type === 'error' ? 'bi-exclamation-triangle-fill' : 'bi-info-circle-fill');
            const toastId = 'toast_' + Date.now();
            const toastHtml = `
                <div id="${toastId}" class="glass-toast ${type}">
                    <i class="bi ${icon} fs-5"></i>
                    <div class="toast-content">${message}</div>
                </div>
            `;
            $('#glassToastContainer').append(toastHtml);

            // Auto remove
            setTimeout(() => {
                $(`#${toastId}`).addClass('fade-out');
                setTimeout(() => $(`#${toastId}`).remove(), 400);
            }, 4000);
        };

        $(document).ready(function () {
            // Re-initialize DataTable only if not already initialized
            // Re-initialize DataTable with support for dynamic serial numbers
            $('.admin-datatable').each(function () {
                if (!$.fn.DataTable.isDataTable(this)) {
                    const table = $(this);
                    // Find the index of the serial number column if it exists
                    const serialColIndex = table.find('th.serial-col').index();

                    const dt = table.DataTable({
                        "pageLength": 10,
                        "order": [],
                        "columnDefs": serialColIndex !== -1 ? [
                            { "orderable": false, "targets": serialColIndex }
                        ] : [],
                        "language": {
                            "search": "Search:",
                            "searchPlaceholder": "Type to filter..."
                        }
                    });

                    // Dynamic serial numbering logic
                    if (serialColIndex !== -1) {
                        dt.on('order.dt search.dt', function () {
                            dt.column(serialColIndex, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                                cell.innerHTML = '#' + (i + 1);
                            });
                        }).draw();
                    }
                }
            });

            // SweetAlert Deletion
            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this action!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#FFB800',
                    cancelButtonColor: '#ff4d4d',
                    confirmButtonText: '<span style="color:#000;">Yes, delete it!</span>',
                    cancelButtonText: 'Cancel',
                    background: 'rgba(255, 255, 255, 0.95)',
                    backdrop: `rgba(0,0,10,0.4)`
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // SweetAlert Block Toggle
            $(document).on('click', '.btn-block-toggle', function (e) {
                e.preventDefault();
                const form = $(this).closest('form');
                const status = $(this).data('status');
                const isBlock = status === 'block';

                Swal.fire({
                    title: isBlock ? 'Block User Account?' : 'Unblock User Account?',
                    text: isBlock ? "The user will be immediately logged out and denied access." : "The user will regain full access to their account.",
                    icon: isBlock ? 'warning' : 'question',
                    showCancelButton: true,
                    confirmButtonColor: isBlock ? '#ef4444' : '#10b981',
                    cancelButtonColor: '#f1f5f9',
                    confirmButtonText: isBlock ? 'Yes, Block User' : 'Yes, Restore Access',
                    cancelButtonText: 'Cancel',
                    background: '#ffffff',
                    color: '#111827',
                    backdrop: `rgba(0,0,0,0.4) backdrop-filter: blur(4px)`,
                    customClass: {
                        popup: 'border border-dark border-opacity-10 rounded-4 shadow-lg',
                        confirmButton: 'rounded-pill fw-bold text-white px-4 py-2 border-0 shadow-sm',
                        cancelButton: 'rounded-pill fw-bold text-dark px-4 py-2 border border-dark border-opacity-10'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Check for Laravel Sessions & Errors
            @if(session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif

            @if(session('error'))
                showToast("{{ session('error') }}", 'error');
            @endif

            @if($errors->any())
                @foreach($errors->all() as $error)
                    showToast("{{ $error }}", 'error');
                @endforeach
            @endif

            // --- Robust Sidebar Toggle Persistence ---
            if (localStorage.getItem('sidebar-collapsed') === 'true') {
                if (window.innerWidth > 991) {
                    document.body.classList.add('sidebar-collapsed');
                }
            }

            // --- Robust Sidebar Toggle Logic ---
            const toggleSidebar = () => {
                const body = document.body;
                const isMobile = window.innerWidth <= 991;

                if (isMobile) {
                    body.classList.toggle('sidebar-active');
                    console.log("Mobile Sidebar Toggle:", body.classList.contains('sidebar-active'));
                } else {
                    body.classList.toggle('sidebar-collapsed');
                    const isCollapsed = body.classList.contains('sidebar-collapsed');
                    localStorage.setItem('sidebar-collapsed', isCollapsed);
                    console.log("Desktop Sidebar Toggle:", isCollapsed ? 'Collapsed' : 'Expanded');
                }
            };

            // Use native listener for maximum reliability
            document.addEventListener('click', function (e) {
                if (e.target.closest('#sidebarToggle')) {
                    e.preventDefault();
                    toggleSidebar();
                }

                if (e.target.closest('#sidebarCloseBtn')) {
                    document.body.classList.remove('sidebar-active');
                }

                // Close on click outside (mobile only)
                if (window.innerWidth <= 991 &&
                    !e.target.closest('.admin-sidebar') &&
                    !e.target.closest('#sidebarToggle') &&
                    document.body.classList.contains('sidebar-active')) {
                    document.body.classList.remove('sidebar-active');
                }
            });
        });

        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Ready to Leave?',
                text: "You are about to securely log out of your session.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#f1f5f9',
                confirmButtonText: '<i class="bi bi-box-arrow-right me-2"></i>Yes, Logout',
                cancelButtonText: 'Stay Logged In',
                background: '#ffffff',
                color: '#111827',
                backdrop: `rgba(0,0,0,0.4) backdrop-filter: blur(4px)`,
                customClass: {
                    popup: 'border border-dark border-opacity-10 rounded-4 shadow-lg',
                    confirmButton: 'rounded-pill fw-bold text-white px-4 py-2 border-0 shadow-sm',
                    cancelButton: 'rounded-pill fw-bold text-dark px-4 py-2 border border-dark border-opacity-10'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

    @stack('scripts')
</body>

</html>