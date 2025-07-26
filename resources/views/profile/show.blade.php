@extends('layouts.app')
@section('title', 'Company Profile & Settings')
@section('meta_description', 'Ini adalah halaman dashboard untuk pengguna terdaftar.')

@section('content')
<div class="md:p-4 sm:ml-64">
    <div class="py-4 md:p-4">

        @if(session('success'))
        <x-alert type="success" :message="session('success')" />
        @endif

        @if(session('error'))
            <x-alert type="error" :message="session('error')" />
        @endif

        <!-- Tab Navigation -->
        <div class=" dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 mb-6">
            <nav class="flex space-x-8 px-4" aria-label="Tabs" id="profile-tabs">
                <a href="javascript:void(0);" class="profile-tab-link py-4 px-1 border-b-2 font-medium text-sm border-blue-600 text-blue-600 dark:text-white active" data-target="profile-tab1">Profile Settings</a>
                @if(Auth::user()->role === 'company')
                    <a href="javascript:void(0);" class="profile-tab-link py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-300 hover:text-blue-600 hover:border-blue-300" data-target="profile-tab2">Legal & Verification</a>
                    <a href="javascript:void(0);" class="profile-tab-link py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-300 hover:text-blue-600 hover:border-blue-300" data-target="profile-tab3">Billing & Tax</a>
                    <a href="javascript:void(0);" class="profile-tab-link py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-300 hover:text-blue-600 hover:border-blue-300" data-target="profile-tab4">Collaboration Preferences</a>
                    <a href="javascript:void(0);" class="profile-tab-link py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-300 hover:text-blue-600 hover:border-blue-300" data-target="profile-tab5">Notification Settings</a>
                @endif
                <a href="javascript:void(0);" class="profile-tab-link py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-300 hover:text-blue-600 hover:border-blue-300" data-target="profile-tab6">Timezone Settings</a>
            </nav>
        </div>

        <div id="profile-tab-content" class="mt-6">
            <!-- Tab 1: Profile Settings -->
            <div id="profile-tab1" class="block">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    @livewire('profile.update-profile-information-form')
                    <x-section-border />
                @endif
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.update-password-form')
                    </div>
                    <x-section-border />
                @endif
                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.two-factor-authentication-form')
                    </div>
                    <x-section-border />
                @endif
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>
                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <x-section-border />
                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.delete-user-form')
                    </div>
                @endif
            </div>

            <!-- Tab 2: Legal & Verification -->
            <div id="profile-tab2" class="hidden">
                @if(Auth::user()->role === 'company')
                    @php $company = \App\Models\Company::where('user_id', Auth::user()->id)->first(); @endphp
                    @if($company)
                    <div class="flex justify-between items-start">
                    <div class="mb-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Legal & Verification</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Verify your company to unlock faster payments and build trust</p>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <form method="POST" action="{{ route('company.onboarding.step.post', ['step' => 1]) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="from_settings" value="1">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Company Name *</label>
                                    <input type="text" name="company_name" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ old('company_name', $company->company_name) }}" required placeholder="Enter the formal company name">
                                    <span class="text-xs text-gray-400 mt-1">This should match exactly with your business license</span>
                                </div>
                                <div>
                                    <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Registration Number *</label>
                                    <input type="text" name="registration_number" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ old('registration_number', $company->registration_number) }}" required placeholder="e.g., 123456789">
                                    <span class="text-xs text-gray-400 mt-1">This helps us verify your company's legal status</span>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Company Address *</label>
                                    <textarea name="address" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required rows="3" placeholder="Enter your company's registered address">{{ old('address', $company->address) }}</textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Business License (Optional)</label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                                        <input type="file" name="business_license" class="sr-only" id="business_license">
                                        <label for="business_license" class="cursor-pointer flex flex-col items-center">
                                            <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            <span class="text-gray-500 dark:text-gray-400">Click to upload business license</span>
                                            <span class="text-xs text-gray-400">PDF, JPG, PNG up to 10MB</span>
                                        </label>
                                        @if($company->business_license_path)
                                            <p class="text-xs mt-2">Current: <a href="{{ asset('storage/' . $company->business_license_path) }}" target="_blank" class="text-blue-600 underline">View License</a></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">Save Changes</button>
                            </div>
                        </form>
                    </div>
                    </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">Company information not found.</p>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 dark:bg-yellow-900/20 dark:border-yellow-800">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-medium text-yellow-800 dark:text-yellow-200">Access Restricted</h3>
                                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">This section is only available for company accounts.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Tab 3: Billing & Tax -->
            <div id="profile-tab3" class="hidden">
                @if(Auth::user()->role === 'company')
                    @php $company = \App\Models\Company::where('user_id', Auth::user()->id)->first(); @endphp
                    @if($company)
                <div class="flex justify-between items-start">
                    <div class="mb-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Billing & Tax</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Set up billing for seamless transactions with Indonesian talent</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <form method="POST" action="{{ route('company.onboarding.step.post', ['step' => 3]) }}">
                            @csrf
                            <input type="hidden" name="from_settings" value="1">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Invoice Recipient *</label>
                                    <input type="text" name="invoice_recipient" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ old('invoice_recipient', $company->invoice_recipient) }}" required placeholder="Company or person name">
                                </div>
                                <div>
                                    <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Billing Email *</label>
                                    <input type="email" name="billing_email" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ old('billing_email', $company->billing_email) }}" required placeholder="billing@company.com">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Billing Address *</label>
                                    <input type="text" name="billing_address" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ old('billing_address', $company->billing_address) }}" required placeholder="Enter your billing address">
                                </div>
                                <div>
                                    <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">ZIP/Postal Code *</label>
                                    <input type="text" name="zip_code" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ old('zip_code', $company->zip_code) }}" required placeholder="12345">
                                </div>
                                <div>
                                    <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Country *</label>
                                    <input type="text" name="country" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ old('country', $company->country) }}" required placeholder="Select country">
                                </div>
                                <div>
                                    <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Tax ID / VAT Number</label>
                                    <input type="text" name="tax_id" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ old('tax_id', $company->tax_id) }}" placeholder="e.g., VAT123456789">
                                    <span class="text-xs text-gray-400 mt-1">Required for proper invoicing and tax compliance</span>
                                </div>
                                <div>
                                    <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Currency *</label>
                                    <select name="currency" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                        <option value="">Select currency</option>
                                        @foreach(\App\Models\Company::currencyOptions() as $value => $label)
                                            <option value="{{ $value }}" {{ old('currency', $company->currency) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Payment Schedule *</label>
                                    <input type="date" name="payment_schedule" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ old('payment_schedule', $company->payment_schedule) }}" required>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="px-6 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">Company information not found.</p>
                    </div>
                @endif
                @else
                    <div class="text-center py-8">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 dark:bg-yellow-900/20 dark:border-yellow-800">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-medium text-yellow-800 dark:text-yellow-200">Access Restricted</h3>
                                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">This section is only available for company accounts.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Tab 4: Collaboration Preferences -->
            <div id="profile-tab4" class="hidden">
                @if(Auth::user()->role === 'company')
                    @php $company = \App\Models\Company::where('user_id', Auth::user()->id)->first(); @endphp
                    @if($company)
                <div class="flex justify-between items-start">
                    <div class="mb-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Collaboration Preferences</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Configure your workflow and tools to match with Indonesian talent</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <form method="POST" action="{{ route('company.onboarding.step.post', ['step' => 4]) }}">
                            @csrf
                            <input type="hidden" name="from_settings" value="1">
                            <div class="space-y-6">
                                <div>
                                    <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Primary Use Case *</label>
                                    <input type="text" name="primary_use_case" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ old('primary_use_case', $company->primary_use_case) }}" required placeholder="e.g., Animation, Illustration, 3D Modeling">
                                </div>
                                <div>
                                    <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Preferred Tools & Software</label>
                                    <div class="grid grid-cols-2 md:grid-cols-2 gap-3">
                                        @php
                                            $tools = ['Clip Studio Paint (CSP)', 'Adobe Photoshop (PSD)', 'Adobe After Effects', 'Blender', 'Maya', 'Google Drive', 'Dropbox', 'Figma', 'Asana', 'Slack'];
                                            $selected = old('collaboration_tools', json_decode($company->collaboration_tools ?? '[]', true));
                                        @endphp
                                        @foreach($tools as $tool)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="collaboration_tools[]" value="{{ $tool }}" @if(in_array($tool, $selected)) checked @endif class="rounded border-gray-300">
                                                <span class="ml-2 text-sm">{{ $tool }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded dark:bg-blue-900/20 dark:border-blue-600">
                                    <div class="font-semibold text-blue-700 dark:text-blue-300 mb-2">NDA Agreement *</div>
                                    <p class="text-sm text-blue-700 dark:text-blue-300 mb-3">To ensure confidentiality when working with Indonesian talent, please review and sign our standard NDA. This agreement will apply to your studio and all talent who will join your projects.</p>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="nda_agreed" value="1" @if(old('nda_agreed', $company->nda_agreed)) checked @endif required class="rounded border-gray-300">
                                        <span class="ml-2 text-sm">I agree to the NDA terms for my studio and all talent who will join our projects</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="px-6 py-2 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">Company information not found.</p>
                    </div>
                @endif
                @else
                    <div class="text-center py-8">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 dark:bg-yellow-900/20 dark:border-yellow-800">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-medium text-yellow-800 dark:text-yellow-200">Access Restricted</h3>
                                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">This section is only available for company accounts.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Tab 5: Notification Settings -->
            <div id="profile-tab5" class="hidden">
                @if(Auth::user()->role === 'company')
                    @php $company = \App\Models\Company::where('user_id', Auth::user()->id)->first(); @endphp
                    @if($company)
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md mt-8">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-2">Discord Notification Settings</h3>
                    <div class="flex flex-col md:flex-row md:space-x-2">
                        <form method="POST" action="{{ route('company.notification-settings.save') }}" class="mb-2 md:mb-0 flex-1">
                            @csrf
                            <div class="mb-4">
                                <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Discord Webhook URL *</label>
                                <input type="url" name="discord_webhook_url" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ old('discord_webhook_url', optional($company->notification)->discord_webhook_url) }}" required placeholder="Paste your Discord webhook URL here">
                            </div>
                            <div class="mb-4">
                                <label class="block font-semibold mb-2 text-gray-700 dark:text-gray-300">Discord Channel (optional)</label>
                                <input type="text" name="discord_channel" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ old('discord_channel', optional($company->notification)->discord_channel) }}" placeholder="#channel-name">
                            </div>
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">Save Notification Settings</button>
                        </form>
                        <form method="POST" action="{{ route('company.notification-settings.test') }}" class="self-end">
                            @csrf
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">Test Webhook</button>
                        </form>
                    </div>
                    </div>
                @endif
                @else
                    <div class="text-center py-8">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 dark:bg-yellow-900/20 dark:border-yellow-800">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-medium text-yellow-800 dark:text-yellow-200">Access Restricted</h3>
                                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">This section is only available for company accounts.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Tab 6: Timezone Settings -->
            <div id="profile-tab6" class="hidden">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md mt-8">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-2">Timezone Settings</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Configure your timezone to ensure all timestamps and schedules are displayed in your local time.</p>

                    <form method="POST" action="{{ route('profile.timezone.update') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Select Your Timezone
                            </label>
                            <select id="timezone" name="timezone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Choose your timezone...</option>
                                @foreach(\App\Helpers\TimezoneHelper::getAllTimezones() as $value => $label)
                                    <option value="{{ $value }}" {{ Auth::user()->timezone == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Current timezone: <span class="font-mono">{{ Auth::user()->timezone ?? 'UTC' }}</span>
                            </p>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 dark:bg-blue-900/20 dark:border-blue-800">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                        Timezone Information
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                        <p>• Your timezone affects how all dates and times are displayed</p>
                                        <p>• Project tracking timestamps will be stored in your local time</p>
                                        <p>• Work sessions and project durations will use your timezone</p>
                                        <p>• You can change this setting at any time</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-medium">Current Local Time:</span>
                                <span class="font-mono ml-2" id="current-local-time">
                                    {{ now()->format('Y-m-d H:i:s') }}
                                </span>
                            </div>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                Save Timezone Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.profile-tab-link');
        const tabContents = document.querySelectorAll('#profile-tab-content > div');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active styles from all tabs
                tabs.forEach(t => t.classList.remove('border-blue-600', 'text-blue-600', 'active'));
                tabs.forEach(t => t.classList.add('border-transparent', 'text-gray-500'));

                // Hide all tab contents
                tabContents.forEach(content => content.classList.add('hidden'));

                // Activate clicked tab
                tab.classList.add('border-blue-600', 'text-blue-600', 'active');
                tab.classList.remove('border-transparent', 'text-gray-500');

                // Show corresponding content
                const targetId = tab.getAttribute('data-target');
                document.getElementById(targetId).classList.remove('hidden');
            });
        });

        // Show the first tab by default
        if (tabs.length > 0) {
            tabs[0].click();
        }

        // Update current time in timezone settings
        function updateCurrentTime() {
            const timeElement = document.getElementById('current-local-time');
            if (timeElement) {
                const now = new Date();
                const timeString = now.toLocaleString('en-US', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                });
                timeElement.textContent = timeString;
            }
        }

        // Update time every second if timezone tab is active
        setInterval(() => {
            const timezoneTab = document.getElementById('profile-tab6');
            if (timezoneTab && !timezoneTab.classList.contains('hidden')) {
                updateCurrentTime();
            }
        }, 1000);
    });
</script>
@endpush
@endsection
