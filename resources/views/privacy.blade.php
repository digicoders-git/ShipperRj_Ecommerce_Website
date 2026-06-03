@extends('layouts.app')

@section('content')
<!-- Custom Styles for Premium Privacy Policy -->
@push('styles')
<style>
    .privacy-hero {
        background: linear-gradient(135deg, #111827 0%, #1F2937 100%);
        padding: 80px 0;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 122, 24, 0.1);
    }
    .privacy-hero::before {
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
    .privacy-hero::after {
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
    .privacy-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 0;
        padding: 35px;
        margin-bottom: 30px;
        position: relative;
        scroll-margin-top: 100px;
    }
    .privacy-card-icon {
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
    .privacy-list {
        list-style: none;
        padding-left: 0;
    }
    .privacy-list li {
        position: relative;
        padding-left: 28px;
        margin-bottom: 12px;
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
    }
    .privacy-list li::before {
        content: "\f285"; /* Bootstrap Icon code for bi-chevron-right */
        font-family: "bootstrap-icons";
        position: absolute;
        left: 4px;
        top: 2px;
        color: var(--primary);
        font-size: 0.85rem;
        font-weight: 800;
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

<section class="privacy-hero text-center">
    <div class="container">
        <span class="hero-badge mb-3">
            <i class="bi bi-shield-lock"></i> PRIVACY POLICY
        </span>
        <h1 class="display-4 fw-black text-white mb-3" style="letter-spacing: -1.5px;">
            Privacy & Data <span class="text-primary" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Protection</span>
        </h1>
        <p class="text-white-50 fs-5 mb-0 mx-auto" style="max-width: 700px; font-weight: 500;">
            Your privacy and data security are very important to us. Learn how we handle your information securely at <strong>SCIB2B</strong>.
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
                <nav id="privacy-toc" class="privacy-toc-list">
                    <a href="#welcome" class="toc-link active"><i class="bi bi-shield-fill-check"></i> Welcome</a>
                    <a href="#info-collection" class="toc-link"><i class="bi bi-database-add"></i> 1. Information We Collect</a>
                    <a href="#info-usage" class="toc-link"><i class="bi bi-gear-fill"></i> 2. How We Use Information</a>
                    <a href="#data-protection" class="toc-link"><i class="bi bi-shield-shaded"></i> 3. Data Protection & Security</a>
                    <a href="#payment-gateways" class="toc-link"><i class="bi bi-credit-card-2-front-fill"></i> 4. Payment Security</a>
                    <a href="#cookies-policy" class="toc-link"><i class="bi bi-cookie"></i> 5. Cookies Policy</a>
                    <a href="#third-party" class="toc-link"><i class="bi bi-people-fill"></i> 6. Third-Party Disclosures</a>
                    <a href="#user-rights" class="toc-link"><i class="bi bi-person-bounding-box"></i> 7. Your Privacy Rights</a>
                    <a href="#policy-updates" class="toc-link"><i class="bi bi-clock-history"></i> 8. Policy Updates</a>
                    <a href="#contact-support" class="toc-link"><i class="bi bi-telephone-fill"></i> 9. Contact Support</a>
                </nav>
            </div>
        </div>

        <!-- Document Content -->
        <div class="col-lg-9">
            <!-- Welcome Introduction -->
            <div id="welcome" class="privacy-card scroll-margin-top shadow-sm">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="privacy-card-icon">
                        <i class="bi bi-shield-fill-check"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">Welcome to SCIB2B Privacy Policy</h3>
                </div>
                <p class="text-secondary leading-relaxed mb-0" style="font-size: 1.05rem;">
                    At <strong>SCIB2B</strong> (owned and operated by <strong>Shopping Club India</strong>), we are committed to respecting your online privacy. We recognize your need for appropriate protection and management of any personally identifiable information you share with us. This policy details how we collect, store, utilize, and secure your personal data.
                </p>
            </div>

            <!-- 1. Information We Collect -->
            <div id="info-collection" class="privacy-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="privacy-card-icon">
                        <i class="bi bi-database-fill-add"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">1. Information We Collect</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    To process your wholesale B2B orders and provide support, we collect the following details when you register, log in, or place an order:
                </p>
                <ul class="privacy-list">
                    <li><strong class="text-dark">Identity & Contact Data:</strong> Name, business name, active mobile number, and email address.</li>
                    <li><strong class="text-dark">Shipping & Billing Addresses:</strong> Delivery locations and pin codes to arrange secure logistics.</li>
                    <li><strong class="text-dark">Authentication Data:</strong> Secure password hashes, OAuth login details (e.g. via secure Google callback).</li>
                    <li><strong class="text-dark">Order History & Invoices:</strong> History of products purchased, invoice receipts, and wallet transaction logs.</li>
                </ul>
            </div>

            <!-- 2. How We Use Your Information -->
            <div id="info-usage" class="privacy-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="privacy-card-icon">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">2. How We Use Your Information</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    Your personal information is processed strictly for the following purposes:
                </p>
                <ul class="privacy-list">
                    <li>To verify and activate your B2B wholesale account.</li>
                    <li>To fulfill, pack, ship, and deliver your orders via our courier partners.</li>
                    <li>To credit refund amounts or claims directly into your business wallet dashboard.</li>
                    <li>To handle support inquiries, complaint resolutions, and replacement requests.</li>
                    <li>To prevent unauthorized, fake, or fraudulent activities on the platform.</li>
                </ul>
            </div>

            <!-- 3. Data Protection & Security -->
            <div id="info-usage" class="privacy-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="privacy-card-icon">
                        <i class="bi bi-shield-shaded"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">3. Data Protection & Security</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    At SCIB2B, customer privacy and data security are very important to us:
                </p>
                <ul class="privacy-list">
                    <li>All customer data is safe, secure, and encrypted using modern cryptographic protocols.</li>
                    <li>We do not sell, lease, trade, or misuse customer information with any external marketing agencies.</li>
                    <li>Access to your personal data is restricted to authorized employees and managers who require it to fulfill logistics and customer support duties.</li>
                </ul>
            </div>

            <!-- 4. Payment Security -->
            <div id="payment-gateways" class="privacy-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="privacy-card-icon">
                        <i class="bi bi-credit-card-2-front-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">4. Payment Security</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    All payment transactions on our platform are processed securely:
                </p>
                <ul class="privacy-list">
                    <li>We do not store your raw credit card numbers, CVV codes, net banking passwords, or UPI pins on our servers.</li>
                    <li>All payments are securely handled through PCI-DSS compliant payment gateways (such as <strong class="text-dark">Razorpay</strong>).</li>
                    <li>Wallet balances and digital transactions are logged securely and can only be used by you for purchases or approved claims on SCIB2B.</li>
                </ul>
            </div>

            <!-- 5. Cookies Policy -->
            <div id="cookies-policy" class="privacy-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="privacy-card-icon">
                        <i class="bi bi-cookie"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">5. Cookies Policy</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    Cookies are small files stored on your browser to enhance usability:
                </p>
                <ul class="privacy-list">
                    <li>We use cookies to maintain your active shopping cart state and keep you logged in securely.</li>
                    <li>CSRF cookies are used to protect your session from malicious request forgery.</li>
                    <li>You can choose to disable cookies in your browser settings, but please note that some features (like add to cart or checkout) may not function properly without them.</li>
                </ul>
            </div>

            <!-- 6. Third-Party Disclosures -->
            <div id="third-party" class="privacy-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="privacy-card-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">6. Third-Party Disclosures</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    We share details with external entities only when essential to deliver our services:
                </p>
                <ul class="privacy-list">
                    <li><strong class="text-dark">Logistics Partners:</strong> Your address and contact number are shared with third-party courier services to facilitate delivery.</li>
                    <li><strong class="text-dark">Payment Gateways:</strong> Order tokens are shared with Razorpay for secure checkout verification.</li>
                    <li><strong class="text-dark">Legal Compliance:</strong> We may disclose information if required to do so by law or government regulatory authorities.</li>
                </ul>
            </div>

            <!-- 7. Your Privacy Rights -->
            <div id="user-rights" class="privacy-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="privacy-card-icon">
                        <i class="bi bi-person-bounding-box"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">7. Your Privacy Rights</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    As a valued client of Shopping Club India, you have full control over your personal data:
                </p>
                <ul class="privacy-list">
                    <li>You can update your profile name, email, and password through the customer dashboard.</li>
                    <li>You can manage, edit, or delete your saved shipping addresses in the dashboard at any time.</li>
                    <li>To delete your account or inquire about your personal data logs, please contact our support team.</li>
                </ul>
            </div>

            <!-- 8. Policy Updates -->
            <div id="policy-updates" class="privacy-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="privacy-card-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">8. Policy Updates</h3>
                </div>
                <p class="text-secondary leading-relaxed mb-0">
                    We reserve the right to modify this privacy policy at any time to reflect operational, legal, or regulatory changes. Any updates will be published directly on this page. We encourage you to review this policy periodically.
                </p>
            </div>

            <!-- 9. Contact Support -->
            <div id="contact-support" class="privacy-card scroll-margin-top">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="privacy-card-icon">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <h3 class="fw-black text-dark mb-0" style="letter-spacing: -0.5px;">9. Contact Support</h3>
                </div>
                <p class="text-secondary leading-relaxed">
                    If you have questions about this privacy policy, data practices, or need support:
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
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Custom Intersection Observer for Scrollspy Active States in TOC
    document.addEventListener('DOMContentLoaded', () => {
        const sections = document.querySelectorAll('.privacy-card');
        const navLinks = document.querySelectorAll('.toc-link');

        // Sticky parent self-healing debugger & auto-fixer
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
                            
                            // Smoothly scroll the link to the center of the TOC sidebar container
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
