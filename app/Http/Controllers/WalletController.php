<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WalletOffer;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transactions = $user->walletTransactions()->latest()->paginate(10);
        $offers = WalletOffer::where('status', 1)->orderBy('min_amount', 'asc')->get();
        return view('wallet', compact('user', 'transactions', 'offers'));
    }

    public function initiate(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);
        
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        $orderData = [
            'receipt' => 'WLT_' . time() . '_' . Auth::id(),
            'amount' => $request->amount * 100,
            'currency' => 'INR'
        ];
        
        $razorOrder = $api->order->create($orderData);

        return response()->json([
            'success' => true,
            'order_id' => $razorOrder['id'],
            'amount' => $request->amount,
            'key' => config('services.razorpay.key'),
            'name' => Auth::user()->name,
            'email' => Auth::user()->email
        ]);
    }

    public function verify(Request $request)
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];
            $api->utility->verifyPaymentSignature($attributes);
            
            $user = Auth::user();
            $amount = $request->amount;
            
            // Calculate Bonus
            $bonus = 0;
            $bestOffer = WalletOffer::where('status', 1)
                ->where('min_amount', '<=', $amount)
                ->orderBy('min_amount', 'desc')
                ->first();
                
            if($bestOffer) {
                $bonus = $bestOffer->bonus_amount;
            }

            $totalAdd = $amount + $bonus;
            $user->increment('wallet_balance', $totalAdd);

            WalletTransaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 1,
                'description' => 'Wallet Recharge via Razorpay'
            ]);
            
            if($bonus > 0) {
                WalletTransaction::create([
                    'user_id' => $user->id,
                    'amount' => $bonus,
                    'type' => 1,
                    'description' => 'Wallet Bonus (Offer)'
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
