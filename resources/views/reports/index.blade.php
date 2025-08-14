<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            {{ __('Basic Reports') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <!-- Filter Section -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium mb-4">Filter</h3>
            <form id="reportFilterForm" method="POST" action="{{ route('reports.generate') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Date Range -->
                    <div>
                        <x-input-label for="start_date" :value="__('Start Date')" />
                        <x-text-input id="start_date" name="start_date" type="date" 
                            class="mt-1 block w-full" value="{{ old('start_date') }}" />
                    </div>
                    <div>
                        <x-input-label for="end_date" :value="__('End Date')" />
                        <x-text-input id="end_date" name="end_date" type="date" 
                            class="mt-1 block w-full" value="{{ old('end_date') }}" />
                    </div>
                    
                    <!-- Document Type -->
                    <div>
                        <x-input-label for="document_type" :value="__('Document Type')" />
                        <select id="document_type" name="document_type" 
                            class="rounded bg-gray-50 border text-gray-900  block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 w-full px-4 py-2 border border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:border-transparent transition mt-1 block w-full">
                            <option value="">All Types</option>
                            <option value="file" @selected(old('document_type') == 'file')>File</option>
                            <option value="invoice" @selected(old('document_type') == 'invoice')>Invoice</option>
                            <option value="proforma" @selected(old('document_type') == 'proforma')>Proforma</option>
                        </select>
                    </div>
                    
                    <!-- Order By -->
                    <div>
                        <x-input-label for="order_by" :value="__('Order By')" />
                        <select id="order_by" name="order_by" 
                            class="rounded bg-gray-50 border text-gray-900  block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 w-full px-4 py-2 border border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:border-transparent transition mt-1 block w-full">
                            <option value="date_asc" @selected(old('order_by') == 'date_asc')>Date (Oldest First)</option>
                            <option value="date_desc" @selected(old('order_by') == 'date_desc')>Date (Newest First)</option>
                            <option value="amount_asc" @selected(old('order_by') == 'amount_asc')>Amount (Low to High)</option>
                            <option value="amount_desc" @selected(old('order_by') == 'amount_desc')>Amount (High to Low)</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button type="button" onclick="resetFilters()">
                        Reset Filters
                    </x-secondary-button>
                    <x-primary-button type="submit">
                        Generate Report
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Report Results -->
        <div id="reportResults" class="overflow-x-auto bg-white shadow rounded-lg">
            <!-- Table will be loaded via AJAX -->
            @include('reports._table', ['reportData' => $initialReportData ?? []])
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('reportFilterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            fetchReportData();
        });

        function fetchReportData() {
            const form = document.getElementById('reportFilterForm');
            const formData = new FormData(form);
            
            fetch("{{ route('reports.generate') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('reportResults').innerHTML = html;
            })
            .catch(error => console.error('Error:', error));
        }

        function resetFilters() {
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
            document.getElementById('document_type').value = '';
            document.getElementById('order_by').value = 'date_desc';
            fetchReportData();
        }

        // Load initial data
        document.addEventListener('DOMContentLoaded', function() {
            fetchReportData();
        });
    </script>
    @endpush
</x-app-layout>