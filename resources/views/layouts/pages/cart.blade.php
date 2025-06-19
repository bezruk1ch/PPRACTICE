<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Корзина</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/header.css'])
    @vite(['resources/css/cart.css'])
    @vite(['resources/css/footer.css'])
    @vite(['resources/js/cart.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body class="m-0 bg-[#2C3E50] font-montserrat">
    <div class="page-wrapper">
        @include('page-elements.header')

        <div class="page-content">
            @php
            $optionLabels = [
            'size' => 'Размер',
            'color' => 'Цвет',
            'print_type' => 'Тип печати',
            'paper_quality' => 'Качество бумаги',
            'lamination' => 'Ламинация',
            'material' => 'Материал',
            'pages' => 'Страницы',
            'binding' => 'Переплёт',
            ];
            @endphp

            <section class="cart-section">
                <h1 class="cart-title">Корзина</h1>

                @if(!empty($cart))

                <form action="{{ route('cart.checkout') }}" method="POST" style="display:inline-block; margin: 0 15px;">
                    @csrf

                    <div class="cart-list">
                        @foreach($cart as $i => $item)
                        @php
                        $product = $products->firstWhere('type', $item['template']['type']);
                        $groups = $product
                        ? $product->options->groupBy('option_type')
                        : collect();
                        @endphp

                        <div class="cart-item">
                            <div class="cart-main">
                                {{-- 1: Левая колонка --}}
                                <div class="col col-left">
                                    <p><strong>Название:</strong> {{ $item['name'] }}</p>
                                    <p><strong>Тип:</strong> {{ $item['template']['type'] ?? '—' }}</p>
                                    <p><strong>Дата:</strong> {{ $item['date'] }}</p>
                                    @if(!empty($item['preview']))
                                    <img src="{{ $item['preview'] }}" alt="Preview" class="cart-preview" />
                                    @endif
                                </div>

                                {{-- 2: Средняя колонка --}}
                                <div class="col col-middle">
                                    @foreach($groups as $type => $opts)
                                    <label class="param-label">
                                        {{ $optionLabels[$type] ?? ucfirst($type) }}:
                                        <select name="items[{{ $i }}][options][{{ $type }}]" class="param-select"
                                            data-base="{{ $product->base_price }}">
                                            @foreach($opts as $opt)
                                            <option value="{{ $opt->option_name }}"
                                                data-modifier="{{ $opt->price_modifier }}">
                                                {{ $opt->option_name }} (+{{ $opt->price_modifier }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </label>
                                    @endforeach

                                    <label class="param-label">
                                        Кол-во:
                                        <input type="number" name="items[{{ $i }}][quantity]" class="qty-input" value="1"
                                            min="1" />
                                    </label>
                                </div>



                                @push('scripts')
                                <script>
                                    document.querySelectorAll('[name="shipping_type"]').forEach(r => {
                                        r.addEventListener('change', e => {
                                            document.getElementById('address-wrap').style.display =
                                                e.target.value === 'delivery' ? 'block' : 'none';
                                        });
                                    });
                                </script>
                                @endpush

                            </div>

                            {{-- 3: Правая колонка --}}
                            <div class="col col-right">
                                <p>Цена за шт.:<br />
                                    <span class="price-per-item">0</span> ₽
                                </p>
                                <p>Всего:<br />
                                    <span class="total-price">0</span> ₽
                                </p>
                            </div>

                        </div>
                        @endforeach
                    </div>

                    <div class="cart-footer">
                        {{-- Вернуться на главную --}}
                        <a href="{{ url('/') }}" class="btn-back">Вернуться на главную</a>

                        {{-- Оформить заказ --}}
                        <button type="button" class="btn-submit" onclick="openShippingModal()">Оформить заказ</button>

                        <!-- Модальное окно 1: доставка, оплата, комментарий -->
                        <div id="shippingModal" class="modal hidden">
                            <div class="modal-content">
                                <span class="close" onclick="closeShippingModal()">&times;</span>

                                <h2>Доставка и оплата</h2>

                                <label>
                                    <input type="radio" name="shipping_type" value="delivery" checked onchange="toggleAddressField()">
                                    Доставка
                                </label>
                                <label>
                                    <input type="radio" name="shipping_type" value="pickup" onchange="toggleAddressField()">
                                    Самовывоз
                                </label>

                                <div id="address-wrap" style="margin-top: 10px;">
                                    <label>
                                        Адрес доставки
                                        <input type="text" id="shipping_address" class="input w-full mt-1" required>
                                    </label>
                                </div>

                                <h2>Оплата</h2>
                                <select name="payment_method" class="input w-full">
                                    <option value="cash">Наличные при получении</option>
                                    <option value="card">Карта при получении</option>
                                    <option value="online">Онлайн‑оплата</option>
                                </select>

                                <label>
                                    <h2>Комментарий к заказу</h2>
                                    <textarea name="comment" rows="3" class="input w-full mt-1"></textarea>
                                </label>

                                <button type="submit">Подтвердить заказ</button>
                            </div>
                        </div>
                </form>

                {{-- Очистить корзину --}}
                <form action="{{ route('cart.clear') }}" method="POST" style="display:inline-block;">
                    @csrf
                    <button type="submit" class="btn-clear">Очистить корзину</button>
                </form>
        </div>

        @else
        <p class="cart-empty">Корзина пуста.</p>
        <div class="cart-footer">
            <a href="{{ url('/') }}" class="btn-back">Вернуться на главную</a>
        </div>
        @endif

        {{-- Плашка об успешном/неуспешном заказе --}}
        @if (session('order_success'))
        <div class="flash flash-success">
            {{ session('order_success') }}
        </div>
        @endif

        @if (session('order_error'))
        <div class="flash flash-error">
            {{ session('order_error') }}
        </div>
        @endif
        </section>

        @if ($errors->any())
        <div class="flash flash-error">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    @include('page-elements.footer')
    </div>
</body>

</html>