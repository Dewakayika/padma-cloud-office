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

    $role = auth()->user()->role;
    $feedbackExists = $role === 'company' ? $companyFeedbackExists : $talentFeedbackExists;
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
                            $isTimerActive = in_array($project->status, $activeStatuses) && $assignTimestamp;
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
                        @elseif ($project->status === 'done' && $assignTimestamp && $doneTimestamp)
                            <div class="grid grid-cols-4 gap-4" id="total-time-taken">
                                @php
                                    $totalTime = $assignTimestamp->diffInSeconds($doneTimestamp);
                                    $days = floor($totalTime / (24 * 3600));
                                    $hours = floor(($totalTime % (24 * 3600)) / 3600);
                                    $minutes = floor(($totalTime % 3600) / 60);
                                    $seconds = $totalTime % 60;
                                @endphp
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-white dark:text-white">{{ str_pad($days, 2, '0', STR_PAD_LEFT) }}</div>
                                    <div class="text-sm text-purple-500 dark:text-purple-400 font-medium">DAYS</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-white dark:text-white">{{ str_pad($hours, 2, '0', STR_PAD_LEFT) }}</div>
                                    <div class="text-sm text-purple-500 dark:text-purple-400 font-medium">HOURS</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-white dark:text-white">{{ str_pad($minutes, 2, '0', STR_PAD_LEFT) }}</div>
                                    <div class="text-sm text-purple-500 dark:text-purple-400 font-medium">MINUTES</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-white dark:text-white">{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}</div>
                                    <div class="text-sm text-purple-500 dark:text-purple-400 font-medium">SECONDS</div>
                                </div>
                            </div>
                            <div class="text-sm font-medium {{ $whiteText }} mt-1">Total Time Consumed</div>
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
                            <div class="flex space-x-3">
                                @if($project->assignedQcAgent && $project->assignedQcAgent->id === auth()->id())
                                    <div x-data="{ open: false }">
                                        <button @click="open = true" type="button" class="{{ $secondaryButton }}">
                                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                            </svg>
                                            Submit Project QC
                                        </button>
                                        <!-- QC Modal -->
                                        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                            <x-project-record.qc-modal :project="$project" />
                                        </div>
                                    </div>
                                @else
                                    <div x-data="{ open: false }">
                                        <button @click="open = true" type="button" class="{{ $secondaryButton }}">
                                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                            </svg>
                                            Submit Project Draft
                                        </button>
                                        <!-- Draft Modal -->
                                        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                            <x-project-record.modal :project="$project" />
                                        </div>
                                    </div>
                                @endif

                                @if ($project->status === 'draf')
                                    <div x-data="{ open: false }">
                                        <button @click="open = true" type="button" class="{{ $primaryButton }}">
                                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                            </svg>
                                            Add Revision
                                        </button>
                                        <!-- Revision Modal -->
                                        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                            <x-project-record.revise-modal :project="$project" />
                                        </div>
                                    </div>
                                @endif
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
                                            <th class="{{ $tableHeader }} {{ $tableCell }}">QC/ Revise Message</th>
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
                                            @elseif($log->status === 'draf')
                                                <span class="{{ $badgeBlue }}">DRAFT SUBMITTED</span>
                                            @elseif($log->status === 'revision')
                                                <span class="{{ $badgeRed }}">REVISION</span>
                                            @elseif ($log->status === 'done')
                                                 <span class="{{ $badgeGreen }}">COMPLETED</span>
                                            @else
                                                -
                                            @endif
                                            </td>
                                            <td class="{{ $tableCell }}">{{ $log->timestamp->format('D, d M Y') }}</td>
                                            <td class="{{ $tableCell }}">
                                                @if ($log->status === 'draf' && $projectRecord)
                                                    <a href="{{ $projectRecord->project_link }}" target="_blank" class="{{ $badgeBlue }}">Project Draf Submission</a>
                                                @elseif ($log->status === 'qc' && $projectRecord)
                                                    <a href="{{ $projectRecord->project_link }}" target="_blank" class="{{ $badgeBlue }}">View Project Link</a>
                                                @elseif ($log->status === 'done' && $projectRecord)
                                                    <a href="{{ $projectRecord->project_link }}" target="_blank" class="{{ $badgeBlue }}">Final Project Link</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="{{ $tableCell }}">
                                                @if ($log->status === 'qc' && $projectRecord)
                                                    <span> - </span>
                                                @elseif ($log->status === 'draf' && $projectRecord)
                                                    <button onclick="showMessage('QC Message', '{{ addslashes($projectRecord->qc_message) }}', '{{ addslashes((string)($projectRecord->qc?->name ?? $projectRecord->talent?->name ?? $projectRecord->user?->name ?? 'Unknown')) }}', '{{ $projectRecord->status }}')" class="{{ $badgeBlue }}">Open QC Message</button>
                                                @elseif ($log->status === 'revision' && $projectRecord)
                                                    <button onclick="showMessage('Revision Message', '{{ addslashes($projectRecord->qc_message) }}', '{{ addslashes((string)($projectRecord->qc?->name ?? $projectRecord->talent?->name ?? $projectRecord->user?->name ?? 'Unknown')) }}', '{{ $projectRecord->status }}')" class="{{ $badgeBlue }}">Open Revision Message</button>
                                                @elseif ($log->status === 'done' && $projectRecord)
                                                    <button onclick="showMessage('Completion Message', '{{ addslashes($projectRecord->qc_message) }}', '{{ addslashes((string)($projectRecord->qc?->name ?? $projectRecord->talent?->name ?? $projectRecord->user?->name ?? 'Unknown')) }}', '{{ $projectRecord->status }}')" class="{{ $badgeBlue }}">Open Completed Message</button>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="{{ $tableCell }}">
                                                @if ($log->status === 'draf' && $projectRecord)
                                                    <span class="{{ $badgeGreen }} cursor-pointer hover:opacity-90" onclick="shareInfo('{{ $project->project_name }}', '{{ $project->projectType->project_name }}', '{{ $project->assignedQcAgent->name ?? "Not Assigned" }}', '{{ $projectRecord->project_link }}', 'Draft Submission')">Share Update</span>
                                                @elseif ($log->status === 'qc' && $projectRecord)
                                                    <span class="{{ $badgeGreen }} cursor-pointer hover:opacity-90" onclick="shareInfo('{{ $project->project_name }}', '{{ $project->projectType->project_name }}', '{{ $project->assignedQcAgent->name ?? "Not Assigned" }}', '{{ $projectRecord->project_link }}', 'Quality Check')">Share Update</span>
                                                @elseif ($log->status === 'revision' && $projectRecord)
                                                    <span class="{{ $badgeGreen }} cursor-pointer hover:opacity-90" onclick="shareInfo('{{ $project->project_name }}', '{{ $project->projectType->project_name }}', '{{ $project->assignedQcAgent->name ?? "Not Assigned" }}', '{{ $projectRecord->project_link }}', 'Revision')">Share Update</span>
                                                @elseif ($log->status === 'done' && $projectRecord)
                                                    <span class="{{ $badgeGreen }} cursor-pointer hover:opacity-90" onclick="shareInfo('{{ $project->project_name }}', '{{ $project->projectType->project_name }}', '{{ $project->assignedQcAgent->name ?? "Not Assigned" }}', '{{ $projectRecord->project_link }}', 'Completed')">Share Update</span>
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
                {{-- <div class="{{ $cardContainer }} {{ $cardSpacing }}">
                    <div class="{{ $cardPadding }}">
                        <div class="{{ $flexBetween }} mb-6">
                            <h2 class="{{ $headingText }}">Project Revision</h2>
                            @if ($project->status === 'draf')
                                <div x-data="{ open: false }">
                                    <button @click="open = true" type="button" class="{{ $primaryButton }}">
                                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                        </svg>
                                        Add Revision
                                    </button>
                                    <!-- Modal -->
                                    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                        <x-project-record.revise-modal :project="$project" />
                                    </div>
                                </div>
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
                </div> --}}
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
                                    $colorClass = 'bg-blue-100 dark:bg-blue-900/30';
                                    $dotColorClass = 'bg-blue-500 dark:bg-blue-400';
                                    $displayText = 'Draft Submitted';
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

