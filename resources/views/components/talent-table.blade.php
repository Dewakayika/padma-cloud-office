<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-lg p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Talent Data</h3>
        {{-- Add buttons for managing talents if needed --}}
    </div>

    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        <a href="{{ route('superadmin.talents', ['sort_by' => 'name', 'sort_order' => ($sortBy === 'name' && $sortOrder === 'asc') ? 'desc' : 'asc']) }}" class="flex items-center text-gray-700 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">
                            Name
                            @if ($sortBy === 'name')
                                @if ($sortOrder === 'asc')
                                    <i class="fas fa-sort-up ml-1 text-gray-800 dark:text-gray-300"></i>
                                @else
                                    <i class="fas fa-sort-down ml-1 text-gray-800 dark:text-gray-300"></i>
                                @endif
                            @else
                                <i class="fas fa-sort ml-1 opacity-50 text-gray-500 dark:text-gray-400"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        <a href="{{ route('superadmin.talents', ['sort_by' => 'email', 'sort_order' => ($sortBy === 'email' && $sortOrder === 'asc') ? 'desc' : 'asc']) }}" class="flex items-center text-gray-700 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">
                            Email
                            @if ($sortBy === 'email')
                                @if ($sortOrder === 'asc')
                                    <i class="fas fa-sort-up ml-1 text-gray-800 dark:text-gray-300"></i>
                                @else
                                    <i class="fas fa-sort-down ml-1 text-gray-800 dark:text-gray-300"></i>
                                @endif
                            @else
                                <i class="fas fa-sort ml-1 opacity-50 text-gray-500 dark:text-gray-400"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        <a href="{{ route('superadmin.talents', ['sort_by' => 'phone_number', 'sort_order' => ($sortBy === 'phone_number' && $sortOrder === 'asc') ? 'desc' : 'asc']) }}" class="flex items-center text-gray-700 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">
                            Phone Number
                            @if ($sortBy === 'phone_number')
                                @if ($sortOrder === 'asc')
                                    <i class="fas fa-sort-up ml-1 text-gray-800 dark:text-gray-300"></i>
                                @else
                                    <i class="fas fa-sort-down ml-1 text-gray-800 dark:text-gray-300"></i>
                                @endif
                            @else
                                <i class="fas fa-sort ml-1 opacity-50 text-gray-500 dark:text-gray-400"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        Gender
                    </th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($talents as $talent)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                            {{ $talent->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                            {{ $talent->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                            {{ $talent->talent->phone_number ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                            {{ $talent->talent->gender ?? 'N/A' }}
                        </td>
                        <td class="flex justify-center items-center gap-4 px-6 py-4 text-center whitespace-nowrap">
                            <a href="{{ route('superadmin.talent.detail', $talent->id . '-' . Str::slug($talent->name)) }}"
                               class="text-white bg-blue-500 dark:text-white border border-blue-500 dark:border-blue-400 hover:bg-blue-600 dark:hover:bg-blue-900 px-4 py-1 rounded-md text-sm">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-blue-400 h-8 w-8 mb-2" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                </svg>
                                <span class="italic">No talents found</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($talents->hasPages())
        <div class="mt-4">
            {{ $talents->appends(['sort_by' => $sortBy, 'sort_order' => $sortOrder])->links() }}
        </div>
    @endif
</div>
