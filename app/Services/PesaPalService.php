<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PesaPalService
{
    protected $consumerKey;
    protected $consumerSecret;
    protected $baseUrl;

    public function __construct()
    {
        $this->consumerKey = env('PESAPAL_CONSUMER_KEY');
        $this->consumerSecret = env('PESAPAL_CONSUMER_SECRET');
        $this->baseUrl = rtrim(env('PESAPAL_BASE_URL'), '/');
    }

    /**
     * Get Access Token from PesaPal v3
     */
    public function getAccessToken()
    {
        try {
            $response = Http::post("{$this->baseUrl}/api/Auth/RequestToken", [
                'consumer_key' => $this->consumerKey,
                'consumer_secret' => $this->consumerSecret,
            ]);

            if ($response->successful()) {
                return $response->json()['token'];
            }

            Log::error('PesaPal Auth Failed', ['response' => $response->body()]);
            return null;
        } catch (\Exception $e) {
            Log::error('PesaPal Auth Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Register IPN URL
     */
    public function registerIpn($token, $url)
    {
        try {
            $response = Http::withToken($token)->post("{$this->baseUrl}/api/URLSetup/RegisterIPN", [
                'url' => $url,
                'ipn_notification_type' => 'GET',
            ]);

            if ($response->successful()) {
                return $response->json()['ipn_id'];
            }

            Log::error('PesaPal IPN Registration Failed', ['response' => $response->body()]);
            return null;
        } catch (\Exception $e) {
            Log::error('PesaPal IPN Registration Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Submit Order and get Redirect URL
     */
    public function submitOrder($token, $orderData)
    {
        try {
            $response = Http::withToken($token)->post("{$this->baseUrl}/api/Transactions/SubmitOrderRequest", $orderData);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('PesaPal Order Submission Failed', ['response' => $response->body()]);
            return null;
        } catch (\Exception $e) {
            Log::error('PesaPal Order Submission Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get Transaction Status
     */
    public function getTransactionStatus($token, $orderTrackingId)
    {
        try {
            $response = Http::withToken($token)->get("{$this->baseUrl}/api/Transactions/GetTransactionStatus", [
                'orderTrackingId' => $orderTrackingId,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('PesaPal Transaction Status Failed', ['response' => $response->body()]);
            return null;
        } catch (\Exception $e) {
            Log::error('PesaPal Transaction Status Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
