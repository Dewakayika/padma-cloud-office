@props([
    'passwordName' => 'password',
    'passwordConfirmationName' => 'password_confirmation',
    'label' => 'Password',
    'confirmationLabel' => 'Confirm Password',
    'showRequirements' => true,
    'required' => true,
    'passwordPlaceholder' => 'Choose a password',
    'confirmationPlaceholder' => 'Confirm your password',
    'withConfirmation' => true,
])

<div x-data="{
    password: '',
    passwordConfirmation: '',
    passwordRules: {
        minLength: false,
        upperCase: false,
        specialChar: false,
        matching: false
    },
    checkPassword() {
        const pass = this.password;
        const confirm = this.passwordConfirmation;
        this.passwordRules.minLength = pass.length >= 8;
        this.passwordRules.upperCase = /[A-Z]/.test(pass);
        this.passwordRules.specialChar = /[^A-Za-z0-9]/.test(pass);
        this.passwordRules.matching = pass !== '' && confirm !== '' && pass === confirm;
    }
}" x-init="checkPassword()">
    <!-- Password Field -->
    <div class="space-y-2">
        <x-label :for="$passwordName" :value="$label" />
        <input type="password"
               :name="$passwordName"
               :id="$passwordName"
               x-model="password"
               @input="checkPassword()"
               :required="$required"
               placeholder="{{ $passwordPlaceholder }}"
               class="block w-full px-4 py-4 rounded-xl border border-gray-300 text-gray-900 placeholder-gray-500
                   focus:outline-none focus:ring-2 focus:ring-black focus:border-black
                   transition-all duration-200 text-base"
               :class="{'border-red-500': password && !passwordRules.minLength}" />
        <x-input-error :for="$passwordName" />
        @if($showRequirements)
        <div class="mt-3 space-y-2">
            <div class="flex items-center space-x-2">
                <svg class="h-4 w-4" :class="passwordRules.minLength ? 'text-green-600' : 'text-red-600'" fill="currentColor" viewBox="0 0 20 20">
                    <path x-show="passwordRules.minLength" fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    <path x-show="!passwordRules.minLength" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm" :class="passwordRules.minLength ? 'text-green-600' : 'text-red-600'">
                    At least 8 characters
                </span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="h-4 w-4" :class="passwordRules.upperCase ? 'text-green-600' : 'text-red-600'" fill="currentColor" viewBox="0 0 20 20">
                    <path x-show="passwordRules.upperCase" fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    <path x-show="!passwordRules.upperCase" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm" :class="passwordRules.upperCase ? 'text-green-600' : 'text-red-600'">
                    One uppercase letter
                </span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="h-4 w-4" :class="passwordRules.specialChar ? 'text-green-600' : 'text-red-600'" fill="currentColor" viewBox="0 0 20 20">
                    <path x-show="passwordRules.specialChar" fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    <path x-show="!passwordRules.specialChar" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm" :class="passwordRules.specialChar ? 'text-green-600' : 'text-red-600'">
                    One special character
                </span>
            </div>
        </div>
        @endif
    </div>

    @if($withConfirmation !== false && $withConfirmation !== 'false' && $withConfirmation !== 0 && $withConfirmation !== '0')
    <!-- Password Confirmation Field -->
    <div class="space-y-2 mt-6">
        <x-label :for="$passwordConfirmationName" :value="$confirmationLabel" />
        <input type="password"
               :name="$passwordConfirmationName"
               :id="$passwordConfirmationName"
               x-model="passwordConfirmation"
               @input="checkPassword()"
               :required="$required"
               placeholder="{{ $confirmationPlaceholder }}"
               class="block w-full px-4 py-4 rounded-xl border border-gray-300 text-gray-900 placeholder-gray-500
                   focus:outline-none focus:ring-2 focus:ring-black focus:border-black
                   transition-all duration-200 text-base"
               :class="{'border-red-500': passwordConfirmation && !passwordRules.matching}" />
        <x-input-error :for="$passwordConfirmationName" />
        <p class="text-red-600 text-sm mt-1"
           x-show="passwordConfirmation !== '' && !passwordRules.matching">
            Passwords do not match
        </p>
    </div>
    @endif
</div> 