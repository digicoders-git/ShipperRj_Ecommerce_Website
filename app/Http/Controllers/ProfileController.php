<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('profile');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $recent_orders = $user->orders()->orderBy('created_at', 'desc')->take(5)->get();
        return view('dashboard', compact('user', 'recent_orders'));
    }

    public function wallet()
    {
        $user = Auth::user();
        $transactions = $user->walletTransactions()->paginate(10);
        return view('wallet', compact('user', 'transactions'));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders()->with(['orderItems.product', 'orderTrackings', 'address'])->orderBy('created_at', 'desc')->paginate(10);
        return view('orders', compact('user', 'orders'));
    }

    public function trackOrder($order_number)
    {
        $user = Auth::user();
        $order = $user->orders()->with(['orderItems.product', 'orderTrackings', 'address'])->where('order_number', $order_number)->firstOrFail();
        return view('order-track', compact('user', 'order'));
    }

    public function addMoney(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        // In a real app, integrate Razorpay/Paypal here.
        // For simulation, just add the balance.
        $user->increment('wallet_balance', $amount);

        \App\Models\WalletTransaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'credit',
            'description' => 'Added money to wallet'
        ]);

        return back()->with('success', '₹' . number_format($amount, 2) . ' added to your wallet successfully!');
    }

    public function update(Request $request)
    {
        \Log::info('Profile update request hit.', $request->all());
        $user = \App\Models\User::find(Auth::id());

        $request->validate([
            'name' => $request->hasFile('profile_photo') ? 'nullable|string|max:255' : 'required|string|max:255',
            'mobile' => 'nullable|string|max:15',
            'alt_mobile' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'mobile', 'alt_mobile', 'address', 'city', 'state', 'pincode']);

        if ($request->hasFile('profile_photo')) {
            \Log::info('Profile photo file detected.');
            // Delete old photo if exists
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            \Log::info('Profile photo stored at: ' . $path);
            $data['profile_photo'] = $path;
        }

        $user->fill($data);
        if ($user->save()) {
            \Log::info('User saved successfully. Photo in DB: ' . $user->profile_photo);
            return back()->with('success', 'Profile updated successfully!');
        }

        \Log::error('User save failed.');
        return back()->with('error', 'Unable to update profile. Please try again.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'Password must be at least 8 characters long.',
            'new_password.confirmed' => 'New password and confirm password do not match.'
        ]);

        $user = \App\Models\User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Your old password is wrong. Please check again!']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
            'plain_password' => $request->new_password,
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    public function destroy(Request $request)
    {
        $user = \App\Models\User::find(Auth::id());
        Auth::logout();

        if ($user->delete()) {
            return redirect('/')->with('success', 'Your account has been permanently deleted.');
        }

        return back()->with('error', 'Unable to delete account. Please try again.');
    }

    public function cancelOrder(Request $request, $id)
    {
        $request->validate(['cancel_reason' => 'required|string|max:1000']);
        $order = Auth::user()->orders()->findOrFail($id);

        // if (!in_array($order->order_status, ['placed', 'confirmed'])) {
        //     return back()->with('error', 'Cancellation not allowed at this stage.');
        // }
        if ($order->order_status !== 'placed') {
            return back()->with('error', 'Cancellation is not allowed once the order is confirmed or processed.');
        }

        // Refund Logic on User Cancellation
        $refundAmount = 0;
        $refundStatus = 'processed';

        if (in_array($order->payment_method, ['online', 'prepaid', 'wallet'])) {
            $refundAmount = $order->total_amount;
            $refundStatus = 'pending';
        } else {
            // COD: advance is non-refundable, so refund is 0
            $refundAmount = 0;
            $refundStatus = 'processed';
        }

        $order->order_status = 'cancelled';
        $order->cancel_reason = $request->cancel_reason;
        $order->refund_amount = $refundAmount;
        $order->refund_status = $refundStatus;
        $order->save();

        if ($refundStatus == 'pending') {
            \App\Models\Refund::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'user_id' => $order->user_id,
                    'amount' => $refundAmount,
                    'status' => 'pending',
                    'reason' => 'Cancellation: ' . $request->cancel_reason
                ]
            );
        }

        // Track changes
        \App\Models\OrderTracking::create([
            'order_id' => $order->id,
            'status' => 'cancelled',
            'message' => 'Order cancellation request submitted by User. Reason: ' . $request->cancel_reason
        ]);

        return back()->with('success', 'Your order cancellation request has been submitted.');
    }

    public function returnOrder(Request $request, $id)
    {
        $request->validate(['return_reason' => 'required|string|max:1000']);
        $order = Auth::user()->orders()->with('orderItems.product')->findOrFail($id);

        if ($order->order_status != 'delivered') {
            return back()->with('error', 'Return can only be requested after delivery.');
        }

        $delivered_at = $order->delivered_at ?? $order->updated_at;
        if (!$delivered_at) {
            return back()->with('error', 'Delivery timestamp missing. Contact Support.');
        }

        $canReturn = true;
        foreach ($order->orderItems as $item) {
            $daysSinceDelivered = $delivered_at->diffInDays(now());
            if ($daysSinceDelivered > ($item->product->return_days ?? 7)) {
                $canReturn = false;
                break;
            }
        }

        if (!$canReturn) {
            return back()->with('error', 'Return window closed for this order.');
        }

        $order->order_status = 'return_requested';
        $order->return_status = 'pending';
        $order->return_reason = $request->return_reason;
        $order->refund_amount = $order->total_amount;
        $order->refund_status = 'pending';
        $order->save();

        \App\Models\Refund::updateOrCreate(
            ['order_id' => $order->id],
            [
                'user_id' => $order->user_id,
                'amount' => $order->total_amount,
                'status' => 'pending',
                'reason' => 'Return: ' . $request->return_reason
            ]
        );

        // Track changes
        \App\Models\OrderTracking::create([
            'order_id' => $order->id,
            'status' => 'return_requested',
            'message' => 'Return request submitted by User. Reason: ' . $request->return_reason
        ]);

        return back()->with('success', 'Your return request has been submitted successfully.');
    }
}
