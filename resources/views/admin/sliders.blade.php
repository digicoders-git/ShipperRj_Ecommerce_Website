@extends('layouts.admin')

@section('title', 'Manage Hero Sliders')

@section('admin_content')
    @php
        $isAdmin = auth('admin')->check();
        $subAdmin = auth('subadmin')->user();
    @endphp
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Manage Hero Sliders</h5>
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('home_sliders_add')))
            <button class="btn btn-add btn-sm px-4" data-bs-toggle="modal" data-bs-target="#addSliderModal">
                <i class="bi bi-plus-lg me-2"></i> Add New Slider
            </button>
        @endif
    </div>

    <div class="glass-card">
        <div class="table-responsive">
            <table class="table admin-datatable table-borderless text-secondary align-middle">
                <thead>
                    <tr class="border-bottom border-white border-opacity-10">
                        <th class="serial-col">S.No</th>
                        <th class="small fw-bold py-3">Image</th>
                        <th class="small fw-bold py-3">Badge & Title</th>
                        <th class="small fw-bold py-3">Background</th>
                        <th class="small fw-bold py-3">Sort Order</th>
                        <th class="small fw-bold py-3">Status</th>
                        <th class="small fw-bold py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sliders as $slider)
                        <tr class="border-bottom border-white border-opacity-5">
                            <td class="serial-cell fw-bold text-secondary">#{{ $loop->iteration }}</td>
                            <td class="py-3">
                                @if($slider->image)
                                    <img src="{{ asset($slider->image) }}" class="rounded shadow-sm border border-secondary" style="height: 50px; width: 80px; object-fit: cover;">
                                @else
                                    <span class="text-muted small">No Image</span>
                                @endif
                            </td>
                            <td>
                                @if($slider->badge)
                                    <span class="badge bg-primary bg-opacity-20 text-primary-emphasis px-2 py-1 mb-1 small">{{ $slider->badge }}</span><br>
                                @endif
                                <span class="fw-bold text-white">{!! strip_tags($slider->title) !!}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-inline-block rounded-circle border border-secondary" style="width: 20px; height: 20px; background-color: {{ $slider->bg_color ?? '#F4F7F9' }};"></span>
                                    <code class="small text-secondary">{{ $slider->bg_color ?? '#F4F7F9' }}</code>
                                </div>
                            </td>
                            <td class="small text-center">{{ $slider->sort_order }}</td>
                            <td>
                                @if($slider->status == 1)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2">Active</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('home_sliders_edit')))
                                        <button class="btn btn-sm btn-outline-light border-0 bg-white bg-opacity-5"
                                            data-bs-toggle="modal" data-bs-target="#editSliderModal{{ $slider->id }}">
                                            <i class="bi bi-pencil-square text-primary"></i>
                                        </button>
                                    @endif

                                    @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('home_sliders_delete')))
                                        <form action="{{ route('admin.home-sliders.destroy', $slider->id) }}" method="POST" class="delete-form">
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

    @foreach($sliders as $slider)
        <!-- Edit Modal -->
        <div class="modal fade" id="editSliderModal{{ $slider->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content glass-card border-0 p-3">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">Edit Hero Slider</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-4">
                        <form action="{{ route('admin.home-sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small">Badge</label>
                                    <input type="text" name="badge" class="form-control glass-input" value="{{ $slider->badge }}" placeholder="e.g. Super Deal">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small">Background Color (Hex code)</label>
                                    <div class="input-group">
                                        <input type="color" class="form-control form-control-color glass-input border-end-0" style="max-width: 50px; padding: 6px; height: 100%;" value="{{ $slider->bg_color ?? '#F4F7F9' }}" onchange="document.getElementById('edit_bg_color_text{{ $slider->id }}').value = this.value">
                                        <input type="text" name="bg_color" id="edit_bg_color_text{{ $slider->id }}" class="form-control glass-input" value="{{ $slider->bg_color ?? '#F4F7F9' }}" placeholder="#F4F7F9" required>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label text-secondary small">Title</label>
                                    <textarea name="title" class="form-control glass-input" rows="2" required>{{ $slider->title }}</textarea>
                                    <small class="text-white-50">Note: You can write HTML tags like &lt;br&gt;, &lt;span class="text-gradient-primary"&gt; to style selected words.</small>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label text-secondary small">Subtitle (Optional)</label>
                                    <input type="text" name="subtitle" class="form-control glass-input" value="{{ $slider->subtitle }}" placeholder="e.g. BIG SALE UP TO 50% OFF">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label text-secondary small">Description</label>
                                    <textarea name="description" class="form-control glass-input" rows="3">{{ $slider->description }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small">Button Text</label>
                                    <input type="text" name="button_text" class="form-control glass-input" value="{{ $slider->button_text }}" placeholder="Shop Now">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small">Button URL</label>
                                    <input type="text" name="button_url" class="form-control glass-input" value="{{ $slider->button_url }}" placeholder="/products">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small">Sort Order</label>
                                    <input type="number" name="sort_order" class="form-control glass-input" value="{{ $slider->sort_order }}" placeholder="0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small">Status</label>
                                    <select name="status" class="form-select glass-input">
                                        <option value="1" {{ $slider->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $slider->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label text-secondary small">Slider Image (Recommended size: 600x600 px)</label>
                                    <input type="file" name="image" class="form-control glass-input" accept="image/*">
                                    @if($slider->image)
                                        <div class="mt-2">
                                            <span class="text-secondary small d-block mb-1">Current Image:</span>
                                            <img src="{{ asset($slider->image) }}" class="rounded border" style="max-height: 80px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer-custom">
                                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-premium btn-submit-small">Update Slider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Add Slider Modal -->
    <div class="modal fade" id="addSliderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content glass-card border-0 p-3">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Add New Hero Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4">
                    <form action="{{ route('admin.home-sliders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary small">Badge</label>
                                <input type="text" name="badge" class="form-control glass-input" placeholder="e.g. Super Deal">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary small">Background Color (Hex code)</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color glass-input border-end-0" style="max-width: 50px; padding: 6px; height: 100%;" value="#F4F7F9" onchange="document.getElementById('add_bg_color_text').value = this.value">
                                    <input type="text" name="bg_color" id="add_bg_color_text" class="form-control glass-input" value="#F4F7F9" placeholder="#F4F7F9" required>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-secondary small">Title</label>
                                <textarea name="title" class="form-control glass-input" rows="2" placeholder="Enter slider title" required></textarea>
                                <small class="text-white-50">Note: You can write HTML tags like &lt;br&gt;, &lt;span class="text-gradient-primary"&gt; to style selected words.</small>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-secondary small">Subtitle (Optional)</label>
                                <input type="text" name="subtitle" class="form-control glass-input" placeholder="e.g. BIG SALE UP TO 50% OFF">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-secondary small">Description</label>
                                <textarea name="description" class="form-control glass-input" rows="3" placeholder="Enter slider description"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary small">Button Text</label>
                                <input type="text" name="button_text" class="form-control glass-input" value="Shop Now" placeholder="Shop Now">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary small">Button URL</label>
                                <input type="text" name="button_url" class="form-control glass-input" value="/products" placeholder="/products">
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
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-secondary small">Slider Image (Recommended size: 600x600 px)</label>
                                <input type="file" name="image" class="form-control glass-input" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer-custom">
                            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-premium btn-submit-small">Save Slider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
