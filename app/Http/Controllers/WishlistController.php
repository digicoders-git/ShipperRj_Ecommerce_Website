<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function add($id)
    {
        $user_id = Auth::id();
        $isExists = Wishlist::where('user_id', $user_id)->where('product_id', $id)->first();

        if (!$isExists) {
            Wishlist::create([
                'user_id' => $user_id,
                'product_id' => $id
            ]);
            return back()->with('success', 'Product added to wishlist successfully!');
        }

        return back()->with('info', 'Product is already in your wishlist.');
    }

    public function remove($id)
    {
        $user_id = Auth::id();
        
        // Smarter deletion: check if ID is a Wishlist ID (starts with WSH) or a Product ID
        $query = Wishlist::where('user_id', $user_id);
        
        if (str_starts_with($id, 'WSH')) {
            $query->where('id', $id);
        } else {
            $query->where('product_id', $id);
        }

        $deletedRows = $query->delete();

        if ($deletedRows > 0) {
            return back()->with('success', 'Product removed from wishlist.');
        }

        return back()->with('info', 'Item was already removed or not found.');
    }
}
