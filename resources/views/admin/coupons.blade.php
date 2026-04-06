@extends('layouts.admin')

@section('title', 'Coupons')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Manage Coupons</h5>
    <button class="btn btn-add btn-sm px-4" data-bs-toggle="modal" data-bs-target="#addCouponModal">
        <i class="bi bi-plus-lg me-2"></i> Add New Coupon
    </button>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table admin-datatable table-borderless text-secondary align-middle">
            <thead>
                <tr class="border-bottom border-white border-opacity-10">
                     <th class="serial-col">S.No</th>
                    <th class="small fw-bold py-3">Code</th>
                    <th class="small fw-bold py-3">Discount</th>
                    <th class="small fw-bold py-3">Min Spend</th>
                    <th class="small fw-bold py-3">Expiry</th>
                    <th class="small fw-bold py-3">Status</th>
                    <th class="small fw-bold py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coupons as $coupon)
                <tr class="border-bottom border-white border-opacity-5">
                    <td class="serial-cell  text-secondary">#{{ $loop->iteration }}</td>
                    <td class="text-white fw-bold small">
                        <span class="badge bg-primary bg-opacity-10 text-light border border-primary border-opacity-25 px-2 py-1">
                            {{ $coupon->code }}
                        </span>
                    </td>
                    <td class="text-white">₹{{ number_format($coupon->discount_amount) }}</td>
                    <td class="text-white">₹{{ number_format($coupon->min_spend) }}</td>
                    <td class="small">
                        <div class="text-white">{{ date('d M, Y', strtotime($coupon->expiry_date)) }}</div>
                    </td>
                    <td>
                        @if($coupon->status == 1 && $coupon->expiry_date >= date('Y-m-d'))
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">Active</span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">Expired/Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5" data-bs-toggle="modal" data-bs-target="#editCouponModal{{ $coupon->id }}">
                                <i class="bi bi-pencil-square text-primary"></i>
                            </button>
                            <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="delete-form">
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

@foreach($coupons as $coupon)
<!-- Edit Coupon Modal -->
<div class="modal fade" id="editCouponModal{{ $coupon->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card border-0 p-3" >
             <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Coupon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-12 mb-3">
                            <label class="form-label text-secondary small">Coupon Code</label>
                            <input type="text" name="code" class="form-control glass-input" value="{{ $coupon->code }}" required style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Discount Amount (₹)</label>
                            <input type="number" name="discount_amount" class="form-control glass-input" value="{{ $coupon->discount_amount }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Min Spend (₹)</label>
                            <input type="number" name="min_spend" class="form-control glass-input" value="{{ $coupon->min_spend }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control glass-input" value="{{ $coupon->expiry_date }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Status</label>
                            <select name="status" class="form-select glass-input">
                                <option value="1" {{ $coupon->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $coupon->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class='modal-footer-custom'>
                        <button type='button' class='btn btn-cancel' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' class='btn btn-premium btn-submit-small'>Update Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Add Coupon Modal -->
<div class="modal fade" id="addCouponModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card border-0 p-3" >
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add New Coupon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form action="{{ route('admin.coupons.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12 mb-3">
                            <label class="form-label text-secondary small">Coupon Code</label>
                            <input type="text" name="code" class="form-control glass-input" placeholder="e.g. SAVE200" required style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Discount Amount (₹)</label>
                            <input type="number" name="discount_amount" class="form-control glass-input" placeholder="200" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Min Spend (₹)</label>
                            <input type="number" name="min_spend" class="form-control glass-input" placeholder="5000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control glass-input" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Status</label>
                            <select name="status" class="form-select glass-input">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class='modal-footer-custom'>
                        <button type='button' class='btn btn-cancel' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' class='btn btn-premium btn-submit-small'>Save Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
