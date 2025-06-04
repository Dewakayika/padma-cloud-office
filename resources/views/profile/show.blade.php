
@extends('layouts.app')
@section('title', 'Profile')
@section('meta_description', 'Ini adalah halaman dashboard untuk pengguna terdaftar.')


@section('content')
<div class="sm:p-4 sm:ml-64 dark:bg-gray-900 min-h-screen">
    <div class="py-4 md:p-4">
    <div>
        <div class="max-w-7xl lg:ml-64 sm:mx-3 mx-auto py-10 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords())) 
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
    </div>
</div>
@endsection
