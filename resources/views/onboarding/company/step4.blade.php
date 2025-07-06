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
    $currentStep = $step ?? 4;
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
        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-orange-100 text-orange-600 mr-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 8c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/></svg>
        </span>
        Collaboration Preferences
    </h2>
    <p class="text-gray-500 mb-6">Configure your workflow and tools to match with Indonesian talent</p>
    <form method="POST" action="{{ route('company.onboarding.step.post', ['step' => 4]) }}">
        @csrf
        <div class="mb-5">
            <label class="block font-semibold mb-1">Primary Use Case</label>
            <input type="text" name="primary_use_case" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-200" value="{{ old('primary_use_case', $company->primary_use_case) }}" required placeholder="Select your primary use case">
        </div>
        <div class="mb-5">
            <label class="block font-semibold mb-1">Preferred Tools & Software</label>
            <div class="flex flex-wrap gap-2">
                @php
                    $tools = ['Clip Studio Paint (CSP)', 'Adobe Photoshop (PSD)', 'Adobe After Effects', 'Blender', 'Maya', 'Google Drive', 'Dropbox', 'Figma', 'Asana', 'Slack'];
                    $selected = old('collaboration_tools', json_decode($company->collaboration_tools ?? '[]', true));
                @endphp
                @foreach($tools as $tool)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="collaboration_tools[]" value="{{ $tool }}" @if(in_array($tool, $selected)) checked @endif class="rounded border-gray-300">
                        <span class="ml-2">{{ $tool }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded mb-6">
            <div class="font-semibold text-blue-700 mb-1">NDA Agreement</div>
            <p class="text-xs text-blue-700 mb-2">To ensure confidentiality when working with Indonesian talent, please review and sign our standard NDA. This agreement will apply to your studio and all talent who join your projects.</p>
            <button type="button" class="text-blue-600 underline text-xs font-medium mb-2">Review NDA Document</button>
            <label class="inline-flex items-center mt-2">
                <input type="checkbox" name="nda_agreed" value="1" @if(old('nda_agreed', $company->nda_agreed)) checked @endif required class="rounded border-gray-300">
                <span class="ml-2 text-xs">I agree to the NDA terms for my studio and all talent who will join our projects</span>
            </label>
        </div>
        <div class="bg-orange-50 border-l-4 border-orange-400 p-4 rounded mb-6">
            <div class="font-semibold text-orange-700 mb-1">What happens next?</div>
            <ul class="text-xs text-orange-700 list-disc pl-5">
                <li>Your workspace will be fully activated</li>
                <li>We'll match you with suitable Indonesian talent</li>
                <li>You can start creating and assigning projects</li>
                <li>Access to premium collaboration features</li>
            </ul>
        </div>
        <button type="submit" class="w-full py-3 bg-black text-white font-semibold rounded-lg hover:bg-gray-900 transition">Complete Setup</button>
    </form>
    <div class="flex justify-between mt-4">
        <a href="{{ route('company.onboarding.step', ['step' => $step - 1]) }}" class="px-4 py-2 rounded bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-300">&larr; Previous</a>
        <span></span>
    </div>
</div>
@endsection
