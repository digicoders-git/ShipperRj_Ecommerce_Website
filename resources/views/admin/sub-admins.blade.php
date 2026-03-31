@extends('layouts.admin')

@section('title', 'Sub Admins')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Sub-Admin Management</h5>
        <p class="text-secondary small mb-0">Manage administrative team and permissions</p>
    </div>
    <button class="btn btn-add btn-sm px-4" data-bs-toggle="modal" data-bs-target="#addSubAdminModal">
        <i class="bi bi-person-plus me-2"></i> Add Sub-Admin
    </button>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table admin-datatable table-borderless text-secondary align-middle">
            <thead>
                <tr class="border-bottom border-white border-opacity-10">
                    <th class="small fw-bold py-3">ID</th>
                    <th class="small fw-bold py-3">Name</th>
                    <th class="small fw-bold py-3">Email</th>
                    <th class="small fw-bold py-3">Role/Perms</th>
                    <th class="small fw-bold py-3">Status</th>
                    <th class="small fw-bold py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr class="border-bottom border-white border-opacity-5">
                    <td class="small">#{{ $admin->id }}</td>
                    <td class="small text-white fw-bold">{{ $admin->name }}</td>
                    <td class="small">{{ $admin->email }}</td>
                    <td>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 x-small">SUB-ADMIN</span>
                    </td>
                    <td>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 x-small">ACTIVE</span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                             <form action="{{ route('admin.sub-admins.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5">
                                    <i class="bi bi-trash text-danger"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Sub-Admin Modal -->
<div class="modal fade" id="addSubAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card border-0 p-3" >
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add New Sub-Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form action="{{ route('admin.sub-admins.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Full Name</label>
                            <input type="text" name="name" class="form-control glass-input" placeholder="Enter name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Email Address</label>
                            <input type="email" name="email" class="form-control glass-input" placeholder="admin@example.com" required>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label text-secondary small">Password</label>
                            <input type="password" name="password" class="form-control glass-input" placeholder="••••••••" required>
                        </div>
                    </div>
                    <div class='modal-footer-custom'>
                        <button type='button' class='btn btn-cancel' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' class='btn btn-premium btn-submit-small'>Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
