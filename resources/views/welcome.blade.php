<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Padma Cloud Office</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Alpine.js -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="bg-white dark:bg-gray-900" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <!-- Navbar -->
        <header class="fixed w-full z-50 transition-all duration-300 pt-5" :class="{ 'bg-transparent': !scrolled }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 rounded-2xl bg-white/95 backdrop-blur-md shadow-xl dark:bg-gray-900/95">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="/" class="text-xl font-semibold text-gray-900 dark:text-white transition-colors duration-300">
                            Padma Cloud Office
                        </a>
                    </div>

                    <div class="flex-shrink-0 flex gap-10">
                        <a href="#features" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-sm font-medium transition-colors duration-300">Features</a>
                        <a href="#benefits" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-sm font-medium transition-colors duration-300">Benefits</a>
                    </div>

                    <!-- Navigation -->
                    @if (Route::has('login'))
                        <nav class="hidden md:flex items-center space-x-8">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-sm font-medium transition-colors duration-300">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-sm font-medium transition-colors duration-300">Sign in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                                        Start for free
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </div>
        </header>

        <main>
            <!-- Hero Section -->
            <div class="relative min-h-screen bg-white dark:bg-gray-900 flex items-center justify-center pb-72">
                <div class="w-full px-4 sm:px-6 lg:px-8">
                    <div class="max-w-4xl mx-auto text-center">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                            <span class="block">Streamline Your Office</span>
                            <span class="block text-red-600">Management System</span>
                        </h1>
                        <p class="mt-6 text-xl text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                            Manage your office operations, track resources, and enhance employee experience—all in one place.
                        </p>
                        <div class="mt-10 flex justify-center gap-4">
                            @if (Route::has('register'))
                                <div>
                                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-black hover:bg-gray-700 md:py-4 md:text-lg md:px-10 transition-all duration-300">
                                        Get started
                                    </a>
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 dark:border-gray-700 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 md:py-4 md:text-lg md:px-10 transition-all duration-300">
                                    Sign in
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Images -->
            <div class="absolute left-0 right-0 -bottom-0 sm:-bottom-80 flex items-end justify-center">
                <div class="w-full px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto text-center max-w-7xl border-8 border-gray-300 dark:border-white rounded-2xl shadow-2xl">
                        <img 
                            src="{{ asset('images/hero-section.png') }}" 
                            alt="Dashboard preview"
                            class="w-full h-auto object-cover rounded-2xl"
                        >
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="py-24 bg-gray-50 dark:bg-gray-800" id="features">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 lg:mt-80">
                    <div class="text-center">
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                            Key Benefits
                        </h2>
                        <p class="mt-4 text-xl text-gray-500 dark:text-gray-400">
                            Everything you need to manage your office efficiently
                        </p>
                    </div>

                    <div class="mt-20 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Feature 1 -->
                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-lg rounded-xl p-6 hover:shadow-xl transition-shadow duration-300">
                            <div class="relative">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Resource Management</h3>
                                <p class="mt-4 text-base text-gray-500 dark:text-gray-400">
                                    Efficiently manage and track all your office resources in one place.
                                </p>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-lg rounded-xl p-6 hover:shadow-xl transition-shadow duration-300">
                            <div class="relative">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Employee Management</h3>
                                <p class="mt-4 text-base text-gray-500 dark:text-gray-400">
                                    Handle employee records, attendance, and performance tracking seamlessly.
                                </p>
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-lg rounded-xl p-6 hover:shadow-xl transition-shadow duration-300">
                            <div class="relative">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Task Automation</h3>
                                <p class="mt-4 text-base text-gray-500 dark:text-gray-400">
                                    Automate routine tasks and improve office productivity.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
