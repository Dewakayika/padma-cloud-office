<div class=" inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden transform transition-all sm:my-8 sm:align-middle sm:w-full">
    <div class="max-h-[80vh] overflow-y-auto">

        <div class="px-6 py-4">
            <div>
                <h1 class="text-2xl font-semibold">Create Project</h1>
                <p class="text-gray-600">Assign and Create New Project and track the progress</p>
            </div>
            <form
                method="POST"
                action="{{ route('company.project.store') }}"
                enctype="multipart/form-data">
        @csrf
                <input type="hidden" name="company_id" value="{{ $company->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                        {{-- Project Name --}}
                        <div class="mt-4">
                            <x-label for="project_name" value="{{ __('Project Name') }}"/>
                            <x-input
                                id="project_name"
                                class="block mt-1 w-full"
                                type="text"
                                name="project_name"
                                :value="old('project_name')"
                                required="required"
                                autofocus="autofocus"/>
                            @error('project_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-label for="project_type_id" value="{{ __('Project Type') }}"/>
                            <select
                                id="project_type_id"
                                name="project_type_id"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required="required">
                                <option value="">Select Project Type</option>
                                @foreach($projectTypes as $type)
                                <option
                                    value="{{ $type->id }}"
                                    data-rate="{{ $type->project_rate }}"
                                    {{ old('project_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->project_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('project_type_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Project Rate (hidden until selected) --}}
                        <div class="mt-4" id="project_rate_container" style="display: none;">
                            <x-label for="project_rate" value="{{ __('Project Rate') }}"/>
                            <x-input
                                id="project_rate"
                                class="block mt-1 w-full"
                                type="number"
                                name="project_rate"
                                readonly="readonly"/>
                        </div>

                        {{-- Project Volume --}}
                        <div class="mt-4">
                            <x-label for="project_volume" value="{{ __('Project Volume') }}"/>
                            <x-input
                                id="project_volume"
                                class="block mt-1 w-full"
                                type="number"
                                name="project_volume"
                                :value="old('project_volume')"
                                required="required"
                                min="0"
                                step="0.01"/>
                            @error('project_volume')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Project Link --}}
                        <div class="mt-4">
                            <x-label for="project_file" value="{{ __('Project File Link*') }}"/>
                            <x-input
                                id="project_file"
                                class="block mt-1 w-full"
                                type="url"
                                name="project_file"
                                :value="old('project_file')"
                                placeholder="https://example.com"/>
                            <p class="text-xs text-gray-500 mt-1">Add any relevant project links or references</p>
                            @error('project_file')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- QC Rate --}}
                        <div class="mt-4">
                            <x-label for="qc_rate" value="{{ __('QC Rate') }}"/>
                            <x-input
                                id="qc_rate"
                                class="block mt-1 w-full"
                                type="number"
                                name="qc_rate"
                                :value="old('qc_rate')"
                                required="required"
                                min="0"
                                step="0.01"/>
                            @error('qc_rate')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Bonuses --}}
                        <div class="mt-4">
                            <x-label for="bonuses" value="{{ __('Bonuses (Optional)') }}"/>
                            <x-input
                                id="bonuses"
                                class="block mt-1 w-full"
                                type="number"
                                name="bonuses"
                                :value="old('bonuses')"
                                min="0"
                                step="0.01"/>
                            @error('bonuses')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Talent Selection (Optional) --}}
                        <div class="mt-4">
                            <x-label for="talent" value="{{ __('Assign Talent (Optional)') }}"/>
                            <select
                                id="talent"
                                name="talent"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Select Talent</option>
                                @foreach($talents as $talent)
                                    <option
                                        value="{{ $talent->id }}"
                                        {{ old('talent') == $talent->id ? 'selected' : '' }}>
                                        {{ $talent->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('talent')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- QC Type Selection --}}
                            <div class="mt-4">
                            <x-label for="qc_type" value="{{ __('QC Type*') }}"/>
                            <select
                                id="qc_type"
                                name="qc_type"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required="required">
                                <option value="">Select QC Type</option>
                                <option value="self" {{ old('qc_type') == 'self' ? 'selected' : '' }}>Self QC</option>
                                <option value="talent" {{ old('qc_type') == 'talent' ? 'selected' : '' }}>Talent QC</option>
                            </select>
                            @error('qc_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- QC Agent Selection (Dynamic) --}}
                        <div class="mt-4" id="qc_agent_container" style="display: none;">
                            <x-label for="qc_agent" value="{{ __('Select QC Agent*') }}"/>
                            <select
                                id="qc_agent"
                                name="qc_agent"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Select QC Agent</option>
                                {{-- Options will be populated dynamically via JavaScript --}}
                            </select>
                            @error('qc_agent')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
                            {{-- Cancel Button --}}
                            <x-secondary-button id="cancelCreateProjectButton" type="button" class="ms-4">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            {{-- Create Project Button --}}
            <x-button class="ms-4">
                                {{ __('Create Project') }}
            </x-button>
        </div>
    </form>
</div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const qcTypeSelect = document.getElementById('qc_type');
                const qcAgentContainer = document.getElementById('qc_agent_container');
                const qcAgentSelect = document.getElementById('qc_agent');

                // Function to update QC agent options
                function updateQcAgentOptions() {
                    const selectedType = qcTypeSelect.value;
                    qcAgentSelect.innerHTML = '<option value="">Select QC Agent</option>';

                    if (selectedType === 'self') {
                        // Add self as the only option
                        qcAgentSelect.innerHTML += `<option value="{{ auth()->id() }}">{{ auth()->user()->name }} (Self)</option>`;
                        qcAgentSelect.value = "{{ auth()->id() }}";
                    } else if (selectedType === 'talent') {
                        // Add talent options
                        @foreach($talents as $talent)
                        qcAgentSelect.innerHTML += `<option value="{{ $talent->id }}" {{ old('qc_agent') == $talent->id ? 'selected' : '' }}>
                    {{ $talent->name }}
                </option>`;
                        @endforeach
                    }

                    // Show/hide the QC agent container
                    qcAgentContainer.style.display = selectedType
                        ? 'block'
                        : 'none';
                }

                // Initial update
                updateQcAgentOptions();

                // Update on change
                qcTypeSelect.addEventListener('change', updateQcAgentOptions);
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const projectTypeSelect = document.getElementById('project_type_id');
                const projectRateContainer = document.getElementById('project_rate_container');
                const projectRateInput = document.getElementById('project_rate');

                function handleProjectTypeChange() {
                    const selectedOption = projectTypeSelect.options[projectTypeSelect.selectedIndex];
                    const rate = selectedOption.dataset.rate;

                    if (rate) {
                        projectRateInput.value = rate;
                        projectRateContainer.style.display = 'block';
                    } else {
                        projectRateInput.value = '';
                        projectRateContainer.style.display = 'none';
                    }
                }

                // Attach event listener
                projectTypeSelect.addEventListener('change', handleProjectTypeChange);

                // Run on page load in case old value exists
                handleProjectTypeChange();
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modalContainer = document.getElementById('createProjectModal');
                const cancelButton = document.getElementById('cancelCreateProjectButton');

                if (cancelButton && modalContainer) {
                    cancelButton.addEventListener('click', function () {
                        modalContainer.style.display = 'none';
                    });
                }
            });
        </script>
