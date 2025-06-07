@extends('layouts.app')
@section('title', 'SOP Details')
@section('meta_description', 'Padma Cloud Office - SOP Details')

@section('content')
<div class="p-2 md:p-4 sm:ml-64">
    <div class="p-2 md:p-4">
        <div class="container mx-auto p-4">

            @if(session('success'))
            <x-alert type="success" :message="session('success')" />
            @endif

            @if(session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif

            @if(session('warning'))
                <x-alert type="warning" :message="session('warning')" />
            @endif

            @if(session('info'))
                <x-alert type="info" :message="session('info')" />
            @endif
            {{-- Breadcrumb --}}
            <x-breadscrums/>

            {{-- Project Type Header --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $projectType->project_name }}</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Project Rate: ${{ number_format($projectType->project_rate, 2) }}</p>
                    </div>
                    <div>
                        <button type="button" id="add-sop-button" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add New SOP
                        </button>
                    </div>
                </div>
            </div>

            {{-- SOP List --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Standard Operating Procedures</h2>

                    @if($sops->isEmpty())
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No SOPs</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new SOP.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($sops as $sop)
                                <div class="border dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">SOP Formula</h3>
                                            <p class="mt-1 text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $sop->sop_formula }}</p>

                                            @if($sop->description)
                                                <h4 class="mt-3 text-sm font-medium text-gray-900 dark:text-white">Description</h4>
                                                <p class="mt-1 text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $sop->description }}</p>
                                            @endif

                                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                Created by {{ $sop->user->name }} on {{ $sop->created_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <button type="button" class="text-blue-600 hover:text-blue-900 mr-3" onclick="editSop({{ $sop->id }})">
                                                Edit
                                            </button>
                                            <button type="button" class="text-red-600 hover:text-red-900" onclick="deleteSop({{ $sop->id }})">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $sops->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add/Edit SOP Modal --}}
<div id="sop-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden" aria-hidden="true">
    <div class="fixed inset-0 z-10 overflow-y-auto">
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
                                <label for="sop_formula" class="block text-sm font-medium text-gray-700 dark:text-gray-400">SOP Formula</label>
                                <textarea name="sop_formula" id="sop_formula" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Description (Optional)</label>
                                <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            </div>

                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">
                                    Save
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



<script>
    const modal = document.getElementById('sop-modal');
    const form = document.getElementById('sop-form');
    const addButton = document.getElementById('add-sop-button');

    function openModal() {
        modal.classList.remove('hidden');
        document.getElementById('modal-title').textContent = 'Add New SOP';
        form.reset();
        document.getElementById('sop_id').value = '';
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    function editSop(sopId) {
        fetch(`/company/project-sop/${sopId}`, {
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

    function deleteSop(sopId) {
        if (confirm('Are you sure you want to delete this SOP?')) {
            fetch(`/company/project-sop/${sopId}`, {
                method: 'DELETE',
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
                    alert(data?.message || 'Failed to delete SOP');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                try {
                    const errorData = JSON.parse(error.message);
                    if (errorData.message) {
                        alert(errorData.message);
                    } else {
                        alert('Failed to delete SOP.');
                    }
                } catch(e) {
                    alert('Failed to delete SOP. Please try again.');
                }
            });
        }
    }

    addButton.addEventListener('click', openModal);

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        const sopId = formData.get('sop_id');
        const url = sopId ? `/company/project-sop/${sopId}` : form.action;
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
@endsection

