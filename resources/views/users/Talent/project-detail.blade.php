@extends('layouts.app')
@section('title', 'Project Detail')
@section('meta_description', 'Project Detail Page')

@section('content')
<div class="sm:ml-64">
    <div class="py-4 space-y-6">
        {{-- Breadcrumb Navigation --}}
        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-white dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('talent#index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ route('talent.manage.projects') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Project Overview</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Project Keiken Ninzu Eps.49</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Project Banner with Countdown --}}
        <div class="relative rounded-lg overflow-hidden h-48">
            <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97" alt="Project Banner" class="w-full h-full object-cover opacity-50">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div class="absolute inset-0 flex items-center justify-between px-6">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center">
                        <img src="https://webtoons-static.pstatic.net/image/favicon/favicon.ico" alt="WebToon" class="w-12 h-12 object-contain">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Keiken Ninzu</h1>
                        <p class="text-gray-200">Episode 49</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="grid grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white" id="days">16</div>
                            <div class="text-sm text-red-500 font-medium">DAY</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white" id="hours">23</div>
                            <div class="text-sm text-red-500 font-medium">HOUR</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white" id="minutes">53</div>
                            <div class="text-sm text-red-500 font-medium">MIN</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white" id="seconds">48</div>
                            <div class="text-sm text-red-500 font-medium">SEC</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Project Information and Status Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Project Information --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Project Information</h2>
                        <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Project Name:</p>
                                <p class="text-base text-gray-900 dark:text-white">Keiken Ninzu</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Update:</p>
                                <p class="text-base text-gray-900 dark:text-white">Sun, Jun 2025</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">QC Talent:</p>
                                <p class="text-base text-gray-900 dark:text-white">Oka Dharmawan</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Project Finish Date:</p>
                                <p class="text-base text-gray-900 dark:text-white">Not finish yet</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Project Assign:</p>
                                <p class="text-base text-gray-900 dark:text-white">Thu, May 2025</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Project File:</p>
                                <a href="#" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">Download File</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Project Records --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow mt-6">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Project Records</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <th class="px-4 py-3">Project Stage</th>
                                        <th class="px-4 py-3">Updated Date</th>
                                        <th class="px-4 py-3">Panel</th>
                                        <th class="px-4 py-3">Project File</th>
                                        <th class="px-4 py-3">QC Message</th>
                                        <th class="px-4 py-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr>
                                        <td class="px-4 py-3">First Draft</td>
                                        <td class="px-4 py-3">Thu, May 2025</td>
                                        <td class="px-4 py-3">-</td>
                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 text-xs text-white bg-blue-500 rounded-full">PROJECT FILE</span>
                                        </td>
                                        <td class="px-4 py-3">-</td>
                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 text-xs text-white bg-yellow-500 rounded-full">REVIEW PROJECT</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">First Draft Submitted</td>
                                        <td class="px-4 py-3">Thu, May 2025</td>
                                        <td class="px-4 py-3">-</td>
                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 text-xs text-white bg-blue-500 rounded-full">PROJECT FILE</span>
                                        </td>
                                        <td class="px-4 py-3">-</td>
                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 text-xs text-white bg-blue-500 rounded-full">SHARE PROJECT</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">Revise 1</td>
                                        <td class="px-4 py-3">Tue, May 2025</td>
                                        <td class="px-4 py-3">-</td>
                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 text-xs text-white bg-blue-500 rounded-full">PROJECT FILE</span>
                                        </td>
                                        <td class="px-4 py-3">-</td>
                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 text-xs text-white bg-yellow-500 rounded-full">REVIEW PROJECT</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Project Revision --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow mt-6">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Project Revision</h2>
                            <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                                Add Revision
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <th class="px-4 py-3">Project Stage</th>
                                        <th class="px-4 py-3">Date</th>
                                        <th class="px-4 py-3">Panel</th>
                                        <th class="px-4 py-3">Message</th>
                                        <th class="px-4 py-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr>
                                        <td class="px-4 py-3">Revise 1</td>
                                        <td class="px-4 py-3">Mon, May 2025</td>
                                        <td class="px-4 py-3">-</td>
                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 text-xs text-white bg-green-500 rounded-full">OPEN MESSAGE</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex space-x-2">
                                                <span class="px-3 py-1 text-xs text-white bg-yellow-500 rounded-full cursor-pointer">EDIT</span>
                                                <span class="px-3 py-1 text-xs text-white bg-red-500 rounded-full cursor-pointer">DELETE</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Project Status Timeline --}}
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Project Status</h2>
                    <h3 class="text-lg text-gray-700 dark:text-gray-300 mb-6">Keiken Ninzu 49</h3>
                    
                    <div class="relative">
                        <div class="absolute left-4 h-full w-0.5 bg-gray-200"></div>
                        
                        <div class="relative flex items-center mb-8">
                            <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full z-10">
                                <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-medium text-gray-900 dark:text-white">Project Asign</h4>
                                <p class="text-sm text-gray-500">THU, MAY 2025 | 17:23 PM</p>
                            </div>
                        </div>

                        <div class="relative flex items-center mb-8">
                            <div class="flex items-center justify-center w-8 h-8 bg-orange-100 rounded-full z-10">
                                <div class="w-4 h-4 bg-orange-500 rounded-full"></div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-medium text-gray-900 dark:text-white">QC First Draft</h4>
                                <p class="text-sm text-gray-500">THU, MAY 2025 | 17:24 PM</p>
                            </div>
                        </div>

                        <div class="relative flex items-center mb-8">
                            <div class="flex items-center justify-center w-8 h-8 bg-yellow-100 rounded-full z-10">
                                <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-medium text-gray-900 dark:text-white">First Draft Submitted</h4>
                                <p class="text-sm text-gray-500">THU, MAY 2025 | 17:28 PM</p>
                            </div>
                        </div>

                        <div class="relative flex items-center mb-8">
                            <div class="flex items-center justify-center w-8 h-8 bg-red-100 rounded-full z-10">
                                <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-medium text-gray-900 dark:text-white">Revision 1</h4>
                                <p class="text-sm text-gray-500">MON, MAY 2025 | 13:35 PM</p>
                            </div>
                        </div>

                        <div class="relative flex items-center">
                            <div class="flex items-center justify-center w-8 h-8 bg-orange-100 rounded-full z-1">
                                <div class="w-4 h-4 bg-orange-500 rounded-full"></div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-base font-medium text-gray-900 dark:text-white">QC Revise 1</h4>
                                <p class="text-sm text-gray-500">TUE, MAY 2025 | 08:52 AM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Set the deadline date (May 25, 2025)
    const deadline = new Date('May 25, 2025 00:00:00').getTime();

    // Update the countdown every second
    const countdown = setInterval(function() {
        const now = new Date().getTime();
        const distance = deadline - now;

        // Calculate days, hours, minutes, seconds
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Update the HTML elements
        document.getElementById('days').innerHTML = String(days).padStart(2, '0');
        document.getElementById('hours').innerHTML = String(hours).padStart(2, '0');
        document.getElementById('minutes').innerHTML = String(minutes).padStart(2, '0');
        document.getElementById('seconds').innerHTML = String(seconds).padStart(2, '0');

        // If the countdown is finished, display expired message
        if (distance < 0) {
            clearInterval(countdown);
            document.getElementById('days').innerHTML = '00';
            document.getElementById('hours').innerHTML = '00';
            document.getElementById('minutes').innerHTML = '00';
            document.getElementById('seconds').innerHTML = '00';
        }
    }, 1000);
</script>
@endpush
