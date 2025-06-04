@props(['icon', 'title', 'value', 'iconColor' => 'text-red-500', 'bgColor' => 'bg-red-100'])

<div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800">
    <div class="flex items-center">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg {{ $bgColor }} dark:bg-red-900/30">
             <svg class="w-6 h-6 {{ $iconColor }} dark:text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                {{ $icon }}
            </svg>
        </div>
        <div class="flex-1 min-w-0 ml-4">
            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                {{ $title }}
            </p>
            <p class="text-3xl font-semibold text-gray-900 dark:text-white">
                {{ $value }}
            </p>
        </div>
    </div>
</div>