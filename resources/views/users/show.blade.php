<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    <div class="flex items-center space-x-4 mb-6">
                        <!--<div class="flex-shrink-0">-->
                        <!--    <img class="h-16 w-16 rounded-full" -->
                        <!--         src="{{ $user->profile_photo_url }}" -->
                        <!--         alt="{{ $user->name }}">-->
                        <!--</div>-->
                        <div>
                            <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                            <p class="text-gray-600 ">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Info Section -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium">{{ __('Basic Information') }}</h3>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('Name') }}</p>
                                    <p>{{ $user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('Email') }}</p>
                                    <p>{{ $user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('Account Created') }}</p>
                                    <p>{{ $user->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Settings Section -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium">{{ __('User Settings') }}</h3>
                            @if($userSettings)
                                <div class="space-y-2">
                                    <div>
                                        <p class="text-sm text-gray-500">{{ __('Language') }}</p>
                                        <p>{{ $userSettings->language }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">{{ __('Timezone') }}</p>
                                        <p>{{ $userSettings->timezone }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">{{ __('Theme Preference') }}</p>
                                        <p>{{ ucfirst($userSettings->theme) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">{{ __('Email Notifications') }}</p>
                                        <p>{{ $userSettings->email_notifications ? 'Enabled' : 'Disabled' }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-500 ">{{ __('No settings found') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-2">
                        <x-link-button :href="route('users.index')">
                            {{ __('Back to Users') }}
                        </x-link-button>
                        @can('update', $user)
                            <x-primary-button :href="route('users.edit', $user)">
                                {{ __('Edit User') }}
                            </x-primary-button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>