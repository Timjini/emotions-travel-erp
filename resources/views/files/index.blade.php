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
            <li class="text-gray-800 font-medium">Booking Files</li>
        </ol>
    </nav>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header and Controls -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Booking Files Management</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage all travel booking files and financials</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <x-link-button :href="route('files.create')" class="">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        New Booking File
                    </x-link-button>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="hidden inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Filters
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <form method="GET" action="{{ route('files.index') }}" class="p-4 space-y-4">
                                <!-- Status Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">All Statuses</option>
                                        <option value="confirmed" @selected(request('status')==='confirmed' )>Confirmed</option>
                                        <option value="pending" @selected(request('status')==='pending' )>Pending</option>
                                        <option value="cancelled" @selected(request('status')==='cancelled' )>Cancelled</option>
                                    </select>
                                </div>

                                <!-- Date Range Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                                    <div class="flex space-x-2">
                                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-1/2 border-gray-300 rounded-md shadow-sm">
                                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-1/2 border-gray-300 rounded-md shadow-sm">
                                    </div>
                                </div>

                                <!-- Program Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                                    <select name="program_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">All Programs</option>
                                        @foreach($programs as $program)
                                        <option value="{{ $program->id }}" @selected(request('program_id')==$program->id)>{{ $program->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex justify-end space-x-2">
                                    <x-secondary-link href="'{{ route('files.index') }}'">
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
                            <button class="hidden inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Export
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="p-2">
                                <a href="{{ route('files.export', array_merge(request()->query(), ['format' => 'csv'])) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">CSV</a>
                                <a href="{{ route('files.export', array_merge(request()->query(), ['format' => 'xlsx'])) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Excel</a>
                                <a href="{{ route('files.export', array_merge(request()->query(), ['format' => 'pdf'])) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">PDF</a>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('files.index') }}" class="mb-6">
            <div class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by reference, customer, or destination..."
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
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

        <!-- Bookings Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortBy('reference')">
                                <div class="flex items-center">
                                    Reference
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>

                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortBy('customer_name')">
                                <div class="flex items-center">
                                    Customer
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Travel Details
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortBy('start_date')">
                                <div class="flex items-center">
                                    Dates
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </div>
                            </th>
                            <th scope="col" class="hidden px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Financials
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortBy('status')">
                                <div class="flex items-center">
                                    Status
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($files as $file)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-5 w-5 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $file->reference }}</div>
                                        <div class="text-sm text-gray-500">{{ $file->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $file->customer->name }}</div>
                                <div class="text-sm text-gray-500">{{ $file->customer->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    <span class="font-medium">Program:</span> {{ $file->program->name ?? 'N/A' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    <span class="font-medium">Destination:</span> {{ $file->destination->name ?? 'N/A' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    <span class="font-medium">People:</span> {{ $file->number_of_people }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $file->start_date->format('M d, Y') }} <br/> {{ $file->end_date->format('M d, Y') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $file->start_date->diffInDays($file->end_date) }} days
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden">
                                <div class="text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Billed:</span>
                                        <span class="font-medium">
                                            {{ number_format($financials['total_billed']) }}
                                            {{ $financials['company_currency'] ?? '' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Costs:</span>
                                        <span class="font-medium">
                                            {{ number_format($financials['total_costs'] ?? 0, 2) }}
                                            {{ $financials['company_currency'] ?? '' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Profit:</span>
                                        @php
                                        $profit = $financials['profit'];
                                        $textColor = $profit >= 0 ? 'text-green-600' : 'text-red-600';
                                        @endphp
                                        <span class="font-medium {{ $textColor }}">
                                            {{ number_format($financials['profit'], 2) }}
                                            {{ $financials['company_currency'] ?? '' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                $statusClasses = [
                                'confirmed' => 'bg-green-100 text-green-800',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'cancelled' => 'bg-red-100 text-red-800'
                                ][$file->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses }}">
                                    {{ ucfirst($file->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <x-action-buttons
                                    viewRoute="{{ route('files.show', $file->id) }}"
                                    editRoute="{{ route('files.edit', $file->id) }}"
                                    deleteRoute="{{ route('files.destroy', $file->id) }}" />
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No booking files found. <a href="{{ route('files.create') }}" class="text-blue-600 hover:text-blue-800">Create one now</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $files->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @endpush
</x-app-layout>