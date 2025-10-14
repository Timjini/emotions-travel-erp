<x-app-layout>
    
    <div class="py-12">
        <div class="mb-2">
        <x-bread-crumb title="Company Settings" />
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($company)
                <!-- Company Information Card -->
                <x-company.company-info-card :company="$company" />

                <!-- System Settings Card -->
                <x-company.system-settings-card :settings="$settings" />

                <!-- Company Users Card -->
                <x-company.company-users-card :users="$users" />

            @else
                <!-- No company yet -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-medium mb-4">Welcome!</h3>
                    <p class="text-gray-700 mb-6">
                        You don’t have a company setup yet. Please create your company to start managing users and system settings.
                    </p>
                    <x-link-button :href="route('company.system.create')">
                        Create Company
                    </x-link-button>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
