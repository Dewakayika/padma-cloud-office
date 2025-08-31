<div class="bg-white rounded-lg p-6 dark:bg-gray-800 dark:text-white">

    <div class="flex items-center mb-6">
        <div class="rounded-full bg-green-100 p-3 mr-3">

            <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M7.5 5.25a3 3 0 0 1 3-3h3a3 3 0 0 1 3 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0 1 12 15.75c-2.73 0-5.357-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 0 1 7.5 5.455V5.25Zm7.5 0v.09a49.488 49.488 0 0 0-6 0v-.09a1.5 1.5 0 0 1 1.5-1.5h3a1.5 1.5 0 0 1 1.5 1.5Zm-3 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                <path d="M3 18.4v-2.796a4.3 4.3 0 0 0 .713.31A26.226 26.226 0 0 0 12 17.25c2.892 0 5.68-.468 8.287-1.335.252-.084.49-.189.713-.311V18.4c0 1.452-1.047 2.728-2.523 2.923-2.12.282-4.282.427-6.477.427a49.19 49.19 0 0 1-6.477-.427C4.047 21.128 3 19.852 3 18.4Z" />
            </svg>


        </div>
        <div>
            <h1 class="text-xl font-semibold">Project Setup</h1>
            <p class="text-gray-600 dark:text-gray-400">Settings Up your project type with base price</p></p>
        </div>
    </div>

    <form id="add-project-type-form" class="border rounded-lg p-6 dark:bg-gray-900 dark:text-white dark:border-gray-800" action="{{ route('company.project.type.store') }}" method="POST">
        @csrf
        <input type="hidden" name="manual_sops_json" id="manual_sops_json">
        <input type="hidden" name="csv_sops_json" id="csv_sops_json">
        <h3 class="text-lg font-semibold mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Project Type
        </h3>
        <input type="hidden" name="user_id" value="{{ $user->id }}" />
        <input type="hidden" name="company_id" value="{{ $company->id }}" />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
            <div>
                <label for="project_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project Type Name</label>
                <input type="text" name="project_name" id="project_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white dark:border-gray-800 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="project_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project Rate ({{ $company->currency }})</label>
                <input type="number" name="project_rate" id="project_rate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white dark:border-gray-800 focus:ring-blue-500 focus:border-blue-500" step="0.01" required>
                <p class="text-gray-500 text-xs mt-1 dark:text-gray-400">Project Rate is in <span class="font-bold">{{ $company->currency }}</span> and will calculate the total project volume</p>
            </div>
            <div>
                <label for="qc_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">QC Rate (%)</label>
                <input type="number" name="qc_rate" id="qc_rate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white dark:border-gray-800 focus:ring-blue-500 focus:border-blue-500" step="0.01" required>
                <p class="text-gray-500 text-xs mt-1 dark:text-gray-400">QC Rate is in percentage</p>
            </div>
        </div>
        <div id="sop-section" class="block">
            <div class="bg-white dark:bg-gray-900 rounded-lg p-6 border border-gray-200 dark:border-gray-700 mt-4">
                <div id="sop-empty-state" class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="6" y="4" width="12" height="16" rx="2" fill="none" stroke="currentColor" stroke-width="2"/>
                        <path d="M9 9h6M9 13h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">No SOPs Found</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Get started by creating your first Standard Operating Procedure for this project type.</p>
                    <div class="mt-6 flex flex-col items-center gap-3">
                        <button type="button" id="create-first-sop-btn" class="inline-flex items-center px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Create First SOP
                        </button>
                        <div class="flex flex-row gap-2 mt-2">
                            <a href="{{ route('company.sop.csv.template') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download CSV Template
                            </a>
                            <label class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 cursor-pointer">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                Upload CSV
                                <input type="file" name="sop_csv" accept=".csv" class="hidden" onchange="handleCsvUploadPreview(event)" />
                            </label>
                        </div>
                    </div>
                </div>
                <!-- CSV Preview Table -->
                <div id="sop-csv-preview-section" class="hidden mt-8">
                    <h4 class="text-md font-semibold mb-2 text-gray-800 dark:text-gray-200">Preview SOPs from CSV</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SOP Formula</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody id="sop-csv-preview-body"></tbody>
                        </table>
                    </div>
                    <button type="button" id="save-csv-sops-btn" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save All SOPs
                    </button>
                </div>
                <!-- The manual SOP entry and preview table will be shown by JS only if there are SOPs -->
                <div id="sop-manual-section" class="hidden">
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 mb-2 font-medium">Add SOPs Manually</label>
                        <div id="manual-sop-list" class="space-y-2">
                            <!-- JS will add SOP rows here -->
                        </div>
                        <button type="button" id="add-sop-row" class="mt-2 bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded shadow">+ Add SOP Row</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md mt-4">Add Project Type</button>
    </form>

    {{-- List Current Project Type --}}
    <div class="mt-6">
        <h3 class="text-xl font-semibold mb-4">Existing Project Types</h3>
        {{-- Existing project types list --}}
        @forelse ($projectTypes as $projectType)
            <div class="bg-gray-100 p-3 px-6 rounded-md mb-3 flex justify-between items-center dark:bg-gray-900 dark:text-white dark:border-gray-800">
                <div>
                    <p class="font-semibold">{{ $projectType->project_name }}</p>
                    <p class="text-gray-600 text-sm dark:text-gray-400">Rate: {{ $projectType->project_rate }}</p>
                    <p class="text-gray-600 text-sm dark:text-gray-400">QC Rate: {{ $projectType->qc_rate }} %</p>
                </div>


                <div class="flex items-center space-x-2">
                    <button type="button" onclick="showSopDetails({{ $projectType->id }})" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View SOPs
                    </button>
                    <a href="{{ route('company.project.type.edit', $projectType->id) }}" class="text-blue-600 hover:text-blue-900 text-sm">Edit</a>
                    <form action="{{ route('company.project.type.destroy', $projectType->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project type?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-600 dark:text-gray-400">No project types added yet.</p>
        @endforelse

        <div class="mt-4">
            {{ $projectTypes->links() }}
        </div>
    </div>

