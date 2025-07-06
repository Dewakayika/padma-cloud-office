@extends('layouts.guest')
@section('title', 'Onboarding Step 1')
@section('meta_description', 'Ini adalah halaman onboarding step 1.')

@section('content')
@php
    $steps = [
        1 => 'Legal & Verification',
        2 => 'Team Setup',
        3 => 'Billing & Tax',
        4 => 'Collaboration'
    ];
    $totalSteps = count($steps);
    $currentStep = $step ?? 3;
    $percent = round(($currentStep - 1) / ($totalSteps - 1) * 100);
@endphp

<div class="max-w-2xl mt-14 mx-auto mb-8">
    <div class="flex items-center justify-between mb-2">
        <div class="font-semibold text-lg">Step {{ $currentStep }} of {{ $totalSteps }}</div>
        <div class="text-sm font-medium text-gray-600">{{ $percent }}% Complete</div>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $percent }}%"></div>
    </div>
    <div class="flex justify-between">
        @foreach($steps as $i => $label)
            <div class="flex flex-col items-center flex-1">
                <div class="@if($i < $currentStep) bg-green-500 @elseif($i == $currentStep) bg-blue-600 @else bg-gray-300 @endif rounded-full w-8 h-8 flex items-center justify-center text-white font-bold text-lg">
                    @if($i < $currentStep)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    @else
                        {{ $i }}
                    @endif
                </div>
                <div class="mt-2 text-xs text-center @if($i == $currentStep) font-bold text-blue-700 @elseif($i < $currentStep) text-green-700 @else text-gray-400 @endif">
                    {{ $label }}
                </div>
            </div>
            @if($i < $totalSteps)
                <div class="flex-1 h-1 bg-gray-300 mx-1 mt-4"></div>
            @endif
        @endforeach
    </div>
</div>

<div class="max-w-2xl mx-auto bg-white shadow rounded-xl p-8 mb-8">
    <h2 class="text-xl font-bold mb-1 flex items-center gap-2">
        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-purple-100 text-purple-600 mr-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 8c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/></svg>
        </span>
        Billing & Tax Preferences
    </h2>
    <p class="text-gray-500 mb-6">Set up billing for seamless transactions with Indonesian talent</p>
    <form method="POST" action="{{ route('company.onboarding.step.post', ['step' => 3]) }}">
        @csrf
        <div class="mb-5">
            <label class="block font-semibold mb-1">Invoice Recipient <span class="text-red-500">*</span></label>
            <input type="text" name="invoice_recipient" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200" value="{{ old('invoice_recipient', $company->invoice_recipient) }}" required placeholder="Company or person name">
        </div>
        <div class="mb-5">
            <label class="block font-semibold mb-1">Billing Email <span class="text-red-500">*</span></label>
            <input type="email" name="billing_email" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200" value="{{ old('billing_email', $company->billing_email) }}" required placeholder="billing@company.com">
        </div>
        <div class="mb-5">
            <label class="block font-semibold mb-1">Billing Address <span class="text-red-500">*</span></label>
            <input type="text" name="billing_address" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200" value="{{ old('billing_address', $company->billing_address) }}" required placeholder="Enter your billing address">
        </div>
        <div class="flex gap-4 mb-5">
            <div class="flex-1">
                <label class="block font-semibold mb-1">ZIP/Postal Code <span class="text-red-500">*</span></label>
                <input type="text" name="zip_code" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200" value="{{ old('zip_code', $company->zip_code) }}" required placeholder="12345">
            </div>
            <div class="flex-1">
                <label class="block font-semibold mb-1">Country <span class="text-red-500">*</span></label>
                <input type="text" name="country" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200" value="{{ old('country', $company->country) }}" required placeholder="Select country">
            </div>
        </div>
        <div class="mb-5">
            <label class="block font-semibold mb-1">Tax ID / VAT Number (Optional)</label>
            <input type="text" name="tax_id" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200" value="{{ old('tax_id', $company->tax_id) }}" placeholder="e.g., VAT123456789">
            <span class="text-xs text-gray-400">Required for proper invoicing and tax compliance</span>
        </div>
        <div class="flex gap-4 mb-5">
            <div class="flex-1">
                <label class="block font-semibold mb-1">Payment Schedule <span class="text-red-500">*</span></label>
                <input type="date" name="payment_schedule" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200" value="{{ old('payment_schedule', $company->payment_schedule) }}" required>
            </div>
            <div class="flex-1">
                <label class="block font-semibold mb-1">Currency <span class="text-red-500">*</span></label>
                <select name="currency" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200" required>
                    <option value="">Select currency</option>
                    @foreach(\App\Models\Company::currencyOptions() as $value => $label)
                        <option value="{{ $value }}" {{ old('currency', $company->currency) == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="bg-purple-50 border-l-4 border-purple-400 p-4 rounded mb-6">
            <div class="font-semibold text-purple-700 mb-1">Secure Payment Processing</div>
            <ul class="text-xs text-purple-700 list-disc pl-5">
                <li>Bank-level encryption for all transactions</li>
                <li>Automated invoicing and tax calculations</li>
                <li>Multi-currency support with real-time rates</li>
                <li>Transparent fee structure</li>
            </ul>
        </div>
        <button type="submit" class="w-full py-3 bg-black text-white font-semibold rounded-lg hover:bg-gray-900 transition">Continue to Preferences</button>
    </form>
    <div class="flex justify-between mt-4">
        <a href="{{ route('company.onboarding.step', ['step' => $step - 1]) }}" class="px-4 py-2 rounded bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-300">&larr; Previous</a>
        <a href="{{ route('company.onboarding.step', ['step' => $step + 1]) }}" class="px-4 py-2 rounded bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-300">Skip for now &rarr;</a>
    </div>
</div>
@endsection