@if($project->status === 'draf')
    <div class="fixed bottom-6 right-6 z-50">
        <div x-data="{ open: false }">
            <button @click="open = true" type="button" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2 transition-all duration-200 transform hover:scale-105">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <span>Make it Done</span>
            </button>

            <!-- Confirmation Modal -->
            <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Confirm Project Completion</h3>
                    <p class="text-gray-600 mb-6">Are you sure you want to mark this project as done? This action cannot be undone.</p>

                    <form action="{{ route('company.project.complete', $project->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="completion_message" class="block text-sm font-medium text-gray-700 mb-2">Completion Message (Optional)</label>
                            <textarea name="completion_message" id="completion_message" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="open = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Confirm Completion
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timerElement = document.getElementById('elapsed-timer');
        if (!timerElement) return;

        const assignTimestamp = timerElement.dataset.assignTimestamp;
        const doneTimestamp = timerElement.dataset.doneTimestamp;
        const projectStatus = document.getElementById('project-timer-area').dataset.projectStatus;

        if (assignTimestamp) {
            const startDate = new Date(assignTimestamp);
            let endDate = doneTimestamp ? new Date(doneTimestamp) : null;

            function updateTimer() {
                const now = endDate || new Date();
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
                if (!endDate) {
                    setTimeout(updateTimer, 1000); // Update every second
                }
            }

            // Start the timer
            updateTimer();
        }
    });

    function showMessage(title, message, sender, status) {
        window.dispatchEvent(new CustomEvent('open-message-modal', {
            detail: {
                title: title,
                message: message,
                sender: sender,
                status: status
            }
        }));
    }

    function shareInfo(projectName, projectType, qcAgent, projectLink, status) {
        const whatsappMessage = `*Project Information*
        Project Name: ${projectName}
        Project Type: ${projectType}
        Project QC Name: ${qcAgent}
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

<!-- Message Modal Component -->
<x-project-record.message-modal />

<x-feedback-modal :project="$project" :role="$role" :feedback-exists="$feedbackExists" />
