<div class="relative">
    <label for="country_search" class="block text-sm font-medium text-gray-700">Country</label>
    
    <!-- Search Input -->
    <div class="relative mt-1">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input 
            type="text" 
            id="country_search"
            wire:model.live.debounce.500ms="search" 
            placeholder="Search by country name or code..." 
            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-xl leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            wire:keydown.escape="resetSearch"
            wire:keydown.arrow-up="decrementHighlight"
            wire:keydown.arrow-down="incrementHighlight"
            wire:keydown.enter="selectHighlighted"
            wire:blur="closeDropdown"
        >
        <!-- Hidden input for form submission -->
        <input type="hidden" name="country_id" value="{{ $selectedCountry?->id }}">
    </div>

    <!-- Results Dropdown -->
    @if($showDropdown && !empty($search))
        <div class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm max-h-60">
            @if($countries->count())
                <ul>
                    @foreach($countries as $index => $country)
                        <li 
                            wire:click="selectCountry('{{ $country->id }}')"
                            class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9 hover:bg-blue-50 {{ $highlightIndex === $index ? 'bg-blue-50' : '' }}"
                        >
                            <div class="flex justify-between items-center">
                                <span class="font-medium">{{ $country->name }}</span>
                                <span class="text-xs bg-gray-100 rounded-full px-2 py-0.5 text-gray-600">
                                    {{ $country->code }}
                                </span>
                            </div>
                            
                            @if($selectedCountry && $selectedCountry->id === $country->id)
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
                <div class="text-gray-500 py-2 pl-3 pr-9">
                    @if(strlen($search) >= 2)
                        No countries found
                    @else
                        Type at least 2 characters to search
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>