<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize border-b">
            {{ __('Edit Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('customers.update', $customer) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name *')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                                value="{{ old('name', $customer->name) }}" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Invoicing Entity -->
                        <div>
                            <x-input-label for="invoicing_entity" :value="__('Invoicing Entity *')" />
                            <x-text-input id="invoicing_entity" name="invoicing_entity" type="text" class="mt-1 block w-full"
                                value="{{ old('invoicing_entity', $customer->invoicing_entity) }}" required />
                            <x-input-error :messages="$errors->get('invoicing_entity')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Address *')" />
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                                value="{{ old('address', $customer->address) }}" required />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- Post Code -->
                        <div>
                            <x-input-label for="post_code" :value="__('Post Code *')" />
                            <x-text-input id="post_code" name="post_code" type="text" class="mt-1 block w-full"
                                value="{{ old('post_code', $customer->post_code) }}" required />
                            <x-input-error :messages="$errors->get('post_code')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- City -->
                        <div>
                            <x-input-label for="city" :value="__('City *')" />
                            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full"
                                value="{{ old('city', $customer->city) }}" required />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>

                        <!-- District -->
                        <div>
                            <x-input-label for="district" :value="__('District')" />
                            <x-text-input id="district" name="district" type="text" class="mt-1 block w-full"
                                value="{{ old('district', $customer->district) }}" />
                        </div>

                        <!-- Country -->
                        <div>
                            <x-input-label for="country" :value="__('Country *')" />
                            <select id="country" name="country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Select...</option>
                                @foreach(config('countries') as $code => $name)
                                    <option value="{{ $code }}" {{ old('country', $customer->country) == $code ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('country')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                value="{{ old('email', $customer->email) }}" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Contact Person -->
                        <div>
                            <x-input-label for="contact_person" :value="__('Contact Person')" />
                            <x-text-input id="contact_person" name="contact_person" type="text" class="mt-1 block w-full"
                                value="{{ old('contact_person', $customer->contact_person) }}" />
                        </div>
                    </div>

                    <!-- Website -->
                    <div class="mb-6">
                        <x-input-label for="website" :value="__('Website')" />
                        <x-text-input id="website" name="website" type="url" class="mt-1 block w-full"
                            value="{{ old('website', $customer->website) }}" />
                    </div>

                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Contact Information') }}</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- VAT Number -->
                        <div>
                            <x-input-label for="vat_number" :value="__('VAT Number')" />
                            <x-text-input id="vat_number" name="vat_number" type="text" class="mt-1 block w-full"
                                value="{{ old('vat_number', $customer->vat_number) }}" />
                        </div>

                        <!-- Contact Number 1 -->
                        <div>
                            <x-input-label for="phone_1" :value="__('Contact Number 1')" />
                            <x-text-input id="phone_1" name="phone_1" type="tel" class="mt-1 block w-full"
                                value="{{ old('phone_1', $customer->phone_1) }}" />
                        </div>

                        <!-- Contact Number 2 -->
                        <div>
                            <x-input-label for="phone_2" :value="__('Contact Number 2')" />
                            <x-text-input id="phone_2" name="phone_2" type="tel" class="mt-1 block w-full"
                                value="{{ old('phone_2', $customer->phone_2) }}" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Type -->
                        <div>
                            <x-input-label for="type" :value="__('Type *')" />
                            <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @foreach(\App\Enums\CustomerType::cases() as $type)
                                    <option value="{{ $type->value }}" {{ old('type', $customer->type->value) == $type->value ? 'selected' : '' }}>
                                        {{ ucfirst($type->value) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div>
                            <x-input-label for="category" :value="__('Category')" />
                            <select id="category" name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select...</option>
                                @foreach(\App\Enums\CustomerCategory::cases() as $category)
                                    <option value="{{ $category->value }}" {{ old('category', $customer->category?->value) == $category->value ? 'selected' : '' }}>
                                        {{ ucfirst($category->value) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- IBAN -->
                        <div>
                            <x-input-label for="iban" :value="__('IBAN')" />
                            <x-text-input id="iban" name="iban" type="text" class="mt-1 block w-full"
                                value="{{ old('iban', $customer->iban) }}" />
                        </div>

                        <!-- Swift Code -->
                        <div>
                            <x-input-label for="swift_code" :value="__('Swift Code')" />
                            <x-text-input id="swift_code" name="swift_code" type="text" class="mt-1 block w-full"
                                value="{{ old('swift_code', $customer->swift_code) }}" />
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <x-input-label for="notes" :value="__('Notes')" />
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $customer->notes) }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <x-secondary-button type="button" onclick="window.history.back()">
                            {{ __('Back') }}
                        </x-secondary-button>
                        <x-primary-button>
                            {{ __('Update Customer') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>