@extends('layouts.admin')

@section('title', 'Order Tracking')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Delivery & Logistics Tracking</h5>
        <p class="text-secondary small mb-0">Monitor shipment progress and update customers</p>
    </div>
    <button class="btn btn-add btn-sm px-4" data-bs-toggle="modal" data-bs-target="#addTrackingModal">
        <i class="bi bi-plus-lg me-2"></i> Add Tracking Update
    </button>
</div>

<div class="glass-card mb-5">
    <div class="table-responsive">
        <table class="table admin-datatable table-borderless text-secondary align-middle">
            <thead>
                <tr class="border-bottom border-white border-opacity-10">
                    <th class="small fw-bold py-3">Order #</th>
                    <th class="small fw-bold py-3">Message</th>
                    <th class="small fw-bold py-3">Update Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trackings as $tracking)
                <tr class="border-bottom border-white border-opacity-5">
                    <td class="small fw-bold text-white">#{{ $loop->iteration }}</td>
                    <td class="small text-white">{{ $tracking->message }}</td>
                    <td class="small">{{ $tracking->created_at ? $tracking->created_at->format('d M, Y H:i') : 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Tracking Modal -->
<div class="modal fade" id="addTrackingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card border-0 p-3">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">New Tracking Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form action="{{ route('admin.order-tracking.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Order ID</label>
                            <select name="order_id" class="form-select glass-input" required>
                                <option value="">Select Order...</option>
                                @foreach($orders as $order)
                                    <option value="{{ $order->id }}">#{{ $order->order_number }} - {{ $order->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-secondary small">Tracking Message</label>
                            <textarea name="message" class="form-control glass-input" placeholder="e.g. Dispatched from Hub" required rows="2"></textarea>
                            <input type="hidden" name="status" value="update">
                        </div>
                    </div>
                    <div class='modal-footer-custom'>
                        <button type='button' class='btn btn-cancel' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' class='btn btn-premium btn-submit-small'>Publish Tracking Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
