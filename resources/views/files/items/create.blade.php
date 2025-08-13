<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Add Items to File: {{ $file->reference }}
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
                <a href="{{ route('files.index') }}" class="hover:text-blue-600">Files</a>
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
            <li class="text-gray-800 font-medium">Add Items</li>
        </ol>
    </nav>

    <div class="max-w-8xl px-4 sm:px-6 lg:px-8 py-6">
        <!-- Add Item Form -->
        <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
            <form method="POST" action="{{ route('files.items.store', $file) }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Add New Item</h3>
                </div>
                
                <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Service Name -->
                    <div class="md:col-span-2">
                        <x-input-label for="service_name" :value="__('Service Name')" />
                        <x-text-input id="service_name" name="service_name" type="text" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('service_name')" />
                    </div>
                    
                    <!-- Quantity -->
                    <div>
                        <x-input-label for="quantity" :value="__('Quantity')" />
                        <x-text-input id="quantity" name="quantity" type="number" min="1" value="1" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                    </div>
                    
                    <!-- Unit Price -->
                    <div>
                        <x-input-label for="unit_price" :value="__('Unit Price')" />
                        <x-text-input id="unit_price" name="unit_price" type="number" step="0.01" min="0" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('unit_price')" />
                    </div>
                    <div>
                    <!-- Currency -->
                    <x-currency-select 
                            :currencies="$currencies" 
                            :selected="$file->currency_id"
                        />
                    </div>
                    <!-- Description -->
                    <div class="md:col-span-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="2" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 mt-1 block"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <x-loading-button label="Add Item" />
                </div>
            </form>
        </div>

        <!-- items list -->
        @livewire('items-table', ['file' => $file])


        
        <div class="mt-6 flex justify-end">
            <x-link-button :href="route('files.show', $file)">
                Back to File Details
            </x-link-button>
        </div>
    </div>
</x-app-layout>