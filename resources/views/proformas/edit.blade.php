<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Edit Proforma
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <form method="POST" action="{{ route('proformas.update', $proforma) }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                @method('PATCH')
                
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Proforma #{{ $proforma->proforma_number }}</h3>
                        <div class="flex space-x-2">
                            <x-link-button :href="route('proformas.show', $proforma)">
                                Cancel
                            </x-link-button>
                            <x-primary-button type="submit">
                                Save Changes
                            </x-primary-button>
                        </div>
                    </div>
                </div>
                
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="due_date" value="Due Date" />
                            <x-text-input 
                                id="due_date" 
                                name="due_date" 
                                type="date" 
                                class="mt-1 block w-full" 
                                value="{{ old('due_date', $proforma->due_date ? $proforma->due_date->format('Y-m-d') : '') }}" 
                            />
                            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="currency_id" value="Currency" />
                            <x-select-input 
                                id="currency_id" 
                                name="currency_id" 
                                class="mt-1 block w-full"
                            >
                                <option value="">Select Currency</option>
                                @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}" {{ old('currency_id', $proforma->currency_id) == $currency->id ? 'selected' : '' }}>
                                    {{ $currency->name }} ({{ $currency->code }})
                                </option>
                                @endforeach
                            </x-select-input>
                            <x-input-error :messages="$errors->get('currency_id')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="status" value="Status" />
                            <x-select-input 
                                id="status" 
                                name="status" 
                                class="mt-1 block w-full"
                                required
                            >
                                @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ old('status', $proforma->status) == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                                @endforeach
                            </x-select-input>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                        
                        <div class="md:col-span-2">
                            <x-input-label for="notes" value="Notes" />
                            <x-text-area 
                                id="notes" 
                                name="notes" 
                                class="mt-1 block w-full" 
                                rows="3"
                            >{{ old('notes', $proforma->notes) }}</x-text-area>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>