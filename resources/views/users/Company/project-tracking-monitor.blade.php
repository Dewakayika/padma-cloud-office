@extends('layouts.app')

@section('title', 'Talent Work Monitor - Company')

@section('content')
<div class="sm:ml-64">
    <div class="py-4 space-y-6">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Talent Work Monitor</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Real-time monitoring of your talents' work sessions and projects</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Last Updated</p>
                        <p class="text-sm font-mono text-gray-900 dark:text-white" id="last-updated">--:--:--</p>
                    </div>
                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>



        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Time Today</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white" id="total-time">{{ $todayStats['total_time'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Sessions</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white" id="total-sessions">{{ $todayStats['total_sessions'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Projects</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white" id="total-projects">{{ $todayStats['total_projects'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Active Work Sessions --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Active Work Sessions
                        <span class="ml-2 px-2 py-1 text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full" id="active-sessions-count">0</span>
                    </h2>
                </div>
                <div class="p-6">
                    <div id="active-sessions-list" class="space-y-4">
                        <!-- Active sessions will be populated here -->
                    </div>
                    <div id="no-active-sessions" class="text-center text-gray-500 dark:text-gray-400 py-8">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>No active work sessions</p>
                    </div>
                </div>
            </div>

            {{-- Active Projects --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Active Projects
                        <span class="ml-2 px-2 py-1 text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full" id="active-projects-count">0</span>
                    </h2>
                </div>
                <div class="p-6">
                    <div id="active-projects-list" class="space-y-4">
                        <!-- Active projects will be populated here -->
                    </div>
                    <div id="no-active-projects" class="text-center text-gray-500 dark:text-gray-400 py-8">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <p>No active projects</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Talent List --}}
        <div class="mt-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        All Talents Status
                        <span class="ml-2 px-2 py-1 text-xs font-bold bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 rounded-full">{{ $talents->count() }}</span>
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($talents as $talent)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-800 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $talent->name }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $talent->email }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($talent->workSessions->count() > 0 || $talent->projectTracking->count() > 0)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <p>Sessions: {{ $talent->workSessions->count() }}</p>
                                <p>Projects: {{ $talent->projectTracking->count() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let updateInterval;

    function updateRealTimeData() {
        fetch('{{ route("company.project-tracking.realtime") }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateWorkSessions(data.work_sessions);
                    updateProjects(data.projects);
                    updateLastUpdated();
                }
            })
            .catch(error => {
                console.error('Error fetching real-time data:', error);
            });
    }

    function updateWorkSessions(sessions) {
        const container = document.getElementById('active-sessions-list');
        const noSessions = document.getElementById('no-active-sessions');
        const countElement = document.getElementById('active-sessions-count');

        if (sessions.length === 0) {
            container.innerHTML = '';
            noSessions.style.display = 'block';
            countElement.textContent = '0';
            return;
        }

        noSessions.style.display = 'none';
        countElement.textContent = sessions.length;

        container.innerHTML = sessions.map(session => `
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">${session.user_name}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Session ID: ${session.id}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${
                            session.status === 'active'
                                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
                        }">
                            ${session.status.charAt(0).toUpperCase() + session.status.slice(1)}
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Started:</span>
                        <span class="ml-2 font-mono text-gray-900 dark:text-white">
                            ${new Date(session.started_at).toLocaleString()}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Duration:</span>
                        <span class="ml-2 font-mono font-bold text-blue-600 dark:text-blue-400">
                            ${session.formatted_working_time}
                        </span>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function updateProjects(projects) {
        const container = document.getElementById('active-projects-list');
        const noProjects = document.getElementById('no-active-projects');
        const countElement = document.getElementById('active-projects-count');

        if (projects.length === 0) {
            container.innerHTML = '';
            noProjects.style.display = 'block';
            countElement.textContent = '0';
            return;
        }

        noProjects.style.display = 'none';
        countElement.textContent = projects.length;

        container.innerHTML = projects.map(project => `
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-800 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">${project.user_name}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">${project.project_type}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Active
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Project:</span>
                        <span class="ml-2 font-semibold text-gray-900 dark:text-white">${project.project_title}</span>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function updateLastUpdated() {
        const now = new Date();
        document.getElementById('last-updated').textContent = now.toLocaleTimeString();
    }

    // Initial load
    updateRealTimeData();

    // Set up real-time updates every 5 seconds
    updateInterval = setInterval(updateRealTimeData, 5000);

    // Clean up interval on page unload
    window.addEventListener('beforeunload', function() {
        if (updateInterval) {
            clearInterval(updateInterval);
        }
    });
});
</script>
@endpush
