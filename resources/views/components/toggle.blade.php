<div x-data="{ isActive: @json($attributes->get('checked', false)) }" class="flex flex-row">
    <!-- Hidden input to submit the value -->
    <input type="hidden" name="{{ $attributes->get('name') }}" :value="isActive ? 1 : 0">

    <button type="button" @click="isActive = !isActive"
        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors"
        :class="isActive ? 'bg-[#4DA8DA]' : 'bg-gray-200'">
        <span class="sr-only">Active Status</span>
        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition"
            :class="isActive ? 'translate-x-6' : 'translate-x-1'"></span>
    </button>
        <label class="block font-medium text-sm text-gray-700 ml-3 " for="is_active">
        Active Program
</label>
</div>
