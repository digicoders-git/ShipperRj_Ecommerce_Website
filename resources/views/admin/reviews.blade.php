@extends('layouts.admin')

@section('title', 'Product Reviews')
@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Product Reviews</h5>
        <div class="badge bg-primary bg-opacity-10 text-white px-3 py-2 rounded-pill x-small fw-bold">
            {{ $reviews->count() }} Total Reviews
        </div>
    </div>

    <div class="glass-card border-0 shadow-lg overflow-hidden p-4">
        <div class="table-responsive">
            <table class="table table-hover table-borderless align-middle mb-0 admin-datatable">
                <thead class="bg-white bg-opacity-5">
                    <tr class="border-bottom border-white border-opacity-10 text-nowrap">
                        <th class="small fw-bold py-3 px-4">S No.</th>
                        <th class="small fw-bold py-3 px-4">USER</th>
                        <th class="small fw-bold py-3">PRODUCT</th>
                        <th class="small fw-bold py-3">RATING</th>
                        <th class="small fw-bold py-3">COMMENT</th>
                        <th class="small fw-bold py-3 text-center">STATUS</th>
                        <th class="small fw-bold py-3 px-4 text-end">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        <tr class="border-bottom border-white border-opacity-5 transition-all">
                            <td class="serial-cell">{{ $loop->iteration }}</td>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-20 d-flex align-items-center justify-content-center text-primary small fw-bold me-2" style="width: 35px; height: 35px;">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold small text-dark">{{ $review->user->name }}</div>
                                        <div class="xx-small text-muted">{{ $review->created_at->format('d M, Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center" style="max-width: 200px;">
                                    <img src="{{ asset($review->product->image) }}" class="rounded me-2" style="width: 35px; height: 35px; object-fit: cover;">
                                    <div class="text-truncate small fw-medium text-dark">{{ $review->product->name }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="text-warning small">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                            </td>
                            <td>
                                <div class="small text-dark opacity-75 text-wrap" style="max-width: 300px;">
                                    {{ Str::limit($review->comment, 100) }}
                                </div>
                            </td>
                            <td class="text-center">
                                @if($review->status == 1)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill x-small">Approved</span>
                                @elseif($review->status == 2)
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1 rounded-pill x-small">Rejected</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-1 rounded-pill x-small">Pending</span>
                                @endif
                            </td>
                            <td class="text-end px-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-sm btn-icon-premium" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $review->id }}">
                                        <i class="bi bi-eye text-info"></i>
                                    </button>
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon-premium">
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

    @push('modals')
    @foreach($reviews as $review)
        <!-- Admin Review Modal -->
        <div class="modal fade" id="reviewModal{{ $review->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content glass-card border-0 p-3 shadow-lg" style="background: #fff; border-radius: 20px;">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold text-dark">Review Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-4">
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img src="{{ asset($review->product->image) }}" class="rounded-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $review->product->name }}</h6>
                                    <div class="text-warning small mt-1">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted small bg-light p-3 rounded-4 mb-0 border">
                                "{{ $review->comment }}"
                            </p>
                            <div class="mt-2 text-end">
                                <span class="xx-small text-muted fw-bold italic">- {{ $review->user->name }} on {{ $review->created_at->format('d M, Y') }}</span>
                            </div>
                        </div>

                        <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label x-small fw-bold text-secondary text-uppercase">Moderation Status</label>
                                <select name="status" class="form-select border-0 bg-light shadow-none x-small rounded-3">
                                    <option value="0" {{ $review->status == 0 ? 'selected' : '' }}>Pending</option>
                                    <option value="1" {{ $review->status == 1 ? 'selected' : '' }}>Approve</option>
                                    <option value="2" {{ $review->status == 2 ? 'selected' : '' }}>Reject</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label x-small fw-bold text-secondary text-uppercase">Admin Reply (Optional)</label>
                                <textarea name="admin_reply" class="form-control border-0 bg-light shadow-none x-small rounded-3" rows="3" placeholder="Write a reply...">{{ $review->admin_reply }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 fw-bold py-2 shadow-sm rounded-pill text-uppercase">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @endpush
@endsection
