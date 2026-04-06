@extends('layouts.admin')

@section('title', 'View Seller Inquiry')

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Inquiry Details #{{ $inquiry->id }}</h5>
        <a href="{{ route('admin.seller-inquiries.index') }}" class="btn btn-sm btn-outline-dark px-3 border-0 bg-white bg-opacity-5">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-8">
            <div class="glass-card p-4">
                <h6 class="fw-bold border-bottom border-white border-opacity-10 pb-3 mb-4">Applicant Information</h6>
                
                <div class="row mb-4">
                    <div class="col-sm-4 text-secondary small text-uppercase fw-bold">Full Name</div>
                    <div class="col-sm-8 text-white">{{ $inquiry->name }}</div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-sm-4 text-secondary small text-uppercase fw-bold">Email Address</div>
                    <div class="col-sm-8 text-white"><a href="mailto:{{ $inquiry->email }}" class="text-primary text-decoration-none">{{ $inquiry->email }}</a></div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-sm-4 text-secondary small text-uppercase fw-bold">Phone Number</div>
                    <div class="col-sm-8 text-white"><a href="tel:{{ $inquiry->phone }}" class="text-primary text-decoration-none">{{ $inquiry->phone }}</a></div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-sm-4 text-secondary small text-uppercase fw-bold">Business Name</div>
                    <div class="col-sm-8 text-white">{{ $inquiry->business_name ?? 'N/A' }}</div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-sm-4 text-secondary small text-uppercase fw-bold">Business Type</div>
                    <div class="col-sm-8 text-white">{{ $inquiry->business_type ?? 'N/A' }}</div>
                </div>
                
                <div class="row mb-0">
                    <div class="col-sm-4 text-secondary small text-uppercase fw-bold">Message</div>
                    <div class="col-sm-8 text-white">
                        <div class="p-3 bg-white bg-opacity-5 rounded-3 border border-white border-opacity-10">
                            {{ $inquiry->message ?? 'No message provided.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="glass-card p-4 mb-4 text-center">
                <h6 class="fw-bold border-bottom border-white border-opacity-10 pb-3 mb-4">Inquiry Status</h6>
                
                <div class="mb-4">
                    @if($inquiry->status == 'pending')
                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-4 py-3 h5 mb-0">PENDING</span>
                    @elseif($inquiry->status == 'approved')
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-4 py-3 h5 mb-0">APPROVED</span>
                    @else
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-4 py-3 h5 mb-0">REJECTED</span>
                    @endif
                </div>
                
                <form action="{{ route('admin.seller-inquiries.update', $inquiry->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <select name="status" class="form-select glass-input text-center">
                            <option value="pending" {{ $inquiry->status == 'pending' ? 'selected' : '' }}>Set as Pending</option>
                            <option value="approved" {{ $inquiry->status == 'approved' ? 'selected' : '' }}>Approve Application</option>
                            <option value="rejected" {{ $inquiry->status == 'rejected' ? 'selected' : '' }}>Reject Application</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-premium w-100 py-3">Update Status</button>
                </form>
            </div>
            
            <div class="glass-card p-4">
                <div class="text-secondary x-small text-uppercase fw-bold mb-2">Submission Date</div>
                <div class="text-white small mb-3">{{ $inquiry->created_at->format('d F, Y — h:i A') }}</div>
                
                <div class="text-secondary x-small text-uppercase fw-bold mb-2">Last Updated</div>
                <div class="text-white small">{{ $inquiry->updated_at->format('d F, Y — h:i A') }}</div>
            </div>
        </div>
    </div>
@endsection
