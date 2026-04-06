@extends('layouts.app')

@section('content')
    <div class="dashboard-main">
        @include('includes.dashboard_header')

        <div class="container py-5">
            <div class="row g-4 align-items-start dashboard-row-premium">
                <!-- Sidebar -->
                <div class="col-lg-3 dashboard-sidebar-column">
                    @include('includes.dashboard_sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9 fade-in-up">
                    <!-- Balance & Actions -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-7">
                            <div class="dashboard-card border-0 p-5 h-100 position-relative overflow-hidden"
                                style="background: var(--primary-gradient);">
                                <div class="position-absolute top-0 end-0 p-5 opacity-10"
                                    style="transform: translate(30%, -30%); pointer-events: none;">
                                    <i class="bi bi-wallet2" style="font-size: 15rem;"></i>
                                </div>
                                <div class="position-relative z-1 text-white">
                                    <span class="x-small text-uppercase fw-bold opacity-75 ls-1 d-block mb-1">AVAILABLE
                                        BALANCE</span>
                                    <h1 class="fw-black display-4 mb-4 letter-spacing-n1">
                                        ₹{{ number_format(Auth::user()->wallet_balance ?? 0, 2) }}</h1>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-white rounded-pill px-4 py-3 fw-bold shadow-premium"
                                            data-bs-toggle="modal" data-bs-target="#addMoneyModal">
                                            <i class="bi bi-plus-lg me-2"></i> Add Money
                                        </button>
                                        <button class="btn btn-outline-light rounded-pill px-4 py-3 fw-bold border-2">
                                            <i class="bi bi-arrow-down-circle me-2"></i> Withdraw
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="dashboard-card p-4 h-100 d-flex flex-column justify-content-center">
                                <h6 class="fw-bold text-muted small text-uppercase ls-1 mb-3">Wallet Highlights</h6>
                                <div class="d-flex justify-content-between py-2 border-bottom border-light">
                                    <span class="small text-secondary fw-medium">Deposited</span>
                                    <span
                                        class="small text-dark fw-bold">₹{{ number_format(Auth::user()->walletTransactions()->where('type', 1)->sum('amount'), 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom border-light">
                                    <span class="small text-secondary fw-medium">Spent</span>
                                    <span
                                        class="small text-dark fw-bold">₹{{ number_format(Auth::user()->walletTransactions()->where('type', 2)->sum('amount'), 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="small text-secondary fw-medium">Last Activity</span>
                                    <span
                                        class="small text-dark fw-bold">{{ Auth::user()->walletTransactions()->latest()->first()?->created_at?->format('d M, Y') ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction History -->
                    <div class="dashboard-card p-4 p-lg-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-black mb-0">Transaction History</h4>
                            <div class="d-flex gap-2">
                                <div class="bg-light p-1 rounded-pill d-flex">
                                    <a href="{{ url('/wallet') }}"
                                        class="btn {{ !request('filter') ? 'btn-white shadow-sm' : 'btn-transparent text-muted' }} btn-sm rounded-pill px-3 fw-bold small">All</a>
                                    <a href="{{ url('/wallet?filter=credits') }}"
                                        class="btn {{ request('filter') == 'credits' ? 'btn-white shadow-sm' : 'btn-transparent text-muted' }} btn-sm rounded-pill px-3 fw-bold small">Credits</a>
                                    <a href="{{ url('/wallet?filter=debits') }}"
                                        class="btn {{ request('filter') == 'debits' ? 'btn-white shadow-sm' : 'btn-transparent text-muted' }} btn-sm rounded-pill px-3 fw-bold small">Debits</a>
                                </div>
                            </div>
                        </div>

                        @if($transactions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-premium align-middle">
                                    <thead>
                                        <tr>
                                            <th>Entity / Description</th>
                                            <th>Transaction ID</th>
                                            <th>Amount</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $txn)
                                            <tr>
                                                <td>
                                                    <div class="fw-bold text-dark small">{{ $txn->description }}</div>
                                                </td>
                                                <td><code class="x-small text-muted">TXN-{{ $txn->id }}</code></td>
                                                <td>
                                                    <span class="fw-black {{ $txn->type == 1 ? 'text-success' : 'text-danger' }}">
                                                        {{ $txn->type == 1 ? '+' : '-' }}₹{{ number_format($txn->amount, 2) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge {{ $txn->type == 1 ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }} rounded-pill px-3 py-1 fw-bold x-small">
                                                        {{ $txn->type == 1 ? 'CREDIT' : 'DEBIT' }}
                                                    </span>
                                                </td>
                                                <td class="text-muted small">{{ $txn->created_at->format('d M, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $transactions->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="bi bi-wallet display-1 text-muted opacity-25"></i>
                                </div>
                                <h5 class="fw-bold text-dark">No transactions!</h5>
                                <p class="text-muted mb-0 small">Add funds to start your shopping journey.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <!-- Add Money Modal -->
    <div class="modal fade" id="addMoneyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
                <div class="modal-header border-0 bg-light p-4">
                    <h5 class="modal-title fw-black">Deposit Funds</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Offers Section -->
                    @if($offers->count() > 0)
                        <div class="mb-4">
                            <label class="form-label x-small fw-black text-muted text-uppercase ls-1 mb-2">Exclusive
                                Boosters</label>
                            <div class="d-flex flex-column gap-2">
                                @foreach($offers as $offer)
                                    <div class="p-3 border rounded-4 d-flex justify-content-between align-items-center bg-light bg-opacity-50 transition-all hover-translate-y pointer"
                                        onclick="document.getElementById('walletAmountInput').value={{ $offer->min_amount }}">
                                        <div>
                                            <span class="d-block small fw-bold text-dark">Add
                                                ₹{{ number_format($offer->min_amount) }}+</span>
                                            <span class="x-small text-muted fw-medium">Get extra <span
                                                    class="text-success fw-bold">₹{{ number_format($offer->bonus_amount) }}</span>
                                                in your wallet</span>
                                        </div>
                                        <div class="badge bg-success-soft text-success rounded-pill px-3 py-1 fw-bold x-small">SAVE
                                            MORE</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <form id="walletAddForm">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Amount (INR)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 px-4 fs-3 fw-bold">₹</span>
                                <input type="number" id="walletAmountInput" name="amount"
                                    class="form-control form-control-lg bg-light border-0 py-3 fw-black fs-2 shadow-none"
                                    placeholder="0.00" required min="1">
                            </div>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-4">
                                <button type="button"
                                    class="btn btn-outline-light text-dark w-100 py-3 rounded-4 small fw-bold border-1 mt-1"
                                    onclick="document.getElementById('walletAmountInput').value=500">₹500</button>
                            </div>
                            <div class="col-4">
                                <button type="button"
                                    class="btn btn-outline-light text-dark w-100 py-3 rounded-4 small fw-bold border-1 mt-1"
                                    onclick="document.getElementById('walletAmountInput').value=1000">₹1000</button>
                            </div>
                            <div class="col-4">
                                <button type="button"
                                    class="btn btn-outline-light text-dark w-100 py-3 rounded-4 small fw-bold border-1 mt-1"
                                    onclick="document.getElementById('walletAmountInput').value=2000">₹2000</button>
                            </div>
                        </div>

                        <button type="submit" id="walletPayBtn"
                            class="btn btn-premium w-100 py-3 rounded-pill fw-bold shadow-premium">
                            Recharge Now <i class="bi bi-arrow-right ms-2"></i>
                        </button>

                        <div class="text-center mt-4">
                            <div class="d-flex align-items-center justify-content-center gap-4 opacity-50">
                                <i class="bi bi-shield-lock-fill fs-3" title="Secure Payment"></i>
                                <i class="bi bi-credit-card-2-back-fill fs-3" title="Card Payments"></i>
                            </div>
                            <p class="x-small text-muted mt-2 mb-0">Secured with 128-bit SSL Encryption</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.getElementById('walletAddForm').onsubmit = function (e) {
            e.preventDefault();
            const btn = document.getElementById('walletPayBtn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Connecting...';

            const amount = document.getElementById('walletAmountInput').value;

            fetch('{{ route("wallet.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ amount: amount })
            })
                .then(res => {
                    if (!res.ok) throw new Error('Server Error');
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        // Hide modal before opening Razorpay to avoid interaction issues
                        const modalEl = document.getElementById('addMoneyModal');
                        const modalInstance = bootstrap.Modal.getInstance(modalEl);
                        if (modalInstance) modalInstance.hide();

                        var options = {
                            "key": data.key,
                            "amount": data.amount * 100,
                            "currency": "INR",
                            "name": "Shopping Club India",
                            "description": "Wallet Recharge",
                            "image": "{{ asset('assets/images/logo.jpeg') }}",
                            "order_id": data.order_id,
                            "handler": function (response) {
                                // Success handler
                                fetch('{{ route("wallet.verify") }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        razorpay_payment_id: response.razorpay_payment_id,
                                        razorpay_order_id: response.razorpay_order_id,
                                        razorpay_signature: response.razorpay_signature,
                                        amount: data.amount
                                    })
                                })
                                    .then(res => res.json())
                                    .then(vData => {
                                        if (vData.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Recharge Successful!',
                                                text: 'Your wallet has been credited.',
                                                confirmButtonColor: '#3399cc'
                                            }).then(() => {
                                                window.location.reload();
                                            });
                                        } else {
                                            Swal.fire('Error', 'Payment verification failed!', 'error');
                                        }
                                    })
                                    .catch(err => Swal.fire('Error', 'Verification request failed.', 'error'));
                            },
                            "modal": {
                                "ondismiss": function () {
                                    btn.disabled = false;
                                    btn.innerHTML = originalText;
                                }
                            },
                            "prefill": {
                                "name": data.name,
                                "email": data.email
                            },
                            "theme": { "color": "#3399cc" }
                        };
                        var rzp1 = new Razorpay(options);
                        rzp1.open();
                    } else {
                        Swal.fire('Error', data.message || 'Unable to initiate payment.', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Something went wrong while connecting to Razorpay.', 'error');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                });
        };
    </script>
@endpush