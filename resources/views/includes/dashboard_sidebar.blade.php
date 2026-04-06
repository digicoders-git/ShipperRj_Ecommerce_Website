<div id="sidebarCard" class="dashboard-card p-0 overflow-hidden shadow-sm border-0 rounded-4 bg-white">
    <!-- Profile Section -->
    <div class="p-4 bg-light bg-opacity-50 border-bottom">
        <div class="d-flex align-items-center gap-3">
            <div class="position-relative">
                @if(Auth::user()->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                        class="rounded-circle border border-3 border-white shadow-sm" alt="User Avatar"
                        style="width: 54px; height: 54px; object-fit: cover;">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=FF7A18&color=fff&size=54&bold=true"
                        class="rounded-circle border border-3 border-white shadow-sm" alt="User Avatar"
                        style="width: 54px; height: 54px;">
                @endif
                <div class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle"
                    style="width: 12px; height: 12px;"></div>
            </div>
            <div class="overflow-hidden">
                <h6 class="fw-black text-dark mb-0 text-truncate">{{ Auth::user()->name }}</h6>
                <p class="text-muted xx-small fw-bold mb-0 text-truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation Links -->
    <div class="p-3">
        <nav class="nav flex-column gap-1">
            <a href="{{ url('/dashboard') }}" class="dash-nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i>
                <span>Overview</span>
            </a>
            <a href="{{ url('/orders') }}" class="dash-nav-link {{ request()->is('orders') ? 'active' : '' }}">
                <i class="bi bi-bag-heart-fill"></i>
                <span>My Orders</span>
            </a>
            <a href="{{ url('/wishlist') }}" class="dash-nav-link {{ request()->is('wishlist') ? 'active' : '' }}">
                <i class="bi bi-bookmark-star-fill"></i>
                <span>Wishlist</span>
            </a>
            <a href="{{ url('/wallet') }}" class="dash-nav-link {{ request()->is('wallet') ? 'active' : '' }}">
                <i class="bi bi-wallet-fill"></i>
                <span>My Wallet</span>
            </a>
            <a href="{{ url('/profile') }}" class="dash-nav-link {{ request()->is('profile') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill"></i>
                <span>Profile Settings</span>
            </a>
            <a href="{{ route('addresses.index') }}"
                class="dash-nav-link {{ request()->is('addresses*') ? 'active' : '' }}">
                <i class="bi bi-geo-fill"></i>
                <span>Delivery Addresses</span>
            </a>
            <a href="{{ url('/helpdesk') }}" class="dash-nav-link {{ request()->is('helpdesk*') ? 'active' : '' }}">
                <i class="bi bi-headset"></i>
                <span>Help & Support</span>
            </a>
            <div class="px-3 my-2">
                <hr class="my-0 opacity-5">
            </div>
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit" class="dash-nav-link logout-btn w-100 border-0 bg-transparent text-start">
                    <i class="bi bi-power"></i>
                    <span>Secure Logout</span>
                </button>
            </form>
        </nav>
    </div>
</div>

<style>
    @media (min-width: 992px) {
        #sidebarCard {
            position: sticky;
            top: 100px;
            /* Accounts for the sticky main header */
            z-index: 90;
        }

        /* Ensure columns stretch to full height so the card has room to move inside them */
        .dashboard-sidebar-column {
            align-self: stretch !important;
        }

        /* Remove force alignment from the row to ensure columns can stretch */
        .dashboard-row-premium,
        .dashboard-main-row {
            align-items: stretch !important;
        }
    }

    .dash-nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: #6c757d;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        border-radius: 12px;
        transition: background 0.2s, color 0.2s;
    }

    .dash-nav-link i {
        font-size: 1.1rem;
    }

    .dash-nav-link:hover {
        background: #f8f9fa;
        color: var(--primary);
    }

    .dash-nav-link.active {
        background: var(--primary);
        color: #fff;
        box-shadow: 0 4px 12px rgba(255, 122, 24, 0.2);
    }

    .dash-nav-link.logout-btn:hover {
        background: #fff5f5;
        color: #dc3545;
    }
</style>