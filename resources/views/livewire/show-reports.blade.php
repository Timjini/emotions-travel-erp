<div class="bg-white shadow rounded-lg overflow-x-auto">
    <!-- Filters Section -->
    <div class="p-4 border-b space-y-4 md:space-y-0 md:flex md:items-center md:justify-between md:space-x-4">
        <!-- Document Type Filter -->
        <div class="w-full md:w-auto">
            <label class="block text-sm font-medium text-gray-700 mb-1">Document Type</label>
            <select wire:model.live="document_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="invoices">Invoices</option>
                <option value="files">Files</option>
                <option value="proformas">Proformas</option>
            </select>
        </div>

        <!-- Date Range Filters -->
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input 
                    type="date" 
                    wire:model.live="start_date"
                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input 
                    type="date" 
                    wire:model.live="end_date"
                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
        </div>

        <!-- Sort Order -->
        <div class="w-full md:w-auto">
            <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
            <select wire:model.live="order_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="date_desc">Date (Newest First)</option>
                <option value="date_asc">Date (Oldest First)</option>
            </select>
        </div>

        <!-- Reset Filters -->
        <div class="flex items-end">
            <button 
                wire:click="resetFilters"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-150"
            >
                Reset
            </button>
        </div>
    </div>

    <!-- Results Summary -->
    @if($start_date || $end_date || $document_type)
    <div class="px-4 py-2 bg-blue-50 border-b">
        <p class="text-sm text-blue-700">
            Showing {{ $document_type ? ucfirst($document_type) : 'All Documents' }}
            @if($start_date)
                from <strong>{{ \Carbon\Carbon::parse($start_date)->format('M d, Y') }}</strong>
            @endif
            @if($end_date)
                to <strong>{{ \Carbon\Carbon::parse($end_date)->format('M d, Y') }}</strong>
            @endif
            ({{ $reportData->total() }} results)
        </p>
    </div>
    @endif

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Number</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destination</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($reportData as $item)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                        {{ $item->number }}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        @php
                            $typeColors = [
                                'invoice' => 'bg-green-100 text-green-800',
                                'file' => 'bg-blue-100 text-blue-800',
                                'proforma' => 'bg-purple-100 text-purple-800'
                            ];
                            $color = $typeColors[$item->report_type] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                            {{ ucfirst($item->report_type) }}
                        </span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ \Carbon\Carbon::parse($item->issue_date ?? $item->start_date ?? $item->created_at)->format('M d, Y') }}
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-900">
                        <a href="{{ route('customers.show', $item->customer_id)}}">
                            {{ $item->customer_email ?? '-' }}
                        </a>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-900">
                        {{ $item->owner->name ?? '-' }}
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-900">
                        {{ $item->destination->name ?? '-' }}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{-- @if($item->profit || $item->total)
                            ${{ number_format($item->profit ?? $item->total, 2) }}
                        @else
                            -
                        @endif --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-lg font-medium">No records found</p>
                            <p class="text-sm mt-1">Try adjusting your filters</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    @if($reportData->hasPages())
        <div class="px-4 py-4 border-t border-gray-200">
            {{ $reportData->links() }}
        </div>
    @endif
</div>