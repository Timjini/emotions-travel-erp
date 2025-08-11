<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Add New Cost
        </h2>
    </x-slot>

    <nav class="max-w-3xl sm:px-6 lg:px-8" aria-label="Breadcrumb">  
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li>
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <a href="{{ route('files.show', $file) }}" class="hover:text-blue-600">{{ $file->reference }}</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li class="text-gray-800 font-medium">Add Cost</li>
        </ol>
    </nav>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <form method="POST" action="{{ route('file-costs.store', $file) }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                
                <!-- Hidden fields -->
                <input type="hidden" name="file_item_id" value="{{ $fileItem->id ?? '' }}">
                <input type="hidden" name="customer_id" value="{{ $file->customer_id }}">
                
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Cost Details</h3>
                </div>
                
                <div class="px-6 py-4 space-y-4">
                    <!-- Service Type -->
                    <div>
                        <x-input-label for="service_type" :value="__('Service Type')" />
                        <select id="service_type" name="service_type" required
                            class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                            <option value="">Select service type</option>
                            <option value="transport" @selected(old('service_type') == 'transport')>Transport</option>
                            <option value="management" @selected(old('service_type') == 'management')>Management</option>
                            <option value="accommodation" @selected(old('service_type') == 'accommodation')>Accommodation</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('service_type')" />
                    </div>
                    
                    <!-- Supplier -->
                    <div>
                        <x-input-label for="supplier_id" :value="__('Supplier')" />
                        <select id="supplier_id" name="supplier_id"
                            class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                            <option value="">Select supplier (optional)</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('supplier_id')" />
                    </div>
                    
                    <!-- Quantity -->
                    <div>
                        <x-input-label for="quantity" :value="__('Quantity')" />
                        <x-text-input id="quantity" name="quantity" type="number" min="1" value="{{ old('quantity', 1) }}" 
                            class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                    </div>
                    
                    <!-- Unit Price -->
                    <div>
                        <x-input-label for="unit_price" :value="__('Unit Price')" />
                        <x-text-input id="unit_price" name="unit_price" type="number" step="0.01" min="0" 
                            value="{{ old('unit_price') }}" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('unit_price')" />
                    </div>
                    
                    <!-- Currency -->
                    <div>
                        <x-input-label for="original_currency" :value="__('Currency')" />
                        <p class="mt-1 text-sm text-gray-900">{{ $file->currency }}</p>
                        <input type="hidden" name="original_currency" value="{{ $file->currency }}">
                    </div>
                    
                    <!-- Exchange Rate -->
                    <div>
                        <x-input-label for="exchange_rate" :value="__('Exchange Rate (to EUR)')" />
                        <x-text-input id="exchange_rate" name="exchange_rate" type="number" step="0.000001" min="0.000001" 
                            value="{{ old('exchange_rate', 1) }}" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('exchange_rate')" />
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="3"
                            class="mt-1 rounded bg-gray-50 border text-gray-900 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5"
                        >{{ old('description') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <x-secondary-link class="mr-2"
                        href="'{{ route('files.show', $file) }}'">
                        Cancel
                    </x-secondary-link>
                    <x-loading-button label="Add Cost" />
                </div>
            </form>
        </div>
    </div>
</x-app-layout>