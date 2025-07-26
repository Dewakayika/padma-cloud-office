@extends('layouts.guest')

@section('title', 'Company Invitation')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <div class="mx-auto h-12 w-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                    Company Invitation
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    You've been invited to join a company
                </p>
            </div>

            <div class="space-y-6">
                <!-- Company Information -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                        {{ $invitation->company->company_name }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Invited by: {{ $invitation->invitingUser->name }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Role: {{ ucfirst($invitation->role) }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Expires: {{ $invitation->expires_at->format('M d, Y H:i') }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    @if(Auth::check())
                        @if(Auth::user()->email === $invitation->email)
                            <a href="{{ route('invitations.accept', $invitation->token) }}"
                               class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Accept Invitation
                            </a>
                            <form action="{{ route('invitations.decline', $invitation->token) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                        class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Decline Invitation
                                </button>
                            </form>
                        @else
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                    This invitation is for {{ $invitation->email }}. Please log in with the correct account.
                                </p>
                            </div>
                        @endif
                    @else
                        <div class="space-y-3">
                            <a href="{{ route('login') }}"
                               class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Log In to Accept
                            </a>
                            <a href="{{ route('register') }}"
                               class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Create Account
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Additional Info -->
                <div class="text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        By accepting this invitation, you'll be added to the company's team and can collaborate on projects.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
