@extends('layouts.guest')
@section('title', 'Start Onboarding')
@section('meta_description', 'Ini adalah halaman start onboarding.')

@section('content')
<div class="w-full min-h-screen bg-gray-50 py-10 px-2 md:px-8">
    <div class="max-w-7xl mx-auto px-5 md:px-0">
        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="mt-10 text-xl md:text-3xl font-extrabold text-gray-900 flex items-center gap-2">
                Welcome to Padma Cloud Office, <span class="text-red-600">John Doe!</span> <span>🎉</span>
            </h1>
            <p class="mt-2 text-gray-600 text-base md:text-lg">
                Your virtual collaboration hub is ready. Let's complete your company setup to unlock all features.
            </p>
        </div>
        <!-- Main Content -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left: Company Setup Card -->
            <section class="flex-1 bg-white rounded-2xl shadow-sm p-8 border border-blue-100">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-semibold text-blue-900">Complete Your Company Setup</h2>
                    <span class="text-xs font-medium text-gray-400">0% Complete</span>
                </div>
                <div class="w-full bg-blue-100 rounded-full h-2 mb-3">
                    <div class="bg-blue-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <p class="text-xs text-blue-600 mb-6 font-medium">0 of 4 steps completed</p>
                <div class="space-y-3">
                    <!-- Step 1 -->
                    <div class="flex items-center bg-blue-50 hover:bg-blue-100 transition rounded-xl px-5 py-4">
                        <div class="mr-4">
                            <!-- Shield SVG -->
                            <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 5.25-3.5 9.75-7 11-3.5-1.25-7-5.75-7-11V7l7-4z"/></svg>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">Legal & Verification</div>
                            <div class="text-sm text-gray-500">Verify your company to unlock faster payments</div>
                        </div>
                        <div class="ml-4 text-gray-300">
                            <!-- Clock SVG -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <!-- <div class="flex items-center bg-blue-50 hover:bg-blue-100 transition rounded-xl px-5 py-4">
                        <div class="mr-4">
                     
                            <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 6a4 4 0 00-3-3.87"/></svg>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">Team Setup</div>
                            <div class="text-sm text-gray-500">Add your team so you can assign projects smoothly</div>
                        </div>
                        <div class="ml-4 text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                        </div>
                    </div> -->
                    <!-- Step 3 -->
                    <div class="flex items-center bg-blue-50 hover:bg-blue-100 transition rounded-xl px-5 py-4">
                        <div class="mr-4">
                            <!-- Credit Card SVG -->
                            <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="14" x="2" y="5" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M2 10h20"/></svg>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">Billing & Tax</div>
                            <div class="text-sm text-gray-500">Set up billing for seamless transactions</div>
                        </div>
                        <div class="ml-4 text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                        </div>
                    </div>
                    <!-- Step 4 -->
                    <div class="flex items-center bg-blue-50 hover:bg-blue-100 transition rounded-xl px-5 py-4">
                        <div class="mr-4">
                            <!-- Settings SVG -->
                            <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 3.25c.38-1.13 1.87-1.13 2.25 0a1.5 1.5 0 002.12.88c1.04-.6 2.23.59 1.63 1.63a1.5 1.5 0 00.88 2.12c1.13.38 1.13 1.87 0 2.25a1.5 1.5 0 00-.88 2.12c.6 1.04-.59 2.23-1.63 1.63a1.5 1.5 0 00-2.12.88c-.38 1.13-1.87 1.13-2.25 0a1.5 1.5 0 00-2.12-.88c-1.04.6-2.23-.59-1.63-1.63a1.5 1.5 0 00-.88-2.12c-1.13-.38-1.13-1.87 0-2.25a1.5 1.5 0 00.88-2.12c-.6-1.04.59-2.23 1.63-1.63a1.5 1.5 0 002.12-.88z"/></svg>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">Collaboration Preferences</div>
                            <div class="text-sm text-gray-500">Configure your workflow and tools</div>
                        </div>
                        <div class="ml-4 text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                        </div>
                    </div>
                </div>
                <button onclick="window.location.href='{{ route('company.onboarding.step', 1) }}'" class="mt-8 w-full bg-black hover:bg-red-600 text-white font-semibold py-3 rounded-xl shadow-sm transition text-base">Start Setup Process <span class="ml-2">→</span></button>
            </section>
            <!-- Right: Sidebar Cards -->
            <aside class="flex flex-col gap-8 w-full lg:w-1/3">
                <!-- Workspace Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-6">
                    <div class="flex items-center mb-3">
                        <svg class="w-6 h-6 text-blue-700 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
                        <h3 class="font-semibold text-base">Your Workspace</h3>
                    </div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-500">Status</span>
                        <span class="bg-gray-100 text-xs px-2 py-0.5 rounded-full font-semibold">Temporary</span>
                    </div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-500">Storage</span>
                        <span class="font-semibold text-gray-900 pr-2">1GB Free</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Complete team setup to activate full workspace features</p>
                </div>
                <!-- Company Info Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-6">
                    <div class="flex items-center mb-3">
                        <svg class="w-6 h-6 text-blue-700 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21V7a2 2 0 012-2h14a2 2 0 012 2v14"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 3v4M8 3v4"/></svg>
                        <h3 class="font-semibold text-base">Company Info</h3>
                    </div>
                    <div class="text-sm text-gray-700 space-y-1">
                        <div><span class="font-medium">Company:</span> <span class="text-gray-400">-</span></div>
                        <div><span class="font-medium">Type:</span> <span class="text-gray-400">-</span></div>
                        <div><span class="font-medium">Country:</span> <span class="text-gray-400">-</span></div>
                    </div>
                </div>
                <!-- Quick Actions Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-6">
                    <h3 class="font-semibold text-base mb-3">Quick Actions</h3>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg px-3 py-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v6M6 9v6M9 6h6M9 18h6"/></svg>
                                <span class="text-gray-700 text-sm">Invite Team Members</span>
                            </div>
                            <span class="bg-gray-100 text-xs px-2 py-0.5 rounded-full font-semibold">Soon</span>
                        </div>
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg px-3 py-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
                                <span class="text-gray-700 text-sm">Create Project</span>
                            </div>
                            <span class="bg-gray-100 text-xs px-2 py-0.5 rounded-full font-semibold">Soon</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
