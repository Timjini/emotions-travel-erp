<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">System Settings</h3>
                        <x-link-button :href="route('company.system.edit-settings')">
                            Edit
                        </x-link-button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Invoice Prefix</p>
                            <p class="text-sm text-gray-900">{{ $settings->invoice_prefix }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Next Invoice #</p>
                            <p class="text-sm text-gray-900">{{ $settings->invoice_start_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Default Currency</p>
                            <p class="text-sm text-gray-900">{{ $settings->default_currency }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Default Language</p>
                            <p class="text-sm text-gray-900">{{ $settings->default_language }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Timezone</p>
                            <p class="text-sm text-gray-900">{{ $settings->timezone }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Financial Year Start</p>
                            <p class="text-sm text-gray-900">{{ $settings->financial_year_start }}</p>
                        </div>
                    </div>
                </div>
            </div>