<?php
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission = null): Response
    {
        // 1. If Main Admin is logged in, grant full access
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // 2. Check Sub-Admin
        $subAdmin = Auth::guard('subadmin')->user();

        if (!$subAdmin) {
            return redirect()->route('admin.login')->with('error', 'Authentication required.');
        }

        if (!$subAdmin->status) {
            Auth::guard('subadmin')->logout();
            return redirect()->route('admin.login')->with('error', 'Your account is inactive.');
        }

        // 3. Permission Check (only for Sub-Admins)
        if ($permission && !$subAdmin->hasPermission($permission)) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthorized access.'], 403);
            }
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access that module.');
        }

        return $next($request);
    }
}
