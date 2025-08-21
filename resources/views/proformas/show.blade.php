<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Proforma Details
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Proforma #{{ $proforma->proforma_number }}</h3>
                    <div class="flex space-x-2">
                        <x-link-button :href="route('proformas.edit', $proforma)">
                            Edit
                        </x-link-button>
                        <form method="POST" action="{{ route('proformas.destroy', $proforma) }}" class="inline-flex items-center px-4 py-2 bg-red-500 border border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this proforma?')">
                                Delete
                            </button>
                        </form>
            
                        @if($proforma->invoice && ($proforma->invoice->status === 'unpaid' || $proforma->invoice->status === 'paid'))
                            <!-- Show link to invoice if invoice exists and status is unpaid or paid -->
                            <x-link-button :href="route('invoices.show', $proforma->invoice)">
                                View Invoice
                            </x-link-button>
                        @else
                            <!-- Show convert button only if no invoice exists -->
                            <form method="POST" action="{{ route('proformas.convert-to-invoice', $proforma) }}">
                                @csrf
                                <x-primary-button type="submit" onclick="return confirm('Convert this proforma to an invoice?')">
                                    Convert to Invoice
                                </x-primary-button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Proforma Number</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $proforma->proforma_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status</p>
                        <p class="mt-1 text-sm text-gray-900">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($proforma->status === 'draft') bg-gray-100 text-gray-800
                                @elseif($proforma->status === 'sent') bg-blue-100 text-blue-800
                                @elseif($proforma->status === 'paid') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($proforma->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Issue Date</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $proforma->issue_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Due Date</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $proforma->due_date ? $proforma->due_date->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Amount</p>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ number_format($proforma->total_amount, 2) }}
                            @if($proforma->currency)
                                {{ $proforma->currency->code }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <div class="mb-2">
                            <p class="text-sm font-medium text-gray-500">Associated File</p>
                            <p class="mt-1 text-sm text-gray-900">
                                <a href="{{ route('files.show', $proforma->file_id) }}" class="text-blue-600 hover:underline">
                                    View File
                                </a>
                            </p>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Email to customer</p>
                        <p class="mt-1 text-sm text-gray-900">
                            <form method="POST" action="{{ route('proformas.send', $proforma) }}"  x-data="{ loading: false }" @submit="loading = true">
                                @csrf
                                <x-loading-button label="Send Now" />
                            </form>
                        </p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <p class="text-sm font-medium text-gray-500">Notes</p>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $proforma->notes ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 text-sm text-gray-500">
                Created {{ $proforma->created_at->diffForHumans() }} | Last updated {{ $proforma->updated_at->diffForHumans() }}
            </div>
        </div>

        <div class="mt-6">
            <x-link-button :href="route('proformas.index')">
                Back to Proformas
            </x-link-button>
        </div>
    </div>
</x-app-layout>