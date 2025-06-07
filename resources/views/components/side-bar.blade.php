<aside id="logo-sidebar" class="fixed top-0 left-0 z-60 w-64 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700 flex flex-col" aria-label="Sidebar">
    <!-- Logo Section -->
    <div class="px-5 py-3 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-black dark:bg-black flex items-center justify-center">
                <x-application-logo class="w-5 h-5" />
            </div>
            <div class="flex flex-col">
                <span class="font-semibold text-sm text-gray-900 dark:text-white">Padma Cloud Office</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst(Auth::user()->role) }}</span>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="flex-1 px-3 py-4 overflow-y-auto">
        <ul class="space-y-2 font-medium">
            @if (Auth::user()->role == 'superadmin')
                {{-- Dashboard --}}
                <li>
                    <a href="{{ url('/superadmin') }}"
                       class="flex items-center p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 {{ Request::is('superadmin') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v2.25m-18 0h18M5.25 6h.008v.008H5.25V6zM7.5 6h.008v.008H7.5V6zm2.25 0h.008v.008H9.75V6z" />
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>

                {{-- Manage Companies --}}
                <li>
                    <a href="{{ url('/superadmin/companies') }}"
                       class="flex items-center p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 {{ Request::is('superadmin/companies*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                        <span class="ml-3">Manage Companies</span>
                    </a>
                </li>

                {{-- Manage Talents --}}
                <li>
                    <a href="{{ url('/superadmin/talents') }}"
                       class="flex items-center p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 {{ Request::is('superadmin/talents*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        <span class="ml-3">Manage Talents</span>
                    </a>
                </li>

            @elseif (Auth::user()->role == 'company')
                {{-- Dashboard --}}
                <li>
                    <a href="{{ url('/company') }}"
                       class="flex items-center p-2 text-gray-900 rounded-md dark:text-white
                   group {{ Request::is('company') ? 'bg-red-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="shrink-0 w-6 h-6 transition duration-75
                        {{ Request::is('company') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v2.25m-18 0h18M5.25 6h.008v.008H5.25V6zM7.5 6h.008v.008H7.5V6zm2.25 0h.008v.008H9.75V6z" />
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>

                {{-- Settings --}}
                <li>
                    <a href="{{ url('/company/settings') }}"
                       class="flex items-center p-2 text-gray-900 rounded-md dark:text-white
                        group {{ Request::is('company/settings') ? 'bg-red-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="shrink-0 w-6 h-6 transition duration-75
                        {{ Request::is('company/settings') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        <span class="ml-3">General Settings</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/company/statistics') }}"
                       class="flex items-center p-2 text-gray-900 rounded-md dark:text-white
                        group {{ Request::is('company/statistics') ? 'bg-red-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="shrink-0 w-6 h-6 transition duration-75
                        {{ Request::is('company/statistics') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        <span class="ml-3">Statistic</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/company/projects') }}"
                       class="flex items-center p-2 text-gray-900 rounded-md dark:text-white
                        group {{ Request::is('company/projects') ? 'bg-red-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="shrink-0 w-6 h-6 transition duration-75
                        {{ Request::is('company/projects') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        <span class="ml-3">Manage Project</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/company/manage-talents') }}"
                       class="flex items-center p-2 text-gray-900 rounded-md dark:text-white
                        group {{ Request::is('company/manage-talents') ? 'bg-red-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="shrink-0 w-6 h-6 transition duration-75
                        {{ Request::is('company/manage-talents') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        <span class="ml-3">Manage Talent</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/company/settings') }}"
                       class="flex items-center p-2 text-gray-900 rounded-md dark:text-white
                   group {{ Request::is('company/settings') ? 'bg-red-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="shrink-0 w-6 h-6 transition duration-75
                        {{ Request::is('company/settings') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        <span class="ml-3">Report</span>
                    </a>
                </li>


            @elseif(Auth::user()->role == 'talent')
            {{-- Company Detail --}}
            <li>
                <a href="{{ $companySlug ? url('/talent/company/' . $companySlug) : '#' }}"
                   class="flex items-center p-2 text-gray-900 rounded-md dark:text-white
                   group {{ Request::is('talent/company/*') ? 'bg-red-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-6 h-6 transition duration-75
                        {{ Request::is('talent/company/*') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z"
                              clip-rule="evenodd" />
                    </svg>
                    <span class="ms-3">Company Detail</span>
                </a>
            </li>

            {{-- Manage Projects --}}
                <li>
                    <a href="{{ url('/talent/manage-projects') }}"
                       class="flex items-center p-2 text-gray-900 rounded-md dark:text-white
                   group {{ Request::is('talent/manage-projects') ? 'bg-red-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-6 h-6 {{ Request::is('talent/manage-projects') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                        </svg>
                        <span class="ml-3">Manage Projects</span>

                    </a>
                </li>

                {{-- Report --}}
                <li>
                    <a href="{{ url('/talent/report') }}"
                       class="flex items-center p-2 text-gray-900 rounded-md dark:text-white
                   group {{ Request::is('talent/report*') ? 'bg-red-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-6 h-6 {{ Request::is('talent/report') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                        </svg>
                        <span class="ml-3">Report</span>
                    </a>
                </li>
            @endif

            {{-- Profile Link (Common for all roles) --}}
            <li>
                <a href="{{ url('/user/profile') }}"
                   class="flex items-center p-2 text-gray-900 rounded-md dark:text-white
                   group {{ Request::is('user/profile*') ? 'bg-red-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-6 h-6 {{ Request::is('user/profile') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="ml-3">Profile</span>
                </a>
            </li>

        </ul>
    </div>


     <!-- User Profile Section -->
     <div class="mt-auto border-t border-gray-200 dark:border-gray-700">
        <div class="px-5 py-4">
            <div class="flex items-center gap-3">
                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-600">
                <div class="flex flex-col min-w-0">
                    <span class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" x-data class="ml-auto">
                    @csrf

                        <button type="submit"

                            @click.prevent="$root.submit();"
                            class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

</aside>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById("logo-sidebar");
        const toggleBtn = document.getElementById("toggleSidebarBtn");

        toggleBtn.addEventListener("click", function () {
            sidebar.classList.toggle("-translate-x-full");
            toggleBtn.classList.toggle("bg-gray-200");
        });
    });
</script>
