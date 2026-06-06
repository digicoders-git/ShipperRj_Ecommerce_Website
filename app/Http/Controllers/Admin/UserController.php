<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('check.subadmin:users_view', only: ['index', 'show']),
            new Middleware('check.subadmin:users_edit', only: ['update', 'adjustWallet']),
            new Middleware('check.subadmin:users_delete', only: ['destroy']),
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
        $user = User::with([
            'addresses',
            'walletTransactions',
            'wishlists.product',
            'carts.product',
            'orders' => function ($q) {
                $q->latest(); }
        ])->findOrFail($id);

        return view('admin.users-show', compact('user'));
    }

    /**
     * Toggle the blocked status of a user.
     */
    public function toggleBlock(string $id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        $status = $user->is_blocked ? 'blocked' : 'unblocked';
        return back()->with('success', "User has been successfully $status.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    /**
     * Adjust the wallet balance of a user.
     */
    public function adjustWallet(Request $request, string $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:credit,debit',
            'description' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $amount = (float) $request->amount;
        $type = $request->type;
        $description = $request->description;

        if ($type === 'debit' && $user->wallet_balance < $amount) {
            return back()->with('error', 'Insufficient wallet balance. User current balance is ₹' . number_format($user->wallet_balance, 2));
        }

        if ($type === 'credit') {
            $user->increment('wallet_balance', $amount);
        } else {
            $user->decrement('wallet_balance', $amount);
        }

        \App\Models\WalletTransaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => $type === 'credit' ? 1 : 2, // 1 for Credit, 2 for Debit
            'description' => $description,
        ]);

        $actionWord = $type === 'credit' ? 'credited with' : 'debited by';
        return back()->with('success', "Wallet has been successfully $actionWord ₹" . number_format($amount, 2));
    }
}

