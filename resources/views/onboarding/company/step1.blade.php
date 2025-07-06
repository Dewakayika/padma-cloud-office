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
    $currentStep = $step ?? 1;
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
        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-blue-100 text-blue-600 mr-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
        </span>
        Legal & Verification
    </h2>
    <p class="text-gray-500 mb-6">Verify your company to unlock faster payments and build trust with Indonesian talent</p>
    <form method="POST" action="{{ route('company.onboarding.step.post', ['step' => 1]) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-5">
            <label class="block font-semibold mb-1">Formal Company Name</label>
            <input type="text" name="company_name" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-200" value="{{ old('company_name', $company->company_name) }}" required placeholder="Enter the formal company name as per business license">
            <span class="text-xs text-gray-400">This should match exactly with your business license</span>
        </div>
        <div class="mb-5">
            <label class="block font-semibold mb-1">Company Registration Number</label>
            <input type="text" name="registration_number" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-200" value="{{ old('registration_number', $company->registration_number) }}" required placeholder="e.g., 123456789">
            <span class="text-xs text-gray-400">This helps us verify your company's legal status</span>
        </div>
        <div class="mb-5">
            <label class="block font-semibold mb-1">Company Address</label>
            <textarea name="address" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-200" required placeholder="Enter your company's registered address">{{ old('address', $company->address) }}</textarea>
        </div>
        <div class="mb-5">
            <label class="block font-semibold mb-1">Business License (Optional)</label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center bg-gray-50">
                <input type="file" name="business_license" class="sr-only" id="business_license">
                <label for="business_license" class="cursor-pointer flex flex-col items-center">
                    <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    <span class="text-gray-500">Click to upload business license</span>
                    <span class="text-xs text-gray-400">PDF, JPG, PNG up to 10MB</span>
                </label>
                @if($company->business_license_path)
                    <p class="text-xs mt-2">Current: <a href="{{ asset('storage/' . $company->business_license_path) }}" target="_blank" class="text-blue-600 underline">View License</a></p>
                @endif
            </div>
        </div>
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded mb-6">
            <div class="font-semibold text-blue-700 mb-1">Why verify your company?</div>
            <ul class="text-xs text-blue-700 list-disc pl-5">
                <li>Faster payment processing</li>
                <li>Higher trust score with Indonesian talent</li>
                <li>Access to premium collaboration features</li>
                <li>Priority support</li>
            </ul>
        </div>
        <button type="submit" class="w-full py-3 bg-black text-white font-semibold rounded-lg hover:bg-gray-900 transition">Continue to Team Setup</button>
    </form>
    <div class="flex justify-between mt-4">
        <span></span>
        <a href="{{ route('company.onboarding.step', ['step' => $step + 1]) }}" class="px-4 py-2 rounded bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-300">Skip for now &rarr;</a>
    </div>
</div>
@endsection
