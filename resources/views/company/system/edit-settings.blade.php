<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit System Settings
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('company.system.update-settings') }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Invoice Settings -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium mb-4">Invoice Settings</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <x-input-label for="invoice_prefix" :value="__('Invoice Prefix')" />
                                        <x-text-input id="invoice_prefix" name="invoice_prefix" type="text" class="mt-1 block w-full" 
                                            :value="old('invoice_prefix', $settings->invoice_prefix)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('invoice_prefix')" />
                                    </div>

                                    <div>
                                        <x-input-label for="invoice_start_number" :value="__('Next Invoice Number')" />
                                        <x-text-input id="invoice_start_number" name="invoice_start_number" type="number" class="mt-1 block w-full" 
                                            :value="old('invoice_start_number', $settings->invoice_start_number)" required min="1" />
                                        <x-input-error class="mt-2" :messages="$errors->get('invoice_start_number')" />
                                    </div>
                                </div>
                            </div>

                            <!-- System Defaults -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium mb-4">System Defaults</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <x-input-label for="default_currency" :value="__('Default Currency')" />
                                        <select id="default_currency" name="default_currency" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full">
                                            <option value="USD" {{ old('default_currency', $settings->default_currency) == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                            <option value="EUR" {{ old('default_currency', $settings->default_currency) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                            <option value="GBP" {{ old('default_currency', $settings->default_currency) == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                            <!-- Add more currencies as needed -->
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('default_currency')" />
                                    </div>

                                    <div>
                                        <x-input-label for="default_language" :value="__('Default Language')" />
                                        <select id="default_language" name="default_language" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full">
                                            <option value="en" {{ old('default_language', $settings->default_language) == 'en' ? 'selected' : '' }}>English</option>
                                            <option value="es" {{ old('default_language', $settings->default_language) == 'es' ? 'selected' : '' }}>Spanish</option>
                                            <option value="fr" {{ old('default_language', $settings->default_language) == 'fr' ? 'selected' : '' }}>French</option>
                                            <!-- Add more languages as needed -->
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('default_language')" />
                                    </div>

                                    <div>
                                        <x-input-label for="timezone" :value="__('Timezone')" />
                                        <select id="timezone" name="timezone" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full">
                                            @foreach(timezone_identifiers_list() as $timezone)
                                            <option value="{{ $timezone }}" {{ old('timezone', $settings->timezone) == $timezone ? 'selected' : '' }}>
                                                {{ $timezone }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('timezone')" />
                                    </div>

                                    <div>
                                        <x-input-label for="date_format" :value="__('Date Format')" />
                                        <select id="date_format" name="date_format" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full">
                                            <option value="Y-m-d" {{ old('date_format', $settings->date_format) == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                            <option value="d/m/Y" {{ old('date_format', $settings->date_format) == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                            <option value="m/d/Y" {{ old('date_format', $settings->date_format) == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('date_format')" />
                                    </div>

                                    <div>
                                        <x-input-label for="financial_year_start" :value="__('Financial Year Start')" />
                                        <x-text-input id="financial_year_start" name="financial_year_start" type="text" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full" 
                                            placeholder="MM-DD"
                                            :value="old('financial_year_start', $settings->financial_year_start)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('financial_year_start')" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button :href="route('company.system.index')">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button class="ml-3">
                                Save Changes
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>