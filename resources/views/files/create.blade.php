<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Create New File
        </h2>
    </x-slot>

    <nav class="max-w-3xl sm:px-6 lg:px-8" aria-label="Breadcrumb">  
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li>
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <a href="{{ route('files.index') }}" class="hover:text-blue-600">Files</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li class="text-gray-800 font-medium">Create</li>
        </ol>
    </nav>

    <div class="max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <form method="POST" action="{{ route('files.store') }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">File Information</h3>
                </div>
                
                <div class="px-6 py-4 space-y-4">
                    <!-- Customer -->
                    <div>
                        <x-input-label for="customer_id" :value="__('Customer')" />
                        <select id="customer_id" name="customer_id" class="rounded bg-gray-50 border text-gray-900  flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full" required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('customer_id')" />
                    </div>
                    
                    <!-- Number of People -->
                    <div>
                        <x-input-label for="number_of_people" :value="__('Number of People')" />
                        <x-text-input id="number_of_people" name="number_of_people" type="text" class="mt-1 block w-full" 
                            :value="old('number_of_people')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('number_of_people')" />
                    </div>
                    
                    <!-- Date Range -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="start_date" :value="__('Start Date')" />
                            <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" 
                                :value="old('start_date')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                        </div>
                        <div>
                            <x-input-label for="end_date" :value="__('End Date')" />
                            <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" 
                                :value="old('end_date')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
                        </div>
                    </div>
                    
                    <!-- Relationships -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Program -->
                        <div>
                            <x-input-label for="program_id" :value="__('Program')" />
                            <select id="program_id" name="program_id" class="rounded bg-gray-50 border text-gray-900  flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full">
                                <option value="">Select Program</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                        {{ $program->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('program_id')" />
                        </div>
                        
                        <!-- Destination -->
                        <div>
                            <x-input-label for="destination_id" :value="__('Destination')" />
                            <select id="destination_id" name="destination_id" class="rounded bg-gray-50 border text-gray-900  flex-1 min-w-0 text-sm border-gray-300 p-2.5 mt-1 block w-full">
                                <option value="">Select Destination</option>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->id }}" {{ old('destination_id') == $destination->id ? 'selected' : '' }}>
                                        {{ $destination->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('destination_id')" />
                        </div>
                        
                        <!-- Currency -->
                       <x-currency-select 
                                :currencies="$currencies" 
                            />
                    </div>
                    
                    <!-- Guide -->
                    <div>
                        <x-input-label for="guide" :value="__('Guide')" />
                        <x-text-input id="guide" name="guide" type="text" class="mt-1 block w-full" 
                            :value="old('guide')" />
                        <x-input-error class="mt-2" :messages="$errors->get('guide')" />
                    </div>
                    
                    <!-- Note -->
                    <div>
                        <x-input-label for="note" :value="__('Notes')" />
                         <x-text-area 
                                id="notes" 
                                name="notes" 
                                class="mt-1 block w-full" 
                                rows="3"
                            >{{ old('note') }}</x-text-area>
                        <x-input-error class="mt-2" :messages="$errors->get('note')" />
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <x-secondary-button class="mr-2" onclick="window.location='/files'">
                        Cancel
                    </x-secondary-button>
                    <x-loading-button label="Create File" />
                </div>
            </form>
        </div>
    </div>
</x-app-layout>