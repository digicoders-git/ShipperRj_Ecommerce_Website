<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\PushSubscription;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\VAPID;
use Illuminate\Support\Facades\Log;

class WebPushService
{
    protected ?WebPush $webPush = null;
    protected array $vapidKeys = [];

    public function __construct()
    {
        $this->ensureVapidKeys();
    }

    /**
     * Ensure VAPID Public/Private keys exist in database settings.
     */
    public function ensureVapidKeys(): void
    {
        $settings = Setting::getAllCached();
        $pubKey = $settings['vapid_public_key'] ?? null;
        $privKey = $settings['vapid_private_key'] ?? null;

        if (!$pubKey || !$privKey) {
            try {
                $keys = VAPID::createVapidKeys();
                $pubKey = $keys['publicKey'];
                $privKey = $keys['privateKey'];

                Setting::updateOrCreate(['key' => 'vapid_public_key'], ['value' => $pubKey]);
                Setting::updateOrCreate(['key' => 'vapid_private_key'], ['value' => $privKey]);
                Setting::clearRequestCache();
            } catch (\Throwable $e) {
                Log::error('VAPID key generation failed: ' . $e->getMessage());
                // Fallback valid VAPID keys for Windows environments without OpenSSL EC curve configuration
                $pubKey = $pubKey ?: 'BOYrD601qTShrtqoQwRpmynJLujQaWoQ8mIQ19Bjti_5sYbazTmnfWU1XGWynhip3bz0zjgX0D43j_BV_F5CdWU';
                $privKey = $privKey ?: 'PXUgIg8Gy3PWV7VGLmrJC4o1EG0wMhuDAyEjJvodtAo';
                Setting::updateOrCreate(['key' => 'vapid_public_key'], ['value' => $pubKey]);
                Setting::updateOrCreate(['key' => 'vapid_private_key'], ['value' => $privKey]);
            }
        }

        $this->vapidKeys = [
            'VAPID' => [
                'subject' => config('app.url', 'http://localhost:8000'),
                'publicKey' => $pubKey,
                'privateKey' => $privKey,
            ]
        ];
    }

    /**
     * Get the VAPID Public Key for client-side subscription.
     */
    public function getPublicKey(): ?string
    {
        return $this->vapidKeys['VAPID']['publicKey'] ?? null;
    }

    /**
     * Get WebPush Client instance.
     */
    public function getWebPush(): WebPush
    {
        if (!$this->webPush) {
            $this->webPush = new WebPush($this->vapidKeys);
            $this->webPush->setReuseVAPIDHeaders(true);
        }
        return $this->webPush;
    }

    /**
     * Send notification to a single PushSubscription record.
     */
    public function sendToSubscription(PushSubscription $sub, array $payload): bool
    {
        try {
            $subscription = Subscription::create([
                'endpoint' => $sub->endpoint,
                'publicKey' => $sub->public_key,
                'authToken' => $sub->auth_token,
                'contentEncoding' => $sub->content_encoding ?? 'aes128gcm',
            ]);

            $jsonPayload = json_encode($payload);
            $webPush = $this->getWebPush();
            $webPush->queueNotification($subscription, $jsonPayload);

            $results = $webPush->flush();
            foreach ($results as $report) {
                $endpoint = $report->getRequest()->getUri()->__toString();
                if ($report->isSuccess()) {
                    Log::info("[WebPush] Notification delivered successfully to {$endpoint}");
                    return true;
                } else {
                    Log::warning("[WebPush] Message failed to send to {$endpoint}: {$report->getReason()}");
                    if ($report->isSubscriptionExpired()) {
                        // Delete expired/invalid endpoint
                        PushSubscription::where('endpoint', $endpoint)->delete();
                        Log::info("[WebPush] Deleted expired subscription: {$endpoint}");
                    }
                    return false;
                }
            }
        } catch (\Exception $e) {
            Log::error('[WebPush Exception] ' . $e->getMessage());
            return false;
        }
        return false;
    }

    /**
     * Broadcast notification to all active push subscriptions.
     */
    public function broadcast(array $payload): array
    {
        $subscriptions = PushSubscription::all();
        $webPush = $this->getWebPush();
        $sentCount = 0;
        $failedCount = 0;

        $jsonPayload = json_encode($payload);

        foreach ($subscriptions as $sub) {
            try {
                $subscription = Subscription::create([
                    'endpoint' => $sub->endpoint,
                    'publicKey' => $sub->public_key,
                    'authToken' => $sub->auth_token,
                    'contentEncoding' => $sub->content_encoding ?? 'aes128gcm',
                ]);
                $webPush->queueNotification($subscription, $jsonPayload);
            } catch (\Exception $e) {
                Log::error("[WebPush Queue Error] " . $e->getMessage());
                $failedCount++;
            }
        }

        foreach ($webPush->flush() as $report) {
            $endpoint = $report->getRequest()->getUri()->__toString();
            if ($report->isSuccess()) {
                $sentCount++;
            } else {
                $failedCount++;
                if ($report->isSubscriptionExpired()) {
                    PushSubscription::where('endpoint', $endpoint)->delete();
                }
            }
        }

        return [
            'total' => count($subscriptions),
            'success' => $sentCount,
            'failed' => $failedCount
        ];
    }
}
