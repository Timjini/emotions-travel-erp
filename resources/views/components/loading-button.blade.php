@props([
    'label' => 'Submit',
    'customClass' => '',
])

<button 
    type="{{ $attributes->get('type', 'submit') }}" 
    :disabled="loading" 
    class="{{$customClass}} flex justify-center items-center  border border-transparent  text-sm  shadow-sm  focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200 bg-[#4DA8DA] hover:bg-[#3a8cc4] text-white font-medium py-2 px-4 rounded-xl transition"
    {{ $attributes->except('type') }}
>
    <template x-if="!loading">
        <span>{{ $label }}</span>
    </template>

    <template x-if="loading">
        <span class="flex items-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            Loading...
        </span>
    </template>
</button>
