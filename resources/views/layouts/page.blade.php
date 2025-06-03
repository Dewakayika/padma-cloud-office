<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100 dark:bg-gray-900">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Padma Cloud Office')</title>
        <meta name="description" content="@yield('meta_description', 'Padma Cloud Office - Project Management System')">

        {{-- Favicon --}}
        <link rel="icon" type="image/png" href="{{ asset('images/logo/favicon.png') }}" sizes="16x16">

        {{-- font awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        @stack('styles')
    </head>

    <body class="h-full font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

            <x-banner />

            @if (Auth::check())
                {{-- Navbar --}}
                <x-nav-page />

                {{-- Main Content --}}
                <div class="">
                    <main class="py-16 sm:px-6">
                        @yield('content')
                    </main>
                </div>
                <x-footer-page/>
            @else
                <x-nav-page />
                <main>
                    @yield('content')
                </main>
                <x-footer-page />
            @endif
        </div>

        @stack('modals')
        @livewireScripts
        @stack('scripts')
    </body>
</html>
"
