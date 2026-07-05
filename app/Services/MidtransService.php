<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected string $serverKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->serverKey = env('MIDTRANS_SERVER_KEY', '');
        $this->baseUrl = env('MIDTRANS_IS_PRODUCTION', false)
            ? 'https://api.midtrans.com'
            : 'https://api.sandbox.midtrans.com';
    }

    /**
     * Charge a QRIS payment.
     */
    public function chargeQris(string $orderId, int $amount)
    {
        $url = $this->baseUrl . '/v2/charge';
        $auth = base64_encode($this->serverKey . ':');

        $payload = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'qris' => [
                'acquirer' => 'gopay',
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $auth,
            ])->post($url, $payload);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Midtrans QRIS Charge Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Check transaction status.
     */
    public function checkStatus(string $orderId)
    {
        $url = $this->baseUrl . '/v2/' . $orderId . '/status';
        $auth = base64_encode($this->serverKey . ':');

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $auth,
            ])->get($url);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Midtrans Status Check Error: ' . $e->getMessage());
            return null;
        }
    }
}
