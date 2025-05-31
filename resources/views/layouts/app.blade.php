<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100 dark:bg-gray-900">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Padma Cloud Office')</title>
        <meta name="description" content="@yield('meta_description', 'Padma Cloud Office - Project Management System')">

        {{-- Favicon --}}
        {{-- <link rel="icon" type="image/png" href="{{ asset('images/logo/favicon.png') }}" sizes="16x16"> --}}

        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>


    <body class="h-full font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            {{-- Loading State --}}
            <div wire:loading class="fixed inset-0 z-50 bg-white bg-opacity-75 flex items-center justify-center dark:bg-gray-900 dark:bg-opacity-75">
                <svg class="animate-spin h-10 w-10 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            </div>


            <x-banner />

            @if (Auth::check())
                {{-- Sidebar --}}
                <x-side-bar/>
                
                {{-- Navbar --}}
                <x-navbar />

                {{-- Main Content --}}
                <div class="">
                    <main class="py-16 sm:px-6">
                        @yield('content')
                    </main>
                </div>
            @else
                <x-navbar />
                <main>
                    @yield('content')
                </main>
            @endif
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>
