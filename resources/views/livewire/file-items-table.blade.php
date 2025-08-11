<!-- resources/views/livewire/file-items-table.blade.php -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">File Items</h3>
        <p class="text-sm text-gray-500 mt-1">
            Total People: {{ $file->number_of_people }} | 
            Items: {{ $items->count() }} | 
            Grand Total: {{ number_format($items->sum('total_price'), 2) }}
        </p>
    </div>
    
    @if($items->isEmpty())
        <div class="px-6 py-4 text-center text-gray-500">
            No items added yet.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Currency</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($items as $item)
                    <tr wire:key="item-{{ $item->id }}">
                        @if($editingId !== $item->id)
                            <!-- Display Mode -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->service_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $item->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($item->total_price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->currency->code ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex space-x-2">
                                <button wire:click="edit('{{ $item->id }}')" class="text-blue-600 hover:text-blue-900">
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('files.items.destroy', ['file' => $file, 'item' => $item]) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        @else
                            <!-- Edit Mode -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input wire:model.defer="editItem.service_name" class="text-sm border rounded px-2 py-1 w-full">
                                @error('editItem.service_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </td>
                            <td class="px-6 py-4">
                                <textarea wire:model.defer="editItem.description" class="text-sm border rounded px-2 py-1 w-full"></textarea>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="number" wire:model.defer="editItem.quantity" class="text-sm border rounded px-2 py-1 w-full">
                                @error('editItem.quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="number" step="0.01" wire:model.defer="editItem.unit_price" class="text-sm border rounded px-2 py-1 w-full">
                                @error('editItem.unit_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($editItem['quantity'] * $editItem['unit_price'], 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <select wire:model.defer="editItem.currency_id" class="text-sm border rounded px-2 py-1 w-full">
                                    <option value="">Select Currency</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->code }}</option>
                                    @endforeach
                                </select>
                                @error('editItem.currency_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex space-x-2">
                               <form wire:submit.prevent="save">
    <button type="submit" wire:loading.attr="disabled">Save</button>
</form>
                                <button wire:click="cancel" class="text-gray-600 hover:text-gray-900">
                                    Cancel
                                </button>
                            </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<script>
document.addEventListener('livewire:load', function() {
    Livewire.on('item-updated', message => {
        alert(message);
    });
});
</script>