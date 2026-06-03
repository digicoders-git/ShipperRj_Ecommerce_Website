@extends('layouts.app')

@section('content')
<!-- Custom Styles for Premium FAQ Page -->
@push('styles')
<style>
    .faq-hero {
        background: linear-gradient(135deg, #111827 0%, #1F2937 100%);
        padding: 50px 0 40px 0;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 122, 24, 0.1);
    }
    .faq-hero::before {
        content: '';
        position: absolute;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(255, 122, 24, 0.12) 0%, rgba(255, 122, 24, 0) 70%);
        top: -120px;
        right: -60px;
        border-radius: 50%;
        pointer-events: none;
    }
    .faq-hero::after {
        content: '';
        position: absolute;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(242, 112, 26, 0.08) 0%, rgba(242, 112, 26, 0) 70%);
        bottom: -90px;
        left: -60px;
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
    
    /* Search Bar Design */
    .faq-search-wrapper {
        max-width: 600px;
        margin: 20px auto 0 auto;
        position: relative;
    }
    .faq-search-input {
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        padding: 16px 24px 16px 50px !important;
        font-size: 1rem !important;
        color: #ffffff !important;
        border-radius: 30px !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
    }
    .faq-search-input::placeholder {
        color: rgba(255, 255, 255, 0.5) !important;
        opacity: 1 !important;
    }
    .faq-search-input:focus {
        background: rgba(255, 255, 255, 0.12) !important;
        border-color: #f2701aff !important;
        box-shadow: 0 8px 30px rgba(242, 112, 26, 0.3) !important;
        color: #ffffff !important;
    }
    .faq-search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.5) !important;
        font-size: 1.2rem;
        pointer-events: none;
        transition: all 0.3s ease;
    }
    .faq-search-input:focus + .faq-search-icon {
        color: #f2701aff !important;
    }

    /* FAQ Item Cards */
    .faq-item-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.06);
        border-radius: 16px;
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .faq-item-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border-color: rgba(242, 112, 26, 0.15);
    }
    
    .faq-question-btn {
        width: 100%;
        text-align: left;
        background: transparent;
        border: none;
        padding: 22px 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        font-weight: 700;
        font-size: 1.05rem;
        color: #1f2937;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .faq-question-btn:focus {
        outline: none;
    }
    .faq-question-btn:hover {
        color: #f2701aff;
    }
    
    .faq-answer-collapse {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .faq-answer-body {
        padding: 0 28px 24px 28px;
        color: #4b5563;
        font-size: 0.95rem;
        line-height: 1.7;
        border-top: 1px solid rgba(0,0,0,0.02);
        padding-top: 16px;
    }
    .faq-answer-body a {
        color: #f2701aff;
        text-decoration: none;
        font-weight: 700;
        transition: opacity 0.2s ease;
    }
    .faq-answer-body a:hover {
        opacity: 0.85;
    }
    
    .faq-icon-arrow {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(242, 112, 26, 0.05);
        color: #f2701aff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
    }
    
    /* Open State */
    .faq-item-card.open {
        border-color: rgba(242, 112, 26, 0.25);
        box-shadow: 0 12px 30px rgba(242, 112, 26, 0.06);
    }
    .faq-item-card.open .faq-question-btn {
        color: #f2701aff;
    }
    .faq-item-card.open .faq-icon-arrow {
        transform: rotate(180deg);
        background: #f2701aff;
        color: #fff;
    }
    
    /* Contact CTA Cards */
    .cta-card {
        background: linear-gradient(135deg, #111827 0%, #1F2937 100%);
        border: 1px solid rgba(255, 122, 24, 0.15);
        border-radius: 20px;
        padding: 40px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }
    .cta-card::before {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255, 122, 24, 0.1) 0%, rgba(255, 122, 24, 0) 70%);
        bottom: -80px;
        right: -80px;
        pointer-events: none;
    }

    /* Highlight badges inside answers */
    .highlight-badge {
        background: rgba(242, 112, 26, 0.08);
        color: #f2701aff;
        padding: 3px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.85rem;
    }
</style>
@endpush

<!-- FAQs Hero Section -->
<div class="faq-hero text-center text-white">
    <div class="container">
        <div class="hero-badge mb-3">
            <i class="bi bi-patch-question-fill"></i> Help Center
        </div>
        <h1 class="display-4 fw-black uppercase tracking-tight mb-3">Frequently Asked <span class="text-primary">Questions</span></h1>
        <p class="text-white-50 lead mx-auto" style="max-width: 600px; font-weight: 500;">
            Find quick answers to common queries about B2B orders, delivery support, seller partner setup, and more.
        </p>

        <!-- Live Search Bar -->
        <div class="faq-search-wrapper">
            <input type="text" id="faqSearchInput" class="form-control faq-search-input shadow-none" placeholder="Search questions or keywords...">
            <i class="bi bi-search faq-search-icon"></i>
        </div>
    </div>
