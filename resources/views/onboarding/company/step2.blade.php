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
    $currentStep = $step ?? 2;
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
        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100 text-green-600 mr-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87m9-7V7a4 4 0 0 0-8 0v2m12 0v6a9 9 0 1 1-18 0V9m18 0a9 9 0 1 1-18 0"/></svg>
        </span>
        Team Setup
    </h2>
    <p class="text-gray-500 mb-6">Add your team so you can assign projects smoothly and collaborate effectively.</p>
    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded mb-6">
        <div class="font-semibold text-green-700 mb-1">Team Benefits</div>
        <ul class="text-xs text-green-700 list-disc pl-5">
            <li>Streamlined project assignments</li>
            <li>Role-based access control</li>
            <li>Collaborative review workflows</li>
            <li>Team activity tracking</li>
        </ul>
    </div>
    <form method="POST" action="{{ route('company.onboarding.step.post', ['step' => 2]) }}">
        @csrf
        <button type="submit" class="w-full py-3 bg-black text-white font-semibold rounded-lg hover:bg-gray-900 transition">Continue to Billing & Tax</button>
    </form>
    <div class="flex justify-between mt-4">
        <a href="{{ route('company.onboarding.step', ['step' => $step - 1]) }}" class="px-4 py-2 rounded bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-300">&larr; Previous</a>
        <a href="{{ route('company.onboarding.step', ['step' => $step + 1]) }}" class="px-4 py-2 rounded bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-300">Skip for now &rarr;</a>
    </div>
</div>
@endsection
