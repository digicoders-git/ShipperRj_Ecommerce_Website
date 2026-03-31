<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderTracking;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('check.subadmin:orders_view', only: ['index', 'show']),
            new Middleware('check.subadmin:orders_update', only: ['update']),
            new Middleware('check.subadmin:orders_invoice', only: ['downloadInvoice']),
            new Middleware('check.subadmin:orders_delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.product', 'address'])->latest()->paginate(15);
        return view('admin.orders', compact('orders'));
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product', 'address', 'orderTrackings'])->findOrFail($id);
        return view('admin.orders-show', compact('order'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'order_status' => 'required',
            'payment_status' => 'required',
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->order_status;
        $newStatus = $request->order_status;

        // Business Logic: Cancellation
        if ($newStatus == 'cancelled' && !in_array($oldStatus, ['placed', 'confirmed'])) {
            return redirect()->back()->with('error', 'Cannot cancel order once it is shipped or delivered.');
        }

        // Logic for Specific Timestamps
        if ($newStatus == 'delivered' && $oldStatus != 'delivered') {
            $order->delivered_at = now();
        } elseif ($newStatus == 'shipped' && $oldStatus != 'shipped') {
            $order->shipped_at = now(); // Even if shipped_at column doesn't exist yet, it's good to have this logic if we add it later or just use tracking.
        }

        // Logic for Refund on Cancellation (ADMIN TRIGGERED)
        if ($newStatus == 'cancelled' && $oldStatus != 'cancelled') {
            if ($order->payment_method == 'online' || $order->payment_method == 'prepaid' || $order->payment_method == 'wallet') {
                $order->refund_amount = $order->total_amount;
                $order->refund_status = 'processed';
            } else {
                // For COD, advance is non-refundable, and base refund is 0
                $order->refund_amount = 0;
                $order->refund_status = 'processed';
            }
        }

        // Return Logic
        if ($newStatus == 'return_approved') {
            $order->return_status = 'Approved';
        } elseif ($newStatus == 'return_pickup') {
            $order->return_status = 'Pickup';
        } elseif ($newStatus == 'returned') {
            $order->return_status = 'Refunded';
            if ($order->payment_method == 'online' || $order->payment_method == 'prepaid' || $order->payment_method == 'wallet') {
                $order->refund_amount = $order->total_amount;
                $order->refund_status = 'processed';
            }
        }

        $order->order_status = $newStatus;
        $order->payment_status = $request->payment_status;
        $order->save();

        // Automatic Status Tracking Log
        $tracking = new OrderTracking();
        $tracking->order_id = $order->id;
        $tracking->status = $newStatus;
        $tracking->message = $request->tracking_message ?? "Order status updated to $newStatus";
        $tracking->save();

        return redirect()->back()->with('success', 'Order updated successfully.');
    }

    public function downloadInvoice($id)
    {
        $order = Order::with(['user', 'orderItems.product', 'address'])->findOrFail($id);
        return view('invoice', compact('order'));
    }
}

