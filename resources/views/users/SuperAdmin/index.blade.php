@extends('layouts.app')
@section('title', 'Dashboard')
@section('meta_description', 'Padma Cloud Office')

@section('content')

<div class="p-2 sm:p-4 md:p-6 lg:p-8 sm:ml-64 dark:bg-gray-900 min-h-screen">
    <div class="p-2 md:p-4">
        {{-- Welcome Message --}}
        <div class="mb-4 sm:mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">
                Good to see you, <span class="font-bold">{{$user->name}}</span>
            </h1>
        </div>

        {{-- Score Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-4 sm:mb-6">
            <x-score-card
                icon="far fa-clock"
                iconBackground="bg-green-100 dark:bg-green-800"
                iconColor="text-green-500 dark:text-green-200"
                value="{{ $totalCompany }}"
                title="Total Company Registered"/>

            <x-score-card
                icon="fas fa-users"
                iconBackground="bg-blue-100 dark:bg-blue-800"
                iconColor="text-blue-500 dark:text-blue-200"
                value="{{ $totalUser }}"
                title="Total Talent Registered"/>

            <x-score-card
                icon="fas fa-file-alt"
                iconBackground="bg-orange-100 dark:bg-orange-800"
                iconColor="text-orange-500 dark:text-orange-200"
                value="{{ $totalProject }}"
                title="Total Project Managed"/>

            <x-score-card
                icon="fas fa-list-alt"
                iconBackground="bg-purple-100 dark:bg-purple-800"
                iconColor="text-purple-500 dark:text-purple-200"
                value="{{ $companyByCountry }}"
                title="Total Country Registred"/>
        </div>

        {{-- Company Data Table --}}
        <div class="mt-4 sm:mt-6 md:mt-8">
            <x-company-table :companies="$company" :sortBy="$sortBy" :sortOrder="$sortOrder" />
        </div>

        {{-- Footer --}}
        <footer class="mt-4 sm:mt-6 md:mt-8 text-center text-gray-500 dark:text-gray-400 text-xs sm:text-sm">
            © 2025, made with ❤️ by Padma Creative Studio
        </footer>
    </div>
</div>

@endsection
