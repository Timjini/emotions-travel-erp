<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Program Details
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Program Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $program->name }}</h3>
                        <div class="flex space-x-2">
                            <x-link-button :href="route('programs.edit', $program)" class="bg-blue-600 hover:bg-blue-700">
                                Edit Program
                            </x-link-button>
                            <form method="POST" action="{{ route('programs.destroy', $program) }}">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit" onclick="return confirm('Are you sure you want to delete this program?')">
                                    Delete
                                </x-danger-button>
                            </form>
                        </div>
                    </div>

                    <!-- Program Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Description</h4>
                                <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $program->description ?? 'No description provided' }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Destination</h4>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $program->destination->name }} ({{ $program->destination->country->name }})
                                </p>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Base Price</h4>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $program->currency->code }} {{ number_format($program->base_price, 2) }}
                                </p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $program->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $program->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Created At</h4>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $program->created_at->format('M d, Y \a\t h:i A') }}
                                </p>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Last Updated</h4>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $program->updated_at->format('M d, Y \a\t h:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-8">
                        <x-link-button :href="route('programs.index')" class="bg-gray-600 hover:bg-gray-700">
                            Back to Programs
                        </x-link-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>