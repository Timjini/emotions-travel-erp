<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('User Settings') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Manage your personal information, update your email or password, and customize your account preferences to suit your needs.') }}
        </p>
    </header>

    <x-link-button :href="route('user-settings.show')">
        {{ __('Open User Settings') }}
    </x-link-button>
</section>
