@props([
    'destination' => null,
    'method' => 'POST',
    'action' => '',
])

<form method="POST" action="{{ $action }}">
    @csrf
    @method($method)
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Destination Information</h3>
        </div>
        
        <div class="px-6 py-4 space-y-4">
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                    :value="old('name', $destination?->name)" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            
            <div>
                <x-input-label for="country" :value="__('Country')" />
                <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" 
                    :value="old('country', $destination?->country)" required />
                <x-input-error class="mt-2" :messages="$errors->get('country')" />
            </div>
            
            <div>
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" rows="3" 
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >{{ old('description', $destination?->description) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
            <x-secondary-button class="mr-2" onclick="window.location='/destinations' ">
                Cancel
            </x-secondary-button>
            <x-primary-button type="submit">
                Save
            </x-primary-button>
        </div>
    </div>
</form>