@extends('layouts.admin')

@section('title', 'Sub Categories')

@section('admin_content')
@php
    $isAdmin = auth('admin')->check();
    $subAdmin = auth('subadmin')->user();
@endphp
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Manage Sub Categories</h5>
    @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('sub_categories_add')))
    <button class="btn btn-add btn-sm px-4" data-bs-toggle="modal" data-bs-target="#addSubCategoryModal">
        <i class="bi bi-plus-lg me-2"></i> Add New Sub Category
    </button>
    @endif
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table admin-datatable table-borderless text-secondary align-middle">
            <thead>
                <tr class="border-bottom border-white border-opacity-10">
                    <th class="small fw-bold py-3">ID</th>
                    <th class="small fw-bold py-3">Category</th>
                    <th class="small fw-bold py-3">Sub Category</th>
                    <th class="small fw-bold py-3">Description</th>
                    <th class="small fw-bold py-3">Status</th>
                    <th class="small fw-bold py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subCategories as $subCategory)
                <tr class="border-bottom border-white border-opacity-5">
                    <td class="small">#{{ $loop->iteration }}</td>
                    <td class="text-white small">{{ $subCategory->category->name }}</td>
                    <td class="fw-bold">{{ $subCategory->name }}</td>
                    <td class="small text-secondary">{{ Str::limit($subCategory->description, 50) }}</td>
                    <td>
                        @if($subCategory->status == 1)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2">Active</span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('sub_categories_edit')))
                            <button class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5" data-bs-toggle="modal" data-bs-target="#editSubCategoryModal{{ $subCategory->id }}">
                                <i class="bi bi-pencil-square text-primary"></i>
                            </button>
                            @endif

                            @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('sub_categories_delete')))
                            <form action="{{ route('admin.sub-categories.destroy', $subCategory->id) }}" method="POST" class="delete-form">
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

@foreach($subCategories as $subCategory)
<!-- Edit Modal -->
<div class="modal fade" id="editSubCategoryModal{{ $subCategory->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card border-0 p-3" >
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Sub Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form action="{{ route('admin.sub-categories.update', $subCategory->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Main Category</label>
                            <select name="category_id" class="form-select glass-input" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $subCategory->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Sub Category Name</label>
                            <input type="text" name="name" class="form-control glass-input" value="{{ $subCategory->name }}" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-secondary small">Description</label>
                            <textarea name="description" class="form-control glass-input" rows="2">{{ $subCategory->description }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-secondary small">Status</label>
                            <select name="status" class="form-select glass-input">
                                <option value="1" {{ $subCategory->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $subCategory->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class='modal-footer-custom'>
                        <button type='button' class='btn btn-cancel' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' class='btn btn-premium btn-submit-small'>Update Sub Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Add Sub Category Modal -->
<div class="modal fade" id="addSubCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card border-0 p-3" >
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add New Sub Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form action="{{ route('admin.sub-categories.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Main Category</label>
                            <select name="category_id" class="form-select glass-input" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Sub Category Name</label>
                            <input type="text" name="name" class="form-control glass-input" placeholder="Enter sub category name" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-secondary small">Description</label>
                            <textarea name="description" class="form-control glass-input" placeholder="Enter sub category description" rows="2"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-secondary small">Status</label>
                            <select name="status" class="form-select glass-input">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class='modal-footer-custom'>
                        <button type='button' class='btn btn-cancel' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' class='btn btn-premium btn-submit-small'>Save Sub Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
