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
    <body class="bg-white dark:bg-gray-900" x-data="{ scrolled: false, mobileMenuOpen: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <!-- Navbar -->
        <header class="fixed w-full z-50 transition-all duration-300 pt-5" :class="{ 'bg-transparent': !scrolled }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-2xl bg-white/95 backdrop-blur-md shadow-xl dark:bg-gray-900/95">
                    <div class="flex justify-between items-center h-16 lg:h-20 px-4 lg:px-6">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <a href="/" class="text-lg lg:text-xl font-semibold text-gray-900 dark:text-white transition-colors duration-300">
                                Padma Cloud Office
                            </a>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden lg:flex items-center space-x-8">
                            <a href="#features" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-sm font-medium transition-colors duration-300">Features</a>
                            <a href="#benefits" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-sm font-medium transition-colors duration-300">Benefits</a>

                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-sm font-medium transition-colors duration-300">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-sm font-medium transition-colors duration-300">Sign in</a>
                                    @if (Route::has('signup'))
                                        <a href="{{ route('signup') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                                            Start for free
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </div>

                        <!-- Mobile menu button -->
                        <div class="lg:hidden">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Navigation -->
                    <div x-show="mobileMenuOpen" x-transition class="lg:hidden border-t border-gray-200 dark:border-gray-700">
                        <div class="px-4 py-4 space-y-3">
                            <a href="#features" class="block text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-sm font-medium transition-colors duration-300">Features</a>
                            <a href="#benefits" class="block text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-sm font-medium transition-colors duration-300">Benefits</a>

                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="block text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-sm font-medium transition-colors duration-300">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="block text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-sm font-medium transition-colors duration-300">Sign in</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="block mt-3 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                                            Start for free
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <!-- Hero Section -->
            <div class="relative min-h-screen bg-white dark:bg-gray-900 flex items-center justify-center pb-20 lg:pb-72 pt-20 lg:pt-10">
                <div class="w-full px-4 sm:px-6 lg:px-8">
                    <div class="max-w-4xl mx-auto text-center">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                            <span class="block">Streamline Your Office</span>
                            <span class="block text-red-600">Management System</span>
                        </h1>
                        <p class="mt-4 sm:mt-6 text-lg sm:text-xl text-gray-500 dark:text-gray-400 max-w-2xl mx-auto px-4">
                            Manage your office operations, track resources, and enhance employee experience—all in one place.
                        </p>
                        <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row justify-center gap-4 px-4">
                            @if (Route::has('register'))
                                <div>
                                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-black hover:bg-gray-700 lg:py-4 lg:text-lg lg:px-10 transition-all duration-300">
                                        Get started
                                    </a>
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-8 py-3 border border-gray-300 dark:border-gray-700 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 lg:py-4 lg:text-lg lg:px-10 transition-all duration-300">
                                    Sign in
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Image -->
            <div class="relative -mt-20 lg:-mt-80 pb-20 lg:pb-0">
                <div class="w-full px-4 sm:px-6 lg:px-8">

                    <div class="mx-auto text-center max-w-7xl">
                        <div class="border-4 lg:border-8 border-gray-300 dark:border-white rounded-xl lg:rounded-2xl shadow-2xl overflow-hidden">
                            <img
                                src="{{ asset('images/hero-section.png') }}"
                                alt="Dashboard preview"
                                class="w-full h-auto object-cover"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="py-16 lg:py-24 bg-gray-50 dark:bg-gray-800" id="features">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-white">
                            Key Benefits
                        </h2>
                        <p class="mt-4 text-lg sm:text-xl text-gray-500 dark:text-gray-400 max-w-3xl mx-auto">
                            Everything you need to manage your office efficiently
                        </p>
                    </div>

                    <div class="mt-12 lg:mt-20 grid grid-cols-1 gap-6 sm:gap-8 lg:grid-cols-3">
                        <!-- Feature 1 -->
                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-lg rounded-xl p-6 hover:shadow-xl transition-shadow duration-300">
                            <div class="relative">
                                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Resource Management</h3>
                                <p class="mt-4 text-base text-gray-500 dark:text-gray-400">
                                    Efficiently manage and track all your office resources in one place.
                                </p>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-lg rounded-xl p-6 hover:shadow-xl transition-shadow duration-300">
                            <div class="relative">
                                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Employee Management</h3>
                                <p class="mt-4 text-base text-gray-500 dark:text-gray-400">
                                    Handle employee records, attendance, and performance tracking seamlessly.
                                </p>
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-lg rounded-xl p-6 hover:shadow-xl transition-shadow duration-300">
                            <div class="relative">
                                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Task Automation</h3>
                                <p class="mt-4 text-base text-gray-500 dark:text-gray-400">
                                    Automate routine tasks and improve office productivity.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Workflow Section -->
            <section class="bg-white dark:bg-gray-900 py-16 lg:py-24 px-4 sm:px-6 lg:px-8" id="benefits">
                <div class="max-w-7xl mx-auto">
                    <!-- Heading -->
                    <div class="mb-12 lg:mb-20 text-center">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-white">Explore Our Workflows</h2>
                        <p class="mt-4 text-lg sm:text-xl text-gray-500 dark:text-gray-400 max-w-3xl mx-auto">
                            From multi-layer approvals to automated tracking, Padma Cloud Office adapts to your business needs with intuitive tools you already know.
                        </p>
                    </div>

                    <!-- Cards Wrapper -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                        <!-- Card 1 -->
                        <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <img src="{{ asset('images/hero-section.png') }}" alt="Workflow 1" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-3 text-white">Register Your Team</h3>
                                <p class="text-sm text-gray-300">
                                    Create your organization's workspace and invite your team in under 5 minutes.
                                </p>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <img src="{{ asset('images/hero-section.png') }}" alt="Workflow 2" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-3 text-white">Setup Roles & Access</h3>
                                <p class="text-sm text-gray-300">
                                    Assign roles, set permissions, and organize teams based on your workflow.
                                </p>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <img src="{{ asset('images/hero-section.png') }}" alt="Workflow 3" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-3 text-white">Manage Everything</h3>
                                <p class="text-sm text-gray-300">
                                    Track tasks, approvals, leave requests, and more – all in one place.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Testimonials Section -->
            <section class="py-16 lg:py-24 bg-gray-50 dark:bg-gray-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12 lg:mb-16">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-white">What Our Clients Say</h2>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10">
                        <div class="bg-white dark:bg-gray-900 p-6 lg:p-8 rounded-xl shadow-lg">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                                    <span class="text-red-600 dark:text-red-400 font-semibold">M</span>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Maya Putri</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">HR Manager</p>
                                </div>
                            </div>
                            <p class="text-lg text-gray-700 dark:text-gray-300">"Padma Cloud Office helped us cut our admin overhead by 50%. It's intuitive and powerful."</p>
                        </div>
                        <div class="bg-white dark:bg-gray-900 p-6 lg:p-8 rounded-xl shadow-lg">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 dark:text-blue-400 font-semibold">D</span>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Dwi Santosa</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Office Manager</p>
                                </div>
                            </div>
                            <p class="text-lg text-gray-700 dark:text-gray-300">"A one-stop solution for managing employees, tasks, and resources. Love the UI!"</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="py-16 lg:py-24 bg-gradient-to-r from-red-600 to-black text-white text-center">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-4">Ready to streamline your office?</h2>
                    <p class="text-lg sm:text-xl mb-8">Start your free trial today. No credit card required.</p>
                    <a href="{{ route('register') }}" class="inline-block bg-white text-black font-semibold px-6 py-3 rounded-md shadow-lg hover:bg-gray-200 transition duration-300">
                        Get Started Now
                    </a>
                </div>
            </section>

            <!-- Demo Section -->
            <section class="bg-white dark:bg-gray-900 py-16 lg:py-24">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">Try Padma Cloud Office Instantly</h2>
                        <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Experience how it works — no login required.</p>
                    </div>
                    <div class="relative">
                        <iframe src="/demo" class="w-full h-[400px] lg:h-[500px] rounded-xl shadow-lg border border-gray-300 dark:border-gray-600"></iframe>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-black dark:bg-gray-900 text-white py-8 lg:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row justify-between items-center">
                    <p class="text-center lg:text-left mb-4 lg:mb-0">&copy; {{ date('Y') }} Padma Cloud Office. All rights reserved.</p>
                    <div class="flex space-x-6 lg:space-x-8">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Privacy</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Terms</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Contact</a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
