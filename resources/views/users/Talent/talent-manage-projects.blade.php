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
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               placeholder="Search projects..." 
                               class="w-64 pl-10 pr-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-purple-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter Component --}}
            <div class="flex justify-between items-center mb-6">
                {{-- Project Status Tabs --}}
                <div class="inline-flex rounded-lg shadow-sm">
                    <a href="#" class="px-4 py-2 text-sm font-medium bg-white text-gray-900 border border-gray-200 rounded-l-lg hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-purple-500 active:bg-purple-100 active:text-purple-600">
                        All Projects
                    </a>
                    <a href="#" class="px-4 py-2 text-sm font-medium bg-white text-gray-900 border-t border-b border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-purple-500">
                        Ongoing
                    </a>
                    <a href="#" class="px-4 py-2 text-sm font-medium bg-white text-gray-900 border-t border-b border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-purple-500">
                        QC
                    </a>
                    <a href="#" class="px-4 py-2 text-sm font-medium bg-white text-gray-900 border border-gray-200 rounded-r-lg hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-purple-500">
                        Completed
                    </a>
                </div>

                {{-- Sort and Filter Options --}}
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        <select class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 appearance-none pr-8">
                            <option selected>Newest First</option>
                            <option>Oldest First</option>
                            <option>Name A-Z</option>
                            <option>Name Z-A</option>
                        </select>
                    </div>
                    <button type="button" class="inline-flex items-center px-3 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-purple-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>
                </div>
            </div>

            {{-- Project List Section --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">All Projects</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Manage all your projects across different stages</p>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">PROJECT NAME</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">TYPE</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">DEADLINE</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">STATUS</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">PROGRESS</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">ACTIONS</th>
                            </tr>
                        </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <tr>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-900 dark:text-white">Keiken Ninzu - Episode 49</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">Character Design</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">May 25, 2025</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">In QC</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">100%</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-3">
                                            <a href="#" class="text-gray-600 hover:text-gray-900">Edit</a>
                                            <a href="{{ route('talent.project.detail') }}" class="text-gray-600 hover:text-gray-900">Details</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-900 dark:text-white">Mystic Warriors - Main Character</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">Character Design</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">May 30, 2025</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">65%</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-3">
                                            <a href="#" class="text-gray-600 hover:text-gray-900">Edit</a>
                                            <a href="#" class="text-gray-600 hover:text-gray-900">Details</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-900 dark:text-white">Stellar Odyssey - Background Art</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">Background Art</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">June 5, 2025</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">40%</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-3">
                                            <a href="#" class="text-gray-600 hover:text-gray-900">Edit</a>
                                            <a href="#" class="text-gray-600 hover:text-gray-900">Details</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-900 dark:text-white">Urban Legends - Chapter 3</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">Storyboarding</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">May 20, 2025</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">100%</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-3">
                                            <a href="#" class="text-gray-600 hover:text-gray-900">Edit</a>
                                            <a href="#" class="text-gray-600 hover:text-gray-900">Details</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-900 dark:text-white">Dragon Realm - Episode 12</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">Coloring</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">May 22, 2025</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">In QC</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">100%</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-3">
                                            <a href="#" class="text-gray-600 hover:text-gray-900">Edit</a>
                                            <a href="#" class="text-gray-600 hover:text-gray-900">Details</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-900 dark:text-white">Neon City - Cyberpunk Elements</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">Concept Art</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">June 10, 2025</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-gray-500 dark:text-gray-400">100%</span>
                                </td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-3">
                                            <a href="#" class="text-gray-600 hover:text-gray-900">Edit</a>
                                            <a href="#" class="text-gray-600 hover:text-gray-900">Details</a>
                                        </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
