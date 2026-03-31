@extends('layouts.admin')

@section('admin_content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-black mb-0">Edit Sub Admin: <span class="text-primary">{{ $subadmin->name }}</span></h4>
        <a href="{{ route('admin.subadmins.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">
            <i class="bi bi-arrow-left me-2"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.subadmins.update', $subadmin) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <!-- Account Info -->
            <div class="col-lg-12">
                <div class="dashboard-card p-4">
                    <h5 class="fw-black mb-4"><i class="bi bi-person-circle me-2 text-primary"></i> Account Details</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control rounded-pill px-4 py-2" required value="{{ old('name', $subadmin->name) }}">
                            @error('name') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" class="form-control rounded-pill px-4 py-2" required value="{{ old('username', $subadmin->username) }}">
                            @error('username') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-pill px-4 py-2" required value="{{ old('email', $subadmin->email) }}">
                            @error('email') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control rounded-pill px-4 py-2" value="{{ old('phone', $subadmin->mobile) }}">
                            @error('phone') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">New Password (Ignore to keep existing)</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control rounded-start-pill ps-4 py-2 border-end-0" placeholder="Minimum 6 characters">
                                <span class="input-group-text bg-white border-start-0 rounded-end-pill pe-3 position-relative" style="cursor: pointer;" onclick="togglePassword('password')">
                                    <i class="bi bi-eye-slash-fill text-muted" id="password-toggle-icon"></i>
                                </span>
                            </div>
                            @error('password') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control rounded-start-pill ps-4 py-2 border-end-0" placeholder="Repeat new password">
                                <span class="input-group-text bg-white border-start-0 rounded-end-pill pe-3 position-relative" style="cursor: pointer;" onclick="togglePassword('password_confirmation')">
                                    <i class="bi bi-eye-slash-fill text-muted" id="password_confirmation-toggle-icon"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Account Status</label>
                            <select name="status" class="form-select rounded-pill px-4 py-2">
                                <option value="1" {{ $subadmin->status ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$subadmin->status ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions Selection -->
            <div class="col-lg-12">
                <div class="dashboard-card p-4">
                    <h5 class="fw-black mb-4"><i class="bi bi-shield-lock me-2 text-primary"></i> Update Permissions</h5>
                    <div class="row g-4">
                        @php $currentPermissions = $subadmin->permissions ?? []; @endphp
                        @foreach($permissions as $module => $actions)
                        <div class="col-md-6 col-lg-4">
                            <div class="p-3 border rounded-4 bg-light bg-opacity-50">
                                <h6 class="fw-black text-dark border-bottom pb-2 mb-3 text-uppercase small ls-1">
                                    <i class="bi bi-grid-fill me-2 opacity-50"></i> {{ ucfirst(str_replace('_', ' ', $module)) }}
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($actions as $action)
                                    @php $perm = $module . '_' . $action; @endphp
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm }}" id="{{ $perm }}" {{ in_array($perm, $currentPermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label small fw-bold text-muted" for="{{ $perm }}">
                                            {{ ucfirst($action) }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-12 text-end mt-4">
                <button type="submit" class="btn btn-premium px-5 py-3 rounded-pill fw-black">
                    Update Sub Admin <i class="bi bi-check-lg ms-2"></i>
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const toggleIcon = document.getElementById(fieldId + '-toggle-icon');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
            toggleIcon.classList.add('text-primary');
            toggleIcon.classList.remove('text-muted');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            toggleIcon.classList.remove('text-primary');
            toggleIcon.classList.add('text-muted');
        }
    }
</script>
@endpush
@endsection
