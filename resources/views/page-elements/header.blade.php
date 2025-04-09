<header class="header">
    <div class="container">
        <!-- Логотип -->
        <div class="logo">
            <a href="{{ route('home') }}"><img src="{{ asset('img/header/logo.png') }}" alt="Логотип" class="logo-img"></a>
            <div class="logo-text">А ПЛЮС</div>
        </div>

        <!-- Бургерное меню (видно только на мобильных) -->
        <button id="burger-menu" class="burger-menu">
            <svg class="burger-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <!-- Правая часть шапки -->
        <div class="header-right">
            <!-- Верхняя часть шапки -->
            <div class="header-top">
                <!-- Кнопка звонка -->
                <button class="call-button" id="call-button">
                    <img src="{{ asset('img/header/tel.png') }}" alt="Телефон" class="call-icon">
                    <span class="call-text">+7 (351) 777-36-55</span>
                </button>

                <!-- Соцсети -->
                <div class="social-icons">
                    <!--<button class="social-button"> <img src="{{ asset('img/header/mail.png') }}" alt="Соц сеть 1" class="social-icon"></button>-->
                    <p class="mail">aplus174@mail.ru</p>
                    <button class="social-button"> <img src="{{ asset('img/header/tg.png') }}" alt="Соц сеть 1" class="social-icon"></button>
                    <button class="social-button"> <img src="{{ asset('img/header/vk.png') }}" alt="Соц сеть 1" class="social-icon"></button>
                    <button class="social-button"> <img src="{{ asset('img/header/whapp.png') }}" alt="Соц сеть 1" class="social-icon"></button>
                </div>

                <!-- Кнопка пользователя -->
                <a href="{{ route(Auth::check() ? 'profile' : 'register') }}">
                    <button class="user-button" id="user-button">
                        <img src="{{ asset('img/header/user.png') }}" alt="Пользователь" class="user-icon">
                        <span class="user-text" id="user-text">
                            @auth
                            {{ Auth::user()->name }} {{ Auth::user()->surname }}
                            @else
                            Вход/регистрация
                            @endauth
                        </span>
                    </button>
                </a>

            </div>

            <!-- Нижняя часть шапки -->
            <div class="header-bottom">
                <nav class="header-nav">
                    <!-- Кнопки меню -->
                    <div class="menu-buttons">
                    <a href="{{ route('constructor.index') }}"><button class="menu-button">Конструктор заказов</button></a>
                        <a href="{{ route('portfolio') }}"><button class="menu-button">Портфолио</button></a>
                        <a href="{{ route('about') }}"><button class="menu-button">О нас</button></a>
                        <a href="{{ route('contacts') }}"><button class="menu-button">Контакты</button></a>
                        <a href="{{ route('reviews') }}"><button class="menu-button">Отзывы</button></a>
                        <!-- Кнопка корзины -->
                        <button class="cart-button">
                            <img src="{{ asset('img/header/basket.png') }}" alt="Корзина" class="cart-icon">
                            <span class="cart-text">Корзина</span>
                            <div class="cart-counter">0</div>
                        </button>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <!-- Мобильное меню (появляется при клике на бургер) -->
    <div id="mobile-menu" class="mobile-menu hidden">
        <nav class="mobile-nav">
            <button class="mobile-menu-button">Конструктор заказов</button>
            <button class="mobile-menu-button">Портфолио</button>
            <button class="mobile-menu-button">О нас</button>
            <button class="mobile-menu-button">Контакты</button>
            <button class="mobile-menu-button">Личный кабинет</button>
        </nav>
    </div>
</header>