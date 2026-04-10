<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $user_id = Auth::id();
        $cartItem = Cart::where('user_id', $user_id)->where('product_id', $id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => $user_id,
                'product_id' => $id,
                'quantity' => 1
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request)
    {
        $quantities = $request->input('quantities');

        if (!is_array($quantities)) {
            return back()->with('error', 'Invalid data.');
        }

        foreach ($quantities as $id => $quantity) {
            Cart::where('user_id', Auth::id())
                ->where('id', $id)
                ->update(['quantity' => max(1, (int) $quantity)]);
        }

        return back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Product removed from cart.');
    }
}
