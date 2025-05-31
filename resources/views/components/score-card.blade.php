<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-lg p-6 flex items-center space-x-4">
    @if($icon)
        <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center {{ $iconBackground ?? 'bg-blue-100' }} {{ $iconColor ?? 'text-blue-500' }}">
            <i class="{{ $icon }} text-xl"></i>
        </div>
    @endif
    <div>
        <div class="text-3xl font-bold text-gray-800 dark:text-white">{{ $value }}</div>
        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $description }}</div>
    </div>
</div>
