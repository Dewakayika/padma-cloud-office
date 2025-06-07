<x-guest-layout>
    <div class="min-h-screen flex bg-white">
        <!-- Left Side: Branding -->
        <div class="w-1/3 bg-gray-50 p-12 flex flex-col">
            <!-- Back to Home Link -->
            <div class="mb-12">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to home
                </a>
            </div>

            <!-- Info -->
            <div class="flex-1">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">User Registration</h2>
                <p class="text-gray-600 text-sm">Join Padma Cloud Office and collaborate virtually with your team.</p>
            </div>

            <!-- Sign In Link -->
            <div class="mt-auto pt-8">
                <p class="text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-red-700 font-medium">Sign in</a>
                </p>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="flex-1 flex items-center justify-center p-12 bg-gray-100">
            <div class="w-full max-w-md">
                <!-- Welcome -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-semibold text-gray-900">Create an account</h1>
                    <p class="mt-2 text-gray-600">Get started instantly with your virtual collaboration hub</p>
                </div>

                <!-- Alerts -->
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

                <form method="POST" action="{{ route('register.invitation.store') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name"
                               class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                      focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition duration-150 ease-in-out"
                               placeholder="Enter your full name"
                               value="{{ old('name') }}"
                               required autofocus autocomplete="name">
                        @error('name')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                               class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                      focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition duration-150 ease-in-out"
                               placeholder="you@example.com"
                               value="{{ old('email', $email ?? '') }}"
                               required autocomplete="username">
                        @error('email')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hidden Invitation Token -->
                    @if(isset($invitation))
                        <input type="hidden" name="invitation_token" value="{{ $invitation->token }}">
                    @endif

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password"
                               class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                      focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition duration-150 ease-in-out"
                               required autocomplete="new-password">
                        @error('password')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                      focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition duration-150 ease-in-out"
                               required autocomplete="new-password">
                        @error('password_confirmation')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                            Already registered?
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-black transition duration-150">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
