
<div>
    {{-- Project Type Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Project Name Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Project Type</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $projectType->project_name }}</p>
                                </div>
                            </div>
                        </div>

        <!-- Project Rate Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Project Rate</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($projectType->project_rate, 2) }}</p>
                                </div>
                            </div>
                        </div>

        <!-- QC Rate Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">QC Rate</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $projectType->qc_rate }}%</p>
                                </div>
                            </div>
                        </div>
                    </div>

    <!-- SOP Details Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                            </svg>
                                                    </div>
                                                        <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">SOP Details</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage and organize your project procedures</p>
                    </div>
                                                        </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        {{ $sops->count() }} SOP{{ $sops->count() !== 1 ? 's' : '' }}
                    </span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">•</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Last updated: {{ $sops->max('updated_at') ? $sops->max('updated_at')->format('M d, Y') : 'Never' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

    <!-- SOP Content -->
    <div class="mt-6">
        <!-- SOP Overview Content -->
        <div class="block">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Standard Operating Procedures</h2>
                        <button type="button" onclick="openModal()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Add SOP</button>
                    </div>
                    @if($sops->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No SOPs Found</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Get started by creating your first Standard Operating Procedure for this project type.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($sops as $index => $sop)
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col justify-between border border-gray-200 dark:border-gray-700">
                                    <div>
                                        <div class="flex items-center mb-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 text-sm font-medium dark:bg-blue-900 dark:text-blue-200 mr-2">{{ $index + 1 }}</span>
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white flex-1">SOP Formula</h3>
                                        </div>
                                        <div class="bg-gray-50 dark:bg-gray-900 rounded-md p-3 border dark:border-gray-600 mb-2">
                                            <p class="text-gray-800 dark:text-gray-200 whitespace-pre-wrap font-mono text-sm">{{ $sop->sop_formula }}</p>
                                        </div>
                                        @if($sop->description)
                                            <div class="mb-2">
                                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-1">Description</h4>
                                                <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap text-sm">{{ $sop->description }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex items-center justify-between mt-4 text-xs text-gray-500 dark:text-gray-400">
                                        <div>
                                            <span>By {{ $sop->user->name }}</span> •
                                            <span>{{ $sop->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button type="button" class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm rounded-md text-blue-700 bg-white hover:bg-blue-50 dark:bg-gray-700 dark:text-blue-300 dark:border-gray-600 dark:hover:bg-gray-600" onclick="editSop({{ $sop->id }})">Edit</button>
                                            <button type="button" class="inline-flex items-center px-3 py-1 border border-red-300 text-sm rounded-md text-red-700 bg-white hover:bg-red-50 dark:bg-gray-700 dark:text-red-300 dark:border-red-600 dark:hover:bg-red-600" onclick="deleteSop({{ $sop->id }})">Delete</button>
                                </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($sops->hasPages())
                            <div class="mt-8">
                                {{ $sops->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add/Edit SOP Modal --}}
<x-sop-edit-modal :projectType="$projectType" />


