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
    $badgeGray = $badgeBase . ' bg-gray-500 dark:bg-gray-600';


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

                        @php
                            $activeStatuses = ['project assign', 'qc', 'draf', 'revision'];
                            $isTimerActive = $project->status !== 'done' && $assignTimestamp;
                        @endphp

                        @if ($isTimerActive)
                             <div class="grid grid-cols-4 gap-4" id="elapsed-timer"
                                  data-assign-timestamp="{{ $assignTimestamp }}"
                                  data-done-timestamp="{{ $doneTimestamp }}">
                                 @foreach(['days', 'hours', 'minutes', 'seconds'] as $unit)
                                 <div class="text-center">
                                     <div class="text-3xl font-bold {{ $whiteText }}" id="{{ $unit }}">00</div>
                                     <div class="text-sm text-purple-500 dark:text-purple-400 font-medium">{{ strtoupper($unit) }}</div>
                                 </div>
                                 @endforeach
                             </div>
                        @elseif ($project->status === 'done')
                            <div id="total-time-taken" class="text-lg font-bold text-green-500 dark:text-green-400"></div>
                            <div class="text-sm font-medium {{ $whiteText }} mt-1">Project Completed</div>
                        @else
                            <div class="text-lg font-bold text-yellow-400 dark:text-yellow-300">Project Not Started</div>
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
                            <div x-data="{ open: false }">
                                <a @click="open = true"
                                   class="{{ $secondaryButton }} cursor-pointer">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                    </svg>
                                   Submit Project Draf
                                </a>
                                <!-- Modal -->
                                <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                    @include('components.project-record.modal', ['projectData' => $project])
                                </div>
                            </div>
                        </div>
                        @if($project->projectLogs->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full {{ $tableDivider }}">
                                    <thead>
                                        <tr>
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">Project Stage</th>
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">Updated Date</th>
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">Draft Submission</th>
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">QC Message</th>
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="{{ $tableDivider }}">
                                        @foreach($project->projectLogs as $log)
                                        @php
                                            $projectRecord = $project->projectRecords->where('created_at', '<=', $log->timestamp)->last();
                                        @endphp
                                        <tr>
                                            <td class="{{ $tableCell }}">
                                            @if ($log->status === 'waiting talent')
                                                <span class="{{ $badgeGray }}">WAITING TALENT</span>
                                            @elseif ($log->status === 'project assign')
                                                <span class="{{ $badgeBlue }}">PROJECT ASSIGN</span>
                                            @elseif($log->status === 'qc')
                                                <span class="{{ $badgeYellow }}">PROJECT IN REVIEW </span>
                                            @elseif ($log->status === 'done')
                                                 <span class="{{ $badgeGreen }}">SHARE PROJECT</span>
                                            @else
                                                -
                                            @endif
                                            </td>
                                            <td class="{{ $tableCell }}">{{ $log->timestamp->format('D, d M Y') }}</td>
                                            <td class="{{ $tableCell }}">
                                                @if ($log->status === 'draf' && $projectRecord)
                                                    <a href="{{ $projectRecord->project_link }}" target="_blank" class="{{ $BadgeBlue }}">Project Draf Submission</a>
                                                @elseif ($log->status === 'qc' && $projectRecord)
                                                    <a href="{{ $projectRecord->project_link }}" target="_blank" class="{{ $badgeBlue }}">View Project Link</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="{{ $tableCell }}">
                                                @if ($log->status === 'qc' && $projectRecord)
                                                    <span> - </span>
                                                @elseif ($log->status === 'draf' && $projectRecord)
                                                    <a href="{{ $projectRecord->project_link }}" target="_blank" class="{{ $badgeBlue }}">View Project Link</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="{{ $tableCell }}">
                                                @if ($log->status === 'draf' && $projectRecord)
                                                    <span class="{{ $badgeGreen }} cursor-pointer hover:opacity-90" onclick="shareInfo('{{ $project->project_name }}', '{{ $project->projectType->project_name }}', '{{ $project->assignedQcAgent->name ?? "Not Assigned" }}', '{{ $projectRecord->project_link }}', 'Draft Submission')">Share Update</span>
                                                @elseif ($log->status === 'qc' && $projectRecord)
                                                    <span class="{{ $badgeGreen }} cursor-pointer hover:opacity-90" onclick="shareInfo('{{ $project->project_name }}', '{{ $project->projectType->project_name }}', '{{ $project->assignedQcAgent->name ?? "Not Assigned" }}', '{{ $projectRecord->project_link }}', 'Quality Check')">Share Update</span>
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

                                $status = strtolower($log->status);

                                if (str_contains($status, 'project assign')) {
                                    $colorClass = 'bg-blue-100 dark:bg-blue-900/30';
                                    $dotColorClass = 'bg-blue-500 dark:bg-blue-400';
                                    $displayText = 'Project Assigned';
                                } elseif (str_contains($status, 'draf')) {
                                    $colorClass = 'bg-orange-100 dark:bg-orange-900/30';
                                    $dotColorClass = 'bg-orange-500 dark:bg-orange-400';
                                    $displayText = 'Draft In Progress';
                                } elseif (str_contains($status, 'qc')) {
                                    $colorClass = 'bg-orange-100 dark:bg-orange-900/30';
                                    $dotColorClass = 'bg-orange-500 dark:bg-orange-400';
                                    $displayText = 'Quality Check';
                                } elseif (str_contains($status, 'done')) {
                                    $colorClass = 'bg-green-100 dark:bg-green-900/30';
                                    $dotColorClass = 'bg-green-500 dark:bg-green-400';
                                    $displayText = 'Completed';
                                } elseif (str_contains($status, 'revision') || str_contains($status, 'needed')) {
                                    $colorClass = 'bg-red-100 dark:bg-red-900/30';
                                    $dotColorClass = 'bg-red-500 dark:bg-red-400';
                                    $displayText = 'Revision Needed';
                                } else {
                                    $colorClass = 'bg-gray-100 dark:bg-gray-800/30';
                                    $dotColorClass = 'bg-gray-500 dark:bg-gray-400';
                                    $displayText = ucfirst($log->status);
                                }
                            @endphp

                            <div class="relative flex items-center mb-8">
                                <div class="{{ $timelineDot }} {{ $colorClass }}">
                                    <div class="w-4 h-4 {{ $dotColorClass }} rounded-full"></div>
                                </div>
                                <div class="{{ $timelineContent }}">
                                    <h4 class="{{ $subHeadingText }}">{{ $displayText }}</h4>
                                    <p class="{{ $mutedText }}">
                                        {{ $log->timestamp->setTimezone(session('timezone', config('app.timezone')))->format('D, d M Y | h:i A') }}
                                    </p>
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
    document.addEventListener('DOMContentLoaded', function() {
        const timerElement = document.getElementById('elapsed-timer');
        if (!timerElement) return;

        const assignTimestamp = timerElement.dataset.assignTimestamp;
        const doneTimestamp = timerElement.dataset.doneTimestamp;

        if (assignTimestamp) {
            const startDate = new Date(assignTimestamp);

            function updateTimer() {
                const now = new Date();
                const diff = now - startDate;

                // Calculate time units
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                // Update the display
                document.getElementById('days').textContent = String(days).padStart(2, '0');
                document.getElementById('hours').textContent = String(hours).padStart(2, '0');
                document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
                document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');

                // If project is not done, continue updating
                if (!doneTimestamp) {
                    setTimeout(updateTimer, 1000); // Update every second
                }
            }

            // Start the timer
            updateTimer();
        }
    });

    function shareInfo(projectName, projectType, qcName, projectLink, status) {
        const whatsappMessage = `*Project Information*
        Project Name: ${projectName}
        Project Type: ${projectType}
        Project QC Name: ${qcName}
        Project Link: ${projectLink}
        Status: ${status}`;

        // Create WhatsApp share URL
        const encodedMessage = encodeURIComponent(whatsappMessage);
        const whatsappUrl = `https://wa.me/?text=${encodedMessage}`;

        // Open WhatsApp in new tab
        window.open(whatsappUrl, '_blank');
    }
</script>
@endpush
