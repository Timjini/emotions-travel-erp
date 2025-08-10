<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight">
            {{ __('User Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    @if (session('success'))
                        <x-alert type="success" :message="session('success')" />
                    @endif

                    <form method="POST" action="{{ route('user-settings.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Language -->
                            <div>
                                <x-input-label for="language" :value="__('Language')" />
                                <select id="language" name="language" class="mt-1 block w-full">
                                    @foreach ($languages as $code => $name)
                                        <option value="{{ $code }}" @selected($settings->language === $code)>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('language')" class="mt-2" />
                            </div>

                            <!-- Timezone -->
                            <div>
                                <x-input-label for="timezone" :value="__('Timezone')" />
                                <select id="timezone" name="timezone" class="mt-1 block w-full">
                                    @foreach ($timezones as $tz)
                                        <option value="{{ $tz }}" @selected($settings->timezone === $tz)>
                                            {{ $tz }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('timezone')" class="mt-2" />
                            </div>

                            <!-- Theme -->
                            <div>
                                <x-input-label :value="__('Theme')" />
                                <div class="mt-2 space-y-2">
                                    @foreach ($themes as $value => $label)
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="theme" value="{{ $value }}" 
                                                @checked($settings->theme === $value)>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Notifications -->
                            <div class="flex items-start gap-2">
                                <input type="checkbox" id="email_notifications" name="email_notifications"
                                    @checked($settings->email_notifications)>
                                <div>
                                    <x-input-label for="email_notifications" :value="__('Email Notifications')" />
                                    <p class="text-sm text-gray-500 ">
                                        {{ __('Receive important updates via email') }}
                                    </p>
                                </div>
                            </div>

                            <x-primary-button class="w-full justify-center">
                                {{ __('Save Settings') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>