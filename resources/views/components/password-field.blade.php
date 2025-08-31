@props([
    'passwordName' => 'password',
    'passwordConfirmationName' => 'password_confirmation',
    'label' => 'Password',
    'confirmationLabel' => 'Confirm Password',
    'required' => true,
    'passwordPlaceholder' => 'Choose a password',
    'confirmationPlaceholder' => 'Confirm your password',
    'withConfirmation' => true,
])

<div x-data="{
    password: '',
    passwordConfirmation: '',
    passwordRules: {
        matching: false
    },
    checkPassword() {
        const pass = this.password;
        const confirm = this.passwordConfirmation;
        this.passwordRules.matching = pass !== '' && confirm !== '' && pass === confirm;
    }
}" x-init="checkPassword()">
    <!-- Password Field -->
    <div class="space-y-2">
        <x-label :for="$passwordName" :value="$label" />
        <input type="password"
               name="{{ $passwordName }}"
               id="{{ $passwordName }}"
               x-model="password"
               @input="checkPassword()"
               :required="$required"
               placeholder="{{ $passwordPlaceholder }}"
               class="block w-full px-4 py-4 rounded-xl border border-gray-300 text-gray-900 placeholder-gray-500
                   focus:outline-none focus:ring-2 focus:ring-black focus:border-black
                   transition-all duration-200 text-base" />
        <x-input-error :for="$passwordName" />
    </div>

    @if($withConfirmation !== false && $withConfirmation !== 'false' && $withConfirmation !== 0 && $withConfirmation !== '0')
    <!-- Password Confirmation Field -->
    <div class="space-y-2 mt-6">
        <x-label :for="$passwordConfirmationName" :value="$confirmationLabel" />
        <input type="password"
               name="{{ $passwordConfirmationName }}"
               id="{{ $passwordConfirmationName }}"
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
