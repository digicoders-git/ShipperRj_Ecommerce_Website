@extends('layouts.admin')

@section('title', 'Inquiries')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-2 ps-1">
        <h5 class="fw-bold mb-0 text-white">Contact Inquiries</h5>
        <span class="badge bg-primary bg-opacity-20 text-white rounded-pill px-3 py-2 fw-bold" style="font-size: 0.75rem;">{{ $contacts->total() }} Total</span>
    </div>
</div>

<div class="glass-card p-4">
    <div class="table-responsive">
        <table class="table admin-datatable table-borderless text-secondary align-middle">
            <thead>
                <tr class="border-bottom border-white border-opacity-10">
                    <th class="small fw-bold py-3 text-white">ID</th>
                    <th class="small fw-bold py-3 text-white">Sender Info</th>
                    <th class="small fw-bold py-3 text-white">Subject</th>
                    <th class="small fw-bold py-3 text-white">Message</th>
                    <th class="small fw-bold py-3 text-white">Received Date</th>
                    <th class="small fw-bold py-3 text-end text-white">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                <tr class="border-bottom border-white border-opacity-5">
                    <td class="small text-white-50">#{{ $contact->id }}</td>
                    <td>
                        <div class="fw-bold text-white">{{ $contact->name }}</div>
                        <div class="small text-white">{{ $contact->email }}</div>
                        @if($contact->phone)
                            <div class="text-primary x-small fw-bold mt-1">{{ $contact->phone }}</div>
                        @endif
                    </td>
                    <td class="small text-white">{{ $contact->subject ?? 'N/A' }}</td>
                    <td class="small text-white-50">
                        {{ Str::limit($contact->message, 40) }}
                    </td>
                    <td class="small text-white-50">
                        <div class="text-white">{{ $contact->created_at->format('d M, Y') }}</div>
                        <div class="x-small">{{ $contact->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5" 
                                    data-bs-toggle="modal" data-bs-target="#viewModal{{ $contact->id }}">
                                <i class="bi bi-eye text-primary"></i>
                            </button>
                            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5 btn-delete">
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
    
    @if($contacts->hasPages())
    <div class="mt-4 pt-3 border-top border-white border-opacity-5">
        {{ $contacts->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

<style>
    .btn-icon-glass {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.2s;
    }
    .btn-icon-glass:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.2);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }
</style>

<!-- Modals outside table for correct display - Soft Light Theme -->
@foreach($contacts as $contact)
<div class="modal fade" id="viewModal{{ $contact->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 30px; background: #ffffff !important;">
            <div class="modal-header border-0 pb-0 pt-4 px-4 position-relative">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="bi bi-person-badge fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">{{ $contact->name }}</h5>
                        <p class="text-muted small mb-0">{{ $contact->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-4 mt-2">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 h-100 rounded-4" style="background: #f8f9fa; border: 1px solid #eef0f3;">
                            <label class="x-small fw-bold text-uppercase text-muted opacity-75 mb-1 d-block">Email Address</label>
                            <a href="mailto:{{ $contact->email }}" class="text-decoration-none text-dark fw-bold small d-block">{{ $contact->email }}</a>
                        </div>
                    </div>
                    @if($contact->phone)
                    <div class="col-md-6">
                        <div class="p-3 h-100 rounded-4" style="background: #f8f9fa; border: 1px solid #eef0f3;">
                            <label class="x-small fw-bold text-uppercase text-muted opacity-75 mb-1 d-block">Mobile Number</label>
                            <a href="tel:{{ $contact->phone }}" class="text-decoration-none text-primary fw-bold small d-block">{{ $contact->phone }}</a>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mb-4 ps-1">
                    <label class="x-small fw-bold text-uppercase text-muted opacity-75 mb-1 d-block">Inquiry Subject</label>
                    <h6 class="fw-bold text-dark mb-0">{{ $contact->subject ?? 'General Inquiry' }}</h6>
                </div>

                <div class="p-4 rounded-4" style="background: #ffffff; border: 1px solid #f0f0f0; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);">
                    <label class="x-small fw-bold text-uppercase text-muted opacity-75 mb-2 d-block">Message Message</label>
                    <p class="text-dark mb-0 lh-lg" style="font-size: 0.95rem;">
                        {{ $contact->message }}
                    </p>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4 d-flex gap-2">
                <a href="mailto:{{ $contact->email }}?subject=RE: {{ $contact->subject }}" class="btn btn-primary px-4 rounded-pill py-2 btn-sm fw-bold shadow-sm flex-grow-1">Reply via Email</a>
                <button type="button" class="btn btn-light px-4 rounded-pill py-2 btn-sm fw-bold border border-light text-muted shadow-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
