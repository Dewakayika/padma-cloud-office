@extends('layouts.guest')
@section('title', 'Login')
@section('meta_description', 'Ini adalah halaman login.')

@section('content')
    <div class="min-h-screen flex bg-white">
        <!-- Left Side -->
        <div class="w-1/3 bg-gray-50 p-12 flex flex-col">
            <div class="mb-12">
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
                    Don’t have an account?
                    <a href="{{ route('company.register') }}" class="text-blue-600 hover:text-red-700 font-medium">Register</a>
                </p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="flex-1 flex items-center justify-center p-12 bg-gray-100">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-semibold text-gray-900">Padma Cloud Office Login</h1>
                </div>

                <x-validation-errors class="mb-4" />
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input id="email" class="block w-full mt-1 px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                            focus:outline-none focus:ring-1 focus:ring-black focus:border-black" type="email" name="email"
                            value="{{ old('email') }}" required autofocus />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" class="block w-full mt-1 px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                            focus:outline-none focus:ring-1 focus:ring-black focus:border-black" type="password" name="password" required />
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-blue-600 hover:text-red-700 font-medium" href="{{ route('password.request') }}">
                                Forgot your password?
                            </a>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="w-full py-3.5 px-4 bg-gray-800 text-white font-medium rounded-lg hover:bg-black
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition">
                            Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
