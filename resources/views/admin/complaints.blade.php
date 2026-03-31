@extends('layouts.admin')

@section('title', 'Complaints')

@section('admin_content')
<div class="mb-4">
    <h5 class="fw-bold mb-0">Customer Complaints</h5>
    <p class="text-secondary small">Review and resolve user support tickets</p>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table admin-datatable table-borderless text-secondary align-middle">
            <thead>
                <tr class="border-bottom border-white border-opacity-10">
                    <th class="small fw-bold py-3">ID</th>
                    <th class="small fw-bold py-3">Customer</th>
                    <th class="small fw-bold py-3">Product</th>
                    <th class="small fw-bold py-3">Subject</th>
                    <th class="small fw-bold py-3">Status</th>
                    <th class="small fw-bold py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($complaints as $complaint)
                <tr class="border-bottom border-white border-opacity-5">
                    <td class="small">#{{ $loop->iteration }}</td>
                    <td>
                        <div class="small text-white">{{ $complaint->user->name }}</div>
                        <div class="x-small text-secondary">{{ $complaint->user->mobile }}</div>
                    </td>
                    <td>
                        @if($complaint->product)
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset($complaint->product->image) }}" class="rounded" style="width: 25px; height: 25px; object-fit: cover;">
                                <div class="x-small text-truncate text-white" style="max-width: 100px;">{{ $complaint->product->name }}</div>
                            </div>
                        @else
                            <span class="x-small text-secondary italic">N/A</span>
                        @endif
                    </td>
                    <td class="small text-white fw-bold">{{ $complaint->subject }}</td>
                    <td>
                        <span class="badge bg-{{ $complaint->status == 'open' || $complaint->status == 'pending' ? 'danger' : ($complaint->status == 'in_progress' ? 'warning' : 'success') }} bg-opacity-10 text-{{ $complaint->status == 'open' || $complaint->status == 'pending' ? 'danger' : ($complaint->status == 'in_progress' ? 'warning' : 'success') }} px-2 py-1 x-small">
                            {{ strtoupper(str_replace('_', ' ', $complaint->status)) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5" data-bs-toggle="modal" data-bs-target="#resolveComplaintModal{{ $complaint->id }}">
                            <i class="bi bi-chat-left-text text-primary"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('modals')
    @foreach($complaints as $complaint)
        <!-- Resolve Complaint Modal -->
        <div class="modal fade" id="resolveComplaintModal{{ $complaint->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 p-3 shadow-lg" style="background: #fff; border-radius: 20px;">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold text-dark">Support Case Resolution</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-4">
                        <div class="mb-4">
                            <label class="xx-small fw-bold text-secondary text-uppercase mb-2 d-block">Customer Issue & Message</label>
                            <div class="bg-light p-3 rounded-4 border">
                                <span class="d-block small fw-bold text-dark mb-1 text-uppercase">{{ $complaint->subject }}</span>
                                <p class="small text-muted mb-0 italic">"{{ $complaint->message }}"</p>
                                
                                @if($complaint->product)
                                    <div class="d-flex align-items-center gap-3 mt-3 pt-3 border-top">
                                        <img src="{{ asset($complaint->product->image) }}" class="rounded-3 shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0 x-small fw-bold text-dark">{{ $complaint->product->name }}</h6>
                                            <span class="xx-small text-muted fw-semi-bold">SKU: {{ $complaint->product->sku }}</span>
                                        </div>
                                    </div>
                                @endif
                                <div class="mt-2 text-end">
                                    <span class="xx-small text-muted fw-bold italic">- {{ $complaint->user->name }}</span>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.complaints.update', $complaint->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label x-small fw-bold text-secondary text-uppercase">Moderation Status</label>
                                <select name="status" class="form-select border-0 bg-light shadow-none x-small rounded-3">
                                    <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="closed" {{ $complaint->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label x-small fw-bold text-secondary text-uppercase">Admin Resolution Response</label>
                                <textarea name="admin_comment" class="form-control border-0 bg-light shadow-none x-small rounded-3" rows="3" placeholder="Write our response to user...">{{ $complaint->admin_comment }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 fw-bold py-2 shadow-sm rounded-pill text-uppercase">Save Resolution</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endpush
            </tbody>
        </table>
    </div>
</div>
@endsection









