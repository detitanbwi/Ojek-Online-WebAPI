<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OneSignalService
{
    protected string $appId;
    protected string $restApiKey;

    public function __construct()
    {
        $this->appId = config('services.onesignal.app_id') ?? env('ONESIGNAL_APP_ID', '');
        $this->restApiKey = config('services.onesignal.rest_api_key') ?? env('ONESIGNAL_REST_API_KEY', '');
    }

    /**
     * Send a high-priority notification to a specific player ID.
     *
     * @param string $playerId OneSignal Player ID
     * @param string $title Notification Title
     * @param string $message Notification Message Content
     * @param array $data Custom data payload (must include type and order_id)
     * @return array
     */
    public function sendNotification(string $playerId, string $title, string $message, array $data = [])
    {
        if (empty($this->appId) || empty($this->restApiKey)) {
            Log::warning('OneSignal credentials not set in environment config.');
            return [
                'success' => false,
                'message' => 'OneSignal configuration missing'
            ];
        }

        $payload = [
            'app_id' => $this->appId,
            'include_player_ids' => [$playerId],
            'headings' => [
                'en' => $title
            ],
            'contents' => [
                'en' => $message
            ],
            'data' => $data,
            // 10 represents high priority in OneSignal API
            'priority' => 10,
            // To ensure it wakes up Android background handler / data payload delivery:
            'android_channel_id' => null, // Optional, can be set if needed
        ];

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json; charset=utf-8',
                'Authorization' => 'Basic ' . $this->restApiKey,
            ])->post('https://onesignal.com/api/v1/notifications', $payload);

            if ($response->successful()) {
                Log::info('OneSignal notification sent successfully', ['response' => $response->json()]);
                return [
                    'success' => true,
                    'response' => $response->json()
                ];
            }

            Log::error('OneSignal notification failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => false,
                'status' => $response->status(),
                'message' => $response->body()
            ];

        } catch (\Exception $e) {
            Log::error('OneSignal notification error', ['exception' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
