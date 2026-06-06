@extends('layouts.admin')

@section('title', 'Sub Admin Management')

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Sub Admin Management</h5>
        <a href="{{ route('admin.subadmins.create') }}" class="btn btn-add btn-sm px-4">
            <i class="bi bi-plus-lg me-2"></i> Add New Sub Admin
        </a>
    </div>

    <div class="glass-card">
        <div class="table-responsive">
            <table class="table admin-datatable table-borderless text-secondary align-middle mb-0">
                <thead>
                    <tr class="border-bottom border-white border-opacity-10">
                        <th class="small fw-bold py-3">Sub Admin Info</th>
                        <th class="small fw-bold py-3">Username</th>
                        <th class="small fw-bold py-3">Access Level</th>
                        <th class="small fw-bold py-3">Status</th>
                        <th class="small fw-bold py-3">Last Activity</th>
                        <th class="small fw-bold py-3 text-end">Actions Control</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subAdmins as $subadmin)
                        <tr class="border-bottom border-white border-opacity-5">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-20 d-flex align-items-center justify-content-center text-white small fw-bold me-3"
                                        style="width: 40px; height: 40px;">{{ substr($subadmin->name, 0, 1) }}</div>
                                    <div>
                                        <div class="fw-bold text-white small mb-0">{{ $subadmin->name }}</div>
                                        <div class="xx-small text-secondary fw-bold opacity-75">{{ $subadmin->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="badge bg-white bg-opacity-5 text-secondary border border-white border-opacity-10 px-3 py-2 rounded-3 x-small">
                                    <i class="bi bi-person me-1"></i> {{ $subadmin->username }}
                                </span>
                            </td>
                            <td>
                                <span
                                    class="badge bg-primary bg-opacity-10 text-light-soft border border-primary border-opacity-25 px-3 py-2 rounded-3 x-small">
                                    {{ count($subadmin->permissions ?? []) }} Modules Access
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.subadmins.toggle-status', $subadmin) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm border-0 p-0">
                                        @if($subadmin->status)
                                            <span
                                                class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-3 x-small">Active</span>
                                        @else
                                            <span
                                                class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 rounded-3 x-small">Inactive</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td>
                                @if($subadmin->last_login_at)
                                    <div class="x-small text-white fw-bold">{{ $subadmin->last_login_at->format('d M Y') }}</div>
                                    <div class="x-small text-secondary opacity-50">{{ $subadmin->last_login_at->format('h:i A') }}
                                    </div>
                                @else
                                    <span class="x-small text-secondary opacity-50">Never Active</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5"
                                        onclick="viewSubAdmin({{ json_encode($subadmin) }}, {{ json_encode($subadmin->permissions ?? []) }})"
                                        title="View Details">
                                        <i class="bi bi-eye text-info"></i>
                                    </button>

                                    <a href="{{ route('admin.subadmins.edit', $subadmin) }}"
                                        class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5"
                                        title="Edit Account">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </a>

                                    <form action="{{ route('admin.subadmins.destroy', $subadmin) }}" method="POST"
                                        class="d-inline border-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5 btn-delete"
                                            title="Delete Account">
                                            <i class="bi bi-trash text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sub Admin Details Modal -->
    <div class="modal fade" id="subAdminViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content overflow-hidden border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 p-4 text-white"
                    style="background: linear-gradient(135deg,  #efeae8ff 0%, #959392ff 100%); border-bottom: 3px solid var(--premium-orange);">
                    <div class="d-flex align-items-center">
                        <div class="p-2 rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="background: rgba(255, 255, 255, 0.1); width: 46px; height: 46px; border: 1px solid rgba(37, 37, 37, 0.15);">
                            <i class="bi bi-shield-lock-fill text-warning fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-black text-white outfit" id="modalSubAdminName">Account Details</h5>
                            <p class="text-white opacity-100 small mb-0 font-monospace" id="modalSubAdminUsername">admin_user</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white opacity-75 shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <div class="row g-4">
                        <!-- Basic Info -->
                        <div class="col-md-6">
                            <div class="p-4 bg-white rounded-4 shadow-sm h-100 border border-dark border-opacity-5 d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="fw-black mb-4 border-bottom pb-2 text-uppercase small ls-1 text-dark" style="letter-spacing: 0.5px;">
                                        <i class="bi bi-person-lines-fill me-2 text-primary"></i> Personal Information
                                    </h6>
                                    <div class="mb-3 d-flex align-items-start gap-3">
                                        <div class="p-2 rounded-3 bg-light text-primary" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-person-fill"></i></div>
                                        <div>
                                            <label class="xx-small text-muted fw-bold text-uppercase d-block mb-0" style="font-size: 0.65rem;">Full Name</label>
                                            <span class="fw-bold text-dark fs-6" id="viewName"></span>
                                        </div>
                                    </div>
                                    <div class="mb-3 d-flex align-items-start gap-3">
                                        <div class="p-2 rounded-3 bg-light text-primary" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-envelope-fill"></i></div>
                                        <div>
                                            <label class="xx-small text-muted fw-bold text-uppercase d-block mb-0" style="font-size: 0.65rem;">Email Id</label>
                                            <span class="fw-bold text-dark font-monospace" id="viewEmail"></span>
                                        </div>
                                    </div>
                                    <div class="mb-0 d-flex align-items-start gap-3">
                                        <div class="p-2 rounded-3 bg-light text-primary" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-telephone-fill"></i></div>
                                        <div>
                                            <label class="xx-small text-muted fw-bold text-uppercase d-block mb-0" style="font-size: 0.65rem;">Phone/Mobile</label>
                                            <span class="fw-bold text-dark" id="viewPhone"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Info -->
                        <div class="col-md-6">
                            <div class="p-4 bg-white rounded-4 shadow-sm h-100 border border-dark border-opacity-5 d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="fw-black mb-4 border-bottom pb-2 text-uppercase small ls-1 text-dark" style="letter-spacing: 0.5px;">
                                        <i class="bi bi-key-fill me-2 text-warning"></i> Security & Access
                                    </h6>
                                    <div class="mb-3 d-flex align-items-start gap-3">
                                        <div class="p-2 rounded-3 bg-light text-warning" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-activity"></i></div>
                                        <div>
                                            <label class="xx-small text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 0.65rem;">Status</label>
                                            <div id="viewStatus"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 d-flex align-items-start gap-3">
                                        <div class="p-2 rounded-3 bg-light text-warning" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-shield-lock"></i></div>
                                        <div>
                                            <label class="xx-small text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 0.65rem;">Current Password</label>
                                            <div class="d-flex align-items-center">
                                                <span class="fw-bold text-dark font-monospace bg-light px-3 py-1 rounded border small" id="viewPlainPassword">---</span>
                                                <span class="badge bg-success bg-opacity-10 text-success border-0 ms-2 xx-small fw-black text-uppercase">Decrypted</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-0 d-flex align-items-start gap-3">
                                        <div class="p-2 rounded-3 bg-light text-warning" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-calendar-check-fill"></i></div>
                                        <div>
                                            <label class="xx-small text-muted fw-bold text-uppercase d-block mb-0" style="font-size: 0.65rem;">Created On</label>
                                            <span class="fw-bold text-dark small" id="viewCreated"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Permissions Section -->
                        <div class="col-12">
                            <div class="p-4 bg-white rounded-4 shadow-sm border border-dark border-opacity-5">
                                <h6 class="fw-black mb-3 border-bottom pb-2 text-uppercase small ls-1 text-dark" style="letter-spacing: 0.5px;">
                                    <i class="bi bi-shield-check me-2 text-success"></i> Assigned System Permissions
                                </h6>
                                <div class="d-flex flex-wrap gap-2" id="viewPermissions" style="margin-top: 15px;">
                                    <!-- Populated dynamically -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0 bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-5 py-2.5 fw-bold border-0 transition-all hover-scale" 
                        data-bs-dismiss="modal" style="background: #475569 !important; box-shadow: 0 4px 6px rgba(71, 85, 105, 0.2);">
                        Close Panel
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function viewSubAdmin(admin, permissions) {
                // Basic Info
                $('#modalSubAdminName').text(admin.name);
                $('#modalSubAdminUsername').text('@' + admin.username);
                $('#viewName').text(admin.name);
                $('#viewEmail').text(admin.email);
                $('#viewPhone').text(admin.mobile || '---');
                $('#viewPlainPassword').text(admin.plain_password || 'Not Available');
                $('#viewCreated').text(new Date(admin.created_at).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }));

                // Status Badge
                const statusHtml = admin.status
                    ? '<span class="badge bg-success-soft text-success border-0 px-3 py-2 fw-black small text-uppercase"><i class="bi bi-check-circle-fill me-2"></i>Active Account</span>'
                    : '<span class="badge bg-danger-soft text-danger border-0 px-3 py-2 fw-black small text-uppercase"><i class="bi bi-x-circle-fill me-2"></i>Inactive Account</span>';
                $('#viewStatus').html(statusHtml);

                // Permissions Badges
                let permHtml = '';
                if (permissions && permissions.length > 0) {
                    permissions.forEach(p => {
                        const label = p.replace('_', ' ').toUpperCase();
                        permHtml += `<span class="badge bg-warning bg-opacity-10 text-orange border border-warning border-opacity-25 px-3 py-2 fw-bold xx-small ls-1 m-1 d-inline-flex align-items-center gap-1 text-uppercase" style="color: #f2701a !important; background: rgba(242, 112, 26, 0.08) !important; border: 1px solid rgba(242, 112, 26, 0.2) !important;"><i class="bi bi-patch-check-fill" style="color: #f2701a;"></i> ${label}</span>`;
                    });
                } else {
                    permHtml = '<span class="text-muted small fw-bold">No permissions assigned yet.</span>';
                }
                $('#viewPermissions').html(permHtml);

                // Show Modal
                const modalElement = document.getElementById('subAdminViewModal');
                const myModal = new bootstrap.Modal(modalElement);
                myModal.show();
            }
        </script>
    @endpush
@endsection