<div id="costModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75" onclick="hideCostModal()"></div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium mb-4">Add Cost to Item</h3>
                    <form method="POST" action="{{ route('file-costs.store', $file) }}" x-data="{ loading: false }" @submit="loading = true">
                        @csrf
                        <input type="hidden" name="file_item_id" id="file_item_id" value="{{ $fileItem->id ?? '' }}">
                        <input type="hidden" name="original_currency" id="original_currency" value="{{ $file->currency->code ?? 'EUR' }}">
                        <input type="hidden" name="customer_id" id="customer_id" value="{{ $file->customer_id }}">
                        <input type="hidden" name="file_id" id="file_id" value="{{ $file->id }}">
                        
                        <input type="hidden" name="exchange_rate" id="exchange_rate" value="1">
                        
                        <div class="space-y-4">
                            
                            <!-- Supplier -->
                            <div>
                                @livewire('supplier-search')
                                <input type="hidden" name="supplier_id" id="form_supplier_id" value="">
                            </div>
                    
                            <!-- Service Type -->
                            <div>
                                <label for="service_type" class="block text-sm font-medium text-gray-700">Service Type</label>
                                <select id="service_type" name="service_type" required class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select service type</option>
                                    @foreach(\App\Enums\Supplier\SupplierType::cases() as $type)
                                    <option value="{{ $type->value }}" 
                                            @selected(isset($fileItem) && $fileItem->service_name === $type->value)
                                            @selected(old('service_type') === $type->value)>
                                        {{ $type->name() }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Payment Status -->
                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-gray-700">Payment Status</label>
                                <select id="payment_status" name="payment_status" required class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
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
                                    class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    value="{{ old('service_date', now()->format('Y-m-d')) }}">
                            </div>
                    
                            <!-- Quantity -->
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" id="quantity" name="quantity" min="1" value="{{ $fileItem->quantity ?? 1 }}" required
                                    class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            
                            <!-- Number of People-->
                            
                            <div>
                                <label for="number_of_people" class="block text-sm font-medium text-gray-700">Number of People</label>
                                <input type="number" id="number_of_people" name="number_of_people" min="1" 
                                       value="{{ ($file->number_of_people) }}"
                                       class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                    
                            <!-- Unit Price -->
                            <div>
                                <label for="unit_price" class="block text-sm font-medium text-gray-700">Unit Price</label>
                                <input type="number" id="unit_price" name="unit_price" step="0.01" min="0" value="{{ $fileItem->unit_price ?? '' }}" required
                                    class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            
                            <div>
                                 <!-- Currency -->
                                <!-- Currency -->
                                 <div>
                                <x-input-label for="base_currency_id" :value="__('Currency')" />
                                <div class="flex">
                                    <select id="base_currency_id" name="base_currency_id" class="rounded bg-gray-50 border text-gray-900  block flex-1 min-w-0  text-sm  p-2.5 px-4 py-2  border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:border-transparent transition mt-1 block w-full">
                                        <option value="">-- Select --</option>
                                        @foreach($currencies as $currency)
                                        <option value="{{ $currency->id }}" @selected(old('base_currency_id', $file->currency_id) == $currency->id)>
                                            {{ $currency->code }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <a href="{{ route('currencies.create') }}" target="_blank"
                                        class="ml-2 mt-1 text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </a>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('currency_id')" />
                            </div>

                            </div>
                    
                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                
                                <textarea id="description" name="description" 
                                    class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ $fileItem->description ?? old('description') }}</textarea>
                            </div>
                            
                            <!-- Add quantity anomaly checkbox -->
                            <div class="flex items-center">
                                <input type="checkbox" id="quantity_anomaly" name="quantity_anomaly" value="1"
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                       @checked(old('quantity_anomaly', false))>
                                <label for="quantity_anomaly" class="ml-2 block text-sm text-gray-700">Quantity Anomaly</label>
                            </div>
                    
                            <!-- Amount Paid (shown when status is partially_paid) -->
                            <div id="amountPaidContainer" class="hidden">
                                <label for="amount_paid" class="block text-sm font-medium text-gray-700">Amount Paid</label>
                                <input type="number" id="amount_paid" name="amount_paid" step="0.01" min="0"
                                    class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                    
                            <!-- Payment Date (shown when status is paid) -->
                            <div id="paymentDateContainer" class="hidden">
                                <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                                <input type="date" id="payment_date" name="payment_date"
                                    class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>
                    
                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                            <x-loading-button label="Save Cost" />

                            <button type="button" onclick="hideCostModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
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
    
    document.addEventListener('DOMContentLoaded', function() {
        const paymentStatus = document.getElementById('payment_status');
        const amountPaidContainer = document.getElementById('amountPaidContainer');
        const paymentDateContainer = document.getElementById('paymentDateContainer');
    
        function updatePaymentFields() {
            const status = paymentStatus.value;
            
            amountPaidContainer.classList.toggle('hidden', !['partially_paid', 'paid'].includes(status));
            paymentDateContainer.classList.toggle('hidden', status !== 'paid');
        }
    
        if (paymentStatus) {
            paymentStatus.addEventListener('change', updatePaymentFields);
            updatePaymentFields(); // Initialize on load
        }
    });

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
    
    
    
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('supplierSelected', (supplierId) => {
            // Update the hidden input in the form
            document.getElementById('form_supplier_id').value = supplierId.supplierId;
            console.log('Supplier selected:', supplierId.supplierId);
        });
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