<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletOffer;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class WalletOfferController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('check.subadmin:wallet_deals_view', only: ['index']),
            new Middleware('check.subadmin:wallet_deals_add', only: ['store']),
            new Middleware('check.subadmin:wallet_deals_edit', only: ['update']),
            new Middleware('check.subadmin:wallet_deals_delete', only: ['destroy']),
        ];
    }
    public function index()
    {
        $offers = WalletOffer::latest()->get();
        return view('admin.wallet-offers', compact('offers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'min_amount' => 'required|numeric|min:1',
            'bonus_amount' => 'required|numeric|min:0',
        ]);

        WalletOffer::create($request->all());

        return back()->with('success', 'Wallet offer created successfully.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'min_amount' => 'required|numeric|min:1',
            'bonus_amount' => 'required|numeric|min:0',
        ]);

        $offer = WalletOffer::findOrFail($id);
        $offer->update($request->all());

        return back()->with('success', 'Wallet offer updated successfully.');
    }

    public function destroy(string $id)
    {
        WalletOffer::findOrFail($id)->delete();
        return back()->with('success', 'Wallet offer deleted successfully.');
    }
}
