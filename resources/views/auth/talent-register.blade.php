<x-guest-layout>
    <div class="min-h-screen flex bg-white" x-data="{ 
        step: 1,
        totalSteps: 4,
        formData: {
            step1: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            step2: {
                phone_number: '',
                address: '',
                gender: '',
                date_of_birth: ''
            },
            step3: {
                id_card_number: '',
            },
            step4: {
                bank_name: '',
                bank_account: '',
                swift_code: '',
                subjected_tax: '',
                terms: false
            }
        },
        passwordRules: {
            minLength: false,
            upperCase: false,
            specialChar: false,
            matching: false
        },
        checkPassword() {
            const pass = this.formData.step1.password;
            const confirm = this.formData.step1.password_confirmation;
            
            this.passwordRules.minLength = pass.length >= 8;
            this.passwordRules.upperCase = /[A-Z]/.test(pass);
            this.passwordRules.specialChar = /[^A-Za-z0-9]/.test(pass);
            this.passwordRules.matching = pass !== '' && confirm !== '' && pass === confirm;
        },
        validateStep1() {
            this.checkPassword();
            return this.formData.step1.name !== '' && 
                   this.formData.step1.email !== '' && 
                   Object.values(this.passwordRules).every(rule => rule === true);
        },
        validateStep2() {
            return this.formData.step2.phone_number !== '' && 
                   this.formData.step2.address !== '' && 
                   this.formData.step2.gender !== '' && 
                   this.formData.step2.date_of_birth !== '';
        },
        validateStep3() {
            return this.formData.step3.id_card_number !== '';
                   
        },
        validateStep4() {
            return this.formData.step4.bank_name !== '' && 
                   this.formData.step4.bank_account !== '' && 
                   this.formData.step4.swift_code !== '' && 
                   this.formData.step4.subjected_tax !== '' && 
                   this.formData.step4.terms === true;
        },
        canProceed() {
            if (this.step === 1) return this.validateStep1();
            if (this.step === 2) return this.validateStep2();
            if (this.step === 3) return this.validateStep3();
            if (this.step === 4) return this.validateStep4();
            return false;
        },
        nextStep() {
            if (this.step < this.totalSteps && this.canProceed()) {
                this.step++;
            }
        },
        prevStep() {
            if (this.step > 1) this.step--;
        }
    }">
        <!-- Left Side: Progress Steps -->
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

            <!-- Steps List -->
            <div class="space-y-12 flex-1">
                <!-- Your details step -->
                <div class="relative">
                    <div class="flex items-start" :class="{'opacity-100': step >= 1, 'opacity-50': step < 1}">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center"
                                :class="{'border-red-600 bg-red-600 text-white': step >= 1, 'border-gray-300': step < 1}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="h-full w-0.5 bg-gray-200 absolute left-5 top-10 -bottom-12" 
                                x-show="step > 1"></div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Your details</h3>
                            <p class="mt-1 text-sm text-gray-500">Provide an email and password</p>
                        </div>
                    </div>
                </div>

                <!-- Verify email step -->
                <div class="relative">
                    <div class="flex items-start" :class="{'opacity-100': step >= 2, 'opacity-50': step < 2}">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center"
                                :class="{'border-red-600 bg-red-600 text-white': step >= 2, 'border-gray-300': step < 2}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="h-full w-0.5 bg-gray-200 absolute left-5 top-10 -bottom-12"
                                x-show="step > 2"></div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Personal Details</h3>
                            <p class="mt-1 text-sm text-gray-500">Provide your personal details</p>
                        </div>
                    </div>
                </div>

                <!-- Personal Details step -->
                <div class="relative">
                    <div class="flex items-start" :class="{'opacity-100': step >= 3, 'opacity-50': step < 3}">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center"
                                :class="{'border-red-600 bg-red-600 text-white': step >= 3, 'border-gray-300': step < 3}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="h-full w-0.5 bg-gray-200 absolute left-5 top-10 -bottom-12"
                                x-show="step > 3"></div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Identity Verification</h3>
                            <p class="mt-1 text-sm text-gray-500">Verify your identity</p>
                        </div>
                    </div>
                </div>

                <!-- Financial & Legal step -->
                <div class="relative">
                    <div class="flex items-start" :class="{'opacity-100': step >= 4, 'opacity-50': step < 4}">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center"
                                :class="{'border-red-600 bg-red-600 text-white': step >= 4, 'border-gray-300': step < 4}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Financial & Legal</h3>
                            <p class="mt-1 text-sm text-gray-500">Provide your financial and legal details</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sign In Link -->
            <div class="mt-auto pt-8">
                <p class="text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-green-700 font-medium">Sign in</a>
                </p>
            </div>
        </div>

        <!-- Right Side: Form Content -->
        <div class="flex-1 flex items-center justify-center p-12 bg-gray-100">
            <div class="w-full max-w-md">
                <!-- Form Header -->
                <div class="text-center mb-12">
                    <h1 class="text-2xl font-semibold text-gray-900">Create a Talent account</h1>
                    <p class="mt-2 text-gray-600">Provide your email and choose a password to get started.</p>
                </div>

                <!-- Validation Errors -->
                <x-validation-errors class="mb-4" />

                <!-- Form Content -->
                <form method="POST" action="{{ route('talent.register.store') }}" class="space-y-8">
                    @csrf

                    <!-- Step 1: Account Creation -->
                    <div x-show="step === 1">
                        <!-- Name Field -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Name<span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                    name="name" 
                                    id="name" 
                                    x-model="formData.step1.name"
                                    class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                        focus:outline-none focus:ring-1 focus:ring-black focus:border-black
                                        transition duration-150 ease-in-out @error('name') is-invalid @enderror"
                                    placeholder="Enter your name"
                                    value="{{ old('name') }}"
                                    required />
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <!-- Email Field -->
                        <div class="space-y-2 mt-6">
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email<span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="email" 
                                    name="email" 
                                    id="email" 
                                    x-model="formData.step1.email"
                                    class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                        focus:outline-none focus:ring-1 focus:ring-black focus:border-black
                                        transition duration-150 ease-in-out @error('email') is-invalid @enderror"
                                    placeholder="Enter your email"
                                    value="{{ old('email') }}"
                                    required />
                                @error('email')
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2 mt-6">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Password<span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                    name="password" 
                                    id="password" 
                                    x-model="formData.step1.password"
                                    @input="checkPassword"
                                    class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                        focus:outline-none focus:ring-1 focus:ring-black focus:border-black
                                        transition duration-150 ease-in-out"
                                    :class="{'border-red-500': formData.step1.password && !passwordRules.minLength}"
                                    placeholder="Choose a password"
                                    required />
                                <div class="mt-2 space-y-1.5">
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
                            </div>
                        </div>

                        <!-- Password Confirmation Field -->
                        <div class="space-y-2 mt-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                Confirm Password<span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                    name="password_confirmation" 
                                    id="password_confirmation" 
                                    x-model="formData.step1.password_confirmation"
                                    @input="checkPassword()"
                                    class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                        focus:outline-none focus:ring-1 focus:ring-black focus:border-black 
                                        transition duration-150 ease-in-out"
                                    :class="{'border-red-500': formData.step1.password_confirmation && !passwordRules.matching}"
                                    placeholder="Confirm your password"
                                    required />
                            </div>
                            <p class="text-red-600 text-sm mt-1"
                               x-show="formData.step1.password_confirmation !== '' && !passwordRules.matching">
                                Passwords do not match
                            </p>
                        </div>
                    </div>

                    <!-- Step 2: Personal Details -->
                    <div x-show="step === 2">
                        <!-- Phone Number -->
                        <div class="space-y-2">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" 
                                name="phone_number" 
                                id="phone_number" 
                                x-model="formData.step2.phone_number"
                                class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                    focus:outline-none focus:ring-1 focus:ring-black focus:border-black
                                    transition duration-150 ease-in-out"
                                placeholder="Enter your phone number"
                                :value="old('phone_number')" />
                        </div>

                        <!-- Address -->
                        <div class="space-y-2 mt-6">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea id="address" 
                                name="address" 
                                rows="3"
                                x-model="formData.step2.address"
                                class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                    focus:outline-none focus:ring-1 focus:ring-black focus:border-black
                                    transition duration-150 ease-in-out"
                                placeholder="Enter your address">{{ old('address') }}</textarea>
                        </div>

                        <!-- Gender -->
                        <div class="space-y-2 mt-6">
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                            <select id="gender" 
                                name="gender"
                                x-model="formData.step2.gender"
                                class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900
                                    focus:outline-none focus:ring-1 focus:ring-black focus:border-black
                                    transition duration-150 ease-in-out">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <!-- Date of Birth -->
                        <div class="space-y-2 mt-6">
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" 
                                name="date_of_birth" 
                                id="date_of_birth" 
                                x-model="formData.step2.date_of_birth"
                                class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900
                                    focus:outline-none focus:ring-1 focus:ring-black focus:border-black
                                    transition duration-150 ease-in-out"
                                :value="old('date_of_birth')" />
                        </div>
                    </div>

                    <!-- Step 3: Identity Verification -->
                    <div x-show="step === 3">
                        <!-- ID Card Number -->
                        <div class="space-y-2">
                            <label for="id_card_number" class="block text-sm font-medium text-gray-700">
                                ID Card Number<span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                name="id_card_number" 
                                id="id_card_number" 
                                x-model="formData.step3.id_card_number"
                                class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                    focus:outline-none focus:ring-1 focus:ring-black focus:border-black
                                    transition duration-150 ease-in-out"
                                placeholder="Enter your ID card number"
                                required />
                        </div>

                        <!-- ID Card Upload -->
                        <!-- <div class="space-y-2 mt-6">
                            <label for="id_card_file" class="block text-sm font-medium text-gray-700">
                                ID Card Image<span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="id_card_file" class="relative cursor-pointer rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-black">
                                            <span>Upload a file</span>
                                            <input id="id_card_file" name="id_card_file" type="file" class="sr-only" accept="image/*" required @change="formData.step3.id_card_file = $event.target.files[0]">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div> -->
                    </div>

                    <!-- Step 4: Financial & Legal -->
                    <div x-show="step === 4">
                        <!-- Bank Name -->
                        <div class="space-y-2">
                            <label for="bank_name" class="block text-sm font-medium text-gray-700">
                                Bank Name<span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                name="bank_name" 
                                id="bank_name" 
                                x-model="formData.step4.bank_name"
                                class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                    focus:outline-none focus:ring-1 focus:ring-black focus:border-black
                                    transition duration-150 ease-in-out"
                                placeholder="Enter your bank name"
                                required />
                        </div>

                        <!-- Bank Account Number -->
                        <div class="space-y-2 mt-6">
                            <label for="bank_account" class="block text-sm font-medium text-gray-700">
                                Bank Account Number<span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                name="bank_account" 
                                id="bank_account" 
                                x-model="formData.step4.bank_account"
                                class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                    focus:outline-none focus:ring-1 focus:ring-black focus:border-black
                                    transition duration-150 ease-in-out"
                                placeholder="Enter your bank account number"
                                required />
                        </div>

                        <!-- SWIFT Code -->
                        <div class="space-y-2 mt-6">
                            <label for="swift_code" class="block text-sm font-medium text-gray-700">
                                SWIFT Code<span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                name="swift_code" 
                                id="swift_code" 
                                x-model="formData.step4.swift_code"
                                class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                    focus:outline-none focus:ring-1 focus:ring-black focus:border-black
                                    transition duration-150 ease-in-out"
                                placeholder="Enter bank SWIFT code"
                                required />
                        </div>

                        <!-- Subjected Tax -->
                        <div class="space-y-2 mt-6">
                            <label for="subjected_tax" class="block text-sm font-medium text-gray-700">
                                Subjected Tax<span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                name="subjected_tax" 
                                id="subjected_tax" 
                                x-model="formData.step4.subjected_tax"
                                class="block w-full px-4 py-3.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400
                                    focus:outline-none focus:ring-1 focus:ring-black focus:border-black
                                    transition duration-150 ease-in-out"
                                placeholder="Enter your tax information"
                                required />
                        </div>

                        <!-- Terms and Privacy -->
                        <div class="mt-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" 
                                        id="terms" 
                                        name="terms" 
                                        x-model="formData.step4.terms"
                                        class="h-4 w-4 text-green-600 focus:ring-black border-gray-300 rounded"
                                        required>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-medium text-gray-700">
                                        I agree to the 
                                        <a href="#" class="text-green-600 hover:text-green-500">Terms</a>
                                        and
                                        <a href="#" class="text-green-600 hover:text-green-500">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center justify-between mt-8">
                        <button type="button" 
                            x-show="step > 1" 
                            @click="prevStep()"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black
                                transition duration-150 ease-in-out">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Previous
                        </button>

                        <div class="flex-1 flex justify-end">
                            <button type="button" 
                                x-show="step < totalSteps" 
                                @click="nextStep()"
                                :class="{'opacity-50 cursor-not-allowed': !canProceed()}"
                                :disabled="!canProceed()"
                                class="inline-flex items-center px-6 py-3.5 text-base font-medium text-white bg-gray-800 rounded-lg
                                    hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black
                                    transition duration-150 ease-in-out">
                                Continue
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>

                            <button type="submit" 
                                x-show="step === totalSteps"
                                :class="{'opacity-50 cursor-not-allowed': !canProceed()}"
                                :disabled="!canProceed()"
                                class="inline-flex items-center px-6 py-3.5 text-base font-medium text-white bg-gray-800 rounded-lg
                                    hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black
                                    transition duration-150 ease-in-out">
                                Complete Registration
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>