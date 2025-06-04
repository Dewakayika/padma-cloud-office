<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-lg p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Company Data</h3>
        {{-- Add buttons for managing companies if needed, similar to the project table --}}
        {{-- For now, just keep the title --}}
    </div>

    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        <a href="{{ route('superadmin#index', ['sort_by' => 'company_name', 'sort_order' => ($sortBy === 'company_name' && $sortOrder === 'asc') ? 'desc' : 'asc']) }}" class="flex items-center text-gray-700 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">
                            Company Name
                            @if ($sortBy === 'company_name')
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
                         <a href="{{ route('superadmin#index', ['sort_by' => 'company_type', 'sort_order' => ($sortBy === 'company_type' && $sortOrder === 'asc') ? 'desc' : 'asc']) }}" class="flex items-center text-gray-700 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">
                            Company Type
                            @if ($sortBy === 'company_type')
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
                        <a href="{{ route('superadmin#index', ['sort_by' => 'country', 'sort_order' => ($sortBy === 'country' && $sortOrder === 'asc') ? 'desc' : 'asc']) }}" class="flex items-center text-gray-700 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">
                            Country
                            @if ($sortBy === 'country')
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
                        <a href="{{ route('superadmin#index', ['sort_by' => 'contact_person_name', 'sort_order' => ($sortBy === 'contact_person_name' && $sortOrder === 'asc') ? 'desc' : 'asc']) }}" class="flex items-center text-gray-700 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">
                            Contact Person
                            @if ($sortBy === 'contact_person_name')
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
                    <th scope="col" class="px-6 py-3 whitespace-nowrap text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ $company->company_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ $company->company_type ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ $company->country ?? 'N/A' }}</td>
                         <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ $company->contact_person_name }}</td>
                        <td class="flex justify-center items-center gap-4 px-6 py-4 text-center whitespace-nowrap">
                            <a href="{{ route('superadmin.company.detail', $company->id . '-' . Str::slug($company->company_name)) }}" class="text-white bg-blue-500 dark:text-white border border-blue-500 dark:border-blue-400 hover:bg-blue-600 dark:hover:bg-blue-900 px-4 py-1 rounded-md text-sm">Detail</a>
                            {{-- Add other actions like Edit/Delete if needed --}}
                        </td>
                    </tr>
                @empty
                     <tr>
                        <td colspan="5" class="px-6 py-20 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-blue-400 h-8 w-8 mb-2" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                    </svg>
                                <span class="italic">No companies found</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Add pagination links if needed --}}
     @if ($companies->hasPages())
        <div class="mt-4">
            {{ $companies->appends(['sort_by' => $sortBy, 'sort_order' => $sortOrder])->links() }}
        </div>
    @endif
</div>
