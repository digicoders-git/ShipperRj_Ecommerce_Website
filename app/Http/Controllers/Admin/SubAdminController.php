<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SubAdminController extends Controller
{
    public $allPermissions = [
        'dashboard' => ['view'],
        'categories' => ['view', 'add', 'edit', 'delete'],
        'sub_categories' => ['view', 'add', 'edit', 'delete'],
        'products' => ['view', 'add', 'edit', 'delete'],
        'coupons' => ['view', 'add', 'edit', 'delete'],
        'orders' => ['view', 'update', 'delete', 'invoice'],
        'transactions' => ['view'],
        'wallet_deals' => ['view', 'add', 'edit', 'delete'],
        'users' => ['view', 'edit', 'delete', 'block'],
        'complaints' => ['view', 'reply', 'delete'],
        'contacts' => ['view', 'delete'],
        'support' => ['view', 'reply', 'delete'],
        'reviews' => ['view', 'update', 'delete'],
        'refunds' => ['view', 'update']
    ];

    public function index()
    {
        $subAdmins = SubAdmin::latest()->get();
        return view('admin.sub_admins.index', compact('subAdmins'));
    }

    public function create()
    {
        $permissions = $this->allPermissions;
        return view('admin.sub_admins.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:sub_admins',
            'email' => 'required|email|unique:sub_admins',
            'phone' => 'nullable|string',
            'password' => 'required|min:6|confirmed',
            'status' => 'required|boolean',
            'permissions' => 'nullable|array'
        ]);

        SubAdmin::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'mobile' => $request->phone,
            'password' => Hash::make($request->password),
            'permissions' => $request->permissions ?? [],
            'status' => $request->status
        ]);

        return redirect()->route('admin.subadmins.index')->with('success', 'Sub-admin created successfully.');
    }

    public function edit(SubAdmin $subadmin)
    {
        $permissions = $this->allPermissions;
        return view('admin.sub_admins.edit', compact('subadmin', 'permissions'));
    }

    public function update(Request $request, SubAdmin $subadmin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:sub_admins,username,' . $subadmin->id,
            'email' => 'required|email|unique:sub_admins,email,' . $subadmin->id,
            'phone' => 'nullable|string',
            'password' => 'nullable|min:6|confirmed',
            'status' => 'required|boolean',
            'permissions' => 'nullable|array'
        ]);

        $data = $request->only(['name', 'username', 'email', 'status']);
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        $data['permissions'] = $request->permissions ?? [];
        $data['mobile'] = $request->phone;

        $subadmin->update($data);

        return redirect()->route('admin.subadmins.index')->with('success', 'Sub-admin updated successfully.');
    }

    public function toggleStatus(SubAdmin $subadmin)
    {
        $subadmin->update(['status' => !$subadmin->status]);
        return back()->with('success', 'Status updated successfully.');
    }

    public function destroy(SubAdmin $subadmin)
    {
        $subadmin->delete();
        return back()->with('success', 'Sub-admin deleted successfully.');
    }

    public function showLogin()
    {
        return view('admin.auth.subadmin_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required', // can be email or username
            'password' => 'required'
        ]);

        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::guard('subadmin')->attempt([$loginField => $request->login, 'password' => $request->password])) {
            $user = Auth::guard('subadmin')->user();
            
            if (!$user->status) {
                Auth::guard('subadmin')->logout();
                return back()->with('error', 'Your account is inactive.');
            }

            $user->update(['last_login_at' => now()]);
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->with('error', 'Invalid credentials.');
    }
}

