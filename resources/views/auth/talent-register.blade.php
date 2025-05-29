<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

            <h2 class="text-2xl font-bold mb-4 text-center">Talent Registration</h2>

            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('talent.register.store') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-label for="name" value="{{ __('Full Name *') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email *') }}" />
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

                <!-- Phone Number -->
                <div class="mt-4">
                    <x-label for="phone_number" value="{{ __('Phone Number') }}" />
                    <x-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" />
                </div>

                <!-- Address -->
                <div class="mt-4">
                    <x-label for="address" value="{{ __('Address') }}" />
                    <textarea id="address" name="address" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('address') }}</textarea>
                </div>

                <!-- Gender -->
                <div class="mt-4">
                    <x-label for="gender" value="{{ __('Gender') }}" />
                    <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">{{ __('Select Gender') }}</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                    </select>
                </div>

                <!-- Date of Birth -->
                <div class="mt-4">
                    <x-label for="date_of_birth" value="{{ __('Date of Birth') }}" />
                    <x-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" />
                </div>

                 <!-- ID Card (Example for text input, change if file upload) -->
                 <div class="mt-4">
                    <x-label for="id_card" value="{{ __('ID Card (e.g., NIK)') }}" />
                    <x-input id="id_card" class="block mt-1 w-full" type="text" name="id_card" :value="old('id_card')" />
                </div>

                <!-- Bank Name -->
                <div class="mt-4">
                    <x-label for="bank_name" value="{{ __('Bank Name') }}" />
                    <x-input id="bank_name" class="block mt-1 w-full" type="text" name="bank_name" :value="old('bank_name')" />
                </div>

                <!-- Bank Account -->
                <div class="mt-4">
                    <x-label for="bank_account" value="{{ __('Bank Account Number') }}" />
                    <x-input id="bank_account" class="block mt-1 w-full" type="text" name="bank_account" :value="old('bank_account')" />
                </div>

                <!-- Swift Code -->
                <div class="mt-4">
                    <x-label for="swift_code" value="{{ __('Swift Code') }}" />
                    <x-input id="swift_code" class="block mt-1 w-full" type="text" name="swift_code" :value="old('swift_code')" />
                </div>

                <div class="mt-4">
                    <x-label for="subjected_tax" value="{{ __('Subjected Tax') }}" />
                    <x-input id="subjected_tax" class="block mt-1 w-full" type="text" name="subjected_tax" :value="old('subjected_tax')" />
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
                        {{ __('Register as Talent') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>