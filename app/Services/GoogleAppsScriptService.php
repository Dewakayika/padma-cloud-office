<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GoogleAppsScriptService
{
    /**
     * Generate HMAC signature for data
     */
    public function generateHmacSignature($data, $hmacKey)
    {
        $jsonData = json_encode($data);
        $base64Data = $this->base64UrlEncode($jsonData);
        $signature = hash_hmac('sha256', $base64Data, $hmacKey, true);
        return $this->base64UrlEncode($signature);
    }

    /**
     * Base64 URL encode (web-safe)
     */
    public function base64UrlEncode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    /**
     * Send data to Google Apps Script
     */
    public function sendToGoogleAppsScript($deploymentId, $hmacKey, $data)
    {
        try {
            $signature = $this->generateHmacSignature($data, $hmacKey);
            $jsonData = json_encode($data);
            $base64Data = $this->base64UrlEncode($jsonData);

            $url = "https://script.google.com/macros/s/{$deploymentId}/exec";
            $fullUrl = $url . "?data=" . $base64Data . "&sig=" . $signature;

            Log::info('Sending to GAS', [
                'url' => $url,
                'data' => $data,
                'signature' => $signature
            ]);

            // Log the full URL to console for debugging
            \Log::info('GAS API Endpoint URL:', [
                'full_url' => $fullUrl,
                'deployment_id' => $deploymentId,
                'base64_data' => $base64Data,
                'signature' => $signature
            ]);

            $response = Http::timeout(30)->get($fullUrl);

            Log::info('GAS Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'body' => $response->body(),
                'url' => $fullUrl
            ];

        } catch (\Exception $e) {
            Log::error('GAS API Error', [
                'error' => $e->getMessage(),
                'data' => $data ?? null
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'url' => $fullUrl ?? null
            ];
        }
    }

    /**
     * Generate test data for API testing
     */
    public function generateTestData($talentId = 'T1', $talentName = 'Alice')
    {
        return [
            'lastUpdate' => Carbon::now('UTC')->toISOString(),
            'talentId' => $talentId,
            'talentName' => $talentName,
            'workingTime' => '02:30',
            'projectCode' => 'AE_s',
            'projectName' => 'After Effect Storyboard',
            'workTitle' => 'Initial Draft',
            'role' => 'Talent',
            'link' => 'https://drive.google.com/drive/u/0/folders/1W7XyVx32NlevvLXKWQHeUqzJkWckO29t'
        ];
    }

    /**
     * Generate real data from ProjectTracking
     */
    public function generateProjectTrackingData($projectTracking)
    {
        $user = $projectTracking->user;
        $workingDuration = $projectTracking->working_duration ?? 0;
        $hours = floor($workingDuration / 3600);
        $minutes = floor(($workingDuration % 3600) / 60);
        $workingTime = sprintf('%02d:%02d', $hours, $minutes);

        return [
            'lastUpdate' => Carbon::now('UTC')->toISOString(),
            'talentId' => 'T' . $user->id,
            'talentName' => $user->name,
            'workingTime' => $workingTime,
            'projectCode' => $projectTracking->project_code ?? 'N/A',
            'projectName' => $projectTracking->project_title ?? 'N/A',
            'workTitle' => $projectTracking->project_title ?? 'N/A',
            'role' => $projectTracking->role ?? 'Talent',
            'link' => $projectTracking->project_link ?? 'N/A'
        ];
    }
}
