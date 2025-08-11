<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Alpine Core + Plugins (load in proper order) -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.8/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.14.8/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>


    <script>
        document.addEventListener('alpine:init', () => {
            // Alpine.plugin(Collapse);
            // Alpine.plugin(Focus);
        });
    </script>

    <script src="/js/app.js"></script>
    @livewireStyles
</head>

<body class="font-sans antialiased">
    @if(session('success'))
    <x-flash type="success"
        :title="session('success-title', 'Success')"
        :message="session('success')" />
    @endif

    @if ($errors->any())
    <x-flash type="error"
        title="Validation Error"
        :message="$errors->all()" />
    @endif



    <div class="flex flex-col md:flex-row h-screen">
        @include('layouts.navigation')
        <div class="flex-1 p-4 overflow-auto bg-gray-100">
            <!-- Page Heading -->
            @isset($header)
            <header class="mt-4 p-1">
                <div class="max-w-3xl sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('closeModal', () => {
            // This will close any modal by resetting the selectedItemId
            Livewire.emit('resetSelectedItemId');
        });
        
        Livewire.on('costAdded', () => {
            // Refresh the items table
            Livewire.emit('refresh');
        });
    });
</script>
    @livewire('livewire-ui-modal')

</body>

</html>