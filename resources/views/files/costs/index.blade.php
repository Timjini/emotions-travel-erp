<x-app-layout>
    <!-- Breadcrumbs -->
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li>
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path>
                </svg>
            </li>
            @if($file?->reference)
                <li>
                    <a href="{{ route('files.show', $file) }}" class="hover:text-blue-600">File #{{ $file->reference }}</a>
                </li>
            @endif
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li class="text-gray-800 font-medium">Costs</li>
        </ol>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if(optional($file)->exists)
        <!-- Header and Controls -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Cost Management</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage all costs for File #{{ $file->reference }} - {{ $file->customer->name }}</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <x-link-button :href="route('file-costs.create', $file->id)" class="">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Cost
                    </x-link-button>
                    
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Filters
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <form method="GET" action="{{ route('file-costs.index', $file->id) }}" class="p-4 space-y-4">
                                <!-- Status Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                                    <select name="payment_status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">All Statuses</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->value }}" @selected(request('payment_status') === $status->value)>{{ $status->label() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Service Type Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                                    <select name="service_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">All Types</option>
                                        <option value="transport" @selected(request('service_type') === 'transport')>Transport</option>
                                        <option value="accommodation" @selected(request('service_type') === 'accommodation')>Accommodation</option>
                                        <option value="activity" @selected(request('service_type') === 'activity')>Activity</option>
                                        <option value="management" @selected(request('service_type') === 'management')>Management</option>
                                        <option value="other" @selected(request('service_type') === 'other')>Other</option>
                                    </select>
                                </div>
                                
                                <!-- Date Range Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Date Range</label>
                                    <div class="flex space-x-2">
                                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-1/2 border-gray-300 rounded-md shadow-sm">
                                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-1/2 border-gray-300 rounded-md shadow-sm">
                                    </div>
                                </div>
                                
                                <div class="flex justify-end space-x-2">
                                    <x-secondary-link href="'{{ route('file-costs.index', $file->id) }}'">
                                        Reset
                                    </x-secondary-link>
                                    <x-primary-button type="submit">
                                        Apply
                                    </x-primary-button>
                                </div>
                            </form>
                        </x-slot>
                    </x-dropdown>
                    
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Export
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="p-2">
                                <a href="{{ route('file-costs.export', array_merge(['file' => $file->id], request()->query(), ['format' => 'csv'])) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">CSV</a>
                                <a href="{{ route('file-costs.export', array_merge(['file' => $file->id], request()->query(), ['format' => 'xlsx'])) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Excel</a>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Quick Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Costs</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_costs'], 2) }} {{ $file->currency->code }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Paid</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['paid_amount'], 2) }} {{ $file->currency->code }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pending</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['pending_amount'], 2) }} {{ $file->currency->code }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Overdue</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['overdue_amount'], 2) }} {{ $file->currency->code }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cost Breakdown -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Cost Breakdown</h2>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">View:</span>
                        <select id="view-selector" class="text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="original">Original Currency</option>
                            <option value="base">Base Currency ({{ config('app.currency') }})</option>
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="border rounded-lg p-4">
                        <p class="text-sm font-medium text-gray-500">Transport Costs</p>
                        <p class="text-2xl font-semibold">{{ number_format($stats['transport_costs'], 2) }} {{ $file->currency->code }}</p>
                    </div>
                    
                    <div class="border rounded-lg p-4">
                        <p class="text-sm font-medium text-gray-500">Accommodation</p>
                        <p class="text-2xl font-semibold">{{ number_format($stats['accommodation_costs'], 2) }} {{ $file->currency->code }}</p>
                    </div>
                    
                    <div class="border rounded-lg p-4">
                        <p class="text-sm font-medium text-gray-500">Activities</p>
                        <p class="text-2xl font-semibold">{{ number_format($stats['activity_costs'], 2) }} {{ $file->currency->code }}</p>
                    </div>
                </div>
                
                <!-- Cost Breakdown Chart -->
                <div class="mt-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-lg border">
                            <canvas id="costBreakdownChart" height="250"></canvas>
                        </div>
                        <div class="bg-white p-4 rounded-lg border">
                            <canvas id="paymentStatusChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('file-costs.index', $file->id) }}" class="mb-6">
            <div class="flex flex-col md:flex-row gap-3">
                <div class="flex-1">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by supplier, description, or service type..."
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <x-primary-button type="submit" class="w-full md:w-auto">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </x-primary-button>
                </div>
            </div>
        </form>

        <!-- Costs Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Service Details
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Supplier
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Financials
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Payment Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Service Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($costs as $cost)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 capitalize">{{ $cost->service_type }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($cost->description, 50) }}</div>
                                <div class="text-xs text-gray-400 mt-1">
                                    {{ $cost->quantity }} × {{ number_format($cost->unit_price, 2) }} {{ $cost->original_currency }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($cost->supplier)
                                <div class="text-sm font-medium text-gray-900">{{ $cost->supplier->name }}</div>
                                <div class="text-sm text-gray-500">{{ $cost->supplier->email }}</div>
                                @else
                                <span class="text-sm text-gray-500">No supplier</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Total:</span>
                                        <span class="font-medium">{{ number_format($cost->total_price, 2) }} {{ $cost->original_currency }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Converted:</span>
                                        <span class="font-medium">{{ number_format($cost->converted_total, 2) }} {{ $cost->base_currency }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Paid:</span>
                                        <span class="font-medium">{{ number_format($cost->amount_paid, 2) }} {{ $cost->original_currency }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $status = \App\Enums\Payment\PaymentStatus::tryFrom($cost->payment_status);
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'partially_paid' => 'bg-blue-100 text-blue-800',
                                        'fully_paid' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'refunded' => 'bg-gray-100 text-gray-800',
                                    ][$cost->payment_status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses }}">
                                    {{ $status?->label() ?? $cost->payment_status }}
                                </span>
                                @if($cost->payment_date)
                                <div class="text-xs text-gray-500 mt-1">{{ $cost->payment_date->format('M d, Y') }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $cost->service_date->format('M d, Y') }}
                                </div>
                                @if($cost->quantity_anomaly)
                                <div class="text-xs text-red-500 mt-1">
                                    <svg class="inline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Quantity anomaly
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <x-action-buttons 
                                    viewRoute="{{ route('file-costs.show', [$file->id, $cost->id]) }}"
                                    editRoute="{{ route('file-costs.edit', [$file->id, $cost->id]) }}"
                                    deleteRoute="{{ route('file-costs.destroy', [$file->id, $cost->id]) }}"
                                />
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No costs found. <a href="{{ route('file-costs.create', $file->id) }}" class="text-blue-600 hover:text-blue-800">Add one now</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $costs->appends(request()->query())->links() }}
            </div>
        </div>
        @else

         <!-- No File yet -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-medium mb-4">Opps!</h3>
                    <p class="text-gray-700 mb-6">
                        You don’t have a company setup yet. Please create your file to start managing bookings.
                    </p>
                    <x-link-button :href="route('files.create')">
                        Create File
                    </x-link-button>
                </div>
        @endif
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
</x-app-layout>