<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-100 px-3">
    <div class="px-4 py-2.5">
        <div class="flex items-center justify-between">
            <!-- Left side - Brand -->
            <div class="flex items-center">
                <button id="toggleSidebarBtn" type="button"
                    class="lg:hidden sm:hidden p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <a href="{{ route('talent.landing.page') }}" class="flex items-center ml-2 lg:ml-0">
                    <span class="text-xl font-semibold text-black">Padma Cloud Office</span>
                </a>
            </div>

            <!-- Center - Search Bar
            <div class="flex-1 max-w-2xl mx-4 lg:mx-8">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="search" class="w-full p-2.5 pl-10 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-purple-500 focus:border-purple-500" placeholder="Search...">
                </div>
            </div> -->

            <!-- Right side - Icons -->
            <div class="flex items-center space-x-3">
                <!-- E-Wallet -->
                <button type="button" onclick="window.location.href='{{ route('talent.e-wallet') }}'" 
                    class="relative p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none transition-all duration-200 ease-in-out transform hover:scale-105 {{ request()->routeIs('talent.e-wallet') ? 'bg-purple-100 text-purple-600 hover:bg-purple-100' : '' }}">
                    <span class="sr-only">E-Wallet</span>
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3 10H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <!-- Analytics -->
                <button type="button" onclick="window.location.href='{{ route('talent.statistic') }}'" 
                    class="relative p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none transition-all duration-200 ease-in-out transform hover:scale-105 {{ request()->routeIs('talent.statistic') ? 'bg-purple-100 text-purple-600 hover:bg-purple-100' : '' }}">
                    <span class="sr-only">Analytics</span>
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 5v14h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M5 14c4-1 6-3 8-5s4-4 6-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </button>

                <!-- Documentation -->
                <button type="button" onclick="window.location.href=''" 
                    class="relative p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none transition-all duration-200 ease-in-out transform hover:scale-105 {{ request()->routeIs('talent.documentation') ? 'bg-purple-100 text-purple-600 hover:bg-purple-100' : '' }}">
                    <span class="sr-only">Documentation</span>
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    @if(request()->routeIs('talent.documentation'))
                        <span class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-purple-600 rounded-full"></span>
                    @endif
                </button>

                <!-- Notifications -->
                <button type="button" onclick="window.location.href=''" 
                    class="relative p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none transition-all duration-200 ease-in-out transform hover:scale-105 {{ request()->routeIs('talent.notifications') ? 'bg-purple-100 text-purple-600 hover:bg-purple-100' : '' }}">
                    <span class="sr-only">View notifications</span>
                    <div class="relative">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <div class="absolute -top-1 -right-1 w-2 h-2 bg-purple-500 rounded-full"></div>
                    </div>
                    @if(request()->routeIs('talent.notifications'))
                        <span class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-purple-600 rounded-full"></span>
                    @endif
                </button>

                <!-- Settings -->
                <button type="button" onclick="window.location.href=''" 
                    class="relative p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none transition-all duration-200 ease-in-out transform hover:scale-105 {{ request()->routeIs('talent.settings') ? 'bg-purple-100 text-purple-600 hover:bg-purple-100' : '' }}">
                    <span class="sr-only">Settings</span>
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    @if(request()->routeIs('talent.settings'))
                        <span class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-purple-600 rounded-full"></span>
                    @endif
                </button>

                <x-theme-switcher />

                <!-- Profile -->
                <!-- <button type="button" class="p-2 flex items-center justify-center w-8 h-8 rounded-full bg-gray-100">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover">
                </button> -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="p-2 flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 focus:outline-none">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover">
                    </button>
                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 z-50 mt-2 w-36 bg-white border border-gray-200 rounded-lg shadow-md py-1 text-sm text-gray-700">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-100">Detail</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
