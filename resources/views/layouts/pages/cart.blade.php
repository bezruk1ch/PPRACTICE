<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Корзина</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/header.css'])
    @vite(['resources/css/cart.css'])
    @vite(['resources/css/footer.css'])
    @vite(['resources/js/cart.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="m-0 bg-[#2C3E50] font-montserrat">
    @include('page-elements.header')

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
        <div class="cart-list">
            @foreach($cart as $i => $item)
            @php
            $product = $products->firstWhere('type', $item['template']['type']);
            $groups = $product
            ? $product->options->groupBy('option_type')
            : collect();
            @endphp

            <div class="cart-item">

                {{-- 1: Левая колонка --}}
                <div class="col col-left">
                    <p><strong>Название:</strong> {{ $item['name'] }}</p>
                    <p><strong>Тип:</strong> {{ $item['template']['type'] ?? '—' }}</p>
                    <p><strong>Дата:</strong> {{ $item['date'] }}</p>
                    @if(!empty($item['preview']))
                    <img src="{{ $item['preview'] }}" alt="Preview" class="cart-preview">
                    @endif
                </div>

                {{-- 2: Средняя колонка --}}
                <div class="col col-middle">
                    @foreach($groups as $type => $opts)
                    <label class="param-label">
                        {{ $optionLabels[$type] ?? ucfirst($type) }}:
                        <select name="items[{{ $i }}][options][{{ $type }}]" class="param-select" data-base="{{ $product->base_price }}">
                            @foreach($opts as $opt)
                            <option value="{{ $opt->option_name }}" data-modifier="{{ $opt->price_modifier }}">
                                {{ $opt->option_name }} (+{{ $opt->price_modifier }})
                            </option>
                            @endforeach
                        </select>
                    </label>
                    @endforeach

                    <label class="param-label">
                        Кол-во:
                        <input type="number" name="items[{{ $i }}][quantity]" class="qty-input" value="1" min="1">
                    </label>
                </div>

                {{-- 3: Правая колонка --}}
                <div class="col col-right">
                    <p>Цена за шт.:<br>
                        <span class="price-per-item">0</span> ₽
                    </p>
                    <p>Всего:<br>
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
            <form action="{{ route('cart.checkout') }}" method="POST" style="display:inline-block; margin: 0 15px;">
                @csrf
                <button type="submit" class="btn-submit">Оформить заказ</button>
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
    </section>

    @include('page-elements.footer')
</body>

</html>