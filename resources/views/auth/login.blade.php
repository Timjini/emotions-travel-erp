<x-guest-layout>
    <!-- Session Status -->
    @if(session('status'))
        <div class="p-3 bg-[#4DA8DA]/10 text-[#4DA8DA] rounded-lg text-sm mb-4">
            {{ session('status') }}
        </div>
    @endif

    <div class="w-full max-w-md bg-white rounded-xl shadow-sm p-8 space-y-6">
        <!-- Logo/Header -->
        <div class="text-center">
            <h1 class="text-2xl font-bold text-[#333333]">Welcome Back</h1>
            <p class="text-[#666666] mt-1">Sign in to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Field -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-[#333333] mb-1" />
                <x-text-input id="email" class="w-full px-4 py-2 border border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:border-transparent transition" 
                             type="email" 
                             name="email" 
                             :value="old('email')" 
                             required 
                             autofocus 
                             autocomplete="username"
                             placeholder="your@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
            </div>

            <!-- Password Field -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-[#333333] mb-1" />
                <div class="relative">
                    <x-text-input id="password" class="w-full px-4 py-2 border border-[#E5E7EB] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:border-transparent transition"
                                  type="password"
                                  name="password"
                                  required
                                  autocomplete="current-password"
                                  placeholder="••••••••" />
                    <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-[#666666] hover:text-[#333333]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-[#E5E7EB] text-[#4DA8DA] focus:ring-[#4DA8DA]" name="remember">
                    <span class="ml-2 text-sm text-[#666666]">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-[#4DA8DA] hover:underline">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <x-primary-button class="w-full justify-center bg-[#4DA8DA] hover:bg-[#3a8cc4] text-white font-medium py-2 px-4 rounded-xl transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#4DA8DA] focus:ring-opacity-50">
                {{ __('Log in') }}
            </x-primary-button>
        </form>

    </div>
</x-guest-layout>