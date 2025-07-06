<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyOnboardingController extends Controller
{
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
                $request->validate([
                    'company_name' => 'required|string|max:255',
                    'registration_number' => 'required|string|max:255',
                    'address' => 'required|string|max:255',
                    'business_license' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                ]);
                $company->company_name = $request->company_name;
                $company->registration_number = $request->registration_number;
                $company->address = $request->address;
                if ($request->hasFile('business_license')) {
                    $path = $request->file('business_license')->store('business_licenses', 'public');
                    $company->business_license_path = $path;
                }
                $company->save();
                // Also update user name
                $user->name = $request->company_name;
                $user->save();
                break;
            case 2: // Team Setup
                // Implement as needed
                break;
            case 3: // Billing & Tax
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
            case 4: // Collaboration Preferences
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

        // Check if the request came from settings page
        if ($request->has('from_settings') || $request->header('Referer') && str_contains($request->header('Referer'), '/company/onboarding-settings')) {
            return redirect()->route('profile.show')->with('success', 'Information updated successfully!');
        }

        // Check if the request came from profile page
        if ($request->header('Referer') && str_contains($request->header('Referer'), '/user/profile')) {
            return redirect()->route('profile.show')->with('success', 'Company information updated successfully!');
        }

        // Redirect to next step or dashboard
        $nextStep = ((int)$step < 4) ? (int)$step + 1 : null;
        if ($nextStep) {
            return redirect()->route('company.onboarding.step', ['step' => $nextStep]);
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
        // Step 2: Team Setup (customize as needed)
        // Example: if you want at least 1 team member
        // if ($company->teamMembers()->count() < 1) {
        //     $missingOnboardingSteps[] = 'Team Setup';
        // }
        // Step 3: Billing & Tax
        if (empty($company->billing_address) || empty($company->billing_email) || empty($company->invoice_recipient) || empty($company->zip_code) || empty($company->country) || empty($company->payment_schedule) || empty($company->currency)) {
            $missingOnboardingSteps[] = 'Billing & Tax';
        }
        // Step 4: Collaboration Preferences
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
