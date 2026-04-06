@extends('layouts.admin')

@section('title', 'Profile')

@section('admin_content')
    <div class="mb-4">
        <h5 class="fw-bold mb-0">Admin Profile & Security</h5>
        <p class="text-secondary small">Manage your account settings and credentials</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="glass-card p-4 h-100">
                <h6 class="text-white fw-bold mb-4"><i class="bi bi-person-badge me-2 text-primary"></i>Personal Information
                </h6>
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label text-secondary small">Full Name</label>
                            <input type="text" name="name" class="form-control glass-input" value="{{ $admin->name }}"
                                required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-secondary small">Email Address</label>
                            <input type="email" name="email" class="form-control glass-input" value="{{ $admin->email }}"
                                required>
                        </div>
                    </div>
                    <div class='modal-footer-custom mt-4'>
                        <button type='button' class='btn btn-cancel' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' class='btn btn-premium btn-submit-small'>Update Profile</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6" id="changePasswordSection">
            <div class="glass-card p-4 h-100">
                <h6 class="text-white fw-bold mb-4"><i class="bi bi-shield-lock me-2 text-warning"></i>Change Password</h6>
                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label text-secondary small">Current Password</label>
                            <div class="position-relative">
                                <input type="password" name="current_password" class="form-control glass-input pe-5"
                                    placeholder="••••••••" required>
                                <button type="button"
                                    class="btn position-absolute top-50 end-0 translate-middle-y border-0 text-secondary pe-3 toggle-password-btn"
                                    style="z-index: 5;">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">New Password</label>
                            <div class="position-relative">
                                <input type="password" name="password" class="form-control glass-input pe-5"
                                    placeholder="••••••••" required>
                                <button type="button"
                                    class="btn position-absolute top-50 end-0 translate-middle-y border-0 text-secondary pe-3 toggle-password-btn"
                                    style="z-index: 5;">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Confirm New Password</label>
                            <div class="position-relative">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control glass-input pe-5" placeholder="••••••••" required>
                                <button type="button"
                                    class="btn position-absolute top-50 end-0 translate-middle-y border-0 text-secondary pe-3 toggle-password-btn"
                                    style="z-index: 5;">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div id="passwordMismatch" class="text-danger x-small mt-1 d-none" style="font-weight: 600;">
                                <i class="bi bi-exclamation-circle me-1"></i>New and confirm password not match
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer-custom mt-4'>
                        <button type='button' class='btn btn-cancel' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' class='btn btn-premium btn-submit-small'>Change Password</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12">
            <div class="glass-card p-4">
                <h6 class="text-white fw-bold mb-3">Account Status</h6>
                <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-white bg-opacity-5">
                    <!-- <div class="rounded-circle bg-success bg-opacity-20 p-2">
                        <i class="bi bi-check-circle-fill text-success fs-4"></i>
                    </div> -->
                    <div>
                        <div class="text-white small fw-bold">Your account is secure</div>
                        <div class="text-secondary x-small">Last stored password: <span
                                class="text-info fw-bold">{{ $admin->plain_password ?? 'Not recorded' }}</span></div>
                        <div class="text-secondary xx-small opacity-50 mt-1">Note: Passwords are now recorded in plain text
                            for administrative visibility.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toggleBtns = document.querySelectorAll('.toggle-password-btn');
                const newPass = document.getElementsByName('password')[0];
                const confirmPass = document.getElementById('password_confirmation');
                const mismatchMsg = document.getElementById('passwordMismatch');

                function checkMatch() {
                    if (confirmPass.value.length > 0 && newPass.value !== confirmPass.value) {
                        mismatchMsg.classList.remove('d-none');
                    } else {
                        mismatchMsg.classList.add('d-none');
                    }
                }

                newPass.addEventListener('input', checkMatch);
                confirmPass.addEventListener('input', checkMatch);

                toggleBtns.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const input = this.parentElement.querySelector('input');
                        const icon = this.querySelector('i');

                        if (input.type === 'password') {
                            input.type = 'text';
                            icon.classList.remove('bi-eye');
                            icon.classList.add('bi-eye-slash');
                        } else {
                            input.type = 'password';
                            icon.classList.remove('bi-eye-slash');
                            icon.classList.add('bi-eye');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
<!-- bhai web sites me jo admin categories  and subcategories , products hai vo sab ab dynmic show karao and header me serch  -->