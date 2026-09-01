<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $user_id = Auth::id();
        $product = Product::findOrFail($id);
        $minQty = max(1, (int) ($product->minimum_order_quantity ?? 1));

        $reqQty = (int) $request->input('quantity', 0);
        $qtyToAdd = ($reqQty > 0) ? max($reqQty, $minQty) : $minQty;

        $cartItem = Cart::where('user_id', $user_id)->where('product_id', $id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $qtyToAdd);
        } else {
            Cart::create([
                'user_id' => $user_id,
                'product_id' => $id,
                'quantity' => $qtyToAdd
            ]);
        }

        return back()->with('success', "{$product->name} (Qty: {$qtyToAdd}) added to cart!");
    }

    public function update(Request $request)
    {
        $quantities = $request->input('quantities');

        if (!is_array($quantities)) {
            return back()->with('error', 'Invalid data.');
        }

        $warnings = [];
        foreach ($quantities as $id => $quantity) {
            $cartItem = Cart::with('product')->where('user_id', Auth::id())->where('id', $id)->first();
            if ($cartItem) {
                $minQty = max(1, (int) ($cartItem->product->minimum_order_quantity ?? 1));
                $newQty = (int) $quantity;

                if ($newQty < $minQty) {
                    $newQty = $minQty;
                    $warnings[] = "Quantity for '{$cartItem->product->name}' cannot be less than required minimum quantity ({$minQty}).";
                }

                $cartItem->update(['quantity' => $newQty]);
            }
        }

        if (!empty($warnings)) {
            return back()->with('warning', implode(' ', $warnings));
        }

        return back()->with('success', 'Cart updated successfully!');
    }

    public function remove($id)
    {
        Cart::where('user_id', Auth::id())
            ->where(function ($q) use ($id) {
                $q->where('id', $id)->orWhere('product_id', $id);
            })->delete();

        return back()->with('success', 'Product removed from cart.');
    }
}
