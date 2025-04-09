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
                <button class="call-button">
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

                <!-- Кнопка подписки с угловыми стрелками -->
                <div class="subscribe-container">
                    <!-- Стрелки по углам -->
                    <div class="corner-arrow top-left"></div>
                    <div class="corner-arrow top-right"></div>
                    <div class="corner-arrow bottom-left"></div>
                    <div class="corner-arrow bottom-right"></div>

                    <button class="subscribe-button" id="subscribe-button">
                        Подпишитесь на новости
                    </button>
                </div>
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

    <!-- Модальное окно для подписки -->
    <div id="subscribe-modal" class="feedback-modal">
        <div class="feedback-content">
            <span class="close-modal" id="close-button">&times;</span>
            <h2>Подписка на новости</h2>
            <form id="subscribe-form" class="feedback-form">
                <div class="form-group">
                    <label for="email">Ваш email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="submit" class="submit-btn">Подписаться</button>
            </form>
        </div>
    </div>
</header>