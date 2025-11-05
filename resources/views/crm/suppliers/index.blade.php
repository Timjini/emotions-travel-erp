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
                <li class="text-gray-800 font-medium">suppliers</li>
            </ol>
        </nav>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div>
            <div class="flex justify-between items-center mb-6">
                  <div>
                    <h1 class="text-2xl font-bold text-gray-900">Suppliers List</h1>
                    <p class="text-sm text-gray-500 mt-1"></p>
                </div>
                <x-link-button :href="route('suppliers.create')">
                    Add New supplier
                </x-link-button>

                <form action="{{ route('suppliers.bulkUpload') }}" method="POST" enctype="multipart/form-data" class="bg-white p-1 rounded-lg" x-data="{ loading: false }" @submit="loading = true">
                    @csrf
                    <input type="file" name="csvFile" class="p-2">
                    <x-loading-button label=" {{ __('Upload') }}" />
                </form>
            </div>
             <form method="GET" action="{{ route('suppliers.index') }}" class="mb-6" x-data="{ loading: false }" @submit="loading = true">
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
                        placeholder="Search by name or email..." 
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <x-loading-button label=" {{ __('Search') }}" />
                </div>
            </div>
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
                    @forelse ($suppliers as $supplier)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $supplier->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $supplier->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $supplier->phone_1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $supplier->address }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ $supplier->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4">
                             <x-action-buttons 
                                viewRoute="{{ route('suppliers.show', $supplier) }}"
                                editRoute="{{ route('suppliers.edit', $supplier) }}"
                                deleteRoute="{{ route('suppliers.destroy', $supplier) }}"
                            />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No suppliers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $suppliers->links() }}
        </div>

    </div>
</x-app-layout>