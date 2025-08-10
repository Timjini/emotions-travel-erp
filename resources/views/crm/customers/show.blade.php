<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight capitalize">
            {{ __('Customer Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">{{ $customer->name }}</h1>

                        <div class="space-x-2">
                            <x-link-button :href="route('customers.edit', $customer)">
                                {{ __('Edit') }}
                            </x-link-button>
                            <x-danger-button
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-customer-deletion')"
                            >
                                {{ __('Delete') }}
                            </x-danger-button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Info -->
                        <div class="bg-gray-50  rounded p-4">
                            <h2 class="text-lg font-semibold mb-3">{{ __('Basic Information') }}</h2>
                            <p><strong>{{ __('Name:') }}</strong> {{ $customer->name }}</p>
                            <p><strong>{{ __('Email:') }}</strong> {{ $customer->email ?? '—' }}</p>
                            <p><strong>{{ __('Phone:') }}</strong> {{ $customer->phone ?? '—' }}</p>
                            <p><strong>{{ __('Status:') }}</strong> {{ $customer->status->label()  }}</p>
                            <p><strong>{{ __('Source:') }}</strong> {{ $customer->source ?? '—' }}</p>
                            <p><strong>{{ __('Preferred Language:') }}</strong> {{ strtoupper($customer->preferred_language ?? '—') }}</p>
                        </div>

                        <!-- Company Info -->
                        @if($customer->is_company)
                            <div class="bg-gray-50  rounded p-4">
                                <h2 class="text-lg font-semibold mb-3">{{ __('Company Details') }}</h2>
                                <p><strong>{{ __('Company Name:') }}</strong> {{ $customer->company_name }}</p>
                                <p><strong>{{ __('Tax ID:') }}</strong> {{ $customer->company_tax_id ?? '—' }}</p>
                                <p><strong>{{ __('Website:') }}</strong> 
                                    @if($customer->company_website)
                                        <a href="{{ $customer->company_website }}" class="text-blue-500 underline" target="_blank">
                                            {{ $customer->company_website }}
                                        </a>
                                    @else
                                        —
                                    @endif
                                </p>
                                <p><strong>{{ __('Address:') }}</strong> {{ $customer->company_address ?? '—' }}</p>
                            </div>
                        @endif
                    </div>

                    @if($customer->notes)
                        <div class="mt-6">
                            <h2 class="text-lg font-semibold mb-2">{{ __('Notes') }}</h2>
                            <div class="bg-gray-100  p-4 rounded">
                                <p class="whitespace-pre-line">{{ $customer->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="mt-6 text-sm text-gray-500">
                        {{ __('Created on') }}: {{ $customer->created_at->format('F d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Customer Confirmation Modal -->
    <x-modal name="confirm-customer-deletion" :show="$errors->customerDeletion->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('customers.destroy', $customer) }}" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900 ">
                {{ __('Are you sure you want to delete this customer?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 ">
                {{ __('This action cannot be undone.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
