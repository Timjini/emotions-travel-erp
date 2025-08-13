<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">File</th>
            <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Client</th>
            <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Reference</th>
            <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Start</th>
            <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">End</th>
            <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Profit</th>
            <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Mark-up</th>
            <th class="px-6 py-3 text-left font-medium text-gray-600 uppercase">Owner</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse ($reportData as $item)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">{{ $item->name }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $item->customer->name }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $item->reference }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $item->start_date->format('m/d/Y') }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $item->end_date->format('m/d/Y') }}</td>

        </tr>
        @empty
        <tr>
            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                No records found matching your criteria.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>