@extends('layouts.app')

@section('content')
<!-- Custom Styles for Premium Refund Policy Page -->
@push('styles')
<style>
    .refund-hero {
        background: linear-gradient(135deg, #111827 0%, #1F2937 100%);
        padding: 80px 0;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 122, 24, 0.1);
    }
    .refund-hero::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 122, 24, 0.15) 0%, rgba(255, 122, 24, 0) 70%);
        top: -100px;
        right: -50px;
        border-radius: 50%;
        pointer-events: none;
    }
    .refund-hero::after {
        content: '';
        position: absolute;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(242, 112, 26, 0.08) 0%, rgba(242, 112, 26, 0) 70%);
        bottom: -80px;
        left: -50px;
        border-radius: 50%;
        pointer-events: none;
    }
    .hero-badge {
        background: rgba(255, 122, 24, 0.1);
        border: 1px solid rgba(255, 122, 24, 0.2);
        color: var(--primary);
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 8px 16px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 8px;
    }
    .policy-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.08);
        padding: 35px;
        border-radius: 16px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
    }
    .policy-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.04);
        border-color: rgba(255, 122, 24, 0.15);
    }
    .policy-card-icon {
        width: 48px;
        height: 48px;
        background: rgba(242, 112, 26, 0.05);
        color: #f2701aff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        border-radius: 12px;
        flex-shrink: 0;
    }
    .policy-list {
        list-style: none;
        padding-left: 0;
    }
    .policy-list li {
        position: relative;
        padding-left: 28px;
        margin-bottom: 12px;
        color: #4b5563;
        font-size: 0.95rem;
        line-height: 1.7;
    }
    .policy-list li::before {
        content: "\f285"; /* Bootstrap Icon code for bi-chevron-right */
        font-family: "bootstrap-icons";
        position: absolute;
        left: 4px;
        top: 2px;
        color: #f2701aff;
        font-size: 0.85rem;
        font-weight: 800;
    }
    .highlight-badge {
        background: rgba(242, 112, 26, 0.08);
        color: #f2701aff;
        padding: 3px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.85rem;
    }
    .alert-card {
        border-left: 4px solid #ff4747 !important;
        background: #fffdfd !important;
    }
    .alert-card .policy-card-icon {
        background: rgba(255, 71, 71, 0.08);
        color: #ff4747;
    }
</style>
@endpush

<section class="refund-hero text-center text-white">
    <div class="container">
        <span class="hero-badge mb-3">
            <i class="bi bi-shield-check"></i> OFFICIAL POLICY
        </span>
        <h1 class="display-4 fw-black text-white mb-3" style="letter-spacing: -1.5px;">
            Refund & <span class="text-primary">Cancellation</span>
        </h1>
        <p class="text-white-50 fs-5 mb-0 mx-auto" style="max-width: 700px; font-weight: 500;">
            At <a href="https://scib2b.com" target="_blank" class="text-primary text-decoration-none">Shopping Club India</a>, we aim to provide smooth and transparent service for all customers and business partners.
        </p>
    </div>
</section>

<div class="container py-5 my-3">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <!-- 1. Order Cancellation -->
            <div class="policy-card">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="policy-card-icon">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">Order Cancellation</h3>
                </div>
                <ul class="policy-list mb-0">
                    <li>Customers can cancel their order only before the order is accepted and processed.</li>
                    <li>Once the order is accepted or dispatched, cancellation requests may not be applicable.</li>
                </ul>
            </div>

            <!-- 2. Refund Policy -->
            <div class="policy-card">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="policy-card-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">Refund Policy</h3>
                </div>
                <ul class="policy-list mb-0">
                    <li>After cancellation approval, the refund amount will be credited to the customer <strong class="text-dark">Wallet / Account Balance</strong>.</li>
                    <li>Wallet balance can be conveniently used for future purchases on the platform.</li>
                </ul>
            </div>

            <!-- 3. Courier Return Policy -->
            <div class="policy-card">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="policy-card-icon">
                        <i class="bi bi-truck-flatbed"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">Courier Return Policy</h3>
                </div>
                <ul class="policy-list mb-0">
                    <li>In case a parcel is returned due to courier-side issues or delivery failure, the parcel will be re-dispatched promptly after it is safely received back at the Shopping Club India Hub.</li>
                </ul>
            </div>

            <!-- 4. Buyer Rejection Policy -->
            <div class="policy-card alert-card">
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="policy-card-icon">
                            <i class="bi bi-exclamation-octagon-fill"></i>
                        </div>
                        <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">Buyer Rejection Policy</h3>
                    </div>
                    <span class="badge bg-danger text-white px-3 py-2 rounded-8 fw-bold xx-small uppercase tracking-widest">
                        CRITICAL CLAUSE
                    </span>
                </div>
                <p class="text-secondary leading-relaxed fw-medium mb-3">
                    If the buyer rejects the order at the time of delivery, the following terms apply:
                </p>
                <ul class="policy-list text-secondary mb-0">
                    <li>The advance payment taken for the order <strong class="text-danger">will not be refunded</strong> under any circumstances.</li>
                    <li>If the buyer has already made full payment, then:
                        <ul class="list-unstyled mt-2 ps-3 border-start border-2 border-danger border-opacity-10">
                            <li class="mb-2"><span class="highlight-badge">Deduction:</span> The advance percentage amount and actual shipping charges will be deducted from the total.</li>
                            <li><span class="highlight-badge">Refund:</span> The remaining balance amount will be refunded directly to the customer wallet.</li>
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- 5. Important Note -->
            <div class="policy-card">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="policy-card-icon">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">Important Notes</h3>
                </div>
                <ul class="policy-list mb-0">
                    <li>Refund processing time may vary depending on order status and verification process.</li>
                    <li>Shopping Club India reserves the right to update or modify this policy at any time without prior notice.</li>
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection
