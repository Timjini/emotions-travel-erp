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
                    <form method="POST" action="{{ route('company.system.update-settings') }}" x-data="{ loading: false }" @submit="loading = true">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Invoice Settings -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium mb-4">Invoice Settings</h3>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
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

                                    <div>
                                        <x-input-label for="invoice_due_days" :value="__('Invoice Due Days')" />
                                        <x-text-input id="invoice_due_days" name="invoice_due_days" type="number" class="mt-1 block w-full" 
                                            :value="old('invoice_due_days', $settings->invoice_due_days)" required min="1" />
                                        <x-input-error class="mt-2" :messages="$errors->get('invoice_due_days')" />
                                    </div>

                                    <div>
                                        <x-input-label for="invoice_currency" :value="__('Invoice Currency')" />
                                        <select id="invoice_currency" name="invoice_currency" class=" bg-gray-50 border text-gray-900  flex-1 min-w-0  text-sm border-gray-300 p-2.5  px-4 py-2 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:border-transparent transition mt-1 block w-full">
                                            <option value="EUR" {{ old('invoice_currency', $settings->invoice_currency) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                            <option value="USD" {{ old('invoice_currency', $settings->invoice_currency) == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                            <option value="GBP" {{ old('invoice_currency', $settings->invoice_currency) == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                        </select>
                                        <input type="hidden" name="invoice_currency" id="invoice_currency" value="{{old('invoice_currency', $settings->invoice_currency ?? '')}}" />
                                        <x-input-error class="mt-2" :messages="$errors->get('invoice_currency')" />
                                    </div>
                                    <x-currency-select 
                                        :currencies="$currencies" 
                                    />
                                </div>
                            </div>

                            <!-- Banking Information -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium mb-4">Banking Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="bank_name" :value="__('Bank Name')" />
                                        <x-text-input id="bank_name" name="bank_name" type="text" class="mt-1 block w-full" 
                                            :value="old('bank_name', $settings->bank_name)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
                                    </div>

                                    <div>
                                        <x-input-label for="bank_account_name" :value="__('Account Name')" />
                                        <x-text-input id="bank_account_name" name="bank_account_name" type="text" class="mt-1 block w-full" 
                                            :value="old('bank_account_name', $settings->bank_account_name)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('bank_account_name')" />
                                    </div>

                                    <div>
                                        <x-input-label for="iban" :value="__('IBAN')" />
                                        <x-text-input id="iban" name="iban" type="text" class="mt-1 block w-full" 
                                            :value="old('iban', $settings->iban)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('iban')" />
                                    </div>

                                    <div>
                                        <x-input-label for="swift_code" :value="__('SWIFT Code')" />
                                        <x-text-input id="swift_code" name="swift_code" type="text" class="mt-1 block w-full" 
                                            :value="old('swift_code', $settings->swift_code)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('swift_code')" />
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium mb-4">Contact Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <x-input-label for="contact_person" :value="__('Contact Person')" />
                                        <x-text-input id="contact_person" name="contact_person" type="text" class="mt-1 block w-full" 
                                            :value="old('contact_person', $settings->contact_person)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('contact_person')" />
                                    </div>

                                    <div>
                                        <x-input-label for="phone_2" :value="__('Secondary Phone')" />
                                        <x-text-input id="phone_2" name="phone_2" type="text" class="mt-1 block w-full" 
                                            :value="old('phone_2', $settings->phone_2)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('phone_2')" />
                                    </div>

                                    <div>
                                        <x-input-label for="website" :value="__('Website')" />
                                        <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" 
                                            :value="old('website', $settings->website)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('website')" />
                                    </div>

                                    <div>
                                        <x-input-label for="district" :value="__('District')" />
                                        <x-text-input id="district" name="district" type="text" class="mt-1 block w-full" 
                                            :value="old('district', $settings->district)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('district')" />
                                    </div>
                                </div>
                            </div>

                            <!-- System Defaults -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium mb-4">System Defaults</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <x-input-label for="preferred_language" :value="__('Preferred Language')" />
                                        <select id="preferred_language" name="preferred_language" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full">
                                            <option value="en" {{ old('preferred_language', $settings->preferred_language) == 'en' ? 'selected' : '' }}>English</option>
                                            <option value="es" {{ old('preferred_language', $settings->preferred_language) == 'es' ? 'selected' : '' }}>Spanish</option>
                                            <option value="fr" {{ old('preferred_language', $settings->preferred_language) == 'fr' ? 'selected' : '' }}>French</option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('preferred_language')" />
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
                                        <x-text-input id="financial_year_start" name="financial_year_start" type="text" class="mt-1 block w-full" 
                                            placeholder="MM-DD"
                                            :value="old('financial_year_start', $settings->financial_year_start)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('financial_year_start')" />
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium mb-4">Additional Information</h3>
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <x-input-label for="notes" :value="__('Notes')" />
                                        <textarea id="notes" name="notes" rows="3" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full">{{ old('notes', $settings->notes) }}</textarea>
                                        <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                                    </div>

                                    <div>
                                        <x-input-label for="source" :value="__('Source')" />
                                        <x-text-input id="source" name="source" type="text" class="mt-1 block w-full" 
                                            :value="old('source', $settings->source)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('source')" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-link class="m-2" href="{{route('company.system.index')}}">
                                Cancel
                            </x-secondary-link>
                            <x-loading-button label="Save Setting" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>