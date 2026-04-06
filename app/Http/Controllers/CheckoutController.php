<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $addresses = UserAddress::where('user_id', $user->id)->latest()->get();

        $buy_now = $request->get('buy_now');
        $qty = $request->get('qty', 1);

        $items = [];
        $total = 0;
        $order_type = 'cart';
        $online_shipping = 0;
        $cod_shipping = 0;

        // Fetch Global Settings using Cache
        $settingsData = \App\Models\Setting::getAllCached();
        $global_online = ($settingsData['global_online_shipping'] ?? '') !== '' ? (float) $settingsData['global_online_shipping'] : 0;
        $global_cod = ($settingsData['global_cod_shipping'] ?? '') !== '' ? (float) $settingsData['global_cod_shipping'] : 0;
        $global_adv = ($settingsData['global_cod_advance_percent'] ?? '') !== '' ? (float) $settingsData['global_cod_advance_percent'] : 0;

        if ($buy_now) {
            $product = Product::findOrFail($buy_now);

            // Calculation logic: use product value if not NULL/zero/empty, otherwise fallback to global
            $item_adv = ((float) $product->cod_advance_percent > 0) ? $product->cod_advance_percent : $global_adv;

            // Treat these as percentages now
            $item_online_ship_pct = ((float) $product->online_shipping_charges > 0) ? $product->online_shipping_charges : $global_online;
            $item_cod_ship_pct = ((float) $product->cod_shipping_charges > 0) ? $product->cod_shipping_charges : $global_cod;

            $item_online_ship = ($product->selling_price * $item_online_ship_pct / 100);
            $item_cod_ship = ($product->selling_price * $item_cod_ship_pct / 100);

            $items[] = [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'qty' => $qty,
                'price' => $product->selling_price,
                'advance_percent' => $item_adv,
                'online_shipping' => $item_online_ship,
                'cod_shipping' => $item_cod_ship,
                'online_shipping_pct' => $item_online_ship_pct,
                'cod_shipping_pct' => $item_cod_ship_pct,
                'min_qty' => $product->minimum_order_quantity ?? 1
            ];
            $total = $product->selling_price * $qty;
            $online_shipping += ($item_online_ship * $qty);
            $cod_shipping += ($item_cod_ship * $qty);
            $order_type = 'buy_now';
        } else {
            $carts = Cart::with('product')->where('user_id', $user->id)->get();
            foreach ($carts as $cart) {
                // Calculation logic for each cart item: favor global if product is empty/0
                $item_adv = ((float) $cart->product->cod_advance_percent > 0) ? $cart->product->cod_advance_percent : $global_adv;

                $item_online_ship_pct = ((float) $cart->product->online_shipping_charges > 0) ? $cart->product->online_shipping_charges : $global_online;
                $item_cod_ship_pct = ((float) $cart->product->cod_shipping_charges > 0) ? $cart->product->cod_shipping_charges : $global_cod;

                $item_online_ship = ($cart->product->selling_price * $item_online_ship_pct / 100);
                $item_cod_ship = ($cart->product->selling_price * $item_cod_ship_pct / 100);

                $items[] = [
                    'id' => $cart->product->id,
                    'name' => $cart->product->name,
                    'image' => $cart->product->image,
                    'qty' => $cart->quantity,
                    'price' => $cart->product->selling_price,
                    'advance_percent' => $item_adv,
                    'online_shipping' => $item_online_ship,
                    'cod_shipping' => $item_cod_ship,
                    'online_shipping_pct' => $item_online_ship_pct,
                    'cod_shipping_pct' => $item_cod_ship_pct,
                    'min_qty' => $cart->product->minimum_order_quantity ?? 1
                ];
                $total += ($cart->product->selling_price * $cart->quantity);
                $online_shipping += ($item_online_ship * $cart->quantity);
                $cod_shipping += ($item_cod_ship * $cart->quantity);
            }
        }

        if (empty($items)) {
            return redirect('/')->with('error', 'Your cart is empty.');
        }

        $min_order_val = (isset($settingsData['min_order_price']) && $settingsData['min_order_price'] !== '') ? (float) $settingsData['min_order_price'] : 0;
        /* Min order validation moved to frontend Place Order button as per user request */
        // if($min_order_val > 0 && $total < $min_order_val) {
        //     return redirect()->back()->with('error', 'Minimum order amount to place order is ₹'.number_format($min_order_val));
        // }

        $coupons = \App\Models\Coupon::where('status', 1)
            ->where('expiry_date', '>=', date('Y-m-d'))
            ->get();

        // Calculate total advance required across all items
        $base_advance = 0;
        foreach ($items as $item) {
            $base_advance += ($item['price'] * $item['qty'] * $item['advance_percent'] / 100);
        }

        $online_shipping = (float) $online_shipping;
        $cod_shipping = (float) $cod_shipping;
        $shipping_savings_amount = $cod_shipping - $online_shipping;
        $shipping_savings_pct = ($total > 0) ? ($shipping_savings_amount / $total * 100) : 0;

        return view('checkout', compact(
            'addresses',
            'items',
            'total',
            'order_type',
            'buy_now',
            'qty',
            'online_shipping',
            'cod_shipping',
            'coupons',
            'base_advance',
            'global_online',
            'global_cod',
            'global_adv',
            'min_order_val',
            'shipping_savings_pct',
            'shipping_savings_amount'
        ));
    }

    public function checkCoupon(Request $request)
    {
        $code = $request->coupon_code;
        $total = $request->total;

        $coupon = \App\Models\Coupon::where('code', $code)
            ->where('status', 1)
            ->where('expiry_date', '>=', date('Y-m-d'))
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon.']);
        }

        if ($total < $coupon->min_spend) {
            return response()->json(['success' => false, 'message' => 'Minimum spend of ₹' . $coupon->min_spend . ' required.']);
        }

        return response()->json([
            'success' => true,
            'discount' => $coupon->discount_amount,
            'message' => 'Coupon applied! You saved ₹' . $coupon->discount_amount
        ]);
    }

    // ... saveAddress and selectAddress methods ...
    public function saveAddress(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|regex:/^[6-9]\d{9}$/',
            'alt_mobile' => 'nullable|regex:/^[6-9]\d{9}$/',
            'address_line' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'type' => 'required'
        ]);

        $is_first = UserAddress::where('user_id', Auth::id())->count() === 0;

        $address = UserAddress::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'mobile' => $request->mobile,
            'alt_mobile' => $request->alt_mobile,
            'address_line' => $request->address_line,
            'landmark' => $request->landmark,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'type' => $request->type,
            'is_default' => $is_first
        ]);

        return response()->json(['success' => true, 'address' => $address]);
    }

    public function selectAddress(Request $request)
    {
        return response()->json(['success' => true]);
    }

    public function processOrder(Request $request)
    {
        $user = Auth::user();
        $items = [];
        $total = 0;
        $shipping = 0;

        // Fetch Global Settings for backend validation (using Cache)
        $settingsData = \App\Models\Setting::getAllCached();
        $global_online = ($settingsData['global_online_shipping'] ?? '') !== '' ? (float) $settingsData['global_online_shipping'] : 0;
        $global_cod = ($settingsData['global_cod_shipping'] ?? '') !== '' ? (float) $settingsData['global_cod_shipping'] : 0;
        $global_adv = ($settingsData['global_cod_advance_percent'] ?? '') !== '' ? (float) $settingsData['global_cod_advance_percent'] : 0;
        $min_order_val = (isset($settingsData['min_order_price']) && $settingsData['min_order_price'] !== '') ? (float) $settingsData['min_order_price'] : 0;

        if ($request->order_type == 'buy_now') {
            $product = Product::findOrFail($request->buy_now);

            // MOQ Check
            if ($request->qty < $product->minimum_order_quantity) {
                return redirect()->back()->with('error', 'MOQ Error for ' . $product->name);
            }

            $item_adv = ((float) $product->cod_advance_percent > 0) ? $product->cod_advance_percent : $global_adv;

            $item_online_ship_pct = ((float) $product->online_shipping_charges > 0) ? $product->online_shipping_charges : $global_online;
            $item_cod_ship_pct = ((float) $product->cod_shipping_charges > 0) ? $product->cod_shipping_charges : $global_cod;

            $items[] = [
                'id' => $product->id,
                'qty' => $request->qty,
                'price' => $product->selling_price,
                'advance_percent' => $item_adv
            ];
            $total = $product->selling_price * $request->qty;

            $calculated_shipping = ($request->payment_method == 'cod')
                ? ($product->selling_price * $item_cod_ship_pct / 100)
                : ($product->selling_price * $item_online_ship_pct / 100);

            $shipping = round($calculated_shipping * $request->qty, 2);
        } else {
            $carts = Cart::with('product')->where('user_id', $user->id)->get();
            foreach ($carts as $cart) {
                // MOQ Check
                if ($cart->quantity < $cart->product->minimum_order_quantity) {
                    return redirect('/cart')->with('error', 'MOQ Error for ' . $cart->product->name);
                }

                $item_adv = ((float) $cart->product->cod_advance_percent > 0) ? $cart->product->cod_advance_percent : $global_adv;

                $item_online_ship_pct = ((float) $cart->product->online_shipping_charges > 0) ? $cart->product->online_shipping_charges : $global_online;
                $item_cod_ship_pct = ((float) $cart->product->cod_shipping_charges > 0) ? $cart->product->cod_shipping_charges : $global_cod;

                $items[] = [
                    'id' => $cart->product->id,
                    'qty' => $cart->quantity,
                    'price' => $cart->product->selling_price,
                    'advance_percent' => $item_adv
                ];
                $total += ($cart->product->selling_price * $cart->quantity);

                $calculated_shipping = ($request->payment_method == 'cod')
                    ? ($cart->product->selling_price * $item_cod_ship_pct / 100)
                    : ($cart->product->selling_price * $item_online_ship_pct / 100);

                $shipping += ($calculated_shipping * $cart->quantity);
            }
            $shipping = round($shipping, 2);
        }



        // Coupon Handling
        $discount = 0;
        if ($request->coupon_code) {
            $coupon = \App\Models\Coupon::where('code', $request->coupon_code)
                ->where('status', 1)
                ->where('expiry_date', '>=', date('Y-m-d'))
                ->first();
            if ($coupon && $total >= $coupon->min_spend) {
                $discount = $coupon->discount_amount;
            }
        }

        $grand_total = round(($total + $shipping) - $discount, 2);

        // RE-VALIDATE: Min Order Total Price during processing
        if ($min_order_val > 0 && $grand_total < $min_order_val) {
            return redirect()->back()->with('error', 'Minimum order total of ₹' . number_format($min_order_val) . ' is required.');
        }

        $prepaid_amount = 0;
        if ($request->payment_method == 'cod') {
            $itemAdvance = 0;
            foreach ($items as $item) {
                // Ensure we use global default if product advance is not explicitly set
                $adv_pct = (float) ($item['advance_percent'] ?? $global_adv);
                $itemAdvance += ($item['price'] * $item['qty'] * $adv_pct / 100);
            }
            // Advance payment = Item Advance + Full Shipping (to secure logistical costs)
            $prepaid_amount = round($itemAdvance + $shipping, 2);

            // Ensure prepaid doesn't exceed total (edge case with huge shipping/discount)
            if ($prepaid_amount > $grand_total)
                $prepaid_amount = $grand_total;
        } else {
            $prepaid_amount = $grand_total;
        }

        $order = Order::create([
            'user_id' => $user->id,
            'address_id' => $request->address_id,
            'order_number' => strtoupper(uniqid('ORD')),
            'shipping_amount' => $shipping,
            'coupon_discount' => $discount,
            'coupon_code' => $request->coupon_code,
            'total_amount' => $grand_total,
            'prepaid_amount' => $prepaid_amount,
            'cod_amount' => $grand_total - $prepaid_amount,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'order_status' => 'placed'
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['qty'],
                'price' => $item['price']
            ]);
        }

        if ($prepaid_amount > 0) {
            return redirect()->route('checkout.payment', $order->id);
        } else {
            $order->update(['payment_status' => 'paid']);
            if ($request->order_type == 'cart')
                Cart::where('user_id', $user->id)->delete();
            return redirect('/order-success?order_id=' . $order->id);
        }
    }

    public function paymentPage($order_id)
    {
        $order = Order::with('user')->findOrFail($order_id);

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        $razorOrderData = [
            'receipt' => $order->order_number,
            'amount' => (int) round($order->prepaid_amount * 100),
            'currency' => 'INR'
        ];

        $razorOrder = $api->order->create($razorOrderData);

        $order->update(['razorpay_order_id' => $razorOrder['id']]);

        $keyID = config('services.razorpay.key');

        return view('checkout-payment', compact('order', 'razorOrder', 'keyID'));
    }

    public function payByWallet(Request $request)
    {
        $user = Auth::user();
        $order = Order::findOrFail($request->order_id);

        if ($user->wallet_balance < $order->prepaid_amount) {
            return response()->json(['success' => false, 'message' => 'Insufficient wallet balance.']);
        }

        // Deduct from wallet
        $user->wallet_balance -= $order->prepaid_amount;
        $user->save();

        // Create wallet transaction record
        \App\Models\WalletTransaction::create([
            'user_id' => $user->id,
            'amount' => $order->prepaid_amount,
            'type' => 2, // Debit
            'description' => 'Payment for Order #' . $order->order_number
        ]);

        $order->update(['payment_status' => 'paid']);

        // Clear cart for the user
        Cart::where('user_id', $user->id)->delete();

        return response()->json(['success' => true]);
    }

    public function downloadInvoice($order_id)
    {
        $order = Order::where('user_id', Auth::id())->with(['orderItems.product', 'user', 'address'])->findOrFail($order_id);
        return view('invoice', compact('order'));
    }

    public function verifyPayment(Request $request)
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->firstOrFail();

        try {
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];
            $api->utility->verifyPaymentSignature($attributes);

            $order->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'payment_status' => 'paid'
            ]);

            // Clear cart
            Cart::where('user_id', $order->user_id)->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
