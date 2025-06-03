<div class="bg-white rounded-lg p-4">

    <div class="flex items-center mb-6">
        <div class="rounded-full bg-green-100 p-3 mr-3">

            <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd" />
            </svg>

        </div>
        <div>
            <h1 class="text-2xl font-semibold">Project Setup</h1>
            <p class="text-gray-600">Settings Up your project type with base price</p></p>
        </div>
    </div>

    <form id="add-project-type-form" class="border rounded-lg p-4" action="{{ route('company.project.store') }}" method="POST">
        @csrf
        <h3 class="text-lg font-semibold mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Project Type
        </h3>
        <input type="hidden" name="user_id" value="{{ $user->id }}" />
        <input type="hidden" name="company_id" value="{{ $company->id }}" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="project_name" class="block text-sm font-medium text-gray-700">Project Name</label>
                <input type="text" name="project_name" id="project_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="project_rate" class="block text-sm font-medium text-gray-700">Project Rate</label>
                <input type="number" name="project_rate" id="project_rate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" step="0.01">
            </div>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Add Project Type</button>
    </form>

    {{-- List Current Project Type --}}
    <div class="mt-6">
        <h3 class="text-xl font-semibold mb-4">Existing Project Types</h3>

        {{-- Existing project types list --}}
        @forelse ($projectTypes as $projectType)
            <div class="bg-gray-100 p-3 rounded-md mb-3 flex justify-between items-center">
                <div>
                    <p class="font-semibold">{{ $projectType->project_name }}</p>
                    <p class="text-gray-600 text-sm">Rate: {{ $projectType->project_rate }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('company.project.type.edit', $projectType->id) }}" class="text-blue-600 hover:text-blue-900 text-sm">Edit</a>
                    <form action="{{ route('company.project.type.destroy', $projectType->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project type?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-600">No project types added yet.</p>
        @endforelse

        <div class="mt-4">
            {{ $projectTypes->links() }}
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Project settings specific JavaScript can go here if needed
});
</script>


