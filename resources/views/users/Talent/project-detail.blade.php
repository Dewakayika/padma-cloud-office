@extends('layouts.app')
@section('title', $project->project_name . ' Detail')
@section('meta_description', $project->project_name . ' Project Detail Page')

@php
    // Common text styles
    $headingText = 'text-xl font-semibold text-gray-900 dark:text-white';
    $subHeadingText = 'text-base font-medium text-gray-900 dark:text-white';
    $labelText = 'text-sm font-medium text-gray-500 dark:text-gray-400';
    $valueText = 'text-base text-gray-900 dark:text-white';
    $mutedText = 'text-sm text-gray-500 dark:text-gray-400';
    $whiteText = 'text-white dark:text-gray-100';
    $linkText = 'text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300';

    // Common container styles
    $cardContainer = 'bg-white dark:bg-gray-800 rounded-lg shadow dark:shadow-gray-700/50';
    $cardPadding = 'p-6';
    $cardSpacing = 'mt-6';
    $tableHeader = 'text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider';
    $tableCell = 'px-4 py-3 text-gray-900 dark:text-gray-100';
    $tableDivider = 'divide-y divide-gray-200 dark:divide-gray-700';

    // Common button styles
    $primaryButton = 'inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 transition-colors duration-200';
    $secondaryButton = 'inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 dark:bg-purple-700 dark:hover:bg-purple-800 transition-colors duration-200';

    $badgeBase = 'px-3 py-1 text-xs text-white rounded-full transition-colors duration-200';
    $badgeBlue = $badgeBase . ' bg-blue-500 dark:bg-blue-600';
    $badgeGreen = $badgeBase . ' bg-green-500 dark:bg-green-600';
    $badgeYellow = $badgeBase . ' bg-yellow-500 dark:bg-yellow-600';
    $badgeRed = $badgeBase . ' bg-red-500 dark:bg-red-600';

    // Common layout styles
    $gridContainer = 'grid grid-cols-1 lg:grid-cols-3 gap-6';
    $gridInfo = 'grid grid-cols-2 gap-x-8 gap-y-4';
    $flexContainer = 'flex items-center space-x-4';
    $flexBetween = 'flex justify-between items-center';

    // Timeline styles
    $timelineLine = 'absolute left-4 h-full w-0.5 bg-gray-200 dark:bg-gray-700';
    $timelineDot = 'flex items-center justify-center w-8 h-8 rounded-full z-10';
    $timelineContent = 'ml-4';
@endphp

