@extends('layouts.app')
@section('title', 'Company Statistics')
@section('meta_description', 'Padma Cloud Office - Company Statistics')

@section('content')
<div class="sm:ml-64">
    <div class="py-4 px-0 sm:p-6 space-y-6">
        {{-- Header Section with Filters --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <h1 class="text-xl font-medium text-gray-900 dark:text-white">
                    Company Statistics
                </h1>

                <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4">
                    {{-- Filter Controls --}}
                    <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                        <div class="w-full sm:w-48">
                            <select id="year_filter" name="year" class="w-full dark:text-white rounded-lg border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Years</option>
                                @for($i = now()->year; $i >= 2020; $i--)
                                    <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="w-full sm:w-48">
                            <select id="project_type_filter" name="project_type" class="w-full dark:text-white rounded-lg border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Types</option>
                                @foreach($projectTypes as $type)
                                    <option value="{{ $type->id }}" {{ request('project_type') == $type->id ? 'selected' : '' }}>
                                        {{ $type->project_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Overview --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($projectTypeStats as $stat)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $stat->projectType->project_name }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stat->total_projects }}</p>
                    </div>
                    <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-full">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Volume</p>
                    <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $stat->total_volume }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Monthly Completion Trend --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Monthly Completion Trend</h3>
                <div class="h-80">
                    <canvas id="completionTrendChart"></canvas>
                </div>
            </div>

            {{-- Status Distribution --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Project Status Distribution</h3>
                <div class="h-80">
                    <canvas id="statusDistributionChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Completion Time by Project Type --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Average Completion Time by Project Type</h3>
            <div class="h-80">
                <canvas id="completionTimeChart"></canvas>
            </div>
        </div>

        <!-- Talent Statistics -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Talent Performance</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Talent Completion Chart -->
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                    <canvas id="talentChart" height="300"></canvas>
                </div>

                <!-- Talent Stats Table -->
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Talent</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Completed</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">In Progress</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Avg. Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach($talentStats as $talent)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $talent->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $talent->completed_projects }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $talent->in_progress_projects }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                        @php
                                            $seconds = $talent->avg_completion_time ? abs($talent->avg_completion_time * 60) : 0;
                                            $days = floor($seconds / (24 * 3600));
                                            $hours = floor(($seconds % (24 * 3600)) / 3600);
                                            $minutes = floor(($seconds % 3600) / 60);
                                            $secs = $seconds % 60;
                                        @endphp
                                        @if($talent->avg_completion_time && $seconds > 0)
                                            {{ $days }}d {{ $hours }}h {{ $minutes }}m {{ $secs }}s
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dark mode detection
        const isDarkMode = document.documentElement.classList.contains('dark');

        // Fungsi observer untuk reload jika mode berubah
        const observer = new MutationObserver(() => {
            const currentDark = document.documentElement.classList.contains('dark');
            if (currentDark !== isDarkMode) {
                window.location.reload();
            }
        });

        // Observe class pada html (documentElement)
        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });

        // Color schemes for light and dark mode
        const colors = {
            light: {
                background: 'rgba(255, 255, 255, 0.95)',
                border: 'rgba(75, 192, 192, 0.2)',
                text: '#000000',
                secondaryText: '#4B5563',
                grid: 'rgba(0, 0, 0, 0.08)',
                tooltip: {
                    background: 'rgba(255, 255, 255, 0.98)',
                    text: '#000000',
                    border: 'rgba(75, 192, 192, 0.2)'
                },
                bar: {
                    gradient: {
                        start: 'rgba(75, 192, 192, 0.8)',
                        end: 'rgba(75, 192, 192, 0.6)'
                    },
                    border: 'rgba(75, 192, 192, 0.9)'
                }
            },
            dark: {
                background: 'rgba(17, 24, 39, 0.95)',
                border: 'rgba(75, 192, 192, 0.3)',
                text: '#FFFFFF',
                secondaryText: '#9CA3AF',
                grid: 'rgba(255, 255, 255, 0.08)',
                tooltip: {
                    background: 'rgba(17, 24, 39, 0.98)',
                    border: 'rgba(75, 192, 192, 0.3)',
                    text: '#FFFFFF'
                },
                bar: {
                    gradient: {
                        start: 'rgba(75, 192, 192, 0.7)',
                        end: 'rgba(75, 192, 192, 0.5)'
                    },
                    border: 'rgba(75, 192, 192, 0.8)'
                }
            }
        };

        const currentColors = isDarkMode ? colors.dark : colors.light;
        const figtreeFont = {
            size: 12,
            weight: '500',
            family: 'Figtree'
        };

        // Create gradient for bars
        function createGradient(ctx, startColor, endColor) {
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, startColor);
            gradient.addColorStop(1, endColor);
            return gradient;
        }

        // Monthly Chart
        const monthlyCtx = document.getElementById('completionTrendChart').getContext('2d');
        const monthlyGradient = createGradient(monthlyCtx, currentColors.bar.gradient.start, currentColors.bar.gradient.end);

        const monthlyChart = new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Completed Projects',
                    data: @json(array_values($monthlyStats)),
                    backgroundColor: monthlyGradient,
                    barThickness: 24,
                    maxBarThickness: 32
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: currentColors.tooltip.background,
                        titleColor: currentColors.tooltip.text,
                        bodyColor: currentColors.tooltip.text,
                        borderColor: currentColors.tooltip.border,
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: context => `Completed: ${context.raw} projects`
                        },
                        titleFont: figtreeFont,
                        bodyFont: figtreeFont
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: currentColors.grid, drawBorder: false },
                        ticks: { color: currentColors.secondaryText, font: figtreeFont, padding: 8 }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: currentColors.text, font: figtreeFont, padding: 8 }
                    }
                }
            }
        });

        // Status Chart
        const statusCtx = document.getElementById('statusDistributionChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: @json($statusDistribution->pluck('status')),
                datasets: [{
                    data: @json($statusDistribution->pluck('count')),
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(54, 162, 235, 0.8)'
                    ],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: currentColors.text,
                            padding: 20,
                            font: figtreeFont,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: currentColors.tooltip.background,
                        titleColor: currentColors.tooltip.text,
                        bodyColor: currentColors.tooltip.text,
                        padding: 12,
                        displayColors: true,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        titleFont: figtreeFont,
                        bodyFont: figtreeFont
                    }
                }
            }
        });

        // Completion Time Chart
        const timeCtx = document.getElementById('completionTimeChart').getContext('2d');
        const timeGradient = createGradient(timeCtx, currentColors.bar.gradient.start, currentColors.bar.gradient.end);

        const timeChart = new Chart(timeCtx, {
            type: 'bar',
            data: {
                labels: @json($completionTimeByType->pluck('project.projectType.name')),
                datasets: [{
                    label: 'Average Completion Time',
                    data: @json($completionTimeByType->pluck('avg_time')),
                    backgroundColor: timeGradient,
                    barThickness: 24,
                    maxBarThickness: 32
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: currentColors.tooltip.background,
                        titleColor: currentColors.tooltip.text,
                        bodyColor: currentColors.tooltip.text,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: context => {
                                const minutes = Math.round(context.raw);
                                const hours = Math.floor(minutes / 60);
                                const remainingMinutes = minutes % 60;
                                return `Average: ${hours}h ${remainingMinutes}m`;
                            }
                        },
                        titleFont: figtreeFont,
                        bodyFont: figtreeFont
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: currentColors.grid, drawBorder: false },
                        ticks: {
                            color: currentColors.secondaryText,
                            font: figtreeFont,
                            padding: 8,
                            callback: value => {
                                const hours = Math.floor(value / 60);
                                const minutes = value % 60;
                                return `${hours}h ${minutes}m`;
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: currentColors.text, font: figtreeFont, padding: 8 }
                    }
                }
            }
        });

        // Talent Chart
        const talentCtx = document.getElementById('talentChart').getContext('2d');
        const talentGradient = createGradient(talentCtx, currentColors.bar.gradient.start, currentColors.bar.gradient.end);

        const talentChart = new Chart(talentCtx, {
            type: 'bar',
            data: {
                labels: @json($talentStats->pluck('name')),
                datasets: [{
                    label: 'Completed Projects',
                    data: @json($talentStats->pluck('completed_projects')),
                    backgroundColor: talentGradient,
                    borderColor: currentColors.bar.border,
                    barThickness: 24,
                    maxBarThickness: 32
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: currentColors.tooltip.background,
                        titleColor: currentColors.tooltip.text,
                        bodyColor: currentColors.tooltip.text,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: context => `Completed: ${context.raw} projects`
                        },
                        titleFont: figtreeFont,
                        bodyFont: figtreeFont
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: currentColors.grid, drawBorder: false },
                        ticks: { color: currentColors.secondaryText, font: figtreeFont, padding: 8 }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: currentColors.text, font: figtreeFont, padding: 8 }
                    }
                }
            }
        });

        // Theme switching
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            const newColors = e.matches ? colors.dark : colors.light;
            const newMonthlyGradient = createGradient(monthlyCtx, newColors.bar.gradient.start, newColors.bar.gradient.end);
            const newTimeGradient = createGradient(timeCtx, newColors.bar.gradient.start, newColors.bar.gradient.end);
            const newTalentGradient = createGradient(talentCtx, newColors.bar.gradient.start, newColors.bar.gradient.end);

            [monthlyChart, statusChart, timeChart, talentChart].forEach(chart => {
                chart.options.scales.y.ticks.color = newColors.secondaryText;
                chart.options.scales.x.ticks.color = newColors.text;
                chart.options.scales.y.grid.color = newColors.grid;
                chart.options.plugins.tooltip.backgroundColor = newColors.tooltip.background;
                chart.options.plugins.tooltip.titleColor = newColors.tooltip.text;
                chart.options.plugins.tooltip.bodyColor = newColors.tooltip.text;
                chart.options.plugins.tooltip.borderColor = newColors.tooltip.border;

                if (chart.options.plugins.legend) {
                    chart.options.plugins.legend.labels.color = newColors.text;
                }

                if (chart === monthlyChart) {
                    chart.data.datasets[0].backgroundColor = newMonthlyGradient;
                    chart.data.datasets[0].borderColor = newColors.bar.border;
                } else if (chart === timeChart) {
                    chart.data.datasets[0].backgroundColor = newTimeGradient;
                    chart.data.datasets[0].borderColor = newColors.bar.border;
                } else if (chart === talentChart) {
                    chart.data.datasets[0].backgroundColor = newTalentGradient;
                    chart.data.datasets[0].borderColor = newColors.bar.border;
                }

                chart.update();
            });
        });


        // Filter
        const yearFilter = document.getElementById('year_filter');
        const projectTypeFilter = document.getElementById('project_type_filter');

        function applyFilters() {
            const year = yearFilter.value;
            const projectType = projectTypeFilter.value;
            const url = new URL(window.location.href);

            year ? url.searchParams.set('year', year) : url.searchParams.delete('year');
            projectType ? url.searchParams.set('project_type', projectType) : url.searchParams.delete('project_type');

            window.location.href = url.toString();
        }

        yearFilter.addEventListener('change', applyFilters);
        projectTypeFilter.addEventListener('change', applyFilters);
    });
</script>

@endpush

@endsection
