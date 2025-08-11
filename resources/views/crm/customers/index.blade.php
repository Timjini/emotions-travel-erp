<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            {{ __('messages.customers') }}
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
                <li class="text-gray-800 font-medium">Customers</li>
            </ol>
        </nav>
    <div class="max-w-7xl px-4 sm:px-6 lg:px-8 py-6">

        <div>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Customers List</h1>
                <x-link-button :href="route('customers.create')">
                    Add New Customer
                </x-link-button>
            </div>
             <h1 class="text-md text-gray-500">Search</h1>

            <!-- Search Bar -->
            <form method="GET" action="{{ route('customers.index') }}" class="mb-4 flex items-center gap-2">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search by name or email..." 
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
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Name</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Email</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Phone</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Created</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($customers as $customer)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                           <span class="inline-block px-2 py-1 text-xs rounded" >
                             
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ $customer->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('customers.show', $customer->id) }}" class="text-blue-600 hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No customers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $customers->links() }}
        </div>

    </div>
</x-app-layout>