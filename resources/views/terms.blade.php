@extends('layouts.app')

@section('content')
<!-- Custom Styles for Premium Terms & Conditions -->
@push('styles')
<style>
    .terms-hero {
        background: linear-gradient(135deg, #111827 0%, #1F2937 100%);
        padding: 80px 0;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 122, 24, 0.1);
    }
    .terms-hero::before {
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
    .terms-hero::after {
        content: '';
        position: absolute;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(19, 136, 8, 0.1) 0%, rgba(19, 136, 8, 0) 70%);
        bottom: -80px;
        left: -50px;
        border-radius: 50%;
        pointer-events: none;
    }
    .hero-badge {
        background: rgba(255, 122, 24, 0.1);
        border: 1px solid rgba(255, 122, 24, 0.2);
        color: var(--primary);
        font-family: var(--font-heading);
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 8px 16px;
        border-radius: 0;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .toc-sticky {
        position: sticky;
        top: 120px;
        z-index: 1000;
        max-height: calc(100vh - 160px);
        overflow-y: auto;
    }
    /* Compact custom scrollbar for toc */
    .toc-sticky::-webkit-scrollbar {
        width: 3px;
    }
    .toc-sticky::-webkit-scrollbar-track {
        background: transparent;
    }
    .toc-sticky::-webkit-scrollbar-thumb {
        background: rgba(255, 122, 24, 0.15);
    }
    .toc-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 16px;
        border-radius: 0;
        color: var(--text-muted);
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(0, 0, 0, 0.05);
        margin-bottom: 8px;
        transition: all 0.2s ease;
    }
    .toc-link:hover {
        color: var(--primary);
        background: #ffffff;
        border-color: rgba(255, 122, 24, 0.25);
    }
    .toc-link.active {
        color: #ffffff;
        background: var(--primary-gradient);
        border-color: transparent;
    }
    .terms-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 0;
        padding: 35px;
        margin-bottom: 30px;
        position: relative;
        scroll-margin-top: 100px;
    }
    .terms-card.warning-card {
        background: #fffdfb;
        border: 2px solid #ff4747;
    }
    .terms-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 0;
        background: var(--primary-soft);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }
    .terms-card.warning-card .terms-card-icon {
        background: rgba(255, 71, 71, 0.08);
        color: #ff4747;
    }
    .terms-list {
        list-style: none;
        padding-left: 0;
    }
    .terms-list li {
        position: relative;
        padding-left: 28px;
        margin-bottom: 12px;
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
    }
    .terms-list li::before {
        content: "\f285"; /* Bootstrap Icon code for bi-chevron-right */
        font-family: "bootstrap-icons";
        position: absolute;
        left: 4px;
        top: 2px;
        color: var(--primary);
        font-size: 0.85rem;
        font-weight: 800;
    }
    .terms-card.warning-card .terms-list li::before {
        content: "\f33a"; /* bi-exclamation-triangle */
        color: #ff4747;
    }
    .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-top: 20px;
    }
    .contact-item-card {
        background: var(--light);
        border: 1px solid rgba(0, 0, 0, 0.05);
        padding: 20px;
        border-radius: 0;
        display: flex;
        align-items: center;
        gap: 16px;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .contact-item-card:hover {
        background: #ffffff;
        border-color: rgba(255, 122, 24, 0.25);
    }
    .contact-item-card i {
        font-size: 1.5rem;
        color: var(--primary);
    }
</style>
@endpush

<section class="terms-hero text-center">
    <div class="container">
        <span class="hero-badge mb-3">
            <i class="bi bi-shield-check"></i> LEGAL DOCUMENT
        </span>
        <h1 class="display-4 fw-black text-white mb-3" style="letter-spacing: -1.5px;">
            Terms & <span class="text-primary" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Conditions</span>
        </h1>
        <p class="text-white-50 fs-5 mb-0 mx-auto" style="max-width: 700px; font-weight: 500;">
            Welcome to <strong>SCIB2B by Shopping Club India</strong>. These terms govern your use of our platform and secure B2B services.
        </p>
    </div>
</section>

<div class="container py-5">
    <div class="row align-items-stretch">
        <!-- Sidebar Navigation (TOC) -->
        <div class="col-lg-3 d-none d-lg-block">
            <div class="toc-sticky">
                <h5 class="fw-black text-dark mb-3 px-2" style="font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase;">
                    <i class="bi bi-list-nested text-primary me-2"></i> Document Sections
                </h5>
                <nav id="terms-toc" class="terms-toc-list">
                    <a href="#welcome" class="toc-link active"><i class="bi bi-hand-thumbs-up"></i> Welcome</a>
                    <a href="#company-info" class="toc-link"><i class="bi bi-building"></i> 1. Company Info</a>
                    <a href="#min-order" class="toc-link"><i class="bi bi-cart-check"></i> 2. Min Order Value</a>
                    <a href="#product-info" class="toc-link"><i class="bi bi-info-circle"></i> 3. Product Info</a>
                    <a href="#orders-payments" class="toc-link"><i class="bi bi-credit-card"></i> 4. Orders & Payments</a>
                    <a href="#shipping-delivery" class="toc-link"><i class="bi bi-truck"></i> 5. Shipping & Delivery</a>
                    <a href="#unboxing-video" class="toc-link"><i class="bi bi-camera-video-fill text-danger"></i> 6. Unboxing Video</a>
                    <a href="#replacement-policy" class="toc-link"><i class="bi bi-arrow-repeat"></i> 7. 2-Day Replacement</a>
                    <a href="#wallet-claims" class="toc-link"><i class="bi bi-wallet2"></i> 8. Claim & Wallet</a>
                    <a href="#privacy-policy" class="toc-link"><i class="bi bi-shield-lock-fill"></i> 9. Privacy Policy</a>
                    <a href="#user-resp" class="toc-link"><i class="bi bi-person-x"></i> 10. User Conduct</a>
                    <a href="#intellectual-prop" class="toc-link"><i class="bi bi-c-circle-fill"></i> 11. Intellectual Property</a>
                    <a href="#limitation-liability" class="toc-link"><i class="bi bi-exclamation-triangle"></i> 12. Liability Limits</a>
                    <a href="#changes-terms" class="toc-link"><i class="bi bi-pencil-square"></i> 13. Changes to Terms</a>
                    <a href="#contact-info" class="toc-link"><i class="bi bi-telephone-fill"></i> 14. Contact Support</a>
                    <a href="#acceptance-terms" class="toc-link"><i class="bi bi-check2-circle"></i> 15. Agreement</a>
                </nav>
            </div>
        </div>

        <!-- Document Content -->
        <div class="col-lg-9">
            <!-- Welcome Introduction -->
            <div id="welcome" class="terms-card scroll-margin-top shadow-sm">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="terms-card-icon">
                        <i class="bi bi-hand-thumbs-up-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">Welcome to SCIB2B</h3>
                </div>
                <p class="text-secondary leading-relaxed mb-0" style="font-size: 1.05rem;">
                    These Terms & Conditions govern your use of our website and B2B services. By accessing <a href="https://scib2b.com" target="_blank" class="fw-bold text-primary text-decoration-none">scib2b.com</a> or placing an order on the portal, you agree to follow and be bound by all the policies and terms outlined in this document. Please read them carefully before conducting business.
                </p>
            </div>

            <!-- 1. Company Information -->
            <div id="company-info" class="terms-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="terms-card-icon">
                        <i class="bi bi-building-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">1. Company Information</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    This online B2B website is owned and operated by <strong class="text-dark">Shopping Club India</strong>.
                </p>
                <div class="d-flex align-items-center gap-2 mt-3 bg-light p-3 rounded-0 border border-light">
                    <i class="bi bi-globe2 text-primary fs-5 me-2"></i>
                    <div>
                        <span class="d-block xx-small text-secondary fw-bold uppercase">OFFICIAL WEBSITE</span>
                        <a href="https://scib2b.com" target="_blank" class="fw-bold text-dark text-decoration-none hover-primary">scib2b.com</a>
                    </div>
                </div>
            </div>

            <!-- 2. Minimum Order Value -->
            <div id="min-order" class="terms-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="terms-card-icon">
                        <i class="bi bi-cart-check-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">2. Minimum Order Value</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    To maintain efficient operational standards and cater exclusively to wholesale/business clients:
                </p>
                <ul class="terms-list">
                    <li>The minimum order value on our website is <strong class="text-dark">₹2000</strong>.</li>
                    <li>Orders below ₹2000 may not be accepted or processed.</li>
                </ul>
            </div>

            <!-- 3. Product Information -->
            <div id="product-info" class="terms-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="terms-card-icon">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">3. Product Information</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    We try our best to provide accurate details, but please note:
                </p>
                <ul class="terms-list">
                    <li>We try our best to provide accurate product details, pricing, and images.</li>
                    <li>Product colors or appearance may vary slightly due to lighting, screen settings, or packaging updates.</li>
                    <li>Product availability depends on stock status.</li>
                </ul>
            </div>

            <!-- 4. Orders & Payments -->
            <div id="orders-payments" class="terms-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="terms-card-icon">
                        <i class="bi bi-credit-card-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">4. Orders & Payments</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    Fulfillment and security parameters governing your purchase orders:
                </p>
                <ul class="terms-list">
                    <li>Orders are confirmed only after successful payment verification.</li>
                    <li>We reserve the right to cancel suspicious, fake, or fraudulent orders at any time.</li>
                    <li>Customers must provide correct shipping address and contact details while placing orders.</li>
                </ul>
            </div>

            <!-- 5. Shipping & Delivery -->
            <div id="shipping-delivery" class="terms-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="terms-card-icon">
                        <i class="bi bi-truck-flatbed"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">5. Shipping & Delivery</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    Our logistics operations are governed by the following clauses:
                </p>
                <ul class="terms-list">
                    <li>Delivery time may vary depending on location and courier availability.</li>
                    <li>In case of parcel delay, customers are requested to wait patiently as shipping is handled by third-party courier partners.</li>
                    <li>We are not responsible for delays caused by courier companies, weather conditions, transport issues, or unexpected situations.</li>
                </ul>
            </div>

            <!-- 6. Mandatory Unboxing Video Policy -->
            <div id="unboxing-video" class="terms-card warning-card scroll-margin-top">
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="terms-card-icon text-danger bg-danger bg-opacity-10">
                            <i class="bi bi-camera-video-fill"></i>
                        </div>
                        <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">6. Mandatory Unboxing Video Policy</h3>
                    </div>
                    <span class="badge bg-danger text-white px-3 py-2 rounded-0 fw-bold xx-small uppercase tracking-widest">
                        MANDATORY
                    </span>
                </div>
                <p class="text-secondary leading-relaxed fw-medium">
                    Customers must record a complete unboxing video while opening the parcel.
                </p>
                <div class="bg-danger bg-opacity-10 border border-danger border-opacity-20 p-4 rounded-0 mb-4">
                    <p class="text-dark small mb-3 fw-bold"><i class="bi bi-exclamation-octagon-fill text-danger me-2"></i> The video must clearly show:</p>
                    <ul class="terms-list text-secondary mb-0">
                        <li>Sealed package</li>
                        <li>Opening process</li>
                        <li>Product condition inside the box</li>
                    </ul>
                </div>
                <p class="text-danger small mb-0 fw-bold">
                    <i class="bi bi-x-circle-fill me-1"></i> Without a proper unboxing video, no claim for missing item, damaged item, or wrong product will be accepted.
                </p>
            </div>

            <!-- 7. 2-Day Replacement Policy -->
            <div id="replacement-policy" class="terms-card scroll-margin-top">
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="terms-card-icon">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">7. 2-Day Replacement Policy</h3>
                    </div>
                    <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-0 fw-bold xx-small uppercase tracking-widest">
                        2-DAY WINDOW
                    </span>
                </div>
                <p class="text-secondary leading-relaxed">
                    Replacement guidelines for damaged or defective items:
                </p>
                <ul class="terms-list">
                    <li>We provide a <strong class="text-dark">2-Day Replacement Policy</strong> for damaged, defective, or incorrect products only.</li>
                    <li>Customers must report the issue within 2 days of delivery.</li>
                    <li>Products should be unused and returned with original packaging.</li>
                    <li>Replacement requests without proper proof may be rejected.</li>
                </ul>
            </div>

            <!-- 8. Claim & Wallet Policy -->
            <div id="wallet-claims" class="terms-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="terms-card-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">8. Claim & Wallet Policy</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    Refunds and claims resolution:
                </p>
                <ul class="terms-list">
                    <li>If any claim, replacement, or refund is approved by the company, the amount may be credited to the customer wallet/balance account as per company policy.</li>
                    <li>Direct bank refund may not be applicable in certain cases.</li>
                </ul>
            </div>

            <!-- 9. Privacy Policy -->
            <div id="privacy-policy" class="terms-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="terms-card-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">9. Privacy Policy</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    At <a href="https://scib2b.com" target="_blank" class="fw-bold text-primary text-decoration-none">SCIB2B</a>, customer privacy and data security are very important to us.
                </p>
                <ul class="terms-list">
                    <li>All customer data is safe and secure with us.</li>
                    <li>We do not sell, share, or misuse customer information with any third party.</li>
                    <li>Customer information is used only for order processing, delivery, and support purposes.</li>
                    <li>Payment transactions are processed through secure payment gateways.</li>
                </ul>
            </div>

            <!-- 10. User Responsibilities -->
            <div id="user-resp" class="terms-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="terms-card-icon">
                        <i class="bi bi-person-exclamation"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">10. User Responsibilities</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    By using our website, you agree that you will not:
                </p>
                <ul class="terms-list">
                    <li>Use the website for illegal activities.</li>
                    <li>Attempt to hack or damage the website.</li>
                    <li>Provide false information.</li>
                    <li>Misuse offers, policies, or services.</li>
                </ul>
            </div>

            <!-- 11. Intellectual Property -->
            <div id="intellectual-prop" class="terms-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="terms-card-icon">
                        <i class="bi bi-c-circle-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">11. Intellectual Property</h3>
                </div>
                <p class="text-secondary leading-relaxed mb-0">
                    All website content including logos, banners, images, text, graphics, and designs are the property of <strong class="text-dark">Shopping Club India</strong> and may not be copied or reused without written permission.
                </p>
            </div>

            <!-- 12. Limitation of Liability -->
            <div id="limitation-liability" class="terms-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="terms-card-icon">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">12. Limitation of Liability</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    Shopping Club India is not responsible for:
                </p>
                <ul class="terms-list">
                    <li>Courier delays caused by third-party shipping partners.</li>
                    <li>Customer misuse of products.</li>
                    <li>Temporary website downtime.</li>
                    <li>Incorrect shipping information submitted by customers.</li>
                </ul>
            </div>

            <!-- 13. Changes to Terms -->
            <div id="changes-terms" class="terms-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="terms-card-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">13. Changes to Terms</h3>
                </div>
                <p class="text-secondary leading-relaxed mb-0">
                    We reserve the right to update or modify these Terms & Conditions at any time without prior notice.
                </p>
            </div>

            <!-- 14. Contact Information -->
            <div id="contact-info" class="terms-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="terms-card-icon">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">14. Contact Information</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    For support or business inquiries:
                </p>
                <p class="text-dark fw-bold mb-3"><i class="bi bi-building me-2 text-primary"></i> Shopping Club India</p>
                <div class="contact-grid">
                    <a href="https://scib2b.com" target="_blank" class="contact-item-card">
                        <i class="bi bi-globe"></i>
                        <div>
                            <span class="d-block xx-small text-secondary fw-bold uppercase">Website</span>
                            <span class="d-block text-dark fw-bold small">scib2b.com</span>
                        </div>
                    </a>
                    <a href="tel:+917088213888" class="contact-item-card">
                        <i class="bi bi-telephone"></i>
                        <div>
                            <span class="d-block xx-small text-secondary fw-bold uppercase">Phone</span>
                            <span class="d-block text-dark fw-bold small">+91 70882 13888</span>
                        </div>
                    </a>
                    <a href="mailto:shoppingclubindia1@gmail.com" class="contact-item-card">
                        <i class="bi bi-envelope"></i>
                        <div>
                            <span class="d-block xx-small text-secondary fw-bold uppercase">Email Support</span>
                            <span class="d-block text-dark fw-bold small text-truncate" style="max-width: 170px;">shoppingclubindia1@gmail.com</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- 15. Acceptance of Terms -->
            <div id="acceptance-terms" class="terms-card scroll-margin-top bg-gradient-primary border-0 text-white p-5">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="terms-card-icon bg-white text-primary">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                    <h3 class="fw-black text-white mb-0" style="letter-spacing: -0.5px;">15. Acceptance of Terms</h3>
                </div>
                <p class="text-white opacity-90 mb-4 fs-5" style="line-height: 1.6; font-weight: 500;">
                    By using <a href="https://scib2b.com" target="_blank" class="text-white fw-bold text-decoration-underline">SCIB2B</a> or placing an order, you confirm that you have read, understood, and agreed to all Terms & Conditions mentioned above.
                </p>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-patch-check-fill text-white fs-4"></i>
                    <span class="small fw-bold uppercase tracking-widest text-white">Officially Agreed & Accepted</span>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    // Custom Intersection Observer for Scrollspy Active States in TOC
    document.addEventListener('DOMContentLoaded', () => {
        const sections = document.querySelectorAll('.terms-card');
        const navLinks = document.querySelectorAll('.toc-link');

        // Sticky parent self-healing debugger & auto-fixer
        // Checks all parent elements for overflow: hidden/auto which break position: sticky
        // and automatically overrides them to allow sticky positioning to work natively.
        const stickyEl = document.querySelector('.toc-sticky');
        if (stickyEl) {
            let parent = stickyEl.parentElement;
            while (parent && parent !== document.documentElement) {
                const style = window.getComputedStyle(parent);
                const overflowX = style.getPropertyValue('overflow-x');
                const overflowY = style.getPropertyValue('overflow-y');
                const overflow = style.getPropertyValue('overflow');
                
                if (
                    (overflowX !== 'visible' && overflowX !== 'clip') ||
                    (overflowY !== 'visible' && overflowY !== 'clip') ||
                    (overflow !== 'visible' && overflow !== 'clip')
                ) {
                    console.log('Fixed sticky-breaking ancestor:', parent.tagName, parent.className);
                    if (parent.tagName === 'BODY' || parent.tagName === 'HTML') {
                        parent.style.overflowX = 'clip';
                    } else {
                        parent.style.overflow = 'visible';
                    }
                }
                parent = parent.parentElement;
            }
        }

        const observerOptions = {
            root: null,
            rootMargin: '-10% 0px -75% 0px',
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    navLinks.forEach(link => {
                        if (link.getAttribute('href') === `#${id}`) {
                            link.classList.add('active');
                            
                            // Smoothly scroll the link to the center of the TOC sidebar container ONLY
                            const container = document.querySelector('.toc-sticky');
                            if (container) {
                                const containerTop = container.getBoundingClientRect().top;
                                const linkTop = link.getBoundingClientRect().top;
                                const relativeTop = linkTop - containerTop;
                                container.scrollTo({
                                    top: container.scrollTop + relativeTop - (container.clientHeight / 2),
                                    behavior: 'smooth'
                                });
                            }
                        } else {
                            link.classList.remove('active');
                        }
                    });
                }
            });
        }, observerOptions);

        sections.forEach(section => {
            observer.observe(section);
        });

        // Smooth scroll adjustment for anchor links to handle sticky header offset
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.getAttribute('href');
                const targetSection = document.querySelector(targetId);
                if (targetSection) {
                    const headerHeight = document.querySelector('.main-header')?.offsetHeight || 80;
                    const elementPosition = targetSection.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.scrollY - headerHeight - 20;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection
