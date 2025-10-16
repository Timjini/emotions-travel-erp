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
    </head>
    <body class="font-sans text-gray-900 antialiased">
        @if(session('success'))
        <x-flash type="success"
            :title="session('success-title', 'Success')"
            :message="session('success')" />
        @endif
    
        @if(session('error'))
        <x-flash type="error"
            :title="session('error-title', 'Error')"
            :message="session('error')" />
        @endif
        
        @if ($errors->any())
        <x-flash type="error"
            title="Validation Error"
            :message="$errors->all()" />
        @endif
        <div class="flex items-center justify-center h-screen bg-gradient-to-br from-white via-[#f5f7fa] to-[#e6ecf5] relative overflow-hidden">
            <!-- Futuristic subtle elements -->
            <div class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-r from-[#c4d7ff]/40 to-[#ffffff]/0 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-32 w-96 h-96 bg-gradient-to-l from-[#d4f1ff]/50 to-[#ffffff]/0 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_120%,rgba(255,255,255,0.2),transparent_70%)]"></div>
            <div class="z-10 w-full sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

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
