<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            {{ __('Supplier Details') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header with actions -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $supplier->name }}</h1>
                    <x-supplier.status-chip :status="$supplier->status" />
                    <x-supplier.type-chip :type="$supplier->type" />
                </div>
                
                <div class="flex space-x-3">
                    <x-link-button :href="route('suppliers.edit', $supplier)" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        {{ __('Edit') }}
                    </x-link-button>
                    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-supplier-deletion')" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Delete') }}
                    </x-danger-button>
                </div>
            </div>

            <!-- Main content -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Tabs navigation -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button x-data="{ activeTab: 'overview' }" @click="activeTab = 'overview'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'overview', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'overview' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Overview
                            </button>
                            <button x-data="{ activeTab: 'overview' }" @click="activeTab = 'financial'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'financial', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'financial' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Financial
                            </button>
                            <button x-data="{ activeTab: 'overview' }" @click="activeTab = 'activity'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'activity', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'activity' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Activity
                            </button>
                        </nav>
                    </div>

                    <!-- Overview Tab Content -->
                    <div x-show="activeTab === 'overview'" class="space-y-6">
                        <!-- Contact Information Card -->
                        <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                    Contact Information
                                </h2>
                                <!-- <button class="text-blue-500 text-sm font-medium">Edit</button> -->
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Primary Contact</h3>
                                    <div class="space-y-2">
                                        <p class="text-gray-900">{{ $supplier->contact_person ?? 'Not specified' }}</p>
                                        <p class="text-gray-900">{{ $supplier->email ?? 'No email' }}</p>
                                        <div class="flex space-x-2">
                                            @if($supplier->phone_1)
                                                <x-supplier.phone-chip :phone="$supplier->phone_1" label="Primary" />
                                            @endif
                                            @if($supplier->phone_2)
                                                <x-supplier.phone-chip :phone="$supplier->phone_2" label="Secondary" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Website</h3>
                                    @if($supplier->website)
                                        <a href="{{ $supplier->website }}" target="_blank" class="text-blue-500 hover:underline flex items-center">
                                            {{ parse_url($supplier->website, PHP_URL_HOST) }}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    @else
                                        <p class="text-gray-500">No website</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Address Information Card -->
                        <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    Address Information
                                </h2>
                                <!-- <button class="text-blue-500 text-sm font-medium">Edit</button> -->
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Physical Address</h3>
                                    <address class="not-italic text-gray-900">
                                        {{ $supplier->address }}<br>
                                        {{ $supplier->post_code }} {{ $supplier->city }}<br>
                                        @if($supplier->district){{ $supplier->district }}, @endif{{ $supplier->country }}
                                    </address>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Invoicing Entity</h3>
                                    <p class="text-gray-900">{{ $supplier->invoicing_entity }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Business Information Card -->
                        <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 010-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                                    </svg>
                                    Business Information
                                </h2>
                                <!-- <button class="text-blue-500 text-sm font-medium">Edit</button> -->
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">VAT Number</h3>
                                    <p class="text-gray-900">{{ $supplier->vat_number ?? 'Not provided' }}</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Category</h3>
                                    @if($supplier->category)
                                        <x-supplier.category-chip :category="$supplier->category" />
                                    @else
                                        <p class="text-gray-500">Not categorized</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Preferred Language</h3>
                                    <x-supplier.language-chip :language="$supplier->preferred_language" />
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Source</h3>
                                    @if($supplier->source)
                                        <x-supplier.source-chip :source="$supplier->source" />
                                    @else
                                        <p class="text-gray-500">Unknown</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Tab Content -->
                    <div x-show="activeTab === 'financial'" class="space-y-6">
                        <!-- Bank Information Card -->
                        <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                    </svg>
                                    Bank Information
                                </h2>
                                <!-- <button class="text-blue-500 text-sm font-medium">Edit</button> -->
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">IBAN</h3>
                                    @if($supplier->iban)
                                        <div class="flex items-center">
                                            <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $supplier->iban }}</span>
                                            <button class="ml-2 text-blue-500 hover:text-blue-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                                                    <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                                                </svg>
                                            </button>
                                        </div>
                                    @else
                                        <p class="text-gray-500">Not provided</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">SWIFT/BIC Code</h3>
                                    @if($supplier->swift_code)
                                        <p class="font-mono bg-gray-100 px-2 py-1 rounded inline-block">{{ $supplier->swift_code }}</p>
                                    @else
                                        <p class="text-gray-500">Not provided</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Tab Content -->
                    <div x-show="activeTab === 'activity'" class="space-y-6">
                        <!-- System Information Card -->
                        <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                    </svg>
                                    System Information
                                </h2>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Created By</h3>
                                    <p class="text-gray-900">{{ $supplier->createdBy->name ?? 'System' }}</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Created At</h3>
                                    <p class="text-gray-900">{{ $supplier->created_at->format('M d, Y H:i') }}</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 mb-1">Last Updated</h3>
                                    <p class="text-gray-900">{{ $supplier->updated_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Notes Card -->
                        @if($supplier->notes)
                        <div class="bg-gray-50 rounded-lg p-6 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z" />
                                        <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                                    </svg>
                                    Notes
                                </h2>
                                <!-- <button class="text-blue-500 text-sm font-medium">Edit</button> -->
                            </div>
                            
                            <div class="prose max-w-none">
                                {!! nl2br(e($supplier->notes)) !!}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete supplier Confirmation Modal -->
    <x-modal name="confirm-supplier-deletion" :show="$errors->supplierDeletion->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete this supplier?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('This action cannot be undone. All related data will be permanently removed.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete Supplier') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>