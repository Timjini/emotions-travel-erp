<!-- resources/views/components/country-select.blade.php -->
@props(['name' => 'country', 'required' => false, 'value' => ''])

<div x-data="{ 
    query: '',
    open: false,
    selected: '{{ $value }}',
    countries: {{ json_encode(config('countries')) }},
    get filteredCountries() {
        return Object.entries(this.countries)
            .filter(([code, name]) => 
                name.toLowerCase().includes(this.query.toLowerCase()) ||
                code.toLowerCase().includes(this.query.toLowerCase())
            )
    }
}">
    <x-input-label for="{{ $name }}" :value="__('Country') . ($required ? ' *' : '')" />
    
    <div class="relative mt-1">
        <x-text-input 
            x-model="query"
            @click="open = true"
            @focus="open = true"
            @keydown.escape="open = false"
            :name="$name"
            :id="$name"
            :required="$required"
            autocomplete="off"
        />
        
        <input type="hidden" :name="$name" x-model="selected">
        
        <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto max-h-60 focus:outline-none">
            <template x-for="[code, name] in filteredCountries" :key="code">
                <div 
                    @click="selected = code; query = name; open = false"
                    class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-gray-100"
                    :class="{ 'bg-gray-100': code === selected }"
                >
                    <span x-text="name" class="block truncate"></span>
                </div>
            </template>
        </div>
    </div>
    
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>