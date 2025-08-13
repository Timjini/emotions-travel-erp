<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Destination Details
        </h2>
    </x-slot>

    <nav class="max-w-3xl sm:px-6 lg:px-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
            <li><svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path></svg></li>
            <li><a href="{{ route('destinations.index') }}" class="hover:text-blue-600">Destinations</a></li>
            <li><svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path></svg></li>
            <li class="text-gray-800 font-medium">{{ $destination->name }}</li>
        </ol>
    </nav>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Destination Information</h3>
                <div class="flex space-x-2">
                    <x-link-button :href="route('destinations.edit', $destination)">Edit</x-link-button>
                    <form method="POST" action="{{ route('destinations.destroy', $destination) }}">
                        @csrf @method('DELETE')
                        <x-danger-button type="submit" onclick="return confirm('Are you sure?')">Delete</x-danger-button>
                    </form>
                </div>
            </div>
            
            <div class="px-6 py-4 space-y-6">
                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-2 border-b pb-1">Location</h4>
                        <dl class="space-y-3">
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm text-gray-500">Name</dt>
                                <dd class="text-sm text-gray-900 col-span-2">{{ $destination->name }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm text-gray-500">Country</dt>
                                <dd class="text-sm text-gray-900 col-span-2">{{ $destination->country->name }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm text-gray-500">City</dt>
                                <dd class="text-sm text-gray-900 col-span-2">{{ $destination->city ?? 'N/A' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm text-gray-500">Region</dt>
                                <dd class="text-sm text-gray-900 col-span-2">{{ $destination->region ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-2 border-b pb-1">Travel Details</h4>
                        <dl class="space-y-3">
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm text-gray-500">Airport</dt>
                                <dd class="text-sm text-gray-900 col-span-2">{{ $destination->airport_code ?? 'N/A' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm text-gray-500">Visa Required</dt>
                                <dd class="text-sm text-gray-900 col-span-2">
                                    <span class="px-2 py-0.5 rounded text-xs font-medium {{ $destination->visa_required ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $destination->visa_required ? 'Yes' : 'No' }}
                                    </span>
                                </dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm text-gray-500">Currency</dt>
                                <dd class="text-sm text-gray-900 col-span-2">
                                    {{ $destination->currency->code ?? 'N/A' }}
                                    @if($destination->currency)
                                        ({{ $destination->currency->name }})
                                    @endif
                                </dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm text-gray-500">Timezone</dt>
                                <dd class="text-sm text-gray-900 col-span-2">{{ $destination->timezone ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Coordinates -->
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2 border-b pb-1">Coordinates</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm text-gray-500">Latitude</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $destination->latitude ?? 'N/A' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm text-gray-500">Longitude</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $destination->longitude ?? 'N/A' }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Climate -->
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2 border-b pb-1">Climate</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm text-gray-500">Best Season</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $destination->best_season ?? 'N/A' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm text-gray-500">Avg Temp</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $destination->average_temperature ?? 'N/A' }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2 border-b pb-1">Description</h4>
                    <div class="prose prose-sm max-w-none text-gray-900">
                        {{ $destination->description ?? 'No description available' }}
                    </div>
                </div>

                <!-- Status -->
                <div class="grid grid-cols-3 gap-4">
                    <dt class="text-sm text-gray-500">Status</dt>
                    <dd class="text-sm text-gray-900 col-span-2">
                        <span class="px-2 py-0.5 rounded text-xs font-medium {{ $destination->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $destination->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </dd>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 text-sm text-gray-500">
                Created {{ $destination->created_at->diffForHumans() }} | Updated {{ $destination->updated_at->diffForHumans() }}
            </div>
        </div>
        
        <div class="mt-6">
            <x-link-button :href="route('destinations.index')">
                Back to Destinations
            </x-link-button>
        </div>
    </div>
</x-app-layout>