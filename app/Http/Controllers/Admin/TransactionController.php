<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $walletTx = WalletTransaction::with('user')->get()->map(function($t) {
            $t->source = 'wallet';
            $t->display_type = $t->type;
            return $t;
        });

        $orderPayments = \App\Models\Order::with('user')->where('payment_status', 'paid')->get()->map(function($o) {
            return (object)[
                'id' => $o->id,
                'user' => $o->user,
                'display_type' => 'debit',
                'amount' => $o->prepaid_amount,
                'description' => 'Payment for Order #' . $o->order_number,
                'created_at' => $o->updated_at,
                'source' => 'order'
            ];
        });

        $transactions = $walletTx->concat($orderPayments)->sortByDesc('created_at');

        return view('admin.transactions', compact('transactions'));
    }
}

