@extends('layouts.admin')

@section('title', 'Wallet Bonus Offers')

@section('admin_content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h5 class="fw-black mb-0 text-dark uppercase tracking-tighter">Wallet Recharge Incentives</h5>
        <p class="text-secondary small fw-bold mb-0 opacity-50 uppercase tracking-widest x-small">Set rules for bonus balance on wallet top-ups.</p>
    </div>
    <button class="btn btn-primary bg-gradient-primary px-4 py-2 rounded-pill fw-black uppercase small tracking-widest shadow-premium border-0" data-bs-toggle="modal" data-bs-target="#addOfferModal">
        <i class="bi bi-plus-lg me-2"></i> Create Incentive
    </button>
</div>

<div class="glass-card shadow-lg border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table admin-datatable table-hover align-middle mb-0">
            <thead class="bg-white bg-opacity-5">
                <tr class="border-bottom border-white border-opacity-10 text-nowrap">
                    <th class="x-small fw-black py-3 px-4 tracking-widest text-uppercase">RULE ID</th>
                    <th class="x-small fw-black py-3 tracking-widest text-uppercase text-center">MIN TOP-UP</th>
                    <th class="x-small fw-black py-3 tracking-widest text-uppercase text-center">BONUS REWARD</th>
                    <th class="x-small fw-black py-3 tracking-widest text-uppercase text-center">STATUS</th>
                    <th class="x-small fw-black py-3 px-4 text-end tracking-widest text-uppercase">INTEL</th>
                </tr>
            </thead>
            <tbody class="text-white text-md-start">
                @foreach($offers as $offer)
                <tr class="border-bottom border-white border-opacity-5 transition-all">
                    <td class="small fw-black py-4 px-4 text-dark opacity-75">#WBT-{{ str_pad($offer->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border border-secondary border-opacity-10 px-3 py-2 rounded-pill small fw-black tracking-tighter">
                            ₹{{ number_format($offer->min_amount, 2) }} +
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                             <span class="pulse-dot bg-success" style="width: 6px; height: 6px;"></span>
                             <h6 class="text-success fw-black mb-0 letter-spacing-n1">₹{{ number_format($offer->bonus_amount, 2) }}</h6>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-{{ $offer->status ? 'success' : 'danger' }} bg-opacity-10 text-{{ $offer->status ? 'success' : 'danger' }} border border-{{ $offer->status ? 'success' : 'danger' }} border-opacity-25 px-3 py-1 rounded-pill xx-small fw-black uppercase tracking-widest">
                            {{ $offer->status ? 'ACTIVE' : 'SUSPENDED' }}
                        </span>
                    </td>
                    <td class="text-end px-4">
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-sm btn-icon-premium" data-bs-toggle="modal" data-bs-target="#editOfferModal{{ $offer->id }}">
                                <i class="bi bi-pencil-square text-primary"></i>
                            </button>
                            <form action="{{ route('admin.wallet-offers.destroy', $offer->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon-premium btn-delete">
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

@endsection

@push('modals')
<!-- Add Offer Modal -->
<div class="modal fade" id="addOfferModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card border-0 p-3">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add New Incentive</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form action="{{ route('admin.wallet-offers.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Threshold Amount (Min Add)</label>
                        <input type="number" name="min_amount" class="form-control glass-input" placeholder="e.g. 500" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Reward Bonus Amount</label>
                        <input type="number" name="bonus_amount" class="form-control glass-input" placeholder="e.g. 50" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-secondary small">Status</label>
                        <select name="status" class="form-select glass-input">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class='modal-footer-custom'>
                        <button type='button' class='btn btn-cancel' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' class='btn btn-premium btn-submit-small'>Save Incentive</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach($offers as $offer)
<!-- Edit Offer Modal -->
<div class="modal fade" id="editOfferModal{{ $offer->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card border-0 p-3">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Rule #{{ $offer->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form action="{{ route('admin.wallet-offers.update', $offer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Threshold Amount (Min Add)</label>
                        <input type="number" name="min_amount" value="{{ $offer->min_amount }}" class="form-control glass-input" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Reward Bonus Amount</label>
                        <input type="number" name="bonus_amount" value="{{ $offer->bonus_amount }}" class="form-control glass-input" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-secondary small">Status</label>
                        <select name="status" class="form-select glass-input">
                            <option value="1" {{ $offer->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$offer->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class='modal-footer-custom'>
                        <button type='button' class='btn btn-cancel' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' class='btn btn-premium btn-submit-small'>Update Rule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endpush
