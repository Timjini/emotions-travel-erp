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
                                rows="3"
                            >{{ old('description') }}</x-text-area>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                    
                    <div>
                        <x-input-label for="base_price" :value="__('Base Price')" />
                        <x-text-input id="base_price" name="base_price" type="number" step="0.01" class="mt-1 block w-full"
                            :value="old('base_price')" />
                        <x-input-error class="mt-2" :messages="$errors->get('base_price')" />
                    </div>
                    
                    <div class="flex items-center">
                        <x-checkbox id="is_active" name="is_active" :checked="old('is_active', true)" />
                        <x-input-label for="is_active" :value="__('Active')" class="ml-2" />
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <x-secondary-link class="mr-2" href="{{ route('programs.index') }}">
                        Cancel
                    </x-secondary-link>
                    <x-primary-button type="submit">
                        Create Program
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
