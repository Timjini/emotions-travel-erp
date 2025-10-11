<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-6 py-3">File</th>
            <th class="px-6 py-3">Customer</th>
            <th class="px-6 py-3">Reference</th>
            <th class="px-6 py-3">Start</th>
            <th class="px-6 py-3">End</th>
            <th class="px-6 py-3">Owner</th>
            <th class="px-6 py-3">Proformas</th>
            <th class="px-6 py-3">Invoices</
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse ($reportData as $file)
        <tr>
            <td class="px-6 py-4">{{ $file->id }}</td>
            <td class="px-6 py-4">{{ $file->customer->name ?? '-' }}</td>
            <td class="px-6 py-4">{{ $file->reference }}</td>
            <td class="px-6 py-4">{{ $file->start_date->format('Y-m-d') }}</td>
            <td class="px-6 py-4">{{ $file->end_date->format('Y-m-d') }}</td>
            <td class="px-6 py-4">{{ $file->owner->name ?? '-' }}</td>
            <td class="px-6 py-4">{{ $file->proformas->count() }}</td>
            <td class="px-6 py-4">{{ $file->invoice?->id }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                No records found.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@if($reportData instanceof \Illuminate\Pagination\LengthAwarePaginator && $reportData->hasPages())
<div class="px-6 py-4 bg-gray-50">
    {{ $reportData->withQueryString()->links() }}
</div>
@endif
