@extends('layouts.admin')

@section('title', 'Offers')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Manage Product Offers</h5>
    <button class="btn btn-add btn-sm px-4" data-bs-toggle="modal" data-bs-target="#addOfferModal">
        <i class="bi bi-plus-lg me-2"></i> Add New Offer
    </button>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table admin-datatable table-borderless text-secondary align-middle">
            <thead>
                <tr class="border-bottom border-white border-opacity-10">
                    <th class="small fw-bold py-3">ID</th>
                    <th class="small fw-bold py-3">Product</th>
                    <th class="small fw-bold py-3">Discount (%)</th>
                    <th class="small fw-bold py-3">Duration</th>
                    <th class="small fw-bold py-3">Status</th>
                    <th class="small fw-bold py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($offers as $offer)
                <tr class="border-bottom border-white border-opacity-5">
                    <td class="small">#{{ $loop->iteration }}</td>
                    <td class="text-white fw-bold small">{{ $offer->product->name }}</td>
                    <td>
                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1">
                            {{ $offer->discount_percentage }}% OFF
                        </span>
                    </td>
                    <td class="small">
                        <div class="text-white">{{ date('d M, Y', strtotime($offer->start_date)) }}</div>
                        <div class="text-secondary x-small">to {{ date('d M, Y', strtotime($offer->end_date)) }}</div>
                    </td>
                    <td>
                        @php
                            $today = date('Y-m-d');
                            $isActive = ($offer->status == 1 && $today >= $offer->start_date && $today <= $offer->end_date);
                        @endphp
                        @if($isActive)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">Running</span>
                        @elseif($today < $offer->start_date)
                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2 py-1">Upcoming</span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">Expired/Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5" data-bs-toggle="modal" data-bs-target="#editOfferModal{{ $offer->id }}">
                                <i class="bi bi-pencil-square text-primary"></i>
                            </button>
                            <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5 btn-delete">
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

@foreach($offers as $offer)
<!-- Edit Offer Modal -->
<div class="modal fade" id="editOfferModal{{ $offer->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card border-0 p-3" >
             <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form action="{{ route('admin.offers.update', $offer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Product</label>
                            <select name="product_id" class="form-select glass-input" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ $offer->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Discount Percentage (%)</label>
                            <input type="number" name="discount_percentage" class="form-control glass-input" value="{{ $offer->discount_percentage }}" required min="1" max="100">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Start Date</label>
                            <input type="date" name="start_date" class="form-control glass-input" value="{{ $offer->start_date }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">End Date</label>
                            <input type="date" name="end_date" class="form-control glass-input" value="{{ $offer->end_date }}" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-secondary small">Status</label>
                            <select name="status" class="form-select glass-input">
                                <option value="1" {{ $offer->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $offer->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class='modal-footer-custom'>
                        <button type='button' class='btn btn-cancel' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' class='btn btn-premium btn-submit-small'>Update Offer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Add Offer Modal -->
<div class="modal fade" id="addOfferModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card border-0 p-3" >
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add New Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form action="{{ route('admin.offers.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Select Product</label>
                            <select name="product_id" class="form-select glass-input" required>
                                <option value="">Choose product...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Discount Percentage (%)</label>
                            <input type="number" name="discount_percentage" class="form-control glass-input" placeholder="e.g. 10" required min="1" max="100">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Start Date</label>
                            <input type="date" name="start_date" class="form-control glass-input" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">End Date</label>
                            <input type="date" name="end_date" class="form-control glass-input" required>
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
                        <button type='submit' class='btn btn-premium btn-submit-small'>Save Offer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
