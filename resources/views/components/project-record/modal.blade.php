<div class="bg-white dark:bg-gray-900 w-full max-w-4xl mx-auto">
    <div class="modal fade" id="projectRecordModal" tabindex="-1" aria-labelledby="projectRecordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-white dark:bg-gray-800 rounded-lg shadow-xl max-h-[90vh] flex flex-col">
                <!-- Modal Header -->
                <div class="modal-header border-b border-gray-200 dark:border-gray-700 px-6 py-4 flex-shrink-0">
                    <h5 class="modal-title text-xl font-semibold text-gray-900 dark:text-white" id="projectRecordModalLabel">
                        Project SOP Checklist
                    </h5>
                </div>

                <form action="{{ route('talent.project-records.store', $project->id) }}" method="POST" id="sopForm" class="flex flex-col h-full">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="company_id" value="{{ $project->company_id }}">
                    <input type="hidden" name="user_id" value="{{ $projectData->user_id }}">
                    <input type="hidden" name="talent_id" value="{{ $project->talent }}">
                    <input type="hidden" name="qc_id" value="{{ $projectData->assignedQcAgent->id }}">


                    <div class="modal-body px-6 py-4 flex-grow overflow-y-auto">
                        <!-- Project Link Input -->
                        <div class="mb-6">
                            <label for="project_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Project Link
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <input type="url"
                                       class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('project_link') border-red-500 @enderror"
                                       id="project_link"
                                       name="project_link"
                                       value="{{ old('project_link') }}"
                                       placeholder="https://"
                                       required>
                                @error('project_link')
                                    <div class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- SOP Table -->
                        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">SOP Formula</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($sopList as $index => $sop)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $sop->sop_formula }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $sop->description }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 sop-status" id="status-{{ $sop->id }}">
                                                    Pending
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <button type="button"
                                                        class="pass-sop inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200"
                                                        data-sop-id="{{ $sop->id }}"
                                                        data-sop-formula="{{ $sop->sop_formula }}">
                                                    Pass
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Hidden input for passed SOPs -->
                        <input type="hidden" name="passed_sops" id="passedSops" value="">
                    </div>

                    <div class="modal-footer bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600 flex-shrink-0">
                        <button  @click="open = false" type="button"
                                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit"
                                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed ml-3"
                                id="saveRecordBtn"
                                disabled>
                            Save Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passedSops = new Set();
            const saveRecordBtn = document.getElementById('saveRecordBtn');
            const passedSopsInput = document.getElementById('passedSops');
            const modal = document.getElementById('projectRecordModal');
            const closeButtons = modal.querySelectorAll('[data-bs-dismiss="modal"]');

            // Handle close button clicks
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Reset the form
                    document.getElementById('sopForm').reset();
                    passedSops.clear();
                    passedSopsInput.value = '';
                    saveRecordBtn.disabled = true;

                    // Reset all SOP statuses
                    document.querySelectorAll('.sop-status').forEach(status => {
                        status.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 sop-status';
                        status.textContent = 'Pending';
                    });

                    // Reset all Pass buttons
                    document.querySelectorAll('.pass-sop').forEach(button => {
                        button.textContent = 'Pass';
                        button.classList.remove('bg-red-600', 'hover:bg-red-700', 'focus:ring-red-500');
                        button.classList.add('bg-green-600', 'hover:bg-green-700', 'focus:ring-green-500');
                    });

                    // Close the modal using Bootstrap's modal method
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                });
            });

            // Handle Pass button clicks
            document.querySelectorAll('.pass-sop').forEach(button => {
                button.addEventListener('click', function() {
                    const sopId = this.dataset.sopId;
                    const statusBadge = document.getElementById(`status-${sopId}`);

                    if (passedSops.has(sopId)) {
                        // Unpass
                        passedSops.delete(sopId);
                        statusBadge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 sop-status';
                        statusBadge.textContent = 'Pending';
                        this.textContent = 'Pass';
                        this.classList.remove('bg-red-600', 'hover:bg-red-700', 'focus:ring-red-500');
                        this.classList.add('bg-green-600', 'hover:bg-green-700', 'focus:ring-green-500');
                    } else {
                        // Pass
                        passedSops.add(sopId);
                        statusBadge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 sop-status';
                        statusBadge.textContent = 'Passed';
                        this.textContent = 'Unpass';
                        this.classList.remove('bg-green-600', 'hover:bg-green-700', 'focus:ring-green-500');
                        this.classList.add('bg-red-600', 'hover:bg-red-700', 'focus:ring-red-500');
                    }

                    // Update hidden input
                    passedSopsInput.value = Array.from(passedSops).join(',');

                    // Enable/disable save button based on whether all SOPs are passed
                    saveRecordBtn.disabled = passedSops.size !== {{ count($sopList) }};
                });
            });

            // Form submission
            document.getElementById('sopForm').addEventListener('submit', function(e) {
                if (passedSops.size !== {{ count($sopList) }}) {
                    e.preventDefault();
                    alert('Please pass all SOPs before saving.');
                }
            });
        });
    </script>
    @endpush

</div>
