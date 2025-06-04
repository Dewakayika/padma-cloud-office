@extends('layouts.page')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Tab Navigation -->
    <div class="flex space-x-1 mb-8 border-b">
        <button 
            onclick="switchTab('studios')"
            id="studios-tab"
            class="px-6 py-3 text-sm font-medium border-b-2 transition-colors duration-200"
            :class="activeTab === 'studios' ? 'text-gray-600 border-purple-500' : 'text-gray-400 border-transparent hover:text-gray-600'">
            Studios
        </button>
        <button 
            onclick="switchTab('current-tasks')"
            id="current-tasks-tab"
            class="px-6 py-3 text-sm font-medium border-b-2 transition-colors duration-200"
            :class="activeTab === 'current-tasks' ? 'text-gray-600 border-purple-500' : 'text-gray-400 border-transparent hover:text-gray-600'">
            Current Tasks
        </button>
    </div>

    <!-- Studios Content -->
    <div id="studios-content" class="tab-content">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Studio Card 1 -->
            <a href="{{ url('/talent') }}" class="block group">
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 transition-all duration-200 hover:shadow-md hover:border-purple-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center">
                                <x-application-logo class="w-7 h-7" /> 
                            </div>
                            <div class="ml-3">
                                <h3 class="font-semibold text-gray-800">Padma Studio</h3>
                                <p class="text-sm text-gray-500">Tokyo, Japan</p>
                            </div>
                        </div>
                        <button class="text-purple-600 relative z-10" onclick="event.preventDefault();">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Role:</span>
                            <span class="text-purple-600 font-medium">Character Designer</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Projects Completed:</span>
                            <span class="text-gray-800">24</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Avg. Completion Time:</span>
                            <span class="text-gray-800">3.2 days</span>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-500">Performance:</span>
                                <span class="text-gray-800">92%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: 92%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Studio Card 2 -->
            <a href="" class="block group">
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 transition-all duration-200 hover:shadow-md hover:border-purple-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold">AA</span>
                            </div>
                            <div class="ml-3">
                                <h3 class="font-semibold text-gray-800">Anime Artisans</h3>
                                <p class="text-sm text-gray-500">Osaka, Japan</p>
                            </div>
                        </div>
                        <button class="text-purple-600 relative z-10" onclick="event.preventDefault();">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Role:</span>
                            <span class="text-purple-600 font-medium">Background Artist</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Projects Completed:</span>
                            <span class="text-gray-800">18</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Avg. Completion Time:</span>
                            <span class="text-gray-800">4.5 days</span>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-500">Performance:</span>
                                <span class="text-gray-800">87%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: 87%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Join New Studio Card -->
            <a href="" class="block group">
                <div class="bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 p-6 flex items-center justify-center transition-all duration-200 hover:bg-gray-100 hover:border-purple-300">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h3 class="text-gray-800 font-medium">Join New Studio</h3>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Current Tasks Content -->
    <div id="current-tasks-content" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Task Card Example -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-gray-900 text-base">Character Design for 'Mystic Warriors'</h3>
                    <span class="px-2 py-1 text-xs font-medium bg-red-50 text-red-700 rounded">High</span>
                </div>

                <p class="text-sm text-gray-600 mb-4">Create concept art for the main protagonist with detailed expressions and poses.</p>

                <div class="space-y-2">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Studio:</span>
                        <span class="ml-2 text-gray-900">Manga Masters</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Deadline:</span>
                        <span class="ml-2 text-gray-900">May 21, 2025</span>
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="inline-block w-2 h-2 bg-purple-500 rounded-full"></span>
                        <span class="ml-2 text-sm text-gray-600">In Progress</span>
                    </div>
                    <button class="px-4 py-2 text-sm text-purple-600 bg-purple-100 rounded-md hover:text-purple-700 font-medium">View Details</button>
                </div>
            </div>

            <!-- Task Card Example -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-gray-900 text-base">Character Design for 'Mystic Warriors'</h3>
                    <span class="px-2 py-1 text-xs font-medium bg-red-50 text-red-700 rounded">High</span>
                </div>
                <p class="text-sm text-gray-600 mb-4">Create concept art for the main protagonist with detailed expressions and poses.</p>
                <div class="space-y-2">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Studio:</span>
                        <span class="ml-2 text-gray-900">Manga Masters</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Deadline:</span>
                        <span class="ml-2 text-gray-900">May 21, 2025</span>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="inline-block w-2 h-2 bg-purple-500 rounded-full"></span>
                            <span class="ml-2 text-sm text-gray-600">In Progress</span>
                        </div>
                        <button class="px-4 py-2 text-sm text-purple-600 bg-purple-100 rounded-md hover:text-purple-700 font-medium">View Details</button>
                    </div>  
                </div>
            </div>  
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-purple-100 {
        background-color: #F3E8FF;
    }
    .text-purple-600 {
        color: #9333EA;
    }
    .bg-purple-500 {
        background-color: #8B5CF6;
    }
    .border-purple-500 {
        border-color: #8B5CF6;
    }
    .tab-content {
        transition: opacity 0.2s ease-in-out;
    }
    .tab-content.hidden {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
    let activeTab = 'studios';

    function switchTab(tabId) {
        // Update active tab
        activeTab = tabId;

        // Update tab buttons
        document.querySelectorAll('button[id$="-tab"]').forEach(button => {
            if (button.id === `${tabId}-tab`) {
                button.classList.remove('text-gray-400', 'border-transparent');
                button.classList.add('text-gray-600', 'border-purple-500');
            } else {
                button.classList.remove('text-gray-600', 'border-purple-500');
                button.classList.add('text-gray-400', 'border-transparent');
            }
        });

        // Update content visibility
        document.querySelectorAll('.tab-content').forEach(content => {
            if (content.id === `${tabId}-content`) {
                content.classList.remove('hidden');
            } else {
                content.classList.add('hidden');
            }
        });
    }

    // Initialize the first tab as active
    document.addEventListener('DOMContentLoaded', () => {
        switchTab('studios');
    });
</script>
@endpush
@endsection
