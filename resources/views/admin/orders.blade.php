@extends('layouts.admin')

@section('title', 'Orders')

@section('admin_content')
    <div class="mb-4">
        <h5 class="fw-bold mb-0">Order Management</h5>
        <p class="text-secondary small">Track and manage customer orders</p>
    </div>

    <div class="glass-card">
        <div class="table-responsive">
            <table class="table admin-datatable table-borderless text-secondary align-middle">
                <thead>
                    <tr class="border-bottom border-white border-opacity-10">
                        <th class="small fw-bold py-3">Order #</th>
                        <th class="small fw-bold py-3">Customer</th>
                        <th class="small fw-bold py-3">Amount</th>
                        <th class="small fw-bold py-3">Payment</th>
                        <th class="small fw-bold py-3">Status</th>
                        <th class="small fw-bold py-3">Date</th>
                        <th class="small fw-bold py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                                <tr class="border-bottom border-white border-opacity-5">
                                    <td class="small fw-bold">#{{ $order->order_number }}</td>
                                    <td>
                                        <div class="small text-white">{{ $order->user->name }}</div>
                                        <div class="x-small text-secondary">{{ $order->user->email }}</div>
                                    </td>
                                    <td class="text-white fw-bold">₹{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} bg-opacity-10 text-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} border border-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} border-opacity-25 px-2 py-1 x-small">
                                            {{ strtoupper($order->payment_status) }}
                                        </span>
                                        <div class="x-small text-secondary mt-1">{{ $order->payment_method }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2 py-1 x-small">
                                            {{ strtoupper($order->order_status) }}
                                        </span>
                                    </td>
                                    <td class="small">{{ $order->created_at ? $order->created_at->format('d M, Y H:i') : 'N/A' }}</td>

                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5">
                                                <i class="bi bi-eye text-primary"></i>
                                            </a>
                                            <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5" title="Generate Invoice">
                                                <i class="bi bi-file-earmark-pdf text-info"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5" data-bs-toggle="modal" data-bs-target="#updateOrderModal{{ $order->id }}">
                                                <i class="bi bi-gear text-secondary"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('modals')
    @foreach($orders as $order)
        <!-- Update Order Modal -->
       <div class="modal fade" id="updateOrderModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-2xl rounded-4" style="background: #ffffff;">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-black text-dark mb-0">Order Control Center #{{ $order->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-4">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="xx-small text-secondary fw-black uppercase tracking-widest mb-2 d-block">Logistics Status</label>
                                <select name="order_status" class="form-select shadow-none border-1 x-small fw-bold py-2 rounded-3 bg-light">
                                    <option value="placed" {{ $order->order_status == 'placed' ? 'selected' : '' }}>Order Placed</option>
                                    <option value="confirmed" {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="dispatched" {{ $order->order_status == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                                    <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="out_for_delivery" {{ $order->order_status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                    <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="returned" {{ $order->order_status == 'returned' ? 'selected' : '' }}>Returned</option>
                                    <option value="return_requested" {{ $order->order_status == 'return_requested' ? 'selected' : '' }}>Return Requested</option>
                                    <option value="return_approved" {{ $order->order_status == 'return_approved' ? 'selected' : '' }}>Return Approved</option>
                                    <option value="return_pickup" {{ $order->order_status == 'return_pickup' ? 'selected' : '' }}>Return Pickup</option>
                                    <option value="refunded" {{ $order->order_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="xx-small text-secondary fw-black uppercase tracking-widest mb-2 d-block">Settlement Status</label>
                                <select name="payment_status" class="form-select shadow-none border-1 x-small fw-bold py-2 rounded-3 bg-light">
                                    <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </div>
                        </div>

                        @if($order->cancel_reason || $order->return_reason)
                            <div class="glass-card mb-4 bg-light border-0 p-3 rounded-4">
                                @if($order->cancel_reason)
                                    <div class="mb-2">
                                        <label class="xx-small text-danger fw-black uppercase mb-1 d-block">Cancellation Intelligence</label>
                                        <p class="x-small text-dark mb-0 italic">"{{ $order->cancel_reason }}"</p>
                                    </div>
                                @endif
                                @if($order->return_reason)
                                    <div>
                                        <label class="xx-small text-warning fw-black uppercase mb-1 d-block">Return Intelligence</label>
                                        <p class="x-small text-dark mb-0 italic">"{{ $order->return_reason }}"</p>
                                        @if($order->return_status)
                                            <span class="badge bg-warning bg-opacity-20 text-warning xx-small mt-1 px-2 py-1 rounded-pill">{{ strtoupper($order->return_status) }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($order->refund_status)
                            <div class="mb-4 d-flex align-items-center justify-content-between p-3 bg-primary bg-opacity-5 rounded-4 border border-primary border-opacity-10">
                                <div>
                                    <label class="xx-small text-primary fw-black uppercase d-block mb-1">Financial Settlement</label>
                                    <span class="x-small fw-bold text-dark">REFUND: {{ strtoupper($order->refund_status) }}</span>
                                </div>
                                <span class="h6 mb-0 fw-black text-primary">₹{{ number_format($order->refund_amount, 2) }}</span>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="xx-small text-secondary fw-black uppercase tracking-widest mb-2 d-block">Global Tracking Update</label>
                            <textarea name="tracking_message" class="form-control shadow-none border-1 x-small py-3 rounded-3 bg-light" placeholder="Explain the current status to the customer..." rows="3" required></textarea>
                            <div class="x-small text-secondary opacity-50 mt-1"><i class="bi bi-info-circle me-1"></i> Customer will see this on their dashboard tracking.</div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <button type="button" class="btn btn-light px-4 py-2 rounded-pill x-small fw-black text-secondary uppercase tracking-widest border" data-bs-dismiss="modal">Discard</button>
                            <button type="submit" class="btn btn-premium px-4 py-2 rounded-pill x-small fw-black uppercase tracking-widest shadow-lg">Push Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endpush









