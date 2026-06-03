<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSlider;
use Illuminate\Support\Facades\File;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HomeSliderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('check.subadmin:home_sliders_view', only: ['index']),
            new Middleware('check.subadmin:home_sliders_add', only: ['store']),
            new Middleware('check.subadmin:home_sliders_edit', only: ['update']),
            new Middleware('check.subadmin:home_sliders_delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = HomeSlider::orderBy('sort_order', 'asc')->latest()->get();
        return view('admin.sliders', compact('sliders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'badge' => 'nullable|string|max:255',
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'bg_color' => 'nullable|string|max:50',
            'status' => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $slider = new HomeSlider();
        $slider->badge = $request->badge;
        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->description = $request->description;
        $slider->button_text = $request->button_text ?? 'Shop Now';
        $slider->button_url = $request->button_url ?? '/products';
        $slider->bg_color = $request->bg_color ?? '#F4F7F9';
        $slider->status = $request->status;
        $slider->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $directory = public_path('uploads/sliders');
            File::ensureDirectoryExists($directory);
            $request->image->move($directory, $imageName);
            $slider->image = 'uploads/sliders/' . $imageName;
        }

        $slider->save();

        return redirect()->back()->with('success', 'Hero Slider added successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'badge' => 'nullable|string|max:255',
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'bg_color' => 'nullable|string|max:50',
            'status' => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $slider = HomeSlider::findOrFail($id);
        $slider->badge = $request->badge;
        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->description = $request->description;
        $slider->button_text = $request->button_text ?? 'Shop Now';
        $slider->button_url = $request->button_url ?? '/products';
        $slider->bg_color = $request->bg_color ?? '#F4F7F9';
        $slider->status = $request->status;
        $slider->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            // Delete old image if it is an uploaded file
            if ($slider->image && !str_starts_with($slider->image, 'images/') && File::exists(public_path($slider->image))) {
                File::delete(public_path($slider->image));
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $directory = public_path('uploads/sliders');
            File::ensureDirectoryExists($directory);
            $request->image->move($directory, $imageName);
            $slider->image = 'uploads/sliders/' . $imageName;
        }

        $slider->save();

        return redirect()->back()->with('success', 'Hero Slider updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = HomeSlider::findOrFail($id);

        if ($slider->image && !str_starts_with($slider->image, 'images/') && File::exists(public_path($slider->image))) {
            File::delete(public_path($slider->image));
        }

        $slider->delete();

        return redirect()->back()->with('success', 'Hero Slider deleted successfully.');
    }
}
