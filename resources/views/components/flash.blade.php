@props(['type' => 'success'])

@php
    $config = [
        'success' => [
            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'color' => 'green',
            'title' => session('success-title', 'Success')
        ],
        'error' => [
            'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
            'color' => 'red',
            'title' => session('error-title', 'Error')
        ]
    ][$type] ?? [
        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'color' => 'green',
        'title' => session('success-title', 'Success')
    ];
@endphp

<!-- resources/views/components/notification.blade.php -->
<div 
    x-data="{
        show: true,
        close() {
            this.show = false;
        }
    }"
    x-show="show"
    x-init="setTimeout(() => close(), 4000)"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    class="fixed top-4 left-1/2 z-50 transform -translate-x-1/2 w-auto max-w-md px-2"
>
    <div class="bg-white shadow-md rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
        <div class="p-3">
            <div class="flex items-start">
                <div class="flex-shrink-0 pt-0.5">
                    <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-2 flex-1">
                    <p class="text-sm font-medium text-gray-900 leading-tight">
                        {{ session('success-title', 'Success') }}
                    </p>
                    <p class="mt-0.5 text-xs text-gray-500">
                        {{ session('success') }}
                    </p>
                </div>
                <div class="ml-2 flex-shrink-0 flex">
                    <button 
                        @click="close()" 
                        class="inline-flex rounded-md hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-gray-200 p-1"
                    >
                        <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Slim progress bar -->
        <div class="bg-gray-100 h-0.5 w-full">
            <div 
                x-data="{ width: 100 }"
                x-init="
                    let interval = setInterval(() => {
                        width -= 1;
                        if(width <= 0) {
                            clearInterval(interval);
                            close();
                        }
                    }, 40);
                "
                class="bg-green-400 h-full transition-all duration-40 ease-linear"
                :style="`width: ${width}%`"
            ></div>
        </div>
    </div>
</div>