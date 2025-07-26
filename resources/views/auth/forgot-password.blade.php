@extends('layouts.guest')
@section('title', 'Forgot Password')
@section('meta_description', 'Reset your password')

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
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Forgot Your Password?</h2>
                <p class="text-sm text-gray-600">No worries! Enter your email address and we'll send you a password reset link to get you back on track.</p>
            </div>
            <div class="mt-auto pt-8">
                <p class="text-gray-600">
                    Remember your password?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium">Sign in</a>
                </p>
            </div>
        </div>

        <!-- Right Side: Forgot Password Form -->
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
                    <h2 class="text-2xl font-semibold text-gray-900 mb-3">Forgot Your Password?</h2>
                    <p class="text-gray-600 leading-relaxed">No worries! Enter your email address and we'll send you a password reset link.</p>
                </div>

                <div class="text-center mb-8 lg:mb-10">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Padma Cloud Office</h1>
                    <p class="text-gray-600 mt-1">Reset your password</p>
                </div>

                <x-validation-errors class="mb-6" />

                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm text-green-700">{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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

                    <div class="pt-2">
                        <button type="submit"
                                class="w-full py-4 px-6 bg-black text-white font-semibold rounded-xl hover:bg-gray-800
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black
                                       transition-all duration-200 text-base">
                            Send Password Reset Link
                        </button>
                    </div>
                </form>

                <!-- Mobile Footer -->
                <div class="lg:hidden mt-10 pt-8 border-t border-gray-200 text-center">
                    <p class="text-gray-600">
                        Remember your password?
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-200">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
