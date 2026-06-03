@extends('layouts.admin')

@section('title', 'Manage FAQs')

@section('admin_content')
    @php
        $isAdmin = auth('admin')->check();
        $subAdmin = auth('subadmin')->user();
    @endphp
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Manage FAQs</h5>
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('faqs_add')))
            <button class="btn btn-add btn-sm px-4" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                <i class="bi bi-plus-lg me-2"></i> Add New FAQ
            </button>
        @endif
    </div>

    <div class="glass-card">
        <div class="table-responsive">
            <table class="table admin-datatable table-borderless text-secondary align-middle">
                <thead>
                    <tr class="border-bottom border-white border-opacity-10">
                        <th class="serial-col">S.No</th>
                        <th class="small fw-bold py-3">Question</th>
                        <th class="small fw-bold py-3">Answer</th>
                        <th class="small fw-bold py-3">Sort Order</th>
                        <th class="small fw-bold py-3">Status</th>
                        <th class="small fw-bold py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faqs as $faq)
                        <tr class="border-bottom border-white border-opacity-5">
                            <td class="serial-cell fw-bold text-secondary">#{{ $loop->iteration }}</td>
                            <td class="fw-bold text-white">{{ $faq->question }}</td>
                            <td class="small text-secondary" style="max-width: 400px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {!! strip_tags($faq->answer) !!}
                            </td>
                            <td class="small text-center">{{ $faq->sort_order }}</td>
                            <td>
                                @if($faq->status == 1)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2">Active</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('faqs_edit')))
                                        <button class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5"
                                            data-bs-toggle="modal" data-bs-target="#editFaqModal{{ $faq->id }}">
                                            <i class="bi bi-pencil-square text-primary"></i>
                                        </button>
                                    @endif

                                    @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('faqs_delete')))
                                        <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5 btn-delete">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @foreach($faqs as $faq)
        <!-- Edit Modal -->
        <div class="modal fade" id="editFaqModal{{ $faq->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content glass-card border-0 p-3">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">Edit FAQ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-4">
                        <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label text-secondary small">Question</label>
                                    <input type="text" name="question" class="form-control glass-input" value="{{ $faq->question }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label text-secondary small">Answer</label>
                                    <textarea name="answer" class="form-control glass-input" rows="4" required>{{ $faq->answer }}</textarea>
                                    <small class="text-white-50">Note: You can write HTML tags like &lt;strong&gt;, &lt;span class="highlight-badge"&gt;, or links.</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small">Sort Order</label>
                                    <input type="number" name="sort_order" class="form-control glass-input" value="{{ $faq->sort_order }}" placeholder="0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small">Status</label>
                                    <select name="status" class="form-select glass-input">
                                        <option value="1" {{ $faq->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $faq->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer-custom">
                                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-premium btn-submit-small">Update FAQ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Add FAQ Modal -->
    <div class="modal fade" id="addFaqModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content glass-card border-0 p-3">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Add New FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4">
                    <form action="{{ route('admin.faqs.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-secondary small">Question</label>
                                <input type="text" name="question" class="form-control glass-input" placeholder="Enter FAQ question" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-secondary small">Answer</label>
                                <textarea name="answer" class="form-control glass-input" placeholder="Enter FAQ answer" rows="4" required></textarea>
                                <small class="text-white-50">Note: You can write HTML tags like &lt;strong&gt;, &lt;span class="highlight-badge"&gt;, or links.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary small">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control glass-input" placeholder="0" value="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary small">Status</label>
                                <select name="status" class="form-select glass-input">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer-custom">
                            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-premium btn-submit-small">Save FAQ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
