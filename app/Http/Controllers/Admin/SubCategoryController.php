<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SubCategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('check.subadmin:sub_categories_view', only: ['index']),
            new Middleware('check.subadmin:sub_categories_add', only: ['store']),
            new Middleware('check.subadmin:sub_categories_edit', only: ['update']),
            new Middleware('check.subadmin:sub_categories_delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subCategories = SubCategory::with('category')->latest()->get();
        $categories = Category::where('status', 1)->get();
        return view('admin.sub-categories', compact('subCategories', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
        ]);

        $subCategory = new SubCategory();
        $subCategory->category_id = $request->category_id;
        $subCategory->name = $request->name;
        $subCategory->slug = Str::slug($request->name);
        $subCategory->description = $request->description;
        $subCategory->status = $request->status ?? 1;
        $subCategory->save();

        return redirect()->back()->with('success', 'Sub-Category added successfully.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
        ]);

        $subCategory = SubCategory::findOrFail($id);
        $subCategory->category_id = $request->category_id;
        $subCategory->name = $request->name;
        $subCategory->slug = Str::slug($request->name);
        $subCategory->description = $request->description;
        $subCategory->status = $request->status ?? 1;
        $subCategory->save();

        return redirect()->back()->with('success', 'Sub-Category updated successfully.');
    }

    public function destroy(string $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->delete();
        return redirect()->back()->with('success', 'Sub-Category deleted successfully.');
    }
}

