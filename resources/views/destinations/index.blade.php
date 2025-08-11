<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            {{ __('Destinations') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Destinations</h1>
            <x-link-button :href="route('destinations.create')">
                Add New Destination
            </x-link-button>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Name</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Country</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($destinations as $destination)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $destination->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $destination->country }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-action-buttons 
                                viewRoute="{{ route('destinations.show', $destination) }}"
                                editRoute="{{ route('destinations.edit', $destination) }}"
                                deleteRoute="{{ route('destinations.destroy', $destination) }}"
                            />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No destinations found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $destinations->links() }}
        </div>
    </div>
</x-app-layout>