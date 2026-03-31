@extends('layouts.admin')

@section('title', 'Support & Feedback')

@section('admin_content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h5 class="fw-bold mb-0">Support & Feedback Tickets</h5>
        <p class="text-secondary small">Manage user inquiries and suggestions</p>
    </div>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table admin-datatable table-borderless text-secondary align-middle">
            <thead>
                <tr class="border-bottom border-white border-opacity-10">
                    <th class="small fw-bold py-3 text-white">Ref</th>
                    <th class="small fw-bold py-3 text-white">Contact Info</th>
                    <th class="small fw-bold py-3 text-white">Message Snippet</th>
                    <th class="small fw-bold py-3 text-white">Suggestion</th>
                    <th class="small fw-bold py-3 text-white">Timestamp</th>
                    <th class="small fw-bold py-3 text-end text-white">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                <tr class="border-bottom border-white border-opacity-5">
                    <td class="small">#ST-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div class="small text-white fw-bold">{{ $ticket->name }}</div>
                        <div class="x-small text-secondary">{{ $ticket->email }}</div>
                        <div class="x-small text-primary fw-bold">{{ $ticket->phone }}</div>
                    </td>
                    <td class="small text-white">
                        <div class="text-truncate" style="max-width: 350px;">{{ $ticket->message }}</div>
                        @if($ticket->suggestion)
                            <div class="x-small text-success mt-1"><i class="bi bi-lightbulb me-1"></i> Suggestion Included</div>
                        @endif
                    </td>
                    <td class="small text-white">
                        <div class="text-truncate" style="max-width: 350px;">{{ $ticket->suggestion }}</div>
                    </td>
                    <td class="small">{{ $ticket->created_at->format('d M, Y h:i A') }}</td>
                    <td class="text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5" 
                                    data-bs-toggle="modal" data-bs-target="#viewTicketModal{{ $ticket->id }}" title="View Full Details">
                                <i class="bi bi-eye text-primary"></i>
                            </button>
                            <form action="{{ route('admin.support-tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5 btn-delete" title="Delete Ticket">
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

@foreach($tickets as $ticket)
<!-- View Ticket Modal -->
<div class="modal fade" id="viewTicketModal{{ $ticket->id }}" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card border border-white border-opacity-10 p-3 shadow-2xl overflow-hidden">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-white">Ticket Details: #ST-{{ $ticket->id }}</h5>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <div class="p-4 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-5">
                            <h6 class="x-small text-warning fw-black uppercase tracking-widest mb-4">Sender Information</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3 mb-md-0 border-end border-white border-opacity-10">
                                    <label class="xx-small text-secondary uppercase fw-bold mb-1 d-block tracking-widest">Full Name</label>
                                    <div class="h6 text-white fw-bold mb-0">{{ $ticket->name }}</div>
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0 border-end border-white border-opacity-10">
                                    <label class="xx-small text-secondary uppercase fw-bold mb-1 d-block tracking-widest">Email Address</label>
                                    <div class="h6 text-white mb-0">{{ $ticket->email }}</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="xx-small text-secondary uppercase fw-bold mb-1 d-block tracking-widest">Phone Number</label>
                                    <div class="h6 text-primary fw-bold mb-0">{{ $ticket->phone }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="x-small text-primary fw-black uppercase tracking-widest mb-2">Problem / Message</label>
                    <div class="p-4 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10 small text-white line-height-md overflow-auto" style="max-height: 200px;">
                        {{ $ticket->message }}
                    </div>
                </div>

                @if($ticket->suggestion)
                <div class="mb-2">
                    <label class="x-small text-success fw-black uppercase tracking-widest mb-2">Feedback / Suggestion</label>
                    <div class="p-4 rounded-4 bg-white bg-opacity-5 border border-success border-opacity-20 small text-white line-height-md overflow-auto shadow-inner" style="max-height: 200px;">
                        <i class="bi bi-stars text-success me-2 opacity-50"></i>
                        {{ $ticket->suggestion }}
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center">
                <button type="button" class="btn btn-premium px-5 py-2 rounded-pill fw-black uppercase tracking-widest x-small" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
