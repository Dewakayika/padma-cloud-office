@extends('layouts.app')
@section('title', 'Dashboard')
@section('meta_description', 'Padma Cloud Office')

@section('content')

<div class="sm:ml-64">
    <div class="p-4 sm:p-6 space-y-6">
        {{-- Header Section with Filters --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <h1 class="text-xl font-medium text-gray-900 dark:text-white">
                    Good to see you, {{ Auth::user()->name }}!
                </h1>

                <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4">
                    {{-- Filter Controls --}}
                    <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                        <div class="w-full sm:w-48">
                            <select id="year_filter" name="year" class="w-full rounded-lg dark:text-white border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-sm focus:border-indigo-500 focus:ring-indigo-500">
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

                    {{-- New Project Button --}}
                    <div x-data="{ openEdit: false }">
                        <button @click="openEdit = true" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                                <path d="M6 3a3 3 0 0 0-3 3v2.25a3 3 0 0 0 3 3h2.25a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H6ZM15.75 3a3 3 0 0 0-3 3v2.25a3 3 0 0 0 3 3H18a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3h-2.25ZM6 12.75a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h2.25a3 3 0 0 0 3-3v-2.25a3 3 0 0 0-3-3H6ZM17.625 13.5a.75.75 0 0 0-1.5 0v2.625H13.5a.75.75 0 0 0 0 1.5h2.625v2.625a.75.75 0 0 0 1.5 0v-2.625h2.625a.75.75 0 0 0 0-1.5h-2.625V13.5Z" />
                            </svg>
                            New Project
                        </button>

                        {{-- Modal --}}
                        <div x-show="openEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                            <div @click.outside="openEdit = false" class="bg-white dark:bg-gray-800 rounded-xl w-full max-w-3xl shadow-xl">
                                @include('components.create-project', ['projectTypes' => $projectTypes, 'talents' => $talents, 'company' => $company])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alert Messages --}}
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

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Project Serving Time --}}
            <x-score-card
                title="Project Serving Time"
                :value="$averageServingTime . ' hours'"
                iconColor="text-green-500"
                bgColor="bg-green-50 dark:bg-green-900/20">
                <x-slot name="icon">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                    </svg>
                </x-slot>
            </x-score-card>

            {{-- Total Projects --}}
            <x-score-card
                title="Total Project"
                :value="$totalProjects"
                iconColor="text-blue-500"
                bgColor="bg-blue-50 dark:bg-blue-900/20">
                <x-slot name="icon">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" />
                    </svg>
                </x-slot>
            </x-score-card>

            {{-- Total Project Volume --}}
            <x-score-card
                title="Total Project Volume"
                :value="$totalVolume"
                iconColor="text-yellow-500"
                bgColor="bg-yellow-50 dark:bg-yellow-900/20">
                <x-slot name="icon">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z" />
                    </svg>
                </x-slot>
            </x-score-card>

            {{-- Total On Going Project --}}
            <x-score-card
                title="Total On Going Project"
                :value="$onGoingProjects"
                iconColor="text-red-500"
                bgColor="bg-red-50 dark:bg-red-900/20">
                <x-slot name="icon">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.25 4.533A9.707 9.707 0 006 3a9.735 9.735 0 00-3.25.555.75.75 0 00-.5.707v14.25a.75.75 0 001 .707A8.237 8.237 0 016 18.75c1.995 0 3.823.707 5.25 1.886V4.533zM12.75 20.636A8.214 8.214 0 0118 18.75c.966 0 1.89.166 2.75.47a.75.75 0 001-.708V4.262a.75.75 0 00-.5-.707A9.735 9.735 0 0018 3a9.707 9.707 0 00-5.25 1.533v16.103z" />
                    </svg>
                </x-slot>
            </x-score-card>
        </div>

        {{-- Charts and Stats Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Project Completion Chart --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Project Completion Trend</h3>
                <div class="h-80">
                    <canvas id="completionChart"></canvas>
                </div>
            </div>

            {{-- On Going Projects --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">On Going Projects</h3>
                <div class="space-y-3">
                    {{-- Project Status Cards --}}
                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                        <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-yellow-100 dark:bg-yellow-900/50 text-yellow-500 flex items-center justify-center">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div class="flex-grow ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Waiting Talent</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Waiting Talent approved Project</p>
                        </div>
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $onGoingProjects['waiting talent'] ?? 0 }}</span>
                    </div>

                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                        <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/50 text-blue-500 flex items-center justify-center">
                            <i class="fas fa-chess-knight"></i>
                        </div>
                        <div class="flex-grow ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Project Assign</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Project Applied, still working on it</p>
                        </div>
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $onGoingProjects['Project Assign'] ?? 0 }}</span>
                    </div>

                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                        <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-orange-100 dark:bg-orange-900/50 text-orange-500 flex items-center justify-center">
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                        <div class="flex-grow ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Project QC</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Waiting QC agent check the project</p>
                        </div>
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $onGoingProjects['Project QC'] ?? 0 }}</span>
                    </div>

                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                        <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/50 text-red-500 flex items-center justify-center">
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="flex-grow ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Project Revision</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Revision note release by admin</p>
                        </div>
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $onGoingProjects['Revision'] ?? 0 }}</span>
                    </div>

                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                        <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/50 text-green-500 flex items-center justify-center">
                            <i class="fas fa-thumbs-up"></i>
                        </div>
                        <div class="flex-grow ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Project Completed</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Number of project completed</p>
                        </div>
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $onGoingProjects['Done'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Projects Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Recent Projects</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 dark:text-gray-400 uppercase bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Project Name</th>
                                <th scope="col" class="px-6 py-3">Project Type</th>
                                <th scope="col" class="px-6 py-3">QC Agent</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                                <th scope="col" class="px-6 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($projects as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{$item->project_name}}</td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{$item->projectType->project_name}}</td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $item->qcAgent->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @switch($item->status)
                                            @case('Waiting Talent')
                                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">
                                                    Waiting Talent
                                                </span>
                                                @break
                                            @case('Project Assign')
                                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                                                    Project Assign
                                                </span>
                                                @break
                                            @case('Project Draft')
                                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-300">
                                                    Project Draft
                                                </span>
                                                @break
                                            @case('Revision')
                                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300">
                                                    Revision
                                                </span>
                                                @break
                                            @case('Done')
                                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                                                    Done
                                                </span>
                                                @break
                                            @default
                                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-300">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 text-center space-x-2">
                                        <a href="#" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-1">
                                                <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM12.75 12a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V18a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V12Z" clip-rule="evenodd" />
                                            </svg>
                                            Edit
                                        </a>
                                        <a href="#" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-1">
                                                <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                                            </svg>
                                            Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No projects available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Filter functionality
    const yearFilter = document.getElementById('year_filter');
    const projectTypeFilter = document.getElementById('project_type_filter');

    function applyFilters() {
        const year = yearFilter.value;
        const projectType = projectTypeFilter.value;

        let url = new URL(window.location.href);

        if (year) {
            url.searchParams.set('year', year);
        } else {
            url.searchParams.delete('year');
        }

        if (projectType) {
            url.searchParams.set('project_type', projectType);
        } else {
            url.searchParams.delete('project_type');
        }

        window.location.href = url.toString();
    }

    // Add event listeners
    yearFilter.addEventListener('change', applyFilters);
    projectTypeFilter.addEventListener('change', applyFilters);

    // Initialize charts with filtered data
    document.addEventListener('DOMContentLoaded', function() {
        const completionCtx = document.getElementById('completionChart').getContext('2d');
        const monthlyStats = @json($monthlyStats);
        const projectTypes = @json($projectTypes);
        const currentProjectType = @json(request('project_type'));

        // Check if dark mode is enabled
        const isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

        // Create array for all months
        const allMonths = Array.from({length: 12}, (_, i) => {
            const month = i + 1;
            return {
                month: month,
                count: monthlyStats[month]?.count || 0
            };
        });

        // iOS-style gradients for different project types
        const gradients = {};
        const colors = isDarkMode ? [
            { start: 'rgba(10, 132, 255, 0.9)', end: 'rgba(10, 132, 255, 0.5)' },    // iOS Blue (Dark)
            { start: 'rgba(48, 209, 88, 0.9)', end: 'rgba(48, 209, 88, 0.5)' },      // iOS Green (Dark)
            { start: 'rgba(255, 159, 10, 0.9)', end: 'rgba(255, 159, 10, 0.5)' },    // iOS Orange (Dark)
            { start: 'rgba(255, 69, 58, 0.9)', end: 'rgba(255, 69, 58, 0.5)' },      // iOS Red (Dark)
            { start: 'rgba(191, 90, 242, 0.9)', end: 'rgba(191, 90, 242, 0.5)' }     // iOS Purple (Dark)
        ] : [
            { start: 'rgba(0, 122, 255, 0.8)', end: 'rgba(0, 122, 255, 0.4)' },      // iOS Blue
            { start: 'rgba(52, 199, 89, 0.8)', end: 'rgba(52, 199, 89, 0.4)' },      // iOS Green
            { start: 'rgba(255, 149, 0, 0.8)', end: 'rgba(255, 149, 0, 0.4)' },      // iOS Orange
            { start: 'rgba(255, 59, 48, 0.8)', end: 'rgba(255, 59, 48, 0.4)' },      // iOS Red
            { start: 'rgba(175, 82, 222, 0.8)', end: 'rgba(175, 82, 222, 0.4)' }     // iOS Purple
        ];

        projectTypes.forEach((type, index) => {
            const gradient = completionCtx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, colors[index % colors.length].start);
            gradient.addColorStop(1, colors[index % colors.length].end);
            gradients[type.id] = gradient;
        });

        // Prepare datasets based on whether a project type is selected
        let datasets;
        if (currentProjectType) {
            // Single dataset for selected project type
            datasets = [{
                label: 'Completed Projects',
                data: allMonths.map(item => item.count),
                backgroundColor: gradients[currentProjectType] || gradients[projectTypes[0]?.id],
                borderColor: isDarkMode ? 'rgba(255, 255, 255, 0.3)' : 'rgba(255, 255, 255, 0.2)',
                borderWidth: 1,
                borderRadius: 12,
                barThickness: 20,
                maxBarThickness: 24,
                minBarLength: 4
            }];
        } else {
            // Multiple datasets for all project types
            datasets = projectTypes.map(type => ({
                label: type.project_name,
                data: allMonths.map(item => {
                    const typeStats = monthlyStats[item.month]?.types || {};
                    return typeStats[type.id] || 0;
                }),
                backgroundColor: gradients[type.id],
                borderColor: isDarkMode ? 'rgba(255, 255, 255, 0.3)' : 'rgba(255, 255, 255, 0.2)',
                borderWidth: 1,
                borderRadius: 12,
                barThickness: 20,
                maxBarThickness: 24,
                minBarLength: 4
            }));
        }

        new Chart(completionCtx, {
            type: 'bar',
            data: {
                labels: allMonths.map(item => {
                    const date = new Date();
                    date.setMonth(item.month - 1);
                    return date.toLocaleString('default', { month: 'short' });
                }),
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        stacked: !currentProjectType,
                        grid: {
                            display: true,
                            drawBorder: false,
                            color: isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                            lineWidth: 1,
                            drawTicks: false
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 13,
                                family: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif'
                            },
                            color: isDarkMode ? 'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.7)',
                            padding: 10
                        }
                    },
                    x: {
                        stacked: !currentProjectType,
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 13,
                                family: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif'
                            },
                            color: isDarkMode ? 'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.7)',
                            padding: 10
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: !currentProjectType,
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 12,
                            padding: 20,
                            font: {
                                size: 13,
                                family: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif'
                            },
                            color: isDarkMode ? 'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.7)',
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: isDarkMode ? 'rgba(0, 0, 0, 0.8)' : 'rgba(255, 255, 255, 0.95)',
                        titleColor: isDarkMode ? '#fff' : '#000',
                        bodyColor: isDarkMode ? 'rgba(255, 255, 255, 0.7)' : '#666',
                        borderColor: isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 10,
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
