<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\Refund;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('check.subadmin:orders_view', only: ['index', 'show', 'pendingPayments']),
            new Middleware('check.subadmin:orders_update', only: ['update']),
            new Middleware('check.subadmin:orders_invoice', only: ['downloadInvoice']),
            new Middleware('check.subadmin:orders_delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product', 'address']);

        if ($request->has('status') && $request->status !== '') {
            $query->where('order_status', $request->status);
        } else {
            $query->whereNotIn('order_status', ['payment_pending', 'payment_failed']);
        }

        // GST / Invoice Type Filter (B2B vs B2C)
        if ($request->has('gst_type') && $request->gst_type !== '') {
            if ($request->gst_type === 'b2b') {
                $query->where(function ($q) {
                    $q->where('has_gst', 1)
                      ->orWhereNotNull('gst_number');
                });
            } elseif ($request->gst_type === 'b2c') {
                $query->where(function ($q) {
                    $q->where('has_gst', 0)
                      ->whereNull('gst_number');
                });
            }
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        // Counts for filter tabs
        $totalAllCount = Order::whereNotIn('order_status', ['payment_pending', 'payment_failed'])->count();
        $totalB2BCount = Order::whereNotIn('order_status', ['payment_pending', 'payment_failed'])
            ->where(function ($q) {
                $q->where('has_gst', 1)->orWhereNotNull('gst_number');
            })->count();
        $totalB2CCount = Order::whereNotIn('order_status', ['payment_pending', 'payment_failed'])
            ->where(function ($q) {
                $q->where('has_gst', 0)->whereNull('gst_number');
            })->count();

        return view('admin.orders', compact('orders', 'totalAllCount', 'totalB2BCount', 'totalB2CCount'));
    }

    /**
     * Display listing of pending/failed/unpaid orders (abandoned checkouts).
     */
    public function pendingPayments(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product', 'address'])
            ->where(function ($q) {
                $q->whereIn('order_status', ['payment_pending', 'payment_failed', 'pending'])
                  ->orWhereIn('payment_status', ['pending', 'unpaid', 'failed']);
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('mobile', 'LIKE', "%{$search}%");
                  });
            });
        }

        $pendingOrders = $query->orderBy('created_at', 'desc')->paginate(15);

        // Stats
        $totalPendingCount = Order::where(function ($q) {
            $q->whereIn('order_status', ['payment_pending', 'payment_failed', 'pending'])
              ->orWhereIn('payment_status', ['pending', 'unpaid', 'failed']);
        })->count();

        $totalPendingAmount = Order::where(function ($q) {
            $q->whereIn('order_status', ['payment_pending', 'payment_failed', 'pending'])
              ->orWhereIn('payment_status', ['pending', 'unpaid', 'failed']);
        })->sum('total_amount');

        $totalFailedCount = Order::where('payment_status', 'failed')
            ->orWhere('order_status', 'payment_failed')->count();

        return view('admin.pending-payments', compact('pendingOrders', 'totalPendingCount', 'totalPendingAmount', 'totalFailedCount'));
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
            'tracking_link' => 'nullable|url',
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
            $order->shipped_at = now();
        }

        // Save tracking link if provided
        if ($newStatus == 'confirmed') {
            $order->tracking_link = $request->tracking_link;
        }

        // Logic for Refund on Cancellation (ADMIN TRIGGERED)
        if ($newStatus == 'cancelled' && $oldStatus != 'cancelled') {
            if ($order->payment_method == 'online' || $order->payment_method == 'prepaid' || $order->payment_method == 'wallet') {
                $refundAmt = $order->total_amount;
            } else {
                // COD: refund advance amount paid by user
                $refundAmt = (float) ($order->advance_paid ?? 0);
            }

            $order->refund_amount = $refundAmt;
            $order->refund_status = ($refundAmt > 0) ? 'pending' : 'processed';

            if ($refundAmt > 0) {
                Refund::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'user_id' => $order->user_id,
                        'amount' => $refundAmt,
                        'status' => 'pending',
                        'reason' => 'Order Cancellation (Admin Cancelled)'
                    ]
                );
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

