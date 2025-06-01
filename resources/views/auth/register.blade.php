<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-6">
        <div class="w-full max-w-4xl bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="text-center p-8 bg-white">
                <h1 class="text-3xl font-bold text-gray-900">Welcome to Padma Cloud Office</h1>
                <p class="mt-2 text-lg text-gray-600">Get started instantly with your virtual collaboration hub</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 p-8">
                <!-- Company Registration Card -->
                <a href="{{ route('company.register') }}" class="block group">
                    <div class="p-6 bg-white border border-gray-200 rounded-lg transition-all duration-200 hover:border-black hover:shadow-lg">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-gray-100 rounded-lg group-hover:bg-gray-200">
                                <svg class="w-6 h-6 text-gray-600 group-hover:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800 group-hover:text-black">Company</h2>
                                <p class="mt-2 text-gray-600">Create a company account</p>
                            </div>
                        </div>
                    </div>
                </a> --}}

                <!-- Talent Registration Card -->
                <a href="{{ route('talent.register') }}" class="block group">
                    <div class="p-6 bg-white border border-gray-200 rounded-lg transition-all duration-200 hover:border-black hover:shadow-lg">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-gray-100 rounded-lg group-hover:bg-gray-200">
                                <svg class="w-6 h-6 text-gray-600 group-hover:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800 group-hover:text-black">Talent</h2>
                                <p class="mt-2 text-gray-600">Create a talent account</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="text-center pb-8">
                <p class="text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 font-semibold">Sign in</a>
                </p>
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


            <form method="POST" action="{{ route('register.invitation.store') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                    <input type="text"
                           id="name"
                           name="name"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('name') }}"
                           required
                           autofocus
                           autocomplete="name">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email"
                           id="email"
                           name="email"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('email', $email ?? '') }}"
                           required
                           autocomplete="username">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Invitation Token (Hidden) -->
                @if(isset($invitation))
                    <input type="hidden" name="invitation_token" value="{{ $invitation->token }}">
                @endif

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <input type="password"
                           id="password"
                           name="password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           required
                           autocomplete="new-password">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           required
                           autocomplete="new-password">
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                        Already registered?
                    </a>

                    <button type="submit"
                            class="ml-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
