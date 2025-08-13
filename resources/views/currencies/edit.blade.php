<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Edit Currency
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <form method="POST" action="{{ route('currencies.update', $currency) }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" value="{{ $currency->id }}">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Currency Information</h3>
                </div>
                
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <x-input-label for="code" :value="__('Code (3 letters)')" />
                        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full uppercase font-mono" 
                            :value="old('code', $currency->code)" required maxlength="3" pattern="[A-Z]{3}" />
                        <x-input-error class="mt-2" :messages="$errors->get('code')" />
                    </div>
                    
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                            :value="old('name', $currency->name)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    
                    <div>
                        <x-input-label for="symbol" :value="__('Symbol')" />
                        <x-text-input id="symbol" name="symbol" type="text" class="mt-1 block w-full" 
                            :value="old('symbol', $currency->symbol)" maxlength="5" />
                        <x-input-error class="mt-2" :messages="$errors->get('symbol')" />
                    </div>
                    
                    <div class="flex items-center">
                        <x-toggle id="is_active" name="is_active" :checked="old('is_active', $currency->is_active)" />
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <x-secondary-link class="mr-2" href="'{{ route('currencies.show', $currency) }}'">
                        Cancel
                    </x-secondary-button>
                    <x-loading-button label="Save Changes" />
                </div>
            </form>
        </div>
    </div>
</x-app-layout>