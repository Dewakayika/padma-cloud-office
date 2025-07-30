@props(['id' => null, 'project' => null])

<div class="p-6 bg-white dark:bg-gray-900 w-full rounded-lg max-w-md mx-auto ">
    <div class="mb-6 text-center">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Are you sure to apply this project?</h2>
        <p class="text-sm text-gray-600 dark:text-gray-300 text-center whitespace-normal">
            This action will apply you to work on this project and commit to finishing it on time. Make sure you're ready — this action cannot be undone.
        </p>
    </div>

    <div class="flex gap-3 mt-6">
        <button
            @click="open = false"
            class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 transition ease-in-out duration-200">
            Batal
        </button>
        <form method="POST" action="{{ route('talent.project.apply', [$project->id, $project->company->slug ?? request()->route('companySlug')]) }}" class="w-full">
            @csrf
            <button
                type="submit"
                class="w-full px-4 py-2 rounded-xl bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 transition ease-in-out duration-200">
                Apply Now
            </button>
        </form>
    </div>
</div>
