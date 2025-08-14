<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Company Information</h3>
                        <x-link-button :href="route('company.system.edit-company')">
                            Edit
                        </x-link-button>
                    </div>
                    
                    <div class="flex items-start">
                        @if($company->logo_path)
                        <div class="mr-6">
                            <img src="/public{{ Storage::url($company->logo_path) }}" alt="Company Logo" class="h-20">
                        </div>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 flex-1">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Company Name</p>
                                <p class="text-sm text-gray-900">{{ $company->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Legal Name</p>
                                <p class="text-sm text-gray-900">{{ $company->legal_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Tax ID</p>
                                <p class="text-sm text-gray-900">{{ $company->tax_id }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="text-sm text-gray-900">{{ $company->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Phone</p>
                                <p class="text-sm text-gray-900">{{ $company->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Address</p>
                                <p class="text-sm text-gray-900">
                                    {{ $company->address }}, {{ $company->city }}, {{ $company->country }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>