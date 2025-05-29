<x-guest-layout>

    <div class="max-w-md w-full space-y-8 bg-gray-800 p-8 rounded-2xl shadow-lg">
        <h2 class="mt-2 text-center text-3xl font-extrabold text-white">Регистрация</h2>

        <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
            @csrf

            <!-- Имя -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300">Имя</label>
                <input id="name" name="name" type="text" required autofocus value="{{ old('name') }}"
                    class="appearance-none rounded-md relative block w-full px-3 py-2 bg-gray-700 border border-gray-600 placeholder-gray-400 text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500 text-sm" />
            </div>

            <!-- Фамилия -->
            <div>
                <label for="surname" class="block text-sm font-medium text-gray-300">Фамилия</label>
                <input id="surname" name="surname" type="text" required value="{{ old('surname') }}"
                    class="appearance-none rounded-md relative block w-full px-3 py-2 bg-gray-700 border border-gray-600 placeholder-gray-400 text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                <x-input-error :messages="$errors->get('surname')" class="mt-1 text-red-500 text-sm" />
            </div>

            <!-- Логин -->
            <div>
                <label for="login" class="block text-sm font-medium text-gray-300">Логин</label>
                <input id="login" name="login" type="text" required value="{{ old('login') }}"
                    class="appearance-none rounded-md relative block w-full px-3 py-2 bg-gray-700 border border-gray-600 placeholder-gray-400 text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                <x-input-error :messages="$errors->get('login')" class="mt-1 text-red-500 text-sm" />
            </div>

            <!-- Почта -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Почта</label>
                <input id="email" name="email" type="email" required value="{{ old('email') }}"
                    class="appearance-none rounded-md relative block w-full px-3 py-2 bg-gray-700 border border-gray-600 placeholder-gray-400 text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-sm" />
            </div>

            <!-- Пароль -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">Пароль</label>
                <div class="relative">
                    <input id="password" name="password" type="password" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 pr-10 bg-gray-700 border border-gray-600 placeholder-gray-400 text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-gray-400 hover:text-white"
                        onclick="togglePasswordVisibility('password', 'eye-icon')">
                        <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Подтверждение пароля -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Подтверждение пароля</label>
                <div class="relative">
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 pr-10 bg-gray-700 border border-gray-600 placeholder-gray-400 text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-gray-400 hover:text-white"
                        onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-confirm')">
                        <svg id="eye-icon-confirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Кнопки -->
            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-white underline">Уже есть аккаунт?</a>

                <button type="submit"
                    class="ml-4 group relative w-auto flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Зарегистрироваться
                </button>
            </div>
        </form>
    </div>


    <!-- Скрипт "показать/скрыть пароль" -->
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l18 18" />`;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
</x-guest-layout>