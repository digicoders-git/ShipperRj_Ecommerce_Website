<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('check.subadmin:categories_view', only: ['index']),
            new Middleware('check.subadmin:categories_add', only: ['store']),
            new Middleware('check.subadmin:categories_edit', only: ['update']),
            new Middleware('check.subadmin:categories_delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $directory = public_path('uploads/categories');
            File::ensureDirectoryExists($directory);
            $request->image->move($directory, $imageName);
            $category->image = 'uploads/categories/'.$imageName;
        }

        $category->status = $request->status ?? 1;
        $category->save();

        return redirect()->back()->with('success', 'Category added successfully.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,'.$id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = Category::findOrFail($id);
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image && File::exists(public_path($category->image))) {
                File::delete(public_path($category->image));
            }

            $imageName = time().'.'.$request->image->extension();
            $directory = public_path('uploads/categories');
            File::ensureDirectoryExists($directory);
            $request->image->move($directory, $imageName);
            $category->image = 'uploads/categories/'.$imageName;
        }

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->status = $request->status ?? 1;
        $category->save();

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        
        // Delete image associated
        if ($category->image && File::exists(public_path($category->image))) {
            File::delete(public_path($category->image));
        }

        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}

