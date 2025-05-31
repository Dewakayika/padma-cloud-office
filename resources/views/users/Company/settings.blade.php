@extends('layouts.app')
@section('title', 'Dashboard')
@section('meta_description', 'Padma Cloud Office')

@section('content')


     <div class="p-2 md:p-4 sm:ml-64">
        <div class="p-2 md:p-4">



            <div class="container mx-auto p-4">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm  border-blue-500 text-blue-600"  aria-current="page">Project Settings</button>
                        <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Team Settings</button>
                        <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">Billing Settings</button>
                    </nav>
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

                <!-- Tab Content -->
                <div id="tab-content" class="mt-6">
                    <!-- Project Settings Content -->
                    <div id="project-settings" class="block">
                        <x-project-settings :company="$company" :projectTypes="$projectTypes" />
                    </div>

                    <!-- Team Settings Content -->
                    <div id="team-settings" class="hidden">
                        <div class="flex items-center mb-6">
                            <div class="rounded-full bg-green-100 p-3 mr-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5m-5 0a2 2 0 100-4m0 4a2 2 0 110-4m0 4H12V5c0-.955-.424-1.555-1-2l-2.343 2.343A1.001 1.001 0 009 5.414V9H4a2 2 0 00-2 2v9a2 2 0 002 2h12a2 2 0 002-2v-1zm-6-.75a.75.75 0 000 1.5h.01a.75.75 0 000-1.5H8z"></path></svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-semibold">Team Setup</h1>
                                <p class="text-gray-600">Add your team so you can assign projects smoothly and collaborate effectively</p>
                            </div>
                        </div>

                        <h2 class="text-xl font-semibold mb-4">Team Members (2)</h2>

                        <!-- Existing Team Members -->
                        <div class="bg-gray-100 p-4 rounded-lg mb-4 flex items-center justify-between">
                            <div>
                                <p class="font-semibold">jhon</p>
                                <p class="text-gray-600 text-sm">jhon@gmail.com</p>
                            </div>
                            <div class="flex items-center">
                                <span class="bg-gray-200 text-gray-700 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">Project Manager</span>
                                <button class="text-gray-500 hover:text-gray-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="bg-gray-100 p-4 rounded-lg mb-6 flex items-center justify-between">
                            <div>
                                <p class="font-semibold">jhon</p>
                                <p class="text-gray-600 text-sm">company@gmail.com</p>
                            </div>
                            <div class="flex items-center">
                                <span class="bg-gray-200 text-gray-700 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full">Talent</span>
                                 <button class="text-gray-500 hover:text-gray-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Add New Team Member -->
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-semibold mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Add Team Member
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                    <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        <option>Select role</option>
                                        <!-- Add more role options here -->
                                    </select>
                                </div>
                            </div>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-md">Add Team Member</button>
                        </div>
                    </div>



                    <!-- Billing Settings Content -->
                    <div id="billing-settings" class="hidden">
                         <h2 class="text-xl font-semibold mb-4">Billing Settings</h2>
                        <p>Content for Billing Settings will go here.</p>
                    </div>
                </div>

            </div>

        </div>
     </div>


@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('nav[aria-label="Tabs"] button');
        const tabContents = document.querySelectorAll('#tab-content > div');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const targetId = tab.textContent.toLowerCase().replace(' ', '-').replace('settings', 'settings');

                // Hide all tab contents and deactivate all tabs
                tabContents.forEach(content => content.classList.add('hidden'));
                tabs.forEach(t => t.classList.replace('border-blue-500', 'border-transparent'));
                 tabs.forEach(t => t.classList.replace('text-blue-600', 'text-gray-500'));

                // Show the target tab content and activate the clicked tab
                document.getElementById(targetId).classList.remove('hidden');
                tab.classList.replace('border-transparent', 'border-blue-500');
                tab.classList.replace('text-gray-500', 'text-blue-600');
            });
        });

        // Show the first tab by default
         if (tabs.length > 0) {
            const initialTargetId = tabs[0].textContent.toLowerCase().replace(' ', '-').replace('settings', 'settings');
            document.getElementById(initialTargetId).classList.remove('hidden');
             tabs[0].classList.replace('border-transparent', 'border-blue-500');
            tabs[0].classList.replace('text-gray-500', 'text-blue-600');
        }
    });
</script>
