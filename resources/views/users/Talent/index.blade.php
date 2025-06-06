@extends('layouts.app')
@section('title', 'Dashboard')
@section('meta_description', 'Padma Cloud Office')

@section('content')
    <div class="sm:ml-64">
        <div class="py-4 space-y-6">
            {{-- Welcome Message --}}
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Good to see you, {{ Auth::user()->name }}!
                </h1>
                <div class="flex items-center gap-2">
                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                            <path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                        </svg>
                        Export Report
                    </button>
                </div>
            </div>

            @if(session('success'))
            <x-alert type="success" :message="session('success')" />
            @endif

            @if(session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif

            @if(session('warning'))
                <x-alert type="warning" :message="session('warning')" />
            @endif

            @if(session('info'))
                <x-alert type="info" :message="session('info')" />
            @endif

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                {{-- On Going Project --}}
                <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 bg-red-100 rounded-lg dark:bg-red-900/30">
                            <svg class="w-6 h-6 text-red-500 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0 ml-4">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                On Going Project
                            </p>
                            <p class="text-3xl font-semibold text-gray-900 dark:text-white">
                                {{ $onGoingProjects }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Project QC --}}
                <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 bg-yellow-100 rounded-lg dark:bg-yellow-900/30">
                            <svg class="w-6 h-6 text-yellow-500 dark:text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5zm6.61 10.936a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0 ml-4">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Project QC
                            </p>
                            <p class="text-3xl font-semibold text-gray-900 dark:text-white">
                                {{ $projectQC }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Project This Month --}}
                <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg dark:bg-blue-900/30">
                            <svg class="w-6 h-6 text-blue-500 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0 ml-4">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Project This Month
                            </p>
                            <p class="text-3xl font-semibold text-gray-900 dark:text-white">
                                {{ $projectThisMonth }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Total Project --}}
                <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg dark:bg-green-900/30">
                            <svg class="w-6 h-6 text-green-500 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0 ml-4">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Total Project
                            </p>
                            <p class="text-3xl font-semibold text-gray-900 dark:text-white">
                                {{ $totalProjects }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content Grid --}}
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-[2fr_1fr]">
                <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                    <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Project Offer</h2>
                    @if($projectOffers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 ">Project Name</th>
                                        <th scope="col" class="px-6 py-3">Type</th>
                                        <th scope="col" class="px-6 py-3">Volume</th>
                                        {{-- <th scope="col" class="px-6 py-3">QC Talent</th> --}}
                                        <th scope="col" class="px-6 py-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projectOffers as $offer)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $offer->project_name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $offer->projectType->name === 'Manga' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300 whitespace-nowrap' }}">
                                                {{ $offer->projectType->project_name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $offer->project_volume }}
                                        </td>
                                        {{-- <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $offer->talent_qc ? $offer->talent_qc->name : 'Not Assigned' }}
                                        </td> --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div x-data="{ open: false }">
                                                <a @click="open = true"
                                                   class="inline-flex items-center px-2 py-1 text-xs font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 cursor-pointer">
                                                    Apply Project
                                                </a>
                                                <!-- Modal -->
                                                <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                                    {{-- return competitons data --}}
                                                    @include('components.apply-modal', ['project' => $offer]  )
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $projectOffers->links() }}
                        </div>
                    @else
                        <div class="flex items-center justify-center h-48 bg-gray-50 rounded-lg dark:bg-gray-700/50">
                            <div class="text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">There's no Project Offer yet</h3>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Project On Going Section --}}
                <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                    <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Project On Going</h2>
                    {{-- Project Status List --}}
                    <div class="space-y-4">
                        {{-- Project Assign --}}
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg dark:bg-gray-700/50">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-lg dark:bg-blue-900/30">
                                    <svg class="w-4 h-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.5 5.25a3 3 0 013-3h3a3 3 0 013 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0112 15.75c-2.73 0-5.357-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 017.5 5.455V5.25zm7.5 0v.09a49.488 49.488 0 00-6 0v-.09a1.5 1.5 0 011.5-1.5h3a1.5 1.5 0 011.5 1.5zm-3 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                        <path d="M3 18.4v-2.796a4.3 4.3 0 00.713.31A26.226 26.226 0 0012 17.25c2.892 0 5.68-.468 8.287-1.335.252-.084.49-.189.713-.311V18.4c0 1.452-1.047 2.728-2.523 2.923-2.12.282-4.282.427-6.477.427a49.19 49.19 0 01-6.477-.427C4.047 21.128 3 19.852 3 18.4z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">Project Assign</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Project Applied, still working on it</p>
                                </div>
                            </div>
                            <span class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $projectAssign }}</span>
                        </div>

                        {{-- Project QC --}}
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg dark:bg-gray-700/50">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 bg-yellow-100 rounded-lg dark:bg-yellow-900/30">
                                    <svg class="w-4 h-4 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5zm6.61 10.936a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">Project QC</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Waiting QC agent check the project</p>
                                </div>
                            </div>
                            <span class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $projectQCStatus }}</span>
                        </div>

                        {{-- Project Revision --}}
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg dark:bg-gray-700/50">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 bg-red-100 rounded-lg dark:bg-red-900/30">
                                    <svg class="w-4 h-4 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12 5.25c1.213 0 2.415.046 3.605.135a3.256 3.256 0 013.01 3.01c.044.583.077 1.17.1 1.759L17.03 8.47a.75.75 0 10-1.06 1.06l3 3a.75.75 0 001.06 0l3-3a.75.75 0 00-1.06-1.06l-1.752 1.751c-.023-.65-.06-1.296-.108-1.939a4.756 4.756 0 00-4.392-4.392 49.422 49.422 0 00-7.436 0A4.756 4.756 0 003.89 8.282c-.017.224-.033.447-.046.672a.75.75 0 101.497.092c.013-.217.028-.434.044-.651a3.256 3.256 0 013.01-3.01c1.19-.09 2.392-.135 3.605-.135zm-6.97 6.22a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l1.752-1.751c.023.65.06 1.296.108 1.939a4.756 4.756 0 004.392 4.392 49.413 49.413 0 007.436 0 4.756 4.756 0 004.392-4.392c.017-.223.032-.447.046-.672a.75.75 0 00-1.497-.092c-.013.217-.028.434-.044.651a3.256 3.256 0 01-3.01 3.01 47.953 47.953 0 01-7.21 0 3.256 3.256 0 01-3.01-3.01 47.759 47.759 0 01-.1-1.759L6.97 15.53a.75.75 0 001.06-1.06l-3-3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">Project Revision</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Revision note passed by admin</p>
                                </div>
                            </div>
                            <span class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $projectRevision }}</span>
                        </div>

                        {{-- Project Completed --}}
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg dark:bg-gray-700/50">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-lg dark:bg-green-900/30">
                                    <svg class="w-4 h-4 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">Project Completed</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Number of project completed</p>
                                </div>
                            </div>
                            <span class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $projectDone }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Projects QC Overview --}}
            <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Projects Overview</h2>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Project Name</th>
                                <th scope="col" class="px-6 py-3">Type</th>
                                <th scope="col" class="px-6 py-3">Volume</th>
                                <th scope="col" class="px-6 py-3">QC Talent</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allProjects as $project)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $project->project_name }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->projectType->name === 'Manga' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' }} whitespace-nowrap">
                                        {{ $project->projectType->project_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $project->project_volume }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $project->assignedQcAgent->name ? $project->assignedQcAgent->name : 'Not Assigned' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($project->status === 'project assign')
                                            bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                        @elseif($project->status === 'qc')
                                            bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @elseif($project->status === 'revision')
                                            bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                        @elseif($project->status === 'completed')
                                            bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @else
                                            bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('talent.project.detail', $project->id) }}"
                                       class="inline-flex items-center px-2 py-1 text-xs font-medium text-center text-white bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
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
                <div class="mt-4">
                    {{ $allProjects->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection


