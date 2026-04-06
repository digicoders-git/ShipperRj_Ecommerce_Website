@extends('layouts.admin')

@section('title', 'Products')
@section('admin_content')
    @php
        $isAdmin = auth('admin')->check();
        $subAdmin = auth('subadmin')->user();
    @endphp
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Manage Products</h5>
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('products_add')))
            <button class="btn btn-add btn-sm px-4" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-lg me-2"></i> Add New Product
            </button>
        @endif
    </div>

    <div class="glass-card border-0 shadow-lg overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover table-borderless align-middle mb-0">
                <thead class="bg-white bg-opacity-5">
                    <tr class="border-bottom border-white border-opacity-10 text-nowrap">
                        <th class="small fw-bold py-3">S No.</th>
                        <th class="small fw-bold py-3">REF ID</th>
                        <th class="small fw-bold py-3 ">PRODUCT INFO</th>
                        <th class="small fw-bold py-3 ">CLASSIFICATION</th>
                        <th class="small fw-bold py-3 ">Price & Discount</th>
                        <th class="small fw-bold py-3 ">Stock</th>
                        <th class="small fw-bold py-3 text-center ">Status</th>
                        <th class="small fw-bold py-3 px-4 text-end ">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="border-bottom border-white border-opacity-5 transition-all">
                            <td>#{{ $loop->iteration }}</td>
                            <td class="small px-4 text-secondary">{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-3">
                                        @if($product->image)
                                            <img src="{{ asset($product->image) }}"
                                                class="rounded-3 shadow-sm border border-white border-opacity-10"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="rounded-3 bg-primary bg-opacity-20 d-flex align-items-center justify-content-center text-white small fw-bold"
                                                style="width: 50px; height: 50px;">{{ substr($product->name, 0, 1) }}</div>
                                        @endif
                                    </div>
                                    <div style="max-width: 200px;">
                                        <div class="fw-extrabold small text-white text-truncate mb-0">{{ $product->name }}</div>
                                        <div class="x-small text-secondary opacity-50 tracking-tight">SKU:
                                            {{ $product->sku ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small fw-bold text-white">{{ $product->subCategory->category->name }}</div>
                                <div class="x-small text-secondary opacity-75 d-flex align-items-center">
                                    <i class="bi bi-arrow-return-right me-1 opacity-50"></i>{{ $product->subCategory->name }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <div class="small fw-bold text-white">₹{{ number_format($product->selling_price, 2) }}</div>
                                    <div class="x-small text-secondary text-decoration-line-through">
                                        ₹{{ number_format($product->mrp, 2) }}</div>
                                    @if($product->mrp > $product->selling_price)
                                        @php $off = round((($product->mrp - $product->selling_price) / $product->mrp) * 100); @endphp
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success x-small px-1 py-0 mt-1 d-inline-block border border-success border-opacity-25"
                                            style="width: fit-content;">{{ $off }}% OFF</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column align-items-start">
                                    <span
                                        class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }} bg-opacity-10 text-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }} border border-white border-opacity-10 mb-1 px-2 py-1 x-small fw-bold">
                                        <i class="bi {{ $product->stock > 0 ? 'bi-check2-circle' : 'bi-x-circle' }} me-1"></i>
                                        {{ $product->stock_status }}
                                    </span>
                                    <div class="x-small text-secondary opacity-50 ps-1">{{ $product->stock }} units</div>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($product->status == 1)
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill x-small">Active</span>
                                @else
                                    <span
                                        class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 rounded-pill x-small">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end px-4">
                                <div class="d-flex justify-content-end gap-2 action-group">
                                    <button class="btn btn-sm btn-icon-premium" data-bs-toggle="modal"
                                        data-bs-target="#viewProductModal{{ $product->id }}" title="View Details">
                                        <i class="bi bi-eye text-info"></i>
                                    </button>
                                    @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('products_edit')))
                                        <button class="btn btn-sm btn-icon-premium" data-bs-toggle="modal"
                                            data-bs-target="#editProductModal{{ $product->id }}" title="Edit Product">
                                            <i class="bi bi-pencil-square text-primary"></i>
                                        </button>
                                    @endif

                                    @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('products_delete')))
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            class="delete-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-icon-premium btn-delete"
                                                title="Delete Product">
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
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>

        @push('modals')
            @foreach($products as $product)
                <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content glass-card border-0 p-3">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold text-black small">Edit Product: {{ $product->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pt-4 scrollable-modal-body" style="max-height: 70vh; overflow-y: auto;">
                                <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-3">
                                        <!-- Basic Information Section -->
                                        <div class="col-12">
                                            <h6 class="text-primary fw-bold mb-2 d-flex align-items-center x-small">
                                                <i class="bi bi-info-circle me-2"></i> Basic Information
                                            </h6>
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <label class="form-label text-secondary x-small fw-bold">CATEGORY</label>
                                                    <select class="form-select glass-input shadow-none edit-category-select x-small"
                                                        data-product-id="{{ $product->id }}">
                                                        @foreach($categories as $cat)
                                                            <option value="{{ $cat->id }}" {{ $product->subCategory->category_id == $cat->id ? 'selected' : '' }}>
                                                                {{ $cat->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label text-secondary x-small fw-bold">SUB CATEGORY</label>
                                                    <select name="subcategory_id"
                                                        class="form-select glass-input shadow-none edit-subcategory-select-{{ $product->id }} x-small"
                                                        required>
                                                        @foreach($subCategories as $sub)
                                                            <option value="{{ $sub->id }}" {{ $product->subcategory_id == $sub->id ? 'selected' : '' }} data-category="{{ $sub->category_id }}"
                                                                style="{{ $product->subCategory->category_id == $sub->category_id ? 'display:block;' : 'display:none;' }}">
                                                                {{ $sub->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label text-secondary x-small fw-bold">PRODUCT TITLE</label>
                                                    <input type="text" name="name" class="form-control glass-input x-small"
                                                        value="{{ $product->name }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label text-secondary x-small fw-bold">BRAND NAME</label>
                                                    <input type="text" name="brand" class="form-control glass-input x-small"
                                                        value="{{ $product->brand }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label text-secondary x-small fw-bold">MANUFACTURER</label>
                                                    <input type="text" name="manufacturer" class="form-control glass-input x-small"
                                                        value="{{ $product->manufacturer }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label text-secondary x-small fw-bold">SELLER NAME</label>
                                                    <input type="text" name="seller_name" class="form-control glass-input x-small"
                                                        value="{{ $product->seller_name }}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pricing & Stock Section -->
                                        <div class="col-12">
                                            <h6 class="text-primary fw-bold mb-2 d-flex align-items-center x-small">
                                                <i class="bi bi-currency-rupee me-2"></i> Pricing & Inventory
                                            </h6>
                                            <div class="row g-2">
                                                <div class="col-md-3">
                                                    <label class="form-label text-secondary x-small fw-bold">MRP</label>
                                                    <input type="number" name="mrp" class="form-control glass-input x-small"
                                                        value="{{ $product->mrp }}" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label text-secondary x-small fw-bold">SELLING</label>
                                                    <input type="number" name="selling_price"
                                                        class="form-control glass-input x-small"
                                                        value="{{ $product->selling_price }}" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label text-secondary x-small fw-bold">STOCK</label>
                                                    <input type="number" name="stock" class="form-control glass-input x-small"
                                                        value="{{ $product->stock ?? 0 }}" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label text-secondary x-small fw-bold">SKU</label>
                                                    <input type="text" name="sku" class="form-control glass-input x-small"
                                                        value="{{ $product->sku }}">
                                                </div>
                                                <!-- <div class="col-md-3">
                                                                <label class="form-label text-secondary x-small fw-bold">ONLINE SHIPPING
                                                                    (%)</label>
                                                                <input type="number" name="online_shipping_charges"
                                                                    class="form-control glass-input x-small"
                                                                    value="{{ $product->online_shipping_charges }}" step="0.01"
                                                                    placeholder="Global default">
                                                                <div class="xx-small text-secondary mt-1">Leave blank for global default (%)
                                                                </div>
                                                            </div> -->
                                                <!-- <div class="col-md-3">
                                                                <label class="form-label text-secondary x-small fw-bold">COD SHIPPING
                                                                    (%)</label>
                                                                <input type="number" name="cod_shipping_charges"
                                                                    class="form-control glass-input x-small"
                                                                    value="{{ $product->cod_shipping_charges }}" step="0.01"
                                                                    placeholder="Global default">
                                                                <div class="xx-small text-secondary mt-1">Leave blank for global default (%)
                                                                </div>
                                                            </div> -->
                                                <div class="col-md-3">
                                                    <label class="form-label text-secondary x-small fw-bold">MIN QTY</label>
                                                    <input type="number" name="minimum_order_quantity"
                                                        class="form-control glass-input x-small"
                                                        value="{{ $product->minimum_order_quantity ?? 1 }}" placeholder="1">
                                                </div>
                                                <!-- <div class="col-md-3">
                                                                <label class="form-label text-secondary x-small fw-bold">COD ADVANCE %</label>
                                                                <input type="number" name="cod_advance_percent"
                                                                    class="form-control glass-input x-small"
                                                                    value="{{ $product->cod_advance_percent }}" step="0.01"
                                                                    placeholder="Global default">
                                                                <div class="xx-small text-secondary mt-1">Leave blank for global default (%)
                                                                </div>
                                                            </div> -->

                                            </div>
                                        </div>

                                        <!-- Specifications Section -->
                                        <div class="col-12">
                                            <h6 class="text-primary fw-bold mb-2 d-flex align-items-center x-small">
                                                <i class="bi bi-gear me-2"></i> Specifications
                                            </h6>
                                            <div class="row g-2">
                                                <div class="col-md-3">
                                                    <label class="form-label text-secondary xx-small fw-bold">SIZES</label>
                                                    <div id="size-container-{{ $product->id }}">
                                                        <div class="position-relative mb-1">
                                                            <input type="text" name="size[]"
                                                                class="form-control glass-input x-small pe-4"
                                                                placeholder="Add Size">
                                                            <i class="bi bi-plus-lg position-absolute end-0 top-50 translate-middle-y me-2 text-primary cursor-pointer"
                                                                onclick="addDynamicField('size-container-{{ $product->id }}', 'size[]')"
                                                                style="cursor: pointer;"></i>
                                                        </div>
                                                        @foreach(explode(',', $product->size) as $sz)
                                                            @if(trim($sz))
                                                                <div class="d-flex gap-1 mb-1">
                                                                    <input type="text" name="size[]"
                                                                        class="form-control glass-input x-small" value="{{ trim($sz) }}">
                                                                    <button type="button" class="btn btn-danger btn-sm p-1"
                                                                        onclick="this.parentElement.remove()">&times;</button>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-md-3 text-white text-md-start">
                                                    <label class="form-label text-secondary xx-small fw-bold">COLORS</label>
                                                    <div id="color-container-{{ $product->id }}">
                                                        <div class="position-relative mb-1">
                                                            <input type="text" name="color[]"
                                                                class="form-control glass-input x-small pe-4"
                                                                placeholder="Add Color">
                                                            <i class="bi bi-plus-lg position-absolute end-0 top-50 translate-middle-y me-2 text-primary cursor-pointer"
                                                                onclick="addDynamicField('color-container-{{ $product->id }}', 'color[]')"
                                                                style="cursor: pointer;"></i>
                                                        </div>
                                                        @foreach(explode(',', $product->color) as $cl)
                                                            @if(trim($cl))
                                                                <div class="d-flex gap-1 mb-1">
                                                                    <input type="text" name="color[]"
                                                                        class="form-control glass-input x-small" value="{{ trim($cl) }}">
                                                                    <button type="button" class="btn btn-danger btn-sm p-1"
                                                                        onclick="this.parentElement.remove()">&times;</button>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label text-secondary x-small fw-bold">WEIGHT</label>
                                                    <input type="text" name="weight" class="form-control glass-input x-small"
                                                        value="{{ $product->weight }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label text-secondary x-small fw-bold">DIMENSIONS</label>
                                                    <input type="text" name="dimensions" class="form-control glass-input x-small"
                                                        value="{{ $product->dimensions }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label text-secondary x-small fw-bold">TAGS</label>
                                                    <input type="text" name="tags" class="form-control glass-input x-small"
                                                        value="{{ $product->tags }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label text-secondary x-small fw-bold">DESCRIPTION</label>
                                                    <textarea name="description" class="form-control glass-input x-small"
                                                        rows="2">{{ $product->description }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Media Section -->
                                        <div class="col-12">
                                            <h6 class="text-primary fw-bold mb-2 d-flex align-items-center x-small">
                                                <i class="bi bi-images me-2"></i> Media
                                            </h6>
                                            <div class="row g-3 mb-2">
                                                <div class="col-md-4">
                                                    <label class="form-label text-secondary x-small fw-bold">THUMBNAIL</label>
                                                    <input type="file" name="image" class="form-control glass-input x-small mb-1">
                                                    @if($product->image)
                                                        <img src="{{ asset($product->image) }}"
                                                            class="rounded border border-white border-opacity-10"
                                                            style="width: 60px; height: 60px; object-fit: cover;">
                                                    @endif
                                                </div>
                                                <div class="col-md-8 text-white text-md-start">
                                                    <label class="form-label text-secondary x-small fw-bold">ADD GALLERY
                                                        IMAGES</label>
                                                    <div id="gallery-container-{{ $product->id }}">
                                                        <div class="position-relative mb-1">
                                                            <input type="file" name="gallery_images[]"
                                                                class="form-control glass-input x-small pe-5">
                                                            <i class="bi bi-plus-lg position-absolute end-0 top-50 translate-middle-y me-2 text-primary cursor-pointer"
                                                                onclick="addDynamicField('gallery-container-{{ $product->id }}', 'gallery_images[]', 'file')"
                                                                style="cursor: pointer;"></i>
                                                        </div>
                                                    </div>

                                                    @if($product->images->count() > 0)
                                                        <div class="row g-1 mt-2">
                                                            @foreach($product->images as $gal)
                                                                <div class="col-2 position-relative" id="gal-img-{{ $gal->id }}">
                                                                    <img src="{{ asset($gal->image_path) }}"
                                                                        class="img-fluid rounded border border-white border-opacity-10"
                                                                        style="height: 40px; width: 100%; object-fit: cover;">
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0 rounded-circle"
                                                                        style="width: 15px; height: 15px; font-size: 8px;"
                                                                        onclick="deleteGalleryImage({{ $gal->id }})">&times;</button>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="glass-card p-2 bg-white bg-opacity-5 mb-2">
                                                <div class="row g-2">
                                                    <div class="col-md-4">
                                                        <div class="form-check form-switch ps-5">
                                                            <input class="form-check-input" type="checkbox" name="status" value="1"
                                                                {{ $product->status ? 'checked' : '' }}
                                                                id="statusSwitch{{ $product->id }}">
                                                            <label class="form-check-label text-black x-small fw-bold"
                                                                for="statusSwitch{{ $product->id }}">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check form-switch ps-5">
                                                            <input class="form-check-input" type="checkbox" name="featured"
                                                                value="1" {{ $product->featured ? 'checked' : '' }}
                                                                id="featuredSwitch{{ $product->id }}">
                                                            <label class="form-check-label text-black x-small fw-bold"
                                                                for="featuredSwitch{{ $product->id }}">Featured</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check form-switch ps-5">
                                                            <input class="form-check-input" type="checkbox" name="trending"
                                                                value="1" {{ $product->trending ? 'checked' : '' }}
                                                                id="trendingSwitch{{ $product->id }}">
                                                            <label class="form-check-label text-black x-small fw-bold"
                                                                for="trendingSwitch{{ $product->id }}">Trending</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-2 text-white text-md-start">
                                                <div class="col-md-6">
                                                    <label class="form-label text-secondary x-small fw-bold">RETURN POLICY</label>
                                                    <textarea name="return_policy" class="form-control glass-input x-small"
                                                        rows="1">{{ $product->return_policy }}</textarea>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label text-secondary x-small fw-bold">WARRANTY</label>
                                                    <textarea name="warranty" class="form-control glass-input x-small"
                                                        rows="1">{{ $product->warranty }}</textarea>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label text-secondary x-small fw-bold">RETURN DAYS</label>
                                                    <input type="number" name="return_days" class="form-control glass-input x-small"
                                                        value="{{ $product->return_days ?? 7 }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer-custom mt-3">
                                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-premium btn-submit-small">Update Product</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- View Product Modal -->
                <div class="modal fade" id="viewProductModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 p-0 shadow-2xl overflow-hidden bg-white" style="border-radius: 20px;">

                            <!-- Tight Premium Header -->
                            <div class="modal-header border-0 p-3 pb-0 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="p-2 rounded-3 me-2"
                                        style="background: rgba(255, 122, 24, 0.1); border: 1px solid rgba(255, 122, 24, 0.2);">
                                        <i class="bi bi-box-seam text-primary fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="modal-title fw-bold text-dark mb-0">Product Intel</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="text-secondary opacity-75 xx-small fw-bold uppercase tracking-widest">SKU:
                                                {{ $product->sku ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body pt-4 scrollable-modal-body" style="max-height: 70vh; overflow-y: auto;">
                                <div class="row g-3">
                                    <!-- Column 1: Compact Media & Logistics -->
                                    <div class="col-lg-5">
                                        <div class="position-relative mb-3 group">
                                            <div class="glass-card p-2 text-center rounded-4 overflow-hidden border border-white border-opacity-10 shadow-xl position-relative"
                                                style="background: rgba(255,255,255,0.02); min-height: 320px; display: flex; align-items: center; justify-content: center;">

                                                @if($product->image)
                                                    <img id="mainProductImage{{ $product->id }}" src="{{ asset($product->image) }}"
                                                        class="img-fluid rounded-3 main-product-preview"
                                                        style="max-height: 300px; width: auto; object-fit: contain;">
                                                @else
                                                    <div class="flex-column d-flex align-items-center opacity-20 py-5">
                                                        <i class="bi bi-image fs-2 mb-1 text-white"></i>
                                                        <p class="xx-small text-white fw-bold">NO IMAGE</p>
                                                    </div>
                                                @endif

                                                <div
                                                    class="position-absolute bottom-0 start-0 w-100 p-2 bg-gradient-to-t from-black opacity-0 group-hover-opacity-100 transition-all">
                                                    <span
                                                        class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }} bg-opacity-20 text-{{ $product->status ? 'success' : 'danger' }} border border-white border-opacity-10 px-2 py-1 rounded-pill xx-small fw-bold">
                                                        {{ $product->status ? 'ONLINE' : 'OFFLINE' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        @if($product->images->count() > 0)
                                            <div
                                                class="glass-card p-3 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10 mb-3">
                                                <h6
                                                    class="text-primary xx-small fw-black mb-2 d-flex align-items-center gap-2 uppercase tracking-widest opacity-75">
                                                    <i class="bi bi-grid-3x3-gap text-primary"></i> GALLERY
                                                </h6>
                                                <div class="row g-2">
                                                    <div class="col-3">
                                                        <div class="ratio ratio-1x1 rounded-2 overflow-hidden border border-white border-opacity-5 cursor-pointer shadow-sm "
                                                            onclick="document.getElementById('mainProductImage{{ $product->id }}').src='{{ asset($product->image) }}'">
                                                            <img src="{{ asset($product->image) }}"
                                                                class="thumbnail-preview border-primary object-fit-cover w-100 h-100">
                                                        </div>
                                                    </div>
                                                    @foreach($product->images as $gal)
                                                        <div class="col-3">
                                                            <div class="ratio ratio-1x1 rounded-2 overflow-hidden border border-white border-opacity-5 cursor-pointer shadow-sm"
                                                                onclick="document.getElementById('mainProductImage{{ $product->id }}').src='{{ asset($gal->image_path) }}'">
                                                                <img src="{{ asset($gal->image_path) }}"
                                                                    class="thumbnail-preview object-fit-cover w-100 h-100">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div
                                            class="glass-card p-3 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                                            <h6
                                                class="text-primary xx-small fw-black mb-2 d-flex align-items-center gap-2 uppercase tracking-widest opacity-75">
                                                <i class="bi bi-truck text-primary"></i> LOGISTICS
                                            </h6>
                                            <div class="small">
                                                <div class="d-flex justify-content-between py-1">
                                                    <span class="xx-small text-secondary fw-bold uppercase">Shipping</span>
                                                    <span
                                                        class="text-dark fw-bold">₹{{ number_format($product->shipping_charges, 2) }}</span>
                                                </div>
                                                <div
                                                    class="d-flex justify-content-between py-1 border-top border-white border-opacity-5 mt-1">
                                                    <span class="xx-small text-secondary fw-bold uppercase">Weight</span>
                                                    <span class="text-dark fw-bold">{{ $product->weight ?? '--' }}</span>
                                                </div>
                                                <div
                                                    class="d-flex justify-content-between py-1 border-top border-white border-opacity-5 mt-1">
                                                    <span class="xx-small text-secondary fw-bold uppercase">Dimension</span>
                                                    <span class="text-dark fw-bold">{{ $product->dimensions ?? '--' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Column 2: Efficient Data Display -->
                                    <div class="col-lg-7">
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span
                                                    class="x-small text-primary fw-bold uppercase tracking-wider">{{ $product->subCategory->category->name }}</span>
                                                <i class="bi bi-chevron-right xx-small text-secondary opacity-50"></i>
                                                <span
                                                    class="x-small text-secondary fw-bold uppercase tracking-wider">{{ $product->subCategory->name }}</span>
                                            </div>
                                            <h3 class="fw-black text-dark mb-2" style="letter-spacing: -0.5px;">{{ $product->name }}
                                            </h3>
                                            <div class="d-flex align-items-center flex-wrap gap-2">
                                                @if($product->brand)
                                                    <span
                                                        class="badge bg-primary bg-opacity-10 text-white xx-small px-2 py-1 rounded border border-primary border-opacity-10 fw-black">{{ strtoupper($product->brand) }}</span>
                                                @endif
                                                @if($product->trending)
                                                    <span
                                                        class="badge bg-danger bg-opacity-10 text-danger xx-small px-2 py-1 rounded border border-danger border-opacity-10 fw-black"><i
                                                            class="bi bi-fire me-1"></i>TRENDING</span>
                                                @endif
                                                <span
                                                    class="badge bg-white bg-opacity-5 text-secondary xx-small px-2 py-1 rounded border border-white border-opacity-10 fw-bold">ID:
                                                    {{ $product->id }}</span>
                                            </div>
                                        </div>

                                        <!-- Compact Financial Insights -->
                                        <div class="glass-card p-3 rounded-4 mb-3 border-0 position-relative overflow-hidden shadow-xl"
                                            style="background: linear-gradient(135deg, rgba(112, 0, 255, 0.1) 0%, rgba(0, 0, 0, 0.3) 100%); border: 1px solid rgba(112, 0, 255, 0.1) !important;">
                                            <div class="row align-items-center position-relative z-1">
                                                <div class="col-6 col-md-4">
                                                    <p
                                                        class="xx-small text-secondary uppercase fw-black mb-1 opacity-50 tracking-widest">
                                                        Pricing</p>
                                                    <div class="d-flex align-items-baseline gap-2 flex-wrap">
                                                        <h3 class="text-dark fw-black mb-0">
                                                            ₹{{ number_format($product->selling_price, 0) }}</h3>
                                                        @if($product->mrp > $product->selling_price)
                                                            <span
                                                                class="text-secondary text-decoration-line-through xx-small opacity-40">₹{{ number_format($product->mrp, 0) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3 border-start border-white border-opacity-10 ps-3">
                                                    @php $off = $product->mrp > 0 ? round((($product->mrp - $product->selling_price) / $product->mrp) * 100) : 0; @endphp
                                                    <p class="xx-small text-success uppercase fw-black mb-0 tracking-widest">Growth
                                                    </p>
                                                    <h4 class="text-success fw-black mb-0">{{ $off }}%</h4>
                                                </div>
                                                <div
                                                    class="col-12 col-md-5 border-start border-white border-opacity-10 text-md-end ps-md-3 mt-2 mt-md-0">
                                                    <p
                                                        class="xx-small text-secondary uppercase fw-black mb-1 opacity-50 tracking-widest">
                                                        Stock Level</p>
                                                    <div class="d-flex align-items-center justify-content-md-end gap-2">
                                                        <span class="h4 text-dark fw-black mb-0">{{ $product->stock }}</span>
                                                        <span
                                                            class="badge {{ $product->stock > 10 ? 'bg-success' : 'bg-warning' }} px-2 py-1 rounded-pill xx-small fw-bold">
                                                            {{ strtoupper($product->stock_status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Data Grid: Tightened -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-md-6">
                                                <div class="glass-card p-3 rounded-4 h-100 border border-white border-opacity-5">
                                                    <h6 class="text-primary xx-small fw-black mb-2 uppercase tracking-widest">
                                                        SPECIFICATIONS</h6>
                                                    <div class="space-y-2">
                                                        <div>
                                                            <label
                                                                class="xx-small text-secondary fw-bold opacity-50 uppercase tracking-tighter d-block">Sizes</label>
                                                            <p class="x-small text-dark fw-medium mb-0">
                                                                {{ $product->size ?: 'Standard' }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="xx-small text-secondary fw-bold opacity-50 uppercase tracking-tighter d-block">Colors</label>
                                                            <p class="x-small text-dark fw-medium mb-0">
                                                                {{ $product->color ?: 'Variable' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="glass-card p-3 rounded-4 h-100 border border-white border-opacity-5">
                                                    <h6 class="text-primary xx-small fw-black mb-2 uppercase tracking-widest">SUPPLY
                                                    </h6>
                                                    <div class="space-y-2">
                                                        <div>
                                                            <label
                                                                class="xx-small text-secondary fw-bold opacity-50 uppercase tracking-tighter d-block">Manufacturer</label>
                                                            <p class="x-small text-dark fw-medium mb-0">
                                                                {{ $product->manufacturer ?: 'Standard OEM' }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="xx-small text-secondary fw-bold opacity-50 uppercase tracking-tighter d-block">Seller</label>
                                                            <p class="x-small text-dark fw-medium mb-0">
                                                                {{ $product->seller_name ?: 'Direct Fulfillment' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Narrative & Compliance -->
                                        <div
                                            class="glass-card p-3 rounded-4 mb-3 border border-dark border-opacity-5 bg-white bg-opacity-5">
                                            <h6 class="text-primary xx-small fw-black mb-2 uppercase tracking-widest">NARRATIVE</h6>
                                            <p class="text-dark opacity-80 x-small mb-0"
                                                style="line-height: 1.5; max-height: 100px; overflow-y: auto;">
                                                {{ $product->description }}
                                            </p>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <div class="glass-card p-2 px-3 rounded-4 border border-danger border-opacity-10">
                                                    <h6 class="text-danger xx-small fw-black mb-1 uppercase tracking-widest">RETURNS
                                                    </h6>
                                                    <p class="xx-small text-dark opacity-60 mb-0 font-italic">
                                                        {{ $product->return_policy ?? '7-day policy' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="glass-card p-2 px-3 rounded-4 border border-success border-opacity-10">
                                                    <h6 class="text-success xx-small fw-black mb-1 uppercase tracking-widest">
                                                        WARRANTY
                                                    </h6>
                                                    <p class="xx-small text-dark opacity-60 mb-0 font-italic">
                                                        {{ $product->warranty ?? 'Standard Warranty' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer border-0 p-3 bg-white bg-opacity-5 d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-cancel px-4 py-2 rounded-pill shadow-none"
                                    data-bs-dismiss="modal">Close</button>
                                @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('products_edit')))
                                    <button type="button" class="btn btn-premium px-4 py-2 rounded-pill shadow-lg border-0"
                                        data-bs-toggle="modal" data-bs-target="#editProductModal{{ $product->id }}">Edit
                                        Product</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endpush



        <!-- Script for sub-category filtering -->
        <script>
            // Script for add-category-select
            document.getElementById('category_select')?.addEventListener('change', function () {
                const categoryId = this.value;
                const subCategorySelect = document.getElementById('subcategory_select');
                const options = subCategorySelect.querySelectorAll('option');

                subCategorySelect.value = '';
                options.forEach(option => {
                    if (option.getAttribute('data-category') === categoryId || option.value === '') {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });
            });

            // Script for edit-category-select
            document.querySelectorAll('.edit-category-select').forEach(select => {
                select.addEventListener('change', function () {
                    const productId = this.getAttribute('data-product-id');
                    const categoryId = this.value;
                    const subCategorySelect = document.querySelector(`.edit-subcategory-select-${productId}`);
                    const options = subCategorySelect.querySelectorAll('option');

                    subCategorySelect.value = '';
                    options.forEach(option => {
                        if (option.getAttribute('data-category') === categoryId || option.value === '') {
                            option.style.display = 'block';
                        } else {
                            option.style.display = 'none';
                        }
                    });
                });
            });
            // Dynamic field addition
            function addDynamicField(containerId, name, type = 'text') {
                const container = document.getElementById(containerId);
                const inputGroup = document.createElement('div');
                inputGroup.className = 'd-flex gap-2 mb-2';
                inputGroup.innerHTML = `
                                    <input type="${type}" name="${name}" class="form-control glass-input" placeholder="e.g. New Value">
                                    <button type="button" class="btn btn-danger btn-sm px-2" onclick="this.parentElement.remove()"><i class="bi bi-trash"></i></button>
                                `;
                container.appendChild(inputGroup);
            }

            // Gallery Image Delete
            function deleteGalleryImage(id) {
                if (confirm('Are you sure you want to delete this gallery image?')) {
                    $.ajax({
                        url: `/admin/products/delete-gallery-image/${id}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                $(`#gal-img-${id}`).fadeOut(300, function () { $(this).remove(); });
                                showToast('Gallery image deleted.', 'success');
                            }
                        },
                        error: function () {
                            showToast('Error deleting image.', 'error');
                        }
                    });
                }
            }

            // Image switching for view modal gallery
            $(document).on('click', '.thumbnail-preview', function () {
                const newSrc = $(this).attr('src');
                const mainImg = $(this).closest('.modal-body').find('.main-product-preview');

                mainImg.fadeOut(200, function () {
                    $(this).attr('src', newSrc).fadeIn(200);
                });

                // Thumbnail highlight
                $(this).addClass('border-primary shadow-lg scale-110').parent().addClass('z-index-10');
                $(this).closest('.row').find('.thumbnail-preview').not(this).removeClass('border-primary shadow-lg scale-110').parent().removeClass('z-index-10');
            });
        </script>

        @push('modals')
            <!-- Add Product Modal -->
            <div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content glass-card border-0 p-3">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold text-black small">Add New Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body pt-4 scrollable-modal-body" style="max-height: 70vh; overflow-y: auto;">
                            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3 text-white text-md-start">
                                    <!-- Basic Information Section -->
                                    <div class="col-12">
                                        <h6 class="text-primary fw-bold mb-2 d-flex align-items-center x-small">
                                            <i class="bi bi-info-circle me-2"></i> Basic Information
                                        </h6>
                                        <div class="row g-2">
                                            <div class="col-md-4">
                                                <label class="form-label text-secondary x-small fw-bold">CATEGORY</label>
                                                <select id="category_select" class="form-select glass-input shadow-none x-small"
                                                    required>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label text-secondary x-small fw-bold">SUB CATEGORY</label>
                                                <select name="subcategory_id" id="subcategory_select"
                                                    class="form-select glass-input shadow-none x-small" required>
                                                    <option value="">Select Sub Category</option>
                                                    @foreach($subCategories as $sub)
                                                        <option value="{{ $sub->id }}" data-category="{{ $sub->category_id }}"
                                                            style="display:none;">{{ $sub->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label text-secondary x-small fw-bold">PRODUCT TITLE</label>
                                                <input type="text" name="name" class="form-control glass-input x-small"
                                                    placeholder="e.g. Premium Cotton Shirt" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label text-secondary x-small fw-bold">BRAND</label>
                                                <input type="text" name="brand" class="form-control glass-input x-small"
                                                    placeholder="e.g. Nike">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label text-secondary x-small fw-bold">MANUFACTURER</label>
                                                <input type="text" name="manufacturer" class="form-control glass-input x-small"
                                                    placeholder="e.g. ABC Textiles">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label text-secondary x-small fw-bold">SELLER</label>
                                                <input type="text" name="seller_name" class="form-control glass-input x-small"
                                                    placeholder="e.g. Cloudtail">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pricing & Stock Section -->
                                    <div class="col-12">
                                        <h6 class="text-primary fw-bold mb-2 d-flex align-items-center x-small">
                                            <i class="bi bi-currency-rupee me-2"></i> Pricing & Inventory
                                        </h6>
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <label class="form-label text-secondary x-small fw-bold">MRP</label>
                                                <input type="number" name="mrp" class="form-control glass-input x-small"
                                                    placeholder="0.00" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label text-secondary x-small fw-bold">SELLING</label>
                                                <input type="number" name="selling_price"
                                                    class="form-control glass-input x-small" placeholder="0.00" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label text-secondary x-small fw-bold">STOCK</label>
                                                <input type="number" name="stock" class="form-control glass-input x-small"
                                                    placeholder="0" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label text-secondary x-small fw-bold">SKU</label>
                                                <input type="text" name="sku" class="form-control glass-input x-small"
                                                    placeholder="e.g. PRD-123">
                                            </div>
                                            <!-- <div class="col-md-3">
                                                        <label class="form-label text-secondary x-small fw-bold">ONLINE SHIPPING
                                                            (%)</label>
                                                        <input type="number" name="online_shipping_charges"
                                                            class="form-control glass-input x-small" step="0.01" placeholder="Global %">
                                                    </div> -->
                                            <!-- <div class="col-md-3">
                                                        <label class="form-label text-secondary x-small fw-bold">COD SHIPPING
                                                            (%)</label>
                                                        <input type="number" name="cod_shipping_charges"
                                                            class="form-control glass-input x-small" step="0.01" placeholder="Global %">
                                                    </div> -->
                                            <div class="col-md-3">
                                                <label class="form-label text-secondary x-small fw-bold">MIN QTY</label>
                                                <input type="number" name="minimum_order_quantity"
                                                    class="form-control glass-input x-small" value="1">
                                            </div>
                                            <!-- <div class="col-md-3">
                                                        <label class="form-label text-secondary x-small fw-bold">COD ADVANCE %</label>
                                                        <input type="number" name="cod_advance_percent"
                                                            class="form-control glass-input x-small" placeholder="0.00" step="0.01">
                                                    </div> -->
                                        </div>
                                    </div>

                                    <!-- Specifications Section -->
                                    <div class="col-12">
                                        <h6 class="text-primary fw-bold mb-2 d-flex align-items-center x-small">
                                            <i class="bi bi-gear me-2"></i> Specifications
                                        </h6>
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <label class="form-label text-secondary xx-small fw-bold">SIZES</label>
                                                <div id="add-size-container">
                                                    <div class="position-relative mb-1">
                                                        <input type="text" name="size[]"
                                                            class="form-control glass-input x-small pe-4"
                                                            placeholder="Add Size">
                                                        <i class="bi bi-plus-lg position-absolute end-0 top-50 translate-middle-y me-2 text-primary cursor-pointer"
                                                            onclick="addDynamicField('add-size-container', 'size[]')"
                                                            style="cursor: pointer;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-white text-md-start">
                                                <label class="form-label text-secondary xx-small fw-bold">COLORS</label>
                                                <div id="add-color-container">
                                                    <div class="position-relative mb-1">
                                                        <input type="text" name="color[]"
                                                            class="form-control glass-input x-small pe-4"
                                                            placeholder="Add Color">
                                                        <i class="bi bi-plus-lg position-absolute end-0 top-50 translate-middle-y me-2 text-primary cursor-pointer"
                                                            onclick="addDynamicField('add-color-container', 'color[]')"
                                                            style="cursor: pointer;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label text-secondary x-small fw-bold">WEIGHT</label>
                                                <input type="text" name="weight" class="form-control glass-input x-small"
                                                    placeholder="e.g. 1kg">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label text-secondary x-small fw-bold">DIMENSIONS</label>
                                                <input type="text" name="dimensions" class="form-control glass-input x-small"
                                                    placeholder="e.g. 10x10x5">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label text-secondary x-small fw-bold">TAGS</label>
                                                <input type="text" name="tags" class="form-control glass-input x-small"
                                                    placeholder="e.g. cotton, summer">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label text-secondary x-small fw-bold">DESCRIPTION</label>
                                                <textarea name="description" class="form-control glass-input x-small" rows="2"
                                                    placeholder="Details..."></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Media Section -->
                                    <div class="col-12">
                                        <h6 class="text-primary fw-bold mb-2 d-flex align-items-center x-small">
                                            <i class="bi bi-images me-2"></i> Media
                                        </h6>
                                        <div class="row g-3 mb-2">
                                            <div class="col-md-4">
                                                <label class="form-label text-secondary x-small fw-bold">THUMBNAIL</label>
                                                <input type="file" name="image" class="form-control glass-input x-small">
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label text-secondary x-small fw-bold">GALLERY IMAGES</label>
                                                <div id="add-gallery-container">
                                                    <div class="position-relative mb-1">
                                                        <input type="file" name="gallery_images[]"
                                                            class="form-control glass-input x-small pe-5">
                                                        <i class="bi bi-plus-lg position-absolute end-0 top-50 translate-middle-y me-2 text-primary cursor-pointer"
                                                            onclick="addDynamicField('add-gallery-container', 'gallery_images[]', 'file')"
                                                            style="cursor: pointer;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="glass-card p-2 bg-white bg-opacity-5 mb-2">
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <div class="form-check form-switch ps-5">
                                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                                            checked id="addStatusSwitch">
                                                        <label class="form-check-label text-white x-small fw-bold"
                                                            for="addStatusSwitch">Active</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check form-switch ps-5">
                                                        <input class="form-check-input" type="checkbox" name="featured"
                                                            value="1" id="addFeaturedSwitch">
                                                        <label class="form-check-label text-white x-small fw-bold"
                                                            for="addFeaturedSwitch">Featured</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check form-switch ps-5">
                                                        <input class="form-check-input" type="checkbox" name="trending"
                                                            value="1" id="addTrendingSwitch">
                                                        <label class="form-check-label text-white x-small fw-bold"
                                                            for="addTrendingSwitch">Trending</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label class="form-label text-secondary x-small fw-bold">RETURN POLICY</label>
                                                <textarea name="return_policy" class="form-control glass-input x-small" rows="1"
                                                    placeholder="e.g. 7 Days"></textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label text-secondary x-small fw-bold">WARRANTY</label>
                                                <textarea name="warranty" class="form-control glass-input x-small" rows="1"
                                                    placeholder="e.g. 1 Year"></textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label text-secondary x-small fw-bold">RETURN DAYS</label>
                                                <input type="number" name="return_days" class="form-control glass-input x-small"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer-custom mt-3">
                                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-premium btn-submit-small">Save Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endpush
        @push('styles')
            <style>
                .fw-black {
                    font-weight: 900 !important;
                }

                .shadow-2xl {
                    filter: drop-shadow(0 25px 50px rgba(0, 0, 0, 0.5));
                }

                .hover-bg-white-opacity-5:hover {
                    background: rgba(255, 255, 255, 0.05);
                }

                .transition-all {
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                }

                .group:hover .group-hover-opacity-100 {
                    opacity: 1 !important;
                }

                /* Typography Scale */
                .xx-small {
                    font-size: 0.65rem !important;
                }

                .x-small {
                    font-size: 0.75rem !important;
                }

                .scrollable-modal-body::-webkit-scrollbar {
                    width: 4px;
                }

                .scrollable-modal-body::-webkit-scrollbar-track {
                    background: transparent;
                }

                .scrollable-modal-body::-webkit-scrollbar-thumb {
                    background: rgba(255, 255, 255, 0.1);
                    border-radius: 10px;
                    border: 1px solid rgba(255, 255, 255, 0.05);
                }

                .scrollable-modal-body::-webkit-scrollbar-thumb:hover {
                    background: rgba(255, 255, 255, 0.2);
                }

                .main-product-preview {
                    transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
                    transform-origin: center center;
                }

                .group:hover .main-product-preview {
                    transform: scale(1.05) rotate(1deg);
                }

                .animate-pulse {
                    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
                }

                @keyframes pulse {

                    0%,
                    100% {
                        opacity: 1;
                    }

                    50% {
                        opacity: .7;
                    }
                }

                .thumbnail-preview {
                    filter: grayscale(0.5) contrast(0.8);
                    opacity: 0.6;
                    transition: all 0.3s ease;
                }

                .thumbnail-preview:hover {
                    filter: grayscale(0) contrast(1);
                    opacity: 1;
                    transform: scale(1.1);
                }

                .space-y-1>*+* {
                    margin-top: 0.25rem;
                }

                .space-y-2>*+* {
                    margin-top: 0.5rem;
                }

                .space-y-3>*+* {
                    margin-top: 0.75rem;
                }

                .space-y-4>*+* {
                    margin-top: 1rem;
                }

                @media (max-width: 991px) {
                    .modal-xl {
                        max-width: 95vw;
                        margin: 0.5rem auto;
                    }

                    .display-5 {
                        font-size: 2.5rem;
                    }
                }

                /* Reset to Light Theme for Modals to match website */
                .modal-content {
                    background-color: #ffffff !important;
                    color: #1f2937 !important;
                    border: 1px solid rgba(0, 0, 0, 0.1) !important;
                }

                .modal-header,
                .modal-footer {
                    border-color: rgba(0, 0, 0, 0.05) !important;
                }

                .modal-title,
                .modal-header .modal-title,
                h3,
                h4,
                h5,
                h6 {
                    color: #1f2937 !important;
                }

                .text-secondary {
                    color: #6b7280 !important;
                }

                .glass-card {
                    background: #f8fafc !important;
                    border: 1px solid rgba(0, 0, 0, 0.05) !important;
                }

                .text-dark {
                    color: #1f2937 !important;
                }

                .text-white {
                    color: #ffffff !important;
                    /* Keep utility class valid */
                }

                .thumbnail-preview {
                    border: 2px solid #3974aeff;
                    cursor: pointer;
                    transition: all 0.3s ease;
                }

                .thumbnail-preview.border-primary {
                    border: 2px solid var(--accent-color) !important;
                    opacity: 1 !important;
                    filter: grayscale(0) !important;
                }
            </style>
        @endpush
@endsection