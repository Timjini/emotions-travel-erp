<div id="editCostModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75" onclick="hideEditCostModal()"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-medium mb-4">Edit Cost</h3>
                <form action="{{ route('file-costs.update', $cost->id, $cost) }}" method="POST" x-data="{ loading: false }" @submit="loading = true" id="editCostForm">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4">

                        <!-- Supplier -->
                        <div>
                            @livewire('supplier-search')
                            <input type="hidden" name="supplier_id" id="edit_supplier_id" value="{{ old('supplier_id', $cost->supplier_id) }}">
                        </div>

                        <!-- Service Type -->
                        <div>
                            <label for="edit_service_type" class="block text-sm font-medium text-gray-700">Service Type</label>
                            <select id="edit_service_type" name="service_type" required class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select service type</option>
                                @foreach(\App\Enums\Supplier\SupplierType::cases() as $type)
                                <option value="{{ $type->value }}" {{ old('service_type', $cost->service_type) == $type->value ? 'selected' : '' }}>
                                    {{ $type->name() }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Payment Status -->
                        <div>
                            <label for="edit_payment_status" class="block text-sm font-medium text-gray-700">Payment Status</label>
                            <select id="edit_payment_status" name="payment_status" required class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select payment status</option>
                                @foreach(\App\Enums\Payment\PaymentStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ old('payment_status', $cost->payment_status) == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Service Date -->
                        <div>
                            <label for="edit_service_date" class="block text-sm font-medium text-gray-700">Service Date</label>
                            <input type="date" id="edit_service_date" name="service_date" required
                                value="{{ old('service_date', $cost->service_date?->format('Y-m-d')) }}"
                                class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="edit_quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" id="edit_quantity" name="quantity" min="1"
                                value="{{ old('quantity', $cost->quantity) }}" required
                                class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- Number of People -->
                        <div>
                            <label for="edit_number_of_people" class="block text-sm font-medium text-gray-700">Number of People</label>
                            <input type="number" id="edit_number_of_people" name="number_of_people" min="1"
                                value="{{ old('number_of_people', $cost->number_of_people) }}"
                                class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- Unit Price -->
                        <div>
                            <label for="edit_unit_price" class="block text-sm font-medium text-gray-700">Unit Price</label>
                            <input type="number" id="edit_unit_price" name="unit_price" step="0.01" min="0" required
                                value="{{ old('unit_price', $cost->unit_price) }}"
                                class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- Currency -->
                        <div>
                            <x-input-label for="edit_base_currency_id" :value="__('Currency')" />
                            <div class="flex">
                                <select id="edit_base_currency_id" name="base_currency_id" class="rounded bg-gray-50 border text-gray-900 block flex-1 min-w-0 text-sm p-2.5 px-4 py-2 border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:border-transparent transition mt-1 block w-full">
                                    <option value="">-- Select --</option>
                                    @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}" {{ old('base_currency_id', $cost->base_currency_id) == $currency->id ? 'selected' : '' }}>
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
                                <input type="hidden" name="base_currency_id" value="{{ old('base_currency_id', $cost->base_currency_id)}}" />
                                <input type="hidden" name="original_currency_id" id="original_currency_id" value="{{ old('original_currency_id', $cost->original_currency_id)}}" />
                                <input type="hidden" name="file_id" id="file_id" value="{{ old('file_id', $cost->file->id)}}" />
                                <input type="hidden" name="customer_id" id="customer_id" value="{{ old('customer_id', $cost->file->customer_id)}}" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('currency_id')" />
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="edit_description" name="description"
                                class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description', $cost->description) }}</textarea>
                        </div>

                        <!-- Quantity Anomaly -->
                        <div class="flex items-center">
                            <input type="checkbox" id="edit_quantity_anomaly" name="quantity_anomaly" value="1"
                                {{ old('quantity_anomaly', $cost->quantity_anomaly) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="edit_quantity_anomaly" class="ml-2 block text-sm text-gray-700">Quantity Anomaly</label>
                        </div>

                        <!-- Amount Paid -->
                        <div id="edit_amountPaidContainer" class="{{ in_array(old('payment_status', $cost->payment_status), ['partially_paid','paid']) ? '' : 'hidden' }}">
                            <label for="edit_amount_paid" class="block text-sm font-medium text-gray-700">Amount Paid</label>
                            <input type="number" id="edit_amount_paid" name="amount_paid" step="0.01" min="0"
                                value="{{ old('amount_paid', $cost->amount_paid) }}"
                                class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- Payment Date -->
                        <div id="edit_paymentDateContainer" class="{{ old('payment_status', $cost->payment_status) === 'paid' ? '' : 'hidden' }}">
                            <label for="edit_payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                            <input type="date" id="edit_payment_date" name="payment_date"
                                value="{{ old('payment_date', $cost->payment_date?->format('Y-m-d')) }}"
                                class="block w-full px-2 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                        <x-loading-button label="Update Cost" />

                        <button type="button" onclick="hideEditCostModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    // ====================== CREATE MODAL FUNCTIONS ======================
    function showCostModal(itemId) {
        document.getElementById('file_item_id').value = itemId;
        document.getElementById('costModal').classList.remove('hidden');
    }

    function hideCostModal() {
        document.getElementById('costModal').classList.add('hidden');
    }

    // ====================== EDIT MODAL FUNCTIONS ======================
    function showEditCostModal(costId) {
        // Fetch cost data and populate form
        fetch(`/file-costs/${costId}/edit`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(cost => {
                // Populate form fields
                document.getElementById('edit_supplier_id').value = cost.supplier_id;
                document.getElementById('edit_service_type').value = cost.service_type;
                document.getElementById('edit_payment_status').value = cost.payment_status;
                document.getElementById('edit_quantity').value = cost.quantity;
                document.getElementById('edit_unit_price').value = cost.unit_price;
                document.getElementById('edit_description').value = cost.description;
                document.getElementById('edit_number_of_people').value = cost.number_of_people;
                document.getElementById('edit_service_date').value = cost.service_date;
                document.getElementById('edit_amount_paid').value = cost.amount_paid;
                document.getElementById('edit_payment_date').value = cost.payment_date;
                document.getElementById('edit_quantity_anomaly').checked = cost.quantity_anomaly;
                document.getElementById('edit_base_currency_id').value = cost.currency_id;

                // Set form action
                document.getElementById('editCostForm').action = `/file-costs/${costId}`;

                // Show modal
                document.getElementById('editCostModal').classList.remove('hidden');

                // Update payment fields visibility
                updateEditPaymentFields();
            })
            .catch(error => {
                console.error('Error fetching cost data:', error);
                alert('Failed to load cost data');
            });
    }

    function hideEditCostModal() {
        document.getElementById('editCostModal').classList.add('hidden');
    }

    function updateEditPaymentFields() {
        const status = document.getElementById('edit_payment_status').value;
        const amountPaidContainer = document.getElementById('edit_amountPaidContainer');
        const paymentDateContainer = document.getElementById('edit_paymentDateContainer');

        amountPaidContainer.classList.toggle('hidden', !['partially_paid', 'fully_paid'].includes(status));
        paymentDateContainer.classList.toggle('hidden', status !== 'fully_paid');
    }

    // ====================== COMMON EVENT LISTENERS ======================
    document.addEventListener('DOMContentLoaded', function() {
        // Create modal payment status handling
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

        // Edit modal payment status handling
        const editPaymentStatus = document.getElementById('edit_payment_status');
        if (editPaymentStatus) {
            editPaymentStatus.addEventListener('change', updateEditPaymentFields);
        }

        // Livewire supplier selection for both modals
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('supplierSelected', (supplierId) => {
                // For create modal
                if (document.getElementById('form_supplier_id')) {
                    document.getElementById('form_supplier_id').value = supplierId.supplierId;
                }
                // For edit modal
                if (document.getElementById('edit_supplier_id')) {
                    document.getElementById('edit_supplier_id').value = supplierId.supplierId;
                }
            });
        });
    });

    // ====================== FORM SUBMISSIONS ======================
    // // Create form submission
    // if (document.getElementById('costForm')) {
    //     document.getElementById('costForm').addEventListener('submit', function(e) {
    //         e.preventDefault();
    //         submitForm(this, 'POST');
    //     });
    // }

    // // Edit form submission
    // if (document.getElementById('editCostForm')) {
    //     document.getElementById('editCostForm').addEventListener('submit', function(e) {
    //         e.preventDefault();
    //         submitForm(this, 'PATCH');
    //     });
    // }

    // // Generic form submission handler
    // function submitForm(form, method) {
    //     const formData = new FormData(form);
    //     let url = form.action;
    //     console.log("data", formData);
    //     // For PATCH requests, we need to add _method to FormData
    //     if (method !== 'POST') {
    //         formData.append('_method', method);
    //     }

    //     fetch(url, {
    //         method: 'POST',
    //         body: formData,
    //         headers: {
    //             'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //             'Accept': 'application/json',
    //         }
    //     })
    //     .then(response => {
    //         if (!response.ok) throw new Error('Network response was not ok');
    //         return response.json();
    //     })
    //     .then(data => {
    //         if (data.success) {
    //             window.location.reload(); // Refresh to show changes
    //             if (form.id === 'costForm') hideCostModal();
    //             if (form.id === 'editCostForm') hideEditCostModal();
    //         } else {
    //             throw new Error(data.message || 'Unknown error occurred');
    //         }
    //     })
    //     .catch(error => {
    //         console.error('Error:', error);
    //         alert('Error: ' + error.message);
    //     });
    // }

    // ====================== HELPER FUNCTIONS ======================
    // Close modals when clicking outside
    document.addEventListener('click', function(event) {
        if (event.target.id === 'costModal') hideCostModal();
        if (event.target.id === 'editCostModal') hideEditCostModal();
    });
</script>