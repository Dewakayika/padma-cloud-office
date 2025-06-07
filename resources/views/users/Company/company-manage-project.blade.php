@extends('layouts.app')
@section('title', 'Dashboard')
@section('meta_description', 'Padma Cloud Office')

@section('content')
    <div class="sm:ml-64">
        <div class="py-4 space-y-6">
            {{-- Title --}}
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Manage Projects
                </h1>
                <div class="flex items-center gap-2">
                    <form action="{{ route('talent.manage.projects') }}" method="GET" class="flex items-center gap-2">
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Search projects..."
                                   class="w-64 pl-10 pr-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:placeholder-gray-400 dark:focus:border-purple-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Filter Component --}}
            <div class="flex justify-between items-center mb-6">
                {{-- Project Status Tabs --}}
                <div class="inline-flex rounded-lg shadow-sm">
                    <a href="{{ route('company.manage.projects', array_merge(request()->query(), ['status' => 'all'])) }}"
                       class="px-4 py-2 text-sm font-medium {{ request('status', 'all') == 'all' ? 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-200' : 'bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-300' }} border border-gray-200 dark:border-gray-600 rounded-l-lg hover:bg-gray-100 dark:hover:bg-gray-600 focus:z-10 focus:ring-2 focus:ring-purple-500">
                        All Projects
                    </a>
                    <a href="{{ route('company.manage.projects', array_merge(request()->query(), ['status' => 'ongoing'])) }}"
                       class="px-4 py-2 text-sm font-medium {{ request('status') == 'ongoing' ? 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-200' : 'bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-300' }} border-t border-b border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 focus:z-10 focus:ring-2 focus:ring-purple-500">
                        Ongoing
                    </a>
                    <a href="{{ route('company.manage.projects', array_merge(request()->query(), ['status' => 'qc'])) }}"
                       class="px-4 py-2 text-sm font-medium {{ request('status') == 'qc' ? 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-200' : 'bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-300' }} border-t border-b border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 focus:z-10 focus:ring-2 focus:ring-purple-500">
                        QC
                    </a>
                    <a href="{{ route('company.manage.projects', array_merge(request()->query(), ['status' => 'completed'])) }}"
                       class="px-4 py-2 text-sm font-medium {{ request('status') == 'completed' ? 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-200' : 'bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-300' }} border border-gray-200 dark:border-gray-600 rounded-r-lg hover:bg-gray-100 dark:hover:bg-gray-600 focus:z-10 focus:ring-2 focus:ring-purple-500">
                        Completed
                    </a>
                </div>

                {{-- Sort and Filter Options --}}
                <div class="flex items-center space-x-2">
                    <form action="{{ route('company.manage.projects') }}" method="GET" class="flex items-center gap-2">
                        @foreach(request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <div class="relative">
                            <select name="sort"
                                    onchange="this.form.submit()"
                                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 appearance-none pr-8 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-purple-500 dark:focus:border-purple-500">
                                <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Project List Section --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">All Projects</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Manage all your projects across different stages</p>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">PROJECT NAME</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">TYPE</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">START DATE</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">TALENT QC</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">STATUS</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($projects as $project)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $project->project_name }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $project->projectType->project_name }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $project->start_date ? $project->start_date->format('M d, Y') : 'Not set' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $project->User ? $project->User->name : 'Not Assigned' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusClasses = [
                                                    'project assign' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                                    'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                                                    'qc' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                    'revision' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                                                    'done' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                ];
                                                $statusClass = $statusClasses[$project->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
                                            @endphp
                                            <span class="px-3 py-1 text-xs rounded-full {{ $statusClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="{{ route('company.project.detail', $project->id . '-' . Str::slug($project->project_name)) }}"
                                               class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">
                                                Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white dark:bg-gray-800">
                                        <td colspan="6" class="px-6 py-4 text-center">
                                            <div class="flex flex-col items-center justify-center py-8">
                                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" />
                                                </svg>
                                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">No projects found</h3>
                                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">There are no projects available at the moment.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
