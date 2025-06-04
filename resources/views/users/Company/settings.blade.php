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
                        <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600" aria-current="page">Project Settings</button>
                        <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">SOP Settings</button>
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

                    <!-- SOP Settings Content -->
                    <div id="sop-settings" class="hidden">
                        <x-sop-settings :projectTypes="$projectTypes" />
                    </div>

                    <!-- Team Settings Content -->
                    <div id="team-settings" class="hidden">
                        <x-team-settings :company="$company" :teamMembers="$teamMembers" />
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

@push('scripts')
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
@endpush
