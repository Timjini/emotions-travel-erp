<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Edit Program
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <form method="POST" action="{{ route('programs.update', $program->id) }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                @method('PATCH')

                <!-- Header Section -->
                <div class="px-6 py-4 border-b border-[#E5E7EB] bg-[#F9FAFB]">
                    <h3 class="text-lg font-medium text-[#333333] flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4DA8DA] mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                        Program Information
                    </h3>
                </div>

                <!-- Form Fields -->
                <div class="px-6 py-4 space-y-5">
                    <!-- Name Field -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="block text-sm font-medium text-[#333333] mb-1" />
                        <x-text-input id="name" name="name" type="text"
                            class="w-full px-4 py-2 border border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:border-transparent transition"
                            :value="old('name', $program->name)"
                            required
                            placeholder="Program name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm text-red-600" />
                    </div>

                    <!-- Destination Field -->
                    <div>
                        @livewire('destination-search', [
                            'selectedDestination' => $program->destination,
                            'initialSearch' => $program->destination->name
                        ])
                        <input type="hidden" name="destination_id" value="{{ old('destination_id', $program->destination_id) }}">
                        <x-input-error :messages="$errors->get('destination_id')" class="mt-1 text-sm text-red-600" />
                    </div>

                    <!-- Description Field -->
                    <div>
                        <x-input-label for="description" :value="__('Description')" class="block text-sm font-medium text-[#333333] mb-1" />
                        <textarea id="description" name="description" 
                            class="w-full px-4 py-2 border border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:border-transparent transition"
                            rows="4">{{ old('description', $program->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1 text-sm text-red-600" />
                    </div>

                    <!-- Currency Field -->
                    <div>
                        <x-input-label for="currency_id" :value="__('Currency')" class="block text-sm font-medium text-[#333333] mb-1" />
                        <div class="flex items-center">
                            <select id="currency_id" name="currency_id" 
                                class="flex-1 w-full px-4 py-2 border border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:border-transparent transition">
                                <option value="">-- Select --</option>
                                @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}" @selected(old('currency_id', $program->currency_id) == $currency->id)>
                                    {{ $currency->name }} ({{ $currency->code }})
                                </option>
                                @endforeach
                            </select>
                            <a href="{{ route('currencies.create') }}" target="_blank" class="ml-2 text-blue-600 hover:text-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </a>
                        </div>
                        <x-input-error :messages="$errors->get('currency_id')" class="mt-1 text-sm text-red-600" />
                    </div>

                    <!-- Base Price Field -->
                    <div>
                        <x-input-label for="base_price" :value="__('Base Price')" class="block text-sm font-medium text-[#333333] mb-1" />
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-[#666666]"> {{ $currency->symbol }}</span>
                            <x-text-input id="base_price" name="base_price" type="number" step="0.01"
                                class="w-full pl-8 pr-4 py-2 border border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:border-transparent transition"
                                :value="old('base_price', $program->base_price)"
                                placeholder="0.00" />
                        </div>
                        <x-input-error :messages="$errors->get('base_price')" class="mt-1 text-sm text-red-600" />
                    </div>

                    <!-- Status Toggle -->
                    <div class="flex items-center">
                        <x-toggle id="is_active" name="is_active" :checked="old('is_active', $program->is_active)" />
                        <x-input-label for="is_active" :value="__('Active Program')" class="ml-2 text-sm text-[#666666]" />
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-6 py-4 border-t border-[#E5E7EB] bg-[#F9FAFB] flex justify-end space-x-3">
                    <x-secondary-link href="{{ route('programs.index') }}"
                        class="px-4 py-2 border border-[#E5E7EB] rounded-xl hover:bg-[#F7F9FA] transition">
                        Cancel
                    </x-secondary-link>
                    <x-loading-button label="Update Program" />
                </div>
            </form>
        </div>
    </div>
</x-app-layout>