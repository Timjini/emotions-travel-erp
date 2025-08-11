<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800  leading-tight">
                {{ __('User Settings') }}
            </h2>
            <x-secondary-link :href="route('profiles.edit')">
                {{ __('Back to Profile') }}
            </x-secondary-link>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if (session('status') === 'settings-updated')
                <div class="mb-6 p-4 bg-green-100 text-green-800  rounded-lg">
                    {{ __('Settings saved successfully!') }}
                </div>
            @endif

            <div class="bg-white  shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('user-settings.update') }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Language Selection -->
                        <div>
                            <x-input-label for="language" :value="__('Language Preference')" />
                            <select id="language" name="language" required
                                class="mt-1 block w-full rounded-md border-gray-300  shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach ($languages as $code => $name)
                                    <option value="{{ $code }}" 
                                        @selected(old('language', $settings->language) === $code)
                                        @class([
                                            'bg-gray-100 ' => old('language', $settings->language) === $code
                                        ])>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('language')" class="mt-2" />
                        </div>

                        <!-- Timezone Selection -->
                        <div>
                            <x-input-label for="timezone" :value="__('Timezone')" />
                            <select id="timezone" name="timezone" required
                                class="mt-1 block w-full rounded-md border-gray-300  shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach ($timezones as $tz)
                                    <option value="{{ $tz }}" 
                                        @selected(old('timezone', $settings->timezone) === $tz)
                                        @class([
                                            'bg-gray-100 ' => old('timezone', $settings->timezone) === $tz
                                        ])>
                                        {{ $tz }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('timezone')" class="mt-2" />
                        </div>

                        <!-- Theme Selection -->
                        <div>
                            <x-input-label :value="__('Theme Preference')" />
                            <div class="mt-2 grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach ($themes as $value => $label)
                                    <label class="flex items-center p-3 rounded-lg border cursor-pointer transition-colors
                                        @if(old('theme', $settings->theme) === $value) 
                                            border-indigo-500 bg-indigo-50 
                                        @else 
                                            border-gray-300 hover:bg-gray-50 
                                        @endif">
                                        <input type="radio" name="theme" value="{{ $value }}" 
                                            @checked(old('theme', $settings->theme) === $value)
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-3 block text-sm font-medium ">
                                            {{ $label }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('theme')" class="mt-2" />
                        </div>

                        <!-- Email Notifications -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="email_notifications" name="email_notifications" type="checkbox"
                                    @checked(old('email_notifications', $settings->email_notifications))
                                    class="rounded border-gray-300  text-indigo-600 shadow-sm focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="email_notifications" class="font-medium text-gray-700 ">
                                    {{ __('Email Notifications') }}
                                </label>
                                <p class="text-gray-500  mt-1">
                                    {{ __('Receive email alerts for important account activities') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4">
                            <x-secondary-button type="button" onclick="window.location.reload()">
                                {{ __('Reset Changes') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Save Settings') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>