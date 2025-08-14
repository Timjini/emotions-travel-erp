<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Create New Program
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <form method="POST" action="{{ route('programs.store') }}">
                @csrf

                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Program Information</h3>
                </div>

                <div class="px-6 py-4 space-y-4">
                    <div>
                        @livewire('destination-search')
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <x-text-area
                            id="description"
                            name="description"
                            class="mt-1 block w-full"
                            rows="3">{{ old('description') }}</x-text-area>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div>
                        <x-input-label for="currency_id" :value="__('Currency')" />
                        <div class="flex">
                            <select id="currency_id" name="currency_id" class="rounded bg-gray-50 border text-gray-900  block flex-1 min-w-0  text-sm  p-2.5 px-4 py-2  border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:border-transparent transition mt-1 block w-full">
                                <option value="">-- Select --</option>
                                @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}" @selected(old('currency_id', $program->currency_id) == $currency->id)>
                                    {{ $currency->code }}
                                </option>
                                @endforeach
                            </select>
                            <a href="{{ route('currencies.create') }}" target="_blank"
                                class="ml-2 mt-1 text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </a>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('currency_id')" />
                    </div>

                    <div>
                        <x-input-label for="base_price" :value="__('Base Price')" />
                        <x-text-input id="base_price" name="base_price" type="number" step="0.01" class="mt-1 block w-full"
                            :value="old('base_price')" />
                        <x-input-error class="mt-2" :messages="$errors->get('base_price')" />
                    </div>

                    <div class="flex items-center">
                        <x-toggle id="is_active" name="is_active" :checked="old('is_active', $program->is_active)" />
                        <x-input-label for="is_active" :value="__('Active Program')" class="ml-2 text-sm text-[#666666]" />
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <x-secondary-link class="mr-2" href="{{ route('programs.index') }}">
                        Cancel
                    </x-secondary-link>
                    <x-loading-button label="Create Program" />
                </div>
            </form>
        </div>
    </div>
</x-app-layout>