</div>

<!-- Main FAQ Content Section -->
<div class="container py-5 my-3">
    <div class="row">
        <!-- FAQs Accordions Column -->
        <div class="col-lg-10 offset-lg-1">
            <div class="faq-accordion-container">
                @forelse($faqs as $faq)
                    <div class="faq-item-card">
                        <button class="faq-question-btn" onclick="toggleFaq(this)">
                            <span>{{ $loop->iteration }}. {{ $faq->question }}</span>
                            <div class="faq-icon-arrow"><i class="bi bi-chevron-down"></i></div>
                        </button>
                        <div class="faq-answer-collapse">
                            <div class="faq-answer-body">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-patch-question text-muted mb-3" style="font-size: 2.5rem;"></i>
                        <h5 class="fw-bold">No FAQs Available</h5>
                        <p class="text-muted">Please check back later or contact support if you need help.</p>
                    </div>
                @endforelse

                <!-- No Results State -->
                <div id="faqNoResults" class="text-center py-5 d-none">
                    <i class="bi bi-search text-muted mb-3" style="font-size: 2.5rem;"></i>
                    <h5 class="fw-bold">No FAQs Found</h5>
                    <p class="text-muted">We couldn't find any questions matching your query. Try searching other keywords.</p>
                </div>
            </div>
        </div>

        <!-- Contact CTA Section -->
        <div class="col-lg-10 offset-lg-1 mt-5">
            <div class="cta-card text-center text-white">
                <h3 class="fw-black uppercase tracking-tight mb-2">Still Have Questions?</h3>
                <p class="text-white-50 mb-4 mx-auto" style="max-width: 550px;">
                    Our friendly customer service team is always here to assist you. Get in touch with us directly via phone, email or whatsapp.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="tel:+917088213888" class="btn btn-premium px-4 py-2 d-inline-flex align-items-center gap-2" style="border-radius: 10px !important;">
                        <i class="bi bi-telephone-fill"></i> Call Us
                    </a>
                    <a href="mailto:shoppingclubindia1@gmail.com" class="btn btn-outline-light px-4 py-2 d-inline-flex align-items-center gap-2" style="font-weight: 700; border-radius: 10px !important; border-color: rgba(255, 255, 255, 0.25) !important;">
                        <i class="bi bi-envelope-fill"></i> Email Us
                    </a>
                    <a href="https://wa.me/917088213888" target="_blank" class="btn btn-success px-4 py-2 d-inline-flex align-items-center gap-2" style="background: #25d366; border: none; font-weight: 700; border-radius: 10px !important;">
                        <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Live Vanilla Javascript logic for Filter and Accordion toggles -->
@push('scripts')
<script>
    // Toggle FAQ Collapse
    function toggleFaq(btn) {
        const card = btn.closest('.faq-item-card');
        const collapse = card.querySelector('.faq-answer-collapse');
        const isOpen = card.classList.contains('open');

        // Close all other opened FAQs for pristine clean UX
        document.querySelectorAll('.faq-item-card.open').forEach(openCard => {
            if (openCard !== card) {
                openCard.classList.remove('open');
                openCard.querySelector('.faq-answer-collapse').style.maxHeight = null;
            }
        });

        if (isOpen) {
            card.classList.remove('open');
            collapse.style.maxHeight = null;
        } else {
            card.classList.add('open');
            collapse.style.maxHeight = collapse.scrollHeight + "px";
        }
    }

    // Realtime Search Functionality
    document.addEventListener('DOMContentLoaded', function () {
        const faqCards = document.querySelectorAll('.faq-item-card');
        const searchInput = document.getElementById('faqSearchInput');
        const noResults = document.getElementById('faqNoResults');

        searchInput.addEventListener('input', function () {
            const searchQuery = this.value.toLowerCase().trim();
            let visibleCount = 0;

            faqCards.forEach(card => {
                const question = card.querySelector('.faq-question-btn span').textContent.toLowerCase();
                const answer = card.querySelector('.faq-answer-body').textContent.toLowerCase();

                const matchesSearch = (question.includes(searchQuery) || answer.includes(searchQuery));

                if (matchesSearch) {
                    card.classList.remove('d-none');
                    visibleCount++;
                } else {
                    card.classList.add('d-none');
                    card.classList.remove('open');
                    card.querySelector('.faq-answer-collapse').style.maxHeight = null;
                }
            });

            if (visibleCount === 0) {
                noResults.classList.remove('d-none');
            } else {
                noResults.classList.add('d-none');
            }
        });
    });
</script>
@endpush
@endsection
