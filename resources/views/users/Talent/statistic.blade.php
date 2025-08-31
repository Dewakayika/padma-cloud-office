@extends('layouts.page')

@section('content')
    <div class="container py-6 px-3 mx-auto">
        {{-- Blur overlay and "Under Development" banner --}}
        <div class="fixed inset-0 bg-black/20 backdrop-blur-sm z-40" style="left: 16rem;"></div>
        <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50" style="left: calc(50% + 12rem);">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8 max-w-md mx-4">
                <div class="text-center">
                    <div class="mb-6">
                        <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Coming Soon</h1>
                        <p class="text-gray-600 dark:text-gray-400 text-lg mb-4">This feature is currently being built</p>
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <p class="text-sm text-blue-800 dark:text-blue-200">
                                <strong>What's coming:</strong> Comprehensive talent statistics with performance analytics, skill assessments, project insights, and detailed performance tracking.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center justify-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Development in progress...</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <!-- Projects Completed -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow dark:shadow-gray-700/50">
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Projects Completed</h3>
                <div class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">78</div>
                <div class="text-sm text-green-600 dark:text-green-400">12% from last period</div>
            </div>

            <!-- Avg. Completion Time -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow dark:shadow-gray-700/50">
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Avg. Completion Time</h3>
                <div class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">3.8 days</div>
                <div class="text-sm text-green-600 dark:text-green-400">5% improvement from last period</div>
            </div>

            <!-- Average Rating -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow dark:shadow-gray-700/50">
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Average Rating</h3>
                <div class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">4.7/5</div>
                <div class="text-sm text-green-600 dark:text-green-400">0.3 from last period</div>
            </div>

            <!-- Earnings per Project -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow dark:shadow-gray-700/50">
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Earnings per Project</h3>
                <div class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">$842</div>
                <div class="text-sm text-green-600 dark:text-green-400">8% from last period</div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-6">
            <nav class="flex space-x-4 border-b border-gray-200 dark:border-gray-700">
                <button onclick="switchTab('overview')" class="px-4 py-2 text-sm font-medium text-purple-600 dark:text-purple-400 border-b-2 border-purple-600 dark:border-purple-400" data-tab="overview">
                    Overview
                </button>
                <button onclick="switchTab('projects')" class="px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" data-tab="projects">
                    Projects
                </button>
                <button onclick="switchTab('skills')" class="px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" data-tab="skills">
                    Skills
                </button>
            </nav>
        </div>

        <!-- Tab Contents -->
        <div id="overview" class="tab-content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow dark:shadow-gray-700/50">
                    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Performance Trend</h2>
                    <p class="text-gray-600 dark:text-gray-400">Your performance metrics over time</p>
                    <div class="h-64 flex items-center justify-center">
                        <p class="text-gray-500 dark:text-gray-400">Performance chart visualization</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow dark:shadow-gray-700/50">
                    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Project Distribution</h2>
                    <p class="text-gray-600 dark:text-gray-400">Types of projects you've worked on</p>
                    <div class="h-64 flex items-center justify-center">
                        <p class="text-gray-500 dark:text-gray-400">Project distribution chart</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg p-6 shadow dark:shadow-gray-700/50">
                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Monthly Earnings</h2>
                <p class="text-gray-600 dark:text-gray-400">Your earnings over the past 6 months</p>
                <div class="h-64 flex items-center justify-center">
                    <p class="text-gray-500 dark:text-gray-400">Monthly earnings chart</p>
                </div>
            </div>
        </div>

        <div id="projects" class="tab-content hidden">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow dark:shadow-gray-700/50">
                <h2 class="text-xl font-semibold mb-1 text-gray-900 dark:text-white">Project Performance</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Detailed metrics for your recent projects</p>

                <div class="space-y-8">
                    <!-- Project 1 -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-medium text-lg text-gray-900 dark:text-white">Character Design for "Mystic Warriors"</h3>
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    May 15, 2025 • 3 days
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-medium text-gray-900 dark:text-white">Manga Masters</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Character Design</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Quality Score -->
                            <div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Quality Score</div>
                                <div class="flex items-center">
                                    <span class="text-2xl font-semibold text-gray-900 dark:text-white">9.2/10</span>
                                    <svg class="w-4 h-4 text-green-500 dark:text-green-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Efficiency -->
                            <div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Efficiency</div>
                                <div class="flex items-center">
                                    <span class="text-2xl font-semibold text-gray-900 dark:text-white">94%</span>
                                    <svg class="w-4 h-4 text-green-500 dark:text-green-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Client Satisfaction -->
                            <div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Client Satisfaction</div>
                                <div class="flex items-center">
                                    <span class="text-2xl font-semibold text-gray-900 dark:text-white">4.8/5</span>
                                    <svg class="w-4 h-4 text-green-500 dark:text-green-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Project 2 -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-medium text-lg text-gray-900 dark:text-white">Background Art for Episode 5</h3>
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    May 10, 2025 • 4 days
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-medium text-gray-900 dark:text-white">Anime Artisans</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Background Art</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Quality Score -->
                            <div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Quality Score</div>
                                <div class="flex items-center">
                                    <span class="text-2xl font-semibold text-gray-900 dark:text-white">8.7/10</span>
                                    <svg class="w-4 h-4 text-green-500 dark:text-green-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Efficiency -->
                            <div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Efficiency</div>
                                <div class="flex items-center">
                                    <span class="text-2xl font-semibold text-gray-900 dark:text-white">88%</span>
                                    <svg class="w-4 h-4 text-green-500 dark:text-green-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Client Satisfaction -->
                            <div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Client Satisfaction</div>
                                <div class="flex items-center">
                                    <span class="text-2xl font-semibold text-gray-900 dark:text-white">4.5/5</span>
                                    <svg class="w-4 h-4 text-green-500 dark:text-green-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="skills" class="tab-content hidden">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow dark:shadow-gray-700/50">
                <h2 class="text-xl font-semibold mb-1 text-gray-900 dark:text-white">Skill Assessment</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Your skill ratings based on project performance</p>

                <div class="space-y-6">
                    <!-- Character Design -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium text-gray-900 dark:text-white">Character Design</span>
                            <span class="font-medium text-gray-900 dark:text-white">9.4/10</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 mb-1">
                            <div class="h-2.5 rounded-full" style="width: 94%; background: linear-gradient(90deg, #8B5CF6 0%, #3B82F6 100%)"></div>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Based on 24 projects</span>
                            <span class="text-green-500 dark:text-green-400">+0.3 from last assessment</span>
                        </div>
                    </div>

                    <!-- Background Art -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium text-gray-900 dark:text-white">Background Art</span>
                            <span class="font-medium text-gray-900 dark:text-white">8.7/10</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 mb-1">
                            <div class="h-2.5 rounded-full" style="width: 87%; background: linear-gradient(90deg, #8B5CF6 0%, #3B82F6 100%)"></div>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Based on 18 projects</span>
                            <span class="text-green-500 dark:text-green-400">+0.5 from last assessment</span>
                        </div>
                    </div>

                    <!-- Storyboarding -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium text-gray-900 dark:text-white">Storyboarding</span>
                            <span class="font-medium text-gray-900 dark:text-white">8.9/10</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 mb-1">
                            <div class="h-2.5 rounded-full" style="width: 89%; background: linear-gradient(90deg, #8B5CF6 0%, #3B82F6 100%)"></div>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Based on 12 projects</span>
                            <span class="text-green-500 dark:text-green-400">+0.4 from last assessment</span>
                        </div>
                    </div>

                    <!-- Coloring -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium text-gray-900 dark:text-white">Coloring</span>
                            <span class="font-medium text-gray-900 dark:text-white">9.2/10</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 mb-1">
                            <div class="h-2.5 rounded-full" style="width: 92%; background: linear-gradient(90deg, #8B5CF6 0%, #3B82F6 100%)"></div>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Based on 31 projects</span>
                            <span class="text-green-500 dark:text-green-400">+0.2 from last assessment</span>
                        </div>
                    </div>

                    <!-- Inking -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium text-gray-900 dark:text-white">Inking</span>
                            <span class="font-medium text-gray-900 dark:text-white">8.5/10</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 mb-1">
                            <div class="h-2.5 rounded-full" style="width: 85%; background: linear-gradient(90deg, #8B5CF6 0%, #3B82F6 100%)"></div>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Based on 15 projects</span>
                            <span class="text-green-500 dark:text-green-400">+0.6 from last assessment</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Show selected tab content
            document.getElementById(tabName).classList.remove('hidden');

            // Update active tab styling
            document.querySelectorAll('nav button').forEach(button => {
                button.classList.remove('text-purple-600', 'border-b-2', 'border-purple-600', 'dark:text-purple-400', 'dark:border-purple-400');
                button.classList.add('text-gray-500', 'dark:text-gray-400');
            });

            // Add active styling to clicked tab
            const activeButton = document.querySelector(`button[data-tab="${tabName}"]`);
            activeButton.classList.remove('text-gray-500', 'dark:text-gray-400');
            activeButton.classList.add('text-purple-600', 'border-b-2', 'border-purple-600', 'dark:text-purple-400', 'dark:border-purple-400');
        }
    </script>
@endsection

