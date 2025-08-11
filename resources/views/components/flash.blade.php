@props([
'type' => 'success',
'title' => null,
'message' => null,
'timeout' => 4000
])

@php
$config = [
'success' => [
'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
'color' => 'green',
'title' => $title ?? 'Success'
],
'error' => [
'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
'color' => 'red',
'title' => $title ?? 'Error'
],
'warning' => [
'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
'color' => 'yellow',
'title' => $title ?? 'Warning'
]
][$type] ?? [
'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
'color' => 'green',
'title' => $title ?? 'Notification'
];

// Handle array messages (like validation errors)
$messages = is_array($message) ? $message : [$message];
@endphp

<div
    x-data="{
        show: true,
        close() {
            this.show = false;
        }
    }"
    x-show="show"
    x-init="setTimeout(() => close(), {{ $timeout }})"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    class="fixed inset-x-0 top-4 z-50 mx-auto w-full max-w-md px-2">
    <div class="bg-white shadow-md rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
        <div class="p-3">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-{{ $config['color'] }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}" />
                    </svg>
                </div>
                <div class="ml-2 flex-1">
                    <p class="text-sm font-medium text-gray-900">
                        {{ $config['title'] }}
                    </p>
                    <div class="mt-1 text-xs text-gray-500">
                        @foreach($messages as $msg)
                        <p>{{ $msg }}</p>
                        @endforeach
                    </div>
                </div>
                <div class="ml-2 flex-shrink-0 flex">
                    <button
                        @click="close()"
                        class="inline-flex rounded-md hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-gray-200 p-1">
                        <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Progress bar -->
        <div class="bg-gray-100 h-0.5 w-full">
            <div
                x-data="{ width: 100 }"
                x-init="
                    let interval = setInterval(() => {
                        width -= 100/{{ $timeout }}*40;
                        if(width <= 0) {
                            clearInterval(interval);
                            close();
                        }
                    }, 40);
                "
                class="bg-{{ $config['color'] }}-400 h-full transition-all duration-40 ease-linear"
                :style="`width: ${width}%`"></div>
        </div>
    </div>
</div>