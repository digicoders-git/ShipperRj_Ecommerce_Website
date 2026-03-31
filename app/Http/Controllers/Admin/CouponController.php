<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CouponController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('check.subadmin:coupons_view', only: ['index']),
            new Middleware('check.subadmin:coupons_add', only: ['store']),
            new Middleware('check.subadmin:coupons_edit', only: ['update']),
            new Middleware('check.subadmin:coupons_delete', only: ['destroy']),
        ];
    }
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'discount_amount' => 'required|numeric',
            'min_spend' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);

        Coupon::create([
            'code' => strtoupper($request->code),
            'discount_amount' => $request->discount_amount,
            'min_spend' => $request->min_spend,
            'expiry_date' => $request->expiry_date,
            'status' => $request->status ?? 1
        ]);

        return redirect()->back()->with('success', 'Coupon created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code,'.$id,
            'discount_amount' => 'required|numeric',
            'min_spend' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'code' => strtoupper($request->code),
            'discount_amount' => $request->discount_amount,
            'min_spend' => $request->min_spend,
            'expiry_date' => $request->expiry_date,
            'status' => $request->status ?? 1
        ]);

        return redirect()->back()->with('success', 'Coupon updated successfully.');
    }

    public function destroy($id)
    {
        Coupon::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Coupon deleted successfully.');
    }
}
