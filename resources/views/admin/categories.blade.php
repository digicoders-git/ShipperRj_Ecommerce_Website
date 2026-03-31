@extends('layouts.admin')

@section('title', 'Categories')

@section('admin_content')
@php
    $isAdmin = auth('admin')->check();
    $subAdmin = auth('subadmin')->user();
@endphp
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Manage Categories</h5>
    @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('categories_add')))
    <button class="btn btn-add btn-sm px-4" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="bi bi-plus-lg me-2"></i> Add New Category
    </button>
    @endif
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table admin-datatable table-borderless text-secondary align-middle">
            <thead>
                <tr class="border-bottom border-white border-opacity-10">
                    <th class="small fw-bold py-3">ID</th>
                    <th class="small fw-bold py-3">Image</th>
                    <th class="small fw-bold py-3">Category Name</th>
                    <th class="small fw-bold py-3">Description</th>
                    <th class="small fw-bold py-3">Status</th>
                    <th class="small fw-bold py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr class="border-bottom border-white border-opacity-5">
                    <td class="small">#{{ $loop->iteration }}</td>
                    <td>
                        @if($category->image)
                            <img src="{{ asset($category->image) }}" class="rounded-3 shadow-sm border border-white border-opacity-10" style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary bg-opacity-20 d-flex align-items-center justify-content-center text-white small fw-bold" style="width: 40px; height: 40px;">{{ substr($category->name, 0, 1) }}</div>
                        @endif
                    </td>
                    <td class="fw-bold">{{ $category->name }}</td>
                    <td class="small text-secondary">{{ Str::limit($category->description, 50) }}</td>
                    <td>
                        @if($category->status == 1)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2">Active</span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('categories_edit')))
                            <button class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                                <i class="bi bi-pencil-square text-primary"></i>
                            </button>
                            @endif

                            @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('categories_delete')))
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5 btn-delete">
                                    <i class="bi bi-trash text-danger"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@foreach($categories as $category)
<!-- Edit Modal -->
<div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card border-0 p-3" >
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Category Name</label>
                            <input type="text" name="name" class="form-control glass-input" value="{{ $category->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Status</label>
                            <select name="status" class="form-select glass-input">
                                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-secondary small">Description</label>
                            <textarea name="description" class="form-control glass-input" rows="2">{{ $category->description }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-secondary small">Category Image</label>
                            <input type="file" name="image" class="form-control glass-input">
                            @if($category->image)
                                <div class="mt-2 text-center border border-white border-opacity-10 rounded-4 p-2 bg-white bg-opacity-5 d-inline-block">
                                    <p class="x-small text-secondary mb-1">Current Image</p>
                                    <img src="{{ asset($category->image) }}" class="rounded-3 shadow-sm" style="width: 70px; height: 70px; object-fit: cover;">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class='modal-footer-custom'>
                        <button type='button' class='btn btn-cancel' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' class='btn btn-premium btn-submit-small'>Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card border-0 p-3" >
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Category Name</label>
                            <input type="text" name="name" class="form-control glass-input" placeholder="Enter category name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Status</label>
                            <select name="status" class="form-select glass-input">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-secondary small">Description</label>
                            <textarea name="description" class="form-control glass-input" placeholder="Enter category description" rows="2"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-secondary small">Category Image</label>
                            <input type="file" name="image" class="form-control glass-input">
                        </div>
                    </div>
                    <div class='modal-footer-custom'>
                        <button type='button' class='btn btn-cancel' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' class='btn btn-premium btn-submit-small'>Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <style>
.modal-content.glass-card::before {
    content: "";
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, var(--accent-color), transparent, var(--accent-color));
    z-index: -1;
    border-radius: 22px;
    opacity: 0.3;
}
</style> -->
@endsection









