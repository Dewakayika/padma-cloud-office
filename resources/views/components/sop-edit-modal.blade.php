@props(['projectType'])

{{-- Add/Edit SOP Modal --}}
<div id="sop-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden z-50" aria-hidden="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <div class="absolute right-0 top-0 pr-4 pt-4">
                    <button type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none" onclick="closeModal()">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white" id="modal-title">Add New SOP</h3>
                        <form id="sop-form" action="{{ route('company.project.sop.store') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="project_type_id" value="{{ $projectType->id }}">
                            <input type="hidden" name="sop_id" id="sop_id">
                            <div class="mb-4">
                                <label for="sop_formula" class="block text-sm font-medium text-gray-700 dark:text-gray-400">SOP Formula <span class="text-red-500">*</span></label>
                                <textarea name="sop_formula" id="sop_formula" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter the SOP formula or procedure..."></textarea>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter the step-by-step procedure or formula for this SOP.</p>
                            </div>
                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Description (Optional)</label>
                                <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Provide additional context or notes..."></textarea>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Add any additional context, notes, or explanations for this SOP.</p>
                            </div>
                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">
                                    Save SOP
                                </button>
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" onclick="closeModal()">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Modal functionality for SOP Edit/Add
    const modal = document.getElementById('sop-modal');
    const form = document.getElementById('sop-form');

    window.openModal = function() {
        modal.classList.remove('hidden');
        document.getElementById('modal-title').textContent = 'Add New SOP';
        form.reset();
        document.getElementById('sop_id').value = '';
    }

    window.closeModal = function() {
        modal.classList.add('hidden');
    }

    window.editSop = function(sopId) {
        fetch(`/company/sop/${sopId}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load SOP details');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('modal-title').textContent = 'Edit SOP';
            document.getElementById('sop_id').value = data.id;
            document.getElementById('sop_formula').value = data.sop_formula || '';
            document.getElementById('description').value = data.description || '';
            modal.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load SOP details');
        });
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        const sopId = formData.get('sop_id');
        const url = sopId ? `/company/sop/${sopId}` : form.action;
        const method = sopId ? 'PUT' : 'POST';

        if (method === 'PUT') {
            formData.append('_method', 'PUT');
        }

        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(el => el.remove());

        fetch(url, {
            method: 'POST',
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
                return response.json().then(data => { throw new Error(JSON.stringify(data)); });
            }
            return response.json();
        })
        .then(data => {
            if (data && data.success) {
                window.location.reload();
            } else {
                alert(data?.message || 'Failed to save SOP');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            try {
                const errorData = JSON.parse(error.message);
                if (errorData.errors) {
                    Object.keys(errorData.errors).forEach(field => {
                        const input = document.getElementById(field);
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
                } else {
                    alert('Failed to save SOP.');
                }
            } catch (e) {
                alert('Failed to save SOP. Please try again.');
            }
        });
    });

    // Clear error messages on input
    document.getElementById('sop_formula').addEventListener('input', function() {
        this.classList.remove('border-red-500');
        const errorMessage = this.parentNode.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
    });

    document.getElementById('description').addEventListener('input', function() {
        this.classList.remove('border-red-500');
        const errorMessage = this.parentNode.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
    });
</script>
@endpush 