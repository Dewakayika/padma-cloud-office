@extends('layouts.app')
@section('title', 'Dashboard')
@section('meta_description', 'Padma Cloud Office')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Users Overview</h1>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($users as $user)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="flex-shrink-0">
                        <img class="h-12 w-12 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>
                    </div>
                </div>

                @if($user->companyTalent->isNotEmpty())
                    <div class="mt-4">
                        <h3 class="text-lg font-medium text-gray-900">Talent Assignments Created</h3>
                        <div class="mt-2 space-y-2">
                            @foreach($user->companyTalent as $assignment)
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="font-medium">Job Role: {{ $assignment->job_role }}</p>
                                    <p class="text-sm text-gray-600">Assigned Talent: {{ $assignment->talent->name }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($user->assignedTalents->isNotEmpty())
                    <div class="mt-4">
                        <h3 class="text-lg font-medium text-gray-900">Assigned As Talent</h3>
                        <div class="mt-2 space-y-2">
                            @foreach($user->assignedTalents as $assignment)
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="font-medium">Job Role: {{ $assignment->job_role }}</p>
                                    <p class="text-sm text-gray-600">Assigned By: {{ $assignment->user->name }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('company.user.detail', $user->id . '-' . Str::slug($user->name)) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        View Details
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
