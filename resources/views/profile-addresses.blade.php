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
                <div class="col-lg-9">
                    <div class="dashboard-card p-4 p-lg-5">
                        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
                            <div>
                                <h3 class="fw-black mb-1">My Addresses</h3>
                                <p class="text-muted small mb-0 fw-medium">Manage your delivery addresses for a faster
                                    checkout.</p>
                            </div>
                            <button class="btn btn-premium px-4 py-2 rounded-pill fw-bold" data-bs-toggle="modal"
                                data-bs-target="#addAddressModal">
                                <i class="bi bi-plus-lg me-2"></i> Add New Address
                            </button>
                        </div>

                        @if($addresses->isEmpty())
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="bi bi-geo-alt text-light display-1"></i>
                                </div>
                                <h5 class="fw-black text-dark">No Addresses Found</h5>
                                <p class="text-muted small mb-4">You haven't added any addresses yet. Add one to get started.
                                </p>
                                <button class="btn btn-outline-primary rounded-pill px-5 fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#addAddressModal">
                                    Create Your First Address
                                </button>
                            </div>
                        @else
                            <div class="row g-4">
                                @foreach($addresses as $address)
                                    <div class="col-md-6">
                                        <div
                                            class="address-premium-card p-4 rounded-4 border {{ $address->is_default ? 'active shadow-premium' : '' }} position-relative transition-all overflow-hidden h-100">
                                            @if($address->is_default)
                                                <div class="default-badge">
                                                    <i class="bi bi-check2-circle me-1"></i> Default
                                                </div>
                                            @endif

                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <span
                                                    class="badge bg-primary-soft text-primary xx-small fw-bold uppercase px-3 py-1 rounded-pill">
                                                    {{ $address->type ?? 'Home' }}
                                                </span>
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                                                        <li><a class="dropdown-item small" href="#"
                                                                onclick="editAddress({{ json_encode($address) }})"><i
                                                                    class="bi bi-pencil me-2"></i> Edit</a></li>
                                                        @if(!$address->is_default)
                                                            <li>
                                                                <form action="{{ route('addresses.set-default', $address->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item small"><i
                                                                            class="bi bi-star me-2"></i> Set as Default</button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <hr class="dropdown-divider opacity-50">
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('addresses.destroy', $address->id) }}"
                                                                method="POST" class="delete-address-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="dropdown-item small text-danger btn-delete-address"><i
                                                                        class="bi bi-trash me-2"></i> Delete</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <h6 class="fw-black text-dark mb-2">{{ $address->name }}</h6>
                                            <div class="address-details pe-4">
                                                <p class="text-secondary small mb-1">{{ $address->address_line }}</p>
                                                <p class="text-secondary small mb-3">
                                                    {{ $address->landmark ? $address->landmark . ', ' : '' }}
                                                    {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                                                </p>
                                                <p class="text-dark small mb-0 fw-bold">
                                                    <i class="bi bi-telephone me-1 text-muted"></i> {{ $address->mobile }}
                                                    @if($address->alt_mobile)
                                                        <span
                                                            class="text-muted ms-2 px-2 border-start">{{ $address->alt_mobile }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .address-premium-card {
                background: rgba(255, 255, 255, 0.4);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                cursor: default;
            }

            .address-premium-card:hover {
                transform: translateY(-5px);
                background: rgba(255, 255, 255, 0.8);
                border-color: var(--primary);
            }

            .address-premium-card.active {
                background: #fff;
                border-color: var(--primary);
                border-width: 2px;
            }

            .default-badge {
                position: absolute;
                top: 0;
                right: 0;
                background: var(--primary-gradient);
                color: #fff;
                font-size: 0.55rem;
                font-weight: 800;
                text-transform: uppercase;
                padding: 4px 12px;
                border-bottom-left-radius: 12px;
                letter-spacing: 0.5px;
            }

            .address-details p {
                line-height: 1.6;
            }

            .modal {
                z-index: 10001 !important;
            }
        </style>

        @push('modals')
            <!-- Address Modals at body root level to avoid stacking issues -->
            <div class="modal fade" id="addAddressModal" aria-hidden="true" style="backdrop-filter: blur(5px); z-index: 10001;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow-lg" style="pointer-events: auto;">
                        <div class="modal-header border-0 p-4 pb-0">
                            <h5 class="fw-black mb-0">Add New Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <form action="{{ route('addresses.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-floating mb-1">
                                            <input type="text" name="name" class="form-control rounded-3" id="addName"
                                                placeholder="Full Name" required>
                                            <label for="addName">Full Name</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-1">
                                            <input type="text" name="mobile" class="form-control rounded-3" id="addMobile"
                                                placeholder="10-digit Mobile" required>
                                            <label for="addMobile">Mobile Number</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-1">
                                            <input type="text" name="alt_mobile" class="form-control rounded-3"
                                                id="addAltMobile" placeholder="Alt Mobile">
                                            <label for="addAltMobile">Alt Mobile (Optional)</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-1">
                                            <textarea name="address_line" class="form-control rounded-3" id="addAddress"
                                                placeholder="Address" style="height: 80px" required></textarea>
                                            <label for="addAddress">Full Address (Line, Street)</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-1">
                                            <input type="text" name="city" class="form-control rounded-3" id="addCity"
                                                placeholder="City" required>
                                            <label for="addCity">City</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-1">
                                            <input type="text" name="state" class="form-control rounded-3" id="addState"
                                                placeholder="State" required>
                                            <label for="addState">State</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-1">
                                            <input type="text" name="pincode" class="form-control rounded-3" id="addPincode"
                                                placeholder="Pincode" required>
                                            <label for="addPincode">Pincode</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-1">
                                            <input type="text" name="landmark" class="form-control rounded-3" id="addLandmark"
                                                placeholder="Landmark">
                                            <label for="addLandmark">Landmark (Optional)</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label
                                            class="xx-small fw-bold text-muted uppercase tracking-widest mb-2 d-block">ADDRESS
                                            TYPE</label>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="type" id="addHome" value="Home" checked>
                                            <label class="btn btn-outline-primary border py-2 rounded-3 me-2" for="addHome"><i
                                                    class="bi bi-house me-1"></i> Home</label>
                                            <input type="radio" class="btn-check" name="type" id="addWork" value="Work">
                                            <label class="btn btn-outline-primary border py-2 rounded-3" for="addWork"><i
                                                    class="bi bi-briefcase me-1"></i> Work</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-premium w-100 py-3 rounded-pill fw-black mt-4 shadow-sm">
                                    SAVE ADDRESS
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Address Modal -->
            <div class="modal fade" id="editAddressModal" aria-hidden="true"
                style="backdrop-filter: blur(5px); z-index: 10001;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow-lg" style="pointer-events: auto;">
                        <div class="modal-header border-0 p-4 pb-0">
                            <h5 class="fw-black mb-0">Edit Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <form id="editAddressForm" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-floating mb-1">
                                            <input type="text" name="name" class="form-control rounded-3" id="editName"
                                                placeholder="Full Name" required>
                                            <label for="editName">Full Name</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-1">
                                            <input type="text" name="mobile" class="form-control rounded-3" id="editMobile"
                                                placeholder="10-digit Mobile" required>
                                            <label for="editMobile">Mobile Number</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-1">
                                            <input type="text" name="alt_mobile" class="form-control rounded-3"
                                                id="editAltMobile" placeholder="Alt Mobile">
                                            <label for="editAltMobile">Alt Mobile (Optional)</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-1">
                                            <textarea name="address_line" class="form-control rounded-3" id="editAddress"
                                                placeholder="Address" style="height: 80px" required></textarea>
                                            <label for="editAddress">Full Address (Line, Street)</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-1">
                                            <input type="text" name="city" class="form-control rounded-3" id="editCity"
                                                placeholder="City" required>
                                            <label for="editCity">City</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-1">
                                            <input type="text" name="state" class="form-control rounded-3" id="editState"
                                                placeholder="State" required>
                                            <label for="editState">State</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-1">
                                            <input type="text" name="pincode" class="form-control rounded-3" id="editPincode"
                                                placeholder="Pincode" required>
                                            <label for="editPincode">Pincode</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-1">
                                            <input type="text" name="landmark" class="form-control rounded-3" id="editLandmark"
                                                placeholder="Landmark">
                                            <label for="editLandmark">Landmark (Optional)</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label
                                            class="xx-small fw-bold text-muted uppercase tracking-widest mb-2 d-block">ADDRESS
                                            TYPE</label>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="type" id="editHome" value="Home">
                                            <label class="btn btn-outline-primary border py-2 rounded-3 me-2" for="editHome"><i
                                                    class="bi bi-house me-1"></i> Home</label>
                                            <input type="radio" class="btn-check" name="type" id="editWork" value="Work">
                                            <label class="btn btn-outline-primary border py-2 rounded-3" for="editWork"><i
                                                    class="bi bi-briefcase me-1"></i> Work</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-premium w-100 py-3 rounded-pill fw-black mt-4 shadow-sm">
                                    UPDATE ADDRESS
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endpush

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function editAddress(address) {
                const form = document.getElementById('editAddressForm');
                form.action = `/addresses/update/${address.id}`;

                document.getElementById('editName').value = address.name;
                document.getElementById('editMobile').value = address.mobile;
                document.getElementById('editAltMobile').value = address.alt_mobile || '';
                document.getElementById('editAddress').value = address.address_line;
                document.getElementById('editCity').value = address.city;
                document.getElementById('editState').value = address.state;
                document.getElementById('editPincode').value = address.pincode;
                document.getElementById('editLandmark').value = address.landmark || '';

                if (address.type === 'Work') {
                    document.getElementById('editWork').checked = true;
                } else {
                    document.getElementById('editHome').checked = true;
                }

                new bootstrap.Modal(document.getElementById('editAddressModal')).show();
            }

            document.querySelectorAll('.btn-delete-address').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    const form = this.closest('.delete-address-form');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#FF7A18',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        background: '#fff',
                        borderRadius: '20px'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
@endsection