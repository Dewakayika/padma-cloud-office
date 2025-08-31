<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CompanyOnboardingController extends Controller
{

    // Show the onboarding page
    public function showOnboarding()
    {
        return view('onboarding.company.start-onboarding');
    }

    // Show the onboarding step
    public function showStep($step = 1)
    {
        $user = Auth::user();
        $company = Company::where('user_id', $user->id)->firstOrFail();
        return view('onboarding.company.step' . $step, compact('company', 'user', 'step'));
    }

    // Handle onboarding step submission
    public function postStep(Request $request, $step)
    {
        $user = Auth::user();
        $company = Company::where('user_id', $user->id)->firstOrFail();

        switch ((int)$step) {
            case 1: // Legal & Verification
                $validator = Validator::make($request->all(), [
                    'company_name' => 'required|string|max:255',
                    'registration_number' => 'required|string|max:255',
                    'address' => 'required|string|max:1000',
                    'business_license' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB max
                ], [
                    'company_name.required' => 'Company name is required.',
                    'registration_number.required' => 'Company registration number is required.',
                    'address.required' => 'Company address is required.',
                    'business_license.file' => 'The business license must be a valid file.',
                    'business_license.mimes' => 'The business license must be a PDF, JPG, or PNG file.',
                    'business_license.max' => 'The business license file size must not exceed 10MB.',
                ]);

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                try {
                    $company->company_name = $request->company_name;
                    $company->registration_number = $request->registration_number;
                    $company->address = $request->address;

                    // Handle file upload
                    if ($request->hasFile('business_license')) {
                        $file = $request->file('business_license');

                        // Delete old file if exists
                        if ($company->business_license_path && Storage::disk('public')->exists($company->business_license_path)) {
                            Storage::disk('public')->delete($company->business_license_path);
                        }

                        // Store new file with unique name
                        $fileName = 'business_licenses/' . time() . '_' . $user->id . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('business_licenses', $fileName, 'public');
                        $company->business_license_path = $path;
                    }

                    $company->save();

                    // Also update user name
                    $user->name = $request->company_name;
                    $user->save();

                } catch (\Exception $e) {
                    return back()->withErrors(['error' => 'An error occurred while saving your information. Please try again.'])->withInput();
                }
                break;

            case 2: // Billing & Tax
                $request->validate([
                    'billing_address' => 'required|string|max:255',
                    'billing_email' => 'required|email|max:255',
                    'invoice_recipient' => 'required|string|max:255',
                    'zip_code' => 'required|string|max:20',
                    'country' => 'required|string|max:100',
                    'tax_id' => 'nullable|string|max:100',
                    'payment_schedule' => 'required|date',
                    'currency' => 'required|string|max:20',
                ]);
                $company->billing_address = $request->billing_address;
                $company->billing_email = $request->billing_email;
                $company->invoice_recipient = $request->invoice_recipient;
                $company->zip_code = $request->zip_code;
                $company->country = $request->country;
                $company->tax_id = $request->tax_id;
                $company->payment_schedule = $request->payment_schedule;
                $company->currency = $request->currency;
                $company->save();
                break;

            case 3: // Collaboration
                $request->validate([
                    'primary_use_case' => 'required|string|max:255',
                    'collaboration_tools' => 'nullable|array',
                    'nda_agreed' => 'required|in:1,on',
                ]);
                $company->primary_use_case = $request->primary_use_case;
                $company->collaboration_tools = $request->collaboration_tools ? json_encode($request->collaboration_tools) : null;
                $company->nda_agreed = $request->has('nda_agreed');
                $company->save();
                // Mark onboarding as complete (optional)
                // $user->is_onboarding_complete = true;
                $user->save();
                break;
        }

        // Check if the request came from settings page or profile page
        if ($request->has('from_settings') || $request->header('Referer') && (str_contains($request->header('Referer'), '/company/onboarding-settings') || str_contains($request->header('Referer'), '/user/profile'))) {
            $returnTab = $request->input('return_tab');
            $redirectUrl = route('profile.show');

            if ($returnTab) {
                $redirectUrl .= '?tab=' . $returnTab;
            }

            return redirect($redirectUrl)->with('success', 'Information updated successfully!');
        }

        // Redirect to next step or dashboard
        $nextStep = ((int)$step < 3) ? (int)$step + 1 : null;
        if ($nextStep) {
            return redirect()->route('company.onboarding.step', ['step' => $nextStep])->with('success', 'Step ' . $step . ' completed successfully!');
        } else {
            return redirect()->route('home')->with('success', 'Onboarding complete!');
        }
    }

    public function index()
    {
        $user = auth()->user();
        $company = Company::where('user_id', $user->id)->first();

        if (!$company) {
            return redirect()->route('home')->with('error', 'Company not found.');
        }

        // Onboarding steps check
        $missingOnboardingSteps = [];

        // Step 1: Legal & Verification
        if (empty($company->company_name) || empty($company->registration_number) || empty($company->address)) {
            $missingOnboardingSteps[] = 'Legal & Verification';
        }
        // Step 2: Billing & Tax
        if (empty($company->billing_address) || empty($company->billing_email) || empty($company->invoice_recipient) || empty($company->zip_code) || empty($company->country) || empty($company->payment_schedule) || empty($company->currency)) {
            $missingOnboardingSteps[] = 'Billing & Tax';
        }
        // Step 3: Collaboration Preferences
        if (empty($company->primary_use_case) || !$company->nda_agreed) {
            $missingOnboardingSteps[] = 'Collaboration Preferences';
        }

        // ... rest of your index logic ...

        return view('users.Company.index', compact(
            // ... existing variables ...
            'missingOnboardingSteps'
        ));
    }
}
