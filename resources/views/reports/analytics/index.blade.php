<x-app-layout>

    <!-- Breadcrumbs -->
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li>
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li class="text-gray-800 font-medium">Statistics</li>
        </ol>
    </nav>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
 <!-- Quick Stats Cards -->
 <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 ">
    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Bookings</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_bookings'] }}</p>
            </div>
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Confirmed</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['confirmed_bookings'] }}</p>
            </div>
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pending</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_bookings'] }}</p>
            </div>
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-lg shadow border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Cancelled</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['cancelled_bookings'] }}</p>
            </div>
            <div class="p-3 rounded-full bg-red-100 text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Financial Summary -->
<div class="bg-white p-6 rounded-lg shadow mb-6 ">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-900">Financial Overview</h2>
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-500">Currency:</span>
            <select id="currency-selector" class="text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <option value="base">Base Currency ({{ config('app.currency') }})</option>
                <option value="original">Original Currencies</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="border rounded-lg p-4">
            <p class="text-sm font-medium text-gray-500">Total Billed</p>
            <p class="text-2xl font-semibold">{{ number_format($financials['total_billed'], 2) }} {{$financials['company_currency']}}</p>
        </div>

        <div class="border rounded-lg p-4">
            <p class="text-sm font-medium text-gray-500">Total Costs</p>
            <p class="text-2xl font-semibold">{{ number_format($financials['total_costs'], 2) }} {{$financials['company_currency']}}</p>
        </div>

        <div class="border rounded-lg p-4">
            <p class="text-sm font-medium text-gray-500">Gross Profit</p>
            <p class="text-2xl font-semibold {{ $financials['profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ number_format($financials['profit'], 2) }} {{$financials['company_currency']}}
            </p>
        </div>

        <div class="border rounded-lg p-4">
            <p class="text-sm font-medium text-gray-500">Profit Margin</p>
            <p class="text-2xl font-semibold {{ $financials['profit_margin'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ number_format($financials['profit_margin'], 2) }}%
            </p>
        </div>
    </div>

    <!-- Cost Breakdown Chart -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg border flex items-center justify-center h-64">
            <span class="text-gray-400 text-lg font-semibold">Cost Breakdown Graph Coming Soon</span>
        </div>
        <div class="bg-white p-6 rounded-lg border flex items-center justify-center h-64">
            <span class="text-gray-400 text-lg font-semibold">Payment Status Graph Coming Soon</span>
        </div>
    </div>
    
    <div class="mt-6 hidden">
        <h3 class="text-md font-medium text-gray-700 mb-3">Cost Breakdown</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-4 rounded-lg border">
                <canvas id="costBreakdownChart" height="250"></canvas>
            </div>
            <div class="bg-white p-4 rounded-lg border">
                <canvas id="paymentStatusChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>
</div>
</x-app-layout>