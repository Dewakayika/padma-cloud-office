@props(['projectTypes'])

<div class="bg-white rounded-lg p-6 dark:bg-gray-800 dark:text-white">
    <div class="flex items-center mb-6">
        <div class="rounded-full bg-blue-100 p-3 mr-3">
            <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path d="M19.5 22.5a.75.75 0 0 0 0-1.5H21a.75.75 0 0 0 .75-.75V6a3 3 0 0 0-3-3h-3a.75.75 0 0 0-.75.75v1.5a.75.75 0 0 0 .75.75h2.25a.75.75 0 0 1 .75.75v10.5a.75.75 0 0 1-.75.75h-9.75a.75.75 0 0 1-.75-.75V6.75a.75.75 0 0 0-.75-.75H5.25a.75.75 0 0 0-.75.75v10.5c0 .414.336.75.75.75H19.5Z" />
                <path d="M12 12.75a.75.75 0 0 0 0-1.5H9a.75.75 0 0 0-.75.75c0 .414.336.75.75.75h3Z" />
                <path d="M7.5 6.75a.75.75 0 0 0 0-1.5H5.25a.75.75 0 0 0-.75.75v1.5c0 .414.336.75.75.75H7.5a.75.75 0 0 0 .75-.75V7.5a.75.75 0 0 0-.75-.75ZM12 9.75a.75.75 0 0 0 0-1.5H9a.75.75 0 0 0-.75.75c0 .414.336.75.75.75h3Z" />
            </svg>
        </div>
        <div>
            <h1 class="text-xl font-semibold">SOP Setup</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage Standard Operating Procedures for project types</p>
        </div>
    </div>

    {{-- Project Types List --}}
    <div class="space-y-4">
        @forelse($projectTypes as $projectType)
            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:bg-gray-900 dark:text-white dark:border-gray-800">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $projectType->project_name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">Rate: ${{ number_format($projectType->project_rate, 2) }}</p>
                    </div>
                    <div>
                        <a href="{{ route('company.project.type.sops', $projectType->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View SOPs
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No Project Types</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new project type.</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $projectTypes->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const projectTypeSelect = document.getElementById('select_project_type_sop');
        const projectSopsSection = document.getElementById('project-sops-section');
        const projectSopsListBody = document.querySelector('#project-sops-list tbody');
        const sopProjectTypeIdInput = document.getElementById('sop_project_type_id');
        const noSopsMessage = document.getElementById('no-sops-message');

        const toggleAddSopButton = document.getElementById('toggle-add-sop-form');
        const addSopFormContainer = document.getElementById('add-sop-form-container');
        const addSopForm = document.getElementById('add-sop-form');

        // Function to fetch and display SOPs
        function fetchAndDisplaySops(projectTypeId) {
            if (projectTypeId) {
                // Show SOPs section and set the project type ID for the form
                projectSopsSection.classList.remove('hidden');
                sopProjectTypeIdInput.value = projectTypeId;

                // Hide the add SOP form when a new project type is selected
                addSopFormContainer.classList.add('hidden');

                // Fetch and display SOPs
                fetch(`/company/project-sops/${projectTypeId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(sops => {
                        console.log('Received SOPs:', sops); // Debug log
                        projectSopsListBody.innerHTML = ''; // Clear previous SOPs
                        if (sops.length > 0) {
                            noSopsMessage.classList.add('hidden');
                            sops.forEach(sop => {
                                const sopRow = `
                                    <tr>
                                        <td class="px-6 py-4 whitespace-pre-wrap">${sop.sop_formula}</td>
                                        <td class="px-6 py-4 whitespace-pre-wrap">${sop.description ? sop.description : '-'}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                            <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                        </td>
                                    </tr>
                                `;
                                projectSopsListBody.innerHTML += sopRow;
                            });
                        } else {
                            noSopsMessage.classList.remove('hidden');
                            noSopsMessage.textContent = 'No SOPs found for this project type.';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching SOPs:', error);
                        projectSopsListBody.innerHTML = ''; // Clear list on error
                        noSopsMessage.classList.remove('hidden');
                        noSopsMessage.textContent = 'Failed to load SOPs. Please try again.';
                    });
            } else {
                // Hide SOPs section if no project type is selected
                projectSopsSection.classList.add('hidden');
                projectSopsListBody.innerHTML = '';
                noSopsMessage.classList.add('hidden');
                sopProjectTypeIdInput.value = '';
            }
        }

        projectTypeSelect.addEventListener('change', function () {
            fetchAndDisplaySops(this.value);
        });

        // Toggle visibility of the Add SOP form
        if (toggleAddSopButton && addSopFormContainer) {
            toggleAddSopButton.addEventListener('click', function() {
                addSopFormContainer.classList.toggle('hidden');
            });
        }

        // Handle form submission with AJAX to update the list without a full page reload
        if (addSopForm) {
            addSopForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                // Clear any existing error messages
                const errorMessages = document.querySelectorAll('.error-message');
                errorMessages.forEach(el => el.remove());

                fetch(this.action, {
                    method: this.method,
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                        return null;
                    }
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(JSON.stringify(data));
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.success) {
                        // Refresh the SOP list for the current project type
                        fetchAndDisplaySops(sopProjectTypeIdInput.value);
                        // Clear the form and hide it
                        addSopForm.reset();
                        addSopFormContainer.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    try {
                        const errorData = JSON.parse(error.message);
                        if (errorData.errors) {
                            // Handle validation errors
                            Object.keys(errorData.errors).forEach(field => {
                                const input = document.querySelector(`[name="${field}"]`);
                                if (input) {
                                    const errorMessage = document.createElement('p');
                                    errorMessage.className = 'error-message text-red-500 text-sm mt-1';
                                    errorMessage.textContent = errorData.errors[field][0];
                                    input.parentNode.appendChild(errorMessage);
                                    input.classList.add('border-red-500');
                                }
                            });
                        } else if (errorData.message) {
                            alert(errorData.message);
                        }
                    } catch (e) {
                        alert('Failed to save SOP. Please try again.');
                    }
                });
            });
        }

        // Add input event listeners to remove error styling when user types
        const formInputs = addSopForm.querySelectorAll('input, textarea');
        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('border-red-500');
                const errorMessage = this.parentNode.querySelector('.error-message');
                if (errorMessage) {
                    errorMessage.remove();
                }
            });
        });

        // Initial state: Hide SOPs section and Add SOP form
        projectSopsSection.classList.add('hidden');
        noSopsMessage.classList.add('hidden');
        addSopFormContainer.classList.add('hidden'); // Ensure form is hidden on load

        // Trigger change event if a project type is already selected (e.g., due to old input on page load)
        if (projectTypeSelect.value) {
            fetchAndDisplaySops(projectTypeSelect.value);
        }
    });
</script>
@endpush
