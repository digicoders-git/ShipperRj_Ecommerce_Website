<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    public function store(Request $request)
    {
        \Log::info('Saving Settings:', $request->except('_token'));
        try {
            $data = $request->except('_token');
            foreach ($data as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
            return redirect()->back()->with('success', 'Settings updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Settings Save Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Critical Error: ' . $e->getMessage());
        }
    }
}

