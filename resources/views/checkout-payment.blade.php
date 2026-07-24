@extends('layouts.app')

@section('title', 'Pay Now')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="card border-0 shadow-premium p-5 rounded-5 animate-fade-in">
                    <div class="mb-4">
                        <div class="display-1 text-primary mb-3">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <h2 class="fw-black mb-1">Secure Payment</h2>
                        <p class="text-secondary small">Order ID: <b>#{{ $order->order_number }}</b></p>
                    </div>

                    <div class="bg-light p-4 rounded-4 mb-4 text-start">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary small fw-bold">Upfront Payment Required</span>
                            <span
                                class="fw-black h4 mb-0 text-primary">₹{{ number_format($order->prepaid_amount, 2) }}</span>
                        </div>
                        <div
                            class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top border-white border-opacity-50">
                            <div class="xx-small text-muted uppercase tracking-widest fw-black">Wallet Balance: <b
                                    class="text-dark">₹{{ number_format(Auth::user()->wallet_balance, 2) }}</b></div>
                            @if(Auth::user()->wallet_balance >= $order->prepaid_amount)
                                <span class="badge bg-success-soft text-success xx-small fw-black uppercase">Sufficient
                                    Balance</span>
                            @else
                                <span class="badge bg-danger-soft text-danger xx-small fw-black uppercase">Insufficient
                                    Balance</span>
                            @endif
                        </div>
                    </div>

                    <div class="d-grid gap-3">
                        @if(!empty($cashfreeSessionId))
                            <button id="cashfreePayBtn"
                                class="btn btn-primary w-100 py-3 rounded-pill fw-black transform-transition hover-scale shadow-lg border-0"
                                style="background: linear-gradient(135deg, #7026ed 0%, #4b14b6 100%) !important; color: #fff !important;">
                                <i class="bi bi-shield-check me-2"></i> PAY VIA CASHFREE
                            </button>
                        @endif

                        <button id="walletPayBtn"
                            class="btn btn-dark w-100 py-3 rounded-pill fw-black transform-transition hover-scale shadow-lg border-0"
                            {{ Auth::user()->wallet_balance < $order->prepaid_amount ? 'disabled opacity-50' : '' }}>
                            <i class="bi bi-wallet2 me-2"></i> PAY VIA WALLET
                        </button>
                    </div>

                    <p class="text-muted xx-small fw-bold">
                        <i class="bi bi-info-circle me-1"></i>
                        Closing this window will cancel the transaction.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
    <script>
        @if(!empty($cashfreeSessionId))
        const cashfree = Cashfree({
            mode: "{{ $cashfreeMode ?? 'sandbox' }}"
        });

        const cashfreeBtn = document.getElementById('cashfreePayBtn');
        if (cashfreeBtn) {
            cashfreeBtn.onclick = function (e) {
                e.preventDefault();
                cashfree.checkout({
                    paymentSessionId: "{{ $cashfreeSessionId }}",
                    redirectTarget: "_self"
                }).then(async function(result) {
                    if (result.error) {
                        alert(result.error.message || 'Cashfree payment was cancelled or failed.');
                    }
                });
            };
        }
        @endif

        document.getElementById('walletPayBtn').onclick = async function (e) {
            if (confirm('Are you sure you want to pay ₹{{ number_format($order->prepaid_amount, 2) }} from your wallet?')) {
                const btn = this;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> PROCESSING...';

                try {
                    const freshToken = window.getFreshCsrfToken ? await window.getFreshCsrfToken() : document.querySelector('meta[name="csrf-token"]').content;
                    const res = await fetch('{{ route("checkout.payment.wallet", [], false) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': freshToken
                        },
                        body: JSON.stringify({
                            order_id: '{{ $order->id }}'
                        })
                    });
                    const data = await res.json();
                    if (data.success) {
                        window.location.href = '/order-success?order_id={{ $order->id }}';
                    } else {
                        alert(data.message || 'Wallet Payment Failed!');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-wallet2 me-2"></i> PAY VIA WALLET';
                    }
                } catch (err) {
                    console.error(err);
                    alert('Something went wrong!');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-wallet2 me-2"></i> PAY VIA WALLET';
                }
            }
            e.preventDefault();
        }
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.165, 0.84, 0.44, 1) both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
@endsection