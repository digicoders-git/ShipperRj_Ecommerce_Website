@extends('layouts.admin')

@section('title', 'Live Selling Offers')

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-white fw-bold mb-1"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Live Selling Offers</h3>
            <p class="text-secondary small mb-0">Create and manage live promotional offers applied automatically to all products in selected categories.</p>
        </div>
        <button class="btn btn-add btn-sm px-4" data-bs-toggle="modal" data-bs-target="#addOfferModal">
            <i class="bi bi-plus-lg me-2"></i> Create Category Offer
        </button>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: "{{ session('success') }}",
                        showConfirmButton: false,
                        timer: 3500,
                        timerProgressBar: true
                    });
                }
            });
        </script>
    @endif

    <!-- Analytics Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="glass-card p-4 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary x-small text-uppercase fw-bold ls-1 d-block mb-1">Total Offers</span>
                        <h2 class="text-white fw-black mb-0">{{ $offers->count() }}</h2>
                    </div>
                    <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-4 p-3 fs-3">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card p-4 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary x-small text-uppercase fw-bold ls-1 d-block mb-1">Active Live</span>
                        <h2 class="text-success fw-black mb-0">{{ $offers->filter(fn($o) => $o->offer_status === 'Live')->count() }}</h2>
                    </div>
                    <div class="icon-shape bg-success bg-opacity-10 text-success rounded-4 p-3 fs-3">
                        <i class="bi bi-broadcast"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card p-4 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary x-small text-uppercase fw-bold ls-1 d-block mb-1">Scheduled</span>
                        <h2 class="text-info fw-black mb-0">{{ $offers->filter(fn($o) => $o->offer_status === 'Scheduled')->count() }}</h2>
                    </div>
                    <div class="icon-shape bg-info bg-opacity-10 text-info rounded-4 p-3 fs-3">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card p-4 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-secondary x-small text-uppercase fw-bold ls-1 d-block mb-1">Expired / Inactive</span>
                        <h2 class="text-danger fw-black mb-0">{{ $offers->filter(fn($o) => in_array($o->offer_status, ['Expired', 'Inactive']))->count() }}</h2>
                    </div>
                    <div class="icon-shape bg-danger bg-opacity-10 text-danger rounded-4 p-3 fs-3">
                        <i class="bi bi-calendar-x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="glass-card">
        <div class="table-responsive">
            <table class="table admin-datatable table-hover text-secondary align-middle">
                <thead>
                    <tr class="border-bottom text-dark">
                        <th class="small fw-bold py-3 text-uppercase">Banner</th>
                        <th class="small fw-bold py-3 text-uppercase">Offer Details</th>
                        <th class="small fw-bold py-3 text-uppercase">Target Category</th>
                        <th class="small fw-bold py-3 text-uppercase">Discount</th>
                        <th class="small fw-bold py-3 text-uppercase">Validity Duration</th>
                        <th class="small fw-bold py-3 text-uppercase">Live Status</th>
                        <th class="small fw-bold py-3 text-end text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($offers as $offer)
                        <tr class="border-bottom">
                            <td style="width: 80px;">
                                @if($offer->image)
                                    <img src="{{ asset($offer->image) }}" alt="Banner" class="rounded-3 shadow-sm border" style="width: 75px; height: 48px; object-fit: cover;">
                                @else
                                    <div class="bg-light border rounded-3 d-flex align-items-center justify-content-center text-muted small" style="width: 75px; height: 48px;">
                                        <i class="bi bi-image fs-5"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="text-dark fw-black fs-6">{{ $offer->offer_name ?: 'Unnamed Offer' }}</div>
                                <span class="badge bg-danger text-white px-2 py-1 xx-small fw-bold uppercase tracking-wider">
                                    <i class="bi bi-lightning-fill me-1"></i>{{ $offer->offer_type ?: 'Special Offer' }}
                                </span>
                            </td>
                            <td>
                                @if($offer->category)
                                    <span class="text-info fw-semibold"><i class="bi bi-folder2-open me-1"></i>{{ $offer->category->name }}</span>
                                @else
                                    <span class="text-muted italic">All Categories</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark fw-black px-3 py-2 fs-6 shadow-sm border-0">
                                    <i class="bi bi-tag-fill me-1"></i>
                                    @if($offer->discount_type === 'fixed')
                                        ₹{{ number_format($offer->discount_value, 2) }} OFF
                                    @else
                                        {{ (float) $offer->discount_value }}% OFF
                                    @endif
                                </span>
                            </td>
                            <td class="small">
                                <div class="text-dark fw-bold"><i class="bi bi-calendar-event me-1 text-warning"></i> {{ $offer->start_date ? $offer->start_date->format('d M Y, h:i A') : 'N/A' }}</div>
                                <div class="text-secondary small mt-1"><i class="bi bi-flag me-1 text-danger"></i> {{ $offer->end_date ? $offer->end_date->format('d M Y, h:i A') : 'N/A' }}</div>
                            </td>
                            <td>
                                @php $status = $offer->offer_status; @endphp
                                @if($status === 'Live')
                                    <span class="badge bg-success text-white px-3 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-1">
                                        <span class="spinner-grow spinner-grow-sm text-white me-1" style="width: 6px; height: 6px;" role="status"></span>
                                        LIVE
                                    </span>
                                @elseif($status === 'Scheduled')
                                    <span class="badge bg-info text-dark px-3 py-2 fw-bold shadow-sm">
                                        <i class="bi bi-clock me-1"></i> SCHEDULED
                                    </span>
                                @elseif($status === 'Expired')
                                    <span class="badge bg-danger text-white px-3 py-2 fw-bold shadow-sm">
                                        EXPIRED
                                    </span>
                                @else
                                    <span class="badge bg-secondary text-white px-3 py-2 fw-bold shadow-sm">
                                        INACTIVE
                                    </span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <button class="btn btn-sm border-0 bg-transparent p-1 shadow-none"
                                        data-bs-toggle="modal" data-bs-target="#editOfferModal{{ $offer->id }}" title="Edit Offer">
                                        <i class="bi bi-pencil-square text-warning fs-5"></i>
                                    </button>
                                    <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm border-0 bg-transparent p-1 shadow-none btn-delete" title="Delete Offer">
                                            <i class="bi bi-trash text-danger fs-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-secondary">
                                <i class="bi bi-percent fs-1 d-block mb-2 opacity-50"></i>
                                No Category Offers created yet. Click "Create Category Offer" to start!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Offer Modals -->
    @foreach($offers as $offer)
        <div class="modal fade" id="editOfferModal{{ $offer->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 p-3 shadow-lg" style="border-radius: 20px;">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Category Offer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-4">
                        <form action="{{ route('admin.offers.update', $offer->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-dark small fw-bold">Offer Name *</label>
                                    <input type="text" name="offer_name" class="form-control" value="{{ $offer->offer_name }}" placeholder="e.g. Diwali Mega Sale" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark small fw-bold">Offer Type *</label>
                                    <select name="offer_type" class="form-select" required>
                                        <option value="Festival Sale" {{ $offer->offer_type == 'Festival Sale' ? 'selected' : '' }}>Festival Sale</option>
                                        <option value="Flash Sale" {{ $offer->offer_type == 'Flash Sale' ? 'selected' : '' }}>Flash Sale</option>
                                        <option value="Special Offer" {{ $offer->offer_type == 'Special Offer' ? 'selected' : '' }}>Special Offer</option>
                                        <option value="Clearance Sale" {{ $offer->offer_type == 'Clearance Sale' ? 'selected' : '' }}>Clearance Sale</option>
                                        <option value="Weekend Special" {{ $offer->offer_type == 'Weekend Special' ? 'selected' : '' }}>Weekend Special</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-dark small fw-bold">Target Category * (Offer applies to all products in this category)</label>
                                    <select name="category_id" class="form-select" required>
                                        <option value="">Select Category...</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ $offer->category_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark small fw-bold">Discount Type *</label>
                                    <select name="discount_type" class="form-select" required>
                                        <option value="percentage" {{ $offer->discount_type == 'percentage' ? 'selected' : '' }}>Percentage Discount (%)</option>
                                        <option value="fixed" {{ $offer->discount_type == 'fixed' ? 'selected' : '' }}>Fixed Amount Discount (₹)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark small fw-bold">Discount Value *</label>
                                    <input type="number" step="0.01" name="discount_value" class="form-control" value="{{ $offer->discount_value }}" placeholder="e.g. 20 for 20% or 150 for ₹150" required min="0.01">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark small fw-bold">Start Date & Time *</label>
                                    <input type="datetime-local" name="start_date" class="form-control" value="{{ $offer->start_date ? $offer->start_date->format('Y-m-d\TH:i') : '' }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark small fw-bold">End Date & Time *</label>
                                    <input type="datetime-local" name="end_date" class="form-control" value="{{ $offer->end_date ? $offer->end_date->format('Y-m-d\TH:i') : '' }}" required>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label text-dark small fw-bold">Offer Banner / Image</label>
                                    @if($offer->image)
                                        <div class="mb-2 d-flex align-items-center gap-3 p-2 bg-light rounded-3 border">
                                            <img src="{{ asset($offer->image) }}" alt="Current Banner" class="rounded-2 border shadow-sm" style="width: 120px; height: 65px; object-fit: cover;">
                                            <div>
                                                <span class="d-block xx-small fw-bold text-success"><i class="bi bi-check-circle-fill me-1"></i> Current Banner</span>
                                                <span class="xx-small text-muted">Upload a new image below if you wish to change it.</span>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    <span class="xx-small text-muted">Upload custom promotional banner image for category header.</span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-dark small fw-bold">Status *</label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ $offer->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $offer->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer border-0 px-0 pb-0 mt-4">
                                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Update Offer</button>
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
            <div class="modal-content border-0 p-3 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark"><i class="bi bi-tag-fill me-2 text-primary"></i>Create New Category Live Offer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4">
                    <form action="{{ route('admin.offers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold">Offer Name *</label>
                                <input type="text" name="offer_name" class="form-control" placeholder="e.g. Diwali Sale" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold">Offer Type *</label>
                                <select name="offer_type" class="form-select" required>
                                    <option value="Festival Sale">Festival Sale</option>
                                    <option value="Flash Sale">Flash Sale</option>
                                    <option value="Special Offer">Special Offer</option>
                                    <option value="Clearance Sale">Clearance Sale</option>
                                    <option value="Weekend Special">Weekend Special</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-dark small fw-bold">Target Category * (Offer automatically applies to all products in this category)</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category...</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold">Discount Type *</label>
                                <select name="discount_type" class="form-select" required>
                                    <option value="percentage">Percentage Discount (%)</option>
                                    <option value="fixed">Fixed Amount Discount (₹)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold">Discount Value *</label>
                                <input type="number" step="0.01" name="discount_value" class="form-control" placeholder="e.g. 20 for 20% or 150 for ₹150" required min="0.01">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold">Start Date & Time *</label>
                                <input type="datetime-local" name="start_date" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold">End Date & Time *</label>
                                <input type="datetime-local" name="end_date" class="form-control" value="{{ now()->addDays(1)->format('Y-m-d\TH:i') }}" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label text-dark small fw-bold">Offer Banner / Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <span class="xx-small text-muted"><i class="bi bi-info-circle me-1 text-primary"></i> Recommended Aspect Ratio: <strong>16:9</strong> (e.g. <strong>800 x 450 px</strong> or <strong>600 x 338 px</strong>) for a full edge-to-edge fit.</span>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-dark small fw-bold">Status *</label>
                                <select name="status" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer border-0 px-0 pb-0 mt-4">
                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Save & Publish Offer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection