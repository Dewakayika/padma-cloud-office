<div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800 p-4">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @foreach ($columns as $column)
                    <th scope="col" class="px-6 py-3">
                        {{ $column['label'] }}
                    </th>
                @endforeach
                {{-- Optional: Add a column for Actions if needed --}}
                {{-- <th scope="col" class="px-6 py-3">
                    Actions
                </th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    @foreach ($columns as $column)
                        <td class="px-6 py-4">
                            {{-- Access data based on the key provided in column definition --}}
                            {{ data_get($item, $column['key']) }}
                        </td>
                    @endforeach
                    {{-- Optional: Add action buttons here --}}
                    {{-- <td class="px-6 py-4 text-right">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </td> --}}
                </tr>
            @empty
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td colspan="{{ count($columns) + (isset($actions) ? 1 : 0) }}" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        No data available.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination Links --}}
    @if (method_exists($data, 'links'))
        <div class="mt-4">
            {{ $data->links() }}
        </div>
    @endif
</div>
