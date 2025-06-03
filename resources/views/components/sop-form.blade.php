@props(['projectType'])

<div class="bg-white rounded-lg p-6 shadow-sm">
    <div class="flex items-center mb-6">
        <div class="rounded-full bg-blue-100 p-3 mr-3">
            <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19.5 22.5a.75.75 0 0 0 0-1.5H21a.75.75 0 0 0 .75-.75V6a3 3 0 0 0-3-3h-3a.75.75 0 0 0-.75.75v1.5a.75.75 0 0 0 .75.75h2.25a.75.75 0 0 1 .75.75v10.5a.75.75 0 0 1-.75.75h-9.75a.75.75 0 0 1-.75-.75V6.75a.75.75 0 0 0-.75-.75H5.25a.75.75 0 0 0-.75.75v10.5c0 .414.336.75.75.75H19.5Z" />
                <path d="M12 12.75a.75.75 0 0 0 0-1.5H9a.75.75 0 0 0-.75.75c0 .414.336.75.75.75h3Z" />
                <path d="M7.5 6.75a.75.75 0 0 0 0-1.5H5.25a.75.75 0 0 0-.75.75v1.5c0 .414.336.75.75.75H7.5a.75.75 0 0 0 .75-.75V7.5a.75.75 0 0 0-.75-.75ZM12 9.75a.75.75 0 0 0 0-1.5H9a.75.75 0 0 0-.75.75c0 .414.336.75.75.75h3Z" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-semibold">Add New SOP</h2>
            <p class="text-gray-600">Create a new Standard Operating Procedure for {{ $projectType->project_name }}</p>
        </div>
    </div>

    <form id="sop-form" action="{{ route('company.project.sop.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="project_type_id" value="{{ $projectType->id }}">

        <div>
            <label for="sop_formula" class="block text-sm font-medium text-gray-700">SOP Formula</label>
            <textarea
                name="sop_formula"
                id="sop_formula"
                rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Enter the SOP formula..."
                required
            ></textarea>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
            <textarea
                name="description"
                id="description"
                rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Enter a description for this SOP..."
            ></textarea>
        </div>

        <div class="flex justify-end space-x-3">
            <button type="button" onclick="closeSopForm()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Cancel
            </button>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Save SOP
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function closeSopForm() {
        const form = document.getElementById('sop-form');
        if (form) {
            form.closest('.bg-white').remove();
        }
    }

    document.getElementById('sop-form').addEventListener('submit', function(e) {
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
                // Close the form
                closeSopForm();
                // Refresh the SOP list
                if (typeof fetchAndDisplaySops === 'function') {
                    fetchAndDisplaySops(formData.get('project_type_id'));
                } else {
                    window.location.reload();
                }
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

    // Add input event listeners to remove error styling when user types
    const formInputs = document.querySelectorAll('#sop-form input, #sop-form textarea');
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('border-red-500');
            const errorMessage = this.parentNode.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        });
    });
</script>
@endpush
