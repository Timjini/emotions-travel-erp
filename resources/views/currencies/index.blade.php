<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            {{ __('Currencies') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Currencies</h1>
            <x-link-button :href="route('currencies.create')">
                Add New Currency
            </x-link-button>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Code</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Name</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Symbol</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($currencies as $currency)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-mono">{{ $currency->code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $currency->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $currency->symbol ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full {{ $currency->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $currency->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-action-buttons 
                                viewRoute="{{ route('currencies.show', $currency) }}"
                                editRoute="{{ route('currencies.edit', $currency) }}"
                                deleteRoute="{{ route('currencies.destroy', $currency) }}"
                            />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No currencies found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $currencies->links() }}
        </div>
    </div>
</x-app-layout>