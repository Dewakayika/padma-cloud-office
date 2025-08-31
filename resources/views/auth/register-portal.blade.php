@extends('layouts.guest')
@section('title', 'Register Portal')
@section('meta_description', 'Ini adalah halaman register portal.')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-6">
        <div class="w-full max-w-4xl bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="text-center p-8 bg-white">
                <h1 class="text-3xl font-bold text-gray-900">Welcome to Padma Cloud Office</h1>
                <p class="text-gray-600 text-md pb-10">Join Padma Cloud Office and collaborate virtually with your team.</p>

                <div class="grid md:grid-cols-2 gap-8 p-8 pb-10">
                <!-- Company Registration Card -->
                <a href="{{ route('company.register') }}" class="block group">
                    <div class="p-6 bg-white border border-gray-200 rounded-lg transition-all duration-200 hover:border-black hover:shadow-lg">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-gray-100 rounded-lg group-hover:bg-gray-200">
                                <svg class="w-6 h-6 text-gray-600 group-hover:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <h2 class="text-xl font-semibold text-gray-800 group-hover:text-black">Company</h2>
                                <p class="mt-2 text-gray-600">Create a company account</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Talent Registration Card -->
                <a href="{{ route('talent.register') }}" class="block group">
                    <div class="p-6 bg-white border border-gray-200 rounded-lg transition-all duration-200 hover:border-black hover:shadow-lg">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-gray-100 rounded-lg group-hover:bg-gray-200">
                                <svg class="w-6 h-6 text-gray-600 group-hover:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <h2 class="text-xl font-semibold text-gray-800 group-hover:text-black">Talent</h2>
                                <p class="mt-2 text-gray-600">Create a talent account</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="text-center pb-8">
                <p class="text-gray-600">
                    Already have an account?
                    <a href="/login" class="text-blue-500 hover:text-blue-600 font-semibold">Sign in</a>
                </p>
            </div>
        </div>
    </div>
@endsection
