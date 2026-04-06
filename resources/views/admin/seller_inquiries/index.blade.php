@extends('layouts.admin')

@section('title', 'Seller Inquiries')

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Seller Inquiries</h5>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="glass-card">
        <div class="table-responsive">
            <table class="table admin-datatable table-borderless text-secondary align-middle">
                <thead>
                    <tr class="border-bottom border-white border-opacity-10">
                        <th class="serial-col">S.No</th>
                        <th class="small fw-bold py-3">Date</th>
                        <th class="small fw-bold py-3">Name</th>
                        <th class="small fw-bold py-3">Contact</th>
                        <th class="small fw-bold py-3">Business Name</th>
                        <th class="small fw-bold py-3">Status</th>
                        <th class="small fw-bold py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inquiries as $inquiry)
                        <tr class="border-bottom border-white border-opacity-5">
                            <td class="serial-cell fw-bold text-secondary">#{{ $loop->iteration }}</td>
                            <td class="small">{{ $inquiry->created_at->format('d M, Y') }}</td>
                            <td class="fw-bold text-white">{{ $inquiry->name }}</td>
                            <td class="small">
                                <div><i class="bi bi-envelope me-1"></i> {{ $inquiry->email }}</div>
                                <div><i class="bi bi-telephone me-1"></i> {{ $inquiry->phone }}</div>
                            </td>
                            <td class="small">{{ $inquiry->business_name ?? 'N/A' }}</td>
                            <td>
                                @if($inquiry->status == 'pending')
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2">Pending</span>
                                @elseif($inquiry->status == 'approved')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2">Approved</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2">Rejected</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.seller-inquiries.show', $inquiry->id) }}" class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5">
                                        <i class="bi bi-eye text-primary"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.seller-inquiries.destroy', $inquiry->id) }}" method="POST" class="delete-form">
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
    </div>
@endsection
