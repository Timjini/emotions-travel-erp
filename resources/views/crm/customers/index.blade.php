<x-app-layout>
     <!-- Breadcrumbs -->
        <x-bread-crumb title="Customers" />
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
                             <x-action-buttons 
                                viewRoute="{{ route('customers.show', $customer) }}"
                                editRoute="{{ route('customers.edit', $customer) }}"
                                deleteRoute="{{ route('customers.destroy', $customer) }}"
                            />
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