@section('content')
<div class="sm:ml-64">
    <div class="py-4 space-y-6">
        {{-- Breadcrumb Navigation --}}
        <x-breadscrums/>

        {{-- Project Banner with Timer --}}
        <div class="relative rounded-lg overflow-hidden h-48">
            <img src="{{ asset('images/banner.jpg')}}" alt="Project Banner" class="w-full h-full object-cover opacity-50 dark:opacity-40">
            <div class="absolute inset-0 bg-black bg-opacity-70 dark:bg-opacity-80"></div>
            <div class="absolute inset-0 flex items-center justify-between px-6">
                <div class="{{ $flexContainer }}">
                    {{-- <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center">
                        <img src="{{ $project->company->logo_url ?? 'https://webtoons-static.pstatic.net/image/favicon/favicon.ico' }}" alt="{{ $project->projectType->project_name ?? 'Project' }}" class="w-12 h-12 object-contain">
                    </div> --}}
                    <div>
                        <h1 class="text-2xl font-bold {{ $whiteText }}">{{ $project->project_name }}</h1>
                        <h1 class="text-sm font-bold {{ $whiteText }}">{{ $project->projectType->project_name }}</h1>
                    </div>
                </div>
                <div class="text-center">
                    <div id="project-timer-area"
                         data-project-status="{{ $project->status }}"
                         data-assign-timestamp="{{ $assignTimestamp }}"
                         data-done-timestamp="{{ $doneTimestamp }}">

                         @if ($project->status === 'project assign')
                             <div class="grid grid-cols-4 gap-4" id="elapsed-timer">
                                 @foreach(['days', 'hours', 'minutes', 'seconds'] as $unit)
                                 <div class="text-center">
                                     <div class="text-3xl font-bold {{ $whiteText }}" id="{{ $unit }}">00</div>
                                     <div class="text-sm text-purple-500 dark:text-purple-400 font-medium">{{ strtoupper($unit) }}</div>
                                 </div>
                                 @endforeach
                             </div>
                              <div class="text-sm font-medium {{ $whiteText }} mt-1">Time Elapsed</div>
                         @elseif ($project->status === 'done')
                            <div id="total-time-taken" class="text-lg font-bold text-green-500 dark:text-green-400"></div>
                            <div class="text-sm font-medium {{ $whiteText }} mt-1">Total Time Taken</div>
                         @else
                             <div class="text-lg font-bold text-yellow-400 dark:text-yellow-300">Project Not Assigned Yet</div>
                         @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Project Information and Status Section --}}
        <div class="{{ $gridContainer }}">
            {{-- Project Information --}}
            <div class="lg:col-span-2">
                <div class="{{ $cardContainer }}">
                    <div class="{{ $cardPadding }}">
                        <h2 class="{{ $headingText }} mb-6">Project Information</h2>
                        <div class="{{ $gridInfo }}">
                            @php
                                $infoItems = [
                                    'Project Name' => $project->project_name,
                                    'Last Update' => $project->updated_at->format('D, d M Y'),
                                    'QC Talent' => $project->assignedQcAgent->name ?? 'Not Assigned',
                                    'Project Finish Date' => $project->finish_date ? $project->finish_date->format('D, d M Y') : 'Not finish yet',
                                    'Project Assign Date' => $assignTimestamp ? \Carbon\Carbon::parse($assignTimestamp)->format('D, d M Y') : 'Not Assigned Yet',
                                ];
                            @endphp

                            @foreach($infoItems as $label => $value)
                            <div>
                                <p class="{{ $labelText }}">{{ $label }}:</p>
                                <p class="{{ $valueText }}">{{ $value }}</p>
                            </div>
                            @endforeach

                            <div>
                                <p class="{{ $labelText }}">Project File:</p>
                                @if ($project->project_file)
                                    <a href="{{ Storage::url($project->project_file) }}" class="{{ $linkText }}" target="_blank">Download File</a>
                                @else
                                    <span class="{{ $mutedText }}">No file available</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Project Records --}}
                <div class="{{ $cardContainer }} {{ $cardSpacing }}">
                    <div class="{{ $cardPadding }}">
                        <div class="{{ $flexBetween }} mb-6">
                            <h2 class="{{ $headingText }}">Project Records</h2>
                            <button type="button" class="{{ $secondaryButton }}">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                                Submit Project Draf
                            </button>
                        </div>
                        @if($project->projectLogs->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full {{ $tableDivider }}">
                                    <thead>
                                        <tr>
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">Project Stage</th>
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">Updated Date</th>
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">Draft Submission</th>
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="{{ $tableDivider }}">
                                        @foreach($project->projectLogs as $log)
                                        <tr>
                                            <td class="{{ $tableCell }}">
                                            @if ($log->status === 'waiting talent')
                                                <span class="{{ $badgeYellow }}">WAITING TALENT</span>
                                            @elseif ($log->status === 'project assign')
                                                <span class="{{ $badgeBlue }}">PROJECT ASSIGN</span>
                                            @elseif($log->status === 'qc')
                                                <span class="{{ $badgeYellow }}">REVIEW PROJECT</span>
                                            @elseif ($log->status === 'done')
                                                 <span class="{{ $badgeGreen }}">SHARE PROJECT</span>
                                            @else
                                                -
                                            @endif
                                            </td>
                                            <td class="{{ $tableCell }}">{{ $log->timestamp->format('D, d M Y') }}</td>
                                            <td class="{{ $tableCell }}">
                                                @if ($log->status === 'draf')
                                                    <span class="{{ $badgeYellow }}">PROJECT DRAF SUBMISSION</span>
                                                @elseif ($log->status === 'qc')
                                                     <span class="{{ $badgeBlue }}">SHARE PROJECT</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="{{ $tableCell }}">
                                                @if ($log->status === 'draf')
                                                    <span class="{{ $badgeYellow }} cursor-pointer hover:opacity-90">SHARE INFO</span>
                                                @elseif ($log->status === 'qc')
                                                     <span class="{{ $badgeBlue }} cursor-pointer hover:opacity-90">OPEN QC MESSAGE</span>
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
                            <div class="text-center {{ $mutedText }}">No project records available yet.</div>
                        @endif
                    </div>
                </div>

                {{-- Project Revision --}}
                <div class="{{ $cardContainer }} {{ $cardSpacing }}">
                    <div class="{{ $cardPadding }}">
                        <div class="{{ $flexBetween }} mb-6">
                            <h2 class="{{ $headingText }}">Project Revision</h2>
                            @if ($project->status === 'revision needed')
                                <button type="button" class="{{ $primaryButton }}">
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
                                <table class="min-w-full {{ $tableDivider }}">
                                    <thead>
                                        <tr>
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">Project Stage</th>
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">Date</th>
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">Panel</th>
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">Message</th>
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="{{ $tableDivider }}">
                                        @foreach($revisionLogs as $log)
                                        <tr>
                                            <td class="{{ $tableCell }}">{{ $log->status }}</td>
                                            <td class="{{ $tableCell }}">{{ $log->timestamp->format('D, d M Y') }}</td>
                                            <td class="{{ $tableCell }}">{{ $log->user->name ?? 'System' }}</td>
                                            <td class="{{ $tableCell }}">
                                                 @if ($log->message ?? null)
                                                    <span class="{{ $badgeGreen }} cursor-pointer hover:opacity-90">OPEN MESSAGE</span>
                                                 @else
                                                    -
                                                 @endif
                                            </td>
                                            <td class="{{ $tableCell }}">
                                                 <div class="flex space-x-2">
                                                    <span class="{{ $badgeYellow }} cursor-pointer hover:opacity-90">EDIT</span>
                                                    <span class="{{ $badgeRed }} cursor-pointer hover:opacity-90">DELETE</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center {{ $mutedText }}">No revision history available yet.</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Project Status Timeline --}}
            <div class="lg:col-span-1">
                <div class="{{ $cardContainer }} {{ $cardPadding }}">
                    <h2 class="{{ $headingText }} mb-2">Project Status</h2>
                    <h3 class="{{ $subHeadingText }} mb-6">{{ $project->project_name }}</h3>

                    @if($project->projectLogs->count() > 0)
                        <div class="relative">
                            <div class="{{ $timelineLine }}"></div>

                            @foreach($project->projectLogs->sortBy('timestamp') as $log)
                                @php
                                    $colorClass = 'bg-gray-100 dark:bg-gray-700';
                                    $dotColorClass = 'bg-gray-500 dark:bg-gray-400';

                                    if (str_contains(strtolower($log->status), 'project assign')) {
                                        $colorClass = 'bg-blue-100 dark:bg-blue-900/30';
                                        $dotColorClass = 'bg-blue-500 dark:bg-blue-400';
                                    } elseif (str_contains(strtolower($log->status), 'draf')){
                                        $colorClass = 'bg-orange-100 dark:bg-orange-900/30';
                                        $dotColorClass = 'bg-orange-500 dark:bg-orange-400';
                                    }elseif (str_contains(strtolower($log->status), 'qc')) {
                                        $colorClass = 'bg-orange-100 dark:bg-orange-900/30';
                                        $dotColorClass = 'bg-orange-500 dark:bg-orange-400';
                                    } elseif (str_contains(strtolower($log->status), 'done') || str_contains(strtolower($log->status), 'done')) {
                                        $colorClass = 'bg-green-100 dark:bg-green-900/30';
                                        $dotColorClass = 'bg-green-500 dark:bg-green-400';
                                    } elseif (str_contains(strtolower($log->status), 'revision') || str_contains(strtolower($log->status), 'needed')) {
                                        $colorClass = 'bg-red-100 dark:bg-red-900/30';
                                        $dotColorClass = 'bg-red-500 dark:bg-red-400';
                                    }
                                @endphp
                                <div class="relative flex items-center mb-8">
                                    <div class="{{ $timelineDot }} {{ $colorClass }}">
                                        <div class="w-4 h-4 {{ $dotColorClass }} rounded-full"></div>
                                    </div>
                                    <div class="{{ $timelineContent }}">
                                        <h4 class="{{ $subHeadingText }}">{{ $log->status }}</h4>
                                        <p class="{{ $mutedText }}">{{ $log->timestamp->format('D, d M Y | H:i A') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center {{ $mutedText }}">No status history available yet.</div>
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
