<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        <!-- Top Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Total Clients -->
            <div class="bg-white shadow rounded-lg p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                        <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Clients</p>
                        <p class="text-2xl font-bold">{{ $clientsCount ?? 0 }}</p>
                        <p class="text-green-500 text-sm font-medium">+12%</p>
                    </div>
                </div>
            </div>

            <!-- Active Suppliers -->
            <div class="bg-white shadow rounded-lg p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Active Suppliers</p>
                        <p class="text-2xl font-bold">{{ $suppliersCount ?? 0 }}</p>
                        <p class="text-green-500 text-sm font-medium">+5%</p>
                    </div>
                </div>
            </div>

            <!-- Reservations -->
            <div class="bg-white shadow rounded-lg p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Reservations</p>
                        <p class="text-2xl font-bold">{{ $reservationsCount ?? 0 }}</p>
                        <p class="text-green-500 text-sm font-medium">+18%</p>
                    </div>
                </div>
            </div>

            <!-- Revenue -->
            <div class="bg-white shadow rounded-lg p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 text-orange-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Revenue</p>
                        <p class="text-2xl font-bold">${{ number_format($revenue ?? 0) }}</p>
                        <p class="text-green-500 text-sm font-medium">+23%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities + Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Recent Activities -->
            <div class="bg-white shadow rounded-lg p-5">
                <h3 class="text-lg font-semibold mb-4">Recent Activities</h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <span class="h-2 w-2 bg-blue-500 rounded-full mt-2"></span>
                        <div class="ml-3">
                            <p class="font-medium">John Smith</p>
                            <p class="text-sm text-gray-500">New booking for Paris trip · 2 hours ago</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <span class="h-2 w-2 bg-blue-500 rounded-full mt-2"></span>
                        <div class="ml-3">
                            <p class="font-medium">Sarah Johnson</p>
                            <p class="text-sm text-gray-500">Payment received for Tokyo package · 4 hours ago</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg p-5">
                <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('files.create') }}" class="bg-blue-50 text-blue-500 rounded-lg p-4 font-medium hover:bg-blue-100">New Booking</a>
                    <a href="{{ route('customers.create') }}" class="bg-green-50 text-green-500 rounded-lg p-4 font-medium hover:bg-green-100">Add Client</a>
                    <a href="{{ route('suppliers.create') }}" class="bg-purple-50 text-purple-500 rounded-lg p-4 font-medium hover:bg-purple-100">Add Supplier</a>
                    <button class="bg-orange-50 text-orange-500 rounded-lg p-4 font-medium hover:bg-orange-100">Create Invoice</button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
