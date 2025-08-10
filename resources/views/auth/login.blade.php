<x-guest-layout>
    <!-- Session Status -->
    @if(session('status'))
        <div class="p-3 bg-[#4DA8DA]/10 text-[#4DA8DA] rounded-lg text-sm mb-4">
            {{ session('status') }}
        </div>
    @endif

    <div class="w-full max-w-md bg-white rounded-xl shadow-sm p-8 space-y-6">
        <!-- Language Toggle (Top-right) -->
        <div class="flex justify-end">
            <div class="relative">
                <select class="appearance-none bg-transparent pl-2 pr-8 py-1 text-sm text-[#333333] border border-[#F7F9FA] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4DA8DA]">
                    <option value="en" data-flag="🇬🇧">English</option>
                    <option value="pl" data-flag="🇪🇸">Polska</option>
                </select>
                <div class="absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </div>
            </div>
        </div>

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

        <!-- Social Login or Sign Up -->
        <div class="text-center text-sm text-[#666666]">
            <p>Or continue with</p>
            <div class="flex justify-center space-x-4 mt-3">
                <button class="p-2 border border-[#E5E7EB] rounded-xl hover:bg-[#F7F9FA] transition">
                    <svg class="w-5 h-5" fill="#333333" viewBox="0 0 24 24">
                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/>
                    </svg>
                </button>
                <button class="p-2 border border-[#E5E7EB] rounded-xl hover:bg-[#F7F9FA] transition">
                    <svg class="w-5 h-5" fill="#333333" viewBox="0 0 24 24">
                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/>
                    </svg>
                </button>
                <button class="p-2 border border-[#E5E7EB] rounded-xl hover:bg-[#F7F9FA] transition">
                    <svg class="w-5 h-5" fill="#333333" viewBox="0 0 24 24">
                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Sign Up Link -->
        <div class="text-center text-sm text-[#666666]">
            Don't have an account? <a href="#" class="text-[#4DA8DA] hover:underline">Sign up</a>
        </div>
    </div>
</x-guest-layout>