@extends('layouts.app')
@section('title', $project->project_name . ' Detail')
@section('meta_description', $project->project_name . ' Project Detail Page')

@section('content')
<div class="sm:ml-64">
    <div class="py-4 space-y-6">
        {{-- Breadcrumb Navigation --}}
        <x-breadscrums/>

        {{-- Project Banner with Timer --}}
        <div class="relative rounded-lg overflow-hidden h-48">
            <img src="{{ asset('images/banner.jpg')}}" alt="Project Banner" class="w-full h-full object-cover opacity-50">
            <div class="absolute inset-0 bg-black bg-opacity-70"></div>
            <div class="absolute inset-0 flex items-center justify-between px-6">
                <div class="flex items-center space-x-4">
                    {{-- <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center">
                        <img src="{{ $project->company->logo_url ?? 'https://webtoons-static.pstatic.net/image/favicon/favicon.ico' }}" alt="{{ $project->projectType->project_name ?? 'Project' }}" class="w-12 h-12 object-contain">
                    </div> --}}
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $project->project_name }}</h1>
                        <h1 class="text-sm font-bold text-white">{{ $project->projectType->project_name }}</h1>

                    </div>
                </div>
                <div class="text-center">
                    <div id="project-timer-area"
                         data-project-status="{{ $project->status }}"
                         data-assign-timestamp="{{ $assignTimestamp }}"
                         data-done-timestamp="{{ $doneTimestamp }}">

                         @if ($project->status === 'project assign')
                             <div class="grid grid-cols-4 gap-4" id="elapsed-timer">
                                 <div class="text-center">
                                     <div class="text-3xl font-bold text-white" id="days">00</div>
                                     <div class="text-sm text-blue-500 font-medium">DAY</div>
                                 </div>
                                 <div class="text-center">
                                     <div class="text-3xl font-bold text-white" id="hours">00</div>
                                     <div class="text-sm text-blue-500 font-medium">HOUR</div>
                                 </div>
                                 <div class="text-center">
                                     <div class="text-3xl font-bold text-white" id="minutes">00</div>
                                     <div class="text-sm text-blue-500 font-medium">MIN</div>
                                 </div>
                                 <div class="text-center">
                                     <div class="text-3xl font-bold text-white" id="seconds">00</div>
                                     <div class="text-sm text-blue-500 font-medium">SEC</div>
                                 </div>
                             </div>
                              <div class="text-sm font-medium text-white mt-1">Time Elapsed</div>
                         @elseif ($project->status === 'done')
                            <div id="total-time-taken" class="text-lg font-bold text-green-500"></div>
                            <div class="text-sm font-medium text-white mt-1">Total Time Taken</div>
                         @else
                             <div class="text-lg font-bold text-yellow-400">Project Not Assigned Yet</div>
                         @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Project Information and Status Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Project Information --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Project Information</h2>
                        <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Project Name:</p>
                                <p class="text-base text-gray-900 dark:text-white">{{ $project->project_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Update:</p>
                                <p class="text-base text-gray-900 dark:text-white">{{ $project->updated_at->format('D, d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">QC Talent:</p>
                                <p class="text-base text-gray-900 dark:text-white">{{ $project->assignedQcAgent->name ?? 'Not Assigned' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Project Finish Date:</p>
                                <p class="text-base text-gray-900 dark:text-white">{{ $project->finish_date ? $project->finish_date->format('D, d M Y') : 'Not finish yet' }}</p>
                            </div>
                             <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Project Assign Date:</p>
                                 <p class="text-base text-gray-900 dark:text-white">{{ $assignTimestamp ? \Carbon\Carbon::parse($assignTimestamp)->format('D, d M Y') : 'Not Assigned Yet' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Project File:</p>
                                @if ($project->project_file)
                                    <a href="{{ Storage::url($project->project_file) }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300" target="_blank">Download File</a>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">No file available</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Project Records --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow mt-6">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Project Records</h2>
                        @if($project->projectLogs->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead>
                                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <th class="px-4 py-3">Project Stage</th>
                                            <th class="px-4 py-3">Updated Date</th>
                                            <th class="px-4 py-3">Panel</th>
                                            <th class="px-4 py-3">Project File</th>
                                            <th class="px-4 py-3">QC Message</th>
                                            <th class="px-4 py-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($project->projectLogs as $log)
                                        <tr>
                                            <td class="px-4 py-3">{{ $log->status }}</td>
                                            <td class="px-4 py-3">{{ $log->timestamp->format('D, d M Y') }}</td>
                                            <td class="px-4 py-3">{{ $log->user->name ?? 'System' }}</td>
                                            <td class="px-4 py-3">
                                                 @if ($log->project_file_url ?? null)
                                                     <a href="{{ $log->project_file_url }}" class="px-3 py-1 text-xs text-white bg-blue-500 rounded-full" target="_blank">PROJECT FILE</a>
                                                 @else
                                                     -
                                                 @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if ($log->qc_message ?? null)
                                                    <span class="px-3 py-1 text-xs text-white bg-green-500 rounded-full cursor-pointer">OPEN MESSAGE</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if ($log->status === 'Needs Review')
                                                    <span class="px-3 py-1 text-xs text-white bg-yellow-500 rounded-full">REVIEW PROJECT</span>
                                                @elseif ($log->status === 'Completed')
                                                     <span class="px-3 py-1 text-xs text-white bg-blue-500 rounded-full">SHARE PROJECT</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center text-gray-500 dark:text-gray-400">No project records available yet.</div>
                        @endif
                    </div>
                </div>

                {{-- Project Revision --}}
                 <div class="bg-white dark:bg-gray-800 rounded-lg shadow mt-6">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Project Revision</h2>
                            @if ($project->status === 'revision needed')
                                <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                    </svg>
                                    Add Revision
                                </button>
                            @endif
                        </div>
                         @php
                             $revisionLogs = $project->projectLogs->filter(fn($log) => str_contains(strtolower($log->status), 'revise'));
                         @endphp
                        @if($revisionLogs->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead>
                                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <th class="px-4 py-3">Project Stage</th>
                                            <th class="px-4 py-3">Date</th>
                                            <th class="px-4 py-3">Panel</th>
                                            <th class="px-4 py-3">Message</th>
                                            <th class="px-4 py-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($revisionLogs as $log)
                                        <tr>
                                            <td class="px-4 py-3">{{ $log->status }}</td>
                                            <td class="px-4 py-3">{{ $log->timestamp->format('D, d M Y') }}</td>
                                            <td class="px-4 py-3">{{ $log->user->name ?? 'System' }}</td>
                                            <td class="px-4 py-3">
                                                 @if ($log->message ?? null)
                                                    <span class="px-3 py-1 text-xs text-white bg-green-500 rounded-full cursor-pointer">OPEN MESSAGE</span>
                                                 @else
                                                    -
                                                 @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                 <div class="flex space-x-2">
                                                    <span class="px-3 py-1 text-xs text-white bg-yellow-500 rounded-full cursor-pointer">EDIT</span>
                                                    <span class="px-3 py-1 text-xs text-white bg-red-500 rounded-full cursor-pointer">DELETE</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                         @else
                              <div class="text-center text-gray-500 dark:text-gray-400">No revision history available yet.</div>
                         @endif
                    </div>
                </div>
            </div>

            {{-- Project Status Timeline --}}
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Project Status</h2>
                    <h3 class="text-lg text-gray-700 dark:text-gray-300 mb-6">{{ $project->project_name }}</h3>

                    @if($project->projectLogs->count() > 0)
                         <div class="relative">
                            <div class="absolute left-4 h-full w-0.5 bg-gray-200 dark:bg-gray-700"></div>

                             @foreach($project->projectLogs->sortBy('timestamp') as $log)
                                @php
                                    $colorClass = 'bg-gray-100 dark:bg-gray-700';
                                    $dotColorClass = 'bg-gray-500';

                                    if (str_contains(strtolower($log->status), 'assign')) {
                                        $colorClass = 'bg-blue-100 dark:bg-blue-900/30';
                                        $dotColorClass = 'bg-blue-500 dark:bg-blue-400';
                                    } elseif (str_contains(strtolower($log->status), 'qc')) {
                                         $colorClass = 'bg-orange-100 dark:bg-orange-900/30';
                                        $dotColorClass = 'bg-orange-500 dark:bg-orange-400';
                                    } elseif (str_contains(strtolower($log->status), 'submitted') || str_contains(strtolower($log->status), 'completed')) {
                                        $colorClass = 'bg-green-100 dark:bg-green-900/30';
                                        $dotColorClass = 'bg-green-500 dark:bg-green-400';
                                    } elseif (str_contains(strtolower($log->status), 'revision') || str_contains(strtolower($log->status), 'needed')) {
                                        $colorClass = 'bg-red-100 dark:bg-red-900/30';
                                        $dotColorClass = 'bg-red-500 dark:bg-red-400';
                                    }
                                @endphp
                                <div class="relative flex items-center mb-8">
                                    <div class="flex items-center justify-center w-8 h-8 {{ $colorClass }} rounded-full z-10">
                                        <div class="w-4 h-4 {{ $dotColorClass }} rounded-full"></div>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-base font-medium text-gray-900 dark:text-white">{{ $log->status }}</h4>
                                        <p class="text-sm text-gray-500">{{ $log->timestamp->format('D, d M Y | H:i A') }}</p>
                                    </div>
                                </div>
                             @endforeach
                        </div>
                    @else
                        <div class="text-center text-gray-500 dark:text-gray-400">No status history available yet.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const projectTimerArea = document.getElementById('project-timer-area');

    if (projectTimerArea) {
        const projectStatus = projectTimerArea.getAttribute('data-project-status');
        const assignTimestamp = projectTimerArea.getAttribute('data-assign-timestamp');
        const doneTimestamp = projectTimerArea.getAttribute('data-done-timestamp');
        const elapsedTimerDisplay = document.getElementById('elapsed-timer');
        const totalTimeTakenDisplay = document.getElementById('total-time-taken');

        let timerInterval = null;

        function updateTimerDisplay(distance) {
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

             if (document.getElementById('days')) {
                 document.getElementById('days').innerHTML = String(days).padStart(2, '0');
                 document.getElementById('hours').innerHTML = String(hours).padStart(2, '0');
                 document.getElementById('minutes').innerHTML = String(minutes).padStart(2, '0');
                 document.getElementById('seconds').innerHTML = String(seconds).padStart(2, '0');
             }
        }

        function formatElapsedTime(distance) {
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            let parts = [];
            if (days > 0) parts.push(`${days}d`);
            if (hours > 0) parts.push(`${hours}h`);
            if (minutes > 0) parts.push(`${minutes}m`);
             if (seconds > 0 || parts.length === 0) parts.push(`${seconds}s`);


            return parts.join(' ');
        }

        if (projectStatus === 'project assign' && assignTimestamp) {
            const startTime = new Date(assignTimestamp).getTime();

            timerInterval = setInterval(function() {
                const now = new Date().getTime();
                const elapsed = now - startTime;
                updateTimerDisplay(elapsed);
            }, 1000);

        } else if (projectStatus === 'done' && assignTimestamp && doneTimestamp) {
             const startTime = new Date(assignTimestamp).getTime();
             const finishTime = new Date(doneTimestamp).getTime();
             const totalElapsed = finishTime - startTime;

             if (totalTimeTakenDisplay) {
                 totalTimeTakenDisplay.innerHTML = formatElapsedTime(totalElapsed);
             }
             if (elapsedTimerDisplay) {
                 elapsedTimerDisplay.style.display = 'none';
             }

        } else {
             if (elapsedTimerDisplay) {
                 elapsedTimerDisplay.style.display = 'none';
             }
              if (totalTimeTakenDisplay) {
                 totalTimeTakenDisplay.style.display = 'none';
              }
        }

         window.addEventListener('beforeunload', function() {
             if (timerInterval) {
                 clearInterval(timerInterval);
             }
         });
    }
</script>
@endpush
