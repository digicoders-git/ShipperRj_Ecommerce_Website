<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WalletOffer;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Auth;
use App\Services\CashfreeService;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $user->walletTransactions()->latest();

        if ($request->filter == 'credits') {
            $query->where('type', 1);
        } elseif ($request->filter == 'debits') {
            $query->where('type', 2);
        }

        $transactions = $query->paginate(10)->withQueryString();
        $offers = WalletOffer::where('status', 1)->orderBy('min_amount', 'asc')->get();
        return view('wallet', compact('user', 'transactions', 'offers'));
    }

    public function initiate(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);

        $user = Auth::user();
        $orderId = 'WLT_' . time() . '_' . $user->id;

        $cashfreeService = new CashfreeService();
        $cfResult = $cashfreeService->createOrder(
            $orderId,
            (float) $request->amount,
            $user->name ?? 'Customer',
            $user->email ?? 'customer@example.com',
            $user->mobile ?? '9999999999'
        );

        if ($cfResult['success']) {
            return response()->json([
                'success' => true,
                'payment_session_id' => $cfResult['payment_session_id'],
                'order_id' => $orderId,
                'amount' => $request->amount,
                'mode' => $cashfreeService->getMode()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $cfResult['message'] ?? 'Unable to initiate Cashfree payment.'
        ]);
    }

    public function verify(Request $request)
    {
        $orderId = $request->order_id;
        $amount = (float) $request->amount;

        $cashfreeService = new CashfreeService();
        $status = $cashfreeService->getOrderStatus($orderId);

        if ($status['success'] && isset($status['data']['order_status']) && in_array($status['data']['order_status'], ['PAID', 'SUCCESS'])) {
            $user = Auth::user();

            // Calculate Bonus
            $bonus = 0;
            $bestOffer = WalletOffer::where('status', 1)
                ->where('min_amount', '<=', $amount)
                ->orderBy('min_amount', 'desc')
                ->first();

            if ($bestOffer) {
                $bonus = $bestOffer->bonus_amount;
            }

            $totalAdd = $amount + $bonus;
            $user->increment('wallet_balance', $totalAdd);

            WalletTransaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 1,
                'description' => 'Wallet Recharge via Cashfree'
            ]);

            if ($bonus > 0) {
                WalletTransaction::create([
                    'user_id' => $user->id,
                    'amount' => $bonus,
                    'type' => 1,
                    'description' => 'Wallet Bonus (Offer)'
                ]);
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'error' => $status['message'] ?? 'Payment verification failed.']);
    }
}
