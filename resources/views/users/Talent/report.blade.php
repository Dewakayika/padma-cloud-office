@extends('layouts.app')
@section('title', 'Talent Report')
@section('meta_description', 'Talent Report and Statistics')

@push('styles')
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endpush

@section('content')
<div class="sm:ml-64">
    <div class="py-4" x-data="{ activeTab: 'overview' }">
        {{-- Header Section with Date Selector --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Report</h1>
            <div class="flex items-center gap-4">
                {{-- Date Selector --}}
                <div class="relative">
                    <select class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 appearance-none pr-8">
                        <option selected>May 2025</option>
                        <option>June 2025</option>
                        <option>July 2025</option>
                    </select>
                </div>
                {{-- Export Button --}}
                <button type="button" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 dark:bg-purple-700 dark:hover:bg-purple-800">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Export Report
                </button>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="">
            <nav class="relative flex space-x-8 border-b border-gray-200 dark:border-gray-700" aria-label="Tabs">
                <button
                    @click="activeTab = 'overview'"
                    class="text-sm transition-colors duration-200 pb-4 relative"
                    :class="{ 'text-gray-900 dark:text-white font-medium after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-gray-900 dark:after:bg-white': activeTab === 'overview',
                             'text-gray-500 dark:text-gray-400': activeTab !== 'overview' }">
                    Overview
                </button>
                <button
                    @click="activeTab = 'performance'"
                    class="text-sm transition-colors duration-200 pb-4 relative"
                    :class="{ 'text-gray-900 dark:text-white font-medium after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-gray-900 dark:after:bg-white': activeTab === 'performance',
                             'text-gray-500 dark:text-gray-400': activeTab !== 'performance' }">
                    Performance
                </button>
                <button
                    @click="activeTab = 'financial'"
                    class="text-sm transition-colors duration-200 pb-4 relative"
                    :class="{ 'text-gray-900 dark:text-white font-medium after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-gray-900 dark:after:bg-white': activeTab === 'financial',
                             'text-gray-500 dark:text-gray-400': activeTab !== 'financial' }">
                    Financial
                </button>
                <button
                    @click="activeTab = 'quality'"
                    class="text-sm transition-colors duration-200 pb-4 relative"
                    :class="{ 'text-gray-900 dark:text-white font-medium after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-gray-900 dark:after:bg-white': activeTab === 'quality',
                             'text-gray-500 dark:text-gray-400': activeTab !== 'quality' }">
                    Quality
                </button>
            </nav>
        </div>

        {{-- Tab Contents --}}
        <div class="py-4">
            {{-- Overview Tab Content --}}
            <div x-show="activeTab === 'overview'" x-cloak>
                {{-- Statistics Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {{-- Total Projects Card --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm dark:shadow-gray-700/50">
                        <div class="flex flex-col">
                            <div class="flex items-center justify-between mb-2">
                                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Projects</h2>
                            <div class="mt-1 flex items-baseline justify-between">
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">27</p>
                                <p class="text-sm text-green-600 dark:text-green-400 font-medium">+12% from last period</p>
                            </div>
                        </div>
                    </div>

                    {{-- Avg. Completion Time Card --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm dark:shadow-gray-700/50">
                        <div class="flex flex-col">
                            <div class="flex items-center justify-between mb-2">
                                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg. Completion Time</h2>
                            <div class="mt-1 flex items-baseline justify-between">
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">3.8 days</p>
                                <p class="text-sm text-red-600 dark:text-red-400 font-medium">-8% from last period</p>
                            </div>
                        </div>
                    </div>

                    {{-- Client Satisfaction Card --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm dark:shadow-gray-700/50">
                        <div class="flex flex-col">
                            <div class="flex items-center justify-between mb-2">
                                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Client Satisfaction</h2>
                            <div class="mt-1 flex items-baseline justify-between">
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">4.8/5</p>
                                <p class="text-sm text-green-600 dark:text-green-400 font-medium">+0.3 from last period</p>
                            </div>
                        </div>
                    </div>

                    {{-- Revenue Card --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm dark:shadow-gray-700/50">
                        <div class="flex flex-col">
                            <div class="flex items-center justify-between mb-2">
                                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Revenue</h2>
                            <div class="mt-1 flex items-baseline justify-between">
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">$12,450</p>
                                <p class="text-sm text-green-600 dark:text-green-400 font-medium">+15% from last period</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Charts Grid --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                    {{-- Project Completion Trend --}}
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Project Completion Trend</h3>
                        <p class="text-sm text-gray-500 mb-6">Monthly project completion for the past 6 months</p>
                        <div style="height: 300px; position: relative;">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>

                    {{-- Project Type Distribution --}}
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Project Type Distribution</h3>
                        <p class="text-sm text-gray-500 mb-6">Breakdown of projects by type for May 2025</p>
                        <div style="height: 300px; position: relative;">
                            <canvas id="distributionChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Recent Projects Section --}}
                <div class="bg-white rounded-lg p-6 shadow-sm mt-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Recent Projects</h3>
                            <p class="text-sm text-gray-500">Latest completed projects for May 2025</p>
                        </div>
                        <button type="button" class="inline-flex items-center gap-2 px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                            </svg>
                            Filter
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        {{-- Project Item 1 --}}
                        <div class="flex items-center justify-between py-4 border-b border-gray-100">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="text-sm font-medium text-gray-900">Keiken Ninzu - Episode 49</h4>
                                    <span class="px-2 py-1 text-xs font-medium text-purple-700 bg-purple-50 rounded-full">Character Design</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                        Completed: May 15, 2025
                                    </span>
                                    <span>Client: Manga Masters</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <span class="block text-sm font-medium text-gray-900">$850</span>
                                    <span class="text-xs text-gray-500">Revenue</span>
                                </div>
                                <button type="button" class="inline-flex items-center text-sm text-gray-700 border border-gray-300 rounded-lg px-3 py-2 hover:text-gray-900">
                                    <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    View Report
                                </button>
                            </div>
                        </div>

                        {{-- Project Item 2 --}}
                        <div class="flex items-center justify-between py-4 border-b border-gray-100">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="text-sm font-medium text-gray-900">Stellar Odyssey - Space Station</h4>
                                    <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-50 rounded-full">Background Art</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                        Completed: May 12, 2025
                                    </span>
                                    <span>Client: Cosmic Comics</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <span class="block text-sm font-medium text-gray-900">$720</span>
                                    <span class="text-xs text-gray-500">Revenue</span>
                                </div>
                                <button type="button" class="inline-flex items-center text-sm text-gray-700 border border-gray-300 rounded-lg px-3 py-2 hover:text-gray-900">
                                    <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    View Report
                                </button>
                            </div>
                        </div>

                        {{-- Project Item 3 --}}
                        <div class="flex items-center justify-between py-4 border-b border-gray-100">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="text-sm font-medium text-gray-900">Urban Legends - Chapter 3</h4>
                                    <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-50 rounded-full">Storyboarding</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                        Completed: May 10, 2025
                                    </span>
                                    <span>Client: Dreamscape Animation</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <span class="block text-sm font-medium text-gray-900">$650</span>
                                    <span class="text-xs text-gray-500">Revenue</span>
                                </div>
                                <button type="button" class="inline-flex items-center text-sm text-gray-700 border border-gray-300 rounded-lg px-3 py-2 hover:text-gray-900">
                                    <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    View Report
                                </button>
                            </div>
                        </div>

                        {{-- Project Item 4 --}}
                        <div class="flex items-center justify-between py-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="text-sm font-medium text-gray-900">Dragon Realm - Episode 12</h4>
                                    <span class="px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-50 rounded-full">Coloring</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                        Completed: May 8, 2025
                                    </span>
                                    <span>Client: Manga Masters</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <span class="block text-sm font-medium text-gray-900">$580</span>
                                    <span class="text-xs text-gray-500">Revenue</span>
                                </div>
                                <button type="button" class="inline-flex items-center text-sm text-gray-700 border border-gray-300 rounded-lg px-3 py-2 hover:text-gray-900">
                                    <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    View Report
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Performance Tab Content --}}
            <div x-show="activeTab === 'performance'" x-cloak>
                <div class="space-y-6">
                    {{-- Header --}}
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Performance Metrics</h2>
                        <p class="text-sm text-gray-500">Detailed performance analysis for May 2025</p>
                    </div>

                    {{-- Efficiency Metrics --}}
                    <div class="bg-white rounded-lg p-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Efficiency Metrics</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            {{-- Avg. Completion Time --}}
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Avg. Completion Time</p>
                                <p class="text-2xl font-semibold text-gray-900 mb-1">3.8 days</p>
                                <p class="text-sm text-green-600">↑ 8% faster than last period</p>
                            </div>
                            {{-- On-Time Delivery --}}
                            <div>
                                <p class="text-sm text-gray-600 mb-1">On-Time Delivery</p>
                                <p class="text-2xl font-semibold text-gray-900 mb-1">98.3%</p>
                                <p class="text-sm text-green-600">↑ 2.1% higher than last period</p>
                            </div>
                            {{-- Revision Rate --}}
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Revision Rate</p>
                                <p class="text-2xl font-semibold text-gray-900 mb-1">5.2%</p>
                                <p class="text-sm text-green-600">↑ 3.1% lower than last period</p>
                            </div>
                            {{-- Productivity --}}
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Productivity</p>
                                <p class="text-2xl font-semibold text-gray-900 mb-1">+15%</p>
                                <p class="text-sm text-green-600">↑ 5% higher than last period</p>
                            </div>
                        </div>
                    </div>

                    {{-- Project Type Performance --}}
                    <div class="bg-white rounded-lg p-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Project Type Performance</h3>
                        <div class="space-y-4">
                            {{-- Character Design --}}
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-600">Character Design</span>
                                    <span class="text-sm text-gray-600">Avg. Completion: 3.5 days</span>
                                </div>
                                <div class="h-2 bg-gray-200 rounded-full">
                                    <div class="h-2 bg-purple-500 rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                            {{-- Background Art --}}
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-600">Background Art</span>
                                    <span class="text-sm text-gray-600">Avg. Completion: 4.2 days</span>
                                </div>
                                <div class="h-2 bg-gray-200 rounded-full">
                                    <div class="h-2 bg-blue-500 rounded-full" style="width: 92%"></div>
                                </div>
                            </div>
                            {{-- Storyboarding --}}
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-600">Storyboarding</span>
                                    <span class="text-sm text-gray-600">Avg. Completion: 2.8 days</span>
                                </div>
                                <div class="h-2 bg-gray-200 rounded-full">
                                    <div class="h-2 bg-green-500 rounded-full" style="width: 78%"></div>
                                </div>
                            </div>
                            {{-- Coloring --}}
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-600">Coloring</span>
                                    <span class="text-sm text-gray-600">Avg. Completion: 3.2 days</span>
                                </div>
                                <div class="h-2 bg-gray-200 rounded-full">
                                    <div class="h-2 bg-yellow-500 rounded-full" style="width: 88%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Performance Comparison --}}
                    <div class="bg-white rounded-lg p-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Performance Comparison</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-sm text-gray-500">
                                        <th class="pb-3 font-normal">Metric</th>
                                        <th class="pb-3 font-normal">Your Performance</th>
                                        <th class="pb-3 font-normal">Studio Average</th>
                                        <th class="pb-3 font-normal">Difference</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    <tr class="border-t border-gray-200">
                                        <td class="py-3 text-gray-600">Completion Time</td>
                                        <td class="py-3 text-gray-900">3.8 days</td>
                                        <td class="py-3 text-gray-900">4.5 days</td>
                                        <td class="py-3 text-green-600">-0.7 days (15.6% faster)</td>
                                    </tr>
                                    <tr class="border-t border-gray-200">
                                        <td class="py-3 text-gray-600">Quality Score</td>
                                        <td class="py-3 text-gray-900">9.2/10</td>
                                        <td class="py-3 text-gray-900">8.7/10</td>
                                        <td class="py-3 text-green-600">+0.5 (5.7% higher)</td>
                                    </tr>
                                    <tr class="border-t border-gray-200">
                                        <td class="py-3 text-gray-600">Client Satisfaction</td>
                                        <td class="py-3 text-gray-900">4.8/5</td>
                                        <td class="py-3 text-gray-900">4.5/5</td>
                                        <td class="py-3 text-green-600">+0.3 (6.7% higher)</td>
                                    </tr>
                                    <tr class="border-t border-gray-200">
                                        <td class="py-3 text-gray-600">Revision Rate</td>
                                        <td class="py-3 text-gray-900">5.2%</td>
                                        <td class="py-3 text-gray-900">8.3%</td>
                                        <td class="py-3 text-green-600">-3.1% (37.3% lower)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Financial Tab Content --}}
            <div x-show="activeTab === 'financial'" x-cloak>
                <div class="space-y-6">
                    {{-- Header --}}
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Financial Overview</h2>
                        <p class="text-sm text-gray-500">Financial performance analysis for May 2025</p>
                    </div>

                    {{-- Financial Summary Cards --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        {{-- Total Revenue Card --}}
                        <div class="bg-white rounded-lg p-6 shadow-sm">
                            <div class="flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="p-2 bg-green-100 rounded-lg">
                                        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <h2 class="text-sm font-medium text-gray-500">Total Revenue</h2>
                                <div class="mt-1">
                                    <p class="text-2xl font-semibold text-gray-900">$12,450</p>
                                    <p class="text-sm text-green-600">+15% from last month</p>
                                </div>
                            </div>
                        </div>

                        {{-- Average Project Value Card --}}
                        <div class="bg-white rounded-lg p-6 shadow-sm">
                            <div class="flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5" />
                                        </svg>
                                    </div>
                                </div>
                                <h2 class="text-sm font-medium text-gray-500">Avg. Project Value</h2>
                                <div class="mt-1">
                                    <p class="text-2xl font-semibold text-gray-900">$700</p>
                                    <p class="text-sm text-green-600">+8% from last month</p>
                                </div>
                            </div>
                        </div>

                        {{-- Pending Payments Card --}}
                        <div class="bg-white rounded-lg p-6 shadow-sm">
                            <div class="flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="p-2 bg-yellow-100 rounded-lg">
                                        <svg class="w-6 h-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <h2 class="text-sm font-medium text-gray-500">Pending Payments</h2>
                                <div class="mt-1">
                                    <p class="text-2xl font-semibold text-gray-900">$2,800</p>
                                    <p class="text-sm text-yellow-600">3 projects pending</p>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Success Rate Card --}}
                        <div class="bg-white rounded-lg p-6 shadow-sm">
                            <div class="flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="p-2 bg-purple-100 rounded-lg">
                                        <svg class="w-6 h-6 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <h2 class="text-sm font-medium text-gray-500">Payment Success Rate</h2>
                                <div class="mt-1">
                                    <p class="text-2xl font-semibold text-gray-900">98.5%</p>
                                    <p class="text-sm text-green-600">+2.5% from last month</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Revenue Breakdown --}}
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Revenue by Project Type</h3>
                        <div class="space-y-4">
                            {{-- Character Design Revenue --}}
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-purple-500"></span>
                                        <span class="text-sm text-gray-600">Character Design</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">$5,200</span>
                                </div>
                                <div class="h-2 bg-gray-100 rounded-full">
                                    <div class="h-2 bg-purple-500 rounded-full" style="width: 42%"></div>
                                </div>
                            </div>

                            {{-- Background Art Revenue --}}
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                                        <span class="text-sm text-gray-600">Background Art</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">$3,600</span>
                                </div>
                                <div class="h-2 bg-gray-100 rounded-full">
                                    <div class="h-2 bg-blue-500 rounded-full" style="width: 29%"></div>
                                </div>
                            </div>

                            {{-- Storyboarding Revenue --}}
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-green-500"></span>
                                        <span class="text-sm text-gray-600">Storyboarding</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">$2,150</span>
                                </div>
                                <div class="h-2 bg-gray-100 rounded-full">
                                    <div class="h-2 bg-green-500 rounded-full" style="width: 17%"></div>
                                </div>
                            </div>

                            {{-- Coloring Revenue --}}
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                                        <span class="text-sm text-gray-600">Coloring</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">$1,500</span>
                                </div>
                                <div class="h-2 bg-gray-100 rounded-full">
                                    <div class="h-2 bg-yellow-500 rounded-full" style="width: 12%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Monthly Revenue Trend --}}
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Monthly Revenue Trend</h3>

                        {{-- Chart Container --}}
                        <div class="mb-6" style="height: 200px;">
                            <canvas id="revenueChart"></canvas>
                        </div>

                        <!-- {{-- Revenue List --}}
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-600">May 2025</span>
                                <span class="text-sm font-medium text-gray-900">$12,450</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-600">April 2025</span>
                                <span class="text-sm font-medium text-gray-900">$10,820</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-600">March 2025</span>
                                <span class="text-sm font-medium text-gray-900">$11,350</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-600">February 2025</span>
                                <span class="text-sm font-medium text-gray-900">$9,780</span>
                            </div>
                        </div> -->
                    </div>

                </div>
            </div>

            {{-- Quality Tab Content --}}
            <div x-show="activeTab === 'quality'" x-cloak>
                <div class="space-y-6">
                    {{-- Header --}}
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Quality Metrics</h2>
                        <p class="text-sm text-gray-500">Quality assessment for May 2025</p>
                    </div>

                    {{-- Quality Scores by Project Type --}}
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Quality Scores by Project Type</h3>
                        <div class="space-y-4">
                            {{-- Character Design Score --}}
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-600">Character Design</span>
                                    <span class="text-sm font-medium text-gray-900">9.4/10</span>
                                </div>
                                <div class="h-2 bg-gray-100 rounded-full">
                                    <div class="h-2 bg-purple-500 rounded-full" style="width: 94%"></div>
                                </div>
                            </div>

                            {{-- Background Art Score --}}
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-600">Background Art</span>
                                    <span class="text-sm font-medium text-gray-900">8.7/10</span>
                                </div>
                                <div class="h-2 bg-gray-100 rounded-full">
                                    <div class="h-2 bg-blue-500 rounded-full" style="width: 87%"></div>
                                </div>
                            </div>

                            {{-- Storyboarding Score --}}
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-600">Storyboarding</span>
                                    <span class="text-sm font-medium text-gray-900">8.9/10</span>
                                </div>
                                <div class="h-2 bg-gray-100 rounded-full">
                                    <div class="h-2 bg-green-500 rounded-full" style="width: 89%"></div>
                                </div>
                            </div>

                            {{-- Coloring Score --}}
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-600">Coloring</span>
                                    <span class="text-sm font-medium text-gray-900">9.2/10</span>
                                </div>
                                <div class="h-2 bg-gray-100 rounded-full">
                                    <div class="h-2 bg-yellow-500 rounded-full" style="width: 92%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Client Feedback Highlights --}}
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Client Feedback Highlights</h3>
                        <div class="space-y-6">
                            {{-- Feedback Item 1 --}}
                            <div class="space-y-2 border-b border-gray-200 pb-2">
                                <div class="flex items-center gap-3">
                                    <span class="px-2 py-1 text-xs font-medium text-purple-700 bg-purple-50 rounded-full">Character Design</span>
                                    <span class="font-medium text-gray-900">Keiken Ninzu - Episode 49</span>
                                </div>
                                <div class="flex text-yellow-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <p class="text-sm text-gray-600 italic">"Exceptional character expressions and attention to detail. The dynamic poses really capture the essence of the action scenes."</p>
                            </div>

                            {{-- Feedback Item 2 --}}
                            <div class="space-y-2 border-b border-gray-200 pb-2">
                                <div class="flex items-center gap-3">
                                    <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-50 rounded-full">Background Art</span>
                                    <span class="font-medium text-gray-900">Stellar Odyssey - Space Station</span>
                                </div>
                                <div class="flex text-yellow-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <p class="text-sm text-gray-600 italic">"The perspective and lighting in the space station scenes are outstanding. Creates a perfect atmosphere for the story."</p>
                            </div>

                            {{-- Feedback Item 3 --}}
                            <div class="space-y-2 border-b border-gray-200 pb-2">
                                <div class="flex items-center gap-3">
                                    <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-50 rounded-full">Storyboarding</span>
                                    <span class="font-medium text-gray-900">Urban Legends - Chapter 3</span>
                                </div>
                                <div class="flex text-yellow-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <p class="text-sm text-gray-600 italic">"The pacing and panel layout for the chase sequence was brilliantly executed. Really enhances the tension in the story."</p>
                            </div>
                        </div>
                    </div>

                    {{-- Quality Improvement Areas --}}
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">Quality Improvement Areas</h3>
                        <div class="space-y-4">
                            <div class="border-b border-gray-200 pb-2">
                                <h4 class="text-sm font-medium text-gray-900 mb-1">Background Consistency</h4>
                                <p class="text-sm text-gray-600">Ensure consistent lighting and perspective across all background scenes, especially in multi-episode projects.</p>
                            </div>
                            <div class="border-b border-gray-200 pb-2">
                                <h4 class="text-sm font-medium text-gray-900 mb-1">Character Proportions</h4>
                                <p class="text-sm text-gray-600">Maintain consistent character proportions across different poses and angles, particularly in action sequences.</p>
                            </div>
                            <div class="border-b border-gray-200 pb-2">
                                <h4 class="text-sm font-medium text-gray-900 mb-1">Color Palette Cohesion</h4>
                                <p class="text-sm text-gray-600">Ensure color palettes remain cohesive across scenes and maintain the established mood of the project.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('alpine:init', () => {
    setTimeout(() => {
        // Common font styling
        Chart.defaults.font.family = 'Figtree, system-ui, sans-serif';
        Chart.defaults.font.size = 13;
        Chart.defaults.color = '#6B7280';

        // Revenue Trend Chart
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['February 2025', 'March 2025', 'April 2025', 'May 2025'],
                    datasets: [{
                        label: 'Monthly Revenue',
                        data: [9780, 11350, 10820, 12450],
                        borderColor: 'rgb(147, 51, 234)',
                        backgroundColor: 'rgba(147, 51, 234, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: 'rgb(147, 51, 234)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            padding: 12,
                            titleColor: '#fff',
                            titleFont: {
                                size: 14,
                                weight: '600'
                            },
                            bodyColor: '#fff',
                            bodyFont: {
                                size: 13
                            },
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            displayColors: false,
                            callbacks: {
                                title: (items) => items[0].label,
                                label: (item) => `Revenue: $${item.formattedValue}`
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                padding: 10
                            },
                            border: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            border: {
                                display: false
                            },
                            grid: {
                                color: 'rgba(243, 244, 246, 1)',
                                drawBorder: false
                            },
                            ticks: {
                                padding: 10,
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        }

        // Project Completion Trend Chart
        const trendCtx = document.getElementById('trendChart');
        if (trendCtx) {
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: ['February 2025', 'March 2025', 'April 2025', 'May 2025'],
                    datasets: [{
                        label: 'Projects Completed',
                        data: [19, 22, 24, 27],
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        borderColor: 'rgba(139, 92, 246, 0.9)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(139, 92, 246, 0.9)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            padding: 12,
                            titleColor: '#fff',
                            titleFont: {
                                size: 14,
                                weight: '600'
                            },
                            bodyColor: '#fff',
                            bodyFont: {
                                size: 13
                            },
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            displayColors: false,
                            callbacks: {
                                title: (items) => items[0].label,
                                label: (item) => `${item.formattedValue} projects completed`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 5,
                                padding: 10
                            },
                            grid: {
                                color: 'rgba(243, 244, 246, 1)',
                                drawBorder: false,
                                drawTicks: false
                            },
                            border: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                padding: 10
                            },
                            border: {
                                display: false
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            right: 10,
                            bottom: 10,
                            left: 10
                        }
                    }
                }
            });
        }

        // Project Type Distribution Chart
        const distributionCtx = document.getElementById('distributionChart');
        if (distributionCtx) {
            new Chart(distributionCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Character Design', 'Background Art', 'Storyboarding', 'Coloring'],
                    datasets: [{
                        data: [40, 25, 20, 15],
                        backgroundColor: [
                            'rgba(139, 92, 246, 0.9)',  // Purple for Character Design
                            'rgba(59, 130, 246, 0.9)',  // Blue for Background Art
                            'rgba(34, 197, 94, 0.9)',   // Green for Storyboarding
                            'rgba(251, 191, 36, 0.9)'   // Yellow for Coloring
                        ],
                        borderWidth: 0,
                        borderRadius: 4,
                        spacing: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    radius: '90%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 20,
                                font: {
                                    size: 13,
                                    weight: '500'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            padding: 12,
                            titleColor: '#fff',
                            titleFont: {
                                size: 14,
                                weight: '600'
                            },
                            bodyColor: '#fff',
                            bodyFont: {
                                size: 13
                            },
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            displayColors: true,
                            callbacks: {
                                label: (context) => {
                                    const label = context.label || '';
                                    const value = context.formattedValue || '';
                                    return ` ${label}: ${value}%`;
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            right: 10,
                            bottom: 10,
                            left: 10
                        }
                    }
                }
            });
        }
    }, 100);
});
</script>
@endsection
