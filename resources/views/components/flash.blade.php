@props(['type' => 'notice', 'message' => '', 'delay' => 3000])

<div x-data="flash"
     x-init="
        type = '{{ $type }}';
        message = '{{ addslashes($message) }}';
        delay = {{ $delay }};
        setIcon();
     "
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-4"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform translate-y-4"
     class="fixed inset-x-0 top-4 mx-auto z-50 w-full max-w-md">
    <div class="bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden">
        <div class="flex items-start p-4">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" 
                     x-bind:viewBox="icon.viewBox" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          x-bind:d="icon.path" />
                </svg>
            </div>
            <div class="ml-3 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900" x-text="message"></p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button @click="show = false" class="inline-flex text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div x-show="delay > 0" class="h-0.5 bg-gray-200 w-full">
            <div x-show="show" 
                 x-transition:enter="transition ease-linear duration-300"
                 x-transition:enter-start="w-full"
                 x-transition:enter-end="w-0"
                 class="h-full bg-gray-400"></div>
        </div>
    </div>
</div>