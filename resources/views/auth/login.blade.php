<x-guest-layout>
    <div class="max-w-[1280px] mx-auto mt-8 bg-[#212A33] rounded-[15px] p-8 md:p-12 shadow-lg">
        <h1 class="text-white text-4xl md:text-5xl font-bold font-montserrat text-center mb-6">Вход</h1>
        <p class="text-white text-lg md:text-xl font-lato text-center mb-10">Пожалуйста, введите логин и пароль</p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6 max-w-xl mx-auto">
            @csrf

            <!-- Login -->
            <div>
                <label for="login" class="block text-white font-medium font-lato mb-1">Логин</label>
                <x-text-input id="login" class="w-full rounded-md p-3 border border-gray-300 focus:ring-2 focus:ring-red-400" type="text" name="login" :value="old('login')" required autofocus autocomplete="login" />
                <x-input-error :messages="$errors->get('login')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-white font-medium font-lato mb-1">Пароль</label>
                <div class="relative">
                    <x-text-input id="password" class="w-full rounded-md p-3 border border-gray-300 pr-10 focus:ring-2 focus:ring-red-400" type="password" name="password" required autocomplete="current-password" />
                    <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-white">
                        <svg id="eye-icon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 
                                9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 
                                0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" class="rounded text-red-500 border-gray-300 shadow-sm focus:ring-red-400" name="remember">
                <label for="remember_me" class="ml-2 text-sm text-white font-lato">Запомнить меня</label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <a class="text-sm text-white underline hover:text-red-400 font-lato" href="{{ route('register') }}">
                    Регистрация
                </a>

                <a class="text-sm text-white underline hover:text-red-400 font-lato" href="{{ route('home') }}">
                    Вход без аккаунта
                </a>

                <x-primary-button class="bg-red-500 hover:bg-red-600 text-white py-2 px-5 rounded-[15px] font-semibold font-montserrat transition-all">
                    Войти
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            const input = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 
                1.274-4.057 5.064-7 9.542-7 1.052 0 2.065.165 3.015.468M15 12a3 
                3 0 11-6 0 3 3 0 016 0z" />`;
            } else {
                input.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 
                3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 
                9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 
                0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
</x-guest-layout>