@extends('layouts.app')
@section('title', 'Project Tracking')
@section('meta_description', 'Track your work sessions and manage projects')

@section('content')
<div class="sm:ml-64">
    <div class="py-4 space-y-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                Project Tracking - {{ Auth::user()->name }}
            </h1>
            <div class="flex items-center gap-2">
                <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                    </svg>
                    View History
                </button>
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

        {{-- Timezone Info --}}
        <div class="bg-green-50 border border-green-200 rounded-lg p-3 dark:bg-green-900/20 dark:border-green-800">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium text-green-800 dark:text-green-200">
                        Your Timezone: <span data-timezone-display>{{ session('timezone', Auth::user()->timezone ?? 'UTC') }}</span>
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-sm text-green-700 dark:text-green-300">Current Time</p>
                    <p class="text-sm font-mono font-semibold text-green-800 dark:text-green-200" data-current-time>
                        {{ now()->format('H:i:s') }}
                    </p>
                </div>
            </div>

        </div>

        {{-- Main Tracking Interface --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column: Stopwatch & Controls --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Stopwatch Display --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Work Timer</h2>
                        <div class="text-6xl font-mono font-bold text-gray-900 dark:text-white mb-6" id="stopwatch-display">
                            00:00:00
                        </div>
                        <div id="timer-status" class="text-lg text-gray-600 dark:text-gray-400 font-medium mb-4">
                            Status: ready
                        </div>

                        {{-- Control Buttons --}}
                        <div class="flex justify-center space-x-4 mb-6">
                            {{-- Start Work Button --}}
                            @if(!$currentWorkSession || $currentWorkSession->status === 'completed')
                            <form action="{{ route('talent.work-session.start') }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-lg font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Start Work
                                </button>
                            </form>
                            @endif

                            {{-- Pause Button --}}
                            @if($currentWorkSession && $currentWorkSession->status === 'active')
                                <div x-data="{ openPause: false }">
                                <button @click="openPause = true" class="inline-flex items-center px-6 py-3 bg-yellow-600 border border-transparent rounded-lg font-semibold text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                        Pause Work
                                </button>

                                <!-- Pause Modal -->
                                    <div x-show="openPause" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
                                    <div @click.outside="openPause = false" class="bg-white dark:bg-gray-800 p-6 rounded-xl w-full max-w-md shadow-xl">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pause Work Session</h3>
                                        <form action="{{ route('talent.work-session.pause') }}" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <label for="pause_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reason for pause</label>
                                                <textarea id="pause_reason" name="pause_reason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter reason for pause..." required></textarea>
                                            </div>
                                            <div class="flex justify-end space-x-3">
                                                <button type="button" @click="openPause = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-lg hover:bg-yellow-700">
                                                    Pause
                                                </button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Resume Button --}}
                            @if($currentWorkSession && $currentWorkSession->status === 'paused')
                            <form action="{{ route('talent.work-session.resume') }}" method="POST">
                                    @csrf
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Resume
                            </button>
                                </form>
                            @endif

                            {{-- End Work Button --}}
                            @if($currentWorkSession && in_array($currentWorkSession->status, ['active', 'paused']))
                            <form action="{{ route('talent.work-session.end') }}" method="POST">
                                    @csrf
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-lg font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                End Work
                            </button>
                                </form>
                            @endif
                        </div>

                        {{-- Session Info --}}
                        @if($currentWorkSession)
                        <div class="text-left bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Session Details</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Started:</span>
                                    <span class="ml-2 font-mono text-gray-900 dark:text-white" data-utc-time="{{ $currentWorkSession->started_at ? $currentWorkSession->started_at->toISOString() : '' }}">
                                        {{ $currentWorkSession->started_at ? \App\Helpers\TimezoneHelper::formatForDisplay($currentWorkSession->started_at, 'M d, H:i', $timezone) : 'N/A' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Status:</span>
                                    <span class="ml-2 text-gray-900 dark:text-white">
                                        {{ ucfirst($currentWorkSession->status) }}
                                    </span>
                                </div>
                                @if($currentWorkSession->status === 'paused' && $currentWorkSession->pause_reason)
                                <div class="col-span-2">
                                    <span class="text-gray-600 dark:text-gray-400">Pause Reason:</span>
                                    <span class="ml-2 text-gray-900 dark:text-white">{{ $currentWorkSession->pause_reason }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Project Management --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Project Management</h3>
                        <div x-data="{ openNewProject: false }">
                            <button @click="openNewProject = true" class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                New Project

                            </button

                            <!-- New Project Modal -->
                            <div x-show="openNewProject" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
                                <div @click.outside="openNewProject = false" class="bg-white dark:bg-gray-800 p-6 rounded-xl w-full max-w-lg shadow-xl max-h-[90vh] overflow-y-auto">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Start New Project</h3>
                                    <form action="{{ route('talent.project.start') }}" method="POST">
                                        @csrf
                                        <div class="space-y-4">
                                            <div>
                                            {{-- drop down project type text --}}
                                                <label for="project_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project Type *</label>
                                                <input type="text" id="project_type" name="project_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter project type" required>
                                            </div>
                                            <div>
                                                <label for="project_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project Title *</label>
                                                <input type="text" id="project_title" name="project_title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter project title" required>
                                            </div>
                                            <div>
                                                <label for="project_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project Code</label>
                                                <input type="text" id="project_code" name="project_code" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="e.g., PRJ-001">
                                            </div>
                                            <div>
                                                <label for="project_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project Link</label>
                                                <input type="url" id="project_link" name="project_link" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="https://example.com">
                                            </div>
                                            <div>
                                                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role *</label>
                                                <select id="role" name="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                                    <option value="">Select role</option>
                                                    <option value="talent">Talent</option>
                                                    <option value="talent_qc">Talent QC</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                                                <textarea id="notes" name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Additional notes..."></textarea>
                                            </div>
                                        </div>
                                        <div class="flex justify-end space-x-3 mt-6">
                                            <button type="button" @click="openNewProject = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                                                Cancel
                                            </button>
                                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700">
                                                Start Project
                            </button>
                                        </div>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>

                    {{-- Active Projects --}}
                    @if($activeProjects->count() > 0)
                    <div class="space-y-4">
                        <h4 class="text-md font-semibold text-gray-900 dark:text-white">Active Projects</h4>
                        @foreach($activeProjects as $project)
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <h5 class="font-medium text-green-900 dark:text-green-200">{{ $project->project_title }}</h5>
                                    <p class="text-sm text-green-700 dark:text-green-300">{{ $project->project_type }}</p>
                                    @if($project->project_code)
                                    <p class="text-xs text-green-600 dark:text-green-400">Code: {{ $project->project_code }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-2">
                                    <form action="{{ route('talent.project.end', $project->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-lg font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors text-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        End Project
                                    </button>
                                </form>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="text-green-700 dark:text-green-300">Started:</span>
                                    <span class="ml-2 font-mono text-green-900 dark:text-green-200">
                                        {{ \App\Helpers\TimezoneHelper::formatForDisplay($project->start_at, 'M d, H:i', $timezone) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-green-700 dark:text-green-300">Role:</span>
                                    <span class="ml-2 text-green-900 dark:text-green-200">
                                        {{ ucfirst(str_replace('_', ' ', $project->role)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                                        @endif

                    {{-- Recent Completed Projects --}}
                    @if($recentProjects->count() > 0)
                    <div class="mt-6">
                        <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">Recent Completed Projects</h4>
                        <div class="space-y-3">
                            @foreach($recentProjects as $project)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <h5 class="font-medium text-gray-900 dark:text-white text-sm">{{ $project->project_title }}</h5>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $project->project_type }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        Completed
                                    </span>
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">
                                    @if($project->working_duration)
                                        <span class=" text-yellow-600 dark:text-yellow-200 text-xs bg-yellow-100 dark:bg-yellow-700 rounded-lg p-1 px-2">Working Duration: ({{ $project->formatted_working_duration }})</span>
                                            @endif
                                    </div>
                            </div>
                            @endforeach
                        </div>
                        </div>
                            @endif

                    @if($activeProjects->count() === 0 && $recentProjects->count() === 0)
                    <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        <p class="text-lg font-medium">No projects yet</p>
                        <p class="text-sm mt-1">Start your first project to see it here</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Right Column: Stats --}}
            <div class="space-y-6">
                {{-- Quick Stats --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Today's Summary</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Time:</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white" id="today-total">{{ $todayStats['total_time'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Sessions:</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white" id="today-sessions">{{ $todayStats['total_sessions'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Work Sessions:</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $todayStats['work_sessions'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Projects:</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $todayStats['projects'] }}</span>
                        </div>
                    </div>
                </div>

                {{-- Current Session Info --}}
                @if($currentWorkSession)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Current Session</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Status:</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ ucfirst($currentWorkSession->status) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Started:</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white" data-utc-time="{{ $currentWorkSession->started_at->toISOString() }}">
                                {{ \App\Helpers\TimezoneHelper::formatForDisplay($currentWorkSession->started_at, 'M d, H:i', $timezone) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Duration:</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white" id="current-duration">
                                {{ $currentWorkSession->formatted_working_time }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

{{-- Timer Script --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const currentWorkSession = @json($currentWorkSession ?? null);
    const stopwatchDisplay = document.getElementById("stopwatch-display");
    const statusDisplay = document.getElementById("timer-status");
    const currentDuration = document.getElementById("current-duration");

    console.log('=== TIMER DEBUG START ===');
    console.log('Current work session:', currentWorkSession);

    if (currentWorkSession && currentWorkSession.status && currentWorkSession.started_at) {
        console.log('Starting timer with:', {
            started_at: currentWorkSession.started_at,
            status: currentWorkSession.status,
            total_paused_time: currentWorkSession.total_paused_time,
            paused_at: currentWorkSession.paused_at
        });

        // Get the detected timezone
        const detectedTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        console.log('Detected timezone for timer:', detectedTimezone);

        // Convert UTC timestamps to local timezone for accurate calculation
        const startTimeLocal = new Date(currentWorkSession.started_at);
        const pausedAtLocal = currentWorkSession.paused_at ? new Date(currentWorkSession.paused_at) : null;

        console.log('Converted times:', {
            original_start: currentWorkSession.started_at,
            local_start: startTimeLocal,
            original_paused: currentWorkSession.paused_at,
            local_paused: pausedAtLocal
        });

        startTimer(startTimeLocal, currentWorkSession.status, currentWorkSession.total_paused_time, pausedAtLocal);
    } else {
        console.log('No active session found');
        stopwatchDisplay.textContent = '00:00:00';
        updateStatusDisplay('ready');
    }

    function startTimer(startTimestamp, currentStatus, totalPausedTime = 0, pausedAt = null) {
        console.log('startTimer called with:', {
            startTimestamp,
            currentStatus,
            totalPausedTime,
            pausedAt
        });

        if (!startTimestamp) {
            console.log('No start timestamp provided');
            stopwatchDisplay.textContent = '00:00:00';
            return;
        }

        const startTime = new Date(startTimestamp);
        const totalPausedTimeMs = (totalPausedTime || 0) * 1000; // Convert seconds to milliseconds
        const pausedAtTime = pausedAt ? new Date(pausedAt) : null;

        console.log('Parsed times:', {
            startTime: startTime,
            totalPausedTimeMs: totalPausedTimeMs,
            pausedAtTime: pausedAtTime
        });

        let interval;

        function updateTimer() {
            const now = new Date();
            let elapsedTime;

            // Simple calculation: use the original timestamps but ensure they're in the same timezone context
            if (currentStatus === 'paused' && pausedAtTime) {
                // If paused, calculate time up to when it was paused (excluding pause time)
                elapsedTime = pausedAtTime - startTime - totalPausedTimeMs;
                console.log('Paused calculation:', {
                    pausedAtTime: pausedAtTime,
                    startTime: startTime,
                    totalPausedTimeMs: totalPausedTimeMs,
                    elapsedTime: elapsedTime
                });
            } else {
                // If active, calculate current time minus total paused time
                elapsedTime = now - startTime - totalPausedTimeMs;
                console.log('Active calculation:', {
                    now: now,
                    startTime: startTime,
                    totalPausedTimeMs: totalPausedTimeMs,
                    elapsedTime: elapsedTime
                });
            }

            // Ensure elapsed time is not negative
            const positiveElapsedTime = Math.max(0, elapsedTime);

            const hours = Math.floor(positiveElapsedTime / (1000 * 60 * 60));
            const minutes = Math.floor((positiveElapsedTime % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((positiveElapsedTime % (1000 * 60)) / 1000);

            const formattedTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            stopwatchDisplay.textContent = formattedTime;
            console.log('Displayed time:', formattedTime);

            // Update current duration display if it exists
            if (currentDuration) {
                currentDuration.textContent = formattedTime;
            }
        }

        // Show appropriate status
        if (currentStatus === 'completed') {
            console.log('Session completed - showing final time');
            updateTimer();
            updateStatusDisplay('completed');
            return;
        }

        if (currentStatus === 'paused') {
            console.log('Session paused - showing paused time');
            updateTimer();
            updateStatusDisplay('paused');
            return;
        }

        // Active session - start the timer
        console.log('Starting active timer');
        updateTimer(); // Initial update
        interval = setInterval(updateTimer, 1000);
        updateStatusDisplay('active');

        // Clean up interval when page unloads
        window.addEventListener('beforeunload', function() {
            if (interval) {
                clearInterval(interval);
            }
        });
    }

    function updateStatusDisplay(status) {
        let statusText = '';
        let statusColor = '';

        switch(status) {
            case 'active':
                statusText = 'Status: running';
                statusColor = 'text-green-600 dark:text-green-400';
                break;
            case 'paused':
                statusText = 'Status: paused';
                statusColor = 'text-yellow-600 dark:text-yellow-400';
                break;
            case 'completed':
                statusText = 'Status: completed';
                statusColor = 'text-blue-600 dark:text-blue-400';
                break;
            default:
                statusText = 'Status: ready';
                statusColor = 'text-gray-600 dark:text-gray-400';
        }

        statusDisplay.textContent = statusText;
        statusDisplay.className = `text-lg ${statusColor} font-medium`;
    }

    // Load today's stats
    loadTodayStats();

    // Manual timezone setting function
    window.setManualTimezone = function() {
        const select = document.getElementById('manual-timezone');
        const timezone = select.value;

        if (timezone) {
            fetch("{{ route('set.timezone') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                },
                body: JSON.stringify({ timezone: timezone })
            }).then(function(response) {
                if (response.ok) {
                    console.log('Manual timezone set to:', timezone);
                    location.reload(); // Reload to apply new timezone
                }
            }).catch(function(error) {
                console.error('Error setting manual timezone:', error);
            });
        }
    };

    function loadTodayStats() {
        fetch('{{ route("talent.today-stats") }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('today-total').textContent = data.total_time;
                    document.getElementById('today-sessions').textContent = data.total_sessions;
                }
            })
            .catch(error => {
                console.error('Error loading today stats:', error);
            });
    }
});
</script>
