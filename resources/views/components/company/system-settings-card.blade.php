<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">System Settings</h3>
            <x-link-button :href="route('company.system.edit-settings')">
                Edit
            </x-link-button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Banking --}}
            <div>
                <p class="text-sm font-medium text-gray-500">IBAN</p>
                <p class="text-sm text-gray-900">{{ $settings->iban ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">SWIFT Code</p>
                <p class="text-sm text-gray-900">{{ $settings->swift_code ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Bank Name</p>
                <p class="text-sm text-gray-900">{{ $settings->bank_name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Bank Account Name</p>
                <p class="text-sm text-gray-900">{{ $settings->bank_account_name ?? '—' }}</p>
            </div>

            {{-- Invoice --}}
            <div>
                <p class="text-sm font-medium text-gray-500">Invoice Prefix</p>
                <p class="text-sm text-gray-900">{{ $settings->invoice_prefix }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Next Invoice #</p>
                <p class="text-sm text-gray-900">{{ $settings->invoice_start_number }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Invoice Due Days</p>
                <p class="text-sm text-gray-900">{{ $settings->invoice_due_days }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Default Currency</p>
                <p class="text-sm text-gray-900">{{ $settings->currency->code }}</p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">Invoice Currency</p>
                <p class="text-sm text-gray-900">{{ $settings->invoice_currency }}</p>
            </div>

            {{-- General --}}
            <div>
                <p class="text-sm font-medium text-gray-500">Default Language</p>
                <p class="text-sm text-gray-900">{{ $settings->preferred_language }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Timezone</p>
                <p class="text-sm text-gray-900">{{ $settings->timezone }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Date Format</p>
                <p class="text-sm text-gray-900">{{ $settings->date_format }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Financial Year Start</p>
                <p class="text-sm text-gray-900">{{ $settings->financial_year_start }}</p>
            </div>

            {{-- Contact --}}
            <div>
                <p class="text-sm font-medium text-gray-500">Contact Person</p>
                <p class="text-sm text-gray-900">{{ $settings->contact_person ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Phone 2</p>
                <p class="text-sm text-gray-900">{{ $settings->phone_2 ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Website</p>
                <p class="text-sm text-gray-900">{{ $settings->website ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">District</p>
                <p class="text-sm text-gray-900">{{ $settings->district ?? '—' }}</p>
            </div>

            {{-- Notes & Source --}}
            <div class="md:col-span-3">
                <p class="text-sm font-medium text-gray-500">Notes</p>
                <p class="text-sm text-gray-900">{{ $settings->notes ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Source</p>
                <p class="text-sm text-gray-900">{{ $settings->source ?? '—' }}</p>
            </div>
        </div>
    </div>
</div>
