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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Costs</th>
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($item->costs->isNotEmpty())
                        <div class="space-y-2">
                            @foreach($item->costs as $cost)
                            <div class="flex items-center justify-between">
                                <span class="text-sm">
                                    {{ $cost->supplier?->name ?? 'No Supplier' }}:
                                    {{ number_format($cost->total_price, 2) }} {{ $cost->original_currency }}
                                </span>
                                <span class="text-xs {{ $cost->payment_status->color() }} px-2 py-1 rounded-full">
                                    {{ $cost->payment_status->label() }}
                                </span>
                            </div>
                            @endforeach
                            <div class="text-sm font-medium mt-1">
                                Total Costs: {{ number_format($item->costs_sum_total_price, 2) }}
                            </div>
                        </div>
                        @else
                        <span class="text-gray-400 text-sm">No costs</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex space-x-2">
                        <button
                            onclick="showCostModal('{{ $item->id }}')"
                            class="text-green-600 hover:text-green-900 text-sm">
                            Add Cost
                        </button>
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

    <!-- Modal -->

    <div id="costModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75" onclick="hideCostModal()"></div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium mb-4">Add Cost to Item</h3>
                    <form id="costForm" method="POST" action="{{ route('file-costs.store', $file) }}">
                        @csrf
                        <input type="hidden" name="file_item_id" id="file_item_id">
                        <input type="hidden" name="original_currency" id="original_currency" value="{{ $file->currency->code ?? 'EUR' }}">
                        <input type="hidden" name="exchange_rate" id="exchange_rate" value="1">

                        <div class="space-y-4">
                            <!-- Service Type -->
                            <div>
                                <label for="service_type" class="block text-sm font-medium text-gray-700">Service Type</label>
                                <select id="service_type" name="service_type" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select service type</option>
                                    <option value="transport">Transport</option>
                                    <option value="management">Management</option>
                                    <option value="accommodation">Accommodation</option>
                                </select>
                            </div>

                            <!-- Payment Status -->
                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-gray-700">Payment Status</label>
                                <select id="payment_status" name="payment_status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select payment status</option>
                                    @foreach(\App\Enums\Payment\PaymentStatus::cases() as $status)
                                    <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Service Date -->
                            <div>
                                <label for="service_date" class="block text-sm font-medium text-gray-700">Service Date</label>
                                <input type="date" id="service_date" name="service_date" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('service_date', now()->format('Y-m-d')) }}">
                            </div>

                            <!-- Supplier -->
                            <div>
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                                <select id="supplier_id" name="supplier_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select supplier (optional)</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" id="quantity" name="quantity" min="1" value="1" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <!-- Unit Price -->
                            <div>
                                <label for="unit_price" class="block text-sm font-medium text-gray-700">Unit Price</label>
                                <input type="number" id="unit_price" name="unit_price" step="0.01" min="0" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <!-- Amount Paid (shown when status is partially_paid) -->
                            <div id="amountPaidContainer" class="hidden">
                                <label for="amount_paid" class="block text-sm font-medium text-gray-700">Amount Paid</label>
                                <input type="number" id="amount_paid" name="amount_paid" step="0.01" min="0"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <!-- Payment Date (shown when status is paid) -->
                            <div id="paymentDateContainer" class="hidden">
                                <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                                <input type="date" id="payment_date" name="payment_date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
                                Save Cost
                            </button>
                            <button type="button" onclick="hideCostModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    // Show modal and set file item ID
    function showCostModal(itemId) {
        document.getElementById('file_item_id').value = itemId;
        document.getElementById('costModal').classList.remove('hidden');
    }

    // Hide modal
    function hideCostModal() {
        document.getElementById('costModal').classList.add('hidden');
    }

    document.getElementById('payment_status').addEventListener('change', function() {
        const status = this.value;
        const amountPaidContainer = document.getElementById('amountPaidContainer');
        const paymentDateContainer = document.getElementById('paymentDateContainer');

        // Hide both containers first
        amountPaidContainer.classList.add('hidden');
        paymentDateContainer.classList.add('hidden');

        // Show relevant containers based on status
        if (status === 'partially_paid') {
            amountPaidContainer.classList.remove('hidden');
        } else if (status === 'fully_paid') {
            paymentDateContainer.classList.remove('hidden');
            document.getElementById('payment_date').value = new Date().toISOString().split('T')[0];
        }
    });

    // Handle form submission
    document.getElementById('costForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const costsContainer = document.getElementById(`costs-${form.file_item_id.value}`);
                    if (costsContainer) {
                        window.location.reload();
                    }
                    hideCostModal();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>