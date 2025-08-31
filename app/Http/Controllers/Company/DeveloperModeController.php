<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\GoogleAppsScriptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DeveloperModeController extends Controller
{
    protected $gasService;

    public function __construct(GoogleAppsScriptService $gasService)
    {
        $this->gasService = $gasService;
    }

    /**
     * Save API configuration
     */
    public function saveApiConfig(Request $request)
    {
        $request->validate([
            'gas_deployment_id' => 'required|string|max:255',
            'gas_hmac_key' => 'required|string|max:500',
        ]);

        try {
            $company = Company::where('user_id', Auth::user()->id)->first();

            if (!$company) {
                return back()->with('error', 'Company not found.');
            }

            $company->update([
                'gas_deployment_id' => $request->gas_deployment_id,
                'gas_hmac_key' => $request->gas_hmac_key,
                'gas_access_link' => "https://script.google.com/macros/s/{$request->gas_deployment_id}/exec",
                'gas_api_enabled' => true,
            ]);

            $returnTab = $request->input('return_tab');
            $redirectUrl = route('profile.show');

            if ($returnTab) {
                $redirectUrl .= '?tab=' . $returnTab;
            }

            return redirect($redirectUrl)->with('success', 'API configuration saved successfully!');

        } catch (\Exception $e) {
            Log::error('Error saving API config', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to save API configuration.');
        }
    }

    /**
     * Test API with dummy data (matching GAS reference code)
     */
    public function testApi(Request $request)
    {
        $request->validate([
            'talent_id' => 'nullable|string|max:50',
            'talent_name' => 'nullable|string|max:255',
        ]);

        try {
            $company = Company::where('user_id', Auth::user()->id)->first();

            if (!$company || !$company->gas_api_enabled) {
                return back()->with('error', 'API not configured. Please configure your API settings first.');
            }

            // Generate the exact same URL structure as GAS reference code
            $fullUrl = $this->gasService->generateAutoLink(
                $company->gas_deployment_id,
                $company->gas_hmac_key,
                $request->talent_id ?? 'T1',
                $request->talent_name ?? 'Alice'
            );

            // Test the URL by making a request
            $response = \Illuminate\Support\Facades\Http::timeout(30)->get($fullUrl);

            $result = [
                'success' => $response->successful(),
                'status' => $response->status(),
                'body' => $response->body(),
                'url' => $fullUrl
            ];

            // Log the API endpoint URL to console
            Log::info('GAS API Test - Full URL (matching reference):', [
                'url' => $fullUrl,
                'deployment_id' => $company->gas_deployment_id,
                'response_status' => $response->status(),
                'response_body' => $response->body()
            ]);

            // Update company with test results
            $company->update([
                'gas_last_test' => now(),
                'gas_last_response' => $result,
            ]);

            if ($result['success']) {
                return back()->with('success', 'API test successful! Check the logs for the full URL.');
            } else {
                return back()->with('error', 'API test failed: ' . ($result['body'] ?? 'Unknown error'));
            }

        } catch (\Exception $e) {
            Log::error('GAS API Test Error', [
                'error' => $e->getMessage(),
                'company_id' => $company->id ?? null
            ]);

            return back()->with('error', 'API test failed: ' . $e->getMessage());
        }
    }

    /**
     * Disable API
     */
    public function disableApi()
    {
        try {
            $company = Company::where('user_id', Auth::user()->id)->first();

            if ($company) {
                $company->update([
                    'gas_api_enabled' => false,
                ]);
            }

            return back()->with('success', 'API disabled successfully!');

        } catch (\Exception $e) {
            Log::error('Error disabling API', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to disable API.');
        }
    }

    /**
     * Get API status and configuration
     */
    public function getApiStatus()
    {
        $company = Company::where('user_id', Auth::user()->id)->first();

        return response()->json([
            'enabled' => $company ? $company->gas_api_enabled : false,
            'deployment_id' => $company ? $company->gas_deployment_id : null,
            'access_link' => $company ? $company->gas_access_link : null,
            'last_test' => $company ? $company->gas_last_test : null,
            'last_response' => $company ? json_decode($company->gas_last_response, true) : null,
        ]);
    }
}
