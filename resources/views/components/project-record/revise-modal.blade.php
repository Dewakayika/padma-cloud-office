@props(['project'])

@php
    // Get the latest project record for this project
    $latestRecord = $project->projectRecords()->latest()->first();
@endphp

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full mx-4">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Submit Project Revision</h3>
            <button @click="open = false" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('company.project.revise', $project) }}" method="POST" class="space-y-6">
            @csrf

            <input type="hidden" name="project_link" value="{{ $latestRecord->project_link ?? '' }}">

            <div>
                <label for="revise_message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Revision Message</label>
                <textarea name="revise_message" id="revise_message" rows="4" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" @click="open = false"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800">
                    Submit Revision
                </button>
            </div>
        </form>
    </div>
</div>