<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PushSubscription;
use App\Models\User;
use App\Services\WebPushService;
use Illuminate\Support\Facades\Log;

class AdminPushNotificationController extends Controller
{
    protected WebPushService $webPushService;

    public function __construct(WebPushService $webPushService)
    {
        $this->webPushService = $webPushService;
    }

    /**
     * Display Push Notification Management Dashboard.
     */
    public function index()
    {
        $totalSubscribers = PushSubscription::count();
        $userSubscribers = PushSubscription::whereNotNull('user_id')->count();
        $guestSubscribers = PushSubscription::whereNull('user_id')->count();
        $vapidPublicKey = $this->webPushService->getPublicKey();

        $recentSubscriptions = PushSubscription::with('user')->latest()->take(10)->get();

        return view('admin.push-notifications', compact(
            'totalSubscribers',
            'userSubscribers',
            'guestSubscribers',
            'vapidPublicKey',
            'recentSubscriptions'
        ));
    }

    /**
     * Broadcast custom Push Notification to all or targeted subscribers.
     */
    public function sendBroadcast(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'body' => 'required|string|max:255',
            'url' => 'nullable|string',
            'icon' => 'nullable|string',
            'image' => 'nullable|string'
        ]);

        $payload = [
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'icon' => $request->input('icon') ?: asset('images/logo-icon.png'),
            'badge' => asset('images/logo-icon.png'),
            'image' => $request->input('image') ?: null,
            'url' => $request->input('url') ?: url('/'),
        ];

        $target = $request->input('target', 'all'); // 'all', 'users', 'guests'

        $query = PushSubscription::query();
        if ($target === 'users') {
            $query->whereNotNull('user_id');
        } elseif ($target === 'guests') {
            $query->whereNull('user_id');
        }

        $subscriptions = $query->get();

        if ($subscriptions->isEmpty()) {
            return redirect()->back()->with('error', 'No active subscribers found for selected target audience.');
        }

        $sentCount = 0;
        $failedCount = 0;

        foreach ($subscriptions as $sub) {
            $result = $this->webPushService->sendToSubscription($sub, $payload);
            if ($result) {
                $sentCount++;
            } else {
                $failedCount++;
            }
        }

        return redirect()->back()->with('success', "Push Notification Broadcast sent! Success: {$sentCount}, Failed: {$failedCount}");
    }
}
