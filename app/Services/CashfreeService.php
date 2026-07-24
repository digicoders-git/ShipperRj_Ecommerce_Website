<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CashfreeService
{
    protected string $appId;
    protected string $secretKey;
    protected string $mode;
    protected string $baseUrl;

    public function __construct()
    {
        $this->mode = config('services.cashfree.mode', 'sandbox');
        $this->appId = config('services.cashfree.app_id', '');
        $this->secretKey = config('services.cashfree.secret_key', '');
        
        if ($this->mode === 'production') {
            $this->baseUrl = 'https://api.cashfree.com/pg';
        } else {
            $this->baseUrl = 'https://sandbox.cashfree.com/pg';
        }
    }

    public function getAppId(): string
    {
        return $this->appId;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function createOrder($orderId, float $amount, string $name, string $email, string $phone, ?string $returnUrl = null): array
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($cleanPhone) < 10) {
            $cleanPhone = '9999999999';
        }

        $cleanEmail = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : 'customer@example.com';
        $cleanName = !empty(trim($name)) ? trim($name) : 'Customer';

        $payload = [
            'order_id' => (string) $orderId,
            'order_amount' => round($amount, 2),
            'order_currency' => 'INR',
            'customer_details' => [
                'customer_id' => 'CUST_' . preg_replace('/[^A-Za-z0-9_]/', '_', $orderId),
                'customer_name' => $cleanName,
                'customer_email' => $cleanEmail,
                'customer_phone' => $cleanPhone,
            ]
        ];

        if ($returnUrl) {
            $payload['order_meta'] = [
                'return_url' => $returnUrl
            ];
        }

        try {
            $response = Http::withHeaders([
                'x-client-id' => $this->appId,
                'x-client-secret' => $this->secretKey,
                'x-api-version' => '2023-08-01',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/orders', $payload);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'payment_session_id' => $data['payment_session_id'] ?? null,
                    'cf_order_id' => $data['cf_order_id'] ?? null,
                    'order_id' => $data['order_id'] ?? $orderId,
                    'raw' => $data
                ];
            }

            Log::error('Cashfree Order Creation Failed: ' . $response->body());
            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Failed to create Cashfree order.',
                'raw' => $response->json()
            ];
        } catch (\Exception $e) {
            Log::error('Cashfree Service Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getOrderStatus(string $cfOrderId): array
    {
        try {
            $response = Http::withHeaders([
                'x-client-id' => $this->appId,
                'x-client-secret' => $this->secretKey,
                'x-api-version' => '2023-08-01',
                'Accept' => 'application/json',
            ])->get($this->baseUrl . '/orders/' . $cfOrderId);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Failed to fetch Cashfree order status.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getPayments(string $cfOrderId): array
    {
        try {
            $response = Http::withHeaders([
                'x-client-id' => $this->appId,
                'x-client-secret' => $this->secretKey,
                'x-api-version' => '2023-08-01',
                'Accept' => 'application/json',
            ])->get($this->baseUrl . '/orders/' . $cfOrderId . '/payments');

            if ($response->successful()) {
                return [
                    'success' => true,
                    'payments' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Failed to fetch Cashfree payments.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
