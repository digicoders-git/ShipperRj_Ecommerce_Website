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
                        <button id="rzp-button1"
                            class="btn btn-primary w-100 py-3 rounded-pill fw-black transform-transition hover-scale shadow-lg border-0"
                            style="background-color: #3399cc !important;">
                            <i class="bi bi-credit-card me-2"></i> PAY VIA RAZORPAY
                        </button>

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

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ $keyID }}",
            "amount": "{{ $razorOrder->amount }}",
            "currency": "INR",
            "name": "Shopping Club India",
            "description": "Payment for Order #{{ $order->order_number }}",
            "image": "{{ asset('assets/images/logo.jpeg') }}",
            "order_id": "{{ $order->razorpay_order_id }}",
            "handler": function (response) {
                // Success handler
                fetch('{{ route("checkout.payment.verify") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_signature: response.razorpay_signature
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '/order-success?order_id={{ $order->id }}';
                        } else {
                            alert('Payment Verification Failed!');
                        }
                    });
            },
            "prefill": {
                "name": "{{ Auth::user()->name }}",
                "email": "{{ Auth::user()->email }}",
                "contact": "{{ Auth::user()->mobile }}"
            },

            // "config": {
            //     "display": {
            //         "blocks": {
            //             "vpa": {
            //                 "name": "Pay via UPI",
            //                 "instruments": [
            //                     {
            //                         "method": "upi"
            //                     }
            //                 ]
            //             },
            //             "wallets": {
            //                 "name": "Wallets",
            //                 "instruments": [
            //                   {
            //                     "method": "wallet"
            //                   }
            //                 ]
            //             }
            //         },
            //         "sequence": [
            //             "block.vpa",
            //             "block.wallets"
            //         ],
            //         "preferences": {
            //             "show_default_blocks": true
            //         }
            //     }
            // },
            "theme": {
                "color": "#3399cc"
            },
            "modal": {
                "ondismiss": function () {
                    console.log('Checkout form closed');
                }
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', function (response) {
            alert(response.error.description);
        });
        document.getElementById('rzp-button1').onclick = function (e) {
            rzp1.open();
            e.preventDefault();
        }

        document.getElementById('walletPayBtn').onclick = function (e) {
            if (confirm('Are you sure you want to pay ₹{{ number_format($order->prepaid_amount, 2) }} from your wallet?')) {
                const btn = this;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> PROCESSING...';

                fetch('{{ route("checkout.payment.wallet") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order_id: '{{ $order->id }}'
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '/order-success?order_id={{ $order->id }}';
                        } else {
                            alert(data.message || 'Wallet Payment Failed!');
                            btn.disabled = false;
                            btn.innerHTML = '<i class="bi bi-wallet2 me-2"></i> PAY VIA WALLET';
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Something went wrong!');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-wallet2 me-2"></i> PAY VIA WALLET';
                    });
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