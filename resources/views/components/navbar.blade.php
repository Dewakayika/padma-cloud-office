<nav class="fixed top-0 z-50 w-full lg:w-[calc(100%-16rem)] lg:ml-64 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between min-w-0">
            <div class="flex items-center justify-start">
                <button id="toggleSidebarBtn" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg lg:hidden sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>

                @if(Auth::user()->role == 'talent')
                <a href="{{ url('/talent') }}" class="flex items-center ml-3 gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3" />
                    </svg>
                    <span class="text-xl font-semibold text-gray-800 dark:text-white">{{ $companySlug}} Space</span>
                </a>
                @else
                @endif
            </div>
            <div class="flex items-center  gap-4">
                {{-- Notifications --}}
                <div class="relative">
                    <button type="button" class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">View notifications</span>
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <div class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></div>
                    </button>
                </div>

                @if(Auth::user()->role == 'company')
                {{-- Project Settings --}}
                <a href="{{ url('/company/settings') }}" class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" title="Project Settings">
                    <span class="sr-only">Project Settings</span>
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 2.25c-.621 0-1.125.504-1.125 1.125v.548a7.496 7.496 0 00-2.371.974l-.388-.388a1.125 1.125 0 00-1.59 0l-.795.795a1.125 1.125 0 000 1.59l.388.388a7.496 7.496 0 00-.974 2.371H3.375A1.125 1.125 0 002.25 11.25v1.5c0 .621.504 1.125 1.125 1.125h.548a7.496 7.496 0 00.974 2.371l-.388.388a1.125 1.125 0 000 1.59l.795.795a1.125 1.125 0 001.59 0l.388-.388a7.496 7.496 0 002.371.974v.548c0 .621.504 1.125 1.125 1.125h1.5c.621 0 1.125-.504 1.125-1.125v-.548a7.496 7.496 0 002.371-.974l.388.388a1.125 1.125 0 001.59 0l.795-.795a1.125 1.125 0 000-1.59l-.388-.388a7.496 7.496 0 00.974-2.371h.548c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-.548a7.496 7.496 0 00-.974-2.371l.388-.388a1.125 1.125 0 000-1.59l-.795-.795a1.125 1.125 0 00-1.59 0l-.388.388a7.496 7.496 0 00-2.371-.974v-.548c0-.621-.504-1.125-1.125-1.125h-1.5zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" />
                    </svg>
                </a>
                @endif

                {{-- Theme Switcher --}}
                <x-theme-switcher />
            </div>
        </div>
  </div>
</nav>
