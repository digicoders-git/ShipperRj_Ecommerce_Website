@extends('layouts.app')

@section('title', 'Order Placed Successful')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="p-5 rounded-5 shadow-premium bg-white animate-fade-in border-0">
                    <div class="mb-4">
                        <div class="display-1 text-success mb-3 pulse-success">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <h1 class="fw-black mb-1">Order Successfully!</h1>
                        <p class="text-secondary opacity-75 lead">Your order has been confirmed and is being processed for
                            delivery.</p>
                    </div>

                    <div class="row g-4 mb-5 text-start justify-content-center">
                        <div class="col-md-5">
                            <div class="p-4 rounded-4 bg-light border-0">
                                <label
                                    class="xx-small fw-black text-secondary uppercase tracking-widest mb-1 d-block opacity-50">Transaction
                                    Status</label>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-shield-check text-success"></i>
                                    <span class="fw-black">Payment Confirmed</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3 justify-content-center pt-3">
                        @if(request()->order_id)
                            <a href="{{ route('order.invoice', request()->order_id) }}"
                                class="btn btn-dark btn-lg px-5 rounded-pill fw-black shadow-lg border-0 transform-transition hover-scale">
                                <i class="bi bi-file-earmark-pdf me-2"></i> DOWNLOAD INVOICE
                            </a>
                        @endif
                        <a href="{{ route('orders') }}"
                            class="btn btn-primary bg-gradient-primary btn-lg px-5 rounded-pill fw-black shadow-lg border-0 transform-transition hover-scale">
                            VIEW MY ORDERS
                        </a>
                        <a href="{{ url('/') }}"
                            class="btn btn-outline-light border text-dark btn-lg px-5 rounded-pill fw-black shadow-sm transform-transition hover-scale">
                            CONTINUE SHOPPING
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 1s cubic-bezier(0.165, 0.84, 0.44, 1) both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pulse-success {
            animation: pulseS 2s infinite;
        }

        @keyframes pulseS {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
@endsection