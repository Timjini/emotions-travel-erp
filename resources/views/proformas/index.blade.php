<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Proformas
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="mb-4 flex justify-between items-center">
            <div class="flex-1">
               
            </div>
            @can('create', App\Models\Proforma::class)
            <x-link-button :href="route('proformas.create')" class="ml-4">
                Create Proforma
            </x-link-button>
            @endcan
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Number
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                File
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Issue Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($proformas as $proforma)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <a href="{{ route('proformas.show', $proforma) }}" class="text-blue-600 hover:underline">
                                    {{ $proforma->proforma_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="{{ $proforma->file?->id ? route('files.show', $proforma->file_id) : '#' }}" class="text-blue-600 hover:underline">
                                    {{ $proforma->file?->file_number ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($proforma->total_amount, 2) }}
                                @if($proforma->currency)
                                    {{ $proforma->currency->code }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($proforma->status === 'draft') bg-gray-100 text-gray-800
                                    @elseif($proforma->status === 'sent') bg-blue-100 text-blue-800
                                    @elseif($proforma->status === 'paid') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($proforma->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $proforma->issue_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <x-link-button :href="route('proformas.edit', $proforma)" size="sm">
                                        Edit
                                    </x-link-button>
                                    <form method="POST" action="{{ route('proformas.destroy', $proforma) }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit" size="sm" onclick="return confirm('Are you sure you want to delete this proforma?')">
                                            Delete
                                        </x-danger-button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No proformas found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($proformas->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $proformas->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>