</div>

<script>
    // Function to show SOP details tab with project type
    function showSopDetails(projectTypeId) {
        // Update URL with project type parameter and tab
        const url = new URL(window.location);
        url.searchParams.set('project_type_id', projectTypeId);
        url.searchParams.set('tab', 'sop-details');

        // Navigate to the updated URL to load the SOP data
        window.location.href = url.toString();
    }

document.addEventListener('DOMContentLoaded', function () {
    // Manual SOP row logic
    const manualSopList = document.getElementById('manual-sop-list');
    const addSopRowBtn = document.getElementById('add-sop-row');
    const sopPreviewTable = document.getElementById('sop-preview-table').querySelector('tbody');
    const sopSection = document.getElementById('sop-section');
    const projectNameInput = document.getElementById('project_name');
    const projectRateInput = document.getElementById('project_rate');
    const qcRateInput = document.getElementById('qc_rate');

    function createSopRow(sop = {sop_formula: '', description: ''}) {
        const row = document.createElement('div');
        row.className = 'flex space-x-2 mb-2';
        row.innerHTML = `
            <input type="text" name="manual_sops[][sop_formula]" placeholder="SOP Formula" value="${sop.sop_formula}" class="flex-1 border rounded px-2 py-1" required />
            <input type="text" name="manual_sops[][description]" placeholder="Description" value="${sop.description}" class="flex-1 border rounded px-2 py-1" />
            <button type="button" class="remove-sop-row bg-red-500 text-white px-2 rounded">&times;</button>
        `;
        row.querySelector('.remove-sop-row').onclick = () => row.remove();
        return row;
    }

    addSopRowBtn.onclick = function() {
        manualSopList.appendChild(createSopRow());
    };

    // CSV upload logic
    const sopCsvInput = document.querySelector('input[name="sop_csv"]');
    sopCsvInput && sopCsvInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(evt) {
            const lines = evt.target.result.split(/\r?\n/).filter(Boolean);
            if (lines.length < 2) return;
            const headers = lines[0].split(',');
            const sopFormulaIdx = headers.indexOf('sop_formula');
            const descIdx = headers.indexOf('description');
            if (sopFormulaIdx === -1) return;
            // Remove existing manual rows
            manualSopList.innerHTML = '';
            // Add rows from CSV
            for (let i = 1; i < lines.length; i++) {
                const cols = lines[i].split(',');
                if (!cols[sopFormulaIdx]) continue;
                manualSopList.appendChild(createSopRow({
                    sop_formula: cols[sopFormulaIdx],
                    description: descIdx !== -1 ? cols[descIdx] : ''
                }));
            }
        };
        reader.readAsText(file);
    });

    function checkShowSopSection() {
        if (projectNameInput.value && projectRateInput.value && qcRateInput.value) {
            sopSection.classList.remove('hidden');
        } else {
            sopSection.classList.add('hidden');
        }
    }
    projectNameInput.addEventListener('input', checkShowSopSection);
    projectRateInput.addEventListener('input', checkShowSopSection);
    qcRateInput.addEventListener('input', checkShowSopSection);
    checkShowSopSection();
});

