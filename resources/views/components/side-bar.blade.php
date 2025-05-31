<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <di v class="flex items-center justify-start rtl:justify-end">
            <button id="toggleSidebarBtn" type="button"
                class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                    </path>
                </svg>
            </button>
           <x-application-logo />
        </di>
        <div class="flex items-center">
            <x-theme-switcher class="h-2 "/>
            <a href="{{ url('user/profile') }}" class="flex items-center ms-3">
                <div class="flex text-sm  rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 text-center" >
                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="rounded-full w-9 h-9  object-cover">
                    <div class="flex flex-col text-left">
                    <span class="hidden md:block text-dark dark:text-white ms-2 font-bold">{{ $user->name ?? 'Username'  }}</span>
                    <span class="hidden md:block text-gray-500 dark:text-white ms-2">{{ $user->email ?? 'Usermame@example.com' }}</span>
                    </div>
                </div>
            </a>
          </div>
      </div>
    </div>
  </nav>

  <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
     <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @if (Auth::user()->role == 'superadmin')
            <li>
                <a href="{{ url('/') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white
                   group
                   {{ Request::is('superadmin') ? 'bg-blue-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-6 h-6 transition duration-75
                        {{ Request::is('superadmin') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z"
                              clip-rule="evenodd" />
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/superadmin/companies') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white
                   group
                   {{ Request::is('superadmin/companies') ? 'bg-blue-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-6 h-6 transition duration-75
                    {{ Request::is('superadmin/companies') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M7.5 5.25a3 3 0 0 1 3-3h3a3 3 0 0 1 3 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0 1 12 15.75c-2.73 0-5.357-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 0 1 7.5 5.455V5.25Zm7.5 0v.09a49.488 49.488 0 0 0-6 0v-.09a1.5 1.5 0 0 1 1.5-1.5h3a1.5 1.5 0 0 1 1.5 1.5Zm-3 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                        <path d="M3 18.4v-2.796a4.3 4.3 0 0 0 .713.31A26.226 26.226 0 0 0 12 17.25c2.892 0 5.68-.468 8.287-1.335.252-.084.49-.189.713-.311V18.4c0 1.452-1.047 2.728-2.523 2.923-2.12.282-4.282.427-6.477.427a49.19 49.19 0 0 1-6.477-.427C4.047 21.128 3 19.852 3 18.4Z" />
                      </svg>

                    <span class="ms-3">Manage Company</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/superadmin/talents') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white
                   group
                   {{ Request::is('superadmin/talents') ? 'bg-blue-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-6 h-6 transition duration-75
                    {{ Request::is('superadmin/talents') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd" />
                        <path d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                      </svg>

                    <span class="ms-3">Manage Talent</span>
                </a>
            </li>

            {{-- Nav bar untuk superadmin --}}

            @elseif(Auth::user()->role == 'company')
            <li>
                <a href="{{ url('/') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white
                   group
                   {{ Request::is('company') ? 'bg-blue-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-6 h-6 transition duration-75
                        {{ Request::is('company') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z"
                              clip-rule="evenodd" />
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/company/settings') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white
                   group
                   {{ Request::is('company/settings') ? 'bg-blue-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-6 h-6 transition duration-75
                    {{ Request::is('company/settings') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M11.828 2.25c-.916 0-1.699.663-1.85 1.567l-.091.549a.798.798 0 0 1-.517.608 7.45 7.45 0 0 0-.478.198.798.798 0 0 1-.796-.064l-.453-.324a1.875 1.875 0 0 0-2.416.2l-.243.243a1.875 1.875 0 0 0-.2 2.416l.324.453a.798.798 0 0 1 .064.796 7.448 7.448 0 0 0-.198.478.798.798 0 0 1-.608.517l-.55.092a1.875 1.875 0 0 0-1.566 1.849v.344c0 .916.663 1.699 1.567 1.85l.549.091c.281.047.508.25.608.517.06.162.127.321.198.478a.798.798 0 0 1-.064.796l-.324.453a1.875 1.875 0 0 0 .2 2.416l.243.243c.648.648 1.67.733 2.416.2l.453-.324a.798.798 0 0 1 .796-.064c.157.071.316.137.478.198.267.1.47.327.517.608l.092.55c.15.903.932 1.566 1.849 1.566h.344c.916 0 1.699-.663 1.85-1.567l.091-.549a.798.798 0 0 1 .517-.608 7.52 7.52 0 0 0 .478-.198.798.798 0 0 1 .796.064l.453.324a1.875 1.875 0 0 0 2.416-.2l.243-.243c.648-.648.733-1.67.2-2.416l-.324-.453a.798.798 0 0 1-.064-.796c.071-.157.137-.316.198-.478.1-.267.327-.47.608-.517l.55-.091a1.875 1.875 0 0 0 1.566-1.85v-.344c0-.916-.663-1.699-1.567-1.85l-.549-.091a.798.798 0 0 1-.608-.517 7.507 7.507 0 0 0-.198-.478.798.798 0 0 1 .064-.796l.324-.453a1.875 1.875 0 0 0-.2-2.416l-.243-.243a1.875 1.875 0 0 0-2.416-.2l-.453.324a.798.798 0 0 1-.796.064 7.462 7.462 0 0 0-.478-.198.798.798 0 0 1-.517-.608l-.091-.55a1.875 1.875 0 0 0-1.85-1.566h-.344ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
                    </svg>

                    <span class="ms-3">General Settings</span>
                </a>
            </li>

            {{-- Nav bar untuk company admin --}}

            @elseif(Auth::user()->role == 'talent')
            <li>
                <a href="{{ url('/') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white
                   group
                   {{ Request::is('company') ? 'bg-blue-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-6 h-6 transition duration-75
                        {{ Request::is('company') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z"
                              clip-rule="evenodd" />
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>


            {{-- Nav bar untuk talent --}}
            @endif



            <li>
                <a href="{{ url('/user/profile') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white group {{ Request::is('user/profile') ? 'bg-blue-500 text-white dark:bg-gray-900' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-6 h-6 text-gray-500 transition duration-75 {{ Request::is('user/profile') ? 'text-white dark:text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                    </svg>
                <span class="flex-1 ms-3 whitespace-nowrap">Profile</span>
                </a>
            </li>
           <li>
            <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
              <a href="{{ route('logout') }}" class="flex items-center p-2 text-red-500 rounded-lg dark:text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700 group" @click.prevent="$root.submit();">
                 <svg class="shrink-0 w-6 h-6 text-red-500 transition duration-75 dark:text-red-500 group-hover:text-red-500 dark:group-hover:text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-4.28 9.22a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72h5.69a.75.75 0 0 0 0-1.5h-5.69l1.72-1.72a.75.75 0 0 0-1.06-1.06l-3 3Z" clip-rule="evenodd" />
                  </svg>
                 <span class="flex-1 ms-3 whitespace-nowrap">Log Out</span>
              </a>
            </form>
           </li>
        </ul>
     </div>

  </aside>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById("logo-sidebar");
        const toggleBtn = document.getElementById("toggleSidebarBtn");

        toggleBtn.addEventListener("click", function () {
            // Toggle class translate-x-full untuk sidebar
            sidebar.classList.toggle("-translate-x-full");

            // Jika sidebar sedang aktif (tidak ada class -translate-x-full)
            if (!sidebar.classList.contains("-translate-x-full")) {
                toggleBtn.classList.add("bg-gray-200");
            } else {
                toggleBtn.classList.remove("bg-gray-200");
            }
        });
    });
</script>

