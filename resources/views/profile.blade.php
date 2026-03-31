@extends('layouts.app')

@section('content')
    <div class="dashboard-main">
        @include('includes.dashboard_header')

        <div class="container py-5">
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
                    <div class="dashboard-card p-4 p-lg-5">
                        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
                            <div>
                                <h3 class="fw-black mb-1 letter-spacing-n1">My Profile</h3>
                                <p class="text-muted small mb-0 fw-medium">Manage your personal information and security.
                                </p>
                            </div>
                            <div class="badge bg-success-soft text-success px-4 py-2 rounded-pill small fw-bold">
                                <i class="bi bi-shield-check me-2"></i> Account Verified
                            </div>
                        </div>

                        <div class="row g-5">
                            <!-- Profile Photo -->
                            <div class="col-md-4">
                                <div class="p-4 rounded-4 bg-light text-center">
                                    <form action="{{ url('/profile/update') }}" method="POST" enctype="multipart/form-data"
                                        id="avatarForm">
                                        @csrf
                                        <div class="position-relative d-inline-block mb-3">
                                            <div
                                                class="avatar-wrapper rounded-circle p-1 border border-2 border-primary border-dashed">
                                                @if(Auth::user()->profile_photo)
                                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                                        id="avatarPreview"
                                                        class="rounded-circle border border-4 border-white object-fit-cover shadow-sm"
                                                        alt="Avatar" style="width:140px; height:140px;">
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=FF7A18&color=fff&size=200&bold=true"
                                                        id="avatarPreview"
                                                        class="rounded-circle border border-4 border-white object-fit-cover shadow-sm"
                                                        alt="Avatar" style="width:140px; height:140px;">
                                                @endif
                                                <label for="profile_photo"
                                                    class="btn-camera shadow-sm position-absolute bottom-0 end-0 rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-camera-fill"></i>
                                                    <input type="file" name="profile_photo" id="profile_photo"
                                                        class="d-none" onchange="previewImage(event)">
                                                </label>
                                            </div>
                                        </div>
                                        <h5 class="fw-black text-dark mb-1">{{ Auth::user()->name }}</h5>
                                        <p class="x-small text-muted fw-bold text-uppercase ls-1 mb-4">
                                            {{ Auth::user()->email }}
                                        </p>
                                        <button type="button"
                                            class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-bold"
                                            onclick="document.getElementById('profile_photo').click()">Change Photo</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Profile Details -->
                            <div class="col-md-8">
                                <form action="{{ url('/profile/update') }}" method="POST" class="row g-4">
                                    @csrf
                                    <div class="col-12">
                                        <h6 class="fw-bold text-muted small text-uppercase ls-1 mb-3">Personal Details</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold text-dark">Full Name</label>
                                                <input type="text" name="name" class="form-control form-control-premium"
                                                    value="{{ Auth::user()->name }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold text-dark">Mobile Number</label>
                                                <input type="text" name="mobile" class="form-control form-control-premium"
                                                    value="{{ Auth::user()->mobile }}" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label small fw-bold text-dark">Email Address
                                                    (Readonly)</label>
                                                <input type="email"
                                                    class="form-control form-control-premium bg-light opacity-75"
                                                    value="{{ Auth::user()->email }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-5">
                                        <h6 class="fw-bold text-muted small text-uppercase ls-1 mb-3">Delivery Address</h6>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label small fw-bold text-dark">Address Line</label>
                                                <textarea name="address" rows="3" class="form-control form-control-premium"
                                                    placeholder="Enter your full address">{{ Auth::user()->address }}</textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold text-dark">City</label>
                                                <input type="text" name="city" class="form-control form-control-premium"
                                                    value="{{ Auth::user()->city }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold text-dark">State</label>
                                                <input type="text" name="state" class="form-control form-control-premium"
                                                    value="{{ Auth::user()->state }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold text-dark">Pincode</label>
                                                <input type="text" name="pincode" class="form-control form-control-premium"
                                                    value="{{ Auth::user()->pincode }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-5">
                                        <button type="submit" class="btn btn-premium px-5 py-3 rounded-pill fw-bold">Save
                                            All Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <hr class="my-5 opacity-5">

                        <!-- Password Management -->
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="p-4 rounded-4 border-0 bg-light-orange shadow-sm">
                                    <h5 class="fw-black mb-3"><i class="bi bi-shield-lock me-2 text-primary"></i> Change
                                        Password</h5>
                                    <p class="text-muted small mb-4">Keep your account secure with a strong password.</p>
                                    <form action="{{ url('/profile/password') }}" method="POST" class="row g-3">
                                        @csrf
                                        <div class="col-12">
                                            <div class="input-group input-group-premium">
                                                <input type="password" name="current_password"
                                                    class="form-control form-control-premium border-end-0"
                                                    placeholder="Current Password" required>
                                                <span
                                                    class="input-group-text bg-white border-start-0 cursor-pointer toggle-password"
                                                    style="border-radius: 0 12px 12px 0; border: 1px solid var(--border); border-left: none;">
                                                    <i class="bi bi-eye text-muted"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="input-group input-group-premium">
                                                <input type="password" name="new_password"
                                                    class="form-control form-control-premium border-end-0"
                                                    placeholder="New Password" required>
                                                <span
                                                    class="input-group-text bg-white border-start-0 cursor-pointer toggle-password"
                                                    style="border-radius: 0 12px 12px 0; border: 1px solid var(--border); border-left: none;">
                                                    <i class="bi bi-eye text-muted"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="input-group input-group-premium">
                                                <input type="password" name="new_password_confirmation"
                                                    class="form-control form-control-premium border-end-0"
                                                    placeholder="Confirm New Password" required>
                                                <span
                                                    class="input-group-text bg-white border-start-0 cursor-pointer toggle-password"
                                                    style="border-radius: 0 12px 12px 0; border: 1px solid var(--border); border-left: none;">
                                                    <i class="bi bi-eye text-muted"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex gap-2">
                                            <button type="reset"
                                                class="btn btn-outline-secondary w-80 py-2 rounded-pill fw-bold">Reset</button>
                                            <button type="submit" class="btn btn-dark w-80 py-2 rounded-pill fw-bold">Update
                                                Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-4 rounded-4 border-0 bg-danger-soft h-100 d-flex flex-column">
                                    <h5 class="fw-black text-danger mb-3"><i class="bi bi-person-x me-2"></i> Delete Account
                                    </h5>
                                    <p class="text-muted small mb-4">Once deleted, your account and all associated data will
                                        be gone forever.</p>
                                    <div class="mt-auto">
                                        <button
                                            class="btn btn-outline-danger w-100 py-3 rounded-pill fw-bold border-2">Request
                                            Deletion</button>
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
        .avatar-wrapper {
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-camera {
            width: 40px;
            height: 40px;
            background: var(--primary);
            color: white;
            border: 3px solid white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-camera:hover {
            transform: scale(1.1);
            background: #e66e15;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .input-group-premium .input-group-text {
            transition: all 0.3s ease;
        }

        .input-group-premium:focus-within .input-group-text {
            border-color: var(--primary) !important;
            background: var(--primary-soft) !important;
        }

        .bg-light-orange {
            background-color: #fff9f5;
            border: 1px solid #ffe8d9 !important;
        }

        .avatar-wrapper img {
            transition: transform 0.5s ease;
        }

        .avatar-wrapper:hover img {
            transform: scale(1.05);
        }
    </style>
@endsection