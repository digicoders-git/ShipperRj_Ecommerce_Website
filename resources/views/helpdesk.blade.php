@extends('layouts.app')

@section('content')
    <div class="">
        @include('includes.dashboard_header')

        <div class="container py-5">
            <div class="row g-4 align-items-start dashboard-row-premium ">
                <!-- Sidebar -->
                <div class="col-lg-3 dashboard-sidebar-column">
                    @inclu
                </div>de('includes.dashboard_sidebar')

                <!-- Main Content -->
                <div class="col-lg-9 fade-in-up">
                    <div class="dashboard-card p-4 p-lg-5">
                        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
                            <div>
                                <h3 class="fw-black mb-1 letter-spacing-n1">Support Intelligence</h3>
                                <p class="text-muted small mb-0 fw-medium">Resolution hub for your shopping queries and
                                    ticket tracking.</p>
                            </div>
                            <button class="btn btn-premium px-4 py-2 rounded-pill fw-bold" data-bs-toggle="modal"
                                data-bs-target="#newTicketModal">
                                <i class="bi bi-plus-lg me-2"></i> New Support Ticket
                            </button>
                        </div>

                        <!-- Quick Contact Grid -->
                        <div class="row g-4 mb-5">
                            <div class="col-md-4">
                                <div
                                    class="bg-light bg-opacity-50 p-4 rounded-4 border border-white h-100 transition-all hover-translate-y text-center">
                                    <div class="avatar-sm bg-primary-soft text-primary mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="bi bi-chat-dots-fill fs-5"></i>
                                    </div>
                                    <h6 class="fw-black text-dark mb-1">Live Concierge</h6>
                                    <p class="xx-small text-muted fw-bold uppercase mb-3">10 AM - 7 PM IST</p>
                                    <a href="https://wa.me/917010314981"
                                        class="btn btn-sm btn-premium-outline rounded-pill px-4 w-100 fw-bold">START
                                        CHAT</a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div
                                    class="bg-light bg-opacity-50 p-4 rounded-4 border border-white h-100 transition-all hover-translate-y text-center">
                                    <div class="avatar-sm bg-warning-soft text-warning mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="bi bi-envelope-paper-fill fs-5"></i>
                                    </div>
                                    <h6 class="fw-black text-dark mb-1">Email Archive</h6>
                                    <p class="xx-small text-muted fw-bold uppercase mb-3">24h Response Goal</p>
                                    <a href="mailto:support@shoppingclubindia.com"
                                        class="btn btn-sm btn-premium-outline rounded-pill px-4 w-100 fw-bold text-decoration-none">EMAIL
                                        US</a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div
                                    class="bg-light bg-opacity-50 p-4 rounded-4 border border-white h-100 transition-all hover-translate-y text-center">
                                    <div class="avatar-sm bg-success-soft text-success mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="bi bi-telephone-outbound-fill fs-5"></i>
                                    </div>
                                    <h6 class="fw-black text-dark mb-1">Direct Hotline</h6>
                                    <p class="xx-small text-muted fw-bold uppercase mb-3">+91 999 999 9999</p>
                                    <a href="tel:+919999999999"
                                        class="btn btn-sm btn-premium-outline rounded-pill px-4 w-100 fw-bold text-decoration-none">CALL
                                        NOW</a>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-4">
                            <h6 class="fw-black mb-0 uppercase tracking-widest text-dark">Active Resolutions</h6>
                            <span class="badge bg-dark rounded-pill xx-small">{{ $userComplaints->count() }}</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-premium align-middle">
                                <thead class="bg-light bg-opacity-50">
                                    <tr>
                                        <th class="ps-3 uppercase xx-small fw-black tracking-widest text-dark py-3">TICKET
                                            ID</th>
                                        <th class="uppercase xx-small fw-black tracking-widest text-dark py-3">SUBJECT</th>
                                        <th class="uppercase xx-small fw-black tracking-widest text-dark text-center py-3">
                                            STATUS</th>
                                        <th class="uppercase xx-small fw-black tracking-widest text-dark text-center py-3">
                                            ACTIVITY</th>
                                        <th
                                            class="pe-3 text-end uppercase xx-small fw-black tracking-widest text-dark py-3">
                                            ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($userComplaints as $complaint)
                                        <tr class="transition-all hover-translate-y">
                                            <td class="ps-3 py-4">
                                                <span class="fw-black text-dark">#{{ substr($complaint->id, -6) }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="small fw-bold text-dark d-block text-uppercase">{{ $complaint->subject }}</span>
                                                @if($complaint->product)
                                                    <span class="xx-small text-muted fw-bold">Product:
                                                        {{ Str::limit($complaint->product->name, 30) }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($complaint->status == 'resolved' || $complaint->status == 'Approved' || $complaint->status == 'Completed')
                                                    <span
                                                        class="badge bg-success-soft text-success px-3 py-1 rounded-pill xx-small fw-black uppercase">Resolved</span>
                                                @elseif($complaint->status == 'Rejected' || $complaint->status == 'cancelled')
                                                    <span
                                                        class="badge bg-danger-soft text-danger px-3 py-1 rounded-pill xx-small fw-black uppercase">Rejected</span>
                                                @else
                                                    <span
                                                        class="badge bg-warning-soft text-warning px-3 py-1 rounded-pill xx-small fw-black uppercase">{{ $complaint->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="xx-small text-muted fw-bold">{{ $complaint->created_at->diffForHumans() }}</span>
                                            </td>
                                            <td class="pe-3 text-end">
                                                <button
                                                    class="btn btn-premium-outline btn-sm rounded-pill px-4 fw-black tracking-tighter"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#complaintDetails{{$complaint->id}}">VIEW</button>
                                            </td>
                                        </tr>
                                        <tr class="collapse border-0" id="complaintDetails{{$complaint->id}}">
                                            <td colspan="5" class="py-0 px-3">
                                                <div class="p-4 bg-light bg-opacity-50 rounded-4 border-2 border-white mb-4">
                                                    <div class="row g-4">
                                                        <div class="col-md-6">
                                                            <label
                                                                class="xx-small fw-black uppercase text-muted tracking-widest mb-2 d-block">YOUR
                                                                MESSAGE</label>
                                                            <p class="small text-dark mb-0 fw-medium">
                                                                "{{ $complaint->message }}"</p>
                                                        </div>
                                                        <div class="col-md-6 border-start">
                                                            <label
                                                                class="xx-small fw-black uppercase text-muted tracking-widest mb-2 d-block">ADMIN
                                                                RESOLUTION</label>
                                                            @if($complaint->admin_comment)
                                                                <p class="small text-primary mb-0 fw-bold">
                                                                    "{{ $complaint->admin_comment }}"</p>
                                                                <span
                                                                    class="xx-small text-muted fw-bold italic d-block mt-2">Response
                                                                    Date: {{ $complaint->updated_at->format('d M, Y') }}</span>
                                                            @else
                                                                <p class="small text-muted mb-0 italic">Waiting for response...</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="bi bi-shield-check display-3 text-muted opacity-25 d-block mb-3"></i>
                                                <p class="text-muted small">No Support Tickets initialized yet.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('modals')
        <!-- New Ticket Modal -->
        <div class="modal fade" id="newTicketModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div>
                            <h5 class="fw-black mb-1">Open Support Case</h5>
                            <p class="text-muted small mb-0">Our intelligence team will respond within 12-24 hours.</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="{{ route('complaints.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="xx-small fw-bold text-muted uppercase tracking-widest mb-2 d-block">CASE
                                    CATEGORY</label>
                                <select name="subject" id="complaintCategory"
                                    class="form-select border-2 py-3 rounded-4 shadow-none fw-bold small" required>
                                    <option value="" disabled selected>Select Category...</option>
                                    <option value="Issue with Delivered Product">Issue with Delivered Product</option>
                                    <option value="Order Tracking & Logistics">Order Tracking & Logistics</option>
                                    <option value="Payment & Wallet Inquiries">Payment & Wallet Inquiries</option>
                                    <option value="Account & Privacy Settings">Account & Privacy Settings</option>
                                    <option value="Other Technical Issues">Other Technical Issues</option>
                                </select>
                            </div>

                            <div class="mb-3 d-none" id="productSelectWrapper">
                                <label class="xx-small fw-bold text-muted uppercase tracking-widest mb-2 d-block">CHOOSE
                                    DELIVERED PRODUCT</label>
                                <select name="product_id" class="form-select border-2 py-3 rounded-4 shadow-none fw-bold small">
                                    <option value="" disabled selected>Choose Product...</option>
                                    @foreach($deliveredProducts as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="xx-small fw-bold text-muted uppercase tracking-widest mb-2 d-block">DETAILED
                                    DESCRIPTION</label>
                                <textarea name="message" class="form-control border-2 py-3 rounded-4 shadow-none fw-medium"
                                    rows="4" placeholder="Briefly describe your issue or question..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-premium w-100 py-3 rounded-pill fw-black shadow-sm">
                                INITIALIZE RESOLUTION
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endpush

    @push('styles')
        <style>
            .btn-premium-outline {
                border: 2px solid #f0f0f0;
                color: #444;
                transition: all 0.3s ease;
            }

            .btn-premium-outline:hover {
                background: var(--bs-primary);
                border-color: var(--bs-primary);
                color: #fff;
                transform: scale(1.05);
            }

            .bg-primary-soft {
                background-color: rgba(13, 110, 253, 0.08) !important;
                color: #0d6efd !important;
            }

            .bg-warning-soft {
                background-color: rgba(242, 112, 26, 0.08) !important;
                color: #f2701aff !important;
            }

            .bg-success-soft {
                background-color: rgba(25, 135, 84, 0.08) !important;
                color: #198754 !important;
            }

            .hover-translate-y:hover {
                transform: translateY(-5px);
            }

            .fw-black {
                font-weight: 900;
            }

            .xx-small {
                font-size: 0.65rem;
            }

            .letter-spacing-n1 {
                letter-spacing: -1px;
            }

            table.table-premium thead tr th {
                border-bottom: 2px solid #f0f0f0;
                border-top: none;
            }

            .italic {
                font-style: italic;
            }

            .bg-danger-soft {
                background-color: rgba(220, 53, 69, 0.08) !important;
                color: #dc3545 !important;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const categorySelect = document.getElementById('complaintCategory');
                const productWrapper = document.getElementById('productSelectWrapper');

                if (categorySelect) {
                    categorySelect.addEventListener('change', function () {
                        const showProductSelect = ['Issue with Delivered Product', 'Order Tracking & Logistics'].includes(this.value);

                        if (showProductSelect) {
                            productWrapper.classList.remove('d-none');
                        } else {
                            productWrapper.classList.add('d-none');
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection