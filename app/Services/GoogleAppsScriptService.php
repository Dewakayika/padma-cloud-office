<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GoogleAppsScriptService
{
    /**
     * Generate HMAC signature for data (matching GAS reference code)
     */
    public function generateHmacSignature($data, $hmacKey)
    {
        // 1. Convert data to JSON string (matching GAS: const json = JSON.stringify(payload))
        $jsonData = json_encode($data);

        // 2. Decode Base64 HMAC key to raw bytes (matching GAS: const keyBytes = Utilities.base64Decode(HMAC_KEY_B64))
        $keyBytes = base64_decode($hmacKey);

        // 3. Compute HMAC-SHA256 over the raw JSON bytes (matching GAS: Utilities.computeHmacSha256Signature(Utilities.newBlob(json).getBytes(), keyBytes))
        $macBytes = hash_hmac('sha256', $jsonData, $keyBytes, true);

        // 4. Web-safe Base64-URL encode the MAC without padding (matching GAS: Utilities.base64EncodeWebSafe(macBytes).replace(/=+$/, ''))
        $signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($macBytes));

        return $signature;
    }

    /**
     * Base64 URL encode (web-safe)
     */
    public function base64UrlEncode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    /**
     * Send data to Google Apps Script (matching GAS reference code)
     */
    public function sendToGoogleAppsScript($deploymentId, $hmacKey, $data)
    {
        try {
            // 1. Convert data to JSON string (matching GAS: const json = JSON.stringify(payload))
            $jsonData = json_encode($data);

            // 2. JSON → web-safe Base64 without padding (matching GAS: Utilities.base64EncodeWebSafe(json).replace(/=+$/, ''))
            $base64Data = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($jsonData));

            // 3. Generate HMAC signature (matching GAS reference code)
            $signature = $this->generateHmacSignature($data, $hmacKey);

            // 4. Build the final URL (matching GAS: const link = `${GAS_URL}?data=${dataB64}&sig=${sigB64}`)
            $url = "https://script.google.com/macros/s/{$deploymentId}/exec";
            $fullUrl = $url . "?data=" . $base64Data . "&sig=" . $signature;

            // Detailed logging for debugging
            Log::info('=== GAS API CALL DEBUG ===', [
                'deployment_id' => $deploymentId,
                'original_data' => $data,
                'json_data' => $jsonData,
                'base64_data' => $base64Data,
                'signature' => $signature,
                'full_url' => $fullUrl,
                'data_structure' => [
                    'has_lastUpdate' => isset($data['lastUpdate']),
                    'has_talentId' => isset($data['talentId']),
                    'has_talentName' => isset($data['talentName']),
                    'has_workingTime' => isset($data['workingTime']),
                    'has_projectCode' => isset($data['projectCode']),
                    'has_projectName' => isset($data['projectName']),
                    'has_workTitle' => isset($data['workTitle']),
                    'has_role' => isset($data['role']),
                    'has_link' => isset($data['link'])
                ]
            ]);

            $response = Http::timeout(30)->get($fullUrl);

            Log::info('GAS Response', [
                'status' => $response->status(),
                'body' => $response->body(),
                'successful' => $response->successful()
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
                'data' => $data ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'url' => $fullUrl ?? null
            ];
        }
    }

    /**
     * Generate test data (using actual project data structure)
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
     * Validate data structure matches GAS reference
     */
    public function validateDataStructure($data)
    {
        $requiredFields = [
            'lastUpdate',
            'talentId',
            'talentName',
            'workingTime',
            'projectCode',
            'projectName',
            'workTitle',
            'role',
            'link'
        ];

        $missingFields = [];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            Log::error('Data structure validation failed', [
                'missing_fields' => $missingFields,
                'provided_data' => $data,
                'required_fields' => $requiredFields
            ]);
            return false;
        }

        Log::info('Data structure validation passed', [
            'data' => $data,
            'all_fields_present' => true
        ]);
        return true;
    }

    /**
     * Compare real data with test data structure
     */
    public function compareDataStructures($realData, $testData = null)
    {
        if (!$testData) {
            $testData = $this->generateTestData();
        }

        $realKeys = array_keys($realData);
        $testKeys = array_keys($testData);

        $missingInReal = array_diff($testKeys, $realKeys);
        $extraInReal = array_diff($realKeys, $testKeys);

        // Compare field values
        $fieldDifferences = [];
        foreach ($testKeys as $key) {
            if (isset($realData[$key]) && isset($testData[$key])) {
                if ($realData[$key] !== $testData[$key]) {
                    $fieldDifferences[$key] = [
                        'test_value' => $testData[$key],
                        'real_value' => $realData[$key]
                    ];
                }
            }
        }

        $comparison = [
            'real_data_keys' => $realKeys,
            'test_data_keys' => $testKeys,
            'missing_in_real' => $missingInReal,
            'extra_in_real' => $extraInReal,
            'field_differences' => $fieldDifferences,
            'structures_match' => empty($missingInReal) && empty($extraInReal) && empty($fieldDifferences)
        ];

        Log::info('Data structure comparison', $comparison);

        return $comparison;
    }

    /**
     * Generate real data from ProjectTracking (matching GAS reference exactly)
     */
    public function generateProjectTrackingData($projectTracking)
    {
        $user = $projectTracking->user;

        // Calculate working duration
        $workingDuration = $projectTracking->working_duration ?? 0;

        // For new projects that just started, set a minimum working time
        if ($workingDuration == 0 && $projectTracking->status === 'active') {
            $workingDuration = 1; // 1 second minimum for new projects
        }

        $hours = floor($workingDuration / 3600);
        $minutes = floor(($workingDuration % 3600) / 60);
        $workingTime = sprintf('%02d:%02d', $hours, $minutes);

        // Determine if this is a start or end event
        $isEndEvent = $projectTracking->status === 'completed' && $projectTracking->end_at;

        // Generate appropriate work title based on event type
        $workTitle = $isEndEvent ? 'Project Completed' : 'Project Started';

        // Ensure project code and name are not empty
        $projectCode = $projectTracking->project_code ?? $projectTracking->project_type ?? 'PROJ_' . $projectTracking->id;
        $projectName = $projectTracking->project_title ?? 'Project ' . $projectTracking->id;

        // Use the exact same payload structure as GAS reference
        $data = [
            'lastUpdate' => Carbon::now('UTC')->toISOString(),
            'talentId' => 'T' . $user->id,
            'talentName' => $user->name,
            'workingTime' => $workingTime,
            'projectCode' => $projectCode,
            'projectName' => $projectName,
            'workTitle' => $workTitle,
            'role' => $projectTracking->role,
            'link' => $projectTracking->project_link ?? 'https://drive.google.com/drive/u/0/folders/1W7XyVx32NlevvLXKWQHeUqzJkWckO29t'
        ];

        // Debug output
        Log::info('generateProjectTrackingData debug', [
            'working_duration' => $workingDuration,
            'working_time' => $workingTime,
            'project_code' => $projectCode,
            'project_name' => $projectName,
            'work_title' => $workTitle,
            'is_end_event' => $isEndEvent,
            'final_data' => $data
        ]);

        // Validate the data structure
        $this->validateDataStructure($data);

        // Compare with test data structure
        $this->compareDataStructures($data);

        return $data;
    }

    /**
     * Generate auto link (matching GAS reference code exactly)
     */
    public function generateAutoLink($deploymentId, $hmacKey, $talentId = 'T1', $talentName = 'Alice')
    {
        // Use the same payload structure as real data
        $payload = [
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

        // 1. Convert data to JSON string (matching GAS: const json = JSON.stringify(payload))
        $jsonData = json_encode($payload);

        // 2. JSON → web-safe Base64 without padding (matching GAS: Utilities.base64EncodeWebSafe(json).replace(/=+$/, ''))
        $base64Data = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($jsonData));

        // 3. Generate HMAC signature (matching GAS reference code)
        $signature = $this->generateHmacSignature($payload, $hmacKey);

        // 4. Build the final URL (matching GAS: const link = `${GAS_URL}?data=${dataB64}&sig=${sigB64}`)
        $url = "https://script.google.com/macros/s/{$deploymentId}/exec";
        $fullUrl = $url . "?data=" . $base64Data . "&sig=" . $signature;

        Log::info('Generated auto link (matching GAS reference)', [
            'payload' => $payload,
            'json_data' => $jsonData,
            'base64_data' => $base64Data,
            'signature' => $signature,
            'full_url' => $fullUrl
        ]);

        return $fullUrl;
    }
}
