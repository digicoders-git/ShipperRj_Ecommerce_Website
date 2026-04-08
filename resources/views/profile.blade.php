@extends('layouts.app')

@section('content')
    <div class="dashboard-main">
        @include('includes.dashboard_header')

        <div class="container py-5">
            @if(session('success'))
                <div class="alert alert-success rounded-4 border-0 shadow-sm p-3 mb-4 fade-in-up">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                        <span class="fw-bold">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger rounded-4 border-0 shadow-sm p-4 mb-4">
                    <h6 class="fw-bold mb-2">Update Failed!</h6>
                    <ul class="mb-0 small fw-medium">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-4 align-items-start dashboard-row-premium">
                <!-- Sidebar -->
                <div class="col-lg-3 dashboard-sidebar-column">
                    @include('includes.dashboard_sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9 fade-in-up">
                    <div
                        class="profile-header-premium mb-4 rounded-4 p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-4">
                            <div class="position-relative">
                                <div class="profile-avatar-container">
                                    @if(Auth::user()->profile_photo)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                            class="rounded-circle border border-4 border-white shadow-md profile-avatar-img"
                                            alt="Avatar">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=FF7A18&color=fff&size=200&bold=true"
                                            class="rounded-circle border border-4 border-white shadow-md profile-avatar-img"
                                            alt="Avatar">
                                    @endif
                                    <label for="profile_photo_top" class="avatar-edit-btn">
                                        <i class="bi bi-camera-fill"></i>
                                    </label>
                                    <form action="{{ url('/profile/update') }}" method="POST" enctype="multipart/form-data"
                                        id="topAvatarForm" class="d-none">
                                        @csrf
                                        <input type="file" name="profile_photo" id="profile_photo_top"
                                            onchange="document.getElementById('topAvatarForm').submit()">
                                    </form>
                                </div>
                            </div>
                            <div>
                                <h3 class="fw-black text-dark mb-1">{{ Auth::user()->name }}</h3>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted small fw-medium">{{ Auth::user()->email }}</span>
                                    <span
                                        class="badge bg-success-soft text-success rounded-pill px-2 py-1 x-small fw-bold border border-success border-opacity-10">
                                        <i class="bi bi-patch-check-fill me-1"></i> Verified
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="stat-pill">
                                <span class="label">Orders</span>
                                <span class="value">{{ Auth::user()->orders->count() }}</span>
                            </div>
                            <div class="stat-pill primary">
                                <span class="label">Wallet</span>
                                <span class="value">₹{{ number_format(Auth::user()->wallet_balance, 0) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-card overflow-hidden">
                        <!-- Custom Tabs -->
                        <div class="profile-tabs-nav border-bottom bg-light bg-opacity-50 px-4">
                            <ul class="nav nav-pills gap-1 py-2" id="profileTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="details-tab" data-bs-toggle="pill"
                                        data-bs-target="#details" type="button" role="tab">
                                        <i class="bi bi-person-fill"></i> <span>Personal Details</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="address-tab" data-bs-toggle="pill"
                                        data-bs-target="#address" type="button" role="tab">
                                        <i class="bi bi-geo-alt-fill"></i> <span>Customer Address</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="security-tab" data-bs-toggle="pill"
                                        data-bs-target="#security" type="button" role="tab">
                                        <i class="bi bi-shield-lock-fill"></i> <span>Security</span>
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content" id="profileTabsContent">
                            <!-- Tab 1: Details -->
                            <div class="tab-pane fade show active p-4 p-lg-5" id="details" role="tabpanel">
                                <form action="{{ url('/profile/update') }}" method="POST">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="section-divider mb-4">
                                                <span class="fw-bold small text-primary text-uppercase ls-1">Account
                                                    Information</span>
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-premium">Display Name</label>
                                            <div class="input-with-icon">
                                                <i class="bi bi-person text-muted"></i>
                                                <input type="text" name="name" class="form-control form-control-premium"
                                                    value="{{ Auth::user()->name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-premium">Phone Number</label>
                                            <div class="input-with-icon">
                                                <i class="bi bi-phone text-muted"></i>
                                                <input type="text" name="mobile" class="form-control form-control-premium"
                                                    value="{{ Auth::user()->mobile }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label-premium">Email Address <small
                                                    class="text-muted">(Primary)</small></label>
                                            <div class="input-with-icon">
                                                <i class="bi bi-envelope text-muted"></i>
                                                <input type="email"
                                                    class="form-control form-control-premium bg-light opacity-75"
                                                    value="{{ Auth::user()->email }}" readonly>
                                            </div>
                                            <p class="xx-small text-muted mt-2 fw-medium"><i
                                                    class="bi bi-info-circle me-1"></i> Email address cannot be changed.
                                                Contact support for updates.</p>
                                        </div>
                                        <div class="col-12 mt-4 pt-2">
                                            <button type="submit"
                                                class="btn btn-premium px-5 py-3 rounded-pill fw-bold">Update Account
                                                Details</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Tab 2: Address -->
                            <div class="tab-pane fade p-4 p-lg-5" id="address" role="tabpanel">
                                <form action="{{ url('/profile/update') }}" method="POST">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="section-divider mb-4">
                                                <span class="fw-bold small text-primary text-uppercase ls-1">User
                                                    Address</span>
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label-premium">Address</label>
                                            <textarea name="address" rows="3" class="form-control form-control-premium"
                                                placeholder="Flat No, Building, Street Name...">{{ Auth::user()->address }}</textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-premium">City</label>
                                            <input type="text" name="city" class="form-control form-control-premium"
                                                value="{{ Auth::user()->city }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-premium">State</label>
                                            <input type="text" name="state" class="form-control form-control-premium"
                                                value="{{ Auth::user()->state }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-premium">Pincode</label>
                                            <input type="text" name="pincode" class="form-control form-control-premium"
                                                value="{{ Auth::user()->pincode }}">
                                        </div>
                                        <div class="col-12 mt-4 pt-2">
                                            <button type="submit"
                                                class="btn btn-premium px-5 py-3 rounded-pill fw-bold">Save Address</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Tab 3: Security -->
                            <div class="tab-pane fade p-4 p-lg-5" id="security" role="tabpanel">
                                <div class="row g-5">
                                    <div class="col-lg-7">
                                        <form action="{{ url('/profile/password') }}" method="POST">
                                            @csrf
                                            <div class="section-divider mb-4">
                                                <span class="fw-bold small text-primary text-uppercase ls-1">Change Account
                                                    Password</span>
                                                <hr>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col-12">
                                                    <label class="form-label-premium">Current Password</label>
                                                    <div class="input-group input-group-premium">
                                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                                        <input type="password" name="current_password"
                                                            class="form-control form-control-premium border-start-0"
                                                            placeholder="••••••••" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label-premium">New Password</label>
                                                    <div class="input-group input-group-premium">
                                                        <span class="input-group-text"><i
                                                                class="bi bi-shield-lock"></i></span>
                                                        <input type="password" name="new_password"
                                                            class="form-control form-control-premium border-start-0"
                                                            placeholder="Minimum 8 characters" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label-premium">Confirm New Password</label>
                                                    <div class="input-group input-group-premium">
                                                        <span class="input-group-text"><i
                                                                class="bi bi-shield-check"></i></span>
                                                        <input type="password" name="new_password_confirmation"
                                                            class="form-control form-control-premium border-start-0"
                                                            placeholder="Repeat new password" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-4">
                                                    <button type="submit"
                                                        class="btn btn-dark px-5 py-3 rounded-pill fw-bold w-100">Update
                                                        Secure Password</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-5">
                                        <div
                                            class="account-security-info h-100 p-4 rounded-4 bg-light d-flex flex-column border">
                                            <div class="text-center mb-4">
                                                <div class="security-icon-circle mx-auto mb-3">
                                                    <i class="bi bi-shield-fill-check"></i>
                                                </div>
                                                <h6 class="fw-black mb-1">Security Health</h6>
                                                <p class="xx-small text-muted fw-medium">Keep your account safe and secure.
                                                </p>
                                            </div>
                                            <ul class="list-unstyled mb-4 flex-grow-1">
                                                <li class="d-flex gap-2 mb-3 align-items-start small">
                                                    <i class="bi bi-check2-circle text-success mt-1"></i>
                                                    <span>Regularly change your password for safety.</span>
                                                </li>
                                                <li class="d-flex gap-2 mb-3 align-items-start small">
                                                    <i class="bi bi-check2-circle text-success mt-1"></i>
                                                    <span>Ensure your phone number is up to date for OTPs.</span>
                                                </li>
                                            </ul>
                                            <div class="pt-4 border-top">
                                                <h6 class="fw-bold text-danger small mb-3">Danger Zone</h6>
                                                <button type="button" onclick="confirmDeletion()"
                                                    class="btn btn-outline-danger w-100 rounded-pill small fw-bold py-2">Delete
                                                    My Account Permanently</button>
                                                <form id="deleteAccountForm" action="{{ route('profile.delete') }}"
                                                    method="POST" class="d-none">
                                                    @csrf
                                                </form>
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
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('avatarPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    document.getElementById('avatarForm').submit();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Deletion Confirmation
        function confirmDeletion() {
            Swal.fire({
                title: 'Are you absolutely sure?',
                text: "Your account and all your data (orders, wishlist, wallet history) will be permanently gone. This cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it',
                customClass: {
                    popup: 'rounded-4 border-0',
                    confirmButton: 'rounded-pill px-4',
                    cancelButton: 'rounded-pill px-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteAccountForm').submit();
                }
            });
        }

        // Toggle Password Visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('bi-eye', 'bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('bi-eye-slash', 'bi-eye');
                }
            });
        });
    </script>

    <style>
        .profile-header-premium {
            background: #fff;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .profile-avatar-container {
            position: relative;
            width: 90px;
            height: 90px;
        }

        .profile-avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-edit-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 32px;
            height: 32px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
            cursor: pointer;
            font-size: 0.8rem;
            box-shadow: 0 4px 10px rgba(255, 122, 24, 0.3);
            transition: all 0.3s ease;
        }

        .avatar-edit-btn:hover {
            transform: scale(1.1);
            background: #e66e15;
        }

        .stat-pill {
            background: #f8f9fa;
            padding: 8px 16px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            min-width: 100px;
            border: 1px solid var(--border);
        }

        .stat-pill.primary {
            background: var(--primary-soft);
            border-color: rgba(255, 122, 24, 0.1);
        }

        .stat-pill .label {
            font-size: 0.65rem;
            text-transform: uppercase;
            font-weight: 800;
            color: var(--text-muted);
            letter-spacing: 0.5px;
        }

        .stat-pill.primary .label {
            color: var(--primary);
        }

        .stat-pill .value {
            font-size: 1.1rem;
            font-weight: 900;
            color: var(--dark);
        }

        .profile-tabs-nav .nav-link {
            border: none;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.85rem;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-tabs-nav .nav-link i {
            font-size: 1.1rem;
        }

        .profile-tabs-nav .nav-link.active {
            background: #fff;
            color: var(--primary);
            box-shadow: var(--shadow-sm);
        }

        .section-divider {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .section-divider hr {
            flex: 1;
            margin: 0;
            opacity: 0.1;
        }

        .form-label-premium {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
            display: block;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.1rem;
        }

        .input-with-icon .form-control {
            padding-left: 45px;
        }

        .input-group-premium .input-group-text {
            background: #fff;
            border: 1px solid var(--border);
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: var(--text-muted);
            padding: 0 15px;
        }

        .security-icon-circle {
            width: 60px;
            height: 60px;
            background: var(--primary-soft);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .bg-success-soft {
            background: rgba(13, 148, 136, 0.08);
        }

        @media (max-width: 768px) {
            .profile-header-premium {
                flex-direction: column;
                text-align: center;
            }

            .profile-header-premium .d-flex {
                flex-direction: column;
            }

            .profile-tabs-nav .nav {
                flex-wrap: nowrap;
                overflow-x: auto;
                padding-bottom: 5px;
            }

            .profile-tabs-nav .nav-link span {
                white-space: nowrap;
            }
        }
    </style>
@endsection