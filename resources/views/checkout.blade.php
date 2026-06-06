@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="checkout-luxury-wrapper">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4 mt-0 px-lg-5">
                <div>
                    <h2 class="fw-black text-dark tracking-tighter mb-1 uppercase">Secure Checkout</h2>
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-1 bg-success rounded-circle animate-pulse"></div>
                        <p class="text-muted small mb-0 fw-bold opacity-75">SSL CRYPTO-SECURED TRANSACTION</p>
                    </div>
                </div>
                <div class="d-none d-md-flex align-items-center gap-3">
                    <i class="bi bi-shield-check display-6 text-primary opacity-50"></i>
                    <div class="vr h-25 opacity-10"></div>
                    <div class="text-end">
                        <p class="xx-small fw-black text-secondary mb-0 tracking-widest uppercase">Verified Merchant</p>
                        <p class="small fw-bold text-dark mb-0">Shopping Club India</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-4">
                <div class="col-lg-12">
                    <div class="checkout-modern-stepper p-3 rounded-4">
                        <div class="d-flex justify-content-between align-items-center position-relative px-lg-4">
                            <div class="luxury-step active" id="step1-indicator">
                                <div class="luxury-step-icon">1</div>
                                <span class="luxury-step-label">Delivery Details</span>
                            </div>
                            <div class="luxury-step" id="step2-indicator">
                                <div class="luxury-step-icon">2</div>
                                <span class="luxury-step-label">Order Summary</span>
                            </div>
                            <div class="luxury-step" id="step3-indicator">
                                <div class="luxury-step-icon">3</div>
                                <span class="luxury-step-label">Secure Payment</span>
                            </div>
                            <div class="luxury-step-line">
                                <div class="luxury-step-progress" id="step-progress"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @push('modals')
                <!-- Moving Modal to the TOP level to avoid any nested container pointer-events issues -->
                <div class="modal fade" id="addAddressModal" aria-hidden="true"
                    style="backdrop-filter: blur(5px); z-index: 10001;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 border-0 shadow-lg" style="pointer-events: auto;">
                            <div class="modal-header border-0 p-4 pb-0">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary-soft p-2 rounded-circle">
                                        <i class="bi bi-geo-alt-fill text-primary"></i>
                                    </div>
                                    <h5 class="fw-black mb-0">Add New Address</h5>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4 pt-0">
                                <form id="addressForm" action="{{ route('checkout.address.save', [], false) }}" method="POST" onsubmit="handleAddressSaveSubmit(event)">
                                    @csrf
                                    <div class="luxury-form-group mb-3">
                                        <label class="small fw-bold text-dark mb-2 ms-1">Contact Information</label>
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <div class="luxury-input-wrapper">
                                                    <i class="bi bi-person luxury-input-icon"></i>
                                                    <input type="text" name="name" class="luxury-input" placeholder="Full Name"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="luxury-input-wrapper">
                                                    <i class="bi bi-phone luxury-input-icon"></i>
                                                    <input type="tel" name="mobile" class="luxury-input"
                                                        placeholder="Mobile Number" required pattern="[6789][0-9]{9}"
                                                        minlength="10" maxlength="10"
                                                        title="10 digits starting with 6,7,8 or 9">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="luxury-input-wrapper">
                                                    <i class="bi bi-phone-vibrate luxury-input-icon"></i>
                                                    <input type="tel" name="alt_mobile" class="luxury-input"
                                                        placeholder="Alt Mobile" pattern="[6789][0-9]{9}" minlength="10"
                                                        maxlength="10" title="10 digits starting with 6, 7, 8 or 9">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="luxury-form-group mb-3">
                                        <label class="small fw-bold text-dark mb-2 ms-1">Shipping Address</label>
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <div class="luxury-input-wrapper">
                                                    <i class="bi bi-geo-alt luxury-input-icon"></i>
                                                    <textarea name="address_line" class="luxury-input pt-4"
                                                        placeholder="House No, Building, Street, Area" style="height: 80px"
                                                        required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="luxury-input-wrapper">
                                                    <i class="bi bi-building luxury-input-icon"></i>
                                                    <input type="text" name="city" class="luxury-input"
                                                        placeholder="City/District" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="luxury-input-wrapper">
                                                    <i class="bi bi-map luxury-input-icon"></i>
                                                    <input type="text" name="state" class="luxury-input" placeholder="State"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="luxury-input-wrapper">
                                                    <i class="bi bi-pin-map luxury-input-icon"></i>
                                                    <input type="text" name="pincode" class="luxury-input" placeholder="Pincode"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="luxury-input-wrapper">
                                                    <i class="bi bi-flag luxury-input-icon"></i>
                                                    <input type="text" name="landmark" class="luxury-input"
                                                        placeholder="Landmark (Optional)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="luxury-form-group mb-4">
                                        <label class="small fw-bold text-dark mb-3 ms-1 uppercase tracking-widest">Address
                                            Category</label>
                                        <div class="d-flex gap-3">
                                            <input type="radio" class="btn-check" name="type" id="typeHomeLux" value="Home"
                                                checked autocomplete="off">
                                            <label class="luxury-type-btn btn flex-grow-1" for="typeHomeLux">
                                                <i class="bi bi-house-door me-2"></i> HOME
                                            </label>
                                            <input type="radio" class="btn-check" name="type" id="typeWorkLux" value="Work"
                                                autocomplete="off">
                                            <label class="luxury-type-btn btn flex-grow-1" for="typeWorkLux">
                                                <i class="bi bi-briefcase me-2"></i> WORK
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="btn btn-luxury-primary w-100 py-3 rounded-3 fw-black shadow-premium border-0">
                                        COMPLETE PROFILE & SAVE
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endpush


            <form id="checkoutForm" action="{{ route('checkout.order.process') }}" method="POST"
                onsubmit="return validateCheckout(event)">
                @csrf
                <input type="hidden" name="order_type" value="{{ $order_type }}">
                <input type="hidden" name="buy_now" value="{{ $buy_now }}">
                <input type="hidden" name="qty" value="{{ $qty }}">
                <input type="hidden" name="address_id" id="selectedAddressId"
                    value="{{ $addresses->where('is_default', 1)->first()->id ?? $addresses->first()->id ?? '' }}">
                <input type="hidden" name="payment_method" id="paymentMethodInput" value="">

                <div class="row g-4">
                    <!-- Left Side: Steps Content -->
                    <div class="col-lg-8">
                        <!-- Step 1: Address Selection -->
                        <div class="checkout-step-content active" id="step1-content">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-black mb-0">Select Delivery Address</h4>
                                <button type="button" class="btn btn-outline-primary rounded-3 px-4"
                                    data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                    <i class="bi bi-plus-lg me-2"></i> Add New Address
                                </button>
                            </div>

                            <div class="row g-4" id="addressList">
                                @forelse($addresses as $address)
                                    <div class="col-md-6">
                                        <div class="luxury-address-card {{ $loop->first ? 'active' : '' }}"
                                            onclick="selectAddress('{{ $address->id }}', this)">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="luxury-badge">{{ $address->type }}</span>
                                                @if($address->is_default)
                                                    <span class="luxury-status"><i class="bi bi-patch-check-fill me-1"></i>
                                                        DEFAULT</span>
                                                @endif
                                            </div>
                                            <h5 class="fw-black text-dark mb-2">{{ $address->name }}</h5>
                                            <p class="text-secondary small mb-4 opacity-75 lh-base">
                                                {{ $address->address_line }},
                                                {{ $address->landmark ? $address->landmark . ', ' : '' }}{{ $address->city }},
                                                {{ $address->state }} - {{ $address->pincode }}</p>
                                            <div class="luxury-contact-footer">
                                                <div class="d-flex align-items-center gap-2 text-dark fs-6 fw-bold">
                                                    <i class="bi bi-telephone text-primary"></i>
                                                    {{ $address->mobile }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="luxury-empty-state">
                                            <div class="luxury-empty-icon">
                                                <i class="bi bi-geo-alt"></i>
                                            </div>
                                            <h4 class="fw-black text-dark">Where should we deliver?</h4>
                                            <p class="text-muted small mb-4">Please add a shipping address to discover delivery
                                                methods and estimated times for your items.</p>
                                            <button type="button" class="btn btn-luxury-primary px-5 py-3 rounded-3 fw-black"
                                                data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                                <i class="bi bi-plus-lg me-2"></i> ADD SHIPPING ADDRESS
                                            </button>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <div class="text-end mt-5">
                                <button type="button"
                                    class="btn btn-primary bg-gradient-primary px-5 py-3 rounded-3 fw-black"
                                    onclick="goToStep(2)" {{ $addresses->isEmpty() ? 'disabled' : '' }}>
                                    CONTINUE <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Order Summary -->
                        <div class="checkout-step-content" id="step2-content">
                            <h4 class="fw-black mb-4">Order Summary</h4>
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                                <div class="card-body p-0">
                                    @foreach($items as $item)
                                        <div class="p-4 border-bottom last-child-border-0">
                                            <div class="d-flex gap-4">
                                                <div class="product-img rounded-3 border overflow-hidden"
                                                    style="width: 100px; height: 100px; flex-shrink: 0;">
                                                    <img src="{{ $item['image'] ? asset($item['image']) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=200' }}"
                                                        class="w-100 h-100 object-fit-contain p-2">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-black text-dark mb-1">{{ $item['name'] }}</h6>
                                                    <div class="d-flex align-items-center gap-3 mb-2">
                                                        <span class="fw-black text-primary product-unit-price" data-id="{{ $item['id'] }}">₹{{ number_format($item['price']) }}</span>
                                                        <div class="d-flex align-items-center bg-light border rounded-3 px-2" style="width: fit-content; gap: 8px; height: 32px;">
                                                            <button type="button" class="btn btn-sm btn-link p-0 text-dark fw-bold text-decoration-none" style="font-size: 1.1rem; line-height: 1;" onclick="changeCheckoutQty('{{ $item['id'] }}', '{{ $item['cart_id'] ?? '' }}', -1, '{{ $order_type }}', {{ $item['min_qty'] }}, {{ $item['stock'] }}, this)">&minus;</button>
                                                            <input type="number" class="text-center fw-bold border-0 bg-transparent checkout-qty-input" value="{{ $item['qty'] }}" min="{{ $item['min_qty'] }}" max="{{ $item['stock'] }}" style="width: 40px; font-size: 0.9rem;" onchange="handleCheckoutQtyType(this, '{{ $item['id'] }}', '{{ $item['cart_id'] ?? '' }}', '{{ $order_type }}', {{ $item['min_qty'] }}, {{ $item['stock'] }})">
                                                            <button type="button" class="btn btn-sm btn-link p-0 text-dark fw-bold text-decoration-none" style="font-size: 1.1rem; line-height: 1;" onclick="changeCheckoutQty('{{ $item['id'] }}', '{{ $item['cart_id'] ?? '' }}', 1, '{{ $order_type }}', {{ $item['min_qty'] }}, {{ $item['stock'] }}, this)">+</button>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        <div
                                                            class="xx-small text-secondary fw-bold uppercase px-2 py-1 bg-light d-inline-block rounded-3">
                                                            DELIVERY IN 3-5 DAYS
                                                        </div>
                                                        @if($item['min_qty'] > 1)
                                                            <div
                                                                class="xx-small text-danger fw-bold uppercase px-2 py-1 bg-danger bg-opacity-10 d-inline-block rounded-3">
                                                                MOQ: {{ $item['min_qty'] }} Required
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-5">
                                <button type="button" class="btn btn-link text-dark text-decoration-none fw-bold"
                                    onclick="goToStep(1)">
                                    <i class="bi bi-arrow-left me-2"></i> BACK TO ADDRESS
                                </button>
                                <button type="button"
                                    class="btn btn-primary bg-gradient-primary px-5 py-3 rounded-3 fw-black"
                                    onclick="goToStep(3)">
                                    CONTINUE TO PAYMENT <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Payment Options -->
                        <div class="checkout-step-content" id="step3-content">
                            <h4 class="fw-black mb-4">Payment Options</h4>
                            <!-- Shipping savings message moved to Price Summary -->

                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="payment-card p-4 rounded-4 border" onclick="selectPayment('cod', this)">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="fw-black mb-0">Partial COD(Cash on Delivery)</h6>
                                                        <div class="payment-select-indicator">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $advanceTotal = 0;
                                                        foreach ($items as $item) {
                                                            // Use pre-calculated percent from controller (already handles product vs global)
                                                            $advanceTotal += ($item['price'] * $item['qty'] * $item['advance_percent'] / 100);
                                                        }
                                                    @endphp
                                                    <p class="text-secondary small mb-3 lh-sm">Pay <b class="text-dark">₹<span id="codAdvancePlusShippingDisplay">{{ number_format($base_advance + $cod_shipping, 2) }}</span></b> now and rest <b class="text-dark">₹<span id="codRestDisplay">{{ number_format($total - $base_advance, 2) }}</span></b> on delivery.</p>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-truck text-primary"></i>
                                                        <span class="xx-small text-primary fw-bold uppercase">Advance Required</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="payment-card p-4 rounded-4 border" onclick="selectPayment('online', this)">
                                                <div id="shippingSavingsAlert" class="p-2 rounded-3 bg-success bg-opacity-10 border border-success border-opacity-10 mb-3 animate-pulse-light" style="{{ $shipping_savings_amount > 0 ? '' : 'display: none !important;' }}">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-lightning-charge-fill text-success x-small"></i>
                                                        <span class="xx-small text-success fw-black uppercase tracking-tighter">Save ₹<span id="shippingSavingsAmountDisplay">{{ number_format($shipping_savings_amount) }}</span> (<span id="shippingSavingsPctDisplay">{{ round($shipping_savings_pct, 1) }}</span>%) by paying online</span>
                                                    </div>
                                                </div>
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        
                                                        <h6 class="fw-black mb-0">Full Online</h6>
                                                        <div class="payment-select-indicator">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </div>
                                                    </div>
                                                    <p class="text-secondary small mb-3 lh-sm">Pay full <b>₹<span id="onlineTotalDisplay">{{ number_format($total, 2) }}</span></b> online for faster processing & priority delivery.</p>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-shield-check text-success"></i>
                                                        <span class="xx-small text-success fw-bold uppercase">Safe & Secure</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-5">
                                            <button type="button" class="btn btn-link text-dark text-decoration-none fw-bold" onclick="goToStep(2)">
                                                <i class="bi bi-arrow-left me-2"></i> BACK TO SUMMARY
                                            </button>
                                            <button type="submit" id="placeOrderBtn" class="btn btn-primary bg-gradient-primary px-5 py-3 rounded-3 fw-black" disabled>
                                                PLACE ORDER <i class="bi bi-check-lg ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <!-- Available Offers -->
                                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white border-start border-4 border-warning">
                                        <div class="card-header bg-white border-0 p-4 pb-0">
                                            <h6 class="fw-black text-dark tracking-tight mb-2 uppercase small">
                                                <i class="bi bi-gift text-warning me-2"></i>Exclusive Offers
                                            </h6>
                                        </div>
                                        <div class="card-body p-4 pt-2">
                                            @forelse($coupons as $coupon)
                                                <div class="offer-item p-3 rounded-3 bg-light bg-opacity-50 border border-dashed border-dark border-opacity-10 mb-2 transition-all hover-scale cursor-pointer" onclick="selectCoupon('{{ $coupon->code }}')">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <span class="badge bg-primary bg-opacity-10 text-white border border-primary border-opacity-25 px-2 py-1 xx-small fw-black uppercase">{{ $coupon->code }}</span>
                                                        <span class="small fw-black text-success">SAVE ₹{{ number_format($coupon->discount_amount) }}</span>
                                                    </div>
                                                    <p class="xx-small text-secondary fw-bold mb-0">Apply {{ $coupon->code }} on shopping of ₹{{ number_format($coupon->min_spend) }}</p>
                                                </div>
                                            @empty
                                                <p class="xx-small text-secondary fw-bold mb-0 italic">Check back soon for exciting deals and discounts.</p>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div id="priceSummaryCard" class="card border-0 shadow-premium rounded-5 price-details-card position-sticky overflow-hidden" style="top: 100px;">
                                        <div class="card-header bg-transparent border-0 p-4 pb-0">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <div class="p-1 bg-primary rounded-circle"></div>
                                                <h6 class="fw-black text-dark uppercase tracking-widest small mb-0">Price Summary</h6>
                                            </div>
                                        </div>
                                        <div class="card-body p-4 pt-4">
                                            <div class="d-flex justify-content-between mb-3 align-items-center">
                                                @php $total_qty = 0;
                                                    foreach ($items as $item)
                                                        $total_qty += $item['qty']; 
                                                @endphp
                                                <span class="text-muted fw-medium" id="totalQtyDisplay">Price ({{ $total_qty }} items)</span>
                                                <span class="fw-black text-dark">₹<span id="subtotalDisplay">{{ number_format($total, 2) }}</span></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2 align-items-center">
                                                <span class="text-muted fw-medium" id="shippingMethodLabel">Shipping Charges</span>
                                                <span class="text-dark fw-bold" id="shippingDisplay">--</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2 align-items-center d-none" id="gstRow">
                                                 <span class="text-muted fw-medium">GST (18%)</span>
                                                 <span class="text-dark fw-bold">+₹<span id="gstDisplay">0.00</span></span>
                                            </div>

                                            <div id="couponSection" class="mt-4 mb-3">
                                                <div class="luxury-input-wrapper mb-2">
                                                    <i class="bi bi-ticket-perforated luxury-input-icon"></i>
                                                    <input type="text" name="coupon_code" id="couponInput" class="luxury-input" placeholder="Enter Coupon Code">
                                                    <button type="button" onclick="applyCoupon()" class="btn btn-sm btn-primary position-absolute end-0 top-50 translate-middle-y me-2 rounded-3 px-3 py-1 fw-bold" style="font-size: 0.65rem;">APPLY</button>
                                                </div>
                                                <p id="couponMsg" class="xx-small fw-bold mb-0 mt-1"></p>
                                            </div>

                                            <!-- GST Option Section -->
                                            <div id="gstSection" class="mb-4">
                                                 <div class="form-check form-switch mb-2">
                                                     <input class="form-check-input" type="checkbox" name="has_gst" id="gstCheckbox" value="1" onchange="toggleGst(this)">
                                                     <label class="form-check-label small fw-bold text-dark" for="gstCheckbox">
                                                         Add GST (18%) / GST Invoice
                                                     </label>
                                                 </div>
                                                 <div id="gstDetailsForm" style="display: none;" class="mt-2">
                                                     <div class="luxury-input-wrapper mb-2">
                                                         <i class="bi bi-building luxury-input-icon"></i>
                                                         <input type="text" name="gst_company" id="gstCompanyInput" class="luxury-input" placeholder="Company Name">
                                                     </div>
                                                     <div class="luxury-input-wrapper mb-2">
                                                         <i class="bi bi-hash luxury-input-icon"></i>
                                                         <input type="text" name="gst_number" id="gstNumberInput" class="luxury-input" placeholder="GSTIN (15 Digits)" minlength="15" maxlength="15">
                                                     </div>
                                                 </div>
                                            </div>

                                            @php
                                                $base_advance = 0;
                                                foreach ($items as $item) {
                                                    $base_advance += ($item['price'] * $item['qty'] * ($item['advance_percent'] ?? 10) / 100);
                                                }
                                            @endphp

                                            <div class="dashed-divider my-4"></div>

                                            <div class="d-flex justify-content-between align-items-baseline mb-2">
                                                <h5 class="fw-black text-dark mb-0">Total Amount</h5>
                                                <div class="text-end">
                                                    <h4 class="fw-black text-primary mb-0">₹<span id="grandTotalDisplay">{{ number_format($total, 2) }}</span></h4>
                                                    <p class="xx-small text-success fw-bold mb-0 d-none" id="discountInfo">You saved <span id="discountDisplay">0</span> with coupon</p>
                                                </div>
                                            </div>

                                            <div class="p-3 rounded-4 mt-3 d-flex justify-content-between align-items-center glass-payable-box">
                                                <div>
                                                    <div class="xx-small fw-black uppercase tracking-widest mb-1" id="payableNowLabel" style="color: #e96715 !important;">Payable Now</div>
                                                    <div class="x-small fw-bold opacity-75 lh-sm text-dark">Total Payable Amount</div>
                                                </div>
                                                <div class="text-end">
                                                    <h5 class="fw-black mb-0" style="color: #e96715 !important;">₹<span id="payableNowDisplay">0.00</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white bg-opacity-50 border-0 p-4">
                                            <div class="d-flex align-items-start gap-3 text-success small fw-bold">
                                                <i class="bi bi-shield-check fs-5"></i>
                                                <span class="lh-sm">Safe and Secure Payments. 100% Authentic products exclusively from Shopping Club India.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <style>
                        .checkout-qty-input::-webkit-outer-spin-button,
                        .checkout-qty-input::-webkit-inner-spin-button {
                            -webkit-appearance: none;
                            margin: 0;
                        }
                        .checkout-qty-input {
                            -moz-appearance: textfield;
                        }
                        :root {
                            --luxury-primary: #f2701a;
                            --luxury-accent: #ff4d00;
                            --luxury-bg: #fdfdfd;
                            --luxury-glass: rgba(255, 255, 255, 0.7);
                            --luxury-text: #1a202c;
                        }

                        .checkout-luxury-wrapper {
                            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 50%, #f1f4f8 100%);
                            min-height: 100vh;
                            position: relative;
                            overflow: hidden;
                        }

                        .checkout-modern-stepper {
                            background: var(--luxury-glass);
                            backdrop-filter: blur(20px);
                            border: 1px solid rgba(255, 255, 255, 0.6);
                            box-shadow: 0 20px 40px rgba(0,0,0,0.04);
                            position: relative;
                            z-index: 10;
                        }

                        .luxury-step {
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            gap: 6px;
                            z-index: 12;
                            width: 120px;
                            transition: all 0.4s ease;
                        }

                        .luxury-step-icon {
                            width: 32px;
                            height: 32px;
                            background: #fff;
                            border: 2px solid #edf2f7;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-weight: 800;
                            color: #ccd0d5;
                            font-size: 0.8rem;
                            transition: all 0.4s ease;
                        }

                        .luxury-step.active .luxury-step-icon {
                            background: var(--luxury-primary);
                            border-color: var(--luxury-primary);
                            color: #fff;
                            transform: scale(1.1);
                            box-shadow: 0 5px 10px rgba(242, 112, 26, 0.2);
                        }

                        .luxury-step.completed .luxury-step-icon {
                            background: #10b981;
                            border-color: #10b981;
                            color: #fff;
                        }

                        .luxury-step-label {
                            font-size: 0.6rem;
                            font-weight: 800;
                            text-transform: uppercase;
                            color: #adb5bd;
                            letter-spacing: 0.5px;
                        }

                        .luxury-step.active .luxury-step-label {
                            color: var(--luxury-text);
                        }

                        .luxury-step-line {
                            position: absolute;
                            top: 25px;
                            left: 10%;
                            right: 10%;
                            height: 2px;
                            background: #edf2f7;
                            z-index: 11;
                        }

                        .luxury-step-progress {
                            height: 100%;
                            background: var(--luxury-primary);
                            width: 0%;
                            transition: width 0.8s ease;
                        }

                        .luxury-address-card {
                            background: #fff;
                            border: 1px solid #f1f4f8;
                            border-radius: 20px;
                            padding: 24px;
                            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                            cursor: pointer;
                            position: relative;
                        }

                        .luxury-address-card:hover {
                            transform: translateY(-8px);
                            box-shadow: 0 20px 40px rgba(0,0,0,0.06);
                            border-color: rgba(242, 112, 26, 0.2);
                        }

                        .luxury-address-card.active {
                            border-color: var(--luxury-primary);
                            background: rgba(242, 112, 26, 0.02);
                            box-shadow: 0 15px 30px rgba(242, 112, 26, 0.08);
                        }

                        .luxury-status {
                            font-size: 0.58rem;
                            font-weight: 800;
                            color: var(--luxury-primary);
                            letter-spacing: 1px;
                        }

                        .luxury-badge {
                            background: #f8fafc;
                            border: 1px solid #edf2f7;
                            color: #64748b;
                            font-size: 0.58rem;
                            font-weight: 800;
                            padding: 4px 12px;
                            border-radius: 50px;
                            text-transform: uppercase;
                        }

                        .luxury-contact-footer {
                            padding-top: 15px;
                            border-top: 1px solid #f1f4f8;
                        }

                        .luxury-empty-state {
                            text-align: center;
                            padding: 60px 40px;
                            background: #fff;
                            border: 2px dashed #edf2f7;
                            border-radius: 30px;
                        }

                        .luxury-empty-icon {
                            width: 70px;
                            height: 70px;
                            background: #f8fafc;
                            border-radius: 20px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            margin: 0 auto 20px;
                            font-size: 2rem;
                            color: #ccd0d5;
                        }

                        .checkout-step-content {
                            display: none;
                            animation: slideInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
                        }
                        .checkout-step-content.active {
                            display: block;
                        }

                        .payment-card {
                            cursor: pointer;
                            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                            background: #fff;
                            border: 2px solid #f1f4f8 !important;
                            position: relative;
                            overflow: hidden;
                        }

                        .payment-select-indicator {
                            width: 24px;
                            height: 24px;
                            color: #ccd0d5;
                            font-size: 1.2rem;
                            transition: all 0.3s ease;
                        }

                        .payment-card.active {
                            border-color: var(--luxury-primary) !important;
                            background: rgba(242, 112, 26, 0.03);
                            box-shadow: 0 10px 20px rgba(242, 112, 26, 0.08);
                        }

                        .payment-card.active .payment-select-indicator {
                            color: var(--luxury-primary);
                            transform: scale(1.1);
                        }

                        .payment-card:hover:not(.active) {
                            border-color: #e2e8f0 !important;
                            background: #fcfcfc;
                        }

                        .btn-luxury-primary {
                            background: linear-gradient(135deg, #f2701a 0%, #e96715 100%);
                            color: #fff;
                            padding: 14px 30px;
                            border-radius: 50px;
                            font-weight: 800;
                            font-size: 0.85rem;
                            letter-spacing: 1px;
                            text-transform: uppercase;
                            border: none;
                            transition: all 0.3s ease;
                        }

                        .btn-luxury-primary:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 10px 20px rgba(242, 112, 26, 0.3);
                            color: #fff;
                        }

                        .luxury-type-btn {
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            padding: 14px;
                            border: 2px solid #edf2f7;
                            border-radius: 16px;
                            cursor: pointer;
                            font-weight: 800;
                            font-size: 0.75rem;
                            color: #718096;
                            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                            background: #fff;
                        }

                        .luxury-type-btn:hover {
                            border-color: rgba(242, 112, 26, 0.2);
                            background: #f8fafc;
                            transform: translateY(-2px);
                        }

                        .btn-check:checked + .luxury-type-btn {
                            background: var(--luxury-primary);
                            color: #fff;
                            border-color: var(--luxury-primary);
                            box-shadow: 0 10px 20px rgba(242, 112, 26, 0.2);
                        }
                        .luxury-input {
                            width: 100%;
                            padding: 12px 12px 12px 45px;
                            background: #f8fafc;
                            border: 1px solid #edf2f7;
                            border-radius: 12px;
                            font-size: 0.9rem;
                            transition: all 0.3s ease;
                        }
                        .luxury-input:focus {
                            background: #fff;
                            border-color: var(--luxury-primary);
                            box-shadow: 0 0 0 4px rgba(242, 112, 26, 0.05);
                            outline: none;
                        }
                        .luxury-input-wrapper { position: relative; }
                        .luxury-input-icon {
                            position: absolute;
                            left: 15px;
                            top: 50%;
                            transform: translateY(-50%);
                            color: #cbd5e0;
                        }
                        .price-details-card {
                            background: rgba(255, 255, 255, 0.85);
                            backdrop-filter: blur(20px);
                            border: 1px solid rgba(255, 255, 255, 0.5);
                        }
                        .glass-payable-box {
                            background: rgba(242, 112, 26, 0.08) !important;
                            backdrop-filter: blur(10px);
                            -webkit-backdrop-filter: blur(10px);
                            border: 1px solid rgba(242, 112, 26, 0.2) !important;
                            box-shadow: 0 8px 32px 0 rgba(242, 112, 26, 0.03);
                        }

                        @keyframes slideInUp {
                            from { opacity: 0; transform: translateY(30px); }
                            to { opacity: 1; transform: translateY(0); }
                        }

                        .luxury-savings-banner {
                            position: relative;
                            overflow: hidden;
                            transition: all 0.3s ease;
                        }
                        .luxury-savings-banner:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.1);
                        }
                        .pulse-green {
                            animation: pulseGreen 2s infinite;
                        }
                        @keyframes pulseGreen {
                            0% { transform: scale(0.95); opacity: 0.8; }
                            50% { transform: scale(1.05); opacity: 1; }
                            100% { transform: scale(0.95); opacity: 0.8; }
                        }
                        .animate-shine {
                            position: relative;
                        }
                        .animate-shine::after {
                            content: '';
                            position: absolute;
                            top: 0;
                            left: -100%;
                            width: 50%;
                            height: 100%;
                            background: linear-gradient(to right, transparent, rgba(255,255,255,0.4), transparent);
                            transform: skewX(-25deg);
                            animation: shine 4s infinite;
                        }
                        @keyframes shine {
                            0% { left: -100%; }
                            20% { left: 100%; }
                            100% { left: 100%; }
                        }
                        @keyframes pulse-light {
                            0% { opacity: 0.8; transform: scale(1); }
                            50% { opacity: 1; transform: scale(1.02); }
                            100% { opacity: 0.8; transform: scale(1); }
                        }
                        .animate-pulse-light {
                            animation: pulse-light 2s infinite ease-in-out;
                        }
                    </style>

                    <script>
                        function goToStep(step) {
                            document.querySelectorAll('.luxury-step').forEach(el => el.classList.remove('active', 'completed'));
                            for(let i=1; i<step; i++) {
                                document.getElementById('step'+i+'-indicator').classList.add('completed');
                            }
                            document.getElementById('step'+step+'-indicator').classList.add('active');

                            const progress = (step - 1) / 2 * 100;
                            document.getElementById('step-progress').style.width = progress + '%';

                            document.querySelectorAll('.checkout-step-content').forEach(el => el.classList.remove('active'));
                            document.getElementById('step'+step+'-content').classList.add('active');

                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }

                        function selectAddress(id, element) {
                            document.getElementById('selectedAddressId').value = id;
                            document.querySelectorAll('.luxury-address-card').forEach(el => el.classList.remove('active'));
                            element.classList.add('active');

                            const continueBtn = document.querySelector('#step1-content button[onclick="goToStep(2)"]');
                            if(continueBtn) continueBtn.disabled = false;
                        }

                        window.handleAddressSaveSubmit = async function(e) {
                            e.preventDefault();
                            const form = e.target;
                            const saveBtn = form.querySelector('button[type="submit"]');
                            const originalText = saveBtn ? saveBtn.innerHTML : 'SAVE';
 
                            if(saveBtn) {
                                saveBtn.disabled = true;
                                saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> PROCESSING...';
                            }
 
                            try {
                                const freshToken = await window.getFreshCsrfToken();
                                const tokenInput = form.querySelector('input[name="_token"]');
                                if (tokenInput) tokenInput.value = freshToken;
                                form.submit(); // traditional form submit
                            } catch(err) {
                                console.error('Save Error:', err);
                                form.submit(); // fallback
                            }
                        };

                        let baseSubtotal = {{ $total }};
                        let baseAdvance = {{ $base_advance }};
                        const minOrderVal = {{ $min_order_val ?? 0 }};
                        const orderItems = @json($items);
                        let currentShipping = 0;
                        let currentDiscount = 0;
                        let currentGstAmount = 0;
                        let onlineShipping = {{ $online_shipping }};
                        let codShipping = {{ $cod_shipping }};

                        function formatMoney(amount) {
                            return amount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        }

                        async function validateCheckout(e) {
                            e.preventDefault();
                            const form = e.currentTarget || e.target;
 
                            const gstCheckbox = document.getElementById('gstCheckbox');
                            if (gstCheckbox && gstCheckbox.checked) {
                                const gstNum = document.getElementById('gstNumberInput').value.trim();
                                if (!gstNum) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'GST NUMBER REQUIRED',
                                        text: 'Please enter your 15-digit GST number.',
                                        confirmButtonColor: '#f2701a'
                                    });
                                    return false;
                                }
                                const gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
                                if (!gstRegex.test(gstNum.toUpperCase())) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'INVALID GST FORMAT',
                                        text: 'Please enter a valid 15-digit GSTIN (e.g. 07AAAAA1111A1Z1).',
                                        confirmButtonColor: '#f2701a'
                                    });
                                    return false;
                                }
                            }

                            for (const item of orderItems) {
                                if (item.qty < item.min_qty) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'MINIMUM QUANTITY ERROR',
                                        text: `The minimum order quantity for "${item.name}" is ${item.min_qty} units. You have chosen ${item.qty}.`,
                                        confirmButtonColor: '#f2701a'
                                    });
                                    return false;
                                }
                            }
 
                            const currentGrandTotal = parseFloat(document.getElementById('grandTotalDisplay').innerText.replace(/,/g, ''));
                            if (minOrderVal > 0 && currentGrandTotal < minOrderVal) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'MINIMUM ORDER VALUE',
                                    text: `Your current order total is ₹${currentGrandTotal.toLocaleString()}. A minimum order of ₹${minOrderVal.toLocaleString()} is required to place an order.`,
                                    confirmButtonColor: '#f2701a'
                                });
                                return false;
                            }
 
                            const btn = document.getElementById('placeOrderBtn');
                            if(btn) {
                                btn.disabled = true;
                                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> PROCESSING...';
                            }
 
                            try {
                                const freshToken = await window.getFreshCsrfToken();
                                const tokenInput = form.querySelector('input[name="_token"]');
                                if (tokenInput) tokenInput.value = freshToken;
                                form.submit();
                            } catch (err) {
                                console.error('Submit Error:', err);
                                form.submit(); // Fallback
                            }
                        }

                        function selectPayment(method, element) {
                            const input = document.getElementById('paymentMethodInput');
                            if(input) input.value = method;
                            document.querySelectorAll('.payment-card').forEach(el => el.classList.remove('active'));
                            if(element) element.classList.add('active');

                            const placeOrderBtn = document.getElementById('placeOrderBtn');
                            if(placeOrderBtn) placeOrderBtn.disabled = false;

                            currentShipping = (method === 'online') ? onlineShipping : codShipping;
                            const label = document.getElementById('shippingMethodLabel');
                            if(label) label.innerText = (method === 'online') ? 'Online Shipping Charges' : 'COD Shipping Charges';
                            updateGrandTotal();
                        }

                        window.toggleGst = function(checkbox) {
                            const detailsForm = document.getElementById('gstDetailsForm');
                            if (checkbox.checked) {
                                detailsForm.style.display = 'block';
                            } else {
                                detailsForm.style.display = 'none';
                                document.getElementById('gstCompanyInput').value = '';
                                document.getElementById('gstNumberInput').value = '';
                            }
                            updateGrandTotal();
                        }

                        function updateGrandTotal() {
                            document.getElementById('shippingDisplay').innerText = '₹' + formatMoney(currentShipping);
                            
                            const gstCheckbox = document.getElementById('gstCheckbox');
                            if (gstCheckbox && gstCheckbox.checked) {
                                currentGstAmount = Math.round((baseSubtotal - currentDiscount) * 18) / 100;
                                document.getElementById('gstRow').classList.remove('d-none');
                                document.getElementById('gstDisplay').innerText = formatMoney(currentGstAmount);
                            } else {
                                currentGstAmount = 0;
                                document.getElementById('gstRow').classList.add('d-none');
                            }
                            
                            const grandTotal = (baseSubtotal + currentShipping + currentGstAmount) - currentDiscount;
                            document.getElementById('grandTotalDisplay').innerText = formatMoney(grandTotal);

                            let payableNow = 0;
                            if(document.getElementById('paymentMethodInput').value === 'online') {
                                payableNow = grandTotal;
                                document.getElementById('payableNowLabel').innerText = 'Payable Now (Full Amount)';
                            } else {
                                payableNow = Math.min(baseAdvance + currentShipping, grandTotal);
                                document.getElementById('payableNowLabel').innerText = 'Payable Now (Security Advance)';
                            }
                            document.getElementById('payableNowDisplay').innerText = formatMoney(payableNow);
                        }

                        function selectCoupon(code) {
                            document.getElementById('couponInput').value = code;
                            applyCoupon();
                        }

                        async function applyCoupon() {
                            const code = document.getElementById('couponInput').value;
                            const msg = document.getElementById('couponMsg');
 
                            if(!code) return;
 
                            try {
                                const freshToken = await window.getFreshCsrfToken();
                                const res = await fetch('{{ route("checkout.coupon.check", [], false) }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': freshToken
                                    },
                                    body: JSON.stringify({ coupon_code: code, total: baseSubtotal + currentShipping })
                                });
                                const data = await res.json();
                                if(data.success) {
                                    currentDiscount = data.discount;
                                    msg.className = 'xx-small fw-bold mb-0 mt-1 text-success';
                                    msg.innerText = data.message;
 
                                    document.getElementById('discountInfo').classList.remove('d-none');
                                    document.getElementById('discountDisplay').innerText = '₹' + currentDiscount;
                                    updateGrandTotal();
                                } else {
                                    msg.className = 'xx-small fw-bold mb-0 mt-1 text-danger';
                                    msg.innerText = data.message;
                                    currentDiscount = 0;
                                    document.getElementById('discountInfo').classList.add('d-none');
                                    updateGrandTotal();
                                }
                            } catch(err) {
                                console.error('Coupon Error:', err);
                            }
                        }

                        window.changeCheckoutQty = function(productId, cartId, delta, orderType, minQty, maxStock, btnEl) {
                            const input = btnEl.parentElement.querySelector('input');
                            let val = (parseInt(input.value) || 1) + delta;
                            if (val < minQty) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'MINIMUM QUANTITY ERROR',
                                    text: `Minimum order quantity is ${minQty} units.`,
                                    confirmButtonColor: '#f2701a'
                                });
                                return;
                            }
                            if (val > maxStock) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'STOCK LIMIT ERROR',
                                    text: `Only ${maxStock} units are available in stock.`,
                                    confirmButtonColor: '#f2701a'
                                });
                                return;
                            }
                            input.value = val;
                            processCheckoutQtyUpdate(productId, cartId, val, orderType);
                        }

                        window.handleCheckoutQtyType = function(inputEl, productId, cartId, orderType, minQty, maxStock) {
                            let val = parseInt(inputEl.value);
                            if (isNaN(val) || val < minQty) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'MINIMUM QUANTITY ERROR',
                                    text: `Minimum order quantity is ${minQty} units.`,
                                    confirmButtonColor: '#f2701a'
                                });
                                inputEl.value = minQty;
                                val = minQty;
                            } else if (val > maxStock) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'STOCK LIMIT ERROR',
                                    text: `Only ${maxStock} units are available in stock.`,
                                    confirmButtonColor: '#f2701a'
                                });
                                inputEl.value = maxStock;
                                val = maxStock;
                            }
                            processCheckoutQtyUpdate(productId, cartId, val, orderType);
                        }

                        async function processCheckoutQtyUpdate(productId, cartId, newQty, orderType) {
                            // Find the item in local orderItems array and update its quantity
                            let item = orderItems.find(i => i.id == productId);
                            if (item) {
                                item.qty = newQty;
                                
                                // Recalculate price using wholesale tiered pricing
                                let price = parseFloat(item.selling_price);
                                if (item.wholesale_prices && Array.isArray(item.wholesale_prices)) {
                                    let sortedTiers = [...item.wholesale_prices].sort((a, b) => parseInt(b.min_qty) - parseInt(a.min_qty));
                                    for (let tier of sortedTiers) {
                                        if (newQty >= parseInt(tier.min_qty)) {
                                            price = parseFloat(tier.price);
                                            break;
                                        }
                                    }
                                }
                                item.price = price;
                                item.online_shipping = price * parseFloat(item.online_shipping_pct) / 100;
                                item.cod_shipping = price * parseFloat(item.cod_shipping_pct) / 100;
                                
                                // Update item's price display in the UI list
                                const priceSpan = document.querySelector(`.product-unit-price[data-id="${productId}"]`);
                                if (priceSpan) {
                                    priceSpan.innerText = '₹' + formatMoney(price);
                                }
                            }

                            // Update the hidden quantity input for Buy Now
                            const hiddenQtyInput = document.querySelector('input[name="qty"]');
                            if (hiddenQtyInput) {
                                hiddenQtyInput.value = newQty;
                            }

                            // Update all price details and coupon values instantly in place
                            updatePricesAndTotals();

                            if (orderType === 'cart') {
                                // Background DB update for cart
                                const placeBtn = document.getElementById('placeOrderBtn');
                                const originalPlaceHtml = placeBtn ? placeBtn.innerHTML : '';
                                if (placeBtn) {
                                    placeBtn.disabled = true;
                                    placeBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> SAVING...';
                                }

                                const data = {};
                                data['quantities'] = {};
                                data['quantities'][cartId] = newQty;

                                try {
                                    const freshToken = await window.getFreshCsrfToken();
                                    await fetch('/cart/update', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': freshToken,
                                            'Accept': 'application/json'
                                        },
                                        body: JSON.stringify(data)
                                    });
                                } catch (error) {
                                    console.error('Error updating cart in database:', error);
                                } finally {
                                    if (placeBtn) {
                                        const paymentMethod = document.getElementById('paymentMethodInput').value;
                                        placeBtn.disabled = !paymentMethod;
                                        placeBtn.innerHTML = originalPlaceHtml;
                                    }
                                }
                            }
                        }

                        function updatePricesAndTotals() {
                            let newSubtotal = 0;
                            let newAdvance = 0;
                            let newOnlineShipping = 0;
                            let newCodShipping = 0;
                            let totalQty = 0;
                            
                            orderItems.forEach(i => {
                                totalQty += i.qty;
                                newSubtotal += i.price * i.qty;
                                newAdvance += i.price * i.qty * parseFloat(i.advance_percent) / 100;
                                newOnlineShipping += i.online_shipping * i.qty;
                                newCodShipping += i.cod_shipping * i.qty;
                            });
                            
                            baseSubtotal = newSubtotal;
                            baseAdvance = newAdvance;
                            onlineShipping = newOnlineShipping;
                            codShipping = newCodShipping;
                            
                            // Update display elements
                            const qtyDisplay = document.getElementById('totalQtyDisplay');
                            if (qtyDisplay) {
                                qtyDisplay.innerText = `Price (${totalQty} items)`;
                            }
                            const subtotalDisplay = document.getElementById('subtotalDisplay');
                            if (subtotalDisplay) {
                                subtotalDisplay.innerText = formatMoney(baseSubtotal);
                            }
                            
                            const codAdvPlusShip = document.getElementById('codAdvancePlusShippingDisplay');
                            if (codAdvPlusShip) {
                                codAdvPlusShip.innerText = formatMoney(baseAdvance + codShipping);
                            }
                            const codRest = document.getElementById('codRestDisplay');
                            if (codRest) {
                                codRest.innerText = formatMoney(baseSubtotal - baseAdvance);
                            }
                            const onlineTotal = document.getElementById('onlineTotalDisplay');
                            if (onlineTotal) {
                                onlineTotal.innerText = formatMoney(baseSubtotal);
                            }
                            
                            const savingsAmount = codShipping - onlineShipping;
                            const savingsPct = baseSubtotal > 0 ? (savingsAmount / baseSubtotal * 100) : 0;
                            
                            const savingsAlert = document.getElementById('shippingSavingsAlert');
                            if (savingsAlert) {
                                if (savingsAmount > 0) {
                                    savingsAlert.style.display = 'block';
                                    const savingsAmtDisp = document.getElementById('shippingSavingsAmountDisplay');
                                    if (savingsAmtDisp) {
                                        savingsAmtDisp.innerText = formatMoney(savingsAmount);
                                    }
                                    const savingsPctDisp = document.getElementById('shippingSavingsPctDisplay');
                                    if (savingsPctDisp) {
                                        savingsPctDisp.innerText = savingsPct.toFixed(1);
                                    }
                                } else {
                                    savingsAlert.style.display = 'none';
                                }
                            }
                            
                            // Update shipping based on current selected payment method
                            const currentMethod = document.getElementById('paymentMethodInput').value;
                            if (currentMethod) {
                                currentShipping = (currentMethod === 'online') ? onlineShipping : codShipping;
                                const label = document.getElementById('shippingMethodLabel');
                                if (label) {
                                    label.innerText = (currentMethod === 'online') ? 'Online Shipping Charges' : 'COD Shipping Charges';
                                }
                            }
                            
                            // Re-apply coupon or just update grand total
                            const couponInput = document.getElementById('couponInput');
                            if (couponInput && couponInput.value) {
                                applyCoupon();
                            } else {
                                updateGrandTotal();
                            }
                        }
                    </script>
@endsection