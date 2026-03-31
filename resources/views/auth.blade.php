@extends('layouts.app')

@section('content')
    <!-- Auth Layout -->
    <section class="py-5"
        style="background: linear-gradient(135deg, #f8f9ff 0%, #f0f2f8 100%); min-height: 80vh; display: flex; align-items: center;">
        <div class="container container-sm py-5" style="max-width: 500px;">
            <div class="bg-white rounded-5 shadow-premium border p-4 p-md-5 fade-in-up">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/images/logo1.png') }}" alt="Logo" height="60" class="mb-4">
                    <h3 class="fw-black mb-1">Welcome</h3>
                    <p class="text-secondary small">Access your premium tricolor account profile</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-4 small">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger border-0 rounded-4 small">{{ session('error') }}</div>
                @endif

                <ul class="nav nav-pills nav-justified mb-4 border rounded-pill p-1 bg-light" id="authTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill fw-bold" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-selected="true">Login</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill fw-bold" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-selected="false">Register</button>
                    </li>
                </ul>

                <div class="tab-content" id="authTabContent">
                    <!-- Login Tab -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <form action="{{ route('login.post') }}" method="POST" class="d-flex flex-column gap-3">
                            @csrf
                            @if(session('error'))
                                <div class="alert alert-danger px-4 py-3 rounded-4 border-0 small m-0 mb-2">
                                    {{ session('error') }}
                                </div>
                            @elseif($errors->any())
                                <div class="alert alert-danger px-4 py-3 rounded-4 border-0 small m-0 mb-2">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="small fw-bold mb-2">Email or Mobile Number</label>
                                <div class="position-relative">
                                    <input type="text" name="email" class="form-control px-4 py-3 bg-light border-0 rounded-4 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter Email or Mobile" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label class="small fw-bold mb-2">Password</label>
                                    <a href="#" class="small text-secondary text-decoration-none">Forgot?</a>
                                </div>
                                <div class="position-relative">
                                    <input type="password" id="loginPassword" name="password" class="form-control px-4 py-3 bg-light border-0 rounded-4" placeholder="Your secure password" required>
                                    <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password" data-target="#loginPassword">
                                        <i class="bi bi-eye text-secondary"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-check small my-2">
                                <input class="form-check-input" type="checkbox" name="remember" id="rem">
                                <label class="form-check-label text-secondary" for="rem">Keep me logged in</label>
                            </div>

                            <button type="submit" class="btn btn-premium w-100 py-3 rounded-pill shadow-premium fw-bold mt-2">Login to Account</button>
                        </form>
                    </div>

                    <!-- Register Tab -->
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <form action="{{ route('register') }}" method="POST" class="d-flex flex-column gap-3">
                            @csrf
                            @if($errors->has('error'))
                                <div class="alert alert-danger px-4 py-3 rounded-4 border-0 small m-0 mb-2">
                                    {{ $errors->first('error') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="position-relative">
                                    <input type="text" name="name" class="form-control px-4 py-3 bg-light border-0 rounded-4 @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Full Name" required>
                                </div>
                                @error('name')<span class="text-danger small">{{ $message }}</span>@enderror
                            </div>
                            
                            <div class="form-group">
                                <div class="position-relative">
                                    <input type="email" name="email" class="form-control px-4 py-3 bg-light border-0 rounded-4 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email Address (Optional)">
                                </div>
                                @error('email')<span class="text-danger small">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <div class="position-relative">
                                    <input type="text" name="mobile" class="form-control px-4 py-3 bg-light border-0 rounded-4 @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" placeholder="Mobile Number" required>
                                </div>
                                @error('mobile')<span class="text-danger small">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <div class="position-relative">
                                    <input type="password" id="regPassword" name="password" class="form-control px-4 py-3 bg-light border-0 rounded-4 @error('password') is-invalid @enderror" placeholder="Create Password" required>
                                    <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password" data-target="#regPassword">
                                        <i class="bi bi-eye text-secondary"></i>
                                    </span>
                                </div>
                                @error('password')<span class="text-danger small">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <div class="position-relative">
                                    <input type="password" id="regConfirmPassword" name="password_confirmation" class="form-control px-4 py-3 bg-light border-0 rounded-4" placeholder="Confirm Password" required>
                                    <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password" data-target="#regConfirmPassword">
                                        <i class="bi bi-eye text-secondary"></i>
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill shadow-sm fw-bold mt-2">Create Account</button>
                        </form>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-top d-flex justify-content-center gap-3">
                    <a href="{{ route('auth.google') }}" class="action-btn px-4 w-auto h-auto py-3 rounded-pill bg-light border-0 fs-6 shadow-sm text-dark small text-decoration-none fw-bold transition-all hover-bg-light border">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" width="20" class="me-2"> 
                        Continue with Google
                    </a>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if($errors->hasAny(['name', 'mobile', 'password']))
                const registerTab = new bootstrap.Tab(document.querySelector('#register-tab'));
                registerTab.show();
            @endif

            // Toggle Password Visibility
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const input = document.querySelector(this.getAttribute('data-target'));
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
        });
    </script>
@endsection