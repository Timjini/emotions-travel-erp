<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Create New Company
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
                <a href="{{ route('company.system.index') }}" class="hover:text-blue-600">Companies</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li class="text-gray-600">Create</li>
        </ol>
    </nav>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Company Information</h3>
            </div>

        <form method="POST" action="{{ route('company.system.store') }}" enctype="multipart/form-data" x-data="{ loading: false }" @submit="loading = true">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500 mb-4">Basic Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" :value="__('Company Name *')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="legal_name" :value="__('Legal Name')" />
                            <x-text-input id="legal_name" name="legal_name" type="text" class="mt-1 block w-full" :value="old('legal_name')" />
                            <x-input-error :messages="$errors->get('legal_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="logo" :value="__('Company Logo')" />
                            <x-file-input 
                                id="logo_path" 
                                name="logo_path" 
                                label="Upload company logo" 
                                class="mt-1" 
                                accept="image/*"
                                required
                            />
                            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                        </div>


                        <div>
                            <x-input-label for="type" :value="__('Company Type *')" />
                            <select id="type" name="type" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0  text-sm border-gray-300 p-2.5 mt-1 block w-full" required>
                                <option value="">Select Type</option>
                                <option value="agency" @selected(old('type') == 'agency')>Travel Agency</option>
                                <option value="dmo" @selected(old('type') == 'dmo')>DMO</option>
                                <option value="hotel" @selected(old('type') == 'hotel')>Hotel</option>
                                <option value="tour_operator" @selected(old('type') == 'tour_operator')>Tour Operator</option>
                                <option value="other" @selected(old('type') == 'other')>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="invoicing_entity" :value="__('Invoicing Entity')" />
                            <x-text-input id="invoicing_entity" name="invoicing_entity" type="text" class="mt-1 block w-full" :value="old('invoicing_entity')" />
                            <x-input-error :messages="$errors->get('invoicing_entity')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="source" :value="__('Source')" />
                            <x-text-input id="source" name="source" type="text" class="mt-1 block w-full" :value="old('source')" />
                            <x-input-error :messages="$errors->get('source')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500 mb-4">Contact Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="contact_person" :value="__('Contact Person')" />
                            <x-text-input id="contact_person" name="contact_person" type="text" class="mt-1 block w-full" :value="old('contact_person')" />
                            <x-input-error :messages="$errors->get('contact_person')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="website" :value="__('Website')" />
                            <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" :value="old('website')" />
                            <x-input-error :messages="$errors->get('website')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone_1" :value="__('Primary Phone *')" />
                            <x-text-input id="phone_1" name="phone_1" type="text" class="mt-1 block w-full" :value="old('phone_1')" required />
                            <x-input-error :messages="$errors->get('phone_1')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone_2" :value="__('Secondary Phone')" />
                            <x-text-input id="phone_2" name="phone_2" type="text" class="mt-1 block w-full" :value="old('phone_2')" />
                            <x-input-error :messages="$errors->get('phone_2')" class="mt-2" />
                        </div>

                        <div>
                                <x-input-label for="language" :value="__('Language')" />
                                <select id="language" name="language" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full">
                                    @foreach ($languages as $code => $name)
                                        <option value="{{ $code }}">
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('language')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500 mb-4">Address Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <x-input-label for="address" :value="__('Address *')" />
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')" required />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="post_code" :value="__('Postal Code *')" />
                            <x-text-input id="post_code" name="post_code" type="text" class="mt-1 block w-full" :value="old('post_code')" required />
                            <x-input-error :messages="$errors->get('post_code')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="city" :value="__('City *')" />
                            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city')" required />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="district" :value="__('District/State')" />
                            <x-text-input id="district" name="district" type="text" class="mt-1 block w-full" :value="old('district')" />
                            <x-input-error :messages="$errors->get('district')" class="mt-2" />
                        </div>

                         <!-- Country -->
                        <div>
                            <x-input-label for="country" :value="__('Country *')" />
                            <select id="country" name="country" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full" required>
                                <option value="">Select...</option>
                                @foreach(config('countries') as $code => $name)
                                    <option value="{{ $code }}" {{ old('country') == $code ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('country')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Business Information -->
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500 mb-4">Business Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="vat_number" :value="__('VAT Number')" />
                            <x-text-input id="vat_number" name="vat_number" type="text" class="mt-1 block w-full" :value="old('vat_number')" />
                            <x-input-error :messages="$errors->get('vat_number')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full">
                                <option value="active" @selected(old('status', 'active') == 'active')>Active</option>
                                <option value="inactive" @selected(old('status') == 'inactive')>Inactive</option>
                                <option value="suspended" @selected(old('status') == 'suspended')>Suspended</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Financial Information -->
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500 mb-4">Financial Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="iban" :value="__('IBAN')" />
                            <x-text-input id="iban" name="iban" type="text" class="mt-1 block w-full" :value="old('iban')" />
                            <x-input-error :messages="$errors->get('iban')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="swift_code" :value="__('SWIFT/BIC Code')" />
                            <x-text-input id="swift_code" name="swift_code" type="text" class="mt-1 block w-full" :value="old('swift_code')" />
                            <x-input-error :messages="$errors->get('swift_code')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500 mb-4">Additional Information</h4>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <x-input-label for="notes" :value="__('Notes')" />
                            <textarea id="notes" name="notes" rows="3" class="rounded bg-gray-50 border text-gray-900 flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <x-secondary-button :href="route('company.system.index')" class="mr-4">
                    Cancel
                </x-secondary-button>
                <x-loading-button label="Create Company" />
            </div>
        </form>
            
        </div>
    </div>
</x-app-layout>