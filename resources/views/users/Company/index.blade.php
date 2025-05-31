@extends('layouts.app')
@section('title', 'Dashboard')
@section('meta_description', 'Padma Cloud Office')

@section('content')


     <div class="p-2 md:p-4 sm:ml-64">
        <div class="p-2 md:p-4">
                    {{-- Welcome Message --}}
                    <div class="mb-4 sm:mb-6">
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">
                            Good to see you, <span class="font-bold">{{$user->name}}</span>
                        </h1>
                    </div>

                    {{-- Score Cards --}}
                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-4 sm:mb-6">
                        <x-score-card
                            icon="far fa-clock"
                            iconBackground="bg-green-100 dark:bg-green-800"
                            iconColor="text-green-500 dark:text-green-200"
                            value=""
                            description="Project Serving Time"/>

                        <x-score-card
                            icon="fas fa-users"
                            iconBackground="bg-blue-100 dark:bg-blue-800"
                            iconColor="text-blue-500 dark:text-blue-200"
                            value=""
                            description="Total Working Volume"/>

                        <x-score-card
                            icon="fas fa-file-alt"
                            iconBackground="bg-orange-100 dark:bg-orange-800"
                            iconColor="text-orange-500 dark:text-orange-200"
                            value=""
                            description="Total Project"/>

                        <x-score-card
                            icon="fas fa-list-alt"
                            iconBackground="bg-purple-100 dark:bg-purple-800"
                            iconColor="text-purple-500 dark:text-purple-200"
                            value=""
                            description="Total Talent"/>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr] gap-4 mb-4">
                        <div div class="p-3 md:p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                        </div>
                        <div div class="p-3 md:p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                            <h2 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-white">On Going Project</h2>
                            <div class="mt-4 grid grid-cols-1 gap-4 sm:gap-3">

                                {{-- Waiting Talent Card --}}
                                <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-lg border dark:border-none ">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-800 text-yellow-500 dark:text-yellow-200 flex items-center justify-center">
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
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-800 text-blue-500 dark:text-blue-200 flex items-center justify-center">
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
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-800 text-orange-500 dark:text-orange-200 flex items-center justify-center">
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
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 dark:bg-red-800 text-red-500 dark:text-red-200 flex items-center justify-center">
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
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 dark:bg-green-800 text-green-500 dark:text-green-200 flex items-center justify-center">
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
