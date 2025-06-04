@props(['type', 'message'])

<div class="flex items-center p-4 mb-4 text-sm {{
    $type == 'success' ? 'text-green-800 border-green-300 bg-green-50 dark:text-white dark:bg-green-800' :
    ($type == 'error' ? 'text-red-800 border-red-300 bg-red-50 dark:text-white dark:bg-red-800' :
    ($type == 'warning' ? 'text-yellow-800 border-yellow-300 bg-yellow-50 dark:text-white dark:bg-yellow-800' :
    ($type == 'info' ? 'text-blue-800 border-blue-300 bg-blue-50 dark:text-white dark:bg-blue-800' : '')))
}} border rounded-lg dark:bg-gray-800 dark:text-{{ $type }}-400 dark:border-{{ $type }}-800" role="alert">

    <!-- Success Icon -->
    @if($type == 'success')
        <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M2.293 9.293a1 1 0 011.414 0L8 13.586l7.293-7.293a1 1 0 111.414 1.414l-8 8a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414z" clip-rule="evenodd"/>
        </svg>
    @endif

    <!-- Error Icon -->
    @if($type == 'error')
        <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-14a6 6 0 110 12 6 6 0 010-12zm-.75 9a.75.75 0 011.5 0v-4.5a.75.75 0 10-1.5 0v4.5zM10 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
        </svg>
    @endif

    <!-- Warning Icon -->
    @if($type == 'warning')
        <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 2a8 8 0 11-8 8 8 8 0 018-8zm0 14a6 6 0 100-12 6 6 0 000 12zM9 7a1 1 0 011-1h1a1 1 0 110 2h-2a1 1 0 01-1-1zm1 4a1 1 0 011 1v4a1 1 0 11-2 0v-4a1 1 0 011-1z" clip-rule="evenodd"/>
        </svg>
    @endif

    <!-- Info Icon -->
    @if($type == 'info')
        <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-14a6 6 0 110 12 6 6 0 010-12zm-.75 9a.75.75 0 011.5 0v-4.5a.75.75 0 10-1.5 0v4.5zM10 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
        </svg>
    @endif

    <span class="sr-only">{{ ucfirst($type) }}</span>
    <div>
        <span class="font-medium">{{ ucfirst($type) }} alert!</span> {{ $message }}
    </div>
</div>
