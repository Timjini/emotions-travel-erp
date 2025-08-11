@props([
    'name' => 'currency_id',
    'label' => 'Currency',
    'currencies' => [],
    'selected' => null,
    'required' => false,
    'class' => '',
])

<div>
    <x-input-label :for="$name" :value="__($label)" />
    <select 
        id="{{ $name }}" 
        name="{{ $name }}" 
        class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full {{ $class }}"
        @if($required) required @endif
    >
        <option value="">Select Currency</option>
        @foreach($currencies as $currency)
            <option 
                value="{{ $currency->id }}" 
                @selected($selected == $currency->id)
            >
                {{ $currency->code }} - {{ $currency->symbol }}
            </option>
        @endforeach
    </select>
    <x-input-error class="mt-2" :messages="$errors->get($name)" />
</div>