@extends('layouts.guest')
@section('title', 'Register')
@section('meta_description', 'Ini adalah halaman register.')

@section('content')
    <div class="min-h-screen flex flex-col lg:flex-row bg-white">
        <!-- Left Side: Branding - Hidden on mobile, visible on desktop -->
        <div class="hidden lg:flex lg:w-1/3 bg-gray-50 p-8 lg:p-12 flex-col">
            <!-- Back to Home Link -->
            <div class="mb-8 lg:mb-12">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to home
                </a>
            </div>

            <!-- Registration Info -->
            <div class="flex-1">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Company Registration</h2>

                <!-- Company Benefits -->
                <div class="space-y-6">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-red-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <div>
                            <h3 class="font-medium text-gray-900">Access Top Talent</h3>
                            <p class="text-sm text-gray-500">Connect with skilled creators in animation, manga, and design.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-red-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <div>
                            <h3 class="font-medium text-gray-900">Efficient Hiring</h3>
                            <p class="text-sm text-gray-500">Streamlined process to find and hire the right talent.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-red-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <div>
                            <h3 class="font-medium text-gray-900">Secure Platform</h3>
                            <p class="text-sm text-gray-500">Safe and reliable environment for business operations.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sign In Link -->
            <div class="mt-auto pt-8">
                <p class="text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-red-700 font-medium">Sign in</a>
                </p>
            </div>
        </div>

        <!-- Right Side: Form Content -->
        <div class="flex-1 flex items-center justify-center px-4 py-8 sm:px-6 sm:py-12 lg:p-12 bg-gray-50 lg:bg-gray-100">
            <div class="w-full max-w-sm sm:max-w-md">
                <!-- Mobile Header -->
                <div class="lg:hidden mb-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800 mb-6">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to home
                    </a>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-3">Company Registration</h2>
                    <p class="text-gray-600 leading-relaxed">Register your company and start hiring talented creators.</p>
                </div>

                <!-- Form Header -->
                <div class="text-center mb-8 lg:mb-10">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Create Company Account</h1>
                    <p class="mt-2 text-gray-600">Join our platform and connect with top talent</p>
                </div>

                <!-- Validation Errors -->
                <x-validation-errors class="mb-6" />

                <form method="POST" action="{{ route('company.register.store') }}" class="space-y-6">
                    @csrf

                    <!-- Company Name and Type Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-4">
                        <!-- Company Name -->
                        <div class="space-y-2">
                            <label for="company_name" class="block text-sm font-semibold text-gray-700">
                                Company Name<span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                name="company_name"
                                id="company_name"
                                class="block w-full px-4 py-4 rounded-xl border border-gray-300 text-gray-900 placeholder-gray-500
                                    focus:outline-none focus:ring-2 focus:ring-black focus:border-black
                                    transition-all duration-200 text-base"
                                placeholder="Enter your company name"
                                value="{{ old('company_name') }}"
                                required
                                autofocus />
                        </div>

                        <!-- Company Type -->
                        <div class="space-y-2">
                            <label for="company_type" class="block text-sm font-semibold text-gray-700">
                                Company Type<span class="text-red-500">*</span>
                            </label>
                            <select id="company_type"
                                name="company_type"
                                class="block w-full px-4 py-4 rounded-xl border border-gray-300 text-gray-900
                                    focus:outline-none focus:ring-2 focus:ring-black focus:border-black
                                    transition-all duration-200 text-base appearance-none"
                                required>
                                <option value="">Select company type</option>
                                <option value="Webtoon Studio" {{ old('company_type') == 'Webtoon Studio' ? 'selected' : '' }}>Webtoon Studio</option>
                                <option value="Anime Studio" {{ old('company_type') == 'Anime Studio' ? 'selected' : '' }}>Anime Studio</option>
                                <option value="Manga Studio" {{ old('company_type') == 'Manga Studio' ? 'selected' : '' }}>Manga Studio</option>
                                <option value="Design Agency" {{ old('company_type') == 'Design Agency' ? 'selected' : '' }}>Design Agency</option>
                                <option value="Other" {{ old('company_type') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Country Select -->
                    <div class="space-y-2" x-data="{
                        countries: [],
                        loading: true,
                        async fetchCountries() {
                            try {
                                const response = await fetch('https://restcountries.com/v3.1/all?fields=name');
                                const data = await response.json();
                                this.countries = data
                                    .map(country => country.name.common)
                                    .sort((a, b) => a.localeCompare(b));
                                this.loading = false;
                            } catch (error) {
                                console.error('Error fetching countries:', error);
                                this.loading = false;
                            }
                        },
                        init() {
                            this.fetchCountries();
                        }
                    }">
                        <label for="country" class="block text-sm font-semibold text-gray-700">
                            Country<span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="country"
                                id="country"
                                class="block w-full px-4 py-4 rounded-xl border border-gray-300 text-gray-900
                                    focus:outline-none focus:ring-2 focus:ring-black focus:border-black
                                    transition-all duration-200 text-base appearance-none"
                                required>
                                <option value="">Select a country</option>
                                <template x-for="country in countries" :key="country">
                                    <option :value="country"
                                        :selected="country === '{{ old('country') }}'"
                                        x-text="country"></option>
                                </template>
                            </select>

                            <!-- Loading indicator -->
                            <div x-show="loading"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Person Name -->
                    <div class="space-y-2">
                        <label for="contact_person_name" class="block text-sm font-semibold text-gray-700">
                            Contact Person Name<span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            name="contact_person_name"
                            id="contact_person_name"
                            class="block w-full px-4 py-4 rounded-xl border border-gray-300 text-gray-900 placeholder-gray-500
                                focus:outline-none focus:ring-2 focus:ring-black focus:border-black
                                transition-all duration-200 text-base"
                            placeholder="Enter contact person name"
                            value="{{ old('contact_person_name') }}"
                            required />
                    </div>

                    <!-- Work Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-gray-700">
                            Work Email<span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                            name="email"
                            id="email"
                            class="block w-full px-4 py-4 rounded-xl border border-gray-300 text-gray-900 placeholder-gray-500
                                focus:outline-none focus:ring-2 focus:ring-black focus:border-black
                                transition-all duration-200 text-base"
                            placeholder="Enter your work email"
                            value="{{ old('email') }}"
                            required />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            Password<span class="text-red-500">*</span>
                        </label>
                        <input type="password"
                            name="password"
                            id="password"
                            class="block w-full px-4 py-4 rounded-xl border border-gray-300 text-gray-900 placeholder-gray-500
                                focus:outline-none focus:ring-2 focus:ring-black focus:border-black
                                transition-all duration-200 text-base"
                            placeholder="Choose a password"
                            required />
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                            Confirm Password<span class="text-red-500">*</span>
                        </label>
                        <input type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="block w-full px-4 py-4 rounded-xl border border-gray-300 text-gray-900 placeholder-gray-500
                                focus:outline-none focus:ring-2 focus:ring-black focus:border-black
                                transition-all duration-200 text-base"
                            placeholder="Confirm your password"
                            required />
                    </div>

                    <!-- Terms and Privacy -->
                    <div class="mt-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox"
                                    id="terms"
                                    name="terms"
                                    class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                    required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700 leading-relaxed">
                                    I agree to the
                                    <a href="{{ route('terms.show') }}" class="text-blue-600 hover:text-blue-700 transition-colors duration-200">Terms</a>
                                    and
                                    <a href="{{ route('policy.show') }}" class="text-blue-600 hover:text-blue-700 transition-colors duration-200">Privacy Policy</a>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8">
                        <button type="submit"
                            class="w-full flex justify-center py-4 px-6 border border-transparent rounded-xl
                                text-base font-semibold text-white bg-black hover:bg-gray-800
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black
                                transition-all duration-200">
                            Create Company Account
                        </button>
                    </div>
                </form>

                <!-- Mobile Footer -->
                <div class="lg:hidden mt-10 pt-8 border-t border-gray-200 text-center">
                    <p class="text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-200">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection