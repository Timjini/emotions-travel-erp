<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Company Information
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('company.system.update-company') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium mb-4">Basic Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="name" :value="__('Company Name')" />
                                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                                            :value="old('name', $company->name)" required autofocus />
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>

                                    <div>
                                        <x-input-label for="legal_name" :value="__('Legal Name')" />
                                        <x-text-input id="legal_name" name="legal_name" type="text" class="mt-1 block w-full" 
                                            :value="old('legal_name', $company->legal_name)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('legal_name')" />
                                    </div>

                                    <div>
                                        <x-input-label for="vat_number" :value="__('VAT Number')" />
                                        <x-text-input id="vat_number" name="vat_number" type="text" class="mt-1 block w-full" 
                                            :value="old('vat_number', $company->vat_number)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('vat_number')" />
                                    </div>

                                    <div>
                                        <x-input-label for="logo" :value="__('Company Logo')" />
                                        <input id="logo" name="logo" type="file" class="mt-1 block w-full" />
                                        <x-input-error class="mt-2" :messages="$errors->get('logo')" />
                                        @if($company->logo_path)
                                            <div class="mt-2">
                                                <img src="{{ Storage::url($company->logo_path) }}" alt="Current Logo" class="h-20">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium mb-4">Contact Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" 
                                            :value="old('email', $company->email)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                    </div>

                                    <div>
                                        <x-input-label for="phone_1" :value="__('Phone')" />
                                        <x-text-input id="phone_1" name="phone_1" type="text" class="mt-1 block w-full" 
                                            :value="old('phone_1', $company->phone_1)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                    </div>

                                    <div>
                                        <x-input-label for="website" :value="__('Website')" />
                                        <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" 
                                            :value="old('website', $company->website)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('website')" />
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium mb-4">Address Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="md:col-span-2">
                                        <x-input-label for="address" :value="__('Address')" />
                                        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" 
                                            :value="old('address', $company->address)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                                    </div>

                                    <div>
                                        <x-input-label for="city" :value="__('City')" />
                                        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" 
                                            :value="old('city', $company->city)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('city')" />
                                    </div>

                                    <div>
                                        <x-input-label for="state" :value="__('State/Province')" />
                                        <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" 
                                            :value="old('state', $company->state)" />
                                        <x-input-error class="mt-2" :messages="$errors->get('state')" />
                                    </div>

                                    <div>
                                        <x-input-label for="post_code" :value="__('Zip/Postal Code')" />
                                        <x-text-input id="post_code" name="post_code" type="text" class="mt-1 block w-full" 
                                            :value="old('post_code', $company->post_code)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('post_code')" />
                                    </div>

                                    <div>
                                        <x-input-label for="country" :value="__('Country')" />
                                        <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" 
                                            :value="old('country', $company->country)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('country')" />
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