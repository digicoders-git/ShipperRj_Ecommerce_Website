<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('check.subadmin:users_view', only: ['index', 'show', 'userCarts']),
            new Middleware('check.subadmin:users_edit', only: ['update', 'adjustWallet', 'resetPassword']),
            new Middleware('check.subadmin:users_delete', only: ['destroy', 'clearUserCart']),
            new Middleware('check.subadmin:users_block', only: ['toggleBlock']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(25);
        return view('admin.users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users-show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'nullable|string|max:20',
        ]);

        $user->update($request->only('name', 'email', 'mobile'));

        return back()->with('success', 'User profile updated successfully.');
    }

    /**
     * Toggle Block/Unblock status of user.
     */
    public function toggleBlock(string $id)
    {
        $user = User::findOrFail($id);
        $user->status = ($user->status == 1) ? 0 : 1;
        $user->save();

        $statusText = $user->status == 1 ? 'Unblocked' : 'Blocked';
        return back()->with('success', "User '{$user->name}' has been {$statusText} successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Manually Adjust User Wallet Balance by Admin.
     */
    public function adjustWallet(Request $request, string $id)
    {
        $request->validate([
            'type' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $amount = (float) $request->amount;
        $type = $request->type;
        $description = $request->description;

        if ($type === 'debit' && $user->wallet_balance < $amount) {
            return back()->with('error', "User's current wallet balance (₹" . number_format($user->wallet_balance, 2) . ") is lower than the debit amount.");
        }

        if ($type === 'credit') {
            $user->increment('wallet_balance', $amount);
        } else {
            $user->decrement('wallet_balance', $amount);
        }

        WalletTransaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => $type === 'credit' ? 1 : 2, // 1 for Credit, 2 for Debit
            'description' => $description,
        ]);

        $actionWord = $type === 'credit' ? 'credited with' : 'debited by';
        return back()->with('success', "Wallet has been successfully $actionWord ₹" . number_format($amount, 2));
    }

    /**
     * Reset user password by Admin.
     */
    public function resetPassword(Request $request, string $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        if (Schema::hasColumn('users', 'plain_password')) {
            $user->plain_password = $request->password;
        }
        $user->save();

        session()->forget('failed_pass_count_' . $user->id);

        return back()->with('success', "Password for user '{$user->name}' reset successfully to: {$request->password}");
    }

    /**
     * Display all customer active carts.
     */
    public function userCarts(Request $request)
    {
        $query = User::has('carts')->with(['carts.product']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('mobile', 'LIKE', "%{$search}%")
                  ->orWhereHas('carts.product', function ($pq) use ($search) {
                      $pq->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $usersWithCarts = $query->latest('updated_at')->paginate(15);

        // Calculated stats
        $totalActiveCarts = User::has('carts')->count();
        $totalCartItems = Cart::sum('quantity');
        $totalCartValue = Cart::join('products', 'carts.product_id', '=', 'products.id')
            ->sum(DB::raw('carts.quantity * products.selling_price'));

        return view('admin.user-carts', compact('usersWithCarts', 'totalActiveCarts', 'totalCartItems', 'totalCartValue'));
    }

    /**
     * Clear a customer's cart.
     */
    public function clearUserCart(string $id)
    {
        $user = User::findOrFail($id);
        Cart::where('user_id', $user->id)->delete();

        return back()->with('success', "Cart for {$user->name} has been cleared successfully.");
    }
}
