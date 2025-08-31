@extends('layouts.app')
@section('title', 'SOP Details - ' . $projectType->project_name)
@section('meta_description', 'Padma Cloud Office - SOP Details')

@section('content')
<div class="md:p-4 sm:ml-64">
    <div class="py-4 md:p-4">
        <div class="container mx-auto">

            <!-- Page Header with Navigation -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">SOP Management</h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Manage Standard Operating Procedures for {{ $projectType->project_name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('company.settings') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Settings
                        </a>
                        <button type="button" id="add-sop-button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add New SOP
                        </button>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <x-alert type="success" :message="session('success')" />
            @endif

            @if(session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif

            @if(session('warning'))
                <x-alert type="warning" :message="session('warning')" />
            @endif

            @if(session('info'))
                <x-alert type="info" :message="session('info')" />
            @endif

            {{-- Breadcrumb --}}
            <x-breadscrums/>

            {{-- Project Type Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Project Name Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Project Type</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $projectType->project_name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Project Rate Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Project Rate</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($projectType->project_rate, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- QC Rate Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">QC Rate</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $projectType->qc_rate }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">SOP Management</h2>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ $sops->count() }} SOP{{ $sops->count() !== 1 ? 's' : '' }}
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">•</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Last updated: {{ $sops->max('updated_at') ? $sops->max('updated_at')->format('M d, Y') : 'Never' }}</span>
                        </div>
                    </div>
                </div>
                <nav class="flex space-x-8 px-6" aria-label="Tabs" id="sop-tabs">
                    <a href="javascript:void(0);" class="tab-link py-4 px-1 border-b-2 font-medium text-sm border-blue-600 text-blue-600 dark:text-white active flex items-center" data-target="sop-overview">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        SOP Overview
                    </a>
                    <a href="javascript:void(0);" class="tab-link py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-300 hover:text-blue-600 hover:border-blue-300 flex items-center" data-target="sop-statistics">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Statistics
                    </a>
                    <a href="javascript:void(0);" class="tab-link py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-300 hover:text-blue-600 hover:border-blue-300 flex items-center" data-target="sop-settings">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Settings
                    </a>
                </nav>
            </div>

            <!-- Tab Content -->
            <div id="tab-content" class="mt-6">
                <!-- SOP Overview Content -->
                <div id="sop-overview" class="hidden">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Standard Operating Procedures</h2>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage and organize your project procedures</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Total SOPs</p>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $sops->count() }}</p>
                                    </div>
                                    <div class="w-px h-8 bg-gray-300 dark:bg-gray-600"></div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Last Updated</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $sops->max('updated_at') ? $sops->max('updated_at')->format('M d, Y') : 'Never' }}</p>
                                    </div>
                                </div>
                            </div>

                            @if($sops->isEmpty())
                                <div class="text-center py-16">
                                    <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No SOPs Found</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">Get started by creating your first Standard Operating Procedure for this project type. SOPs help ensure consistent quality and efficiency.</p>
                                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                        <button type="button" onclick="openModal()" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Create First SOP
                                        </button>
                                        <a href="{{ route('company.settings') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                            </svg>
                                            Back to Settings
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="grid gap-6">
                                    @foreach($sops as $index => $sop)
                                        <div class="border dark:border-gray-700 rounded-lg p-6 hover:shadow-md transition-shadow bg-gray-50 dark:bg-gray-700">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <div class="flex items-center space-x-3 mb-3">
                                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 text-sm font-medium dark:bg-blue-900 dark:text-blue-200">
                                                            {{ $index + 1 }}
                                                        </span>
                                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">SOP Formula</h3>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                            Active
                                                        </span>
                                                    </div>
                                                    <div class="bg-white dark:bg-gray-800 rounded-md p-4 border dark:border-gray-600">
                                                        <p class="text-gray-800 dark:text-gray-200 whitespace-pre-wrap font-mono text-sm">{{ $sop->sop_formula }}</p>
                                                    </div>

                                                    @if($sop->description)
                                                        <div class="mt-4">
                                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Description</h4>
                                                            <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap text-sm">{{ $sop->description }}</p>
                                                        </div>
                                                    @endif

                                                    <div class="mt-4 flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                                        <span class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                            </svg>
                                                            {{ $sop->user->name }}
                                                        </span>
                                                        <span class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            {{ $sop->created_at->format('M d, Y') }}
                                                        </span>
                                                        @if($sop->updated_at != $sop->created_at)
                                                            <span class="flex items-center">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                                </svg>
                                                                Updated {{ $sop->updated_at->format('M d, Y') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="ml-6 flex-shrink-0 flex items-center space-x-2">
                                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600" onclick="editSop({{ $sop->id }})">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        Edit
                                                    </button>
                                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-red-300 dark:border-red-600 dark:hover:bg-red-600" onclick="deleteSop({{ $sop->id }})">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Pagination --}}
                                @if($sops->hasPages())
                                    <div class="mt-8">
                                        {{ $sops->links() }}
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- SOP Statistics Content -->
                <div id="sop-statistics" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Total SOPs Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total SOPs</p>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $sops->count() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</p>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        {{ $sops->max('updated_at') ? $sops->max('updated_at')->diffForHumans() : 'Never' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Project Type Info Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Project Rate</p>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">${{ number_format($projectType->project_rate, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SOP Timeline -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">SOP Timeline</h3>
                        @if($sops->count() > 0)
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    @foreach($sops->sortByDesc('created_at') as $index => $sop)
                                        <li>
                                            <div class="relative pb-8">
                                                @if($index < $sops->count() - 1)
                                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                        <div>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                                SOP created by <span class="font-medium text-gray-900 dark:text-white">{{ $sop->user->name }}</span>
                                                            </p>
                                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                                                {{ Str::limit($sop->sop_formula, 100) }}
                                                            </p>
                                                        </div>
                                                        <div class="text-right text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                            <time datetime="{{ $sop->created_at->format('Y-m-d') }}">{{ $sop->created_at->format('M d, Y') }}</time>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">No SOPs to display in timeline.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- SOP Settings Content -->
                <div id="sop-settings" class="hidden">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">SOP Management Settings</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Export Settings -->
                            <div class="border dark:border-gray-700 rounded-lg p-4">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Export Options</h4>
                                <div class="space-y-3">
                                    <button type="button" class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Export as CSV
                                    </button>
                                    <button type="button" class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Export as PDF
                                    </button>
                                </div>
                            </div>

                            <!-- Import Settings -->
                            <div class="border dark:border-gray-700 rounded-lg p-4">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Import Options</h4>
                                <div class="space-y-3">
                                    <button type="button" class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        Import from CSV
                                    </button>
                                    <button type="button" class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        </svg>
                                        Download Template
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Settings -->
                        <div class="mt-8 border-t dark:border-gray-700 pt-6">
                            <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Advanced Settings</h4>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Auto-number SOPs</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Automatically assign sequential numbers to new SOPs</p>
                                    </div>
                                    <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 bg-blue-600" role="switch" aria-checked="true">
                                        <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Require descriptions</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Make SOP descriptions mandatory</p>
                                    </div>
                                    <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 bg-gray-200 dark:bg-gray-700" role="switch" aria-checked="false">
                                        <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add/Edit SOP Modal --}}
<div id="sop-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden" aria-hidden="true">
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <div class="absolute right-0 top-0 pr-4 pt-4">
                    <button type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none" onclick="closeModal()">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white" id="modal-title">Add New SOP</h3>
                        <form id="sop-form" action="{{ route('company.project.sop.store') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="project_type_id" value="{{ $projectType->id }}">
                            <input type="hidden" name="sop_id" id="sop_id">

                            <div class="mb-4">
                                <label for="sop_formula" class="block text-sm font-medium text-gray-700 dark:text-gray-400">SOP Formula <span class="text-red-500">*</span></label>
                                <textarea name="sop_formula" id="sop_formula" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter the SOP formula or procedure..."></textarea>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter the step-by-step procedure or formula for this SOP.</p>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Description (Optional)</label>
                                <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Provide additional context or notes..."></textarea>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Add any additional context, notes, or explanations for this SOP.</p>
                            </div>

                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">
                                    Save SOP
                                </button>
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" onclick="closeModal()">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Tab functionality
        const tabs = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('#tab-content > div');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active styles from all tabs
                tabs.forEach(t => t.classList.remove('border-blue-600', 'text-blue-600', 'active'));
                tabs.forEach(t => t.classList.add('border-transparent', 'text-gray-500'));

                // Hide all tab contents
                tabContents.forEach(content => content.classList.add('hidden'));

                // Activate clicked tab
                tab.classList.add('border-blue-600', 'text-blue-600', 'active');
                tab.classList.remove('border-transparent', 'text-gray-500');

                // Show corresponding content
                const targetId = tab.getAttribute('data-target');
                document.getElementById(targetId).classList.remove('hidden');
            });
        });

        // Show the first tab by default
        if (tabs.length > 0) {
            tabs[0].click();
        }
    });

    // Modal functionality
    const modal = document.getElementById('sop-modal');
    const form = document.getElementById('sop-form');
    const addButton = document.getElementById('add-sop-button');

    function openModal() {
        modal.classList.remove('hidden');
        document.getElementById('modal-title').textContent = 'Add New SOP';
        form.reset();
        document.getElementById('sop_id').value = '';
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    function editSop(sopId) {
        fetch(`/company/project-sop/${sopId}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load SOP details');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('modal-title').textContent = 'Edit SOP';
            document.getElementById('sop_id').value = data.id;
            document.getElementById('sop_formula').value = data.sop_formula || '';
            document.getElementById('description').value = data.description || '';
            modal.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load SOP details');
        });
    }

    function deleteSop(sopId) {
        if (confirm('Are you sure you want to delete this SOP? This action cannot be undone.')) {
            fetch(`/company/project-sop/${sopId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                    return null;
                }
                if (!response.ok) {
                    return response.json().then(data => { throw new Error(JSON.stringify(data)); });
                }
                return response.json();
            })
            .then(data => {
                if (data && data.success) {
                    window.location.reload();
                } else {
                    alert(data?.message || 'Failed to delete SOP');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                try {
                    const errorData = JSON.parse(error.message);
                    if (errorData.message) {
                        alert(errorData.message);
                    } else {
                        alert('Failed to delete SOP.');
                    }
                } catch(e) {
                    alert('Failed to delete SOP. Please try again.');
                }
            });
        }
    }

    addButton.addEventListener('click', openModal);

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        const sopId = formData.get('sop_id');
        const url = sopId ? `/company/project-sop/${sopId}` : form.action;
        const method = sopId ? 'PUT' : 'POST';

        if (method === 'PUT') {
            formData.append('_method', 'PUT');
        }

        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(el => el.remove());

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
                return null;
            }
            if (!response.ok) {
                return response.json().then(data => { throw new Error(JSON.stringify(data)); });
            }
            return response.json();
        })
        .then(data => {
            if (data && data.success) {
                window.location.reload();
            } else {
                alert(data?.message || 'Failed to save SOP');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            try {
                const errorData = JSON.parse(error.message);
                if (errorData.errors) {
                    Object.keys(errorData.errors).forEach(field => {
                        const input = document.getElementById(field);
                        if (input) {
                            const errorMessage = document.createElement('p');
                            errorMessage.className = 'error-message text-red-500 text-sm mt-1';
                            errorMessage.textContent = errorData.errors[field][0];
                            input.parentNode.appendChild(errorMessage);
                            input.classList.add('border-red-500');
                        }
                    });
                } else if (errorData.message) {
                    alert(errorData.message);
                } else {
                    alert('Failed to save SOP.');
                }
            } catch (e) {
                alert('Failed to save SOP. Please try again.');
            }
        });
    });

    // Clear error messages on input
    document.getElementById('sop_formula').addEventListener('input', function() {
        this.classList.remove('border-red-500');
        const errorMessage = this.parentNode.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
    });

    document.getElementById('description').addEventListener('input', function() {
        this.classList.remove('border-red-500');
        const errorMessage = this.parentNode.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
    });
</script>
@endpush

