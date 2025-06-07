@props(['title' => 'Message', 'message' => '', 'sender' => '', 'status' => '', 'type' => 'info'])

<div x-data="{
    open: false,
    title: '{{ $title }}',
    message: '{{ $message }}',
    sender: '{{ $sender ?? '' }}',
    status: '{{ $status ?? '' }}',
    init() {
        window.addEventListener('open-message-modal', (e) => {
            this.title = e.detail.title;
            this.message = e.detail.message;
            this.sender = e.detail.sender;
            this.status = e.detail.status;
            this.open = true;
        });
    }
}"
     x-show="open"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[9999] flex justify-end items-stretch"
     style="display: none;">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-30 transition-opacity z-[9998]" @click="open = false"></div>
    <!-- Side Panel -->
    <div class="fixed right-0 top-0 h-full w-full max-w-xl bg-white shadow-2xl rounded-l-2xl flex flex-col overflow-y-auto animate-slide-in-right z-[10000]">
        <!-- Close Button -->
        <button @click="open = false" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 text-2xl focus:outline-none z-[10001]">
            &times;
        </button>
        <!-- Content -->
        <div class="p-8 pt-12 flex-1 flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900 mb-2" x-text="title"></h2>
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <span class="mr-4">From: <span class="font-semibold text-gray-700" x-text="sender"></span></span>
                <span>Status: <span class="font-semibold text-gray-700" x-text="status"></span></span>
            </div>
            <div class="border-b border-gray-200 mb-4"></div>
            <div class="text-gray-700 text-base whitespace-pre-line mb-6" x-html="message"></div>
            <!-- Example: Activities section (optional, can be removed or customized) -->

            {{-- <div class="mt-auto">
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-sm font-semibold text-gray-500 mb-2">Activities</h3>
                    <ul class="text-xs text-gray-400 space-y-1">
                        <li>John Doe marked as done · 2 days ago</li>
                        <li>Jane Smith added a comment · 3 days ago</li>
                    </ul>
                </div>
            </div> --}}

        </div>
    </div>
    <style>
        @keyframes slide-in-right {
            0% { transform: translateX(100%); }
            100% { transform: translateX(0); }
        }
        .animate-slide-in-right {
            animation: slide-in-right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</div>
