@extends('layouts.app')
@section('title', 'Edit Project Type')
@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Edit Project Type</h2>

    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif

    <form action="{{ route('company.project.type.update', $projectType->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $projectType->name) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $projectType->description) }}</textarea>
        </div>
        <div>
            <label for="qc_rate" class="block text-sm font-medium text-gray-700">QC Rate</label>
            <input type="number" step="0.01" name="qc_rate" id="qc_rate" value="{{ old('qc_rate', $projectType->qc_rate) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="flex items-center space-x-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
            <a href="{{ route('company.settings') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Back to Settings</a>
        </div>
    </form>
</div>
@endsection 