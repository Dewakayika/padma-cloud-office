@extends('layouts.app')
@section('title', 'Dashboard')
@section('meta_description', 'Padma Cloud Office')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">User Details</h1>
            <a href="{{ route('company.users') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Users
            </a>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center space-x-6 mb-6">
                <div class="flex-shrink-0">
                    <img class="h-24 w-24 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                </div>
                <div>
                    <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <p class="text-gray-600">Role: {{ ucfirst($user->role) }}</p>
                </div>
            </div>

            @if($companyTalent)
                <div class="mt-6">
                    <h3 class="text-xl font-semibold mb-4">Company Talent Information</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Job Role</p>
                                <p class="font-medium">{{ $companyTalent->job_role }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Assigned By</p>
                                <p class="font-medium">{{ $companyTalent->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Company</p>
                                <p class="font-medium">{{ $companyTalent->company->company_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Assigned Date</p>
                                <p class="font-medium">{{ $companyTalent->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($user->assignedTalents->isNotEmpty())
                <div class="mt-6">
                    <h3 class="text-xl font-semibold mb-4">Talent Assignments</h3>
                    <div class="space-y-4">
                        @foreach($user->assignedTalents as $assignment)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Job Role</p>
                                        <p class="font-medium">{{ $assignment->job_role }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Assigned By</p>
                                        <p class="font-medium">{{ $assignment->user->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Company</p>
                                        <p class="font-medium">{{ $assignment->company->company_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Assigned Date</p>
                                        <p class="font-medium">{{ $assignment->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
