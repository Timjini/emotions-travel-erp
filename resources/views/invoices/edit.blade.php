<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Edit Invoice #{{ $invoice->invoice_number }}
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <form method="POST" action="{{ route('invoices.update', $invoice) }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                @method('PATCH')

                <!-- Header Section -->
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">
                            Editing Invoice #{{ $invoice->invoice_number }}
                        </h3>
                    </div>
                    <div class="flex space-x-2">
                        <x-link-button :href="route('invoices.show', $invoice)">
                            Cancel
                        </x-link-button>
                        <x-primary-button type="submit">
                            Save Changes
                        </x-primary-button>
                    </div>
                </div>

                <!-- Invoice Details Section -->
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div>
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Basic Information</h4>
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="invoice_number" :value="__('Invoice Number')" />
                                        <x-text-input id="invoice_number" name="invoice_number" type="text" class="mt-1 block w-full" 
                                            :value="old('invoice_number', $invoice->invoice_number)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('invoice_number')" />
                                    </div>

                                    <div>
                                        <x-input-label for="file_id" :value="__('File Reference')" />
                                        <x-select-input id="file_id" name="file_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="{{ $file->id }}" {{ old('file_id', $invoice->file_id) == $file->id ? 'selected' : '' }}>
                                                {{ $file->reference }}
                                            </option>
                                        </x-select-input>
                                        <x-input-error class="mt-2" :messages="$errors->get('file_id')" />
                                    </div>

                                    @if($proforma)
                                    <div>
                                        <x-input-label for="proforma_id" :value="__('Proforma (optional)')" />
                                        <x-select-input id="proforma_id" name="proforma_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="">No Proforma</option>
                                            <option value="{{ $proforma->id }}" {{ old('proforma_id', $invoice->proforma_id) == $proforma->id ? 'selected' : '' }}>
                                                {{ $proforma->proforma_number }}
                                            </option>
                                        </x-select-input>
                                        <x-input-error class="mt-2" :messages="$errors->get('proforma_id')" />
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Dates</h4>
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="issue_date" :value="__('Issue Date')" />
                                        <x-text-input id="issue_date" name="issue_date" type="date" class="mt-1 block w-full" 
                                            :value="old('issue_date', $invoice->issue_date->format('Y-m-d'))" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('issue_date')" />
                                    </div>

                                    <div>
                                        <x-input-label for="due_date" :value="__('Due Date (optional)')" />
                                        <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full" 
                                            :value="old('due_date', $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('due_date')" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div>
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Payment Information</h4>
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="status" :value="__('Status')" />
                                        <x-select-input id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="draft" {{ old('status', $invoice->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="sent" {{ old('status', $invoice->status) == 'sent' ? 'selected' : '' }}>Sent</option>
                                            <option value="paid" {{ old('status', $invoice->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="cancelled" {{ old('status', $invoice->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            <option value="refunded" {{ old('status', $invoice->status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                        </x-select-input>
                                        <x-input-error class="mt-2" :messages="$errors->get('status')" />
                                    </div>

                                    <div>
                                        <x-input-label for="currency_id" :value="__('Currency')" />
                                        <x-select-input id="currency_id" name="currency_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            @foreach($currencies as $currency)
                                            <option value="{{ $currency->id }}" {{ old('currency_id', $invoice->currency_id) == $currency->id ? 'selected' : '' }}>
                                                {{ $currency->name }} ({{ $currency->code }})
                                            </option>
                                            @endforeach
                                        </x-select-input>
                                        <x-input-error class="mt-2" :messages="$errors->get('currency_id')" />
                                    </div>

                                    <div>
                                        <x-input-label for="total_amount" :value="__('Total Amount')" />
                                        <x-text-input id="total_amount" name="total_amount" type="number" step="0.01" class="mt-1 block w-full" 
                                            :value="old('total_amount', $invoice->total_amount)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('total_amount')" />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <x-input-label for="notes" :value="__('Notes (optional)')" />
                                <x-text-area id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $invoice->notes) }}</x-text-area >
                                <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Items Section -->
                    <div class="mt-8">
                        <h4 class="text-sm font-medium text-gray-500 mb-4">Services</h4>
                        
                        <div id="items-container">
                            @foreach($invoice->items as $index => $item)
                            <div class="item-row mb-4 p-4 border border-gray-200 rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <x-input-label :for="'items['.$index.'][service_name]'" :value="__('Service Name')" />
                                        <x-text-input :id="'items['.$index.'][service_name]'" :name="'items['.$index.'][service_name]'" type="text" class="mt-1 block w-full" 
                                            :value="old('items.'.$index.'.service_name', $item->service_name)" required />
                                    </div>
                                    <div>
                                        <x-input-label :for="'items['.$index.'][description]'" :value="__('Description')" />
                                        <x-text-input :id="'items['.$index.'][description]'" :name="'items['.$index.'][description]'" type="text" class="mt-1 block w-full" 
                                            :value="old('items.'.$index.'.description', $item->description)" />
                                    </div>
                                    <div>
                                        <x-input-label :for="'items['.$index.'][quantity]'" :value="__('Quantity')" />
                                        <x-text-input :id="'items['.$index.'][quantity]'" :name="'items['.$index.'][quantity]'" type="number" step="1" class="mt-1 block w-full" 
                                            :value="old('items.'.$index.'.quantity', $item->quantity)" required />
                                    </div>
                                    <div>
                                        <x-input-label :for="'items['.$index.'][unit_price]'" :value="__('Unit Price')" />
                                        <x-text-input :id="'items['.$index.'][unit_price]'" :name="'items['.$index.'][unit_price]'" type="number" step="0.01" class="mt-1 block w-full" 
                                            :value="old('items.'.$index.'.unit_price', $item->unit_price)" required />
                                    </div>
                                </div>
                                <input type="hidden" :name="'items['.$index.'][id]'" value="{{ $item->id }}">
                                <button type="button" class="mt-2 text-red-600 text-sm hover:text-red-900 remove-item">Remove</button>
                            </div>
                            @endforeach
                        </div>

                        <button type="button" id="add-item" class="mt-4 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add Service
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add new item
            document.getElementById('add-item').addEventListener('click', function() {
                const container = document.getElementById('items-container');
                const index = document.querySelectorAll('.item-row').length;
                
                const template = `
                    <div class="item-row mb-4 p-4 border border-gray-200 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <x-input-label for="items[${index}][service_name]" :value="__('Service Name')" />
                                <x-text-input id="items[${index}][service_name]" name="items[${index}][service_name]" type="text" class="mt-1 block w-full" required />
                            </div>
                            <div>
                                <x-input-label for="items[${index}][description]" :value="__('Description')" />
                                <x-text-input id="items[${index}][description]" name="items[${index}][description]" type="text" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="items[${index}][quantity]" :value="__('Quantity')" />
                                <x-text-input id="items[${index}][quantity]" name="items[${index}][quantity]" type="number" step="1" class="mt-1 block w-full" required />
                            </div>
                            <div>
                                <x-input-label for="items[${index}][unit_price]" :value="__('Unit Price')" />
                                <x-text-input id="items[${index}][unit_price]" name="items[${index}][unit_price]" type="number" step="0.01" class="mt-1 block w-full" required />
                            </div>
                        </div>
                        <button type="button" class="mt-2 text-red-600 text-sm hover:text-red-900 remove-item">Remove</button>
                    </div>
                `;
                
                container.insertAdjacentHTML('beforeend', template);
            });

            // Remove item
            document.getElementById('items-container').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item')) {
                    e.target.closest('.item-row').remove();
                    // Re-index remaining items if needed
                }
            });
        });
    </script>
    @endpush
</x-app-layout>