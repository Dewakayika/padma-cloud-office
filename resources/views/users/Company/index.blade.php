@extends('layouts.app')
@section('title', 'Dashboard')
@section('meta_description', 'Padma Cloud Office')

@section('content')

        <div class="sm:ml-64">
            <div class="py-5 space-y-6">
                    <div class="flex items-center justify-between">
                        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Good to see you, {{ Auth::user()->name }}!
                        </h1>

                        <div class="flex items-center gap-2">
                            <div x-data="{ openEdit: false }">
                                <a @click="openEdit = true"
                                   class="inline-flex items-center px-3 py-2 gap-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 dark:bg-purple-600 dark:hover:bg-purple-700 cursor-pointer">
                                    New Project
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path d="M6 3a3 3 0 0 0-3 3v2.25a3 3 0 0 0 3 3h2.25a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H6ZM15.75 3a3 3 0 0 0-3 3v2.25a3 3 0 0 0 3 3H18a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3h-2.25ZM6 12.75a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h2.25a3 3 0 0 0 3-3v-2.25a3 3 0 0 0-3-3H6ZM17.625 13.5a.75.75 0 0 0-1.5 0v2.625H13.5a.75.75 0 0 0 0 1.5h2.625v2.625a.75.75 0 0 0 1.5 0v-2.625h2.625a.75.75 0 0 0 0-1.5h-2.625V13.5Z" />
                                </svg>
                                </a>

                                <!-- Modal -->
                                <div x-show="openEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                    <div @click.outside="openEdit = false" class="bg-white dark:bg-gray-800 rounded-xl w-full max-w-3xl">
                                        {{-- Komponen Edit Kompetisi --}}
                                        @include('components.create-project', ['projectTypes' => $projectTypes, 'talents' => $talents])
                                    </div>
                                </div>
                            </div>
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

                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-4 sm:mb-6 mt-6">
                        {{-- Project Serving Time --}}
                        <x-score-card
                            title="Project Serving Time"
                            value="0"
                            iconColor="text-green-500"
                            bgColor="bg-green-100">
                            <x-slot name="icon">
                                {{-- Replace with actual SVG path data for serving time icon or Font Awesome <i> tag --}}
                                <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" />
                            </x-slot>
                        </x-score-card>

                        {{-- Total Projects --}}
                        <x-score-card
                            title="Total Project"
                            value="0"
                            iconColor="text-blue-500"
                            bgColor="bg-blue-100">
                            <x-slot name="icon">
                                {{-- Replace with actual SVG path data for total project icon or Font Awesome <i> tag --}}
                                <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" />
                            </x-slot>
                        </x-score-card>

                        {{-- Total Project Volume --}}
                        <x-score-card
                            title="Total Project Volume"
                            value="0"
                            iconColor="text-yellow-500"
                            bgColor="bg-yellow-100">
                            <x-slot name="icon">
                                {{-- Replace with actual SVG path data for volume icon or Font Awesome <i> tag --}}
                                <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" />
                            </x-slot>
                        </x-score-card>

                        {{-- Total On Going Project --}}
                        <x-score-card
                            title="Total On Going Project"
                            value="0"
                            iconColor="text-red-500"
                            bgColor="bg-red-100">
                            <x-slot name="icon">
                                {{-- Replace with actual SVG path data for ongoing project icon or Font Awesome <i> tag --}}
                                <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" />
                            </x-slot>
                        </x-score-card>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr] gap-4 mb-4">
                        <div div class="p-3 md:p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                        </div>
                        <div div class="p-3 md:p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                            <h2 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-white">On Going Project</h2>
                            <div class="mt-4 grid grid-cols-1 gap-4 sm:gap-3">

                                {{-- Waiting Talent Card --}}
                                <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg border dark:border-none ">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg  bg-yellow-100 dark:bg-yellow-800 text-yellow-500 dark:text-yellow-200 flex items-center justify-center">
                                        <i class="fas fa-hourglass-half"></i>
                                    </div>
                                    <div class="flex-grow ml-4">
                                        <p class="text-md font-semibold text-gray-800 dark:text-white">Waiting Talent</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Waiting Talent approved Project</p>
                                    </div>
                                    <span class="text-xl font-bold text-gray-800 dark:text-white">{{ $onGoingProjects['waiting talent'] ?? 0 }}</span>
                                </div>

                                {{-- Project Assign Card --}}
                                <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg border dark:border-none">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg  bg-blue-100 dark:bg-blue-800 text-blue-500 dark:text-blue-200 flex items-center justify-center">
                                        <i class="fas fa-chess-knight"></i>
                                    </div>
                                    <div class="flex-grow ml-4">
                                        <p class="text-md font-semibold text-gray-800 dark:text-white">Project Assign</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Project Applied, still working on it</p>
                                    </div>
                                    <span class="text-xl font-bold text-gray-800 dark:text-white"><p>{{ $onGoingProjects['Project Assign'] ?? 0 }}</p></span>
                                </div>

                                {{-- Project QC Card --}}
                                <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg border dark:border-none">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg  bg-orange-100 dark:bg-orange-800 text-orange-500 dark:text-orange-200 flex items-center justify-center">
                                        <i class="fas fa-pencil-alt"></i>
                                    </div>
                                    <div class="flex-grow ml-4">
                                        <p class="text-md font-semibold text-gray-800 dark:text-white">Project QC</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Waiting QC agent check the project</p>
                                    </div>
                                    <span class="text-xl font-bold text-gray-800 dark:text-white"><p>{{ $onGoingProjects['Project QC'] ?? 0 }}</p></span>
                                </div>

                                {{-- Project Revision Card --}}
                                <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg border dark:border-none">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg  bg-red-100 dark:bg-red-800 text-red-500 dark:text-red-200 flex items-center justify-center">
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <div class="flex-grow ml-4">
                                        <p class="text-md font-semibold text-gray-800 dark:text-white">Project Revision</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Revision note release by admin</p>
                                    </div>
                                    <span class="text-xl font-bold text-gray-800 dark:text-white"><p>{{ $onGoingProjects['Revision'] ?? 0 }}</p></span>
                                </div>

                                {{-- Project Completed Card --}}
                                <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg border dark:border-none">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg  bg-green-100 dark:bg-green-800 text-green-500 dark:text-green-200 flex items-center justify-center">
                                        <i class="fas fa-thumbs-up"></i>
                                    </div>
                                    <div class="flex-grow ml-4">
                                        <p class="text-md font-semibold text-gray-800 dark:text-white">Project Completed</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Number of project completed</p>
                                    </div>
                                    <span class="text-xl font-bold text-gray-800 dark:text-white"><p>{{ $onGoingProjects['Done'] ?? 0 }}</p></span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-6 md:mt-8">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800 p-4">
                            <table class="w-full text-sm text-left text-gray-900 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Project Name</th>
                                        <th scope="col" class="px-6 py-3">Project Type</th>
                                        <th scope="col" class="px-6 py-3">QC Agent</th>
                                        <th scope="col" class="px-6 py-3 text-center">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($projects as $item)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-6 py-4">{{$item->project_name}}</td>
                                            <td class="px-6 py-4">{{$item->projectType->project_name}}</td>
                                            <td class="px-6 py-4">{{ $item->qcAgent->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 text-center">
                                                @switch($item->status)
                                                    @case('Waiting Talent')
                                                        <span class="px-4 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Waiting Talent
                                                        </span>
                                                        @break
                                                    @case('Project Assign')
                                                        <span class="px-4 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            Project Assign
                                                        </span>
                                                        @break
                                                    @case('Project Draft')
                                                        <span class="px-4 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                            Project Draft
                                                        </span>
                                                        @break
                                                    @case('Revision')
                                                        <span class="px-4 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Revision
                                                        </span>
                                                        @break
                                                    @case('Done')
                                                        <span class="px-4 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Done
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="px-4 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                            {{ ucfirst($item->status) }}
                                                        </span>
                                                @endswitch
                                            </td>
                                            <td class="px-6 py-4 text-center gap-4">
                                                {{-- Edit Button --}}
                                                <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 dark:text-blue-500 border border-blue-600 dark:border-blue-500 rounded-md hover:bg-blue-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                    <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM12.75 12a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V18a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V12Z" clip-rule="evenodd" />
                                                    <path d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                {{-- Details Button --}}
                                                <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 border border-gray-600 dark:border-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 ms-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                        <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                                                        <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                                                      </svg>
                                                    Details
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                                No data available.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Pagination Links --}}
                            <div class="mt-2 px-4">
                                {{ $projects->links() }}
                            </div>
                        </div>

                    </div>

        </div>
     </div>


@endsection
