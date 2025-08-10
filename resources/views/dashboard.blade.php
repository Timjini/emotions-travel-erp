<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">

            <!-- Users Card -->
            <div class="bg-white  overflow-hidden shadow rounded-lg p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M7 21v-2a4 4 0 0 1 3-3.87"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-700 ">Users</h3>
                        <p class="text-3xl font-bold text-gray-900 ">{{ $usersCount ?? '0' }}</p>
                    </div>
                </div>
            </div>

            <!-- Customers Card -->
            <div class="bg-white  overflow-hidden shadow rounded-lg p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M16 11c1.66 0 3-1.34 3-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3z"></path>
                            <path d="M12 14c-3 0-6 1.5-6 4.5V21h12v-2.5c0-3-3-4.5-6-4.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-700 ">Customers</h3>
                        <p class="text-3xl font-bold text-gray-900 ">{{ $customersCount ?? '0' }}</p>
                    </div>
                </div>
            </div>

            <!-- Bookings Card -->
            <div class="bg-white  overflow-hidden shadow rounded-lg p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M3 7h18"></path>
                            <path d="M3 12h18"></path>
                            <path d="M3 17h18"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-700 ">Bookings</h3>
                        <p class="text-3xl font-bold text-gray-900 ">—</p>
                    </div>
                </div>
            </div>

            <!-- Revenue Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-red-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M12 8c-3 0-5 1.5-5 4.5s2 4.5 5 4.5 5-1.5 5-4.5-2-4.5-5-4.5z"></path>
                            <path d="M12 4v4"></path>
                            <path d="M12 16v4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-700 ">Revenue</h3>
                        <p class="text-3xl font-bold text-gray-900 ">—</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
