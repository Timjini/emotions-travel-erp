<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Create New Currency
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <form method="POST" action="{{ route('currencies.store') }}">
                @csrf
                
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Currency Information</h3>
                </div>
                
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <x-input-label for="code" :value="__('Code (3 letters)')" />
                        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full uppercase font-mono" 
                            :value="old('code')" required maxlength="3" pattern="[A-Z]{3}" />
                        <x-input-error class="mt-2" :messages="$errors->get('code')" />
                    </div>
                    
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                            :value="old('name')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    
                    <div>
                        <x-input-label for="symbol" :value="__('Symbol')" />
                        <x-text-input id="symbol" name="symbol" type="text" class="mt-1 block w-full" 
                            :value="old('symbol')" maxlength="5" />
                        <x-input-error class="mt-2" :messages="$errors->get('symbol')" />
                    </div>
                    
                    <div class="flex items-center">
                        <x-checkbox id="is_active" name="is_active" :checked="old('is_active', true)" />
                        <x-input-label for="is_active" :value="__('Active')" class="ml-2" />
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <x-secondary-link class="mr-2" href="'{{ route('currencies.index') }}'">
                        Cancel
                    </x-secondary-button>
                    <x-primary-button type="submit">
                        Create Currency
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>