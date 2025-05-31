<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold text-gray-800">Company Data</h3>
        <div class="space-x-4">
            <button class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                <i class="fas fa-plus mr-2"></i> NEW PROJECT
            </button>
            <button class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-opacity-50">
                <i class="fas fa-upload mr-2"></i> UPLOAD CSV PROJECT
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comic Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Episode Number</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Talent QC</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($company as $data)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $project->projectType->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $project->project_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $project->episode_number ?? 'N/A' }}</td> {{-- Assuming an episode_number field --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $project->talentQc->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @php
                                $statusColor = '';
                                switch($project->status) {
                                    case 'waiting talent': $statusColor = 'bg-yellow-200 text-yellow-800'; break;
                                    case 'in progress': $statusColor = 'bg-blue-200 text-blue-800'; break;
                                    case 'completed': $statusColor = 'bg-green-200 text-green-800'; break;
                                    // Add other statuses as needed
                                    default: $statusColor = 'bg-gray-200 text-gray-800';
                                }
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="" class="text-blue-600 hover:text-blue-900 mr-3">Detail</a>
                            {{-- Add other actions like Edit/Delete if needed for SuperAdmin --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
