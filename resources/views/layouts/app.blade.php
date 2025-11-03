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
    <!--<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.8/dist/cdn.min.js"></script>-->
    <!--<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.14.8/dist/cdn.min.js"></script>-->
    <!--<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>-->

    <script src="/js/app.js"></script>
    @livewireStyles
</head>

<body class="font-sans antialiased">

@if(Auth::check() && is_null(Auth::user()->company_id))
@include('partials.setup-company')
@endif
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



    <div class="flex flex-col md:flex-row h-screen bg-gradient-to-br from-white via-[#BEC2CB] to-[#f5f5f5] relative overflow-hidden">
            <div class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-r from-[#c4d7ff]/40 to-[#ffffff]/0 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-32 w-96 h-96 bg-gradient-to-l from-[#d4f1ff]/50 to-[#ffffff]/0 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_120%,rgba(255,255,255,0.2),transparent_70%)]"></div>
        @include('layouts.navigation')
        <div class="z-10 flex-1 p-4 overflow-auto">
            @isset($header)
            <header class="mt-4 p-1">
                <div class="max-w-3xl sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('closeModal', () => {
            Livewire.emit('resetSelectedItemId');
        });
        
        Livewire.on('costAdded', () => {
            Livewire.emit('refresh');
        });
    });

</script>
    @livewire('livewire-ui-modal')

</body>

</html>