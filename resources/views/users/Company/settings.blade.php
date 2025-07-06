@extends('layouts.app')
@section('title', 'Dashboard')
@section('meta_description', 'Padma Cloud Office')

@section('content')


     <div class="md:p-4 sm:ml-64">
        <div class="py-4 md:p-4">

            <div class="container mx-auto">
                <!-- Tab Navigation -->
                <div class="bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 mb-6">
                    <nav class="flex space-x-8 px-4" aria-label="Tabs" id="settings-tabs">
                        <a href="javascript:void(0);" class="tab-link py-4 px-1 border-b-2 font-medium text-sm border-blue-600 text-blue-600 dark:text-white active" data-target="project-settings">Project Settings</a>
                        <a href="javascript:void(0);" class="tab-link py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-300 hover:text-blue-600 hover:border-blue-300" data-target="sop-settings">SOP Settings</a>
                        <a href="javascript:void(0);" class="tab-link py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-300 hover:text-blue-600 hover:border-blue-300" data-target="team-settings">Team Settings</a>
                        <a href="javascript:void(0);" class="tab-link py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-300 hover:text-blue-600 hover:border-blue-300" data-target="billing-settings">Billing Settings</a>
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
                        <h2 class="text-xl font-semibold mb-4 dark:text-white">Billing Settings</h2>
                        <p class="text-gray-600 dark:text-gray-400">Content for Billing Settings will go here.</p>
                    </div>
                </div>

            </div>

        </div>
     </div>


@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('#tab-content > div');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active styles from all tabs
                tabs.forEach(t => t.classList.remove('border-blue-600', 'text-blue-600', 'active'));
                tabs.forEach(t => t.classList.add('border-transparent', 'text-gray-500'));

                // Hide all tab contents
                tabContents.forEach(content => content.classList.add('hidden'));

                // Activate clicked tab
                tab.classList.add('border-blue-600', 'text-blue-600', 'active');
                tab.classList.remove('border-transparent', 'text-gray-500');

                // Show corresponding content
                const targetId = tab.getAttribute('data-target');
                document.getElementById(targetId).classList.remove('hidden');
            });
        });

        // Show the first tab by default
        if (tabs.length > 0) {
            tabs[0].click();
        }
    });
</script>
@endpush
