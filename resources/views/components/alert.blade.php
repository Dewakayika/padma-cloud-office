@props(['type', 'message'])

<div class="fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full animate-slide-in {{
    $type == 'success' ? 'bg-green-500 text-white' :
    ($type == 'error' ? 'bg-red-500 text-white' :
    ($type == 'warning' ? 'bg-yellow-500 text-white' :
    ($type == 'info' ? 'bg-blue-500 text-white' : 'bg-gray-500 text-white')))
}}" role="alert" id="alert-{{ uniqid() }}">

    <div class="flex items-center">
        <!-- Success Icon -->
        @if($type == 'success')
            <svg class="shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2.293 9.293a1 1 0 011.414 0L8 13.586l7.293-7.293a1 1 0 111.414 1.414l-8 8a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        @endif

        <!-- Error Icon -->
        @if($type == 'error')
            <svg class="shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
        @endif

        <!-- Warning Icon -->
        @if($type == 'warning')
            <svg class="shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 2a8 8 0 11-8 8 8 8 0 018-8zm0 14a6 6 0 100-12 6 6 0 000 12zM9 7a1 1 0 011-1h1a1 1 0 110 2h-2a1 1 0 01-1-1zm1 4a1 1 0 011 1v4a1 1 0 11-2 0v-4a1 1 0 011-1z" clip-rule="evenodd"/>
            </svg>
        @endif

        <!-- Info Icon -->
        @if($type == 'info')
            <svg class="shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-14a6 6 0 110 12 6 6 0 010-12zm-.75 9a.75.75 0 011.5 0v-4.5a.75.75 0 10-1.5 0v4.5zM10 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
            </svg>
        @endif

        <span class="font-medium">{{ ucfirst($type) }} alert!</span> {{ $message }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-remove alerts after 3 seconds
    const alerts = document.querySelectorAll('[role="alert"]');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.classList.add('translate-x-full');
            setTimeout(function() {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 300);
        }, 3000);
    });
});
</script>

<style>
@keyframes slideIn {
    0% {
        transform: translateX(100%);
        opacity: 0;
    }
    100% {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    0% {
        transform: translateX(0);
        opacity: 1;
    }
    100% {
        transform: translateX(100%);
        opacity: 0;
    }
}

.animate-slide-in {
    animation: slideIn 0.3s ease-out forwards;
}

.animate-slide-out {
    animation: slideOut 0.3s ease-in forwards;
}

/* Optional: Add a subtle bounce effect */
@keyframes slideInBounce {
    0% {
        transform: translateX(100%);
        opacity: 0;
    }
    70% {
        transform: translateX(-5px);
        opacity: 1;
    }
    100% {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slide-in-bounce {
    animation: slideInBounce 0.4s ease-out forwards;
}
</style>
