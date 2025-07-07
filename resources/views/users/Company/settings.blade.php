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
                        @if(isset($projectType) && isset($sops))
                            <a href="javascript:void(0);" class="tab-link py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-300 hover:text-blue-600 hover:border-blue-300" data-target="sop-details">SOP Details</a>
                        @endif
                        <a href="javascript:void(0);" class="tab-link py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-300 hover:text-blue-600 hover:border-blue-300" data-target="team-settings">Team Settings</a>
                    </nav>
                </div>

                @if(session('success'))
                <x-alert type="success" :message="session('success')" />
                @endif

                @if(session('error'))
                    <x-alert type="error" :message="session('error')" />
                @endif

                @if(request('error'))
                    <x-alert type="error" :message="request('error')" />
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

                    <!-- SOP Details Content -->
                    <div id="sop-details" class="hidden">
                        @if(isset($projectType) && isset($sops))
                            <x-sop-details-information :projectType="$projectType" :sops="$sops" />
                        @else
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                                <div class="text-center py-12">
                                    <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Project Type Selected</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">Please select a project type from the SOP Settings tab to view its detailed SOPs.</p>
                                    <button type="button" onclick="showTab('sop-settings')" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Go to SOP Settings
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Team Settings Content -->
                    <div id="team-settings" class="hidden">
                        <x-team-settings :company="$company" :teamMembers="$teamMembers" :invitations="$invitations" />
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
                showTab(tab.getAttribute('data-target'));
            });
        });

        // Check URL parameters to show specific tab on page load
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab');
        
        if (activeTab) {
            // Check if the requested tab exists
            const targetTab = document.querySelector(`[data-target="${activeTab}"]`);
            if (targetTab) {
                showTab(activeTab);
                
                // Show SOP Details tab if we're on SOP Details page
                if (activeTab === 'sop-details') {
                    targetTab.style.display = 'block';
                }
            } else {
                // If the requested tab doesn't exist, show the first available tab
                if (tabs.length > 0) {
                    tabs[0].click();
                }
            }
        } else {
            // Show the first tab by default
            if (tabs.length > 0) {
                tabs[0].click();
            }
        }
    });

    // Function to programmatically show a specific tab
    function showTab(targetId) {
        const tabs = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('#tab-content > div');

        // Remove active styles from all tabs
        tabs.forEach(t => t.classList.remove('border-blue-600', 'text-blue-600', 'active'));
        tabs.forEach(t => t.classList.add('border-transparent', 'text-gray-500'));

        // Hide all tab contents
        tabContents.forEach(content => content.classList.add('hidden'));

        // Find and activate the target tab
        const targetTab = document.querySelector(`[data-target="${targetId}"]`);
        if (targetTab) {
            targetTab.classList.add('border-blue-600', 'text-blue-600', 'active');
            targetTab.classList.remove('border-transparent', 'text-gray-500');
        }

        // Show corresponding content
        const targetContent = document.getElementById(targetId);
        if (targetContent) {
            targetContent.classList.remove('hidden');
        }

        // Update URL with the active tab (except for SOP Details)
        if (targetId !== 'sop-details') {
            const url = new URL(window.location);
            url.searchParams.set('tab', targetId);
            
            // Remove project_type_id when switching away from SOP Details
            if (url.searchParams.has('project_type_id')) {
                url.searchParams.delete('project_type_id');
            }
            
            // Update browser history without reloading the page
            window.history.pushState({}, '', url);
            
            // Hide SOP Details tab when switching to other tabs
            const sopDetailsTab = document.querySelector('[data-target="sop-details"]');
            if (sopDetailsTab) {
                sopDetailsTab.style.display = 'none';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const url = new URL(window.location);
        if (url.searchParams.has('error')) {
            url.searchParams.delete('error');
            window.history.replaceState({}, '', url);
        }
    });

</script>
@endpush
