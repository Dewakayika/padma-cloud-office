@extends('layouts.app')
@section('title', 'Dashboard')
@section('meta_description', 'Padma Cloud Office')

@section('content')


        <div class="sm:ml-64">
            <div class="space-y-6">
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
                            <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 dark:bg-purple-600 dark:hover:bg-purple-700">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                                New Project
                            </button>
                        </div>
                    </div>

                    {{-- Score Cards --}}
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
                                    <span class="text-xl font-bold text-gray-800 dark:text-white">0</span>
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
                                    <span class="text-xl font-bold text-gray-800 dark:text-white">0</span>
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
                                    <span class="text-xl font-bold text-gray-800 dark:text-white">0</span>
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
                                    <span class="text-xl font-bold text-gray-800 dark:text-white">0</span>
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
                                    <span class="text-xl font-bold text-gray-800 dark:text-white">0</span>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Project List Table --}}
                    <div class="mt-4 sm:mt-6 md:mt-8">
                        <x-generic-table :data="$projects" :columns="$projectColumns" />
                    </div>

        </div>
     </div>


@endsection
