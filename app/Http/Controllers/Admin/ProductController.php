<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('check.subadmin:products_view', only: ['index']),
            new Middleware('check.subadmin:products_add', only: ['store']),
            new Middleware('check.subadmin:products_edit', only: ['update', 'deleteGalleryImage']),
            new Middleware('check.subadmin:products_delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['subCategory.category', 'images'])->latest()->paginate(15);
        $subCategories = SubCategory::with('category')->where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        return view('admin.products', compact('products', 'subCategories', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subcategory_id' => 'required|exists:sub_categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'mrp' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock' => 'required|integer',
            'sku' => 'nullable|unique:products,sku',
        ]);

        $product = new Product();
        $product->id = 'PRD' . strtoupper(Str::random(6));
        $product->subcategory_id = $request->subcategory_id;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name) . '-' . time();
        $product->description = $request->description;
        $product->sku = $request->sku;
        $product->tags = $request->tags;
        
        // Automatic Stock Status
        $stock = $request->stock;
        $product->stock = $stock;
        $product->stock_status = ($stock <= 0) ? 'Out of Stock' : ($request->stock_status ?? 'In Stock');
        
        $product->brand = $request->brand;
        $product->manufacturer = $request->manufacturer;
        $product->seller_name = $request->seller_name;
        $product->featured = $request->featured ? 1 : 0;
        $product->trending = $request->trending ? 1 : 0;
        $product->return_policy = $request->return_policy;
        $product->warranty = $request->warranty;
        $product->dimensions = $request->dimensions;
        $product->weight = $request->weight;
        $product->shipping_charges = $request->shipping_charges ?? 0;
        $product->online_shipping_charges = $request->filled('online_shipping_charges') ? $request->online_shipping_charges : null;
        $product->cod_shipping_charges = $request->filled('cod_shipping_charges') ? $request->cod_shipping_charges : null;
        $product->minimum_order_quantity = $request->minimum_order_quantity ?? 1;
        $product->cod_advance_percent = $request->filled('cod_advance_percent') ? $request->cod_advance_percent : null;
        $product->status = $request->status ?? 1;
        $product->return_days = $request->return_days ?? 7;

        // Pricing & Inventory
        $product->mrp = $request->mrp;
        $product->selling_price = $request->selling_price;
        $product->size = is_array($request->size) ? implode(',', $request->size) : $request->size;
        $product->color = is_array($request->color) ? implode(',', $request->color) : $request->color;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $product->image = 'uploads/products/' . $imageName;
        }

        $product->save();

        // Handle Gallery Images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $galImage) {
                $galName = Str::random(10) . '_' . time() . '.' . $galImage->extension();
                $galImage->move(public_path('uploads/products/gallery'), $galName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'uploads/products/gallery/' . $galName,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product added successfully.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'subcategory_id' => 'required|exists:sub_categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'mrp' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock' => 'required|integer',
            'sku' => 'nullable|unique:products,sku,' . $id,
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $product->image = 'uploads/products/' . $imageName;
        }

        $product->subcategory_id = $request->subcategory_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->sku = $request->sku;
        $product->tags = $request->tags;
        
        // Automatic Stock Status
        $stock = $request->stock;
        $product->stock = $stock;
        $product->stock_status = ($stock <= 0) ? 'Out of Stock' : ($request->stock_status ?? 'In Stock');

        $product->brand = $request->brand;
        $product->manufacturer = $request->manufacturer;
        $product->seller_name = $request->seller_name;
        $product->featured = $request->featured ? 1 : 0;
        $product->trending = $request->trending ? 1 : 0;
        $product->return_policy = $request->return_policy;
        $product->warranty = $request->warranty;
        $product->dimensions = $request->dimensions;
        $product->weight = $request->weight;
        $product->shipping_charges = $request->shipping_charges ?? 0;
        $product->online_shipping_charges = $request->filled('online_shipping_charges') ? $request->online_shipping_charges : null;
        $product->cod_shipping_charges = $request->filled('cod_shipping_charges') ? $request->cod_shipping_charges : null;
        $product->minimum_order_quantity = $request->minimum_order_quantity ?? 1;
        $product->cod_advance_percent = $request->filled('cod_advance_percent') ? $request->cod_advance_percent : null;
        $product->status = $request->status ?? 1;
        $product->return_days = $request->return_days ?? 7;

        $product->mrp = $request->mrp;
        $product->selling_price = $request->selling_price;
        $product->size = is_array($request->size) ? implode(',', $request->size) : $request->size;
        $product->color = is_array($request->color) ? implode(',', $request->color) : $request->color;

        $product->save();

        // Handle Gallery Images (Append)
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $galImage) {
                $galName = Str::random(10) . '_' . time() . '.' . $galImage->extension();
                $galImage->move(public_path('uploads/products/gallery'), $galName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'uploads/products/gallery/' . $galName,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    public function destroy(string $id)
    {
        $product = Product::with('images')->findOrFail($id);

        if ($product->image && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }

        foreach ($product->images as $img) {
            if (File::exists(public_path($img->image_path))) {
                File::delete(public_path($img->image_path));
            }
        }

        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function deleteGalleryImage($id)
    {
        $image = ProductImage::findOrFail($id);
        if (File::exists(public_path($image->image_path))) {
            File::delete(public_path($image->image_path));
        }
        $image->delete();
        return response()->json(['success' => true]);
    }
}
