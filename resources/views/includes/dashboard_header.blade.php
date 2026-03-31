<div class="dashboard-header-light">
    <div class="container position-relative z-1">
        <div class="row g-4 align-items-center">
            <div class="col-md-auto text-center text-md-start">
                <div class="profile-avatar-wrapper mx-auto">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
                             class="profile-avatar" 
                             alt="User Avatar">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=FF7A18&color=fff&size=120&bold=true" 
                             class="profile-avatar" 
                             alt="User Avatar">
                    @endif
                    <div class="verify-badge shadow-sm">
                        <i class="bi bi-check-lg"></i>
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="text-center text-md-start">
                    <span class="badge bg-primary-soft text-primary rounded-pill px-3 py-2 mb-3 fw-bold x-small">WELCOME BACK</span>
                    <h1 class="fw-black text-dark mb-1 letter-spacing-n1 display-5">Namaste, {{ explode(' ', Auth::user()->name)[0] }}!</h1>
                    <p class="text-muted mb-0 fw-medium">
                        Manage your orders, wallet balance and account settings in one place.
                    </p>
                </div>
            </div>
            <div class="col-md-auto ms-auto text-center text-md-end">
                <div class="d-flex gap-2 justify-content-center justify-content-md-end">
                    <div class="bg-white p-3 rounded-4 border shadow-sm">
                        <p class="x-small text-muted fw-bold mb-1 text-uppercase ls-1">Current Balance</p>
                        <h4 class="fw-black text-dark mb-0">₹{{ number_format(Auth::user()->wallet_balance ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

