<div class="bg-white rounded-lg p-6 dark:bg-gray-800 dark:text-white">
<div class="flex items-center mb-6">
    <div class="rounded-full bg-green-100 p-3 mr-3">
        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
            <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 5.69 3.117M22.5 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM12 12a6.745 6.745 0 0 1 5.69 3.117M12 12a6.745 6.745 0 0 0-5.69 3.117M12 12a6.745 6.745 0 0 0 5.69 3.117" clip-rule="evenodd" />
        </svg>
    </div>
    <div>
        <h1 class="text-xl font-semibold">Team Setup</h1>
        <p class="text-gray-600 dark:text-gray-400">Add your team so you can assign projects smoothly and collaborate effectively</p>
    </div>
</div>

<div class="bg-white rounded-lg dark:bg-gray-800 dark:text-white dark:border-gray-800">
    <form id="invite-user-form" class="border rounded-lg p-6 dark:bg-gray-900 dark:text-white dark:border-gray-800" action="{{ route('company.invite.user') }}" method="POST">
        @csrf
        <h3 class="text-lg font-semibold mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Invite New Team Member
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-800" required>
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>   
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-800" required>
                    <option value="">Select Role</option>
                    <option value="talent">Talent</option>
                    <option value="talent_qc">Talent QC</option>
                </select>
                @error('role')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Send Invitation
        </button>
    </form>

    {{-- List Current Team Members --}}
    <div class="mt-6">
        <h3 class="text-xl font-semibold mb-4">Current Team Members</h3>
        @forelse ($teamMembers as $member)
            <div class="bg-gray-100 p-3 px-6 rounded-md mb-3 flex justify-between items-center dark:bg-gray-900 dark:text-white dark:border-gray-800">
                <div>
                    <p class="font-semibold">{{ $member->name }}</p>
                    <p class="text-gray-600 text-sm dark:text-gray-400">Role: {{ ucfirst($member->role) }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('company.user.detail', $member->id) }}" class="text-blue-600 hover:text-blue-900 text-sm">View Details</a>
                </div>
            </div>
        @empty
            <p class="text-gray-600 dark:text-gray-400">No team members added yet.</p>
        @endforelse

        @if(isset($teamMembers) && $teamMembers->hasPages())
            <div class="mt-4">
                {{ $teamMembers->links() }}
            </div>
        @endif
    </div>
</div>
</div>