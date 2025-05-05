<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Корзина</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/header.css'])
    @vite(['resources/css/cart.css'])
    @vite(['resources/css/footer.css'])

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="m-0 bg-[#2C3E50] font-montserrat">
    @include('page-elements.header')

    <section class="profile-section">
        <div class="container-profile">
            <h2 class="profile-title">Ваша корзина</h2>

            {{-- Пустая корзина --}}
            <div id="cart-empty" class="text-center py-16" style="display: none;">
                <p>Ваша корзина пуста.</p>
                <a href="{{ route('home') }}" class="save-btn mt-4 inline-block">Перейти в каталог</a>
            </div>

            {{-- Основной контент --}}
            <div id="cart-content">
                <form action="{{ route('cart.checkout') }}" method="POST" id="checkoutForm">
                    @csrf

                    {{-- 1) Опции макета --}}
                    <div class="order-options mb-6">
                        <h3 class="options-title">Параметры макета</h3>
                        <div class="options-row">
                            <label>
                                Качество бумаги:
                                <select name="paperQuality" id="paperQuality" class="option-select">
                                    <option value="standard">Стандарт (130 г/м²)</option>
                                    <option value="premium">Премиум (200 г/м²)</option>
                                    <option value="deluxe">Делюкс (300 г/м²)</option>
                                </select>
                            </label>
                            <label>
                                Ламинация:
                                <select name="lamination" id="lamination" class="option-select">
                                    <option value="none">Без ламинации</option>
                                    <option value="matte">Матовая</option>
                                    <option value="gloss">Глянцевая</option>
                                </select>
                            </label>
                        </div>
                    </div>

                    {{-- 3) Таблица корзины --}}
                    <table class="cart-table mb-6">
                        <thead>
                            <tr>
                                <th>Товар</th>
                                <th>Цена</th>
                                <th>Кол-во</th>
                                <th>Сумма</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cart-items">
                            {{-- JS или серверный рендер вставит строки --}}
                        </tbody>
                    </table>

                    {{-- 4) Итоги и кнопки --}}
                    <div class="cart-summary">
                        <div class="total">
                            <span>Итого:</span>
                            <span id="cart-total">0 ₽</span>
                        </div>
                        <div class="cart-actions">
                            <button type="button" id="clearCartBtn" class="side-btn">Очистить корзину</button>
                            <button type="submit" class="save-btn">Оформить заказ</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>

    @include('page-elements.footer')
    @vite(['resources/js/cart.js'])
</body>

</html>