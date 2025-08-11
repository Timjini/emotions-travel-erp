<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            {{ __('messages.files') }}
        </h2>
    </x-slot>
    
    <!-- Breadcrumbs -->
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
            <li class="text-gray-800 font-medium">files</li>
        </ol>
    </nav>
    
    <div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
        <div>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">files List</h1>
                <x-link-button :href="route('files.create')">
                    Add New Booking
                </x-link-button>
            </div>
            
            <h1 class="text-md text-gray-500">Search</h1>
            
            <!-- Search Bar -->
            <form method="GET" action="{{ route('files.index') }}" class="mb-4 flex items-center gap-2">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search by reference or customer..." 
                    class="border rounded px-3 py-2 w-full max-w-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                >
                <x-primary-button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Search</x-primary-button>
            </form>
        </div>

        <!-- Table -->
        <div class="max-w-7xl overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Reference</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">People</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Dates</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Program</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Destination</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Created</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($files as $booking)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $booking->reference }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $booking->customer->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $booking->number_of_people }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $booking->start_date->format('Y-m-d') }} to 
                            {{ $booking->end_date->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $booking->program->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $booking->destination->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ $booking->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                            <a href="{{ route('files.show', $booking->id) }}" class="text-blue-600 hover:underline">
                                View
                            </a>
                            <a href="{{ route('files.edit', $booking->id) }}" class="text-green-600 hover:underline">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">No files found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $files->links() }}
        </div>
    </div>
</x-app-layout>