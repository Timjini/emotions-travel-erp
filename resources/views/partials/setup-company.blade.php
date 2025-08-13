<div x-data="{ showForm: false }">
    <!-- Initial Prompt -->
    <div x-show="!showForm" class="fixed inset-0 bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center p-4 z-50">
        <div class="max-w-md w-full bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-center">
                <svg class="w-16 h-16 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h2 class="mt-4 text-2xl font-bold text-white">Setup Your Company</h2>
                <p class="mt-2 text-blue-100">To continue using our platform, please set up your company profile</p>
            </div>
            
            <div class="p-8 text-center">
                <div class="mb-6">
                    <svg class="w-20 h-20 mx-auto text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                
                <h3 class="text-xl font-semibold text-gray-800">Company Profile Required</h3>
                <p class="mt-2 text-gray-600">Before you can access all features, we need some information about your company.</p>
                
                <div class="mt-8">
                    <button @click="showForm = true" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Company Profile
                    </button>
                </div>
                
                <div class="mt-4">
                    <form method="POST" action="{{ route('company.system.create-temporary') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            I'll do this later (create temporary company)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Company Form (hidden initially) -->
    <div x-show="showForm" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50 transition-opacity duration-300">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-screen overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900">Create Your Company</h3>
                <button @click="showForm = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="p-6">
                @include('company.system.create-company-form')
            </div>
            
        </div>
    </div>
</div>
