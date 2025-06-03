@extends('layouts.page')

@section('content')
    <div class="container py-6 px-3 mx-auto">
        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <!-- Projects Completed -->
            <div class="bg-white rounded-lg p-4 shadow">
                <h3 class="text-lg font-semibold mb-2">Projects Completed</h3>
                <div class="text-3xl font-bold mb-2">78</div>
                <div class="text-sm text-green-600">12% from last period</div>
            </div>

            <!-- Avg. Completion Time -->
            <div class="bg-white rounded-lg p-4 shadow">
                <h3 class="text-lg font-semibold mb-2">Avg. Completion Time</h3>
                <div class="text-3xl font-bold mb-2">3.8 days</div>
                <div class="text-sm text-green-600">5% improvement from last period</div>
            </div>

            <!-- Average Rating -->
            <div class="bg-white rounded-lg p-4 shadow">
                <h3 class="text-lg font-semibold mb-2">Average Rating</h3>
                <div class="text-3xl font-bold mb-2">4.7/5</div>
                <div class="text-sm text-green-600">0.3 from last period</div>
            </div>

            <!-- Earnings per Project -->
            <div class="bg-white rounded-lg p-4 shadow">
                <h3 class="text-lg font-semibold mb-2">Earnings per Project</h3>
                <div class="text-3xl font-bold mb-2">$842</div>
                <div class="text-sm text-green-600">8% from last period</div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-6">
            <nav class="flex space-x-4 border-b">
                <button onclick="switchTab('overview')" class="px-4 py-2 text-sm font-medium text-purple-600 border-b-2 border-purple-600" data-tab="overview">
                    Overview
                </button>
                <button onclick="switchTab('projects')" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" data-tab="projects">
                    Projects
                </button>
                <button onclick="switchTab('skills')" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" data-tab="skills">
                    Skills
                </button>
            </nav>
        </div>

        <!-- Tab Contents -->
        <div id="overview" class="tab-content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg p-6 shadow">
                    <h2 class="text-lg font-semibold mb-4">Performance Trend</h2>
                    <p class="text-gray-600">Your performance metrics over time</p>
                    <div class="h-64 flex items-center justify-center">
                        <p class="text-gray-500">Performance chart visualization</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 shadow">
                    <h2 class="text-lg font-semibold mb-4">Project Distribution</h2>
                    <p class="text-gray-600">Types of projects you've worked on</p>
                    <div class="h-64 flex items-center justify-center">
                        <p class="text-gray-500">Project distribution chart</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white rounded-lg p-6 shadow">
                <h2 class="text-lg font-semibold mb-4">Monthly Earnings</h2>
                <p class="text-gray-600">Your earnings over the past 6 months</p>
                <div class="h-64 flex items-center justify-center">
                    <p class="text-gray-500">Monthly earnings chart</p>
                </div>
            </div>
        </div>

        <div id="projects" class="tab-content hidden">
            <div class="bg-white rounded-lg p-6 shadow">
                <h2 class="text-xl font-semibold mb-1">Project Performance</h2>
                <p class="text-sm text-gray-600 mb-6">Detailed metrics for your recent projects</p>
                
                <div class="space-y-8">
                    <!-- Project 1 -->
                    <div class="border-b pb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-medium text-lg">Character Design for "Mystic Warriors"</h3>
                                <div class="flex items-center text-sm text-gray-600 mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    May 15, 2025 • 3 days
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-medium">Manga Masters</div>
                                <div class="text-sm text-gray-600">Character Design</div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Quality Score -->
                            <div>
                                <div class="text-sm text-gray-600 mb-1">Quality Score</div>
                                <div class="flex items-center">
                                    <span class="text-2xl font-semibold">9.2/10</span>
                                    <svg class="w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Efficiency -->
                            <div>
                                <div class="text-sm text-gray-600 mb-1">Efficiency</div>
                                <div class="flex items-center">
                                    <span class="text-2xl font-semibold">94%</span>
                                    <svg class="w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Client Satisfaction -->
                            <div>
                                <div class="text-sm text-gray-600 mb-1">Client Satisfaction</div>
                                <div class="flex items-center">
                                    <span class="text-2xl font-semibold">4.8/5</span>
                                    <svg class="w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Project 2 -->
                    <div class="border-b pb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-medium text-lg">Background Art for Episode 5</h3>
                                <div class="flex items-center text-sm text-gray-600 mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    May 10, 2025 • 4 days
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-medium">Anime Artisans</div>
                                <div class="text-sm text-gray-600">Background Art</div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Quality Score -->
                            <div>
                                <div class="text-sm text-gray-600 mb-1">Quality Score</div>
                                <div class="flex items-center">
                                    <span class="text-2xl font-semibold">8.7/10</span>
                                    <svg class="w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Efficiency -->
                            <div>
                                <div class="text-sm text-gray-600 mb-1">Efficiency</div>
                                <div class="flex items-center">
                                    <span class="text-2xl font-semibold">88%</span>
                                    <svg class="w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Client Satisfaction -->
                            <div>
                                <div class="text-sm text-gray-600 mb-1">Client Satisfaction</div>
                                <div class="flex items-center">
                                    <span class="text-2xl font-semibold">4.5/5</span>
                                    <svg class="w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="bg-white rounded-lg p-6 shadow">
                <h2 class="text-xl font-semibold mb-1">Skill Assessment</h2>
                <p class="text-sm text-gray-600 mb-6">Your skill ratings based on project performance</p>

                <div class="space-y-6">
                    <!-- Character Design -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium">Character Design</span>
                            <span class="font-medium">9.4/10</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5 mb-1">
                            <div class="h-2.5 rounded-full" style="width: 94%; background: linear-gradient(90deg, #8B5CF6 0%, #3B82F6 100%)"></div>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Based on 24 projects</span>
                            <span class="text-green-500">+0.3 from last assessment</span>
                        </div>
                    </div>

                    <!-- Background Art -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium">Background Art</span>
                            <span class="font-medium">8.7/10</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5 mb-1">
                            <div class="h-2.5 rounded-full" style="width: 87%; background: linear-gradient(90deg, #8B5CF6 0%, #3B82F6 100%)"></div>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Based on 18 projects</span>
                            <span class="text-green-500">+0.5 from last assessment</span>
                        </div>
                    </div>

                    <!-- Storyboarding -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium">Storyboarding</span>
                            <span class="font-medium">8.9/10</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5 mb-1">
                            <div class="h-2.5 rounded-full" style="width: 89%; background: linear-gradient(90deg, #8B5CF6 0%, #3B82F6 100%)"></div>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Based on 12 projects</span>
                            <span class="text-green-500">+0.4 from last assessment</span>
                        </div>
                    </div>

                    <!-- Coloring -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium">Coloring</span>
                            <span class="font-medium">9.2/10</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5 mb-1">
                            <div class="h-2.5 rounded-full" style="width: 92%; background: linear-gradient(90deg, #8B5CF6 0%, #3B82F6 100%)"></div>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Based on 31 projects</span>
                            <span class="text-green-500">+0.2 from last assessment</span>
                        </div>
                    </div>

                    <!-- Inking -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium">Inking</span>
                            <span class="font-medium">8.5/10</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5 mb-1">
                            <div class="h-2.5 rounded-full" style="width: 85%; background: linear-gradient(90deg, #8B5CF6 0%, #3B82F6 100%)"></div>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Based on 15 projects</span>
                            <span class="text-green-500">+0.6 from last assessment</span>
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
                button.classList.remove('text-purple-600', 'border-b-2', 'border-purple-600');
                button.classList.add('text-gray-500');
            });

            // Add active styling to clicked tab
            document.querySelector(`button[data-tab="${tabName}"]`).classList.remove('text-gray-500');
            document.querySelector(`button[data-tab="${tabName}"]`).classList.add('text-purple-600', 'border-b-2', 'border-purple-600');
        }
    </script>
@endsection

