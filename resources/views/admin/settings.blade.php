@extends('layouts.admin')

@section('title', 'Settings')

@section('admin_content')
<div class="mb-4">
    <h5 class="fw-bold mb-0">Platform Settings</h5>
    <p class="text-secondary small">Configure global e-commerce parameters</p>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 glass-card text-success p-3 rounded-4 small mb-4 bg-success bg-opacity-10">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="glass-card p-4">
            <form action="{{ route('admin.settings.store') }}" method="POST">
                @csrf

                <div class="mb-4 pt-3 border-top border-white border-opacity-10" id="logisticsConfiguration">
                    <h6 class="text-white fw-bold mb-3"><i class="bi bi-truck me-2 text-warning"></i>Logistics & Shipping (Default Rates)</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Default Online Shipping (₹)</label>
                            <input type="number" name="global_online_shipping" class="form-control glass-input" value="{{ $settings['global_online_shipping'] ?? 0 }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Default COD Shipping (₹)</label>
                            <input type="number" name="global_cod_shipping" class="form-control glass-input" value="{{ $settings['global_cod_shipping'] ?? 0 }}" required>
                        </div>
                    </div>
                </div>

                <div class="mb-4 pt-3 border-top border-white border-opacity-10" id="paymentConfiguration">
                    <h6 class="text-white fw-bold mb-3"><i class="bi bi-gear-wide-connected me-2 text-primary"></i>Ordering & Adv. Policy</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Min Order Value to Place Order (₹)</label>
                            <input type="number" name="min_order_price" class="form-control glass-input" value="{{ $settings['min_order_price'] ?? 1 }}" required min="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Default COD Advance (%)</label>
                            <input type="number" name="global_cod_advance_percent" class="form-control glass-input" value="{{ $settings['global_cod_advance_percent'] ?? 10 }}" required min="0" max="100">
                        </div>
                    </div>
                </div>

                <!-- <div class="mb-4 pt-3 border-top border-white border-opacity-10" id="paymentIncentives">
                    <h6 class="text-white fw-bold mb-3"><i class="bi bi-wallet2 me-2 text-success"></i>Incentives & Discounts</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Min Order for Free Delivery (₹)</label>
                            <input type="number" name="min_free_delivery_amount" class="form-control glass-input" value="{{ $settings['min_free_delivery_amount'] ?? 500 }}" required min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Wallet Cashback Percentage (%)</label>
                            <input type="number" name="cashback_percentage" class="form-control glass-input" value="{{ $settings['cashback_percentage'] ?? 0 }}" required min="0" max="100">
                        </div>
                    </div>
                </div> -->

                <div class="mb-4 pt-3 border-top border-white border-opacity-10">
                    <h6 class="text-white fw-bold mb-3"><i class="bi bi-info-circle me-2 text-info"></i>Support & Contact</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Support Email</label>
                            <input type="email" name="support_email" class="form-control glass-input" value="{{ $settings['support_email'] ?? 'support@shoppingclubindia.com' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Support Phone</label>
                            <input type="text" name="support_phone" class="form-control glass-input" value="{{ $settings['support_phone'] ?? '+91 999 999 9999' }}">
                        </div>
                    </div>
                </div>

                <div class='modal-footer-custom'>
            <button type='button' class='btn btn-cancel' data-bs-dismiss='modal'>Cancel</button>
            <button type='submit' class='btn btn-premium btn-submit-small'>Save Configuration</button>
        </div>
            </form>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="glass-card p-4 h-100 shadow-premium">
            <h6 class="text-white fw-bold mb-3 uppercase small tracking-widest"><i class="bi bi-eye me-2 text-warning"></i>Live Status Preview</h6>
            <p class="x-small text-secondary mb-4 italic opacity-75">Platform-wide defaults currently enforced:</p>
            
            <div class="mb-4">
                <div class="text-white x-small fw-bold mb-1">Global COD Advance</div>
                <div class="h3 fw-bold text-success mb-0">{{ $settings['global_cod_advance_percent'] ?? 10 }}%</div>
                <div class="x-small text-secondary">of product price charged upfront</div>
            </div>

            <!-- <div class="mb-4">
                <div class="text-white x-small fw-bold mb-1">Free Delivery Threshold</div>
                <div class="h3 fw-bold text-primary mb-0">₹{{ $settings['min_free_delivery_amount'] ?? 500 }}</div>
                <div class="x-small text-secondary">Minimum spend required</div>
            </div> -->

            <div class="mb-4 pt-3 border-top border-white border-opacity-10">
                <div class="text-white x-small fw-bold mb-2">Active Support Channels</div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-envelope-at text-info xx-small"></i>
                    <span class="x-small text-white opacity-75">{{ $settings['support_email'] ?? 'Not set' }}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-telephone text-warning xx-small"></i>
                    <span class="x-small text-white opacity-75">{{ $settings['support_phone'] ?? 'Not set' }}</span>
                </div>
            </div>

            <div class="mt-auto p-3 rounded-4  bg-opacity-10 border border-primary border-opacity-10">
                <p class="xx-small text-primary fw-bold mb-0 lh-sm">All changes reflect in real-time on mobile & dashboard interfaces.</p>
            </div>
        </div>
    </div>
</div>
@endsection
