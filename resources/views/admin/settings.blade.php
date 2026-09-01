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

                    @php
                        $onlineTiers = isset($settings['shipping_tiers_online']) ? json_decode($settings['shipping_tiers_online'], true) : [];
                        if (!is_array($onlineTiers) || empty($onlineTiers)) {
                            $defaultOnline = $settings['global_online_shipping'] ?? 2;
                            $onlineTiers = [
                                ['min_price' => 0, 'max_price' => '', 'shipping_percent' => $defaultOnline]
                            ];
                        }

                        $codTiers = isset($settings['shipping_tiers_cod']) ? json_decode($settings['shipping_tiers_cod'], true) : [];
                        if (!is_array($codTiers) || empty($codTiers)) {
                            $defaultCod = $settings['global_cod_shipping'] ?? 5;
                            $codTiers = [
                                ['min_price' => 0, 'max_price' => '', 'shipping_percent' => $defaultCod]
                            ];
                        }
                    @endphp

                    <div class="mb-4 pt-3 border-top border-white border-opacity-10" id="logisticsConfiguration">
                        <h6 class="text-white fw-bold mb-2"><i class="bi bi-truck me-2 text-warning"></i>Tier-Wise Shipping Rate Management</h6>
                        <p class="x-small text-secondary mb-4">Set exact price range tiers (Min ₹ - Max ₹) and their shipping charge (%). Leave Max Price empty for "Above".</p>

                        <!-- Online Shipping Tiers -->
                        <div class="card bg-white bg-opacity-5 border border-white border-opacity-10 rounded-4 p-3 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-bold text-white small"><i class="bi bi-credit-card me-2 text-primary"></i>Online Payment Shipping Tiers</span>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 xx-small fw-bold" onclick="addShippingTier('online')">
                                    <i class="bi bi-plus-circle me-1"></i>Add Online Tier
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0" id="table-online-tiers">
                                    <thead>
                                        <tr class="xx-small text-secondary text-uppercase border-bottom border-white border-opacity-10">
                                            <th style="width: 30%;">Min Price (₹)</th>
                                            <th style="width: 30%;">Max Price (₹)</th>
                                            <th style="width: 25%;">Shipping (%)</th>
                                            <th class="text-end" style="width: 15%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="container-online-tiers">
                                        @foreach($onlineTiers as $idx => $tier)
                                            <tr class="tier-row">
                                                <td>
                                                    <input type="number" step="0.01" min="0" name="shipping_tiers_online[{{ $idx }}][min_price]" class="form-control glass-input form-control-sm" value="{{ $tier['min_price'] ?? 0 }}" required placeholder="0">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" min="0" name="shipping_tiers_online[{{ $idx }}][max_price]" class="form-control glass-input form-control-sm" value="{{ $tier['max_price'] ?? '' }}" placeholder="Above">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" min="0" max="100" name="shipping_tiers_online[{{ $idx }}][shipping_percent]" class="form-control glass-input form-control-sm" value="{{ $tier['shipping_percent'] ?? 0 }}" required placeholder="%">
                                                </td>
                                                <td class="text-end">
                                                    <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle" onclick="removeShippingTier(this, 'online')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- COD Shipping Tiers -->
                        <div class="card bg-white bg-opacity-5 border border-white border-opacity-10 rounded-4 p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-bold text-white small"><i class="bi bi-cash-stack me-2 text-warning"></i>COD Payment Shipping Tiers</span>
                                <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 xx-small fw-bold" onclick="addShippingTier('cod')">
                                    <i class="bi bi-plus-circle me-1"></i>Add COD Tier
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0" id="table-cod-tiers">
                                    <thead>
                                        <tr class="xx-small text-secondary text-uppercase border-bottom border-white border-opacity-10">
                                            <th style="width: 30%;">Min Price (₹)</th>
                                            <th style="width: 30%;">Max Price (₹)</th>
                                            <th style="width: 25%;">Shipping (%)</th>
                                            <th class="text-end" style="width: 15%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="container-cod-tiers">
                                        @foreach($codTiers as $idx => $tier)
                                            <tr class="tier-row">
                                                <td>
                                                    <input type="number" step="0.01" min="0" name="shipping_tiers_cod[{{ $idx }}][min_price]" class="form-control glass-input form-control-sm" value="{{ $tier['min_price'] ?? 0 }}" required placeholder="0">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" min="0" name="shipping_tiers_cod[{{ $idx }}][max_price]" class="form-control glass-input form-control-sm" value="{{ $tier['max_price'] ?? '' }}" placeholder="Above">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" min="0" max="100" name="shipping_tiers_cod[{{ $idx }}][shipping_percent]" class="form-control glass-input form-control-sm" value="{{ $tier['shipping_percent'] ?? 0 }}" required placeholder="%">
                                                </td>
                                                <td class="text-end">
                                                    <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle" onclick="removeShippingTier(this, 'cod')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 pt-3 border-top border-white border-opacity-10" id="paymentConfiguration">
                        <h6 class="text-white fw-bold mb-3"><i
                                class="bi bi-gear-wide-connected me-2 text-primary"></i>Ordering & Adv. Policy</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-secondary small">Min Order Value to Place Order (₹)</label>
                                <input type="number" name="min_order_price" class="form-control glass-input"
                                    value="{{ $settings['min_order_price'] ?? 1 }}" required min="1">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-secondary small">Default COD Advance (%)</label>
                                <input type="number" name="global_cod_advance_percent" class="form-control glass-input"
                                    value="{{ $settings['global_cod_advance_percent'] ?? 10 }}" required min="0" max="100">
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
                        <h6 class="text-white fw-bold mb-3"><i class="bi bi-info-circle me-2 text-info"></i>Support &
                            Contact</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-secondary small">Support Email</label>
                                <input type="email" name="support_email" class="form-control glass-input"
                                    value="{{ $settings['support_email'] ?? 'shoppingclubindia1@gmail.com' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-secondary small">Support Phone</label>
                                <input type="text" name="support_phone" class="form-control glass-input"
                                    value="{{ $settings['support_phone'] ?? '08069378060' }}">
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label text-secondary small">Office Address</label>
                                <textarea name="office_address" class="form-control glass-input" rows="2" placeholder="Office Address">{{ $settings['office_address'] ?? 'Avenue 7, New Delhi, India 110001' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 pt-3 border-top border-white border-opacity-10">
                        <h6 class="text-white fw-bold mb-3"><i class="bi bi-share me-2 text-info"></i>Social Media Links</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-secondary small">Facebook Link</label>
                                <input type="url" name="facebook_link" class="form-control glass-input"
                                    value="{{ $settings['facebook_link'] ?? '' }}" placeholder="https://facebook.com/yourpage">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-secondary small">Instagram Link</label>
                                <input type="url" name="instagram_link" class="form-control glass-input"
                                    value="{{ $settings['instagram_link'] ?? '' }}" placeholder="https://instagram.com/yourprofile">
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-secondary small">Twitter/X Link</label>
                                <input type="url" name="twitter_link" class="form-control glass-input"
                                    value="{{ $settings['twitter_link'] ?? '' }}" placeholder="https://twitter.com/yourprofile">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-secondary small">YouTube Link</label>
                                <input type="url" name="youtube_link" class="form-control glass-input"
                                    value="{{ $settings['youtube_link'] ?? '' }}" placeholder="https://youtube.com/yourchannel">
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
                <h6 class="text-white fw-bold mb-3 uppercase small tracking-widest"><i
                        class="bi bi-eye me-2 text-warning"></i>Live Status Preview</h6>
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
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-telephone text-warning xx-small"></i>
                        <span class="x-small text-white opacity-75">{{ $settings['support_phone'] ?? 'Not set' }}</span>
                    </div>
                    <div class="d-flex align-items-start gap-2 mb-3">
                        <i class="bi bi-geo-alt text-danger xx-small mt-1"></i>
                        <span class="x-small text-white opacity-75 text-wrap">{{ $settings['office_address'] ?? 'Not set' }}</span>
                    </div>
                    
                    <div class="text-white x-small fw-bold mb-2">Social Connections</div>
                    <div class="d-flex gap-2">
                        <a href="{{ $settings['facebook_link'] ?? '#' }}" target="_blank" class="btn btn-sm btn-dark text-white p-1 rounded d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;"><i class="bi bi-facebook"></i></a>
                        <a href="{{ $settings['instagram_link'] ?? '#' }}" target="_blank" class="btn btn-sm btn-dark text-white p-1 rounded d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;"><i class="bi bi-instagram"></i></a>
                        <a href="{{ $settings['twitter_link'] ?? '#' }}" target="_blank" class="btn btn-sm btn-dark text-white p-1 rounded d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;"><i class="bi bi-twitter-x"></i></a>
                        <a href="{{ $settings['youtube_link'] ?? '#' }}" target="_blank" class="btn btn-sm btn-dark text-white p-1 rounded d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

                <div class="mt-auto p-3 rounded-4  bg-opacity-10 border border-primary border-opacity-10">
                    <p class="xx-small text-primary fw-bold mb-0 lh-sm">All changes reflect in real-time on mobile &
                        dashboard interfaces.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let onlineTierIndex = {{ count($onlineTiers) }};
    let codTierIndex = {{ count($codTiers) }};

    function addShippingTier(type) {
        let container = document.getElementById(type === 'cod' ? 'container-cod-tiers' : 'container-online-tiers');
        let idx = (type === 'cod') ? codTierIndex++ : onlineTierIndex++;
        let fieldPrefix = (type === 'cod') ? 'shipping_tiers_cod' : 'shipping_tiers_online';

        let row = document.createElement('tr');
        row.className = 'tier-row';
        row.innerHTML = `
            <td>
                <input type="number" step="0.01" min="0" name="${fieldPrefix}[${idx}][min_price]" class="form-control glass-input form-control-sm" value="" required placeholder="Min">
            </td>
            <td>
                <input type="number" step="0.01" min="0" name="${fieldPrefix}[${idx}][max_price]" class="form-control glass-input form-control-sm" value="" placeholder="Above">
            </td>
            <td>
                <input type="number" step="0.01" min="0" max="100" name="${fieldPrefix}[${idx}][shipping_percent]" class="form-control glass-input form-control-sm" value="" required placeholder="%">
            </td>
            <td class="text-end">
                <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle" onclick="removeShippingTier(this, '${type}')">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        container.appendChild(row);
    }

    function removeShippingTier(btn, type = 'online') {
        let row = btn.closest('tr');
        if (!row) return;

        let inputs = row.querySelectorAll('input');
        let minPrice = inputs[0] ? inputs[0].value : 0;
        let maxPrice = inputs[1] ? inputs[1].value : '';

        Swal.fire({
            title: 'Delete Shipping Tier?',
            text: "Do you want to delete this tier?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ route('admin.settings.deleteTier') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        type: type,
                        min_price: minPrice,
                        max_price: maxPrice
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        row.style.transition = 'all 0.3s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'scale(0.95)';
                        setTimeout(() => row.remove(), 300);
                        if (typeof showToast === 'function') {
                            showToast(data.message, 'success');
                        } else {
                            Swal.fire('Deleted!', data.message, 'success');
                        }
                    } else {
                        Swal.fire('Error', data.message || 'Failed to delete tier.', 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('Error', 'Server error while deleting tier.', 'error');
                });
            }
        });
    }
</script>
@endpush