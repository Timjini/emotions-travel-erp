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

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <!-- Add Item Form -->
        <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
            <form method="POST" action="{{ route('files.items.store', $file) }}">
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
                    
                    <!-- Currency -->
                    <div>
                        <x-input-label for="currency_id" :value="__('Currency')" />
                        <select id="currency_id" name="currency_id" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full">
                            <option value="">Select Currency</option>
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}">
                                    {{ $currency->code }} - {{ $currency->symbol }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('currency_id')" />
                    </div>
                    
                    <!-- Description -->
                    <div class="md:col-span-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="2" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 mt-1 block"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <x-primary-button type="submit">
                        Add Item
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Items List -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">File Items</h3>
                <p class="text-sm text-gray-500 mt-1">
                    Total People: {{ $file->number_of_people }} | 
                    Items: {{ $file->items->count() }} | 
                    Grand Total: {{ number_format($file->items->sum('total_price'), 2) }}
                </p>
            </div>
            
            @if($file->items->isEmpty())
                <div class="px-6 py-4 text-center text-gray-500">
                    No items added yet.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Currency</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($file->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->service_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($item->description, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($item->total_price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->currency->code ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <form method="POST" action="{{ route('files.items.destroy', ['file' => $file, 'item' => $item]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this item?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="4" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Grand Total</td>
                                <td class="px-6 py-3 text-sm font-medium text-gray-900">{{ number_format($file->items->sum('total_price'), 2) }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
        
        <div class="mt-6 flex justify-end">
            <x-link-button :href="route('files.show', $file)">
                Back to File Details
            </x-link-button>
        </div>
    </div>
</x-app-layout>