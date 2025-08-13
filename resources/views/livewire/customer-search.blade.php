<div class="relative">
    <label for="customer_search" class="block text-sm font-medium text-gray-700">Customer</label>
    
    <!-- Search Input -->
    <div class="relative mt-1">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input 
            type="text" 
            id="customer_search"
            wire:model.live.debounce.500ms="search" 
            placeholder="Search by name, email, phone..." 
            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            wire:keydown.escape="resetSearch"
            wire:keydown.arrow-up="decrementHighlight"
            wire:keydown.arrow-down="incrementHighlight"
            wire:keydown.enter="selectHighlighted"
            wire:blur="closeDropdown"
        >
        <!-- Hidden input for form submission -->
        <input type="hidden" name="customer_id" value="{{ $selectedCustomer?->id }}">
    </div>

    <!-- Results Dropdown -->
    @if($showDropdown && !empty($search))
        <div class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm max-h-60">
            @if($customers->count())
                <ul>
                    @foreach($customers as $index => $customer)
                        <li 
                            wire:click="selectCustomer('{{ $customer->id }}')"
                            class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9 hover:bg-blue-50 {{ $highlightIndex === $index ? 'bg-blue-50' : '' }}"
                        >
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $customerr->name }}</span>
                                <div class="flex flex-wrap gap-x-2 text-xs text-gray-500">
                                    @if($customer->email)
                                        <span>{{ $customer->email }}</span>
                                    @endif
                                    @if($customer->contact_person)
                                        <span>{{ $customer->contact_person }}</span>
                                    @endif
                                    @if($customer->phone_1)
                                        <span>{{ $customer->phone_1 }}</span>
                                    @endif
                                </div>
                            </div>
                            @if($selectedCustomer?->id === $customer->id)
                                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-blue-600">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-gray-500 py-2 pl-3 pr-9">No customers found</div>
            @endif
        </div>
    @endif
</div>