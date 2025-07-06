@extends('layouts.app')

@section('content')
<div class="sm:ml-64">
    <div class="py-4 space-y-6">
        {{-- Basic Information Section --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Basic Information</h2>
                <a href="{{ route('company.manage.talents') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Talents
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img class="h-20 w-20 rounded-full ring-4 ring-purple-100 dark:ring-purple-900" src="{{ $talent->profile_photo_url }}" alt="{{ $talent->name }}">
                        <span class="absolute bottom-0 right-0 block h-4 w-4 rounded-full ring-2 ring-white dark:ring-gray-800
                            {{ $talent->companyTalent->first()->job_role === 'talent' ? 'bg-green-400' : 'bg-blue-400' }}">
                        </span>
                    </div>
                    <div>
                        <h3 class="text-xl font-medium text-gray-900 dark:text-gray-100">{{ $talent->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $talent->email }}
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Job Role</p>
                        </div>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ ucfirst($talent->companyTalent->first()->job_role) }}
                        </p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Phone Number</p>
                        </div>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ $talent->talent->phone_number ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Gender</p>
                        </div>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ $talent->talent->gender ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Date of Birth</p>
                        </div>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{-- {{ $talent->talent->date_of_birth ? date('F j, Y', strtotime($talent->talent->date_of_birth)) : 'N/A' }} --}}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Project Statistics Section --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Project Statistics</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-purple-100 dark:bg-purple-900 opacity-50"></div>
                    <div class="relative">
                        <div class="flex items-center mb-2">
                            <svg class="w-6 h-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Projects</p>
                        </div>
                        <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $projectStats['total'] }}</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-green-100 dark:bg-green-900 opacity-50"></div>
                    <div class="relative">
                        <div class="flex items-center mb-2">
                            <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Completed</p>
                        </div>
                        <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $projectStats['completed'] }}</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-blue-100 dark:bg-blue-900 opacity-50"></div>
                    <div class="relative">
                        <div class="flex items-center mb-2">
                            <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">In Progress</p>
                        </div>
                        <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $projectStats['in_progress'] }}</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-yellow-100 dark:bg-yellow-900 opacity-50"></div>
                    <div class="relative">
                        <div class="flex items-center mb-2">
                            <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">In QC</p>
                        </div>
                        <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $projectStats['in_qc'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Average Completion Time Section --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Average Completion Time</h2>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                <div>
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Average Completion Time</p>
                    </div>
                    <p class="text-3xl font-medium text-gray-900 dark:text-gray-100">
                        @if($formattedCompletionTime)
                            {{ $formattedCompletionTime['days'] }}d
                            {{ $formattedCompletionTime['hours'] }}h
                            {{ $formattedCompletionTime['minutes'] }}m
                            {{ $formattedCompletionTime['seconds'] }}s
                            <span class="ml-1 cursor-help" title="Formula: Total Time of All Completed Projects \xF7 Number of Completed Projects\nWhere:\n- Total Time = Sum of (Last Log Timestamp - First Log Created At) for each completed project\n- Number of Completed Projects = Count of projects with status 'done'">ⓘ</span>
                        @else
                            N/A
                        @endif
                    </p>
                    @if($formattedCompletionTime)
                        <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white dark:bg-gray-600 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Time</p>
                                </div>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ floor($formattedCompletionTime['total_seconds'] / 3600) }} hours
                                </p>
                            </div>
                            <div class="bg-white dark:bg-gray-600 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Projects</p>
                                </div>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $formattedCompletionTime['total_projects'] }}
                                </p>
                            </div>
                            <div class="bg-white dark:bg-gray-600 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Fastest</p>
                                </div>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ floor($formattedCompletionTime['min_seconds'] / 3600) }} hours
                                </p>
                            </div>
                            <div class="bg-white dark:bg-gray-600 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Slowest</p>
                                </div>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ floor($formattedCompletionTime['max_seconds'] / 3600) }} hours
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Monthly Project Completion Chart Section --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center mb-6">
                <svg class="w-6 h-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Monthly Project Completion</h2>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                <canvas id="monthlyChart" class="w-full h-64"></canvas>
            </div>
        </div>

        {{-- Recent Projects Section --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center mb-6">
                <svg class="w-6 h-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Recent Projects</h2>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-600">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Project Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Completion Time</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                            @forelse($recentProjects as $project)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $project->project_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $project->projectType->project_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $project->status === 'done' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                                               ($project->status === 'qc' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' :
                                               'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200') }}">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        @if($project->formatted_completion_time)
                                            {{ $project->formatted_completion_time['days'] }}d
                                            {{ $project->formatted_completion_time['hours'] }}h
                                            {{ $project->formatted_completion_time['minutes'] }}m
                                            {{ $project->formatted_completion_time['seconds'] }}s
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                        No recent projects found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyData = @json($monthlyStats);

        // Check if dark mode is enabled
        const isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(monthlyData).map(month => {
                    const date = new Date(2024, month - 1);
                    return date.toLocaleString('default', { month: 'short' });
                }),
                datasets: [{
                    label: 'Completed Projects',
                    data: Object.values(monthlyData),
                    backgroundColor: isDarkMode ? 'rgba(147, 51, 234, 0.5)' : 'rgba(147, 51, 234, 0.7)',
                    borderColor: isDarkMode ? 'rgba(147, 51, 234, 1)' : 'rgba(147, 51, 234, 0.9)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: isDarkMode ? 'rgba(255, 255, 255, 0.7)' : '#374151',
                            font: {
                                size: 13,
                                family: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif'
                            }
                        },
                        grid: {
                            color: isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        ticks: {
                            color: isDarkMode ? 'rgba(255, 255, 255, 0.7)' : '#374151',
                            font: {
                                size: 13,
                                family: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: isDarkMode ? 'rgba(255, 255, 255, 0.7)' : '#374151',
                            font: {
                                size: 13,
                                family: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif'
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: isDarkMode ? 'rgba(0, 0, 0, 0.8)' : 'rgba(255, 255, 255, 0.95)',
                        titleColor: isDarkMode ? '#fff' : '#111827',
                        bodyColor: isDarkMode ? 'rgba(255, 255, 255, 0.7)' : '#4B5563',
                        borderColor: isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true,
                        boxWidth: 12,
                        boxHeight: 12,
                        usePointStyle: true,
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw} projects`;
                            }
                        }
                    }
                },
                animation: {
                    duration: 750,
                    easing: 'easeInOutQuart'
                }
            }
        });

        // Listen for dark mode changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            // Reload the page to update the chart colors
            window.location.reload();
        });
    });
</script>
@endpush
@endsection
