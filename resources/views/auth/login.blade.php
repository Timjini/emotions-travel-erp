<x-guest-layout>
    <!-- Session Status -->
    @if(session('status'))
        <div class="p-3 bg-[#4DA8DA]/10 text-[#4DA8DA] rounded-lg text-sm mb-4 text-center font-medium">
            {{ session('status') }}
        </div>
    @endif

    <div class="w-full max-w-md  rounded-2xl p-10 space-y-8 border border-gray-100">
        <!-- Logo/Header -->
        <div class="text-center">
            <div class="mx-auto  flex items-center justify-center ">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>
            <h1 class="text-2xl font-extrabold text-[#333333]">Welcome Back</h1>
            <p class="text-[#666666] mt-1 text-sm">Log in to continue to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6" x-data="{ loading: false }" @submit="loading = true">
            @csrf

            <!-- Email Field -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-[#333333] mb-1" />
                <x-text-input id="email" class="w-full px-4 py-3 border border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA]/80 focus:border-transparent transition placeholder:text-gray-400" 
                             type="email" 
                             name="email" 
                             :value="old('email')" 
                             required 
                             autofocus 
                             autocomplete="username"
                             placeholder="your@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-500" />
            </div>

            <!-- Password Field -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-[#333333] mb-1" />
                <div class="relative">
                    <x-text-input id="password" class="w-full px-4 py-3 border border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA]/80 focus:border-transparent transition placeholder:text-gray-400"
                                  type="password"
                                  name="password"
                                  required
                                  autocomplete="current-password"
                                  placeholder="••••••••" />
                    <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-[#999] hover:text-[#333] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-500" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center gap-2">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#4DA8DA] focus:ring-[#4DA8DA]">
                    <span class="text-sm text-[#666666]">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-[#4DA8DA] hover:underline">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-loading-button label="Login" customClass="w-full" />

        </form>
    </div>
</x-guest-layout>
