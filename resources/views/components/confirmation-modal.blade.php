@props([
    'id' => 'confirmation-modal',
    'title' => 'Confirm Action',
    'message' => 'Are you sure you want to proceed?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'confirmColor' => 'bg-red-600 hover:bg-red-700',
    'cancelColor' => 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600'
])

<div x-data="confirmationModal()"
     x-show="open"
     x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
    <div @click.outside="close()" class="bg-white dark:bg-gray-800 p-6 rounded-xl w-full max-w-md shadow-xl">
        <div class="flex items-center mb-4">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white" x-text="title"></h3>
            </div>
        </div>

        <div class="mb-6">
            <p class="text-sm text-gray-600 dark:text-gray-400" x-text="message"></p>
        </div>

        <div class="flex justify-end space-x-3">
            <button type="button"
                    @click="close()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 {{ $cancelColor }} border border-gray-300 dark:border-gray-600 dark:text-gray-300 rounded-lg transition-colors">
                {{ $cancelText }}
            </button>
            <button type="button"
                    @click="confirm()"
                    class="px-4 py-2 text-sm font-medium text-white {{ $confirmColor }} border border-transparent rounded-lg transition-colors">
                {{ $confirmText }}
            </button>
        </div>
    </div>
</div>

<script>
function confirmationModal() {
    return {
        open: false,
        title: '{{ $title }}',
        message: '{{ $message }}',
        onConfirm: null,

        show(title, message, onConfirm) {
            this.title = title || this.title;
            this.message = message || this.message;
            this.onConfirm = onConfirm;
            this.open = true;
        },

        close() {
            this.open = false;
            this.onConfirm = null;
        },

        confirm() {
            if (this.onConfirm && typeof this.onConfirm === 'function') {
                this.onConfirm();
            }
            this.close();
        }
    }
}

// Global function to show confirmation modal
window.showConfirmation = function(title, message, onConfirm) {
    const modal = document.querySelector('[x-data*="confirmationModal"]');
    if (modal) {
        const alpineComponent = Alpine.$data(modal);
        alpineComponent.show(title, message, onConfirm);
    }
};
</script>
