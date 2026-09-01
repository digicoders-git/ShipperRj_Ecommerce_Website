<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PushSubscription;
use App\Services\WebPushService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PushNotificationController extends Controller
{
    protected WebPushService $webPushService;

    public function __construct(WebPushService $webPushService)
    {
        $this->webPushService = $webPushService;
    }

    /**
     * Return VAPID Public Key for client subscription.
     */
    public function getPublicKey()
    {
        $key = $this->webPushService->getPublicKey();
        return response()->json([
            'success' => !empty($key),
            'public_key' => $key
        ]);
    }

    /**
     * Store or update Web Push Subscription.
     */
    public function subscribe(Request $request)
    {
        $endpoint = $request->input('endpoint');
        if (!$endpoint) {
            return response()->json(['success' => false, 'message' => 'Invalid endpoint.'], 400);
        }

        $keys = $request->input('keys', []);
        $publicKey = $keys['p256dh'] ?? null;
        $authToken = $keys['auth'] ?? null;
        $contentEncoding = $request->input('contentEncoding', 'aes128gcm');

        $userId = Auth::check() ? Auth::id() : null;

        $subscription = PushSubscription::updateOrCreate(
            ['endpoint' => $endpoint],
            [
                'user_id' => $userId,
                'public_key' => $publicKey,
                'auth_token' => $authToken,
                'content_encoding' => $contentEncoding,
                'user_agent' => $request->userAgent()
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Subscription saved successfully!',
            'subscription_id' => $subscription->id
        ]);
    }

    /**
     * Remove Web Push Subscription.
     */
    public function unsubscribe(Request $request)
    {
        $endpoint = $request->input('endpoint');
        if ($endpoint) {
            PushSubscription::where('endpoint', $endpoint)->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Unsubscribed successfully.'
        ]);
    }

    /**
     * Send instant test push notification to current device/user.
     */
    public function sendTestNotification(Request $request)
    {
        $sub = null;
        if (Auth::check()) {
            $sub = PushSubscription::where('user_id', Auth::id())->latest()->first();
        }

        if (!$sub && $request->input('endpoint')) {
            $sub = PushSubscription::where('endpoint', $request->input('endpoint'))->first();
        }

        if (!$sub) {
            $sub = PushSubscription::latest()->first();
        }

        if (!$sub) {
            return response()->json([
                'success' => false,
                'message' => 'No active push subscriptions found on server.'
            ]);
        }

        $payload = [
            'title' => '🎉 Test Push Notification',
            'body' => 'Web Push Notifications are working 100% on Shopping Club India!',
            'icon' => asset('images/logo-icon.png'),
            'url' => url('/'),
        ];

        $result = $this->webPushService->sendToSubscription($sub, $payload);

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Test Push Notification delivered!' : 'Failed to deliver push notification.'
        ]);
    }
}
