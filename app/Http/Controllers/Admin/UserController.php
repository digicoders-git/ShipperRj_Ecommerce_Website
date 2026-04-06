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
            new Middleware('check.subadmin:users_edit', only: ['update']),
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
}

