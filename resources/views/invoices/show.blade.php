<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Invoice Details
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Header Section -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">
                        Invoice #{{ $invoice->invoice_number }}
                        <span class="ml-2 px-2 py-1 text-xs rounded-full 
                            @if($invoice->status === 'paid') bg-green-100 text-green-800
                            @elseif($invoice->status === 'cancelled') bg-red-100 text-red-800
                            @elseif($invoice->status === 'refunded') bg-blue-100 text-blue-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </h3>
                    <div class="flex space-x-2">
                        <x-link-button :href="route('invoices.edit', $invoice)">
                            Edit
                        </x-link-button>
                        <form method="POST" action="{{ route('invoices.destroy', $invoice) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit" onclick="return confirm('Are you sure you want to delete this invoice?')">
                                Delete
                            </x-danger-button>
                        </form>
                        
                          <x-secondary-link :href="route('invoices.download.pdf', $invoice)">
                                View PDF
                            </x-secondary-link>
                    </div>
                
                </div>
            </div>

            <!-- Invoice Details Section -->
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div>
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-500">Billing Details</h4>
                            <div class="mt-2 space-y-1">
                                <p class="text-sm text-gray-900">
                                    <span class="font-medium">File:</span> 
                                    <a href="{{ route('files.show', $invoice->file_id) }}" class="text-blue-600 hover:underline">
                                        {{ $invoice->file->reference ?? 'NAN' }}
                                    </a>
                                </p>
                                @if($invoice->proforma_id)
                                <p class="text-sm text-gray-900">
                                    <span class="font-medium">Proforma:</span> 
                                    <a href="{{ route('proformas.show', $invoice->proforma_id) }}" class="text-blue-600 hover:underline">
                                        {{ $invoice->proforma->proforma_number }}
                                    </a>
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-500">Dates</h4>
                            <div class="mt-2 space-y-1">
                                <p class="text-sm text-gray-900">
                                    <span class="font-medium">Issued:</span> 
                                    {{ $invoice->issue_date->format('M d, Y') }}
                                </p>
                                <p class="text-sm text-gray-900">
                                    <span class="font-medium">Due:</span> 
                                    {{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-500">Payment Information</h4>
                            <div class="mt-2 space-y-1">
                                <p class="text-sm text-gray-900">
                                    <span class="font-medium">Total Amount:</span> 
                                    {{ number_format($invoice->total_amount, 2) }}
                                    @if($invoice->currency)
                                        {{ $invoice->currency->code }}
                                    @endif
                                </p>
                                <p class="text-sm text-gray-900">
                                    <span class="font-medium">Currency:</span> 
                                    {{ $invoice->currency ? $invoice->currency->name : 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Notes</h4>
                            <p class="mt-2 text-sm text-gray-900 whitespace-pre-line">
                                {{ $invoice->notes ?? 'No additional notes' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Invoice Items Table -->
                <div class="mt-8">
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Services</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Service
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Qty
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit Price
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($invoice->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $item->service_name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $item->description ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($item->unit_price, 2) }}
                                        @if($item->currency)
                                            {{ $item->currency->code }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($item->total_price, 2) }}
                                        @if($item->currency)
                                            {{ $item->currency->code }}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td colspan="4" class="px-6 py-4 text-right text-sm font-medium text-gray-500">
                                        Subtotal
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ number_format($invoice->items->sum('total_price'), 2) }}
                                        @if($invoice->currency)
                                            {{ $invoice->currency->code }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer Section -->
            <div class="px-6 py-4 border-t border-gray-200 text-sm text-gray-500">
                Created {{ $invoice->created_at->diffForHumans() }} | 
                Last updated {{ $invoice->updated_at->diffForHumans() }}
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <x-link-button :href="route('invoices.index')">
                Back to Invoices
            </x-link-button>
            
            @if($invoice->status !== 'paid')
            <x-primary-button onclick="window.print()">
                Print Invoice
            </x-primary-button>
            @endif
        </div>
    </div>
</x-app-layout>