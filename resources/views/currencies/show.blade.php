<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Currency Details
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Currency Information</h3>
                    <div class="flex space-x-2">
                        <x-link-button :href="route('currencies.edit', $currency)">
                            Edit
                        </x-link-button>
                        <form method="POST" action="{{ route('currencies.destroy', $currency) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit" onclick="return confirm('Are you sure you want to delete this currency?')">
                                Delete
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Code</p>
                        <p class="mt-1 text-sm font-mono text-gray-900">{{ $currency->code }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Name</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $currency->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Symbol</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $currency->symbol ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status</p>
                        <p class="mt-1 text-sm">
                            <span class="px-2 py-1 rounded-full {{ $currency->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $currency->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 text-sm text-gray-500">
                Created {{ $currency->created_at->diffForHumans() }} | Last updated {{ $currency->updated_at->diffForHumans() }}
            </div>
        </div>
        
        <div class="mt-6">
            <x-link-button :href="route('currencies.index')">
                Back to Currencies
            </x-link-button>
        </div>
    </div>
</x-app-layout>