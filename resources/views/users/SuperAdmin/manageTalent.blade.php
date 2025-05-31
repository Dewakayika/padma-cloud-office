@extends('layouts.app')
@section('title', 'Dashboard')
@section('meta_description', 'Padma Cloud Office')

@section('content')

<div class="p-2 sm:p-4 md:p-6 lg:p-8 sm:ml-64 dark:bg-gray-900 min-h-screen">
    <div class="p-2 md:p-4">

        <x-breadscrums />

        {{-- Company Data Table --}}
        <div class="mt-4 sm:mt-6 md:mt-6">
            <x-talent-table :talents="$talents" :sortBy="$sortBy" :sortOrder="$sortOrder" />
        </div>

        {{-- Footer --}}
        <footer class="mt-4 sm:mt-6 md:mt-8 text-center text-gray-500 dark:text-gray-400 text-xs sm:text-sm">
            © 2025, made with ❤️ by Padma Creative Studio
        </footer>
    </div>
</div>

@endsection
