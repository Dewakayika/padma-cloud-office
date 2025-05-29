<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

            <h2 class="text-2xl font-bold mb-4 text-center">Company Registration</h2>

            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('company.register.store') }}">
                @csrf

                <!-- Company Name -->
                <div>
                    <x-label for="company_name" value="{{ __('Company Name *') }}" />
                    <x-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" required autofocus />
                </div>

                <!-- Company Type -->
                <div class="mt-4">
                    <x-label for="company_type" value="{{ __('Company Type *') }}" />
                    <select id="company_type" name="company_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="">{{ __('Select type') }}</option>
                        <option value="Webtoon Studio" {{ old('company_type') == 'Webtoon Studio' ? 'selected' : '' }}>{{ __('Webtoon Studio') }}</option>
                        <option value="Anime Studio" {{ old('company_type') == 'Anime Studio' ? 'selected' : '' }}>{{ __('Anime Studio') }}</option>
                        <option value="Manga Studio" {{ old('company_type') == 'Manga Studio' ? 'selected' : '' }}>{{ __('Manga Studio') }}</option>
                        <option value="Design Agency" {{ old('company_type') == 'Design Agency' ? 'selected' : '' }}>{{ __('Design Agency') }}</option>
                        <option value="Design Agency" {{ old('company_type') == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                    </select>
                </div>

                <!-- Country -->
                <div class="mt-4">
                    <x-label for="country" value="{{ __('Country *') }}" />
                     {{-- You might replace this with a proper select dropdown with country options --}}
                    <x-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')" required />
                </div>

                 <!-- Contact Person Name -->
                 <div class="mt-4">
                    <x-label for="contact_person_name" value="{{ __('Contact Person Name *') }}" />
                    <x-input id="contact_person_name" class="block mt-1 w-full" type="text" name="contact_person_name" :value="old('contact_person_name')" required />
                </div>

                <!-- Work Email (User Email) -->
                <div class="mt-4">
                    <x-label for="email" value="{{ __('Work Email *') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password *') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password *') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <!-- Terms Checkbox -->
                <div class="mt-4">
                    <label for="terms" class="flex items-center">
                        <x-checkbox name="terms" id="terms" required />
                        <span class="ms-2 text-sm text-gray-600">{{ __('I accept the') }} <a target="_blank" href="{{ route('terms.show') }}" class="underline text-sm text-gray-600 hover:text-gray-900">{{ __('Terms of Use') }}</a> {{ __('and') }} <a target="_blank" href="{{ route('policy.show') }}" class="underline text-sm text-gray-600 hover:text-gray-900">{{ __('Data Policy') }}</a></span>
                    </label>
                </div>


                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already have an account? Sign in') }}
                    </a>

                    <x-button class="ms-4">
                        {{ __('Get Started Instantly') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>