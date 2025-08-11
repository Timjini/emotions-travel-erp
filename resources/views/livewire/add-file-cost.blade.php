<!-- resources/views/livewire/add-file-cost.blade.php -->
<div class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="$dispatch('closeModal')"></div>

        <!-- Modal Content -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-medium mb-4">Add Cost to Item</h3>
                
                <form wire:submit.prevent="save">
                    <!-- Service Type -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Service Type</label>
                        <select wire:model="serviceType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Select a service</option>
                            <option value="transport">Transport</option>
                            <option value="management">Management</option>
                        </select>
                        @error('serviceType') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Supplier -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Supplier</label>
                        <select wire:model="supplierId" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Select a supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Quantity and Price -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" wire:model="quantity" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unit Price</label>
                            <input type="number" wire:model="unitPrice" step="0.01" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('unitPrice') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <!-- Currency and Exchange Rate -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Currency</label>
                            <p class="mt-1 text-sm">{{ $originalCurrency }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Exchange Rate (to EUR)</label>
                            <input type="number" wire:model="exchangeRate" step="0.000001" min="0.000001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('exchangeRate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea wire:model="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Save Cost
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>