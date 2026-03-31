@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="dashboard-card p-4 p-lg-5 text-center shadow-lg border-0 rounded-5">
                <div class="mb-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                        <i class="bi bi-shield-lock-fill text-primary fs-1"></i>
                    </div>
                    <h3 class="fw-black mb-1">Sub Admin Login</h3>
                    <p class="text-muted small fw-bold">Enter your credentials to manage assigned modules.</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger rounded-pill py-2 px-4 small fw-bold border-0">{{ session('error') }}</div>
                @endif

                <form action="{{ route('admin.subadmin.login.submit') }}" method="POST" class="text-start">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email or Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 rounded-start-pill ps-3"><i class="bi bi-person"></i></span>
                            <input type="text" name="login" class="form-control bg-light border-0 rounded-end-pill py-3 px-3" placeholder="john@example.com" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 rounded-start-pill ps-3"><i class="bi bi-key"></i></span>
                            <input type="password" name="password" class="form-control bg-light border-0 rounded-end-pill py-3 px-3" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-premium w-100 py-3 rounded-pill fw-black uppercase ls-1">
                        Secure Access <i class="bi bi-unlock ms-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
