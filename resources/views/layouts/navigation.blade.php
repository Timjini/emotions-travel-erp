<div class="z-10 hidden md:flex md:flex-shrink-0">
    <!-- Desktop Sidebar -->
    <div class="relative flex flex-col w-64 border-r border-gray-200 bg-gradient-to-b from-[#f5f5f5] via-[#f7f9fb] to-[#e9eff6] overflow-hidden">
        <!-- Subtle futuristic glow elements -->
        <div class="absolute top-10 -left-10 w-40 h-40 bg-gradient-to-tr from-[#c4d7ff]/40 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 -right-10 w-48 h-48 bg-gradient-to-bl from-[#d4f1ff]/50 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_120%,rgba(255,255,255,0.3),transparent_70%)]"></div>
        <!-- Logo -->
        <div class="grid grid-cols-2 items-center h-16 px-4 border-b border-gray-200">
            <a href="{{ route('dashboard') }}" class="flex items-center z-10">
                <img 
                    src="/public{{ $company && $company->logo_path ? Storage::url($company->logo_path) : 'https://pub-56989421c96a4a83a6c1e963a31939e6.r2.dev/emotions-travel/emotions-travel-and-events-logo.jpeg' }}"
                    alt="Logo"
                    class="p-2 rounded-full h-16 w-auto mx-auto md:mx-0"
                />

            </a>
            <span class="truncate"> {{$company->name ?? ''}} </span>
        </div>
        
        <!-- Navigation Menu -->
        <div class="z-10 flex flex-col flex-grow px-4 py-4 overflow-y-auto">
            <nav class="flex flex-col space-y-6 text-gray-800">
                @foreach(config('navigation.sections') as $section)
                <div class="space-y-2" x-data="{ open: true }">
                    <button 
                        @click="open = !open"
                        class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-700 focus:outline-none focus:ring focus:ring-blue-200 rounded-lg transition"
                    >
                        <span class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                            </svg>

                            
                            <span>{{ __('messages.' . $section['title']) }}</span>
                        </span>
                        <svg 
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 ml-2 text-gray-400 transition-transform duration-200" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke="currentColor"
                            :class="{ 'transform rotate-90': open }"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
            
                    <div x-show="open" x-collapse class="ml-4 border-l border-gray-200 pl-4 space-y-1">
                        @foreach($section['items'] as $item)
                        <x-nav-link 
                            :href="route($item['route'])" 
                            :active="request()->routeIs($item['route'].'*')" 
                            class="w-full flex items-center px-2 py-2 text-sm font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50 transition group"
                        >
                            <x-dynamic-icon :name="$item['icon']" class="w-5 h-5 mr-3 text-gray-400" />
                            <span class="ml-3 capitalize">
                                {{ __('messages.' . $item['name']) }}
                            </span>
                        </x-nav-link>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </nav>

            
            <!-- User & Logout -->
            <div class="mt-auto pt-4 border-t border-gray-200">
                <a href="{{route('profiles.edit')}}" class="flex items-center px-2">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 rounded-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.22 0-4 1.78-4 4s1.78 4 4 4 4-1.78 4-4-1.78-4-4-4zm0 6c-1.11 0-2-.89-2-2s.89-2 2-2 2 .89 2 2-.89 2-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                        <p class="text-xs font-medium text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 group">
                        <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Navigation -->
<div class="md:hidden z-10">
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-200 ">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <button @click="open = !open" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="ml-4">
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <img 
                             class="p-2 rounded-full h-16 w-auto mx-auto md:mx-0"
                                                src="/public{{ $company && $company->logo_path ? Storage::url($company->logo_path) : 'https://pub-56989421c96a4a83a6c1e963a31939e6.r2.dev/emotions-travel/emotions-travel-and-events-logo.jpeg' }}"
                            />
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <!-- Mobile profile dropdown -->
                    <div class="ml-4 relative" x-data="{ open: false }">
                        <button @click="open = !open" class="max-w-xs flex items-center text-sm rounded-full focus:outline-none">
                            <span class="sr-only">Open user menu</span>
                            <svg class="h-8 w-8 rounded-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.22 0-4 1.78-4 4s1.78 4 4 4 4-1.78 4-4-1.78-4-4-4zm0 6c-1.11 0-2-.89-2-2s.89-2 2-2 2 .89 2 2-.89 2-2 2z" />
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="{{ route('profiles.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div x-show="open" class="relative md:hidden w-screen h-[100vh]">
            <div class="pt-2 pb-3 space-y-1">
                @foreach(config('navigation.sections') as $section)
                <div class="px-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        {{ $section['title'] }}
                    </h3>
                    
                    <div class="mt-1 space-y-1">
                        @foreach($section['items'] as $item)
                        <x-responsive-nav-link 
                            :href="route($item['route'])" 
                            :active="request()->routeIs($item['route'].'*')" 
                            class="flex items-center px-3 py-2 text-base font-medium"
                        >
                            <x-dynamic-icon :name="$item['icon']" class="w-5 h-5 mr-3 text-gray-400" />
                            {{ $item['name'] }}
                        </x-responsive-nav-link>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="pt-4 pb-3 border-t border-gray-200">
                <a href="{{route('profiles.edit')}}" class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 rounded-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.22 0-4 1.78-4 4s1.78 4 4 4 4-1.78 4-4-1.78-4-4-4zm0 6c-1.11 0-2-.89-2-2s.89-2 2-2 2 .89 2 2-.89 2-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </a>
                
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profiles.edit')" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</div>