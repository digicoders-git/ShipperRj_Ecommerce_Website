@extends('layouts.admin')

@section('title', 'Refunds')

@section('admin_content')
<div class="mb-4">
    <h5 class="fw-bold mb-0">Refund & Cancellation Requests</h5>
    <p class="text-secondary small">Process and manage customer refund requests</p>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table admin-datatable table-borderless text-secondary align-middle">
            <thead>
                <tr class="border-bottom border-white border-opacity-10">
                    <th class="small fw-bold py-3 text-white">Ref ID</th>
                    <th class="small fw-bold py-3 text-white">Order Details</th>
                    <th class="small fw-bold py-3 text-white">Customer Info</th>
                    <th class="small fw-bold py-3 text-white">Request Context</th>
                    <th class="small fw-bold py-3 text-white">Refund Value</th>
                    <th class="small fw-bold py-3 text-white">Payment Mode</th>
                    <th class="small fw-bold py-3 text-white">Settlement Status</th>
                    <th class="small fw-bold py-3 text-end text-white">Control</th>
                </tr>
            </thead>
            <tbody>
                @foreach($refunds as $refund)
                <tr class="border-bottom border-white border-opacity-5">
                    <td class="small opacity-50">#{{ $refund->id }}</td>
                    <td>
                        <div class="small text-white fw-bold">ORD-{{ $refund->order->order_number ?? 'N/A' }}</div>
                        <div class="xx-small text-secondary fw-black uppercase opacity-50">{{ $refund->created_at->format('d M, Y H:i') }}</div>
                    </td>
                    <td>
                        <div class="small text-white">{{ $refund->user->name ?? 'Deleted User' }}</div>
                        <div class="x-small text-secondary">{{ $refund->user->mobile ?? 'N/A' }}</div>
                    </td>
                    <td>
                        <div class="alert alert-light bg-opacity-5 border-white border-opacity-10 py-1 px-2 rounded-3 mb-0" style="max-width: 200px;">
                            <div class="xx-small fw-black uppercase opacity-50 mb-1">{{ str_contains($refund->reason, 'Cancellation') ? 'Cancellation Request' : 'Return Request' }}</div>
                            <div class="text-white x-small text-truncate" title="{{ $refund->reason }}">{{ Str::limit($refund->reason, 50) }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-black text-warning">₹{{ number_format($refund->amount, 2) }}</div>
                    </td>
                    <td>
                        <span class="badge bg-light bg-opacity-10 text-dark xx-small border border-white border-opacity-10 px-2 py-1">
                            {{ strtoupper($refund->order->payment_method ?? 'N/A') }}
                        </span>
                    </td>
                    <td>
                        <span class="badge border border-white border-opacity-10 px-2 py-1 x-small fw-bold badge-glass-premium text-{{ $refund->status == 'pending' ? 'warning' : ($refund->status == 'approved' ? 'success' : 'danger') }}">
                            {{ strtoupper($refund->status) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5 rounded-pill px-3 shadow-sm" 
                                data-bs-toggle="modal" data-bs-target="#processRefundModal{{ $refund->id }}">
                            <i class="bi bi-shield-check text-primary me-1"></i> <span class="xx-small fw-black uppercase">Review</span>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('modals')
    @foreach($refunds as $refund)
    <!-- Process Refund Modal -->
    <div class="modal fade" id="processRefundModal{{ $refund->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-2xl rounded-4 overflow-hidden" style="background: #ffffff;">
                 <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-black text-dark mb-0 letter-spacing-n1">Financial Settlement #{{ $refund->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-4">
                    <div class="alert {{ str_contains($refund->reason, 'Cancellation') ? 'alert-danger-soft text-danger' : 'alert-warning-soft text-warning' }} border-0 rounded-4 p-3 mb-4 d-flex align-items-center gap-3">
                        <i class="bi {{ str_contains($refund->reason, 'Cancellation') ? 'bi-x-circle-fill' : 'bi-arrow-counterclockwise' }} fs-4"></i>
                        <div>
                            <div class="xx-small fw-black uppercase tracking-widest opacity-75">Request Type</div>
                            <div class="small fw-bold">{{ str_contains($refund->reason, 'Cancellation') ? 'ORDER CANCELLATION' : 'PRODUCT RETURN' }}</div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-4 border">
                                <div class="xx-small text-secondary fw-black uppercase mb-1">Total Impact</div>
                                <div class="h5 fw-black mb-0 text-dark">₹{{ number_format($refund->order->total_amount ?? 0, 2) }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-4 border">
                                <div class="xx-small text-secondary fw-black uppercase mb-1">Refund Amount</div>
                                <div class="h5 fw-black mb-0 text-primary">₹{{ number_format($refund->amount, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="xx-small text-secondary fw-black uppercase ps-1 mb-2">Customer Justification</label>
                        <div class="p-3 rounded-4 bg-light small text-dark border-start border-4 border-primary">
                            "{{ $refund->reason }}"
                        </div>
                    </div>

                    <form action="{{ route('admin.refunds.update', $refund->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="xx-small text-secondary fw-black uppercase ps-1 mb-2">Executive Decision</label>
                            <select name="status" class="form-select shadow-none border-1 x-small fw-bold py-2 rounded-3 bg-light" required>
                                <option value="pending" {{ $refund->status == 'pending' ? 'selected' : '' }}>Decision Pending</option>
                                <option value="approved" {{ $refund->status == 'approved' ? 'selected' : '' }}>Approve & Credit Wallet</option>
                                <option value="rejected" {{ $refund->status == 'rejected' ? 'selected' : '' }}>Reject Request</option>
                            </select>
                            <div class="xx-small text-primary mt-2 opacity-75"><i class="bi bi-info-circle me-1"></i> Approving will immediately credit total refund amount to customer's global wallet.</div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <button type="button" class="btn btn-light px-4 py-2 rounded-pill x-small fw-black border" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-premium px-4 py-2 rounded-pill x-small fw-black uppercase tracking-widest shadow-lg border-0 text-white">Push Decision</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@push('styles')
<style>
    .badge-glass-premium {
        background: rgba(255, 255, 255, 0.15) !important;
        backdrop-filter: blur(10px) saturate(180%);
        -webkit-backdrop-filter: blur(10px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        text-shadow: 0 1px 1px rgba(0,0,0,0.05); /* Soften for readability */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 80px;
    }
    
    /* Ensure the colors are deep enough for white glass */
    .badge-glass-premium.text-warning { color: #f2701a !important; }
    .badge-glass-premium.text-success { color: #198754 !important; }
    .badge-glass-premium.text-danger { color: #dc3545 !important; }
</style>
@endpush
