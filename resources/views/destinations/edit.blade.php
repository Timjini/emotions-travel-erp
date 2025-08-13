<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Edit Destination
        </h2>
    </x-slot>

    <nav class="max-w-3xl sm:px-6 lg:px-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li>
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <a href="{{ route('destinations.index') }}" class="hover:text-blue-600">Destinations</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <a href="{{ route('destinations.show', $destination) }}" class="hover:text-blue-600">{{ $destination->name }}</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li class="text-gray-800 font-medium">Edit</li>
        </ol>
    </nav>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <form method="POST" action="{{ route('destinations.update', $destination) }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                @method('PATCH')

                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Destination Information</h3>
                </div>

                <div class="px-6 py-4 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name', $destination->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-country-select name="country" required :value="old('country', $destination->country)" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="city" :value="__('City')" />
                            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" 
                                :value="old('city', $destination->city)" />
                            <x-input-error class="mt-2" :messages="$errors->get('city')" />
                        </div>

                        <div>
                            <x-input-label for="region" :value="__('Region/State')" />
                            <x-text-input id="region" name="region" type="text" class="mt-1 block w-full" 
                                :value="old('region', $destination->region)" />
                            <x-input-error class="mt-2" :messages="$errors->get('region')" />
                        </div>

                        <div>
                            <x-input-label for="airport_code" :value="__('Airport Code')" />
                            <x-text-input id="airport_code" name="airport_code" type="text" maxlength="3" 
                                class="mt-1 block w-full uppercase" 
                                :value="old('airport_code', $destination->airport_code)" />
                            <x-input-error class="mt-2" :messages="$errors->get('airport_code')" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <x-input-label for="latitude" :value="__('Latitude')" />
                            <x-text-input id="latitude" name="latitude" type="number" step="0.0000001" 
                                class="mt-1 block w-full" 
                                :value="old('latitude', $destination->latitude)" />
                            <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                        </div>

                        <div>
                            <x-input-label for="longitude" :value="__('Longitude')" />
                            <x-text-input id="longitude" name="longitude" type="number" step="0.0000001" 
                                class="mt-1 block w-full" 
                                :value="old('longitude', $destination->longitude)" />
                            <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
                        </div>

                        <div>
                            <x-input-label for="timezone" :value="__('Timezone')" />
                            <select id="timezone" name="timezone" class="rounded bg-gray-50 border text-gray-900  block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 w-full px-4 py-2 border border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:border-transparent transition mt-1 block w-full">
                                <option value="">-- Select --</option>
                                @foreach(config('timezones.all') as $tz)
                                <option value="{{ $tz }}" @selected(old('timezone', $destination->timezone) == $tz)>{{ $tz }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('timezone')" />
                        </div>

                        <div>
                            <x-input-label for="currency_id" :value="__('Currency')" />
                            <div class="flex">
                                <select id="currency_id" name="currency_id" class="rounded bg-gray-50 border text-gray-900  block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 w-full px-4 py-2 border border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:border-transparent transition mt-1 block w-full">
                                    <option value="">-- Select --</option>
                                    @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}" @selected(old('currency_id', $destination->currency_id) == $currency->id)>
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

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="best_season" :value="__('Best Season')" />
                            <x-text-input id="best_season" name="best_season" type="text" 
                                class="mt-1 block w-full" 
                                :value="old('best_season', $destination->best_season)" />
                            <x-input-error class="mt-2" :messages="$errors->get('best_season')" />
                        </div>

                        <div>
                            <x-input-label for="average_temperature" :value="__('Avg Temp')" />
                            <x-text-input id="average_temperature" name="average_temperature" type="text" 
                                placeholder="20°C - 30°C" class="mt-1 block w-full" 
                                :value="old('average_temperature', $destination->average_temperature)" />
                            <x-input-error class="mt-2" :messages="$errors->get('average_temperature')" />
                        </div>

                        <div class="flex items-end">
                            <div class="flex items-center h-10 mt-1">
                                <x-checkbox id="visa_required" name="visa_required" 
                                    :checked="old('visa_required', $destination->visa_required)" />
                                <x-input-label for="visa_required" :value="__('Visa Required')" class="ml-2" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <x-text-area 
                                id="description" 
                                name="description" 
                                class="mt-1 block w-full" 
                                rows="3"
                            >{{ old('description', $destination->description) }}</x-text-area>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div class="flex items-center">
                        <x-checkbox id="is_active" name="is_active" 
                            :checked="old('is_active', $destination->is_active)" />
                        <x-input-label for="is_active" :value="__('Active')" class="ml-2" />
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <x-secondary-link class="mr-2" type="button" 
                        href="{{ route('destinations.show', $destination) }}">
                        Cancel
                    </x-secondary-link>
                    <x-loading-button label="Save Changes" />
                </div>
            </form>
        </div>
    </div>
</x-app-layout>