@extends('layouts.guest')
@section('title', 'Onboarding Step 1')
@section('meta_description', 'Ini adalah halaman onboarding step 1.')

@section('content')
@php
    $steps = [
        1 => 'Legal & Verification',
        2 => 'Billing & Tax',
        3 => 'Collaboration'
    ];
    $totalSteps = count($steps);
    $currentStep = $step ?? 1;
    $percent = round(($currentStep - 1) / ($totalSteps - 1) * 100);
@endphp

<div class="max-w-2xl mt-10 sm:mt-14 mx-auto mb-8 bg-gray-50 rounded-xl shadow-sm px-4 md-px-0 py-6">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between mb-2">
        <div class="font-semibold text-base sm:text-lg">Step {{ $currentStep }} of {{ $totalSteps }}</div>
        <div class="text-xs sm:text-sm font-medium text-gray-600">{{ $percent }}% Complete</div>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
        <div class="bg-red-600 h-2 rounded-full transition-all duration-300" style="width: {{ $percent }}%"></div>
    </div>
    <div class="overflow-x-auto">
        <div class="flex justify-between min-w-[340px] sm:min-w-0">
            @foreach($steps as $i => $label)
                <div class="flex flex-col items-center flex-1 min-w-[80px]">
                    <div class="@if($i < $currentStep) bg-green-500 @elseif($i == $currentStep) bg-red-600 @else bg-gray-300 @endif rounded-full w-8 h-8 flex items-center justify-center text-white font-bold text-lg">
                        @if($i < $currentStep)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        @else
                            {{ $i }}
                        @endif
                    </div>
                    <div class="mt-2 text-xs text-center @if($i == $currentStep) font-bold text-black @elseif($i < $currentStep) text-green-700 @else text-gray-400 @endif">
                        {{ $label }}
                    </div>
                </div>
                @if($i < $totalSteps)
                    <div class="flex-1 h-1 bg-gray-300 mx-1 mt-4 hidden sm:block"></div>
                    <div class="h-1 w-8 bg-gray-300 mx-1 my-4 sm:hidden"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<div class="max-w-2xl mx-auto bg-white shadow rounded-xl p-4 sm:p-8 mb-8">
    <h2 class="text-lg sm:text-xl font-bold mb-1 flex items-center gap-2">
        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-blue-100 text-blue-600 mr-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
        </span>
        Legal & Verification
    </h2>
    <p class="text-gray-500 mb-6 text-sm sm:text-base">Verify your company to unlock faster payments and build trust with Indonesian talent</p>
    
    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">There were some errors with your submission:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <form method="POST" action="{{ route('company.onboarding.step.post', ['step' => 1]) }}" enctype="multipart/form-data" id="onboarding-form">
        @csrf
        <div class="mb-5">
            <label class="block font-semibold mb-1">Formal Company Name</label>
            <input type="text" name="company_name" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-200 @error('company_name') border-red-300 @enderror" value="{{ old('company_name', $company->company_name) }}" required placeholder="Enter the formal company name as per business license">
            <span class="text-xs text-gray-400">This should match exactly with your business license</span>
            @error('company_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-5">
            <label class="block font-semibold mb-1">Company Registration Number</label>
            <input type="text" name="registration_number" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-200 @error('registration_number') border-red-300 @enderror" value="{{ old('registration_number', $company->registration_number) }}" required placeholder="e.g., 123456789">
            <span class="text-xs text-gray-400">This helps us verify your company's legal status</span>
            @error('registration_number')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-5">
            <label class="block font-semibold mb-1">Company Address</label>
            <textarea name="address" class="form-input w-full bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-200 @error('address') border-red-300 @enderror" required placeholder="Enter your company's registered address">{{ old('address', $company->address) }}</textarea>
            @error('address')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-5">
            <label class="block font-semibold mb-1">Business License (Optional)</label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors duration-200" id="upload-area">
                <input type="file" name="business_license" class="sr-only" id="business_license" accept=".pdf,.jpg,.jpeg,.png">
                <label for="business_license" class="cursor-pointer flex flex-col items-center">
                    <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    <span class="text-gray-500 font-medium">Click to upload business license</span>
                    <span class="text-xs text-gray-400 mt-1">PDF, JPG, PNG up to 10MB</span>
                </label>
                
                <!-- File preview area -->
                <div id="file-preview" class="hidden w-full mt-4">
                    <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900" id="file-name"></p>
                                    <p class="text-xs text-gray-500" id="file-size"></p>
                                </div>
                            </div>
                            <button type="button" id="remove-file" class="text-red-500 hover:text-red-700 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Current file display -->
                @if($company->business_license_path)
                    <div class="w-full mt-4">
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-blue-900">Current License</p>
                                        <p class="text-xs text-blue-600">Uploaded previously</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $company->business_license_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm transition-colors duration-200">
                                    View File
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            @error('business_license')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded mb-6">
            <div class="font-semibold text-blue-700 mb-1">Why verify your company?</div>
            <ul class="text-xs text-blue-700 list-disc pl-5">
                <li>Faster payment processing</li>
                <li>Higher trust score with Indonesian talent</li>
                <li>Access to premium collaboration features</li>
                <li>Priority support</li>
            </ul>
        </div>
        <button type="submit" class="w-full py-3 bg-black text-white font-semibold rounded-lg hover:bg-gray-900 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed" id="submit-btn">
            <span class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" id="loading-spinner" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Continue to Billing & Tax
            </span>
        </button>
    </form>
    <div class="flex flex-col sm:flex-row justify-between mt-4 gap-2">
        <span></span>
        <a href="{{ route('company.onboarding.step', ['step' => $step + 1]) }}" class="px-4 py-2 rounded bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-300 text-center transition-colors duration-200">Skip for now &rarr;</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('business_license');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const removeFileBtn = document.getElementById('remove-file');
    const uploadArea = document.getElementById('upload-area');
    const form = document.getElementById('onboarding-form');
    const submitBtn = document.getElementById('submit-btn');
    const loadingSpinner = document.getElementById('loading-spinner');

    // File input change handler
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file type
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                showNotification('Please select a valid file type (PDF, JPG, PNG)', 'error');
                fileInput.value = '';
                return;
            }

            // Validate file size (10MB = 10 * 1024 * 1024 bytes)
            const maxSize = 10 * 1024 * 1024;
            if (file.size > maxSize) {
                showNotification('File size must be less than 10MB', 'error');
                fileInput.value = '';
                return;
            }

            // Display file preview
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            filePreview.classList.remove('hidden');
            
            // Change upload area style
            uploadArea.classList.add('border-blue-300', 'bg-blue-50');
            
            showNotification('File selected successfully!', 'success');
        }
    });

    // Remove file handler
    removeFileBtn.addEventListener('click', function() {
        fileInput.value = '';
        filePreview.classList.add('hidden');
        uploadArea.classList.remove('border-blue-300', 'bg-blue-50');
        showNotification('File removed', 'info');
    });

    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('border-blue-300', 'bg-blue-50');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        if (!uploadArea.contains(e.relatedTarget)) {
            uploadArea.classList.remove('border-blue-300', 'bg-blue-50');
        }
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-blue-300', 'bg-blue-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });

    // Form submission handler
    form.addEventListener('submit', function(e) {
        // Show loading state
        submitBtn.disabled = true;
        loadingSpinner.classList.remove('hidden');
        submitBtn.querySelector('span').textContent = 'Processing...';
    });

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Show notification
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
        
        // Set background color based on type
        switch(type) {
            case 'success':
                notification.className += ' bg-green-500 text-white';
                break;
            case 'error':
                notification.className += ' bg-red-500 text-white';
                break;
            case 'info':
                notification.className += ' bg-blue-500 text-white';
                break;
        }
        
        notification.textContent = message;
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
});
</script>
@endsection
