<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Destination Details
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Destination Information</h3>
                    <div class="flex space-x-2">
                        <x-link-button :href="route('destinations.edit', $destination)">
                            Edit
                        </x-link-button>
                        <form method="POST" action="{{ route('destinations.destroy', $destination) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit" onclick="return confirm('Are you sure you want to delete this destination?')">
                                Delete
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Name</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $destination->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Country</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $destination->country }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm font-medium text-gray-500">Description</p>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $destination->description ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 text-sm text-gray-500">
                Created {{ $destination->created_at->diffForHumans() }} | Last updated {{ $destination->updated_at->diffForHumans() }}
            </div>
        </div>
        
        <div class="mt-6">
            <x-link-button :href="route('destinations.index')">
                Back to Destinations
            </x-link-button>
        </div>
    </div>
</x-app-layout>