// Show/hide empty state and manual section based on SOPs
function updateSopSectionDisplay() {
    const manualSopList = document.getElementById('manual-sop-list');
    const sopEmptyState = document.getElementById('sop-empty-state');
    const sopManualSection = document.getElementById('sop-manual-section');
    const sopCsvPreviewSection = document.getElementById('sop-csv-preview-section');

    console.log('Updating SOP section display:', {
        manualSops: manualSopList ? manualSopList.children.length : 0,
        csvData: window.sopCsvPreviewData ? window.sopCsvPreviewData.length : 0
    });

    if (manualSopList && manualSopList.children.length > 0) {
        sopEmptyState.classList.add('hidden');
        sopManualSection.classList.remove('hidden');
        sopCsvPreviewSection.classList.add('hidden');
    } else if (window.sopCsvPreviewData && window.sopCsvPreviewData.length > 0) {
        sopEmptyState.classList.add('hidden');
        sopManualSection.classList.add('hidden');
        sopCsvPreviewSection.classList.remove('hidden');
    } else {
        sopEmptyState.classList.remove('hidden');
        sopManualSection.classList.add('hidden');
        sopCsvPreviewSection.classList.add('hidden');
    }
}

// CSV Upload Preview Logic
function handleCsvUploadPreview(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(evt) {
        const lines = evt.target.result.split(/\r?\n/).filter(Boolean);
        console.log('CSV lines:', lines);

        if (lines.length < 2) {
            alert('CSV must have at least one SOP row.');
            return;
        }
        // Parse CSV with proper handling of quoted fields
        function parseCSVLine(line) {
            const result = [];
            let current = '';
            let inQuotes = false;

            for (let i = 0; i < line.length; i++) {
                const char = line[i];
                if (char === '"') {
                    inQuotes = !inQuotes;
                } else if (char === ',' && !inQuotes) {
                    result.push(current.trim());
                    current = '';
                } else {
                    current += char;
                }
            }
            result.push(current.trim());
            return result;
        }

        const headers = parseCSVLine(lines[0]);
        const sopFormulaIdx = headers.indexOf('sop_formula');
        const descIdx = headers.indexOf('description');

        console.log('Headers:', headers, 'SOP Formula Index:', sopFormulaIdx, 'Description Index:', descIdx);

        if (sopFormulaIdx === -1) {
            alert('CSV missing sop_formula column.');
            return;
        }
        window.sopCsvPreviewData = [];
        for (let i = 1; i < lines.length; i++) {
            const cols = parseCSVLine(lines[i]);
            if (!cols[sopFormulaIdx]) continue;
            window.sopCsvPreviewData.push({
                sop_formula: cols[sopFormulaIdx].replace(/"/g, '').trim(),
                description: descIdx !== -1 ? cols[descIdx].replace(/"/g, '').trim() : ''
            });
        }
        console.log('Parsed CSV data:', window.sopCsvPreviewData);
        renderCsvPreviewTable();
        updateSopSectionDisplay();
    };
    reader.readAsText(file);
}

function renderCsvPreviewTable() {
    const tbody = document.getElementById('sop-csv-preview-body');
    console.log('Rendering CSV preview table, tbody:', tbody);
    tbody.innerHTML = '';
    if (!window.sopCsvPreviewData) {
        console.log('No CSV preview data available');
        return;
    }
    console.log('Rendering', window.sopCsvPreviewData.length, 'SOP rows');
    window.sopCsvPreviewData.forEach((sop, idx) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="px-4 py-2"><input type="text" class="border rounded px-2 py-1 w-full" value="${sop.sop_formula}" onchange="window.sopCsvPreviewData[${idx}].sop_formula = this.value" /></td>
            <td class="px-4 py-2"><input type="text" class="border rounded px-2 py-1 w-full" value="${sop.description}" onchange="window.sopCsvPreviewData[${idx}].description = this.value" /></td>
            <td class="px-4 py-2 text-right"><button type="button" class="text-red-600 hover:text-red-900" onclick="removeCsvPreviewRow(${idx})">Delete</button></td>
        `;
        tbody.appendChild(tr);
    });
}

function removeCsvPreviewRow(idx) {
    window.sopCsvPreviewData.splice(idx, 1);
    renderCsvPreviewTable();
    updateSopSectionDisplay();
}

// Save All SOPs from CSV
const saveCsvSopsBtn = document.getElementById('save-csv-sops-btn');
if (saveCsvSopsBtn) {
    saveCsvSopsBtn.onclick = function() {
        if (!window.sopCsvPreviewData || window.sopCsvPreviewData.length === 0) {
            window.location.href = window.location.pathname + '?error=No SOPs to save.';
            return;
        }
        const formData = new FormData();
        formData.append('project_type_id', document.querySelector('input[name="company_id"]').value);
        formData.append('sops', JSON.stringify(window.sopCsvPreviewData));
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        fetch('{{ route("company.project.sop.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            window.location.reload();
        });
    };
}

// Attach to manual SOP row add/remove
const addSopRowBtn = document.getElementById('add-sop-row');
if (addSopRowBtn) {
    addSopRowBtn.onclick = function() {
        const manualSopList = document.getElementById('manual-sop-list');
        const row = document.createElement('div');
        row.className = 'flex space-x-2 mb-2';
        row.innerHTML = `
            <input type="text" name="manual_sops[][sop_formula]" placeholder="SOP Formula" class="flex-1 border rounded px-2 py-1" required />
            <input type="text" name="manual_sops[][description]" placeholder="Description" class="flex-1 border rounded px-2 py-1" />
            <button type="button" class="remove-sop-row bg-red-500 text-white px-2 rounded">&times;</button>
        `;
        row.querySelector('.remove-sop-row').onclick = () => {
            row.remove();
            updateSopSectionDisplay();
        };
        manualSopList.appendChild(row);
        updateSopSectionDisplay();
    };
}

// Initial display
updateSopSectionDisplay();

// Create First SOP button opens manual section
const createFirstSopBtn = document.getElementById('create-first-sop-btn');
if (createFirstSopBtn) {
    createFirstSopBtn.onclick = function() {
        document.getElementById('sop-empty-state').classList.add('hidden');
        document.getElementById('sop-manual-section').classList.remove('hidden');
        // Add one row if none exists
        const manualSopList = document.getElementById('manual-sop-list');
        if (manualSopList.children.length === 0) {
            const row = document.createElement('div');
            row.className = 'flex space-x-2 mb-2';
            row.innerHTML = `
                <input type="text" name="manual_sops[][sop_formula]" placeholder="SOP Formula" class="flex-1 border rounded px-2 py-1" required />
                <input type="text" name="manual_sops[][description]" placeholder="Description" class="flex-1 border rounded px-2 py-1" />
                <button type="button" class="remove-sop-row bg-red-500 text-white px-2 rounded">&times;</button>
            `;
            row.querySelector('.remove-sop-row').onclick = () => {
                row.remove();
                updateSopSectionDisplay();
            };
            manualSopList.appendChild(row);
        }
    };
}

// On form submit, gather all SOPs and attach as JSON
const addProjectTypeForm = document.getElementById('add-project-type-form');
addProjectTypeForm.addEventListener('submit', function(e) {
    // Gather manual SOPs
    const manualSopList = document.getElementById('manual-sop-list');
    const manualSops = [];
    if (manualSopList) {
        Array.from(manualSopList.children).forEach(row => {
            const sopFormula = row.querySelector('input[name^="manual_sops"][name$="[sop_formula]"]');
            const description = row.querySelector('input[name^="manual_sops"][name$="[description]"]');
            if (sopFormula && sopFormula.value.trim()) {
                manualSops.push({
                    sop_formula: sopFormula.value.trim(),
                    description: description ? description.value.trim() : ''
                });
            }
        });
    }
    document.getElementById('manual_sops_json').value = JSON.stringify(manualSops);

    // Gather CSV SOPs (from preview)
    if (window.sopCsvPreviewData && window.sopCsvPreviewData.length > 0) {
        document.getElementById('csv_sops_json').value = JSON.stringify(window.sopCsvPreviewData);
    } else {
        document.getElementById('csv_sops_json').value = '';
    }
});
</script>


