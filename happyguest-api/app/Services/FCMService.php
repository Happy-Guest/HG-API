<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class FCMService
{
    public static function send($token, $notification)
    {
        try {
            $response =
                Http::acceptJson()->withToken(config('fcm.token'))->post(
                    'https://fcm.googleapis.com/fcm/send',
                    [
                        'to' => $token,
                        'notification' => $notification,
                    ]
                );

            if ($response->successful()) {
                // Success, log or handle accordingly
            } else {
                // Handle unsuccessful response
                Log::error('FCM Request Failed: ' . $response->status() . ' - ' . $response->body());
            }
        } catch (Exception $e) {
            // Handle exception
            Log::error('FCM Request Exception: ' . $e->getMessage());
        }
    }
}
