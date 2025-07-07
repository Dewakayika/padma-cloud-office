@extends('layouts.guest')
@section('title', 'Login')
@section('meta_description', 'Ini adalah halaman login.')

@section('content')
    <div class="min-h-screen flex bg-white">
        <!-- Left Side - Hidden on mobile, visible on desktop -->
        <div class="hidden lg:flex lg:w-1/3 bg-gray-50 p-8 lg:p-12 flex-col">
            <div class="mb-8 lg:mb-12">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to home
                </a>
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Welcome Back!</h2>
                <p class="text-sm text-gray-600">Log in to manage your company, post jobs, and connect with creators.</p>
            </div>
            <div class="mt-auto pt-8">
                <p class="text-gray-600">
                    Don't have an account?
                    <a href="{{ route('company.register') }}" class="text-blue-600 hover:text-red-700 font-medium">Register</a>
                </p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="flex-1 flex items-center justify-center px-4 py-8 sm:px-6 sm:py-12 lg:p-12 bg-gray-50 lg:bg-gray-100">
            <div class="w-full max-w-sm sm:max-w-md">
                <!-- Mobile Header -->
                <div class="lg:hidden mb-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800 mb-6">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to home
                    </a>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-3">Welcome Back!</h2>
                    <p class="text-gray-600 leading-relaxed">Log in to manage your company, post jobs, and connect with creators.</p>
                </div>

                <div class="text-center mb-8 lg:mb-10">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Padma Cloud Office</h1>
                    <p class="text-gray-600 mt-1">Sign in to your account</p>
                </div>

                <x-validation-errors class="mb-6" />
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm text-green-700">{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input id="email" 
                               class="block w-full px-4 py-4 rounded-xl border border-gray-300 text-gray-900 placeholder-gray-500
                                      focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition-all duration-200
                                      text-base" 
                               type="email" 
                               name="email"
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               placeholder="Enter your email address" />
                    </div>

                    <div>
                        <x-password-field ref="passwordField"
                            passwordName="password"
                            withConfirmation="false"
                            label="Password"
                            confirmationLabel="Confirm Password"
                            required="true" 
                            passwordPlaceholder="Enter your secure password"
                            />
                    </div>

                    <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="remember" 
                                   class="w-4 h-4 rounded border-gray-300 text-black focus:ring-black">
                            <span class="ml-3 text-sm text-gray-700">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200" 
                               href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full py-4 px-6 bg-black text-white font-semibold rounded-xl hover:bg-gray-800
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black 
                                       transition-all duration-200 text-base">
                            Sign In
                        </button>
                    </div>
                </form>

                <!-- Mobile Footer -->
                <div class="lg:hidden mt-10 pt-8 border-t border-gray-200 text-center">
                    <p class="text-gray-600">
                        Don't have an account?
                        <a href="{{ route('company.register') }}" class="text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-200">Create account</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
