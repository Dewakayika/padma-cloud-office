<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100 dark:bg-gray-900">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Padma Cloud Office')</title>
        <meta name="description" content="@yield('meta_description', 'Padma Cloud Office - Project Management System')">

        {{-- Favicon --}}
        <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}" sizes="16x16">

        {{-- font awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        @stack('styles')
    </head>

    <body class="h-full font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

            <x-banner />

            @if (Auth::check())
                {{-- Sidebar --}}
                <x-side-bar/>
                {{-- Navbar --}}
                <x-navbar />

                {{-- Main Content --}}
                <div class="">
                    <main class="py-16 sm:px-6">
                        @yield('content')
                    </main>
                </div>
                <x-footer />
            @else
                <x-navbar />
                <main>
                    @yield('content')
                </main>
                <x-footer />
            @endif
        </div>

                @stack('modals')
        @livewireScripts
        @stack('scripts')

        {{-- Timezone Detection Script --}}
        <script>
        (function() {
            function getRealTimeTimezone() {
                return Intl.DateTimeFormat().resolvedOptions().timeZone;
            }

            // Function to get all available timezones
            async function getAvailableTimezones() {
                try {
                    const response = await fetch("{{ route('timezones.list') }}");
                    const data = await response.json();
                    return data.all_php_timezones;
                } catch (error) {
                    console.error('Error fetching timezones:', error);
                    return [];
                }
            }

            function updateTimezoneDisplay() {
                const displayTz = hasManualTimezone ? userTimezone : getRealTimeTimezone();
                const timezoneElements = document.querySelectorAll('[data-timezone-display]');
                timezoneElements.forEach(function(element) {
                    element.textContent = displayTz;
                });
                return displayTz;
            }

            function updateCurrentTime() {
                const timeTz = hasManualTimezone ? userTimezone : getRealTimeTimezone();
                const currentTimeElements = document.querySelectorAll('[data-current-time]');
                currentTimeElements.forEach(function(element) {
                    const now = new Date();
                    const localTime = now.toLocaleTimeString('en-US', {
                        timeZone: timeTz,
                        hour12: false,
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });
                    element.textContent = localTime;
                });
            }

            function updateAllTimeDisplays() {
                const displayTz = hasManualTimezone ? userTimezone : getRealTimeTimezone();
                const timeElements = document.querySelectorAll('[data-utc-time]');
                timeElements.forEach(function(element) {
                    const utcTime = element.getAttribute('data-utc-time');
                    if (utcTime) {
                        const localTime = new Date(utcTime).toLocaleString('en-US', {
                            timeZone: displayTz,
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        element.textContent = localTime;
                    }
                });
            }

            // Check if user has manually set a timezone
            const userTimezone = '{{ Auth::user()->timezone ?? "" }}';
            const hasManualTimezone = userTimezone && userTimezone !== '';

            // Initial update with enhanced detection
            const initialTimezone = getRealTimeTimezone();
            console.log('Initial timezone detection:', initialTimezone);
            console.log('User manual timezone:', userTimezone);

            // Only auto-set timezone if user hasn't manually set one
            if (!hasManualTimezone) {
                fetch("{{ route('set.timezone') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ timezone: initialTimezone })
                }).then(function(response) {
                    if (response.ok) {
                        console.log('Initial timezone set to:', initialTimezone);
                    }
                }).catch(function(error) {
                    console.error('Error setting initial timezone:', error);
                });
            } else {
                console.log('Using manual timezone setting:', userTimezone);
            }

            updateTimezoneDisplay();
            updateCurrentTime();
            updateAllTimeDisplays();

            // Update current time every second
            setInterval(function() {
                updateCurrentTime();
            }, 1000);

            // Check for timezone changes every 30 seconds (only if no manual timezone)
            let lastTimezone = hasManualTimezone ? userTimezone : getRealTimeTimezone();
            setInterval(function() {
                if (hasManualTimezone) {
                    // Use manual timezone if set
                    updateTimezoneDisplay();
                    updateAllTimeDisplays();
                    return;
                }

                const currentTimezone = getRealTimeTimezone();
                if (currentTimezone !== lastTimezone) {
                    console.log('Timezone changed from', lastTimezone, 'to', currentTimezone);
                    lastTimezone = currentTimezone;
                    updateTimezoneDisplay();
                    updateAllTimeDisplays();

                    // Send new timezone to backend
                    fetch("{{ route('set.timezone') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ timezone: currentTimezone })
                    }).then(function(response) {
                        if (response.ok) {
                            console.log('Updated timezone to:', currentTimezone);
                        }
                    }).catch(function(error) {
                        console.error('Error updating timezone:', error);
                    });
                }
            }, 30000);

            // Also update when user changes their system timezone (only if no manual timezone)
            window.addEventListener('focus', function() {
                if (hasManualTimezone) {
                    // Use manual timezone if set
                    updateTimezoneDisplay();
                    updateCurrentTime();
                    updateAllTimeDisplays();
                    return;
                }

                const currentTimezone = getRealTimeTimezone();
                if (currentTimezone !== lastTimezone) {
                    console.log('Timezone changed on focus:', currentTimezone);
                    lastTimezone = currentTimezone;
                    updateTimezoneDisplay();
                    updateCurrentTime();
                    updateAllTimeDisplays();
                }
            });
        })();
        </script>
    </body>
</html>
"
