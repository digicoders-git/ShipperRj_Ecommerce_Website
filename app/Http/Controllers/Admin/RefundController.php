<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Refund;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $refunds = Refund::with(['order', 'user'])->latest()->get();
        return view('admin.refunds', compact('refunds'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $refund = Refund::with(['order', 'user'])->findOrFail($id);
        
        if ($refund->status == 'approved') {
            return back()->with('error', 'This refund has already been approved and processed.');
        }

        $refund->status = $request->status;
        $refund->save();

        $order = $refund->order;
        $user = $refund->user;

        if ($request->status == 'approved') {
            // Update User Wallet
            $user->increment('wallet_balance', $refund->amount);

            // Create Transaction Record
            \App\Models\WalletTransaction::create([
                'user_id' => $user->id,
                'amount' => $refund->amount,
                'type' => 'credit',
                'description' => 'Refund for Order #' . $order->order_number . ' (Approved by Admin)'
            ]);

            // Sync Order Status
            $order->refund_status = 'processed';
            
            if ($order->order_status == 'return_requested') {
                $order->order_status = 'returned';
                $order->return_status = 'completed';
            }
            
            $order->save();

            // Add Tracking
            \App\Models\OrderTracking::create([
                'order_id' => $order->id,
                'status' => $order->order_status,
                'message' => 'Refund of ₹' . number_format($refund->amount, 2) . ' approved and credited to your wallet.'
            ]);

        } elseif ($request->status == 'rejected') {
            $order->refund_status = 'rejected';
            if ($order->order_status == 'return_requested') {
                $order->return_status = 'rejected';
            }
            $order->save();

            \App\Models\OrderTracking::create([
                'order_id' => $order->id,
                'status' => $order->order_status,
                'message' => 'Your refund request for Order #' . $order->order_number . ' was rejected by Admin.'
            ]);
        }

        return redirect()->back()->with('success', 'Refund status updated and processed.');
    }
}

